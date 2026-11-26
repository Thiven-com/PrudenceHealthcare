<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Hospital;
use App\Models\LeadModule;
use Illuminate\Http\Request;
use App\Models\DoctorLeadDetail;
use App\Models\CommunityLeadDetail;
use App\Models\CompanyHealthInsuranceDetail;
use App\Models\PersonalHealthInsuranceDetail;
use App\Models\CashTreatmentDetail;
use App\Models\CreditTreatmentDetail;
use App\Models\HealthAdvisorDetail;

class LeadOverviewController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = Lead::query();

        // Statistics
        $totalLeads = (clone $baseQuery)->count();

        $newLeads = (clone $baseQuery)
            ->where('status', 'new')
            ->count();

        $contactedLeads = (clone $baseQuery)
            ->where('status', 'contacted')
            ->count();

        $interestedLeads = (clone $baseQuery)
            ->where('status', 'interested')
            ->count();

        $followUpLeads = (clone $baseQuery)
            ->where('status', 'follow_up')
            ->count();

        $convertedLeads = (clone $baseQuery)
            ->where('status', 'converted')
            ->count();

        $closedLeads = (clone $baseQuery)
            ->where('status', 'closed')
            ->count();

        $notInterestedLeads = (clone $baseQuery)
            ->where('status', 'not_interested')
            ->count();

        // Filter options
        $hospitals = Hospital::orderBy('hospital_name')
            ->get(['id', 'hospital_name']);

        $leadModules = LeadModule::where('is_active', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        // Leads listing
        $query = Lead::with([
            'hospital',
            'leadModule',
        ]);

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('leadcode', 'like', "%{$search}%");
            });
        }

        // Hospital filter
        if ($request->filled('hospital_id')) {
            $query->where('hospital_id', $request->hospital_id);
        }

        // Module filter
        if ($request->filled('lead_module_id')) {
            $query->where('lead_module_id', $request->lead_module_id);
        }
        $selectedModule = null;

        if ($request->filled('lead_module_id')) {
            $selectedModule = LeadModule::findOrFail($request->lead_module_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date filters
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $leads = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.lead-overview.index', compact(
            'totalLeads',
            'newLeads',
            'contactedLeads',
            'interestedLeads',
            'followUpLeads',
            'convertedLeads',
            'closedLeads',
            'notInterestedLeads',
            'hospitals',
            'leadModules',
            'leads',
            'selectedModule',
        ));
    }

    public function show($id)
    {
        $lead = Lead::with([
            'hospital',
            'leadModule',
            'followUps',
            'activities',
            'assignedStaff',
        ])->findOrFail($id);

        $moduleDetails = null;

        $slug = $lead->leadModule?->slug;

        $models = [
            'doctor' => DoctorLeadDetail::class,
            'community' => CommunityLeadDetail::class,
            'company-health-insurance' => CompanyHealthInsuranceDetail::class,
            'personal-health-insurance' => PersonalHealthInsuranceDetail::class,
            'cash-treatment' => CashTreatmentDetail::class,
            'credit-treatment' => CreditTreatmentDetail::class,
            'health-advisor' => HealthAdvisorDetail::class,
        ];

        if (isset($models[$slug])) {

            $model = $models[$slug];

            $query = $model::where('hospital_id', $lead->hospital_id)
                ->where('lead_id', $lead->id);

            if ($slug === 'community') {
                $query->with('members');
            }

            if ($slug === 'company-health-insurance') {
                $query->with('employees');
            }

            $moduleDetails = $query->first();
        }

        return view('admin.lead-overview.show', compact(
            'lead',
            'moduleDetails'
        ));
    }
}
