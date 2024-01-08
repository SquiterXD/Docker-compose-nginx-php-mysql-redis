<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\CT\PtctMfgBatchGenWipend;
use App\Models\CT\MFGJobGenWipendTmp;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Arr;
use DB;
use PDO;

class CTR007310 implements FromView, ShouldAutoSize, WithColumnFormatting

{
    public function columnFormats(): array
    {
        return [
            'B' => '#,##0.000000000',
            'C' => '#,##0.000000000',
            'D' => '#,##0.000000000',
            'E' => '#,##0.000000000',
            'F' => '#,##0.000000000',
            'G' => '#,##0.000000000'
        ];
    }

    public function view(): View
    {
        $request        = request()->all();
        $year           = Arr::get($request, 'year');
        $ct_cc          = Arr::get($request, 'ct_cc');
        $start_date     = Arr::get($request, 'start_date');
        $end_date       = Arr::get($request, 'end_date');
        $ct_dept_code   = Arr::get($request, 'ct_dept_code');
        $ct_batch_id    = Arr::get($request, 'ct_batch_id');
        $program_code   = Arr::get($request, 'program_code');
        // $apIn = PtctMfgBatchGenWipend::selectRaw("  to_number(REPLACE(ct_dm_aq_inwip,',','')) ct_dm_aq_inwip, 
        //                                             ct_batch_no, 
        //                                             ct_dept_code,
        //                                             ct_dept_name,
        //                                             TRUNC(to_date(ct_accounting_date, 'DD-Mon-YY')) ct_accounting_date, 
        //                                             ct_product_code,
        //                                             ct_product_name,
        //                                             ct_wip_code, 
        //                                             ct_wip_name,
        //                                             to_number(REPLACE(ct_prd_aq_wipbegin,',','')) ct_prd_aq_wipbegin,
        //                                             ct_dm_aqsp_wipbegin, 
        //                                             to_number(REPLACE(ct_dl_aqsp_wipbegin,',','')) ct_dl_aqsp_wipbegin,
        //                                             to_number(REPLACE(ct_voh_aqsp_wipbegin,',','')) ct_voh_aqsp_wipbegin, 
        //                                             to_number(REPLACE(ct_foh_aqsp_wipbegin,',','')) ct_foh_aqsp_wipbegin,
        //                                             to_number(REPLACE(ct_voh_aqsp_issue,',','')) ct_voh_aqsp_issue, 
        //                                             ct_dm_group,
        //                                             ct_dm_group_name,
        //                                             ct_percent_finish_dl_rate,
        //                                             ct_percent_finish_voh_rate,
        //                                             ct_percent_finish_foh_rate,
        //                                             ct_percent_finish_dl,
        //                                             ct_percent_finish_voh,
        //                                             ct_percent_finish_foh,
        //                                             to_number(REPLACE(ct_dm_aqsp_inwip,',','')) ct_dm_aqsp_inwip,
        //                                             to_number(REPLACE(ct_prd_aq_loss,',','')) ct_prd_aq_loss,
        //                                             to_number(REPLACE(ct_prd_aq_inwip,',','')) ct_prd_aq_inwip,
        //                                             to_number(REPLACE(ct_prd_aq_issue,',','')) ct_prd_aq_issue, 
        //                                             ct_cc_code,
        //                                             ct_cc_id,
        //                                             to_number(REPLACE(ct_dl_aqsp_inwip,',','')) ct_dl_aqsp_inwip,
        //                                             to_number(REPLACE(ct_voh_aqsp_inwip,',','')) ct_voh_aqsp_inwip,
        //                                             to_number(REPLACE(ct_foh_aqsp_inwip,',','')) ct_foh_aqsp_inwip,
        //                                             to_number(REPLACE(ct_dl_aqsp_total,',','')) ct_dl_aqsp_total, 
        //                                             to_number(REPLACE(ct_voh_aqsp_total,',','')) ct_voh_aqsp_total, 
        //                                             to_number(REPLACE(ct_foh_aqsp_total,',','')) ct_foh_aqsp_total,
        //                                             to_number(REPLACE(ct_dl_aqsp_issue,',','')) ct_dl_aqsp_issue,
        //                                             to_number(REPLACE(ct_foh_aqsp_issue,',','')) ct_foh_aqsp_issue,
        //                                             to_number(REPLACE(ct_dl_aqsp_wipend,',','')) ct_dl_aqsp_wipend,
        //                                             to_number(REPLACE(ct_voh_aqsp_wipend,',','')) ct_voh_aqsp_wipend,
        //                                             to_number(REPLACE(ct_foh_aqsp_wipend,',','')) ct_foh_aqsp_wipend,
        //                                             to_number(REPLACE(ct_prev_wip_prd_aq_issue,',','')) ct_prev_wip_prd_aq_issue,
        //                                             to_number(REPLACE(ct_prev_wip_dm_aqsp_issue,',','')) ct_prev_wip_dm_aqsp_issue,
        //                                             to_number(REPLACE(ct_prev_wip_dl_aqsp_issue,',','')) ct_prev_wip_dl_aqsp_issue,
        //                                             to_number(REPLACE(ct_prev_wip_voh_aqsp_issue,',','')) ct_prev_wip_voh_aqsp_issue,
        //                                             to_number(REPLACE(ct_prev_wip_foh_aqsp_issue,',','')) ct_prev_wip_foh_aqsp_issue,
        //                                             ct_prev_wip_code           ")
        //                             ->where('ct_batch_id', $ct_batch_id)
        //                             ->whereNotNull('ct_accounting_date')
        //                             ->where('ct_cc_code', $ct_cc)
        //                             ->where('ct_dept_code', $ct_dept_code)   
        //                             ->whereRaw(" to_date(ct_accounting_date, 'DD-Mon-YY') BETWEEN to_date('$start_date', 'DD/MM/yyyy') AND to_date('$end_date', 'DD/MM/yyyy') ")
        //                             ->whereRaw(" transaction_id > 317 ")
        //                             ->get();
        // $CTBatchNoShow  = $apIn->groupBy('ct_batch_no')->keys()->first();
        // $CTDeptCodeShow = $apIn->groupBy('ct_dept_code')->keys()->first();
        // $CTDeptNameShow = $apIn->groupBy('ct_dept_name')->keys()->first();
        // $CTProductCode  = $apIn->groupBy('ct_product_code')->keys()->first();
        // $CTProductName  = $apIn->groupBy('ct_product_name')->keys()->first();

        // dd($CTBatchNoShow, $CTDeptCodeShow, $CTDeptNameShow, $CTProductCode, $CTProductName);

        // return  view('ct.reports.ctr007310.excel.index', 
        //         compact('apIn', 'CTBatchNoShow', 'CTDeptCodeShow', 'CTDeptNameShow',
        //                 'CTProductCode', 'CTProductName'));

        ################ New ################

        // $db     =   DB::connection('oracle')->getPdo();
        // $sql    =   "
        //                 declare
        //                 v_status         varchar2(5);
        //                 v_err_msg        varchar2(2000);
        //                 begin
                        
        //                 PTPM_MICS_PKG.COST_REPORT_INS_TEMP( p_batch_no_from         => '{$ct_batch_id}'
        //                                                     ,p_batch_no_to          =>  null
        //                                                     ,p_date_from            => '{$start_date}'
        //                                                     ,p_date_to              => '{$end_date}'
        //                                                     ,p_year                 => '{$year}'
        //                                                     ,p_cost_center          => '{$ct_cc}'
        //                                                     ,p_department           => '{$ct_dept_code}'
        //                                                     );
                        
        //                 end;
        //             ";

        $CTList = MFGJobGenWipendTmp::get();
        $CTBatchNoShow  = $CTList->groupBy('ct_batch_no')->keys()->first();
        $CTDeptCodeShow = $CTList->groupBy('ct_dept_code')->keys()->first();
        $CTDeptNameShow = $CTList->groupBy('ct_dept_name')->keys()->first();
        $CTProductCode  = $CTList->groupBy('ct_product_code')->keys()->first();
        $CTProductName  = $CTList->groupBy('ct_product_name')->keys()->first();
        $dateNowTh      = parseToDateTh(now());

        return  view('ct.reports.ctr007310.excel.index', 
                compact('CTList', 
                        'CTBatchNoShow', 
                        'CTDeptCodeShow', 
                        'CTDeptNameShow',
                        'CTProductCode', 
                        'CTProductName',
                        'dateNowTh'));
    }

}
