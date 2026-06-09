<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalProfile extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'specialty',
        'bio',
        'experience_years',
        'location',
        'phone',
        'rating',
        'completed_jobs',
        'image_path',
        'total_earnings',
        'payout_balance'
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the services offered by this professional.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the bookings received by this professional.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'professional_profile_id');
    }
}
