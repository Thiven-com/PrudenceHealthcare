<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Lead;
use App\Models\LeadModule;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadReportController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'hospital_id' => 'nullable|integer',
            'department_id' => 'nullable|integer',
            'designation_id' => 'nullable|integer',
            'staff_id' => 'nullable|integer',
            'lead_module_id' => 'nullable|integer',
            'status' => 'nullable|in:new,contacted,interested,follow_up,converted,not_interested,closed',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        // Filter options
        $hospitals = Hospital::orderBy('hospital_name')
            ->get(['id', 'hospital_name']);

        $departments = DB::table('departments')
            ->orderBy('name')
            ->get(['id', 'name']);

        $designations = DB::table('designations')
            ->orderBy('name')
            ->get(['id', 'name']);

        $staffMembers = Staff::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name', 'employee_code']);

        $leadModules = LeadModule::orderBy('name')
            ->get(['id', 'name']);

        // Base query: only leads currently assigned to staff
        $baseQuery = function () {
            return Lead::query()
                ->join('staff', function ($join) {
                    $join->on('leads.assigned_to', '=', 'staff.id')
                        ->where('leads.assigned_to_type', '=', 'staff');
                })
                ->leftJoin('hospitals', 'leads.hospital_id', '=', 'hospitals.id')
                ->leftJoin('departments', 'staff.department_id', '=', 'departments.id')
                ->leftJoin('designations', 'staff.designation_id', '=', 'designations.id');
        };

        // Apply common filters
        $applyFilters = function ($query) use ($request) {

            if ($request->filled('hospital_id')) {
                $query->where('leads.hospital_id', $request->hospital_id);
            }

            if ($request->filled('department_id')) {
                $query->where('staff.department_id', $request->department_id);
            }

            if ($request->filled('designation_id')) {
                $query->where('staff.designation_id', $request->designation_id);
            }

            if ($request->filled('staff_id')) {
                $query->where('staff.id', $request->staff_id);
            }

            if ($request->filled('lead_module_id')) {
                $query->where('leads.lead_module_id', $request->lead_module_id);
            }

            if ($request->filled('status')) {
                $query->where('leads.status', $request->status);
            }

            if ($request->filled('from_date')) {
                $query->whereDate('leads.created_at', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $query->whereDate('leads.created_at', '<=', $request->to_date);
            }

            return $query;
        };

        // Common report totals
        $selectTotals = [
            DB::raw('COUNT(leads.id) as total_leads'),
            DB::raw("SUM(CASE WHEN leads.status = 'new' THEN 1 ELSE 0 END) as new_leads"),
            DB::raw("SUM(CASE WHEN leads.status = 'contacted' THEN 1 ELSE 0 END) as contacted_leads"),
            DB::raw("SUM(CASE WHEN leads.status = 'interested' THEN 1 ELSE 0 END) as interested_leads"),
            DB::raw("SUM(CASE WHEN leads.status = 'follow_up' THEN 1 ELSE 0 END) as follow_up_leads"),
            DB::raw("SUM(CASE WHEN leads.status = 'converted' THEN 1 ELSE 0 END) as converted_leads"),
            DB::raw("SUM(CASE WHEN leads.status = 'not_interested' THEN 1 ELSE 0 END) as not_interested_leads"),
            DB::raw("SUM(CASE WHEN leads.status = 'closed' THEN 1 ELSE 0 END) as closed_leads"),
        ];

        // 1. Staff-wise report
        $staffReport = $applyFilters($baseQuery())
            ->select(array_merge([
                'staff.id as staff_id',
                'staff.name as staff_name',
                'staff.employee_code',
                'hospitals.hospital_name',
                'departments.name as department_name',
                'designations.name as designation_name',
            ], $selectTotals))
            ->groupBy(
                'staff.id',
                'staff.name',
                'staff.employee_code',
                'hospitals.hospital_name',
                'departments.name',
                'designations.name'
            )
            ->orderByDesc('total_leads')
            ->paginate(25, ['*'], 'staff_page');

        // 2. Department-wise report
        $departmentReport = $applyFilters($baseQuery())
            ->select(array_merge([
                'leads.hospital_id',
                'hospitals.hospital_name',
                'staff.department_id',
                'departments.name as department_name',
            ], $selectTotals))
            ->groupBy(
                'leads.hospital_id',
                'hospitals.hospital_name',
                'staff.department_id',
                'departments.name'
            )
            ->orderByDesc('total_leads')
            ->paginate(25, ['*'], 'department_page');

        // 3. Designation-wise report
        $designationReport = $applyFilters($baseQuery())
            ->select(array_merge([
                'leads.hospital_id',
                'hospitals.hospital_name',
                'staff.designation_id',
                'designations.name as designation_name',
            ], $selectTotals))
            ->groupBy(
                'leads.hospital_id',
                'hospitals.hospital_name',
                'staff.designation_id',
                'designations.name'
            )
            ->orderByDesc('total_leads')
            ->paginate(25, ['*'], 'designation_page');

        // 4. Hospital-wise report
        $hospitalReport = $applyFilters($baseQuery())
            ->select(array_merge([
                'leads.hospital_id',
                'hospitals.hospital_name',
            ], $selectTotals))
            ->groupBy(
                'leads.hospital_id',
                'hospitals.hospital_name'
            )
            ->orderByDesc('total_leads')
            ->paginate(25, ['*'], 'hospital_page');

        return view('admin.lead-reports.index', compact(
            'hospitals',
            'departments',
            'designations',
            'staffMembers',
            'leadModules',
            'staffReport',
            'departmentReport',
            'designationReport',
            'hospitalReport'
        ));
    }
}
