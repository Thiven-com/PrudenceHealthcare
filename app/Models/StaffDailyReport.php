<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffDailyReport extends Model
{
    protected $fillable = [
        'hospital_id',
        'staff_id',
        'report_date',
        'working_status',
        'start_time',
        'end_time',
        'work_summary',
        'achievements',
        'challenges',
        'pending_work',
        'tomorrow_plan',
        'status',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'report_date' => 'date',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function activities()
    {
        return $this->hasMany(
            StaffDailyReportActivity::class,
            'staff_daily_report_id'
        );
    }

    public function reviews()
    {
        return $this->hasMany(
            StaffDailyReportReview::class,
            'staff_daily_report_id'
        );
    }
}
