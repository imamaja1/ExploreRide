<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'name', 'brand', 'model', 'year', 'plate_number', 'color',
        'fuel_type', 'transmission', 'seats', 'price_per_day',
        'main_photo', 'description', 'is_active', 'with_driver',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'with_driver' => 'boolean',
            'price_per_day' => 'decimal:2',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
