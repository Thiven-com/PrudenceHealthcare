<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    private function hospitalId()
    {
        return Auth::guard('hospital')->id();
    }

    public function index()
    {
        $departments = Department::where('hospital_id', $this->hospitalId())
            ->latest()
            ->get();

        return view('hospital.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('hospital.departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'code' => [
                'nullable',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        Department::create([
            'hospital_id' => $this->hospitalId(),
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('hospital.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show($id)
    {
        $department = Department::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        return view('hospital.departments.show', compact('department'));
    }

    public function edit($id)
    {
        $department = Department::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        return view('hospital.departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'code' => [
                'nullable',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $department->update([
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('hospital.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy($id)
    {
        $department = Department::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        $department->delete();

        return redirect()
            ->route('hospital.departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}
