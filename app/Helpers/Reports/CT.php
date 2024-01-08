<?php
//CTRP0097
function ctDateText($dateFrom = null, $dateTo = null)
{
    // dd($dateFrom, $dateTo);
    if ($dateFrom == null || $dateTo == null) {
        return '';
    }
    // dd($dateFrom, $dateTo);
    $from   =  formatDateThai(\Carbon\Carbon::createFromFormat('d/m/Y', $dateFrom)->format('d-m-Y'));
    $to     =  formatDateThai(\Carbon\Carbon::createFromFormat('d/m/Y', $dateTo)->format('d-m-Y'));


    return 'ตั้งแต่วันที่ ' . $from . ' ถึง ' . $to;
}

function periodCT($period)
{
    $month =  getMonthTh(\Carbon\Carbon::createFromFormat('M-y', $period)->format('M'));
    $year = \Carbon\Carbon::createFromFormat('M-y', $period)->format('Y');

    $yearTh = (int)$year+543;

    return  $month. ' ' . $yearTh;
}


function transferCWip($wip, $batch_no, $date) {
    $sql = "select sum(CT.transaction_quantity * CT.transaction_cost) Amount
                ,(select sum(X.confirm_qty)
                    from PTPM_WIP_STEP_BY_BATCH_V X
                    where  CT.batch_id = X.batch_id
                        and nvl(CT.opt,'XX') = nvl(X.opt,'XX')
                        and trunc(CT.transaction_date) = trunc(X.transaction_date)
                    ) Qty
            from ptct_cost_transactions CT
            where CT.ct_group_code = 'CT_CS_ABSORBED' and ct.amount_type = 'DR'
                --////////Parameter///////--
                and CT.wip_step = '{$wip}'  --ขั้นตอน
                and CT.batch_id = '{$batch_no}' --เลขที่คำสั่งผลิต
                --////////Parameter///////--
                and CT.transaction_date = (select max(V.transaction_date)
                                        from PTPM_WIP_STEP_BY_BATCH_V V
                                        where V.batch_no = CT.batch_no
                                            --////////Parameter///////--
                                            and V.transaction_date <  to_date('{$date}','DD-MM-YYYY')   --ประจำวันที่ 
                                            --////////Parameter///////--
                                            and V.confirm_issue_qty > 0
                                            and V.wip_step = CT.wip_step
                                        )
            group by CT.batch_id, CT.opt, trunc(CT.transaction_date)
            ";

        return \DB::select($sql);
}

function sumTransactionQuantity($batchID, $wip, $dateFrom, $dateTo)
{   
    $dFrom = \Carbon\Carbon::createFromFormat('d/m/Y', $dateFrom)->format('Y-m-d');
    $tFrom = \Carbon\Carbon::createFromFormat('d/m/Y', $dateTo)->format('Y-m-d');
    // dd( $dFrom , $tFrom  , $wip , $batchID);
    $productV = App\Models\CT\PtmesProductWipV::
    // selectRaw("inv_convert.inv_um_convert_new(item_id => inventory_item_id,
    //                     precision => 2,
    //                     from_quantity =>  confirm_qty,
    //                     from_unit => plan_uom,
    //                     to_unit => 'CGK',
    //                     from_name => '',
    //                     to_name => '',
    //                     capacity_type => 'U') 
    //                     conv_transaction_quantity,
    //                     PTPM_WIP_STEP_BY_BATCH_V.*")
        whereRaw("trunc(transaction_date)  BETWEEN to_date('$dFrom', 'YYYY-MM-DD') and to_date('$tFrom', 'YYYY-MM-DD')")
        ->where('batch_id', $batchID)
        ->orderBy('transaction_date')
        ->where('wip_step', $wip)

        // ->whereDate('transaction_date', '>=', $dFrom)
        // ->whereDate('transaction_date', '<=', $tFrom)
        ->get();
    // dd($productV);

    return $productV->sum('confirm_qty');
    // dd($productV);
    // dd($batchID, $wip, $dateFrom , $dateTo);
}

function productWipV($batchID, $wip, $date)
{
    // dd($batchID, $date, $wip);
    // $date = \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d'); 

$productV = App\Models\CT\PtmesProductWipV::

                // selectRaw("inv_convert.inv_um_convert_new(item_id => inventory_item_id,
                //         precision => 2,
                //         from_quantity =>  confirm_qty,
                //         from_unit => plan_uom,
                //         to_unit => 'CGK',
                //         from_name => '',
                //         to_name => '',
                //         capacity_type => 'U') 
                //         conv_transaction_quantity,
                //         PTPM_WIP_STEP_BY_BATCH_V.*")
        where('batch_id', $batchID)
        ->orderBy('transaction_date')
        ->where('wip_step', $wip)
        ->whereRaw("trunc(transaction_date) = to_date('".$date."', 'YYYY-MM-DD')")
        // ->where('confirm_qty' , '!=' , 0)
        ->get();

        // dd( $productV , $batchID ,$wip);
    // dd($productV,  $date, $batchID ,$wip);
    if (!$productV) {
        return new App\Models\CT\PtmesProductWipV;
    }
    return $productV;
    // return $productV->sum('transaction_quantity'); 
}

function productWipBy09($fromDate, $toDate,$productItemNumber, $batchId=null)
{
    // dd( date('d-M-y', strtotime($toDate)));
    $dFrom = \Carbon\Carbon::createFromFormat('d/m/Y', $fromDate)->format('d-M-y'); 
    $dTo = \Carbon\Carbon::createFromFormat('d/m/Y', $toDate)->format('d-M-y'); 


    // dd($fromDate, $toDate,$productItemNumber, $batchId);
    // dd($fromDate, $toDate,$productItemNumber, $batchId);
    if($batchId){
        // $sql =  collect(\DB::select("
        // select sum(x.transaction_quantity) sum_qty from PTMES_PRODUCT_WIP_V x
        // where x.item_code =  '$productItemNumber'
        // where x.batch_id =  '$batchId'
        //     and to_date(x.transaction_date) BETWEEN to_date('$dFrom', 'DD-Mon-YY') and to_date('$dTo', 'DD-Mon-YY')
        //     and x.wip_step in (select min(v.wip_step)
        //                     from PTMES_PRODUCT_WIP_V v
        //                     where v.batch_no = x.batch_no)"));

        // dd($fromDate, $toDate,$productItemNumber, $batchId);
    $sql =  collect(\DB::select("select sum(x.confirm_qty) sum_qty 
                from PTPM_WIP_STEP_BY_BATCH_V x
            where x.item_number =  '$productItemNumber'
            and x.batch_id =  '$batchId'
            and to_date(x.transaction_date) BETWEEN to_date('$dFrom', 'DD-Mon-YY') and to_date('$dTo', 'DD-Mon-YY')
            and x.wip_step in (select min(v.wip_step)
                from PTPM_WIP_STEP_BY_BATCH_V v
                where v.batch_no = x.batch_no)"));


    } else {
        // dd('xxxxxxxxxxxxxxx');
        // $sql =  collect(\DB::select("
        // select sum(x.transaction_quantity) sum_qty from PTMES_PRODUCT_WIP_V x
        // where x.item_code =  '$productItemNumber'
        //     and to_date(x.transaction_date) BETWEEN to_date('$dFrom', 'DD-Mon-YY') and to_date('$dTo', 'DD-Mon-YY')
        //     and x.wip_step in (select min(v.wip_step)
        //                     from PTMES_PRODUCT_WIP_V v
        //                     where v.batch_no = x.batch_no)"));

        $sql =  collect(\DB::select("select sum(x.confirm_qty) sum_qty 
                    from PTPM_WIP_STEP_BY_BATCH_V x
                where x.item_number =  '$productItemNumber'
                and to_date(x.transaction_date) BETWEEN to_date('$dFrom', 'DD-Mon-YY') and to_date('$dTo', 'DD-Mon-YY')
                and x.wip_step in (select min(v.wip_step)
                    from PTPM_WIP_STEP_BY_BATCH_V v
                    where v.batch_no = x.batch_no)"));
        

    }


    return $sql->sum('sum_qty'); 

}



function output($dateFrom, $dateTo, $costCode, $period , $batchNo=null)
{   
    // dd($batchNo);
    $from  = strtoupper(Carbon\Carbon::createFromFormat('d/m/Y', $dateFrom)->format('Y-m-d'));
    $to = strtoupper(Carbon\Carbon::createFromFormat('d/m/Y', $dateTo)->format('Y-m-d'));


    $tran =  App\Models\CT\PtctCostTransaction::
                // whereDate('transaction_date', '>=', $from )
                // ->whereDate('transaction_date', '<=', $to )
                when($batchNo, function($q) use ($batchNo) {
                    $q->where('batch_no' ,$batchNo);
                })
                ->whereRaw("trunc(transaction_date) BETWEEN  to_date('".$from."', 'YYYY-MM-DD')  AND to_date('".$to."', 'YYYY-MM-DD')")
                ->where('period_year', $period)
                ->where('cost_code', $costCode)
                ->where('transaction_type', 'WIP Completion')
                ->get()
                ;
        // dd($tran , $from ,$to , $batchNo , $period , $costCode);
    
    return $tran->sum('transaction_quantity');
}

function outputByProduct($dateFrom, $dateTo, $costCode, $period , $batchNos)
{   
    // dd($batchNos);
    $from  = strtoupper(Carbon\Carbon::createFromFormat('d/m/Y', $dateFrom)->format('Y-m-d'));
    $to = strtoupper(Carbon\Carbon::createFromFormat('d/m/Y', $dateTo)->format('Y-m-d'));


    $tran =  App\Models\CT\PtctCostTransaction::
                // whereDate('transaction_date', '>=', $from )
                // ->whereDate('transaction_date', '<=', $to )
                when(!!$batchNos, function($q) use ($batchNos) {
                    $q->whereIn('batch_no' ,$batchNos);
                })
                ->whereRaw("trunc(transaction_date) BETWEEN  to_date('".$from."', 'YYYY-MM-DD')  AND to_date('".$to."', 'YYYY-MM-DD')")
                ->where('period_year', $period)
                ->where('cost_code', $costCode)
                ->where('transaction_type', 'WIP Completion')
                ->get()
                ;
        // dd($tran , $from ,$to , $batchNo , $period , $costCode);
    
    return $tran->sum('transaction_quantity');
}


function costCenter($costCode)
{
    $cost =  App\Models\CT\PtctCostCenterV::where('cost_code' , $costCode)
        ->first();

        if($cost){
            return $cost;
        }

        return new App\Models\CT\PtctCostCenterV;
}
