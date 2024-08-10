<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email:rfc|unique:users,email",
            "password" => "required|min:6",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Bad request",
                "data" => $validator->errors()
            ], 400);
        }

        try {
            $result = $this->authService->register($request->only('email', 'password'));

            return response()->json([
                "status" => "success",
                "message" => "User registered successfully",
                "data" => [
                    "user" => $result['user'],
                    "token" => $result['token']
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Server error",
                "data" => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            $result = $this->authService->login($credentials);

            if (isset($result['error'])) {
                return response()->json([
                    "status" => "error",
                    "message" => $result['error'],
                    "data" => null
                ], 401);
            }

            return response()->json([
                "status" => "success",
                "message" => "Login successful",
                "data" => [
                    "user" => auth()->user(),
                    "token" => $result['token']
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Server error",
                "data" => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            $this->authService->logout();
            return response()->json([
                "status" => "success",
                "message" => "Logout successful",
                "data" => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Server error",
                "data" => $e->getMessage()
            ], 500);
        }
    }

    public function me()
    {
        try {
            return response()->json([
                "status" => "success",
                "message" => "User data retrieved successfully",
                "data" => auth()->user()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Server error",
                "data" => $e->getMessage()
            ], 500);
        }
    }

    public function unauthorized()
    {
        return response()->json([
            "status" => "error",
            "message" => "Unauthorized",
            "data" => null
        ], 401);
    }
}
