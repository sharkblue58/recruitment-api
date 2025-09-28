<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\RefundRequest;
use App\Http\Controllers\Controller;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Use Cashier's webhook controller to handle billing events first
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('cashier.webhook.secret'); // set in env

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // handle events you care about
        switch ($event->type) {
            case 'invoice.payment_succeeded':
                $invoice = $event->data->object;
                // update subscription/payment status in DB
                // you can find user by invoice.customer
                // Cashier handles invoice and subscriptions automatically if you use Cashier WebhookController
                break;

            case 'customer.subscription.updated':
            case 'customer.subscription.created':
            case 'customer.subscription.deleted':
                // update local subscription metadata/status if needed
                break;

            case 'charge.refunded':
                $charge = $event->data->object;
                // find refundRequests by charge id and update status to refunded if present
                RefundRequest::where('stripe_charge_id', $charge->id)->update(['status' => 'refunded']);
                break;

            // handle price/product deleted/updated events to keep your Plan table synced
            case 'product.updated':
            case 'price.updated':
                // optional: sync changes
                break;
        }

        return response()->json(['received' => true]);
    }
}
