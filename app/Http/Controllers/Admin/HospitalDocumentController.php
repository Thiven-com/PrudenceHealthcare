<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Hospital;
use App\Models\HospitalDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HospitalDocumentController extends Controller
{
    public function index(Hospital $hospital)
    {
        $documents = $hospital->documents()
            ->latest()
            ->paginate(10);

        return view('admin.hospitals.documents.index', compact(
            'hospital',
            'documents'
        ));
    }

    public function store(Request $request, Hospital $hospital)
    {
        $validated = $request->validate([
            'document_name' => 'required|string|max:255',
            'document_type' => 'nullable|string|max:100',
            'document_number' => 'nullable|string|max:100',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'issued_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:issued_date',
        ]);

        $file = $request->file('document');

        $path = $file->store(
            'hospitals/' . $hospital->id . '/documents',
            'public'
        );

        $hospital->documents()->create([
            'document_name' => $validated['document_name'],
            'document_type' => $validated['document_type'] ?? null,
            'document_number' => $validated['document_number'] ?? null,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_extension' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'verification_status' => 'pending',
            'issued_date' => $validated['issued_date'] ?? null,
            'expiry_date' => $validated['expiry_date'] ?? null,
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    public function verify(Hospital $hospital, HospitalDocument $document)
    {
        $this->validateDocumentHospital($hospital, $document);

        $document->update([
            'verification_status' => 'approved',
            'verified_by' => auth('admin')->id(),
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Document approved successfully.');
    }

    public function reject(Request $request, Hospital $hospital, HospitalDocument $document)
    {
        $this->validateDocumentHospital($hospital, $document);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $document->update([
            'verification_status' => 'rejected',
            'verified_by' => auth('admin')->id(),
            'verified_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('success', 'Document rejected successfully.');
    }

    public function destroy(Hospital $hospital, HospitalDocument $document)
    {
        $this->validateDocumentHospital($hospital, $document);

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }

    private function validateDocumentHospital(
        Hospital $hospital,
        HospitalDocument $document
    ): void {
        abort_unless(
            (int) $document->hospital_id === (int) $hospital->id,
            404
        );
    }
}