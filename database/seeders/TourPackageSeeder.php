<?php

namespace Database\Seeders;

use App\Models\TourPackage;
use Illuminate\Database\Seeder;

class TourPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Paket Bromo Sunrise',
                'slug' => 'paket-bromo-sunrise',
                'description' => 'Nikmati matahari terbit yang spektakuler di Gunung Bromo. Paket lengkap dengan transportasi, penginapan, dan pemandu wisata profesional.',
                'price' => 850000,
                'duration_days' => 2,
                'route' => ['Penjemputan di hotel', 'Menuju Bromo', 'Sunrise di Bromo', 'Kawah Bromo', 'Kembali ke hotel'],
                'includes' => 'Mobil + Sopir, Tiket masuk, Pemandu lokal, Makan 1x, Air mineral',
                'excludes' => 'Penginapan, Pribadi belanja, Tips',
                'is_active' => true,
            ],
            [
                'name' => 'Paket Bali Selatan',
                'slug' => 'paket-bali-selatan',
                'description' => 'Jelajahi keindahan Bali Selatan: Pantai Kuta, Uluwatu, Jimbaran, dan Tanah Lot. Cocok untuk liburan keluarga.',
                'price' => 1200000,
                'duration_days' => 3,
                'route' => ['Penjemputan di bandara', 'Pantai Kuta', 'Uluwatu', 'Jimbaran', 'Tanah Lot', 'Antar ke bandara'],
                'includes' => 'Mobil + Sopir, BBM, Tiket wisata, Air mineral',
                'excludes' => 'Penginapan, Makan, Tips',
                'is_active' => true,
            ],
            [
                'name' => 'Paket Bandung Lembang',
                'slug' => 'paket-bandung-lembang',
                'description' => 'Wisata seru di Bandung dan Lembang. Kunjungi Kawah Putih, Floating Market, dan Farmhouse.',
                'price' => 650000,
                'duration_days' => 1,
                'route' => ['Penjemputan di hotel', 'Kawah Putih', 'Floating Market', 'Farmhouse Lembang', 'Kembali ke hotel'],
                'includes' => 'Mobil + Sopir, BBM, Tiket masuk, Air mineral',
                'excludes' => 'Makan, Oleh-oleh, Tips',
                'is_active' => true,
            ],
            [
                'name' => 'Paket Yogyakarta Ekspres',
                'slug' => 'paket-yogyakarta-ekspres',
                'description' => 'Liburan singkat ke Yogyakarta. Kunjungi Candi Borobudur, Malioboro, dan Pantai Parangtritis.',
                'price' => 750000,
                'duration_days' => 2,
                'route' => ['Penjemputan di hotel/stasiun', 'Candi Borobudur', 'Malioboro', 'Pantai Parangtritis', 'Kembali'],
                'includes' => 'Mobil + Sopir, BBM, Tiket masuk, Air mineral',
                'excludes' => 'Penginapan, Makan, Tips',
                'is_active' => true,
            ],
            [
                'name' => 'Paket Malang Rafting',
                'slug' => 'paket-malang-rafting',
                'description' => 'Petualangan arung jeram di Sungai Konto, Malang. Paket lengkap dengan peralatan dan instruktur profesional.',
                'price' => 550000,
                'duration_days' => 1,
                'route' => ['Penjemputan di hotel', 'Basecamp rafting', 'Arung jeram', 'Makan siang', 'Kembali'],
                'includes' => 'Mobil + Sopir, Peralatan rafting, Instruktur, Makan siang, Air mineral',
                'excludes' => 'Pakaian ganti, Tips, Dokumentasi',
                'is_active' => true,
            ],
        ];

        foreach ($packages as $p) {
            TourPackage::create($p);
        }
    }
}
