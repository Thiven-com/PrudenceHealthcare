<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthAdvisorImport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_id',
        'health_advisor_detail_id',
        'uploaded_by',
        'file_name',
        'file_path',
        'file_type',
        'total_records',
        'imported_records',
        'duplicate_records',
        'failed_records',
        'status',
        'error_details',
        'imported_at',
    ];

    protected function casts(): array
    {
        return [
            'total_records' => 'integer',
            'imported_records' => 'integer',
            'duplicate_records' => 'integer',
            'failed_records' => 'integer',
            'imported_at' => 'datetime',
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

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'uploaded_by');
    }
}
