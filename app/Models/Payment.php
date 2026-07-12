<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id', 'amount', 'method', 'bank_id', 'bank_name',
        'account_number', 'account_name', 'proof_photo', 'notes',
    ];

    protected $guarded = [
        'id', 'status', 'verified_by', 'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'verified_at' => 'datetime',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
