<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();

    }

    public function callback($provider)
    {
        try {
            $provider_user = Socialite::driver($provider)->user();
            $user = User::where([
                'provider' => $provider,
                'provider_id' => $provider_user->id,
            ])->first();

            if (! $user) {
                $user = User::create([
                    'name' => $provider_user->name,
                    'email' => $provider_user->email,
                    'provider' => $provider,
                    'provider_id' => $provider_user->id,
                    'password' => Hash::make(Str::random(16)),
                    'provider_token' => $provider_user->token,
                ]);
            }
            Auth::login($user);

            return redirect()->route('home');
        } catch (\Exception $e) {
            throw $e;

            return redirect()->route('login')->withErrors(['message' => 'Failed to login with '.$provider.'. Please try again.']);
        }

    }
}
