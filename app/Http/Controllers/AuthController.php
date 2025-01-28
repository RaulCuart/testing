<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register (Request $request) {
        $data = $request -> validate( [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
        ],201);
    }

    public function login (Request $request) 
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password,$user->password))
        {
            return response() ->json([
                'message' => ['Username Or password incorrect']
            ],200);
        }
        $user->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'name' => $user->name,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ],200);
    }
    public function logout (Request $request) 
    {
        $user = User::where('email',$request->email)->first();
        if (! $user->email || ! Hash::check($request->password,$user->password))
        {
            return response() ->json([
                'message' => ['Username Or password incorrect']
            ],200);
        }
            $token = $request->user()->currentAccessToken();
            $request->user()->currentAccessToken()->delete(); 
        
            return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully',
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
        ],200);
        
    }
}
