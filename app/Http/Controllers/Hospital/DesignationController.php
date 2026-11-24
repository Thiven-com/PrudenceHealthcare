<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DesignationController extends Controller
{
    private function hospitalId()
    {
        return Auth::guard('hospital')->id();
    }

    public function index()
    {
        $designations = Designation::with('department')
            ->where('hospital_id', $this->hospitalId())
            ->latest()
            ->get();

        return view('hospital.designations.index', compact('designations'));
    }

    public function create()
    {
        $departments = Department::where('hospital_id', $this->hospitalId())
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();

        return view('hospital.designations.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $department = Department::where('hospital_id', $this->hospitalId())
            ->where('is_active', 1)
            ->findOrFail($validated['department_id']);

        Designation::create([
            'hospital_id' => $this->hospitalId(),
            'department_id' => $department->id,
            'name' => $validated['name'],
            'slug' => $this->generateSlug(
                $validated['name'],
                $this->hospitalId()
            ),
            'code' => $validated['code'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);
        return redirect()
            ->route('hospital.designations.index')
            ->with('success', 'Designation created successfully.');
    }

    public function show($id)
    {
        $designation = Designation::with('department')
            ->where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        return view('hospital.designations.show', compact('designation'));
    }

    public function edit($id)
    {
        $designation = Designation::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        $departments = Department::where('hospital_id', $this->hospitalId())
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();

        return view('hospital.designations.edit', compact('designation', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $designation = Designation::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        $validated = $request->validate([
            'department_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $department = Department::where('hospital_id', $this->hospitalId())
            ->where('is_active', 1)
            ->findOrFail($validated['department_id']);

        $designation->update([
            'department_id' => $department->id,
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('hospital.designations.index')
            ->with('success', 'Designation updated successfully.');
    }

    public function destroy($id)
    {
        $designation = Designation::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        $designation->delete();

        return redirect()
            ->route('hospital.designations.index')
            ->with('success', 'Designation deleted successfully.');
    }

    private function generateSlug($name, $hospitalId, $excludeId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (
            Designation::where('hospital_id', $hospitalId)
                ->where('slug', $slug)
                ->when($excludeId, function ($query) use ($excludeId) {
                    $query->where('id', '!=', $excludeId);
                })
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
