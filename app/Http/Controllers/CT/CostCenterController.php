<?php

namespace App\Http\Controllers\CT;

use App\Models\CT\CostCenter;
use App\Models\CT\CostCenterOrg;
use App\Models\CT\ProductGroup;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ct.cost_center.index');
    }

    public function create()
    {
        return view('ct.cost_center.create',[
            "is_edit" => false
        ]);
    }
    
    public function specifyPercentage()
    {
        return view('ct.specify_percentage.create');
    }

    public function specifySetAccountTypeDept()
    {
        return view('ct.specify_agency.index');
    }

    public function edit($cost_code)
    {
      // dd($cost_code);
      $cost_center = DB::table('ptct_cost_center_v')->where('cost_code', $cost_code)->first();
        // $cost_center = CostCenter::where('cost_code', $cost_code)->first();
        // $cost_center_org = CostCenterOrg::where('cost_code', $cost_code)->get();
        // $product_group = ProductGroup::where('cost_code', $cost_code)->get();
        return view('ct.cost_center.edit')->with([
            "is_edit" => true,
            "cost_center" => $cost_center,
            // "cost_center_org" => $cost_center_org,
            // "product_group" => $product_group
        ]);
    }
}
