<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PendingUser;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{

    public function verify($token)
    {
        $pendingUser = PendingUser::where('token', $token)->first();

        if (!$pendingUser) {
            toastr()->error('Token không hợp lệ hoặc đã hết hạn.');
            return redirect()->route('auth.login');
        }

        // Tạo người dùng chính thức
        $user = new User();
        $user->name = $pendingUser->name;
        $user->email = $pendingUser->email;
        $user->password = $pendingUser->password;
        $user->save();

        // Xóa người dùng tạm thời
        $pendingUser->delete();

        toastr()->success('Xác nhận email thành công! Bạn có thể đăng nhập.');
        return redirect()->route('auth.login');
    }
}
