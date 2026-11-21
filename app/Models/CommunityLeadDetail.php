<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityLeadDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'community_name',
        'community_type',
        'description',
        'total_members',
        'president_head',
        'contact_person',
        'contact_designation',
        'community_address',
        'city',
        'state',
        'pincode',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'total_members' => 'integer',
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

    public function members(): HasMany
    {
        return $this->hasMany(CommunityMember::class);
    }
}
