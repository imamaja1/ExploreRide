<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    const STATUSES = ['pending', 'waiting_payment', 'confirmed', 'in_progress', 'completed', 'cancelled'];

    const STATUS_BADGES = [
        'pending'          => ['bg' => '#f3f4f6', 'color' => '#374151'],
        'waiting_payment'  => ['bg' => '#fef3c7', 'color' => '#92400e'],
        'confirmed'        => ['bg' => '#dbeafe', 'color' => '#1e40af'],
        'in_progress'      => ['bg' => '#ede9fe', 'color' => '#5b21b6'],
        'completed'        => ['bg' => '#d1fae5', 'color' => '#065f46'],
        'cancelled'        => ['bg' => '#fee2e2', 'color' => '#991b1b'],
    ];

    const ACTIVE_STATUSES = ['pending', 'waiting_payment', 'confirmed', 'in_progress'];

    protected $fillable = [
        'booking_code', 'customer_id', 'car_id', 'service_id', 'tour_package_id',
        'start_date', 'end_date', 'duration_days', 'pickup_location', 'dropoff_location',
        'pickup_time', 'total_price', 'status', 'driver_id', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'pickup_time' => 'datetime:H:i',
            'total_price' => 'decimal:2',
        ];
    }

    public function getStatusBadgeStyle(): array
    {
        return self::STATUS_BADGES[$this->status] ?? self::STATUS_BADGES['pending'];
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', self::ACTIVE_STATUSES);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
