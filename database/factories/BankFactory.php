<?php

namespace Database\Factories;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankFactory extends Factory
{
    protected $model = Bank::class;

    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Bank Mandiri', 'Bank BCA', 'Bank BNI', 'Bank BRI']),
            'account_number' => fake()->numerify('#############'),
            'account_name' => 'ExploreRide',
            'logo' => null,
            'is_active' => true,
        ];
    }
}
