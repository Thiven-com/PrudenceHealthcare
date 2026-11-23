<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalFacility extends Model
{
    protected $fillable = [
        'hospital_id',
        'facility_name',
        'facility_category',
        'description',
        'is_available',
        'operating_hours',
        'contact_number',
        'image',
        'status',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}