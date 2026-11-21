<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HealthAdvisorContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'health_advisor_detail_id',
        'name',
        'mobile',
        'alternate_mobile',
        'email',
        'gender',
        'date_of_birth',
        'occupation',
        'address',
        'city',
        'state',
        'pincode',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
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

    public function healthAdvisorDetail(): BelongsTo
    {
        return $this->belongsTo(
            HealthAdvisorDetail::class,
            'health_advisor_detail_id'
        );
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            HealthAdvisorGroup::class,
            'health_advisor_group_contacts',
            'health_advisor_contact_id',
            'health_advisor_group_id'
        )->withTimestamps();
    }
}
