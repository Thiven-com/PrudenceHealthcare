<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadFollowUp extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'followed_up_by',
        'followed_up_by_type',
        'follow_up_date',
        'follow_up_type',
        'follow_up_status',
        'discussion',
        'customer_response',
        'remarks',
        'next_follow_up_at',
    ];

    protected function casts(): array
    {
        return [
            'follow_up_date' => 'datetime',
            'next_follow_up_at' => 'datetime',
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

    public function followedUpByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'followed_up_by');
    }
}
