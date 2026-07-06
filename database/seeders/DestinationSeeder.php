<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            // Pantai
            ['name' => 'Pantai Kuta', 'slug' => 'pantai-kuta', 'category' => 'pantai', 'location' => 'Bali', 'rating' => 4.5, 'description' => 'Pantai terkenal dengan sunset yang indah dan ombak yang cocok untuk berselancar.'],
            ['name' => 'Pantai Sanur', 'slug' => 'pantai-sanur', 'category' => 'pantai', 'location' => 'Bali', 'rating' => 4.3, 'description' => 'Pantai dengan pasir putih dan sunrise yang memukau, cocok untuk keluarga.'],
            ['name' => 'Pantai Nusa Dua', 'slug' => 'pantai-nusa-dua', 'category' => 'pantai', 'location' => 'Bali', 'rating' => 4.6, 'description' => 'Kawasan wisata pantai eksklusif dengan resor mewah dan air jernih.'],
            ['name' => 'Pantai Pangandaran', 'slug' => 'pantai-pangandaran', 'category' => 'pantai', 'location' => 'Jawa Barat', 'rating' => 4.2, 'description' => 'Pantai dengan pasir hitam dan hutan lindung di sekitarnya.'],
            ['name' => 'Pantai Anyer', 'slug' => 'pantai-anyer', 'category' => 'pantai', 'location' => 'Banten', 'rating' => 4.0, 'description' => 'Pantai populer dengan pemandangan Gunung Krakatau di kejauhan.'],

            // Gunung
            ['name' => 'Gunung Bromo', 'slug' => 'gunung-bromo', 'category' => 'gunung', 'location' => 'Jawa Timur', 'rating' => 4.7, 'description' => 'Gunung berapi aktif dengan pemandangan sunrise yang menakjubkan di lautan pasir.'],
            ['name' => 'Gunung Rinjani', 'slug' => 'gunung-rinjani', 'category' => 'gunung', 'location' => 'Lombok', 'rating' => 4.8, 'description' => 'Gunung tertinggi kedua di Indonesia dengan danau kawah yang indah.'],
            ['name' => 'Gunung Merapi', 'slug' => 'gunung-merapi', 'category' => 'gunung', 'location' => 'Yogyakarta', 'rating' => 4.4, 'description' => 'Gunung berapi paling aktif di Indonesia dengan pemandangan spektakuler.'],
            ['name' => 'Kawah Ijen', 'slug' => 'kawah-ijen', 'category' => 'gunung', 'location' => 'Jawa Timur', 'rating' => 4.6, 'description' => 'Kawah dengan api biru dan danau asam terbesar di dunia.'],
            ['name' => 'Gunung Papandayan', 'slug' => 'gunung-papandayan', 'category' => 'gunung', 'location' => 'Jawa Barat', 'rating' => 4.3, 'description' => 'Gunung dengan kawah aktif dan taman edelweis yang indah.'],

            // Air Terjun
            ['name' => 'Air Terjun Tumpak Sewu', 'slug' => 'air-terjun-tumpak-sewu', 'category' => 'air-terjun', 'location' => 'Jawa Timur', 'rating' => 4.7, 'description' => 'Air terjun bertingkat yang indah, dijuluki Niagara-nya Jawa.'],
            ['name' => 'Kawah Putih', 'slug' => 'kawah-putih', 'category' => 'air-terjun', 'location' => 'Jawa Barat', 'rating' => 4.5, 'description' => 'Danau kawah dengan air berwarna putih kehijauan yang unik.'],
            ['name' => 'Air Terjun Gitgit', 'slug' => 'air-terjun-gitgit', 'category' => 'air-terjun', 'location' => 'Bali', 'rating' => 4.3, 'description' => 'Air terjun tertinggi di Bali dengan suasana alam yang asri.'],
            ['name' => 'Air Terjun Madakaripura', 'slug' => 'air-terjun-madakaripura', 'category' => 'air-terjun', 'location' => 'Jawa Timur', 'rating' => 4.4, 'description' => 'Air terjun tertinggi di Jawa dengan tebing batu yang megah.'],
            ['name' => 'Air Terjun Leke Leke', 'slug' => 'air-terjun-leke-leke', 'category' => 'air-terjun', 'location' => 'Bali', 'rating' => 4.2, 'description' => 'Air terjun tersembunyi di tengah hutan tropis yang tenang.'],
        ];

        foreach ($destinations as $dest) {
            Destination::create($dest);
        }
    }
}
