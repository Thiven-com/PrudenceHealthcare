<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Staff;
use App\Models\StaffDailyReport;

class StaffDailyReportController extends Controller
{
    public function index(Request $request)
    {
        // Logged-in hospital
        $hospital = auth('hospital')->user();

        abort_if(!$hospital, 403, 'Unauthorized access');

        // Only this hospital's reports
        $query = StaffDailyReport::with(['staff'])
            ->withCount('activities')
            ->where('hospital_id', $hospital->id)
            ->latest('report_date');

        // Search staff
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('staff', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        // Staff filter
        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        // Date filter
        if ($request->filled('report_date')) {
            $query->whereDate('report_date', $request->report_date);
        }

        // Report status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Working status filter
        if ($request->filled('working_status')) {
            $query->where('working_status', $request->working_status);
        }

        $reports = $query->paginate(15)->withQueryString();

        // Only staff belonging to this hospital
        $staffList = Staff::where('hospital_id', $hospital->id)
            ->orderBy('name')
            ->get();

        // Hospital-wise statistics
        $totalReports = StaffDailyReport::where(
            'hospital_id',
            $hospital->id
        )->count();

        $submittedReports = StaffDailyReport::where('hospital_id', $hospital->id)
            ->where('status', 'submitted')
            ->count();

        $approvedReports = StaffDailyReport::where('hospital_id', $hospital->id)
            ->where('status', 'approved')
            ->count();

        $draftReports = StaffDailyReport::where('hospital_id', $hospital->id)
            ->where('status', 'draft')
            ->count();

        return view('hospital.staff-daily-reports.index', compact(
            'reports',
            'staffList',
            'totalReports',
            'submittedReports',
            'approvedReports',
            'draftReports'
        ));
    }

    public function show($id)
    {
        $hospital = auth('hospital')->user();

        abort_if(!$hospital, 403, 'Unauthorized access');

        // Prevent another hospital's report from being accessed
        $report = StaffDailyReport::with([
            'staff',
            'activities.staff',
        ])
            ->where('hospital_id', $hospital->id)
            ->findOrFail($id);

        return view('hospital.staff-daily-reports.show', compact('report'));
    }
}
