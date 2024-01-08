<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Models\CT\GetMeasureVl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeasureController extends Controller
{
    public function index()
    {
        $measure = GetMeasureVl::where(function ($q) {
            $query = request()->text;
            if ($query) {
                $q->where('unit_of_measure', 'like', "%{$query}%")
                    ->orWhere('uom_code', 'like', "%{$query}%");
            }
        })
        ->select('unit_of_measure', 'uom_code')
        ->get();
        return response()->json($measure);
    }
}
