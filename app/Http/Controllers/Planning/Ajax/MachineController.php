<?php

namespace App\Http\Controllers\Planning\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\MachineBiWeeklyHeader;
use App\Models\Planning\MachineBiWeeklyLines;
use App\Models\Planning\ProductType;
use App\Models\Planning\BiWeeklyV;

class MachineController extends Controller
{
    public function findMonthMachine(Request $request)
    {
        $year = $request->year-543;
        $months = BiWeeklyV::selectRaw('distinct thai_month, period_num')->where('period_year', $year)->orderBy('period_num')->get();
        return response()->json($months);
    }

    public function findBiWeeklyMachine(Request $request)
    {
        $year = $request->year-543;
        $biweekly = BiWeeklyV::selectRaw('distinct biweekly')->where('period_year', $year)->where('period_num', $request->month)->orderBy('biweekly')->get();
        return response()->json($biweekly);
    }
}
