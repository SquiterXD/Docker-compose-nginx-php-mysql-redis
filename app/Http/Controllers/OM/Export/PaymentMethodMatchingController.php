<?php

namespace App\Http\Controllers\OM\Export;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\AttachFiles;
use App\Models\OM\CreditNote\CustomerContractGroupModel;
use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\DomesticMatching\InvoiceHeaders;
use App\Models\OM\DomesticMatching\OrderHeaders;
use App\Models\OM\DomesticMatching\PaymentApply;
use App\Models\OM\DomesticMatching\PaymentHeaders;
use App\Models\OM\DomesticMatching\PaymentMatchInvoice;
use App\Models\OM\Invoice;
use App\Models\OM\InvoiceHeaders as OMInvoiceHeaders;
use App\Models\OM\PaymentHeader;
use App\Models\OM\PaymentLines;
use App\Models\OM\PtomInvoiceHeader;
use App\Models\OM\PtomOrderCreditGroup;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDO;
use FormatDate;
use App\Models\OM\OverdueDebt\PaymentApplyCNDN;
use App\Models\OM\OverdueDebt\ProformaInvoiceHeaders;
use App\Models\OM\SaleConfirmation\ProformaInvoiceLots;

class PaymentMethodMatchingController extends Controller
{
    public function index()
    {
        $customers = Customers::whereRaw("UPPER(sales_classification_code) = 'EXPORT'")->orderBy('customer_number', 'ASC')->get(['customer_id', 'customer_number', 'customer_name', 'sales_classification_code', 'address_line1', 'address_line2', 'address_line3', 'city', 'district', 'alley', 'province_name', 'state', 'country_code']);
        $paymentCnDn = [];

        $orders = DB::select("SELECT PTOM_ORDER_HEADERS.payment_type_code,PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER, PTOM_ORDER_HEADERS.GRAND_TOTAL,PTOM_ORDER_HEADERS.ORDER_DATE,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_CUSTOMERS.CUSTOMER_TYPE_ID,PTOM_CUSTOMERS.CUSTOMER_ID,PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE FROM PTOM_ORDER_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE PTOM_ORDER_HEADERS.SA_STATUS = 'Confirm' AND PTOM_ORDER_HEADERS.SALE_CONFIRM_FLAG = 'Y' ORDER BY PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER DESC");

        $dninvoices = [];
        $sqldn = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_CUSTOMERS.CUSTOMER_NAME FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.PROGRAM_CODE = 'OMP0076' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN' AND PTOM_INVOICE_HEADERS.DELETED_AT IS NULL ORDER BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER DESC");
        foreach ($sqldn as $dn) {
            $datas['text'] = $dn->invoice_headers_number . ':' . $dn->customer_name;
            $datas['value'] = $dn->invoice_headers_number;
            $datas['date'] = $dn->invoice_date;

            array_push($dninvoices, $datas);
        }

        $invoices = [];
        $sqlinvoice = DB::select("SELECT PTOM_PROFORMA_INVOICE_HEADERS.PI_HEADER_ID,PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO,PTOM_PROFORMA_INVOICE_HEADERS.ORDER_DATE, PTOM_CUSTOMERS.CUSTOMER_NAME FROM PTOM_PROFORMA_INVOICE_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_PROFORMA_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE PTOM_PROFORMA_INVOICE_HEADERS.ORDER_STATUS = 'Confirm' AND PTOM_PROFORMA_INVOICE_HEADERS.DELETED_AT IS NULL AND PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO IS NOT NULL ORDER BY PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO DESC");
        foreach ($sqlinvoice as $in) {
            $datas['text'] = $in->pick_release_no . ':' . $in->customer_name;
            $datas['value'] = $in->pick_release_no;
            $datas['date'] = $in->order_date;

            array_push($invoices, $datas);
        }

        if (request()->all()) {
            $request = request()->all();
            $order =collect($orders)->where('prepare_order_number', $request['number_ref'])->first();

            if (strpos($request['number_ref'], 'DN') !== false) {
                $customer = Customer::join('ptom_order_headers', 'ptom_customers.customer_id', 'ptom_order_headers.customer_id', 'left')->join('ptom_invoice_headers', 'ptom_customers.customer_id', 'ptom_invoice_headers.customer_id', 'left')->where(function ($q) use ($request) {
                    $q->where('ptom_customers.customer_number', $request['customer_ref']);
                    $q->orWhere('ptom_order_headers.prepare_order_number', $request['number_ref']);
                    $q->orWhere('ptom_invoice_headers.invoice_headers_number', $request['number_ref']);
                })->first(['ptom_customers.customer_id']);
            } else {
                if (strpos($request['number_ref'], 'IV') !== false) {
                    $customer = Customer::join('ptom_proforma_invoice_headers', 'ptom_customers.customer_id', 'ptom_proforma_invoice_headers.customer_id', 'left')->where(function ($q) use ($request) {
                        $q->where('ptom_customers.customer_number', $request['customer_ref']);
                        $q->orWhere('ptom_proforma_invoice_headers.pick_release_no', $request['number_ref']);
                    })->first(['ptom_customers.customer_id']);
                } else {
                    $customer = Customer::join('ptom_order_headers', 'ptom_customers.customer_id', 'ptom_order_headers.customer_id', 'left')->where(function ($q) use ($request) {
                        $q->where('ptom_customers.customer_number', $request['customer_ref']);
                        $q->orWhere('ptom_order_headers.prepare_order_number', $request['number_ref']);
                    })->first(['ptom_customers.customer_id']);
                }
            }

            if (empty($customer)) {
                request()->session()->flashInput($request);
                return back()->withErrors('ข้อมูลลูกค้าไม่ถูกต้อง');
            }
            request()->session()->flashInput($request);

            $payments = PaymentMatchInvoice::leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id')
            ->where('ptom_payment_headers.customer_id', $customer->customer_id)
            // ->havingRaw('SUM(ptom_payment_match_invoices.payment_amount) - SUM((select sum(payment_amount) from ptom_payment_details where ptom_payment_details.payment_header_id = ptom_payment_headers.payment_header_id))  > 0')
            ->groupBy(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', 'ptom_payment_headers.payment_date', 'ptom_payment_match_invoices.currency'])
            ->get(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', 'ptom_payment_headers.payment_date', DB::raw("SUM(ptom_payment_match_invoices.payment_amount) payment_amount"), 'ptom_payment_match_invoices.currency']);
            $invoicess = InvoiceHeaders::where('customer_id', '=', $customer->customer_id)->where('invoice_type', '=', 'DN')->get(['invoice_headers_id', 'invoice_headers_number', 'invoice_date', 'invoice_amount', 'currency']);
            if (strpos($request['number_ref'], 'DN') !== false) {
                $datapayment = PaymentMatchInvoice::with(['customers', 'invoices'])->where(function ($w) use ($request) {
                    $w->where('ptom_payment_match_invoices.invoice_number', '=', $request['number_ref']);
                })->leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', '=', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_match_invoices.match_flag', '=', 'Y')->groupBy(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', 'ptom_payment_match_invoices.currency', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD')")])->get(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', DB::raw("SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT"), 'ptom_payment_match_invoices.currency', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD') CREATION_DATE")]);
            } else {
                $datapayment = PaymentMatchInvoice::with(['customers', 'invoices'])->where(function ($w) use ($request) {
                    $w->where('ptom_payment_match_invoices.prepare_order_number', '=', $request['number_ref']);
                    if (is_numeric($request['number_ref'])) {
                        $w->orWhere('ptom_payment_match_invoices.invoice_id', '=', $request['number_ref']);
                    }
                    $w->orWhere('ptom_payment_match_invoices.invoice_number', $request['number_ref']);
                })->leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', '=', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_match_invoices.match_flag', '=', 'Y')->groupBy(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', 'ptom_payment_match_invoices.currency', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD')")])->get(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', DB::raw("SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT"), 'ptom_payment_match_invoices.currency', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD') CREATION_DATE")]);
            }

            if (strpos($request['number_ref'], 'DN') !== false) {
                $orderw = PtomInvoiceHeader::where('invoice_headers_number', $request['number_ref'])->first();
                $files = AttachFiles::where('header_id', $orderw->document_id)->where('attachment_program_code', 'OMP0068')->get();
            } else {
                if (strpos($request['number_ref'], 'IV') !== false) {
                    $orderID = ProformaInvoiceHeaders::where('pick_release_no', $request['number_ref'])->first();
                } else {
                    $orderID = OrderHeader::where('prepare_order_number', $request['number_ref'])->first();
                }
                $files = AttachFiles::where('header_id', $orderID->order_header_id)->where('attachment_program_code', 'OMP0068')->get();
            }
            if($order->payment_type_code == 10) {
                $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT  FROM ptom_payment_match_invoices WHERE prepare_order_number = '{$order->prepare_order_number}' AND match_flag ='Y'");
            } else {
                if (strpos($request['number_ref'], 'DN') !== false) {
                    $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . request()->number_ref . "'");
                } else {
                    $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND (PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER = '" . request()->number_ref . "' OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . request()->number_ref . "')");
                }
            }
            
            $p = $payment[0]->payment_amount == null ? 0 : $payment[0]->payment_amount;


            $searchomp0068 = true;

            if (strpos($request['number_ref'], 'DN') !== false) {
                $cus = DB::select("SELECT CUSTOMER_ID,DOCUMENT_ID,INVOICE_DATE FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_NUMBER = '" . $request['number_ref'] . "'");
                $customerinfo = Customer::find($cus[0]->customer_id);
                $order_header_id = $cus[0]->document_id ?? '';
                $order_date_invoice = $cus[0]->invoice_date ?? '';
            } else {
                if (strpos($request['number_ref'], 'IV') !== false) {
                    $cus = DB::select("SELECT CUSTOMER_ID,ORDER_HEADER_ID,ORDER_DATE FROM PTOM_PROFORMA_INVOICE_HEADERS WHERE PICK_RELEASE_NO = '" . $request['number_ref'] . "'");
                } else {
                    $cus = DB::select("SELECT CUSTOMER_ID,ORDER_HEADER_ID,ORDER_DATE FROM PTOM_ORDER_HEADERS WHERE PREPARE_ORDER_NUMBER = '" . $request['number_ref'] . "'");
                }

                $customerinfo = Customer::find($cus[0]->customer_id);
                $order_header_id = $cus[0]->order_header_id ?? '';
                $order_date_invoice = $cus[0]->order_date ?? '';
            }

            if (strpos($request['number_ref'], 'DN') !== false) {
                $totalAmountw = PtomInvoiceHeader::where('invoice_headers_number', $request['number_ref'])->first();
                $totalAmount = $totalAmountw->invoice_amount;
            } else {
                if (strpos($request['number_ref'], 'IV') !== false) {
                    $or_header_id = ProformaInvoiceHeaders::where('pick_release_no', $request['number_ref'])->first();
                    // $totalAmounts = PtomOrderCreditGroup::join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->where(function ($q) use ($or_header_id) {
                    //     $q->where('ptom_order_credit_groups.order_header_id', $or_header_id['order_header_id']);
                    // })->where('ptom_order_credit_groups.order_line_id', '!=', '0')->sum('ptom_order_credit_groups.amount');
                    // $totalAmount = abs($totalAmounts - $or_header_id->grand_total);
                    if ($or_header_id->order_header_id != null) {
                        $totalAmount = OrderHeader::find($or_header_id->order_header_id)->grand_total;
                    } else {
                        $totalAmount = $or_header_id->grand_total;
                    }
                } else {
                    // $totalAmount = PtomOrderCreditGroup::join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->where(function ($q) use ($request) {
                    //     $q->where('ptom_order_headers.prepare_order_number', $request['number_ref']);
                    //     $q->orWhere('ptom_order_headers.pick_release_no', $request['number_ref']);
                    // })->where('ptom_order_credit_groups.order_line_id', '!=', '0')->sum('ptom_order_credit_groups.amount');
                    $or_header_id = ProformaInvoiceHeaders::where('sa_number', $request['number_ref'])->first();
                    if($order->payment_type_code == 10) {
                        $totalAmount = $order->grand_total;
                    } else {
                        if (optional($or_header_id)->order_header_id != null) {
                            $totalAmount = OrderHeader::find($or_header_id->order_header_id)->grand_total;
                        } else {
                            $totalAmount = optional($or_header_id)->grand_total;
                        }
                    }
                    
                }
            }

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
                if (strpos($request['number_ref'], 'IV') !== false) {
                    $or_header_id2 = ProformaInvoiceHeaders::where('pick_release_no', $request['number_ref'])->first();
                } else {
                    $or_header_id2 = ProformaInvoiceHeaders::where('sa_number', $request['number_ref'])->first();
                }

                $cns = PaymentApplyCNDN::where(function ($q) use ($request, $or_header_id2) {
                    $q->where('pick_release_no', $request['number_ref']);
                    if(!empty($or_header_id2)){
                        $q->orWhere('order_header_id', $or_header_id2->order_header_id);
                    }
                })->where('attribute1', 'Y')->get();
            }

            if (!empty($cns)) {
                $sumcns = 0;
                foreach ($cns as $scn) {
                    $sumcns += $scn->invoice_amount;
                }

                $p = $p + $sumcns;
            }
            $paymentCnDn = PaymentApplyCNDN::where('ptom_payment_apply_cndn.attribute3', $request['number_ref'])
            ->leftJoin('ptom_invoice_headers', 'ptom_payment_apply_cndn.invoice_header_id', '=', 'ptom_invoice_headers.invoice_headers_id')
            ->get();
            if (!empty($paymentCnDn)) {
                $sumpaymentCnDn = 0;
                foreach ($paymentCnDn as $scn) {
                    $sumpaymentCnDn += $scn->invoice_amount;
                }

                $p = $p + $sumpaymentCnDn;
            }
            
        } else {
            $payments = [];
            $invoicess = [];
            $datapayment = [];
            $searchomp0068 = false;
            $p = 0;
            $customerinfo = [];
            $order_header_id = '';
            $files = [];
            $totalAmount = 0;
            $order_date_invoice = '';
            $cns = [];
        }
        return view('om.exports.paymentMatching.index', compact('orders','paymentCnDn', 'invoices', 'payments', 'invoicess', 'datapayment', 'customers', 'searchomp0068', 'p', 'customerinfo', 'order_header_id', 'files', 'dninvoices', 'order_date_invoice', 'totalAmount', 'cns'));
    }

    public function getinvoice(Request $request)
    {
        $invoices = [];
        $html = '<option></option>';
        $customer = Customer::where('customer_number', '=', $request->customer_number)->first(['customer_id']);
        if (empty($customer)) {
            return response()->json(['data' => '']);
        }

        $orders = DB::select("SELECT PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,PTOM_ORDER_HEADERS.ORDER_DATE,PTOM_ORDER_HEADERS.PICK_RELEASE_NO,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_CUSTOMERS.CUSTOMER_TYPE_ID,PTOM_CUSTOMERS.CUSTOMER_ID,PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE FROM PTOM_ORDER_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE (PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER IS NOT NULL OR PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL) AND PTOM_ORDER_HEADERS.CUSTOMER_ID = '$customer->customer_id' ORDER BY PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER DESC");

        $dninvoices = [];
        $sqldn = DB::select("SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_ID,PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER,PTOM_INVOICE_HEADERS.INVOICE_DATE,PTOM_INVOICE_HEADERS.INVOICE_AMOUNT,PTOM_CUSTOMERS.CUSTOMER_NAME FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE PTOM_INVOICE_HEADERS.INVOICE_STATUS = 'Confirm' AND PTOM_INVOICE_HEADERS.PROGRAM_CODE = 'OMP0076' AND PTOM_INVOICE_HEADERS.INVOICE_TYPE = 'DN' AND PTOM_INVOICE_HEADERS.DELETED_AT IS NULL AND PTOM_INVOICE_HEADERS.DOCUMENT_ID IS NOT NULL AND PTOM_INVOICE_HEADERS.CUSTOMER_ID = '$customer->customer_id' ORDER BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER DESC");
        foreach ($sqldn as $dn) {
            $datas['text'] = $dn->invoice_headers_number . ':' . $dn->customer_name;
            $datas['value'] = $dn->invoice_headers_number;
            $datas['date'] = $dn->invoice_date;

            array_push($dninvoices, $datas);
        }

        foreach ($orders as $order) {
            if (strpos($order->prepare_order_number, 'SA') !== false) {
                $l1 = 'value="' . $order->prepare_order_number . '"';
                if ($order->prepare_order_number != null) {
                    $l2 = ':';
                } else {
                    $l2 = '';
                }
                $html .= '<option ' . $l1 . '>' . $order->prepare_order_number . ' : ' . $order->customer_name . '</option>';
            }
        }

        $invoices = [];
        $sqlinvoice = DB::select("SELECT PTOM_PROFORMA_INVOICE_HEADERS.PI_HEADER_ID,PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO,PTOM_PROFORMA_INVOICE_HEADERS.ORDER_DATE, PTOM_CUSTOMERS.CUSTOMER_NAME FROM PTOM_PROFORMA_INVOICE_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_PROFORMA_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE PTOM_PROFORMA_INVOICE_HEADERS.ORDER_STATUS = 'Confirm' AND PTOM_PROFORMA_INVOICE_HEADERS.DELETED_AT IS NULL AND PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO IS NOT NULL AND PTOM_PROFORMA_INVOICE_HEADERS.CUSTOMER_ID = '$customer->customer_id' ORDER BY PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO DESC");
        foreach ($sqlinvoice as $in) {
            $datas['text'] = $in->pick_release_no . ':' . $in->customer_name;
            $datas['value'] = $in->pick_release_no;
            $datas['date'] = $in->order_date;

            array_push($invoices, $datas);
        }

        foreach ($invoices as $in) {
            $html .= '<option value="' . $in['value'] . '">' . $in['text'] . '</option>';
        }

        foreach ($dninvoices as $dninvoice) {
            $html .= '<option value="' . $dninvoice['value'] . '">' . $dninvoice['text'] . '</option>';
        }

        return response()->json(['data' => $html]);
    }

    public function getamount(Request $request)
    {
        $customer = Customer::where('customer_number', '=', $request->customer_ref)->first(['customer_id']);

        if (strpos($request->sa_number, 'DN') !== false) {
            $order = DB::select("SELECT CUSTOMER_ID,INVOICE_HEADERS_ID,DOCUMENT_ID FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_NUMBER = '" . $request->sa_number . "'");
            $headers_id = $order[0]->document_id;

            $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND (PTOM_PAYMENT_MATCH_INVOICES.INVOICE_ID = '" . $order[0]->invoice_headers_id . "' OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . $request->sa_number . "')");

            $p = $payment[0]->payment_amount == null ? 0 : $payment[0]->payment_amount;
        } else {
            if (strpos($request->sa_number, 'IV') !== false) {
                $order = ProformaInvoiceHeaders::where('pick_release_no', $request['number_ref'])->first();
                $headers_id = $order->order_header_id;

                $payments = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND (PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER = '" . $order->prepare_order_number . "' OR PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER = '" . $request->sa_number . "')");
                $p = $payments[0]->payment_amount == null ? 0 : $payments[0]->payment_amount;
            } else {
                $order = OrderHeader::where('prepare_order_number', $request->sa_number)->first();
                $headers_id = $order->order_header_id;

                $payment = DB::select("SELECT SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT FROM PTOM_PAYMENT_MATCH_INVOICES LEFT JOIN PTOM_PAYMENT_HEADERS ON PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID WHERE PTOM_PAYMENT_HEADERS.CUSTOMER_ID = '" . $customer->customer_id . "' AND PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' AND PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER = '" . $order->prepare_order_number . "'");

                $p = $payment[0]->payment_amount == null ? 0 : $payment[0]->payment_amount;
            }
        }


        if (strpos($request->sa_number, 'DN') !== false) {
            $totalAmountw = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number)->sum('invoice_amount');
            $totalAmount = $totalAmountw;
        } else {
            if (strpos($request->sa_number, 'IV') !== false) {
                // $or_header_id = ProformaInvoiceHeaders::where('pick_release_no', $request->sa_number)->first();
                // $totalAmounts = PtomOrderCreditGroup::join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->where(function ($q) use ($or_header_id) {
                //     $q->where('ptom_order_credit_groups.order_header_id', $or_header_id['order_header_id']);
                // })->where('ptom_order_credit_groups.order_line_id', '!=', '0')->sum('ptom_order_credit_groups.amount');
                // $totalAmount = abs($totalAmounts - $or_header_id->grand_total);
                $or_header_id = ProformaInvoiceHeaders::where('pick_release_no', $request['number_ref'])->first();
                $totalAmount = $or_header_id->grand_total;
            } else {
                // $totalAmount = PtomOrderCreditGroup::join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->where(function ($q) use ($request) {
                //     $q->where('ptom_order_headers.prepare_order_number', $request->sa_number);
                // })->where('ptom_order_credit_groups.order_line_id', '!=', '0')->sum('ptom_order_credit_groups.amount');
                $or_header_id = ProformaInvoiceHeaders::where('sa_number', $request['number_ref'])->first();
                $totalAmount = $or_header_id->grand_total;
            }
        }

        $html = '';

        $t = 0;
        $numberkey = 0;
        if ($request->search) {
            if (strpos($request->sa_number, 'DN') !== false) {
                $datapayment = PaymentMatchInvoice::with(['customers', 'invoices'])->where(function ($w) use ($request) {
                    $w->where('ptom_payment_match_invoices.invoice_number', '=', $request['sa_number']);
                })->leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', '=', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_match_invoices.match_flag', '=', 'Y')->groupBy(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', 'ptom_payment_match_invoices.currency', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD')")])->get(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', DB::raw("SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT"), 'ptom_payment_match_invoices.currency', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD') CREATION_DATE")]);

                if (!empty($datapayment)) {
                    foreach ($datapayment as $key => $match) {
                        $numberkey++;
                        $t += $match->payment_amount;
                        $html .= '<tr class="align-middle"><input type="hidden" value="draft" name="payment_type[]">';
                        $html .= '<td>' . $numberkey . '</td>';
                        $html .= '<td><div class="input-icon"><input type="text" class="form-control md text-center" name="payment_number[]" placeholder="" value="' . $match->payment_number . '" readonly><i class="fa fa-search"></i></div></td>';
                        $html .= '<td>' . FormatDate::DateThaiNumericWithSplash($match->creation_date) . '<input type="hidden" name="date_matching_ref[]" value="' . $match->creation_date . '"></td>';
                        $html .= '<td class="text-center">' . $match->currency . '</td>';
                        $html .= '<td><input type="text" class="form-control md text-right" name="exchangerate[]" value="' . number_format($match->rate->conversion_rate ?? 0, 2) . '" readonly></td>';
                        $html .= '<td><input type="text" class="form-control md text-right" name="payment_amounts[]" placeholder="" value="' . number_format($match->payment_amount, 2) . '" readonly><input type="hidden" name="payment_amount[]" value="' . number_format($match->payment_amount, 2) . '"><input type="hidden" name="type_payment_match[]" value="old"></td>';
                        $html .= '<td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td>';
                    }
                }
            } else {
                if (strpos($request->sa_number, 'IV') !== false) {
                    $datapayment = PaymentMatchInvoice::with(['customers', 'invoices'])->where(function ($w) use ($request) {
                        $w->where('ptom_payment_match_invoices.invoice_number', '=', $request['sa_number']);
                    })->leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', '=', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_match_invoices.match_flag', '=', 'Y')->groupBy(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', 'ptom_payment_match_invoices.currency', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD')")])->get(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', DB::raw("SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT"), 'ptom_payment_match_invoices.currency', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD') CREATION_DATE")]);
                } else {
                    $datapayment = PaymentMatchInvoice::with(['customers', 'invoices'])->where(function ($w) use ($request) {
                        $w->where('ptom_payment_match_invoices.prepare_order_number', '=', $request['sa_number']);
                        if (is_numeric($request['sa_number'])) {
                            $w->orWhere('ptom_payment_match_invoices.invoice_id', '=', $request['sa_number']);
                        }
                    })->leftJoin('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', '=', 'ptom_payment_headers.payment_header_id')->where('ptom_payment_match_invoices.match_flag', '=', 'Y')->groupBy(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', 'ptom_payment_match_invoices.currency', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD')")])->get(['ptom_payment_headers.payment_header_id', 'ptom_payment_headers.payment_number', DB::raw("SUM(PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_AMOUNT) PAYMENT_AMOUNT"), 'ptom_payment_match_invoices.currency', DB::raw("TO_CHAR(PTOM_PAYMENT_MATCH_INVOICES.CREATION_DATE,'YYYY-MM-DD') CREATION_DATE")]);
                }

                if (!empty($datapayment)) {
                    foreach ($datapayment as $key => $match) {
                        $numberkey++;
                        $t += $match->payment_amount;
                        $html .= '<tr class="align-middle"><input type="hidden" value="draft" name="payment_type[]">';
                        $html .= '<td>' . $numberkey . '</td>';
                        $html .= '<td><div class="input-icon"><input type="text" class="form-control md text-center" name="payment_number[]" placeholder="" value="' . $match->payment_number . '" readonly><i class="fa fa-search"></i></div></td>';
                        $html .= '<td>' . FormatDate::DateThaiNumericWithSplash($match->creation_date) . '<input type="hidden" name="date_matching_ref[]" value="' . $match->creation_date . '"></td>';
                        $html .= '<td class="text-center">' . $match->currency . '</td>';
                        $html .= '<td><input type="text" class="form-control md text-right" name="exchangerate[]" value="' . number_format($match->rate->conversion_rate ?? 0, 2) . '" readonly></td>';
                        $html .= '<td><input type="text" class="form-control md text-right" name="payment_amounts[]" placeholder="" value="' . number_format($match->payment_amount, 2) . '" readonly><input type="hidden" name="payment_amount[]" value="' . number_format($match->payment_amount, 2) . '"><input type="hidden" name="type_payment_match[]" value="old"></td>';
                        $html .= '<td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td>';
                    }
                }
            }

            $countmatchinvoice = [];
            $ptomorder = PaymentMatchInvoice::where('invoice_number', $request['sa_number'])->get(['payment_match_id']);
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
                    $html .= '<td class="text-center">' . getCurrency($cn->invoice_number) . '</td>';
                    $html .= '<td><input type="text" class="form-control md text-right" name="exchangerate[]" value="' . number_format(convertRatetoomp0068($cn->invoice_number) ?? 0, 2) . '" readonly></td>';
                    $html .= '<td><input type="text" readonly class="form-control md text-right" name="payment_amounts[]" placeholder="" value="(' . number_format($cn->invoice_amount, 2) . ')"><input type="hidden" name="payment_amount[]" value="' . number_format($cn->invoice_amount, 2) . '"><input type="hidden" name="type_payment_match[]" value="old"></td>';
                    $html .= '<td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td></tr>';

                    $p += $cn->invoice_amount;
                    $t += $cn->invoice_amount;
                }
            }
        }

        $html .= '<tr class="align-middle"><td class="text-right pt-3 pb-3" colspan="5" id="ignore"><strong class="black">จำนวนเงินรวม</strong></td><td class="text-right pt-3 pb-3" id="total"><strong class="black">' . number_format($t ?? 0, 2) . '</strong></td><td></td></tr>';

        return response()->json(['data' => $p, 'totalAmount' => $totalAmount, 'header_id' => $headers_id, 'html' => json_decode(json_encode($html))]);
    }

    public function unmatching(Request $request)
    {
        $apps = DB::select("SELECT PERIOD_NAME,CLOSING_STATUS FROM APPS.GL_PERIOD_STATUSES WHERE TO_CHAR(START_DATE, 'YYYY-MM-DD') <= '".Carbon::now()->format('Y-m-d')."' AND TO_CHAR(END_DATE, 'YYYY-MM-DD') >= '".Carbon::now()->format('Y-m-d')."' ORDER BY LAST_UPDATE_DATE DESC FETCH FIRST 1 ROWS ONLY");
        if (empty($apps)) {
            return response()->json(['status' => 'error', 'data' => 'ไม่พบข้อมูล APPS.GL_PERIOD_STATUSES'], 200);
        }

        if ($apps[0]->closing_status != 'O') {
            return response()->json(['status' => 'error', 'data' => 'กรุณาเปิด AR period ของ ' . $apps[0]->period_name . ' ก่อน'], 200);
        }

        if (strpos($request->number_ref, 'DN') !== false) {
            $payment = PaymentMatchInvoice::where(function ($w) use ($request) {
                $w->where('invoice_number', '=', $request->number_ref);
            })->where('match_flag', 'Y')->get();
        } else {
            if (strpos($request->number_ref, 'IV') !== false) {
                $payment = PaymentMatchInvoice::where(function ($w) use ($request) {
                    $w->where('invoice_number', '=', $request->number_ref);
                })->where('match_flag', 'Y')->get();
            } else {
                $payment = PaymentMatchInvoice::where(function ($w) use ($request) {
                    $w->where('prepare_order_number', '=', $request->number_ref);
                })->where('match_flag', 'Y')->get();
            }
        }

        $pay = [];
        $pre = [];
        foreach ($payment as $p) {
            if (!in_array($p->payment_match_id, $pay)) {
                array_push($pay, $p->payment_match_id);
            }
            if (!in_array($p->prepare_order_number, $pre) && $p->prepare_order_number != null) {
                array_push($pre, $p->prepare_order_number);
            }


            $pg = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('ptom_payment_match_invoices.payment_match_id', $p->payment_match_id)->first();
            if (!empty($pg)) {
                $customer_id = $pg->customer_id;
                $credit_group_code = $pg->credit_group_code;
                $amount = $pg->payment_amount;

                $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id)->where('credit_group_code', $credit_group_code)->whereNull('deleted_at')->first();
                if (!empty($ccgm)) {
                    $ramount_ccgm = $ccgm->remaining_amount;

                    $ccgm->remaining_amount = $ramount_ccgm - $amount;
                    $ccgm->save();
                }

                PaymentMatchInvoice::find($p->payment_match_id)->update(['match_flag' => 'N', 'last_updated_by' => getDefaultData('/users')->user_id, 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
            }
        }

        $ors = [];

        $or = OrderHeaders::whereIn('prepare_order_number', $pre)->get();
        if (count($or) > 0) {
            foreach ($or as $r) {
                if (!in_array($r->order_header_id, $ors)) {
                    array_push($ors, $r->order_header_id);
                }
            }
        }


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
        PaymentApplyCNDN::whereIn('order_header_id', $ors)->orWhereIn('payment_match_id', $pay)->where('attribute1', 'Y')->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);

        return response()->json(['data' => 'ดำเนินการเรียบร้อยแล้ว'], 200);
    }

    public function uploaded(Request $request)
    {
        $responseUploadFile = array();
        $responseUploadFile['status'] = 200;
        $responseUploadFile['message'] = "";
        $responseUploadFile['attachments'] = [];
        if ($request->hasFile('attachment')) {
            $idTest = 1;
            foreach ($request->file('attachment') as $file) {
                $newfilename = date('YmdHis') . '-upload' . '.' . $file->getClientOriginalExtension();
                $fileInfo = [];
                $program_code = 'OMP0068';
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
                } catch (Exception $e) {
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

    public function getDataFirsttime(Request $request)
    {
        $customer = Customer::where('customer_number', '=', $request->customer_ref)->first(['customer_id', 'currency']);
        $payments = [];

        if ($request->list == null || $request->list == '') {
            $payment = PaymentHeader::where('customer_id', $customer->customer_id)
            ->whereRaw("(select sum(payment_amount) from ptom_payment_details where ptom_payment_details.payment_header_id = ptom_payment_headers.payment_header_id)
            -
            (select sum(payment_amount) from ptom_payment_match_invoices where ptom_payment_match_invoices.payment_header_id = ptom_payment_headers.payment_header_id)
            > 0 ")
            ->where('payment_status', '!=', 'Cancel')
            ->get(['payment_header_id', 'payment_number', 'payment_date']);
        } else {
            $payment = PaymentHeader::where('customer_id', $customer->customer_id)->where('payment_status', '!=', 'Cancel')
            ->whereRaw("(select sum(payment_amount) from ptom_payment_details where ptom_payment_details.payment_header_id = ptom_payment_headers.payment_header_id)
            -
            (select sum(payment_amount) from ptom_payment_match_invoices where ptom_payment_match_invoices.payment_header_id = ptom_payment_headers.payment_header_id)
            > 0 ")
            ->whereNotIn('payment_number', $request->list)
            ->get(['payment_header_id', 'payment_number', 'payment_date']);
        }
        if (!empty($payment)) {
            foreach ($payment as $p) {
                $sumd = PaymentLines::where('payment_header_id', $p->payment_header_id)->sum('conversion_amount');
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
        $in = PaymentApplyCNDN::join('ptom_invoice_headers', 'ptom_payment_apply_cndn.invoice_header_id', 'ptom_invoice_headers.invoice_headers_id', 'left')->where(function ($q) {
            $q->where('ptom_payment_apply_cndn.attribute1', 'N');
            $q->orWhereNull('ptom_payment_apply_cndn.attribute1');
        })->where('ptom_invoice_headers.customer_id', $customer->customer_id)
        ->whereNotNull('ptom_payment_apply_cndn.invoice_number')
        ->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')
        ->orderBy('ptom_payment_apply_cndn.invoice_number', 'DESC')
        ->get(['ptom_invoice_headers.invoice_headers_id', 'ptom_payment_apply_cndn.invoice_number', 'ptom_invoice_headers.invoice_date', 'ptom_payment_apply_cndn.invoice_amount']);
        if (!empty($in)) {
            foreach ($in as $i) {
                $datas['invoice_headers_id'] = $i->invoice_headers_id;
                $datas['invoice_headers_number'] = $i->invoice_number;
                $datas['invoice_date'] = $i->invoice_date;
                $datas['invoice_amount'] = $i->invoice_amount;
                $datas['currency'] = $customer->currency;
                $datas['exchange_rate'] = $i->exchange_rate;

                array_push($invoicess, $datas);
            }
        }

        $invoice = Invoice::query()
        ->where('ptom_invoice_headers.program_code', 'OMP0077')
        ->where('ptom_invoice_headers.invoice_status' ,'Confirm')
        // ->leftJoin('ptom_payment_apply_cndn' ,'ptom_payment_apply_cndn.invoice_number', '=', 'ptom_invoice_headers.invoice_headers_number')
        // ->where('ptom_payment_apply_cndn.attribute1', 'Y')
        ->whereRaw("ptom_invoice_headers.invoice_amount  - nvl((select sum(invoice_amount) from  ptom_payment_apply_cndn where  ptom_payment_apply_cndn.invoice_number = ptom_invoice_headers.invoice_headers_number AND ptom_payment_apply_cndn.attribute1='Y' ), 0) > 0")
        ->get();

        if (!empty($invoice)) {
            foreach ($invoice as $i) {
                $datas['invoice_headers_id'] = $i->invoice_headers_id;
                $datas['invoice_headers_number'] = $i->invoice_headers_number;
                $datas['invoice_date'] = $i->invoice_date;
                $datas['invoice_amount'] = $i->invoice_amount;
                $datas['currency'] = $customer->currency;
                $datas['exchange_rate'] = $i->exchange_rate;

                array_push($invoicess, $datas);
            }
        }
        return response()->json(['payments' => json_decode(json_encode($payments)), 'invoicess' => json_decode(json_encode($invoicess))], 200);
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
                    if ($request->type_payment_match[$key] == 'old') {
                        if (!in_array($payment_number, $cndn_unmatch)) {
                            array_push($cndn_unmatch, $payment_number);
                        }
                    } else {
                        $invoiceHCn = PtomInvoiceHeader::where('invoice_headers_number', $payment_number)->first();

                        $insertCnDn= [
                            // 'order_header_id' => '',
                            // 'pick_release_no' => '',
                            // 'credit_group_code' => '',
                            // 'invoice_number' => '',
                            'invoice_header_id' => '',
                            'invoice_amount' => '',
                            'attribute1' => '',
                            'attribute2' => '',
                            'attribute3' => '',
                            'program_code' => 'OMP0068',
                        ];

                        if (strpos($request->sa_number_for, 'DN') !== false) {
                            $invoiceh = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
                            $orderget = OrderHeaders::join('ptom_proforma_invoice_headers', 'ptom_order_headers.order_header_id', 'ptom_proforma_invoice_headers.order_header_id', 'left')->where(function ($q) use ($invoiceh) {
                                $q->where('ptom_order_headers.pick_release_no', $invoiceh->ref_invoice_number);
                                $q->orWhere('ptom_order_headers.order_header_id', $invoiceh->document_id);
                                $q->orWhere('ptom_proforma_invoice_headers.pick_release_no', $invoiceh->ref_invoice_number);
                            })->first();

                            $pick_release_nos = $invoiceh->ref_invoice_number ?? null;
                            $number_pi = $orderget->order_header_id ?? null;
                            $customer_id = $invoiceh->customer_id;
                            $order_id = $orderget->order_header_id;
                        } else {
                            if (strpos($request->sa_number_for, 'IV') !== false) {
                                $pi = ProformaInvoiceHeaders::where('pick_release_no', $request->sa_number_for)->where('order_status', 'Confirm')->first();
                                $number_pi = $pi->pi_header_id ?? '';
                                $pick_release_nos = $pi->pick_release_no;
                                $customer_id = $pi->customer_id;
                                $order_id = $pi->order_header_id;
                                $insertCnDn['order_header_id'] = optional($pi)->pi_header_id;
                                $insertCnDn['pick_release_no'] = optional($pi)->pick_release_no;
                                $insertCnDn['attribute3'] = $pi->sa_number;
                            } else {
                                $orderget = OrderHeaders::where('prepare_order_number', $request->sa_number_for)->orWhere('pick_release_no', $request->sa_number_for)->first();
                                $pi = ProformaInvoiceHeaders::where('order_header_id', $orderget->order_header_id)
                                ->where('sa_number', $request->sa_number_for)
                                ->where('order_status', 'Confirm')
                                ->first();
                                $number_pi = $pi->pi_header_id ?? '';
                                $pick_release_nos = $orderget->pick_release_no;
                                $customer_id = $orderget->customer_id;
                                $order_id = $orderget->order_header_id;
                                $insertCnDn['order_header_id'] = optional($orderget)->order_header_id;
                                $insertCnDn['pick_release_no'] ='';
                                $insertCnDn['attribute3'] = $orderget->prepare_order_number;
                            }
                        }

                        if(strpos($payment_number, 'CN') !== false) {
                            $insertCnDn['invoice_number'] = $invoiceHCn->invoice_headers_number;
                            $insertCnDn['invoice_header_id'] = $invoiceHCn->invoice_headers_id;
                            $insertCnDn['invoice_amount'] = (float)str_replace(',', '',$request->payment_amounts[$key]);
                            $insertCnDn['attribute1'] = 'Y';
                            $insertCnDn['created_by'] = 1;
                            $insertCnDn['last_updated_by'] = 1;
                            $insertCnDn['attribute2'] = $invoiceHCn->invoice_type;
                            PaymentApplyCNDN::insert($insertCnDn);
                        }

                        // $fond = PaymentApply::where('invoice_number', $payment_number)->where(function ($q) {
                        //     $q->where('attribute1', 'N');
                        //     $q->orWhereNull('attribute1');
                        // });
                        // if ($fond->count() > 0) {
                        //     // dd(1);
                        //     //update
                        //     $f = $fond->first();

                        //     $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id)->where('credit_group_code', '0')->whereNull('deleted_at')->first();
                        //     if (!empty($ccgm)) {
                        //         $ramount_ccgm = $ccgm->remaining_amount;

                        //         // $ccgm->remaining_amount = $ramount_ccgm + $f->invoice_amount;
                        //         $ccgm->remaining_amount = $ramount_ccgm + $request->payment_amounts[$key];
                        //         $ccgm->save();
                        //     }

                        //     if (str_replace(',', '', $request->payment_amounts[$key]) == $f->invoice_amount) {
                        //         // dd(2);
                        //         PaymentApply::find($f->payment_apply_id)->update(['payment_match_id' => null, 'attribute1' => 'Y', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'), 'order_header_id' => $order_id, 'pick_release_no' => $pick_release_nos]);
                        //     } else {
                        //         // dd(3);
                        //         $amount_total_bb = abs(str_replace(',', '', $request->payment_amounts[$key]) - $f->invoice_amount);

                        //         PaymentApply::find($f->payment_apply_id)->update(['payment_match_id' => null, 'attribute1' => 'Y', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'), 'order_header_id' => $order_id, 'pick_release_no' => $pick_release_nos, 'invoice_amount' => str_replace(',', '', $request->payment_amounts[$key])]);

                        //         PaymentApply::create([
                        //             'invoice_number' => $f->invoice_number,
                        //             'invoice_header_id' => $f->invoice_header_id,
                        //             'invoice_amount' => $amount_total_bb,
                        //             'attribute2' => $f->attribute2,
                        //             'program_code' => 'OMP0025',
                        //             'created_by' => $user_id,
                        //             'last_updated_by' => $user_id,
                        //         ]);
                        //     }
                        // } else {
                        //     $kaaa++;
                        //     PaymentApply::create([
                        //         'order_header_id' => $orderget->order_header_id,
                        //         'pick_release_no' => $pick_release_nos,
                        //         'credit_group_code' => '0',
                        //         'invoice_number' => $payment_number,
                        //         'attribute1' => 'Y',
                        //         'line_number' => $kaaa,
                        //         'invoice_header_id' => $request->payment_id[$key],
                        //         'invoice_amount' => str_replace(',', '', $request->payment_amounts[$key]),
                        //         'program_code' => 'OMP0025',
                        //         'created_by' => $user_id,
                        //         'last_updated_by' => $user_id,
                        //     ]);

                        //     $amountinvoicetotal = InvoiceHeaders::where('invoice_headers_number', $payment_number)->first();
                        //     if (str_replace(',', '', $request->payment_amounts[$key]) < $amountinvoicetotal->invoice_amount) {
                        //         PaymentApply::create([
                        //             'invoice_number' => $amountinvoicetotal->invoice_headers_number,
                        //             'invoice_header_id' => $amountinvoicetotal->invoice_header_id,
                        //             'invoice_amount' => abs(str_replace(',', '', $request->payment_amounts[$key]) < $amountinvoicetotal->invoice_amount),
                        //             'attribute2' => $amountinvoicetotal->invoice_type,
                        //             'program_code' => 'OMP0025',
                        //             'created_by' => $user_id,
                        //             'last_updated_by' => $user_id,
                        //         ]);
                        //     }

                        //     $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id)->where('credit_group_code', '0')->whereNull('deleted_at')->first();
                        //     if (!empty($ccgm)) {
                        //         $ramount_ccgm = $ccgm->remaining_amount;

                        //         $ccgm->remaining_amount = $ramount_ccgm + str_replace(',', '', $request->payment_amounts[$key]);
                        //         $ccgm->save();
                        //     }
                        // }
                        if (!in_array($payment_number, $cndn_unmatch)) {
                            array_push($cndn_unmatch, $payment_number);
                        }
                    }
                } else {
                    if ($request->type_payment_match[$key] == 'old') {
                        if (!in_array($payment_number, $number_unmatch)) {
                            array_push($number_unmatch, $payment_number);
                        }
                    } else {
                        $amount_payment_total = str_replace(',', '', $request->payment_amounts[$key]);

                        if (strpos($request->sa_number_for, 'DN') !== false) {
                            $invoces = DB::table('ptom_invoice_headers')->join('ptom_proforma_invoice_headers', 'ptom_invoice_headers.document_id', 'ptom_proforma_invoice_headers.pi_header_id')->join('ptom_order_headers', 'ptom_proforma_invoice_headers.order_header_id', 'ptom_order_headers.order_header_id', 'left')->join('ptom_customers', 'ptom_order_headers.customer_id', 'ptom_customers.customer_id', 'left')->whereNotNull('ptom_invoice_headers.document_id')->where('ptom_invoice_headers.invoice_headers_number', $request->sa_number_for)->whereNull('ptom_invoice_headers.deleted_at')->where('ptom_invoice_headers.invoice_status', 'Confirm')->groupBy(['ptom_invoice_headers.customer_id', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.pick_release_id', 'ptom_order_headers.order_header_id', 'ptom_invoice_headers.invoice_status', 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.pick_release_no', 'ptom_invoice_headers.invoice_date', 'ptom_customers.customer_type_id', 'ptom_customers.currency', 'ptom_order_headers.payment_type_code'])->get(['ptom_invoice_headers.customer_id', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.pick_release_id', 'ptom_order_headers.order_header_id', DB::raw('ptom_invoice_headers.invoice_status order_status'), 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.pick_release_no', DB::raw('ptom_invoice_headers.invoice_date delivery_date'), 'ptom_customers.customer_type_id', 'ptom_customers.currency', 'ptom_order_headers.payment_type_code']);
                        } else {
                            if (strpos($request->sa_number_for, 'IV') !== false) {
                                $invoces = DB::select("SELECT PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_ID,PTOM_PROFORMA_INVOICE_HEADERS.SA_NUMBER PREPARE_ORDER_NUMBER,PTOM_PROFORMA_INVOICE_HEADERS.CUSTOMER_ID,PTOM_PROFORMA_INVOICE_HEADERS.PAYMENT_TYPE_CODE,PTOM_PROFORMA_INVOICE_HEADERS.CURRENCY,PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_APPROVE_FLAG,PTOM_PROFORMA_INVOICE_HEADERS.PRODUCT_TYPE_CODE,PTOM_PROFORMA_INVOICE_HEADERS.ORDER_STATUS,PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO,PTOM_PROFORMA_INVOICE_HEADERS.PAYMENT_TYPE_CODE CREDIT_GROUP_CODE,PTOM_PROFORMA_INVOICE_HEADERS.DELIVERY_DATE FROM PTOM_PROFORMA_INVOICE_HEADERS WHERE PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO = '$request->sa_number_for' AND PTOM_PROFORMA_INVOICE_HEADERS.SALE_CONFIRM_FLAG = 'Y' AND PTOM_PROFORMA_INVOICE_HEADERS.ORDER_STATUS = 'Confirm'");
                            } else {
                                $invoces = DB::table('ptom_order_credit_groups')->join('ptom_order_headers', 'ptom_order_credit_groups.order_header_id', 'ptom_order_headers.order_header_id', 'left')->where('ptom_order_headers.order_header_id', '=', $request->order_header_id)->where('ptom_order_credit_groups.order_line_id', '!=', '0')->where('ptom_order_headers.sa_status', 'Confirm')->where('ptom_order_headers.sale_confirm_flag', 'Y')->groupBy(['ptom_order_headers.pick_release_id', 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.customer_id', 'ptom_order_headers.payment_type_code', 'ptom_order_headers.currency', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.order_status', 'ptom_order_headers.pick_release_no', 'ptom_order_credit_groups.credit_group_code', 'ptom_order_headers.delivery_date'])->get(['ptom_order_headers.pick_release_id', 'ptom_order_headers.prepare_order_number', 'ptom_order_headers.customer_id', 'ptom_order_headers.payment_type_code', 'ptom_order_headers.currency', 'ptom_order_headers.pick_release_approve_flag', 'ptom_order_headers.product_type_code', 'ptom_order_headers.order_status', 'ptom_order_headers.pick_release_no', 'ptom_order_credit_groups.credit_group_code', 'ptom_order_headers.delivery_date']);
                            }
                        }

                        foreach ($invoces as $invoce) {
                            $cry = $invoce->currency ?? '';
                            if ($amount_payment_total > 0) { //5210
                                $p1 = PaymentHeader::where('payment_number', $payment_number)->first();
                                if (!empty($p1)) {
                                    $p2 = PaymentLines::where('payment_header_id', $p1->payment_header_id)->orderBy('payment_detail_id', 'ASC')->get();
                                    $sum_total_amount = 0;
                                    $i2_array = [];
                                    $gcode_array = [];
                                    foreach ($p2 as $pp2) {
                                        if ($amount_payment_total > 0) {
                                            if (strpos($request->sa_number_for, 'DN') !== false) {
                                                $gCode = '0';
                                                $sum1 = PaymentMatchInvoice::where('payment_header_id', $p1->payment_header_id)->where(function ($q) use ($pp2) {
                                                    $q->where('payment_detail_id', $pp2->payment_detail_id);
                                                    $q->orWhereNull('payment_detail_id');
                                                })->where('match_flag', 'Y')->sum('payment_amount');
                                            } else {
                                                $gCode = $invoce->credit_group_code ?? '';
                                                $sum1 = PaymentMatchInvoice::where('payment_header_id', $p1->payment_header_id)->where(function ($q) use ($pp2) {
                                                    $q->where('payment_detail_id', $pp2->payment_detail_id);
                                                    $q->orWhereNull('payment_detail_id');
                                                })->where('match_flag', 'Y')->sum('payment_amount');
                                            }

                                            if ($pp2->conversion_amount >= $sum1) {
                                                // dd($sum1);

                                                if (strpos($request->sa_number_for, 'DN') !== false) {
                                                    $bbamount = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
                                                    $bbamount1 = empty($bbamount) ? 0 : $bbamount->invoice_amount;
                                                } else {
                                                    if (strpos($request->sa_number_for, 'IV') !== false) {
                                                        $bbamount0 = ProformaInvoiceHeaders::where('pick_release_no', $request->sa_number_for)->first();
                                                        $ordersum = OrderHeader::where(function ($q) use ($bbamount0) {
                                                            $q->where('order_header_id', $bbamount0->order_header_id);
                                                        })->first();
                                                        $bbamount = abs($ordersum->grand_total - $bbamount0->grand_total);
                                                        $bbamount1 = $bbamount;
                                                    } else {
                                                        $bbamount = OrderHeader::where(function ($q) use ($request) {
                                                            $q->where('prepare_order_number', $request->sa_number_for);
                                                        })->first();
                                                        $bbamount1 = empty($bbamount) ? 0 : $bbamount->grand_total;
                                                    }
                                                }
                                                // dd($bbamount1, $sum1);
                                                if ($bbamount1 < $sum1) {
                                                    $bbamount2 = $bbamount1;
                                                } else {
                                                    $bbamount2 = $bbamount1 - $sum1;
                                                }

                                                if ($pp2->conversion_amount > $amount_payment_total) {
                                                    $total_balance = $amount_payment_total;
                                                } else {
                                                    $total_balance = $pp2->conversion_amount - $sum1;
                                                }
                                                $amount_payment_total = $amount_payment_total - $total_balance;

                                                if (strpos($request->sa_numbser_for, 'IV') !== false || strpos($request->sa_number_for, 'DN') !== false) {
                                                    $invoceees = DB::table('ptom_proforma_invoice_headers')->select('pick_release_id', DB::raw("sa_number prepare_order_number"), 'payment_type_code')->where('pick_release_no', '=', $request->sa_number_for)->first();
                                                } else {
                                                    $invoceees = DB::table('ptom_order_headers')->select('pick_release_id', 'prepare_order_number', 'payment_type_code')->where('order_header_id', '=', $request->order_header_id)->first();
                                                }

                                                if ($invoceees) {
                                                    if (strpos($request->sa_number_for, 'DN') !== false) {
                                                        $iii1 = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
                                                        $i1 = $iii1->invoice_headers_id;
                                                    } else {
                                                        if (strpos($request->sa_number_for, 'IV') !== false) {
                                                            $i3 = $request->sa_number_for;
                                                            $i2 = $invoceees->prepare_order_number;
                                                        } else {
                                                            $ddptom = DB::select("SELECT PICK_RELEASE_NO FROM PTOM_PROFORMA_INVOICE_HEADERS WHERE ORDER_HEADER_ID = '" . $request->order_header_id . "'");
                                                            $i3 = empty($ddptom) ? '' : $ddptom[0]->pick_release_no;
                                                        }
                                                        $i1 = $invoceees->pick_release_id;
                                                        $i2 = $invoceees->prepare_order_number;
                                                    }
                                                } else {
                                                    if (strpos($request->sa_number_for, 'DN') !== false) {
                                                        $iii1 = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
                                                        $i1 = $iii1->invoice_headers_id;
                                                    } else {
                                                        $i1 = '';
                                                    }
                                                    $i2 = '';
                                                    $i3 = '';
                                                }

                                                if ($invoce->payment_type_code == 20) {
                                                    if (strpos($request->sa_number_for, 'DN') !== false) {
                                                        $dataday2 = null;
                                                    } else {
                                                        $dbdayamount = DB::select("SELECT TERM_ID FROM PTOM_PROFORMA_INVOICE_HEADERS WHERE PICK_RELEASE_NO = '" . $request->sa_number_for . "'");

                                                        if (empty($dbdayamount)) {
                                                            $dataday2 = 15;
                                                        } else {
                                                            $dayt = DB::select("SELECT DUE_DAYS FROM PTOM_TERMS_V WHERE TERM_ID = '" . $dbdayamount[0]->term_id . "'");
                                                            $dataday2 = empty($dayt) ? '0' : $dayt[0]->due_days;
                                                        }
                                                    }
                                                } else {
                                                    $dataday2 = 15;
                                                }

                                                if ($invoce->payment_type_code == 20) {
                                                    if (strpos($request->sa_number_for, 'DN') !== false) {
                                                        $paymentduedate2 = null;
                                                    } else {
                                                        if ($dataday2 != 0) {
                                                            $paymentduedate2 = Carbon::parse($invoce->delivery_date)->addDays($dataday2)->format('Y-m-d');
                                                        } else {
                                                            $paymentduedate2 = Carbon::parse($invoce->delivery_date)->format('Y-m-d');
                                                        }
                                                    }
                                                } else {
                                                    $paymentduedate2 = Carbon::parse($invoce->delivery_date)->addDays($dataday2)->format('Y-m-d');
                                                }

                                                if (strpos($request->sa_number_for, 'DN') !== false || strpos($request->sa_number_for, 'IV') !== false) {
                                                    $DPayment = DB::select("SELECT ORDER_HEADER_ID,PICK_RELEASE_NO,SA_NUMBER PREPARE_ORDER_NUMBER,PRODUCT_TYPE_DESCRIPTION DESCRIPTION,OUTSTANDING_DEBT TOTAL_AMOUNT,ORDER_DATE,DELIVERY_DATE,PAYMENT_TYPE_CODE,CURRENCY,PAYMENT_TYPE_CODE CREDIT_GROUP_CODE,PAYMENT_TYPE_DESCRIPTION,DUE_DAYS,DUE_DATE FROM PTOM_OUTSTANDING_DEBT_EXP_V WHERE PICK_RELEASE_NO = '".$request->sa_number_for."'");
                                                } else {
                                                    $DPayment = DB::select("SELECT ORDER_HEADER_ID,PICK_RELEASE_NO,SA_NUMBER PREPARE_ORDER_NUMBER,PRODUCT_TYPE_DESCRIPTION DESCRIPTION,OUTSTANDING_DEBT TOTAL_AMOUNT,ORDER_DATE,DELIVERY_DATE,PAYMENT_TYPE_CODE,CURRENCY,PAYMENT_TYPE_CODE CREDIT_GROUP_CODE,PAYMENT_TYPE_DESCRIPTION,DUE_DAYS,DUE_DATE FROM PTOM_OUTSTANDING_DEBT_EXP_V WHERE SA_NUMBER = '".$request->sa_number_for."'");
                                                }

                                                if(empty($DPayment)){
                                                    $paymentduedate = $paymentduedate2;
                                                    $dataday = $dataday2;
                                                } else {
                                                    $paymentduedate = $DPayment[0]->due_date;
                                                    $dataday = $DPayment[0]->due_days;
                                                }

                                                if (strpos($request->sa_number_for, 'DN') !== false || strpos($request->sa_number_for, 'IV') !== false) {
                                                    $i3 = $request->sa_number_for;
                                                }

                                                $datainsert = [
                                                    'payment_header_id' => $p1->payment_header_id,
                                                    'payment_detail_id' => $pp2->payment_detail_id,
                                                    'invoice_id' => $i1,
                                                    'invoice_number' => $i3,
                                                    'prepare_order_number' => $i2,
                                                    // 'credit_group_code' => $gCode,
                                                    'due_day' => $dataday,
                                                    'due_date' => $paymentduedate,
                                                    'payment_amount' => $total_balance,
                                                    'match_flag' => 'Y',
                                                    'payment_type_code' => $invoce->payment_type_code,
                                                    'currency' => $cry,
                                                    'program_code' => 'OMP0068',
                                                    'created_by' => $user_id,
                                                    'last_updated_by' => $user_id,
                                                    'outstanding_debt' => $bbamount2
                                                ];

                                                PaymentMatchInvoice::create($datainsert);

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
                                    if (strpos($request->sa_number_for, 'IV') !== false) {
                                        $orderid_array = ProformaInvoiceHeaders::whereIn('sa_number', $i2_array)->get();
                                    } else {
                                        $orderid_array = OrderHeader::whereIn('prepare_order_number', $i2_array)->get();
                                    }

                                    foreach ($orderid_array as $arr) {
                                        if (!in_array($arr->order_header_id, $orderid_arrays)) {
                                            array_push($orderid_arrays, $arr->order_header_id);
                                        }
                                    }
                                    if (strpos($request->sa_number_for, 'IV') !== false) {
                                        $getTotalAmounts = ProformaInvoiceHeaders::whereIn('order_header_id', $orderid_arrays)->whereIn('payment_type_code', $gcode_array)->sum('grand_total');
                                    } else {
                                        $getTotalAmounts = PtomOrderCreditGroup::whereIn('order_header_id', $orderid_arrays)->whereIn('credit_group_code', $gcode_array)->where('order_line_id', '!=', '0')->sum('amount');
                                    }
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
            $apps = DB::select("SELECT PERIOD_NAME,CLOSING_STATUS FROM APPS.GL_PERIOD_STATUSES WHERE TO_CHAR(START_DATE, 'YYYY-MM-DD') <= '".Carbon::now()->format('Y-m-d')."' AND TO_CHAR(END_DATE, 'YYYY-MM-DD') >= '".Carbon::now()->format('Y-m-d')."' ORDER BY LAST_UPDATE_DATE DESC FETCH FIRST 1 ROWS ONLY");
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
                    $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('payment_match_id', $pppp11->payment_match_id)->first();
                    if (!empty($customer_and_credit)) {
                        $customer_id_2 = $customer_and_credit->customer_id;
                        $credit_group_code_2 = $customer_and_credit->payment_type_code;
                        $amount_2 = $pppp11->invoice_amount;

                        $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id_2)->where('credit_group_code', $credit_group_code_2)->whereNull('deleted_at')->first();
                        if (!empty($ccgm)) {
                            $ramount_ccgm = $ccgm->remaining_amount;

                            $ccgm->remaining_amount = $ramount_ccgm - $amount_2;
                            $ccgm->save();
                        }
                    }
                }

                PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
            } else {
                if (strpos($request->sa_number_for, 'IV') !== false) {
                    $odddr = ProformaInvoiceHeaders::where('pick_release_no', $request->sa_number_for)->first();

                    // $pppp1 = PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->where(function ($q) use ($odddr) {
                    //     $q->where('pick_release_no', $odddr->pick_release_no);
                    //     $q->orWhere('order_header_id', $odddr->order_header_id);
                    // })->where('attribute1', 'Y')->whereNotNull('payment_match_id')->get();
                    $pppp1 = PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->where(function ($q) use ($odddr) {
                        $q->where('pick_release_no', $odddr->pick_release_no);
                        $q->orWhere('order_header_id', $odddr->order_header_id);
                    })->where('attribute1', 'Y')->get();

                    foreach ($pppp1 as $pppp11) {
                        $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('payment_match_id', $pppp11->payment_match_id)->first();
                        if (!empty($customer_and_credit)) {
                            $customer_id_2 = $customer_and_credit->customer_id;
                            $credit_group_code_2 = $customer_and_credit->payment_type_code;
                            $amount_2 = $pppp11->invoice_amount;

                            $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id_2)->where('credit_group_code', $credit_group_code_2)->whereNull('deleted_at')->first();
                            if (!empty($ccgm)) {
                                $ramount_ccgm = $ccgm->remaining_amount;

                                $ccgm->remaining_amount = $ramount_ccgm - $amount_2;
                                $ccgm->save();
                            }
                        }
                    }

                    PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->where(function ($q) use ($odddr) {
                        $q->where('pick_release_no', $odddr->pick_release_no);
                        $q->orWhere('order_header_id', $odddr->order_header_id);
                    })->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
                } else {
                    $odddr = OrderHeader::where('prepare_order_number', $request->sa_number_for)->orWhere('pick_release_no', $request->sa_number_for)->first();

                    // $pppp1 = PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->where(function ($q) use ($odddr) {
                    //     $q->where('pick_release_no', $odddr->pick_release_no);
                    //     $q->orWhere('order_header_id', $odddr->order_header_id);
                    // })->where('attribute1', 'Y')->whereNotNull('payment_match_id')->get();
                    $pppp1 = PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->where(function ($q) use ($odddr) {
                        $q->where('pick_release_no', $odddr->pick_release_no);
                        $q->orWhere('order_header_id', $odddr->order_header_id);
                    })->where('attribute1', 'Y')->get();
                    foreach ($pppp1 as $pppp11) {
                        $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('payment_match_id', $pppp11->payment_match_id)->first();
                        if (!empty($customer_and_credit)) {
                            $customer_id_2 = $customer_and_credit->customer_id;
                            $credit_group_code_2 = $customer_and_credit->payment_type_code;
                            $amount_2 = $pppp11->invoice_amount;

                            $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id_2)->where('credit_group_code', $credit_group_code_2)->whereNull('deleted_at')->first();
                            if (!empty($ccgm)) {
                                $ramount_ccgm = $ccgm->remaining_amount;

                                $ccgm->remaining_amount = $ramount_ccgm - $amount_2;
                                $ccgm->save();
                            }
                        }
                    }

                    PaymentApplyCNDN::whereNotIn('invoice_number', $cndn_unmatch)->where(function ($q) use ($odddr) {
                        $q->where('pick_release_no', $odddr->pick_release_no);
                        $q->orWhere('order_header_id', $odddr->order_header_id);
                    })->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
                }
            }
        } else {
            if (strpos($request->sa_number_for, 'DN') !== false) {
                $inv = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
                $pppp1 = PaymentApplyCNDN::where(function ($q) use ($request, $inv) {
                    $q->where('invoice_number', $request->sa_number_for);
                    $q->orWhere('invoice_header_id', $inv->invoice_headers_id);
                })->where('attribute1', 'Y')->get();
                foreach ($pppp1 as $pppp11) {
                    $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('payment_match_id', $pppp11->payment_match_id)->first();
                    if (!empty($customer_and_credit)) {
                        $customer_id_2 = $customer_and_credit->customer_id;
                        $credit_group_code_2 = $customer_and_credit->payment_type_code;
                        $amount_2 = $pppp11->invoice_amount;

                        $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id_2)->where('credit_group_code', $credit_group_code_2)->whereNull('deleted_at')->first();
                        if (!empty($ccgm)) {
                            $ramount_ccgm = $ccgm->remaining_amount;

                            $ccgm->remaining_amount = $ramount_ccgm - $amount_2;
                            $ccgm->save();
                        }
                    }
                }

                PaymentApplyCNDN::where(function ($q) use ($request, $inv) {
                    $q->where('invoice_number', $request->sa_number_for);
                    $q->orWhere('invoice_header_id', $inv->invoice_headers_id);
                })->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
            } else {
                if (strpos($request->sa_number_for, 'IV') !== false) {
                    $orderids = ProformaInvoiceHeaders::where('pick_release_no', $request->sa_number_for)->first();
                } else {
                    $orderids = OrderHeader::where('prepare_order_number', $request->sa_number_for)->orWhere('pick_release_no', $request->sa_number_for)->first();
                }
                $pppp1 = PaymentApplyCNDN::where(function ($q) use ($request, $orderids) {
                    $q->where('pick_release_no', $request->sa_number_for);
                    $q->orWhere('order_header_id', $orderids->order_header_id);
                })->where('attribute1', 'Y')->get();
                foreach ($pppp1 as $pppp11) {
                    $customer_and_credit = PaymentMatchInvoice::join('ptom_payment_headers', 'ptom_payment_match_invoices.payment_header_id', 'ptom_payment_headers.payment_header_id', 'left')->where('payment_match_id', $pppp11->payment_match_id)->first();
                    if (!empty($customer_and_credit)) {
                        $customer_id_2 = $customer_and_credit->customer_id;
                        $credit_group_code_2 = $customer_and_credit->payment_type_code;
                        $amount_2 = $pppp11->invoice_amount;

                        $ccgm = CustomerContractGroupModel::where('customer_id', $customer_id_2)->where('credit_group_code', $credit_group_code_2)->whereNull('deleted_at')->first();
                        if (!empty($ccgm)) {
                            $ramount_ccgm = $ccgm->remaining_amount;

                            $ccgm->remaining_amount = $ramount_ccgm - $amount_2;
                            $ccgm->save();
                        }
                    }
                }

                PaymentApplyCNDN::where(function ($q) use ($request, $orderids) {
                    $q->where('pick_release_no', $request->sa_number_for);
                    $q->orWhere('order_header_id', $orderids->order_header_id);
                })->update(['attribute1' => 'N', 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok')]);
            }
        }

        if (count($number_unmatch) > 0) {
            $apps = DB::select("SELECT PERIOD_NAME,CLOSING_STATUS FROM APPS.GL_PERIOD_STATUSES WHERE TO_CHAR(START_DATE, 'YYYY-MM-DD') <= '".Carbon::now()->format('Y-m-d')."' AND TO_CHAR(END_DATE, 'YYYY-MM-DD') >= '".Carbon::now()->format('Y-m-d')."' ORDER BY LAST_UPDATE_DATE DESC FETCH FIRST 1 ROWS ONLY");
            if (empty($apps)) {
                return redirect()->back()->with('error', 'ไม่พบข้อมูล APPS.GL_PERIOD_STATUSES');
            }

            if ($apps[0]->closing_status != 'O') {
                return redirect()->back()->with('error', 'กรุณาเปิด AR period ของ ' . $apps[0]->period_name . ' ก่อน');
            }
            $h = [];
            $payH = PaymentHeaders::whereIn('payment_number', $number_unmatch)->get(['payment_header_id']);
            foreach ($payH as $pay) {
                array_push($h, $pay->payment_header_id);
            }
            if (strpos($request->sa_number_for, 'DN') !== false) {
                $orderssss = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
            } else {
                if (strpos($request->sa_number_for, 'IV') !== false) {
                    $orderssss = ProformaInvoiceHeaders::where('pick_release_no', $request->sa_number_for)->first();
                } else {
                    $orderssss = OrderHeaders::where('prepare_order_number', $request->sa_number_for)->orWhere('pick_release_no', $request->sa_number_for)->first();
                }
            }
            if (!empty($orderssss)) {
                if (strpos($request->sa_number_for, 'DN') !== false) {
                    $payment_amounts = PaymentMatchInvoice::where(function ($q) use ($orderssss) {
                        $q->where('invoice_number', $orderssss->invoice_headers_number);
                        $q->orWhere('invoice_id', $orderssss->invoice_headers_id);
                    })->whereNotIn('payment_header_id', $h)->where('match_flag', 'Y')->get();
                } else {
                    if (strpos($request->sa_number_for, 'IV') !== false) {
                        $payment_amounts = PaymentMatchInvoice::where('invoice_number', '=', $orderssss->pick_release_no)->whereNotIn('payment_header_id', $h)->where('match_flag', 'Y')->get();
                    } else {
                        $payment_amounts = PaymentMatchInvoice::where('prepare_order_number', '=', $orderssss->prepare_order_number)->whereNotIn('payment_header_id', $h)->where('match_flag', 'Y')->get();
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
                        if (strpos($request->sa_number_for, 'IV') !== false) {
                            $orderid = ProformaInvoiceHeaders::where('sa_number', $pp->prepare_order_number)->first();

                            if (!empty($orderid)) {
                                $getTotalAmount = $orderid->grand_total;
                            } else {
                                $getTotalAmount = 0;
                            }
                        } else {
                            $orderid = OrderHeader::where('prepare_order_number', $pp->prepare_order_number)->first();

                            if (count($order_id) > 0 && count($group_id) > 0) {
                                $getTotalAmount = PtomOrderCreditGroup::where('order_header_id', $orderid->order_header_id)->whereNotIn('order_header_id', $order_id)->where('credit_group_code', $pp->payment_type_code)->whereNotIn('credit_group_code', $group_id)->where('order_line_id', '!=', '0')->sum('amount');
                            } else {
                                $getTotalAmount = PtomOrderCreditGroup::where('order_header_id', $orderid->order_header_id)->where('credit_group_code', $pp->payment_type_code)->where('order_line_id', '!=', '0')->sum('amount');
                            }
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

                        if (!in_array($pp->payment_type_code, $group_id)) {
                            array_push($group_id, $pp->payment_type_code);
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
                    $ccgm = CustomerContractGroupModel::where('customer_id', $payments->customer_id)->where('credit_group_code', $pp->payment_type_code)->whereNull('deleted_at')->first();
                    if (!empty($ccgm)) {
                        $ramount_ccgm = $ccgm->remaining_amount;

                        $ccgm->remaining_amount = $ramount_ccgm - $pp->payment_amount;
                        $ccgm->save();
                    }
                }
            }
        } else {
            if (strpos($request->sa_number_for, 'DN') !== false) {
                $orderssss = PtomInvoiceHeader::where('invoice_headers_number', $request->sa_number_for)->first();
            } else {
                if (strpos($request->sa_number_for, 'IV') !== false) {
                    $orderssss = ProformaInvoiceHeaders::where('pick_release_no', $request->sa_number_for)->first();
                } else {
                    $orderssss = OrderHeaders::where('prepare_order_number', $request->sa_number_for)->orWhere('pick_release_no', $request->sa_number_for)->first();
                }
            }

            if (!empty($orderssss)) {
                if (strpos($request->sa_number_for, 'DN') !== false) {
                    $payment_amounts = PaymentMatchInvoice::where(function ($q) use ($orderssss) {
                        $q->where('invoice_number', $orderssss->invoice_headers_number);
                    })->where('match_flag', 'Y')->get();
                } else {
                    if (strpos($request->sa_number_for, 'IV') !== false) {
                        $payment_amounts = PaymentMatchInvoice::where('invoice_number', '=', $orderssss->pick_release_no)->where('match_flag', 'Y')->get();
                    } else {
                        $payment_amounts = PaymentMatchInvoice::where('prepare_order_number', '=', $orderssss->prepare_order_number)->where('match_flag', 'Y')->get();
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
                        if (strpos($request->sa_number_for, 'IV') !== false) {
                            $orderid = ProformaInvoiceHeaders::where('pick_release_no', $request->sa_number_for)->first();
                        } else {
                            $orderid = OrderHeader::where('prepare_order_number', $pp->prepare_order_number)->first();
                        }

                        if (!in_array($orderid->order_header_id, $order_id)) {
                            array_push($order_id, $orderid->order_header_id);
                        }

                        if (!in_array($pp->payment_type_code, $group_id)) {
                            array_push($group_id, $pp->payment_type_code);
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

                    $ccgm = CustomerContractGroupModel::where('customer_id', $payments->customer_id)->where('credit_group_code', $pp->payment_type_code)->whereNull('deleted_at')->first();
                    if (!empty($ccgm)) {
                        $ramount_ccgm = $ccgm->remaining_amount;

                        $ccgm->remaining_amount = $ramount_ccgm - $pp->payment_amount;
                        $ccgm->save();
                    }
                }

                if (strpos($request->sa_number_for, 'DN') !== false) {
                    $getTotalAmounts = DB::select("SELECT INVOICE_AMOUNT FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_NUMBER = '" . $request->sa_number_for . "'");
                    $getTotalAmount = $getTotalAmounts[0]->invoice_amount;
                } else {
                    if (strpos($request->sa_number_for, 'IV') !== false) {
                        $getTotalAmountss = ProformaInvoiceHeaders::where('pick_release_no', $request->sa_number_for)->first();
                        $getTotalAmount = $getTotalAmountss->grand_total;
                    } else {
                        $getTotalAmount = PtomOrderCreditGroup::whereIn('order_header_id', $order_id)->whereIn('credit_group_code', $group_id)->where('order_line_id', '!=', '0')->sum('amount');
                    }
                }

                if (count($payments_id) > 0) {
                    $paymentsss = PaymentHeader::whereIn('payment_header_id', $payments_id)->sum('total_amount_with_vat');
                    if ($paymentsss == 0 && empty($payment_amounts)) {
                        $total_with_vat = $getTotalAmount;
                    } else {
                        $total_with_vat = $paymentsss - $getTotalAmount;
                    }
                } else {
                    $total_with_vat = $getTotalAmount;
                }

                if ($total_with_vat < 0) {
                    $twv = 0;
                } else {
                    $twv = $total_with_vat;
                }

                if (count($payments_id) > 0) {
                    $paymentssss = PaymentHeader::whereIn('payment_header_id', $payments_id)->sum('total_payment_amount');
                    if ($paymentssss == 0 && empty($payment_amounts)) {
                        $total_payment_amount = $getTotalAmount;
                    } else {
                        $total_payment_amount = $paymentssss - $sum_payment_amount;
                    }
                } else {
                    $total_payment_amount = $getTotalAmount;
                }
                if ($total_payment_amount < 0) {
                    $tpa = 0;
                } else {
                    $tpa = $total_payment_amount;
                }

                if ($request->payment_number) {
                    if(!empty($pp)) {
                        PaymentHeader::where('payment_header_id', $pp->payment_header_id)->update(['last_updated_by' => $user_id, 'last_update_date' => Carbon::now()->timezone('Asia/Bangkok'), 'total_amount_with_vat' => $twv, 'total_payment_amount' => $tpa]);
                    }
                }
            }
        }

        return redirect()->to('/om/export-matching?number_ref=' . $request->sa_number_for . '&customer_ref=' . $request->cust_ref . '&date_ref=' . $request->data_date . '&date_ref1=' . $request->data_date1)->with('success', 'บันทึกเรียบร้อยแล้ว');
    }

    public function getDataexchangerate(Request $request)
    {
        if ($request->type_add == 'draft') {
            $header_id = $request->payment_header_id;

            $ex = PaymentLines::where('payment_header_id', $header_id)->first();

            if (empty($ex)) {
                $rate = "1.00";
            } elseif ($ex->conversion_rate == null) {
                $rate = "1.00";
            } else {
                $rate = number_format($ex->conversion_rate, 2);
            }

            return response()->json(['data' => $rate], 200);
        } else {
            $header_id = $request->payment_header_id;

            $ex = OMInvoiceHeaders::find($header_id);

            if (empty($ex)) {
                $rate = "1.00";
            } elseif ($ex->exchange_rate == null) {
                $rate = "1.00";
            } else {
                $rate = number_format($ex->exchange_rate, 2);
            }

            return response()->json(['data' => $rate], 200);
        }
    }
}
