<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Candidate;
use App\Models\Recruiter;
use App\Models\Invitation;
use Illuminate\Support\Str;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\V1\RegisterRequest;


class InvitationLinkController extends Controller
{
    public function sendInvitation(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        $token = Str::random(40);

        $invitation = Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'expires_at' => now()->addDays(3), // اللينك صالح 3 أيام
        ]);

        $link = url('/register/invite/' . $token);


        Mail::to($request->email)->queue(new InvitationMail($link));

        return response()->json(['message' => 'Invitation sent', 'link' => $link]);
    }

    public function registerWithInvitation(RegisterRequest $request, $token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (! $invitation) {
            return response()->json(['message' => 'Invalid or expired invitation'], 400);
        }

        $user = DB::transaction(function () use ($request, $invitation) {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'is_term_accepted' => $request->is_term_accepted,
                'field_id' => $request->field_id,
                'email_verified_at' => now(),
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
            $invitation->update(['is_used' => true]);

            return $user;
        });

        return response()->json(['message' => 'Registered successfully', 'user' => $user]);
    }
}
