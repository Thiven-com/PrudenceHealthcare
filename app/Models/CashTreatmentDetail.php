<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashTreatmentDetail extends Model
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
        'disease',
        'treatment_description',
        'doctor_name',
        'hospital_name',
        'appointment_date',
        'appointment_time',
        'appointment_status',
        'estimated_amount',
        'final_amount',
        'advance_amount',
        'balance_amount',
        'payment_status',
        'reference_source',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'appointment_date' => 'date',
            'estimated_amount' => 'decimal:2',
            'final_amount' => 'decimal:2',
            'advance_amount' => 'decimal:2',
            'balance_amount' => 'decimal:2',
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
