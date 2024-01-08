<?php

namespace App\Http\Controllers\PM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PM\PtpmRequestReportV;

class TestReportController extends Controller
{
    public function getItems()
    {
        $startDate = parseFromDateTh(request()->startDate);
        $endDate = parseFromDateTh(request()->endDate);

        $items = PtpmRequestReportV::whereDate('CREATION_DATE','>=',$startDate)
            ->whereDate('CREATION_DATE','<=',$endDate)
            ->get();

        return response()->json(['data'=>$items]);
    }

    public function getItems2()
    {
        $startDate = parseFromDateTh(request()->startDate);
        $endDate = parseFromDateTh(request()->endDate);

        $items = PtpmRequestReportV::whereDate('CREATION_DATE','>=',$startDate)
            ->whereDate('CREATION_DATE','<=',$endDate)
            ->get();

        return view('pm.confirm-order.report3',compact('items'));
    }
}
