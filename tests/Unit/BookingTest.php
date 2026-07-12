<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_has_valid_statuses(): void
    {
        $this->assertEquals(
            ['pending', 'waiting_payment', 'confirmed', 'in_progress', 'completed', 'cancelled'],
            Booking::STATUSES
        );
    }

    public function test_active_statuses_exclude_completed_and_cancelled(): void
    {
        $this->assertEquals(
            ['pending', 'waiting_payment', 'confirmed', 'in_progress'],
            Booking::ACTIVE_STATUSES
        );
    }

    public function test_booking_belongs_to_customer(): void
    {
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();
        $service = Service::factory()->create();

        $booking = Booking::factory()->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'service_id' => $service->id,
        ]);

        $this->assertInstanceOf(Customer::class, $booking->customer);
        $this->assertEquals($customer->id, $booking->customer->id);
    }

    public function test_booking_belongs_to_car(): void
    {
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();
        $service = Service::factory()->create();

        $booking = Booking::factory()->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'service_id' => $service->id,
        ]);

        $this->assertInstanceOf(Car::class, $booking->car);
    }

    public function test_booking_belongs_to_driver(): void
    {
        $driver = User::factory()->create(['role' => 'driver']);
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();
        $service = Service::factory()->create();

        $booking = Booking::factory()->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'service_id' => $service->id,
            'driver_id' => $driver->id,
        ]);

        $this->assertInstanceOf(User::class, $booking->driver);
        $this->assertEquals($driver->id, $booking->driver->id);
    }

    public function test_active_scope_only_returns_active_bookings(): void
    {
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();
        $service = Service::factory()->create();

        Booking::factory()->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'service_id' => $service->id,
            'status' => 'completed',
        ]);
        Booking::factory()->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'service_id' => $service->id,
            'status' => 'cancelled',
        ]);
        $active = Booking::factory()->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'service_id' => $service->id,
            'status' => 'confirmed',
        ]);

        $this->assertCount(1, Booking::active()->get());
        $this->assertEquals($active->id, Booking::active()->first()->id);
    }

    public function test_status_badge_style_returns_valid_css(): void
    {
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();
        $service = Service::factory()->create();

        $booking = Booking::factory()->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'service_id' => $service->id,
            'status' => 'pending',
        ]);

        $style = $booking->getStatusBadgeStyle();
        $this->assertArrayHasKey('bg', $style);
        $this->assertArrayHasKey('color', $style);
    }

    public function test_booking_has_payment_relation(): void
    {
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();
        $service = Service::factory()->create();

        $booking = Booking::factory()->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'service_id' => $service->id,
        ]);

        $booking->payment()->create([
            'amount' => $booking->total_price,
            'method' => 'transfer',
            'status' => 'pending',
        ]);

        $this->assertNotNull($booking->payment);
        $this->assertEquals($booking->total_price, $booking->payment->amount);
    }
}
