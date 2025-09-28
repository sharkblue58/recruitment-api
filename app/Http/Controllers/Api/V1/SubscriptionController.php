<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'payment_method' => 'required|string',
        ]);

        $user = $request->user();
        $plan = Plan::findOrFail($request->plan_id);
        // attach payment method to customer
        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($request->payment_method);

        // create subscription
        $subscription = $user->newSubscription('default', $plan->stripe_price_id)
            ->create($request->payment_method, [
                'metadata' => ['plan_id' => $plan->id, 'user_id' => $user->id]
            ]);
        return response()->json(['subscription' => $subscription], 201);
    }

    public function cancel(Request $request)
    {
        $user = $request->user();
        $sub = $user->subscription('default');
        if (!$sub) return response()->json(['message' => 'No subscription'], 404);
        $sub->cancel(); // or cancelNow()
        return response()->json(['message' => 'Subscription cancelled']);
    }
}
