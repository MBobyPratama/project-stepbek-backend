<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dedoc\Scramble\Attributes\ExcludeAllRoutesFromDocs;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get All User
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
}
