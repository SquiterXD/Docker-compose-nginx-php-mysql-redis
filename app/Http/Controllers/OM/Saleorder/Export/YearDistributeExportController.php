<?php

namespace App\Http\Controllers\OM\Saleorder\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Saleorder\Domestic\YearDistributeModel;


class YearDistributeExportController extends Controller
{
    public function approved()
    {
        $list = YearDistributeModel::select('budget_year')->where('sales_class_type','EXPORT')->groupBy('budget_year')->orderBy('budget_year','asc')->get();
        $year = [];
        foreach($list as $year_item){
            $year[] = [
                'year'   => $year_item->budget_year + 543,
            ];
        }

        return view('om.yeardistribute.export.approve',[
            'year_list'  => $year
        ]);
    }
}
