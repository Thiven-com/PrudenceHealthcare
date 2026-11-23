<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\HospitalTieup;
use App\Models\HospitalFacility;
use App\Models\HospitalEmergencyContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;

class HospitalAdditionalDetailsController extends Controller
{
    /**
     * Get authenticated hospital ID.
     */
    private function hospitalId()
    {
        return Auth::guard('hospital')->id();
    }

    /**
     * Get configuration based on record type.
     */
    private function getConfig($type)
    {
        $configs = [
            'tieup' => [
                'model' => HospitalTieup::class,
                'title' => 'Hospital Tie-up',
                'folder' => 'hospital/tieups',
                'has_image' => true,
            ],

            'facility' => [
                'model' => HospitalFacility::class,
                'title' => 'Hospital Facility',
                'folder' => 'hospital/facilities',
                'has_image' => true,
            ],

            'emergency' => [
                'model' => HospitalEmergencyContact::class,
                'title' => 'Emergency Contact',
                'folder' => null,
                'has_image' => false,
            ],
        ];

        abort_unless(isset($configs[$type]), 404);

        return $configs[$type];
    }

    /**
     * Display all additional hospital details.
     */
    public function index()
    {
        $hospitalId = $this->hospitalId();

        abort_unless($hospitalId, 401);

        $tieups = HospitalTieup::where('hospital_id', $hospitalId)
            ->latest()
            ->get();

        $facilities = HospitalFacility::where('hospital_id', $hospitalId)
            ->latest()
            ->get();

        $emergencyContacts = HospitalEmergencyContact::where(
            'hospital_id',
            $hospitalId
        )->latest()->get();

        return view('hospital.additional-details.index', compact(
            'tieups',
            'facilities',
            'emergencyContacts'
        ));
    }

    /**
     * Validation rules.
     */
    private function validationRules($type)
    {
        $rules = [
            'tieup' => [
                'organization_name' => ['required', 'string', 'max:255'],
                'tieup_type' => ['nullable', 'string', 'max:100'],
                'contact_person' => ['nullable', 'string', 'max:255'],
                'mobile' => ['nullable', 'string', 'max:20'],
                'email' => ['nullable', 'email', 'max:255'],
                'address' => ['nullable', 'string'],
                'description' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'status' => ['required', 'in:active,inactive'],
            ],

            'facility' => [
                'facility_name' => ['required', 'string', 'max:255'],
                'facility_category' => ['nullable', 'string', 'max:100'],
                'description' => ['nullable', 'string'],
                'is_available' => ['nullable', 'boolean'],
                'operating_hours' => ['nullable', 'string', 'max:100'],
                'contact_number' => ['nullable', 'string', 'max:20'],
                'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'status' => ['required', 'in:active,inactive'],
            ],

            'emergency' => [
                'contact_name' => ['required', 'string', 'max:255'],
                'emergency_type' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:20'],
                'alternate_mobile' => ['nullable', 'string', 'max:20'],
                'email' => ['nullable', 'email', 'max:255'],
                'availability' => ['nullable', 'string', 'max:100'],
                'description' => ['nullable', 'string'],
                'status' => ['required', 'in:active,inactive'],
            ],
        ];

        abort_unless(isset($rules[$type]), 404);

        return $rules[$type];
    }

    /**
     * Store a new record.
     */
    public function store(Request $request, $type)
    {
        $hospitalId = $this->hospitalId();

        abort_unless($hospitalId, 401);

        $config = $this->getConfig($type);

        $validated = $request->validate(
            $this->validationRules($type)
        );

        $imagePath = null;

        try {
            if ($config['has_image'] && $request->hasFile('image')) {
                $imagePath = $this->uploadImage(
                    $request->file('image'),
                    $config['folder']
                );

                $validated['image'] = $imagePath;
            }

            $validated['hospital_id'] = $hospitalId;

            if ($type === 'facility') {
                $validated['is_available'] = $request->boolean('is_available');
            }

            $config['model']::create($validated);

            return redirect()
                ->route('hospital.additional-details.index')
                ->with('success', $config['title'] . ' added successfully.');

        } catch (Throwable $e) {
            if ($imagePath) {
                Storage::disk('s3')->delete($imagePath);
            }

            report($e);

            return back()
                ->withInput()
                ->with('error', 'Unable to add ' . strtolower($config['title']) . '.');
        }
    }

    /**
     * Show edit form.
     */
    public function edit($type, $id)
    {
        $hospitalId = $this->hospitalId();

        abort_unless($hospitalId, 401);

        $config = $this->getConfig($type);

        $record = $config['model']::where('hospital_id', $hospitalId)
            ->where('id', $id)
            ->firstOrFail();

        return view('hospital.additional-details.form', compact(
            'record',
            'type',
            'config'
        ));
    }

    /**
     * Update an existing record.
     */
    public function update(Request $request, $type, $id)
    {
        $hospitalId = $this->hospitalId();

        abort_unless($hospitalId, 401);

        $config = $this->getConfig($type);

        $record = $config['model']::where('hospital_id', $hospitalId)
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate(
            $this->validationRules($type)
        );

        $newImage = null;
        $oldImage = $record->image ?? null;

        try {
            if ($config['has_image'] && $request->hasFile('image')) {
                $newImage = $this->uploadImage(
                    $request->file('image'),
                    $config['folder']
                );

                $validated['image'] = $newImage;
            }

            if ($type === 'facility') {
                $validated['is_available'] = $request->boolean('is_available');
            }

            $record->update($validated);

            if ($newImage && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            return redirect()
                ->route('hospital.additional-details.index')
                ->with('success', $config['title'] . ' updated successfully.');

        } catch (Throwable $e) {
            if ($newImage) {
                Storage::disk('s3')->delete($newImage);
            }

            report($e);

            return back()
                ->withInput()
                ->with('error', 'Unable to update ' . strtolower($config['title']) . '.');
        }
    }

    /**
     * Delete a record.
     */
    public function destroy($type, $id)
    {
        $hospitalId = $this->hospitalId();

        abort_unless($hospitalId, 401);

        $config = $this->getConfig($type);

        $record = $config['model']::where('hospital_id', $hospitalId)
            ->where('id', $id)
            ->firstOrFail();

        try {
            $oldImage = $record->image ?? null;

            $record->delete();

            if ($oldImage) {
                Storage::disk('s3')->delete($oldImage);
            }

            return redirect()
                ->route('hospital.additional-details.index')
                ->with('success', $config['title'] . ' deleted successfully.');

        } catch (Throwable $e) {
            report($e);

            return back()
                ->with('error', 'Unable to delete ' . strtolower($config['title']) . '.');
        }
    }

    private function uploadImage($file, $folder)
    {
        if (!$file || !$file->isValid()) {
            throw new \RuntimeException('Invalid image file.');
        }

        return $file->store($folder, 'public');
    }
}
