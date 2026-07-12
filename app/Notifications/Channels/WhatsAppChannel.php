<?php

namespace App\Notifications\Channels;

use App\Helpers\WhatsAppHelper;
use App\Jobs\SendWhatsAppMessage;
use App\Models\Setting;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class WhatsAppChannel
{
    public function send(object $notifiable, Notification $notification): void
    {
        if (Setting::get('whatsapp_enabled') !== '1') {
            Log::info('WhatsAppChannel: notifikasi WhatsApp dinonaktifkan di settings', [
                'notifiable' => get_class($notifiable),
            ]);
            return;
        }

        $phone = $notifiable->whatsapp ?? $notifiable->phone ?? null;

        if (! $phone) {
            Log::warning('WhatsAppChannel: nomor WhatsApp tidak ditemukan', [
                'notifiable' => get_class($notifiable),
                'notifiable_id' => $notifiable->id ?? null,
                'name' => $notifiable->name ?? 'unknown',
            ]);
            return;
        }

        $normalizedPhone = WhatsAppHelper::normalizePhone($phone);

        if (! $normalizedPhone) {
            Log::warning('WhatsAppChannel: gagal normalisasi nomor', [
                'phone' => $phone,
            ]);
            return;
        }

        $message = $notification->toWhatsApp($notifiable);

        Log::info('WhatsAppChannel: mengirim job ke queue', [
            'to' => $normalizedPhone,
            'message' => mb_substr($message, 0, 50),
        ]);

        SendWhatsAppMessage::dispatch($normalizedPhone, $message);
    }
}
