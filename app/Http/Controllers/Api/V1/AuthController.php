<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Mail\OtpMail;
use App\Mail\WelcomeMail;
use App\Models\Candidate;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\V1\RegisterRequest;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'is_term_accepted' => $request->is_term_accepted,
                'field_id' => $request->field_id
            ]);

            if ($request->role == 'candidate') {
                Candidate::create([
                    'user_id' => $user->id
                ]);
                $user->assignRole('candidate');
            } else if ($request->role == 'recruiter') {
                Recruiter::create([
                    'user_id' => $user->id,
                    'company_name' => $request->company_name,
                    'job_title' => $request->job_title
                ]);
                $user->assignRole('recruiter');
            }
            return $user;
        });


        $otp = rand(100000, 999999);
        Cache::put("otp_{$user->email}", $otp, now()->addMinutes(5));
        Mail::to($user->email)->queue(new OtpMail($otp));

        return response()->json([
            'message' => 'Registered successfully. Please verify your email.',
            'user'    => $user,
        ], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember_me' => 'boolean',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (is_null($user->email_verified_at)) {
            return response()->json([
                'message' => 'Please verify your email before login.'
            ], 403);
        }

        // لو remember_me true → 30 يوم
        $expiresAt = $request->boolean('remember_me')
            ? now()->addDays(30)
            : now()->addHours(2);

        $token = $user->createToken(
            'api-token',
            ['*'], // permissions
            $expiresAt
        );
        Mail::to($user->email)->queue(new WelcomeMail($user));
        return response()->json([
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
