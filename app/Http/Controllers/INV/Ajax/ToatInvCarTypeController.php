<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\FndFlexValueSets;
use App\Models\INV\FndFlexValuesVl;
use Illuminate\Http\Request;

class ToatInvCarTypeController extends Controller
{
    public function index()
    {
        $carTypes = FndFlexValuesVl::with('fndFlexValueSet')
            ->select('flex_value', 'description')
            ->where('enabled_flag', 'Y')
            ->whereHas('fndFlexValueSet', function($q) {
                $q->where('flex_value_set_name', 'TOAT_INV_CAR_TYPE');
            })
            ->where(function ($q) {
                $query = request()->text;
                if ($query) {
                    $q->where('flex_value', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                }
            })
            ->get();

        return response()->json($carTypes);
    }
}
