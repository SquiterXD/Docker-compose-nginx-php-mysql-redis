<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Report\ReportRepo;

class ReportsController extends Controller
{
    public function index()
    {
        // dd(\DB::connection('oracle')->getDatabaseName());
        // dd(route('ir.ajax.ir-report-get-info'));
        // $roles = \App\Models\Role::whereIn('role_id', auth()->user()->role_options)
        // ->pluck('module_name');
        // dd(
        //         \DB::connection('oracle')->getDatabaseName(),
        //         getDefaultData(\Request::path()),
        //         $roles

        // );
        $url = (Object)[];
        $url->getInfor = route('ir.ajax.ir-report-get-info');

        $url->getInfoAttribute =route('ir.ajax.ir-report-get-info-attribute');
        $url->getParam = route('ir.report.get-param');


        return view('reports.index', [
            'url' => $url,

        ]);
    }

    public function getParam()
    {
        $code =  request()->program_code;
        $module = substr($code, 0, 2);
        return (new ReportRepo)->mapReport($module,$code, request());
    }
}
