<?php

namespace App\Http\Controllers\OM\DebitNote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OM\DebitNote\DebitTypeModel;
use App\Models\OM\CreditNote\AccountsMappingModel;
use App\Models\OM\CreditNote\MappingAccountModel;
use App\Models\OM\CreditNote\PeriodModel;
use App\Models\OM\DebitNote\DebitNoteModel;
use App\Models\OM\DebitNote\CustomerModel;
use App\Models\OM\DebitNote\OrderHeaderModel;
use App\Models\OM\DebitNote\DebitNoteLineModel;
use App\Models\OM\DebitNote\ConsigmentHeadersModel;
use App\Models\OM\DebitNote\OrderLineModel;

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

class DebitNoteController extends Controller
{
    public function index()
    {
        $list  = DebitNoteModel::where('program_code','OMP0032')->orderBy('creation_date','desc')->get();

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

        $accont_gl      = MappingAccountModel::where('account_code','09')->first();
        $accont_cr_gl   = MappingAccountModel::where('account_code','06')->first();

        $period     = PeriodModel::where('start_period','<=',date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('end_period','>=',date('Y-m-d'));
                                        $query->orWhereNull('end_period');
                                    })->first();
        
        if(!empty($period->budget_year)){
            $budget_year = $period->budget_year + 543;
        }else{
            $budget_year = date('Y') + 543;
        }
      
        $buget_year_segment =  substr($budget_year,-2);

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

        $debittype  = DebitTypeModel::where('enabled_flag','Y')
                                    ->where('start_date_active','<=',date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('end_date_active','>=',date('Y-m-d'));
                                        $query->orWhereNull('end_date_active');
                                    })
                                    ->get();

        return view('om.debitnote.index',\compact('segment','accont_gl','buget_year_segment','account_mapping','debittype','accont_cr_gl','list'));
    }

    public function report(Request $request)
    {
        $dataInvoice       = DebitNoteModel::where('invoice_type','DN')
                                ->where('invoice_headers_number',$request->number)
                                ->first();

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
        $customer   = CustomerModel::where('customer_id',$dataInvoice->customer_id)->first();

        if(!empty($dataInvoice->document_id)){
            if($customer->customer_type_id != '30' && $customer->customer_type_id != '40'){ // ลูกค้าที่ไม่ได้เป็นสโมสร
                $orderheader            = OrderHeaderModel::where('order_header_id',$dataInvoice->document_id)->first();
                $header_table_group     = DB::table('ptom_list_headers')
                                            ->where('price_list_header_id',$orderheader->price_list_id)->first(); 
                $header_table_sale      = DB::table('ptom_list_headers')
                                                ->where('name','ราคาขายปลีก')
                                                ->where('active_flag','Y')
                                                ->where('effective_dates_from','<=',date('Y-m-d'))
                                                ->where(function($query){
                                                    $query->where('effective_dates_to','>=',date('Y-m-d'));
                                                    $query->orWhereNull('effective_dates_to');
                                                })
                                                ->first(); 
                
                $data['header'] = [
                    'id'                => $orderheader->order_header_id,
                    'number'            => $orderheader->order_number,
                    'approve_date'      => $orderheader->pick_release_approve_date,
                    'header_group'      => $header_table_group->name,
                    'header_group_sub'  => $header_table_group->comments,
                    'header_sale_sub'   => $header_table_sale->comments
                ];
                $data['total_old_group'] = 0;
                $data['total_new_group'] = 0;
                $data['total_old_sale'] = 0;
                $data['total_new_sale'] = 0;
                
                $orderline      = OrderLineModel::where('order_header_id',$orderheader->order_header_id)->get();
                foreach($orderline as $key_line => $orderline){
                    $data['line'][] = [
                        'id'                    => $orderline->order_line_id,
                        'item_id'               => $orderline->item_id,
                        'description'           => $orderline->item_description,
                        'old_price_group'       => $orderline->unit_price,
                        'new_price_group'       => $orderline->unit_price + $invoice_line['line'][$orderline->order_line_id]['diff'],
                        'old_price_sale'        => $orderline->attribute1,
                        'new_price_sale'        => $orderline->attribute1 + $invoice_line['line'][$orderline->order_line_id]['diff'],
                        'approve_total'         => $invoice_line['line'][$orderline->order_line_id]['quantity']
                    ];
                    $data['total_old_group'] += $invoice_line['line'][$orderline->order_line_id]['quantity'] * $orderline->unit_price;
                    $data['total_new_group'] += $invoice_line['line'][$orderline->order_line_id]['quantity'] * ($orderline->unit_price + $invoice_line['line'][$orderline->order_line_id]['diff']);
                    $data['total_old_sale']  += $invoice_line['line'][$orderline->order_line_id]['quantity'] * $orderline->attribute1;
                    $data['total_new_sale']  += $invoice_line['line'][$orderline->order_line_id]['quantity'] * ($orderline->attribute1 + $invoice_line['line'][$orderline->order_line_id]['diff']);
                }

                $data['diff_group'] = $data['total_new_group'] - $data['total_old_group'];
                $data['diff_sale'] = $data['total_new_sale'] - $data['total_old_sale'];

                $tax_rate = DB::table('ptom_transaction_types_all_v')->where('order_type_id', $orderheader->order_type_id)->first();
                $data['tax_group'] = $data['diff_group'] *  $tax_rate->tax_rate / (100 +  $tax_rate->tax_rate );
                $data['tax_sale'] = $data['diff_sale'] *  $tax_rate->tax_rate / (100 +  $tax_rate->tax_rate );
                $data['outvat_tax_group'] =  $data['diff_group'] - $data['tax_group'];
                $data['outvat_tax_sale'] = $data['diff_sale'] - $data['tax_sale'];
            }else{
                $consigeheader    = ConsigmentHeadersModel::where('consignment_header_id',$dataInvoice->document_id)->first();
                $orderheader            = OrderHeaderModel::where('order_header_id',$consigeheader->order_header_id)->first();
                $header_table_group     = DB::table('ptom_list_headers')
                                            ->where('price_list_header_id',$orderheader->price_list_id)->first(); 
                $header_table_sale      = DB::table('ptom_list_headers')
                                                ->where('name','ราคาขายปลีก')
                                                ->where('active_flag','Y')
                                                ->where('effective_dates_from','<=',date('Y-m-d'))
                                                ->where(function($query){
                                                    $query->where('effective_dates_to','>=',date('Y-m-d'));
                                                    $query->orWhereNull('effective_dates_to');
                                                })
                                                ->first(); 
                
                $data['header'] = [
                    'id'                => $orderheader->order_header_id,
                    'number'            => $orderheader->order_number,
                    'approve_date'      => $orderheader->pick_release_approve_date,
                    'header_group'      => $header_table_group->name,
                    'header_group_sub'  => $header_table_group->comments,
                    'header_sale_sub'   => $header_table_sale->comments
                ];
                $data['total_old_group'] = 0;
                $data['total_new_group'] = 0;
                $data['total_old_sale'] = 0;
                $data['total_new_sale'] = 0;
                
                $orderline      = OrderLineModel::where('order_header_id',$orderheader->order_header_id)->get();
                foreach($orderline as $key_line => $orderline){
                    $data['line'][] = [
                        'id'                    => $orderline->order_line_id,
                        'item_id'               => $orderline->item_id,
                        'description'           => $orderline->item_description,
                        'old_price_group'       => $orderline->unit_price,
                        'new_price_group'       => $orderline->unit_price + $invoice_line['line'][$orderline->order_line_id]['diff'],
                        'old_price_sale'        => $orderline->attribute1,
                        'new_price_sale'        => $orderline->attribute1 + $invoice_line['line'][$orderline->order_line_id]['diff'],
                        'approve_total'         => $invoice_line['line'][$orderline->order_line_id]['quantity']
                    ];
                    $data['total_old_group'] += $invoice_line['line'][$orderline->order_line_id]['quantity'] * $orderline->unit_price;
                    $data['total_new_group'] += $invoice_line['line'][$orderline->order_line_id]['quantity'] * ($orderline->unit_price + $invoice_line['line'][$orderline->order_line_id]['diff']);
                    $data['total_old_sale']  += $invoice_line['line'][$orderline->order_line_id]['quantity'] * $orderline->attribute1;
                    $data['total_new_sale']  += $invoice_line['line'][$orderline->order_line_id]['quantity'] * ($orderline->attribute1 + $invoice_line['line'][$orderline->order_line_id]['diff']);
                }

                $data['diff_group'] = $data['total_new_group'] - $data['total_old_group'];
                $data['diff_sale'] = $data['total_new_sale'] - $data['total_old_sale'];

                $tax_rate = DB::table('ptom_transaction_types_all_v')->where('order_type_id', $orderheader->order_type_id)->first();
                $data['tax_group'] = $data['diff_group'] *  $tax_rate->tax_rate / (100 +  $tax_rate->tax_rate );
                $data['tax_sale'] = $data['diff_sale'] *  $tax_rate->tax_rate / (100 +  $tax_rate->tax_rate );
                $data['outvat_tax_group'] =  $data['diff_group'] - $data['tax_group'];
                $data['outvat_tax_sale'] = $data['diff_sale'] - $data['tax_sale'];
            }
        }else{
            $datahead = [];
            $invoice_line = [];
        }

        return view('om.debitnote.report',compact('dataInvoice','data','company','customer','invoice_line'));
    }
}
