<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyCategory;
use Carbon\Carbon;

class PropertyCategoryController extends Controller
{
    public function index()
    {
        $pcategories = PropertyCategory::orderBy('id', 'desc')->get()->map(function ($pcategorie) {
            $pcategorie->encode_id = base64_encode($pcategorie->id);
            $pcategorie->created_at = Carbon::parse($pcategorie->created_at)
                ->format('d-m-Y g:i A');

            return $pcategorie;
        });

        return view('admin.components.pcategory.index', compact('pcategories'));
    }

    public function createPage()
    {
        return view('admin.components.pcategory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        try {
            PropertyCategory::create([
                'name' => $request->name,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.pcategory.index')
                ->with('success', 'Property Category Added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function update(Request $request, $encode_id)
    {
        $id = base64_decode($encode_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        try {
            $pcategorie = PropertyCategory::findOrFail($id);

            $pcategorie->update([
                'name' => $request->name,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.pcategory.index')
                ->with('success', 'Property Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to update category.');
        }
    }

    public function fetch($encode_id)
    {
        $id = base64_decode($encode_id, true);
        abort_if(!$id || !is_numeric($id), 404);

        $pcategorie = PropertyCategory::findOrFail($id);

        return view(
            'admin.components.pcategory.edit',
            compact('pcategorie', 'encode_id')
        );
    }

    public function destroy($encode_id)
    {
        $id = base64_decode($encode_id);
        $pcategorie = PropertyCategory::findOrFail($id);
        $message = '';
        $status = 1;
        $messageType = 'success';
        if ($pcategorie->status == 1) {
            $status = 0;
            $message = 'Inactive';
            $messageType = 'error';
        } else {
            $status = 1;
            $message = 'Active';
            $messageType = 'success';
        }
        $pcategorie->update([
            'status' => $status,
        ]);

        return redirect()->back()->with($messageType, 'Property Category ' . $message . ' successfully.');
    }
}
