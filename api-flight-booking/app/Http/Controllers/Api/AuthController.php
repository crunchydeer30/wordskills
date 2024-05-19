<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (!Auth::attempt(['phone' => $data['phone'], 'password' => $data['password']])) {
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                    'errors' => [
                        'phone' => ['phone or password incorrect'],
                    ]
                ]
            ], 401);
        }

        $token = $request->user()->createToken()->plainTextToken;
        return response()->json([
            'data' => [
                'token' => $token
            ]
        ], 200);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        User::create($data);
        return response()->noContent();
    }
}
