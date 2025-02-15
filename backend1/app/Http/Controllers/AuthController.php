<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    //Đăng ký tài khoản
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20|unique:users',
            'avatar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'avatar' => $request->avatar,
            'role' => 'customer',
        ]);

        try {
            $token = $user->createToken('auth_token')->plainTextToken;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi tạo token!'], 500);
        }

        return response()->json([
            'message' => 'Đăng ký thành công!',
            'user' => $user->only(['id', 'name', 'email', 'phone', 'avatar', 'role']),
            'token' => $token,
        ], 201);
    }

    //Đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Sai tài khoản hoặc mật khẩu!'], 401);
        }

        $user = Auth::user();
        
        try {
            $token = $user->createToken('auth_token')->plainTextToken;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi tạo token!'], 500);
        }

        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'user' => $user->only(['id', 'name', 'email', 'phone', 'avatar', 'role']),
            'token' => $token,
        ]);
    }

    //Lấy thông tin người dùng
    public function profile(Request $request)
    {
        return response()->json($request->user()->only(['id', 'name', 'email', 'phone', 'avatar', 'role']));
    }

    //Đăng xuất
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Đăng xuất thành công!']);
    }
}
