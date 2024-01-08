<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use PDO;

use App\Exports\CT\CTM0015;
use App\Exports\CT\CTR0006;
use App\Models\CT\CTM0015RPT;
use App\Models\CT\PtctCostCenterV;
use Carbon\Carbon;

class CTR0006Controller extends Controller
{
    const PROGRAME_CODE = 'CTR0006';

    public function getData($request)
    {
        $result = array();
        $db     = DB::connection('oracle')->getPdo();
        $date_to =  Carbon::createFromFormat('d/m/Y', $request['date_to'])->format("d-M-Y");
        $date_from = Carbon::createFromFormat('d/m/Y', $request['date_from'])->format("d-M-Y");
        $sql = "declare
                x_rpt_id number;
                begin
                    ptct_report_pkg.CTR0006 (P_YEAR  => '{$request['period_year']}'
                                    ,P_COST_CODE => '{$request['cost_code']}'
                                    ,P_DATE_FROM => '{$date_from}' 
                                    ,P_DATE_TO   => '{$date_to}'
                                    ,P_BATCH_NO_FROM  => '{$request['batch_from']}'
                                    ,P_BATCH_NO_TO  => '{$request['batch_to']}'
                                    ,P_ITEM_FROM   => '{$request['product_num_form']}'
                                    ,P_ITEM_TO   => '{$request['product_num_to']}'
                                    ,X_RPT_ID    => :x_rpt_id );
                end;
                ";
                $sql  = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':X_RPT_ID', $result['x_rpt_id'], PDO::PARAM_INT);
        $stmt->execute();
        // dd($result);
        // $datas = \DB::table('oact.ptct_CTR0006')->where('rpt_id', 4574)->get();
        $datas = \DB::table('oact.ptct_CTR0006')->where('rpt_id', $result['x_rpt_id'])->get();
        return $datas = collect($datas);
        //  ==========================================================================
    //     $conditionProductNum = '';
    //     $conditionBatch = '';
    //     if (!empty($request['product_num_form']) && !empty($request['product_num_to'])) {
    //         $conditionProductNum = " AND GBH.item_no BETWEEN '{$request['product_num_form']}' 
    //         AND '{$request['product_num_to']}' ";
    //     }
    //     if (!empty($request['batch_from']) && !empty($request['batch_to'])) {
    //         $conditionBatch = " AND CT.batch_no BETWEEN '{$request['batch_from']}' 
    //         AND '{$request['batch_to']}'  ";
    //     }
    //     $sql = "select CT.period_year, CT.cost_code, PTCG.cost_desc,CT.transaction_date ,
    //     org.organization_code ,org.organization_name,GBH.primary_unit_of_measure,
    //     GBH.item_no product_item_number, GBH.item_desc product_item_desc, GBH.primary_uom_code product_uom_code,
    //     CT.batch_id, CT.batch_no, CT.request_number, (select opt_plan_qty from PTPM_MES_REVIEW_ISSUE_HEADERS
    //                                                     where rownum = 1 and request_number = CT.request_number) opt_plan_qty,
    //     (select transaction_cost from ptct_cost_transactions
    //         where period_year = CT.period_year
    //             and batch_no = CT.batch_no
    //             and ct_group_code = 'CT_CS_STD_COST'
    //             and transaction_type = 'WIP Completion'
    //             and rownum = 1) opt_plan_cost,
    //     PTOR.oprn_class_desc,PTOR.oprn_desc,
    //     MFG.tobacco_group_code,MFG.tobacco_group,MFG.item_number,MFG.item_desc,
    //     CT.transaction_uom detail_uom,UOM.unit_of_measure th_detail_unit_of_measure,
    //     sum(decode(MFG.tobacco_group_code, '1080', 0, CT.transaction_quantity)) transaction_quantity, 
    //     MTT.actual_cost transaction_cost,
    //     sum(round(decode(MFG.tobacco_group_code, '1080', 0, CT.transaction_quantity) * MTT.actual_cost,2)) transaction_amount
    // from ptct_cost_transactions CT
    //     ,PTCT_SUMMARY_BATCH_V GBH
    //     ,ptpm_item_number_v MFG
    //     ,PTCT_CTM0018_G32_V PTCG
    //     ,PTPM_OPM_ROUTING_V PTOR
    //     ,MTL_UNITS_OF_MEASURE UOM
    //     ,org_organization_definitions org
    //     ,(select mca.actual_cost, MTTM.transaction_id
    //         from mtl_cst_actual_cost_details mca
    //         , MTL_MATERIAL_TRANSACTIONS MTTC
    //         , MTL_MATERIAL_TRANSACTIONS MTTM
    //         where MTTM.inventory_item_id = MTTC.inventory_item_id
    //             and MTTM.transaction_source_name = MTTC.transaction_source_name
    //             and MTTM.attribute14 = MTTC.source_line_id
    //             and MTTM.organization_id <> MTTC.organization_id
    //             and MTTC.transaction_id = mca.transaction_id) MTT
    // where 1=1
    //     and CT.organization_id  = GBH.organization_id
    //     and CT.batch_id         = GBH.batch_id
    
    //     and CT.inv_transaction_id   = MTT.transaction_id(+)
    //     and CT.organization_id      = MFG.organization_id
    //     and CT.inventory_item_id    = MFG.inventory_item_id
        
    //     and CT.cost_code        = PTCG.cost_code
    //     and GBH.item_no         = PTCG.product_item_number
    //     and CT.period_year      = PTCG.period_year
        
    //     and CT.transaction_uom = UOM.uom_code
    //     and CT.organization_id = org.organization_id
    //     and GBH.routing_id     = PTOR.routing_id
    //     and CT.wip_step        = PTOR.oprn_class_desc
        
    //     and PTCG.approved_status = 'Active'
    //     and ct.ct_group_code = 'CT_CS_ABSORBED' and ct.amount_type = 'DR'
    //     and CT.transaction_date is not null
    //     and CT.request_number is not null
    //     and CT.batch_id in (select BATCH_ID from PTPM_WIP_STEP_BY_BATCH_V)
        
    // --////////Parameter///////--
    //     and CT.period_year =  '{$request['period_year']}' 
    //     and TRUNC(CT.transaction_date) between TO_DATE('{$request['date_from']}', 'DD/MM/YYYY')  and TO_DATE('{$request['date_to']}', 'DD/MM/YYYY') 
    //     and CT.cost_code = '{$request['cost_code']}'
    //         {$conditionProductNum}
    //        {$conditionBatch}

    // --////////Parameter///////--
    // group by CT.period_year, CT.cost_code, PTCG.cost_desc,CT.transaction_date ,
    //     org.organization_code ,org.organization_name,
    //     GBH.item_no , GBH.item_desc , GBH.primary_uom_code ,
    //     CT.batch_id, CT.batch_no, CT.request_number,GBH.primary_unit_of_measure,
    //     PTOR.oprn_class_desc,PTOR.oprn_desc,
    //     MFG.tobacco_group_code,MFG.tobacco_group,MFG.item_number,MFG.item_desc,
    //     CT.transaction_uom ,UOM.unit_of_measure , MTT.actual_cost";

    //     $datas = \DB::select($sql);
    //     return $datas = collect($datas);
    }
    public function CTR0006EXCEL()
    {
        $request = request()->all();
        $datas = $this->getData(request()->all());
        // $datas = \DB::table('oact.ptct_CTR0006')->where('rpt_id', 941)->where('batch_no', '66MG601022')->get();
        // $datas = \DB::table('oact.ptct_CTR0006')->where('rpt_id', 1016)->get();

        if (request()->output == 'pdf') {

            $html = view('ct.Reports.ctr0006.pdf.index', compact('datas'))->render();
            $fileName = date('Y/m/d');
            return \PDF::loadHTML($html)
                ->setOption('page-size', 'A4')
                ->setOrientation('landscape')
                // ->setOption('header-html', view('ct.Reports.PDR0004.header')->render())
                ->setOption('header-right', "\n[page]/[toPage]   ")
                ->setOption('header-font-size', 9)
                ->setOption('margin-top', 1)
                ->setOption('margin-bottom', 2)
                ->setOption('margin-left', 2)
                ->setOption('margin-right', 2)
                ->setOption('header-spacing', '-7', '25')
                // ->setOption('enable-javascript', true)
                // ->setOption('javascript-delay', 13500)
                // ->setOption('enable-smart-shrinking', true)
                // ->setOption('no-stop-slow-scripts', true)
                ->inline();
        }
        // return (new CTR0006($datas))->view();
        return Excel::download(new CTR0006($datas), self::PROGRAME_CODE . '.xlsx');
    }
}
