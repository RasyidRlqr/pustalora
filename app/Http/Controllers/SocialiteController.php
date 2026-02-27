<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the provider's authentication page.
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     */
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Check if user already exists by email
            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'email' => $socialUser->getEmail(),
                    'password' => bcrypt('social_' . $provider . '_' . time()),
                ]);
            }

            // Login the user
            Auth::login($user);

            return redirect()->intended(route('dashboard'))->with('status', 'Logged in successfully with ' . ucfirst($provider) . '!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to login with ' . ucfirst($provider) . '. Please try again. Error: ' . $e->getMessage());
        }
    }
}
