<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. SIGNUP API
    public function signup(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 201);
    }

    // 2. LOGIN API
    public function login(Request $request)
    {
        // Validate incoming data
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        // Attempt to log the user in using Laravel's built-in Auth
        if (!Auth::attempt($fields)) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        // Get the authenticated user
        $user = Auth::user();

        return response()->json([
            'message' => 'Login successful!',
            'user' => $user
        ], 200);
    }
}