<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchemeBlock;
use App\Models\Scheme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SchemeBlockController extends Controller
{
    public function index($schemeId)
    {
        $schId = base64_decode($schemeId);
        $schemes = Scheme::with(['blocks', 'propertyType'])
            ->withCount('blocks')
            ->where('id', $schId)
            ->get();
        return view('admin.components.schemes.blocks.index', compact('schemes', 'schemeId'));
    }

    public function createPage()
    {
        $schemes = getSchemes();
        // return $schemes; die();
        return view('admin.components.schemes.blocks.create', compact('schemes'));
    }

    public function addBlocksPage($schemeId)
    {
        $schId = base64_decode($schemeId);

        $scheme = Scheme::with(['blocks', 'propertyType'])
            ->withCount('blocks')
            ->findOrFail($schId);

        return view('admin.components.schemes.blocks.add', compact('scheme' , 'schemeId'));
    }


    public function individualAdd(Request $request)
    {
        $validated = $request->validate([
            'scheme_id' => 'required',
            'scheme_property_type' => 'required|string',
            'new_block.name' => 'required|string|max:255',
            'new_block.area_sqft' => 'required|numeric',
            'new_block.undivided_land_share' => 'nullable|numeric',
            'new_block.total_buildup' => 'nullable|numeric',
            'new_block.total_construction_area' => 'nullable|numeric',

            // Dimensions
            'new_block.dimensions.east' => 'nullable|string',
            'new_block.dimensions.west' => 'nullable|string',
            'new_block.dimensions.north' => 'nullable|string',
            'new_block.dimensions.south' => 'nullable|string',

            // Arms
            'new_block.arms.east_west_north' => 'nullable|string',
            'new_block.arms.east_west_south' => 'nullable|string',
            'new_block.arms.north_south_east' => 'nullable|string',
            'new_block.arms.north_south_west' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            $block = $validated['new_block'];

            SchemeBlock::create([
                'scheme_id' => $validated['scheme_id'],
                'scheme_property_type' => $validated['scheme_property_type'],
                'block_name' => $block['name'],
                'area_sqft' => $block['area_sqft'],
                'undivided_land_share' => $block['undivided_land_share'] ?? null,
                'total_buildup' => $block['total_buildup'] ?? null,

                // Dimensions
                'dimension_east' => $block['dimensions']['east'] ?? null,
                'dimension_west' => $block['dimensions']['west'] ?? null,
                'dimension_north' => $block['dimensions']['north'] ?? null,
                'dimension_south' => $block['dimensions']['south'] ?? null,

                // Arms
                'arm_east_west_north' => $block['arms']['east_west_north'] ?? null,
                'arm_east_west_south' => $block['arms']['east_west_south'] ?? null,
                'arm_north_south_east' => $block['arms']['north_south_east'] ?? null,
                'arm_north_south_west' => $block['arms']['north_south_west'] ?? null,

                'status' => 1,
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.schemes.blocks.add.page', [
                    'schemeId' => base64_encode($validated['scheme_id'])
                ])
                ->with('success', 'Scheme Block Created Successfully!');
        } catch (\Throwable $e) {

            DB::rollBack();
            report($e); // Debugging ke liye helpful

            return back()->with('error', 'Something went wrong!');
        }
    }

    public function individualUpdate(Request $request)
    {
        $validated = $request->validate([
            'edit_block_id' => 'required',
            'scheme_id' => 'required',

            'edit_block.name' => 'required|string|max:255',
            'edit_block.area_sqft' => 'required|numeric',
            'edit_block.property_type' => 'required|string',

            'edit_block.undivided_land_share' => 'nullable|numeric',
            'edit_block.total_buildup' => 'nullable|numeric',

            // Dimensions
            'edit_block.dimensions.east' => 'nullable|string',
            'edit_block.dimensions.west' => 'nullable|string',
            'edit_block.dimensions.north' => 'nullable|string',
            'edit_block.dimensions.south' => 'nullable|string',

            // Arms
            'edit_block.arms.east_west_north' => 'nullable|string',
            'edit_block.arms.east_west_south' => 'nullable|string',
            'edit_block.arms.north_south_east' => 'nullable|string',
            'edit_block.arms.north_south_west' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            $block = SchemeBlock::findOrFail($validated['edit_block_id']);
            $data  = $validated['edit_block'];

            $block->update([
                'scheme_id' => $validated['scheme_id'],
                'scheme_property_type' => $block->scheme_property_type,
                'block_name' => $data['name'],
                'area_sqft' => $data['area_sqft'],
                'undivided_land_share' => $data['undivided_land_share'] ?? null,
                'total_buildup' => $data['total_buildup'] ?? null,

                // Dimensions
                'dimension_east' => $data['dimensions']['east'] ?? null,
                'dimension_west' => $data['dimensions']['west'] ?? null,
                'dimension_north' => $data['dimensions']['north'] ?? null,
                'dimension_south' => $data['dimensions']['south'] ?? null,

                // Arms
                'arm_east_west_north' => $data['arms']['east_west_north'] ?? null,
                'arm_east_west_south' => $data['arms']['east_west_south'] ?? null,
                'arm_north_south_east' => $data['arms']['north_south_east'] ?? null,
                'arm_north_south_west' => $data['arms']['north_south_west'] ?? null,

                'updated_by' => Auth::user()->id,
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Scheme Block Updated Successfully!');
        } catch (\Exception $e) {

            DB::rollBack();
            // return $e->getMessage();

            return back()->with('error', 'Something went wrong!');
        }
    }

    public function schemeBlockDelete($blockId)
    {
        $division = SchemeBlock::findOrFail($blockId);
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
            'updated_by' => Auth::user()->id
        ]);

        return redirect()->back()->with($messageType, 'Scheme Block ' . $message . ' successfully.');
    }

    public function createBlocks(Request $request)
    {
        $request->validate([
            'scheme_id' => 'required',
            'scheme_property_type' => 'required|string',
            'blocks' => 'required|array',
            'blocks.*.name' => 'required|string',
            'blocks.*.area_sqft' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            $insertData = [];

            foreach ($request->blocks as $block) {

                $insertData[] = [
                    'scheme_id' => $request->scheme_id,
                    'scheme_property_type' => $request->scheme_property_type,
                    'block_name' => $block['name'],
                    'area_sqft' => $block['area_sqft'],

                    // Optional fields (if applicable)
                    'undivided_land_share' => $block['undivided_land_share'] ?? null,
                    'total_buildup' => $block['total_buildup'] ?? null,
                    'total_area_of_construction' => $block['total_area_of_construction'] ?? null,

                    // Dimensions
                    'dimension_east' => $block['dimensions']['east'] ?? null,
                    'dimension_west' => $block['dimensions']['west'] ?? null,
                    'dimension_north' => $block['dimensions']['north'] ?? null,
                    'dimension_south' => $block['dimensions']['south'] ?? null,

                    // Arms
                    'arm_east_west_north' => $block['arms']['east_west_north'] ?? null,
                    'arm_east_west_south' => $block['arms']['east_west_south'] ?? null,
                    'arm_north_south_east' => $block['arms']['north_south_east'] ?? null,
                    'arm_north_south_west' => $block['arms']['north_south_west'] ?? null,

                    'status' => 1,
                    'created_by' => Auth::user()->id,
                    'updated_by' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Bulk Insert (Faster)
            SchemeBlock::insert($insertData);

            DB::commit();

            return redirect()
                ->route('admin.schemes.blocks.create.page')
                ->with('success', "Scheme Block Created successfully!");
        } catch (\Exception $e) {

            DB::rollBack();

            // return response()->json([
            //     'success' => false,
            //     'message' => $e->getMessage()
            // ], 500);
            return redirect()
                ->route('admin.schemes.blocks.create.page')
                ->with('error', "Something Wrong");
        }
    }

    public function fetchBlocks($schemeId)
    {
        $schemes = Scheme::with('blocks')
            ->withCount('blocks')
            ->where('id', $schemeId)
            ->get();
        return view('admin.components.schemes.blocks.edit', compact('schemes'));
    }
}
