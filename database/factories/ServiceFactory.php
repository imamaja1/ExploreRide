<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['Lepas Kunci', 'Dengan Sopir', 'Paket Wisata']);
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numerify('###'),
            'description' => fake()->sentence(),
            'icon' => null,
            'is_active' => true,
        ];
    }
}
