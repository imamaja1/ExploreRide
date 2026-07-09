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
            'whatsapp' => '6281234567890',
            'email' => 'info@exploreride.com',
            'address' => 'Jl. Raya Wisata No. 123, Kota Wisata, Indonesia',
            'instagram' => '#',
            'facebook' => '#',
            'twitter' => '#',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
