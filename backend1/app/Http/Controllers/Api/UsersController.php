<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    // Đăng ký người dùng mới
    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Tạo người dùng mới
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Trả về thông tin người dùng sau khi đăng ký
        return response()->json([
            'message' => 'Đăng ký thành công',
            'user' => $user,
        ], 201);
    }

    // Đăng nhập người dùng và cấp token
    public function login(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Kiểm tra thông tin đăng nhập
        if (Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'message' => 'Đăng nhập thành công',
                'token' => $token,
                'user' => $user,
            ]);
        }

        throw ValidationException::withMessages([
            'email' => ['Thông tin đăng nhập không chính xác'],
        ]);
    }

    // Lấy thông tin người dùng hiện tại
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    // Đăng xuất người dùng
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Đăng xuất thành công']);
    }
}
