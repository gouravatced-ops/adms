<?php

use App\Models\Division;
use App\Models\SubDivision;
use App\Models\PropertyCategory;
use App\Models\PropertyType;
use App\Models\PropertyMainType;
use App\Models\QuarterType;

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