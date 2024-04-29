<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public static function login(LoginRequest $request): JsonResponse
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
}
