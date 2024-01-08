<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\FndFlexValuesVl;
use Illuminate\Http\Request;

class FndFlexValuesVlController extends Controller
{
    public function index()
    {
        $costCenters = FndFlexValuesVl::selectRaw('ROWIDTOCHAR(rowid) as "rowid"')
        ->select('parent_flex_value_low', 'flex_value', 'flex_value_meaning', 'description', 'enabled_flag', 'flex_value_set_id', 'flex_value_id')
        ->when(request()->department_code, function($q) {
            $q->where('parent_flex_value_low', request()->department_code);
        })
        ->when(request()->segment4, function($q) {
            $q->where('flex_value_set_id', request()->segment4);
        })
        ->where('flex_value_set_id', 1017447)
        ->whereNotIn('flex_value', ['T'])
        ->where('enabled_flag', 'Y')
        ->get();

        return response()->json($costCenters);
    }
}
