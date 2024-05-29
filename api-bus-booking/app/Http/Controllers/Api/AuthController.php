<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        User::create($data);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (!Auth::attempt(['phone' => $data['phone'], 'password' => $data['password']])) {
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                    'errors' => [
                        'phone' => ['Неверный номер телефона или пароль'],
                    ]
                ]
            ]);
        }

        $token = $request->user()->createToken('token')->plainTextToken;
        return response()->json([
            'token' => $token,
        ]);
    }
}
