<?php

namespace App\Http\Controllers\OM\Saleorder\Domestic;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\OM\Saleorder\Domestic\MonthlyDistributeModel;

class MonthlyDistributeController extends Controller
{
    public function index()
    {
        if(!canEnter('/om/monthly-distribute/domestic') ||  !canView('/om/monthly-distribute/domestic')){
            return \redirect()->back()->withError(trans('403'));
        }
        $menu = Menu::where('program_code', 'OMP0057')->first();

        return view('om.monthlydistribute.domestics.index',compact('menu'));
    }

    public function approved()
    {
        if(!canEnter('/om/monthly-distribute/domestic/approved') ||  !canView('/om/monthly-distribute/domestic/approved')){
            return \redirect()->back()->withError(trans('403'));
        }

        $list = MonthlyDistributeModel::select('budget_year')->where('sales_class_type','DOMESTIC')->groupBy('budget_year')->orderBy('budget_year','asc')->get();
        $year = [];
        foreach($list as $monthly_item){
            $year[] = [
                'year'   => $monthly_item->budget_year + 543,
            ];
        }

        $menu = Menu::where('program_code', 'OMP0058')->first();
        return view('om.monthlydistribute.domestics.approve',[
            'year_list'  => $year,
            'menu'  => $menu
        ]);
    }
}
