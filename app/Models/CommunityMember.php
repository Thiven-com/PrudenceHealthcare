<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'community_lead_detail_id',
        'member_name',
        'mobile',
        'email',
        'designation',
        'notes',
    ];

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function communityDetail(): BelongsTo
    {
        return $this->belongsTo(
            CommunityLeadDetail::class,
            'community_lead_detail_id'
        );
    }
}
