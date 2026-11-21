<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyInsuranceEmployee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'company_health_insurance_detail_id',
        'employee_id',
        'employee_name',
        'mobile',
        'email',
        'date_of_birth',
        'gender',
        'designation',
        'dependent_count',
        'dependent_details',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'dependent_count' => 'integer',
            'dependent_details' => 'array',
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

    public function companyInsuranceDetail(): BelongsTo
    {
        return $this->belongsTo(
            CompanyHealthInsuranceDetail::class,
            'company_health_insurance_detail_id'
        );
    }
}
