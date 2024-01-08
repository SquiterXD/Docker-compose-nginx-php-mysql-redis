<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\CTR0027;
use App\Exports\CT\CTR0028;
use App\Http\Controllers\Controller;
use App\Models\CT\PtctCTR0028;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CTR0028Controller extends Controller
{

    public function pkgCall($request) {
        $result = [];
        $dateFrom = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_from);
        $dateTo = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_to);
        $db     =  DB::connection('oracle')->getPdo();
       
        $sql = "declare
                X_RPT_ID number;
                begin
                    ptct_report_pkg.CTR0028 (P_YEAR  => '". $request->period_year ."'
                                    ,P_COST_CODE => '". $request->cost_code ."'
                                    ,P_DATE_FROM => '". $dateFrom->format('d-M-Y') ."' 
                                    ,P_DATE_TO   => '". $dateTo->format('d-M-Y') ."'
                                    ,P_BATCH_NO_FROM  => '" .$request->batch_from. "'
                                    ,P_BATCH_NO_TO  => '" .$request->batch_to. "'
                                    ,P_ITEM_FROM   => '" .$request->product_from. "'
                                    ,P_ITEM_TO   => '" .$request->product_to. "'
                                    ,X_RPT_ID    => :X_RPT_ID );

                commit;
                end;
                ";
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':x_rpt_id', $result['x_rpt_id'], \PDO::PARAM_INT, 11);
        $stmt->execute();
        DB::commit();
        return $result;
    }
    public function CTR0028EXCEL($programcode,Request $request) {
        $excecute = $this->pkgCall($request);
        $db = PtctCTR0028::where('rpt_id', $excecute['x_rpt_id'])->orderByRaw("toat_product_group_code, product_item_number, batch_no")->get();
        // $db = PtctCTR0028::where('rpt_id', 2322)
        //         ->orderByRaw("toat_description, batch_no, product_item_number")
        //         ->get();
        return Excel::download(new CTR0028($db, $request),  $programcode.'.xlsx');
        return (new CTR0028($db, $request))->view();
    }
}
