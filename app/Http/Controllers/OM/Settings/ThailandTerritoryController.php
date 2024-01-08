<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\Settings\ThailandTerritory;
use App\Imports\OM\ThailandTerritoryImport;
use Maatwebsite\Excel\Facades\Excel;

class ThailandTerritoryController extends Controller
{
    public function index()
    {
        return view('om.settings.thailand-territory.index');
    }

    public function previewImport(Request $request) 
    {
        $data = $request->tambonIds ?? [];
        $thailandTerritories = ThailandTerritory::whereIn('tambon_id', $data)->orderBy('tambon_id')->get();
        $result['html'] = view('om.settings.thailand-territory._preview_existing_data', compact('thailandTerritories'))->render();
        $result['err_msg'] = '';

        if(request()->ajax()){
            return \Response::json($result, 200);
        }else{
            return $result;
        }
    }
    
    public function import(Request $request) 
    {
        Excel::import(new ThailandTerritoryImport,request()->file('select_file'));

        return back()->with('success', 'Excel Data Imported successfully.');
    }

    public function export(Request $request) {

        ini_set("memory_limit","1024M");
        ini_set('max_execution_time', 1800); //1800 seconds = 30 minutes

        $thailandTerritories = ThailandTerritory::orderBy('tambon_id')->get();

        return \Excel::download(new \App\Exports\OM\ThailandTerritoryExport(
            $thailandTerritories
        ), 'TOAT_OM_THAILAND_TERRITORY.xlsx');
    }
}
