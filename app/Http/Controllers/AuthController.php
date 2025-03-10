<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        // Apply basic auth middleware to protected endpoints
    }

    /**
     * Login
     */
    /**
     * @unauthenticated
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        // Instead of token, now return user with success message
        return response()->json([
            'user' => $user,
            'message' => 'Login successful',
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        // No need to delete tokens anymore
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Register
     */
    /**
     * @unauthenticated
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'user' => $user,
        ]);
    }
}
