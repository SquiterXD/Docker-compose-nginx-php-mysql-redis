<?php

namespace App\Http\Controllers\IR\Settings;

use App\Http\Controllers\Controller;

use App\Models\IR\Settings\PtirGasStations;

class GasStationController extends Controller
{
    public function index()
    {
        $btnTrans = trans('btn');
        $dataSearch                   = (object)[];
        $dataSearch->type_code        = request()->type_code;
        $dataSearch->return_vat_flag  = request()->return_vat_flag;
        $dataSearch->active_flag      = request()->active_flag; 
        $dataSearch->url_search       = route('ir.settings.gas-station.index'); 

        $dataLists = PtirGasStations::search($dataSearch)
                                    ->orderby('gas_station_id', 'asc')
                                    ->get();
        // dd($dataLists);

        return view('ir.settings.gas-station.index', compact('btnTrans', 'dataLists', 'dataSearch'));
    }

    public function create()
    {
        $btnTrans = trans('btn');
        return view('ir.settings.gas-station.create', compact('btnTrans'));
    }

    public function edit($id)
    {
        $data = $id;
        $btnTrans = trans('btn');
        return view('ir.settings.gas-station.edit', compact('data', 'btnTrans'));
    }
}