<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LeadModuleController extends Controller
{
    public function index()
    {
        $leadModules = LeadModule::withCount('leads')
            ->latest()
            ->paginate(10);

        return view('admin.lead-modules.index', compact('leadModules'));
    }

    public function create()
    {
        return view('admin.lead-modules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['slug'] ?: $validated['name']);

        $request->validate([
            'slug' => [
                'nullable',
                Rule::unique('lead_modules', 'slug'),
            ],
        ]);

        if (LeadModule::where('slug', $slug)->exists()) {
            return back()
                ->withInput()
                ->withErrors(['slug' => 'This module slug already exists.']);
        }

        LeadModule::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.lead-modules.index')
            ->with('success', 'Lead module created successfully.');
    }

    public function show(LeadModule $leadModule)
    {
        return redirect()->route('admin.lead-modules.edit', $leadModule->id);
    }

    public function edit(LeadModule $leadModule)
    {
        return view('admin.lead-modules.edit', compact('leadModule'));
    }

    public function update(Request $request, LeadModule $leadModule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => [
                'nullable',
                'string',
                'max:150',
                Rule::unique('lead_modules', 'slug')->ignore($leadModule->id),
            ],
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['slug'] ?: $validated['name']);

        if (
            LeadModule::where('slug', $slug)
                ->where('id', '!=', $leadModule->id)
                ->exists()
        ) {
            return back()
                ->withInput()
                ->withErrors(['slug' => 'This module slug already exists.']);
        }

        $leadModule->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.lead-modules.index')
            ->with('success', 'Lead module updated successfully.');
    }

    public function destroy(LeadModule $leadModule)
    {
        $hasHospitals = DB::table('hospital_modules')
            ->where('lead_module_id', $leadModule->id)
            ->exists();

        $hasLeads = DB::table('leads')
            ->where('lead_module_id', $leadModule->id)
            ->exists();

        if ($hasHospitals || $hasLeads) {
            return back()->with(
                'error',
                'This module is already assigned to hospitals or used by leads. Deactivate it instead.'
            );
        }

        $leadModule->delete();

        return redirect()
            ->route('admin.lead-modules.index')
            ->with('success', 'Lead module deleted successfully.');
    }

    public function viewLeads($id)
    {
        $module = LeadModule::findOrFail($id);

        $leads = \App\Models\Lead::with([
            'hospital',
            'leadModule',
            'assignedStaff',
        ])
            ->where('lead_module_id', $module->id)
            ->latest()
            ->paginate(15);

        return view('admin.lead-modules.view', compact(
            'module',
            'leads'
        ));
    }
}
