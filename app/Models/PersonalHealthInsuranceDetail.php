<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonalHealthInsuranceDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'customer_name',
        'alternate_mobile',
        'date_of_birth',
        'gender',
        'occupation',
        'customer_address',
        'city',
        'state',
        'pincode',
        'insurance_provider',
        'policy_type',
        'policy_number',
        'sum_insured',
        'existing_premium',
        'policy_start_date',
        'renewal_date',
        'insurance_requirement',
        'interested_plan',
        'budget',
        'current_insurance_details',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'policy_start_date' => 'date',
            'renewal_date' => 'date',
            'sum_insured' => 'decimal:2',
            'existing_premium' => 'decimal:2',
            'budget' => 'decimal:2',
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

    public function familyMembers(): HasMany
    {
        return $this->hasMany(PersonalInsuranceFamilyMember::class);
    }
}
