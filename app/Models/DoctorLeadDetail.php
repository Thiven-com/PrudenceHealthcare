<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorLeadDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'doctor_name',
        'alternate_mobile',
        'gender',
        'date_of_birth',
        'qualification',
        'specialization',
        'medical_registration_number',
        'experience_years',
        'consultation_type',
        'hospital_clinic_name',
        'clinic_address',
        'clinic_city',
        'clinic_state',
        'clinic_pincode',
        'reference_source',
        'interested_services',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'experience_years' => 'integer',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }
}
