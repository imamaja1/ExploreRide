<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Avanza', 'Xenia', 'Brio', 'Jazz', 'Innova']),
            'brand' => fake()->randomElement(['Toyota', 'Honda', 'Daihatsu']),
            'model' => fake()->year(),
            'year' => fake()->year(),
            'plate_number' => strtoupper(fake()->bothify('? #### ??')),
            'color' => fake()->safeColorName(),
            'fuel_type' => fake()->randomElement(['bensin', 'solar']),
            'transmission' => fake()->randomElement(['manual', 'matic']),
            'seats' => fake()->numberBetween(4, 8),
            'price_per_day' => fake()->numberBetween(200000, 1000000),
            'description' => fake()->sentence(),
            'is_active' => true,
            'with_driver' => false,
        ];
    }
}
