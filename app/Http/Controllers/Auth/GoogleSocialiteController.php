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

        $email = $googleUser->getEmail();

        if (!$email) {
            return redirect()->route('customer.login')->withErrors(['email' => 'Tidak dapat mendapatkan email dari Google. Silakan coba lagi atau gunakan email lain.']);
        }

        $customer = Customer::where('google_id', $googleUser->getId())
            ->orWhere('email', $email)
            ->first();

        if ($customer) {
            if (!$customer->google_id) {
                $customer->update(['google_id' => $googleUser->getId(), 'avatar' => $customer->avatar ?? $googleUser->getAvatar()]);
            }
            Auth::guard('customer')->login($customer);
            return redirect()->intended('/');
        }

        $customer = Customer::create([
            'name' => $googleUser->getName(),
            'email' => $email,
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'password' => Hash::make(str()->random(16)),
        ]);

        Auth::guard('customer')->login($customer);
        return redirect()->intended('/');
    }
}
