<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminSubscriptionController extends Controller
{
    public function allSubscriptions()
    {
        // join users and cashier_subscriptions
        $subs = DB::table('subscriptions')
            ->join('users', 'subscriptions.user_id', 'users.id')
            ->select('users.id as user_id', 'users.email', 'subscriptions.*')
            ->get();
        return response()->json($subs);
    }
}
