<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyHealthInsuranceDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'company_name',
        'industry',
        'company_address',
        'city',
        'state',
        'pincode',
        'website',
        'employee_count',
        'hr_name',
        'hr_designation',
        'hr_mobile',
        'hr_email',
        'alternate_contact',
        'insurance_provider',
        'policy_type',
        'policy_number',
        'sum_insured',
        'premium',
        'policy_start_date',
        'renewal_date',
        'covered_employee_count',
        'current_insurance_details',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'employee_count' => 'integer',
            'covered_employee_count' => 'integer',
            'sum_insured' => 'decimal:2',
            'premium' => 'decimal:2',
            'policy_start_date' => 'date',
            'renewal_date' => 'date',
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

    public function employees()
    {
        return $this->hasMany(CompanyInsuranceEmployee::class);
    }
}
