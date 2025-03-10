<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;

class OauthController extends Controller
{
    public function redirectToProvider()
    {
        try {
            $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
            return response()->json([
                'url' => $url
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $finduser = User::where('gauth_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                $token = $finduser->createToken('auth-token')->plainTextToken;

                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful',
                    'user' => $finduser,
                    'token' => $token
                ]);
            }

            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'gauth_id' => $user->id,
                'gauth_type' => 'google',
                'password' => encrypt('admin@123')
            ]);

            Auth::login($newUser);
            $token = $newUser->createToken('auth-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Registration and login successful',
                'user' => $newUser,
                'token' => $token
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
