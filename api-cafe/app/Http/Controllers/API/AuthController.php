<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (!Auth::attempt(['login' => $data['login'], 'password' => $data['password']])) {
            return response()->json(['error' => [
                'code' => 401,
                'message' => 'Authentication failed'
            ]], 401);
        }

        $token = request()->user()->createToken('token')->plainTextToken;

        return response()->json([
            'data' => [
                'token' => $token
            ]
        ]);
    }
}
