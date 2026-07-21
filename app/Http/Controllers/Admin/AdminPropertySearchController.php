<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allottee;
use Illuminate\Support\Facades\DB;

class AdminPropertySearchController extends Controller
{
    public function index()
    {
        return view('admin.property_search.index');
    }

    public function search(Request $request)
    {
        $propertyNumber = $request->input('property_number');

        if (!$propertyNumber) {
            return redirect()->back();
        }

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

        // Fetch all allottees for this property, ordered by id DESC so the most recent is first.
        $allottees = Allottee::with($baseRelations)
            ->where('property_number', $propertyNumber)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.property_search.index', [
            'propertyNumber' => $propertyNumber,
            'allottees' => $allottees
        ]);
    }

    public function autocomplete(Request $request)
    {
        $query = $request->input('query');
        
        if (!$query) {
            return response()->json([]);
        }

        // Search property_number and get unique values
        $suggestions = Allottee::where('property_number', 'LIKE', '%' . $query . '%')
            ->select('property_number')
            ->distinct()
            ->limit(10)
            ->pluck('property_number');

        return response()->json($suggestions);
    }
}
