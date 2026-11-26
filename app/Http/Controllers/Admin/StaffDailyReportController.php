<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\StaffDailyReport;

class StaffDailyReportController extends Controller
{

    public function index(Request $request)
    {
        $query = StaffDailyReport::with(['staff', 'activities'])
            ->withCount('activities')
            ->orderBy('report_date', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('staff', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('report_date')) {
            $query->whereDate('report_date', $request->report_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('working_status')) {
            $query->where('working_status', $request->working_status);
        }

        $reports = $query->paginate(15)->withQueryString();

        $staffList = Staff::orderBy('name')->get();

        $totalReports = StaffDailyReport::count();
        $submittedReports = StaffDailyReport::where('status', 'submitted')->count();
        $approvedReports = StaffDailyReport::where('status', 'approved')->count();
        $draftReports = StaffDailyReport::where('status', 'draft')->count();

        return view('admin.staff-daily-reports.index', compact(
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
        $report = StaffDailyReport::with([
            'staff',
            'activities.staff',
        ])->findOrFail($id);

        return view('admin.staff-daily-reports.show', compact('report'));
    }
}
