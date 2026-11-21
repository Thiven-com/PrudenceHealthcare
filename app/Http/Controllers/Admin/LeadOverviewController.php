<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Hospital;
use App\Models\LeadModule;
use Illuminate\Http\Request;

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
            'leads'
        ));
    }

    public function show($id)
    {
        $lead = Lead::with([
            'hospital',
            'leadModule',
            'followUps',
            'activities',
        ])->findOrFail($id);

        return view('admin.lead-overview.show', compact('lead'));
    }
}
