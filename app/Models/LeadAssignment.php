<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadAssignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'assigned_by',
        'assigned_by_type',
        'assigned_to',
        'assigned_to_type',
        'assigned_at',
        'accepted_at',
        'completed_at',
        'status',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'accepted_at' => 'datetime',
            'completed_at' => 'datetime',
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

    public function assignedByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_by');
    }

    public function assignedToStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_to');
    }
}
