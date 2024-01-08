<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\LookupValue;
use Illuminate\Http\Request;

class FndLookupValuesController extends Controller
{
    public function index()
    {
        $lookupValues = LookupValue::query()
            ->select('description')
            ->where('enabled_flag', 'Y')
            ->whereHas('lookupType', function($q) {
                $q->where('lookup_type', 'TOAT_INV_CAR_TYPES');
            })
            ->get();

        return response()->json($lookupValues);
    }
}
