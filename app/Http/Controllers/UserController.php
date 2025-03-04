<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
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

    /**
     * Update User By ID
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $data = $request->except('password');

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        try {
            $user->update($data);
            return response()->json(['message' => 'User updated successfully', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
