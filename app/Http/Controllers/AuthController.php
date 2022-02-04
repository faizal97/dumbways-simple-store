<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request, UserService $userService)
    {
        $user = $userService->findByEmail($request->input('email'));

        try {
            if (!$user) {
                throw new ApiException("Email is not found");
            }

            if (!$userService->verifyPassword($user, $request->input('password')))
            {
                throw new ApiException("Email / Password is invalid");
            }

            $token = $userService->generateToken($user);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'login success',
            'data' => [
                'token' => $token,
            ],
        ]);
    }

    public function register(AuthRegisterRequest $request, UserService $userService)
    {
        try {
            $user = $userService->create($request->only(['name', 'password', 'email']));
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server Internal Error'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User created',
            'data' => [
                'user_id' => $user->id,
            ],
        ], 201);
    }
}
