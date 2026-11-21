<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Staff;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hospital statistics
        $totalHospitals = Hospital::count();

        $approvedHospitals = Hospital::where('approval_status', 'approved')->count();

        $pendingHospitals = Hospital::where('approval_status', 'pending')->count();

        $rejectedHospitals = Hospital::where('approval_status', 'rejected')->count();


        $todayHospitals = Hospital::whereDate('created_at', today())->count();

        $monthlyHospitalCount = Hospital::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Staff statistics
        $totalStaff = Staff::count();

        $activeStaff = Staff::where('status', 'active')->count();

        // Lead statistics
        $totalLeads = Lead::count();

        $todayLeads = Lead::whereDate('created_at', today())->count();

        // Recent hospitals
        $recentHospitals = Hospital::latest()
            ->take(5)
            ->get();

        // Pending hospitals
        $pendingHospitalList = Hospital::where('approval_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Monthly hospital registrations
        $monthlyHospitals = Hospital::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

        $hospitalChart = [];

        for ($month = 1; $month <= 12; $month++) {
            $hospitalChart[] = $monthlyHospitals[$month] ?? 0;
        }

        // Lead module distribution
        $leadModuleDistribution = Lead::query()
            ->join('lead_modules', 'leads.lead_module_id', '=', 'lead_modules.id')
            ->select(
                'lead_modules.id',
                'lead_modules.name',
                DB::raw('COUNT(leads.id) as leads_count')
            )
            ->groupBy('lead_modules.id', 'lead_modules.name')
            ->get();

        // Recent leads
        $recentLeads = Lead::with('leadModule')
            ->latest()
            ->take(5)
            ->get();

        // Hospital-wise lead count
        $hospitalLeadDistribution = Lead::select(
            'hospital_id',
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('hospital_id')
            ->with('hospital')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalHospitals',
            'approvedHospitals',
            'pendingHospitals',
            'rejectedHospitals',
            'todayHospitals',
            'monthlyHospitalCount',
            'totalStaff',
            'activeStaff',
            'totalLeads',
            'todayLeads',
            'recentHospitals',
            'pendingHospitalList',
            'hospitalChart',
            'leadModuleDistribution',
            'recentLeads',
            'hospitalLeadDistribution'
        ));
    }
}
