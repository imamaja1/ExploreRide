<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('+1 day', '+5 days');

        return [
            'booking_code' => 'EXP-' . strtoupper(Str::random(8)),
            'customer_id' => Customer::factory(),
            'car_id' => Car::factory(),
            'service_id' => Service::factory(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => (clone $startDate)->modify('+2 days')->format('Y-m-d'),
            'duration_days' => 3,
            'pickup_location' => fake()->city(),
            'pickup_time' => fake()->time('H:i'),
            'total_price' => fake()->numberBetween(300000, 2000000),
            'status' => fake()->randomElement(['pending', 'waiting_payment', 'confirmed', 'in_progress', 'completed', 'cancelled']),
            'notes' => null,
        ];
    }
}
