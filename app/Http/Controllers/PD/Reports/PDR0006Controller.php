<?php

namespace App\Http\Controllers\PD\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PD\Ptpd16GradeReplacHisRV;

use PDF;
use Carbon\Carbon;

class PDR0006Controller extends Controller
{
	public function PDR0006($programCode, $request)
    {
        $req = $request;
        $result = Ptpd16GradeReplacHisRV::selectRaw("
                        ROW_NUMBER() OVER (ORDER BY head_leaf_group, medicinal_leaves_type, medicinal_leaf_species, head_leaf_group, year_edge, approved_date) seq
                        , PTPD_16_GRADE_REPLAC_HIS_R_V.*
                    ")
                    ->when($req->medicinal_leaves_type ?? false, function($q) use($req) {
                        $q->where('medicinal_leaves_type', $req->medicinal_leaves_type);
                    })
                    ->when($req->medicinal_leaf_species ?? false, function($q) use($req) {
                        $q->where('medicinal_leaf_species', $req->medicinal_leaf_species);
                    })
                    ->when($req->head_leaf_group ?? false, function($q) use($req) {
                        $q->where('head_leaf_group', $req->head_leaf_group);
                    })
                    // ->orderby('year_edge')
                    // ->orderBy('head_leaf_group')
                    ->orderby('history_dis_id')
                    ->get();


        $html = ' ';
        if (count($result)) {
            $result = $result->sortBy('seq');
            $html = view('pd.reports.PDR0006.index', compact('result'))->render();
        }

        $fileName = date('Y/m/d');

        return \PDF::loadHTML($html)
            ->setOption('header-html', view('pd.reports.PDR0006.header', compact('result'))->render())
            ->setOrientation('landscape')
            ->setOption('margin-top', 32)
            ->setOption('header-spacing', 5)
            // ->setOption('enable-javascript', true)
            // ->setOption('javascript-delay', 13500)
            // ->setOption('enable-smart-shrinking', true)
            // ->setOption('no-stop-slow-scripts', true)
            ->inline();
    }
}
