<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleSocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('customer.login')->withErrors(['email' => 'Google login failed.']);
        }

        $customer = Customer::where('google_id', $googleUser->getId())->orWhere('email', $googleUser->getEmail())->first();

        if ($customer) {
            if (!$customer->google_id) {
                $customer->update(['google_id' => $googleUser->getId(), 'avatar' => $customer->avatar ?? $googleUser->getAvatar()]);
            }
            Auth::guard('customer')->login($customer);
            return redirect()->intended('/');
        }

        $customer = Customer::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'password' => Hash::make(str()->random(16)),
        ]);

        Auth::guard('customer')->login($customer);
        return redirect()->intended('/');
    }
}
