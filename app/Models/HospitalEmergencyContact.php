<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalEmergencyContact extends Model
{
    protected $fillable = [
        'hospital_id',
        'contact_name',
        'emergency_type',
        'mobile',
        'alternate_mobile',
        'email',
        'availability',
        'description',
        'status',
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}