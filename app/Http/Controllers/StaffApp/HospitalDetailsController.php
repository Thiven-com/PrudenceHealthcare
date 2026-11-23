<?php

namespace App\Http\Controllers\StaffApp;

use App\Http\Controllers\Controller;
use App\Models\HospitalTieup;
use App\Models\HospitalFacility;
use App\Models\HospitalEmergencyContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;

class HospitalDetailsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $staff = Auth::guard('staff')->user();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Hospital details not found for this staff member.',
                ], 404);
            }

            $hospitalId = $staff->hospital_id;

            // Hospital Tie-ups
            $tieups = HospitalTieup::where('hospital_id', $hospitalId)
                ->where('status', 'active')
                ->latest()
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'organization_name' => $item->organization_name,
                        'tieup_type' => $item->tieup_type,
                        'contact_person' => $item->contact_person,
                        'mobile' => $item->mobile,
                        'email' => $item->email,
                        'address' => $item->address,
                        'description' => $item->description,
                        'image' => $item->image
                            ? Storage::disk('public')->url($item->image)
                            : null,
                        'status' => $item->status,
                    ];
                });

            // Hospital Facilities
            $facilities = HospitalFacility::where('hospital_id', $hospitalId)
                ->where('status', 'active')
                ->latest()
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'facility_name' => $item->facility_name,
                        'facility_category' => $item->facility_category,
                        'description' => $item->description,
                        'is_available' => (bool) $item->is_available,
                        'operating_hours' => $item->operating_hours,
                        'contact_number' => $item->contact_number,
                        'image' => $item->image
                            ? Storage::disk('public')->url($item->image)
                            : null,
                        'status' => $item->status,
                    ];
                });

            // Emergency Contacts
            $emergencyContacts = HospitalEmergencyContact::where(
                'hospital_id',
                $hospitalId
            )
                ->where('status', 'active')
                ->latest()
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'contact_name' => $item->contact_name,
                        'designation' => $item->emergency_type,
                        'mobile' => $item->mobile,
                        'alternate_mobile' => $item->alternate_mobile,
                        'email' => $item->email,
                        'availability' => $item->availability,
                        'description' => $item->description,
                        'status' => $item->status,
                    ];
                });

            return response()->json([
                'success' => 1,
                'message' => 'Hospital details fetched successfully.',
                'data' => [
                    'tieups' => $tieups,
                    'facilities' => $facilities,
                    'emergency_contacts' => $emergencyContacts,
                ],
            ], 200);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => 0,
                'message' => 'Unable to fetch hospital details.',
            ], 500);
        }
    }
}
