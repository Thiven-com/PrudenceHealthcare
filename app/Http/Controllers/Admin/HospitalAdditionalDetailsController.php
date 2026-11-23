<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\HospitalFacility;
use App\Models\HospitalTieup;
use App\Models\HospitalEmergencyContact;
use Illuminate\Http\Request;

class HospitalAdditionalDetailsController extends Controller
{
    public function facilities(Request $request, Hospital $hospital)
    {
        $query = HospitalFacility::where('hospital_id', $hospital->id);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('facility_name', 'like', "%{$search}%")
                    ->orWhere('facility_category', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $records = $query->latest()->paginate(10)->withQueryString();

        return view('admin.hospitals.additional-details.index', [
            'hospital' => $hospital,
            'records' => $records,
            'type' => 'facilities',
            'title' => 'Hospital Facilities',
        ]);
    }

    public function tieups(Request $request, Hospital $hospital)
    {
        $query = HospitalTieup::where('hospital_id', $hospital->id);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('organization_name', 'like', "%{$search}%")
                    ->orWhere('tieup_type', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $records = $query->latest()->paginate(10)->withQueryString();

        return view('admin.hospitals.additional-details.index', [
            'hospital' => $hospital,
            'records' => $records,
            'type' => 'tieups',
            'title' => 'Hospital Tie-ups',
        ]);
    }

    public function emergency(Request $request, Hospital $hospital)
    {
        $query = HospitalEmergencyContact::where(
            'hospital_id',
            $hospital->id
        );

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('contact_name', 'like', "%{$search}%")
                    ->orWhere('emergency_type', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $records = $query->latest()->paginate(10)->withQueryString();

        return view('admin.hospitals.additional-details.index', [
            'hospital' => $hospital,
            'records' => $records,
            'type' => 'emergency',
            'title' => 'Emergency Connect',
        ]);
    }
}
