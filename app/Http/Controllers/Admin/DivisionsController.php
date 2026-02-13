<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DivisionsController extends Controller
{
    public function index()
    {
        $divisions = Division::orderBy('id', 'desc')->get()->map(function ($division) {
            $division->encode_id = base64_encode($division->id);
            $division->created_at = Carbon::parse($division->created_at)
                ->format('d-m-Y g:i A');

            return $division;
        });

        return view('admin.components.divisions.index', compact('divisions'));
    }

    public function createPage()
    {
        return view('admin.components.divisions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        try {
            Division::create([
                'name' => $request->name,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.division.index')
                ->with('success', 'Division Added successfully.');
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
            $division = Division::findOrFail($id);

            $division->update([
                'name' => $request->name,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.division.index')
                ->with('success', 'Division updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to update division.');
        }
    }

    public function fetch($encode_id)
    {
        $id = base64_decode($encode_id, true);
        abort_if(!$id || !is_numeric($id), 404);

        $division = Division::findOrFail($id);

        return view(
            'admin.components.divisions.edit',
            compact('division', 'encode_id')
        );
    }

    public function destroy($encode_id)
    {
        $id = base64_decode($encode_id);
        $division = Division::findOrFail($id);
        $message = '';
        $status = 1;
        $messageType = 'success';
        if ($division->status == 1) {
            $status = 0;
            $message = 'Inactive';
            $messageType = 'error';
        } else {
            $status = 1;
            $message = 'Active';
            $messageType = 'success';
        }
        $division->update([
            'status' => $status,
        ]);

        return redirect()->back()->with($messageType, 'Division ' . $message . ' successfully.');
    }
}
