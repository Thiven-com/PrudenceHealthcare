<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthAdvisorGroupContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'health_advisor_group_id',
        'health_advisor_contact_id',
    ];

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(
            HealthAdvisorGroup::class,
            'health_advisor_group_id'
        );
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(
            HealthAdvisorContact::class,
            'health_advisor_contact_id'
        );
    }
}
