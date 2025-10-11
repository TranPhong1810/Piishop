<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\PendingUser;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Kiểm tra trạng thái tài khoản
            if ($user->status == 1) {
                toastr()->success('Đăng nhập thành công!');

                // Phân quyền redirect
                if ($user->hasAnyRole(['admin', 'manager', 'employee', 'super-admin'])) {
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('home');
                }
            } else {
                Auth::logout();
                toastr()->error('Tài khoản của bạn đã bị khóa!');
                return redirect()->route('auth.login');
            }
        } else {
            toastr()->error('Email hoặc mật khẩu không đúng!');
            return redirect()->route('auth.login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }

    public function signUp()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:pending_users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        $token = Str::random(60);

        $pendingUser = new PendingUser();
        $pendingUser->name = $request->input('name');
        $pendingUser->email = $request->input('email');
        $pendingUser->password = bcrypt($request->input('password'));
        $pendingUser->token = $token;
        $pendingUser->save();

        $pendingUser->notify(new VerifyEmailNotification($token));

        toastr()->success('Đăng ký tài khoản thành công! Vui lòng kiểm tra email của bạn để xác nhận đăng ký.');
        return redirect()->route('auth.login');
    }
}
