<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'staff_id',
        'lead_module_id',
        'can_view',
        'can_create',
        'can_edit',
        'can_delete',
        'can_assign',
        'can_export',
        'assigned_by',
        'assigned_at',
    ];

    protected function casts(): array
    {
        return [
            'can_view' => 'boolean',
            'can_create' => 'boolean',
            'can_edit' => 'boolean',
            'can_delete' => 'boolean',
            'can_assign' => 'boolean',
            'can_export' => 'boolean',
            'assigned_at' => 'datetime',
        ];
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function leadModule(): BelongsTo
    {
        return $this->belongsTo(LeadModule::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_by');
    }
}
