<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OM\Api\OrderEcomController;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\AttachFiles;
use App\Models\OM\BankAccounts;
use App\Models\OM\ConsignmentHeader;
use App\Models\OM\CreditNote\CustomerContractGroupModel;
use App\Models\OM\CustomerContractGroup;
use App\Models\OM\Customers;
use App\Models\OM\OrderDirectDebit;
use App\Models\OM\OrderHeaders;
use App\Models\OM\OverdueDebt\PaymentApplyCNDN;
use App\Models\OM\PaymentApply;
use App\Models\OM\PaymentHeader;
use App\Models\OM\PaymentLines;
use App\Models\OM\PaymentMatchInvoice;
use App\Models\OM\PtomInvoiceHeader;
use App\Models\OM\SaleConfirmation\OrderHistory;
use App\Repositories\OM\GenerateNumberRepo;
use App\Repositories\OM\OrderRepo;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Exception;
use FormatDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PDF;

class PaymentMethodController extends Controller
{

    public function __construct()
    {
        ini_set('max_input_vars', '3000');
    }

    public function callApp() {
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                DECLARE
                            V_ORGANIZATION_ID       NUMBER          :=  NULL;

                        BEGIN
                            BEGIN 
                                SELECT  ORGANIZATION_ID
                                INTO    V_ORGANIZATION_ID
                                FROM    HR_OPERATING_UNITS
                                WHERE   SHORT_CODE = 'TOAT';
                            END;
                                
                            mo_global.set_policy_context('S', V_ORGANIZATION_ID);

                        END;
                    ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);

        $stmt = $db->prepare($sql);
        $stmt->execute();
    }


    public function index($type)
    {
        $arReceiptsV = [];
        $customers = Customers::where(function ($q) {
                                        $q->where('customer_type_id', '!=', '80');
                                    })
                                ->whereRaw("UPPER(sales_classification_code) = 'DOMESTIC'")
                                ->orderBy('customer_number', 'ASC')
                                ->get();
        $banks = BankAccounts::get(['bank_number', 'bank_branch_name']);
        $payments = PaymentHeader::get(['payment_number']);
        $methods = DB::table('ptom_payment_method_domestic')->whereNull('tag')->select('lookup_code', 'meaning', 'description')->get();
        $bankdesc = DB::table('oaom.ptom_receipt_bank_acc_v')->whereNotNull('ptom_receipt_bank_acc_v.mapping_om_type')
        ->leftJoin('ptom_receipt_rept_bank_desc_v', 'ptom_receipt_bank_acc_v.bank_account_name', '=', 'ptom_receipt_rept_bank_desc_v.description')
        ->select('ptom_receipt_rept_bank_desc_v.lookup_code','ptom_receipt_bank_acc_v.bank_account_name', 'ptom_receipt_bank_acc_v.bank_account_number', 'ptom_receipt_bank_acc_v.bank_number')
        ->groupBy('ptom_receipt_rept_bank_desc_v.lookup_code','ptom_receipt_bank_acc_v.bank_account_name', 'ptom_receipt_bank_acc_v.bank_account_number', 'ptom_receipt_bank_acc_v.bank_number')
        ->get();
        // dump(DB::table('ptom_payment_details')->take(20)->get());
        $paymenynumberref = DB::table('ptom_payment_headers')->leftJoin('ptom_customers', 'ptom_payment_headers.customer_id', 'ptom_customers.customer_id')->whereRaw("UPPER(ptom_customers.sales_classification_code) = 'DOMESTIC'")->select('ptom_payment_headers.payment_number', 'ptom_customers.customer_name', 'ptom_payment_headers.payment_date', 'ptom_customers.attribute2')->orderBy('ptom_payment_headers.payment_number', 'DESC')->get();
        if(request()->action_note == '_ADD_NOTE') {
            DB::table('ptom_payment_headers')->where('payment_number', request()->payment_number)->update(['remark' => request()->NOTE]);
        }
        if (request()->all()) {
            $validator = Validator::make(request()->all(), [
                'payment_number' => 'required',
            ], [
                'payment_number.required' => 'กรุณาระบุเลขที่ใบเสร็จรับเงิน',
            ]);
            if ($validator->fails()) {
                request()->session()->flashInput(request()->all());
                return redirect()->back()->withErrors($validator->errors()->first());
            }
            $requests = request()->all();
            $infodata = PaymentHeader::with(array('paymentMethod' => function ($query) {
                $query->orderBy('ptom_payment_details.line_number', 'ASC');
            }, 'customer', 'files' => function ($query) {
                $query->where('ptom_attachments.attachment_program_code', '=', 'OMP0024');
            }))->where('ptom_payment_headers.payment_number', $requests['payment_number'])->first();
            $this->callApp();

            $arReceiptsV = DB::table('PTOM_AR_RECEIPTS_V')->where('receipt_number', "LIKE", $infodata->payment_number."%")->get();
            // dd(DB::table('PTOM_AR_RECEIPTS_V')->where('receipt_number', "LIKE", $infodata->payment_number."%")->get(), $infodata);

            if (empty($infodata)) {
                $requests['callback_search'] = true;
                request()->session()->flashInput($requests);
                return back()->withErrors('ไม่พบข้อมูลที่ค้นหา');
            }

            $paymentsmethod = PaymentMatchInvoice::where('payment_header_id', $infodata->payment_header_id)->where('match_flag', 'Y')->groupBy(['prepare_order_number', 'due_date', 'credit_group_code', 'match_flag', 'due_day', 'invoice_id', 'creation_date', 'payment_header_id', 'invoice_number', 'outstanding_debt'])->orderBy('due_date', 'asc')->orderBy('prepare_order_number', 'asc')->get(['prepare_order_number', 'due_date', 'credit_group_code', 'match_flag', 'due_day', 'invoice_id', 'creation_date', 'payment_header_id', 'invoice_number', DB::raw("SUM(payment_amount) payment_amount"), 'outstanding_debt']);

            $payment_date_invoice = PaymentHeader::with('details')->find($infodata->payment_header_id);
            $dataordernumbers = [];
            $usersamo = DB::table('ptom_customers')->select('customer_type_id')->where('customer_id', $infodata->customer->customer_id)->first();
            if (!empty($usersamo) && ($usersamo->customer_type_id == '30' || $usersamo->customer_type_id == '40')) {
                $usamo = true;
            } else {
                $usamo = false;
            }

            if ($usamo) {
                $dataordernumber = DB::select("SELECT PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER FROM PTOM_ORDER_CREDIT_GROUPS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE WHERE PTOM_ORDER_HEADERS.CUSTOMER_ID = '" . $infodata->customer->customer_id . "' AND PTOM_PRODUCT_TYPE_DOMESTIC.DESCRIPTION IS NOT NULL AND UPPER(PTOM_ORDER_HEADERS.ORDER_STATUS) = 'CONFIRM' AND UPPER(PTOM_ORDER_HEADERS.PAYMENT_APPROVE_FLAG) = 'Y' AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 AND PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER IS NOT NULL AND PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE != 10 GROUP BY PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER");
                foreach ($dataordernumber as $key => $dton) {
                    array_push($dataordernumbers, $dton->prepare_order_number);
                }
            } else {
                $dataordernumber = DB::select("SELECT PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER FROM PTOM_ORDER_CREDIT_GROUPS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE WHERE PTOM_ORDER_HEADERS.CUSTOMER_ID = '" . $infodata->customer->customer_id . "' AND PTOM_PRODUCT_TYPE_DOMESTIC.DESCRIPTION IS NOT NULL AND UPPER(PTOM_ORDER_HEADERS.ORDER_STATUS) = 'CONFIRM' AND UPPER(PTOM_ORDER_HEADERS.PAYMENT_APPROVE_FLAG) = 'Y' AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 AND PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER IS NOT NULL GROUP BY PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER");
                foreach ($dataordernumber as $key => $dton) {
                    array_push($dataordernumbers, $dton->prepare_order_number);
                }
            }

            $datainvoices = [];
            $datainvoice = DB::select("SELECT PTOM_ORDER_HEADERS.PICK_RELEASE_NO,SUM(CASE WHEN PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' THEN PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT ELSE 0 END) PAYMENT_AMOUNT,SUM(PTOM_ORDER_CREDIT_GROUPS.AMOUNT) TOTAL_AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE LEFT JOIN PTOM_PAYMENT_MATCH_INVOICES ON (PTOM_ORDER_HEADERS.PICK_RELEASE_ID = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID IS NULL) LEFT JOIN PTOM_PAYMENT_APPLY_CNDN ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_MATCH_ID = PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID WHERE PTOM_ORDER_HEADERS.CUSTOMER_ID = '" . $infodata->customer->customer_id . "' AND UPPER(PTOM_ORDER_HEADERS.ORDER_STATUS) = 'CONFIRM' AND UPPER(PTOM_ORDER_HEADERS.PAYMENT_APPROVE_FLAG) = 'Y' AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 AND PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL GROUP BY PTOM_ORDER_HEADERS.PICK_RELEASE_NO");
            foreach ($datainvoice as $key => $dtiv) {
                array_push($datainvoices, $dtiv->pick_release_no);
            }

            $defineCN = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $infodata->customer->customer_id . " AND PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE != 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NULL AND PROGRAM_CODE = 'OMP0032'"); //denied fines
            $requests['callback_search'] = true;
        } else {
            $usamo = false;
            $infodata = [];
            $defineCN = [];
            $dataordernumbers = [];
            $datainvoices = [];
            $paymentsmethod = [];
            $requests['callback_search'] = false;
            $payment_date_invoice= [];
        }
        request()->session()->flashInput($requests);
        $page = "om.payment_method.index";
        return view($page, compact('customers','arReceiptsV',  'banks', 'payments', 'methods', 'infodata', 'defineCN', 'paymenynumberref', 'bankdesc', 'dataordernumbers', 'datainvoices', 'usamo', 'paymentsmethod', 'payment_date_invoice'));
    }

    public function getvaluefromnumber(Request $request)
    {
        // $number = $request->number;
        // $credit = $request->credit_code;

        // if ($credit == null || $credit == '') {
        //     $DPayment = DB::select("SELECT PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
        //     PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
        //     PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,
        //     PTOM_PRODUCT_TYPE_DOMESTIC.DESCRIPTION,
        //     SUM(PTOM_ORDER_CREDIT_GROUPS.AMOUNT) TOTAL_AMOUNT,
        //     PTOM_ORDER_HEADERS.ORDER_DATE,
        //     PTOM_ORDER_HEADERS.DELIVERY_DATE,
        //     PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE
        //         FROM PTOM_ORDER_CREDIT_GROUPS
        //         LEFT JOIN PTOM_ORDER_HEADERS
        //             ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID
        //         LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC
        //             ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE
        //         LEFT JOIN PTOM_PAYMENT_MATCH_INVOICES
        //             ON (PTOM_ORDER_HEADERS.PICK_RELEASE_ID = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID IS NULL)
        //         WHERE PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER = '" . $number . "' AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0
        //             GROUP BY PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
        //                 PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
        //                 PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,
        //                 PTOM_PRODUCT_TYPE_DOMESTIC.DESCRIPTION,
        //                 PTOM_ORDER_HEADERS.ORDER_DATE,
        //                 PTOM_ORDER_HEADERS.DELIVERY_DATE,
        //                 PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE");
        //     if (count($DPayment) > 1) {
        //         $info = array();
        //         foreach ($DPayment as $dp) {
        //             array_push($info, $dp);
        //         }
        //         return response()->json(['status' => 'choose', 'data' => $info]);
        //     }
        // } else {
        //     $DPayment = DB::select("SELECT PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
        //     PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
        //     PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,
        //     PTOM_PRODUCT_TYPE_DOMESTIC.DESCRIPTION,
        //     SUM(PTOM_ORDER_CREDIT_GROUPS.AMOUNT) TOTAL_AMOUNT,
        //     PTOM_ORDER_HEADERS.ORDER_DATE,
        //     PTOM_ORDER_HEADERS.DELIVERY_DATE,
        //     PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE
        //         FROM PTOM_ORDER_CREDIT_GROUPS
        //         LEFT JOIN PTOM_ORDER_HEADERS
        //             ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID
        //         LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC
        //             ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE
        //         LEFT JOIN PTOM_PAYMENT_MATCH_INVOICES
        //             ON (PTOM_ORDER_HEADERS.PICK_RELEASE_ID = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID IS NULL)
        //         WHERE PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER = '" . $number . "' AND PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE = '" . $credit . "' AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0
        //             GROUP BY PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
        //                 PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
        //                 PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,
        //                 PTOM_PRODUCT_TYPE_DOMESTIC.DESCRIPTION,
        //                 PTOM_ORDER_HEADERS.ORDER_DATE,
        //                 PTOM_ORDER_HEADERS.DELIVERY_DATE,
        //                 PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE");
        // }
        // if (!empty($DPayment)) {
        //     $customer = Customers::where('customer_number', $request->customer_number)->first();

        //     $data = $DPayment[0];
        //     $gCode = $data->credit_group_code == 0 ? 'เงินสด' : $data->credit_group_code;

        //     $getTotalAmount = DB::select("SELECT SUM(AMOUNT) TOTAL_AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS WHERE ORDER_HEADER_ID = $data->order_header_id AND ORDER_LINE_ID != 0 AND CREDIT_GROUP_CODE = $data->credit_group_code");

        //     $dbdayamount = DB::select("SELECT DAY_AMOUNT FROM PTOM_CUSTOMER_CONTRACT_GROUPS WHERE CUSTOMER_ID = '" . $customer->customer_id . "' AND CREDIT_GROUP_CODE = '" . $gCode . "'");

        //     $totaldaysinyear = CarbonInterval::year()->totalDays;
        //     $today = Carbon::now('Asia/Bangkok')->format('Y-m-d');
        //     $d1 = explode('-', $today);


        //     $pyamentd = PaymentMatchInvoice::where('match_flag', 'Y')->where('prepare_order_number', $data->prepare_order_number)->where('credit_group_code', $data->credit_group_code)->sum('payment_amount');

        //     $payment_ed = !empty($pyamentd) ? $pyamentd : 0;

        //     if ($payment_ed == 0) {
        //         $amount_balance_total = $getTotalAmount[0]->total_amount;
        //     } else {
        //         $paymentmathid = PaymentMatchInvoice::where('match_flag', 'Y')->where('prepare_order_number', $data->prepare_order_number)->where('credit_group_code', $data->credit_group_code)->first();

        //         $checkdcn = PaymentApply::where('payment_match_id', $paymentmathid->payment_match_id)->first();
        //         if (!empty($checkdcn)) {
        //             $paymentdcn = DB::select("SELECT PTOM_PAYMENT_APPLY_CNDN.INVOICE_AMOUNT INVOICE_AMOUNT FROM PTOM_PAYMENT_APPLY_CNDN LEFT JOIN PTOM_INVOICE_HEADERS ON PTOM_PAYMENT_APPLY_CNDN.INVOICE_HEADER_ID = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID WHERE PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID = '" . $paymentmathid->payment_match_id . "' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE != 'DN'");
        //             if (!empty($paymentdcn)) {
        //                 $notdn = $paymentdcn[0]->invoice_amount;
        //             } else {
        //                 $notdn = 0;
        //             }
        //         } else {
        //             $notdn = 0;
        //         }

        //         $denine = $payment_ed - $notdn;

        //         $amount_balance_total = $getTotalAmount[0]->total_amount - $denine;
        //     }

        //     if ($customer->customer_type_id == 40 || $customer->customer_type_id == 30) {
        //         if ($data->product_type_code != 10) {
        //             $dbdayamount = DB::select("SELECT DAY_AMOUNT FROM PTOM_CUSTOMER_CONTRACT_GROUPS WHERE CUSTOMER_ID = '" . $customer->customer_id . "' AND CREDIT_GROUP_CODE = '" . $gCode . "'");
        //             $dataday = empty($dbdayamount) ? '0' : $dbdayamount[0]->day_amount;
        //         } else {
        //             if ($customer->customer_type_id == 30) {
        //                 $dataday = 0;
        //             } else {
        //                 $t = DB::select("SELECT * FROM PTOM_TERMS_V WHERE CREDIT_GROUP_CODE = '0'");
        //                 $dataday = empty($t) ? '0' : $t[0]->due_days_consignment;
        //             }
        //         }
        //     } else {
        //         $dbdayamount = DB::select("SELECT DAY_AMOUNT FROM PTOM_CUSTOMER_CONTRACT_GROUPS WHERE CUSTOMER_ID = '" . $customer->customer_id . "' AND CREDIT_GROUP_CODE = '" . $gCode . "'");
        //         $dataday = empty($dbdayamount) ? '0' : $dbdayamount[0]->day_amount;
        //     }


        //     if ($customer->customer_type_id == 40 || $customer->customer_type_id == 30) {
        //         if ($data->product_type_code != 10) {
        //             $paymentduedate = Carbon::parse($data->delivery_date)->format('Y-m-d');
        //             $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
        //         } else {
        //             $c = ConsignmentHeader::where('order_header_id', $data->order_header_id)->first();
        //             if ($data->customer_type_id == 30 && $data->product_type_code == 10) {
        //                 $paymentduedate = Carbon::parse($c->consignment_date)->format('Y-m-d');
        //                 $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
        //             } else {
        //                 if ($data->product_type_code == 10) {
        //                     $t = DB::select("SELECT * FROM PTOM_TERMS_V WHERE CREDIT_GROUP_CODE = '0'");
        //                     if (!empty($t)) {
        //                         if ($t[0]->due_days_consignment == 0) {
        //                             $paymentduedate = Carbon::parse($c->consignment_date)->format('Y-m-d');
        //                             $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
        //                         } else {
        //                             $paymentduedate = Carbon::parse($data->delivery_date)->addDays($t[0]->due_days_consignment)->format('Y-m-d');
        //                             $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
        //                         }
        //                     } else {
        //                         $paymentduedate = Carbon::now()->format('Y-m-d');
        //                         $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
        //                     }
        //                 } elseif ($customer->customer_type_id == 40) {
        //                     $paymentduedate = Carbon::parse($data->delivery_date)->format('Y-m-d');
        //                     $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
        //                 } else {
        //                     $paymentduedate = Carbon::now()->format('Y-m-d');
        //                     $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
        //                 }
        //             }
        //         }
        //         $payfines = '0.00';
        //     } else {
        //         if ($dataday != 0) {
        //             $paymentduedate = Carbon::parse($data->delivery_date)->addDays($dataday)->format('Y-m-d');
        //             $d2 = explode('-', $paymentduedate);
        //             $date1 = Carbon::createMidnightDate($d1[0], $d1[1], $d1[2], 'Asia/Bangkok');
        //             $date2 = Carbon::createMidnightDate($d2[0], $d2[1], $d2[2], 'Asia/Bangkok');
        //             if ($date1->greaterThan($date2)) {
        //                 if ($data->pick_release_no != null) {
        //                     $imporoe = DB::select("SELECT CANCEL_FLAG FROM PTOM_IMPROVE_FINES WHERE INVOICE_NUMBER = '" . $data->pick_release_no . "' AND CREDIT_GROUP_CODE = '" . $data->credit_group_code . "'");
        //                 } else {
        //                     $imporoe = null;
        //                 }

        //                 if (!empty($imporoe) && $imporoe[0]->cancel_flag == 'Y') {
        //                     $payfines = '0.00';
        //                 } else {

        //                     $arrDueDate = explode('-', $paymentduedate);
        //                     $dueYear = $arrDueDate[0];

        //                     if ($dueYear % 4 == 0) {
        //                         $dayOfYear = 366;
        //                     } else {
        //                         $dayOfYear = 365;
        //                     }

        //                     $newDueDate = date('Y-m-d', strtotime($paymentduedate));
        //                     $dateNow = date("Y-m-d");

        //                     // วันเริ่มต้น
        //                     $arrStart = explode('-', $newDueDate);
        //                     $startYear = $arrStart[0];
        //                     $startMonth = $arrStart[1];
        //                     $startDay = $arrStart[2];

        //                     // วันปัจจุบัน
        //                     $arrNow = explode('-', $dateNow);
        //                     $nowYear = $arrNow[0];
        //                     $nowMonth = $arrNow[1];
        //                     $nowDay = $arrNow[2];

        //                     $makeNow = mktime(0, 0, 0, $nowMonth, $nowDay, $nowYear);
        //                     $makeStart = mktime(0, 0, 0, $startMonth, $startDay, $startYear);

        //                     $dayOverDue = ceil(($makeNow - $makeStart) / 86400);

        //                     $totlepayfile = $amount_balance_total * 0.15 * $dayOverDue / $dayOfYear;

        //                     $payfines = number_format($totlepayfile, 2);
        //                 }
        //             } else {
        //                 $payfines = '0.00';
        //             }

        //             $ppp = $d2[0] . '-' . $d2[1] . '-' . $d2[2];
        //             $pdd = FormatDate::DateThaiNumericWithSplash($ppp);
        //         } else {
        //             $paymentduedate = Carbon::parse($data->delivery_date)->format('Y-m-d');
        //             $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
        //             $payfines = '0.00';
        //         }
        //     }

        //     $paymentInvoice = DB::table('ptom_payment_match_invoices as pmi')
        //         ->join('ptom_payment_headers as pph', 'pph.payment_header_id', '=', 'pmi.payment_header_id')
        //         ->where('pmi.match_flag', 'N')
        //         ->where('pph.customer_id', $customer->customer_id)
        //         ->whereNull('pmi.deleted_at')
        //         ->whereNull('pph.deleted_at')
        //         ->sum('payment_amount');

        //     $info = [
        //         'order_header_id' => $data->order_header_id,
        //         'prepare_order_number' => $data->prepare_order_number,
        //         'pick_release_no' => $data->pick_release_no,
        //         'description' => $data->description,
        //         'total_amount' => $amount_balance_total,
        //         'order_date1' => $data->order_date,
        //         'order_date2' => $data->order_date == null ? '' : FormatDate::DateThaiNumericWithSplash($data->order_date),
        //         'payment_duedate1' => $paymentduedate,
        //         'payment_duedate2' => $pdd,
        //         'credit_group1' => $data->credit_group_code,
        //         'credit_group2' => $gCode,
        //         'due_days' => $dataday,
        //         'amount_fines' => $payfines,
        //         'beforeamount' => number_format($paymentInvoice, 2)
        //     ];
        // } else {
        //     $info = [];
        // }

        // return response()->json(['status' => 'success', 'data' => $info]);
    }

    public function getinfofordraft(Request $request)
    {
        $customer = Customers::where('customer_number', $request->customer_number)->first();
        if (empty($customer)) {
            return response()->json(['amount_before' => '']);
        }

        $paymentInvoice = DB::table('ptom_payment_match_invoices as pmi')
            ->join('ptom_payment_headers as pph', 'pph.payment_header_id', '=', 'pmi.payment_header_id')
            ->where('pmi.match_flag', 'Y')
            ->where('pph.payment_status', 'Confirm')
            ->where('pph.customer_id', $customer->customer_id)
            ->whereNull('pmi.deleted_at')
            ->whereNull('pph.deleted_at')
            ->sum('payment_amount');

        $paymentTotal = PaymentLines::join('ptom_payment_headers', 'ptom_payment_details.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('ptom_payment_headers.customer_id', $customer->customer_id)->where('ptom_payment_headers.payment_status', 'Confirm')->sum('ptom_payment_details.payment_amount');

        $sumPayment = $paymentTotal - $paymentInvoice;

        $abs = number_format($sumPayment, 2);
        return response()->json(['amount_before' => $abs]);

        //     $dataordernumbers = [];
        //     if ($customer->customer_type_id == 40 || $customer->customer_type_id == 30) {
        //         $dataordernumber = DB::select("SELECT PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER FROM PTOM_ORDER_CREDIT_GROUPS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE WHERE PTOM_ORDER_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_PRODUCT_TYPE_DOMESTIC.DESCRIPTION IS NOT NULL AND UPPER(PTOM_ORDER_HEADERS.ORDER_STATUS) = 'CONFIRM' AND UPPER(PTOM_ORDER_HEADERS.PAYMENT_APPROVE_FLAG) = 'Y' AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 AND PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER IS NOT NULL AND PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE != 10 GROUP BY PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER ORDER BY PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER DESC");
        //     } else {
        //         $dataordernumber = DB::select("SELECT PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER FROM PTOM_ORDER_CREDIT_GROUPS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE WHERE PTOM_ORDER_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_PRODUCT_TYPE_DOMESTIC.DESCRIPTION IS NOT NULL AND UPPER(PTOM_ORDER_HEADERS.ORDER_STATUS) = 'CONFIRM' AND UPPER(PTOM_ORDER_HEADERS.PAYMENT_APPROVE_FLAG) = 'Y' AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 AND PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER IS NOT NULL GROUP BY PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER ORDER BY PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER DESC");
        //     }
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

        //         $ordercamount = $orderc->grand_total ?? 0;
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
        //     if ($customer->customer_type_id == 40 || $customer->customer_type_id == 30) {
        //         $datainvoice = DB::select("SELECT PTOM_ORDER_HEADERS.PICK_RELEASE_NO,SUM(CASE WHEN PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' THEN PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT ELSE 0 END) PAYMENT_AMOUNT,SUM(PTOM_ORDER_CREDIT_GROUPS.AMOUNT) TOTAL_AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE LEFT JOIN PTOM_PAYMENT_MATCH_INVOICES ON (PTOM_ORDER_HEADERS.PICK_RELEASE_ID = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID IS NULL) LEFT JOIN PTOM_PAYMENT_APPLY_CNDN ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_MATCH_ID = PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID WHERE PTOM_ORDER_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND UPPER(PTOM_ORDER_HEADERS.ORDER_STATUS) = 'CONFIRM' AND UPPER(PTOM_ORDER_HEADERS.PAYMENT_APPROVE_FLAG) = 'Y' AND PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 AND PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE != 10 GROUP BY PTOM_ORDER_HEADERS.PICK_RELEASE_NO ORDER BY PTOM_ORDER_HEADERS.PICK_RELEASE_NO DESC");
        //     } else {
        //         $datainvoice = DB::select("SELECT PTOM_ORDER_HEADERS.PICK_RELEASE_NO,SUM(CASE WHEN PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' THEN PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT ELSE 0 END) PAYMENT_AMOUNT,SUM(PTOM_ORDER_CREDIT_GROUPS.AMOUNT) TOTAL_AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE LEFT JOIN PTOM_PAYMENT_MATCH_INVOICES ON (PTOM_ORDER_HEADERS.PICK_RELEASE_ID = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID IS NULL) LEFT JOIN PTOM_PAYMENT_APPLY_CNDN ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_MATCH_ID = PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID WHERE PTOM_ORDER_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND UPPER(PTOM_ORDER_HEADERS.ORDER_STATUS) = 'CONFIRM' AND UPPER(PTOM_ORDER_HEADERS.PAYMENT_APPROVE_FLAG) = 'Y' AND PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 GROUP BY PTOM_ORDER_HEADERS.PICK_RELEASE_NO ORDER BY PTOM_ORDER_HEADERS.PICK_RELEASE_NO DESC");
        //     }
        //     foreach ($datainvoice as $key => $dtiv) {
        //         $orderc = OrderHeader::where('pick_release_no', $dtiv->pick_release_no)->first();
        //         $paymentc = PaymentMatchInvoice::where('prepare_order_number', $orderc->prepare_order_number)->where('match_flag', 'Y');

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

        //         $ordercamount = $orderc->grand_total ?? 0;
        //         $paymentcamount = $amountreal;

        //         if ($ordercamount != $paymentcamount) {
        //             array_push($datainvoices, $dtiv->pick_release_no);
        //         }
        //     }

        //     $invocess = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO,PTOM_ORDER_HEADERS.ORDER_HEADER_ID,SUM(CASE WHEN PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' THEN PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT ELSE 0 END) PAYMENT_AMOUNT,SUM(PTOM_ORDER_CREDIT_GROUPS.AMOUNT) TOTAL_AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE LEFT JOIN PTOM_PAYMENT_MATCH_INVOICES ON (PTOM_ORDER_HEADERS.PICK_RELEASE_ID = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID IS NULL) LEFT JOIN PTOM_PAYMENT_APPLY_CNDN ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_MATCH_ID = PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID LEFT JOIN PTOM_CONSIGNMENT_HEADERS ON PTOM_ORDER_HEADERS.ORDER_HEADER_ID = PTOM_CONSIGNMENT_HEADERS.ORDER_HEADER_ID WHERE PTOM_ORDER_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND UPPER(PTOM_ORDER_HEADERS.ORDER_STATUS) = 'CONFIRM' AND UPPER(PTOM_ORDER_HEADERS.PAYMENT_APPROVE_FLAG) = 'Y' AND PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID != 0 GROUP BY PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO,PTOM_ORDER_HEADERS.ORDER_HEADER_ID ORDER BY PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO DESC");
        //     foreach ($invocess as $key => $dtivv) {
        //         if ($dtivv->consignment_no != null) {
        //             $orderc = OrderHeader::where('order_header_id', $dtivv->order_header_id)->first();
        //             $paymentc = PaymentMatchInvoice::where('prepare_order_number', $orderc->prepare_order_number)->where('match_flag', 'Y');

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
        //                 array_push($datainvoices, $dtivv->consignment_no);
        //             }
        //         }
        //     }

        //     $defineCN = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $customer->customer_id . " AND PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE != 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NULL AND PROGRAM_CODE = 'OMP0032'");

        //     return response()->json(['dataordernumbers' => $dataordernumbers, 'datainvoices' => $datainvoices, 'defineDN' => json_decode(json_encode($defineDN)), 'defineCN' => json_decode(json_encode($defineCN))]);
    }

    public function getBankfromLogic(Request $request)
    {
        $exp = explode(',', $request->params);
        $data = DB::select(DB::raw("SELECT  ptom_receipt_rept_bank_desc_v.lookup_code,PTOM_RECEIPT_BANK_ACC_V.BANK_ACCOUNT_NAME, PRIMARY 
        FROM OAOM.PTOM_RECEIPT_BANK_ACC_V 
        left join ptom_receipt_rept_bank_desc_v ON ptom_receipt_bank_acc_v.bank_account_name = ptom_receipt_rept_bank_desc_v.description
        WHERE UPPER(MAPPING_OM_TYPE) = '" . strtoupper($exp[1]) . "'"));
        return response()->json(['data' => json_decode(json_encode($data))]);
    }

    public function getvaluebank(Request $request)
    {
        $d = DB::select(DB::raw("SELECT ptom_receipt_rept_bank_desc_v.lookup_code, PTOM_RECEIPT_BANK_ACC_V.BANK_ACCOUNT_NUMBER,PTOM_RECEIPT_BANK_ACC_V.BANK_ID,PTOM_RECEIPT_BANK_ACC_V.BANK_NUMBER 
        FROM OAOM.PTOM_RECEIPT_BANK_ACC_V 
        left join ptom_receipt_rept_bank_desc_v ON ptom_receipt_bank_acc_v.bank_account_name = ptom_receipt_rept_bank_desc_v.description
        WHERE PTOM_RECEIPT_BANK_ACC_V.BANK_ACCOUNT_NAME = '" . $request->valuebank . "'
         AND ROWNUM = 1"));
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
        $data = DB::select(DB::raw("SELECT PAYMENT_NUMBER FROM PTOM_PAYMENT_HEADERS WHERE CUSTOMER_ID = '" . $customer->customer_id . "' ORDER BY PAYMENT_NUMBER DESC"));

        // $defineDN = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $customer->customer_id . " AND PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NULL ORDER BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER DESC");

        $defineCN = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $customer->customer_id . " AND PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE != 'DN' AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NULL AND PROGRAM_CODE = 'OMP0032' ORDER BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER DESC");

        return response()->json(['data' => json_decode(json_encode($data)), 'defineCN' => json_decode(json_encode($defineCN))]);
    }

    public function print($type, $id)
    {
        if (strtoupper($type) == 'PRINT') {
            $prints = DB::select("SELECT * FROM PTOM_PAYMENT_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_PAYMENT_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID LEFT JOIN PTOM_THAILAND_TERRITORY_V ON PTOM_CUSTOMERS.PROVINCE_CODE = PTOM_THAILAND_TERRITORY_V.PROVINCE_ID WHERE PTOM_PAYMENT_HEADERS.PAYMENT_NUMBER = '$id' ORDER BY PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID DESC FETCH FIRST 1 ROWS ONLY");

            //toat_edit 02052566
            $prints_ship = DB::select("SELECT hd.pick_release_no,ship.address_line1,ship.address_line2,ship.address_line3,ship.alley,ship.district ,ship.city,ship.province_name,ship.postal_code
            FROM PTOM_PAYMENT_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_PAYMENT_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
            LEFT JOIN PTOM_THAILAND_TERRITORY_V ON PTOM_CUSTOMERS.PROVINCE_CODE = PTOM_THAILAND_TERRITORY_V.PROVINCE_ID
            INNER JOIN ptom_payment_match_invoices pm ON pm.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID
            inner join ptom_order_headers hd on hd.pick_release_no = pm.invoice_number
            inner join PTOM_CUSTOMER_SHIP_SITES ship on ship.ship_to_site_id = hd.ship_to_site_id
            WHERE PTOM_PAYMENT_HEADERS.PAYMENT_NUMBER = '$id' ORDER BY PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID DESC FETCH FIRST 1 ROWS ONLY");
            //--end toat_edit

            if (empty($prints)) {
                return back();
            }
            $sum_total = DB::table('ptom_payment_details')->where('payment_header_id', $prints[0]->payment_header_id)->sum('payment_amount');
            $prints[0]->payment_amount = $sum_total;
            $prints[0]->cash    = false;
            $prints[0]->bill    = false;
            $prints[0]->tranf   = false;

            $payMatch       = DB::table('ptom_payment_match_invoices')->where('payment_header_id', $prints[0]->payment_header_id)->get();
            $prints[0]->invoice_list = '';
            if($payMatch->count() > 0){
                $paymentDetail  = DB::table('ptom_payment_details')->where('payment_header_id', $prints[0]->payment_header_id)->get();

                foreach ($paymentDetail as $pD_item) {
                    if ($pD_item->payment_method_code == 10) {
                        $prints[0]->cash            = true;
                        $prints[0]->cash_amount     = $pD_item->payment_amount;
                    }
                    if ($pD_item->payment_method_code <> 10) {
                        $prints[0]->tranf           = true;
                        @$prints[0]->tranf_amount    += $pD_item->payment_amount;
                    }
                    if (empty($pD_item->payment_method_code)) {
                        $prints[0]->bill            = true;
                        $prints[0]->bill_amount     = $pD_item->payment_amount;
                    }
                }

                $prints[0]->product_type_10 = false;
                $prints[0]->product_type_20 = false;
                $invoice_number = [];
                $preprenumber = [];
                foreach($payMatch as $paymatch_item){
                    $orderHeader = DB::table('ptom_order_headers')->where('prepare_order_number',$paymatch_item->prepare_order_number)->first();
                    if($orderHeader->product_type_code == 10){
                        $prints[0]->product_type_10 = true;
                    }elseif($orderHeader->product_type_code == 20){
                        $prints[0]->product_type_20 = true;
                    }
                    $preprenumber[$paymatch_item->prepare_order_number] = $paymatch_item->prepare_order_number;
                    $invoice_number[$paymatch_item->invoice_number] = $paymatch_item->invoice_number;
                }
                $listInvoice = self::concatInvoice($invoice_number);/// implode(',',$invoice_number);
                $prints[0]->invoice_list =  $listInvoice;
                $listpreprenumber = implode(',',$preprenumber);
                $prints[0]->prepare_order_number =  $listpreprenumber;
            }
            $pdf = PDF::loadView('om.payment_method.print', compact('prints','prints_ship'))
                ->setOption('page-height', '5.5in')
                ->setOption('page-width', '8in')
                ->setOption('margin-left', '0')
                ->setOption('margin-right', '0')
                ->setOption('margin-top', '0')
                ->setOption('margin-bottom', '0');
            return $pdf->stream('omp0024.pdf');
        }
        return back();
    }

    public function draftpayment(Request $request)
    {
        $payment_date1 = explode('/', $request->payment_date);
        $y = $payment_date1[2] - 543;
        $payment_date = Carbon::parse($y . '-' . $payment_date1[1] . '-' . $payment_date1[0])->format('Y-m-d');
        $total_amount = str_replace(',', '', $request->total_amount);
        $total_amounts = $total_amount;
        $customer_number = trim($request->customer_number);
        $customer = Customers::where('customer_number', $customer_number)->first();

        if (empty($customer)) {
            return response()->json(['status' => 'error', 'msg' => 'ไม่พบข้อมูลลูกค้า', 'data' => '', 'amount_before' => '', 'dn' => '', 'cn' => '']);
        } else {
            $sqlCustomer = "PTOM_ORDER_HEADERS.CUSTOMER_ID = " . $customer->customer_id;
        }

        if ($customer->customer_type_id == 40) {
            $DPayment = DB::select("SELECT ORDER_HEADER_ID,PICK_RELEASE_NO,PICK_RELEASE_STATUS,PREPARE_ORDER_NUMBER,PRODUCT_TYPE_CODE,
            PRODUCT_TYPE_DESCRIPTION DESCRIPTION,OUTSTANDING_DEBT TOTAL_AMOUNT,ORDER_DATE,CUSTOMER_TYPE_ID,CREDIT_GROUP_CODE,
            CUSTOMER_ID,DUE_DATE,CONSIGNMENT_NO,CONSIGNMENT_DATE FROM PTOM_OUTSTANDING_DEBT_DOM_V WHERE CUSTOMER_ID = $customer->customer_id AND CREDIT_GROUP_CODE IS NOT NULL AND PRODUCT_TYPE_CODE != 10 ORDER BY DUE_DATE ASC, CREDIT_GROUP_CODE ASC, PREPARE_ORDER_NUMBER ASC");
        } elseif ($customer->customer_type_id == 30) {
            $DPayment = DB::select("SELECT ORDER_HEADER_ID,PICK_RELEASE_NO,PICK_RELEASE_STATUS,PREPARE_ORDER_NUMBER,PRODUCT_TYPE_CODE,
            PRODUCT_TYPE_DESCRIPTION DESCRIPTION,OUTSTANDING_DEBT TOTAL_AMOUNT,ORDER_DATE,CUSTOMER_TYPE_ID,CREDIT_GROUP_CODE,
            CUSTOMER_ID,DUE_DATE,CONSIGNMENT_NO,CONSIGNMENT_DATE FROM PTOM_OUTSTANDING_DEBT_DOM_V WHERE CUSTOMER_ID = $customer->customer_id AND CREDIT_GROUP_CODE IS NOT NULL ORDER BY DUE_DATE ASC, CREDIT_GROUP_CODE ASC, PREPARE_ORDER_NUMBER ASC");
        } else {
            $DPayment = DB::select("SELECT ORDER_HEADER_ID,PICK_RELEASE_NO,PICK_RELEASE_STATUS,PREPARE_ORDER_NUMBER,PRODUCT_TYPE_CODE,
            PRODUCT_TYPE_DESCRIPTION DESCRIPTION,OUTSTANDING_DEBT TOTAL_AMOUNT,ORDER_DATE,CUSTOMER_TYPE_ID,CREDIT_GROUP_CODE,
            CUSTOMER_ID,DUE_DATE,CONSIGNMENT_NO,CONSIGNMENT_DATE FROM PTOM_OUTSTANDING_DEBT_DOM_V WHERE CUSTOMER_ID = $customer->customer_id AND CREDIT_GROUP_CODE IS NOT NULL ORDER BY DUE_DATE ASC, CREDIT_GROUP_CODE ASC, PREPARE_ORDER_NUMBER ASC");
        }

        $defineCNs = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,
        PTOM_TERMS_V.DESCRIPTION,PTOM_TERMS_V.TERM_ID,PTOM_TERMS_V.DUE_DAYS FROM PTOM_INVOICE_HEADERS
        LEFT JOIN PTOM_TERMS_V ON PTOM_INVOICE_HEADERS.TERM_ID = PTOM_TERMS_V.TERM_ID
        WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = " . $customer->customer_id . " AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM'
        AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'CN_OTHER' AND PROGRAM_CODE = 'OMP0033'
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
            $html = "<tr class=\"align-middle jsonloopnotfound\"><td colspan=\"14\" class=\"text-danger text-center\">ไม่พบข้อมูลหนี้ค้างชำระ</td></tr>";
        } else {
            $payment_invoice_date = explode('/', $request->payment_date);
            $payment_invoice_date_y = $payment_invoice_date[2] - 543;
            $today = Carbon::parse($payment_invoice_date_y  .'-' . $payment_invoice_date[1].'-' . $payment_invoice_date[0])->format('Y-m-d');
            $d1 = explode('-', $today);
            $html = "";
            foreach ($DPayment as $key => $data) {
                $gCode = $data->credit_group_code == 0 ? 'เงินสด' : $data->credit_group_code;

                if ($customer->customer_type_id == 40 || $customer->customer_type_id == 30) {
                    if ($data->product_type_code != 10) {
                        $dbdayamount = DB::select("SELECT DAY_AMOUNT FROM PTOM_CUSTOMER_CONTRACT_GROUPS WHERE CUSTOMER_ID = '" . $customer->customer_id . "' AND CREDIT_GROUP_CODE = '" . $gCode . "'");
                        $dataday = empty($dbdayamount) ? '0' : $dbdayamount[0]->day_amount;
                    } else {
                        if ($customer->customer_type_id == 30 && $data->product_type_code == 10) {
                            $dataday = 0;
                        } else {
                            $t = DB::select("SELECT DUE_DAYS_CONSIGNMENT FROM PTOM_TERMS_V WHERE CREDIT_GROUP_CODE = '0'");
                            $dataday = empty($t) ? '0' : $t[0]->due_days_consignment;
                        }
                    }
                } else {
                    $dbdayamount = DB::select("SELECT DAY_AMOUNT FROM PTOM_CUSTOMER_CONTRACT_GROUPS WHERE CUSTOMER_ID = '" . $customer->customer_id . "' AND CREDIT_GROUP_CODE = '" . $gCode . "'");
                    $dataday = empty($dbdayamount) ? '0' : $dbdayamount[0]->day_amount;
                }

                if ($customer->customer_type_id == 30 && $data->product_type_code == 10) {
                    $getTotalAmount = $data->total_amount;
                } else {
                    $getTotalAmount = DB::select("SELECT SUM(AMOUNT) TOTAL_AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS WHERE ORDER_HEADER_ID = $data->order_header_id AND ORDER_LINE_ID = 0 AND CREDIT_GROUP_CODE = $data->credit_group_code");
                }

                // if ($data->prepare_order_number != null) {
                //     $direct_debit = OrderHeader::where('prepare_order_number', $data->prepare_order_number)->first();
                //     if (!empty($direct_debit)) {
                //         $ignore_prepare_order_number = ['30', '40', '50'];
                //         if (in_array($direct_debit->payment_method_code, $ignore_prepare_order_number)) {
                //             $debit_flag = OrderDirectDebit::where('order_header_id', $direct_debit->order_header_id)->where('credit_group_code', $data->credit_group_code)->where('direct_debit_flag', 'N')->first();
                //             if (!empty($debit_flag)) {
                //                 $flag_debit = true;
                //                 $flag_show = true;
                //                 $flag_amount = $debit_flag->direct_debit_amount;
                //             } else {
                //                 $flag_debit = false;
                //                 $flag_show = false;
                //             }
                //         } else {
                //             $flag_debit = false;
                //             $flag_show = true;
                //         }
                //     } else {
                //         $flag_debit = false;
                //         $flag_show = true;
                //     }
                // } else {
                //     $flag_debit = false;
                //     $flag_show = true;
                // }

                // // if ($payment_ed == 0) {
                // if ($customer->customer_type_id == 30 && $data->product_type_code == 10) {
                //     if ($flag_debit) {
                //         if ($flag_amount > $data->total_amount) {
                //             $amount_balance_total = $data->total_amount;
                //         } else {
                //             $amount_balance_total = $flag_amount;
                //         }
                //     } else {
                //         $amount_balance_total = $data->total_amount;
                //     }
                // } else {
                //     if ($flag_debit) {
                //         if ($flag_amount > $data->total_amount) {
                //             $amount_balance_total = $data->total_amount;
                //         } else {
                //             $amount_balance_total = $flag_amount;
                //         }
                //     } else {
                //         $amount_balance_total = $data->total_amount;
                //     }
                // }
                $amount_balance_total = $data->total_amount;


                //delivery_date
                $paymentduedates = Carbon::parse($data->due_date)->format('Y-m-d');
                if (empty($paymentduedates)) {
                    $paymentduedate = Carbon::parse($paymentduedates)->format('Y-m-d');
                    $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
                    $payfines = '0.00';
                } else {
                    if ($customer->customer_type_id == 40 || $customer->customer_type_id == 30) {
                        if ($data->product_type_code != 10) {
                            $paymentduedate = Carbon::parse($paymentduedates)->format('Y-m-d');
                            $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
                        } else {
                            // $c = ConsignmentHeader::where('order_header_id', $data->order_header_id)->first();
                            if ($data->customer_type_id == 30 && $data->product_type_code == 10) {
                                $paymentduedate = Carbon::parse($data->consignment_date)->format('Y-m-d');
                                $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
                            } else {
                                if ($data->product_type_code == 10) {
                                    $t = DB::select("SELECT DUE_DAYS_CONSIGNMENT FROM PTOM_TERMS_V WHERE CREDIT_GROUP_CODE = '0'");
                                    if (!empty($t)) {
                                        if ($t[0]->due_days_consignment == 0) {
                                            $paymentduedate = Carbon::parse($data->consignment_date)->format('Y-m-d');
                                            $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
                                        } else {
                                            $paymentduedate = Carbon::parse($paymentduedates)->addDays($t[0]->due_days_consignment)->format('Y-m-d');
                                            $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
                                        }
                                    } else {
                                        $paymentduedate = Carbon::now()->format('Y-m-d');
                                        $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
                                    }
                                } elseif ($customer->customer_type_id == 40) {
                                    $paymentduedate = Carbon::parse($paymentduedates)->format('Y-m-d');
                                    $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
                                } else {
                                    $paymentduedate = Carbon::now()->format('Y-m-d');
                                    $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
                                }
                            }
                        }

                        if ($data->product_type_code == 10) {
                            $d2 = explode('-', $paymentduedate);
                            $date1 = Carbon::createMidnightDate($d1[0], $d1[1], $d1[2], 'Asia/Bangkok');
                            $date2 = Carbon::createMidnightDate($d2[0], $d2[1], $d2[2], 'Asia/Bangkok');

                            if ($date1->greaterThan($date2)) {

                                if ($customer->customer_type_id == 30 || $customer->customer_type_id == 40) {
                                    if ($data->consignment_no != null) {
                                        $imporoe = DB::select("SELECT CANCEL_FLAG FROM PTOM_IMPROVE_FINES WHERE INVOICE_NUMBER = '" . $data->consignment_no . "' AND CREDIT_GROUP_CODE = '" . $data->credit_group_code . "' AND CANCEL_FLAG = 'Y'");
                                    } else {
                                        $imporoe = null;
                                    }
                                } else {
                                    if ($data->pick_release_no != null) {
                                        $imporoe = DB::select("SELECT CANCEL_FLAG FROM PTOM_IMPROVE_FINES WHERE INVOICE_NUMBER = '" . $data->pick_release_no . "' AND CREDIT_GROUP_CODE = '" . $data->credit_group_code . "' AND CANCEL_FLAG = 'Y'");
                                    } else {
                                        $imporoe = null;
                                    }
                                }

                                if (!empty($imporoe)) {
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
                                    // $payfines = '0.00';
                                }
                            } else {
                                $payfines = '0.00';
                            }
                        } else {
                            $payfines = '0.00';
                        }
                    } else {
                        // if ($dataday != 0) {
                        $paymentduedate = Carbon::parse($data->due_date)->format('Y-m-d');
                        $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);

                        $d2 = explode('-', $paymentduedate);
                        $date1 = Carbon::createMidnightDate($d1[0], $d1[1], $d1[2], 'Asia/Bangkok');
                        $date2 = Carbon::createMidnightDate($d2[0], $d2[1], $d2[2], 'Asia/Bangkok');

                        if ($date1->greaterThan($date2)) {

                            if ($customer->customer_type_id == 30 || $customer->customer_type_id == 40) {
                                if ($data->consignment_no != null) {
                                    $imporoe = DB::select("SELECT CANCEL_FLAG FROM PTOM_IMPROVE_FINES WHERE INVOICE_NUMBER = '" . $data->consignment_no . "' AND CREDIT_GROUP_CODE = '" . $data->credit_group_code . "' AND CANCEL_FLAG = 'Y'");
                                } else {
                                    $imporoe = null;
                                }
                            } else {
                                if ($data->pick_release_no != null) {
                                    $imporoe = DB::select("SELECT CANCEL_FLAG FROM PTOM_IMPROVE_FINES WHERE INVOICE_NUMBER = '" . $data->pick_release_no . "' AND CREDIT_GROUP_CODE = '" . $data->credit_group_code . "' AND CANCEL_FLAG = 'Y'");
                                } else {
                                    $imporoe = null;
                                }
                            }

                            if (!empty($imporoe)) {
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
                        // } else {
                        //     $paymentduedate = Carbon::parse($data->due_date)->format('Y-m-d');
                        //     $pdd = FormatDate::DateThaiNumericWithSplash($paymentduedate);
                        //     $payfines = '0.00';
                        // }
                    }
                }

                if ($customer->customer_type_id == 30 && $data->product_type_code == 10) {
                    if ($data->consignment_no == null || $data->consignment_no == '') {
                        $payfines = '0.00';
                    }
                } else {
                    if ($data->pick_release_no == null || $data->pick_release_no == '') {
                        $payfines = '0.00';
                    }
                }

                // if ($flag_show) {
                // if ($amount_balance_total > 0) {
                if ($data->credit_group_code == 0) {
                    $cndn = DB::select("SELECT INVOICE_AMOUNT, INVOICE_HEADER_ID FROM PTOM_PAYMENT_APPLY_CNDN WHERE ATTRIBUTE1 = 'N' AND PICK_RELEASE_NO = '" . $data->pick_release_no . "' AND ORDER_HEADER_ID = '" . $data->order_header_id . "' AND (CREDIT_GROUP_CODE = '" . $data->credit_group_code . "' OR CREDIT_GROUP_CODE IS NOT NULL)");
                } else {
                    $cndn = DB::select("SELECT INVOICE_AMOUNT, INVOICE_HEADER_ID FROM PTOM_PAYMENT_APPLY_CNDN WHERE ATTRIBUTE1 = 'N' AND PICK_RELEASE_NO = '" . $data->pick_release_no . "' AND ORDER_HEADER_ID = '" . $data->order_header_id . "' AND CREDIT_GROUP_CODE = '" . $data->credit_group_code . "'");
                }

                // if (empty($cndn)) {
                    $amount_balance_totals = $amount_balance_total;
                // } else {
                    // $amount_balance_totals = $amount_balance_total - $cndn[0]->invoice_amount;
                // }

                if ($paymentduedate <= $payment_date) {
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
                $html .= "<td><div class=\"input-icon\">";
                if ($customer->customer_type_id == 40) {
                    $html .= "<input type=\"text\" readonly class=\"form-control text-center f13\" name=\"doc_id[]\" placeholder=\"\" value=\"" . $data->prepare_order_number . "\" autocomplete=\"off\">";
                } else if ($customer->customer_type_id == 30 && $data->product_type_code == 10) {
                    $html .= "<input type=\"text\" readonly class=\"form-control text-center f13\" name=\"doc_id[]\" placeholder=\"\" value=\"\" autocomplete=\"off\">";
                } else {
                    $html .= "<input type=\"text\" class=\"form-control text-center f13\" name=\"doc_id[]\" placeholder=\"\" value=\"" . $data->prepare_order_number . "\" autocomplete=\"off\">";
                }
                $html .= "<i class=\"fa fa-search\"></i></div></td>";

                if ($customer->customer_type_id == 30 && $data->product_type_code == 10) {
                    // $pick_release_no_consignment = ConsignmentHeader::where('order_header_id', $data->order_header_id)->first();
                    $html .= "<td>" . $data->consignment_no . "<input type=\"hidden\" name=\"pick_no[]\" value=\"" . $data->consignment_no . "\"></td>";
                } else {
                    if ($data->pick_release_no == null || $data->pick_release_no == '') {
                        $html .= "<td><input type=\"hidden\" class=\"form-control text-center f13\" name=\"pick_no[]\" placeholder=\"\" value=\"\" autocomplete=\"off\"></td>";
                    } else {
                        if ($data->pick_release_status == 'Cancel' || $data->pick_release_status == 'Cancelled') {
                            $html .= "<td><input type=\"hidden\" class=\"form-control text-center f13\" name=\"pick_no[]\" placeholder=\"\" value=\"\" autocomplete=\"off\"></td>";
                        } else {
                            $html .= "<td>" . $data->pick_release_no . "<input type=\"hidden\" name=\"pick_no[]\" value=\"" . $data->pick_release_no . "\"></td>";
                        }
                    }
                }

                if ($customer->customer_type_id == 30 && $data->product_type_code == 10) {
                    $abt = DB::select("SELECT DEBT_AMOUNT FROM PTOM_DEBT_DOM_V WHERE CONSIGNMENT_NO = '" . $data->consignment_no . "' AND CREDIT_GROUP_CODE = '" . $data->credit_group_code . "' AND ROWNUM = 1");
                } else {
                    $abt = DB::select("SELECT DEBT_AMOUNT FROM PTOM_DEBT_DOM_V WHERE ORDER_HEADER_ID = '" . $data->order_header_id . "' AND CREDIT_GROUP_CODE = '" . $data->credit_group_code . "' AND ROWNUM = 1");
                }

                $html .= "<td>" . $data->description . "<input type=\"hidden\" name=\"type_product[]\" value=\"" . $data->description . "\"></td>";
                // $html .= "<td class=\"text-right\">" . number_format($amount_balance_total, 2) . "<input type=\"hidden\" name=\"amount_vat[]\" value=\"" . $amount_balance_total . "\"></td>";
                if($customer->customer_type_id == 30 && $data->product_type_code == 10){
                    $deptDomV = \DB::table('ptom_debt_dom_v')->where('consignment_no', $data->consignment_no)->first();
                    $html .= "<td class=\"text-right\">" . number_format($deptDomV->debt_amount, 2) . "<input type=\"hidden\" name=\"amount_vat[]\" value=\"". $deptDomV->debt_amount ."\"></td>";
                } else {
                    if (empty($abt)) {
                        $html .= "<td class=\"text-right\"><input type=\"hidden\" name=\"amount_vat[]\" value=\"\"></td>";
                    } else {
                        $html .= "<td class=\"text-right\">" . number_format($abt[0]->debt_amount, 2) . "<input type=\"hidden\" name=\"amount_vat[]\" value=\"" . $abt[0]->debt_amount . "\"></td>";
                    }
                }
                

                if ($customer->customer_type_id == 30 && $data->product_type_code == 10) {
                    // $consignment_date_consignment = ConsignmentHeader::where('order_header_id', $data->order_header_id)->first();
                    $html .= "<td>" . FormatDate::DateThaiNumericWithSplash(date_format(date_create($data->consignment_date), 'Y-m-d')) . "<input type=\"hidden\" name=\"invoice_date[]\" value=\"" . date_format(date_create($data->consignment_date), 'd/m/Y') . "\"></td>";
                } else {
                    $delivery_date = OrderHeader::find($data->order_header_id);
                    $html .= "<td>" . FormatDate::DateThaiNumericWithSplash(date_format(date_create($delivery_date->delivery_date), 'Y-m-d')) . "<input type=\"hidden\" name=\"invoice_date[]\" value=\"" . date_format(date_create($delivery_date->delivery_date), 'd/m/Y') . "\"></td>";
                }

                $html .= "<td>" . $pdd . "<input type=\"hidden\" name=\"invoice_duedate[]\" value=\"" . $paymentduedate . "\"></td>";
                $html .= "<td>" . $gCode . "<input type=\"hidden\" name=\"credit_group[]\" value=\"" . $data->credit_group_code . "\"></td>";
                $html .= "<td>" . $dataday . "<input type=\"hidden\" name=\"credit_day[]\" value=\"" . $dataday . "\"></td>";
                $html .= "<td class=\"text-right\">" . $payfines . "<input type=\"hidden\" name=\"amount_fines[]\" value=\"" . $payfines . "\"></td>";

                // แก้ไข Nuk ซ่อนการแสดงผล
                if (empty($cndn)) {
                    $html .= "<td style='display:none'><div class=\"input-icon\"><input type=\"text\" class=\"form-control red text-center f13\" name=\"paymatch[]\" placeholder=\"\" value=\"\" onkeyup=\"summatchnew();\" onchange=\"summatchnew();\" onkeypress=\"return false;\" readonly>";
                    $html .= "<i class=\"fa fa-search\" data-toggle=\"modal\" data-target=\"#matchCreditModal\" data-whatever=\"" . $number_key . "\" data-headers=\"F\"></i></div>";
                } else {
                    $html .= "<td style='display:none'><div class=\"input-icon\"><input type=\"text\" class=\"form-control red text-center f13\" name=\"paymatch[]\" placeholder=\"\" value=\"" . number_format($cndn[0]->invoice_amount, 2) . "\" onkeyup=\"summatchnew();\" onchange=\"summatchnew();\" onkeypress=\"return false;\" readonly>";
                    $html .= "<i class=\"fa fa-search\" data-toggle=\"modal\" data-target=\"#matchCreditModal\" data-whatever=\"" . $number_key . "\" data-headers=\"" . $cndn[0]->invoice_header_id . "\"></i></div>";
                }

                if (empty($cndn)) {
                    $html .= "<input type=\"hidden\" name=\"amount_match[]\" value=\"\"></td>";
                } else {
                    $html .= "<input type=\"hidden\" name=\"amount_match[]\" value=\"" . number_format($cndn[0]->invoice_amount, 2) . "\"></td>";
                }

                $html .= "<td class=\"text-right\">" . number_format($amount_balance_totals, 2) . "<input type=\"hidden\" name=\"amount_balance[]\" value=\"" . $amount_balance_totals . "\"></td>";
                $html .= "<td><input type=\"text\" class=\"form-control text-right f13\" name=\"balancetotal[]\" placeholder=\"\" value=\"" . number_format($amount_balance_totals, 2) . "\" onchange=\"inputbyseft(this,this.value);\" oninput=\"validity.valid||(value=\'\');\" onkeyup=\"numericonlys(this,this.value);\">";
                $html .= "<input type=\"hidden\" name=\"amount_balancetotal[]\" value=\"" . $amount_balance_totals . "\"></td><td>" . $checkbox . "</td>";
                if (empty($cndn)) {
                    $html .= "<input type=\"hidden\" name=\"matchid[]\" value=\"\"></tr>";
                } else {
                    $html .= "<input type=\"hidden\" name=\"matchid[]\" value=\"[" . $cndn[0]->invoice_header_id . "]\"></tr>";
                }
                // $html .= "<td class=\"text-center\"><a class=\"fa fa-times red\" href=\"javascript:void(0);\" onclick=\"deleteRow(this,'matchpayment');\"></a></td><input type=\"hidden\" name=\"matchid[]\" value=\"\"></tr>";

                $number_key++;
                // }
                // }
            }
        }

        $sqldn = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT
        FROM PTOM_INVOICE_HEADERS
        WHERE PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.PROGRAM_CODE = 'OMP0032' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN'
        AND PTOM_INVOICE_HEADERS.DELETED_AT IS NULL AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NOT NULL AND PTOM_INVOICE_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "'");
        if (!empty($sqldn)) {
            foreach ($sqldn as $dn) {
                $paymentmatchinvoicedn = PaymentMatchInvoice::where('invoice_id', $dn->invoice_headers_id)->where('invoice_number', $dn->invoice_headers_number)->where('match_flag', 'Y')->sum('payment_amount');
                if ($paymentmatchinvoicedn < $dn->invoice_amount) {
                    $dmamount = $dn->invoice_amount - $paymentmatchinvoicedn;
                    $checkbox = "<input type=\"checkbox\" value=\"" . $dn->invoice_headers_id . ":INVOICE:" . $number_key . "\" name=\"match_check[]\" onclick=\"summatch();\">";

                    $html .= "<tr class=\"align-middle jsonloop\" id=\"" . $number_key . "\">";
                    $html .= "<td><div class=\"input-icon\">";
                    $html .= "<input type=\"text\" class=\"form-control text-center f13\" name=\"doc_id[]\" placeholder=\"\" value=\"" . $dn->invoice_headers_number . "\" autocomplete=\"off\">";
                    $html .= "<i class=\"fa fa-search\"></i></div></td>";
                    $html .= "<td><input type=\"hidden\" name=\"pick_no[]\" value=\"\"></td>";
                    $html .= "<td><input type=\"hidden\" name=\"type_product[]\" value=\"\"></td>";
                    $html .= "<td class=\"text-right\">" . number_format($dmamount, 2) . "<input type=\"hidden\" name=\"amount_vat[]\" value=\"" . $dmamount . "\"></td>";
                    $html .= "<td>" . FormatDate::DateThaiNumericWithSplash(date_format(date_create($dn->invoice_date), 'Y-m-d')) . "<input type=\"hidden\" name=\"invoice_date[]\" value=\"" . date_format(date_create($dn->invoice_date), 'd/m/Y') . "\"></td>";
                    $html .= "<td><input type=\"hidden\" name=\"invoice_duedate[]\" value=\"\"></td>";
                    $html .= "<td><input type=\"hidden\" name=\"credit_group[]\" value=\"\"></td>";
                    $html .= "<td><input type=\"hidden\" name=\"credit_day[]\" value=\"\"></td>";
                    $html .= "<td class=\"text-right\"><input type=\"hidden\" name=\"amount_fines[]\" value=\"\"></td>";

                    $html .= "<td class='d-none'><div class=\"input-icon\"><input type=\"text\" class=\"form-control red text-center f13\" name=\"paymatch[]\" placeholder=\"\" value=\"\" onkeyup=\"summatchnew();\" onchange=\"summatchnew();\" onkeypress=\"return false;\" readonly>";
                    $html .= "<i class=\"fa fa-search\" data-toggle=\"modal\" data-target=\"#matchCreditModal\" data-whatever=\"" . $number_key . "\" data-headers=\"F\"></i></div>";

                    $html .= "<input type=\"hidden\" name=\"amount_match[]\" value=\"\"></td>";
                    $html .= "<td class=\"text-right\">" . number_format($dmamount, 2) . "<input type=\"hidden\" name=\"amount_balance[]\" value=\"" . $dmamount . "\"></td>";
                    $html .= "<td><input type=\"text\" class=\"form-control text-right f13\" name=\"balancetotal[]\" placeholder=\"\" value=\"" . number_format($dmamount, 2) . "\" onchange=\"inputbyseft(this,this.value);\" oninput=\"validity.valid||(value=\'\');\" onkeyup=\"numericonlys(this,this.value);\">";
                    $html .= "<input type=\"hidden\" name=\"amount_balancetotal[]\" value=\"" . $dmamount . "\"></td><td>" . $checkbox . "</td>";
                    $html .= "<input type=\"hidden\" name=\"matchid[]\" value=\"\"></tr>";

                    $number_key++;
                }
            }
        }

        if ($total_amounts < $sum_duedate) {
            $popup = false;
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

        // $paymentTotal = PaymentHeader::where('customer_id', $customer->customer_id)->where('payment_status', 'Confirm')->sum('total_remain_amount');
        // $sumPayment = $paymentTotal + $paymentInvoice;

        // $abs = number_format($sumPayment, 2);

        return response()->json(['status' => 'success', 'msg' => '', 'data' => json_decode(json_encode($html)), 'cn' => json_decode(json_encode($defineCN)), 'popup' => $popup, 'popupmsg' => $popupmsg]);
    }

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
        DB::query("DECLARE
                    V_ORGANIZATION_ID       NUMBER          :=  NULL;
                    BEGIN
                        BEGIN 
                            SELECT  ORGANIZATION_ID
                            INTO    V_ORGANIZATION_ID
                            FROM    HR_OPERATING_UNITS
                            WHERE   SHORT_CODE = 'TOAT';
                        END;
                        mo_global.set_policy_context('S', V_ORGANIZATION_ID);
                    END;");
        $ap = DB::table('PTOM_AR_RECEIPTS_V')->where('receipt_number', 'LIKE', request()->number_payment.'%')->first();

        if($ap == null) {
            PaymentMatchInvoice::where('payment_header_id', $payment->payment_header_id)->delete();
        }
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
    
    /**
     * matchsave
     *
     * @param  mixed $request
     * @return void
     */
    public function matchsave(Request $request)
    {
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
            ], [
                'payment_number.required' => 'ข้อมูลไม่ถูกต้อง',
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
            foreach($request->payment_detail_id as $key => $item) {
                $line = PaymentLines::find($item);
                $this->callApp();
                $arReceiptsV = DB::table('PTOM_AR_RECEIPTS_V')->where('receipt_number', "LIKE", $request->payment_number."%")->get();
                if($line && count($arReceiptsV) == 0) {
                    if(!empty($request->number_payment[$key]) && !empty($request->bank_code[$key]) && !empty($request->payment_desc_number_bank[$key])){
                        $line->payment_no = $request->number_payment[$key];
                        $line->bank_number = $request->bank_code[$key];
                        $line->bank_desc = $request->payment_desc_number_bank[$key];
                        $line->save();
                    }
                }
            }

            $user_id = getDefaultData('/users')->user_id;
            if ($request->match_check) {
                $ch_sum_count = count($request->match_check);
                foreach ($request->match_check as $k => $value_match) {
                    $data_expld = explode(':', $value_match);
                    $usersamo = DB::table('ptom_customers')->select('customer_type_id')->where('customer_id', $payment->customer_id)->first();
                    if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                        $invod = DB::table('ptom_invoice_headers')->select('customer_id', 'invoice_headers_id', 'invoice_headers_number', 'invoice_type', 'invoice_status', 'program_code')->where('invoice_headers_id', '=', $data_expld[0])->first();
                        $usersamo = DB::table('ptom_customers')->select('customer_type_id')->where('customer_id', $invod->customer_id)->first();
                    } else {
                        if ($usersamo->customer_type_id == '30') {
                            $invoce = ConsignmentHeader::where('consignment_no', $request->pick_no[$data_expld[2]])->first();
                        } else {
                            $invoce = DB::table('ptom_order_headers')->select('pick_release_id', 'prepare_order_number', 'customer_id', 'payment_type_code', 'currency', 'pick_release_approve_flag', 'product_type_code', 'order_status', 'pick_release_no')->where('order_header_id', '=', $data_expld[0])->first();
                        }
                    }

                    if (!empty($usersamo) && ($usersamo->customer_type_id == '30' || $usersamo->customer_type_id == '40')) {
                        //สโมสรและภูมิภาค
                        if ($data_expld[1] == 'DRAFT') {
                            if ($invoce) {
                                if ($usersamo->customer_type_id == '30') {
                                    $i1 = $invoce->consignment_header_id;
                                    if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                        $i2 = '';
                                    } else {
                                        $i2 = $request->doc_id[$data_expld[2]];
                                    }
                                    $currency = 'THB';
                                    $payment_type_code = '';
                                } else {
                                    $currency = $invoce->currency ?? '';
                                    $payment_type_code =  $invoce->payment_type_code ?? '';
                                    if ($invoce->pick_release_approve_flag == 'Y' && $invoce->product_type_code != 10) {
                                        if ($usersamo->customer_type_id == '30') {
                                            $i1 = $invoce->consignment_header_id;
                                        } else {
                                            $i1 = $invoce->pick_release_id;
                                        }
                                    } else {
                                        if ($usersamo->customer_type_id == '30') {
                                            $i1 = $invoce->consignment_header_id;
                                        } else {
                                            if ($invoce->product_type_code = 10) {
                                                $c1 = ConsignmentHeader::where('order_header_id', $data_expld[0])->first();
                                                $i1 = $c1->consignment_header_id ?? '';
                                            } else {
                                                $i1 = $invoce->consignment_header_id;
                                            }
                                        }
                                    }

                                    if ($usersamo->customer_type_id == '30') {
                                        if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                            $i2 = '';
                                        } else {
                                            $i2 = $request->doc_id[$data_expld[2]];
                                        }
                                    } else {
                                        if ($invoce->order_status == 'Confirm' && $invoce->product_type_code != 10) {
                                            $i2 = $invoce->prepare_order_number;
                                        } else {
                                            if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                                $i2 = '';
                                            } else {
                                                $i2 = $request->doc_id[$data_expld[2]];
                                            }
                                        }
                                    }
                                    // if ($invoce->product_type_code != 10) {
                                    //     $i3 = $invoce->pick_release_no;
                                    // } else {
                                    //     $i3 = '';
                                    // }
                                }
                            } else {
                                $i1 = '';
                                if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                    $i2 = '';
                                } else {
                                    $i2 = $request->doc_id[$data_expld[2]];
                                }
                                // $i3 = '';
                            }

                            $i3 = $request->pick_no[$data_expld[2]];
                        } else {
                            if ($invod) {
                                $i1 = $invod->invoice_headers_id;
                                if ($invod->invoice_headers_number != null && $invod->invoice_type == 'DN' && $invod->invoice_status == 'Confirm' && $invod->program_code == 'OMP0032') {
                                    $documentid = PtomInvoiceHeader::where('invoice_headers_number', $invod->invoice_headers_number)->first();
                                    $r = DB::table('ptom_order_headers')->select('prepare_order_number')->where('order_header_id', '=', $documentid->document_id)->first();
                                    if (empty($r)) {
                                        if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                            $i2 = '';
                                        } else {
                                            $i2 = $request->doc_id[$data_expld[2]];
                                        }
                                    } else {
                                        $i2 = $r->prepare_order_number;
                                    }
                                } else {
                                    if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                        $i2 = '';
                                    } else {
                                        $i2 = $request->doc_id[$data_expld[2]];
                                    }
                                }
                                $i3 = $invod->invoice_headers_number;
                            } else {
                                $i1 = '';
                                if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                    $i2 = '';
                                } else {
                                    $i2 = $request->doc_id[$data_expld[2]];
                                }
                                $i3 = '';
                            }
                        }
                    } else {
                        $payment_type_code =  $invoce->payment_type_code ?? '';
                        $currency = $invoce->currency ?? '';
                        //ไม่ใช่สโมสรและภูมิภาค
                        if ($data_expld[1] == 'DRAFT') {
                            if ($invoce) {
                                if ($invoce->pick_release_approve_flag == 'Y') {
                                    $i1 = $invoce->pick_release_id;
                                } else {
                                    $i1 = '';
                                }
                                if ($invoce->order_status == 'Confirm') {
                                    $i2 = $invoce->prepare_order_number;
                                } else {
                                    $i2 = '';
                                }
                                $i3 = $invoce->pick_release_no;
                            } else {
                                $i1 = '';
                                $i2 = '';
                                $i3 = '';
                            }
                        } else {
                            if ($invod) {
                                $i1 = $invod->invoice_headers_id;
                                if ($invod->invoice_headers_number != null && $invod->invoice_type == 'DN' && $invod->invoice_status == 'Confirm' && $invod->program_code == 'OMP0032') {
                                    $documentid = PtomInvoiceHeader::where('invoice_headers_number', $invod->invoice_headers_number)->first();
                                    $r = DB::table('ptom_order_headers')->select('prepare_order_number')->where('order_header_id', '=', $documentid->document_id)->first();
                                    if (empty($r)) {
                                        $i2 = '';
                                    } else {
                                        $i2 = $r->prepare_order_number;
                                    }
                                } else {
                                    $i2 = '';
                                }
                                $i3 = $invod->invoice_headers_number;
                            } else {
                                $i1 = '';
                                $i2 = '';
                                $i3 = '';
                            }
                        }
                    }

                    $dt = $request->invoice_duedate[$data_expld[2]];

                    if ($dt == '' || $dt == null) {
                        $dtin = '';
                    } else {
                        $dtin = Carbon::parse($dt)->format('Y-m-d');
                    }

                    $linenumber = 0;
                    $details = PaymentLines::where('payment_header_id', $payment->payment_header_id)->orderBy('payment_detail_id', 'ASC')->get();
                    $paymment_amount_total = str_replace(',', '', $request->amount_balancetotal[$data_expld[2]]);

                    foreach ($details as $d) {
                        if ($paymment_amount_total > 0) {
                            $sumd = PaymentMatchInvoice::where('payment_detail_id', $d->payment_detail_id)->where('match_flag', 'Y')->sum('payment_amount');

                            if ($paymment_amount_total > $d->payment_amount && $sumd < $d->payment_amount) {
                                
                                $ids = PaymentMatchInvoice::create([
                                    'payment_header_id' => $payment->payment_header_id,
                                    'payment_detail_id' => $d->payment_detail_id,
                                    'invoice_id' => $i1,
                                    'invoice_number' => $i3,
                                    'prepare_order_number' => $i2,
                                    'credit_group_code' => $request->credit_group[$data_expld[2]],
                                    'due_day' => $request->credit_day[$data_expld[2]],
                                    'due_date' => $dtin,
                                    'payment_amount' => abs(abs($paymment_amount_total - abs($paymment_amount_total - $d->payment_amount)) -  $sumd),
                                    'match_flag' => 'Y',
                                    'payment_type_code' => $payment_type_code,
                                    'currency' => $currency,
                                    'program_code' => 'OMP0024',
                                    'created_by' => $user_id,
                                    'last_updated_by' => $user_id,
                                    'outstanding_debt' => str_replace(',', '', $request->amount_vat[$data_expld[2]])
                                ]);

                                $ccgm = CustomerContractGroupModel::where('customer_id', $payment->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                if (!empty($ccgm)) {
                                    $ramount_ccgm = $ccgm->remaining_amount;

                                    $ccgm->remaining_amount = $ramount_ccgm + abs(abs($paymment_amount_total - abs($paymment_amount_total - $d->payment_amount)) -  $sumd);
                                    $ccgm->save();
                                }

                                if ($data_expld[1] == 'DRAFT') {
                                    $ar = $request->matchid[$data_expld[2]];
                                    if ($ar != null) {
                                        $ar1 = str_replace("[", "(", $ar);
                                        $ar2 = str_replace("]", ")", $ar1);
                                        $matid = DB::select("SELECT * FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_ID IN $ar2");
                                        if (!empty($matid) && $matid != null) {
                                            foreach ($matid as $keymath => $idmath) {
                                                $linenumber++;
                                                $chck = PaymentApply::where('invoice_header_id', $idmath->invoice_headers_id)->where('attribute1', 'Y');
                                                if ($chck->count() > 0) {
                                                    $updatecndn = $chck->first();
                                                    $updatecndn->payment_match_id = $ids->payment_match_id;
                                                    $updatecndn->line_number = $linenumber;
                                                    $updatecndn->last_updated_by = $user_id;
                                                    $updatecndn->last_update_date = Carbon::now();
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
                                                        'program_code' => 'OMP0024',
                                                        'created_by' => $user_id,
                                                        'last_updated_by' => $user_id,
                                                    ]);
                                                }
                                                $ccgm2 = CustomerContractGroupModel::where('customer_id', $payment->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                                if (!empty($ccgm2)) {
                                                    $ramount_ccgm2 = $ccgm2->remaining_amount;

                                                    $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $idmath->invoice_amount);
                                                    $ccgm2->save();
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
                                            'program_code' => 'OMP0024',
                                            'created_by' => $user_id,
                                            'last_updated_by' => $user_id,
                                            'invoice_number' => $cnmatch->invoice_headers_number,
                                            'attribute1' => 'Y',
                                            'attribute2' => $cnmatch->invoice_type
                                        ]);
                                        $ccgm2 = CustomerContractGroupModel::where('customer_id', $payment->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                        if (!empty($ccgm2)) {
                                            $ramount_ccgm2 = $ccgm2->remaining_amount;

                                            $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $cnmatch->invoice_amount);
                                            $ccgm2->save();
                                        }
                                    }
                                }
                                $paymment_amount_total = $paymment_amount_total - ($d->payment_amount - $sumd);
                            } else {
                                if ($sumd < $d->payment_amount) {
                                    $amount_sum_balance = $d->payment_amount - $sumd;
                                    if ($paymment_amount_total > $amount_sum_balance) {
                                        $paymment_amount_total = $paymment_amount_total -  $amount_sum_balance;

                                        $ids = PaymentMatchInvoice::create([
                                            'payment_header_id' => $payment->payment_header_id,
                                            'payment_detail_id' => $d->payment_detail_id,
                                            'invoice_id' => $i1,
                                            'invoice_number' => $i3,
                                            'prepare_order_number' => $i2,
                                            'credit_group_code' => $request->credit_group[$data_expld[2]],
                                            'due_day' => $request->credit_day[$data_expld[2]],
                                            'due_date' => $dtin,
                                            'payment_amount' => abs($amount_sum_balance),
                                            'match_flag' => 'Y',
                                            'payment_type_code' => $invoce->payment_type_code ?? '',
                                            'currency' => $invoce->currency ?? '',
                                            'program_code' => 'OMP0024',
                                            'created_by' => $user_id,
                                            'last_updated_by' => $user_id,
                                            'outstanding_debt' => str_replace(',', '', $request->amount_vat[$data_expld[2]])
                                        ]);

                                        $ccgm = CustomerContractGroupModel::where('customer_id', $payment->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                        if (!empty($ccgm)) {
                                            $ramount_ccgm = $ccgm->remaining_amount;

                                            $ccgm->remaining_amount = $ramount_ccgm + abs($paymment_amount_total);
                                            $ccgm->save();
                                        }

                                        if ($data_expld[1] == 'DRAFT') {
                                            $ar = $request->matchid[$data_expld[2]];
                                            if ($ar != null) {
                                                $ar1 = str_replace("[", "(", $ar);
                                                $ar2 = str_replace("]", ")", $ar1);
                                                $matid = DB::select("SELECT * FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_ID IN $ar2");
                                                if (!empty($matid) && $matid != null) {
                                                    foreach ($matid as $keymath => $idmath) {
                                                        $linenumber++;
                                                        $chck = PaymentApply::where('invoice_header_id', $idmath->invoice_headers_id)->where('attribute1', 'Y');
                                                        if ($chck->count() > 0) {
                                                            $updatecndn = $chck->first();
                                                            $updatecndn->payment_match_id = $ids->payment_match_id;
                                                            $updatecndn->line_number = $linenumber;
                                                            $updatecndn->last_updated_by = $user_id;
                                                            $updatecndn->last_update_date = Carbon::now();
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
                                                                'program_code' => 'OMP0024',
                                                                'created_by' => $user_id,
                                                                'last_updated_by' => $user_id,
                                                            ]);
                                                        }
                                                        $ccgm2 = CustomerContractGroupModel::where('customer_id', $payment->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                                        if (!empty($ccgm2)) {
                                                            $ramount_ccgm2 = $ccgm2->remaining_amount;

                                                            $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $idmath->invoice_amount);
                                                            $ccgm2->save();
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
                                                    'program_code' => 'OMP0024',
                                                    'created_by' => $user_id,
                                                    'last_updated_by' => $user_id,
                                                    'invoice_number' => $cnmatch->invoice_headers_number,
                                                    'attribute1' => 'Y',
                                                    'attribute2' => $cnmatch->invoice_type
                                                ]);
                                                $ccgm2 = CustomerContractGroupModel::where('customer_id', $payment->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                                if (!empty($ccgm2)) {
                                                    $ramount_ccgm2 = $ccgm2->remaining_amount;

                                                    $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $cnmatch->invoice_amount);
                                                    $ccgm2->save();
                                                }
                                            }
                                        }
                                    } else {
                                        DB::query("DECLARE
                                                    V_ORGANIZATION_ID       NUMBER          :=  NULL;
                                                    BEGIN
                                                        BEGIN 
                                                            SELECT  ORGANIZATION_ID
                                                            INTO    V_ORGANIZATION_ID
                                                            FROM    HR_OPERATING_UNITS
                                                            WHERE   SHORT_CODE = 'TOAT';
                                                        END;
                                                        mo_global.set_policy_context('S', V_ORGANIZATION_ID);
                                                    END;");
                                        $apCheck = DB::table('PTOM_AR_RECEIPTS_V')->where('receipt_number', 'LIKE', $payment->payment_number.'%')->first();
                                        if($request->credit_group[$data_expld[2]] == 0 && $usersamo->customer_type_id != '30') {
                                            $i1 = '';
                                            $i3 = '';
                                        }
                                        $insertIds = [
                                            'payment_header_id' => $payment->payment_header_id,
                                            'payment_detail_id' => $d->payment_detail_id,
                                            'invoice_id' => $i1,
                                            'invoice_number' => $i3,
                                            'prepare_order_number' => $i2,
                                            'credit_group_code' => $request->credit_group[$data_expld[2]],
                                            'due_day' => $request->credit_day[$data_expld[2]],
                                            'due_date' => $dtin,
                                            'payment_amount' => abs($paymment_amount_total),
                                            'match_flag' => 'Y',
                                            'payment_type_code' => $invoce->payment_type_code ?? '',
                                            'currency' => $invoce->currency ?? '',
                                            'program_code' => 'OMP0024',
                                            'created_by' => $user_id,
                                            'last_updated_by' => $user_id,
                                            'outstanding_debt' => str_replace(',', '', $request->amount_vat[$data_expld[2]])
                                        ];

                                        if($apCheck == null) {
                                            $insertIds['last_update_date'] = $payment->payment_date;
                                        }
                                        $ids = PaymentMatchInvoice::create($insertIds);
                                        

                                        $ccgm = CustomerContractGroupModel::where('customer_id', $payment->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                        if (!empty($ccgm)) {
                                            $ramount_ccgm = $ccgm->remaining_amount;

                                            $ccgm->remaining_amount = $ramount_ccgm + abs($paymment_amount_total);
                                            $ccgm->save();
                                        }

                                        if ($data_expld[1] == 'DRAFT') {
                                            $ar = $request->matchid[$data_expld[2]];
                                            if ($ar != null) {
                                                $ar1 = str_replace("[", "(", $ar);
                                                $ar2 = str_replace("]", ")", $ar1);
                                                $matid = DB::select("SELECT * FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_ID IN $ar2");
                                                if (!empty($matid) && $matid != null) {
                                                    foreach ($matid as $keymath => $idmath) {
                                                        $linenumber++;
                                                        $chck = PaymentApply::where('invoice_header_id', $idmath->invoice_headers_id)->where('attribute1', 'Y');
                                                        if ($chck->count() > 0) {
                                                            $updatecndn = $chck->first();
                                                            $updatecndn->payment_match_id = $ids->payment_match_id;
                                                            $updatecndn->line_number = $linenumber;
                                                            $updatecndn->last_updated_by = $user_id;
                                                            $updatecndn->last_update_date = Carbon::now();
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
                                                                'program_code' => 'OMP0024',
                                                                'created_by' => $user_id,
                                                                'last_updated_by' => $user_id,
                                                            ]);
                                                        }
                                                        $ccgm2 = CustomerContractGroupModel::where('customer_id', $payment->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                                        if (!empty($ccgm2)) {
                                                            $ramount_ccgm2 = $ccgm2->remaining_amount;

                                                            $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $idmath->invoice_amount);
                                                            $ccgm2->save();
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
                                                    'program_code' => 'OMP0024',
                                                    'created_by' => $user_id,
                                                    'last_updated_by' => $user_id,
                                                    'invoice_number' => $cnmatch->invoice_headers_number,
                                                    'attribute1' => 'Y',
                                                    'attribute2' => $cnmatch->invoice_type
                                                ]);
                                                $ccgm2 = CustomerContractGroupModel::where('customer_id', $payment->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                                if (!empty($ccgm2)) {
                                                    $ramount_ccgm2 = $ccgm2->remaining_amount;

                                                    $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $cnmatch->invoice_amount);
                                                    $ccgm2->save();
                                                }
                                            }
                                        }
                                        $paymment_amount_total = 0;
                                    }
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

            return redirect('/om/payment-method/form?payment_number=' . $number_p)->with('success', 'บันทึกเรียบร้อยแล้ว');
        }
    }
    
    /**
     * paymentverify
     *
     * @param  mixed $request
     * @return void
     */
    public function paymentverify(Request $request)
    {
        if ($request->number_payment_status == 'Cancel') {
            $validator = Validator::make($request->all(), [
                'number_payment_customer' => 'required',
                'number_payment_status' => 'required',
            ], [
                'number_payment_customer.required' => 'ไม่พบข้อมูลลูกค้า',
                'number_payment_status.required' => 'ข้อมูลการบันทึกไม่ถูกต้อง',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'payment_method.*' => 'required',
                'number_payment.*' => 'required',
                'bank_code.*' => 'required',
                'total_payment_amount.*' => 'required',
                'number_payment_customer' => 'required',
                'number_payment_status' => 'required',
            ], [
                'payment_method.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :1',
                'number_payment.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :2',
                'bank_code.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :3',
                'total_payment_amount.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :4',
                'number_payment_customer.required' => 'ไม่พบข้อมูลลูกค้า',
                'number_payment_status.required' => 'ข้อมูลการบันทึกไม่ถูกต้อง',
            ]);
        }
        $check_match = collect($request->match_check)->map(function($i) use($request) {
            return ['invoice_id' =>explode(':',$i)[0], 'credit_group_code' => $request->credit_group[explode(':',$i)[2]]];
        });
        if(count($check_match) > 0) {
            $mathInvoice = DB::table('ptom_payment_match_invoices')->where('match_flag', 'Y')
            ->where(function($q) use ($check_match) {
                foreach($check_match as $item) {
                    $q->orWhere(function($query) use ($item){
                        $query->where('invoice_id', $item['invoice_id'])
                        ->where('credit_group_code', $item['credit_group_code'])
                        ;
                    });
                }
            })
            ->count();
            if($mathInvoice > 0 ) {
                // return response()->json(array('errors' => 'มีข้อมูลที่ match Invoice อยู่แล้ว'));
    
            }
        }
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->errors()->first()));
        }
        return response()->json(array('errors' => ''));
    }

    public function payment(Request $request)
    {
        if ($request->number_payment_status != 'Cancel') {
            $validator = Validator::make($request->all(), [
                'payment_method.*' => 'required',
                'number_payment.*' => 'required',
                'bank_code.*' => 'required',
                'total_payment_amount.*' => 'required',
                'number_payment_customer' => 'required',
                'number_payment_status' => 'required',
            ], [
                'payment_method.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :1',
                'number_payment.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :2',
                'bank_code.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :3',
                'total_payment_amount.*.required' => 'กรุณาระบุรายละเอียดการรับชำระเงิน :4',
                'number_payment_customer.required' => 'ไม่พบข้อมูลลูกค้า',
                'number_payment_status.required' => 'ข้อมูลการบันทึกไม่ถูกต้อง',
            ]);

            $requests = $request->all();
            if ($validator->fails()) {
                $requests['callback_save'] = true;

                return back()->withInput($requests)->withErrors($validator->errors()->first());
            }
        }

        if (strtoupper($request->number_payment_status) == 'DRAFT') {
            $payment = $this->darftpayment($request);
            $msg = "บันทึกเรียบร้อยแล้ว";
        } elseif (strtoupper($request->number_payment_status) == 'CONFIRM') {
            if (strtoupper($request->number_status) == 'DRAFT' && ($request->number_payment_invoice == null || $request->number_payment_invoice == '')) {
                $payment = $this->darftpayment($request);
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
            $request->session()->flashInput($request->all());
            return redirect()->back()->withErrors('บันทึกข้อมูลไม่สำเร็จหรือการเปลี่ยนแปลงล้มเหลว');
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
                    'program_code' => 'OMP0024',
                    'created_by' => $user_id,
                    'creation_date' => Carbon::now()->timezone('Asia/Bangkok'),
                    'last_updated_by' => $user_id,
                    'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'),
                ]);
            }
        }
        return redirect('/om/payment-method/form?payment_number=' . $payment['number'])->with('success', $msg);
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

        $number_payent->payment_status = 'Confirm';
        if (!$number_payent->save()) {
            return 'false';
        }
        //update status order header is "Invoice"
        $paymentMatchInvoice = PaymentMatchInvoice::where('payment_header_id', '=', $number_payent->payment_header_id)->where('match_flag', 'Y')->groupBy(['prepare_order_number'])->get([DB::raw('SUM(PAYMENT_AMOUNT) PAYMENT_AMOUNT'), 'prepare_order_number']);
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

        return array('number' => $n, 'type' => $customer->sales_classification_code, 'name' => $customer->customer_name, 'id' => $number_payent->payment_header_id);
    }

    private function concelpayment(Request $request)
    {
        $customer = DB::table('ptom_customers')->where('customer_number', '=', $request->number_payment_customer)->first();
        $number_payent = PaymentHeader::where('payment_number', '=', $request->number_payment_invoice)->first();
        if (empty($number_payent) || $number_payent == null) {
            return 'false';
        }
        $payment_header_id = $number_payent->payment_header_id;
        // $paymentMatchInvoices = PaymentMatchInvoice::where('payment_header_id', '=', $payment_header_id);
        // if ($paymentMatchInvoices->where('match_flag', 'Y')->count() > 0) {
        //     return 'false';
        // }
        $number_payent->total_remain_amount = 0;
        $number_payent->total_previous_remain_amount = 0;
        $number_payent->total_amount_with_vat = 0;
        $number_payent->total_payment_amount = 0;
        $number_payent->payment_status = 'Cancel';
        if (!$number_payent->save()) {
            return 'false';
        }

        PaymentMatchInvoice::where('payment_header_id', '=', $payment_header_id)->where('match_flag', 'Y')->update(['match_flag' => 'N']);
        //update status order header is "Confirm"
        $paymentMatchInvoice = PaymentMatchInvoice::where('payment_header_id', '=', $payment_header_id)->get();
        if (!empty($paymentMatchInvoice)) {
            foreach ($paymentMatchInvoice as $pmi) {
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

    /**
     * updateRemainingAmount
     *
     * @param  mixed $customer_id
     * @return void
     */
    public function updateRemainingAmount($customer_id) {
        $customerContracts = CustomerContractGroup::where('customer_id', $customer_id)->get();
        $remaining= (new OrderEcomController)->reCalculateRemainingAmountVal($customer_id);
        foreach($customerContracts as $ccg) {
            DB::table('ptom_customer_contract_groups')
            ->where('customer_id', $customer_id)
            ->where('credit_group_code', $ccg->credit_group_code)
            ->update(['remaining_amount' => !empty(@$remaining[$ccg->credit_group_code]) ? $remaining[$ccg->credit_group_code] :0 ]);
        }
    }
    private function darftpayment(Request $request)
    {
        // dd($request->all());
        // try {
        $customer = DB::table('ptom_customers')->where('customer_number', '=', $request->number_payment_customer)->first();
        $user_id = getDefaultData('/users')->user_id;
        //create
        $xcpbankid = explode(',', $request->number_payment_bank);
        $payment_number = autoNumberPayment('OMP0024_REC_NUM_DOM', 'payment_number');
        $ddate = parseFromDateTh($request->number_payment_date);
        $header = PaymentHeader::create([
            'payment_number' => $payment_number,
            'payment_date' => Carbon::parse($ddate . ' ' . date('H:i:s'))->format('Y-m-d H:i:s'),
            'payment_status' => $request->number_payment_status,
            'customer_id' => $customer->customer_id,
            'sales_classification_code' => $customer->sales_classification_code,
            'remark' => $request->number_payment_remart,
            'total_amount_with_vat' => str_replace(',', '', $request->totalvat_amounts),
            'total_amount_match' => str_replace(',', '', $request->match_count_amounts),
            'total_fine' => str_replace(',', '', $request->paycount_amounts),
            'total_payment_amount' => str_replace(',', '', $request->total_amounts),
            'total_previous_remain_amount' => str_replace(',', '', $request->bbalance_amounts),
            'total_remain_amount' => str_replace(',', '', $request->balance_amounts),
            'program_code' => 'OMP0024',
            'created_by' => $user_id,
            'last_updated_by' => $user_id,
        ]);
        if ($header) {
            foreach ($request->payment_method as $key => $value_payment_method) {
            // dd($request->number_payment);
                $exp = explode(',', $value_payment_method);
                PaymentLines::create([
                    'payment_header_id' => $header->payment_header_id,
                    'line_number' => $key + 1,
                    'payment_method_code' => $exp[0],
                    'payment_no' => $request->number_payment[$key] == 'undefined' ? '' : $request->number_payment[$key],
                    'bank_number' => $request->bank_code[$key] == 'undefined' ? '' : $request->bank_code[$key],
                    'bank_desc' => $request->payment_desc_number_bank[$key],
                    'payment_amount' => str_replace(',', '', $request->total_payment_amount[$key]),
                    'currency' => $customer->currency,
                    'program_code' => 'OMP0024',
                    'created_by' => $user_id,
                    'last_updated_by' => $user_id,
                ]);
            }

            // update header_id file_upload
            if ($request->files_uploadsId && $request->files_uploadsId != '') {
                $attachmentIDs = explode(",", $request->files_uploadsId);
                foreach ($attachmentIDs as $value) {
                    $AttachFile = AttachFiles::where('attachment_id', $value)->first();
                    if ($AttachFile) {
                        $AttachFile->header_id = $header->payment_header_id;
                        $AttachFile->save();
                    }
                }
            }
            // update header_id file_upload

            if ($request->match_check) {
                $ch_sum_count = count($request->match_check);
                foreach ($request->match_check as $k => $value_match) {
                    $data_expld = explode(':', $value_match);
                    $usersamo = DB::table('ptom_customers')->select('customer_type_id')->where('customer_id', $customer->customer_id)->first();
                    if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                        $invod = DB::table('ptom_invoice_headers')->select('customer_id', 'invoice_headers_id', 'invoice_headers_number', 'invoice_type', 'invoice_status', 'program_code')->where('invoice_headers_id', '=', $data_expld[0])->first();
                        $usersamo = DB::table('ptom_customers')->select('customer_type_id')->where('customer_id', $invod->customer_id)->first();
                    } else {
                        if ($usersamo->customer_type_id == '30') {
                            $invoce = ConsignmentHeader::where('consignment_no', $request->pick_no[$data_expld[2]])->first();
                        } else {
                            $invoce = DB::table('ptom_order_headers')->select('pick_release_id', 'prepare_order_number', 'customer_id', 'payment_type_code', 'currency', 'pick_release_approve_flag', 'product_type_code', 'order_status', 'pick_release_no')->where('order_header_id', '=', $data_expld[0])->first();
                        }
                    }

                    if (!empty($usersamo) && ($usersamo->customer_type_id == '30' || $usersamo->customer_type_id == '40')) {
                        //สโมสรและภูมิภาค
                        if ($data_expld[1] == 'DRAFT') {
                            if ($invoce) {
                                if ($usersamo->customer_type_id == '30') {
                                    $i1 = $invoce->consignment_header_id;
                                    if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                        $i2 = '';
                                    } else {
                                        $i2 = $request->doc_id[$data_expld[2]];
                                    }
                                    $currency = 'THB';
                                    $payment_type_code = '';
                                } else {
                                    $currency = $invoce->currency ?? '';
                                    $payment_type_code =  $invoce->payment_type_code ?? '';
                                    if ($invoce->pick_release_approve_flag == 'Y' && $invoce->product_type_code != 10) {
                                        if ($usersamo->customer_type_id == '30') {
                                            $i1 = $invoce->consignment_header_id;
                                        } else {
                                            $i1 = $invoce->pick_release_id;
                                        }
                                    } else {
                                        if ($usersamo->customer_type_id == '30') {
                                            $i1 = $invoce->consignment_header_id;
                                        } else {
                                            if ($invoce->product_type_code = 10) {
                                                $c1 = ConsignmentHeader::where('order_header_id', $data_expld[0])->first();
                                                $i1 = $c1->consignment_header_id ?? '';
                                            } else {
                                                $i1 = $invoce->consignment_header_id;
                                            }
                                        }
                                    }

                                    if ($usersamo->customer_type_id == '30') {
                                        if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                            $i2 = '';
                                        } else {
                                            $i2 = $request->doc_id[$data_expld[2]];
                                        }
                                    } else {
                                        if ($invoce->order_status == 'Confirm' && $invoce->product_type_code != 10) {
                                            $i2 = $invoce->prepare_order_number;
                                        } else {
                                            if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                                $i2 = '';
                                            } else {
                                                $i2 = $request->doc_id[$data_expld[2]];
                                            }
                                        }
                                    }
                                    // if ($invoce->product_type_code != 10) {
                                    //     $i3 = $invoce->pick_release_no;
                                    // } else {
                                    //     $i3 = '';
                                    // }
                                }
                            } else {
                                $i1 = '';
                                if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                    $i2 = '';
                                } else {
                                    $i2 = $request->doc_id[$data_expld[2]];
                                }
                                // $i3 = '';
                            }

                            $i3 = $request->pick_no[$data_expld[2]];
                        } else {
                            if ($invod) {
                                $i1 = $invod->invoice_headers_id;
                                if ($invod->invoice_headers_number != null && $invod->invoice_type == 'DN' && $invod->invoice_status == 'Confirm' && $invod->program_code == 'OMP0032') {
                                    $documentid = PtomInvoiceHeader::where('invoice_headers_number', $invod->invoice_headers_number)->first();
                                    $r = DB::table('ptom_order_headers')->select('prepare_order_number')->where('order_header_id', '=', $documentid->document_id)->first();
                                    if (empty($r)) {
                                        if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                            $i2 = '';
                                        } else {
                                            $i2 = $request->doc_id[$data_expld[2]];
                                        }
                                    } else {
                                        $i2 = $r->prepare_order_number;
                                    }
                                } else {
                                    if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                        $i2 = '';
                                    } else {
                                        $i2 = $request->doc_id[$data_expld[2]];
                                    }
                                }
                                $i3 = $invod->invoice_headers_number;
                            } else {
                                $i1 = '';
                                if (strpos($request->doc_id[$data_expld[2]], 'DN') !== false) {
                                    $i2 = '';
                                } else {
                                    $i2 = $request->doc_id[$data_expld[2]];
                                }
                                $i3 = '';
                            }
                        }
                    } else {
                        $payment_type_code =  $invoce->payment_type_code ?? '';
                        $currency = $invoce->currency ?? '';
                        //ไม่ใช่สโมสรและภูมิภาค
                        if ($data_expld[1] == 'DRAFT') {
                            if ($invoce) {
                                if ($invoce->pick_release_approve_flag == 'Y') {
                                    $i1 = $invoce->pick_release_id;
                                } else {
                                    $i1 = '';
                                }
                                if ($invoce->order_status == 'Confirm') {
                                    $i2 = $invoce->prepare_order_number;
                                } else {
                                    $i2 = '';
                                }
                                $i3 = $request->pick_no[$data_expld[2]];
                            } else {
                                $i1 = '';
                                $i2 = '';
                                $i3 = '';
                            }
                        } else {
                            if ($invod) {
                                $i1 = $invod->invoice_headers_id;
                                if ($invod->invoice_headers_number != null && $invod->invoice_type == 'DN' && $invod->invoice_status == 'Confirm' && $invod->program_code == 'OMP0032') {
                                    $documentid = PtomInvoiceHeader::where('invoice_headers_number', $invod->invoice_headers_number)->first();
                                    $r = DB::table('ptom_order_headers')->select('prepare_order_number')->where('order_header_id', '=', $documentid->document_id)->first();
                                    if (empty($r)) {
                                        $i2 = '';
                                    } else {
                                        $i2 = $r->prepare_order_number;
                                    }
                                } else {
                                    $i2 = '';
                                }
                                $i3 = $invod->invoice_headers_number;
                            } else {
                                $i1 = '';
                                $i2 = '';
                                $i3 = '';
                            }
                        }
                    }

                    $i3 = $request->pick_no[$data_expld[2]];
                    $dt = $request->invoice_duedate[$data_expld[2]];

                    if ($dt == '' || $dt == null) {
                        $dtin = '';
                    } else {
                        $dtin = Carbon::parse($dt)->format('Y-m-d');
                    }

                    $linenumber = 0;
                    $details = PaymentLines::where('payment_header_id', $header->payment_header_id)->orderBy('payment_detail_id', 'ASC')->get();
                    $paymment_amount_total = str_replace(',', '', $request->amount_balancetotal[$data_expld[2]]);

                    foreach ($details as $d) {
                        if ($paymment_amount_total > 0) {
                            $sumd = PaymentMatchInvoice::where('payment_detail_id', $d->payment_detail_id)->where('match_flag', 'Y')->sum('payment_amount');

                            if ($paymment_amount_total > $d->payment_amount && $sumd < $d->payment_amount) {
                                $ids = PaymentMatchInvoice::create([
                                    'payment_header_id' => $header->payment_header_id,
                                    'payment_detail_id' => $d->payment_detail_id,
                                    'invoice_id' => $i1,
                                    'invoice_number' => $i3,
                                    'prepare_order_number' => $i2,
                                    'credit_group_code' => $request->credit_group[$data_expld[2]],
                                    'due_day' => $request->credit_day[$data_expld[2]],
                                    'due_date' => $dtin,
                                    'payment_amount' => abs(abs($paymment_amount_total - abs($paymment_amount_total - $d->payment_amount)) -  $sumd),
                                    'match_flag' => 'Y',
                                    'payment_type_code' => $payment_type_code,
                                    'currency' => $currency,
                                    'program_code' => 'OMP0024',
                                    'created_by' => $user_id,
                                    'last_updated_by' => $user_id,
                                    'outstanding_debt' => str_replace(',', '', $request->amount_vat[$data_expld[2]]),
                                    'last_update_date' => Carbon::parse($ddate .' '.date('H:i:s'))->format('Y-m-d H:i:s'),
                                ]);

                                $ccgm = CustomerContractGroupModel::where('customer_id', $customer->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                if (!empty($ccgm)) {
                                    $ramount_ccgm = $ccgm->remaining_amount;

                                    $ccgm->remaining_amount = $ramount_ccgm + abs(abs($paymment_amount_total - abs($paymment_amount_total - $d->payment_amount)) -  $sumd);
                                    $ccgm->save();
                                }

                                if ($data_expld[1] == 'DRAFT') {
                                    $ar = $request->matchid[$data_expld[2]];
                                    if ($ar != null) {
                                        $ar1 = str_replace("[", "(", $ar);
                                        $ar2 = str_replace("]", ")", $ar1);
                                        $matid = DB::select("SELECT * FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_ID IN $ar2");
                                        if (!empty($matid) && $matid != null) {
                                            foreach ($matid as $keymath => $idmath) {
                                                $linenumber++;
                                                $chck = PaymentApply::where('invoice_header_id', $idmath->invoice_headers_id)->where('attribute1', 'Y');
                                                if ($chck->count() > 0) {
                                                    $updatecndn = $chck->first();
                                                    $updatecndn->payment_match_id = $ids->payment_match_id;
                                                    $updatecndn->line_number = $linenumber;
                                                    $updatecndn->last_updated_by = $user_id;
                                                    $updatecndn->last_update_date = Carbon::now();
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
                                                        'program_code' => 'OMP0024',
                                                        'created_by' => $user_id,
                                                        'last_updated_by' => $user_id,
                                                    ]);
                                                }
                                                $ccgm2 = CustomerContractGroupModel::where('customer_id', $customer->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                                if (!empty($ccgm2)) {
                                                    $ramount_ccgm2 = $ccgm2->remaining_amount;

                                                    $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $idmath->invoice_amount);
                                                    $ccgm2->save();
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
                                            'program_code' => 'OMP0024',
                                            'created_by' => $user_id,
                                            'last_updated_by' => $user_id,
                                            'invoice_number' => $cnmatch->invoice_headers_number,
                                            'attribute1' => 'Y',
                                            'attribute2' => $cnmatch->invoice_type
                                        ]);
                                        $ccgm2 = CustomerContractGroupModel::where('customer_id', $customer->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                        if (!empty($ccgm2)) {
                                            $ramount_ccgm2 = $ccgm2->remaining_amount;

                                            $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $cnmatch->invoice_amount);
                                            $ccgm2->save();
                                        }
                                    }
                                }
                                $paymment_amount_total = $paymment_amount_total - ($d->payment_amount - $sumd);
                            } else {
                                if ($sumd < $d->payment_amount) {
                                    $amount_sum_balance = $d->payment_amount - $sumd;
                                    if ($paymment_amount_total > $amount_sum_balance) {
                                        $paymment_amount_total = $paymment_amount_total -  $amount_sum_balance;

                                        $ids = PaymentMatchInvoice::create([
                                            'payment_header_id' => $header->payment_header_id,
                                            'payment_detail_id' => $d->payment_detail_id,
                                            'invoice_id' => $i1,
                                            'invoice_number' => $i3,
                                            'prepare_order_number' => $i2,
                                            'credit_group_code' => $request->credit_group[$data_expld[2]],
                                            'due_day' => $request->credit_day[$data_expld[2]],
                                            'due_date' => $dtin,
                                            'payment_amount' => abs($amount_sum_balance),
                                            'match_flag' => 'Y',
                                            'payment_type_code' => $invoce->payment_type_code ?? '',
                                            'currency' => $invoce->currency ?? '',
                                            'program_code' => 'OMP0024',
                                            'created_by' => $user_id,
                                            'last_updated_by' => $user_id,
                                            'outstanding_debt' => str_replace(',', '', $request->amount_vat[$data_expld[2]]),
                                            'last_update_date' => Carbon::parse($ddate .' '.date('H:i:s'))->format('Y-m-d H:i:s'),
                                        ]);

                                        $ccgm = CustomerContractGroupModel::where('customer_id', $customer->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                        if (!empty($ccgm)) {
                                            $ramount_ccgm = $ccgm->remaining_amount;

                                            $ccgm->remaining_amount = $ramount_ccgm + abs($paymment_amount_total);
                                            $ccgm->save();
                                        }

                                        if ($data_expld[1] == 'DRAFT') {
                                            $ar = $request->matchid[$data_expld[2]];
                                            if ($ar != null) {
                                                $ar1 = str_replace("[", "(", $ar);
                                                $ar2 = str_replace("]", ")", $ar1);
                                                $matid = DB::select("SELECT * FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_ID IN $ar2");
                                                if (!empty($matid) && $matid != null) {
                                                    foreach ($matid as $keymath => $idmath) {
                                                        $linenumber++;
                                                        $chck = PaymentApply::where('invoice_header_id', $idmath->invoice_headers_id)->where('attribute1', 'Y');
                                                        if ($chck->count() > 0) {
                                                            $updatecndn = $chck->first();
                                                            $updatecndn->payment_match_id = $ids->payment_match_id;
                                                            $updatecndn->line_number = $linenumber;
                                                            $updatecndn->last_updated_by = $user_id;
                                                            $updatecndn->last_update_date = Carbon::now();
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
                                                                'program_code' => 'OMP0024',
                                                                'created_by' => $user_id,
                                                                'last_updated_by' => $user_id,
                                                            ]);
                                                        }
                                                        $ccgm2 = CustomerContractGroupModel::where('customer_id', $customer->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                                        if (!empty($ccgm2)) {
                                                            $ramount_ccgm2 = $ccgm2->remaining_amount;

                                                            $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $idmath->invoice_amount);
                                                            $ccgm2->save();
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
                                                    'program_code' => 'OMP0024',
                                                    'created_by' => $user_id,
                                                    'last_updated_by' => $user_id,
                                                    'invoice_number' => $cnmatch->invoice_headers_number,
                                                    'attribute1' => 'Y',
                                                    'attribute2' => $cnmatch->invoice_type
                                                ]);
                                                $ccgm2 = CustomerContractGroupModel::where('customer_id', $customer->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                                if (!empty($ccgm2)) {
                                                    $ramount_ccgm2 = $ccgm2->remaining_amount;

                                                    $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $cnmatch->invoice_amount);
                                                    $ccgm2->save();
                                                }
                                            }
                                        }
                                    } else {
                                        $ids = PaymentMatchInvoice::create([
                                            'payment_header_id' => $header->payment_header_id,
                                            'payment_detail_id' => $d->payment_detail_id,
                                            'invoice_id' => $i1,
                                            'invoice_number' => $i3,
                                            'prepare_order_number' => $i2,
                                            'credit_group_code' => $request->credit_group[$data_expld[2]],
                                            'due_day' => $request->credit_day[$data_expld[2]],
                                            'due_date' => $dtin,
                                            'payment_amount' => abs($paymment_amount_total),
                                            'match_flag' => 'Y',
                                            'payment_type_code' => $invoce->payment_type_code ?? '',
                                            'currency' => $invoce->currency ?? '',
                                            'program_code' => 'OMP0024',
                                            'created_by' => $user_id,
                                            'last_updated_by' => $user_id,
                                            'outstanding_debt' => str_replace(',', '', $request->amount_vat[$data_expld[2]]),
                                            'last_update_date' => Carbon::parse($ddate .' '.date('H:i:s'))->format('Y-m-d H:i:s'),
                                        ]);

                                        $ccgm = CustomerContractGroupModel::where('customer_id', $customer->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                        if (!empty($ccgm)) {
                                            $ramount_ccgm = $ccgm->remaining_amount;

                                            $ccgm->remaining_amount = $ramount_ccgm + abs($paymment_amount_total);
                                            $ccgm->save();
                                        }

                                        if ($data_expld[1] == 'DRAFT') {
                                            $ar = $request->matchid[$data_expld[2]];
                                            if ($ar != null) {
                                                $ar1 = str_replace("[", "(", $ar);
                                                $ar2 = str_replace("]", ")", $ar1);
                                                $matid = DB::select("SELECT * FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_ID IN $ar2");
                                                if (!empty($matid) && $matid != null) {
                                                    foreach ($matid as $keymath => $idmath) {
                                                        $linenumber++;
                                                        $chck = PaymentApply::where('invoice_header_id', $idmath->invoice_headers_id)->where('attribute1', 'Y');
                                                        if ($chck->count() > 0) {
                                                            $updatecndn = $chck->first();
                                                            $updatecndn->payment_match_id = $ids->payment_match_id;
                                                            $updatecndn->line_number = $linenumber;
                                                            $updatecndn->last_updated_by = $user_id;
                                                            $updatecndn->last_update_date = Carbon::now();
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
                                                                'program_code' => 'OMP0024',
                                                                'created_by' => $user_id,
                                                                'last_updated_by' => $user_id,
                                                            ]);
                                                        }
                                                        $ccgm2 = CustomerContractGroupModel::where('customer_id', $customer->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                                        if (!empty($ccgm2)) {
                                                            $ramount_ccgm2 = $ccgm2->remaining_amount;

                                                            $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $idmath->invoice_amount);
                                                            $ccgm2->save();
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
                                                    'program_code' => 'OMP0024',
                                                    'created_by' => $user_id,
                                                    'last_updated_by' => $user_id,
                                                    'invoice_number' => $cnmatch->invoice_headers_number,
                                                    'attribute1' => 'Y',
                                                    'attribute2' => $cnmatch->invoice_type
                                                ]);
                                                $ccgm2 = CustomerContractGroupModel::where('customer_id', $customer->customer_id)->where('credit_group_code', $request->credit_group[$data_expld[2]])->whereNull('deleted_at')->first();
                                                if (!empty($ccgm2)) {
                                                    $ramount_ccgm2 = $ccgm2->remaining_amount;

                                                    $ccgm2->remaining_amount = $ramount_ccgm2 + str_replace(',', '', $cnmatch->invoice_amount);
                                                    $ccgm2->save();
                                                }
                                            }
                                        }
                                        $paymment_amount_total = 0;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $this->updateRemainingAmount($customer->customer_id);
            return array('id' => $header->payment_header_id, 'number' => $payment_number, 'type' => $customer->sales_classification_code, 'name' => $customer->customer_name);
        } else {
            return 'false';
        }
        // } catch (\Throwable $th) {
        //     return $th->getMessage();
        // }
    }

    public function paymentupload(Request $request)
    {
        // dd($request);
        // $payment = DB::table('ptom_payment_headers')->where('payment_number', '=', $request->number_ref)->first();
        // if (empty($payment)) {
        //     $request->session()->flashInput($request->all());
        //     return redirect()->back()->withErrors('ไม่พบข้อมูลเลขที่ใบเสร็จ');
        // }
        $responseUploadFile = array();
        $responseUploadFile['status'] = 200;
        $responseUploadFile['message'] = "";
        $responseUploadFile['attachments'] = [];
        if ($request->hasFile('attachment')) {
            $idTest = 1;
            foreach ($request->file('attachment') as $file) {
                $newfilename = date('YmdHis') . '-upload' . '.' . $file->getClientOriginalExtension();
                \DB::beginTransaction();
                $fileInfo = [];
                $program_code = 'OMP0024';
                try {
                    $attachment = $this->uploadAttachmentSingle($file, null, $program_code);
                    $fileInfo = [
                        'attachment_id' => $attachment->attachment_id,
                        // 'file_name' => $file->getClientOriginalName(),
                        'file_name' => $attachment->file_name,
                        'path_name' => getDefaultData('/users')->archive_directory,
                        'program_code' => $program_code
                    ];
                    $responseUploadFile['attachments'][] = $fileInfo;
                    $responseUploadFile['message'] = 'อัปโหลดไฟล์เรียบร้อยแล้ว';
                    $idTest++;
                    \DB::commit();
                } catch (Exception $e) {
                    \DB::rollback();
                    $name = explode('.', $newfilename);
                    \Storage::disk('local')->put(getDefaultData('/users')->log_directory . '/' . $name[0] . '.txt', 'ไม่สามารถอัปโหลดไฟล์ได้ :' . $e->getMessage());
                    $responseUploadFile['status'] = 403;
                    $responseUploadFile['message'] = 'เกิดข้อผิดพลาดระหว่างการอัปโหลดไฟล์ ' . $file->getClientOriginalName();
                }
            }
        } else {
            $responseUploadFile['status'] = 422;
            $responseUploadFile['message'] = "ไม่พบไฟล์ที่ต้องการอัปโหลด";
        }
        return $responseUploadFile;
    }

    function uploadAttachmentSingle($file, $header_id, $program_code)
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


    public function uploadAttachmentMultiple(Request $request)
    {
        $payment = DB::table('ptom_payment_headers')->where('payment_number', '=', $request->number_ref)->first();
        if (empty($payment)) {
            $request->session()->flashInput($request->all());
            return redirect()->back()->withErrors('ไม่พบข้อมูลเลขที่ใบเสร็จ');
        }

        if ($request->hasFile('attachment')) {
            $fileAttachment = $request->file('attachment');
            $response = array();
            foreach ($fileAttachment as $key => $file) {
                $newfilename = date('YmdHis') . '-upload' . '.' . $file->getClientOriginalExtension();
                $response[] = $newfilename;
                // DB::beginTransaction();
                // try {
                //     Storage::putFileAs(getDefaultData('/users')->archive_directory, $file, $file->getClientOriginalName());
                //     DB::table('ptom_attachments')->insert([
                //         'attachment_program_code' => 'OMP0024',
                //         'header_id' => $payment->payment_header_id,
                //         'file_name' => $file->getClientOriginalName(),
                //         'path_name' => getDefaultData('/users')->archive_directory,
                //         'program_code' => 'OMP0024',
                //         'created_by' => getDefaultData('/users')->user_id,
                //         'creation_date' => Carbon::now()->timezone('Asia/Bangkok'),
                //         'last_updated_by' => getDefaultData('/users')->user_id,
                //         'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'),
                //     ]);
                //     DB::commit();
                // } catch (Exception $e) {
                //     DB::rollback();
                //     $name = explode('.', $newfilename);
                //     Storage::disk('local')->put(getDefaultData('/users')->log_directory . '/' . $name[0] . '.txt', 'ไม่สามารถอัปโหลดไฟล์ได้ :' . $e->getMessage());
                //     return redirect()->back()->withError('เกิดข้อผิดพลาดระหว่างการอัปโหลดไฟล์ ' . $file->getClientOriginalName())->withInput($request->all());
                // }
            }
            return response()->json(['data' => $response, 'message' => 'File not found', 'status' => false]);
            // request()->session()->flashInput($request->all());
            return redirect()->back()->with('success', 'อัปโหลดไฟล์เรียบร้อยแล้ว');
        } else {
            return response()->json(['data' => [], 'message' => 'File not found', 'status' => false]);
        }
    }

    public function removeAttachmentFile($id = '')
    {
        $attachment = AttachFiles::where('attachment_id', '=', $id)->first();
        $now = Carbon::now();
        if (isset($attachment) && !empty($attachment)) {
            $attachment->deleted_at = $now;
            $attachment->save();
        }
    }

    public function download($id)
    {
        $attachment = AttachFiles::find($id);

        $path = public_path() . '//' . $attachment->path_name;

        if (file_exists($path)) {
            return response()->download($path);
        }
    }

    private static function concatInvoice($invoice_list){
        $invList = collect($invoice_list)->filter();

        $listInvoice = "";
        $count = 0;
        $max = 2;
        $first = $invList->first();
        $last = $invList->last();
        $prev = "";
        $check = "";
        
        foreach($invList as $list){
            if($list == $first){
                $listInvoice .= $list;
                $count++;
            }elseif($list == $last) {
                if((int)substr($list, -4) - (int)substr($prev, -4) > 1){
                    if($count > $max){
                        if($check == $prev){
                            $listInvoice .= '<br>, '.$list;
                        }else {
                            $listInvoice .= '-'.substr($prev,-3).'<br>, '.$list;
                        }
                    }else {
                        if($check == $prev){
                            $listInvoice .= ', '.$list;
                        }else {
                            $listInvoice .= '-'.substr($prev,-3).', '.$list;
                        }
                    }
                }else{
                    $listInvoice .= '-'.$list;
                }
            }else {
                if((int)substr($list, -4) - (int)substr($prev, -4) > 1){
                    if($count > $max){
                        if($check == $prev){
                            $listInvoice .= '<br>, '.$list;
                        }else {
                            $listInvoice .= '-'.substr($prev,-3).'<br>, '.$list;
                        }
                        $max = 3;
                        $count = 0;
                    }else {
                        if($check == $prev){
                            $listInvoice .= ', '.$list;
                        }else {
                            $listInvoice .= '-'.substr($prev,-3).', '.$list;
                        }
                    }
                    $check = $list;
                    $count++;
                }
            }
            $prev = $list;
        }

        //$listInvoice = $invList->count() ? ($invList->count() > 1 ? $invList->first().'-'.substr($invList->last(),-3) : $invList->first()) : "";
        return $listInvoice;
    }
}
