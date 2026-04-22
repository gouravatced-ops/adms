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

if (!function_exists('getSubDivisionById')) {
    function getSubDivisionById($subDivisionId)
    {
        return SubDivision::where('id', $subDivisionId)
            ->where('status', 1)->first();
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

if (!function_exists('getSchemeList')) {
    function getSchemeList($divisionId, $subDivisionId, $categoryId, $typeId, $quarterTypeId)
    {
        return Scheme::where('is_active', 1)
            ->where('division_id', $divisionId)
            ->where('sub_division_id', $subDivisionId)
            ->where('pcategory_id', $categoryId)
            ->where('p_type_id', $typeId)
            ->where('quarter_type_id', $quarterTypeId)
            ->orderBy('scheme_name', 'asc')
            ->get();
    }
}

if (!function_exists('getSchemeName')) {
    function getSchemeName($schemeId)
    {
        return Scheme::where('id', $schemeId)
            ->value('scheme_name');
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

if (!function_exists('getStates')) {
    function getStates()
    {
        return DB::table('states')
            ->orderByRaw("
                CASE 
                    WHEN name_en = 'Bihar (Now Jharkhand)' THEN 1
                    WHEN name_en = 'Jharkhand' THEN 2
                    WHEN name_en = 'Bihar' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('name_en', 'ASC') // optional: sort remaining states
            ->get();
    }
}

if (!function_exists('getDivisionName')) {
    function getDivisionName($divisionId)
    {
        return Division::where('id', $divisionId)->value('name');
    }
}

if (!function_exists('getDistrict')) {
    function getDistrict($stateId)
    {
        return DB::table('districts')->where('state_id', $stateId)->get();
    }
}

if (!function_exists('getStateName')) {
    function getStateName($stateId)
    {
        return DB::table('states')->where('id', $stateId)->value('name_en');
    }
}

if (!function_exists('getAllotteeName')) {
    function getAllotteeName($allotteeId)
    {
        $allottee = DB::table('allottees')->select('prefix', 'allottee_name', 'allottee_middle_name', 'allottee_surname')->where('id', $allotteeId)->first();
        if ($allottee) {
            return trim($allottee->prefix . ' ' . $allottee->allottee_name . ' ' . $allottee->allottee_middle_name . ' ' . $allottee->allottee_surname);
        }
        return null;
    }
}

if (!function_exists('getDistrictName')) {
    function getDistrictName($distId)
    {
        return DB::table('districts')->where('id', $distId)->value('name_en');
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

if (!function_exists('getUsers')) {
    function getUsers()
    {
        return DB::table('users')->where('role', 'scanner')->get();
    }
}

if (!function_exists('getDebugIndex')) {
    function getDebugIndex($data)
    {
        echo '<pre>';
        print_r($data->toArray());
        echo '</pre>';
        die();
    }
}
