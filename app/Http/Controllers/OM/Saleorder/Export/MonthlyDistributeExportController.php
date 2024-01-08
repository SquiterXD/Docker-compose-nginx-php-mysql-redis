<?php

namespace App\Http\Controllers\OM\Saleorder\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Saleorder\Domestic\MonthlyDistributeModel;

class MonthlyDistributeExportController extends Controller
{
    public function approved()
    {
        $list = MonthlyDistributeModel::select('budget_year')->where('sales_class_type','EXPORT')->groupBy('budget_year')->orderBy('budget_year','asc')->get();
        $year = [];
        foreach($list as $monthly_item){
            $year[] = [
                'year'   => $monthly_item->budget_year + 543,
            ];
        }


        return view('om.monthlydistribute.export.approve',[
            'year_list'  => $year
        ]);
    }
}
