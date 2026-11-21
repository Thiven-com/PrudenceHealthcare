<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalInsuranceFamilyMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'personal_health_insurance_detail_id',
        'member_name',
        'relationship',
        'date_of_birth',
        'gender',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function insuranceDetail(): BelongsTo
    {
        return $this->belongsTo(
            PersonalHealthInsuranceDetail::class,
            'personal_health_insurance_detail_id'
        );
    }
}
