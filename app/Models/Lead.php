<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'lead_module_id',
        'leadcode',
        'name',
        'mobile',
        'alternate_mobile',
        'email',
        'address',
        'city',
        'state',
        'pincode',
        'status',
        'source',
        'remarks',
        'created_by',
        'created_by_type',
        'assigned_to',
        'assigned_to_type',
        'assigned_at',
        'next_follow_up_at',
        'converted_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'next_follow_up_at' => 'datetime',
            'converted_at' => 'datetime',
            'is_active' => 'boolean',
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

    public function doctorDetail(): HasOne
    {
        return $this->hasOne(DoctorLeadDetail::class);
    }

    public function communityDetail(): HasOne
    {
        return $this->hasOne(CommunityLeadDetail::class);
    }

    public function companyInsuranceDetail(): HasOne
    {
        return $this->hasOne(CompanyHealthInsuranceDetail::class);
    }

    public function personalInsuranceDetail(): HasOne
    {
        return $this->hasOne(PersonalHealthInsuranceDetail::class);
    }

    public function cashTreatmentDetail(): HasOne
    {
        return $this->hasOne(CashTreatmentDetail::class);
    }

    public function creditTreatmentDetail(): HasOne
    {
        return $this->hasOne(CreditTreatmentDetail::class);
    }

    public function healthAdvisorDetail(): HasOne
    {
        return $this->hasOne(HealthAdvisorDetail::class);
    }
    public function assignments()
    {
        return $this->hasMany(LeadAssignment::class);
    }
    public function followUps()
    {
        return $this->hasMany(LeadFollowUp::class);
    }
    public function statusHistories()
    {
        return $this->hasMany(LeadStatusHistory::class);
    }
    public function activities()
    {
        return $this->hasMany(LeadActivity::class);
    }
    public function attachments()
    {
        return $this->hasMany(LeadAttachment::class);
    }
    public function tasks()
    {
        return $this->hasMany(LeadTask::class);
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_to', 'id');
    }
}
