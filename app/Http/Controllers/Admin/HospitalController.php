<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\LeadModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HospitalController extends Controller
{
    public function index(Request $request)
    {
        $totalHospitals = Hospital::count();
        $approvedCount = Hospital::where('approval_status', 'approved')->count();
        $pendingCount = Hospital::where('approval_status', 'pending')->count();
        $rejectedCount = Hospital::where('approval_status', 'rejected')->count();

        $query = Hospital::query();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('hospital_name', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $hospitals = $query->latest()->paginate(10)->withQueryString();

        $newJoiners = Hospital::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.hospitals.index', compact(
            'hospitals',
            'totalHospitals',
            'approvedCount',
            'pendingCount',
            'rejectedCount',
            'newJoiners'
        ));
    }

    public function create()
    {
        $leadModules = LeadModule::where('is_active', 1)
            ->orderBy('name')
            ->get();

        $selectedModules = [];

        return view('admin.hospitals.create', compact(
            'leadModules',
            'selectedModules'
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validateHospital($request);

        $moduleIds = $this->validateHospitalModules(
            $validated['lead_module_ids'] ?? []
        );

        unset($validated['lead_module_ids']);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('hospitals', 'public');
        }

        $validated['mobile_verified_at'] =
            $validated['is_mobile_verified'] ? now() : null;

        $this->setApprovalFields($validated);

        DB::transaction(function () use ($validated, $moduleIds) {

            $hospital = Hospital::create($validated);

            $this->syncHospitalModules($hospital->id, $moduleIds);
        });

        return redirect()
            ->route('admin.hospitals.index')
            ->with('success', 'Hospital added successfully.');
    }

    public function show(Hospital $hospital)
    {
        return view('admin.hospitals.show', compact('hospital'));
    }

    public function edit(Hospital $hospital)
    {
        $leadModules = LeadModule::where('is_active', 1)
            ->orderBy('name')
            ->get();

        $selectedModules = DB::table('hospital_modules')
            ->where('hospital_id', $hospital->id)
            ->where('is_enabled', 1)
            ->pluck('lead_module_id')
            ->toArray();

        return view('admin.hospitals.edit', compact(
            'hospital',
            'leadModules',
            'selectedModules'
        ));
    }

    public function update(Request $request, Hospital $hospital)
    {
        $validated = $this->validateHospital($request);

        $moduleIds = $this->validateHospitalModules(
            $validated['lead_module_ids'] ?? []
        );

        unset($validated['lead_module_ids']);

        if ($request->hasFile('logo')) {
            if ($hospital->logo) {
                Storage::disk('public')->delete($hospital->logo);
            }

            $validated['logo'] = $request->file('logo')
                ->store('hospitals', 'public');
        }

        $validated['mobile_verified_at'] =
            $validated['is_mobile_verified']
            ? ($hospital->mobile_verified_at ?? now())
            : null;

        $this->setApprovalFields($validated, $hospital);

        DB::transaction(function () use ($hospital, $validated, $moduleIds) {

            $hospital->update($validated);

            $this->syncHospitalModules($hospital->id, $moduleIds);
        });

        return redirect()
            ->route('admin.hospitals.show', $hospital->id)
            ->with('success', 'Hospital updated successfully.');
    }
    public function destroy(Hospital $hospital)
    {
        $hospital->delete();

        return redirect()
            ->route('admin.hospitals.index')
            ->with('success', 'Hospital deleted successfully.');
    }

    private function validateHospital(Request $request): array
    {
        return $request->validate([
            'hospital_name' => ['required', 'string', 'max:255'],
            'registration_number' => ['nullable', 'string', 'max:100'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_mobile_verified' => ['required', 'boolean'],
            'approval_status' => [
                'required',
                Rule::in(['pending', 'approved', 'rejected', 'suspended']),
            ],
            'rejection_reason' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
            'lead_module_ids' => ['nullable', 'array'],
            'lead_module_ids.*' => ['required', 'integer'],
        ]);
    }

    private function setApprovalFields(array &$validated, ?Hospital $hospital = null): void
    {
        if ($validated['approval_status'] === 'approved') {
            $validated['approved_by'] = Auth::guard('admin')->id();
            $validated['approved_at'] = $hospital?->approved_at ?? now();
        } else {
            $validated['approved_by'] = null;
            $validated['approved_at'] = null;
        }

        if ($validated['approval_status'] !== 'rejected') {
            $validated['rejection_reason'] = null;
        }
    }


    public function approve(Hospital $hospital)
    {
        if ($hospital->approval_status === 'approved') {
            return back()->with('success', 'Hospital is already approved.');
        }

        $hospital->update([
            'approval_status' => 'approved',
            'approved_by' => Auth::guard('admin')->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
            'is_active' => 1,
        ]);

        return back()->with('success', 'Hospital approved successfully.');
    }

    public function reject(Request $request, Hospital $hospital)
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:2000'],
        ]);

        $hospital->update([
            'approval_status' => 'rejected',
            'approved_by' => null,
            'approved_at' => null,
            'rejection_reason' => $validated['rejection_reason'],
            'is_active' => 0,
        ]);

        return back()->with('success', 'Hospital rejected successfully.');
    }

    public function suspend(Hospital $hospital)
    {
        if ($hospital->approval_status !== 'approved') {
            return back()->with('error', 'Only approved hospitals can be suspended.');
        }

        $hospital->update([
            'approval_status' => 'suspended',
            'is_active' => 0,
        ]);

        return back()->with('success', 'Hospital suspended successfully.');
    }

    public function reactivate(Hospital $hospital)
    {
        if ($hospital->approval_status !== 'suspended') {
            return back()->with('error', 'Only suspended hospitals can be reactivated.');
        }

        $hospital->update([
            'approval_status' => 'approved',
            'is_active' => 1,
            'approved_by' => Auth::guard('admin')->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Hospital reactivated successfully.');
    }

    /**
     * Validate selected lead modules.
     */
    private function validateHospitalModules(array $moduleIds): array
    {
        $moduleIds = array_values(
            array_unique(array_map('intval', $moduleIds))
        );

        if (empty($moduleIds)) {
            return [];
        }

        $validIds = LeadModule::where('is_active', 1)
            ->whereIn('id', $moduleIds)
            ->pluck('id')
            ->map(fn($id) => (int) $id)
            ->toArray();

        if (count($validIds) !== count($moduleIds)) {
            abort(422, 'One or more selected lead modules are invalid.');
        }

        return $validIds;
    }

    /**
     * Synchronize hospital lead modules.
     */
    private function syncHospitalModules(int $hospitalId, array $moduleIds): void
    {
        DB::table('hospital_modules')
            ->where('hospital_id', $hospitalId)
            ->delete();

        foreach ($moduleIds as $moduleId) {
            DB::table('hospital_modules')->insert([
                'hospital_id' => $hospitalId,
                'lead_module_id' => $moduleId,
                'is_enabled' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
