<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Models\OM\ConsignmentHeader;
use App\Models\OM\ConsignmentLines;
use App\Models\OM\PriceListLines;
use App\Models\OM\TranspotReportModel;
use App\Models\OM\AgentsVendors;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\CustomerAgents;
use App\Repositories\OM\OracleCall;

class TransferCommissionController extends Controller
{
    public function index()
    {
        return view('om.transferCommission.index');
    }

    public function sendAP(Request $request)
    {
        set_time_limit(0);
        $validate = Validator::make($request->all(), [
            'locate' => 'required',
            'start' => 'required',
            'end' => 'required'
        ], [
            'locate.required' => 'กรุณาตรวจสอบรายละเอียด',
            'start.required' => 'กรุณาระบุวันที่เริ่มคำนวณ',
            // 'start.date' => 'รูปแบบวันที่เริ่มคำนวณไม่ถูกต้อง',
            'end.required' => 'กรุณาระบุวันที่สิ้นสุดการคำนวณ',
            // 'end.date' => 'รูปแบบวันที่สิ้นสุดการคำนวณไม่ถูกต้อง',
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => 'error', 'data' => $validate->errors()->first()]);
        }

        $today = Carbon::now()->timezone('Asia/Bangkok')->format('Y-m-d');
        // if (strtoupper($request->locate) == 'BKK') {
        //     $endday = Carbon::now()->timezone('Asia/Bangkok')->endOfMonth()->toDateString();
        //     if ($today != $endday) {
        //         return response()->json(['status' => 'error', 'data' => 'ค่านายหน้าสโมสรกรุงเทพฯ จะส่งรายการได้ ณ​ วันที่สิ้นเดือนเท่านั้น']);
        //     }
        // }


        $web_batch_no = Carbon::now()->format('YmdHis');
        $start0 = parseFromDateTh($request->start);
        $end0 = parseFromDateTh($request->end);

        $start_exp = explode('-', $start0);
        $end_exp = explode('-', $end0);

        $start = Carbon::parse($start0)->startOfDay()->timezone('Asia/Bangkok')->format('Y-m-d H:i:s');
        $end = Carbon::parse($end0)->endOfDay()->timezone('Asia/Bangkok')->format('Y-m-d H:i:s');
        if (Carbon::parse($start0)->startOfDay()->timezone('Asia/Bangkok')->greaterThan(Carbon::parse($end0)->endOfDay()->timezone('Asia/Bangkok'))) {
            return response()->json(['status' => 'error', 'data' => 'ไม่สามารถดำเนินการได้ วันที่สิ้นสุดต้องมีค่ามากกว่าวันที่เริ่มต้น']);
        }

        //  return response()->json(['status' => 'error', 'start' => $start, 'end' => $end, 'data' => $request->all()]);

        if (strtoupper($request->locate) == 'BKK') {
            $id_consignment_header2 = DB::select("SELECT DISTINCT PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID,PTOM_ORDER_HEADERS.ORDER_DATE,PTOM_ORDER_HEADERS.CURRENCY,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS,PTOM_CONSIGNMENT_HEADERS.TOTAL_AMOUNT,PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT,PTOM_CONSIGNMENT_HEADERS.TOTAL_INCLUDE_VAT,PTOM_CONSIGNMENT_HEADERS.COMMISSION_AMOUNT,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE,PTOM_CUSTOMERS.CUSTOMER_ID,PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID FROM PTOM_CONSIGNMENT_LINES LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID LEFT JOIN PTOM_CONSIGNMENT_HEADERS ON PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_HEADER_ID = PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND PTOM_CUSTOMERS.PROVINCE_CODE = 10 AND PTOM_CONSIGNMENT_HEADERS.AGENT_WEB_BATCH_NO IS NULL AND TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('" . $start . "', 'YYYY-MM-DD hh24:mi:ss') AND TO_DATE('" . $end . "', 'YYYY-MM-DD hh24:mi:ss')");
        } else {
            $id_consignment_header2 = DB::select("SELECT DISTINCT PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID,PTOM_ORDER_HEADERS.ORDER_DATE,PTOM_ORDER_HEADERS.CURRENCY,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS,PTOM_CONSIGNMENT_HEADERS.TOTAL_AMOUNT,PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT,PTOM_CONSIGNMENT_HEADERS.TOTAL_INCLUDE_VAT,PTOM_CONSIGNMENT_HEADERS.COMMISSION_AMOUNT,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE,PTOM_CUSTOMERS.CUSTOMER_ID,PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID FROM PTOM_CONSIGNMENT_LINES LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID LEFT JOIN PTOM_CONSIGNMENT_HEADERS ON PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_HEADER_ID = PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND PTOM_CUSTOMERS.PROVINCE_CODE <> 10 AND PTOM_CONSIGNMENT_HEADERS.AGENT_WEB_BATCH_NO IS NULL AND TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('" . $start . "', 'YYYY-MM-DD hh24:mi:ss') AND TO_DATE('" . $end . "', 'YYYY-MM-DD hh24:mi:ss')");
        }

        if (empty($id_consignment_header2)) {
            return response()->json(['status' => 'error', 'data' => 'ไม่พบข้อมูลที่สามารถส่งรายการอินเตอร์เฟซได้']);
        } else {
            foreach ($id_consignment_header2 as $check2) {
                $agent = CustomerAgents::where('customer_id', $check2->customer_id)->count();
                if ($agent == 0) {
                    $cus = Customers::find($check2->customer_id);
                    return response()->json(['status' => 'error', 'data' => 'ไม่พบรหัสนายหน้าของร้านค้า ' . $cus->customer_number . ' โปรดระบุรหัสนายหน้า']);
                }
            }
        }


        // if (strtoupper($request->locate) == 'BKK') {
        //     foreach ($id_consignment_header2 as $check) {
        //         if ($check->order_header_id != null) {
        //             $orders = OrderHeader::find($check->order_header_id);
        //             if ($orders->close_sale_flag != 'Y') {
        //                 return response()->json(['status' => 'error', 'data' => 'ไม่สามารถดำเนินการได้ พบใบสั่งซื้อ ' . $orders->prepare_order_number . ' ยังไม่ปิดการขาย']);
        //             }
        //         }
        //     }
        // }

        if (strtoupper($request->locate) == 'BKK') {
            $id_consignment_header1 = DB::select("SELECT PTOM_CUSTOMERS.CUSTOMER_ID
            FROM PTOM_CONSIGNMENT_LINES
            LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID
            LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
            LEFT JOIN PTOM_CONSIGNMENT_HEADERS ON PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_HEADER_ID = PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID
            WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'
            AND PTOM_CUSTOMERS.PROVINCE_CODE = 10
            AND PTOM_CONSIGNMENT_HEADERS.AGENT_WEB_BATCH_NO IS NULL
            AND TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE)
            BETWEEN TO_DATE('" . $start . "', 'YYYY-MM-DD hh24:mi:ss') AND TO_DATE('" . $end . "', 'YYYY-MM-DD hh24:mi:ss') GROUP BY PTOM_CUSTOMERS.CUSTOMER_ID");
        } else {
            $id_consignment_header1 = DB::select("SELECT PTOM_CUSTOMERS.CUSTOMER_ID
            FROM PTOM_CONSIGNMENT_LINES
            LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID
            LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
            LEFT JOIN PTOM_CONSIGNMENT_HEADERS ON PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_HEADER_ID = PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID
            WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'
            AND PTOM_CUSTOMERS.PROVINCE_CODE <> 10
            AND PTOM_CONSIGNMENT_HEADERS.AGENT_WEB_BATCH_NO IS NULL
            AND TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE)
            BETWEEN TO_DATE('" . $start . "', 'YYYY-MM-DD hh24:mi:ss') AND TO_DATE('" . $end . "', 'YYYY-MM-DD hh24:mi:ss') GROUP BY PTOM_CUSTOMERS.CUSTOMER_ID");
        }

        // return response()->json(['status' => 'success', 'data' => $id_consignment_header1]);

        $number = 0;
        $keys = 0;
        foreach ($id_consignment_header1 as $i1) {
            $invoice_number = invoiceNumberForTest(Carbon::now()->format('Y-m-d'));
            $keys++;
            $group_id = $web_batch_no;

            if (strtoupper($request->locate) == 'BKK') {
                $id_consignment_header = DB::select("SELECT DISTINCT PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID,PTOM_CUSTOMER_AGENTS.AGENT_CODE,PTOM_ORDER_HEADERS.CURRENCY,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS,
                PTOM_CONSIGNMENT_HEADERS.TOTAL_AMOUNT,PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT,PTOM_CONSIGNMENT_HEADERS.TOTAL_INCLUDE_VAT,PTOM_CONSIGNMENT_HEADERS.COMMISSION_AMOUNT,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE,PTOM_CUSTOMERS.CUSTOMER_ID FROM PTOM_CONSIGNMENT_LINES
                LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID
                LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
                LEFT JOIN PTOM_CUSTOMER_AGENTS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMER_AGENTS.CUSTOMER_ID
                LEFT JOIN PTOM_CONSIGNMENT_HEADERS ON PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_HEADER_ID = PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID
                WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND PTOM_CUSTOMERS.PROVINCE_CODE = 10 AND PTOM_CUSTOMER_AGENTS.AGENT_CODE IS NOT NULL AND PTOM_CUSTOMER_AGENTS.DELETED_AT IS NULL
                AND PTOM_CONSIGNMENT_HEADERS.AGENT_WEB_BATCH_NO IS NULL AND PTOM_CUSTOMERS.CUSTOMER_ID = '" . $i1->customer_id . "'
                AND TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('" . $start . "', 'YYYY-MM-DD hh24:mi:ss') AND TO_DATE('" . $end . "', 'YYYY-MM-DD hh24:mi:ss')");
            } else {
                // $id_consignment_header = DB::select("SELECT DISTINCT PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID,PTOM_ORDER_HEADERS.ORDER_DATE,PTOM_CUSTOMER_AGENTS.AGENT_CODE,PTOM_ORDER_HEADERS.CURRENCY,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS,PTOM_CONSIGNMENT_HEADERS.TOTAL_AMOUNT,PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT,PTOM_CONSIGNMENT_HEADERS.TOTAL_INCLUDE_VAT,PTOM_CONSIGNMENT_HEADERS.COMMISSION_AMOUNT,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE,PTOM_CUSTOMERS.CUSTOMER_ID,PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID FROM PTOM_CONSIGNMENT_LINES LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID LEFT JOIN PTOM_CUSTOMER_AGENTS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMER_AGENTS.CUSTOMER_ID LEFT JOIN PTOM_CONSIGNMENT_HEADERS ON PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_HEADER_ID = PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND PTOM_CUSTOMERS.PROVINCE_CODE <> 10 AND PTOM_CUSTOMER_AGENTS.AGENT_CODE IS NOT NULL AND PTOM_CUSTOMER_AGENTS.DELETED_AT IS NULL AND (PTOM_CONSIGNMENT_HEADERS.DELIVERY_WEB_BATCH_NO != 'Y' OR PTOM_CONSIGNMENT_HEADERS.DELIVERY_WEB_BATCH_NO IS NULL) AND PTOM_CUSTOMERS.CUSTOMER_ID = '" . $i1->customer_id . "' AND TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('" . $start . "', 'YYYY-MM-DD hh24:mi:ss') AND TO_DATE('" . $end . "', 'YYYY-MM-DD hh24:mi:ss')");
                $id_consignment_header = DB::select("SELECT DISTINCT PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID,PTOM_CUSTOMER_AGENTS.AGENT_CODE,PTOM_ORDER_HEADERS.CURRENCY,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS,
                PTOM_CONSIGNMENT_HEADERS.TOTAL_AMOUNT,PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT,PTOM_CONSIGNMENT_HEADERS.TOTAL_INCLUDE_VAT,PTOM_CONSIGNMENT_HEADERS.COMMISSION_AMOUNT,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE,PTOM_CUSTOMERS.CUSTOMER_ID FROM PTOM_CONSIGNMENT_LINES
                LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_CONSIGNMENT_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID
                LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
                LEFT JOIN PTOM_CUSTOMER_AGENTS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMER_AGENTS.CUSTOMER_ID
                LEFT JOIN PTOM_CONSIGNMENT_HEADERS ON PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_HEADER_ID = PTOM_CONSIGNMENT_LINES.CONSIGNMENT_HEADER_ID
                WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND PTOM_CUSTOMERS.PROVINCE_CODE <> 10 AND PTOM_CUSTOMER_AGENTS.AGENT_CODE IS NOT NULL AND PTOM_CUSTOMER_AGENTS.DELETED_AT IS NULL
                AND PTOM_CONSIGNMENT_HEADERS.AGENT_WEB_BATCH_NO IS NULL AND PTOM_CUSTOMERS.CUSTOMER_ID = '" . $i1->customer_id . "'
                AND TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('" . $start . "', 'YYYY-MM-DD hh24:mi:ss') AND TO_DATE('" . $end . "', 'YYYY-MM-DD hh24:mi:ss')");
            }

            if (strtoupper($request->locate) == 'BKK') {
                $id_date_end = ConsignmentHeader::leftJoin('ptom_customers', 'ptom_consignment_headers.customer_id', 'ptom_customers.customer_id')->leftJoin('ptom_customer_agents', 'ptom_customers.customer_id', 'ptom_customer_agents.customer_id')->whereRaw("upper(ptom_consignment_headers.consignment_status) = 'CONFIRM'")->where('ptom_customers.province_code', '10')->whereRaw("TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('" . $start . "', 'YYYY-MM-DD hh24:mi:ss') AND TO_DATE('" . $end . "', 'YYYY-MM-DD hh24:mi:ss')")->where(function ($q) {
                    // $q->where('ptom_consignment_headers.agent_web_batch_no', '!=', 'Y');
                    $q->whereNull('ptom_consignment_headers.agent_web_batch_no');
                })->whereNotNull('ptom_customer_agents.agent_code')->where('ptom_customers.customer_id', $i1->customer_id)->whereNull('ptom_customer_agents.deleted_at')->orderBy('ptom_consignment_headers.consignment_date', 'desc')->first(['ptom_consignment_headers.order_header_id']);
            } else {
                $id_date_end = ConsignmentHeader::leftJoin('ptom_customers', 'ptom_consignment_headers.customer_id', 'ptom_customers.customer_id')->leftJoin('ptom_customer_agents', 'ptom_customers.customer_id', 'ptom_customer_agents.customer_id')->whereRaw("upper(ptom_consignment_headers.consignment_status) = 'CONFIRM'")->where('ptom_customers.province_code', '<>', '10')->whereRaw("TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('" . $start . "', 'YYYY-MM-DD hh24:mi:ss') AND TO_DATE('" . $end . "', 'YYYY-MM-DD hh24:mi:ss')")->whereNotNull('ptom_customer_agents.agent_code')->where(function ($q) {
                    // $q->where('ptom_consignment_headers.agent_web_batch_no', '!=', 'Y');
                    $q->whereNull('ptom_consignment_headers.agent_web_batch_no');
                })->where('ptom_customers.customer_id', $i1->customer_id)->whereNull('ptom_customer_agents.deleted_at')->orderBy('ptom_consignment_headers.consignment_date', 'desc')->first(['ptom_consignment_headers.order_header_id']);
            }

            $last_order_header_id = $id_date_end->order_header_id ?? '';

            if (strtoupper($request->locate) == 'BKK') {
                $sumdata = ConsignmentHeader::leftJoin('ptom_customers', 'ptom_consignment_headers.customer_id', 'ptom_customers.customer_id')->leftJoin('ptom_customer_agents', 'ptom_customers.customer_id', 'ptom_customer_agents.customer_id')->whereRaw("upper(ptom_consignment_headers.consignment_status) = 'CONFIRM'")->where('ptom_customers.province_code', '10')->whereRaw("TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('" . $start . "', 'YYYY-MM-DD hh24:mi:ss') AND TO_DATE('" . $end . "', 'YYYY-MM-DD hh24:mi:ss')")->whereNotNull('ptom_customer_agents.agent_code')->where('ptom_customers.customer_id', $i1->customer_id)->where(function ($q) {
                    // $q->where('ptom_consignment_headers.agent_web_batch_no', '!=', 'Y');
                    $q->whereNull('ptom_consignment_headers.agent_web_batch_no');
                })->whereNull('ptom_customer_agents.deleted_at')->sum('ptom_consignment_headers.commission_amount');
            } else {
                $sumdata = ConsignmentHeader::leftJoin('ptom_customers', 'ptom_consignment_headers.customer_id', 'ptom_customers.customer_id')->leftJoin('ptom_customer_agents', 'ptom_customers.customer_id', 'ptom_customer_agents.customer_id')->whereRaw("upper(ptom_consignment_headers.consignment_status) = 'CONFIRM'")->where('ptom_customers.province_code', '<>', '10')->whereRaw("TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('" . $start . "', 'YYYY-MM-DD hh24:mi:ss') AND TO_DATE('" . $end . "', 'YYYY-MM-DD hh24:mi:ss')")->whereNotNull('ptom_customer_agents.agent_code')->where(function ($q) {
                    // $q->where('ptom_consignment_headers.agent_web_batch_no', '!=', 'Y');
                    $q->whereNull('ptom_consignment_headers.agent_web_batch_no');
                })->where('ptom_customers.customer_id', $i1->customer_id)->whereNull('ptom_customer_agents.deleted_at')->sum('ptom_consignment_headers.commission_amount');
            }

            $commission_included = $sumdata;
            $tax_amount =  $commission_included * (7 / 107);
            $commission_excluded =  $commission_included * (100 / 107);
            $invoice_b = '';

            foreach ($id_consignment_header as $key => $value) {

                $getItemP = ConsignmentLines::leftJoin('ptom_order_lines', 'ptom_consignment_lines.order_line_id', 'ptom_order_lines.order_line_id')->leftJoin('ptom_order_headers', 'ptom_order_lines.order_header_id', 'ptom_order_headers.order_header_id')->where('ptom_consignment_lines.consignment_header_id', $value->consignment_header_id)->get(['ptom_order_lines.unit_price', 'ptom_consignment_lines.actual_quantity', 'ptom_order_lines.item_id']);
                if (!empty($getItemP) && count($getItemP) != 0) {
                    $vendor = AgentsVendors::where('vendor_id', $value->agent_code)->first();
                    if (empty($vendor)) {
                        $unit_id = 81;
                        $operating_unit = 'การยาสูบแห่งประเทศไทย';
                        $vendor_name = 'การยาสูบแห่งประเทศไทย';
                        $site_name = 'กทม';
                    } else {
                        $unit_id = $vendor->operating_unit ?? '';
                        $operating_unit = $vendor->organization_code ?? '';
                        $vendor_name = $vendor->vendor_name ?? '';
                        $site_name = $vendor->vendor_site_code ?? '';
                    }

                    if ($unit_id == 81) {
                        $ap = 'AP2';
                    } else {
                        $ap = 'AP1';
                    }

                    $taxrate = DB::select("SELECT * FROM PTOM_TAX_RATE_V WHERE CONFIGURATION_ONWER = '" . $operating_unit . "' AND TAX_RATE_CODE LIKE 'PVAT-G7%'");

                    $t = DB::select("SELECT * FROM PTOM_WITHHOLDING_V WHERE SITE = '" . $vendor->vendor_site_code . "'");

                    $ac_id = DB::select("SELECT * FROM PTOM_MAPPING_ACCOUNT_CODE_GL WHERE ACCOUNT_CODE = 'TRX-DOM-AP Invoice-01'");

                    $d = $start_exp[2];
                    $dd = $end_exp[2];
                    $m = $end_exp[1];
                    $y = $end_exp[0] + 543;

                    $ends = Carbon::parse($end)->format('Y-m-d');

                    if ($unit_id == 81) {
                        $counts = TranspotReportModel::whereDate('creation_date', Carbon::now()->format('Y-m-d'))->where('invoice_batch', 'like', 'ระบบขาย/' . $ap . '/' . strtoupper(date_format(date_create($ends), 'd-M-Y')) . '/ค่านายหน้า' . '%')->where('group_id', '!=', $group_id)->orderBy('ap_interface_id', 'DESC')->first();
                    } else {
                        $counts = TranspotReportModel::whereDate('creation_date', Carbon::now()->format('Y-m-d'))->where('invoice_batch', 'like', 'ระบบขาย/' . $ap . '/' . strtoupper(date_format(date_create($ends), 'd-M-Y')) . '/ค่านายหน้า' . $operating_unit . '%')->where('group_id', '!=', $group_id)->orderBy('ap_interface_id', 'DESC')->first();
                    }
                    if (empty($counts)) {
                        $sssum = '';
                    } else {
                        $sssum0 = substr($counts->invoice_batch, strrpos($counts->invoice_batch, '/') + 1);
                        if (is_numeric($sssum0)) {
                            $s = $sssum0 + 1;
                            $sssum = '/' . $s;
                        } else {
                            $sssum = '/1';
                        }
                    }

                    if ($unit_id == 81) {
                        $invoice_b = 'ระบบขาย/' . $ap . '/' . strtoupper(date_format(date_create($ends), 'd-M-Y')) . '/ค่านายหน้า' . $sssum;
                    } else {
                        $invoice_b = 'ระบบขาย/' . $ap . '/' . strtoupper(date_format(date_create($ends), 'd-M-Y')) . '/ค่านายหน้า' . $operating_unit . $sssum;
                    }

                    if ($operating_unit == 'การยาสูบแห่งประเทศไทย') {
                        $t_insert = 'PVAT-S7';
                    } else {
                        $t_insert = empty($taxrate) ? '' : $taxrate[0]->tax_rate_code;
                    }

                    TranspotReportModel::create([
                        'group_id' => $group_id,
                        'interface_module' => 'AP',
                        'from_program_code' => 'OMP0047',
                        'interface_name' => 'ค่านายหน้า',
                        'invoice_batch' => $invoice_b,
                        'batch_date' => date_format(date_create($ends), 'Y-m-d'),
                        'invoice_source' => 'SALE',
                        'org_id' => $unit_id,
                        'operating_unit' => $operating_unit,
                        'invoice_type' => 'STANDARD',
                        'document_category' => 'SALE',
                        'vendor_id' => $value->agent_code ?? '',
                        'vendor_num' => $vendor->vendor_code ?? '',
                        'vendor_name' => $vendor_name,
                        'vendor_site_id' => $vendor->vendor_site_id ?? '',
                        'vendor_site_code' => $vendor->vendor_site_code ?? '',
                        'vendor_site_name' => $site_name,
                        'invoice_date' => date_format(date_create($ends), 'Y-m-d'),
                        'gl_date' => date_format(date_create($ends), 'Y-m-d'),
                        'invoice_currency' => $value->currency,
                        // 'invoice_amount_included_vat' => str_replace(',', '', number_format($commission + $tax_amount, 2)),
                        'invoice_amount_included_vat' => str_replace(',', '', number_format($commission_included, 2)),
                        'invoice_number' => $invoice_number,
                        'header_description' => 'ค่านายหน้า' . $vendor_name . 'วันที่ ' . $d . '-' . $dd . '/' . $m . '/' . $y,
                        'line_number' => $keys,
                        'line_type' => 'ITEM',
                        // 'line_amount_excluded_vat' => str_replace(',', '', number_format($commission, 2)),
                        'line_amount_excluded_vat' => str_replace(',', '', number_format($commission_excluded, 2)),
                        'line_description' => 'ค่านายหน้า' . $vendor_name . 'วันที่ ' . $d . '-' . $dd . '/' . $m . '/' . $y,
                        'tax_code' => $t_insert,
                        'wht_code' => empty($t) ? '' : $t[0]->tax_code,
                        'tax_amount' => str_replace(',', '', number_format($tax_amount, 2)),
                        'doc_ref_code' => $value->consignment_no,
                        'doc_ref_date' => $value->consignment_date,
                        'doc_ref_status' => $value->consignment_status,
                        'customer_id' => $value->customer_id,
                        'program_code' => 'OMP0047',
                        'created_by' => getDefaultData('/users')->user_id,
                        'last_updated_by' => getDefaultData('/users')->user_id,
                        'expense_account_id' => $ac_id[0]->account_id ?? '',
                        'expense_account_code' => 'TRX-DOM-AP Invoice-01',
                        'doc_ref_id' => $last_order_header_id,
                        'web_batch_no' => $web_batch_no,
                        'exp_segment1' => $ac_id[0]->segment1 ?? '',
                        'exp_segment2' => $ac_id[0]->segment2 ?? '',
                        'exp_segment3' => $ac_id[0]->segment3 ?? '',
                        'exp_segment4' => $ac_id[0]->segment4 ?? '',
                        'exp_segment5' => $this->exp_segment($value->consignment_date),
                        'exp_segment6' => $ac_id[0]->segment6 ?? '',
                        'exp_segment7' => $ac_id[0]->segment7 ?? '',
                        'exp_segment8' => $ac_id[0]->segment8 ?? '',
                        'exp_segment9' => $ac_id[0]->segment9 ?? '',
                        'exp_segment1' => $ac_id[0]->segment10 ?? '',
                        'exp_segment11' => $ac_id[0]->segment11 ?? '',
                        'exp_segment12' => $ac_id[0]->segment12 ?? '',
                        'exp_account_combine' => $ac_id[0]->segment1 . '.' . $ac_id[0]->segment2 . '.' . $ac_id[0]->segment3 . '.' . $ac_id[0]->segment4 . '.' . $this->exp_segment($value->consignment_date) . '.' . $ac_id[0]->segment6 . '.' . $ac_id[0]->segment7 . '.' . $ac_id[0]->segment8 . '.' . $ac_id[0]->segment9 . '.' . $ac_id[0]->segment10 . '.' . $ac_id[0]->segment11 . '.' . $ac_id[0]->segment12,
                        'consignment_headers_id' => $value->consignment_header_id
                    ]);
                }
                $number++;
            }
        }

        if ($number == 0) {
            $msg = 'ไม่พบรายการที่สามารถดำเนินการได้';
            $w = '';
        } else {
            $msg = 'ดำเนินการส่งรายการอินเตอร์เฟซแล้ว';
            $w = $invoice_b;
        }

        $msgerror = '';

        OracleCall::callpakcages($web_batch_no);

        $getmsg = TranspotReportModel::where('web_batch_no', $web_batch_no)->where('interface_status', 'R')->first();
        if (!empty($getmsg)) {
            $msgerror = 'มีการยกเลิก Invoice';
        } else {
            $getmsgs = TranspotReportModel::where('web_batch_no', $web_batch_no)->where('interface_status', 'E')->first();
            if (!empty($getmsgs)) {
                $msgerror = $getmsgs->interfaced_msg;
            }
        }

        return response()->json(['status' => 'success', 'data' => $msg, 'group_id' => $w, 'msg' => $msgerror, 'wbn' => $web_batch_no]);
    }

    public function updateConsignemtn(Request $request)
    {
        $update_consign = TranspotReportModel::where('web_batch_no', $request->web_batch_no)->get(['interface_status', 'consignment_headers_id', 'web_batch_no']);
        foreach ($update_consign as $uc) {
            if ($uc->interface_status == "C") {
                DB::update("UPDATE PTOM_CONSIGNMENT_HEADERS SET AGENT_WEB_BATCH_NO = '" . $uc->web_batch_no . "' WHERE CONSIGNMENT_HEADER_ID = '" . $uc->consignment_headers_id . "'");
            }
        }

        return response()->json(['status' => 'success', 'data' => 'success', 'group_id' => $request->web_batch_no, 'msg' => $update_consign]);
    }

    private function exp_segment($invoice_date)
    {
        $ac_id = DB::select("SELECT * FROM PTOM_MAPPING_ACCOUNT_CODE_GL WHERE ACCOUNT_CODE = 'TRX-DOM-AP Invoice-01'");
        if (empty($ac_id) || $ac_id[0]->segment5 == null || $ac_id[0]->segment5 == '') {
            $m = Carbon::parse($invoice_date)->format('m');
            $y = Carbon::parse($invoice_date)->format('Y');
            $yy = substr($y + 543, 2);
            if ($m == 10 || $m == 11 || $m == 12) {
                $yyy = $yy + 1;
            } else {
                $yyy = $yy;
            }
            return $yyy;
        } else {
            return $ac_id[0]->segment5 ?? '';
        }
    }
}
