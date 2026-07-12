<?php

namespace App\Services;

use App\Helpers\WhatsAppHelper;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public static function getBaseUrl(): string
    {
        return Setting::get('automation_url') ?? env('AUTOMATION_URL', 'https://otomasi.punyaku.online');
    }

    public static function getApiKey(): ?string
    {
        return Setting::get('automation_api_key') ?? env('AUTOMATION_KEY');
    }

    public static function register(): array
    {
        try {
            $response = Http::timeout(30)
                ->post(self::getBaseUrl().'/api/v1/auth/register', [
                    'name' => 'ExploreRide',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                Setting::set('automation_app_id', $data['data']['id'] ?? $data['id'] ?? null);

                return ['success' => true, 'data' => $data];
            }

            return ['success' => false, 'error' => $response->body()];
        } catch (\Exception $e) {
            Log::error('WA Register failed: '.$e->getMessage());

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function generateKey(): array
    {
        try {
            $appId = Setting::get('automation_app_id');

            if (! $appId) {
                return ['success' => false, 'error' => 'Application belum didaftarkan. Silakan daftarkan aplikasi terlebih dahulu.'];
            }

            $response = Http::timeout(30)
                ->post(self::getBaseUrl().'/api/v1/auth/api-key', [
                    'applicationId' => (int) $appId,
                    'name' => 'production',
                    'permissions' => ['whatsapp'],
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $key = $data['data']['key'] ?? $data['key'] ?? null;
                if ($key) {
                    Setting::set('automation_api_key', $key);
                }

                return ['success' => true, 'data' => $data];
            }

            return ['success' => false, 'error' => $response->body()];
        } catch (\Exception $e) {
            Log::error('WA Generate Key failed: '.$e->getMessage());

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function checkStatus(): array
    {
        try {
            $response = Http::timeout(15)
                ->withHeaders(['x-api-key' => self::getApiKey()])
                ->get(self::getBaseUrl().'/api/v1/whatsapp/status');

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            }

            return ['success' => false, 'error' => $response->body()];
        } catch (\Exception $e) {
            Log::error('WA Check Status failed: '.$e->getMessage());

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function getQRImage(): ?string
    {
        try {
            $response = Http::timeout(15)
                ->withHeaders(['x-api-key' => self::getApiKey()])
                ->get(self::getBaseUrl().'/api/v1/whatsapp/qr-image');

            if ($response->successful()) {
                return $response->body();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('WA Get QR failed: '.$e->getMessage());

            return null;
        }
    }

    public static function send(string $to, string $message): bool
    {
        $apiKey = self::getApiKey();

        if (! $apiKey) {
            Log::warning('WA Send failed: API key not configured');

            return false;
        }

        $normalizedTo = WhatsAppHelper::normalizePhone($to);

        if (! $normalizedTo) {
            Log::warning('WA Send failed: Invalid phone number', ['original' => $to]);

            return false;
        }

        try {
            $response = Http::timeout(30)
                ->withHeaders(['x-api-key' => $apiKey])
                ->post(self::getBaseUrl().'/api/v1/whatsapp/send', [
                    'to' => $normalizedTo,
                    'message' => $message,
                ]);

            if ($response->successful()) {
                Log::info('WA Message sent', [
                    'to' => $normalizedTo,
                    'message' => mb_substr($message, 0, 50),
                ]);

                return true;
            }

            Log::error('WA Send failed', [
                'to' => $normalizedTo,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('WA Send exception: '.$e->getMessage(), [
                'to' => $normalizedTo,
            ]);

            return false;
        }
    }
}
