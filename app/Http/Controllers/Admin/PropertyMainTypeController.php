<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyMainType;
use Carbon\Carbon;

class PropertyMainTypeController extends Controller
{
    public function index()
    {
        $propertySubTypes = PropertyMainType::with(['propertyType', 'propertyCategory'])->orderBy('id', 'desc')
            ->get()
            ->map(function ($propertySubType) {
                $propertySubType->encode_id = base64_encode($propertySubType->id);
                $propertySubType->created_at = $propertySubType->created_at
                    ? Carbon::parse($propertySubType->created_at)->format('d-m-Y g:i A')
                    : '-';
                return $propertySubType;
            });

        // return $propertySubTypes; die();

        return view('admin.components.propertysubtypes.index', compact('propertySubTypes'));
    }

    public function createPage()
    {
        return view('admin.components.propertysubtypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ptype_id' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        try {
            PropertyMainType::create([
                'ptype_id' => $request->ptype_id,
                'name' => $request->name,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.propertysubtypes.index')
                ->with('success', 'Property Sub Type Added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function update(Request $request, $encode_id)
    {
        $id = base64_decode($encode_id);

        $request->validate([
            'ptype_id' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        try {
            $SubDivision = PropertyMainType::findOrFail($id);

            $SubDivision->update([
                'ptype_id' => $request->ptype_id,
                'name' => $request->name,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.propertysubtypes.index')
                ->with('success', 'Property Sub Type updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to update type.');
        }
    }

    public function fetch($encode_id)
    {
        $id = base64_decode($encode_id, true);
        abort_if(!$id || !is_numeric($id), 404);

        $pcategorytype = PropertyMainType::findOrFail($id);

        return view(
            'admin.components.propertysubtypes.edit',
            compact('pcategorytype', 'encode_id')
        );
    }

    public function destroy($encode_id)
    {
        $id = base64_decode($encode_id);
        $subdivision = PropertyMainType::findOrFail($id);
        $message = '';
        $status = 1;
        $messageType = 'success';
        if ($subdivision->status == 1) {
            $status = 0;
            $message = 'Inactive';
            $messageType = 'error';
        } else {
            $status = 1;
            $message = 'Active';
            $messageType = 'success';
        }
        $subdivision->update([
            'status' => $status,
        ]);

        return redirect()->back()->with($messageType, 'Property Sub Type ' .$message. ' successfully.');
    }
}
