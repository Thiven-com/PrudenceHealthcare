<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HealthAdvisorGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'health_advisor_detail_id',
        'group_name',
        'group_type',
        'description',
        'location',
        'city',
        'state',
        'pincode',
        'total_contacts',
        'remarks',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'total_contacts' => 'integer',
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

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(
            HealthAdvisorContact::class,
            'health_advisor_group_contacts',
            'health_advisor_group_id',
            'health_advisor_contact_id'
        )->withTimestamps();
    }
}
