<?php

namespace Database\Seeders;

use App\Models\DestinationCategory;
use Illuminate\Database\Seeder;

class DestinationCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['slug' => 'pantai', 'name' => 'Pantai', 'is_active' => true],
            ['slug' => 'gunung', 'name' => 'Gunung', 'is_active' => true],
            ['slug' => 'air-terjun', 'name' => 'Air Terjun', 'is_active' => true],
        ];

        foreach ($categories as $c) {
            DestinationCategory::create($c);
        }
    }
}
