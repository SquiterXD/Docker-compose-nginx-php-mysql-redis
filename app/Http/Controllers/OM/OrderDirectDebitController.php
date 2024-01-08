<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\OM\Customers;
use App\Models\OM\OrderHeaders;
use App\Models\OM\Api\OrderDirectDebit;
use App\Models\OM\Api\DirectDebit;
use App\Models\OM\ReceiptBankAccV;
use App\Models\OM\BankAccounts;
use App\Models\OM\Customers\Domestics\CustomerContractGroups;
use App\Models\OM\Payment\PaymentMethodDomestic;
use App\Models\OM\Payment\PaymentMethodExport;
use App\Models\OM\AdditionQuota;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use App\Models\OM\DirectDebitOutStandV;

use Illuminate\Support\Facades\DB;
use App\Repositories\OM\DirectDebitRepo;

use Illuminate\Http\Request;
use Carbon\Carbon;

use File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderDirectDebitController extends Controller
{

    public function saByCustomer($customer)
    {
        $orderSa = OrderHeaders::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
        // ->whereRaw("lower(ptom_customers.sales_classification_code) = 'export'")
        ->whereRaw("lower(ptom_customers.status) = 'active'")
        ->whereNotNull("ptom_order_headers.prepare_order_number")
        ->where('ptom_order_headers.order_status','Confirm')
        ->where('ptom_customers.customer_number',$customer)
        ->whereNull("ptom_order_headers.deleted_at")
        ->where(function($query) {
            $query->where("payment_method_code","30");
            $query->orWhere("payment_method_code","40");
            $query->orWhere("payment_method_code","50");
        })
        ->orderBy('ptom_order_headers.order_header_id','desc')
        ->get();

        return response()->json(['data'=>$orderSa,'status'=>true]);
    }

    public function index()
    {
        $customers = Customers::byCustomerExport();

        $orderSa = OrderHeaders::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
        ->join('ptom_order_direct_debit', 'ptom_order_direct_debit.order_header_id', '=', 'ptom_order_headers.order_header_id')
        ->whereRaw("lower(ptom_customers.sales_classification_code) = 'export'")
        ->whereRaw("lower(ptom_customers.status) = 'active'")
        ->whereNotNull("ptom_order_headers.prepare_order_number")
        ->where('ptom_order_headers.order_status','Confirm')
        ->whereNull("ptom_order_headers.deleted_at")
        ->where(function($query) {
            $query->where("payment_method_code","30");
            $query->orWhere("payment_method_code","40");
            $query->orWhere("payment_method_code","50");
        })
        ->orderBy('ptom_order_headers.order_header_id','desc')
        ->get();

        $orderInvoice = OrderHeaders::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
        ->join('ptom_order_direct_debit', 'ptom_order_direct_debit.order_header_id', '=', 'ptom_order_headers.order_header_id')
        ->whereRaw("lower(ptom_customers.sales_classification_code) = 'export'")
        ->whereRaw("lower(ptom_customers.status) = 'active'")
        ->whereNotNull("ptom_order_headers.pick_release_no")
        ->whereRaw("ptom_order_headers.pick_release_approve_flag = 'Y'")
        ->whereNotNull("ptom_order_headers.prepare_order_number")
        ->where('ptom_order_headers.order_status','Confirm')
        ->whereNull("ptom_order_headers.deleted_at")
        ->where(function($query) {
            $query->where("ptom_order_headers.payment_method_code","30");
            $query->orWhere("ptom_order_headers.payment_method_code","40");
            $query->orWhere("ptom_order_headers.payment_method_code","50");
        })
        ->orderBy('ptom_order_headers.pick_release_no','desc')
        ->get();

        $bankAccount = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->get();

        $bankAccountSearch = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->get();

        $orderDirectDebit = OrderDirectDebit::joinOrderHeader()
        ->whereNotNull('ptom_order_headers.prepare_order_number')
        ->whereRaw("lower(ptom_customers.sales_classification_code) = 'export'")
        ->whereRaw("lower(ptom_customers.status) = 'active'")
        ->where('ptom_order_headers.order_status','Confirm')
        ->whereNull("ptom_order_headers.deleted_at")
        ->where(function($query) {

            if(request()->bank_id && request()->bank_id != ''){
                $bankNumber = BankAccounts::whereNotNull('short_account_name')->where('bank_number',request()->bank_id)->groupBy('short_account_name','bank_number')->select('short_account_name','bank_number')->first();
                if(!is_null($bankNumber)){
                    $query->whereRaw("ptom_order_direct_debit.customer_bank_number = '".$bankNumber->bank_number."' ");
                }
            }

            if(request()->customer_number && request()->customer_number != ''){
                $query->where('ptom_customers.customer_number', request()->customer_number);
            }

            if(request()->prepare_order_number && request()->prepare_order_number != ''){
                $query->where('ptom_order_headers.prepare_order_number', request()->prepare_order_number);
            }

            if(request()->pick_release_no && request()->pick_release_no != ''){
                $query->where('ptom_order_headers.pick_release_no', request()->pick_release_no);
            }

            if(request()->from_date && request()->from_date != ''){
                $query->where('ptom_order_headers.sa_date', '>=', dateConvertThaiEng(request()->from_date));
            }

            if(request()->to_date && request()->to_date != ''){
                $query->where('ptom_order_headers.sa_date', '<=', dateConvertThaiEng(request()->to_date));
            }

            if(request()->status && request()->status != ''){
                if(request()->status == 'w'){
                    $query->whereNull("ptom_order_direct_debit.direct_debit_flag");
                }else{
                    $query->whereRaw("lower(ptom_order_direct_debit.direct_debit_flag) = '".request()->status."' ");
                }
            }

        })
        ->where(function($query) {
            $query->where("ptom_order_headers.payment_method_code","30");
            $query->orWhere("ptom_order_headers.payment_method_code","40");
            $query->orWhere("ptom_order_headers.payment_method_code","50");
        })
        ->get();

        $bankSelect = [];
        $bankCustomer = [];
        $bankToat = [];
        $bankOrder = [];
        foreach ($orderDirectDebit as $key => $v) {
            $bankCustomer[$v->order_direct_debit_id] = DirectDebit::where('short_bank_name',$v->customer_short_bank_name)->where('customer_id',$v->customer_id)->get();

            $orderHeaders = OrderHeaders::where('order_header_id',$v->order_header_id)->first();

            $paymenyMetchod = PaymentMethodExport::where('lookup_code',$orderHeaders->payment_method_code)->first();

            $bankToat[$v->order_direct_debit_id] = ReceiptBankAccV::where('mapping_om_type',$paymenyMetchod->meaning)->where('short_bank_name',$v->toat_short_bank_name)->where('class_name','ระบบขายต่างประเทศ')->get();

            if($v->payment_type_code == 10){
                $v->new_due_date = (date('d-M-Y',strtotime($v->sa_date.' +15 days')));
            }else{

                $pi = DB::table('PTOM_PROFORMA_INVOICE_HEADERS')
                ->where('order_header_id', $v->order_header_id)
                // ->whereRaw("lower(order_status) = 'confirm' ")
                ->orderBy('pi_header_id','DESC')
                ->first();

                if(is_null($pi)){
                    $v->new_due_date = $v->delivery_date;
                }else{

                    $pi_delivery_date = $pi->delivery_date;

                    $term = DB::table('PTOM_TERMS_V')
                    ->where('term_id', $pi->term_id)
                    ->first();

                    if(is_null($term)){
                        $v->new_due_date = (date('d-M-Y',strtotime($pi_delivery_date)));
                    }else{
                        $v->new_due_date = (date('d-M-Y',strtotime($pi_delivery_date.' +'.$term->due_days.' days')));
                    }

                }

            }

            if(request()->delivery_date && request()->delivery_date != ''){
                if(dateConvertThaiEng(request()->delivery_date) != date('Y-m-d',strtotime($v->new_due_date)))
                    unset($orderDirectDebit[$key]);
            }

            $v->web_batch_no = $orderHeaders->web_batch_no;

            $v->payment_type = ($orderHeaders->payment_type_code == 10) ? 'เงินสด' : 'เงินเชื่อ';
        }

        return view('om.order_direct_debit.export.index',compact('customers','orderSa','orderInvoice','orderDirectDebit','bankAccount','bankAccountSearch','bankSelect','bankOrder','bankToat','bankCustomer'));
    }

    public function domestic()
    {
        $search_flag = request()->search_flag ? request()->search_flag : '';
        $orderDirectDebit = collect([]);
        $orderSa = collect([]);


        if((boolean)request()->ajax == true){
            if(request()->call == 'getPrepareOrder') {
                
                $orderSa = OrderHeaders::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
                ->join('ptom_order_direct_debit', 'ptom_order_direct_debit.order_header_id', '=', 'ptom_order_headers.order_header_id')
                ->whereRaw("lower(ptom_customers.sales_classification_code) = 'domestic'")
                ->whereRaw("lower(ptom_customers.status) = 'active'")
                ->whereNotNull("ptom_order_headers.prepare_order_number")
                ->where('ptom_order_headers.order_status','Confirm')
                ->whereNull("ptom_order_headers.deleted_at")
                ->where(function($query) {
                    $query->where("payment_method_code","30");
                    $query->orWhere("payment_method_code","40");
                    $query->orWhere("payment_method_code","50");
                })
                ->when(!empty(request()->q), function($q) {
                    $q->where('ptom_order_headers.prepare_order_number','LIKE','%'. request()->q.'%');
                })
                ->limit(200)
                ->orderByRaw('ptom_order_headers.customer_id asc, ptom_order_headers.prepare_order_number asc')
                ->get(['ptom_order_headers.prepare_order_number', 'ptom_customers.customer_number']);
                return $orderSa;
            }
        }
        $customers = Customers::byCustomerDomestic();
        
       
        // $orderInvoice = OrderHeaders::lovInvoiceOrderNumber();
        $orderInvoice = [];

        $bankAccount = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->get();
        $bankAccountSearch = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->get();

        if (request()->has('customer_number')) :

            $orderDirectDebit = OrderDirectDebit::joinOrderHeader()
            ->leftjoin('PTOM_CREDIT_GROUP', 'PTOM_CREDIT_GROUP.lookup_code', '=', 'ptom_order_direct_debit.credit_group_code')
            ->whereNotNull('prepare_order_number')
            ->whereRaw("lower(sales_classification_code) = 'domestic'")->whereRaw("lower(status) = 'active'")
            ->where('ptom_order_headers.order_status','Confirm')
            ->where(function($query) {
                if(request()->bank_id && request()->bank_id != ''){
                    $bankNumber = BankAccounts::whereNotNull('short_account_name')->where('bank_number',request()->bank_id)->groupBy('short_account_name','bank_number')->select('short_account_name','bank_number')->first();
                    if(!is_null($bankNumber)){
                        $query->whereRaw("ptom_order_direct_debit.customer_bank_number = '".$bankNumber->bank_number."' ");
                    }
                }

                if(request()->customer_number && request()->customer_number != ''){
                    $query->where('ptom_customers.customer_number', request()->customer_number);
                }

                if(request()->prepare_order_number && request()->prepare_order_number != ''){
                    $query->where('ptom_order_headers.prepare_order_number', request()->prepare_order_number);
                }

                if(request()->from_date && request()->from_date != ''){
                    // $query->where('ptom_order_headers.delivery_date', '>=', dateConvertThaiEng(request()->from_date));
                    $from_date_convert = dateConvertThaiEng(request()->from_date);
                    $query->whereRaw("
                        (CASE ptom_order_direct_debit.credit_group_code WHEN '0' THEN TRUNC(ptom_order_headers.delivery_date) ELSE TRUNC(ptom_order_headers.pick_release_approve_date + PTOM_CREDIT_GROUP.tag) END) >= to_date('{$from_date_convert}', 'YYYY-MM-DD')
                    ");
                }
                if(request()->due_date && request()->due_date != '') {
                    $due_date_convert = dateConvertThaiEng(request()->due_date);
                    $query->whereRaw("(CASE credit_group_code WHEN '3' THEN TRUNC(ptom_order_headers.delivery_date + 7) WHEN '2' THEN TRUNC(ptom_order_headers.delivery_date + 28) ELSE TRUNC(ptom_order_headers.delivery_date) END) = to_date('{$due_date_convert}', 'YYYY-MM-DD') ");
                }

                if(request()->to_date && request()->to_date != ''){
                    $to_date_convert = dateConvertThaiEng(request()->to_date);
                    $query->whereRaw("
                        (CASE ptom_order_direct_debit.credit_group_code WHEN '0' THEN TRUNC(ptom_order_headers.delivery_date) ELSE TRUNC(ptom_order_headers.pick_release_approve_date + PTOM_CREDIT_GROUP.tag) END) <= to_date('{$to_date_convert}', 'YYYY-MM-DD')
                    ");
                }

                if(request()->status && request()->status != ''){
                    if(request()->status == 'w'){
                        $query->whereNull("ptom_order_direct_debit.direct_debit_flag");
                    }else{
                        $query->whereRaw("lower(ptom_order_direct_debit.direct_debit_flag) = '".request()->status."' ");
                    }
                }
            })
            ->where(function($query) {
                $query->where("ptom_order_headers.payment_method_code","30");
                $query->orWhere("ptom_order_headers.payment_method_code","40");
                $query->orWhere("ptom_order_headers.payment_method_code","50");
                $query->orWhere("ptom_order_headers.payment_method_code","60");
            })
            ->orderByRaw('ptom_order_headers.customer_id asc, ptom_order_headers.prepare_order_number asc')
            ->get();
        endif;
        $bankSelect = [];
        $bankCustomer = [];
        $bankToat = [];
        $bankOrder = [];
        $customer_array = $orderDirectDebit->pluck('customer_id')->unique()->join(', ');


        $bankLastOrder = collect();
        if($customer_array != '') {
            $bankLastOrder = collect(DB::select("WITH CT
                            AS (  SELECT	 MAX (order_direct_debit_id) max_order_direct_debit_id,
                                                customer_id
                                        FROM	 ptom_order_direct_debit
                                    WHERE	 DIRECT_DEBIT_FLAG = 'Y' AND CUSTOMER_ID IN ({$customer_array})
                                GROUP BY	 CUSTOMER_ID)
                    SELECT	od.CUSTOMER_ID, CUSTOMER_SHORT_BANK_NAME, TOAT_SHORT_BANK_NAME, oh.payment_method_code
                    FROM		ptom_order_direct_debit od
                                INNER JOIN
                                    CT
                                ON od.order_direct_debit_id = CT.max_order_direct_debit_id
                        INNER JOIN PTOM_ORDER_HEADERS OH ON OH.order_header_id = od.order_header_id   
                                            "));
        }
       


        $directDebitWith  = DirectDebit::query()
                             ->whereRaw("nvl(end_date, sysdate) > trunc(sysdate)")
                             ->where(function($query) use ($orderDirectDebit) {
                                foreach($orderDirectDebit->pluck('customer_id')->toArray() as $v) {
                                    $query->orWhere('customer_id', $v);
                                }
                             })->get();
        $orderWith = OrderHeaders::whereIn('order_header_id', $orderDirectDebit->pluck('order_header_id')->toArray())->get();


        $paymentMethodWith = PaymentMethodExport::whereIn('lookup_code',$bankLastOrder->pluck('payment_method_code')->toArray())->get();
        $bankToatWith = ReceiptBankAccV::whereIn('mapping_om_type', $paymentMethodWith->pluck('meaning')->toArray())->where('class_name','ระบบขายในประเทศ')->get();
        $additionQuotaWith = AdditionQuota::whereIn('order_header_id',$orderDirectDebit->pluck('order_header_id')->toArray())->get();
        $bankToatLov = collect(DB::select("SELECT * FROM OAOM.PTOM_RECEIPT_BANK_ACC_V
                        WHERE class_name = 'ระบบขายในประเทศ' 
                        AND mapping_om_type LIKE 'Direct%'"));

        foreach ($orderDirectDebit as $key => $v) {
            $customerLastedBank = $bankLastOrder->where('customer_id', $v->customer_id)->first();
            $bankCustomer[$v->order_direct_debit_id] = $directDebitWith
                    ->where('customer_id',$v->customer_id)->map(function($i) use($customerLastedBank) {
                        if($i->short_bank_name == optional($customerLastedBank)->customer_short_bank_name) {
                            $i->selected = true;
                        }else {
                            $i->selected = false;
                        }
                        return $i;
                    });

            if($bankCustomer[$v->order_direct_debit_id]->where('selected', true)->count() > 0) {
                $v->bank_default = $bankCustomer[$v->order_direct_debit_id]->where('selected', true)->first()->short_bank_name;
            } else {
                $v->bank_default = $bankCustomer[$v->order_direct_debit_id]->first()->short_bank_name;
            }
            $orderHeaders = $orderWith->where('order_header_id',$v->order_header_id)->first();

            $paymenyMetchod = $paymentMethodWith->where('lookup_code',optional($customerLastedBank)->payment_method_code)->first();
            
            $bankToat[$v->order_direct_debit_id] = $bankToatWith
            ->where('mapping_om_type',optional($paymenyMetchod)->meaning)
            ->where('short_bank_name',$v->toat_short_bank_name)
            ;

            $additionQuota = $additionQuotaWith->where('order_header_id',$v->order_header_id)->where('approve_status','อนุมัติ')->first();

            $v->additionQuota = false;
            if (!is_null($additionQuota)) {
                $v->additionQuota = true;
            }
            $v->dayAmount = '';

            $v->web_batch_no = $orderHeaders->web_batch_no;

            if ($v->credit_group_code == 0) {
                if(!is_null($orderHeaders->pick_release_approve_date)){
                    $date_cash_amount = date('Y-m-d', strtotime($orderHeaders->pick_release_approve_date));
                }elseif(!is_null($orderHeaders->delivery_date)){
                    $date_cash_amount = date('Y-m-d', strtotime($orderHeaders->delivery_date));
                }else{
                    $date_cash_amount = date('Y-m-d');
                }

                if($orderHeaders->cash_amount > 0){
                    $v->dayAmount = dateFormatThai($date_cash_amount);
                }

                if(request()->due_date && request()->due_date != ''){

                    if(dateConvertThaiEng(request()->due_date) != $date_cash_amount){
                        unset($orderDirectDebit[$key]);
                    }
                }

            }else{

                $day_amount = CustomerContractGroups::where('customer_id',$v->customer_id)->where('credit_group_code',$v->credit_group_code)->whereNull('deleted_at')->first();

                if(!is_null($day_amount)){

                    if(!is_null($orderHeaders->pick_release_approve_date)){
                        $date_amount = date('Y-m-d', strtotime($orderHeaders->pick_release_approve_date."+".$day_amount->day_amount." days"));
                    }elseif(!is_null($orderHeaders->delivery_date)){

                        $date_amount = date('Y-m-d', strtotime($orderHeaders->delivery_date."+".$day_amount->day_amount." days"));
                    }else{
                        $date_amount = date('Y-m-d', strtotime("+".$day_amount->day_amount." days"));
                    }

                    $v->dayAmount = dateFormatThai($date_amount);

                    if(request()->due_date && request()->due_date != ''){

                        if(dateConvertThaiEng(request()->due_date) != $date_amount){
                            unset($orderDirectDebit[$key]);
                        }
                    }
                }
            }
        }
        return view('om.order_direct_debit.domestic.index',compact('bankToatLov','customers','orderSa','orderInvoice','orderDirectDebit','bankAccount','bankAccountSearch','bankSelect','bankOrder','bankToat','bankCustomer', 'search_flag'));
    }

    public function exportSave(Request $request)
    {
        $resp = [];
        try {
            foreach ($request->direct_debit_flag as $key => $v) {
                $orderDirectDebit = OrderDirectDebit::where('order_direct_debit_id',$key)->first();

                $direct_debit_amount = $orderDirectDebit->direct_debit_amount;
                $orderHeaders = OrderHeaders::where('order_header_id',$orderDirectDebit->order_header_id)->first();

                // $pi = ProformaInvoiceHeaders::where('order_header_id',$orderDirectDebit->order_header_id)->orderBy('order_header_id','DESC')->first();

                $paymenyMetchod = PaymentMethodExport::where('lookup_code',$orderHeaders->payment_method_code)->first();

                // customer bank
                $directDebit = DirectDebit::where('direct_debit_id',$request->customer_direct_debit_id[$key])->first();

                $orderDirectDebit->customer_bank_id = $directDebit->bank_id;
                $orderDirectDebit->customer_bank_number = $directDebit->bank_number;
                $orderDirectDebit->customer_short_bank_name = $directDebit->short_bank_name;
                $orderDirectDebit->customer_bank_name = $directDebit->bank_name;
                $orderDirectDebit->customer_branch_id = $directDebit->branch_id;
                $orderDirectDebit->customer_branch_number = $directDebit->branch_number;
                $orderDirectDebit->customer_branch_name = $directDebit->branch_name;
                $orderDirectDebit->customer_account_number = $directDebit->account_number;
                // customer bank

                // toat
                $exp_toat = explode('_',$request->toat_direct_debit_id[$key]);
                // ->where('branch_id',$exp_toat[1])
                $receiptBank = ReceiptBankAccV::where('mapping_om_type',$paymenyMetchod->meaning)->where('bank_id',$exp_toat[0])->where('class_name','ระบบขายต่างประเทศ')->first();

                $orderDirectDebit->toat_bank_id = $receiptBank->bank_id;
                $orderDirectDebit->toat_bank_number = $receiptBank->bank_number;
                $orderDirectDebit->toat_short_bank_name = $receiptBank->short_bank_name;
                $orderDirectDebit->toat_bank_name = $receiptBank->bank_name;
                $orderDirectDebit->toat_branch_id = $receiptBank->branch_id;
                $orderDirectDebit->toat_branch_number = $receiptBank->branch_number;
                $orderDirectDebit->toat_branch_name = $receiptBank->branch_name;
                $orderDirectDebit->toat_account_number = $receiptBank->bank_account_number;
                $orderDirectDebit->toat_bank_account_name = $receiptBank->bank_account_name;
                // toat

                $orderDirectDebit->direct_debit_amount = covertNFToFloat($request->direct_debit_amount[$key]);
                $orderDirectDebit->direct_debit_id = $request->customer_direct_debit_id[$key];
                $orderDirectDebit->direct_debit_flag = $request->direct_debit_flag[$key];

                if($request->direct_debit_flag[$key] == 'Y'){
                    $orderDirectDebit->approve_date = Carbon::now();
                    $orderDirectDebit->direct_debit_flag = 'Y';

                    if (covertNFToFloat($request->direct_debit_amount[$key]) < $direct_debit_amount) {

                        $orderNewDirectDebit = $orderDirectDebit->replicate();
                        $orderNewDirectDebit->direct_debit_amount = ($direct_debit_amount - covertNFToFloat($request->direct_debit_amount[$key]));
                        $orderNewDirectDebit->direct_debit_flag = null;
                        $orderNewDirectDebit->approve_date = null;
                        $orderNewDirectDebit->save();

                    }

                }else{
                    $orderDirectDebit->approve_date = null;
                    $orderDirectDebit->direct_debit_flag = 'N';
                }

                $orderDirectDebit->save();
            }
        } catch (\Exception $e) {
            Log::error($e);
        }

        return response()->json(['status'=>true,'data'=>$resp,'message'=>'message']);
    }

    public function domesticSave(Request $request)
    {
        $resp = [];
        try {
            foreach ($request->direct_debit_flag as $key => $v) {
                $orderDirectDebit = OrderDirectDebit::where('order_direct_debit_id',$key)->first();

                $direct_debit_amount = $orderDirectDebit->direct_debit_amount;
                $orderHeaders = OrderHeaders::where('order_header_id',$orderDirectDebit->order_header_id)->first();

                $paymenyMetchod = PaymentMethodDomestic::where('lookup_code',$orderHeaders->payment_method_code)->first();

                // customer bank
                $directDebit = DirectDebit::where('direct_debit_id',$request->customer_direct_debit_id[$key])->first();

                $orderDirectDebit->customer_bank_id = $directDebit->bank_id;
                $orderDirectDebit->customer_bank_number = $directDebit->bank_number;
                $orderDirectDebit->customer_short_bank_name = $directDebit->short_bank_name;
                $orderDirectDebit->customer_bank_name = $directDebit->bank_name;
                $orderDirectDebit->customer_branch_id = $directDebit->branch_id;
                $orderDirectDebit->customer_branch_number = $directDebit->branch_number;
                $orderDirectDebit->customer_branch_name = $directDebit->branch_name;
                $orderDirectDebit->customer_account_number = $directDebit->account_number;
                // customer bank

                // toat
                $exp_toat = explode('_',$request->toat_direct_debit_id[$key]);
                $receiptBank = ReceiptBankAccV::where('mapping_om_type',$paymenyMetchod->meaning)->where('bank_id',$exp_toat[0])->where('branch_id',$exp_toat[1])->where('class_name','ระบบขายในประเทศ')->first();

                $orderDirectDebit->toat_bank_id = $receiptBank->bank_id;
                $orderDirectDebit->toat_bank_number = $receiptBank->bank_number;
                $orderDirectDebit->toat_short_bank_name = $receiptBank->short_bank_name;
                $orderDirectDebit->toat_bank_name = $receiptBank->bank_name;
                $orderDirectDebit->toat_branch_id = $receiptBank->branch_id;
                $orderDirectDebit->toat_branch_number = $receiptBank->branch_number;
                $orderDirectDebit->toat_branch_name = $receiptBank->branch_name;
                $orderDirectDebit->toat_account_number = $receiptBank->bank_account_number;
                $orderDirectDebit->toat_bank_account_name = $receiptBank->bank_account_name;
                // toat

                $orderDirectDebit->direct_debit_amount = covertNFToFloat($request->direct_debit_amount[$key]);
                $orderDirectDebit->direct_debit_id = $request->customer_direct_debit_id[$key];
                $orderDirectDebit->direct_debit_flag = $request->direct_debit_flag[$key];

                if($request->direct_debit_flag[$key] == 'Y'){
                    $orderDirectDebit->approve_date = Carbon::now();
                    $orderDirectDebit->direct_debit_flag = 'Y';

                    if (covertNFToFloat($request->direct_debit_amount[$key]) < $direct_debit_amount) {

                        $orderNewDirectDebit = $orderDirectDebit->replicate();
                        $orderNewDirectDebit->direct_debit_amount = ($direct_debit_amount - covertNFToFloat($request->direct_debit_amount[$key]));
                        $orderNewDirectDebit->direct_debit_flag = null;
                        $orderNewDirectDebit->approve_date = null;
                        $orderNewDirectDebit->save();

                    }

                }else{
                    $orderDirectDebit->approve_date = null;
                    $orderDirectDebit->direct_debit_flag = 'N';
                }

                $orderDirectDebit->save();
            }
        } catch (\Exception $e) {
            Log::error($e);
        }

        return response()->json(['status'=>true,'data'=>$resp,'message'=>'message']);
    }

    public function exportFileTranfer()
    {
        $bankAccount = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->get();

        $bankAccountSearch = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->get();

        return view('om.order_direct_debit.export.file_tranfer',compact('bankAccount','bankAccountSearch'));
    }

    public function domesticFileTranfer()
    {
        $bankAccount = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->get();

        $bankAccountSearch = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')->get();

        return view('om.order_direct_debit.domestic.file_tranfer',compact('bankAccount','bankAccountSearch'));
    }

    function utf8_strlen($s) {
        $c = strlen($s); $l = 0;
        for ($i = 0; $i < $c; ++$i)
        if ((ord($s[$i]) & 0xC0) != 0x80) ++$l;
        return $l;
    }

    public function prepareFileTranferExport(Request $request)
    {
        $orderDirectDebit = OrderDirectDebit::joinOrderHeaderConfirm()
        ->join('ptom_direct_debit', 'ptom_direct_debit.direct_debit_id', '=', 'ptom_order_direct_debit.direct_debit_id')
        ->whereNotNull('prepare_order_number')
        ->where('direct_debit_flag','Y')
        ->whereNull('ptom_order_direct_debit.web_batch_no')
        ->whereRaw("lower(sales_classification_code) = 'export'")->whereRaw("lower(status) = 'active'")
        ->where(function($query) {
            if(request()->bank_id && request()->bank_id != ''){
                $query->whereRaw("ptom_order_direct_debit.customer_bank_number = '".request()->bank_id."' ");
            }

            if(request()->from_date && request()->from_date != ''){
                $query->where('ptom_order_headers.order_date', '>=', dateConvertThaiEng(request()->from_date));
            }

            if(request()->to_date && request()->to_date != ''){
                $query->where('ptom_order_headers.order_date', '<=', dateConvertThaiEng(request()->to_date));
            }

            // if(request()->from_date && request()->from_date != ''){
            //     $query->where('ptom_order_headers.delivery_date', '>=', dateConvertThaiEng(request()->from_date));
            // }

            // if(request()->to_date && request()->to_date != ''){
            //     $query->where('ptom_order_headers.delivery_date', '<=', dateConvertThaiEng(request()->to_date));
            // }
        })
        ->get();

        // foreach ($orderDirectDebit as $key => $v) {

        //     $orderHeaders = OrderHeaders::where('order_header_id',$v->order_header_id)->first();

        //     $v->dayAmount = '';

        //     $v->web_batch_no = $orderHeaders->web_batch_no;

        //     if ($v->credit_group_code == 0) {
        //         if(!is_null($orderHeaders->pick_release_approve_date)){
        //             $date_cash_amount = date('Y-m-d', strtotime($orderHeaders->pick_release_approve_date));
        //         }elseif(!is_null($orderHeaders->delivery_date)){
        //             $date_cash_amount = date('Y-m-d', strtotime($orderHeaders->delivery_date));
        //         }else{
        //             $date_cash_amount = date('Y-m-d');
        //         }

        //         if($orderHeaders->cash_amount > 0){
        //             $v->dayAmount = dateFormatThai($date_cash_amount);
        //         }

        //         if(request()->due_date && request()->due_date != ''){

        //             if(dateConvertThaiEng(request()->due_date) != $date_cash_amount){
        //                 unset($orderDirectDebit[$key]);
        //             }
        //         }

        //     }else{

        //         $day_amount = CustomerContractGroups::where('customer_id',$v->customer_id)->where('credit_group_code',$v->credit_group_code)->whereNull('deleted_at')->first();

        //         if(!is_null($day_amount)){

        //             if(!is_null($orderHeaders->pick_release_approve_date)){
        //                 $date_amount = date('Y-m-d', strtotime($orderHeaders->pick_release_approve_date."+".$day_amount->day_amount." days"));
        //             }elseif(!is_null($orderHeaders->delivery_date)){

        //                 $date_amount = date('Y-m-d', strtotime($orderHeaders->delivery_date."+".$day_amount->day_amount." days"));
        //             }else{
        //                 $date_amount = date('Y-m-d', strtotime("+".$day_amount->day_amount." days"));
        //             }

        //             $v->dayAmount = dateFormatThai($date_amount);

        //             if(request()->due_date && request()->due_date != ''){

        //                 if(dateConvertThaiEng(request()->due_date) != $date_amount){
        //                     unset($orderDirectDebit[$key]);
        //                 }
        //             }


        //         }
        //     }

        // }

        $fileTran = [];

        // $bankAccount = BankAccounts::where('bank_id',request()->bank_id)->whereNotNull('short_account_name')->groupBy('short_bank_name')->select('short_bank_name')->first();

        // $bankAccount = DB::table('APPS.CE_BANKS_V')
        // ->groupBy('bank_party_id','bank_number','bank_name','short_bank_name')
        // ->select('bank_party_id as bank_id','bank_number','bank_name','short_bank_name')
        // ->where('bank_number', request()->bank_id)
        // ->first();
        $bankAccount = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->where('bank_number', request()->bank_id)
        ->first();

        if(count($orderDirectDebit) > 0){
            if($bankAccount->short_bank_name == 'KTB'){
                $fileTran = self::domesticCreateFileTranferV2($orderDirectDebit);
            }elseif($bankAccount->short_bank_name == 'TTB'){
                $fileTran = self::domesticCreateTTBFileTranferV2($orderDirectDebit);
            }else{
                $fileTran = self::domesticCreateSCBFileTranferV2($orderDirectDebit);
            }
        }

        return response()->json(['status'=>true,'data'=>$orderDirectDebit,'fileTran'=>$fileTran,'message'=>'']);
    }

    // --------------------------------------------------------------------------------------
    public function searchDirectDabit(Request $request)
    {
        $orderDirectDebit = DirectDebitOutStandV::whereNotNull('prepare_order_number')
                                    ->where('direct_debit_flag', 'Y')
                                    ->where(function($query) {
                                        if(request()->bank_id && request()->bank_id != ''){
                                            $query->whereRaw("customer_bank_number = '".request()->bank_id."' ");
                                        }
                                        if(request()->from_date && request()->from_date != ''){
                                            $query->where('approve_date', '>=', dateConvertThaiEng(request()->from_date));
                                        }
                                        if(request()->to_date && request()->to_date != ''){
                                            $query->where('approve_date', '<=', dateConvertThaiEng(request()->to_date));
                                        }
                                    })
                                    ->orderByRaw('customer_id asc, prepare_order_number asc')
                                    ->get();

        $orderDirectDebitNew = $orderDirectDebit;
        $orderDirectDebit = [];
        foreach ($orderDirectDebitNew as $key => $v) {
            $unset = false;
            $orderHeaders = OrderHeaders::where('order_header_id',$v->order_header_id)->first();
            $v->dayAmount = '';
            $v->web_batch_no = $orderHeaders->web_batch_no;

            if ($v->credit_group_code == 0) {
                if(!is_null($orderHeaders->pick_release_approve_date)){
                    $date_cash_amount = date('Y-m-d', strtotime($orderHeaders->pick_release_approve_date));
                }elseif(!is_null($orderHeaders->delivery_date)){
                    $date_cash_amount = date('Y-m-d', strtotime($orderHeaders->delivery_date));
                }else{
                    $date_cash_amount = date('Y-m-d');
                }
                if($orderHeaders->cash_amount > 0){
                    $v->dayAmount = dateFormatThai($date_cash_amount);
                }
                if(request()->due_date && request()->due_date != ''){
                    if(dateConvertThaiEng(request()->due_date) != $date_cash_amount){
                        $unset = true;
                    }
                }
            }else{
                $day_amount = CustomerContractGroups::where('customer_id', $v->customer_id)->where('credit_group_code', $v->credit_group_code)->whereNull('deleted_at')->first();
                if(!is_null($day_amount)){
                    if(!is_null($orderHeaders->pick_release_approve_date)){
                        $date_amount = date('Y-m-d', strtotime($orderHeaders->pick_release_approve_date."+".$day_amount->day_amount." days"));
                    }elseif(!is_null($orderHeaders->delivery_date)){

                        $date_amount = date('Y-m-d', strtotime($orderHeaders->delivery_date."+".$day_amount->day_amount." days"));
                    }else{
                        $date_amount = date('Y-m-d', strtotime("+".$day_amount->day_amount." days"));
                    }
                    $v->dayAmount = dateFormatThai($date_amount);
                    if(request()->due_date && request()->due_date != ''){
                        if(dateConvertThaiEng(request()->due_date) != $date_amount){
                            $unset = true;
                        }
                    }
                }
            }

            if(!$unset){
                $orderDirectDebit[] = $v;
            }
        }

        $bankAccount = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->where('bank_number', request()->bank_id)
        ->first();

        return response()->json(['status'=>true
            , 'data' => $orderDirectDebit
            , 'fileTran' => []
            , 'message' => 'message'
            , 'redirect_report' => ''
        ]);
    }
    //---------------------------------------------------------------------------------------

    public function prepareFileTranfer(Request $request)
    {
        // Validate orders
        if ($request->lines == '' || $request->lines == null) {
            return response()->json(['status'=>true
                , 'data' => []
                , 'amount' => []
                , 'fileTran' => []
                , 'message' => 'message'
                , 'redirect_report' => ''
            ]);
        }

        $orderDirectDebit = DirectDebitOutStandV::selectRaw('sum(direct_debit_amount) direct_debit_amount, re_customer_name, customer_account_number')
                                    ->whereNotNull('prepare_order_number')
                                    ->where('direct_debit_flag','Y')
                                    ->whereIn('prepare_order_number', $request->lines)
                                    ->where(function($query) {
                                        if(request()->bank_id && request()->bank_id != ''){
                                            $query->whereRaw("customer_bank_number = '".request()->bank_id."' ");
                                        }
                                        if(request()->from_date && request()->from_date != ''){
                                            $query->where('approve_date', '>=', dateConvertThaiEng(request()->from_date));
                                        }
                                        if(request()->to_date && request()->to_date != ''){
                                            $query->where('approve_date', '<=', dateConvertThaiEng(request()->to_date));
                                        }
                                    })
                                    ->groupByRaw('re_customer_name, customer_account_number')
                                    ->get();

        $fileTran = [];
        $bankAccount = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->where('bank_number', request()->bank_id)
        ->first();

        if(count($orderDirectDebit) > 0){
            if($bankAccount->short_bank_name == 'KTB'){
                $fileTran = self::domesticCreateFileTranferV2($orderDirectDebit);
            }elseif($bankAccount->short_bank_name == 'TTB'){
                $fileTran = self::domesticCreateTTBFileTranferV2($orderDirectDebit);
            }else{
                $fileTran = self::domesticCreateSCBFileTranferV2($orderDirectDebit);
            }
        }

        // url transfer direct debit
        $implode = implode(',', $request->lines);
        $redirect_report = url('/om/order-direct-debit/domestic/download-transfer-debit').'?bank_id='.$request->bank_id.'&from_date='.$request->from_date.'&to_date='.$request->to_date.'&due_date='.$request->due_date.'&lines='.$implode;

        return response()->json(['status'=>true
            , 'data' => $orderDirectDebit
            , 'fileTran' => $fileTran
            , 'message' => 'message'
            , 'redirect_report' => $redirect_report
        ]);
    }

    public function confirmFileExport(Request $request ,$batch_no)
    {
        $orderDirectDebit = OrderDirectDebit::joinOrderHeaderConfirm()
        ->join('ptom_direct_debit', 'ptom_direct_debit.direct_debit_id', '=', 'ptom_order_direct_debit.direct_debit_id')
        ->whereNotNull('prepare_order_number')
        ->where('direct_debit_flag','Y')
        ->whereNull('ptom_order_direct_debit.web_batch_no')
        ->whereRaw("lower(sales_classification_code) = 'export'")->whereRaw("lower(status) = 'active'")
        ->where(function($query) {
            if(request()->bank_id && request()->bank_id != ''){
                $query->whereRaw("ptom_order_direct_debit.customer_bank_number = '".request()->bank_id."' ");
            }

            if(request()->from_date && request()->from_date != ''){
                $query->where('ptom_order_headers.order_date', '>=', dateConvertThaiEng(request()->from_date));
            }

            if(request()->to_date && request()->to_date != ''){
                $query->where('ptom_order_headers.order_date', '<=', dateConvertThaiEng(request()->to_date));
            }
        })
        ->get();

        $fileTran = [];
        $bankAccount = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->where('bank_number', request()->bank_id)
        ->first();

        if(count($orderDirectDebit) > 0){
            if($bankAccount->short_bank_name == 'KTB'){
                $fileTran = self::domesticCreateFileTranferV2($orderDirectDebit, request()->count_download);
            }elseif($bankAccount->short_bank_name == 'TTB'){
                $fileTran = self::domesticCreateTTBFileTranferV2($orderDirectDebit, request()->count_download);
            }else{
                $fileTran = self::domesticCreateSCBFileTranferV2($orderDirectDebit, request()->count_download);
            }
        }

        $web_batch_no = date('dmyhi');
        foreach ($orderDirectDebit as $key => $v) {
            if($v->web_batch_no == '')
            {
                $v->web_batch_no = $web_batch_no;
                $v->save();
            }

            $orderHeaders = OrderHeaders::where('order_header_id',$v->order_header_id)->first();
            if($orderHeaders->web_batch_no == '')
            {
                $orderHeaders->web_batch_no = $web_batch_no;
                $orderHeaders->save();
            }
        }

        return response()->json(['status'=>true,'data'=>$orderDirectDebit,'fileTran'=>$fileTran,'message'=>'message']);
    }

    public function confirmFile(Request $request ,$batch_no)
    {
        $orderDirectDebit = DirectDebitOutStandV::selectRaw('sum(direct_debit_amount) direct_debit_amount, re_customer_name, customer_account_number')
                                    ->whereNotNull('prepare_order_number')
                                    ->where('direct_debit_flag','Y')
                                    ->whereIn('prepare_order_number', $request->lines)
                                    ->where(function($query) {
                                        if(request()->bank_id && request()->bank_id != ''){
                                            $query->whereRaw("customer_bank_number = '".request()->bank_id."' ");
                                        }
                                        if(request()->from_date && request()->from_date != ''){
                                            $query->where('approve_date', '>=', dateConvertThaiEng(request()->from_date));
                                        }
                                        if(request()->to_date && request()->to_date != ''){
                                            $query->where('approve_date', '<=', dateConvertThaiEng(request()->to_date));
                                        }
                                    })
                                    ->groupByRaw('re_customer_name, customer_account_number')
                                    ->get();

        $orderDirectDebitUpdate = DirectDebitOutStandV::whereNotNull('prepare_order_number')
                                    ->where('direct_debit_flag','Y')
                                    ->whereIn('prepare_order_number', $request->lines)
                                    ->where(function($query) {
                                        if(request()->bank_id && request()->bank_id != ''){
                                            $query->whereRaw("customer_bank_number = '".request()->bank_id."' ");
                                        }
                                        if(request()->from_date && request()->from_date != ''){
                                            $query->where('approve_date', '>=', dateConvertThaiEng(request()->from_date));
                                        }
                                        if(request()->to_date && request()->to_date != ''){
                                            $query->where('approve_date', '<=', dateConvertThaiEng(request()->to_date));
                                        }
                                    })
                                    ->get();
        $headerId = $orderDirectDebitUpdate->pluck('order_header_id')->toArray();

        $due_date = date('dmy');
        if(request()->due_date && request()->due_date != ''){
            $due_date =  Carbon::createFromFormat('d/m/Y', request()->due_date)->subYears(543)->format('dmy');
        }

        $fileTran = [];
        $bankAccount = DB::table('PTOM_RECEIPT_BANK_ACC_V')
        ->where('class_name','ระบบขายในประเทศ')
        ->where('primary','Y')
        ->where('method_name', 'like', '%D_Direct%')
        ->where('bank_number', request()->bank_id)
        ->first();

        if(count($orderDirectDebit) > 0){
            if($bankAccount->short_bank_name == 'KTB'){
                $fileTran = self::domesticCreateFileTranferV2($orderDirectDebit, request()->count_download,$due_date);
            }elseif($bankAccount->short_bank_name == 'TTB'){
                $fileTran = self::domesticCreateTTBFileTranferV2($orderDirectDebit, request()->count_download,$due_date);
            }else{
                $fileTran = self::domesticCreateSCBFileTranferV2($orderDirectDebit, request()->count_download,$due_date);
            }
        }

        $web_batch_no = date('dmyhi');
        $orderHeaders = OrderHeaders::whereIn('order_header_id', $headerId)
                                    ->whereNull('web_batch_no')
                                    ->update(['web_batch_no' => $web_batch_no]);
        $directDebit = OrderDirectDebit::whereIn('order_header_id', $headerId)
                                    ->whereNull('web_batch_no')
                                    ->update(['web_batch_no' => $web_batch_no]);

        return response()->json(['status' => true
            ,'data' => $orderDirectDebit
            ,'fileTran' => $fileTran
            ,'message' => 'message'
        ]);
    }

    public function domesticCreateSCBFileTranferV2($orderDirectDebit, $count_download=0, $due_date='')
    {
        $batch_no = autoWebBatchNumber();
        if($due_date == ''){
            $due_date = date('dmy');
        }else{
            $due_date = Carbon::createFromFormat('dmy', $due_date)->format('dmy');
        }

        $strDetail = '';
        $strHeader = '';

        $h1 = sprintf("% 8s", '');

        $length_h3 = 30 - strlen('THAILAND TOBACCO MONOPOLY');
        $h3 = 'THAILAND TOBACCO MONOPOLY'.sprintf("% {$length_h3}s", '');

        $h7 = $due_date;

        $length_h8 = 5 - strlen(count($orderDirectDebit));
        $h8 = sprintf("%0{$length_h8}d", '').strlen(count($orderDirectDebit));


        $runDetail = 2;
        $amount = 0;
        foreach ($orderDirectDebit as $key_debit => $debit) {

            // $orderHeader = OrderHeaders::where('order_header_id',$debit->order_header_id)->first();
            $customer = Customers::where('customer_name', 'like', '%'.$debit->re_customer_name.'%')->get();
            $plCus = $customer->pluck('customer_number')->unique();
            $customerTxt = count($plCus) == 1? $customer->first()->customer_number: '999999';
            // $length_d1 = 6 - strlen($runDetail);
            $d1 = $debit->customer_account_number;

            $length_d4 = 11 - strlen(number_format((float)$debit->direct_debit_amount, 2, '', ''));
            $d4 = sprintf("%011d",number_format((float)$debit->direct_debit_amount, 2, '', ''));

            $length_d6 = 10 - strlen($customerTxt);
            $d6 = $customerTxt.sprintf("% {$length_d6}s", '');

            $length_d7 = 45 - self::utf8_strlen($customer->first()->customer_name);
            $d7 = $customer->first()->customer_name.(($length_d7 > 0) ? sprintf("% {$length_d7}s", '') : '');

            $strDetail .= $d1.$due_date.'1'.$d4.sprintf("% 2s", '').$d6.$d7;

            $runDetail += 1;
            $strDetail .= "\r\n";

            $amount += $debit->direct_debit_amount;
        }

        $length_h9 = 11 - strlen(number_format((float)$amount, 2, '', ''));
        $h9 = sprintf("%0{$length_h9}d",'').number_format((float)$amount, 2, '', '');

        $strHeader .= $h1.'M001001'.$h3.'SA'.$h7.$h8.$h9.'I'.sprintf("% 8s", '');

        $users = getDefaultData('/users');
        $path = $users->archive_directory;
        $file = 'SCB-'.date('YmdHis').'.txt';
        $data = Storage::disk('local')->put($path.'/'.$file,$this->utf8_to_tis620($strHeader."\r\n".$strDetail));

        return ['file_path'=>$path,'file_name'=>$file,'batch_no'=>$batch_no];

    }

    public function domesticCreateSCBFileTranfer($orderDirectDebit,$count_download=0)
    {
        $scbHeader = DirectDebitRepo::createHeaderFileTranferSCB();

        $scbDebitDetail = DirectDebitRepo::createDebitDetailFileTranferSCB();

        $scbCreditDetail = DirectDebitRepo::createCreditDetailFileTranferSCB();

        $scbPayeeDetail = DirectDebitRepo::createPayeeDetailFileTranferSCB();

        $scbWthDetail = DirectDebitRepo::createWHTDetailFileTranferSCB();

        $scbTrailerDetail = DirectDebitRepo::createTrailerDetailFileTranferSCB();

        $batch_no = autoWebBatchNumber();

        $strDetail = '';
        foreach ($orderDirectDebit as $key_debit => $debit) {
            // dd(number_format((float)$debit->direct_debit_amount, 2, '', ''));
            $customer = Customers::byCustomerId($debit->customer_id);

            $orderHeader = OrderHeaders::where('order_header_id',$debit->order_header_id)->first();

            foreach ($scbHeader as $key => $v) {
                if($v['name'] == 'company_id'){
                    $length = $v['length'] - strlen('ttmo797');
                    $strDetail .= 'ttmo797'.sprintf("% {$length}s", '');
                }elseif($v['name'] == 'customer_ref'){
                    $length = $v['length'] - strlen('ttmo797'.date('Ymd'));
                    $strDetail .= 'ttmo797'.date('Ymd').sprintf("% {$length}s",'');
                }elseif($v['name'] == 'batch_ref'){
                    $length = $v['length'] - strlen('ttmo797001');
                    $strDetail .= 'ttmo797001'.sprintf("% {$length}s",'');
                }else{
                    $strDetail .= $v["value"];
                }
            }
            $strDetail .= "\r\n";

            foreach ($scbDebitDetail as $key => $v) {

                if($v['name'] == 'debit_account_no'){
                    $length = $v['length'] - strlen(str_replace('-', '', ($debit->toat_account_number)));
                    $strDetail .= str_replace('-', '', ($debit->toat_account_number)).sprintf("% {$length}s",'');
                }else if($v['name'] == 'fee_debit_account'){
                    $length = $v['length'] - strlen(str_replace('-', '', ($debit->toat_account_number)));
                    $strDetail .= str_replace('-', '', ($debit->toat_account_number)).sprintf("% {$length}s",'');
                }else if($v['name'] == 'debit_amount'){
                    $length = $v['length'] - strlen(number_format((float)$debit->direct_debit_amount, 2, '', ''));
                    $strDetail .= sprintf("%0{$length}d",'').number_format((float)$debit->direct_debit_amount, 2, '', '');
                }else{
                    $strDetail .= $v["value"];
                }
            }
            $strDetail .= "\r\n";

            foreach ($scbCreditDetail as $key => $v) {
                if($v['name'] == 'credit_account'){
                    $length = $v['length'] - strlen($debit->customer_account_number);
                    $strDetail .= $debit->customer_account_number.sprintf("% {$length}s",'');
                }else if($v['name'] == 'credit_amount'){
                    $length = $v['length'] - strlen(number_format((float)$debit->direct_debit_amount, 2, '', ''));
                    $strDetail .= sprintf("%0{$length}d",'').number_format((float)$debit->direct_debit_amount, 2, '', '');
                }else{
                    $strDetail .= $v["value"];
                }
            }

            $strDetail .= "\r\n";

            foreach ($scbPayeeDetail as $key => $v) {
                $strDetail .= $v["value"];
            }

            $strDetail .= "\r\n";

            foreach ($scbTrailerDetail as $key => $v) {

                if($v['name'] == 'total_amount'){
                    $length = $v['length'] - strlen(number_format((float)$debit->direct_debit_amount, 2, '', ''));
                    $strDetail .= sprintf("%0{$length}d",'').number_format((float)$debit->direct_debit_amount, 2, '', '');
                }else{
                    $strDetail .= $v["value"];
                }
            }

        }

        if($count_download > 0){
            $strDetail .= $count_download;
        }

        $users = getDefaultData('/users');
        $path = $users->archive_directory;
        $file = 'SCB-'.date('YmdHis').'.txt';
        $data = Storage::disk('local')->put($path.'/'.$file,$strDetail);

        return ['file_path'=>$path,'file_name'=>$file,'batch_no'=>$batch_no];

    }

    public function domesticCreateTTBFileTranferV2($orderDirectDebit, $count_download=0, $due_date='')
    {
        $ttbHeader = DirectDebitRepo::createFileTranferTTBV2();

        if($due_date == ''){
            $due_date = date('dmy');
        }else{
            $due_date = Carbon::createFromFormat('dmy', $due_date)->format('dmy');
        }

        $batch_no = autoWebBatchNumber();

        $strDetail = '';

        foreach ($ttbHeader as $key => $v) {
            if ($v["name"] == 'post_date') {
                $strDetail .= $due_date;
            }elseif($v["name"] == 'post_type'){
                $length = $v['length'] - self::utf8_strlen('1');
                $strDetail .= '1'.sprintf("% {$length}s", '');
            }else{
                $strDetail .= $v["value"];
            }
        }

        $strDetail .= "\r\n";
        $runDetail = 2;
        $amount = 0;
        foreach ($orderDirectDebit as $key_debit => $debit) {

            // $orderHeader = OrderHeaders::where('order_header_id',$debit->order_header_id)->first();
            // $customer = Customers::byCustomerId($debit->customer_id);
            $customer = Customers::where('customer_name', 'like', '%'.$debit->re_customer_name.'%')->get();
            $plCus = $customer->pluck('customer_number')->unique();
            $customerTxt = count($plCus) == 1? $customer->first()->customer_number: '999999';

            $length_d1 = 6 - strlen($runDetail);
            $d1 = sprintf("%0{$length_d1}d", '').$runDetail;

            $length_d6 = 10 - strlen(number_format((float)$debit->direct_debit_amount, 2, '', ''));
            $d6 = sprintf("%010d",number_format((float)$debit->direct_debit_amount, 2, '', ''));
            $length_d9 = 10 - strlen($customerTxt);
            $d9 = $customerTxt.sprintf("% {$length_d9}s", '');

            $length_d13 = 35 - self::utf8_strlen($customer->first()->customer_name);
            $d13 = $customer->first()->customer_name.(($length_d13 > 0) ? sprintf("% {$length_d13}s", '') : '');

            $strDetail .= 'D'.$d1.'046'.$debit->customer_account_number.'D'.$d6.'089'.$d9.sprintf("% 10s", '').'001'.sprintf("% 36s", '').$d13;

            $runDetail += 1;
            $strDetail .= "\r\n";

            $amount += $debit->direct_debit_amount;
        }

        $length_t1 = 6 - strlen(($runDetail));
        $t1 = sprintf("%0{$length_t1}d", '').($runDetail);

        $length_t5 = 7 - strlen(count($orderDirectDebit));
        $t5 = sprintf("%0{$length_t5}d", '').(count($orderDirectDebit));

        $length_t6 = 13 - strlen(number_format((float)$amount, 2, '', ''));
        $t6 = number_format((float)$amount, 2, '', '');
        if($count_download % 2 != 0) {
            $t6++;
        }

        $t6 = sprintf("%0{$length_t6}d",''). $t6;

        $strDetail .= 'T'.$t1.'0460462703364'.$t5.$t6.sprintf("% 88s", '');

        $strDetail .= "\r\n";
        $users = getDefaultData('/users');
        $path = $users->archive_directory;
        $file = 'TTB-'.date('YmdHis').'.txt';

        $data = Storage::disk('local')->put($path.'/'.$file,$this->utf8_to_tis620($strDetail));
        return ['file_path'=>$path,'file_name'=>$file,'batch_no'=>$batch_no];
    }

    function utf8_to_tis620($string) {
        $str = $string;
        $res = "";
        for ($i = 0; $i < strlen($str); $i++) {
            if (ord($str[$i]) == 224) {
                $unicode = ord($str[$i+2]) & 0x3F;
                $unicode |= (ord($str[$i+1]) & 0x3F) << 6;
                $unicode |= (ord($str[$i]) & 0x0F) << 12;
                $res .= chr($unicode-0x0E00+0xA0);
                $i += 2;
            } else {
                $res .= $str[$i];
            }
        }
        return $res;
    }

    public function domesticCreateTTBFileTranfer($orderDirectDebit,$count_download=0)
    {
        $ttbHeader = DirectDebitRepo::createFileTranferTTB();

        $batch_no = autoWebBatchNumber();

        $strDetail = '';
        foreach ($orderDirectDebit as $key_debit => $debit) {

            $customer = Customers::byCustomerId($debit->customer_id);

            $orderHeader = OrderHeaders::where('order_header_id',$debit->order_header_id)->first();

            foreach ($ttbHeader as $key => $v) {
                if ($v["name"] == 'beneficiary_name') {
                    $length = $v['length'] - self::utf8_strlen($debit->customer_name);
                    $strDetail .= $debit->customer_name.sprintf("% {$length}s", '');
                }elseif ($v["name"] == 'beneficiary_address_1') {
                    $length = $v['length'] - self::utf8_strlen($customer->address_line1);
                    $strDetail .= $debit->address_line1.sprintf("% {$length}s", '');
                }elseif ($v["name"] == 'beneficiary_address_2') {
                    $length = $v['length'] - self::utf8_strlen($customer->address_line2);
                    $strDetail .= $debit->address_line2.sprintf("% {$length}s", '');
                }elseif ($v["name"] == 'beneficiary_address_3') {
                    $length = $v['length'] - self::utf8_strlen($customer->address_line3);
                    $strDetail .= $debit->address_line3.sprintf("% {$length}s", '');
                }elseif ($v["name"] == 'customer_reference') {
                    $strDetail .= $orderHeader->order_number.sprintf("% {$v['length']}s", '');
                }elseif ($v["name"] == 'payment_currency') {
                    $strDetail .= $orderHeader->currency;
                }elseif ($v["name"] == 'debit_account_number') {
                    $strDetail .= $debit->customer_account_number.sprintf("% {$v['length']}s", '');
                }elseif ($v["name"] == 'payment_amount') {
                    $strDetail .= sprintf("% {$v['length']}s", '').sprintf("%.2f",$debit->direct_debit_amount);
                }elseif ($v["name"] == 'beneficiary_bank_branch') {
                    $strDetail .= $debit->toat_branch_number.sprintf("% {$v['length']}s", '');
                }elseif ($v["name"] == 'beneficiary_account_number') {
                    $strDetail .= str_replace('-', '', $debit->toat_account_number).sprintf("% {$v['length']}s",'');
                }elseif ($v["name"] == 'advise_mode') {
                    $strDetail .= str_replace('-', '', $debit->toat_account_number).sprintf("% {$v['length']}s",'');
                }else{
                    $strDetail .= $v["value"];
                }
            }
        }

        if($count_download > 0){
            $strDetail .= $count_download;
        }

        $users = getDefaultData('/users');
        $path = $users->archive_directory;
        $file = 'TTB-'.date('YmdHis').'.txt';
        $data = Storage::disk('local')->put($path.'/'.$file,$strDetail);

        return ['file_path'=>$path,'file_name'=>$file,'batch_no'=>$batch_no];


    }

    public function domesticCreateFileTranferV2($orderDirectDebit, $count_download=0, $due_date='')
    {
        $ktbHeader = DirectDebitRepo::createFileTranferKTBV2();
        if($due_date == ''){
            $due_date = date('dmy');
        }else{
            $due_date = Carbon::createFromFormat('dmy', $due_date)->format('dmy');
        }
        $batch_no = autoWebBatchNumber();

        $strDetail = '';

        foreach ($ktbHeader as $key => $v) {
            if ($v["name"] == 'post_date') {
                $strDetail .= $due_date;
            }elseif($v["name"] == 'filler'){
                $strDetail .= sprintf("%075d", '');
            }else{
                $strDetail .= $v["value"];
            }
        }

        $strDetail .= "\r\n";
        $runDetail = 2;
        $amount = 0;
        foreach ($orderDirectDebit as $key_debit => $debit) {
            // $orderHeader = OrderHeaders::where('order_header_id',$debit->order_header_id)->first();
            // $customer = Customers::byCustomerId($debit->customer_id);
            $customer = Customers::where('customer_name', 'like', '%'.$debit->re_customer_name.'%')->get();
            $plCus = $customer->pluck('customer_number')->unique();
            $customerTxt = count($plCus) == 1? $customer->first()->customer_number: '999999';

            $length_d1 = 6 - strlen($runDetail);
            $d1 = sprintf("%0{$length_d1}d", '').$runDetail;

            $length_d5 = 10 - strlen(number_format((float)$debit->direct_debit_amount, 2, '', ''));
            $d5 = sprintf("%010d", number_format((float)$debit->direct_debit_amount, 2, '', ''));
            $length_d9 = 7 - strlen($customerTxt);
            $d9 = $customerTxt.sprintf("% {$length_d9}s", '');

            $strDetail .= 'D'.$d1.'006'.$debit->customer_account_number.'D'.$d5.'149'.$d9.sprintf("%087s", '');

            $runDetail += 1;
            $strDetail .= "\r\n";

            $amount += $debit->direct_debit_amount;
        }

        $length_t1 = 6 - strlen(($runDetail));
        $t1 = sprintf("%0{$length_t1}d", '').($runDetail);

        $length_t4 = 7 - strlen(count($orderDirectDebit));
        $t4 = sprintf("%0{$length_t4}d", '').(count($orderDirectDebit));

        $length_t5 = 13 - strlen(number_format((float)$amount, 2, '', ''));
        $t5 = sprintf("%0{$length_t5}d",'').number_format((float)$amount, 2, '', '');

        $strDetail .= 'T'.$t1.'0060091108322'.$t4.$t5.sprintf("%088s", '');

        // echo $strDetail;
        $users = getDefaultData('/users');
        $path = $users->archive_directory;
        if($count_download > 0){
            $file = 'KTB-'.date('YmdHis').'-'.$count_download.'.txt';
        }else{
            $file = 'KTB-'.date('YmdHis').'.txt';
        }

        $data = Storage::disk('local')->put($path.'/'.$file,$strDetail);

        return ['file_path'=>$path,'file_name'=>$file,'batch_no'=>$batch_no];
    }

    public function domesticCreateFileTranfer($orderDirectDebit,$count_download=0)
    {
        $ktbHeader = DirectDebitRepo::createFileTranferKTB();

        $ktbDetail = DirectDebitRepo::createDetailFileTranferKTB();

        $sumOrderDirectDebit = 0;

        foreach ($orderDirectDebit as $key => $v) {
            $sumOrderDirectDebit += $v->direct_debit_amount;
        }

        $batch_no = autoWebBatchNumber();

        $strHeader = '';
        foreach ($ktbHeader as $key => $v) {
            if ($v["name"] == 'batch_number') {
                $strHeader .= $batch_no;
            }elseif ($v["name"] == 'totol_transaction_in_batch') {
                $strHeader .= sprintf("%0{$v['length']}d", count($orderDirectDebit));
            }elseif ($v["name"] == 'total_amount') {
                $strHeader .= sprintf("%0{$v['length']}d", str_replace('.', '', $sumOrderDirectDebit));
            }else{
                $strHeader .= $v["value"];
            }
        }
        $strHeader .= "\r\n";

        $strDetail = '';
        foreach ($orderDirectDebit as $key_debit => $debit) {
            foreach ($ktbDetail as $key => $v) {
                if ($v["name"] == 'batch_no') {
                    $strDetail .= $batch_no;
                }elseif ($v["name"] == 'receiving_bank'){
                    $strDetail .= sprintf("%0{$v['length']}d", $debit->customer_bank_number);
                }elseif ($v["name"] == 'receiving_branch_code'){
                    $strDetail .= (strlen($debit->customer_branch_number) > $v['length']) ? substr($debit->customer_branch_number, -$v['length']) : $debit->customer_branch_number;
                }elseif ($v["name"] == 'receiving_ac'){
                    $strDetail .= sprintf("%0{$v['length']}d", $debit->customer_account_number);
                }elseif ($v["name"] == 'sending_branch_code'){
                    $strDetail .= (strlen($debit->toat_branch_number) > $v['length']) ? substr($debit->toat_branch_number, -$v['length']) : $debit->toat_branch_number;
                }elseif ($v["name"] == 'sending_ac'){
                    $strDetail .= sprintf("%0{$v['length']}d", str_replace('-', '', $debit->toat_account_number));
                }elseif ($v["name"] == 'amount'){
                    $strDetail .= sprintf("%0{$v['length']}d", str_replace('.', '', $debit->direct_debit_amount));
                }elseif ($v["name"] == 'receiver_name'){
                    $length = $v['length'] - self::utf8_strlen($debit->customer_name);
                    $strDetail .= $debit->customer_name.sprintf("%0{$length}d", '');
                }elseif ($v["name"] == 'sender_name'){
                    $length = $v['length'] - self::utf8_strlen($v["value"]);
                    $strDetail .= $v["value"].sprintf("%0{$length}d", '');
                }else{
                    $strDetail .= $v["value"];
                }
            }
            $strDetail .= "\r\n";
        }

        $users = getDefaultData('/users');
        $path = $users->archive_directory;
        if($count_download > 0){
            $file = 'KTB-'.date('YmdHis').'-'.$count_download.'.txt';
        }else{
            $file = 'KTB-'.date('YmdHis').'.txt';
        }

        $data = Storage::disk('local')->put($path.'/'.$file,$strHeader.$strDetail);

        return ['file_path'=>$path,'file_name'=>$file,'batch_no'=>$batch_no];
    }

    // add download file pdf
    public function downloadTransferDebit(Request $request)
    {
        $lines = explode(',', $request->lines);
        $st = dateConvertThaiEng(request()->from_date);
        $en = dateConvertThaiEng(request()->to_date);
        $bankId = request()->bank_id;
        $orders = collect(\DB::select("
            select *
                from  PTOM_DIRECT_DEBIT_OUTSTAND_V    pdd
                    ,(select max(delivery_date) delivery_date ,pod.customer_id, product_type_code
                        from ptom_order_direct_debit pod
                           ,ptom_order_headers      poh
                        where 1=1
                        and   pod.order_header_id   = poh.order_header_id
                        and ( trunc(approve_date) >= to_date('{$st}','YYYY-MM-DD')
                        and trunc(approve_date) <= to_date('{$en}','YYYY-MM-DD')
                        or trunc(approve_date) = to_date('{$st}','YYYY-MM-DD'))
                        and customer_bank_number = '{$bankId}'
                        group by   pod.customer_id, product_type_code
                        ) max_pre
                where 1=1
                and direct_debit_flag = 'Y'
                and prepare_order_number is not null
                and ( trunc(pdd.order_delivery_date) >= to_date('{$st}','YYYY-MM-DD')
                and trunc(pdd.order_delivery_date) <= to_date('{$en}','YYYY-MM-DD')
                or  trunc(approve_date) = to_date('{$st}','YYYY-MM-DD'))
                and pdd.order_delivery_date  = max_pre.delivery_date
                and pdd.customer_id    = max_pre.customer_id
                and pdd.product_type_code = max_pre.product_type_code
                and customer_bank_number = '{$bankId}'
                order by pdd.customer_id, pdd.prepare_order_number
        "))->whereIn('prepare_order_number', $lines);

        $orderAmounts = DirectDebitOutStandV::selectRaw("direct_debit_amount, product_type_code||'-'||customer_id as group_type")
                                    ->whereNotNull('prepare_order_number')
                                    ->where('direct_debit_flag', 'Y')
                                    ->whereIn('prepare_order_number', $lines)
                                    ->where(function($query) {
                                        if(request()->bank_id && request()->bank_id != ''){
                                            $query->whereRaw("customer_bank_number = '".request()->bank_id."' ");
                                        }
                                        if(request()->from_date && request()->from_date != ''){
                                            $query->where('approve_date', '>=', dateConvertThaiEng(request()->from_date));
                                        }
                                        if(request()->to_date && request()->to_date != ''){
                                            $query->where('approve_date', '<=', dateConvertThaiEng(request()->to_date));
                                        }
                                    })
                                    ->get();

        $orderAmount = $orderAmounts->groupBy('group_type')->mapWithKeys(function ($item, $group) {
                                $groupName = $item->first()->group_type;
                                return [$groupName => $item->sum('direct_debit_amount')];
                            })->toArray();

        $pdf = \PDF::loadView('om.order_direct_debit.domestic.print', compact('orders', 'orderAmount'))
                ->setOption('margin-left', '5')
                ->setOption('margin-right', '5')
                ->setOption('margin-top', '10')
                ->setOption('margin-bottom', '5');
            return $pdf->stream('รายงานการโอนเงินระบบ Direct Debit.pdf');
    }


}