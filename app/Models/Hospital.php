<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Hospital extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'hospital_name',
        'registration_number',
        'contact_person',
        'mobile',
        'email',
        'address',
        'city',
        'state',
        'pincode',
        'logo',
        'is_mobile_verified',
        'mobile_verified_at',
        'approval_status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'is_mobile_verified' => 'boolean',
            'mobile_verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function isApproved(): bool
    {
        return $this->approval_status === 'approved'
            && $this->is_active;
    }
    public function otps(): HasMany
    {
        return $this->hasMany(HospitalOtp::class);
    }
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
    public function activities()
    {
        return $this->hasMany(HospitalActivity::class);
    }
    public function documents(): HasMany
    {
        return $this->hasMany(HospitalDocument::class);
    }
    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function tieups()
    {
        return $this->hasMany(HospitalTieup::class);
    }

    public function facilities()
    {
        return $this->hasMany(HospitalFacility::class);
    }

    public function emergencyContacts()
    {
        return $this->hasMany(HospitalEmergencyContact::class);
    }
}
