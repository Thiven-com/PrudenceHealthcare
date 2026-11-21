<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthAdvisorDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'advisor_name',
        'advisor_code',
        'advisor_type',
        'qualification',
        'experience',
        'description',
        'address',
        'city',
        'state',
        'pincode',
        'joining_date',
        'reference_source',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'joining_date' => 'date',
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

    public function groups(): HasMany
    {
        return $this->hasMany(HealthAdvisorGroup::class);
    }
}
