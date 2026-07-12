<?php

namespace App\Notifications;

class WhatsAppMessage
{
    public function __construct(
        public string $message
    ) {}
}
