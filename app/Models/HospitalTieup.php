<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalTieup extends Model
{
    protected $fillable = [
        'hospital_id',
        'organization_name',
        'tieup_type',
        'contact_person',
        'mobile',
        'email',
        'address',
        'description',
        'image',
        'status',
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}