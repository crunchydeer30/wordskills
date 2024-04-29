<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return response()->json([
                "success" => false,
                "message" => "Login failed"
            ], 401);
        }

        $token = $request->user()->createToken('token')->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "Login success",
            "token" => $token
        ]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $credentials['password'] = bcrypt($credentials['password']);

        $user = User::create($credentials);
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "Success",
            "token" => $token
        ]);
    }
}
