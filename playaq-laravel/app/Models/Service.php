<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'professional_profile_id',
        'name',
        'description',
        'price_min',
        'price_max'
    ];

    /**
     * Get the professional profile that offers this service.
     */
    public function professionalProfile()
    {
        return $this->belongsTo(ProfessionalProfile::class);
    }
}
