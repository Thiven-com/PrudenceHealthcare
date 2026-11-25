<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\PerformanceTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PerformanceTargetController extends Controller
{
    private function hospitalId()
    {
        return Auth::guard('hospital')->id();
    }

    public function index(Request $request)
    {
        $hospitalId = $this->hospitalId();

        $query = PerformanceTarget::with('designation')
            ->where('hospital_id', $hospitalId);

        if ($request->filled('designation_id')) {
            $query->where('designation_id', $request->designation_id);
        }

        if ($request->filled('target_type')) {
            $query->where('target_type', $request->target_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $targets = $query->latest()->paginate(20)->withQueryString();

        $designations = Designation::where('hospital_id', $hospitalId)
            ->orderBy('name')
            ->get();
        $targetTypes = [
            'lead_generation',
            'customer_calls',
            'follow_ups',
            'hospital_visits',
            'meetings',
            'conversions',
        ];

        $periods = ['daily', 'weekly', 'monthly'];
        return view('hospital.performance-targets.index', compact(
            'targets',
            'designations',
            'targetTypes',
            'periods'
        ));
    }

    public function store(Request $request)
    {
        $hospitalId = $this->hospitalId();

        $validator = Validator::make($request->all(), [
            'designation_id' => ['required', 'integer'],
            'target_name' => ['required', 'string', 'max:150'],
            'target_type' => [
                'required',
                'in:lead_generation,customer_calls,follow_ups,hospital_visits,meetings,conversions',
            ],
            'target_quantity' => ['required', 'integer', 'min:1'],
            'target_period' => ['required', 'in:daily,weekly,monthly'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'in:active,inactive'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $designation = Designation::where('id', $data['designation_id'])
            ->where('hospital_id', $hospitalId)
            ->first();

        if (!$designation) {
            return back()->withErrors([
                'designation_id' => 'Select a designation belonging to your hospital.',
            ])->withInput();
        }

        PerformanceTarget::create([
            'hospital_id' => $hospitalId,
            'designation_id' => $designation->id,
            'target_name' => $data['target_name'],
            'target_type' => $data['target_type'],
            'target_quantity' => $data['target_quantity'],
            'target_period' => $data['target_period'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'created_by' => $hospitalId,
            'created_by_type' => 'hospital',
            'status' => $data['status'] ?? 'active',
        ]);

        return redirect()
            ->route('hospital.performance-targets.index')
            ->with('success', 'Performance target created successfully.');
    }

    public function update(Request $request, $id)
    {
        $target = PerformanceTarget::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'designation_id' => ['required', 'integer'],
            'target_name' => ['required', 'string', 'max:150'],
            'target_type' => [
                'required',
                'in:lead_generation,customer_calls,follow_ups,hospital_visits,meetings,conversions',
            ],
            'target_quantity' => ['required', 'integer', 'min:1'],
            'target_period' => ['required', 'in:daily,weekly,monthly'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $designation = Designation::where('id', $data['designation_id'])
            ->where('hospital_id', $this->hospitalId())
            ->first();

        if (!$designation) {
            return back()->withErrors([
                'designation_id' => 'Select a designation belonging to your hospital.',
            ])->withInput();
        }

        $target->update([
            'designation_id' => $designation->id,
            'target_name' => $data['target_name'],
            'target_type' => $data['target_type'],
            'target_quantity' => $data['target_quantity'],
            'target_period' => $data['target_period'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'status' => $data['status'],
        ]);

        return redirect()
            ->route('hospital.performance-targets.index')
            ->with('success', 'Performance target updated successfully.');
    }

    public function destroy($id)
    {
        $target = PerformanceTarget::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        $target->update([
            'status' => 'inactive',
        ]);

        return redirect()
            ->route('hospital.performance-targets.index')
            ->with('success', 'Performance target deactivated successfully.');
    }
}