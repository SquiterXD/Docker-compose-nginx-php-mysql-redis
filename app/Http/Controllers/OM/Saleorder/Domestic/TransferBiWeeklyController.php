<?php

namespace App\Http\Controllers\OM\Saleorder\Domestic;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

use App\Models\OM\Saleorder\Domestic\TransferBiWeeklyModel;
use App\Models\OM\Saleorder\Domestic\BiWeeklyPeriodsModel;

class TransferBiWeeklyController extends Controller
{
    public function index()
    {
        if(!canEnter('/om/transfer-bi-weekly/domestic') ||  !canView('/om/transfer-bi-weekly/domestic')){
            return \redirect()->back()->withError(trans('403'));
        }
        $menu = Menu::where('program_code', 'OMP0055')->first();
        // $test = TransferBiWeeklyModel::all();
        return view('om.transferbiweekly.domestics.index',compact('menu'));
    }

    public function approved()
    {
        if(!canEnter('/om/transfer-bi-weekly/domestic/approved') ||  !canView('/om/transfer-bi-weekly/domestic/approved')){
            return \redirect()->back()->withError(trans('403'));
        }

        $list = TransferBiWeeklyModel::select('budget_year')
                                        ->where('sales_class_type','DOMESTIC')
                                        ->groupBy('budget_year')
                                        ->orderBy('budget_year','asc')
                                        ->get();
        $year = [];
        foreach($list as $biweek_item){
            $year[] = [
                'year'   => $biweek_item->budget_year + 543,
            ];
        }
        $menu = Menu::where('program_code', 'OMP0056')->first();

        return view('om.transferbiweekly.domestics.appove',[
            'year_list'  => $year,
            'menu'  => $menu
        ]);
    }
}
