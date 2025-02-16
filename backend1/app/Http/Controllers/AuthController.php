<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    // Đăng ký tài khoản
    public function register(RegisterRequest $request)
    {
        // Validation handled by RegisterRequest
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
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    // Đăng nhập
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

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
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    // Lấy thông tin người dùng
    public function profile(Request $request)
    {
        return new UserResource($request->user());
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Đăng xuất thành công!']);
    }
}
