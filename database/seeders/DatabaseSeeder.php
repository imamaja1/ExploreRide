<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin ExploreRide',
            'email' => 'admin@exploreride.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'whatsapp' => '6285941208706',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Driver 1',
            'email' => 'driver1@exploreride.com',
            'password' => Hash::make('password'),
            'role' => 'driver',
            'phone' => '081234567890',
            'whatsapp' => '6285941208706',
            'is_active' => true,
        ]);

        $services = [
            ['name' => 'Sewa Mobil Lepas Kunci', 'slug' => 'lepas-kunci', 'description' => 'Sewa mobil tanpa sopir, bawa sendiri', 'is_active' => true],
            ['name' => 'Sewa Mobil + Sopir', 'slug' => 'dengan-sopir', 'description' => 'Sewa mobil lengkap dengan sopir profesional', 'is_active' => true],
            ['name' => 'Paket Wisata', 'slug' => 'paket-wisata', 'description' => 'Paket lengkap mobil + sopir + rute wisata', 'is_active' => true],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        Bank::create([
            'name' => 'Bank Mandiri',
            'account_number' => '1234567890',
            'account_name' => 'ExploreRide',
            'is_active' => true,
        ]);

        Bank::create([
            'name' => 'Bank BCA',
            'account_number' => '0987654321',
            'account_name' => 'ExploreRide',
            'is_active' => true,
        ]);

        $this->call(DestinationCategorySeeder::class);
        $this->call(DestinationSeeder::class);
        $this->call(TestimonialSeeder::class);
        $this->call(TourPackageSeeder::class);
        $this->call(CarSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
