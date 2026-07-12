<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use App\Notifications\BookingCreated;
use App\Notifications\BookingConfirmed;
use App\Notifications\DriverAssigned;
use App\Notifications\TripCompleted;
use App\Notifications\TripStarted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    private Customer $customer;
    private Car $car;
    private Service $service;
    private Bank $bank;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = Customer::factory()->create([
            'email' => 'test@example.com',
            'name' => 'Test Customer',
            'whatsapp' => '6281234567890',
        ]);

        $this->car = Car::factory()->create([
            'price_per_day' => 300000,
            'is_active' => true,
        ]);

        $this->service = Service::factory()->create(['is_active' => true]);
        $this->bank = Bank::factory()->create(['is_active' => true]);
    }

    public function test_booking_created_notification_via_whatsapp(): void
    {
        Notification::fake();

        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'service_id' => $this->service->id,
            'total_price' => 600000,
        ]);

        $this->customer->notify(new BookingCreated($booking));

        Notification::assertSentTo($this->customer, BookingCreated::class);
    }

    public function test_booking_confirmed_notification_via_whatsapp(): void
    {
        Notification::fake();

        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'service_id' => $this->service->id,
            'total_price' => 600000,
        ]);

        $this->customer->notify(new BookingConfirmed($booking));

        Notification::assertSentTo($this->customer, BookingConfirmed::class);
    }

    public function test_driver_assigned_notification_via_whatsapp(): void
    {
        Notification::fake();

        $driver = User::factory()->create(['role' => 'driver']);

        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'service_id' => $this->service->id,
            'driver_id' => $driver->id,
            'total_price' => 600000,
        ]);

        $driver->notify(new DriverAssigned($booking));

        Notification::assertSentTo($driver, DriverAssigned::class);
    }

    public function test_trip_started_notification_via_whatsapp(): void
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin', 'whatsapp' => '6281234567890']);

        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'service_id' => $this->service->id,
            'total_price' => 600000,
        ]);

        $admin->notify(new TripStarted($booking));

        Notification::assertSentTo($admin, TripStarted::class);
    }

    public function test_trip_completed_notification_via_whatsapp(): void
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin', 'whatsapp' => '6281234567890']);

        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'service_id' => $this->service->id,
            'total_price' => 600000,
        ]);

        $admin->notify(new TripCompleted($booking));

        Notification::assertSentTo($admin, TripCompleted::class);
    }

    public function test_notification_not_sent_when_whatsapp_disabled(): void
    {
        \App\Models\Setting::set('whatsapp_enabled', '0');

        Notification::fake();

        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'service_id' => $this->service->id,
            'total_price' => 600000,
        ]);

        $this->customer->notify(new BookingCreated($booking));

        Notification::assertNothingSent();
    }
}
