<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Province;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function login()
    {
        return view('backend.auth.login');
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->only(['email', 'password']);

        $remember = $request->boolean('remember');

        if (auth()->attempt($credentials, $remember)) {


            $account = auth()->user();


            if ($account->role_id != 1) {
                sessionFlash('error', 'Tài khoản không có quyền truy cập!');

                auth()->logout();
                return back();
            }

            sessionFlash('success', 'Đăng nhập thành công.');
            return redirect()->route('admin.dashboard');
        } else {
            sessionFlash('error', 'Tài khoản hoặc mật khẩu không chính xác!');
            return back()->withInput();
        }
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        sessionFlash('success', 'Đăng xuất thành công.');
        return redirect()->route('admin.login');
    }

}
