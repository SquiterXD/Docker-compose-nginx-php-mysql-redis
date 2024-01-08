<?php

namespace App\Http\Controllers\OM\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OM\ARInvoiceReportTemp;
use App\Models\OM\ARReceiptInfReport;
use App\Models\OM\GLInterfacesReport;
use PDF;
use Illuminate\Support\Facades\DB;

class OMR0112Controller extends Controller
{
    public function export($programCode, Request $request)
    {
        $group_id = $request->group_id;
        $date = Carbon::parse($request->document_date);

        if(!$date){
           return abort('404'); 
        }
        
        $array_category = [
            '' => 'ไม่มีข้อมูล Category',
            'Invoice' => 'Web Sales Invoice',
            'Receipt' => 'Web Receipt',
            'Credit Memo' => 'Web Credit Note',
            'Debit Memo' => 'Web Debit Note',
            'WEB OP Sample' => 'WEB OP Sample',
            'WEB OP จำนวนบุหรี่ขาย' => 'WEB OP จำนวนบุหรี่ขาย',
            'WEB OP Sales Invoice' => 'WEB OP Sales Invoice',
        ];

        $reciept_flag = false;
        $max_line = 16;
        $page = 0;
        $data = [];

        $data_dr_reports = ARInvoiceReportTemp::select(DB::raw("   
            ptom_ar_invoice_report_temp.group_id,
            ptom_ar_invoice_report_temp.interface_type,
            ptom_ar_invoice_report_temp.gl_date as document_date,
            (case when ptom_ar_invoice_report_temp.interface_type = 'Invoice' then 
                (
                    select ptom_sales_invoice_line_num_v.lookup_code 
                    from ptom_sales_invoice_line_num_v 
                    where ptom_sales_invoice_line_num_v.meaning = ptom_ar_invoice_report_temp.rec_segment9
                )
            else
                null
            end) dr_order,
            (case when ptom_ar_invoice_report_temp.interface_type = 'Invoice' then 
                (
                    select ptom_sales_invoice_line_num_v.lookup_code 
                    from ptom_sales_invoice_line_num_v 
                    where ptom_sales_invoice_line_num_v.meaning = ptom_ar_invoice_report_temp.rev_segment9
                )
            else
                null
            end) cr_order,
            ptom_ar_invoice_report_temp.rec_account_combine as dr_account_combination,
            null as cr_account_combination,
            to_number(ptom_ar_invoice_report_temp.amount_before_tax) * nvl(ptom_ar_invoice_report_temp.exchange_rate, 1) as amount,
            ptom_ar_invoice_report_temp.from_program_code,
            (case when ptom_ar_invoice_report_temp.interface_type = 'Invoice' then 
                (
                    select distinct ptom_ar_invoice_report_temp.report_description || ptom_transaction_types_all_v.product_type
                    from ptom_transaction_types_all_v 
                    where ptom_transaction_types_all_v.receivables_transaction_type = ptom_ar_invoice_report_temp.transaction_type
                    and ptom_transaction_types_all_v.product_type is not null
                    and ROWNUM = 1
                )
            else
                ptom_ar_invoice_report_temp.report_description
            end) report_description,
            'THB' as currency,
            ptom_ar_invoice_report_temp.transaction_type
        "))
        ->whereRaw("
            1 = 1
            and ptom_ar_invoice_report_temp.gl_date = ?
            and batch_source_name = 'ระบบขายต่างประเทศ'
        ", [
            strtoupper($date->format('d-M-Y'))
        ])
        ->when($group_id, function ($q) use($group_id) {
            return $q->where('group_id', $group_id);
        });

        $data_cr_reports = ARInvoiceReportTemp::select(DB::raw("   
            ptom_ar_invoice_report_temp.group_id,
            ptom_ar_invoice_report_temp.interface_type,
            ptom_ar_invoice_report_temp.gl_date as document_date,
            (case when ptom_ar_invoice_report_temp.interface_type = 'Invoice' then 
                (
                    select ptom_sales_invoice_line_num_v.lookup_code 
                    from ptom_sales_invoice_line_num_v 
                    where ptom_sales_invoice_line_num_v.meaning = ptom_ar_invoice_report_temp.rec_segment9
                )
            else
                null
            end) dr_order,
            (case when ptom_ar_invoice_report_temp.interface_type = 'Invoice' then 
                (
                    select ptom_sales_invoice_line_num_v.lookup_code 
                    from ptom_sales_invoice_line_num_v 
                    where ptom_sales_invoice_line_num_v.meaning = ptom_ar_invoice_report_temp.rev_segment9
                )
            else
                null
            end) cr_order,
            null as dr_account_combination,
            ptom_ar_invoice_report_temp.rev_account_combine as cr_account_combination,
            to_number(ptom_ar_invoice_report_temp.amount_before_tax) * nvl(ptom_ar_invoice_report_temp.exchange_rate, 1) as amount,
            ptom_ar_invoice_report_temp.from_program_code,
            (case when ptom_ar_invoice_report_temp.interface_type = 'Invoice' then 
                (
                    select distinct ptom_ar_invoice_report_temp.report_description || ptom_transaction_types_all_v.product_type
                    from ptom_transaction_types_all_v 
                    where ptom_transaction_types_all_v.receivables_transaction_type = ptom_ar_invoice_report_temp.transaction_type
                    and ptom_transaction_types_all_v.product_type is not null
                    and ROWNUM = 1
                )
            else
                ptom_ar_invoice_report_temp.report_description
            end) report_description,
            'THB' as currency,
            ptom_ar_invoice_report_temp.transaction_type
        "))
        ->whereRaw("
            1 = 1
            and ptom_ar_invoice_report_temp.gl_date = ?
            and batch_source_name = 'ระบบขายต่างประเทศ'
        ", [
            strtoupper($date->format('d-M-Y'))
        ])
        ->when($group_id, function ($q) use($group_id) {
            return $q->where('group_id', $group_id);
        });

        // $data_tax_reports = ARInvoiceReportTemp::select(DB::raw("   
        //     ptom_ar_invoice_report_temp.group_id,
        //     ptom_ar_invoice_report_temp.interface_type,
        //     ptom_ar_invoice_report_temp.gl_date as document_date,
        //     (case when ptom_ar_invoice_report_temp.interface_type = 'Invoice' then 
        //         (
        //             select ptom_sales_invoice_line_num_v.lookup_code 
        //             from ptom_sales_invoice_line_num_v 
        //             where ptom_sales_invoice_line_num_v.meaning = ptom_ar_invoice_report_temp.rec_segment9
        //         )
        //     else
        //         null
        //     end) dr_order,
        //     (case when ptom_ar_invoice_report_temp.interface_type = 'Invoice' then 
        //         (
        //             select ptom_sales_invoice_line_num_v.lookup_code 
        //             from ptom_sales_invoice_line_num_v 
        //             where ptom_sales_invoice_line_num_v.meaning = ptom_ar_invoice_report_temp.rev_segment9
        //         )
        //     else
        //         null
        //     end) cr_order,
        //     null as dr_account_combination,
        //     ptom_ar_invoice_report_temp.tax_account_combine as cr_account_combination,
        //     to_number(ptom_ar_invoice_report_temp.tax_amount) as amount,
        //     ptom_ar_invoice_report_temp.from_program_code,
        //     (case when ptom_ar_invoice_report_temp.interface_type = 'Invoice' then 
        //         (
        //             select distinct ptom_ar_invoice_report_temp.report_description || ptom_transaction_types_all_v.product_type
        //             from ptom_transaction_types_all_v 
        //             where ptom_transaction_types_all_v.receivables_transaction_type = ptom_ar_invoice_report_temp.transaction_type
        //             and ptom_transaction_types_all_v.product_type is not null
        //             and ROWNUM = 1
        //         )
        //     else
        //         ptom_ar_invoice_report_temp.report_description
        //     end) report_description,
        //     ptom_ar_invoice_report_temp.currency,
        //     ptom_ar_invoice_report_temp.transaction_type
        // "))
        // ->whereRaw("
        //     1 = 1
        //     and ptom_ar_invoice_report_temp.gl_date = ?
        //     and batch_source_name = 'ระบบขายต่างประเทศ'
        // ", [
        //     strtoupper($date->format('d-M-Y'))
        // ])
        // ->when($group_id, function ($q) use($group_id) {
        //     return $q->where('group_id', $group_id);
        // });

        $receipt_reports = ARReceiptInfReport::select(DB::raw("   
            ptom_ar_receipt_inf_report.group_id,
            'Receipt' as interface_type,
            to_char(ptom_ar_receipt_inf_report.apply_gl_date, 'DD-MON-YYYY') as document_date,
            null dr_order,
            null cr_order,
            ptom_ar_receipt_inf_report.dr_account_combination,
            ptom_ar_receipt_inf_report.cr_account_combination,
            (case when ptom_ar_receipt_inf_report.apply_flag is null then 
                (case when ptom_ar_receipt_inf_report.trans_number is null then
                    ptom_ar_receipt_inf_report.receipt_amount * nvl(ptom_ar_receipt_inf_report.exchange_rate, 1)
                else 
                    0
                end)
            when ptom_ar_receipt_inf_report.apply_flag = 'N' then
                (case when ptom_ar_receipt_inf_report.trans_number is null then
                    0
                else 
                    ptom_ar_receipt_inf_report.amount_applied * nvl(ptom_ar_receipt_inf_report.exchange_rate, 1)
                end) 
            when ptom_ar_receipt_inf_report.apply_flag = 'Y' then
                (case when ptom_ar_receipt_inf_report.trans_number is null then
                    0
                else 
                    ptom_ar_receipt_inf_report.amount_applied * nvl(ptom_ar_receipt_inf_report.exchange_rate, 1)
                end) 
            when ptom_ar_receipt_inf_report.apply_flag = 'U' then
                (case when ptom_ar_receipt_inf_report.trans_number is null then
                    ptom_ar_receipt_inf_report.receipt_amount * nvl(ptom_ar_receipt_inf_report.exchange_rate, 1)
                else 
                    0
                end)
            end) amount,
            null as from_program_code,
            ptom_ar_receipt_inf_report.report_description,
            'THB' as currency,
            null transaction_type
        "))
        ->whereRaw("
            1 = 1
            and to_char(ptom_ar_receipt_inf_report.apply_gl_date, 'DD-MON-YYYY') = ?
            and receipt_class = 'ระบบขายต่างประเทศ'
        ", [
            strtoupper($date->format('d-M-Y'))
        ])
        ->when($group_id, function ($q) use($group_id) {
            return $q->where('group_id', $group_id);
        });

        $gl_reports = GLInterfacesReport::select(DB::raw("   
            ptom_gl_interfaces_report.group_id,
            ptom_gl_interfaces_report.user_je_category_name as interface_type,
            to_char(ptom_gl_interfaces_report.accounting_date, 'DD-MON-YYYY') as document_date,
            null as dr_order,
            null as cr_order,
            (case when ptom_gl_interfaces_report.entered_dr is not null then
                (ptom_gl_interfaces_report.segment1 || '.' || ptom_gl_interfaces_report.segment2 || '.' || ptom_gl_interfaces_report.segment3 || '.' || ptom_gl_interfaces_report.segment4 || '.' || ptom_gl_interfaces_report.segment5 || '.' || ptom_gl_interfaces_report.segment6 || '.' ||
                ptom_gl_interfaces_report.segment7 || '.' || ptom_gl_interfaces_report.segment8 || '.' || ptom_gl_interfaces_report.segment9 || '.' || ptom_gl_interfaces_report.segment10 || '.' || ptom_gl_interfaces_report.segment11 || '.' || ptom_gl_interfaces_report.segment12)
            else
                null
            end) dr_account_combination,
            (case when ptom_gl_interfaces_report.entered_cr is not null then
                (ptom_gl_interfaces_report.segment1 || '.' || ptom_gl_interfaces_report.segment2 || '.' || ptom_gl_interfaces_report.segment3 || '.' || ptom_gl_interfaces_report.segment4 || '.' || ptom_gl_interfaces_report.segment5 || '.' || ptom_gl_interfaces_report.segment6 || '.' ||
                ptom_gl_interfaces_report.segment7 || '.' || ptom_gl_interfaces_report.segment8 || '.' || ptom_gl_interfaces_report.segment9 || '.' || ptom_gl_interfaces_report.segment10 || '.' || ptom_gl_interfaces_report.segment11 || '.' || ptom_gl_interfaces_report.segment12)
            else
                null
            end) cr_account_combination,
            (case when ptom_gl_interfaces_report.entered_dr is not null then 
                ptom_gl_interfaces_report.entered_dr
            when entered_cr is not null then
                ptom_gl_interfaces_report.entered_cr
            else 
                0
            end) amount,
            null as from_program_code,
            ptom_gl_interfaces_report.journal_name as report_description,
            ptom_gl_interfaces_report.currency_code as currency,
            null transaction_type
        "))
        ->whereRaw("
            to_char(ptom_gl_interfaces_report.accounting_date, 'DD-MON-YYYY') = ?
            and program_code = 'OMP0078'
        ", [
            strtoupper($date->format('d-M-Y'))
        ])
        ->when($group_id, function ($q) use($group_id) {
            return $q->where('group_id', $group_id);
        });

        $query = $data_dr_reports
            ->unionAll($data_cr_reports)
            // ->unionAll($data_tax_reports)
            ->unionAll($receipt_reports)
            ->unionAll($gl_reports)
            ->orderByRaw("group_id asc, dr_order asc, cr_order asc, dr_account_combination asc, cr_account_combination asc, currency asc")
            ->get()
            ->groupBy('group_id');

        // dd($query);

        foreach ($query as $group_id => $items) {

            $invoices = $items->where('interface_type', 'Invoice')->groupBy('transaction_type');

            $receipts = $items->where('interface_type', 'Receipt');

            $credit_note = $items->where('interface_type', 'Credit Memo')->where('from_program_code', 'OMP0034');

            $credit_other = $items->where('interface_type', 'Credit Memo')->where('from_program_code', '!=', 'OMP0034');

            $debit_memo = $items->where('interface_type', 'Debit Memo');

            $op_sample = $items->where('interface_type', 'WEB OP Sample');

            $op_count = $items->where('interface_type', 'WEB OP จำนวนบุหรี่ขาย');

            $op_sale = $items->where('interface_type', 'WEB OP Sales Invoice');

            if($invoices->count()){
                foreach($invoices as $group => $items){
                    $set_data = $this->setDataReport($items, $data, $group_id, $page, $max_line, $array_category, false);
                    $data = $set_data['data'];
                    $page = $set_data['page'];
                }
            }

            if($receipts->count()){
                $reciept_flag = true;
                $set_data = $this->setDataReport($receipts, $data, $group_id, $page, $max_line, $array_category);
                $data = $set_data['data'];
                $page = $set_data['page'];
            }

            if($credit_note->count()){
                $set_data = $this->setDataReport($credit_note, $data, $group_id, $page, $max_line, $array_category);
                $data = $set_data['data'];
                $page = $set_data['page'];
            }

            if($credit_other->count()){
                $set_data = $this->setDataReport($credit_other, $data, $group_id, $page, $max_line, $array_category);
                $data = $set_data['data'];
                $page = $set_data['page'];
            }

            if($debit_memo->count()){
                $set_data = $this->setDataReport($debit_memo, $data, $group_id, $page, $max_line, $array_category);
                $data = $set_data['data'];
                $page = $set_data['page'];
            }

            if($op_sample->count()){
                $set_data = $this->setDataReport($op_sample, $data, $group_id, $page, $max_line, $array_category);
                $data = $set_data['data'];
                $page = $set_data['page'];
            }
            
            if($op_count->count()){
                $set_data = $this->setDataReport($op_count, $data, $group_id, $page, $max_line, $array_category);
                $data = $set_data['data'];
                $page = $set_data['page'];
            }

            if($op_sale->count()){
                $set_data = $this->setDataReport($op_sale, $data, $group_id, $page, $max_line, $array_category);
                $data = $set_data['data'];
                $page = $set_data['page'];
            }
        }

        $groupReceipts = ARReceiptInfReport::whereRaw("
            1 = 1
            and to_char(ptom_ar_receipt_inf_report.apply_gl_date, 'DD-MON-YYYY') = ?
            and receipt_class = 'ระบบขายต่างประเทศ'
        ", [
            strtoupper($date->format('d-M-Y'))
        ])
        ->when($group_id, function ($q) use($group_id) {
            return $q->where('group_id', $group_id);
        })
        ->orderBy("receipt_number")
        ->get()
        ->groupBy([
            function($item){
                return optional($item->payment)->payment_number ?? $item->receipt_number;
            }
        ]);

        $data_receipt = collect();

        foreach ($groupReceipts as $number => $items) {
            
            $reciept_flag = true;
            $groupFlag = $items->groupBy('apply_flag');
            if(isset($groupFlag[''])){
                $group = $groupFlag[''];
                $match = 'Y';
                $amount = $groupFlag['']->sum("receipt_amount");
            }
            if(isset($groupFlag['Y'])){
                $group = $groupFlag['Y'];
                $match = 'Y';
                $amount = $groupFlag['Y']->sum("amount_applied");
            }
            if(isset($groupFlag['N'])){
                $group = $groupFlag['N'];
                $match = 'N';
                $amount = $groupFlag['N']->sum("amount_applied");
            }
            if(isset($groupFlag['U'])){
                $group = $groupFlag['U'];
                $match = 'N';
                $amount = $groupFlag['U']->sum("receipt_amount");
            }

            if(!isset($data_receipt[$match])){
                $data_receipt[$match] = collect();
            }

            $data_receipt[$match][$number] = $amount;
        }

        // dd($data, $data_receipt);

        $pdf = PDF::loadView('om.reports.OMR0112._template', compact(
            'data',
            'date',
            'array_category',
            'reciept_flag',
            'data_receipt'
        ))
        ->setPaper('a4')
        ->setOrientation('landscape')
        ->setOption('margin-bottom', 0);

        return $pdf->stream('close-daily-sale.pdf');
    }

    private static function setDataReport($items, $array_data, $group_id, $current_page, $max_line, $array_category, $sort_key = true)
    {
        $data = $array_data;
        $page = $current_page;

        $array_segment9 = [];
        $check_combination = [];
        $pass_combination = [];

        $groupData = [];

        $groupCurrency = $items->groupBy('currency');
        //////// validate combination case receipt cancel in one day ////////

        foreach ($groupCurrency as $currency => $groups) {

            if(!array_key_exists($currency, $check_combination)){
                $check_combination[$currency] = [];
            }
            foreach($groups->sortBy('dr_order') as $item){

                if(!array_key_exists($item->report_description, $check_combination[$currency])){
                    $check_combination[$currency][$item->report_description] = [];
                }
                if(!array_key_exists($item->dr_account_combination, $check_combination[$currency][$item->report_description])){
                    $check_combination[$currency][$item->report_description][$item->dr_account_combination]['dr'] = (float)$item->amount;
                    $check_combination[$currency][$item->report_description][$item->dr_account_combination]['cr'] = 0;
                }else {
                    $check_combination[$currency][$item->report_description][$item->dr_account_combination]['dr'] += (float)$item->amount;
                }
            }
        }

        foreach ($groupCurrency as $currency => $groups) {

            if(!array_key_exists($currency, $check_combination)){
                $check_combination[$currency] = [];
            }
            foreach($groups->sortBy('cr_order')as $item){

                if(!array_key_exists($item->report_description, $check_combination[$currency])){
                    $check_combination[$currency][$item->report_description] = [];
                }
                if(!array_key_exists($item->cr_account_combination, $check_combination[$currency][$item->report_description])){
                    $check_combination[$currency][$item->report_description][$item->cr_account_combination]['dr'] = 0;
                    $check_combination[$currency][$item->report_description][$item->cr_account_combination]['cr'] = (float)$item->amount;
                }else {
                    $check_combination[$currency][$item->report_description][$item->cr_account_combination]['cr'] += (float)$item->amount;
                }
            }
        }

        foreach ($check_combination as $currency => $groupDesc) {

            if(!array_key_exists($currency, $groupData)){
                $groupData[$currency] = [];
                $groupData[$currency] = [];
            }

            foreach ($groupDesc as $desc => $groupCombination) {

                if($sort_key){
                    
                    $sorted = collect($groupCombination)->sortByDesc(function ($item, $key) {
                        $segments = explode(".", $key);
                        if( count($segments) != 12 ) return null;
                        return $segments[8];
                    });
                }else {
                    
                    $sorted = $groupCombination;
                }

                foreach ($sorted as $key => $combination) {

                    if(number_format($combination['dr'], 2) != number_format($combination['cr'], 2)){
                        $pass_combination[] = $key;

                        if( $combination['dr'] > $combination['cr'] ){
                            $groupData[$currency]['dr'][$key][$desc] = $combination['dr'] - $combination['cr'];
                        }else{
                            $groupData[$currency]['cr'][$key][$desc] = $combination['cr'] - $combination['dr'];
                        }
                    }
                }
            }
        }

        //////// calculate line number of account ////////

        foreach($groupData as $currency => $groupType) {
            krsort($groupType);
            foreach($groupType as $type => $groupAccount){
                foreach($groupAccount as $key => $groupDesc){
                    foreach($groupDesc as $desc => $amount){
                        $segments = explode(".", $key);
                        if( count($segments) != 12 ) continue;

                        if(!array_key_exists($currency, $array_segment9)){
                            $array_segment9[$currency] = [];
                        }

                        if( array_search($segments[8], $array_segment9) === false ){
                            $array_segment9[$currency][] = $segments[8];
                        }
                    }
                }
            
            }
        }

        if( count($pass_combination) ){

            $maxLine = $max_line;
            $page = $current_page+1;
            $line_num = 0;

            foreach($groupData as $currency => $groupType) {
                krsort($groupType);
                foreach($groupType as $type => $groupAccount){
                    foreach($groupAccount as $key => $groupDesc){
                        foreach($groupDesc as $desc => $amount){

                            $segments = explode(".", $key);
                            if( count($segments) != 12 ) continue;

                            // if($type === 'dr'){
                            //     $item = $items->where('dr_account_combination', $key)->first() ?? $items->where('cr_account_combination', $key)->first();
                            // }else {
                            //     $item = $items->where('cr_account_combination', $key)->first() ?? $items->where('dr_account_combination', $key)->first();
                            // }

                            if($line_num >= $maxLine){
                                $line_num = 0;
                                $page++;
                                $data[$page]['end_flag'] = false;
                            }

                            $data[$page]['category'] = $array_category[$item->interface_type];
                            $data[$page]['group_id'] = $group_id;

                            $line_no = array_search($segments[8], $array_segment9[$currency]);

                            if(!array_key_exists('lines', $data[$page])){
                                $data[$page]['lines'] = [];
                            }

                            if(!array_key_exists($currency, $data[$page]['lines'])){
                                $data[$page]['lines'][$currency] = [];
                            }

                            if(!array_key_exists($key, $data[$page]['lines'][$currency])){

                                $data[$page]['lines'][$currency][$key] = [];
                            }

                            if(!array_key_exists($desc, $data[$page]['lines'][$currency][$key])){

                                $des_seg1 = optional(\App\Models\IE\FNDListOfValues::where('flex_value_set_name', 'TOAT_GL_ACCT_CODE-COMPANY_CODE')
                                ->where('flex_value', $segments[0])->first())->description;
                                $des_seg9 = optional(\App\Models\IE\FNDListOfValues::where('flex_value_set_name', 'TOAT_GL_ACCT_CODE-MAIN_ACCOUNT')
                                ->where('flex_value', $segments[8])->first())->description;
                                $des_seg10 = optional(\App\Models\IE\FNDListOfValues::where('flex_value_set_name', 'TOAT_GL_ACCT_CODE-SUB_ACCOUNT')
                                ->where('parent_flex_value_low', $segments[8])
                                ->where('flex_value', $segments[9])->first())->description;

                                $data[$page]['lines'][$currency][$key][$desc]['line_num'] = $line_no+1;
                                $data[$page]['lines'][$currency][$key][$desc]['account_name'] = $des_seg1.'.'.$des_seg9.'.'.$des_seg10;
                                $data[$page]['lines'][$currency][$key][$desc]['debit_amount'] = $type === 'dr' ? $amount : 0;
                                $data[$page]['lines'][$currency][$key][$desc]['credit_amount'] = $type === 'cr' ? $amount : 0;
                                $data[$page]['lines'][$currency][$key][$desc]['report_description'] = $desc;
                                $line_num++;
                            }
                        }
                    }
                }
            }
        }

        return [
            'data' => $data,
            'page' => $page,
        ];
    }
}
