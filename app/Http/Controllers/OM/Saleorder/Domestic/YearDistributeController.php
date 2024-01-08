<?php

namespace App\Http\Controllers\OM\SaleOrder\Domestic;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

use App\Models\OM\Saleorder\Domestic\YearDistributeModel;

class YearDistributeController extends Controller
{
    public function index()
    {
        if(!canEnter('/om/year-distribute/domestic') ||  !canView('/om/year-distribute/domestic')){
            return \redirect()->back()->withError(trans('403'));
        }

        $menu = Menu::where('program_code', 'OMP0059')->first();

        return view('om.yeardistribute.domestics.index',compact('menu'));
    }

    public function approved()
    {
        if(!canEnter('/om/year-distribute/domestic/approved') ||  !canView('/om/year-distribute/domestic/approved')){
            return \redirect()->back()->withError(trans('403'));
        }


        $list = YearDistributeModel::select('budget_year')->where('sales_class_type','DOMESTIC')->groupBy('budget_year')->orderBy('budget_year','asc')->get();
        $year = [];
        foreach($list as $year_item){
            $year[] = [
                'year'   => $year_item->budget_year + 543,
            ];
        }
        $menu = Menu::where('program_code', 'OMP0060')->first();

        return view('om.yeardistribute.domestics.approve',[
            'year_list'  => $year,
            'menu'  => $menu
        ]);
    }
}
