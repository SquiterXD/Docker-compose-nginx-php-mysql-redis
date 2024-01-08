<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OM\Api\OrderEcomController;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\DomesticMatching\CreditGroup;
use App\Models\OM\DomesticMatching\InvoiceHeaders;
use App\Models\OM\DomesticMatching\OrderHeaders;
use App\Models\OM\DomesticMatching\PaymentHeaders;
use App\Models\OM\DomesticMatching\PaymentMatchInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\OM\AttachFiles;
use App\Models\OM\ConsignmentHeader;
use App\Models\OM\ConsignmentLines;
use App\Models\OM\CreditNote\CustomerContractGroupModel;
use App\Models\OM\Customers;
use App\Models\OM\DomesticMatching\PaymentApply;
use App\Models\OM\OrderHeaders as OMOrderHeaders;
use App\Models\OM\OverdueDebt\PaymentApplyCNDN;
use App\Models\OM\PaymentHeader;
use App\Models\OM\PaymentLines;
use App\Models\OM\PaymentMatchInvoice as OMPaymentMatchInvoice;
use App\Models\OM\PtomInvoiceHeader;
use App\Models\OM\PtomOrderCreditGroup;
use FormatDate;
use Illuminate\Support\Facades\Validator;
use PDO;

class PaymentMethodMatchingController extends Controller
{
    public function index()
    {
        $number_refs = [];
        $customers = Customers::whereRaw("UPPER(sales_classification_code) = 'DOMESTIC'")->orderBy('customer_number', 'ASC')->get(['customer_type_id', 'customer_id', 'customer_number', 'customer_name', 'sales_classification_code', 'address_line1', 'address_line2', 'address_line3', 'city', 'district', 'alley', 'province_name', 'postal_code']);

        $orders = DB::select("SELECT PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,PTOM_ORDER_HEADERS.ORDER_DATE,PTOM_ORDER_HEADERS.PICK_RELEASE_NO,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_CUSTOMERS.CUSTOMER_TYPE_ID,PTOM_CUSTOMERS.CUSTOMER_ID,PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE,PTOM_ORDER_HEADERS.PICK_RELEASE_STATUS FROM PTOM_ORDER_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE (PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER IS NOT NULL OR PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL) AND UPPER(PTOM_ORDER_HEADERS.ORDER_STATUS) = 'CONFIRM' ORDER BY PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER DESC");

        $orderss = [];
        foreach ($orders as $order) {
            if (strpos($order->prepare_order_number, 'SA') !== false) {
            } else {
                if ($order->customer_type_id == '30' && $order->product_type_code == '10') {
                } else {
                    if ($order->prepare_order_number != null) {
                        $pp = ':';
                    } else {
                        $pp = '';
                    }
                    if ($order->pick_release_no != null && $order->pick_release_status != 'Cancelled') {
                        $data['text'] = $order->prepare_order_number . $pp . $order->pick_release_no . ':' . $order->customer_name;
                        $data['value'] = $order->pick_release_no;
                    } else {
                        $data['text'] = $order->prepare_order_number . ':' . $order->customer_name;
                        $data['value'] = $order->prepare_order_number;
                    }
                    $data['date'] = $order->order_date;
                    array_push($orderss, $data);
                }
            }
        }

        $consignments = [];
        foreach ($orders as $r) {
            if ($r->customer_type_id == '30' && $r->product_type_code == '10') {
                $con = ConsignmentHeader::join('ptom_order_headers', 'ptom_consignment_headers.order_header_id', 'ptom_order_headers.order_header_id', 'left')->join('ptom_customers', 'ptom_order_headers.customer_id', 'ptom_customers.customer_id', 'left')->where('ptom_consignment_headers.order_header_id', $r->order_header_id)->get();
                foreach ($con as $co) {
                    if (!empty($co)) {
                        $data['text'] = $co->consignment_no . ':' . $co->customer_name;
                        $data['date'] = $co->consignment_date;
                        $data['value'] = $co->consignment_no;

                        array_push($consignments, $data);
                    }
                }
            }
        }

        $consignmentsss = DB::select("SELECT * FROM PTOM_CONSIGNMENT_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
        WHERE PTOM_CUSTOMERS.CUSTOMER_TYPE_ID = '30' AND PTOM_CONSIGNMENT_HEADERS.ORDER_HEADER_ID IS NULL AND UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'");
        foreach ($consignmentsss as $c) {
            $ch = DB::select("SELECT * FROM PTOM_CONSIGNMENT_LINES LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID 
            WHERE PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID = '" . $c->consignment_header_id . "' AND PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = '10'");
            if (!empty($ch)) {
                if (!in_array($c->consignment_no, $consignments)) {
                    $data['text'] = $c->consignment_no . ':' . $c->customer_name;
                    $data['date'] = $c->consignment_date;
                    $data['value'] = $c->consignment_no;

                    array_push($consignments, $data);
                }
            }
        }

        $dninvoices = [];
        $sqldn = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_CUSTOMERS.CUSTOMER_NAME FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.PROGRAM_CODE = 'OMP0032' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN' AND PTOM_INVOICE_HEADERS.DELETED_AT IS NULL AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NOT NULL ORDER BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER DESC");
        foreach ($sqldn as $dn) {
            $datas['text'] = $dn->invoice_headers_number . ':' . $dn->customer_name;
            $datas['date'] = $dn->invoice_date;
            $datas['value'] = $dn->invoice_headers_number;

            array_push($dninvoices, $datas);
        }

        $number_refs = array_merge($orderss, $consignments);
        $number_refs = array_merge($number_refs, $dninvoices);

        usort($number_refs, function ($item1, $item2) {
            return $item2['date'] <=> $item1['date'];
        });

        $invoices = [];

        if (request()->all()) {
            $request = request()->all();
            if (strpos($request['number_ref'], 'DN') !== false) {
                $customer = Customer::join('ptom_order_headers', 'ptom_customers.customer_id', 'ptom_order_headers.customer_id', 'left')->join('ptom_invoice_headers', 'ptom_customers.customer_id', 'ptom_invoice_headers.customer_id', 'left')->where(function ($q) use ($request) {
                    $q->where('ptom_customers.customer_number', $request['customer_ref']);
                    $q->orWhere('ptom_order_headers.prepare_order_number', $request['number_ref']);
                    $q->orWhere('ptom_order_headers.pick_release_no', $request['number_ref']);
                    $q->orWhere('ptom_invoice_headers.invoice_headers_number', $request['number_ref']);
                })->first(['ptom_customers.customer_id']);
            } else {
                if (strpos($request['number_ref'], 'F') !== false) {
                    $customer = Customer::join('ptom_order_headers', 'ptom_customers.customer_id', 'ptom_order_headers.customer_id', 'left')->join('ptom_consignment_headers', 'ptom_order_headers.order_header_id', 'ptom_consignment_headers.order_header_id')->where(function ($q) use ($request) {
                        $q->where('ptom_consignment_headers.consignment_no', $request['number_ref']);
                    })->first(['ptom_customers.customer_id']);
                    if (empty($customer)) {
                        $customer = Customer::join('ptom_consignment_headers', 'ptom_consignment_headers.customer_id', 'ptom_consignment_headers.customer_id')->where(function ($q) use ($request) {
                            $q->where('ptom_consignment_headers.consignment_no', $request['number_ref']);
                        })->first(['ptom_customers.customer_id']);
                    }
                } else {
                    $customer = Customer::join('ptom_order_headers', 'ptom_customers.customer_id', 'ptom_order_headers.customer_id', 'left')->where(function ($q) use ($request) {
                        $q->where('ptom_customers.customer_number', $request['customer_ref']);
                        $q->orWhere('ptom_order_headers.prepare_order_number', $request['number_ref']);
                        $q->orWhere('ptom_order_headers.pick_release_no', $request['number_ref']);
                    })->first(['ptom_customers.customer_id']);
                }
            }
            if (empty($customer)) {
                request()->session()->flashInput($request);
                return back()->withErrors('ข้อมูลลูกค้าไม่ถูกต้อง');
            }

            if (strpos($request['number_ref'], 'DN') !== false) {
                $datapayment = PaymentMatchInvoice::with(['invoices', 'files' => function ($q) {
                    $q->where('attachment_program_code', '=', 'OMP0025');
                }])->where(function ($w) use ($request) {
                    $ww = PtomInvoiceHeader::where('invoice_headers_number', $request['number_ref'])->first();
                    $w->where('invoice_number', $request['number_ref']);
                    if (!empty($ww)) {
                        $w->orWhere('invoice_id', $ww->invoice_headers_id);
                    }
                })->leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', '=', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_match_invoices.match_flag', '=', 'Y')->groupBy(['ptom_payment_headers.payment_number', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD')")])->get(['ptom_payment_headers.payment_number', DB::raw("SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT"), DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD') CREATION_DATE")]);
            } else {
                if ($request['credit_ref'] == '*') {
                    $datapayment = PaymentMatchInvoice::with(['invoices', 'files' => function ($q) {
                        $q->where('attachment_program_code', '=', 'OMP0025');
                    }])->where(function ($w) use ($request) {
                        if (strpos($request['number_ref'], 'F') !== false) {
                            $w->where('ptom_payment_match_invoices.invoice_number', '=', $request['number_ref']);
                        } else {
                            $order = OrderHeaders::where('pick_release_no', $request['number_ref'])->first();
                            $w->where('ptom_payment_match_invoices.prepare_order_number', '=', $request['number_ref']);
                            if (!empty($order)) {
                                $w->orWhere('ptom_payment_match_invoices.prepare_order_number', '=', $order->prepare_order_number);
                            }
                        }
                    })->leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', '=', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_match_invoices.match_flag', '=', 'Y')->groupBy(['ptom_payment_headers.payment_number', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD')")])->get(['ptom_payment_headers.payment_number', DB::raw("SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT"), DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD') CREATION_DATE")]);
                } else {
                    $datapayment = PaymentMatchInvoice::with(['invoices', 'files' => function ($q) {
                        $q->where('attachment_program_code', '=', 'OMP0025');
                    }])->where(function ($w) use ($request) {
                        if (strpos($request['number_ref'], 'F') !== false) {
                            $order = ConsignmentHeader::where('consignment_no', $request['number_ref'])->first();
                            $orderrh = OrderHeaders::where('order_header_id', $order->order_header_id)->first();
                            $w->where('ptom_payment_match_invoices.invoice_id', '=', $order->consignment_header_id);
                            if (!empty($orderrh)) {
                                $w->orWhere('ptom_payment_match_invoices.prepare_order_number', '=', $orderrh->prepare_order_number);
                            }
                        } else {
                            $order = OrderHeaders::where('pick_release_no', $request['number_ref'])->first();
                            $w->where('ptom_payment_match_invoices.prepare_order_number', '=', $request['number_ref']);
                            if (!empty($order)) {
                                $w->orWhere('ptom_payment_match_invoices.prepare_order_number', '=', $order->prepare_order_number);
                            }
                        }
                    })->where('ptom_payment_match_invoices.credit_group_code', '=', $request['credit_ref'])->leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', '=', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_match_invoices.match_flag', '=', 'Y')->groupBy(['ptom_payment_headers.payment_number', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD')")])->get(['ptom_payment_headers.payment_number', DB::raw("SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT"), DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD') CREATION_DATE")]);
                }
            }

            request()->session()->flashInput($request);

            $payments = PaymentMatchInvoice::leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_headers.customer_id', $customer->customer_id)->where('ptom_payment_match_invoices.prepare_order_number', $request['number_ref'])->groupBy(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', 'ptom_payment_headers.payment_date', 'ptom_payment_match_invoices.currency'])->get(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', 'ptom_payment_headers.payment_date', DB::raw("SUM(ptom_payment_match_invoices.payment_amount) payment_amount"), 'ptom_payment_match_invoices.currency']);


            $invoicess = InvoiceHeaders::where('customer_id', '=', $customer->customer_id)->where('invoice_type', '=', 'DN')->get(['invoice_headers_id', 'invoice_headers_number', 'invoice_date', 'invoice_amount']);


            if (strpos($request['number_ref'], 'DN') !== false) {
                $orderw = PtomInvoiceHeader::where('invoice_headers_number', $request['number_ref'])->first();
                $order = OrderHeaders::find($orderw->document_id);
                $odr = OrderHeaders::find($orderw->document_id);
            } else {
                if (strpos($request['number_ref'], 'F') !== false) {
                    $order = ConsignmentHeader::where('consignment_no', $request['number_ref'])->first();
                    $odr = ConsignmentHeader::where('consignment_no', $request['number_ref'])->first();
                } else {
                    $order = OrderHeaders::where('pick_release_no', $request['number_ref'])->orWhere('prepare_order_number', $request['number_ref'])->first();
                    $odr = OrderHeaders::where('pick_release_no', $request['number_ref'])->orWhere('prepare_order_number', $request['number_ref'])->first();
                }
            }

            if (strpos($request['number_ref'], 'DN') !== false) {
                $paymentw = PtomInvoiceHeader::where('invoice_headers_number', $request['number_ref'])->first();
                $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND (PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID = '" . $paymentw->invoice_headers_id . "' OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . $paymentw->invoice_headers_number . "')");
            } else {
                if (strpos($request['number_ref'], 'F') !== false) {
                    if (!empty($order)) {
                        // $ooor = OrderHeaders::find($order->order_header_id);
                        if (request()->credit_ref == '*') {
                            $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND (PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . $order->consignment_no . "' OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID = '" . $order->consignment_header_id . "')");
                        } else {
                            $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND (PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . $order->consignment_no . "' OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID = '" . $order->consignment_header_id . "' AND CREDIT_GROUP_CODE = '" . request()->credit_ref . "')");
                        }
                    } else {
                        if (request()->credit_ref == '*') {
                            $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . request()->number_ref . "'");
                        } else {
                            $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . request()->number_ref . "' AND CREDIT_GROUP_CODE = '" . request()->credit_ref . "'");
                        }
                    }
                } else {
                    if (!empty($order)) {
                        if (request()->credit_ref == '*') {
                            $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER = '" . $order->prepare_order_number . "'");
                        } else {
                            $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER = '" . $order->prepare_order_number . "' AND CREDIT_GROUP_CODE = '" . request()->credit_ref . "'");
                        }
                    } else {
                        if (request()->credit_ref == '*') {
                            $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER = '" . request()->number_ref . "'");
                        } else {
                            $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER = '" . request()->number_ref . "' AND CREDIT_GROUP_CODE = '" . request()->credit_ref . "'");
                        }
                    }
                }
            }

            $p = $payment[0]->payment_amount == null ? 0 : $payment[0]->payment_amount;

            if (strpos($request['number_ref'], 'DN') !== false) {
                $cus = DB::select("SELECT CUSTOMER_ID,DOCUMENT_ID ORDER_HEADER_ID FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_NUMBER = '" . $request['number_ref'] . "'");
            } else {
                if (strpos($request['number_ref'], 'F') !== false) {
                    $cus = DB::select("SELECT PTOM_ORDER_HEADERS.CUSTOMER_ID,PTOM_CONSIGNMENT_HEADERS.ORDER_HEADER_ID FROM PTOM_CONSIGNMENT_HEADERS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_CONSIGNMENT_HEADERS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID WHERE PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO = '" . $request['number_ref'] . "'");
                    if ($cus[0]->customer_id == null || $cus[0]->order_header_id == null) {
                        $cus = DB::select("SELECT PTOM_CUSTOMERS.CUSTOMER_ID,PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID FROM PTOM_CONSIGNMENT_LINES LEFT JOIN PTOM_CONSIGNMENT_HEADERS ON PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID = PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_HEADER_ID LEFT JOIN PTOM_CUSTOMERS ON PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO = '" . $request['number_ref'] . "' AND ROWNUM = 1");
                    }
                } else {
                    $cus = DB::select("SELECT CUSTOMER_ID,ORDER_HEADER_ID FROM PTOM_ORDER_HEADERS WHERE PREPARE_ORDER_NUMBER = '" . $request['number_ref'] . "' OR PICK_RELEASE_NO = '" . $request['number_ref'] . "'");
                }
            }

            $customerinfo = Customer::find($cus[0]->customer_id);
            $order_header_id = $cus[0]->order_header_id ?? '';

            $files = AttachFiles::where('header_id', $order_header_id)->get();

            $searchomp0025 = true;

            if (strpos($request['number_ref'], 'DN') !== false) {
                $dndndn = InvoiceHeaders::where('invoice_headers_number', $request['number_ref'])->first();
                $countmatchinvoice = [];
                $ptomorder = PaymentMatchInvoice::where('invoice_number', $request['number_ref'])->get(['payment_match_id']);
                foreach ($ptomorder as $cinvoice) {
                    if (!in_array($cinvoice->payment_match_id, $countmatchinvoice)) {
                        array_push($countmatchinvoice, $cinvoice->payment_match_id);
                    }
                }
                if (count($countmatchinvoice) > 0) {
                    $cns = PaymentApplyCNDN::where(function ($q) use ($countmatchinvoice, $dndndn) {
                        $q->whereIn('payment_match_id', $countmatchinvoice);
                        $q->orWhere('pick_release_no', $dndndn->ref_invoice_number);
                    })->where('attribute1', 'Y')->get();
                } else {
                    $cns = [];
                }
            } else {
                if (strpos($request['number_ref'], 'F') !== false) {
                    if (request()->credit_ref == '*') {
                        $cns = PaymentApplyCNDN::where('pick_release_no', $request['number_ref'])->where('attribute1', 'Y')->get();
                    } else {
                        $cns = PaymentApplyCNDN::where('pick_release_no', $request['number_ref'])->where('attribute1', 'Y')->where('credit_group_code', request()->credit_ref)->get();
                    }
                } else {
                    // if ($order->pick_release_no == null) {
                    //     $cns = [];
                    // } else {
                        if (request()->credit_ref == '*') {
                            $cns = PaymentApplyCNDN::where('pick_release_no', $order->pick_release_no)->where('attribute1', 'Y')->get();
                        } else {
                            $cns = PaymentApplyCNDN::where('pick_release_no', $order->pick_release_no)->where('attribute1', 'Y')->where('credit_group_code', request()->credit_ref)->get();
                        }
                    // }
                }
            }

            if (!empty($cns)) {
                $sumcns = 0;
                foreach ($cns as $scn) {
                    $sumcns += $scn->invoice_amount;
                }

                $p = $p + $sumcns;
            }

            if (strpos($request['number_ref'], 'DN') !== false) {
                $totalAmountw = PtomInvoiceHeader::where('invoice_headers_number', $request['number_ref'])->first();
                $totalAmount = $totalAmountw->invoice_amount;
            } else {
                if (strpos($request['number_ref'], 'F') !== false) {
                    $check40 = ConsignmentHeader::where('consignment_no', $request['number_ref'])->first();
                    if (!empty($check40)) {
                        $totalAmount = $check40->total_include_vat;
                    } else {
                        if (request()->credit_ref == '*') {
                            $totalAmount = PtomOrderCreditGroup::join('ptom_consignment_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_consignment_headers.order_header_id', 'left')->where('ptom_consignment_headers.consignment_no', $request['number_ref'])->where('ptom_order_credit_groups.order_line_id', '0')->sum('ptom_order_credit_groups.amount');
                        } else {
                            $totalAmount = PtomOrderCreditGroup::join('ptom_consignment_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_consignment_headers.order_header_id', 'left')->where('ptom_consignment_headers.consignment_no', $request['number_ref'])->where('ptom_order_credit_groups.order_line_id', '0')->where('ptom_order_credit_groups.credit_group_code', request()->credit_ref)->sum('ptom_order_credit_groups.amount');
                        }
                    }
                } else {
                    if (request()->credit_ref == '*') {
                        $totalAmount = PtomOrderCreditGroup::join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->where(function ($q) use ($request) {
                            $q->where('ptom_order_headers.prepare_order_number', $request['number_ref']);
                            $q->orWhere('ptom_order_headers.pick_release_no', $request['number_ref']);
                        })->where('ptom_order_credit_groups.order_line_id', '0')->sum('ptom_order_credit_groups.amount');
                    } else {
                        $totalAmount = PtomOrderCreditGroup::join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->where(function ($q) use ($request) {
                            $q->where('ptom_order_headers.prepare_order_number', $request['number_ref']);
                            $q->orWhere('ptom_order_headers.pick_release_no', $request['number_ref']);
                        })->where('ptom_order_credit_groups.order_line_id', '0')->where('ptom_order_credit_groups.credit_group_code', request()->credit_ref)->sum('ptom_order_credit_groups.amount');
                    }
                }
            }
        } else {
            $payments = [];
            $invoicess = [];
            $datapayment = [];
            $customerinfo = [];
            $order_header_id = '';
            $searchomp0025 = false;
            $p = 0;
            $files = [];
            $totalAmount = 0;
            $cns = [];
            $odr = [];
            request()->session()->forget(['credit_ref', 'customer_ref', 'customer_name_ref1', 'amount_ref_total', 'amount_ref', 'number_ref']);
        }

        $credits = CreditGroup::get(['lookup_code', 'description']);

        return view('om.domestic_matching.index', compact(
            'orders',
            'invoices',
            'datapayment',
            'credits',
            'payments',
            'invoicess',
            'customers',
            'customerinfo',
            'order_header_id',
            'searchomp0025',
            'p',
            'files',
            'consignments',
            'totalAmount',
            'cns',
            'odr',
            'dninvoices',
            'number_refs'
        ));
    }

    public function getinvoice(Request $request)
    {
        $html = '<option></option>';
        $customer = Customer::where('customer_number', '=', $request->customer_number)->first(['customer_id']);
        if (empty($customer)) {
            return response()->json(['data' => '']);
        }

        $orders = DB::select("SELECT PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,PTOM_ORDER_HEADERS.ORDER_DATE,PTOM_ORDER_HEADERS.PICK_RELEASE_NO,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_CUSTOMERS.CUSTOMER_TYPE_ID,PTOM_CUSTOMERS.CUSTOMER_ID,PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE FROM PTOM_ORDER_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE (PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER IS NOT NULL OR PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL) AND PTOM_ORDER_HEADERS.CUSTOMER_ID = '$customer->customer_id' ORDER BY PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER DESC");

        $consignments = [];
        foreach ($orders as $r) {
            if ($r->customer_type_id == '30' && $r->product_type_code == '10') {
                $con = ConsignmentHeader::join('ptom_order_headers', 'ptom_consignment_headers.order_header_id', 'ptom_order_headers.order_header_id', 'left')->join('ptom_customers', 'ptom_order_headers.customer_id', 'ptom_customers.customer_id', 'left')->where('ptom_consignment_headers.order_header_id', $r->order_header_id)->get();
                foreach ($con as $co) {
                    if (!empty($co)) {
                        $data['text'] = $co->consignment_no . ':' . $co->customer_name;
                        $data['value'] = $co->consignment_no;

                        array_push($consignments, $data);
                    }
                }
            }
        }

        $consignmentsss = DB::select("SELECT * FROM PTOM_CONSIGNMENT_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
        WHERE PTOM_CUSTOMERS.CUSTOMER_TYPE_ID = '30' AND PTOM_CONSIGNMENT_HEADERS.ORDER_HEADER_ID IS NULL AND UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = '$customer->customer_id'");
        foreach ($consignmentsss as $c) {
            $ch = DB::select("SELECT * FROM PTOM_CONSIGNMENT_LINES LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID 
            WHERE PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID = '" . $c->consignment_header_id . "' AND PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = '10'");
            if (!empty($ch)) {
                if (!in_array($c->consignment_no, $consignments)) {
                    $data['text'] = $c->consignment_no . ':' . $c->customer_name;
                    $data['value'] = $c->consignment_no;

                    array_push($consignments, $data);
                }
            }
        }

        $dninvoices = [];
        $sqldn = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_CUSTOMERS.CUSTOMER_NAME FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.PROGRAM_CODE = 'OMP0032' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN' AND PTOM_INVOICE_HEADERS.DELETED_AT IS NULL AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NOT NULL AND PTOM_INVOICE_HEADERS.CUSTOMER_ID = '$customer->customer_id' ORDER BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER DESC");
        foreach ($sqldn as $dn) {
            $datas['text'] = $dn->invoice_headers_number . ':' . $dn->customer_name;
            $datas['value'] = $dn->invoice_headers_number;

            array_push($dninvoices, $datas);
        }

        foreach ($orders as $order) {
            if (strpos($order->prepare_order_number, 'SA') !== false) {
            } else {
                if ($order->customer_type_id == '30' && $order->product_type_code == '10') {
                } else {
                    if ($order->pick_release_no != null) {
                        $l1 = 'value="' . $order->pick_release_no . '"';
                    } else {
                        $l1 = 'value="' . $order->prepare_order_number . '"';
                    }
                    if ($order->prepare_order_number != null) {
                        $l2 = ':';
                    } else {
                        $l2 = '';
                    }
                    $html .= '<option ' . $l1 . '>' . $order->prepare_order_number . ' ' . $l2 . ' ' . $order->pick_release_no . ' : ' . $order->customer_name . '</option>';
                }
            }
        }

        foreach ($consignments as $consignment) {
            $html .= '<option value="' . $consignment['value'] . '">' . $consignment['text'] . '</option>';
        }

        foreach ($dninvoices as $dninvoice) {
            $html .= '<option value="' . $dninvoice['value'] . '">' . $dninvoice['text'] . '</option>';
        }

        return response()->json(['data' => $html]);
    }

    public function getamount(Request $request)
    {
        $customer = Customer::where('customer_number', '=', $request->customer_ref)->first(['customer_id']);

        if (strpos($request->number_ref, 'DN') !== false) {
            $order = DB::select("SELECT CUSTOMER_ID,INVOICE_HEADERS_ID,DOCUMENT_ID FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_NUMBER = '" . $request->number_ref . "'");
            $headers_id = $order[0]->document_id;
        } else {
            if (strpos($request->number_ref, 'F') !== false) {
                $order = ConsignmentHeader::where('consignment_no', $request->number_ref)->first();
            } else {
                $order = OrderHeader::where('prepare_order_number', $request->number_ref)->orWhere('pick_release_no', $request->number_ref)->first();
            }
            $headers_id = $order->order_header_id;
        }

        if (strpos($request->number_ref, 'DN') !== false) {
            $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND (PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID = '" . $order[0]->invoice_headers_id . "' OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . $request->number_ref . "')");
        } else {
            if (strpos($request->number_ref, 'F') !== false) {
                $ooor = OrderHeaders::find($order->order_header_id);
                if ($request->credit == '*') {
                    $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND (PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . $request->number_ref . "' OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID = '" . $order->consignment_header_id . "')");
                } else {
                    $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID LEFT JOIN PTOM_CREDIT_GROUP ON PTOM_PAYMENT_MATCH_INVOICES.CREDIT_GROUP_CODE = PTOM_CREDIT_GROUP.LOOKUP_CODE WHERE PTOM_PAYMENT_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND PTOM_PAYMENT_MATCH_INVOICES.CREDIT_GROUP_CODE = '" . $request->credit . "' AND (PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . $request->number_ref . "' OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID = '" . $order->consignment_header_id . "')");
                }
            } else {
                if ($request->credit == '*') {
                    $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND (PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . $request->number_ref . "' OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID = '" . $order->pick_release_id . "')");
                } else {
                    $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID LEFT JOIN PTOM_CREDIT_GROUP ON PTOM_PAYMENT_MATCH_INVOICES.CREDIT_GROUP_CODE = PTOM_CREDIT_GROUP.LOOKUP_CODE WHERE PTOM_PAYMENT_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND PTOM_PAYMENT_MATCH_INVOICES.CREDIT_GROUP_CODE = '" . $request->credit . "' AND (PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . $request->number_ref . "' OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID = '" . $order->pick_release_id . "')");
                }
            }
        }

        $p = $payment[0]->payment_amount == null ? 0 : $payment[0]->payment_amount;

        if (strpos($request->number_ref, 'DN') !== false) {
            $totalAmountw = PtomInvoiceHeader::where('invoice_headers_number', $request->number_ref)->sum('invoice_amount');
            $totalAmount = $totalAmountw;
        } else {
            if (strpos($request->number_ref, 'F') !== false) {
                $check40 = ConsignmentHeader::where('consignment_no', $request->number_ref)->first();
                if (!empty($check40)) {
                    $totalAmount = $check40->total_include_vat;
                } else {
                    if ($request->credit == '*') {
                        $totalAmount = PtomOrderCreditGroup::join('ptom_consignment_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_consignment_headers.order_header_id', 'left')->where('ptom_consignment_headers.consignment_no', $request->number_ref)->where('ptom_order_credit_groups.order_line_id', '0')->sum('ptom_order_credit_groups.amount');
                    } else {
                        $totalAmount = PtomOrderCreditGroup::join('ptom_consignment_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_consignment_headers.order_header_id', 'left')->where('ptom_consignment_headers.consignment_no', $request->number_ref)->where('ptom_order_credit_groups.order_line_id', '0')->where('ptom_order_credit_groups.credit_group_code', $request->credit)->sum('ptom_order_credit_groups.amount');
                    }
                }
            } else {
                if ($request->credit == '*') {
                    $totalAmount = PtomOrderCreditGroup::join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->where(function ($q) use ($request) {
                        $q->where('ptom_order_headers.prepare_order_number', $request->number_ref);
                        $q->orWhere('ptom_order_headers.pick_release_no', $request->number_ref);
                    })->where('ptom_order_credit_groups.order_line_id', '0')->sum('ptom_order_credit_groups.amount');
                } else {
                    $totalAmount = PtomOrderCreditGroup::join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->where(function ($q) use ($request) {
                        $q->where('ptom_order_headers.prepare_order_number', $request->number_ref);
                        $q->orWhere('ptom_order_headers.pick_release_no', $request->number_ref);
                    })->where('ptom_order_credit_groups.order_line_id', '0')->where('ptom_order_credit_groups.credit_group_code', $request->credit)->sum('ptom_order_credit_groups.amount');
                }
            }
        }

        $html = '';

        $t = 0;
        $numberkey = 0;
        if ($request->search) {
            if (strpos($request->number_ref, 'DN') !== false) {
                $datapayment = PaymentMatchInvoice::with(['invoices', 'files' => function ($q) {
                    $q->where('attachment_program_code', '=', 'OMP0025');
                }])->where(function ($w) use ($request) {
                    $ww = PtomInvoiceHeader::where('invoice_headers_number', $request['number_ref'])->first();
                    $w->where('invoice_number', $request['number_ref']);
                    if (!empty($ww)) {
                        $w->orWhere('invoice_id', $ww->invoice_headers_id);
                    }
                })->leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', '=', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_match_invoices.match_flag', '=', 'Y')->groupBy(['ptom_payment_headers.payment_number', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD')")])->get(['ptom_payment_headers.payment_number', DB::raw("SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT"), DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD') CREATION_DATE")]);

                if (!empty($datapayment)) {
                    foreach ($datapayment as $key => $match) {
                        $numberkey++;
                        $t += $match->payment_amount;
                        $html .= '<tr class="align-middle"><input type="hidden" value="draft" name="payment_type[]">';
                        $html .= '<td>' . $numberkey . '</td>';
                        $html .= '<td><div class="input-icon"><input type="text" readonly class="form-control md text-center" name="payment_number[]" placeholder="" value="' . $match->payment_number . '"><i class="fa fa-search"></i></div></td>';
                        $html .= '<td>' . FormatDate::DateThaiNumericWithSplash($match->creation_date) . '<input type="hidden" name="date_matching_ref[]" value="' . FormatDate::DateThaiNumericWithSplash($match->creation_date) . '"></td>';
                        $html .= '<td><input type="text" readonly class="form-control md text-right" name="payment_amounts[]" placeholder="" value="' . number_format($match->payment_amount, 2) . '"><input type="hidden" name="payment_amount[]" value="' . number_format($match->payment_amount, 2) . '"><input type="hidden" name="type_payment_match[]" value="old"></td>';
                        $html .= '<td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td></tr>';
                    }
                }


                $countmatchinvoice = [];
                $ptomorder = PaymentMatchInvoice::where('invoice_number', $request['number_ref'])->get(['payment_match_id']);
                foreach ($ptomorder as $cinvoice) {
                    if (!in_array($cinvoice->payment_match_id, $countmatchinvoice)) {
                        array_push($countmatchinvoice, $cinvoice->payment_match_id);
                    }
                }
                if (count($countmatchinvoice) > 0) {
                    $cns = PaymentApplyCNDN::whereIn('payment_match_id', $countmatchinvoice)->where('attribute1', 'Y')->get();
                } else {
                    $cns = [];
                }

                if (!empty($cns)) {
                    foreach ($cns as $cn) {
                        $numberkey++;
                        $html .= '<tr class="align-middle red"><input type="hidden" value="draft" name="payment_type[]">';
                        $html .= '<td>' . $numberkey . '</td>';
                        $html .= '<td><div class="input-icon"><input type="text" readonly class="form-control md text-center" name="payment_number[]" placeholder="" value="' . $cn->invoice_number . '"><i class="fa fa-search"></i></div></td>';
                        $html .= '<td>' . FormatDate::DateThaiNumericWithSplash($cn->last_update_date) . '<input type="hidden" name="date_matching_ref[]" value="' . FormatDate::DateThaiNumericWithSplash($cn->last_update_date) . '"></td>';
                        $html .= '<td><input type="text" readonly class="form-control md text-right" name="payment_amounts[]" placeholder="" value="(' . number_format($cn->invoice_amount, 2) . ')"><input type="hidden" name="payment_amount[]" value="' . number_format($cn->invoice_amount, 2) . '"><input type="hidden" name="type_payment_match[]" value="old"></td>';
                        $html .= '<td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td></tr>';

                        $p += $cn->invoice_amount;
                        $t += $cn->invoice_amount;
                    }
                }
            } else {
                if ($request->credit == '*') {
                    $datapayment = PaymentMatchInvoice::where(function ($w) use ($request) {
                        if (strpos($request->number_ref, 'F') !== false) {
                            // $order = ConsignmentHeader::where('consignment_no', $request->number_ref)->first();
                            // $orderrh = OrderHeaders::where('order_header_id', $order->order_header_id)->first();
                            // $w->where('ptom_payment_match_invoices.invoice_id', '=', $order->consignment_header_id);
                            // if (!empty($orderrh)) {
                            //     $w->orWhere('ptom_payment_match_invoices.prepare_order_number', '=', $orderrh->prepare_order_number);
                            // }
                            $w->where('ptom_payment_match_invoices.invoice_number', '=', $request->number_ref);
                        } else {
                            $order = OrderHeaders::where('pick_release_no', $request->number_ref)->first();
                            $w->where('ptom_payment_match_invoices.prepare_order_number', '=', $request->number_ref);
                            if (!empty($order)) {
                                $w->orWhere('ptom_payment_match_invoices.prepare_order_number', '=', $order->prepare_order_number);
                            }
                        }
                    })->leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', '=', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_match_invoices.match_flag', '=', 'Y')->groupBy(['ptom_payment_headers.payment_number', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD')")])->get(['ptom_payment_headers.payment_number', DB::raw("SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT"), DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD') CREATION_DATE")]);
                } else {
                    $datapayment = PaymentMatchInvoice::where(function ($w) use ($request) {
                        if (strpos($request->number_ref, 'F') !== false) {
                            $order = ConsignmentHeader::where('consignment_no', $request->number_ref)->first();
                            $orderrh = OrderHeaders::where('order_header_id', $order->order_header_id)->first();
                            $w->where('ptom_payment_match_invoices.invoice_id', '=', $order->consignment_header_id);
                            if (!empty($orderrh)) {
                                $w->orWhere('ptom_payment_match_invoices.prepare_order_number', '=', $orderrh->prepare_order_number);
                            }
                        } else {
                            $order = OrderHeaders::where('pick_release_no', $request->number_ref)->first();
                            $w->where('ptom_payment_match_invoices.prepare_order_number', '=', $request->number_ref);
                            if (!empty($order)) {
                                $w->orWhere('ptom_payment_match_invoices.prepare_order_number', '=', $order->prepare_order_number);
                            }
                        }
                    })->where('ptom_payment_match_invoices.credit_group_code', '=', $request->credit)->leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', '=', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_match_invoices.match_flag', '=', 'Y')->groupBy(['ptom_payment_headers.payment_number', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD')")])->get(['ptom_payment_headers.payment_number', DB::raw("SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT"), DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD') CREATION_DATE")]);
                }

                if (!empty($datapayment)) {
                    foreach ($datapayment as $key => $match) {
                        $numberkey++;
                        $t += $match->payment_amount;
                        $html .= '<tr class="align-middle"><input type="hidden" value="draft" name="payment_type[]">';
                        $html .= '<td>' . $numberkey . '</td>';
                        $html .= '<td><div class="input-icon"><input type="text" readonly class="form-control md text-center" name="payment_number[]" placeholder="" value="' . $match->payment_number . '"><i class="fa fa-search"></i></div></td>';
                        $html .= '<td>' . FormatDate::DateThaiNumericWithSplash($match->creation_date) . '<input type="hidden" name="date_matching_ref[]" value="' . FormatDate::DateThaiNumericWithSplash($match->creation_date) . '"></td>';
                        $html .= '<td><input type="text" readonly class="form-control md text-right" name="payment_amounts[]" placeholder="" value="' . number_format($match->payment_amount, 2) . '"><input type="hidden" name="payment_amount[]" value="' . number_format($match->payment_amount, 2) . '"><input type="hidden" name="type_payment_match[]" value="old"></td>';
                        $html .= '<td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td></tr>';
                    }
                }

                if (strpos($request['number_ref'], 'F') !== false) {
                    if ($request->credit == '*') {
                        $cns = PaymentApplyCNDN::where('pick_release_no', $request['number_ref'])->where('attribute1', 'Y')->get();
                    } else {
                        $cns = PaymentApplyCNDN::where('pick_release_no', $request['number_ref'])->where('attribute1', 'Y')->where('credit_group_code', $request->credit)->get();
                    }
                    if (!empty($cns)) {
                        foreach ($cns as $cn) {
                            $numberkey++;
                            $html .= '<tr class="align-middle red"><input type="hidden" value="draft" name="payment_type[]">';
                            $html .= '<td>' . $numberkey . '</td>';
                            $html .= '<td><div class="input-icon"><input type="text" readonly class="form-control md text-center" name="payment_number[]" placeholder="" value="' . $cn->invoice_number . '"><i class="fa fa-search"></i></div></td>';
                            $html .= '<td>' . FormatDate::DateThaiNumericWithSplash($cn->last_update_date) . '<input type="hidden" name="date_matching_ref[]" value="' . FormatDate::DateThaiNumericWithSplash($cn->last_update_date) . '"></td>';
                            $html .= '<td><input type="text" readonly class="form-control md text-right" name="payment_amounts[]" placeholder="" value="(' . number_format($cn->invoice_amount, 2) . ')"><input type="hidden" name="payment_amount[]" value="' . number_format($cn->invoice_amount, 2) . '"><input type="hidden" name="type_payment_match[]" value="old"></td>';
                            $html .= '<td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td></tr>';

                            $p += $cn->invoice_amount;
                            $t += $cn->invoice_amount;
                        }
                    }
                } else {
                    $orderr = OrderHeaders::where('pick_release_no', $request['number_ref'])->orWhere('prepare_order_number', $request['number_ref'])->first();
                    if (!empty($orderr)) {
                        if ($request->credit == '*') {
                            $cns = PaymentApplyCNDN::where('pick_release_no', $orderr->pick_release_no)->where('attribute1', 'Y')->get();
                        } else {
                            $cns = PaymentApplyCNDN::where('pick_release_no', $orderr->pick_release_no)->where('attribute1', 'Y')->where('credit_group_code', $request->credit)->get();
                        }
                        if (!empty($cns)) {
                            foreach ($cns as $cn) {
                                $numberkey++;
                                $html .= '<tr class="align-middle red"><input type="hidden" value="draft" name="payment_type[]">';
                                $html .= '<td>' . $numberkey . '</td>';
                                $html .= '<td><div class="input-icon"><input type="text" readonly class="form-control md text-center" name="payment_number[]" placeholder="" value="' . $cn->invoice_number . '"><i class="fa fa-search"></i></div></td>';
                                $html .= '<td>' . FormatDate::DateThaiNumericWithSplash($cn->last_update_date) . '<input type="hidden" name="date_matching_ref[]" value="' . FormatDate::DateThaiNumericWithSplash($cn->last_update_date) . '"></td>';
                                $html .= '<td><input type="text" readonly class="form-control md text-right" name="payment_amounts[]" placeholder="" value="(' . number_format($cn->invoice_amount, 2) . ')"><input type="hidden" name="payment_amount[]" value="' . number_format($cn->invoice_amount, 2) . '"><input type="hidden" name="type_payment_match[]" value="old"></td>';
                                $html .= '<td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td></tr>';

                                $p += $cn->invoice_amount;
                                $t += $cn->invoice_amount;
                            }
                        }
                    }
                }
            }
        }

        $html .= '<tr class="align-middle"><td class="text-right pt-3 pb-3" colspan="3" id="ignore"><strong class="black">จำนวนเงินรวม</strong></td><td class="text-right pt-3 pb-3" id="total"><strong class="black">' . number_format($t, 2) . '</strong></td><td></td></tr>';

        return response()->json(['data' => $p, 'totalAmount' => $totalAmount, 'header_id' => $headers_id, 'html' => json_decode(json_encode($html))]);
    }

    public function getDataFirsttime(Request $request)
    {
        $customer = Customer::where('customer_number', '=', $request->customer_ref)->first(['customer_id', 'currency']);
        $payments = [];

        if ($request->list == null || $request->list == '') {
            $payment = PaymentHeader::where('customer_id', $customer->customer_id)->where('payment_status', '!=', 'Cancel')->get(['payment_header_id', 'payment_number', 'payment_date']);
        } else {
            $payment = PaymentHeader::where('customer_id', $customer->customer_id)->where('payment_status', '!=', 'Cancel')->whereNotIn('payment_number', $request->list)->get(['payment_header_id', 'payment_number', 'payment_date']);
        }
        if (!empty($payment)) {
            foreach ($payment as $p) {
                $sumd = PaymentLines::where('payment_header_id', $p->payment_header_id)->sum('payment_amount');
                $summ = PaymentMatchInvoice::where('payment_header_id', $p->payment_header_id)->where('match_flag', 'Y')->sum('payment_amount');
                if ($sumd > $summ) {
                    $data['payment_header_id'] = $p->payment_header_id;
                    $data['payment_number'] = $p->payment_number;
                    $data['payment_date'] = $p->payment_date;
                    $data['payment_amount'] = $sumd - $summ;
                    $data['currency'] = $customer->currency;

                    array_push($payments, $data);
                }
            }
        }

        $invoicess = [];
        if ($request->list == null || $request->list == '') {
            $in = PaymentApplyCNDN::join('ptom_invoice_headers', 'ptom_payment_apply_cndn.invoice_header_id', 'ptom_invoice_headers.invoice_headers_id', 'left')->where(function ($q) {
                $q->where('ptom_payment_apply_cndn.attribute1', 'N');
                $q->orWhereNull('ptom_payment_apply_cndn.attribute1');
            })->where('ptom_invoice_headers.customer_id', $customer->customer_id)->whereNotNull('ptom_payment_apply_cndn.invoice_number')->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')->orderBy('ptom_payment_apply_cndn.invoice_number', 'DESC')->get(['ptom_invoice_headers.invoice_headers_id', 'ptom_payment_apply_cndn.invoice_number', 'ptom_invoice_headers.invoice_date', 'ptom_payment_apply_cndn.invoice_amount']);
        } else {
            $in = PaymentApplyCNDN::join('ptom_invoice_headers', 'ptom_payment_apply_cndn.invoice_header_id', 'ptom_invoice_headers.invoice_headers_id', 'left')->where(function ($q) {
                $q->where('ptom_payment_apply_cndn.attribute1', 'N');
                $q->orWhereNull('ptom_payment_apply_cndn.attribute1');
            })->where('ptom_invoice_headers.customer_id', $customer->customer_id)->whereNotNull('ptom_payment_apply_cndn.invoice_number')->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')->whereNotIn('ptom_payment_apply_cndn.invoice_number', $request->list)->orderBy('ptom_payment_apply_cndn.invoice_number', 'DESC')->get(['ptom_invoice_headers.invoice_headers_id', 'ptom_payment_apply_cndn.invoice_number', 'ptom_invoice_headers.invoice_date', 'ptom_payment_apply_cndn.invoice_amount']);
        }
        if (!empty($in)) {
            foreach ($in as $i) {
                $datas['invoice_headers_id'] = $i->invoice_headers_id;
                $datas['invoice_headers_number'] = $i->invoice_number;
                $datas['invoice_date'] = $i->invoice_date;
                $datas['invoice_amount'] = $i->invoice_amount;
                $datas['currency'] = $customer->currency;

                array_push($invoicess, $datas);
            }
        }


        return response()->json(['payments' => json_decode(json_encode($payments)), 'invoicess' => json_decode(json_encode($invoicess))], 200);
    }

    public function uploaded(Request $request)
    {
        $payment = PaymentMatchInvoice::where(function ($w) use ($request) {
            $w->where('prepare_order_number', '=', $request['number_ref']);
            $w->orWhere('invoice_id', '=', $request['number_ref']);
        })->first();


        if (empty($payment)) {
            return redirect()->back()->withErrors('ไม่พบข้อมูล')->withInput($request->all());
        }
        if ($request->hasFile('aksfileupload')) {
            foreach ($request->file('aksfileupload') as $file) {
                $newfilename =  date('YmdHis') . '-upload' . '.' . $file->getClientOriginalExtension();
                try {
                    Storage::putFileAs(getDefaultData('/users')->archive_directory, $file, $file->getClientOriginalName());
                    DB::table('ptom_attachments')->insert([
                        'attachment_program_code' => 'OMP0025',
                        'header_id' => $payment->payment_header_id,
                        'file_name' => $file->getClientOriginalName(),
                        'path_name' => getDefaultData('/users')->archive_directory,
                        'program_code' => 'OMP0025',
                        'created_by' => getDefaultData('/users')->user_id,
                        'creation_date' => Carbon::now()->timezone('Asia/Bangkok'),
                        'last_updated_by' => getDefaultData('/users')->user_id,
                        'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'),
                    ]);
                    // PDO::commit();
                } catch (Exception $e) {
                    // PDO::rollback();
                    $name = explode('.', $newfilename);
                    Storage::disk('local')->put(getDefaultData('/users')->log_directory . '/' . $name[0] . '.txt', 'ไม่สามารถอัปโหลดไฟล์ได้ :' . $e->getMessage());
                    return redirect()->back()->withError('เกิดข้อผิดพลาดระหว่างการอัปโหลดไฟล์ ' . $file->getClientOriginalName())->withInput($request->all());
                }
            }
        }
        request()->session()->flashInput($request->all());

        return redirect()->back()->with('success', 'อัปโหลดไฟล์เรียบร้อยแล้ว');
    }



    public function fileupload(Request $request)
    {
        $program_code = 'OMP0025';
        $responseUploadFile = array();
        $responseUploadFile['status'] = 200;
        $responseUploadFile['message'] = "";
        $responseUploadFile['attachments'] = [];
        if ($request->hasFile('attachment')) {
            $idTest = 1;
            foreach ($request->file('attachment') as $file) {
                $newfilename = date('YmdHis') . '-upload' . '.' . $file->getClientOriginalExtension();
                $fileInfo = [];
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
                } catch (Exception $e) {
                    $name = explode('.', $newfilename);
                    Storage::disk('local')->put(getDefaultData('/users')->log_directory . '/' . $name[0] . '.txt', 'ไม่สามารถอัปโหลดไฟล์ได้ :' . $e->getMessage());
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

    public function unmatching(Request $request)
    {
        $apps = DB::select("SELECT PERIOD_NAME,CLOSING_STATUS FROM APPS.GL_PERIOD_STATUSES WHERE TO_CHAR(START_DATE, 'YYYY-MM-DD') <= '" . Carbon::now()->format('Y-m-d') . "' AND TO_CHAR(END_DATE, 'YYYY-MM-DD') >= '" . Carbon::now()->format('Y-m-d') . "' ORDER BY LAST_UPDATE_DATE DESC FETCH FIRST 1 ROWS ONLY");
        if (empty($apps)) {
            return response()->json(['status' => 'error', 'data' => 'ไม่พบข้อมูล APPS.GL_PERIOD_STATUSES'], 200);
        }

        if ($apps[0]->closing_status != 'O') {
            return response()->json(['status' => 'error', 'data' => 'กรุณาเปิด AR period ของ ' . $apps[0]->period_name . ' ก่อน'], 200);
        }

        if (strpos($request->number_ref, 'DN') !== false) {
            if ($request->credit_save == '*') {
                $payment = PaymentMatchInvoice::where(function ($w) use ($request) {
                    $w->where('invoice_number', '=', $request->number_ref);
                })->where('match_flag', 'Y')->get();
            } else {
                $payment = PaymentMatchInvoice::where(function ($w) use ($request) {
                    $w->where('invoice_number', '=', $request->number_ref);
                })->where('credit_group_code', '=', $request->credit_save)->where('match_flag', 'Y')->get();
            }
        } else {
            if (strpos($request->number_ref, 'F') !== false) {
                $c = ConsignmentHeader::where('consignment_no', $request->number_ref)->first();
                if ($request->credit_save == '*') {
                    $payment = PaymentMatchInvoice::where(function ($w) use ($request, $c) {
                        $w->where('prepare_order_number', '=', $request->number_ref);
                        $w->orWhere('invoice_id', '=', $c->consignment_header_id);
                    })->where('match_flag', 'Y')->get();
                } else {
                    $payment = PaymentMatchInvoice::where(function ($w) use ($request, $c) {
                        $w->where('prepare_order_number', '=', $request->number_ref);
                        $w->orWhere('invoice_id', '=', $c->consignment_header_id);
                    })->where('credit_group_code', '=', $request->credit_save)->where('match_flag', 'Y')->get();
                }
            } else {
                if ($request->credit_save == '*') {
                    $payment = PaymentMatchInvoice::where(function ($w) use ($request) {
                        $w->where('prepare_order_number', '=', $request->number_ref);
                        // $w->orWhere('invoice_id', '=', $request->number_ref);
                    })->where('match_flag', 'Y')->get();
                } else {
                    $payment = PaymentMatchInvoice::where(function ($w) use ($request) {
                        $w->where('prepare_order_number', '=', $request->number_ref);
                        // $w->orWhere('invoice_id', '=', $request->number_ref);
                    })->where('credit_group_code', '=', $request->credit_save)->where('match_flag', 'Y')->get();
                }
            }
        }

        $pay = [];
        $pre = [];
        $in = [];
        foreach ($payment as $p) {
            if (!in_array($p->payment_match_id, $pay)) {
                array_push($pay, $p->payment_match_id);
            }
            if (!in_array($p->prepare_order_number, $pre) && $p->prepare_order_number != null) {
                array_push($pre, $p->prepare_order_number);
            }
            if (!in_array($p->invoice_id, $in) && $p->invoice_id != null) {
                array_push($in, $p->invoice_id);
            }

            $pg = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('ptom_payment_match_invoices.payment_match_id', $p->payment_match_id)->first();
            if (!empty($pg)) {
                $customer_id = $pg->customer_id;
                $credit_group_code = $pg->credit_group_code;
                $amount = $pg->payment_amount;

                $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id)->where('credit_group_code', $credit_group_code)->whereNull('deleted_at')->first();
                if (!empty($ccgm)) {
                    $ramount_ccgm = $ccgm->remaining_amount;
                    $remaining_amount = (new OrderEcomController)->reCalculateRemainingAmountVal($customer_id);
                               
                    $ccgm->remaining_amount = !empty($remaining_amount[$credit_group_code]) ? $remaining_amount[$credit_group_code] : 0;
                    $ccgm->save();
                }

                PaymentMatchInvoice::find($p->payment_match_id)->update(['match_flag' => 'N', 'last_updated_by' => getDefaultData('/users')->user_id, 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
            }
        }

        $ors = [];
        if (count($in) > 0) {
            $cons = ConsignmentHeader::whereIn('consignment_header_id', $in)->get();
            $conss = [];
            if (!empty($cons)) {
                foreach ($cons as $con) {
                    if (!in_array($con->order_header_id, $conss)) {
                        array_push($conss, $con->order_header_id);
                    }
                }
            }

            if (count($conss) > 0) {
                $or = OrderHeaders::whereIn('prepare_order_number', $pre)->orWhereIn('order_header_id', $conss)->get();
                if (count($or) > 0) {
                    foreach ($or as $r) {
                        if (!in_array($r->order_header_id, $ors)) {
                            array_push($ors, $r->order_header_id);
                        }
                    }
                }
            } else {
                $or = OrderHeaders::whereIn('prepare_order_number', $pre)->get();
                if (count($or) > 0) {
                    foreach ($or as $r) {
                        if (!in_array($r->order_header_id, $ors)) {
                            array_push($ors, $r->order_header_id);
                        }
                    }
                }
            }
        } else {
            $or = OrderHeaders::whereIn('prepare_order_number', $pre)->get();
            if (count($or) > 0) {
                foreach ($or as $r) {
                    if (!in_array($r->order_header_id, $ors)) {
                        array_push($ors, $r->order_header_id);
                    }
                }
            }
        }

        if ($request->credit_save == '*') {
            // $pppa = PaymentApplyCNDN::whereIn('order_header_id', $ors)->orWhereIn('payment_match_id', $pay)->where('attribute1', 'Y')->whereNotNull('payment_match_id')->get();
            $pppa = PaymentApplyCNDN::whereIn('order_header_id', $ors)->orWhereIn('payment_match_id', $pay)->where('attribute1', 'Y')->get();
            foreach ($pppa as $ap) {
                $pg1 = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('ptom_payment_match_invoices.payment_match_id', $ap->payment_match_id)->first();
                if (!empty($pg1)) {
                    $customer_id1 = $pg1->customer_id;
                    $credit_group_code1 = $pg1->credit_group_code;
                    $amount1 = $ap->invoice_amount;

                    $ccgm1 = CustomerContractGroupModel::where('customer_id', $customer_id1)->where('credit_group_code', $credit_group_code1)->whereNull('deleted_at')->first();
                    if (!empty($ccgm1)) {
                        $ramount_ccgm1 = $ccgm1->remaining_amount;

                        $ccgm1->remaining_amount = $ramount_ccgm1 - $amount1;
                        $ccgm1->save();
                    }

                    PaymentMatchInvoice::find($p->payment_match_id)->update(['match_flag' => 'N', 'last_updated_by' => getDefaultData('/users')->user_id, 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
                }
            }
            // PaymentApplyCNDN::whereIn('order_header_id', $ors)->orWhereIn('payment_match_id', $pay)->where('attribute1', 'Y')->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
        } else {
            // $pppa = PaymentApplyCNDN::whereIn('order_header_id', $ors)->orWhereIn('payment_match_id', $pay)->where('attribute1', 'Y')->whereNotNull('payment_match_id')->get();
            $pppa = PaymentApplyCNDN::whereIn('order_header_id', $ors)->orWhereIn('payment_match_id', $pay)->where('attribute1', 'Y')->get();
            foreach ($pppa as $ap) {
                $pg1 = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('ptom_payment_match_invoices.payment_match_id', $ap->payment_match_id)->first();
                if (!empty($pg1)) {
                    $customer_id1 = $pg1->customer_id;
                    $credit_group_code1 = $pg1->credit_group_code;
                    $amount1 = $ap->invoice_amount;

                    $ccgm1 = CustomerContractGroupModel::where('customer_id', $customer_id1)->where('credit_group_code', $credit_group_code1)->whereNull('deleted_at')->first();
                    if (!empty($ccgm1)) {
                        $ramount_ccgm1 = $ccgm1->remaining_amount;

                        $ccgm1->remaining_amount = $ramount_ccgm1 - $amount1;
                        $ccgm1->save();
                    }

                    PaymentMatchInvoice::find($p->payment_match_id)->update(['match_flag' => 'N', 'last_updated_by' => getDefaultData('/users')->user_id, 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
                }
            }
            // PaymentApplyCNDN::whereIn('order_header_id', $ors)->orWhereIn('payment_match_id', $pay)->where('attribute1', 'Y')->where('credit_group_code', $request->credit_save)->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
        }

        return response()->json(['status' => 'success', 'data' => 'ดำเนินการเรียบร้อยแล้ว'], 200);
    }

    public function matching(Request $request)
    {
        // dd($request->all());
        // update header_id file_upload
        if ($request->files_uploadsId && $request->files_uploadsId != '') {
            $attachmentIDs = explode(",", $request->files_uploadsId);
            foreach ($attachmentIDs as $value) {
                $AttachFile = AttachFiles::where('attachment_id', $value)->first();
                // dd($AttachFile);
                if ($AttachFile) {
                    $AttachFile->header_id = $request->order_header_id;
                    $AttachFile->save();
                }
            }
        }
        // update header_id file_upload

        $user_id = getDefaultData('/users')->user_id;
        $number_unmatch = [];
        $cndn_unmatch = [];
        $kaaa = 0;
        if ($request->payment_number) {
            foreach ($request->payment_number as $key => $payment_number) {
                if ($request->payment_type[$key] == 'invoice') {
                    $credit_group_code = $request->credit_save == '*' ? null : $request->credit_save;
                    if ($request->type_payment_match[$key] == 'old') {
                        if (!in_array($payment_number, $cndn_unmatch)) {
                            array_push($cndn_unmatch, $payment_number);
                        }
                    } else {
                        if (strpos($request->sa_number_for, 'DN') !== false) {
                            $invoiceh = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
                            $orderget = OrderHeaders::find($invoiceh->document_id);
                            $pick_release_nos = $orderget->pick_release_no;
                            $order_id = $orderget->order_header_id;
                        } else {
                            if (strpos($request->sa_number_for, 'F') !== false) {
                                $consignmentss = ConsignmentHeader::where('consignment_no', $request->sa_number_for)->first();
                                $orderget = OrderHeaders::find($consignmentss->order_header_id);
                                $pick_release_nos = $consignmentss->consignment_no;
                                $order_id = $consignmentss->order_header_id;
                            } else {
                                $orderget = OrderHeaders::where('prepare_order_number', $request->sa_number_for)->orWhere('pick_release_no', $request->sa_number_for)->first();
                                $pick_release_nos = $orderget->pick_release_no;
                                $order_id = $orderget->order_header_id;
                            }
                        }
                        $fond = PaymentApply::where('invoice_number', $payment_number)->where(function ($q) {
                            $q->where('attribute1', 'N');
                            $q->orWhereNull('attribute1');
                        });
                        if ($fond->count() > 0) {
                            //update
                            $f = $fond->first();

                            $ccgm = CustomerContractGroupModel::where('customer_id', $orderget->customer_id)->where('credit_group_code', $credit_group_code)->whereNull('deleted_at')->first();
                            if (!empty($ccgm)) {
                                $ramount_ccgm = $ccgm->remaining_amount;

                                // $ccgm->remaining_amount = $ramount_ccgm + $f->invoice_amount;
                                $remaining_amount = (new OrderEcomController)->reCalculateRemainingAmountVal($orderget->customer_id);
                               
                                $ccgm->remaining_amount = !empty($remaining_amount[$credit_group_code]) ? $remaining_amount[$credit_group_code] : 0;
                                // $ccgm->remaining_amount = $ramount_ccgm + $request->payment_amounts[$key];
                                $ccgm->save();
                            }

                            if (str_replace(',', '', $request->payment_amounts[$key]) == $f->invoice_amount) {
                                PaymentApply::find($f->payment_apply_id)->update(['payment_match_id' => null, 'attribute1' => 'Y', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'), 'order_header_id' => $order_id, 'pick_release_no' => $pick_release_nos, 'credit_group_code' => $credit_group_code]);
                            } else {
                                $amount_total_bb = abs(str_replace(',', '', $request->payment_amounts[$key]) - $f->invoice_amount);

                                PaymentApply::find($f->payment_apply_id)->update(['payment_match_id' => null, 'attribute1' => 'Y', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'), 'order_header_id' => $order_id, 'pick_release_no' => $pick_release_nos, 'credit_group_code' => $credit_group_code, 'invoice_amount' => str_replace(',', '', $request->payment_amounts[$key])]);

                                PaymentApply::create([
                                    'invoice_number' => $f->invoice_number,
                                    'invoice_header_id' => $f->invoice_header_id,
                                    'invoice_amount' => $amount_total_bb,
                                    'attribute2' => $f->attribute2,
                                    'program_code' => 'OMP0025',
                                    'created_by' => $user_id,
                                    'last_updated_by' => $user_id,
                                ]);
                            }
                        } else {
                            $kaaa++;
                            //create
                            PaymentApply::create([
                                'order_header_id' => $orderget->order_header_id,
                                'pick_release_no' => $pick_release_nos,
                                'credit_group_code' => $credit_group_code,
                                'invoice_number' => $payment_number,
                                'attribute1' => 'Y',
                                'line_number' => $kaaa,
                                'invoice_header_id' => $request->payment_id[$key],
                                'invoice_amount' => str_replace(',', '', $request->payment_amounts[$key]),
                                'program_code' => 'OMP0025',
                                'created_by' => $user_id,
                                'last_updated_by' => $user_id,
                            ]);

                            $amountinvoicetotal = InvoiceHeaders::where('invoice_headers_number', $payment_number)->first();
                            if (str_replace(',', '', $request->payment_amounts[$key]) < $amountinvoicetotal->invoice_amount) {
                                PaymentApply::create([
                                    'invoice_number' => $amountinvoicetotal->invoice_headers_number,
                                    'invoice_header_id' => $amountinvoicetotal->invoice_header_id,
                                    'invoice_amount' => abs(str_replace(',', '', $request->payment_amounts[$key]) < $amountinvoicetotal->invoice_amount),
                                    'attribute2' => $amountinvoicetotal->invoice_type,
                                    'program_code' => 'OMP0025',
                                    'created_by' => $user_id,
                                    'last_updated_by' => $user_id,
                                ]);
                            }

                            $ccgm = CustomerContractGroupModel::where('customer_id', $orderget->customer_id)->where('credit_group_code', $credit_group_code)->whereNull('deleted_at')->first();
                            if (!empty($ccgm)) {
                                $ramount_ccgm = $ccgm->remaining_amount;

                                $remaining_amount = (new OrderEcomController)->reCalculateRemainingAmountVal($orderget->customer_id);
                               
                                $ccgm->remaining_amount = !empty($remaining_amount[$credit_group_code]) ? $remaining_amount[$credit_group_code] : 0;
                                $ccgm->save();
                            }
                        }
                        if (!in_array($payment_number, $cndn_unmatch)) {
                            array_push($cndn_unmatch, $payment_number);
                        }
                    }
                } else {
                    if ($request->type_payment_match[$key] == 'old') {
                        if (!in_array($payment_number, $number_unmatch)) {
                            array_push($number_unmatch, $payment_number);
                        }
                        // dd($number_unmatch);
                    } else {
                        $amount_payment_total = str_replace(',', '', $request->payment_amounts[$key]);

                        if (strpos($request->sa_number_for, 'DN') !== false) {
                            $invoces = DB::table('ptom_invoice_headers')->join('ptom_order_headers', 'ptom_invoice_headers.document_id', 'ptom_order_headers.order_header_id', 'left')->join('ptom_customers', 'ptom_order_headers.customer_id', 'ptom_customers.customer_id', 'left')->whereNotNull('ptom_invoice_headers.document_id')->where('ptom_invoice_headers.invoice_headers_number', $request->sa_number_for)->whereNull('ptom_invoice_headers.deleted_at')->where('ptom_invoice_headers.invoice_status', 'Confirm')->where('ptom_order_headers.payment_approve_flag', 'Y')->groupBy(['ptom_invoice_headers.customer_id', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.pick_release_id', 'ptom_order_headers.order_header_id', 'ptom_invoice_headers.invoice_status', 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.pick_release_no', 'ptom_invoice_headers.invoice_date', 'ptom_customers.customer_type_id', 'ptom_customers.currency', 'ptom_order_headers.payment_type_code'])->get(['ptom_invoice_headers.customer_id', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.pick_release_id', 'ptom_order_headers.order_header_id', DB::raw('ptom_invoice_headers.invoice_status order_status'), 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.pick_release_no', DB::raw('ptom_invoice_headers.invoice_date delivery_date'), 'ptom_customers.customer_type_id', 'ptom_customers.currency', 'ptom_order_headers.payment_type_code']);
                        } else {
                            if (strpos($request->sa_number_for, 'F') !== false) {
                                $invoces = DB::table('ptom_order_credit_groups')->join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->join('ptom_customers', 'ptom_order_headers.customer_id', 'ptom_customers.customer_id', 'left')->join('ptom_consignment_headers', 'ptom_order_headers.order_header_id', 'ptom_consignment_headers.order_header_id')->where('ptom_consignment_headers.consignment_no', '=', $request->sa_number_for)->where('ptom_order_credit_groups.order_line_id', '0')->where('ptom_order_headers.payment_approve_flag', 'Y')->groupBy(['ptom_order_headers.order_header_id', 'ptom_order_headers.pick_release_id', 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.customer_id', 'ptom_order_headers.payment_type_code', 'ptom_order_headers.currency', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.order_status', 'ptom_order_headers.pick_release_no', 'ptom_order_credit_groups.credit_group_code', 'ptom_order_headers.delivery_date', 'ptom_customers.customer_type_id', 'ptom_consignment_headers.total_include_vat'])->get(['ptom_order_headers.order_header_id', 'ptom_order_headers.pick_release_id', 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.customer_id', 'ptom_order_headers.payment_type_code', 'ptom_order_headers.currency', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.order_status', 'ptom_order_headers.pick_release_no', 'ptom_order_credit_groups.credit_group_code', 'ptom_order_headers.delivery_date', 'ptom_customers.customer_type_id', 'ptom_consignment_headers.total_include_vat']);
                                // dd($invoces);
                                if (count($invoces) == 0) {
                                    // dd(1);
                                    $order_header_id_null = true;
                                    $invoces001 = DB::table('ptom_consignment_lines')->join('ptom_consignment_headers', 'ptom_consignment_lines.consignment_header_id', 'ptom_consignment_headers.consignment_header_id')->where('ptom_consignment_headers.consignment_no', '=', $request->sa_number_for)->first();
                                    $invoces = DB::select("SELECT PTOM_ORDER_HEADERS.ORDER_HEADER_ID, PTOM_ORDER_HEADERS.PICK_RELEASE_ID, PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER, 
                                    PTOM_ORDER_HEADERS.CUSTOMER_ID, PTOM_ORDER_HEADERS.PAYMENT_TYPE_CODE, PTOM_ORDER_HEADERS.CURRENCY, 
                                    PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_FLAG, PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE, PTOM_ORDER_HEADERS.ORDER_STATUS, 
                                    PTOM_ORDER_HEADERS.PICK_RELEASE_NO, PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE, PTOM_ORDER_HEADERS.DELIVERY_DATE, 
                                    PTOM_CUSTOMERS.CUSTOMER_TYPE_ID, PTOM_CONSIGNMENT_HEADERS.TOTAL_INCLUDE_VAT FROM PTOM_ORDER_CREDIT_GROUPS 
                                    INNER JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_CREDIT_GROUPS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID 
                                    INNER JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
                                    INNER JOIN PTOM_CONSIGNMENT_LINES ON PTOM_ORDER_HEADERS.ORDER_HEADER_ID = PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID 
                                    INNER JOIN PTOM_CONSIGNMENT_HEADERS ON PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID = PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_HEADER_ID 
                                    WHERE PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_HEADER_ID = '" . $invoces001->consignment_header_id . "'
                                    AND PTOM_ORDER_CREDIT_GROUPS.ORDER_LINE_ID = 0 
                                    AND PTOM_ORDER_HEADERS.PAYMENT_APPROVE_FLAG = 'Y' 
                                    AND ROWNUM = 1 
                                    GROUP BY PTOM_ORDER_HEADERS.ORDER_HEADER_ID, PTOM_ORDER_HEADERS.PICK_RELEASE_ID, PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER, 
                                    PTOM_ORDER_HEADERS.CUSTOMER_ID, PTOM_ORDER_HEADERS.PAYMENT_TYPE_CODE, PTOM_ORDER_HEADERS.CURRENCY, 
                                    PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_FLAG, PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE, PTOM_ORDER_HEADERS.ORDER_STATUS, 
                                    PTOM_ORDER_HEADERS.PICK_RELEASE_NO, PTOM_ORDER_CREDIT_GROUPS.CREDIT_GROUP_CODE, PTOM_ORDER_HEADERS.DELIVERY_DATE, 
                                    PTOM_CUSTOMERS.CUSTOMER_TYPE_ID, PTOM_CONSIGNMENT_HEADERS.TOTAL_INCLUDE_VAT");
                                } else {
                                    // dd(2);
                                    $order_header_id_null = false;
                                }
                            } else {
                                if ($request->credit_save == '*') {
                                    $invoces = DB::table('ptom_order_credit_groups')->join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->join('ptom_customers', 'ptom_order_headers.customer_id', 'ptom_customers.customer_id', 'left')->where('ptom_order_headers.order_header_id', '=', $request->order_header_id)->where('ptom_order_credit_groups.order_line_id', '0')->where('ptom_order_headers.payment_approve_flag', 'Y')->groupBy(['ptom_order_headers.order_header_id', 'ptom_order_headers.pick_release_id', 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.customer_id', 'ptom_order_headers.payment_type_code', 'ptom_order_headers.currency', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.order_status', 'ptom_order_headers.pick_release_no', 'ptom_order_credit_groups.credit_group_code', 'ptom_order_headers.delivery_date', 'ptom_customers.customer_type_id'])->orderBy('ptom_order_credit_groups.credit_group_code', 'ASC')->get(['ptom_order_headers.order_header_id', 'ptom_order_headers.pick_release_id', 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.customer_id', 'ptom_order_headers.payment_type_code', 'ptom_order_headers.currency', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.order_status', 'ptom_order_headers.pick_release_no', 'ptom_order_credit_groups.credit_group_code', 'ptom_order_headers.delivery_date', 'ptom_customers.customer_type_id']);
                                } else {
                                    $invoces = DB::table('ptom_order_credit_groups')->join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->join('ptom_customers', 'ptom_order_headers.customer_id', 'ptom_customers.customer_id', 'left')->where('ptom_order_headers.order_header_id', '=', $request->order_header_id)->where('ptom_order_credit_groups.order_line_id', '0')->where('ptom_order_headers.payment_approve_flag', 'Y')->where('ptom_order_credit_groups.credit_group_code', $request->credit_save)->groupBy(['ptom_order_headers.order_header_id', 'ptom_order_headers.pick_release_id', 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.customer_id', 'ptom_order_headers.payment_type_code', 'ptom_order_headers.currency', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.order_status', 'ptom_order_headers.pick_release_no', 'ptom_order_credit_groups.credit_group_code', 'ptom_order_headers.delivery_date', 'ptom_customers.customer_type_id'])->orderBy('ptom_order_credit_groups.credit_group_code', 'ASC')->get(['ptom_order_headers.order_header_id', 'ptom_order_headers.pick_release_id', 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.customer_id', 'ptom_order_headers.payment_type_code', 'ptom_order_headers.currency', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.order_status', 'ptom_order_headers.pick_release_no', 'ptom_order_credit_groups.credit_group_code', 'ptom_order_headers.delivery_date', 'ptom_customers.customer_type_id']);
                                }
                            }
                        }

                        // dd($invoces);
                        foreach ($invoces as $invoce) { //2 loop
                            if ($amount_payment_total > 0) {
                                $p1 = PaymentHeader::where('payment_number', $payment_number)->first();
                                if (!empty($p1)) {
                                    $p2 = PaymentLines::where('payment_header_id', $p1->payment_header_id)->orderBy('payment_detail_id', 'ASC')->get();
                                    $sum_total_amount = 0;
                                    $i2_array = [];
                                    $gcode_array = [];
                                    foreach ($p2 as $pp2) {
                                        if ($amount_payment_total > 0) {
                                            if (strpos($request->sa_number_for, 'DN') !== false) {
                                                $gCode = null;
                                                $sum1 = PaymentMatchInvoice::where('payment_header_id', $p1->payment_header_id)->where(function ($q) use ($pp2) {
                                                    $q->where('payment_detail_id', $pp2->payment_detail_id);
                                                    $q->orWhereNull('payment_detail_id');
                                                })->where('match_flag', 'Y')->sum('payment_amount');
                                            } else {
                                                $gCode = $invoce->credit_group_code;
                                                // if ($request->credit_save == '*') {
                                                //     $sum1 = PaymentMatchInvoice::where('payment_header_id', $p1->payment_header_id)->where(function ($q) use ($pp2) {
                                                //         $q->where('payment_detail_id', $pp2->payment_detail_id);
                                                //         $q->orWhereNull('payment_detail_id');
                                                //     })->where('match_flag', 'Y')->sum('payment_amount');
                                                // } else {
                                                $sum1 = PaymentMatchInvoice::where('payment_header_id', $p1->payment_header_id)->where('credit_group_code', $gCode)->where(function ($q) use ($pp2) {
                                                    $q->where('payment_detail_id', $pp2->payment_detail_id);
                                                    // $q->orWhereNull('payment_detail_id');
                                                })->where('match_flag', 'Y')->sum('payment_amount');
                                                // }
                                                // file_put_contents('payment', json_encode($sum1));
                                            }


                                            $usersamo = DB::table('ptom_customers')->select('customer_type_id')->where('customer_id', $invoce->customer_id)->first();

                                            if ($pp2->payment_amount > $sum1) {
                                                $gCode = $invoce->credit_group_code;
                                                if (strpos($request->sa_number_for, 'DN') !== false) {
                                                    $bbamount = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
                                                    $bbamount1 = empty($bbamount) ? 0 : $bbamount->invoice_amount;
                                                    $bbamount2 = $bbamount1 - $sum1;
                                                } else {
                                                    // if (strpos($request->sa_number_for, 'F') !== false) {
                                                    //     $bbamount = ConsignmentHeader::where('consignment_no', $request->sa_number_for)->first();
                                                    //     $bbamount1 = empty($bbamount) ? 0 : $bbamount->total_include_vat;
                                                    // } else {
                                                    // $bbamount = OrderHeader::join('ptom_order_lines','ptom_order_headers.order_header_id','ptom_order_lines.order_header_id','left')->where(function ($q) use ($request) {
                                                    //     $q->where('ptom_order_headers.prepare_order_number', $request->sa_number_for);
                                                    //     $q->orWhere('ptom_order_headers.pick_release_no', $request->sa_number_for);
                                                    // })->where('ptom_order_lines.credit_group_code', $gCode)->get();
                                                    // dd($bbamount);
                                                    // $bbamount1 = $bbamount;
                                                    if ($usersamo->customer_type_id == 40) {
                                                        $DPayment = DB::select("SELECT ORDER_HEADER_ID,PICK_RELEASE_NO,PREPARE_ORDER_NUMBER,PRODUCT_TYPE_CODE,
                                                            PRODUCT_TYPE_DESCRIPTION DESCRIPTION,OUTSTANDING_DEBT TOTAL_AMOUNT,ORDER_DATE,CUSTOMER_TYPE_ID,CREDIT_GROUP_CODE,
                                                            CUSTOMER_ID,DUE_DATE,CONSIGNMENT_NO,CONSIGNMENT_DATE FROM PTOM_OUTSTANDING_DEBT_DOM_V WHERE CUSTOMER_ID = $invoce->customer_id AND CREDIT_GROUP_CODE IS NOT NULL AND PRODUCT_TYPE_CODE != 10 AND (PICK_RELEASE_NO = '" . $request->sa_number_for . "' OR PREPARE_ORDER_NUMBER = '" . $request->sa_number_for . "') AND CREDIT_GROUP_CODE = '$gCode' ORDER BY DUE_DATE ASC, CREDIT_GROUP_CODE ASC, PREPARE_ORDER_NUMBER ASC");
                                                    } elseif ($usersamo->customer_type_id == 30) {
                                                        $DPayment = DB::select("SELECT ORDER_HEADER_ID,PICK_RELEASE_NO,PREPARE_ORDER_NUMBER,PRODUCT_TYPE_CODE,
                                                            PRODUCT_TYPE_DESCRIPTION DESCRIPTION,OUTSTANDING_DEBT TOTAL_AMOUNT,ORDER_DATE,CUSTOMER_TYPE_ID,CREDIT_GROUP_CODE,
                                                            CUSTOMER_ID,DUE_DATE,CONSIGNMENT_NO,CONSIGNMENT_DATE FROM PTOM_OUTSTANDING_DEBT_DOM_V WHERE CUSTOMER_ID = $invoce->customer_id AND CREDIT_GROUP_CODE IS NOT NULL AND (PICK_RELEASE_NO = '" . $request->sa_number_for . "' OR PREPARE_ORDER_NUMBER = '" . $request->sa_number_for . "') AND CREDIT_GROUP_CODE = '$gCode' ORDER BY DUE_DATE ASC, CREDIT_GROUP_CODE ASC, PREPARE_ORDER_NUMBER ASC");
                                                    } else {
                                                        $DPayment = DB::select("SELECT ORDER_HEADER_ID,PICK_RELEASE_NO,PREPARE_ORDER_NUMBER,PRODUCT_TYPE_CODE,
                                                            PRODUCT_TYPE_DESCRIPTION DESCRIPTION,OUTSTANDING_DEBT TOTAL_AMOUNT,ORDER_DATE,CUSTOMER_TYPE_ID,CREDIT_GROUP_CODE,
                                                            CUSTOMER_ID,DUE_DATE,CONSIGNMENT_NO,CONSIGNMENT_DATE FROM PTOM_OUTSTANDING_DEBT_DOM_V WHERE CUSTOMER_ID = $invoce->customer_id AND CREDIT_GROUP_CODE IS NOT NULL AND (PICK_RELEASE_NO = '" . $request->sa_number_for . "' OR PREPARE_ORDER_NUMBER = '" . $request->sa_number_for . "') AND CREDIT_GROUP_CODE = '$gCode' ORDER BY DUE_DATE ASC, CREDIT_GROUP_CODE ASC, PREPARE_ORDER_NUMBER ASC");
                                                    }
                                                    // file_put_contents('payment1', json_encode($DPayment));
                                                    $bbamount1 = empty($DPayment) ? 0 : $DPayment[0]->total_amount;
                                                    // }
                                                    $bbamount2 = $bbamount1;
                                                }

                                                // $bbamount2 = $bbamount1 - $sum1;
                                                // $bbamount2 = $bbamount1;
                                                // dd($bbamount2);
                                                $total_balance = $pp2->payment_amount - $sum1;
                                                $amount_payment_total = $amount_payment_total - $bbamount2;

                                                if (!empty($usersamo) && ($usersamo->customer_type_id == '30' || $usersamo->customer_type_id == '40')) {
                                                    //สโมสรและภูมิภาค
                                                    if ($invoce) {
                                                        if (strpos($request->sa_number_for, 'DN') !== false) {
                                                            $iii1 = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
                                                            $i1 = $iii1->invoice_headers_id;
                                                        } else {
                                                            if ($invoce->pick_release_approve_flag == 'Y' && $invoce->product_type_code != 10) {
                                                                // $i1 = $invoce->pick_release_id;
                                                                $c1 = ConsignmentHeader::where('consignment_no', $request->sa_number_for)->first();
                                                                if (!empty($c1)) {
                                                                    $i1 = $c1->consignment_header_id;
                                                                } else {
                                                                    $i1 = '';
                                                                }
                                                            } else {
                                                                if ($usersamo->customer_type_id == '40') {
                                                                    $i1 = $invoce->pick_release_id;
                                                                } else {
                                                                    if ($invoce->product_type_code == 10) {
                                                                        $c1 = ConsignmentHeader::where('consignment_no', $request->sa_number_for)->first();
                                                                        if (!empty($c1)) {
                                                                            $i1 = $c1->consignment_header_id;
                                                                        } else {
                                                                            $cc1 = ConsignmentLines::where('order_header_id', $invoce->order_header_id)->first();
                                                                            $i1 = $cc1->consignment_header_id;
                                                                        }
                                                                    } else {
                                                                        $i1 = '';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if ($order_header_id_null) {
                                                            $i2 = '';
                                                        } else {
                                                            if ($invoce->order_status == 'Confirm' && $invoce->product_type_code != 10) {
                                                                $i2 = $invoce->prepare_order_number;
                                                            } else {
                                                                $i2 = '';
                                                            }
                                                        }
                                                        if ($invoce->product_type_code != 10) {
                                                            $i3 = $invoce->pick_release_no;
                                                        } else {
                                                            $i3 = '';
                                                        }
                                                    } else {
                                                        $i1 = '';
                                                        $i2 = '';
                                                        $i3 = '';
                                                    }

                                                    if ($invoce->product_type_code != 10) {
                                                        $dbdayamount = DB::select("SELECT DAY_AMOUNT FROM PTOM_CUSTOMER_CONTRACT_GROUPS WHERE CUSTOMER_ID = '" . $invoce->customer_id . "' AND CREDIT_GROUP_CODE = '" . $gCode . "'");
                                                        $dataday = empty($dbdayamount) ? '0' : $dbdayamount[0]->day_amount;

                                                        $paymentduedate = Carbon::parse($invoce->delivery_date)->format('Y-m-d');
                                                    } else {
                                                        $c = ConsignmentHeader::where('consignment_no', $request->sa_number_for)->first();
                                                        if ($invoce->customer_type_id == 30) {
                                                            $dataday = 0;
                                                            $paymentduedate = Carbon::parse($c->consignment_date)->format('Y-m-d');
                                                        } else {
                                                            $t = DB::select("SELECT * FROM PTOM_TERMS_V WHERE CREDIT_GROUP_CODE = '0'");
                                                            $dataday = empty($t) ? '0' : $t[0]->due_days_consignment;

                                                            if ($invoce->customer_type_id == 30 && $invoce->product_type_code == 10) {
                                                                $paymentduedate = Carbon::parse($c->consignment_date)->format('Y-m-d');
                                                            } else {
                                                                if ($invoce->product_type_code == 10) {
                                                                    $t = DB::select("SELECT * FROM PTOM_TERMS_V WHERE CREDIT_GROUP_CODE = '0'");
                                                                    if (!empty($t)) {
                                                                        if ($t[0]->due_days_consignment == 0) {
                                                                            $paymentduedate = Carbon::parse($c->consignment_date)->format('Y-m-d');
                                                                        } else {
                                                                            $paymentduedate = Carbon::parse($invoce->delivery_date)->addDays($t[0]->due_days_consignment)->format('Y-m-d');
                                                                        }
                                                                    } else {
                                                                        $paymentduedate = Carbon::now()->format('Y-m-d');
                                                                    }
                                                                } else {
                                                                    $paymentduedate = Carbon::now()->format('Y-m-d');
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    //ไม่ใช่สโมสรและภูมิภาค
                                                    if ($invoce) {
                                                        if (strpos($request->sa_number_for, 'DN') !== false) {
                                                            $iii1 = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
                                                            $i1 = $iii1->invoice_headers_id;
                                                        } else {
                                                            if ($invoce->pick_release_approve_flag == 'Y') {
                                                                $i1 = $invoce->pick_release_id;
                                                            } else {
                                                                $i1 = '';
                                                            }
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

                                                    if (strpos($request->sa_number_for, 'DN') !== false) {
                                                        $dataday = null;
                                                        $paymentduedate = null;
                                                    } else {
                                                        $dbdayamount = DB::select("SELECT DAY_AMOUNT FROM PTOM_CUSTOMER_CONTRACT_GROUPS WHERE CUSTOMER_ID = '" . $invoce->customer_id . "' AND CREDIT_GROUP_CODE = '" . $gCode . "'");
                                                        $dataday = empty($dbdayamount) ? '0' : $dbdayamount[0]->day_amount;
                                                        if ($dataday != 0) {
                                                            $paymentduedate = Carbon::parse($invoce->delivery_date)->addDays($dataday)->format('Y-m-d');
                                                        } else {
                                                            $paymentduedate = Carbon::parse($invoce->delivery_date)->format('Y-m-d');
                                                        }
                                                    }
                                                }

                                                if (strpos($request->sa_number_for, 'DN') !== false) {
                                                    $i3 = $request->sa_number_for;
                                                }

                                                if (strpos($request->sa_number_for, 'F') !== false) {
                                                    $i3 = $request->sa_number_for;
                                                }

                                                if ($bbamount2 < str_replace(',', '', $request->payment_amounts[$key])) {
                                                    $payment_amount = $bbamount2;
                                                } else {
                                                    if (str_replace(',', '', $request->payment_amounts[$key]) < $total_balance) {
                                                        $payment_amount = str_replace(',', '', $request->payment_amounts[$key]);
                                                    } else {
                                                        $payment_amount = $total_balance;
                                                    }
                                                }

                                                PaymentMatchInvoice::create([
                                                    'payment_header_id' => $p1->payment_header_id,
                                                    'payment_detail_id' => $pp2->payment_detail_id,
                                                    'invoice_id' => $i1,
                                                    'invoice_number' => $i3,
                                                    'prepare_order_number' => $i2,
                                                    'credit_group_code' => $gCode,
                                                    'due_day' => $dataday,
                                                    'due_date' => $paymentduedate,
                                                    'payment_amount' => $payment_amount,
                                                    'match_flag' => 'Y',
                                                    'payment_type_code' => $invoce->payment_type_code,
                                                    'currency' => $invoce->currency,
                                                    'program_code' => 'OMP0025',
                                                    'created_by' => $user_id,
                                                    'last_updated_by' => $user_id,
                                                    'outstanding_debt' => $bbamount2
                                                ]);

                                                $ccgm = CustomerContractGroupModel::where('customer_id', $p1->customer_id)->where('credit_group_code', $gCode)->whereNull('deleted_at')->first();
                                                if (!empty($ccgm)) {
                                                    $ramount_ccgm = $ccgm->remaining_amount;
                                                    $remaining_amount = (new OrderEcomController)->reCalculateRemainingAmountVal($p1->customer_id);
                               
                                                    $ccgm->remaining_amount = !empty($remaining_amount[$gCode]) ? $remaining_amount[$gCode] : 0;
                                                    // $ccgm->remaining_amount = $ramount_ccgm + $total_balance;
                                                    $ccgm->save();
                                                }

                                                if ($i2 != '') {
                                                    if (!in_array($i2, $i2_array)) {
                                                        array_push($i2_array, $i2);
                                                    }
                                                }

                                                if (!in_array($gCode, $gcode_array)) {
                                                    array_push($gcode_array, $gCode);
                                                }

                                                $sum_total_amount += $total_balance;
                                            }
                                        }
                                    }

                                    $orderid_arrays = [];
                                    $orderid_array = OrderHeader::whereIn('prepare_order_number', $i2_array)->get();
                                    foreach ($orderid_array as $arr) {
                                        if (!in_array($arr->order_header_id, $orderid_arrays)) {
                                            array_push($orderid_arrays, $arr->order_header_id);
                                        }
                                    }
                                    $getTotalAmounts = PtomOrderCreditGroup::whereIn('order_header_id', $orderid_arrays)->whereIn('credit_group_code', $gcode_array)->where('order_line_id', '0')->sum('amount');
                                    //update payment header

                                    $total_with_vats = $p1->total_amount_with_vat + $getTotalAmounts;
                                    $total_payment_amounts = $p1->total_payment_amount + $sum_total_amount;

                                    PaymentHeader::where('payment_header_id', $p1->payment_header_id)->update(['last_updated_by' => $user_id, 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'), 'total_amount_with_vat' => $total_with_vats, 'total_payment_amount' => $total_payment_amounts]);
                                }
                            }
                            if (!in_array($payment_number, $number_unmatch)) {
                                array_push($number_unmatch, $payment_number);
                            }
                        }
                    }
                }
            }
        }

        if (count($cndn_unmatch) > 0) {

            $apps = DB::select("SELECT PERIOD_NAME,CLOSING_STATUS FROM APPS.GL_PERIOD_STATUSES WHERE TO_CHAR(START_DATE, 'YYYY-MM-DD') <= '" . Carbon::now()->format('Y-m-d') . "' AND TO_CHAR(END_DATE, 'YYYY-MM-DD') >= '" . Carbon::now()->format('Y-m-d') . "' ORDER BY LAST_UPDATE_DATE DESC FETCH FIRST 1 ROWS ONLY");
            if (empty($apps)) {
                return redirect()->back()->with('error', 'ไม่พบข้อมูล APPS.GL_PERIOD_STATUSES');
            }

            if ($apps[0]->closing_status != 'O') {
                return redirect()->back()->with('error', 'กรุณาเปิด AR period ของ ' . $apps[0]->period_name . ' ก่อน');
            }

            if (strpos($request->sa_number_for, 'DN') !== false) {
                // $pppp1 = PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->where('invoice_number', $request->sa_number_for)->where('attribute1', 'Y')->whereNotNull('payment_match_id')->get();
                $pppp1 = PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->where('attribute1', 'Y')->get();
                foreach ($pppp1 as $pppp11) {
                    if ($request->credit_save == '*') {
                        $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('payment_match_id', $pppp11->payment_match_id)->first();
                    } else {
                        $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('ptom_payment_match_invoices.credit_group_code', $request->credit_save)->where('payment_match_id', $pppp11->payment_match_id)->first();
                    }
                    if (!empty($customer_and_credit)) {
                        $customer_id_2 = $customer_and_credit->customer_id;
                        $credit_group_code_2 = $customer_and_credit->credit_group_code;
                        $amount_2 = $pppp11->invoice_amount;

                        $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id_2)->where('credit_group_code', $credit_group_code_2)->whereNull('deleted_at')->first();
                        if (!empty($ccgm)) {
                            $ramount_ccgm = $ccgm->remaining_amount;
                            $remaining_amount = (new OrderEcomController)->reCalculateRemainingAmountVal($customer_id_2);
                               
                            $ccgm->remaining_amount = !empty($remaining_amount[$credit_group_code_2]) ? $remaining_amount[$credit_group_code_2] : 0;
                            // $ccgm->remaining_amount = $ramount_ccgm - $amount_2;
                            $ccgm->save();
                        }
                    }
                }

                // PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
            } else {
                if (strpos($request->sa_number_for, 'F') !== false) {
                    $f = ConsignmentHeader::where('consignment_no', $request->sa_number_for)->first();
                    $odddr = OrderHeader::find($f->order_header_id);
                } else {
                    $odddr = OrderHeader::where('prepare_order_number', $request->sa_number_for)->orWhere('pick_release_no', $request->sa_number_for)->first();
                }

                // $pppp1 = PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->where(function ($q) use ($odddr) {
                //     $q->where('pick_release_no', $odddr->pick_release_no);
                //     $q->orWhere('order_header_id', $odddr->order_header_id);
                // })->where('attribute1', 'Y')->whereNotNull('payment_match_id')->get();
                $pppp1 = PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->where(function ($q) use ($odddr) {
                    $q->where('pick_release_no', $odddr->pick_release_no);
                    $q->orWhere('order_header_id', $odddr->order_header_id);
                })->where('attribute1', 'Y')->get();
                foreach ($pppp1 as $pppp11) {
                    if ($request->credit_save == '*') {
                        $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('payment_match_id', $pppp11->payment_match_id)->first();
                    } else {
                        $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('ptom_payment_match_invoices.credit_group_code', $request->credit_save)->where('payment_match_id', $pppp11->payment_match_id)->first();
                    }
                    if (!empty($customer_and_credit)) {
                        $customer_id_2 = $customer_and_credit->customer_id;
                        $credit_group_code_2 = $customer_and_credit->credit_group_code;
                        $amount_2 = $pppp11->invoice_amount;

                        $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id_2)->where('credit_group_code', $credit_group_code_2)->whereNull('deleted_at')->first();
                        if (!empty($ccgm)) {
                            $ramount_ccgm = $ccgm->remaining_amount;
                            $remaining_amount = (new OrderEcomController)->reCalculateRemainingAmountVal($customer_id_2);
                               
                            $ccgm->remaining_amount = !empty($remaining_amount[$credit_group_code_2]) ? $remaining_amount[$credit_group_code_2] : 0;
                            // $ccgm->remaining_amount = $ramount_ccgm - $amount_2;
                            $ccgm->save();
                        }
                    }
                }

                // PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->where(function ($q) use ($odddr) {
                //     $q->where('pick_release_no', $odddr->pick_release_no);
                //     $q->orWhere('order_header_id', $odddr->order_header_id);
                // })->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
            }
        } else {
            if (strpos($request->sa_number_for, 'DN') !== false) {
                $inv = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();

                // $pppp1 = PaymentApplyCNDN::where(function ($q) use ($request, $inv) {
                //     $q->where('invoice_number', $request->sa_number_for);
                //     $q->orWhere('invoice_header_id', $inv->invoice_headers_id);
                // })->where('attribute1', 'Y')->whereNotNull('payment_match_id')->get();
                $pppp1 = PaymentApplyCNDN::where(function ($q) use ($request, $inv) {
                    $q->where('invoice_number', $request->sa_number_for);
                    $q->orWhere('invoice_header_id', $inv->invoice_headers_id);
                })->where('attribute1', 'Y')->get();
                foreach ($pppp1 as $pppp11) {
                    if ($request->credit_save == '*') {
                        $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('payment_match_id', $pppp11->payment_match_id)->first();
                    } else {
                        $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('ptom_payment_match_invoices.credit_group_code', $request->credit_save)->where('payment_match_id', $pppp11->payment_match_id)->first();
                    }
                    if (!empty($customer_and_credit)) {
                        $customer_id_2 = $customer_and_credit->customer_id;
                        $credit_group_code_2 = $customer_and_credit->credit_group_code;
                        $amount_2 = $pppp11->invoice_amount;

                        $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id_2)->where('credit_group_code', $credit_group_code_2)->whereNull('deleted_at')->first();
                        if (!empty($ccgm)) {
                            $ramount_ccgm = $ccgm->remaining_amount;
                            $remaining_amount = (new OrderEcomController)->reCalculateRemainingAmountVal($customer_id_2);
                               
                            $ccgm->remaining_amount = !empty($remaining_amount[$credit_group_code_2]) ? $remaining_amount[$credit_group_code_2] : 0;
                            // $ccgm->remaining_amount = $ramount_ccgm - $amount_2;
                            $ccgm->save();
                        }
                    }
                }

                // PaymentApplyCNDN::where(function ($q) use ($request, $inv) {
                //     $q->where('invoice_number', $request->sa_number_for);
                //     $q->orWhere('invoice_header_id', $inv->invoice_headers_id);
                // })->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
            } else {
                if (strpos($request->sa_number_for, 'F') !== false) {
                    $f = ConsignmentHeader::where('consignment_no', $request->sa_number_for)->first();
                    $orderids = OrderHeader::find($f->order_header_id);
                } else {
                    $orderids = OrderHeader::where('prepare_order_number', $request->sa_number_for)->orWhere('pick_release_no', $request->sa_number_for)->first();
                }

                $pppp1 = PaymentApplyCNDN::where(function ($q) use ($request, $orderids) {
                    $q->where('pick_release_no', $request->sa_number_for);
                    $q->orWhere('order_header_id', $orderids->order_header_id);
                })->where('attribute1', 'Y')->whereNotNull('payment_match_id')->get();
                if (!empty($orderids)) {
                    $pppp1 = PaymentApplyCNDN::where(function ($q) use ($request, $orderids) {
                        $q->where('pick_release_no', $request->sa_number_for);
                        $q->orWhere('order_header_id', $orderids->order_header_id);
                    })->where('attribute1', 'Y')->get();
                    foreach ($pppp1 as $pppp11) {
                        if ($request->credit_save == '*') {
                            $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('payment_match_id', $pppp11->payment_match_id)->first();
                        } else {
                            $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('ptom_payment_match_invoices.credit_group_code', $request->credit_save)->where('payment_match_id', $pppp11->payment_match_id)->first();
                        }
                        if (!empty($customer_and_credit)) {
                            $customer_id_2 = $customer_and_credit->customer_id;
                            $credit_group_code_2 = $customer_and_credit->credit_group_code;
                            $amount_2 = $pppp11->invoice_amount;

                            $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id_2)->where('credit_group_code', $credit_group_code_2)->whereNull('deleted_at')->first();
                            if (!empty($ccgm)) {
                                $ramount_ccgm = $ccgm->remaining_amount;
                                $remaining_amount = (new OrderEcomController)->reCalculateRemainingAmountVal($customer_id_2);
                               
                                $ccgm->remaining_amount = !empty($remaining_amount[$credit_group_code_2]) ? $remaining_amount[$credit_group_code_2] : 0;
                                // $ccgm->remaining_amount = $ramount_ccgm - $amount_2;
                                $ccgm->save();
                            }
                        }
                    }

                    // PaymentApplyCNDN::where(function ($q) use ($request, $orderids) {
                    //     $q->where('pick_release_no', $request->sa_number_for);
                    //     $q->orWhere('order_header_id', $orderids->order_header_id);
                    // })->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
                }
            }
        }

        if (count($number_unmatch) > 0) {

            $apps = DB::select("SELECT PERIOD_NAME,CLOSING_STATUS FROM APPS.GL_PERIOD_STATUSES WHERE TO_CHAR(START_DATE, 'YYYY-MM-DD') <= '" . Carbon::now()->format('Y-m-d') . "' AND TO_CHAR(END_DATE, 'YYYY-MM-DD') >= '" . Carbon::now()->format('Y-m-d') . "' ORDER BY LAST_UPDATE_DATE DESC FETCH FIRST 1 ROWS ONLY");
            if (empty($apps)) {
                return redirect()->back()->with('error', 'ไม่พบข้อมูล APPS.GL_PERIOD_STATUSES');
            }

            if ($apps[0]->closing_status != 'O') {
                return redirect()->back()->with('error', 'กรุณาเปิด AR period ของ ' . $apps[0]->period_name . ' ก่อน');
            }
            // Unmatching
            $h = [];
            $payH = PaymentHeaders::whereIn('payment_number', $number_unmatch)->get(['payment_header_id']);
            foreach ($payH as $pay) {
                array_push($h, $pay->payment_header_id);
            }
            if (strpos($request->sa_number_for, 'DN') !== false) {
                $orderssss = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
            } else {
                if (strpos($request->sa_number_for, 'F') !== false) {
                    $f = ConsignmentHeader::where('consignment_no', $request->sa_number_for)->first();
                    $orderssss = OrderHeaders::find($f->order_header_id);
                    if (empty($orderssss)) {
                        $orderssss = ConsignmentLines::where('consignment_header_id', $f->consignment_header_id)->first();
                    }
                } else {
                    $orderssss = OrderHeaders::where('prepare_order_number', $request->sa_number_for)->orWhere('pick_release_no', $request->sa_number_for)->first();
                }
            }
            if (!empty($orderssss)) {
                if (strpos($request->sa_number_for, 'DN') !== false) {
                    if ($request->credit_save == '*') {
                        $payment_amounts = PaymentMatchInvoice::where(function ($q) use ($orderssss) {
                            $q->where('invoice_number', $orderssss->invoice_headers_number);
                            $q->orWhere('invoice_id', $orderssss->invoice_headers_id);
                        })->whereNotIn('payment_header_id', $h)->where('match_flag', 'Y')->get();
                    } else {
                        $payment_amounts = PaymentMatchInvoice::where('credit_group_code', $request->credit_save)->where(function ($q) use ($orderssss) {
                            $q->where('invoice_number', $orderssss->invoice_headers_number);
                            $q->orWhere('invoice_id', $orderssss->invoice_headers_id);
                        })->whereNotIn('payment_header_id', $h)->where('match_flag', 'Y')->get();
                    }
                } else {
                    if ($request->credit_save == '*') {
                        $payment_amounts = PaymentMatchInvoice::where('invoice_number', '=', $request->sa_number_for)->whereNotIn('payment_header_id', $h)->where('match_flag', 'Y')->get();
                    } else {
                        $payment_amounts = PaymentMatchInvoice::where('credit_group_code', $request->credit_save)->where('invoice_number', '=', $request->sa_number_for)->whereNotIn('payment_header_id', $h)->where('match_flag', 'Y')->get();
                    }
                }
                $sum_payment_amount = 0;
                $document_id = [];
                $order_id = [];
                $group_id = [];
                $twv = 0;
                $tpa = 0;
                foreach ($payment_amounts as $pp) {
                    $payments = PaymentHeader::where('payment_header_id', $pp->payment_header_id)->first();

                    if (strpos($request->sa_number_for, 'DN') !== false) {
                        $orderid = DB::select("SELECT DOCUMENT_ID,INVOICE_AMOUNT FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_NUMBER = '" . $request->sa_number_for . "'");

                        if (!in_array($orderid[0]->document_id, $document_id)) {
                            array_push($document_id, $orderid[0]->document_id);

                            $total_with_vat = $payments->total_amount_with_vat - $orderid[0]->invoice_amount;
                            if ($total_with_vat < 0) {
                                $twv += 0;
                            } else {
                                $twv += $total_with_vat;
                            }

                            $total_payment_amount = $payments->total_payment_amount - $sum_payment_amount;
                            if ($total_payment_amount < 0) {
                                $tpa += 0;
                            } else {
                                $tpa += $total_payment_amount;
                            }

                            PaymentHeader::where('payment_header_id', $pp->payment_header_id)->update(['last_updated_by' => $user_id, 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'), 'total_amount_with_vat' => $twv, 'total_payment_amount' => $tpa]);
                        } else {
                            $twv += 0;
                            $tpa += 0;
                        }

                        $checkdcn = PaymentApply::where('payment_match_id', $pp->payment_match_id)->first();
                        if (!empty($checkdcn)) {
                            $paymentdcn = DB::select("SELECT PTOM_PAYMENT_APPLY_CNDN.INVOICE_AMOUNT INVOICE_AMOUNT FROM PTOM_PAYMENT_APPLY_CNDN LEFT JOIN PTOM_INVOICE_HEADERS ON PTOM_PAYMENT_APPLY_CNDN.INVOICE_HEADER_ID = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID WHERE PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID = '" . $pp->payment_match_id . "' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN'");
                            if (!empty($paymentdcn)) {
                                $notdn = $paymentdcn[0]->invoice_amount;
                            } else {
                                $notdn = 0;
                            }
                        } else {
                            $notdn = 0;
                        }

                        $sum_payment_amount += $pp->payment_amount + $notdn;

                        $pp->match_flag = 'N';
                        $pp->last_updated_by = $user_id;
                        $pp->last_update_date = Carbon::now()->timezone('Asia/Bangkok');
                        $pp->save();
                    } else {
                        $orderid = OrderHeader::where('prepare_order_number', $pp->prepare_order_number)->first();

                        if (count($order_id) > 0 && count($group_id) > 0) {
                            $getTotalAmount = PtomOrderCreditGroup::where('order_header_id', $orderid->order_header_id)->whereNotIn('order_header_id', $order_id)->where('credit_group_code', $pp->credit_group_code)->whereNotIn('credit_group_code', $group_id)->where('order_line_id', '0')->sum('amount');
                        } else {
                            $getTotalAmount = PtomOrderCreditGroup::where('order_header_id', $orderid->order_header_id)->where('credit_group_code', $pp->credit_group_code)->where('order_line_id', '0')->sum('amount');
                        }

                        if (!in_array($orderid->order_header_id, $order_id)) {
                            array_push($order_id, $orderid->order_header_id);

                            $total_with_vat = $payments->total_amount_with_vat - $getTotalAmount;
                            if ($total_with_vat < 0) {
                                $twv += 0;
                            } else {
                                $twv += $total_with_vat;
                            }

                            $total_payment_amount = $payments->total_payment_amount - $sum_payment_amount;
                            if ($total_payment_amount < 0) {
                                $tpa += 0;
                            } else {
                                $tpa += $total_payment_amount;
                            }

                            PaymentHeader::where('payment_header_id', $pp->payment_header_id)->update(['last_updated_by' => $user_id, 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'), 'total_amount_with_vat' => $twv, 'total_payment_amount' => $tpa]);
                        } else {
                            $twv += 0;
                            $tpa += 0;
                        }

                        if (!in_array($pp->credit_group_code, $group_id)) {
                            array_push($group_id, $pp->credit_group_code);
                        }

                        $checkdcn = PaymentApply::where('payment_match_id', $pp->payment_match_id)->first();
                        if (!empty($checkdcn)) {
                            $paymentdcn = DB::select("SELECT PTOM_PAYMENT_APPLY_CNDN.INVOICE_AMOUNT INVOICE_AMOUNT FROM PTOM_PAYMENT_APPLY_CNDN LEFT JOIN PTOM_INVOICE_HEADERS ON PTOM_PAYMENT_APPLY_CNDN.INVOICE_HEADER_ID = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID WHERE PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID = '" . $pp->payment_match_id . "' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE != 'DN'");
                            if (!empty($paymentdcn)) {
                                $notdn = $paymentdcn[0]->invoice_amount;
                            } else {
                                $notdn = 0;
                            }
                        } else {
                            $notdn = 0;
                        }

                        $sum_payment_amount += $pp->payment_amount + $notdn;

                        $pp->match_flag = 'N';
                        $pp->last_updated_by = $user_id;
                        $pp->last_update_date = Carbon::now()->timezone('Asia/Bangkok');
                        $pp->save();
                    }

                    $ccgm = CustomerContractGroupModel::where('customer_id', $payments->customer_id)->where('credit_group_code', $pp->credit_group_code)->whereNull('deleted_at')->first();
                    if (!empty($ccgm)) {
                        $ramount_ccgm = $ccgm->remaining_amount;
                        $remaining_amount = (new OrderEcomController)->reCalculateRemainingAmountVal($payments->customer_id);
                               
                        $ccgm->remaining_amount = !empty($remaining_amount[$pp->credit_group_code]) ? $remaining_amount[$pp->credit_group_code] : 0;
                        // $ccgm->remaining_amount = $ramount_ccgm - $pp->payment_amount;
                        $ccgm->save();
                    }
                }
            }
            // end Unmatching
        } else {
            if (strpos($request->sa_number_for, 'DN') !== false) {
                $orderssss = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
            } else {
                if (strpos($request->sa_number_for, 'F') !== false) {
                    $orderssss = ConsignmentHeader::where('consignment_no', $request->sa_number_for)->first();
                    // $orderssss = OrderHeaders::find($f->order_header_id);
                } else {
                    $orderssss = OrderHeaders::where('prepare_order_number', $request->sa_number_for)->orWhere('pick_release_no', $request->sa_number_for)->first();
                }
            }

            if (!empty($orderssss)) {
                if (strpos($request->sa_number_for, 'DN') !== false) {
                    if ($request->credit_save == '*') {
                        $payment_amounts = PaymentMatchInvoice::where(function ($q) use ($orderssss) {
                            $q->where('invoice_number', $orderssss->invoice_headers_number);
                            $q->orWhere('invoice_id', $orderssss->invoice_headers_id);
                        })->where('match_flag', 'Y')->get();
                    } else {
                        $payment_amounts = PaymentMatchInvoice::where(function ($q) use ($orderssss) {
                            $q->where('invoice_number', $orderssss->invoice_headers_number);
                            $q->orWhere('invoice_id', $orderssss->invoice_headers_id);
                        })->where('match_flag', 'Y')->where('credit_group_code', $request->credit_save)->get();
                    }
                } else {
                    if (strpos($request->sa_number_for, 'F') !== false) {
                        if ($request->credit_save == '*') {
                            $payment_amounts = PaymentMatchInvoice::where('invoice_number', '=', $orderssss->consignment_no)->where('match_flag', 'Y')->get();
                        } else {
                            $payment_amounts = PaymentMatchInvoice::where('invoice_number', '=', $orderssss->consignment_no)->where('match_flag', 'Y')->where('credit_group_code', $request->credit_save)->get();
                        }
                    } else {
                        if ($request->credit_save == '*') {
                            $payment_amounts = PaymentMatchInvoice::where('prepare_order_number', '=', $orderssss->prepare_order_number)->where('match_flag', 'Y')->get();
                        } else {
                            $payment_amounts = PaymentMatchInvoice::where('prepare_order_number', '=', $orderssss->prepare_order_number)->where('match_flag', 'Y')->where('credit_group_code', $request->credit_save)->get();
                        }
                    }
                }

                $sum_payment_amount = 0;
                $document_id = [];
                $order_id = [];
                $group_id = [];
                $payments_id = [];
                foreach ($payment_amounts as $pp) {
                    $payments = PaymentHeader::where('payment_header_id', $pp->payment_header_id)->first();
                    if (!in_array($pp->payment_header_id, $payments_id)) {
                        array_push($payments_id, $pp->payment_header_id);
                    }

                    if (strpos($request->sa_number_for, 'DN') !== false) {
                        $orderid = DB::select("SELECT DOCUMENT_ID,INVOICE_AMOUNT FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_NUMBER = '" . $request->sa_number_for . "'");
                        if (!in_array($orderid[0]->document_id, $document_id)) {
                            array_push($document_id, $orderid[0]->document_id);
                        }

                        $checkdcn = PaymentApply::where('payment_match_id', $pp->payment_match_id)->first();
                        if (!empty($checkdcn)) {
                            $paymentdcn = DB::select("SELECT PTOM_PAYMENT_APPLY_CNDN.INVOICE_AMOUNT INVOICE_AMOUNT FROM PTOM_PAYMENT_APPLY_CNDN LEFT JOIN PTOM_INVOICE_HEADERS ON PTOM_PAYMENT_APPLY_CNDN.INVOICE_HEADER_ID = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID WHERE PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID = '" . $pp->payment_match_id . "' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN'");
                            if (!empty($paymentdcn)) {
                                $notdn = $paymentdcn[0]->invoice_amount;
                            } else {
                                $notdn = 0;
                            }
                        } else {
                            $notdn = 0;
                        }

                        $sum_payment_amount += $pp->payment_amount + $notdn;

                        $pp->match_flag = 'N';
                        $pp->last_updated_by = $user_id;
                        $pp->last_update_date = Carbon::now()->timezone('Asia/Bangkok');
                        $pp->save();
                    } else {
                        if (strpos($request->sa_number_for, 'F') !== false) {
                            if (!in_array($request->sa_number_for, $order_id)) {
                                array_push($order_id, $request->sa_number_for);
                            }
                            if (!in_array($pp->credit_group_code, $group_id)) {
                                array_push($group_id, $pp->credit_group_code);
                            }
                        } else {
                            $orderid = OrderHeader::where('prepare_order_number', $pp->prepare_order_number)->first();

                            if (!in_array($orderid->order_header_id, $order_id)) {
                                array_push($order_id, $orderid->order_header_id);
                            }

                            if (!in_array($pp->credit_group_code, $group_id)) {
                                array_push($group_id, $pp->credit_group_code);
                            }
                        }
                        $checkdcn = PaymentApply::where('payment_match_id', $pp->payment_match_id)->first();
                        if (!empty($checkdcn)) {
                            $paymentdcn = DB::select("SELECT PTOM_PAYMENT_APPLY_CNDN.INVOICE_AMOUNT INVOICE_AMOUNT FROM PTOM_PAYMENT_APPLY_CNDN LEFT JOIN PTOM_INVOICE_HEADERS ON PTOM_PAYMENT_APPLY_CNDN.INVOICE_HEADER_ID = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID WHERE PTOM_PAYMENT_APPLY_CNDN.PAYMENT_MATCH_ID = '" . $pp->payment_match_id . "' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE != 'DN'");
                            if (!empty($paymentdcn)) {
                                $notdn = $paymentdcn[0]->invoice_amount;
                            } else {
                                $notdn = 0;
                            }
                        } else {
                            $notdn = 0;
                        }

                        $sum_payment_amount += $pp->payment_amount + $notdn;

                        $pp->match_flag = 'N';
                        $pp->last_updated_by = $user_id;
                        $pp->last_update_date = Carbon::now()->timezone('Asia/Bangkok');
                        $pp->save();
                    }

                    $ccgm = CustomerContractGroupModel::where('customer_id', $payments->customer_id)->where('credit_group_code', $pp->credit_group_code)->whereNull('deleted_at')->first();
                    if (!empty($ccgm)) {
                        $ramount_ccgm = $ccgm->remaining_amount;
                        $remaining_amount = (new OrderEcomController)->reCalculateRemainingAmountVal($payments->customer_id);
                               
                        $ccgm->remaining_amount = !empty($remaining_amount[$pp->credit_group_code]) ? $remaining_amount[$pp->credit_group_code] : 0;
                        // $ccgm->remaining_amount = $ramount_ccgm - $pp->payment_amount;
                        $ccgm->save();
                    }

                    if (strpos($request->sa_number_for, 'DN') !== false) {
                        $getTotalAmounts = DB::select("SELECT INVOICE_AMOUNT FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_NUMBER = '" . $request->sa_number_for . "'");
                        $getTotalAmount = $getTotalAmounts[0]->invoice_amount;
                    } else {
                        if (strpos($request->sa_number_for, 'F') !== false) {
                            $getTotalAmount = ConsignmentHeader::whereIn('consignment_no', $order_id)->sum('total_include_vat');
                        } else {
                            $getTotalAmount = PtomOrderCreditGroup::whereIn('order_header_id', $order_id)->whereIn('credit_group_code', $group_id)->where('order_line_id', '0')->sum('amount');
                        }
                    }


                    $paymentsss = PaymentHeader::where('payment_header_id', $pp->payment_header_id)->sum('total_amount_with_vat');
                    if ($paymentsss == 0 && empty($payment_amounts)) {
                        $total_with_vat = $getTotalAmount;
                    } else {
                        $total_with_vat = $paymentsss - $getTotalAmount;
                    }

                    if ($total_with_vat < 0) {
                        $twv = 0;
                    } else {
                        $twv = $total_with_vat;
                    }

                    $paymentssss = PaymentHeader::where('payment_header_id', $pp->payment_header_id)->sum('total_payment_amount');
                    if ($paymentssss == 0 && empty($payment_amounts)) {
                        $total_payment_amount = $getTotalAmount;
                    } else {
                        $total_payment_amount = $paymentssss - $sum_payment_amount;
                    }

                    if ($total_payment_amount < 0) {
                        $tpa = 0;
                    } else {
                        $tpa = $total_payment_amount;
                    }

                    PaymentHeader::where('payment_header_id', $pp->payment_header_id)->update(['last_updated_by' => $user_id, 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'), 'total_amount_with_vat' => $twv, 'total_payment_amount' => $tpa]);
                }
            }
        }

        return redirect()->to('/om/domestic-matching?number_ref=' . $request->sa_number_for . '&customer_ref=' . $request->cust_ref . '&date_ref=' . $request->data_date . '&date_ref1=' . $request->data_date1 . '&credit_ref=' . $request->credit_save)->with('success', 'บันทึกเรียบร้อยแล้ว');
    }

    public function download($id)
    {
        $attachment = AttachFiles::find($id);

        $path = public_path() . '//' . $attachment->path_name;

        if (file_exists($path)) {
            return response()->download($path);
        }
    }
}
