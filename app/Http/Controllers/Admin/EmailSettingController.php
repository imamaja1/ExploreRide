<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.email.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'mail_mailer' => 'required|in:smtp,sendmail',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|string|max:10',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl,none',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);

        Setting::set('email_enabled', $request->boolean('email_enabled') ? '1' : '0');
        Setting::set('mail_mailer', $data['mail_mailer']);
        Setting::set('mail_host', $data['mail_host'] ?? '');
        Setting::set('mail_port', $data['mail_port'] ?? '587');
        Setting::set('mail_username', $data['mail_username'] ?? '');
        Setting::set('mail_password', $data['mail_password'] ?? '');
        Setting::set('mail_encryption', $data['mail_encryption'] ?? 'tls');
        Setting::set('mail_from_address', $data['mail_from_address']);
        Setting::set('mail_from_name', $data['mail_from_name']);

        return redirect()->route('admin.email.index')
            ->with('success', __('Pengaturan email berhasil disimpan!'));
    }

    public function testSend(Request $request)
    {
        $data = $request->validate([
            'test_email' => 'required|email|max:255',
        ]);

        $settings = Setting::pluck('value', 'key')->toArray();

        if (($settings['email_enabled'] ?? '0') !== '1') {
            return redirect()->route('admin.email.index')
                ->with('error', __('Notifikasi email belum diaktifkan.'));
        }

        try {
            config([
                'mail.default' => $settings['mail_mailer'] ?? 'smtp',
                'mail.mailers.smtp.host' => $settings['mail_host'] ?? '',
                'mail.mailers.smtp.port' => $settings['mail_port'] ?? '587',
                'mail.mailers.smtp.username' => $settings['mail_username'] ?? '',
                'mail.mailers.smtp.password' => $settings['mail_password'] ?? '',
                'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? 'tls',
                'mail.from.address' => $settings['mail_from_address'] ?? '',
                'mail.from.name' => $settings['mail_from_name'] ?? 'ExploreRide',
            ]);

            Mail::raw("ExploreRide - Test Email\n\nIni adalah email test dari ExploreRide.\nWaktu: " . now()->format('d/m/Y H:i:s'), function ($message) use ($data) {
                $message->to($data['test_email'])
                    ->subject('ExploreRide - Test Email');
            });

            return redirect()->route('admin.email.index')
                ->with('success', __('Email test berhasil dikirim ke ') . $data['test_email']);
        } catch (\Exception $e) {
            return redirect()->route('admin.email.index')
                ->with('error', __('Gagal mengirim email: ') . $e->getMessage());
        }
    }
}
