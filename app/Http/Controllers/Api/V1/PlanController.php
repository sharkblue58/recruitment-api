<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Services\StripeService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json(Plan::all());
    }

    public function store(Request $request, StripeService $stripe)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'required|integer|min:0',
            'currency' => 'required|string|size:3',
            'interval' => ['required', Rule::in(['month', 'year'])],
            'active' => 'sometimes|boolean',
        ]);

        $stripeRes = $stripe->createProductAndPrice($data['name'], $data['amount'], $data['currency'], $data['interval']);
        $plan = Plan::create(array_merge($data, [
            'stripe_product_id' => $stripeRes['product']->id,
            'stripe_price_id' => $stripeRes['price']->id,
        ]));

        return response()->json($plan, 201);
    }

    public function show(Plan $plan)
    {
        return response()->json($plan);
    }

    public function update(Request $request, Plan $plan, StripeService $stripe)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'description' => 'nullable|string',
            'amount' => 'sometimes|integer|min:0',
            'currency' => 'sometimes|string|size:3',
            'interval' => [Rule::in(['month', 'year'])],
            'active' => 'sometimes|boolean',
        ]);
        // caution: Stripe prices cannot be edited; you'd usually create new price and link it.
        if (isset($data['amount']) || isset($data['interval']) || isset($data['currency'])) {
            // create new price for same product:
            $price = $stripe->client->prices->create([
                'unit_amount' => $data['amount'] ?? $plan->amount,
                'currency' => $data['currency'] ?? $plan->currency,
                'recurring' => ['interval' => $data['interval'] ?? $plan->interval],
                'product' => $plan->stripe_product_id,
            ]);
            $data['stripe_price_id'] = $price->id;
        }
        $plan->update($data);
        return response()->json($plan);
    }

    public function destroy(Plan $plan, StripeService $stripe)
    {
        $subscriptions = $stripe->client->subscriptions->all([
            'price' => $plan->stripe_price_id,
            'status' => 'active',
        ]);

        if (count($subscriptions->data) > 0) {
            return response()->json([
                'message' => 'Plan has active subscribers on Stripe.'
            ], 400);
        }
        // mark inactive locally; optionally archive product on Stripe
        $plan->update(['active' => false]);
        // you might also set stripe product active=false
        $stripe->client->products->update($plan->stripe_product_id, ['active' => false]);
        return response()->json(['message' => 'Plan deactivated']);
    }
}
