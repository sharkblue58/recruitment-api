<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;


class FeatureAccessService
{
    public function userHasFeature(User $user, string $featureKey): bool
    {
        $subscription = $user->subscriptions()
            ->where('stripe_status', 'active')
            ->latest()
            ->first();

        if (!$subscription) {
            return false;
        }

        // Find plan using Stripe price ID
        $plan = Plan::where('stripe_price_id', $subscription->stripe_price)->first();
        if (!$plan) {
            return false;
        }

        return $plan->features()->where('key', $featureKey)->exists();
    }
}
