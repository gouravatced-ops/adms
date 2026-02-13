<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SubDivision;

class SubDivisionController extends Controller
{
    public function index()
    {
        $subdivisions = SubDivision::with('division:id,name')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($subdivision) {
                $subdivision->encode_id = base64_encode($subdivision->id);
                $subdivision->created_at = $subdivision->created_at
                    ? Carbon::parse($subdivision->created_at)->format('d-m-Y g:i A')
                    : '-';
                return $subdivision;
            });

        return view('admin.components.subdivision.index', compact('subdivisions'));
    }

    public function createPage()
    {
        return view('admin.components.subdivision.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'division_id' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        try {
            SubDivision::create([
                'division_id' => $request->division_id,
                'name' => $request->name,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.subdivision.index')
                ->with('success', 'SubDivision Added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function update(Request $request, $encode_id)
    {
        $id = base64_decode($encode_id);

        $request->validate([
            'division_id' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        try {
            $SubDivision = SubDivision::findOrFail($id);

            $SubDivision->update([
                'division_id' => $request->division_id,
                'name' => $request->name,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.subdivision.index')
                ->with('success', 'SubDivision updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to update Sub division.');
        }
    }

    public function fetch($encode_id)
    {
        $id = base64_decode($encode_id, true);
        abort_if(!$id || !is_numeric($id), 404);

        $subdivision = SubDivision::findOrFail($id);

        return view(
            'admin.components.subdivision.edit',
            compact('subdivision', 'encode_id')
        );
    }

    public function destroy($encode_id)
    {
        $id = base64_decode($encode_id);
        $subdivision = SubDivision::findOrFail($id);
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

        return redirect()->back()->with($messageType, 'Subdivision ' .$message. ' successfully.');
    }
}
