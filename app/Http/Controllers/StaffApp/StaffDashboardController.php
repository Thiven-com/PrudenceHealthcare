<?php

namespace App\Http\Controllers\StaffApp;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Lead;
use App\Models\LeadFollowUp;
use App\Models\LeadTask;
use App\Models\StaffPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffDashboardController extends Controller
{
    /**
     * Staff Dashboard
     */
    public function index(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff || $staff->status !== 'active') {
            return response()->json([
                'success' => 0,
                'message' => 'Staff account is unavailable.',
            ], 403);
        }

        $hospital = $staff->hospital;

        if (
            !$hospital ||
            !$hospital->is_active ||
            $hospital->approval_status !== 'approved'
        ) {
            return response()->json([
                'success' => 0,
                'message' => 'Hospital account is not active.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Assigned Leads
        |--------------------------------------------------------------------------
        */

        $leadQuery = Lead::where('hospital_id', $staff->hospital_id)
            ->where('assigned_to', $staff->id)
            ->where('assigned_to_type', 'staff');

        $totalLeads = (clone $leadQuery)->count();

        $newLeads = (clone $leadQuery)
            ->where('status', 'new')
            ->count();

        $contactedLeads = (clone $leadQuery)
            ->where('status', 'contacted')
            ->count();

        $followUpLeads = (clone $leadQuery)
            ->where('status', 'follow_up')
            ->count();

        $interestedLeads = (clone $leadQuery)
            ->where('status', 'interested')
            ->count();

        $convertedLeads = (clone $leadQuery)
            ->where('status', 'converted')
            ->count();

        $notInterestedLeads = (clone $leadQuery)
            ->where('status', 'not_interested')
            ->count();

        $closedLeads = (clone $leadQuery)
            ->where('status', 'closed')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Today's Follow-ups
        |--------------------------------------------------------------------------
        */

        $todayFollowupsQuery = LeadFollowUp::where(
            'hospital_id',
            $staff->hospital_id
        )
            ->whereDate('follow_up_date', today())
            ->whereHas('lead', function ($query) use ($staff) {
                $query->where('assigned_to', $staff->id)
                    ->where('assigned_to_type', 'staff')
                    ->where('hospital_id', $staff->hospital_id);
            });

        $todayFollowups = (clone $todayFollowupsQuery)
            ->with('lead')
            ->latest('follow_up_date')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Pending Tasks
        |--------------------------------------------------------------------------
        */

        $pendingTasks = LeadTask::where('hospital_id', $staff->hospital_id)
            ->where('assigned_to', $staff->id)
            ->where('assigned_to_type', 'staff')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with('lead')
            ->orderBy('due_at')
            ->limit(10)
            ->get();

        $pendingTasksCount = LeadTask::where('hospital_id', $staff->hospital_id)
            ->where('assigned_to', $staff->id)
            ->where('assigned_to_type', 'staff')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Recent Leads
        |--------------------------------------------------------------------------
        */

        $recentLeads = (clone $leadQuery)
            ->with('leadModule')
            ->latest()
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Staff Module Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = StaffPermission::where(
            'hospital_id',
            $staff->hospital_id
        )
            ->where('staff_id', $staff->id)
            ->join(
                'lead_modules',
                'staff_permissions.lead_module_id',
                '=',
                'lead_modules.id'
            )
            ->select(
                'staff_permissions.id',
                'staff_permissions.lead_module_id',
                'staff_permissions.can_view',
                'staff_permissions.can_create',
                'staff_permissions.can_edit',
                'staff_permissions.can_delete',
                'staff_permissions.can_assign',
                'staff_permissions.can_export',
                'lead_modules.name as module_name',
                'lead_modules.slug as module_slug'
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Hospital Enabled Modules
        |--------------------------------------------------------------------------
        */

        $enabledModules = DB::table('hospital_modules')
            ->join(
                'lead_modules',
                'hospital_modules.lead_module_id',
                '=',
                'lead_modules.id'
            )
            ->where('hospital_modules.hospital_id', $staff->hospital_id)
            ->where('hospital_modules.is_enabled', 1)
            ->where('lead_modules.is_active', 1)
            ->select(
                'lead_modules.id',
                'lead_modules.name',
                'lead_modules.slug',
                'lead_modules.description'
            )
            ->orderBy('lead_modules.sort_order')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => 1,
            'message' => 'Dashboard fetched successfully.',
            'data' => [

                'staff' => [
                    'id' => $staff->id,
                    'employee_code' => $staff->employee_code,
                    'name' => $staff->name,
                    'mobile' => $staff->mobile,
                    'email' => $staff->email,
                    'profile_image' => $staff->profile_image,
                    'department' => $staff->department?->name,
                    'designation' => $staff->designation?->name,
                ],

                'hospital' => [
                    'id' => $hospital->id,
                    'name' => $hospital->hospital_name,
                    'mobile' => $hospital->mobile,
                    'email' => $hospital->email,
                    'logo' => $hospital->logo,
                ],

                'statistics' => [
                    'total_leads' => $totalLeads,
                    'new_leads' => $newLeads,
                    'contacted_leads' => $contactedLeads,
                    'follow_up_leads' => $followUpLeads,
                    'interested_leads' => $interestedLeads,
                    'converted_leads' => $convertedLeads,
                    'not_interested_leads' => $notInterestedLeads,
                    'closed_leads' => $closedLeads,
                    'today_followups' => $todayFollowups->count(),
                    'pending_tasks' => $pendingTasksCount,
                ],

                'enabled_modules' => $enabledModules,

                'permissions' => $permissions,

                'recent_leads' => $recentLeads,

                'today_followups' => $todayFollowups,

                'pending_tasks' => $pendingTasks,

            ],
        ], 200);
    }
}
