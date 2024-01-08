<?php

namespace App\Http\Controllers\IR\Settings;

use App\Http\Controllers\Controller;

use App\Models\IR\Settings\PtirCompanies;

class CompanyController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $btnTrans = trans('btn');

        $dataSearch = (object)[];
        $dataSearch->company_id  = request()->company_id;
        $dataSearch->active_flag = request()->active_flag; 
        $dataSearch->url_search  = route('ir.settings.company.index'); 

        $dataLists = PtirCompanies::search($dataSearch)
                                    ->orderby('company_number', 'asc')
                                    ->get();
        // dd(request()->all(), $dataSearch, $dataLists);

        return view('ir.settings.company.index', compact('btnTrans', 'dataSearch', 'dataLists'));
    }
    
    public function create()
    {
        $btnTrans = trans('btn');
        return view('ir.settings.company.create', compact('btnTrans'));
    }

    public function edit($id)
    {
        $data = $id;
        $btnTrans = trans('btn');
        return view('ir.settings.company.edit', compact('data', 'btnTrans'));
    }
}
