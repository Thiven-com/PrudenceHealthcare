<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
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
}
