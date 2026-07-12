<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverAuthController extends Controller
{
    public function showLogin()
    {
        return view('driver.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => __('Email atau password salah')])->withInput();
        }

        if (!Auth::user()->isDriver()) {
            Auth::logout();
            return back()->withErrors(['email' => __('Akses ditolak. Akun ini bukan akun driver.')])->withInput();
        }

        if (!Auth::user()->is_active) {
            Auth::logout();
            return back()->withErrors(['email' => __('Akun Anda telah dinonaktifkan. Hubungi admin.')])->withInput();
        }

        return redirect()->intended('/driver/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/driver/login');
    }
}
