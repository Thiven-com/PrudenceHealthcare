<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HospitalModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'lead_module_id',
        'is_enabled',
        'enabled_by',
        'enabled_at',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'enabled_at' => 'datetime',
        ];
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function leadModule(): BelongsTo
    {
        return $this->belongsTo(LeadModule::class);
    }

    public function enabledBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'enabled_by');
    }
}
