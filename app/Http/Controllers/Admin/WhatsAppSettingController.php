<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WhatsAppHelper;
use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppMessage;
use App\Models\Setting;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class WhatsAppSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        $status = WhatsAppService::checkStatus();

        $lastStatus = Setting::get('automation_last_status');
        if ($lastStatus && ! $status['success']) {
            $status['data'] = json_decode($lastStatus, true);
            $status['success'] = true;
        }

        return view('admin.whatsapp.index', compact('settings', 'status'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'automation_url' => 'required|url|max:255',
        ]);

        Setting::set('automation_url', $data['automation_url']);
        Setting::set('whatsapp_enabled', $request->boolean('whatsapp_enabled') ? '1' : '0');

        return redirect()->route('admin.whatsapp.index')
            ->with('success', __('Pengaturan WhatsApp API berhasil disimpan!'));
    }

    public function register()
    {
        $result = WhatsAppService::register();

        if ($result['success']) {
            return redirect()->route('admin.whatsapp.index')
                ->with('success', __('Aplikasi berhasil didaftarkan! Silakan Generate API Key.'));
        }

        if (isset($result['error']) && str_contains($result['error'], 'ER_DUP_ENTRY')) {
            Setting::set('automation_app_id', 1);

            return redirect()->route('admin.whatsapp.index')
                ->with('success', __('Aplikasi sudah terdaftar. Silakan Generate API Key.'));
        }

        return redirect()->route('admin.whatsapp.index')
            ->with('error', __('Gagal mendaftarkan aplikasi:').' '.($result['error'] ?? 'Unknown error'));
    }

    public function generateKey()
    {
        $result = WhatsAppService::generateKey();

        if ($result['success']) {
            return redirect()->route('admin.whatsapp.index')
                ->with('success', __('API Key berhasil di-generate dan disimpan!'));
        }

        return redirect()->route('admin.whatsapp.index')
            ->with('error', __('Gagal generate API Key:').' '.($result['error'] ?? 'Unknown error'));
    }

    public function checkStatus()
    {
        $result = WhatsAppService::checkStatus();

        if ($result['success']) {
            Setting::set('automation_last_status', json_encode($result['data']));

            $statusText = $result['data']['status'] ?? $result['data']['state'] ?? json_encode($result['data']);

            return redirect()->route('admin.whatsapp.index')
                ->with('success', __('Status: ').$statusText);
        }

        return redirect()->route('admin.whatsapp.index')
            ->with('error', __('Gagal cek status:').' '.($result['error'] ?? 'Unknown error'));
    }

    public function qrImage()
    {
        $image = WhatsAppService::getQRImage();

        if ($image) {
            return response($image, 200, [
                'Content-Type' => 'image/png',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);
        }

        return response()->json(['error' => 'Gagal mengambil QR Code'], 500);
    }

    public function testSend(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        $phone = WhatsAppHelper::normalizePhone($data['phone']);

        if (! $phone) {
            return redirect()->route('admin.whatsapp.index')
                ->with('error', __('Nomor telepon tidak valid.'));
        }

        $message = "ExploreRide - Test Notification\n\n"
            .'Halo! Ini adalah pesan test dari ExploreRide.\n'
            .'Jika Anda menerima pesan ini, berarti integrasi WhatsApp sudah berhasil.\n'
            .'Waktu: '.now()->format('d/m/Y H:i:s');

        SendWhatsAppMessage::dispatch($phone, $message);

        return redirect()->route('admin.whatsapp.index')
            ->with('success', __('Pesan test sedang dikirim ke ').$phone.__('. Cek WhatsApp Anda dalam beberapa saat.'));
    }
}
