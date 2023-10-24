<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        return User::create([
            'admin_username' => $request->input('admin_username'),
            'admin_email' => $request->input('admin_email'),
            'admin_phone' => $request->input('admin_phone'),
            'password' => Hash::make($request->input('password'))
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt([
            'admin_email' => $request->input('admin_email'),
            'password' => $request->input('password')
        ])) {
            return response(['message' => 'Invalid credentials'],Response::HTTP_UNAUTHORIZED);
        }

        // Lấy thông tin user đăng nhập thành công
        $user = Auth::user();

        // Tạo JWT token cho user
        $token = JWTAuth::fromUser($user);

         // Trả về thông tin user và JWT token
        return response()->json(['token' => $token]);
    }

    public function user()
    {
        return response()->json(['user' => Auth::user()], 200);
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $token = $request->bearerToken();

        // Đưa JWT token của user vào blacklist
        JWTAuth::invalidate($token);

        // Trả về thông báo thành công
        return $token;
    }
}
