<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditTreatmentDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'patient_name',
        'alternate_mobile',
        'patient_email',
        'age',
        'gender',
        'treatment_type',
        'specialization',
        'hospital_name',
        'doctor_name',
        'treatment_description',
        'estimated_amount',
        'credit_provider',
        'credit_amount_required',
        'credit_type',
        'application_reference',
        'application_date',
        'approval_status',
        'approved_amount',
        'rejection_reason',
        'treatment_status',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'application_date' => 'date',
            'estimated_amount' => 'decimal:2',
            'credit_amount_required' => 'decimal:2',
            'approved_amount' => 'decimal:2',
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
