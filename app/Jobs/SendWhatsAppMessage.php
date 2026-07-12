<?php

namespace App\Jobs;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 5;

    public function __construct(
        public string $phone,
        public string $message,
    ) {}

    public function handle(): void
    {
        WhatsAppService::send($this->phone, $this->message);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('WhatsApp message failed after all retries', [
            'phone' => $this->phone,
            'message' => mb_substr($this->message, 0, 50),
            'error' => $exception->getMessage(),
        ]);
    }
}
