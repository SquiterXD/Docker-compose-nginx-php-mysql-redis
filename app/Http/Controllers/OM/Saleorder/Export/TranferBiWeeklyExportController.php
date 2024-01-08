<?php

namespace App\Http\Controllers\OM\Saleorder\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Saleorder\Domestic\TransferBiWeeklyModel;
use App\Models\OM\Saleorder\Domestic\BiWeeklyPeriodsModel;

class TranferBiWeeklyExportController extends Controller
{
    public function approved()
    {

        $list = TransferBiWeeklyModel::select('budget_year')->where('sales_class_type','EXPORT')->groupBy('budget_year')->orderBy('budget_year','asc')->get();
        $year = [];
        foreach($list as $biweek_item){
            $year[] = [
                'year'   => $biweek_item->budget_year + 543,
            ];
        }

        return view('om.transferbiweekly.export.appove',[
            'year_list'  => $year
        ]);
    }
}
