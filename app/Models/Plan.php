<?php

namespace App\Models;


use Laravel\Cashier\Subscription;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'description', 'amount', 'currency', 'interval', 'stripe_product_id', 'stripe_price_id', 'active'];
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'stripe_price'); // not required; Cashier handles subscriptions table
    }
}
