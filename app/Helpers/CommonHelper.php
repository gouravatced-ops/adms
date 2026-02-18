<?php

use App\Models\Division;
use App\Models\SubDivision;
use App\Models\PropertyCategory;
use App\Models\PropertyType;
use App\Models\PropertyMainType;
use App\Models\QuarterType;
use App\Models\Scheme;
use Illuminate\Support\Facades\DB;

if (!function_exists('getDivisions')) {
    function getDivisions()
    {
        return Division::where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }
}

if (!function_exists('getPropertyCategory')) {
    function getPropertyCategory()
    {
        return PropertyCategory::where('status', 1)
            ->get();
    }
}

if (!function_exists('getSubDivisions')) {
    function getSubDivisions($divisionId)
    {
        return SubDivision::where('division_id', $divisionId)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }
}

if (!function_exists('getQuarterType')) {
    function getQuarterType()
    {
        return QuarterType::where('status', 1)
            ->get();
    }
}

if (!function_exists('getSchemes')) {
    function getSchemes()
    {
        return Scheme::query()
            ->from('schemes as sm')
            ->leftJoin('divisions as d', 'd.id', '=', 'sm.division_id')
            ->leftJoin('sub_divisions as sd', 'sd.id', '=', 'sm.sub_division_id')
            ->leftJoin('property_category as pc', 'pc.id', '=', 'sm.pcategory_id')
            ->leftJoin('property_type as pt', 'pt.id', '=', 'sm.p_type_id')
            ->leftJoin('property_sub_type as pst', 'pst.id', '=', 'sm.p_sub_type_id')
            ->leftJoin('quarter_type as qt', 'qt.quarter_id', '=', 'sm.quarter_type_id')
            ->select([
                'sm.*',
                'd.name as division_name',
                'sd.name as sub_division_name',
                'pc.name as category_name',
                'pt.name as property_type_name',
                'pst.name as property_sub_type_name',
                'qt.quarter_code',
                DB::raw('(SELECT COUNT(*) FROM scheme_blocks sb WHERE sb.scheme_id = sm.id) as total_blocks')
            ])
            ->latest('sm.created_at') // cleaner than orderByDesc
            ->get(); // ← execute here
    }
}

if (!function_exists('getpcategoryType')) {
    function getpcategoryType()
    {
        return PropertyType::with('propertyCategory:id,name')->where('status', 1)
            ->get();
    }
}

if (!function_exists('getPropertyType')) {
    function getPropertyType($category_id)
    {
        return PropertyType::where('category_id', $category_id)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }
}

if (!function_exists('getPropertySubType')) {
    function getPropertySubType($typeId)
    {
        return PropertyMainType::where('ptype_id', $typeId)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($date, $format = 'd/m/Y H:i A')
    {
        if (!$date) {
            return '-';
        }

        try {
            return \Carbon\Carbon::parse($date)->format($format);
        } catch (\Exception $e) {
            return '-';
        }
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd/m/Y')
    {
        if (!$date) {
            return '-';
        }

        try {
            return \Carbon\Carbon::parse($date)->format($format);
        } catch (\Exception $e) {
            return '-';
        }
    }
}

if (!function_exists('getDebugIndex')) {
    function getDebugIndex($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }
}
