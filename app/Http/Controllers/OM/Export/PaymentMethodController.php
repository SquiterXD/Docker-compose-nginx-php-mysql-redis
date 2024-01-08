<?php

namespace App\Http\Controllers\OM\Export;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\Customer;
use App\Models\OM\AttachFiles;
use App\Models\OM\BankAccounts;
use App\Models\OM\Customers;
use App\Models\OM\DomesticMatching\PaymentApply;
use App\Models\OM\OrderHeaders;
use App\Models\OM\OverdueDebt\PaymentApplyCNDN;
use App\Models\OM\OverdueDebt\ProformaInvoiceHeaders;
use App\Models\OM\PaymentHeader;
use App\Models\OM\PaymentLines;
use App\Models\OM\PaymentMatchInvoice;
use App\Models\OM\PtomCustomer;
use App\Models\OM\SaleConfirmation\OrderHistory;
use App\Repositories\OM\OrderRepo;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Exception;
use FormatDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\View;

class PaymentMethodController extends Controller
{
    public function index()
    {
        if(request()->action == 'type_memo') {
            try {
                $message = '';
                $status = true;
                $paymentHeader = PaymentHeader::where('payment_number', request()->payment_number)->first();
                $paymentHeader->remark = request()->remark;
                $paymentHeader->save();
            } catch (\Throwable $th) {
                $message = $th->getMessage();
                $status = false;
            }
            return ['status' => $status, 'message' => $message];

        }
        $customers = Customers::whereRaw("UPPER(sales_classification_code) = 'EXPORT'")->orderBy('customer_number', 'ASC')->get(['customer_id', 'customer_number', 'customer_name', 'sales_classification_code', 'address_line1', 'address_line2', 'address_line3', 'city', 'district', 'alley', 'province_name', 'currency', 'postal_code', 'country_name', 'state', 'country_code']);
        $banks = BankAccounts::get(['bank_number', 'bank_branch_name']);
        $methods = DB::table('ptom_payment_method_export')->whereNull('tag')->select('lookup_code', 'meaning', 'description')->get();
        $bankdesc = DB::table('oaom.ptom_receipt_bank_acc_v')->whereNotNull('mapping_om_type')->select('bank_account_name')->get();
        $paymenynumberref = DB::table('ptom_payment_headers')->leftJoin('ptom_customers', 'ptom_payment_headers.customer_id', 'ptom_customers.customer_id')->whereRaw("UPPER(ptom_customers.sales_classification_code) = 'EXPORT'")->select('ptom_payment_headers.payment_number', 'ptom_customers.customer_name', 'ptom_payment_headers.payment_date')->orderBy('ptom_payment_headers.payment_number', 'DESC')->get();

        if (request()->all()) {
            $requests = request()->all();
            $requests['callback_search_omp67'] = true;
            $validator = Validator::make(request()->all(), [
                'payment_number' => 'required',
            ], [
                'payment_number.required' => 'กรุณาระบุเลขที่ใบเสร็จรับเงิน',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first())->withInput($requests);
            }

            $infodata = PaymentHeader::with(array('paymentMethod' => function ($query) {
                $query->orderBy('ptom_payment_details.line_number', 'ASC');
            }, 'customer', 'files' => function ($query) {
                $query->where('ptom_attachments.attachment_program_code', '=', 'OMP0067');
            }))->where('ptom_payment_headers.payment_number', $requests['payment_number'])->first();

            if (empty($infodata)) {
                return back()->withErrors('ไม่พบข้อมูลที่ค้นหา')->withInput($requests);
            }

            $paymentsmethod = PaymentMatchInvoice::where('payment_header_id', $infodata->payment_header_id)->where('match_flag', 'Y')->groupBy(['match_exchange_rate', 'prepare_order_number', 'due_date', 'credit_group_code', 'match_flag', 'due_day', 'invoice_id', 'creation_date', 'payment_header_id', 'outstanding_debt', 'currency', 'invoice_number', 'payment_type_code'])->get(['match_exchange_rate', 'prepare_order_number', 'due_date', 'credit_group_code', 'match_flag', 'due_day', 'invoice_id', 'creation_date', 'payment_header_id', DB::raw("SUM(payment_amount) payment_amount"), 'outstanding_debt', 'currency', 'invoice_number', 'payment_type_code']);
            $defineDN = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS,PTOM_INVOICE_HEADERS.CURRENCY FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $infodata->customer->customer_id . " AND PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NULL");
            //add fines
            $defineCN = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $infodata->customer->customer_id . " AND PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE != 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NULL"); //denied fines

            $dataordernumber = DB::select("SELECT PREPARE_ORDER_NUMBER FROM PTOM_ORDER_HEADERS WHERE SA_STATUS = 'Confirm' AND SALE_CONFIRM_FLAG = 'Y' AND CUSTOMER_ID = " . $infodata->customer->customer_id);

            $datainvoices = [];
            $datainvoice = DB::select("SELECT PTOM_ORDER_HEADERS.PICK_RELEASE_NO,SUM(CASE WHEN PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' THEN PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT ELSE 0 END) PAYMENT_AMOUNT,SUM(PTOM_ORDER_CREDIT_GROUPS.AMOUNT) TOTAL_AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_PRODUCT_TYPE_EXPORT ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_EXPORT.LOOKUP_CODE LEFT JOIN PTOM_PAYMENT_MATCH_INVOICES ON (PTOM_ORDER_HEADERS.PICK_RELEASE_ID = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID IS NULL) LEFT JOIN PTOM_PAYMENT_APPLY_CNDN ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_MATCH_ID = PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID WHERE PTOM_ORDER_HEADERS.CUSTOMER_ID = '" . $infodata->customer->customer_id . "' AND UPPER(PTOM_ORDER_HEADERS.ORDER_STATUS) = 'CONFIRM' AND UPPER(PTOM_ORDER_HEADERS.PAYMENT_APPROVE_FLAG) = 'Y' AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 AND PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL GROUP BY PTOM_ORDER_HEADERS.PICK_RELEASE_NO");
            foreach ($datainvoice as $key => $dtiv) {
                array_push($datainvoices, $dtiv->pick_release_no);
            }
        } else {
            $requests['callback_search_omp67'] = false;
            $dataordernumber = [];
            $infodata = [];
            $defineDN = [];
            $defineCN = [];
            $customerinfo = [];
            $datainvoices = [];
            $paymentsmethod = [];
        }

        request()->session()->flashInput($requests);

        return view('om.exports.paymentMethod.index', compact('customers', 'banks', 'methods', 'infodata', 'defineDN', 'defineCN', 'paymenynumberref', 'bankdesc', 'dataordernumber', 'datainvoices', 'paymentsmethod'));
    }

    // public function getinfofordraft(Request $request)
    // {
    //     $customer = Customers::where('customer_number', $request->customer_number)->first();
    //     if (empty($customer)) {
    //         return response()->json(['dataordernumbers' => '', 'datainvoices' => '']);
    //     }
    //     $dataordernumbers = [];
    //     $dataordernumber = DB::select("SELECT ORDER_HEADER_ID,PREPARE_ORDER_NUMBER FROM PTOM_ORDER_HEADERS WHERE SA_STATUS = 'Confirm' AND SALE_CONFIRM_FLAG = 'Y' AND CUSTOMER_ID = $customer->customer_id ORDER BY PREPARE_ORDER_NUMBER DESC");
    //     foreach ($dataordernumber as $key => $dton) {
    //         $orderc = OrderHeader::where('prepare_order_number', $dton->prepare_order_number)->first();
    //         $paymentc = PaymentMatchInvoice::where('prepare_order_number', $dton->prepare_order_number)->where('match_flag', 'Y');

    //         $iddncn = [];
    //         foreach ($paymentc->get() as $paymentcc) {
    //             array_push($iddncn, $paymentcc->payment_match_id);
    //         }

    //         if (count($iddncn) == 0) {
    //             $amountreal = $paymentc->sum('payment_amount') ?? 0;
    //         } else {
    //             $amountnotreal = $paymentc->sum('payment_amount') ?? 0;
    //             $applyc = PaymentApply::whereIn('payment_match_id', $iddncn)->sum('invoice_amount');
    //             $amountreal = $amountnotreal + $applyc;
    //         }

    //         $dbsumtotal = DB::select("SELECT SUM(AMOUNT) TOTAL_AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS WHERE ORDER_HEADER_ID = $dton->order_header_id AND ORDER_LINE_ID != 0");

    //         $ordercamount = $dbsumtotal[0]->total_amount ?? 0;
    //         $paymentcamount = $amountreal;

    //         if ($ordercamount != $paymentcamount) {
    //             array_push($dataordernumbers, $dton->prepare_order_number);
    //         }
    //     }
    //     $defineDN = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $customer->customer_id . " AND PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NULL ORDER BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER DESC"); //add fines
    //     foreach ($defineDN as $key => $dfn) {
    //         array_push($dataordernumbers, $dfn->invoice_header_number);
    //     }

    //     $datainvoices = [];
    //     $datainvoice = DB::select("SELECT PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PICK_RELEASE_NO,SUM(CASE WHEN PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' THEN PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT ELSE 0 END) PAYMENT_AMOUNT,SUM(PTOM_ORDER_CREDIT_GROUPS.AMOUNT) TOTAL_AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_PRODUCT_TYPE_EXPORT ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_EXPORT.LOOKUP_CODE LEFT JOIN PTOM_PAYMENT_MATCH_INVOICES ON (PTOM_ORDER_HEADERS.PICK_RELEASE_ID = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID IS NULL) LEFT JOIN PTOM_PAYMENT_APPLY_CNDN ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_MATCH_ID = PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID WHERE PTOM_ORDER_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND UPPER(PTOM_ORDER_HEADERS.ORDER_STATUS) = 'CONFIRM' AND UPPER(PTOM_ORDER_HEADERS.PAYMENT_APPROVE_FLAG) = 'Y' AND PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 GROUP BY PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PICK_RELEASE_NO ORDER BY PTOM_ORDER_HEADERS.PICK_RELEASE_NO DESC");
    //     foreach ($datainvoice as $key => $dtiv) {
    //         $orderc = OrderHeader::where('pick_release_no', $dtiv->pick_release_no)->first();
    //         $paymentc = PaymentMatchInvoice::where('prepare_order_number', $orderc->prepare_order_number)->where('match_flag', 'Y');

    //         $iddncn = [];
    //         $sumpayment = 0;
    //         foreach ($paymentc->get() as $paymentcc) {
    //             $detailss = PaymentLines::where('payment_detail_id', $paymentcc->payment_detail_id)->first();
    //             if (empty($detailss)) {
    //                 $sumpayment += $paymentcc->sum('payment_amount') ?? 0;
    //             } else {
    //                 $sumpayment += $paymentcc->payment_amount * $detailss->conversion_rate;
    //             }
    //             array_push($iddncn, $paymentcc->payment_match_id);
    //         }

    //         if (count($iddncn) == 0) {
    //             $amountreal = $sumpayment;
    //         } else {
    //             $amountnotreal = $sumpayment;
    //             $applyc = PaymentApply::whereIn('payment_match_id', $iddncn)->sum('invoice_amount');
    //             $amountreal = $amountnotreal + $applyc;
    //         }

    //         $dbsumtotal = DB::select("SELECT SUM(AMOUNT) TOTAL_AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS WHERE ORDER_HEADER_ID = $dtiv->order_header_id AND ORDER_LINE_ID != 0");

    //         $ordercamount = $dbsumtotal[0]->total_amount ?? 0;
    //         $paymentcamount = $amountreal;

    //         if ($ordercamount != $paymentcamount) {
    //             array_push($datainvoices, $dtiv->pick_release_no);
    //         }
    //     }

    //     $invocess = DB::select("SELECT PTOM_INVOICE_HEADERS.REF_INVOICE_NUMBER, PTOM_PROFORMA_INVOICE_HEADERS.ORDER_HEADER_ID,PTOM_PROFORMA_INVOICE_HEADERS.SA_NUMBER, SUM(PTOM_PROFORMA_INVOICE_LINES.TOTAL_AMOUNT) TOTAL_AMOUNT FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_PROFORMA_INVOICE_HEADERS ON PTOM_INVOICE_HEADERS.DOCUMENT_ID = PTOM_PROFORMA_INVOICE_HEADERS.PI_HEADER_ID LEFT JOIN PTOM_PROFORMA_INVOICE_LINES ON PTOM_PROFORMA_INVOICE_HEADERS.PI_HEADER_ID = PTOM_PROFORMA_INVOICE_LINES.PI_HEADER_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NOT NULL AND PTOM_INVOICE_HEADERS.REF_INVOICE_NUMBER IS NOT NULL AND PTOM_PROFORMA_INVOICE_HEADERS.ORDER_STATUS = 'Confirm' AND PTOM_PROFORMA_INVOICE_HEADERS.PAYMENT_TYPE_CODE != '10' GROUP BY PTOM_INVOICE_HEADERS.REF_INVOICE_NUMBER,PTOM_PROFORMA_INVOICE_HEADERS.ORDER_HEADER_ID,PTOM_PROFORMA_INVOICE_HEADERS.SA_NUMBER");
    //     foreach ($invocess as $key => $dtivv) {
    //         if ($dtivv->ref_invoice_number != null) {
    //             $orderc = OrderHeader::where('order_header_id', $dtivv->order_header_id)->first();
    //             $paymentc = PaymentMatchInvoice::where('prepare_order_number', $orderc->sa_number)->where('match_flag', 'Y');

    //             $iddncn = [];
    //             foreach ($paymentc->get() as $paymentcc) {
    //                 array_push($iddncn, $paymentcc->payment_match_id);
    //             }

    //             if (count($iddncn) == 0) {
    //                 $amountreal = $paymentc->sum('payment_amount') ?? 0;
    //             } else {
    //                 $amountnotreal = $paymentc->sum('payment_amount') ?? 0;
    //                 $applyc = PaymentApply::whereIn('payment_match_id', $iddncn)->sum('invoice_amount');
    //                 $amountreal = $amountnotreal + $applyc;
    //             }

    //             $ordercamount = $orderc->grand_total ?? 0;
    //             $paymentcamount = $amountreal;

    //             if ($ordercamount != $paymentcamount) {
    //                 array_push($datainvoices, $dtivv->ref_invoice_number);
    //             }
    //         }
    //     }

    //     $datadebit = [];
    //     $debits = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_PROFORMA_INVOICE_HEADERS.ORDER_HEADER_ID,PTOM_PROFORMA_INVOICE_HEADERS.SA_NUMBER, SUM(PTOM_PROFORMA_INVOICE_LINES.TOTAL_AMOUNT) TOTAL_AMOUNT FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_PROFORMA_INVOICE_HEADERS ON PTOM_INVOICE_HEADERS.DOCUMENT_ID = PTOM_PROFORMA_INVOICE_HEADERS.PI_HEADER_ID LEFT JOIN PTOM_PROFORMA_INVOICE_LINES ON PTOM_PROFORMA_INVOICE_HEADERS.PI_HEADER_ID = PTOM_PROFORMA_INVOICE_LINES.PI_HEADER_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NOT NULL  AND PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER IS NOT NULL AND PTOM_PROFORMA_INVOICE_HEADERS.ORDER_STATUS = 'Confirm' AND PTOM_PROFORMA_INVOICE_HEADERS.PAYMENT_TYPE_CODE != '10' GROUP BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_PROFORMA_INVOICE_HEADERS.ORDER_HEADER_ID,PTOM_PROFORMA_INVOICE_HEADERS.SA_NUMBER");

    //     foreach ($debits as $key => $dtivvv) {
    //         if ($dtivvv->invoice_headers_number != null) {
    //             $orderc = OrderHeader::where('order_header_id', $dtivvv->order_header_id)->first();
    //             $paymentc = PaymentMatchInvoice::where('prepare_order_number', $orderc->sa_number)->where('match_flag', 'Y');

    //             $iddncn = [];
    //             foreach ($paymentc->get() as $paymentcc) {
    //                 array_push($iddncn, $paymentcc->payment_match_id);
    //             }

    //             if (count($iddncn) == 0) {
    //                 $amountreal = $paymentc->sum('payment_amount') ?? 0;
    //             } else {
    //                 $amountnotreal = $paymentc->sum('payment_amount') ?? 0;
    //                 $applyc = PaymentApply::whereIn('payment_match_id', $iddncn)->sum('invoice_amount');
    //                 $amountreal = $amountnotreal + $applyc;
    //             }

    //             $ordercamount = $orderc->grand_total ?? 0;
    //             $paymentcamount = $amountreal;

    //             if ($ordercamount != $paymentcamount) {
    //                 array_push($datadebit, $dtivvv->invoice_headers_number);
    //             }
    //         }
    //     }

    //     $defineCN = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $customer->customer_id . " AND PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE != 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NULL");

    //     return response()->json(['dataordernumbers' => $dataordernumbers, 'datainvoices' => $datainvoices, 'defineDN' => json_decode(json_encode($defineDN)), 'defineCN' => json_decode(json_encode($defineCN)), 'datadebits' => json_decode(json_encode($datadebit))]);
    // }

    public function unmatchall(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'number_payment' => 'required',
        ], [
            'number_payment.required' => 'ข้อมูลไม่ถูกต้อง',
        ]);
        if ($validator->fails()) {
            return response()->json(array('status' => 'error', 'message' => $validator->errors()->first()));
        }

        $apps = DB::select("SELECT PERIOD_NAME,CLOSING_STATUS FROM APPS.GL_PERIOD_STATUSES WHERE TO_CHAR(START_DATE, 'YYYY-MM-DD') <= '" . Carbon::now()->format('Y-m-d') . "' AND TO_CHAR(END_DATE, 'YYYY-MM-DD') >= '" . Carbon::now()->format('Y-m-d') . "' ORDER BY LAST_UPDATE_DATE DESC FETCH FIRST 1 ROWS ONLY");
        if (empty($apps)) {
            return response()->json(array('status' => 'error', 'message' => 'ไม่พบข้อมูล APPS.GL_PERIOD_STATUSES'));
        }

        if ($apps[0]->closing_status != 'O') {
            return response()->json(array('status' => 'error', 'message' => 'กรุณาเปิด AR period ของ ' . $apps[0]->period_name . ' ก่อน'));
        }

        $payment = PaymentHeader::where('payment_number', $request->number_payment)->first();
        if (empty($payment)) {
            return response()->json(array('status' => 'error', 'message' => 'ไม่พบข้อมูลการชำระเงิน'));
        }

        if ($payment->payment_status != 'Confirm') {
            return response()->json(array('status' => 'error', 'message' => 'การชำระเงินนี้ไม่สามารถยกเลิกการชำระเงินได้'));
        }

        $matchs = PaymentMatchInvoice::where('payment_header_id', $payment->payment_header_id)->get();
        if (!empty($matchs)) {
            foreach ($matchs as $match) {
                $match->match_flag = 'N';
                $match->last_update_date = Carbon::now();
                $match->save();
            }

            $payment->total_remain_amount = 0;
            $payment->total_previous_remain_amount = 0;
            $payment->total_amount_with_vat = 0;
            $payment->total_payment_amount = 0;
            $payment->last_update_date = Carbon::now();
            $payment->save();
            return response()->json(array('status' => 'success', 'message' => 'unmatch สำเร็จ'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'ไม่พบรายการ matching'));
        }
    }

    public function matchsave(Request $request)
    {
        // dd($request->all());
        if ($request->number_payment_status == 'Cancel') {
            $payment = $this->concelpayment($request);
            if ($payment == 'false') {
                $request->session()->flashInput($request->all());
                return redirect()->back()->withErrors('ไม่สามารถดำเนินการยกเลิกได้');
            } else {
                $msg = "ยกเลิกเรียบร้อยแล้ว";
            }

            if ($payment == 'false') {
                $request->session()->flashInput($request->all());
                return redirect()->back()->withErrors('บันทึกข้อมูลไม่สำเร็จหรือการเปลี่ยนแปลงล้มเหลว');
            }
            return back()->with('success', $msg);
        } else {
            $validator = Validator::make($request->all(), [
                'payment_number' => 'required',
                'exchang_rate.*' => 'required',
            ], [
                'payment_number.required' => 'ข้อมูลไม่ถูกต้อง',
                'exchang_rate.*.required' => 'กรุณาระบุรายละเอียดอัตราการแลกเปลี่ยน',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first());
            }
            $payment = PaymentHeader::where('payment_number', $request->payment_number)->first();

            if (empty($payment)) {
                return redirect()->back()->withErrors('ไม่พบข้อมูลการชำระเงิน');
            }

            if ($payment->payment_status != 'Confirm') {
                return redirect()->back()->withErrors('ไม่สามารถดำเนินการต่อได้');
            }

            $user_id = getDefaultData('/users')->user_id;
            if ($request->match_check) {
                foreach ($request->match_check as $k => $value_match) {
                    $data_expld = explode(':', $value_match);
                    if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                        $invoce = DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $data_expld[0])->first();
                    } else {
                        $invoce = DB::table('ptom_order_headers')->select('pick_release_id', 'prepare_order_number', 'payment_type_code')->where('order_header_id', '=', $data_expld[0])->first();
                    }

                    if ($invoce) {
                        // $ddptom = DB::select("SELECT PICK_RELEASE_NO FROM PTOM_PROFORMA_INVOICE_HEADERS WHERE ORDER_HEADER_ID = '" . $data_expld[0] . "'");
                        if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                            $i1 = $invoce->invoice_headers_id;
                            $i2 = '';
                        } else {
                            $i1 = $invoce->pick_release_id;
                            $i2 = $invoce->prepare_order_number;
                        }
                    } else {
                        $i1 = '';
                        $i2 = '';
                    }

                    $dt = $request->invoice_duedate[$data_expld[2]];
                    if ($dt == '' || $dt == null) {
                        $dtin = '';
                    } else {
                        $dtin = Carbon::parse($dt)->format('Y-m-d');
                    }

                    if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                        $i3 = $request->doc_id[$data_expld[2]];
                    } else {
                        $i3 = $request->pick_no[$data_expld[2]];
                    }

                    $linenumber = 0;
                    $details = PaymentLines::where('payment_header_id', $payment->payment_header_id)->orderBy('payment_detail_id', 'ASC')->get();
                    $paymment_amount_total = str_replace(',', '', $request->amount_balancetotal[$data_expld[2]]);
                    foreach ($details as $d) {
                        if ($paymment_amount_total > 0) {
                            $sumd = PaymentMatchInvoice::where('payment_detail_id', $d->payment_detail_id)->where('match_flag', 'Y')->sum('payment_amount');
                            if ($paymment_amount_total > $d->conversion_amount && $sumd < $d->conversion_amount) {
                                $ids = PaymentMatchInvoice::create([
                                    'payment_header_id' => $payment->payment_header_id,
                                    'payment_detail_id' => $d->payment_detail_id,
                                    'invoice_id' => $i1,
                                    'invoice_number' => $i3,
                                    'prepare_order_number' => $i2,
                                    'match_exchange_rate' => $request->exchang_rate[$data_expld[2]],
                                    // 'credit_group_code' => $request->credit_group[$data_expld[2]],
                                    'due_day' => $request->credit_day[$data_expld[2]],
                                    'due_date' => $dtin,
                                    'payment_amount' => abs($paymment_amount_total - abs($paymment_amount_total - $d->conversion_amount)),
                                    'match_flag' => 'Y',
                                    'payment_type_code' => $invoce->payment_type_code ?? '',
                                    'currency' => $request->currency[$data_expld[2]],
                                    'program_code' => 'OMP0067',
                                    'created_by' => $user_id,
                                    'last_updated_by' => $user_id,
                                    'outstanding_debt' => str_replace(',', '', $request->amount_vat[$data_expld[2]]),
                                ]);

                                if ($data_expld[1] == 'DRAFT') {
                                    $ar = $request->matchid[$data_expld[2]];
                                    if ($ar != null) {
                                        $ar1 = str_replace("[", "(", $ar);
                                        $ar2 = str_replace("]", ")", $ar1);
                                        $matid = DB::select("SELECT * FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_ID IN $ar2");

                                        if (!empty($matid) && $matid != null) {
                                            foreach ($matid as $keymath => $idmath) {
                                                $linenumber++;
                                                $chck = PaymentApply::where('invoice_header_id', $idmath->invoice_headers_id)->where(function($q) {
                                                    $q->where('attribute1', 'N');
                                                    $q->orWhereNull('attribute1');
                                                });
                                                if ($chck->count() > 0) {
                                                    $updatecndn = $chck->first();
                                                    $updatecndn->payment_match_id = $ids->payment_match_id;
                                                    $updatecndn->line_number = $linenumber;
                                                    $updatecndn->last_updated_by = $user_id;
                                                    $updatecndn->last_update_date = Carbon::now();
                                                    $updatecndn->attribute1 = 'Y';
                                                    $updatecndn->save();
                                                } else {
                                                    PaymentApply::create([
                                                        'payment_match_id' => $ids->payment_match_id,
                                                        'line_number' => $linenumber,
                                                        'invoice_header_id' => $idmath->invoice_headers_id,
                                                        'invoice_number' => $idmath->invoice_headers_number,
                                                        'order_header_id' => $idmath->document_id,
                                                        'pick_release_no' => $i3,
                                                        'arrtibute1' => 'Y',
                                                        'arrtibute2' => $idmath->invoice_type,
                                                        'program_code' => 'OMP0067',
                                                        'credit_group_code',
                                                        'invoice_amount' => str_replace(',', '', $idmath->invoice_amount),
                                                        'created_by' => $user_id,
                                                        'last_updated_by' => $user_id,
                                                    ]);
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $linenumber++;
                                    $matid = DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $data_expld[0])->first();
                                    $cnmatch = DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $request->matchid[$data_expld[2]])->first();
                                    if (empty($cnmatch) || strpos($cnmatch->invoice_headers_number, 'DN') !== false) {
                                    } else {
                                        PaymentApply::create([
                                            'payment_match_id' => $ids->payment_match_id,
                                            'line_number' => $linenumber,
                                            'invoice_header_id' => $cnmatch->invoice_headers_id,
                                            'invoice_amount' => str_replace(',', '', $cnmatch->invoice_amount),
                                            'program_code' => 'OMP0067',
                                            'created_by' => $user_id,
                                            'last_updated_by' => $user_id,
                                            'invoice_number' => $cnmatch->invoice_headers_number,
                                            'attribute1' => 'Y',
                                            'attribute2' => $cnmatch->invoice_type
                                        ]);
                                    }
                                    // DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $pa->invoice_headers_id)->update(array('document_id' => $invoce->pick_release_id));
                                }

                                $paymment_amount_total = $paymment_amount_total - $d->conversion_amount;
                            } else {
                                if ($sumd < $d->conversion_amount) {
                                    $ids = PaymentMatchInvoice::create([
                                        'payment_header_id' => $payment->payment_header_id,
                                        'payment_detail_id' => $d->payment_detail_id,
                                        'invoice_id' => $i1,
                                        'invoice_number' => $i3,
                                        'prepare_order_number' => $i2,
                                        'match_exchange_rate' => $request->exchang_rate[$data_expld[2]],
                                        // 'credit_group_code' => $request->credit_group[$data_expld[2]],
                                        'due_day' => $request->credit_day[$data_expld[2]],
                                        'due_date' => $dtin,
                                        'payment_amount' => abs($paymment_amount_total),
                                        'match_flag' => 'Y',
                                        'payment_type_code' => $invoce->payment_type_code ?? '',
                                        'currency' => $request->currency[$data_expld[2]],
                                        'program_code' => 'OMP0067',
                                        'created_by' => $user_id,
                                        'last_updated_by' => $user_id,
                                        'outstanding_debt' => str_replace(',', '', $request->amount_vat[$data_expld[2]]),
                                    ]);

                                    if ($data_expld[1] == 'DRAFT') {
                                        $ar = $request->matchid[$data_expld[2]];
                                        if ($ar != null) {
                                            $ar1 = str_replace("[", "(", $ar);
                                            $ar2 = str_replace("]", ")", $ar1);
                                            $matid = DB::select("SELECT * FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_ID IN $ar2");
                                            if (!empty($matid) && $matid != null) {
                                                foreach ($matid as $keymath => $idmath) {
                                                    $linenumber++;
                                                    $chck = PaymentApply::where('invoice_header_id', $idmath->invoice_headers_id)->where(function($q) {
                                                        $q->where('attribute1', 'N');
                                                        $q->orWhereNull('attribute1');
                                                    });
                                                    if ($chck->count() > 0) {
                                                        $updatecndn = $chck->first();
                                                        $updatecndn->payment_match_id = $ids->payment_match_id;
                                                        $updatecndn->line_number = $linenumber;
                                                        $updatecndn->last_updated_by = $user_id;
                                                        $updatecndn->last_update_date = Carbon::now();
                                                        $updatecndn->attribute1 = 'Y';
                                                        $updatecndn->save();
                                                    } else {
                                                        PaymentApply::create([
                                                            'payment_match_id' => $ids->payment_match_id,
                                                            'line_number' => $linenumber,
                                                            'invoice_header_id' => $idmath->invoice_headers_id,
                                                            'invoice_number' => $idmath->invoice_headers_number,
                                                            'order_header_id' => $idmath->document_id,
                                                            'pick_release_no' => $i3,
                                                            'arrtibute1' => 'Y',
                                                            'arrtibute2' => $idmath->invoice_type,
                                                            'credit_group_code',
                                                            'invoice_amount' => str_replace(',', '', $idmath->invoice_amount),
                                                            'program_code' => 'OMP0067',
                                                            'created_by' => $user_id,
                                                            'last_updated_by' => $user_id,
                                                        ]);
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        $linenumber++;
                                        $matid = DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $data_expld[0])->first();
                                        $cnmatch = DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $request->matchid[$data_expld[2]])->first();
                                        if (empty($cnmatch) || strpos($cnmatch->invoice_headers_number, 'DN') !== false) {
                                        } else {
                                            $pa = PaymentApply::create([
                                                'payment_match_id' => $ids->payment_match_id,
                                                'line_number' => $linenumber,
                                                'invoice_header_id' => $cnmatch->invoice_headers_id,
                                                'invoice_amount' => str_replace(',', '', $cnmatch->invoice_amount),
                                                'program_code' => 'OMP0067',
                                                'created_by' => $user_id,
                                                'last_updated_by' => $user_id,
                                                'invoice_number' => $cnmatch->invoice_headers_number,
                                                'attribute1' => 'Y',
                                                'attribute2' => $cnmatch->invoice_type
                                            ]);
                                        }
                                        // DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $pa->invoice_headers_id)->update(array('document_id' => $invoce->pick_release_id));
                                    }

                                    $paymment_amount_total = $paymment_amount_total - $d->conversion_amount;
                                }
                            }
                        }
                    }
                }
            }

            $number_p = $payment->payment_number;

            $payment->total_amount_with_vat = str_replace(',', '', $request->totalvat_amounts);
            $payment->total_amount_match = str_replace(',', '', $request->match_count_amounts);
            $payment->total_fine = str_replace(',', '', $request->paycount_amounts);
            $payment->total_payment_amount = str_replace(',', '', $request->total_amounts);
            $payment->total_previous_remain_amount = str_replace(',', '', $request->bbalance_amounts);
            $payment->total_remain_amount = str_replace(',', '', $request->balance_amounts);
            $payment->last_update_date = Carbon::now();
            $payment->save();

            return redirect('/om/export-payout?payment_number=' . $number_p)->with('success', 'บันทึกเรียบร้อยแล้ว');
        }
    }

    public function getvaluefromnumber(Request $request)
    {
        $number = $request->number;
        $credit = $request->credit_code;

        if ($credit == null || $credit == '') {
            $DPayment = DB::select("SELECT PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
            PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
            PTOM_INVOICE_HEADERS.REF_INVOICE_NUMBER,
            PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,
            PTOM_PRODUCT_TYPE_EXPORT.DESCRIPTION,
            SUM(PTOM_ORDER_CREDIT_GROUPS.AMOUNT) TOTAL_AMOUNT,
            PTOM_ORDER_HEADERS.ORDER_DATE,
            PTOM_ORDER_HEADERS.PAYMENT_TYPE_CODE,
            PTOM_ORDER_HEADERS.CURRENCY,
            PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE
                FROM PTOM_ORDER_CREDIT_GROUPS
                LEFT JOIN PTOM_ORDER_HEADERS
                    ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID
                LEFT JOIN PTOM_PRODUCT_TYPE_EXPORT
                    ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_EXPORT.LOOKUP_CODE
                LEFT JOIN PTOM_PAYMENT_MATCH_INVOICES
                    ON (PTOM_ORDER_HEADERS.PICK_RELEASE_ID = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID IS NULL)
                LEFT JOIN PTOM_PROFORMA_INVOICE_HEADERS
                    ON PTOM_ORDER_HEADERS.ORDER_HEADER_ID = PTOM_PROFORMA_INVOICE_HEADERS.ORDER_HEADER_ID
                LEFT JOIN PTOM_INVOICE_HEADERS
                    ON PTOM_PROFORMA_INVOICE_HEADERS.PI_HEADER_ID = PTOM_INVOICE_HEADERS.DOCUMENT_ID
                WHERE PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER = '" . $number . "' AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 GROUP BY PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
                        PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
                        PTOM_PRODUCT_TYPE_EXPORT.DESCRIPTION,
                        PTOM_ORDER_HEADERS.ORDER_DATE,
                        PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE,
                        PTOM_ORDER_HEADERS.PAYMENT_TYPE_CODE,PTOM_ORDER_HEADERS.CURRENCY,PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER");
            if (count($DPayment) > 1) {
                $info = array();
                foreach ($DPayment as $dp) {
                    array_push($info, $dp);
                }
                return response()->json(['status' => 'choose', 'data' => $info]);
            }
        } else {
            $DPayment = DB::select("SELECT PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
            PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
            PTOM_INVOICE_HEADERS.REF_INVOICE_NUMBER,
            PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,
            PTOM_PRODUCT_TYPE_EXPORT.DESCRIPTION,
            SUM(PTOM_ORDER_CREDIT_GROUPS.AMOUNT) TOTAL_AMOUNT,
            PTOM_ORDER_HEADERS.ORDER_DATE,
            PTOM_ORDER_HEADERS.PAYMENT_TYPE_CODE,
            PTOM_ORDER_HEADERS.CURRENCY,
            PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE
                FROM PTOM_ORDER_CREDIT_GROUPS
                LEFT JOIN PTOM_ORDER_HEADERS
                    ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID
                LEFT JOIN PTOM_PRODUCT_TYPE_EXPORT
                    ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_EXPORT.LOOKUP_CODE
                LEFT JOIN PTOM_PAYMENT_MATCH_INVOICES
                    ON (PTOM_ORDER_HEADERS.PICK_RELEASE_ID = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID IS NULL)
                LEFT JOIN PTOM_PROFORMA_INVOICE_HEADERS
                    ON PTOM_ORDER_HEADERS.ORDER_HEADER_ID = PTOM_PROFORMA_INVOICE_HEADERS.ORDER_HEADER_ID
                LEFT JOIN PTOM_INVOICE_HEADERS
                    ON PTOM_PROFORMA_INVOICE_HEADERS.PI_HEADER_ID = PTOM_INVOICE_HEADERS.DOCUMENT_ID
                WHERE PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER = '" . $number . "' AND PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE = '" . $credit . "' AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 GROUP BY PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
                        PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
                        PTOM_PRODUCT_TYPE_EXPORT.DESCRIPTION,
                        PTOM_ORDER_HEADERS.ORDER_DATE,
                        PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE,
                        PTOM_ORDER_HEADERS.PAYMENT_TYPE_CODE,PTOM_ORDER_HEADERS.CURRENCY,PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER");
        }
        if (!empty($DPayment)) {
            $customer = Customers::where('customer_number', $request->customer_number)->first();

            $data = $DPayment[0];
            $gCode = $data->credit_group_code == 0 ? 'เงินสด' : $data->credit_group_code;

            $getTotalAmount = DB::select("SELECT SUM(AMOUNT) TOTAL_AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS WHERE ORDER_HEADER_ID = $data->order_header_id AND ORDER_LINE_ID != 0 AND CREDIT_GROUP_CODE = $data->credit_group_code");

            if ($data->payment_type_code == 20) {
                $dbdayamount = DB::select("SELECT TERM_ID FROM PTOM_PROFORMA_INVOICE_HEADERS WHERE ORDER_HEADER_ID = '" . $data->order_header_id . "'");
                if (empty($dbdayamount)) {
                    $dataday = '';
                } else {
                    $dayt = DB::select("SELECT DUE_DAYS FROM PTOM_TERMS_V WHERE TERM_ID = '" . $dbdayamount[0]->term_id . "'");
                    $dataday = empty($dayt) ? '0' : $dayt[0]->due_days;
                }
            } else {
                $dataday = '';
            }

            $totaldaysinyear = CarbonInterval::year()->totalDays;
            $today = Carbon::now('Asia/Bangkok')->format('d/m/Y');
            $d1 = explode('/', $today);

            $pyamentd = PaymentMatchInvoice::where('match_flag', 'Y')->where('prepare_order_number', $data->prepare_order_number)->where('credit_group_code', $data->credit_group_code)->sum('payment_amount');

            $payment_ed = !empty($pyamentd) ? $pyamentd : 0;

            if ($payment_ed == 0) {
                $amount_balance_total = $getTotalAmount[0]->total_amount;
            } else {
                $paymentmathid = PaymentMatchInvoice::where('match_flag', 'Y')->where('prepare_order_number', $data->prepare_order_number)->where('credit_group_code', $data->credit_group_code)->first();

                $checkdcn = PaymentApply::where('payment_match_id', $paymentmathid->payment_match_id)->first();
                if (!empty($checkdcn)) {
                    $paymentdcn = DB::select("SELECT PTOM_PAYMENT_APPLY_CNDN.INVOICE_AMOUNT INVOICE_AMOUNT FROM PTOM_PAYMENT_APPLY_CNDN LEFT JOIN PTOM_INVOICE_HEADERS ON PTOM_PAYMENT_APPLY_CNDN.INVOICE_HEADER_ID = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID WHERE PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID = '" . $paymentmathid->payment_match_id . "' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE != 'DN'");
                    if (!empty($paymentdcn)) {
                        $notdn = $paymentdcn[0]->invoice_amount;
                    } else {
                        $notdn = 0;
                    }
                } else {
                    $notdn = 0;
                }

                $denine = $payment_ed - $notdn;

                $amount_balance_total = $getTotalAmount[0]->total_amount - $denine;
            }
            if ($data->payment_type_code == 20) {
                if ($dataday != 0) {
                    $totlepayfile = 0;
                    $paymentduedate = Carbon::parse($data->order_date)->addDays($dataday)->format('Y-m-d');
                    $d2 = explode('-', $paymentduedate);
                    $date1 = Carbon::createMidnightDate($d1[2], $d1[1], $d1[1]);
                    $date2 = Carbon::createMidnightDate($d2[0], $d2[1], $d2[2]);
                    if ($date1->greaterThan($date2)) {
                        if ($data->pick_release_no != null) {
                            $imporoe = DB::select("SELECT CANCEL_FLAG FROM PTOM_IMPROVE_FINES WHERE INVOICE_NUMBER = '" . $data->pick_release_no . "' AND CREDIT_GROUP_CODE = '" . $data->credit_group_code . "'");
                        } else {
                            $imporoe = null;
                        }

                        if (!empty($imporoe) && $imporoe[0]->cancel_flag == 'Y') {
                            $payfines = '0.00';
                        } else {

                            $arrDueDate = explode('-', $paymentduedate);
                            $dueYear = $arrDueDate[0];

                            if ($dueYear % 4 == 0) {
                                $dayOfYear = 366;
                            } else {
                                $dayOfYear = 365;
                            }

                            $newDueDate = date('Y-m-d', strtotime($paymentduedate));
                            $dateNow = date("Y-m-d");

                            // วันเริ่มต้น
                            $arrStart = explode('-', $newDueDate);
                            $startYear = $arrStart[0];
                            $startMonth = $arrStart[1];
                            $startDay = $arrStart[2];

                            // วันปัจจุบัน
                            $arrNow = explode('-', $dateNow);
                            $nowYear = $arrNow[0];
                            $nowMonth = $arrNow[1];
                            $nowDay = $arrNow[2];

                            $makeNow = mktime(0, 0, 0, $nowMonth, $nowDay, $nowYear);
                            $makeStart = mktime(0, 0, 0, $startMonth, $startDay, $startYear);

                            $dayOverDue = ceil(($makeNow - $makeStart) / 86400);

                            $totlepayfile = $amount_balance_total * 0.15 * $dayOverDue / $dayOfYear;

                            $payfines = number_format($totlepayfile, 2);
                        }
                    } else {
                        $payfines = '0.00';
                    }

                    $ppp = $d2[0] . '-' . $d2[1] . '-' . $d2[2];
                    $pdd = FormatDate::DateThaiNumericWithSplashwithout543($ppp);
                } else {
                    $paymentduedate = Carbon::parse($data->order_date)->format('Y-m-d');
                    $pdd = FormatDate::DateThaiNumericWithSplashwithout543($paymentduedate);
                    $payfines = '0.00';
                }
            } else {
                $paymentduedate = '';
                $pdd = '';
                $payfines = '0.00';
            }

            $paymentInvoice = DB::table('ptom_payment_match_invoices as pmi')
                ->join('ptom_payment_headers as pph', 'pph.payment_header_id', '=', 'pmi.payment_header_id')
                ->where('pmi.match_flag', 'N')
                ->where('pph.customer_id', $customer->customer_id)
                ->whereNull('pmi.deleted_at')
                ->whereNull('pph.deleted_at')
                ->sum('payment_amount');

            $info = [
                'order_header_id' => $data->order_header_id,
                'prepare_order_number' => $data->prepare_order_number,
                'pick_release_no' => $data->ref_invoice_number,
                'description' => $data->description,
                'total_amount' => $amount_balance_total,
                'curren' => $data->currency,
                'order_date1' => $data->order_date,
                'order_date2' => $data->order_date == null ? '' : FormatDate::DateThaiNumericWithSplashwithout543($data->order_date),
                'payment_duedate1' => $paymentduedate,
                'payment_duedate2' => $pdd,
                'credit_group1' => $data->credit_group_code,
                'credit_group2' => $gCode,
                'due_days' => $dataday,
                'amount_fines' => $payfines,
                'beforeamount' => number_format($paymentInvoice, 2),
            ];
        } else {
            $info = [];
        }

        return response()->json(['status' => 'success', 'data' => $info]);
    }

    public function draftpayment(Request $request)
    {
        $total_amount = str_replace(',', '', $request->total_amount);
        $total_amounts = $total_amount;
        $customer = Customers::where('customer_number', $request->customer_number)->first();
        if (empty($customer)) {
            return response()->json(['status' => 'error', 'msg' => 'ไม่พบข้อมูลลูกค้า', 'data' => '', 'amount_before' => '', 'dn' => '', 'cn' => '']);
        } else {
            if (strtoupper($customer->sales_classification_code) != 'EXPORT') {
                return response()->json(['status' => 'error', 'msg' => 'ดำเนินการได้เฉพาะลูกค้าต่างประเทศเท่านั้น', 'data' => '', 'amount_before' => '', 'dn' => '', 'cn' => '']);
            }
        }
        $customer_id = $customer->customer_id;

        $DPayment = DB::select("SELECT ORDER_HEADER_ID,PICK_RELEASE_NO,SA_NUMBER PREPARE_ORDER_NUMBER,PRODUCT_TYPE_DESCRIPTION DESCRIPTION,OUTSTANDING_DEBT TOTAL_AMOUNT,ORDER_DATE,DELIVERY_DATE,PAYMENT_TYPE_CODE,CURRENCY,PAYMENT_TYPE_CODE CREDIT_GROUP_CODE,PAYMENT_TYPE_DESCRIPTION,DUE_DAYS,DUE_DATE FROM PTOM_OUTSTANDING_DEBT_EXP_V WHERE CUSTOMER_ID = $customer_id ORDER BY DUE_DATE ASC, PREPARE_ORDER_NUMBER ASC");

        $defineCNs = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,
        PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS FROM PTOM_INVOICE_HEADERS
        LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID
        WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $customer->customer_id . " AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM'
        AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'CN_OTHER' AND PROGRAM_CODE = 'OMP0077'
        ORDER BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER DESC"); //denied fines

        $defineCN = [];
        foreach ($defineCNs as $dfc) {
            $chcn = PaymentApplyCNDN::where('invoice_number', $dfc->invoice_headers_number)->where('attribute1', 'Y')->groupBy('invoice_number')->sum('invoice_amount');
            if ($chcn < $dfc->invoice_amount) {
                $ddatacn['invoice_headers_id'] = $dfc->invoice_headers_id;
                $ddatacn['invoice_headers_number'] = $dfc->invoice_headers_number;
                $ddatacn['invoice_date'] = $dfc->invoice_date;
                $ddatacn['invoice_amount'] = $dfc->invoice_amount;
                $ddatacn['description'] = $dfc->description;
                $ddatacn['term_id'] = $dfc->term_id;
                $ddatacn['due_days'] = $dfc->due_days;

                array_push($defineCN, $ddatacn);
            }
        }

        $number_key = 0;
        $sum_duedate = 0;
        if (empty($DPayment)) {
            $html = "<tr class=\"align-middle jsonloopnotfound\"><td colspan=\"15\" class=\"text-danger text-center\">ไม่พบข้อมูลหนี้ค้างชำระ</td></tr>";
        } else {
            $totaldaysinyear = CarbonInterval::year()->totalDays;
            $today = Carbon::now('Asia/Bangkok')->format('d/m/Y');
            $d1 = explode('/', $today);
            $html = "";
            foreach ($DPayment as $key => $data) {
                $gCode = $data->payment_type_description;
                $dbdayamount = $data->due_days;
                $getTotalAmount = str_replace(',', '',  $data->total_amount);
                $dataday = $dbdayamount;


                $amount_balance_total = $getTotalAmount;

                $pi_sa = ProformaInvoiceHeaders::where('sa_number', $data->prepare_order_number)->where('order_status', 'Confirm')->first();
                if (empty($pi_sa)) {
                    $ddrate = null;
                } else {
                    $ddrate = Carbon::parse($data->delivery_date)->format('Y-m-d');
                }

                if ($ddrate == null || $ddrate == '') {
                    $paymentduedate = '';
                    $pdd = '';
                    $payfines = '0.00';
                } else {
                    if ($data->payment_type_code == 20) {
                        // if ($dataday != 0) {
                            $totlepayfile = 0;
                            $paymentduedate = Carbon::parse($data->due_date)->format('Y-m-d');
                            $d2 = explode('-', $paymentduedate);
                            $date1 = Carbon::createMidnightDate($d1[2], $d1[1], $d1[1]);
                            $date2 = Carbon::createMidnightDate($d2[0], $d2[1], $d2[2]);
                            if ($date1->greaterThan($date2)) {
                                if (empty($pi_sa)) {
                                    $imporoe = null;
                                } else {
                                    if ($data->pick_release_no != null || $data->pick_release_no == '') {
                                        $imporoe = DB::select("SELECT CANCEL_FLAG FROM PTOM_IMPROVE_FINES WHERE INVOICE_NUMBER = '" . $pi_sa->pick_release_no . "' AND CREDIT_GROUP_CODE = '" . $data->credit_group_code . "'");
                                    } else {
                                        $imporoe = null;
                                    }
                                }

                                if (!empty($imporoe) && $imporoe[0]->cancel_flag == 'Y') {
                                    $payfines = '0.00';
                                } else {
                                    $arrDueDate = explode('-', $paymentduedate);
                                    $dueYear = $arrDueDate[0];

                                    if ($dueYear % 4 == 0) {
                                        $dayOfYear = 366;
                                    } else {
                                        $dayOfYear = 365;
                                    }

                                    $newDueDate = date('Y-m-d', strtotime($paymentduedate));
                                    $dateNow = date("Y-m-d");

                                    // วันเริ่มต้น
                                    $arrStart = explode('-', $newDueDate);
                                    $startYear = $arrStart[0];
                                    $startMonth = $arrStart[1];
                                    $startDay = $arrStart[2];

                                    // วันปัจจุบัน
                                    $arrNow = explode('-', $dateNow);
                                    $nowYear = $arrNow[0];
                                    $nowMonth = $arrNow[1];
                                    $nowDay = $arrNow[2];

                                    $makeNow = mktime(0, 0, 0, $nowMonth, $nowDay, $nowYear);
                                    $makeStart = mktime(0, 0, 0, $startMonth, $startDay, $startYear);

                                    $dayOverDue = ceil(($makeNow - $makeStart) / 86400);

                                    $totlepayfile = $amount_balance_total * 0.15 * $dayOverDue / $dayOfYear;

                                    $payfines = number_format($totlepayfile, 2);
                                }
                            } else {
                                $payfines = '0.00';
                            }

                            $ppp = $d2[0] . '-' . $d2[1] . '-' . $d2[2];
                            $pdd = FormatDate::DateThaiNumericWithSplashwithout543($ppp);
                        // } else {
                        //     if (empty($pi_sa)) {
                        //         $paymentduedate = '';
                        //         $pdd = '';
                        //     } else {
                        //         $paymentduedate = Carbon::parse($data->delivery_date)->format('Y-m-d');
                        //         $pdd = FormatDate::DateThaiNumericWithSplashwithout543($paymentduedate);
                        //     }
                        //     $payfines = '0.00';
                        // }
                    } else {
                        if (empty($pi_sa)) {
                            $paymentduedate = '';
                            $pdd = '';
                        } else {
                            $paymentduedate = Carbon::parse($data->delivery_date)->format('Y-m-d');
                            $pdd = FormatDate::DateThaiNumericWithSplashwithout543($paymentduedate);
                        }
                        $payfines = '0.00';
                    }
                }

                $paymentduedate = Carbon::parse($data->due_date)->format('Y-m-d');
                $pdd = FormatDate::DateThaiNumericWithSplashwithout543($paymentduedate);

                if ($amount_balance_total != 0) {
                    if (empty($pi_sa)) {
                        $cndn = [];
                    } else {
                        if ($data->credit_group_code == 10) {
                            $cndn = PaymentApply::where('attribute1', 'N')->where('order_header_id', $pi_sa->pi_header_id)->where(function ($q) use ($data) {
                                $q->where('credit_group_code', $data->credit_group_code);
                                $q->orWhereNull('credit_group_code');
                            })->first();
                        } else {
                            $cndn = PaymentApply::where('attribute1', 'N')->where('order_header_id', $pi_sa->pi_header_id)->where('credit_group_code', $data->credit_group_code)->first();
                        }
                    }

                    if (empty($cndn)) {
                        $amount_balance_totals = $amount_balance_total;
                    } else {
                        $amount_balance_totals = $amount_balance_total - $cndn->invoice_amount;
                    }

                    if ($paymentduedate <= Carbon::now()->format('Y-m-d')) {
                        $sum_duedate += $amount_balance_totals;
                        if ($total_amount >= $amount_balance_totals) {
                            $total_amount -= $amount_balance_totals;
                            $checkbox = "<input type=\"checkbox\" value=\"" . $data->order_header_id . ":DRAFT:" . $number_key . "\" name=\"match_check[]\" onclick=\"summatch();\" checked>";
                        } else {
                            $checkbox = "<input type=\"checkbox\" value=\"" . $data->order_header_id . ":DRAFT:" . $number_key . "\" name=\"match_check[]\" onclick=\"summatch();\">";
                        }
                    } else {
                        $checkbox = "<input type=\"checkbox\" value=\"" . $data->order_header_id . ":DRAFT:" . $number_key . "\" name=\"match_check[]\" onclick=\"summatch();\">";
                    }

                    $html .= "<tr class=\"align-middle jsonloop\" id=\"" . $number_key . "\">";
                    $html .= "<td><div class=\"input-icon\"><input type=\"text\" class=\"form-control text-center f13\" name=\"doc_id[]\" placeholder=\"\" value=\"" . $data->prepare_order_number . "\" autocomplete=\"off\"><i class=\"fa fa-search\"></i></div></td>";

                    $html .= "<td>" . $data->pick_release_no . "<input type=\"hidden\" name=\"pick_no[]\" value=\"" . $data->pick_release_no . "\"></td>";

                    $html .= "<td>" . $data->description . "<input type=\"hidden\" name=\"type_product[]\" value=\"" . $data->description . "\"></td>";
                    $html .= "<td class=\"text-right\">" . number_format($amount_balance_total, 2) . "<input type=\"hidden\" name=\"amount_vat[]\" value=\"" . $amount_balance_total . "\"></td>";
                    $html .= "<td>" . FormatDate::DateThaiNumericWithSplashwithout543(date_format(date_create($data->order_date), 'Y-m-d')) . "<input type=\"hidden\" name=\"invoice_date[]\" value=\"" . date_format(date_create($data->order_date), 'd/m/Y') . "\"></td>";

                    $html .= "<td>" . $pdd . "<input type=\"hidden\" name=\"invoice_duedate[]\" value=\"" . $paymentduedate . "\"></td>";
                    $html .= "<td>" . $gCode . "<input type=\"hidden\" name=\"credit_group[]\" value=\"" . $data->credit_group_code . "\"></td>";
                    $html .= "<td>" . $dataday . "<input type=\"hidden\" name=\"credit_day[]\" value=\"" . $dataday . "\"></td>";
                    $html .= "<td>" . $data->currency . "<input type=\"hidden\" name=\"currency[]\" value=\"" . $data->currency . "\"></td>";
                    $html .= "<td class=\"text-right\">" . $payfines . "<input type=\"hidden\" name=\"amount_fines[]\" value=\"" . $payfines . "\"></td>";

                    if (empty($cndn)) {
                        $html .= "<td><div class=\"input-icon\"><input type=\"text\" class=\"form-control red text-center f13\" name=\"paymatch[]\" placeholder=\"\" value=\"\" onchange=\"summatchnew();\" readonly><i class=\"fa fa-search\" data-toggle=\"modal\" data-target=\"#matchCreditModal\" data-headers=\"F\" data-whatever=\"" . $number_key . "\"></i></div><input type=\"hidden\" name=\"amount_match[]\" value=\"\"></td>";
                    } else {
                        $html .= "<td><div class=\"input-icon\"><input type=\"text\" class=\"form-control red text-center f13\" name=\"paymatch[]\" placeholder=\"\" value=\"" . number_format($cndn->invoice_amount, 2) . "\" onchange=\"summatchnew();\" readonly><i class=\"fa fa-search\" data-toggle=\"modal\" data-target=\"#matchCreditModal\" data-headers=\"" . $cndn->invoice_header_id . "\" data-whatever=\"" . $number_key . "\"></i></div><input type=\"hidden\" name=\"amount_match[]\" value=\"" . number_format($cndn->invoice_amount, 2) . "\"></td>";
                    }

                    $html .= "<td class = \"text-center\">" . number_format($amount_balance_totals, 2) . "</td>";
                    $html .= "<td class = \"text-center\"><input type=\"text\" class=\"form-control text-right f13\" name=\"balancetotal[]\" placeholder=\"\" value=\"" . number_format($amount_balance_totals, 2) . "\" onkeyup=\"numericonlysftpayment(this,this.value);\" onchange=\"inputbyseft(this,this.value);\"><input type=\"hidden\" name=\"amount_balance[]\" value=\"" . $amount_balance_totals . "\"><input type=\"hidden\" name=\"amount_balancetotal[]\" value=\"" . $amount_balance_totals . "\"></td><td><input type=\"text\"  class=\"form-control text-right f13\" name=\"exchang_rate[]\" value='".( $data->currency === 'THB' ? '1': '')."' placeholder=\"\"></td><td>" . $checkbox . "</td>";
                    // $html .= "<td class=\"text-center\"><a class=\"fa fa-times red\" href=\"javascript:void(0);\" onclick=\"deleteRow(this,'matchpayment');\"></a></td>";
                    // $html .= "";
                    
                    if (empty($cndn)) {
                        $html .= "<input type=\"hidden\" name=\"matchid[]\" value=\"\"></tr>";
                    } else {
                        $html .= "<input type=\"hidden\" name=\"matchid[]\" value=\"[" . $cndn->invoice_header_id . "]\"></tr>";
                    }

                    $number_key++;
                }
            }
        }

        $sqldn = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_INVOICE_HEADERS.CURRENCY
        FROM PTOM_INVOICE_HEADERS
        WHERE PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.PROGRAM_CODE = 'OMP0076' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN'
        AND PTOM_INVOICE_HEADERS.DELETED_AT IS NULL AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NOT NULL AND PTOM_INVOICE_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "'");
        if (!empty($sqldn)) {
            foreach ($sqldn as $dn) {
                $paymentmatchinvoicedn = PaymentMatchInvoice::where('invoice_id', $dn->invoice_headers_id)->where('invoice_number', $dn->invoice_headers_number)->where('match_flag', 'Y')->sum('payment_amount');

                if ($paymentmatchinvoicedn < $dn->invoice_amount) {
                    $dmamount = $dn->invoice_amount - $paymentmatchinvoicedn;
                    $checkbox = "<input type=\"checkbox\" value=\"" . $dn->invoice_headers_id . ":INVOICE:" . $number_key . "\" name=\"match_check[]\" onclick=\"summatch();\">";
                    $html .= "<tr class=\"align-middle jsonloop\" id=\"" . $number_key . "\">";
                    $html .= "<td><div class=\"input-icon\"><input type=\"text\" class=\"form-control text-center f13\" name=\"doc_id[]\" placeholder=\"\" value=\"" . $dn->invoice_headers_number . "\" autocomplete=\"off\"><i class=\"fa fa-search\"></i></div></td>";
                    $html .= "<td><input type=\"hidden\" name=\"pick_no[]\" value=\"\"></td>";
                    $html .= "<td><input type=\"hidden\" name=\"type_product[]\" value=\"\"></td>";
                    $html .= "<td class=\"text-right\">" . number_format($dmamount, 2) . "<input type=\"hidden\" name=\"amount_vat[]\" value=\"" . number_format($dmamount, 2) . "\"></td>";
                    $html .= "<td>" . FormatDate::DateThaiNumericWithSplashwithout543(date_format(date_create($dn->invoice_date), 'Y-m-d')) . "<input type=\"hidden\" name=\"invoice_date[]\" value=\"" . date_format(date_create($dn->invoice_date), 'd/m/Y') . "\"></td>";
                    $html .= "<td><input type=\"hidden\" name=\"invoice_duedate[]\" value=\"\"></td>";
                    $html .= "<td><input type=\"hidden\" name=\"credit_group[]\" value=\"\"></td>";
                    $html .= "<td><input type=\"hidden\" name=\"credit_day[]\" value=\"\"></td>";
                    $html .= "<td>" . $dn->currency . "<input type=\"hidden\" name=\"currency[]\" value=\"" . $dn->currency . "\"></td>";
                    $html .= "<td class=\"text-right\"><input type=\"hidden\" name=\"amount_fines[]\" value=\"\"></td>";
                    $html .= "<td><div class=\"input-icon\"><input type=\"text\" class=\"form-control red text-center f13\" name=\"paymatch[]\" placeholder=\"\" value=\"\" onchange=\"summatchnew();\" readonly><i class=\"fa fa-search\" data-toggle=\"modal\" data-target=\"#matchCreditModal\" data-headers=\"F\" data-whatever=\"" . $number_key . "\"></i></div><input type=\"hidden\" name=\"amount_match[]\" value=\"\"></td>";
                    $html .= "<td class = \"text-center\">" . number_format($dmamount, 2) . "</td>";
                    $html .= "<td class = \"text-center\"><input type=\"text\" class=\"form-control text-right f13\" name=\"balancetotal[]\" placeholder=\"\" value=\"" . number_format($dmamount, 2) . "\" onkeyup=\"numericonlysftpayment(this,this.value);\" onchange=\"inputbyseft(this,this.value);\"><input type=\"hidden\" name=\"amount_balance[]\" value=\"" . $dmamount . "\"><input type=\"hidden\" name=\"amount_balancetotal[]\" value=\"" . $dmamount . "\"></td><td>" . $checkbox . "</td>";
                    // $html .= "<td class=\"text-center\"><a class=\"fa fa-times red\" href=\"javascript:void(0);\" onclick=\"deleteRow(this,'matchpayment');\"></a></td>";
                    $html .= "<input type=\"hidden\" name=\"matchid[]\" value=\"\"></tr>";

                    $number_key++;
                }
            }
        }

        if ($total_amounts < $sum_duedate) {
            $popup = true;
            $popupmsg = 'จำนวนเงินที่ชำระน้อยกว่าหนี้ค้างชำระในระบบ';
        } else {
            $popup = false;
            $popupmsg = '';
        }

        // $paymentInvoice = DB::table('ptom_payment_match_invoices as pmi')
        //     ->join('ptom_payment_headers as pph', 'pph.payment_header_id', '=', 'pmi.payment_header_id')
        //     ->where('pmi.match_flag', 'N')
        //     ->where('pph.payment_status', 'Confirm')
        //     ->where('pph.customer_id', $customer->customer_id)
        //     ->whereNull('pmi.deleted_at')
        //     ->whereNull('pph.deleted_at')
        //     ->sum('payment_amount');

        $paymentInvoice = DB::table('ptom_payment_details as pmi')
            ->join('ptom_payment_headers as pph', 'pph.payment_header_id', '=', 'pmi.payment_header_id')
            ->where('pph.payment_status', 'Confirm')
            ->where('pph.customer_id', $customer->customer_id)
            ->whereNull('pmi.deleted_at')
            ->whereNull('pph.deleted_at')
            ->sum('payment_amount');

        $paymentExpV = DB::table('ptom_payment_exp_v')
            ->where('customer_id', $customer->customer_id)
            ->sum('payment_amount');
        $abs = number_format($paymentInvoice - $paymentExpV, 2);

        return response()->json(['status' => 'success', 'msg' => '', 'data' => json_decode(json_encode($html)), 'amount_before' => $abs, 'cn' => json_decode(json_encode($defineCN)), 'popup' => $popup, 'popupmsg' => $popupmsg]);
    }

    public function paymentupload(Request $request)
    {
        $responseUploadFile = array();
        $responseUploadFile['status'] = 200;
        $responseUploadFile['message'] = "";
        $responseUploadFile['attachments'] = [];
        if ($request->hasFile('attachment')) {
            $idTest = 1;
            foreach ($request->file('attachment') as $file) {
                $newfilename = date('YmdHis') . '-upload' . '.' . $file->getClientOriginalExtension();
                DB::beginTransaction();
                $fileInfo = [];
                $program_code = 'OMP0067';
                try {
                    $attachment = $this->uploadAttachmentSingle($file, null, $program_code);
                    $fileInfo = [
                        'attachment_id' => $attachment->attachment_id,
                        // 'file_name' => $file->getClientOriginalName(),
                        'file_name' => $attachment->file_name,
                        'path_name' => getDefaultData('/users')->archive_directory,
                        'program_code' => $program_code,
                    ];
                    $responseUploadFile['attachments'][] = $fileInfo;
                    $responseUploadFile['message'] = 'อัปโหลดไฟล์เรียบร้อยแล้ว';
                    $idTest++;
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $name = explode('.', $newfilename);
                    Storage::disk('local')->put(getDefaultData('/users')->log_directory . '/' . $name[0] . '.txt', 'ไม่สามารถอัปโหลดไฟล์ได้ :' . $e->getMessage());
                    $responseUploadFile['status'] = 403;
                    $responseUploadFile['message'] = 'เกิดข้อผิดพลาดระหว่างการอัปโหลดไฟล์ __' . $file->getClientOriginalName();
                }
            }
        } else {
            $responseUploadFile['status'] = 422;
            $responseUploadFile['message'] = "ไม่พบไฟล์ที่ต้องการอัปโหลด";
        }
        return $responseUploadFile;
    }

    public function uploadAttachmentSingle($file, $header_id, $program_code)
    {
        $dateNow = now();
        $dataUser = getDefaultData('/users');
        $location = $dataUser->archive_directory . '/';
        $extension = $file->getClientOriginalExtension();
        // $filename = md5(time() . $dataUser->user_id) . '.' . $extension;
        $filename = $file->getClientOriginalName();
        $validExtension = array("jpg", "jpeg", "bmp", "png", "pdf", "doc", "docx", "xls", "xlsx", "rar", "zip", "csv");
        if (in_array(strtolower($extension), $validExtension)) {
            $file->move($location, $filename);
            $attachment = new AttachFiles();
            $attachment->attachment_program_code = $program_code;
            $attachment->header_id = $header_id;
            $attachment->file_name = $filename;
            $attachment->path_name = $location . $filename;
            $attachment->program_code = $program_code;
            $attachment->creation_date = $dateNow;
            $attachment->created_by = $dataUser->user_id;
            $attachment->last_updated_by = $dataUser->user_id;
            $attachment->save();
        }
        return $attachment;
    }

    public function filesdelete(Request $request)
    {
        $file = AttachFiles::find($request->attachment_id);
        if (empty($file)) {
            return response()->json(['data' => 'ไม่พบข้อมูล'], 200);
        }
        $file->delete();
        Storage::disk('local')->delete($file->path_name . '/' . $file->file_name);
        return response()->json(['data' => 'ลบไฟล์เรียบร้อยแล้ว'], 200);
    }

    public function getBankfromLogic(Request $request)
    {
        $exp = explode(',', $request->params);
        $data = DB::select(DB::raw("SELECT BANK_ACCOUNT_NAME, PRIMARY FROM OAOM.PTOM_RECEIPT_BANK_ACC_V WHERE UPPER(MAPPING_OM_TYPE) = '" . strtoupper($exp[1]) . "'"));
        return response()->json(['data' => json_decode(json_encode($data))]);
    }

    public function getvaluebank(Request $request)
    {
        $d = DB::select(DB::raw("SELECT BANK_ACCOUNT_NUMBER,BANK_ID,BANK_NUMBER FROM OAOM.PTOM_RECEIPT_BANK_ACC_V WHERE BANK_ACCOUNT_NAME = '" . $request->valuebank . "' AND ROWNUM = 1"));
        if (empty($d)) {
            $data = '';
        } else {
            $data = $d[0];
        }
        return response()->json(['data' => json_decode(json_encode($data))]);
    }

    public function getPaymentNumber(Request $request)
    {
        $customer = Customers::where('customer_number', $request->valuecustomer)->first();
        if (empty($customer)) {
            return response()->json(['data' => '']);
        }
        $data = DB::select(DB::raw("SELECT PAYMENT_NUMBER FROM PTOM_PAYMENT_HEADERS WHERE CUSTOMER_ID = '" . $customer->customer_id . "'"));

        $defineDN = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $customer->customer_id . " AND PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NULL ORDER BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER DESC");

        $defineCN = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $customer->customer_id . " AND PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE != 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NULL ORDER BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER DESC");

        return response()->json(['data' => json_decode(json_encode($data)), 'defineDN' => json_decode(json_encode($defineDN)), 'defineCN' => json_decode(json_encode($defineCN))]);
    }

    public function paymentverify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method.*' => 'required',
            'number_payment.*' => 'required',
            'bank_code.*' => 'required',
            'payment_amounts.*' => 'required',
            'total_payment_amount.*' => 'required',
            // 'match_check.*'           => 'required',
            'number_payment_customer' => 'required',
            'number_payment_status' => 'required',
        ], [
            'payment_method.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :1',
            'number_payment.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :2',
            'bank_code.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :3',
            'payment_amounts.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :4',
            'total_payment_amount.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :5',
            // 'match_check.*.required'           => 'กรุณาเลือกข้อมูลที่ต้องการปรับปรุงยอดการชำระเงิน',
            'number_payment_customer.required' => 'ไม่พบข้อมูลลูกค้า',
            'number_payment_status.required' => 'ข้อมูลการบันทึกไม่ถูกต้อง',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->errors()->first()));
        }
        return response()->json(array('errors' => ''));
    }

    public function payment(Request $request)
    {
        $rules = [
            'payment_method.*' => 'required',
            'number_payment.*' => 'required',
            'bank_code.*' => 'required',
            // 'exchang_rate.*' => 'required',
            'payment_amounts.*' => 'required',
            'total_payment_amount.*' => 'required',
            // 'match_check.*'           => 'required',
            'number_payment_customer' => 'required',
            'number_payment_status' => 'required',
        ];

        if($request->has('match_check')) {
            $rules['exchang_rate.*'] = 'required';
        }

        $validator = Validator::make($request->all(),$rules , [
            'payment_method.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :1',
            'number_payment.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :2',
            'bank_code.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :3',
            'exchang_rate.*.required' => 'กรุณาระบุรายละเอียดอัตราการแลกเปลี่ยน',
            'payment_amounts.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :4',
            'total_payment_amount.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :5',
            // 'match_check.*.required'           => 'กรุณาเลือกข้อมูลที่ต้องการปรับปรุงยอดการชำระเงิน',
            'number_payment_customer.required' => 'ไม่พบข้อมูลลูกค้า',
            'number_payment_status.required' => 'ข้อมูลการบันทึกไม่ถูกต้อง',
        ]);
        $requests = $request->all();
        if ($validator->fails()) {
            $requests['callback_save'] = true;
            return redirect()->back()->withErrors($validator->errors()->first())->withInput($request->all());
        }

        if (strtoupper($request->number_payment_status) == 'DRAFT') {
            $payment = $this->darftpayment($request);
            $msg = "บันทึกเรียบร้อยแล้ว";
        } elseif (strtoupper($request->number_payment_status) == 'CONFIRM') {
            if (strtoupper($request->number_status) == 'DRAFT' && ($request->number_payment_invoice == null || $request->number_payment_invoice == '')) {
                $payment = $this->darftpayment($request);
                // dd($payment);
                if ($payment == 'false') {
                    return redirect()->back()->withErrors('การบันทึกการชำระเงินไม่สำเร็จ ลองใหม่อีกครั้ง');
                }
                $this->confirmpayment($request, $payment['number']);
                $msg = "บันทึกและยืนยันข้อมูลแล้ว";
            } else {
                $payment = $this->confirmpayment($request);
                $msg = "ยืนยันข้อมูลแล้ว";
            }
        } else {
            $payment = $this->concelpayment($request);
            if ($payment == 'false') {
                $request->session()->flashInput($request->all());
                return redirect()->back()->withErrors('ไม่สามารถดำเนินการยกเลิกได้');
            } else {
                $msg = "ยกเลิกเรียบร้อยแล้ว";
            }
        }

        if ($payment == 'false') {
            $requests['callback_save'] = true;
            return redirect()->back()->withErrors('บันทึกข้อมูลไม่สำเร็จหรือการเปลี่ยนแปลงล้มเหลว')->withInput($request->all());
        }

        if (strtoupper($request->number_payment_status) == 'DRAFT') {
            $requests['number_payment_invoice'] = $payment['number'];
        }
        if (strtoupper($payment['type']) == 'DOMESTIC') {
            $requests['number_payment_type'] = 'ขายในประเทศ';
        } else {
            $requests['number_payment_type'] = 'ขายต่างประเทศ';
        }

        $requests['number_payment_customer_name'] = $payment['name'];
        $requests['callback_save'] = true;

        request()->session()->flashInput($requests);

        if (strtoupper($request->number_payment_status) != 'CANCEL') {
            $check = DB::table('ptom_release_receipts')->where('payment_header_id', '=', $payment['id'])->first();
            if (empty($check)) {
                $datatoday = Carbon::now()->format('Y-m-d');
                $customer = DB::table('ptom_customers')->where('customer_number', '=', $request->number_payment_customer)->first();
                $auto = DB::select("SELECT * FROM PTOM_NOT_AUTO_RELEASE_RECEIPTS WHERE CUSTOMER_ID = '" . $customer->customer_id . "' AND DELETED_AT IS NULL AND START_DATE <= DATE '" . $datatoday . "' AND (END_DATE >= DATE '" . $datatoday . "' OR END_DATE IS NULL)");
                if (empty($auto)) {
                    $release_flag = 'Y';
                } else {
                    $release_flag = 'N';
                }

                $user_id = getDefaultData('/users')->user_id;
                DB::table('ptom_release_receipts')->insert([
                    'payment_header_id' => $payment['id'],
                    'release_flag' => $release_flag,
                    'reprint_flag' => 'N',
                    'print_flag' => 'N',
                    'printed_flag' => 'N',
                    'status' => 'Reprint 0',
                    'program_code' => 'OMP0067',
                    'created_by' => $user_id,
                    'creation_date' => Carbon::now()->timezone('Asia/Bangkok'),
                    'last_updated_by' => $user_id,
                    'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'),
                ]);
            }
        }

        // return redirect()->back()->with('success', 'บันทึกเรียบร้อยแล้ว เลขที่ใบเสร็จรับเงิน คือ ' . $payment['number']);
        return redirect('/om/export-payout?payment_number=' . $payment['number'])->with('success', $msg);
    }

    private function darftpayment(Request $request)
    {
        $customer = DB::table('ptom_customers')->where('customer_number', '=', $request->number_payment_customer)->first();
        $user_id = getDefaultData('/users')->user_id;
        // if ($request->number_payment_invoice == null || $request->number_payment_invoice == '') {
        //create
        $payment_number = autoNumberPayment('OMP0067_REC_NUM_EXP', 'payment_number');
        $exsss = explode('/', $request->number_payment_date);
        $ddate = $exsss[2] . '-' . $exsss[1] . '-' . $exsss[0];
        // $ddate = Carbon::parse($request->number_payment_date)->format('Y-m-d');
        $header = PaymentHeader::create([
            'payment_number' => $payment_number,
            'payment_date' => Carbon::parse($ddate .' '.date('H:i:s'))->format('Y-m-d H:i:s'),
            'payment_status' => $request->number_payment_status,
            'customer_id' => $customer->customer_id,
            'sales_classification_code' => $customer->sales_classification_code,
            'remark' => $request->number_payment_remart,
            'bank_id' => $request->number_payment_bank,
            'bank_number' => $request->number_payment[0],
            'bank_name' => $request->number_payment_bank_desc,
            'total_amount_with_vat' => str_replace(',', '', $request->totalvat_amounts),
            'total_amount_match' => str_replace(',', '', $request->match_count_amounts),
            'total_fine' => str_replace(',', '', $request->paycount_amounts),
            'total_payment_amount' => str_replace(',', '', $request->total_amounts),
            'total_previous_remain_amount' => str_replace(',', '', $request->bbalance_amounts),
            'total_remain_amount' => str_replace(',', '', $request->balance_amounts),
            'program_code' => 'OMP0067',
            'created_by' => $user_id,
            'last_updated_by' => $user_id
        ]);
        if ($header) {
            foreach ($request->payment_method as $key => $value_payment_method) {
                // $bank_desc = DB::table('ptce_bank_accounts_v')->select('bank_branch_name')->where('bank_number', '=', $request->bank_code[$key])->first();
                $exp = explode(',', $value_payment_method);
                PaymentLines::create([
                    'payment_header_id' => $header->payment_header_id,
                    'line_number' => $key + 1,
                    'payment_method_code' => $exp[0],
                    'payment_no' => $request->number_payment[$key] == 'undefined' ? '' : $request->number_payment[$key],
                    'bank_number' => $request->bank_code[$key] == 'undefined' ? '' : $request->bank_code[$key],
                    'bank_desc' => $request->payment_desc_number_bank[$key],
                    // 'payment_amount' => str_replace(',', '', $request->total_payment_amount[$key]),
                    'currency' => $request->currencys[$key],
                    'conversion_rate' => str_replace(',', '', $request->exchangerates[$key]),
                    // 'conversion_amount' => str_replace(',', '', $request->payment_amounts[$key]),
                    'rate_fee' => str_replace(',', '', $request->number_payment_fines),
                    'program_code' => 'OMP0067',
                    'created_by' => $user_id,
                    'last_updated_by' => $user_id,
                    'payment_amount' => str_replace(',', '', $request->payment_amounts[$key]),
                    'conversion_amount' => str_replace(',', '', $request->total_payment_amount[$key]),
                ]);
            }

            // update header_id file_upload
            if ($request->files_uploadsId && $request->files_uploadsId != '') {

                $attachmentIDs = explode(",", $request->files_uploadsId);
                foreach ($attachmentIDs as $value) {
                    $AttachFile = AttachFiles::where('attachment_id', $value)->first();
                    // dd($AttachFile);
                    if ($AttachFile) {
                        $AttachFile->header_id = $header->payment_header_id;
                        $AttachFile->save();
                    }
                }
            }
            // update header_id file_upload

            if ($request->match_check) {
                foreach ($request->match_check as $k => $value_match) {
                    $data_expld = explode(':', $value_match);
                    if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                        $invoce = DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $data_expld[0])->first();
                    } else {
                        $invoce = DB::table('ptom_order_headers')->select('pick_release_id', 'prepare_order_number', 'payment_type_code')->where('order_header_id', '=', $data_expld[0])->first();
                    }

                    if ($invoce) {
                        // $ddptom = DB::select("SELECT PICK_RELEASE_NO FROM PTOM_PROFORMA_INVOICE_HEADERS WHERE ORDER_HEADER_ID = '" . $data_expld[0] . "'");
                        if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                            $i1 = $invoce->invoice_headers_id;
                            $i2 = '';
                        } else {
                            $i1 = $invoce->pick_release_id;
                            $i2 = $invoce->prepare_order_number;
                        }
                    } else {
                        $i1 = '';
                        $i2 = '';
                    }

                    $dt = $request->invoice_duedate[$data_expld[2]];
                    if ($dt == '' || $dt == null) {
                        $dtin = '';
                    } else {
                        $dtin = Carbon::parse($dt)->format('Y-m-d');
                    }

                    if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                        $i3 = $request->doc_id[$data_expld[2]];
                    } else {
                        $i3 = $request->pick_no[$data_expld[2]];
                    }

                    $linenumber = 0;
                    $details = PaymentLines::where('payment_header_id', $header->payment_header_id)->orderBy('payment_detail_id', 'ASC')->get();
                    $paymment_amount_total = str_replace(',', '', $request->amount_balancetotal[$data_expld[2]]);
                    foreach ($details as $d) {
                        if ($paymment_amount_total > 0) {
                            $sumd = PaymentMatchInvoice::where('payment_detail_id', $d->payment_detail_id)->where('match_flag', 'Y')->sum('payment_amount');
                            if ($paymment_amount_total > $d->conversion_amount && $sumd < $d->conversion_amount) {
                                $ids = PaymentMatchInvoice::create([
                                    'payment_header_id' => $header->payment_header_id,
                                    'payment_detail_id' => $d->payment_detail_id,
                                    'invoice_id' => $i1,
                                    'invoice_number' => $i3,
                                    'prepare_order_number' => $i2,
                                    // 'credit_group_code' => $request->credit_group[$data_expld[2]],
                                    'due_day' => $request->credit_day[$data_expld[2]],
                                    'due_date' => $dtin,
                                    'payment_amount' => abs($paymment_amount_total - abs($paymment_amount_total - $d->conversion_amount)),
                                    'match_flag' => 'Y',
                                    'payment_type_code' => $invoce->payment_type_code ?? '',
                                    'currency' => $request->currency[$data_expld[2]],
                                    'program_code' => 'OMP0067',
                                    'match_exchange_rate' => $request->exchang_rate[$data_expld[2]],
                                    'created_by' => $user_id,
                                    'last_updated_by' => $user_id,
                                    'outstanding_debt' => str_replace(',', '', $request->amount_vat[$data_expld[2]]),
                                    'last_update_date' => Carbon::parse($ddate .' '.date('H:i:s'))->format('Y-m-d H:i:s'),
                                ]);

                                if ($data_expld[1] == 'DRAFT') {
                                    $ar = $request->matchid[$data_expld[2]];
                                    if ($ar != null) {
                                        $ar1 = str_replace("[", "(", $ar);
                                        $ar2 = str_replace("]", ")", $ar1);
                                        $matid = DB::select("SELECT * FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_ID IN $ar2");

                                        if (!empty($matid) && $matid != null) {
                                            foreach ($matid as $keymath => $idmath) {
                                                $linenumber++;
                                                $chck = PaymentApply::where('invoice_header_id', $idmath->invoice_headers_id)->where(function($q) {
                                                    $q->where('attribute1', 'N');
                                                    $q->orWhereNull('attribute1');
                                                });
                                                if ($chck->count() > 0) {
                                                    $updatecndn = $chck->first();
                                                    $updatecndn->payment_match_id = $ids->payment_match_id;
                                                    $updatecndn->line_number = $linenumber;
                                                    $updatecndn->last_updated_by = $user_id;
                                                    $updatecndn->last_update_date = Carbon::now();
                                                    $updatecndn->attribute1 = 'Y';
                                                    $updatecndn->save();
                                                } else {
                                                    PaymentApply::create([
                                                        'payment_match_id' => $ids->payment_match_id,
                                                        'line_number' => $linenumber,
                                                        'invoice_header_id' => $idmath->invoice_headers_id,
                                                        'invoice_number' => $idmath->invoice_headers_number,
                                                        'order_header_id' => $idmath->document_id,
                                                        'pick_release_no' => $i3,
                                                        'arrtibute1' => 'Y',
                                                        'arrtibute2' => $idmath->invoice_type,
                                                        'program_code' => 'OMP0067',
                                                        'credit_group_code',
                                                        'invoice_amount' => str_replace(',', '', $idmath->invoice_amount),
                                                        'created_by' => $user_id,
                                                        'last_updated_by' => $user_id,
                                                    ]);
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $linenumber++;
                                    $matid = DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $data_expld[0])->first();
                                    $cnmatch = DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $request->matchid[$data_expld[2]])->first();
                                    if (empty($cnmatch) || strpos($cnmatch->invoice_headers_number, 'DN') !== false) {
                                    } else {
                                        PaymentApply::create([
                                            'payment_match_id' => $ids->payment_match_id,
                                            'line_number' => $linenumber,
                                            'invoice_header_id' => $cnmatch->invoice_headers_id,
                                            'invoice_amount' => str_replace(',', '', $cnmatch->invoice_amount),
                                            'program_code' => 'OMP0067',
                                            'created_by' => $user_id,
                                            'last_updated_by' => $user_id,
                                            'invoice_number' => $cnmatch->invoice_headers_number,
                                            'attribute1' => 'Y',
                                            'attribute2' => $cnmatch->invoice_type
                                        ]);
                                    }
                                    // DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $pa->invoice_headers_id)->update(array('document_id' => $invoce->pick_release_id));
                                }

                                $paymment_amount_total = $paymment_amount_total - $d->conversion_amount;
                            } else {
                                if ($sumd < $d->conversion_amount) {
                                    $ids = PaymentMatchInvoice::create([
                                        'payment_header_id' => $header->payment_header_id,
                                        'payment_detail_id' => $d->payment_detail_id,
                                        'invoice_id' => $i1,
                                        'invoice_number' => $i3,
                                        'prepare_order_number' => $i2,
                                        // 'credit_group_code' => $request->credit_group[$data_expld[2]],
                                        'due_day' => $request->credit_day[$data_expld[2]],
                                        'due_date' => $dtin,
                                        'payment_amount' => abs($paymment_amount_total),
                                        'match_flag' => 'Y',
                                        'payment_type_code' => $invoce->payment_type_code ?? '',
                                        'currency' => $request->currency[$data_expld[2]],
                                        'program_code' => 'OMP0067',
                                        'match_exchange_rate' => $request->exchang_rate[$data_expld[2]],
                                        'created_by' => $user_id,
                                        'last_updated_by' => $user_id,
                                        'outstanding_debt' => str_replace(',', '', $request->amount_vat[$data_expld[2]]),
                                        'last_update_date' => Carbon::parse($ddate .' '.date('H:i:s'))->format('Y-m-d H:i:s'),
                                    ]);

                                    if ($data_expld[1] == 'DRAFT') {
                                        $ar = $request->matchid[$data_expld[2]];
                                        if ($ar != null) {
                                            $ar1 = str_replace("[", "(", $ar);
                                            $ar2 = str_replace("]", ")", $ar1);
                                            $matid = DB::select("SELECT * FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_ID IN $ar2");
                                            if (!empty($matid) && $matid != null) {
                                                foreach ($matid as $keymath => $idmath) {
                                                    $linenumber++;
                                                    $chck = PaymentApply::where('invoice_header_id', $idmath->invoice_headers_id)->where(function($q) {
                                                        $q->where('attribute1', 'N');
                                                        $q->orWhereNull('attribute1');
                                                    });
                                                    if ($chck->count() > 0) {
                                                        $updatecndn = $chck->first();
                                                        $updatecndn->payment_match_id = $ids->payment_match_id;
                                                        $updatecndn->line_number = $linenumber;
                                                        $updatecndn->last_updated_by = $user_id;
                                                        $updatecndn->last_update_date = Carbon::now();
                                                        $updatecndn->attribute1 = 'Y';
                                                        $updatecndn->save();
                                                    } else {
                                                        PaymentApply::create([
                                                            'payment_match_id' => $ids->payment_match_id,
                                                            'line_number' => $linenumber,
                                                            'invoice_header_id' => $idmath->invoice_headers_id,
                                                            'invoice_number' => $idmath->invoice_headers_number,
                                                            'order_header_id' => $idmath->document_id,
                                                            'pick_release_no' => $i3,
                                                            'arrtibute1' => 'Y',
                                                            'arrtibute2' => $idmath->invoice_type,
                                                            'credit_group_code',
                                                            'invoice_amount' => str_replace(',', '', $idmath->invoice_amount),
                                                            'program_code' => 'OMP0067',
                                                            'created_by' => $user_id,
                                                            'last_updated_by' => $user_id,
                                                        ]);
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        $linenumber++;
                                        $matid = DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $data_expld[0])->first();
                                        $cnmatch = DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $request->matchid[$data_expld[2]])->first();
                                        if (empty($cnmatch) || strpos($cnmatch->invoice_headers_number, 'DN') !== false) {
                                        } else {
                                            $pa = PaymentApply::create([
                                                'payment_match_id' => $ids->payment_match_id,
                                                'line_number' => $linenumber,
                                                'invoice_header_id' => $cnmatch->invoice_headers_id,
                                                'invoice_amount' => str_replace(',', '', $cnmatch->invoice_amount),
                                                'program_code' => 'OMP0067',
                                                'created_by' => $user_id,
                                                'last_updated_by' => $user_id,
                                                'invoice_number' => $cnmatch->invoice_headers_number,
                                                'attribute1' => 'Y',
                                                'attribute2' => $cnmatch->invoice_type
                                            ]);
                                        }
                                        // DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $pa->invoice_headers_id)->update(array('document_id' => $invoce->pick_release_id));
                                    }

                                    $paymment_amount_total = $paymment_amount_total - $d->conversion_amount;
                                }
                            }
                        }
                    }
                }
            }

            return array('id' => $header->payment_header_id, 'number' => $payment_number, 'type' => $customer->sales_classification_code, 'name' => $customer->customer_name);
        } else {
            return 'false';
        }
        // }
        // } else {
        //     //update
        //     if ($request->number_status == 'Confirm') {
        //         return back()->withErrors('การชำระเงินนี้สมบูรณ์แล้ว ไม่สามารถบันทึกการเปลี่ยนแปลงได้')->withInput($request->all());
        //     }
        //     $number_payent = DB::table('ptom_payment_headers')->where('payment_number', '=', $request->number_payment_invoice)->first();
        //     if (!empty($number_payent) && $number_payent != null) {
        //         $dataheader = [
        //             'remark'                       => $request->number_payment_remart,
        //             'total_amount_with_vat'        => str_replace(',', '', $request->totalvat_amounts),
        //             'total_amount_match'           => str_replace(',', '', $request->match_count_amounts),
        //             'total_fine'                   => str_replace(',', '', $request->paycount_amounts),
        //             'total_payment_amount'         => str_replace(',', '', $request->total_amounts),
        //             'total_previous_remain_amount' => str_replace(',', '', $request->bbalance_amounts),
        //             'total_remain_amount'          => str_replace(',', '', $request->balance_amounts),
        //             'last_updated_by'              => $user_id,
        //         ];
        //         $update1 = PaymentHeader::find($number_payent->payment_header_id)->update($dataheader);
        //         if (!$update1) {
        //             return 'false';
        //         }

        //         // update header_id file_upload
        //         if ($request->files_uploadsId && $request->files_uploadsId != '') {
        //             $attachmentIDs = explode(",", $request->files_uploadsId);
        //             foreach ($attachmentIDs as $value) {
        //                 $AttachFile = AttachFiles::where('attachment_id', $value)->first();
        //                 // dd($AttachFile);
        //                 if ($AttachFile) {
        //                     $AttachFile->header_id = $number_payent->payment_header_id;
        //                     $AttachFile->save();
        //                 }
        //             }
        //         }
        //         // update header_id file_upload
        //         $array_payment_detail_id = [];
        //         if ($request->payment_method) {
        //             foreach ($request->payment_method as $key => $pm) {

        //                 if ($request->payment_detail_id[$key]) {
        //                     array_push($array_payment_detail_id, $request->payment_detail_id[$key]);
        //                     //update ptom_payment_details
        //                     $exp = explode(',', $request->payment_method[$key]);
        //                     $datapm = [
        //                         'line_number'         => $key + 1,
        //                         'payment_method_code' => $exp[0],
        //                         'payment_no'          => $request->number_payment[$key] == 'undefined' ? '' : $request->number_payment[$key],
        //                         'bank_number'         => $request->bank_code[$key] == 'undefined' ? '' : $request->bank_code[$key],
        //                         'bank_desc'           => $request->payment_desc_number_bank[$key],
        //                         'payment_amount'      => str_replace(',', '', $request->total_payment_amount[$key]),
        //                         'currency'            => $request->currencys[$key],
        //                         'conversion_rate'     => str_replace(',', '', $request->exchangerates[$key]),
        //                         'conversion_amount'   => str_replace(',', '', $request->payment_amounts[$key]),
        //                         'rate_fee'            => str_replace(',', '', $request->number_payment_fines),
        //                         'program_code'        => 'OMP0067',
        //                         'last_updated_by'     => $user_id,
        //                     ];
        //                     PaymentLines::find($request->payment_detail_id[$key])->update($datapm);
        //                 } else {
        //                     //create ptom_payment_details
        //                     $exp = explode(',', $request->payment_method[$key]);
        //                     PaymentLines::create([
        //                         'payment_header_id'   => $number_payent->payment_header_id,
        //                         'line_number'         => $key + 1,
        //                         'payment_method_code' => $exp[0],
        //                         'payment_no'          => $request->number_payment[$key] == 'undefined' ? '' : $request->number_payment[$key],
        //                         'bank_number'         => $request->bank_code[$key] == 'undefined' ? '' : $request->bank_code[$key],
        //                         'bank_desc'           => $request->payment_desc_number_bank[$key],
        //                         'payment_amount'      => $request->total_payment_amount[$key],
        //                         'currency'            => $request->currencys[$key],
        //                         'conversion_rate'     => str_replace(',', '', $request->exchangerates[$key]),
        //                         'conversion_amount'   => str_replace(',', '', $request->payment_amounts[$key]),
        //                         'rate_fee'            => str_replace(',', '', $request->number_payment_fines),
        //                         'program_code'        => 'OMP0067',
        //                         'created_by'          => $user_id,
        //                         'last_updated_by'     => $user_id,
        //                     ]);
        //                 }
        //             }
        //             PaymentLines::whereNotIn('payment_detail_id', $array_payment_detail_id)->delete();
        //         }

        //         $match_invoice = DB::table('ptom_payment_match_invoices')->where('payment_header_id', '=', $number_payent->payment_header_id)->get();
        //         $id_nath = [];
        //         if (!empty($match_invoice) && $match_invoice != null) {
        //             foreach ($match_invoice as $keymath => $mi) {
        //                 array_push($id_nath, $mi->payment_match_id);
        //                 $data_expld = explode(':', $request->match_check[$keymath]);

        //                 $invoce = DB::table('ptom_order_headers')->select('pick_release_id', 'prepare_order_number', 'payment_type_code')->where('order_header_id', '=', $data_expld[0])->first();

        //                 if ($invoce) {
        //                     $ddptom = DB::select("SELECT PICK_RELEASE_NO FROM PTOM_PROFORMA_INVOICE_HEADERS WHERE ORDER_HEADER_ID = '" . $data_expld[0] . "'");
        //                     $i1 = $invoce->pick_release_id;
        //                     $i2 = $invoce->prepare_order_number;
        //                     $i3 = empty($ddptom) ? '' : $ddptom[0]->pick_release_no;
        //                 } else {
        //                     $i1 = '';
        //                     $i2 = '';
        //                     $i3 = '';
        //                 }

        //                 $dt = $request->invoice_duedate[$data_expld[2]];
        //                 if ($dt == '' || $dt == null) {
        //                     $dtin = '';
        //                 } else {
        //                     $dtin = Carbon::parse($dt)->format('Y-m-d');
        //                 }

        //                 $details = PaymentLines::where('payment_header_id', $mi->payment_header_id)->orderBy('payment_detail_id', 'ASC')->get();
        //                 $paymment_amount_total = str_replace(',', '', $request->amount_balancetotal[$data_expld[2]]);
        //                 foreach ($details as $d) {
        //                     if ($paymment_amount_total > 0) {
        //                         $sumd = PaymentMatchInvoice::where('payment_detail_id', $d->payment_detail_id)->where('match_flag', 'Y')->sum('payment_amount');
        //                         if ($paymment_amount_total > $d->conversion_amount && $sumd < $d->conversion_amount) {
        //                             $datami = [
        //                                 'payment_detail_id' => $d->payment_detail_id,
        //                                 'invoice_id'          => $i1,
        //                                 'invoice_number'       => $i3,
        //                                 'prepare_order_number' => $i2,
        //                                 'credit_group_code'    => $request->credit_group[$data_expld[2]],
        //                                 'due_day'              => $request->credit_day[$data_expld[2]],
        //                                 'due_date'             => $dtin,
        //                                 'payment_amount'       =>  abs($paymment_amount_total - abs($paymment_amount_total - $d->conversion_amount)),
        //                                 'match_flag'           => 'Y',
        //                                 'payment_type_code'    => 'เงินสด',
        //                                 'currency'             => $request->currency[$data_expld[2]],
        //                                 'program_code'         => 'OMP0067',
        //                                 'last_updated_by'      => $user_id,
        //                             ];
        //                             PaymentMatchInvoice::find($mi->payment_match_id)->update($datami);
        //                             $paymment_amount_total = $paymment_amount_total - $d->conversion_amount;
        //                         } else {
        //                             if ($sumd < $d->conversion_amount) {
        //                                 $datami = [
        //                                     'payment_detail_id' => $d->payment_detail_id,
        //                                     'invoice_id'          => $i1,
        //                                     'invoice_number'       => $i3,
        //                                     'prepare_order_number' => $i2,
        //                                     'credit_group_code'    => $request->credit_group[$data_expld[2]],
        //                                     'due_day'              => $request->credit_day[$data_expld[2]],
        //                                     'due_date'             => $dtin,
        //                                     'payment_amount'       =>  abs($paymment_amount_total),
        //                                     'match_flag'           => 'Y',
        //                                     'payment_type_code'    => 'เงินสด',
        //                                     'currency'             => $request->currency[$data_expld[2]],
        //                                     'program_code'         => 'OMP0067',
        //                                     'last_updated_by'      => $user_id,
        //                                 ];
        //                                 PaymentMatchInvoice::find($mi->payment_match_id)->update($datami);
        //                                 $paymment_amount_total = $paymment_amount_total - $d->conversion_amount;
        //                             }
        //                         }
        //                     }
        //                 }
        //             }

        //             $apply = DB::table('ptom_payment_apply_cndn')->whereIn('payment_match_id', $id_nath)->get();
        //             if (!empty($apply) && $apply != null) {
        //                 foreach ($apply as $keyapp => $a) {
        //                     $matid = DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $request->matchid[$keyapp])->get();
        //                     if (!empty($matid) && $matid != null) {
        //                         foreach ($matid as $keymath => $idmath) {
        //                             $dataapp = [
        //                                 'line_number'       => $keymath + 1,
        //                                 'invoice_header_id' => $idmath->invoice_headers_id,
        //                                 'invoice_amount'    => $idmath->invoice_amount,
        //                                 'program_code'      => 'OMP0067',
        //                                 'last_updated_by'   => $user_id,
        //                             ];

        //                             PaymentApply::find($a->payment_apply_id)->update($dataapp);
        //                             DB::table('ptom_invoice_headers')->where('invoice_headers_id', '=', $a->payment_apply_id)->update(array('document_id' => $invoce->pick_release_id));
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }
        //     return array('id' => $number_payent->payment_header_id, 'number' => $request->number_payment_invoice, 'type' => $customer->sales_classification_code, 'name' => $customer->customer_name);
        // }
    }

    private function confirmpayment(Request $request, $number = null)
    {
        $customer = DB::table('ptom_customers')->where('customer_number', '=', $request->number_payment_customer)->first();
        if ($number != null) {
            $number_payent = PaymentHeader::where('payment_number', '=', $number)->first();
            $n = $number;
        } else {
            $number_payent = PaymentHeader::where('payment_number', '=', $request->number_payment_invoice)->first();
            $n = $request->number_payment_invoice;
        }

        if (empty($number_payent) || $number_payent == null) {
            return 'false';
        }
        // if ($number_payent->payment_status != 'Draft') {
        //     return 'false';
        // }
        $number_payent->payment_status = 'Confirm';
        if (!$number_payent->save()) {
            return 'false';
        }
        //update status order header is "Invoice"
        $paymentMatchInvoice = PaymentMatchInvoice::where('payment_header_id', '=', $number_payent->payment_header_id)->get();
        if (!empty($paymentMatchInvoice)) {
            foreach ($paymentMatchInvoice as $pmi) {
                $apple1 = PaymentMatchInvoice::where('prepare_order_number', $pmi->prepare_order_number)->get(['payment_match_id']);
                $amount_invoice = 0;
                foreach ($apple1 as $a1) {
                    $apply = PaymentApply::where('payment_match_id', $a1->payment_match_id)->get(['invoice_amount']);
                    foreach ($apply as $ay) {
                        $amount_invoice += $ay->invoice_amount;
                    }
                }

                $total_payment = $amount_invoice + $pmi->payment_amount;

                $orderH = OrderHeaders::where('prepare_order_number', '=', $pmi->prepare_order_number)->first();
                if (!empty($orderH) && $orderH->grand_total == $total_payment) {
                    OrderRepo::insertOrdersHistoryv2($orderH, 'Invoice');
                    // $orderH->order_status = 'Invoice';
                    // $orderH->save();
                }
            }
        }

        return array('id' => $number_payent->payment_header_id, 'number' => $request->number_payment_invoice, 'type' => $customer->sales_classification_code, 'name' => $customer->customer_name);
    }

    private function concelpayment(Request $request)
    {
        $customer = DB::table('ptom_customers')->where('customer_number', '=', $request->number_payment_customer)->first();
        $number_payent = PaymentHeader::where('payment_number', '=', $request->number_payment_invoice)->first();
        if (empty($number_payent) || $number_payent == null) {
            return 'false';
        }
        $payment_header_id = $number_payent->payment_header_id;
        $paymentMatchInvoices = PaymentMatchInvoice::where('payment_header_id', '=', $payment_header_id);
        if ($paymentMatchInvoices->where('match_flag', 'Y')->count() > 0) {
            return 'false';
        }
        $number_payent->payment_status = 'Cancel';
        if (!$number_payent->save()) {
            return 'false';
        }

        //update status order header is "Confirm"
        $paymentMatchInvoice = PaymentMatchInvoice::where('payment_header_id', '=', $payment_header_id)->get();
        if (!empty($paymentMatchInvoice)) {
            foreach ($paymentMatchInvoice as $pmi) {
                PaymentMatchInvoice::find($pmi->payment_match_id)->update(['match_flag' => 'N']);
                $orderH = OrderHeaders::where('prepare_order_number', '=', $pmi->prepare_order_number)->first();
                if (!empty($orderH)) {
                    OrderHistory::where('order_header_id', $orderH->order_header_id)->where('order_status', 'Invoice')->delete();
                    // $orderH->order_status = 'Confirm';
                    // $orderH->save();
                }
            }
        }

        return array('number' => $request->number_payment_invoice, 'type' => $customer->sales_classification_code, 'name' => $customer->customer_name);
    }

    function print($id)
    {
        $prints = DB::select("SELECT * FROM PTOM_PAYMENT_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_PAYMENT_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE PTOM_PAYMENT_HEADERS.PAYMENT_NUMBER = '$id' ORDER BY PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID DESC FETCH FIRST 1 ROWS ONLY");
        if (empty($prints)) {
            return back();
        }
        $conver_amount= collect(DB::select("select *
                                    from ptom_payment_exp_v
                                    where payment_number = '{$id}'"));

        $ids = $prints[0]->payment_header_id;
        $payments = DB::select("SELECT PTOM_PAYMENT_DETAILS.CONVERSION_RATE,PTOM_PAYMENT_METHOD_EXPORT.MEANING,PTOM_PAYMENT_DETAILS.BANK_DESC, PTOM_PAYMENT_DETAILS.payment_amount FROM PTOM_PAYMENT_DETAILS LEFT JOIN PTOM_PAYMENT_METHOD_EXPORT ON PTOM_PAYMENT_DETAILS.PAYMENT_METHOD_CODE = PTOM_PAYMENT_METHOD_EXPORT.LOOKUP_CODE WHERE PTOM_PAYMENT_DETAILS.PAYMENT_HEADER_ID = '$ids' GROUP BY PTOM_PAYMENT_DETAILS.CONVERSION_RATE,PTOM_PAYMENT_METHOD_EXPORT.MEANING,PTOM_PAYMENT_DETAILS.BANK_DESC, PTOM_PAYMENT_DETAILS.payment_amount");
        $details = PaymentMatchInvoice::where('ptom_payment_match_invoices.match_flag', 'Y')->where('ptom_payment_match_invoices.payment_header_id', $ids)->groupBy(['prepare_order_number', 'payment_type_code'])->get(['prepare_order_number', 'payment_type_code', DB::raw("SUM(payment_amount) as payment_amount")]);

        $tax_id = PtomCustomer::where('customer_id', $prints[0]->customer_id)->first();

        $tax = DB::table('ptom_toat_address_v')->first();

        $sum = 0;
        foreach ($details as $key => $value) {
            $sum += $value->payment_amount * $payments[0]->conversion_rate;
        }

        // MONEY NUMBER TO TEXT
        $explodeSum = explode('.', number_format($sum, 2, '.', ''));
        $sumFirst = !empty($explodeSum[0]) ? ucwords(translateToWords((int)$explodeSum[0])) : '';
        $sumStang = !empty($explodeSum[1]) && $explodeSum[1] > 0 ? ' and '.ucwords(translateToWords((int)$explodeSum[1])) : '';
        $sumText = $sumFirst.$sumStang;


        // if(empty($prints[0]->remark)){

        foreach($details as $detail){
            if($detail->payment_type_code == 10){
                $detail->remarkDes = 'PAYMENT OF SALES CONFIRMATION NO.'.$detail->prepare_order_number;
            }else{
                $detail->remarkDes = 'PAYMENT OF INVOICE NO.'.$detail->prepare_order_number;
            } 
        }
            // if($details[0]->payment_type_code == 10){
            //     $details[0]->remarkDes = 'PAYMENT OF SALES CONFIRMATION NO.'.$details[0]->prepare_order_number;
            // }else{
            //     $details[0]->remarkDes = 'PAYMENT OF INVOICE NO.'.$details[0]->prepare_order_number;
            // }
        // }
        $prints[0]->remark = !empty($prints[0]->remark) ? $prints[0]->remark : optional(@$details[0])->remarkDes;

        if (!empty($prints[0])) {
            $prints[0]->district = DB::table('ptom_thailand_territory')->where('tambon_id', $prints[0]->district_code)->pluck('tambon_eng_short')->first();
            $prints[0]->city = DB::table('ptom_thailand_territory')->where('district_id', $prints[0]->city_code)->pluck('district_eng_short')->first();
        }

        $toatAddress = DB::table('ptom_toat_address_v')->first();

        if ($prints[0]->head_office_flag == 'Y') {
            $prints[0]->customer_name = $prints[0]->customer_name . ' (HEAD OFFICE)';
        } else {
            $prints[0]->customer_name = $prints[0]->customer_name . ' BRANCH NO. ' . $prints[0]->branch;
        }

        if(count($details) == 0) {
            $explodeSum = explode('.', number_format($conver_amount->sum('conversion_amount'), 2, '.', ''));
            $sumFirst = !empty($explodeSum[0]) ? ucwords(translateToWords((int)$explodeSum[0])) : '';
            $sumStang = !empty($explodeSum[1]) && $explodeSum[1] > 0 ? ' and '.ucwords(translateToWords((int)$explodeSum[1])) : '';
            $sumText = $sumFirst.$sumStang;
        }
   
        // dd($conver_amount->sum('conversion_amount'));
        $data_1 = [
            'prints' => $prints[0],
            'details' => $details,
            'details0' => @$details[0],
            'payments' => $payments,
            'tax_id' => $tax_id,
            'tax' => $tax ?? null,
            'sumText' => $sumText,
            'toatAddress' => $toatAddress
        ];

        // dd($data_1);
        // return view('om.exports.paymentMethod.print_1', compact('data_1'));


        // $pages = array();
        // $pages[] = View::make('om.exports.paymentMethod.print_1', compact('data_1'));
        // // $pages[] = View::make('om.exports.paymentMethod.print_2', compact('data_2'));
        // // dd($data_1);
        $pdf = SnappyPdf::loadView('om.exports.paymentMethod.print_1', compact('data_1', 'conver_amount'));
        $pdf->setPaper('a4')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setTimeout(300);

        return $pdf->inline();
    }
}
