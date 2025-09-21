<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\User;
use App\Mail\WelcomeMail;
use App\Models\SocialEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\V1\SocialLoginRequest;


class SocialController extends Controller
{
    public function socialLogin(SocialLoginRequest $request)
    {

        /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
        $driver = Socialite::driver($request->provider);

        $providerUser = $driver->userFromToken($request->access_token);
        if (filled($providerUser)) {
            $user = $this->findOrCreate($providerUser, $request->provider, $request->role);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        $token = $user->createToken(
            'api-token',
            ['*']
        );
        Mail::to($user->email)->queue(new WelcomeMail($user));
        return response()->json([
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }


    protected function findOrCreate($providerUser, $provider, $role)
    {
        $linkedSocialAccount = SocialEmail::query()->where('provider', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($linkedSocialAccount) {
            return $linkedSocialAccount->user;
        } else {

            $user = null;

            if ($email = $providerUser->getEmail()) {
                $user = User::query()->where('email', $email)->first();
            }

            if (! $user) {
                $user = User::query()->create([
                    'first_name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                ]);
                $user->markEmailAsVerified();
            }

            $user->socialEmails()->create([
                'provider_id' => $providerUser->getId(),
                'provider' => $provider,
                'avatar' => $providerUser->getAvatar(),
            ]);

            if ($user->roles->isEmpty()) {
                $user->assignRole($role);
            }

            return $user;
        }
    }
}
