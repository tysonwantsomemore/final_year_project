<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password_hash)) {
            return response()->json([
                'message' => 'Email hoặc mật khẩu không chính xác.'
            ], 422);
        }

        Auth::login($user);

        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'user' => [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
        ]);

        $customerRole = \App\Models\Role::where('name', 'Customer')->first();
        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'role_id' => $customerRole ? $customerRole->id : 2,
        ]);

        Auth::login($user);

        return response()->json([
            'message' => 'Đăng ký tài khoản thành công!',
            'user' => [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Đăng xuất thành công!'
        ]);
    }

    public function status(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json([
                'logged_in' => true,
                'user' => [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'role' => $user->role,
                ]
            ]);
        }

        return response()->json([
            'logged_in' => false,
            'user' => null
        ]);
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Bạn chưa đăng nhập.'], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'full_name' => $data['full_name'],
            'phone' => $data['phone'] ?? null,
        ];

        if (!empty($data['password'])) {
            $updateData['password_hash'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return response()->json([
            'message' => 'Cập nhật tài khoản thành công!',
            'user' => [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);
    }
}
