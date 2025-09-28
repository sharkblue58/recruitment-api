<?php

namespace App\Models;

use Laravel\Cashier\Subscription;
use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    protected $fillable = ['user_id', 'subscription_id', 'stripe_charge_id', 'amount', 'reason', 'status', 'admin_id', 'admin_note'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
