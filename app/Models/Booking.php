<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'professional_profile_id',
        'service_name',
        'description',
        'booking_date',
        'booking_time',
        'deposit_amount',
        'total_estimated_cost',
        'status',
        'rating',
        'review_comment',
        'photo_paths'
    ];

    protected $casts = [
        'photo_paths' => 'array'
    ];

    /**
     * Get the customer user who made the booking.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the professional profile booked.
     */
    public function professionalProfile()
    {
        return $this->belongsTo(ProfessionalProfile::class, 'professional_profile_id');
    }
}
