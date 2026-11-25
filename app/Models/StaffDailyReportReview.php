<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffDailyReportReview extends Model
{
    protected $fillable = [
        'hospital_id',
        'staff_daily_report_id',
        'reviewer_id',
        'reviewer_type',
        'status',
        'remarks',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(
            StaffDailyReport::class,
            'staff_daily_report_id'
        );
    }
}
