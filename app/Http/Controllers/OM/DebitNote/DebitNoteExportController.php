<?php

namespace App\Http\Controllers\OM\DebitNote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OM\DebitNote\DebitNoteModel;
use App\Models\OM\DebitNote\DebitNoteLineModel;
use App\Models\OM\DebitNote\DebitTypeModel;
use App\Models\OM\DebitNote\CountyModel;
use App\Models\OM\CreditNote\AccountsMappingModel;
use App\Models\OM\CreditNote\MappingAccountModel;
use App\Models\OM\CreditNote\PeriodModel;
use App\Models\OM\CreditNote\CurrencyModel;
use App\Models\OM\DebitNote\DebitTypeExportModel;
use App\Models\OM\DebitNote\CustomerModel;
use App\Models\OM\DebitNote\ProformaInvoiceModel;
use App\Models\OM\DebitNote\ProformaInvoiceLineModel;

// ptgl
use App\Models\OM\CreditNote\Ptgl\CoaCompanyVModel;
use App\Models\OM\CreditNote\Ptgl\CoaEvmVModel;
use App\Models\OM\CreditNote\Ptgl\CoaDeptCodeVModel;
use App\Models\OM\CreditNote\Ptgl\CoaCostCenterVModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetYearVModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetTypeVModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetDetailVModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetReasonVModel;
use App\Models\OM\CreditNote\Ptgl\CoaMainAccountVModel;
use App\Models\OM\CreditNote\Ptgl\CoaSubAccountVModel;
use App\Models\OM\CreditNote\Ptgl\CoaReserved1VModel;
use App\Models\OM\CreditNote\Ptgl\CoaReserved2VModel;

class DebitNoteExportController extends Controller
{
    public function index()
    {
        $list  = DebitNoteModel::where('program_code','OMP0076')->orderBy('creation_date','desc')->get();

        $segment = [
            'company' => CoaCompanyVModel::where('company_code','01')->get(),
            'evm' => CoaEvmVModel::get(),
            'dept' => CoaDeptCodeVModel::get(),
            'costCenter' => CoaCostCenterVModel::get(),
            'budgetYear' => CoaBudgetYearVModel::get(),
            'budgetType' => CoaBudgetTypeVModel::get(),
            'budgetDetail' => CoaBudgetDetailVModel::get(),
            'budgetReason' => CoaBudgetReasonVModel::get(),
            'mainAccount' => CoaMainAccountVModel::get(),
            'subAccount' => CoaSubAccountVModel::get(),
            'reserved1' => CoaReserved1VModel::get(),
            'reserved2' => CoaReserved2VModel::get()
        ];

        $accont_gl      = MappingAccountModel::where('account_code','27')->first();
        $accont_cr_gl   = MappingAccountModel::where('account_code','06')->first();
        $county         = CountyModel::get();
        $currency       = CurrencyModel::get();

        $period     = PeriodModel::where('start_period','<=',date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('end_period','>=',date('Y-m-d'));
                                        $query->orWhereNull('end_period');
                                    })->first();

        // $budget_year = $period->budget_year + 543;
        // $buget_year_segment =  substr($budget_year,-2);

        if(!empty($period->budget_year)){
            $buget_year_segment = $period->budget_year + 543;
        }else{
            $buget_year_segment = date('Y') + 543;
        }

        $account_list = AccountsMappingModel::select('ptom_accounts_mapping_v.*','ptom_mapping_account_code_gl.account_combine_desc')
                                            ->leftJoin('ptom_mapping_account_code_gl','ptom_mapping_account_code_gl.account_code','=','ptom_accounts_mapping_v.account_code')
                                            ->get();
        foreach($account_list as $acc_item){
            $account_mapping[$acc_item->account_code] = [
                'account_code'          => $acc_item->account_code,
                'account_combine'       => $acc_item->account_combine,
                'account_description'   => $acc_item->account_description,
                'combine_desc'          => $acc_item->account_combine_desc,
            ];
        }

        $debittype  = DebitTypeExportModel::where('enabled_flag','Y')
                                    ->where('start_date_active','<=',date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('end_date_active','>=',date('Y-m-d'));
                                        $query->orWhereNull('end_date_active');
                                    })
                                    ->get();

        return view('om.debitnote.index_export',\compact('segment','accont_gl','buget_year_segment','account_mapping','debittype','accont_cr_gl','county','currency','list'));
    }

    public function report(Request $request)
    {
        $dataInvoice   = DebitNoteModel::where('invoice_type','DN')
                                    ->where('invoice_headers_number',$request->number)
                                    ->first();
        $customer                   = CustomerModel::where('customer_id',$dataInvoice->customer_id)->first();

        $orderinvoice_line = DebitNoteLineModel::where('invoice_headers_id',$dataInvoice->invoice_headers_id)->get();
        $invoice_line['total'] = 0;
        foreach($orderinvoice_line as $invoiceline_item){
            $invoice_line['line'][$invoiceline_item->document_line_id] = [
                'diff'      => $invoiceline_item->diff_amount,
                'id'        => $invoiceline_item->invoice_line_id,
                'quantity'  => $invoiceline_item->quantity,
            ];
            $invoice_line['total'] += $invoiceline_item->diff_amount;
        }
        $company    = DB::table('ptom_toat_address_v')->first();

        $match_invoice = DB::table('ptom_payment_match_invoices')
                            ->leftJoin('ptom_payment_headers','ptom_payment_headers.payment_header_id','=','ptom_payment_match_invoices.payment_header_id')
                            ->where('ptom_payment_match_invoices.match_flag','Y')
                            ->where('ptom_payment_match_invoices.invoice_id',$dataInvoice->invoice_headers_id)
                            ->get();
        if($match_invoice->count() > 0){
            foreach($match_invoice as $mi_item){
                $payment['number'][] = $mi_item->payment_number;
                $payment['date'] = $mi_item->payment_date;
            }

            $payment['number'] = implode(',', $payment['number']);
        }else{
            $payment = false;
        }
        if(!empty($dataInvoice->document_id)){
            $orderheader    = ProformaInvoiceModel::where('pi_header_id',$dataInvoice->document_id)->first();
            $order          = DB::table('ptom_order_headers')->where('order_header_id',$orderheader->order_header_id)->first();
            $orderline      = ProformaInvoiceLineModel::where('pi_header_id',$orderheader->pi_header_id)->get();
            $data['total']  = 0;
            foreach($orderline as $key_line => $orderline_item){
                $uom = DB::table('ptom_uom_v')->where('uom_code',$orderline_item->uom_code)->first();
                $data['line'][] = [
                    'id'                    => $orderline_item->pi_line_id,
                    'number'                => $orderline_item->line_number,
                    'description'           => $orderline_item->item_description,
                    'quantity'              => !empty($invoice_line['line'][$orderline_item->pi_line_id])? number_format($invoice_line['line'][$orderline_item->pi_line_id]['quantity'],2) : number_format(0,2),
                    'uom_description'       => $uom->description,
                    'price_unit'            => $orderline_item->unit_price + $invoice_line['line'][$orderline_item->pi_line_id]['diff'],
                    'total'                 => $invoice_line['line'][$orderline_item->pi_line_id]['quantity'] * ($orderline_item->unit_price + $invoice_line['line'][$orderline_item->pi_line_id]['diff'])
                ];

                $data['total'] +=  $invoice_line['line'][$orderline_item->pi_line_id]['quantity'] * ($orderline_item->unit_price + $invoice_line['line'][$orderline_item->pi_line_id]['diff']);
            }
            $data['tax'] = $data['total'] * (7 / 100);
            $data['sumary'] =  $data['total'] + $data['tax'];
        }else{
            $data = [];
        }


        return view('om.debitnote.report_export',compact('dataInvoice','company','customer','invoice_line','payment','data','order'));
    }
}