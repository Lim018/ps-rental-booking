<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'booking_date',
        'session_time',
        'base_price',
        'weekend_surcharge',
        'total_price',
        'status',
        'payment_token',
        'payment_url',
        'payment_id',
        'user_name', 
        'user_email',
        'user_phone',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}