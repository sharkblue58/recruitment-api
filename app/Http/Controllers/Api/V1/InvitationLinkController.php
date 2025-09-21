<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Support\Str;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


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

    public function registerWithInvitation(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (! $invitation) {
            return response()->json(['message' => 'Invalid or expired invitation'], 400);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = DB::transaction(function () use ($invitation, $request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $invitation->email,
                'password' => $request->password,
                'email_verified_at' => now(),
            ]);

            $invitation->update(['is_used' => true]);

            return $user;
        });


        return response()->json(['message' => 'Registered successfully', 'user' => $user]);
    }
}
