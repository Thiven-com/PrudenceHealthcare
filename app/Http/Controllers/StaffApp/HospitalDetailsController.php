<?php

namespace App\Http\Controllers\StaffApp;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
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

            // Hospital Profile
            $hospital = Hospital::where('id', $hospitalId)
                ->first();

            if (!$hospital) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Hospital not found.',
                ], 404);
            }

            $hospitalDetails = [
                'id' => $hospital->id,
                'hospital_name' => $hospital->hospital_name,
                'registration_number' => $hospital->registration_number,
                'contact_person' => $hospital->contact_person,
                'mobile' => $hospital->mobile,
                'email' => $hospital->email,
                'logo' => $hospital->logo
                    ? Storage::disk('public')->url($hospital->logo)
                    : null,
                'address' => $hospital->address,
                'city' => $hospital->city,
                'state' => $hospital->state,
                'pincode' => $hospital->pincode,
                'approval_status' => $hospital->approval_status,
            ];

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
                            ? asset($item->image)
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
                            ? asset($item->image)
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
                    'hospital' => $hospitalDetails,
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
