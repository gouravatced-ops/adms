<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyType;
use Carbon\Carbon;

class PropertyTypeController extends Controller
{
    public function index()
    {
        $propertyTypes = PropertyType::with('propertyCategory:id,name')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($PropertyType) {
                $PropertyType->encode_id = base64_encode($PropertyType->id);
                $PropertyType->created_at = $PropertyType->created_at
                    ? Carbon::parse($PropertyType->created_at)->format('d-m-Y g:i A')
                    : '-';
                return $PropertyType;
            });

        return view('admin.components.pcategorytype.index', compact('propertyTypes'));
    }

    public function createPage()
    {
        return view('admin.components.pcategorytype.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        try {
            PropertyType::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.pcategorytype.index')
                ->with('success', 'Property Type Added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function update(Request $request, $encode_id)
    {
        $id = base64_decode($encode_id);

        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        try {
            $SubDivision = PropertyType::findOrFail($id);

            $SubDivision->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.pcategorytype.index')
                ->with('success', 'Property Type updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to update type.');
        }
    }

    public function fetch($encode_id)
    {
        $id = base64_decode($encode_id, true);
        abort_if(!$id || !is_numeric($id), 404);

        $pcategorytype = PropertyType::findOrFail($id);

        return view(
            'admin.components.pcategorytype.edit',
            compact('pcategorytype', 'encode_id')
        );
    }

    public function destroy($encode_id)
    {
        $id = base64_decode($encode_id);
        $subdivision = PropertyType::findOrFail($id);
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

        return redirect()->back()->with($messageType, 'Property Type ' .$message. ' successfully.');
    }
}
