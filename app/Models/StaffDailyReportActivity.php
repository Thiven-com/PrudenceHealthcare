<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffDailyReportActivity extends Model
{
    protected $fillable = [
        'hospital_id',
        'staff_daily_report_id',
        'staff_id',
        'lead_id',
        'activity_type',
        'organization_name',
        'contact_person',
        'mobile',
        'description',
        'outcome',
        'next_follow_up_at',
        'activity_at',
    ];

    protected $casts = [
        'next_follow_up_at' => 'datetime',
        'activity_at' => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(
            StaffDailyReport::class,
            'staff_daily_report_id'
        );
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
