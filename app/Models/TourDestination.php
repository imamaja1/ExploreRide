<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourDestination extends Model
{
    protected $fillable = [
        'tour_package_id', 'name', 'description', 'photo',
        'order', 'estimated_arrival', 'estimated_departure',
    ];

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }
}
