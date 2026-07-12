<?php

namespace App\Helpers;

class WhatsAppHelper
{
    public static function normalizePhone(string $phone): ?string
    {
        $phone = preg_replace('/[\s\-+()]/', '', trim($phone));

        if (empty($phone)) {
            return null;
        }

        if (str_starts_with($phone, '62')) {
            return $phone;
        }

        if (str_starts_with($phone, '0')) {
            return '62'.substr($phone, 1);
        }

        if (str_starts_with($phone, '8')) {
            return '62'.$phone;
        }

        return $phone;
    }
}
