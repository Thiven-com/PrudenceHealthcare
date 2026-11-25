<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceTarget extends Model
{
    protected $fillable = [
        'hospital_id',
        'designation_id',
        'target_name',
        'target_type',
        'target_quantity',
        'target_period',
        'start_date',
        'end_date',
        'created_by',
        'created_by_type',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function records()
    {
        return $this->hasMany(PerformanceRecord::class);
    }
}
