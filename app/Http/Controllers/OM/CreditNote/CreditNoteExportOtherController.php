<?php

namespace App\Http\Controllers\OM\CreditNote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\CreditNote\InvoiceHeaderModel;
use App\Models\OM\CreditNote\InvoiceLineModel;

use App\Models\OM\DebitNote\DebitTypeModel;
use App\Models\OM\CreditNote\CustomerModel;
use App\Models\OM\CreditNote\AccountsMappingModel;
use App\Models\OM\CreditNote\TermsModel;
use App\Models\OM\Customers\Export\TerritoryModel;
use App\Models\OM\DebitNote\CountyModel;
use App\Models\OM\CreditNote\MappingAccountModel;
use App\Models\OM\CreditNote\PeriodModel;
use App\Models\OM\CreditNote\CurrencyModel;
use App\Models\OM\DebitNote\ProformaInvoiceModel;
use App\Models\OM\DebitNote\ProformaInvoiceLineModel;
use App\Models\OM\CreditNote\PaymentMatchInvoiceModel;
use App\Models\OM\CreditNote\PaymentAppleModel;

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

class CreditNoteExportOtherController extends Controller
{
    public function index()
    {
        $list  = InvoiceHeaderModel::where('program_code','OMP0077')->orderBy('creation_date','desc')->get();
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

        $accont_gl      = MappingAccountModel::where('account_code','06')->first();
        $accont_cr_gl   = MappingAccountModel::where('account_code','TRX-EXP-Sales Invoice-01')->first();
        $county         = CountyModel::get();
        $currency       = CurrencyModel::get();

        $period     = PeriodModel::where('start_period','<=',date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('end_period','>=',date('Y-m-d'));
                                        $query->orWhereNull('end_period');
                                    })->first();

        if(!empty($period->budget_year)){
            $budget_year = $period->budget_year + 543;
            $buget_year_segment =  substr($budget_year,-2);
        }else{
            $budget_year = date('Y') + 543;
            $buget_year_segment =  substr($budget_year,-2);
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

        $debittype  = DebitTypeModel::where('enabled_flag','Y')
                                    ->where('start_date_active','<=',date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('end_date_active','>=',date('Y-m-d'));
                                        $query->orWhereNull('end_date_active');
                                    })
                                    ->get();

        return view('om.creditnote.other_export',\compact('segment','accont_gl','buget_year_segment','account_mapping','debittype','accont_cr_gl','county','currency','list'));
    }

    public function creditExport(Request $request)
    {
        //ดึงข้อมูล invoice_header OMP0077
        $data   = InvoiceHeaderModel::whereIn('program_code',['OMP0077','OMP0082','OMP0084'])
                                    ->where(function($query) use($request){
                                        if(!empty($request->number)){
                                            $query->where('invoice_headers_number',$request->number);
                                        }
                                    })
                                    ->first();
        if($data){
            //ดึงข้อมูลลูกค้า
            if(!empty($data->customer_id)){
                $customer           = CustomerModel::where('customer_id',$data->customer_id)->first();
            }
            //ดึงข้อมูล ประเภทการรับเงิน
            $terms_data         = TermsModel::where('term_id',$data->term_id)
                                                    ->where('sale_type','EXPORT')
                                                    ->where('start_date_active','<=',date('Y-m-d'))
                                                    ->first();
            //ดึงข้อมูล line 
            $invoice_line   = InvoiceLineModel::where('invoice_headers_id',$data->invoice_headers_id)
                                                ->join('ptom_proforma_invoice_headers','ptom_proforma_invoice_headers.pi_header_id','=','ptom_invoice_lines.document_id')
                                                ->first();

            //ถ้าเป็นลูกค้าในประเทศ ดึงข้อมูลพื้นที่
            if($customer->country_code == 'TH'){

                $territory = TerritoryModel::get();

                $territory_list = [];
                if(!empty($territory)){
                    foreach($territory as $item){
                        $territory_list['province'][$item->province_id] = [
                            'name_th'  => $item->province_thai,
                            'name_en'  => $item->province_eng
                        ];
                    }
                
                    foreach($territory as $item_district){ //อำเภอ
                        $territory_list['district'][$item_district->province_id][$item_district->district_id] = [
                            'id'            => $item_district->district_id,
                            'name_th'       => $item_district->district_thai,
                            'name_en'       => $item_district->district_eng,
                            'province_id'   => $item_district->province_id,
                        ];
                    }
                
                    foreach($territory as $item_tambon){ //ตำบล
                        $territory_list['tambon'][$item_tambon->district_id][$item_tambon->tambon_id] = [
                            'id'                    => $item_tambon->tambon_id,
                            'name_th'               => $item_tambon->tambon_thai,
                            'name_en'               => $item_tambon->tambon_eng,
                            'postcode_main'         => $item_tambon->postcode_main,
                            'postcode_all'          => $item_tambon->postcode_all,
                            'postal_code_remark'    => $item_tambon->postal_code_remark,
                            'province_id'           => $item_tambon->province_id,
                            'district_id'           => $item_tambon->district_id,
                        ];
                    
                        $zipcode = explode('/',$item_tambon->postcode_all);
                    
                        foreach($zipcode as $zip_item){
                            $territory_list['postcode'][$item_tambon->tambon_id][] = $zip_item;
                        }
                    }
                }

                //เตรียมต่าที่อยู่ลูกค้า
                $address = $customer->address_line1;

                if(!empty($customer->address_line2)){
                    $address .= ' '.$customer->address_line2;
                }

                if(!empty($customer->address_line3)){
                    $address .= ' '.$customer->address_line3;
                }

                if(!empty($territory_list['tambon'][$customer->citi_code][$customer->district_code])){
                    $address .= ' '.$territory_list['tambon'][$customer->citi_code][$customer->district_code]['name_th'];
                }

                if(!empty($territory_list['district'][$customer->province_code][$customer->citi_code])){
                    $address .= ' '.$territory_list['district'][$customer->province_code][$customer->citi_code]['name_th'];
                }

                if(!empty($territory_list['province'][$customer->province_code])){
                    $address .= ' '.$territory_list['province'][$customer->province_code]['name_th'];
                }
                $address .= ' '.$customer->postal_code;
            }else{
                $address = $customer->address_line1.' '.$customer->address_line2.' '.$customer->address_line3.' '.$customer->district.' '.$customer->city.' '.$customer->province_code.' '.$customer->postal_code;
            }

            //ถ้ามีข้อมูล line
            if($invoice_line){

                $proforma       = ProformaInvoiceModel::where('pi_header_id',$invoice_line->document_id)->first();
                $proformaLine   = ProformaInvoiceLineModel::where('pi_header_id',$invoice_line->document_id)->get();
            }

            //ดึงข้อมูล เชื่อมใบลดหนี้ กับ ใบเสร็จรับเงิน
            $payApple = PaymentAppleModel::where('invoice_header_id',$data->invoice_headers_id)->first();
            //ดึงข้อมูล invoice กับ payment 
            $matchInvoice = PaymentMatchInvoiceModel::where('payment_match_id',$payApple->payment_match_id)
                                                    ->leftJoin('ptom_payment_headers','ptom_payment_headers.payment_header_id','=','ptom_payment_match_invoices.payment_header_id')
                                                    ->first();
            $data->paymentNumber    = $matchInvoice->payment_number;
            $data->paymentDate      = explode(' ',$matchInvoice->payment_date)[0];
   
            $data->customer_name    = !empty($customer)? $customer->customer_name : '';
            $data->customer_tax     = !empty($customer)? $customer->taxpayer_id : '';
            $data->customer_addr    = !empty($customer)? $address : '';
            $data->invoice_date     = !empty($data->invoice_date)? explode(' ',$data->invoice_date)[0] : '';
            $data->proforma         = $matchInvoice->invoice_number;
            $total_payment          = $proforma->sub_total + $proforma->tax;
            // $data->approve_date     = !empty($data->apprrove_date)? GlobalToDateThai($data->apprrove_date) : '';
            // $data->document_date    = !empty($data->document_date)? GlobalToDateThai($data->document_date) : '';
            // $data->date_invoice     = !empty($data->invoice_date)? GlobalToDateThai($data->invoice_date) : '';
            // $data->term_data        = !empty($terms_data)? $terms_data->due_days : '';
            // $data->item_line        = !empty($itemline)? $itemline : '';
            // $data->accd_code        = !empty($account_dr)? $account_dr->account_combine : '';
            // $data->accr_code        = !empty($account_cr)? $account_cr->account_combine : '';

            $rest = [
                'status'    => true,
                'data'      => $data
            ];
        }

        return view('om.creditnote.repost.omr19',compact('rest','proformaLine','proforma','total_payment'));
    }
}
