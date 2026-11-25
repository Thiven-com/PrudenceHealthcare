<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceRecord extends Model
{
    protected $fillable = [
        'hospital_id',
        'staff_id',
        'designation_id',
        'performance_target_id',
        'target_quantity',
        'achieved_quantity',
        'period_start',
        'period_end',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
    ];

    public function target()
    {
        return $this->belongsTo(
            PerformanceTarget::class,
            'performance_target_id'
        );
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
