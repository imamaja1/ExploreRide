<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            [
                'name' => 'Toyota Avanza',
                'brand' => 'Toyota',
                'model' => 'Avanza 1.3 E',
                'year' => 2022,
                'plate_number' => 'B 1234 XYZ',
                'color' => 'Putih',
                'fuel_type' => 'Bensin',
                'transmission' => 'Manual',
                'seats' => 7,
                'price_per_day' => 350000,
                'description' => 'Mobil keluarga yang nyaman dan irit bahan bakar. Cocok untuk perjalanan jauh bersama keluarga.',
                'with_driver' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Toyota Avanza (Sopir)',
                'brand' => 'Toyota',
                'model' => 'Avanza 1.5 G',
                'year' => 2023,
                'plate_number' => 'B 5678 ABC',
                'color' => 'Hitam',
                'fuel_type' => 'Bensin',
                'transmission' => 'Manual',
                'seats' => 7,
                'price_per_day' => 500000,
                'description' => 'Mobil Avanza dengan sopir profesional. Santai dan nikmati perjalanan Anda.',
                'with_driver' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Honda Brio',
                'brand' => 'Honda',
                'model' => 'Brio Satya E',
                'year' => 2023,
                'plate_number' => 'D 9012 EFG',
                'color' => 'Merah',
                'fuel_type' => 'Bensin',
                'transmission' => 'Matic',
                'seats' => 5,
                'price_per_day' => 280000,
                'description' => 'Mobil mungil dan lincah untuk perjalanan di perkotaan. Irit dan mudah parkir.',
                'with_driver' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Daihatsu Xenia',
                'brand' => 'Daihatsu',
                'model' => 'Xenia 1.3 R',
                'year' => 2022,
                'plate_number' => 'B 3456 HIJ',
                'color' => 'Silver',
                'fuel_type' => 'Bensin',
                'transmission' => 'Manual',
                'seats' => 7,
                'price_per_day' => 330000,
                'description' => 'Mobil keluarga lega dengan kabin luas. Nyaman untuk perjalanan jarak jauh.',
                'with_driver' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Toyota Innova',
                'brand' => 'Toyota',
                'model' => 'Innova 2.0 G',
                'year' => 2023,
                'plate_number' => 'B 7890 KLM',
                'color' => 'Putih',
                'fuel_type' => 'Diesel',
                'transmission' => 'Manual',
                'seats' => 7,
                'price_per_day' => 600000,
                'description' => 'Mobil premium dengan kabin luas dan kenyamanan maksimal. Cocok untuk perjalanan bisnis atau keluarga.',
                'with_driver' => true,
                'is_active' => true,
            ],
        ];

        foreach ($cars as $c) {
            Car::create($c);
        }
    }
}
