<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'duration_days',
        'main_photo', 'route', 'includes', 'excludes', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'price' => 'decimal:2',
            'route' => 'array',
        ];
    }

    public function destinations()
    {
        return $this->hasMany(TourDestination::class)->orderBy('order');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
