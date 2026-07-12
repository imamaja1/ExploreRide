<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'phone' => '0812-3456-7890',
            'whatsapp' => '6285941208706',
            'email' => 'info@exploreride.com',
            'address' => 'Jl. Raya Wisata No. 123, Kota Wisata, Indonesia',
            'instagram' => '#',
            'facebook' => '#',
            'twitter' => '#',
            'email_enabled' => '0',
            'mail_mailer' => 'smtp',
            'mail_host' => '',
            'mail_port' => '587',
            'mail_username' => '',
            'mail_password' => '',
            'mail_encryption' => 'tls',
            'mail_from_address' => 'noreply@exploreride.com',
            'mail_from_name' => 'ExploreRide',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
