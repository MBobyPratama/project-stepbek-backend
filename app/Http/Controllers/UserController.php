<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dedoc\Scramble\Attributes\ExcludeAllRoutesFromDocs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Get All User
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users]);
    }

    /**
     * Update User By ID
     */
    public function update(Request $request, string $id)
    {
        // Check if user exists
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if authenticated user is updating their own profile
        if (Auth::id() != $id) {
            return response()->json(['message' => 'Unauthorized. You can only update your own profile'], 403);
        }

        // Validate the request
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'sometimes|string|min:8',
            'gambar' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'nomor_telepon' => 'sometimes|string',
            'alamat' => 'sometimes|string',
        ]);

        try {
            // Handle image upload if provided
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($user->gambar) {
                    Storage::delete('public/' . $user->gambar);
                }

                // Store new image
                $gambarPath = $request->file('gambar')->store('profile-images', 'public');
                $user->gambar = $gambarPath;
            }

            // Update other fields if provided
            if ($request->has('name')) {
                $user->name = $request->name;
            }

            if ($request->has('email')) {
                $user->email = $request->email;
            }

            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->has('nomor_telepon')) {
                $user->nomor_telepon = $request->nomor_telepon;
            }

            if ($request->has('alamat')) {
                $user->alamat = $request->alamat;
            }

            $user->save();

            return response()->json([
                'message' => 'Profile updated successfully',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get User By ID
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['data' => $user]);
    }

    /**
     * Delete User By ID
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
