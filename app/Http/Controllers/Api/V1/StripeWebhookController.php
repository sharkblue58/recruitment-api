<?php

namespace App\Http\Controllers\Api\v1;

use Stripe\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
      
        $payload = $request->getContent();
        //logger("This is payload: ".$payload);
        $sigHeader = $request->header('stripe-signature');
        //logger("This is sigHeader: ".$sigHeader);
        $secret = config('services.stripe.webhook_secret'); // من stripe dashboard
        //logger("This is secret: ".$secret);


        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'invoice.payment_succeeded':
                // هنا تحفظ ان الاشتراك اتدفع بنجاح
                break;

            case 'customer.subscription.deleted':
                // هنا تلغي الاشتراك عندك
                break;
        }

        return response()->json(['status' => 'success']);
    }
}
