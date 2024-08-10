<?php

namespace App\Services;

use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthService
{
    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $token = JWTAuth::fromUser($user);

        return [
            "user" => $user,
            "token" => $token
        ];
    }

    public function login(array $credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return ['error' => 'Invalid credentials'];
            }
            return ['token' => $token];
        } catch (JWTException $e) {
            return ['error' => 'Could not create token'];
        }
    }

    public function logout()
    {
        $token = JWTAuth::getToken();

        return JWTAuth::invalidate($token) || null;
    }
}
