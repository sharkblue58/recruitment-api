<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $otp = rand(100000, 999999);
        Cache::put('otp_' . $request->email, $otp, now()->addMinutes(5));

        // Mail::to($request->email)->send(new OtpMail($otp));

        return response()->json([
            'message' => 'OTP sent successfully',
            'otp' => $otp,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
        ]);

        $cachedOtp = Cache::get('otp_' . $request->email);

        if (!$cachedOtp) {
            return response()->json(['message' => 'OTP expired or not found'], 400);
        }

        if ($cachedOtp != $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }


        // verify email
        $user = User::where('email', $request->email)->first();
        $user->email_verified_at = now();
        $user->save();

        
        Cache::forget('otp_' . $request->email);

        
        return response()->json(['message' => 'OTP verified successfully']);
    }
}
