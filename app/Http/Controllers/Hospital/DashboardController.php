<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Staff;
use App\Models\Lead;
use App\Models\LeadModule;
use App\Models\LeadFollowUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hospitalId = Auth::guard('hospital')->id();

        $hospital = Hospital::findOrFail($hospitalId);

        // Staff statistics
        $totalStaff = Staff::where('hospital_id', $hospitalId)
            ->count();

        $activeStaff = Staff::where('hospital_id', $hospitalId)
            ->where('status', 'active')
            ->count();

        $inactiveStaff = Staff::where('hospital_id', $hospitalId)
            ->where('status', 'inactive')
            ->count();

        // Lead statistics
        $totalLeads = Lead::where('hospital_id', $hospitalId)
            ->count();

        $newLeads = Lead::where('hospital_id', $hospitalId)
            ->where('status', 'new')
            ->count();

        $contactedLeads = Lead::where('hospital_id', $hospitalId)
            ->where('status', 'contacted')
            ->count();

        $followUpLeads = Lead::where('hospital_id', $hospitalId)
            ->where('status', 'follow_up')
            ->count();

        $interestedLeads = Lead::where('hospital_id', $hospitalId)
            ->where('status', 'interested')
            ->count();

        $convertedLeads = Lead::where('hospital_id', $hospitalId)
            ->where('status', 'converted')
            ->count();

        $notInterestedLeads = Lead::where('hospital_id', $hospitalId)
            ->where('status', 'not_interested')
            ->count();

        $closedLeads = Lead::where('hospital_id', $hospitalId)
            ->where('status', 'closed')
            ->count();

        // Follow-ups due today or overdue
        $dueFollowUps = LeadFollowUp::where('hospital_id', $hospitalId)
            ->where('follow_up_status', 'scheduled')
            ->whereDate('follow_up_date', '<=', today())
            ->count();

        // Today's follow-ups
        $todayFollowUps = LeadFollowUp::where('hospital_id', $hospitalId)
            ->where('follow_up_status', 'scheduled')
            ->whereDate('follow_up_date', today())
            ->count();

        // Module-wise lead distribution
        $leadModules = LeadModule::where('is_active', 1)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($module) use ($hospitalId) {

                $module->total_leads = Lead::where('hospital_id', $hospitalId)
                    ->where('lead_module_id', $module->id)
                    ->count();

                return $module;
            });

        // Recent leads
        $recentLeads = Lead::with('leadModule')
            ->where('hospital_id', $hospitalId)
            ->latest()
            ->take(10)
            ->get();

        // Upcoming and overdue follow-ups
        $recentFollowUps = LeadFollowUp::with('lead')
            ->where('hospital_id', $hospitalId)
            ->where('follow_up_status', 'scheduled')
            ->orderBy('follow_up_date')
            ->take(10)
            ->get();

        // Monthly lead statistics for current year
        $monthlyLeads = Lead::where('hospital_id', $hospitalId)
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $monthlyLeadChart = collect(range(1, 12))
            ->map(function ($month) use ($monthlyLeads) {
                return (int) ($monthlyLeads[$month] ?? 0);
            })
            ->values();

        $monthlyLeadLabels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        return view('hospital.dashboard', compact(
            'hospital',
            'totalStaff',
            'activeStaff',
            'inactiveStaff',
            'totalLeads',
            'newLeads',
            'contactedLeads',
            'followUpLeads',
            'interestedLeads',
            'convertedLeads',
            'notInterestedLeads',
            'closedLeads',
            'dueFollowUps',
            'todayFollowUps',
            'leadModules',
            'recentLeads',
            'recentFollowUps',
            'monthlyLeadChart',
            'monthlyLeadLabels'
        ));
    }
}
