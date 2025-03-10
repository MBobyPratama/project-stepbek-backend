<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class OauthController extends Controller
{
    public function redirectToGoogle()
    {
        try {
            $url = Socialite::driver('google')
                ->stateless()
                ->redirect()
                ->getTargetUrl();

            return response()->json([
                'status' => 'success',
                'url' => $url
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate Google login URL',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt(uniqid()), // Generate random password
                    'email_verified_at' => now() // Auto verify email for Google users
                ]);
            } else {
                // Update existing user's Google-specific info
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar
                ]);
            }

            // Create token for API authentication
            $token = $user->createToken('google-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged in with Google',
                'user' => $user,
                'token' => $token,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to login with Google',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
