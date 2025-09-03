<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // registration
    public function register(Request $request)
    {
        // validate fields
        $fields = $request->validate([
            'name' => 'required|string',
            'email'=> 'required|string|unique:users,email',
            'password'=> 'required|string|confirmed',
        ]);

        // create new user
        $user = User::create([
            'name' => $fields['name'],
            'email'=> $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);
        
        // create new user personalize access token
        $token = $user->createToken('appToken')->plainTextToken;

        // return new json response
        return response()->json([
            'user' => $user,
            'token'=> $token,
        ], 201); // CREATED
    }

    // account login
    public function login(Request $request)
    {
        // validate login details
        $fields = $request->validate([
            'email' => 'required|string',
            'password'=> 'required|string'
        ]);

        // first find the user email
        $user = User::where('email', $fields['email'])->first();
        // second check the user password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401); // UNAUTHORIZED
        }

        $token = $user->createToken('appToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token'=> $token,
        ], 200); // OK
    }

    // logging out of account
    public function logout(Request $request)
    {
        // get user token and delete & return response
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ], 200);   
    }
}
