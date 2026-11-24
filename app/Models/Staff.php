<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    protected $table = 'staff';

    protected $fillable = [
        'hospital_id',
        'department_id',
        'designation_id',
        'reporting_manager_id',
        'employee_code',
        'name',
        'mobile',
        'email',
        'gender',
        'date_of_birth',
        'address',
        'password',
        'profile_image',
        'staff_type',
        'joining_date',
        'leaving_date',
        'status',
        'last_login_at',
        'added_by',
        'added_by_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'joining_date' => 'date',
            'leaving_date' => 'date',
            'last_login_at' => 'datetime',
        ];
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public function reportingManager(): BelongsTo
    {
        return $this->belongsTo(
            Staff::class,
            'reporting_manager_id'
        );
    }

    public function teamMembers(): HasMany
    {
        return $this->hasMany(
            Staff::class,
            'reporting_manager_id'
        );
    }

    public function otps(): HasMany
    {
        return $this->hasMany(StaffOtp::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
    public function permissions()
    {
        return $this->hasMany(StaffPermission::class);
    }
    public function assignedTasks()
    {
        return $this->hasMany(LeadTask::class, 'assigned_to');
    }

    public function createdTasks()
    {
        return $this->hasMany(LeadTask::class, 'assigned_by');
    }
    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
