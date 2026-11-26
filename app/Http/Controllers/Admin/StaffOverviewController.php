<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\LeadModule;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffOverviewController extends Controller
{
    public function index(Request $request)
    {
        // Global staff statistics
        $totalStaff = Staff::count();

        $activeStaff = Staff::where('status', 'active')->count();

        $inactiveStaff = Staff::where('status', 'inactive')->count();

        $suspendedStaff = Staff::where('status', 'suspended')->count();

        // Hospital dropdown
        $hospitals = Hospital::orderBy('hospital_name')->get([
            'id',
            'hospital_name',
        ]);

        // Staff listing
        $query = Staff::query()
            ->leftJoin('hospitals', 'staff.hospital_id', '=', 'hospitals.id')
            ->leftJoin('departments', 'staff.department_id', '=', 'departments.id')
            ->leftJoin('designations', 'staff.designation_id', '=', 'designations.id')
            ->select(
                'staff.*',
                'hospitals.hospital_name',
                'departments.name as department_name',
                'designations.name as designation_name'
            );

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('staff.name', 'like', "%{$search}%")
                    ->orWhere('staff.mobile', 'like', "%{$search}%")
                    ->orWhere('staff.email', 'like', "%{$search}%")
                    ->orWhere('staff.employee_code', 'like', "%{$search}%");
            });
        }

        // Hospital filter
        if ($request->filled('hospital_id')) {
            $query->where('staff.hospital_id', $request->hospital_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('staff.status', $request->status);
        }

        $staffMembers = $query
            ->orderByDesc('staff.created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.staff-overview.index', compact(
            'totalStaff',
            'activeStaff',
            'inactiveStaff',
            'suspendedStaff',
            'hospitals',
            'staffMembers'
        ));
    }
    public function show(Request $request, $id)
    {
        // Get selected lead module
        $module = LeadModule::findOrFail($id);

        // Get hospital IDs assigned to this module
        $hospitalIds = DB::table('hospital_modules')
            ->where('lead_module_id', $module->id)
            ->pluck('hospital_id');

        // Base staff query filtered by selected module's hospitals
        $query = Staff::query()
            ->leftJoin('hospitals', 'staff.hospital_id', '=', 'hospitals.id')
            ->leftJoin('departments', 'staff.department_id', '=', 'departments.id')
            ->leftJoin('designations', 'staff.designation_id', '=', 'designations.id')
            ->whereIn('staff.hospital_id', $hospitalIds)
            ->select(
                'staff.*',
                'hospitals.hospital_name',
                'departments.name as department_name',
                'designations.name as designation_name'
            );

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('staff.name', 'like', "%{$search}%")
                    ->orWhere('staff.mobile', 'like', "%{$search}%")
                    ->orWhere('staff.email', 'like', "%{$search}%")
                    ->orWhere('staff.employee_code', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('staff.status', $request->status);
        }

        // Module-specific statistics
        $totalStaff = Staff::whereIn('hospital_id', $hospitalIds)->count();

        $activeStaff = Staff::whereIn('hospital_id', $hospitalIds)
            ->where('status', 'active')->count();

        $inactiveStaff = Staff::whereIn('hospital_id', $hospitalIds)
            ->where('status', 'inactive')->count();

        $suspendedStaff = Staff::whereIn('hospital_id', $hospitalIds)
            ->where('status', 'suspended')->count();

        // Hospital dropdown: only hospitals assigned to this module
        $hospitals = Hospital::whereIn('id', $hospitalIds)
            ->orderBy('hospital_name')
            ->get(['id', 'hospital_name']);

        // Hospital filter
        if ($request->filled('hospital_id')) {
            $query->where('staff.hospital_id', $request->hospital_id);
        }

        $staffMembers = $query
            ->orderByDesc('staff.created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.staff-overview.index', compact(
            'module',
            'totalStaff',
            'activeStaff',
            'inactiveStaff',
            'suspendedStaff',
            'hospitals',
            'staffMembers'
        ));
    }
}
