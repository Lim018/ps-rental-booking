<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_date',
        'session_time',
        'service_id',
        'user_name',
        'user_phone',
        'base_price',
        'weekend_surcharge',
        'total_price',
        'status',
        'notes',
        'is_used',
        'used_at',
        'payment_url',
        'payment_token',
        'payment_id',
        'pdf_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'booking_date' => 'date',
        'is_used' => 'boolean',
        'used_at' => 'datetime',
        'base_price' => 'float',
        'weekend_surcharge' => 'float',
        'total_price' => 'float',
    ];

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the service that owns the booking.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

