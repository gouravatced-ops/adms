<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allottee;

class ScannerPropertySearchController extends Controller
{
    public function index()
    {
        return view('applicant.scanner.property_search');
    }

    public function search(Request $request)
    {
        $request->validate([
            'property_number' => 'required|string|max:255',
        ]);

        $propertyNumber = $request->input('property_number');

        $baseRelations = [
            'division',
            'subDivision',
            'propertyCategory',
            'propertyType',
            'quarterType',
            'masterDocuments',
            'documentData.document',
            'registration',
            'accountLedger'
        ];

        // Fetch all allottees for this property, ordered by id DESC so the most recent (Current Allottee) is first.
        $allottees = Allottee::with($baseRelations)
            ->where('property_number', $propertyNumber)
            ->orderBy('id', 'desc')
            ->get();

        return view('applicant.scanner.property_search', [
            'allottees' => $allottees,
            'propertyNumber' => $propertyNumber,
        ]);
    }
}
