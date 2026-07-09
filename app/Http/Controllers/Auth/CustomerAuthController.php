<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        if (request()->ajax()) {
            return response()->json(['modal' => view('components.login-modal')->render()]);
        }
        return view('customer.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }
            return redirect()->intended('/');
        }

        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => __('Email atau password salah')], 422);
        }

        return back()->withErrors(['email' => __('Email atau password salah')])->withInput();
    }

    public function showRegister()
    {
        if (request()->ajax()) {
            return response()->json(['modal' => view('components.register-modal')->render()]);
        }
        return view('customer.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $customer = Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        Auth::guard('customer')->login($customer);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect('/');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }
}
