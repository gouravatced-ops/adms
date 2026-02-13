<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Headquarter;

class HeadquarterController extends Controller
{
    /**
     * Show headquarters list + form
     */
    public function index()
    {
        $headquarters = Headquarter::latest()->get();
        return view('admin.components.headquaters.index', compact('headquarters'));
    }

    /**
     * Store new headquarter
     */
    public function store(Request $request)
    {
        // return $request; die();
        try {
            $request->validate([
                'name' => 'required',
                'status' => 'required',
            ]);
            Headquarter::create([
                'name'   => $request->name,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('headquarters.index')
                ->with('success', 'Headquarter added successfully.');
        } catch (\Exception $e) {
            // retrun $e->getMessage();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function createPage()
    {
        return view('admin.components.headquaters.create');
    }

    /**
     * Update headquarter
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $headquarter = Headquarter::findOrFail($id);
            $headquarter->update([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Headquarter updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Update failed.');
        }
    }

    /**
     * Delete headquarter
     */
    public function destroy($id)
    {
        Headquarter::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Headquarter deleted successfully');
    }
}
