<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                'Validasi gagal',
                422,
                $validator->errors()
            );
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return ApiResponse::success($user, 'Registrasi berhasil', 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return ApiResponse::error('Email atau password salah', 401);
        }

        return ApiResponse::success([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60,
        ], 'Login berhasil');
    }

    public function me()
    {
        return ApiResponse::success(
            Auth::guard('api')->user(),
            'Data user'
        );
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return ApiResponse::success(null, 'Logout berhasil');
    }
}
