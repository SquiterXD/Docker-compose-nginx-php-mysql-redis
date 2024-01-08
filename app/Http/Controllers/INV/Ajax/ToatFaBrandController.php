<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\FndFlexValuesVl;
use Illuminate\Http\Request;

class ToatFaBrandController extends Controller
{
    public function index()
    {
        $carBrands = FndFlexValuesVl::with('fndFlexValueSet')
            ->select('flex_value', 'description')
            ->where('enabled_flag', 'Y')
            ->whereHas('fndFlexValueSet', function($q) {
                $q->where('flex_value_set_name', 'TOAT_FA_BRAND');
            })
            ->where(function ($q) {
                $query = request()->text;
                if ($query) {
                    $q->where('flex_value', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                }
            })
            ->get();

        return response()->json($carBrands);
    }
}
