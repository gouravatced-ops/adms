<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allottee;
use App\Models\RegisterAllottee;

class AdminPropertySearchController extends Controller
{
    public function index()
    {
        return view('admin.property_search.index');
    }

    public function search(Request $request)
    {
        $propertyNumber = trim($request->input('property_number', ''));
        $divisionId = $request->input('division_id');
        $subDivisionId = $request->input('sub_division_id');

        if ($propertyNumber === '') {
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

        $allotteesQuery = Allottee::with($baseRelations)
            ->where('property_number', $propertyNumber);

        if (!empty($divisionId)) {
            $allotteesQuery->where('division_id', $divisionId);
        }
        if (!empty($subDivisionId)) {
            $allotteesQuery->where('subdivision_id', $subDivisionId);
        }

        $allottees = $allotteesQuery->orderBy('id', 'desc')->get();

        $registerRelations = [
            'division',
            'subDivision',
            'propertyCategory',
            'propertyType',
            'quarterType',
            'masterDocuments',
            'registration',
        ];

        $registerQuery = RegisterAllottee::with($registerRelations)
            ->where('property_number', $propertyNumber)
            ->where('is_active', 1)
            ->doesntHave('allottee');

        if (!empty($divisionId)) {
            $registerQuery->where('division_id', $divisionId);
        }
        if (!empty($subDivisionId)) {
            $registerQuery->where('sub_division_id', $subDivisionId);
        }

        $registerAllottees = $registerQuery->orderBy('id', 'desc')->get();

        return view('admin.property_search.index', [
            'propertyNumber' => $propertyNumber,
            'allottees' => $allottees,
            'registerAllottees' => $registerAllottees,
            'selectedDivisionId' => $divisionId,
            'selectedSubDivisionId' => $subDivisionId,
        ]);
    }

    public function autocomplete(Request $request)
    {
        $query = trim($request->input('query', ''));

        if ($query === '') {
            return response()->json([]);
        }

        $results = collect();

        // 1. Allottee records (Data Entry)
        $allotteeMatches = Allottee::with(['division:id,name', 'subDivision:id,name'])
            ->where('property_number', 'LIKE', '%' . $query . '%')
            ->select('id', 'property_number', 'division_id', 'subdivision_id')
            ->orderBy('id', 'desc')
            ->limit(15)
            ->get();

        foreach ($allotteeMatches as $item) {
            $divName = $item->division->name ?? 'N/A';
            $subDivName = $item->subDivision->name ?? 'N/A';
            $status = 'Data Entry';
            $key = strtolower($item->property_number) . '|' . $item->division_id . '|' . $item->subdivision_id . '|' . $status;

            if (!$results->has($key)) {
                $results->put($key, [
                    'property_number' => $item->property_number,
                    'division_id' => $item->division_id,
                    'sub_division_id' => $item->subdivision_id,
                    'division_name' => $divName,
                    'sub_division_name' => $subDivName,
                    'status' => $status,
                    'source' => 'allottee',
                    'label' => "{$item->property_number} | {$divName} | Sub Division : {$subDivName} | {$status}",
                ]);
            }
        }

        // 2. RegisterAllottee records (Received / Scanned) not yet in Allottee
        $registerMatches = RegisterAllottee::with(['division:id,name', 'subDivision:id,name'])
            ->where('property_number', 'LIKE', '%' . $query . '%')
            ->where('is_active', 1)
            ->doesntHave('allottee')
            ->select('id', 'property_number', 'division_id', 'sub_division_id', 'allottee_status')
            ->orderBy('id', 'desc')
            ->limit(15)
            ->get();

        foreach ($registerMatches as $item) {
            $divName = $item->division->name ?? 'N/A';
            $subDivName = $item->subDivision->name ?? 'N/A';
            $status = ucfirst(strtolower($item->allottee_status ?? 'received'));
            $key = strtolower($item->property_number) . '|' . $item->division_id . '|' . $item->sub_division_id . '|' . $status;

            if (!$results->has($key)) {
                $results->put($key, [
                    'property_number' => $item->property_number,
                    'division_id' => $item->division_id,
                    'sub_division_id' => $item->sub_division_id,
                    'division_name' => $divName,
                    'sub_division_name' => $subDivName,
                    'status' => $status,
                    'source' => 'register_allottee',
                    'label' => "{$item->property_number} | {$divName} | Sub Division : {$subDivName} | {$status}",
                ]);
            }
        }

        return response()->json($results->values()->take(15));
    }
}
