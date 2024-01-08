<?php

namespace App\Http\Controllers\PD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PD\MedicinalLeafTypeHV;

class HistoryInsteadGradesController extends Controller
{
    public function index()
    {
        $medicinalLeafTypesH = MedicinalLeafTypeHV::all();
        $transDate = trans('date');
        $transBtn = trans('btn');
        $currentDateTH = parseToDateTh(now());
        return  view('pd.history-instead-grades.index',
                compact('medicinalLeafTypesH', 'transDate', 'transBtn', 'currentDateTH'));
    }
}
