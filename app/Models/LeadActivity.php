<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'performed_by',
        'performed_by_type',
        'activity_type',
        'title',
        'description',
        'old_value',
        'new_value',
        'activity_data',
        'performed_at',
    ];

    protected function casts(): array
    {
        return [
            'activity_data' => 'array',
            'performed_at' => 'datetime',
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

    public function performedByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'performed_by');
    }
}
