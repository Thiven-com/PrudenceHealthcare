<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HospitalActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'performed_by',
        'performed_by_type',
        'module',
        'activity_type',
        'title',
        'description',
        'record_type',
        'record_id',
        'old_values',
        'new_values',
        'performed_at',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'performed_at' => 'datetime',
        ];
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
