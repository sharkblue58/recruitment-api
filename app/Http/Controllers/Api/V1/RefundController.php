<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\RefundRequest;
use App\Services\StripeService;
use App\Http\Controllers\Controller;

class RefundController extends Controller
{
        public function requestRefund(Request $request){
        $data = $request->validate([
            'subscription_id'=>'required|exists:subscriptions,id',
            'stripe_charge_id'=>'required|string',
            'amount'=>'nullable|integer|min:0',
            'reason'=>'nullable|string',
        ]);
        $refund = RefundRequest::create(array_merge($data, ['user_id'=>$request->user()->id]));
        return response()->json($refund, 201);
    }

    // Admin: list pending
    public function pending(){ return RefundRequest::where('status','pending')->with('user','subscription')->get(); }

    // Admin approve
    public function approve(Request $request, RefundRequest $refund, StripeService $stripe){
      
        if($refund->status !== 'pending') return response()->json(['error'=>'Invalid status'],400);

        // create the refund in stripe
        $stripeRefund = $stripe->createRefund($refund->stripe_charge_id, $refund->amount);

        // update DB
        $refund->update([
            'status' => 'refunded',
            'admin_id' => $request->user()->id,
            'admin_note' => $request->input('admin_note',''),
        ]);
        // optionally record stripe refund id in metadata
        return response()->json(['refund' => $refund, 'stripe_refund' => $stripeRefund]);
    }

    public function reject(Request $request, RefundRequest $refund){
        $refund->update([
            'status'=>'rejected',
            'admin_id' => $request->user()->id,
            'admin_note' => $request->input('admin_note',''),
        ]);
        return response()->json($refund);
    }
}
