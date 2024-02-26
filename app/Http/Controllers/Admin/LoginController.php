<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('Admin.Auth.login', [
            'title' => 'Đăng nhập vào HMS Admin'
        ]);
    }
    public function login(Request $request)
    {
        $rememberMe = intval($request->input('remember_me')) === 1;
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:16'],
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.max' => 'Mật khẩu tối đa là :max ký tự.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (Auth::guard('admin')->attempt(
            [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ],
            $rememberMe
        )) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back()->withErrors([
                'login' => 'Email hoặc password của bạn không đúng',
            ])->withInput();
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        // Xóa session hoặc thực hiện bất kỳ xử lý đăng xuất nào khác nếu cần thiết
        $request->session()->invalidate();
        // Redirect về trang đăng nhập hoặc bất kỳ trang nào bạn muốn
        return redirect()->route('admin.login');
    }
}
