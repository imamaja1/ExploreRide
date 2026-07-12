<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookingFlowTest extends TestCase
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

    public function test_customer_can_create_booking(): void
    {
        Auth::guard('customer')->login($this->customer);

        $response = $this->post('/booking', [
            'service_id' => $this->service->id,
            'car_id' => $this->car->id,
            'start_date' => now()->addDay()->format('Y-m-d'),
            'duration_days' => 2,
            'pickup_location' => 'Bandara',
            'pickup_time' => '09:00',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'customer_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'service_id' => $this->service->id,
            'status' => 'pending',
        ]);
    }

    public function test_booking_prevents_overlapping_dates(): void
    {
        Auth::guard('customer')->login($this->customer);

        $startDate = now()->addDay()->format('Y-m-d');

        $this->post('/booking', [
            'service_id' => $this->service->id,
            'car_id' => $this->car->id,
            'start_date' => $startDate,
            'duration_days' => 3,
        ]);

        sleep(1);

        $response = $this->post('/booking', [
            'service_id' => $this->service->id,
            'car_id' => $this->car->id,
            'start_date' => $startDate,
            'duration_days' => 2,
        ]);

        $response->assertSessionHasErrors('car_id');
    }

    public function test_guest_cannot_create_booking(): void
    {
        $response = $this->post('/booking', [
            'service_id' => $this->service->id,
            'car_id' => $this->car->id,
            'start_date' => now()->addDay()->format('Y-m-d'),
            'duration_days' => 2,
        ]);

        $response->assertRedirect('/?modal=login');
    }

    public function test_customer_can_upload_payment(): void
    {
        Storage::fake('public');
        Auth::guard('customer')->login($this->customer);

        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'service_id' => $this->service->id,
            'status' => 'pending',
            'total_price' => 600000,
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $response = $this->post("/booking/{$booking->id}/payment", [
            'bank_id' => $this->bank->id,
            'account_name' => 'Test Account',
            'proof_photo' => UploadedFile::fake()->image('proof.jpg'),
        ]);

        $response->assertRedirect();

        $booking->refresh();
        $this->assertEquals('waiting_payment', $booking->status);
        $this->assertNotNull($booking->payment);
        $this->assertEquals('pending', $booking->payment->status);
    }

    public function test_admin_can_confirm_payment(): void
    {
        Storage::fake('public');
        Auth::guard('customer')->login($this->customer);

        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'service_id' => $this->service->id,
            'status' => 'waiting_payment',
            'total_price' => 600000,
        ]);

        $booking->payment()->create([
            'amount' => 600000,
            'method' => 'transfer',
            'bank_id' => $this->bank->id,
            'bank_name' => $this->bank->name,
            'account_number' => $this->bank->account_number,
            'account_name' => 'Test',
            'status' => 'pending',
        ]);

        Auth::guard('customer')->logout();
        Auth::guard('web')->logout();

        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        Auth::login($admin);

        $response = $this->post("/admin/bookings/{$booking->id}/confirm-payment");

        $response->assertRedirect();

        $booking->refresh();
        $this->assertEquals('confirmed', $booking->status);
        $this->assertEquals('verified', $booking->payment->status);
    }

    public function test_admin_can_assign_driver(): void
    {
        Auth::guard('customer')->login($this->customer);

        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'service_id' => $this->service->id,
            'status' => 'confirmed',
            'total_price' => 600000,
        ]);

        Auth::guard('customer')->logout();

        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $driver = User::factory()->create(['role' => 'driver', 'is_active' => true]);
        Auth::login($admin);

        $response = $this->post("/admin/bookings/{$booking->id}/assign-driver", [
            'driver_id' => $driver->id,
        ]);

        $response->assertRedirect();

        $booking->refresh();
        $this->assertEquals($driver->id, $booking->driver_id);
    }

    public function test_admin_can_cancel_booking(): void
    {
        Auth::guard('customer')->login($this->customer);

        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'service_id' => $this->service->id,
            'status' => 'pending',
            'total_price' => 600000,
        ]);

        Auth::guard('customer')->logout();

        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        Auth::login($admin);

        $response = $this->post("/admin/bookings/{$booking->id}/cancel");

        $response->assertRedirect();

        $booking->refresh();
        $this->assertEquals('cancelled', $booking->status);
    }
}
