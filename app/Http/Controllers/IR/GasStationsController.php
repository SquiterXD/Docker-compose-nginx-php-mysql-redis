<?php

namespace App\Http\Controllers\IR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\IR\GasStationExport;

class GasStationsController extends Controller
{
    public function index()
    {
        return view('ir.gas-stations.index');
    }

    public function export()
    {
        return Excel::download(new GasStationExport(), 'IRP0008'.'.xlsx');
    }
}
