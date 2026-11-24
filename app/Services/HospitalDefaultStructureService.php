<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Hospital;
use Illuminate\Support\Str;

class HospitalDefaultStructureService
{
    public function createFor(Hospital $hospital): void
    {
        // Create or retrieve Marketing Department
        $department = Department::where('hospital_id', $hospital->id)
            ->where('name', 'Marketing')
            ->first();

        if (!$department) {
            $department = Department::create([
                'hospital_id' => $hospital->id,
                'name' => 'Marketing',
                'code' => null,
                'description' => 'Marketing Department',
                'is_active' => 1,
            ]);
        }

        $designations = [
            'Trade Marketing',
            'Corporate Marketing',
            'Internal Marketing',
            'Freelancers Marketing',
        ];

        foreach ($designations as $name) {

            $exists = Designation::where('hospital_id', $hospital->id)
                ->where('department_id', $department->id)
                ->where('name', $name)
                ->exists();

            if (!$exists) {
                $slug = $this->generateSlug($name, $hospital->id);

                Designation::create([
                    'hospital_id' => $hospital->id,
                    'department_id' => $department->id,
                    'name' => $name,
                    'slug' => $slug,
                    'code' => null,
                    'description' => null,
                    'is_active' => 1,
                ]);
            }
        }
    }

    private function generateSlug(string $name, int $hospitalId): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $count = 1;

        while (
            Designation::where('hospital_id', $hospitalId)
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
