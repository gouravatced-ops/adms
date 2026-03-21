<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminDetails;
use Illuminate\Http\Request;
use App\Models\Scheme;
use App\Models\Division;
use App\Models\SubDivision;
use App\Models\Allottee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function superadminDashboard()
    {
        $divisionCount     = Division::where('status', 1)->count();
        $subdivisionCount  = SubDivision::where('status', 1)->count();
        $schemeCount       = Scheme::where('is_active', 1)->count();
        $allotteeCount     = Allottee::where('is_step_completed', 1)->count();

        $recentAllotteeList = Allottee::with('division')->where('is_step_completed', 1)
            ->latest() // cleaner than orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // return $recentAllotteeList;

        return view('admin.superadmin.dashboard', compact(
            'divisionCount',
            'subdivisionCount',
            'schemeCount',
            'allotteeCount',
            'recentAllotteeList'
        ));
    }

    public function showCreateAdmin()
    {
        return view('admin.superadmin.create-admin');
    }
    public function createAdmin(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'nullable|email',
            'whatsapp' => 'required|string|max:15',
            'mobile_no' => 'required|digits:10|unique:admin_details,mobile_no',
            'alt_mobile_no' => 'nullable|digits:10',
            'profile_pic' => 'nullable|string|max:50',
            'role' => 'required|in:council_office,registar,superadmin',
        ]);

        DB::beginTransaction();

        try {
            $adminDetails = AdminDetails::create($validatedData);

            $firstName = ucfirst(strtolower(explode(' ', trim($request->name))[0])); // Get the first name and capitalize the first letter
            $mobileLastFive = substr($request->mobile_no, -5); // Get the last 5 digits of the mobile number
            $uniqueKey = $firstName . '#' . $mobileLastFive;

            $admin = Admin::create([
                'admin_details_id' => $adminDetails->id,
                'mobile_no' => $validatedData['mobile_no'],
                'alt_mobile_no' => $validatedData['alt_mobile_no'],
                'password' => Hash::make($uniqueKey),
                'role' => $validatedData['role'],
            ]);

            DB::commit();

            return back()->with('success', 'Admin created successfully! Mobile: ' . $validatedData["mobile_no"] . ' & Pass: ' . $uniqueKey);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to create admin: ' . $e->getMessage());
        }
    }

    public function showAdmins()
    {
        // Fetch all admins with their details
        $admins = Admin::with('adminDetails')->get();

        // Pass the data to the view
        return view('admin.superadmin.view-admins', compact('admins'));
    }
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email',
            'whatsapp' => 'required|digits:10',
            'mobile_no' => "required|digits:10|unique:admins,mobile_no,$id",
            'alt_mobile_no' => 'nullable|digits:10',
            'profile_pic' => 'nullable|string|max:50',
            'role' => 'required|in:council_office,registar,superadmin',
        ]);

        // Find the admin by ID
        $admin = Admin::findOrFail($id);

        // Update related AdminDetails record
        $admin->adminDetails->update([
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'email' => $validatedData['email'],
            'whatsapp' => $validatedData['whatsapp'],
            'mobile_no' => $validatedData['mobile_no'],
            'alt_mobile_no' => $validatedData['alt_mobile_no'],
        ]);

        // Update the Admin record
        $admin->update([
            'mobile_no' => $validatedData['mobile_no'],
            'alt_mobile_no' => $validatedData['alt_mobile_no'],
            'role' => $validatedData['role'],
        ]);

        return back()->with('success', 'Admin updated successfully!');
    }
}
