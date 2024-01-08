<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\ConsignmentHeader;
use App\Models\OM\Customers;
use App\Models\OM\OMVENDOR_SITES_V;
use App\Models\OM\OrderLines;
use App\Models\OM\TranspotModelView;
use App\Models\OM\TranspotRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OM\TranspotReportModel;
use App\Repositories\OM\OracleCall;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use FormatDate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class TranspotReportController extends Controller
{
    public function draftData(Request $request)
    {
        if ($request->ajax()) {
            $check = Validator::make($request->all(), [
                'owner' => 'required',
                'start' => 'required',
                'end' => 'required'
            ], [
                'owner.required' => 'กรุณาระบุรหัสเจ้าหนี้',
                'start.required' => 'กรุณาระบุวันที่เริ่มคำนวน',
                'end.required' => 'กรุณาระบุวันที่สิ้นสุดคำนวน',
            ]);
            if ($check->fails()) {
                return response()->json(['status' => 'error', 'data' => $check->errors()->first()], 200);
            }
            $owner = $request->owner;
            $start_date = parseFromDateTh($request->start);
            $end_date = parseFromDateTh($request->end);
            $today = Carbon::now()->timezone('Asia/Bangkok');
            if (Carbon::parse($end_date)->greaterThan($today)) {
                return response()->json(['status' => 'error', 'data' => 'วันที่สิ้นสุดไม่สามารถมากกว่าวันที่ปัจจุบันได้'], 200);
            }

            $vendor = TranspotModelView::where('vendor_code', $owner)->first(['vendor_id', 'vendor_name', 'vendor_code']);

            if (empty($vendor)) {
                return response()->json(['status' => 'error', 'data' => 'ไม่พบรหัสเจ้าหนี้ กรุณาตรวจสอบการตั้งค่าเว็นเดอร์'], 200);
            }

            $data = [
                'owner' => $owner,
                'start' => $start_date,
                'end' => $end_date,
                'vendor' => $vendor,
                'groupID' => Carbon::now()->format('YmdHis')
            ];

            return response()->json(['status' => 'success', 'data' => $data], 200);
        }
        return back()->withErrors('Method invalid : อนุญาตการเข้าถึงด้วย Ajax เท่านั้น');
    }

    public function createDataone(Request $request)
    {
        $createData = [];
        set_time_limit(0);
        if ($request->ajax()) {
            $input = $request->data;
            $input['normal'] = 0;

            $ordernormal = DB::select("SELECT
                PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
                PTOM_ORDER_LINES.PROMO_FLAG,
                PTOM_CUSTOMERS.CUSTOMER_ID,
                PTOM_CUSTOMERS.CUSTOMER_TYPE_ID,
                PTOM_ORDER_HEADERS.PICK_RELEASE_ID,
                PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
                PTOM_ORDER_HEADERS.PICK_RELEASE_STATUS,
                PTOM_ORDER_HEADERS.CURRENCY,
                SUM(DISTINCT PTOM_ORDER_LINES.APPROVE_QUANTITY) APPROVE_QUANTITY,
                SUM(DISTINCT PTOM_ORDER_LINES.APPROVE_CARDBOARDBOX) APPROVE_CARDBOARDBOX,
                SUM(DISTINCT PTOM_ORDER_LINES.APPROVE_CARTON) APPROVE_CARTON,
                PTOM_ORDER_HEADERS.ORDER_DATE,
                PTOM_ORDER_HEADERS.DELIVERY_DATE,
                PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE,
                PTOM_ORDER_LINES.VAT_CODE,
                PTOM_THAILAND_TERRITORY_V.PROVINCE_THAI,
                PTOM_CUSTOMERS.region_code REGION_THAI,
                PTOM_THAILAND_TERRITORY_V.REGION_ID,
                PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE,
                PTOM_PRODUCT_TYPE_DOMESTIC.MEANING,
                PTOM_ORDER_HEADERS.CLOSE_SALE_FLAG,
                PTOM_ORDER_HEADERS.DELIVERY_WEB_BATCH_NO,
                PTOM_SEQUENCE_ECOMS.PRODUCT_TYPE_CODE
            FROM
                PTOM_ORDER_LINES
                LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID
                LEFT JOIN PTOM_SHIPMENT_BY ON PTOM_ORDER_HEADERS.TRANSPORT_TYPE_CODE = PTOM_SHIPMENT_BY.LOOKUP_CODE
                LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
                LEFT JOIN PTOM_THAILAND_TERRITORY_V ON PTOM_CUSTOMERS.PROVINCE_CODE = PTOM_THAILAND_TERRITORY_V.PROVINCE_ID
                LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE
                LEFT JOIN PTOM_SEQUENCE_ECOMS ON PTOM_ORDER_LINES.ITEM_CODE = PTOM_SEQUENCE_ECOMS.ITEM_CODE
            WHERE
                PTOM_ORDER_HEADERS.TRANSPORT_TYPE_CODE = '20'
                AND PTOM_SHIPMENT_BY.TAG = 'D'
                AND PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL
                AND PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE IS NOT NULL
                AND PTOM_ORDER_HEADERS.CURRENCY IS NOT NULL
                AND PTOM_ORDER_LINES.APPROVE_QUANTITY IS NOT NULL
                AND PTOM_ORDER_HEADERS.DELIVERY_WEB_BATCH_NO IS NULL
                AND PTOM_ORDER_HEADERS.PROGRAM_CODE = 'OMP0019'
                AND TRUNC(PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE) 
                BETWEEN TO_DATE('" . $input['start'] . "', 'YYYY-MM-DD')
                AND TO_DATE('" . $input['end'] . "', 'YYYY-MM-DD')
                AND (
                    PTOM_ORDER_HEADERS.ORDER_STATUS != 'Cancel'
                    OR PTOM_ORDER_HEADERS.ORDER_STATUS != 'Cancelled'
                    OR PTOM_ORDER_HEADERS.ORDER_STATUS != 'Canceller'
                )
                AND (
                    PTOM_ORDER_HEADERS.ATTRIBUTE2 IS NULL
                    OR PTOM_ORDER_HEADERS.ATTRIBUTE2 != 'Y'
                )
            GROUP BY
                PTOM_CUSTOMERS.CUSTOMER_TYPE_ID,
                PTOM_CUSTOMERS.CUSTOMER_ID,
                PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
                PTOM_ORDER_HEADERS.CURRENCY,
                PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE,
                PTOM_ORDER_LINES.VAT_CODE,
                PTOM_THAILAND_TERRITORY_V.PROVINCE_THAI,
                PTOM_ORDER_HEADERS.PICK_RELEASE_STATUS,
                PTOM_CUSTOMERS.region_code,
                PTOM_THAILAND_TERRITORY_V.REGION_ID,
                PTOM_PRODUCT_TYPE_DOMESTIC.MEANING,
                PTOM_ORDER_HEADERS.CLOSE_SALE_FLAG,
                PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE,
                PTOM_ORDER_HEADERS.ORDER_DATE,
                PTOM_ORDER_HEADERS.DELIVERY_DATE,
                PTOM_ORDER_LINES.PROMO_FLAG,
                PTOM_ORDER_HEADERS.PICK_RELEASE_ID,
                PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
                PTOM_ORDER_HEADERS.DELIVERY_WEB_BATCH_NO,
                PTOM_SEQUENCE_ECOMS.PRODUCT_TYPE_CODE
            ");
            $exp_start = explode('-', $input['start']);
            $exp_end = explode('-', $input['end']);
            // $ordernormal = collect($ordernormal)->where('customer_id', '95')->toArray();
            DB::beginTransaction();

            $keys = 0;

            $d = $exp_start[2];
            $dd = $exp_end[2];
            $m = $exp_end[1];
            $y = $exp_end[0] + 543;
            $arr_invoice_batch = [];
            foreach ($ordernormal as $key => $normal) {
                $counts = TranspotReportModel::where('invoice_batch', 'like', 'ระบบขาย/AP3/' . strtoupper(date_format(date_create($input['end']), 'd-M-Y')) . '/ค่าขนส่ง' . $normal->meaning . 'ปกติ%')->where('group_id', '!=', $input['groupID'])->orderBy('ap_interface_id', 'DESC')->first();

                $countss = TranspotReportModel::where('invoice_batch', 'like', 'ระบบขาย/AP3/' . strtoupper(date_format(date_create($input['end']), 'd-M-Y')) . '/ค่าขนส่ง' . $normal->meaning . 'ส่งเสริม%')->where('group_id', '!=', $input['groupID'])->orderBy('ap_interface_id', 'DESC')->first();

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
                if (empty($countss)) {
                    $sssumm = '';
                } else {
                    $ssssum0 = substr($countss->invoice_batch, strrpos($countss->invoice_batch, '/') + 1);
                    if (is_numeric($ssssum0)) {
                        $ss = $ssssum0 + 1;
                        $sssumm = '/' . $ss;
                    } else {
                        $sssumm = '/1';
                    }
                }

                $invoice_b = 'ระบบขาย/AP3/' . strtoupper(date_format(date_create($input['end']), 'd-M-Y')) . '/ค่าขนส่ง' . $normal->meaning . 'ปกติ' . $sssum;
                $invoice_bb = 'ระบบขาย/AP3/' . strtoupper(date_format(date_create($input['end']), 'd-M-Y')) . '/ค่าขนส่ง' . $normal->meaning . 'ส่งเสริม' . $sssumm;

                $input['invoice_bb'] = $invoice_bb;

                if ($normal->delivery_web_batch_no == null) {
                    $input['normal']++;
                    $keys++;

                    $order_date = Carbon::parse($normal->delivery_date)->format('Y-m-d');
                    $rate = TranspotRate::whereDate('rate_start_date', '<=', $order_date)->where(function ($q) use ($order_date) {
                        $q->whereDate('rate_end_date', '>=', $order_date);
                        $q->orWhereNull('rate_end_date');
                    })->first(['cigarette_delivery_rates', 'leaf_delivery_rates', 'other_delivery_rates']);

                    if (empty($rate)) {
                        DB::rollBack();
                        return response()->json(['status' => 'error', 'data' => 'ไม่พบค่าขนส่ง ณ ช่วงวันที่ ' . $order_date . ' กรุณาตรวจสอบค่าขนส่งที่โปรแกรมปรับอัตราค่าขนส่ง'], 200);
                    }

                    $leaf_delivery_rates = $rate->leaf_delivery_rates;
                    $cigarette_delivery_rates = $rate->cigarette_delivery_rates;
                    $other_delivery_rates = $rate->other_delivery_rates;

                    $vendor = OMVENDOR_SITES_V::where('vendor_code', $input['owner'])->first();

                    $max = DB::select("SELECT 
                        PTOM_THAILAND_TERRITORY_V.REGION_THAI,
                        TO_CHAR(PTOM_ORDER_HEADERS.ORDER_DATE,'YYYY-MM-DD') ORDER_DATE 
                    FROM 
                        PTOM_ORDER_LINES 
                        LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID 
                        LEFT JOIN PTOM_SHIPMENT_BY ON PTOM_ORDER_HEADERS.TRANSPORT_TYPE_CODE = PTOM_SHIPMENT_BY.LOOKUP_CODE 
                        LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
                        LEFT JOIN PTOM_THAILAND_TERRITORY_V ON PTOM_CUSTOMERS.PROVINCE_CODE = PTOM_THAILAND_TERRITORY_V.PROVINCE_ID 
                    WHERE 
                        PTOM_ORDER_HEADERS.TRANSPORT_TYPE_CODE = '20' 
                        AND PTOM_SHIPMENT_BY.TAG = 'D' 
                        AND PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL 
                        AND PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE IS NOT NULL 
                        AND PTOM_ORDER_HEADERS.CURRENCY IS NOT NULL 
                        AND PTOM_ORDER_LINES.APPROVE_QUANTITY IS NOT NULL 
                        AND PTOM_ORDER_HEADERS.PROGRAM_CODE = 'OMP0019'
                        AND TRUNC(PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE) 
                        BETWEEN TO_DATE('" . $input['start'] . "', 'YYYY-MM-DD') 
                        AND TO_DATE('" . $input['end'] . "', 'YYYY-MM-DD') 
                        AND PTOM_ORDER_HEADERS.GRAND_TOTAL IS NOT NULL 
                    GROUP BY 
                        PTOM_THAILAND_TERRITORY_V.REGION_THAI,
                        TO_CHAR(PTOM_ORDER_HEADERS.ORDER_DATE,'YYYY-MM-DD') 
                    ORDER BY 
                        TO_CHAR(PTOM_ORDER_HEADERS.ORDER_DATE,'YYYY-MM-DD') DESC FETCH FIRST 1 ROWS ONLY
                    ");

                    $apv_cardboardbox_qty_2 = OrderLines::where('order_header_id', $normal->order_header_id)->first();
                    $apv_carton_qty_2 = OrderLines::where('order_header_id', $normal->order_header_id)->first();
                    if ($normal->product_type_code == "10") {
                        if ($normal->pick_release_status == 'Confirm') {
                            $doc_ref_code = $normal->pick_release_no ?? '';
                            $consignment_header_id = '';
                            if ($normal->promo_flag == 'Y') {
                                $apv_cardboardbox_qty = 0;
                                $apv_carton_qty = 0;
                            } else {
                                $apv_cardboardbox_qty = OrderLines::where('order_header_id', $normal->order_header_id)->sum('approve_cardboardbox');
                                $apv_carton_qty = OrderLines::where('order_header_id', $normal->order_header_id)->sum('approve_carton');

                            }
                            $pick_release_approve_date = $normal->pick_release_approve_date;
                        } else {
                            $doc_ref_code = '';
                            $consignment_header_id = '';
                            $apv_cardboardbox_qty = 0;
                            $apv_carton_qty = 0;
                            $pick_release_approve_date = $normal->pick_release_approve_date;
                        }
                    } else {
                        if ($normal->pick_release_status == 'Confirm') {
                            $doc_ref_code = $normal->pick_release_no ?? '';
                            $consignment_header_id = '';
                            if ($normal->promo_flag == 'Y') {
                                $apv_cardboardbox_qty = 0;
                                $apv_carton_qty = 0;
                            } else {
                                $apv_cardboardbox_qty_1 = OrderLines::where('uom_code','!=', 'CL1')->where('order_header_id', $normal->order_header_id)
                                // ->get();
                                ->sum('approve_quantity');
                                $apv_carton_qty_1 = OrderLines::where('uom_code', 'CL1')->where('order_header_id', $normal->order_header_id)
                                // ->get();
                                ->sum('approve_quantity');
                                $apv_cardboardbox_qty = $this->convertToCS1($apv_cardboardbox_qty_2->uom_code, $apv_cardboardbox_qty_1);
                                $apv_carton_qty = $this->convertToCS1($apv_carton_qty_2->uom_code, $apv_carton_qty_1);
                            }
                            $pick_release_approve_date = $normal->pick_release_approve_date;
                        } else {
                            $doc_ref_code = '';
                            $consignment_header_id = '';
                            $apv_cardboardbox_qty = 0;
                            $apv_carton_qty = 0;
                            $pick_release_approve_date = $normal->pick_release_approve_date;
                        }
                    }

                    if ($normal->product_type_code == "10") {
                        $carfare_apv_amount = ($apv_cardboardbox_qty * $cigarette_delivery_rates) + ($apv_carton_qty * ($cigarette_delivery_rates / 50));
                        $carfare_pro_amount = (convertToCount(1, $normal->approve_quantity) * $cigarette_delivery_rates) + (convertToCount(2, $normal->approve_quantity) * ($cigarette_delivery_rates / 50));
                    } elseif ($normal->product_type_code == "20") {
                        // $carfare_apv_amount = ($apv_cardboardbox_qty * $leaf_delivery_rates) + (($apv_carton_qty * $leaf_delivery_rates) / 50);
                        $carfare_apv_amount = ($apv_cardboardbox_qty * $leaf_delivery_rates) + (($apv_carton_qty * $leaf_delivery_rates) * (12 / 120));
                        // $carfare_pro_amount = (convertToCount(1, $normal->approve_quantity) * $leaf_delivery_rates) + (convertToCount(2, $normal->approve_quantity) * ($leaf_delivery_rates / 50));
                        $carfare_pro_amount = ($apv_cardboardbox_qty * $leaf_delivery_rates) + (($apv_carton_qty * $leaf_delivery_rates) * (120 / 12));
                    } else {
                        $carfare_apv_amount = ($apv_cardboardbox_qty * $other_delivery_rates) + ($apv_carton_qty * ($other_delivery_rates / 50));
                        $carfare_pro_amount = (convertToCount(1, $normal->approve_quantity) * $other_delivery_rates) + (convertToCount(2, $normal->approve_quantity) * ($other_delivery_rates / 50));
                    }

                    array_push($arr_invoice_batch, $invoice_b);
                    if ($normal->pick_release_status != 'cancelled' || $normal->pick_release_status != 'cancel') {
                        // $createData[] =;
                        if ($normal->promo_flag == 'Y') {
                            //create new record ส่งเสริม
                            array_push($arr_invoice_batch, $invoice_bb);
                            if ($normal->pick_release_status != 'cancelled' || $normal->pick_release_status != 'cancel') {
                                // $createData[] = ;
                                TranspotReportModel::create([
                                    'group_id' => $input['groupID'],
                                    'interface_module' => 'AP',
                                    'from_program_code' => 'OMP0042',
                                    'interface_name' => 'ค่าขนส่งส่งเสริม',
                                    'invoice_batch' => $invoice_bb,
                                    'batch_date' => date_format(date_create($input['end']), 'Y-m-d'),
                                    'invoice_source' => 'SALE',
                                    'org_id' => $vendor->operating_unit ?? '',
                                    'operating_unit' => $vendor->organization_code ?? '',
                                    'invoice_type' => 'STANDARD',
                                    'document_category' => 'SALE',
                                    'vendor_id' => $vendor->vendor_id ?? '',
                                    'vendor_num' => $vendor->vendor_code ?? '',
                                    'vendor_name' => $vendor->vendor_name ?? '',
                                    'vendor_site_id' => $vendor->vendor_site_id ?? '',
                                    'vendor_site_code' => $vendor->vendor_site_code ?? '',
                                    'vendor_site_name' => $vendor->vendor_site_code ?? '',
                                    'invoice_date' => $max[0]->order_date ?? '',
                                    'gl_date' => $max[0]->order_date ?? '',
                                    'invoice_currency' => $normal->currency,
                                    'header_description' => 'ค่าขนส่งส่งเสริม' . $normal->meaning . $normal->region_thai . 'วันที่ ' . $d . '-' . $dd . '/' . $m . '/' . $y,
                                    'line_number' => '1',
                                    'line_type' => 'ITEM',
                                    'line_description' => 'ค่าขนส่งส่งเสริม' . $normal->meaning . $normal->region_thai . 'วันที่ ' . $d . '-' . $dd . '/' . $m . '/' . $y,
                                    'doc_ref_id' => $normal->pick_release_id,
                                    'doc_ref_code' => $doc_ref_code,
                                    'consignment_headers_id' => $consignment_header_id,
                                    'doc_ref_date' => $pick_release_approve_date,
                                    'doc_ref_status' => $normal->pick_release_status == 'cancelled' || $normal->pick_release_status == 'cancel' ? '' : $normal->pick_release_status,
                                    'region_code' => $normal->region_thai,
                                    'customer_id' => $normal->customer_id,
                                    'product_type_code' => 'ค่าขนส่ง' . $normal->meaning . 'ส่งเสริม',
                                    'leaf_delivery_rates' => $leaf_delivery_rates,
                                    'cigarette_delivery_rates' => $cigarette_delivery_rates,
                                    'other_delivery_rates' => $other_delivery_rates,
                                    'pro_cardboardbox_qty' => $apv_cardboardbox_qty == 0 ? '' : $apv_cardboardbox_qty,
                                    'pro_carton_qty' => $apv_carton_qty == 0 ? '' : $apv_carton_qty,
                                    'carfare_pro_amount' =>  $carfare_pro_amount == 0 ? '' : str_replace(',', '', number_format($carfare_pro_amount, 6)),
                                    'program_code' => 'OMP0042',
                                    'created_by' => getDefaultData('/users')->user_id,
                                    'last_updated_by' => getDefaultData('/users')->user_id,
                                    'expense_account_id' => $this->exp_segment('account_id', $normal->meaning, ''),
                                    'expense_account_code' => $this->exp_segment('account_code', $normal->meaning, ''),
                                    'exp_segment1' => $this->exp_segment(1, $normal->meaning, $normal->order_date),
                                    'exp_segment2' => $this->exp_segment(2, $normal->meaning, $normal->order_date),
                                    'exp_segment3' => $this->exp_segment(3, $normal->meaning, $normal->order_date),
                                    'exp_segment4' => $this->exp_segment(4, $normal->meaning, $normal->order_date),
                                    'exp_segment5' => $this->exp_segment(5, $normal->meaning, $normal->order_date),
                                    'exp_segment6' => $this->exp_segment(6, $normal->meaning, $normal->order_date),
                                    'exp_segment7' => $this->exp_segment(7, $normal->meaning, $normal->order_date),
                                    'exp_segment8' => $this->exp_segment(8, $normal->meaning, $normal->order_date),
                                    'exp_segment9' => $this->exp_segment(9, $normal->meaning, $normal->order_date),
                                    'exp_segment10' => $this->exp_segment(10, $normal->meaning, $normal->order_date),
                                    'exp_segment11' => $this->exp_segment(11, $normal->meaning, $normal->order_date),
                                    'exp_segment12' => $this->exp_segment(12, $normal->meaning, $normal->order_date),
                                    'exp_account_combine' => $this->exp_segment('exp_account_combine', $normal->meaning, $normal->order_date),
                                    'order_header_id' => $normal->order_header_id
                                ]);
                            }
                        }else {
                            TranspotReportModel::create( [
                                'group_id' => $input['groupID'],
                                'interface_module' => 'AP',
                                'from_program_code' => 'OMP0042',
                                'interface_name' => 'ค่าขนส่งปกติ',
                                'invoice_batch' => $invoice_b,
                                'batch_date' => date_format(date_create($input['end']), 'Y-m-d'),
                                'invoice_source' => 'SALE',
                                'org_id' => $vendor->operating_unit ?? '',
                                'operating_unit' => $vendor->organization_code ?? '',
                                'invoice_type' => 'STANDARD',
                                'document_category' => 'SALE',
                                'vendor_id' => $vendor->vendor_id ?? '',
                                'vendor_num' => $vendor->vendor_code ?? '',
                                'vendor_name' => $vendor->vendor_name ?? '',
                                'vendor_site_id' => $vendor->vendor_site_id ?? '',
                                'vendor_site_code' => $vendor->vendor_site_code ?? '',
                                'vendor_site_name' => $vendor->vendor_site_code ?? '',
                                'invoice_date' => $max[0]->order_date ?? '',
                                'gl_date' => $max[0]->order_date ?? '',
                                'invoice_currency' => $normal->currency,
                                'header_description' => 'ค่าขนส่งปกติ' . $normal->meaning . $normal->region_thai . 'วันที่ ' . $d . '-' . $dd . '/' . $m . '/' . $y,
                                'line_number' => '1',
                                'line_type' => 'ITEM',
                                'line_description' => 'ค่าขนส่งปกติ' . $normal->meaning . $normal->region_thai . 'วันที่ ' . $d . '-' . $dd . '/' . $m . '/' . $y,
                                'doc_ref_id' => $normal->pick_release_id,
                                'doc_ref_code' => $doc_ref_code,
                                'consignment_headers_id' => $consignment_header_id,
                                'doc_ref_date' => $pick_release_approve_date,
                                'doc_ref_status' => $normal->pick_release_status == 'cancelled' || $normal->pick_release_status == 'cancel' ? '' :  $normal->pick_release_status,
                                'region_code' => $normal->region_thai,
                                'customer_id' => $normal->customer_id,
                                'product_type_code' => 'ค่าขนส่ง' . $normal->meaning . 'ปกติ',
                                'leaf_delivery_rates' => $leaf_delivery_rates,
                                'cigarette_delivery_rates' => $cigarette_delivery_rates,
                                'other_delivery_rates' => $other_delivery_rates,
                                'apv_cardboardbox_qty' => $apv_cardboardbox_qty == 0 ? '' : $apv_cardboardbox_qty,
                                'apv_carton_qty' => $apv_carton_qty == 0 ? '' : $apv_carton_qty,
                                'carfare_apv_amount' => $carfare_apv_amount == 0 ? '' : str_replace(',', '', number_format($carfare_apv_amount, 6)),
                                'program_code' => 'OMP0042',
                                'created_by' => getDefaultData('/users')->user_id,
                                'last_updated_by' => getDefaultData('/users')->user_id,
                                'expense_account_id' => $this->exp_segment('account_id', $normal->meaning, ''),
                                'expense_account_code' => $this->exp_segment('account_code', $normal->meaning, ''),
                                'exp_segment1' => $this->exp_segment(1, $normal->meaning, $normal->order_date),
                                'exp_segment2' => $this->exp_segment(2, $normal->meaning, $normal->order_date),
                                'exp_segment3' => $this->exp_segment(3, $normal->meaning, $normal->order_date),
                                'exp_segment4' => $this->exp_segment(4, $normal->meaning, $normal->order_date),
                                'exp_segment5' => $this->exp_segment(5, $normal->meaning, $normal->order_date),
                                'exp_segment6' => $this->exp_segment(6, $normal->meaning, $normal->order_date),
                                'exp_segment7' => $this->exp_segment(7, $normal->meaning, $normal->order_date),
                                'exp_segment8' => $this->exp_segment(8, $normal->meaning, $normal->order_date),
                                'exp_segment9' => $this->exp_segment(9, $normal->meaning, $normal->order_date),
                                'exp_segment10' => $this->exp_segment(10, $normal->meaning, $normal->order_date),
                                'exp_segment11' => $this->exp_segment(11, $normal->meaning, $normal->order_date),
                                'exp_segment12' => $this->exp_segment(12, $normal->meaning, $normal->order_date),
                                'exp_account_combine' => $this->exp_segment('exp_account_combine', $normal->meaning, $normal->order_date),
                                'order_header_id' => $normal->order_header_id
                            ]);
                        }
                    }
                }
                
            }
            // if(count($createData) > 0) {
            //     TranspotReportModel::create($createData);
            // }
            if ($input['normal'] == 0) {
                $datamsg = 'เสร็จสิ้น ไม่พบรายการจัดเตรียมข้อมูลเจ้าหนี้';
            } else {
                DB::commit();
                $datamsg = 'จัดเตรียมข้อมูลเจ้าหนี้' . $input['vendor']['vendor_name'] . 'ระหว่างวันที่ ' . $d . '-' . $dd . '/' . $m . '/' . $y . ' เรียบร้อยแล้ว ค่าขนส่งปกติ ' . $input['normal'] . ' รายการ';
            }

            return response()->json(['status' => 'success', 'data' => $input, 'datamsg' => $datamsg, 'group_id' => $input['groupID'], 'arr_group' => $arr_invoice_batch, 'ordernormal' => $ordernormal, 'input' => $input], 200);
        }
        return back()->withErrors('Method invalid : อนุญาตการเข้าถึงด้วย Ajax เท่านั้น');
    }

    public function createDatatwo(Request $request)
    {
        set_time_limit(0);
        if ($request->ajax()) {
            $input = $request->data;
            $input['promotion'] = 0;

            $orderpromotion = DB::select("SELECT 
                PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
                PTOM_ORDER_LINES.PROMO_FLAG,
                PTOM_CUSTOMERS.CUSTOMER_ID,
                PTOM_CUSTOMERS.CUSTOMER_TYPE_ID,
                PTOM_ORDER_HEADERS.PICK_RELEASE_ID,
                PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
                PTOM_ORDER_HEADERS.PICK_RELEASE_STATUS,
                PTOM_ORDER_HEADERS.CURRENCY,
                SUM(DISTINCT PTOM_ORDER_LINES.APPROVE_QUANTITY) APPROVE_QUANTITY,
                SUM(DISTINCT PTOM_ORDER_LINES.APPROVE_CARDBOARDBOX) APPROVE_CARDBOARDBOX,
                SUM(DISTINCT PTOM_ORDER_LINES.APPROVE_CARTON) APPROVE_CARTON,
                PTOM_ORDER_HEADERS.ORDER_DATE,
                PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE,
                PTOM_ORDER_LINES.VAT_CODE,
                PTOM_THAILAND_TERRITORY_V.PROVINCE_THAI,
                PTOM_CUSTOMERS.region_code REGION_THAI,
                PTOM_THAILAND_TERRITORY_V.REGION_ID,
                PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE,
                PTOM_PRODUCT_TYPE_DOMESTIC.MEANING,
                PTOM_ORDER_HEADERS.CLOSE_SALE_FLAG,
                PTOM_ORDER_HEADERS.DELIVERY_WEB_BATCH_NO,
                PTOM_SEQUENCE_ECOMS.PRODUCT_TYPE_CODE 
            FROM 
                PTOM_ORDER_LINES 
                LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID 
                LEFT JOIN PTOM_SHIPMENT_BY ON PTOM_ORDER_HEADERS.TRANSPORT_TYPE_CODE = PTOM_SHIPMENT_BY.LOOKUP_CODE 
                LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
                LEFT JOIN PTOM_THAILAND_TERRITORY_V ON PTOM_CUSTOMERS.PROVINCE_CODE = PTOM_THAILAND_TERRITORY_V.PROVINCE_ID 
                LEFT JOIN PTOM_PRODUCT_TYPE_DOMESTIC ON PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE 
                LEFT JOIN PTOM_SEQUENCE_ECOMS ON PTOM_ORDER_LINES.ITEM_CODE = PTOM_SEQUENCE_ECOMS.ITEM_CODE 
            WHERE 
                PTOM_ORDER_HEADERS.TRANSPORT_TYPE_CODE = '20' 
                AND PTOM_SHIPMENT_BY.TAG = 'D' 
                AND PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL 
                AND PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE IS NOT NULL 
                AND PTOM_ORDER_HEADERS.CURRENCY IS NOT NULL 
                AND PTOM_ORDER_LINES.APPROVE_QUANTITY IS NOT NULL 
                AND PTOM_ORDER_HEADERS.DELIVERY_WEB_BATCH_NO IS NULL 
                AND PTOM_ORDER_HEADERS.PROGRAM_CODE = 'OMP0020'
                AND TRUNC(PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE) 
                BETWEEN TO_DATE('" . $input['start'] . "', 'YYYY-MM-DD') 
                AND TO_DATE('" . $input['end'] . "', 'YYYY-MM-DD') 
                AND (
                    PTOM_ORDER_HEADERS.ORDER_STATUS != 'Cancel' 
                    OR PTOM_ORDER_HEADERS.ORDER_STATUS != 'Cancelled' 
                    OR PTOM_ORDER_HEADERS.ORDER_STATUS != 'Canceller'
                ) AND (
                    PTOM_ORDER_HEADERS.ATTRIBUTE2 IS NULL 
                    OR PTOM_ORDER_HEADERS.ATTRIBUTE2 != 'Y'
                ) 
            GROUP BY 
                PTOM_CUSTOMERS.CUSTOMER_TYPE_ID,
                PTOM_CUSTOMERS.CUSTOMER_ID,
                PTOM_ORDER_HEADERS.PICK_RELEASE_NO,
                PTOM_ORDER_HEADERS.CURRENCY,
                PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE,
                PTOM_ORDER_LINES.VAT_CODE,
                PTOM_THAILAND_TERRITORY_V.PROVINCE_THAI,
                PTOM_ORDER_HEADERS.PICK_RELEASE_STATUS,
                PTOM_CUSTOMERS.region_code,
                PTOM_THAILAND_TERRITORY_V.REGION_ID,
                PTOM_PRODUCT_TYPE_DOMESTIC.MEANING,
                PTOM_ORDER_HEADERS.CLOSE_SALE_FLAG,
                PTOM_PRODUCT_TYPE_DOMESTIC.LOOKUP_CODE,
                PTOM_ORDER_HEADERS.ORDER_DATE,
                PTOM_ORDER_LINES.PROMO_FLAG,
                PTOM_ORDER_HEADERS.PICK_RELEASE_ID,
                PTOM_ORDER_HEADERS.ORDER_HEADER_ID,
                PTOM_ORDER_HEADERS.DELIVERY_WEB_BATCH_NO,
                PTOM_SEQUENCE_ECOMS.PRODUCT_TYPE_CODE
            ");

            $exp_start = explode('-', $input['start']);
            $exp_end = explode('-', $input['end']);

            $arr_invoice_batch = $request->arr_invoice_batch;

            $d = $exp_start[2];
            $dd = $exp_end[2];
            $m = $exp_end[1];
            $y = $exp_end[0] + 543;

            $keys = 0;
            DB::beginTransaction();

            foreach ($orderpromotion as $key => $promotion) {
                $countss = TranspotReportModel::where('invoice_batch', 'like', 'ระบบขาย/AP3/' . strtoupper(date_format(date_create($input['end']), 'd-M-Y')) . '/ค่าขนส่ง' . $promotion->meaning . 'ส่งเสริม%')->where('group_id', '!=', $input['groupID'])->orderBy('ap_interface_id', 'DESC')->first();

                if (empty($countss)) {
                    $sssumm = '';
                } else {
                    $ssssum0 = substr($countss->invoice_batch, strrpos($countss->invoice_batch, '/') + 1);
                    if (is_numeric($ssssum0)) {
                        $ss = $ssssum0 + 1;
                        $sssumm = '/' . $ss;
                    } else {
                        $sssumm = '/1';
                    }
                }

                $meaning = $promotion->meaning . 'ส่งเสริม';
                $invoice_bb = 'ระบบขาย/AP3/' . strtoupper(date_format(date_create($input['end']), 'd-M-Y')) . '/ค่าขนส่ง' . $meaning . $sssumm;

                if ($promotion->delivery_web_batch_no == null) {
                    $input['promotion']++;
                    $keys++;

                    $order_date = Carbon::parse($promotion->order_date)->format('Y-m-d');
                    $rate = TranspotRate::whereDate('rate_start_date', '<=', $order_date)->where(function ($q) use ($order_date) {
                        $q->whereDate('rate_end_date', '>=', $order_date);
                        $q->orWhereNull('rate_end_date');
                    })->first(['cigarette_delivery_rates', 'leaf_delivery_rates', 'other_delivery_rates']);

                    if (empty($rate)) {
                        DB::rollBack();
                        return response()->json(['status' => 'error', 'data' => 'ไม่พบค่าขนส่ง ณ ช่วงเวลา ' . $order_date . ' กรุณาตรวจสอบค่าขนส่งที่โปรแกรมปรับอัตราค่าขนส่ง'], 200);
                    }

                    $leaf_delivery_rates = $rate->leaf_delivery_rates;
                    $cigarette_delivery_rates = $rate->cigarette_delivery_rates;
                    $other_delivery_rates = $rate->other_delivery_rates;

                    $vendor = OMVENDOR_SITES_V::where('vendor_code', $input['owner'])->first();

                    $max = DB::select("SELECT 
                        PTOM_THAILAND_TERRITORY_V.REGION_THAI,
                        TO_CHAR(PTOM_ORDER_HEADERS.ORDER_DATE,'YYYY-MM-DD') ORDER_DATE 
                    FROM 
                        PTOM_ORDER_LINES 
                        LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID 
                        LEFT JOIN PTOM_SHIPMENT_BY ON PTOM_ORDER_HEADERS.TRANSPORT_TYPE_CODE = PTOM_SHIPMENT_BY.LOOKUP_CODE 
                        LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
                        LEFT JOIN PTOM_THAILAND_TERRITORY_V ON PTOM_CUSTOMERS.PROVINCE_CODE = PTOM_THAILAND_TERRITORY_V.PROVINCE_ID 
                    WHERE 
                        PTOM_ORDER_HEADERS.TRANSPORT_TYPE_CODE = '20' 
                        AND PTOM_SHIPMENT_BY.TAG = 'D' 
                        AND PTOM_ORDER_HEADERS.PICK_RELEASE_NO IS NOT NULL 
                        AND PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE IS NOT NULL 
                        AND PTOM_ORDER_HEADERS.CURRENCY IS NOT NULL 
                        AND PTOM_ORDER_LINES.APPROVE_QUANTITY IS NOT NULL 
                        AND PTOM_ORDER_HEADERS.PROGRAM_CODE = 'OMP0020'
                        AND TRUNC(PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_DATE) 
                        BETWEEN TO_DATE('" . $input['start'] . "', 'YYYY-MM-DD') 
                        AND TO_DATE('" . $input['end'] . "', 'YYYY-MM-DD') 
                        AND PTOM_ORDER_HEADERS.GRAND_TOTAL IS NOT NULL 
                    GROUP BY 
                        PTOM_THAILAND_TERRITORY_V.REGION_THAI,
                        TO_CHAR(PTOM_ORDER_HEADERS.ORDER_DATE,'YYYY-MM-DD') 
                    ORDER BY 
                        TO_CHAR(PTOM_ORDER_HEADERS.ORDER_DATE,'YYYY-MM-DD') DESC FETCH FIRST 1 ROWS ONLY
                    ");

                    $apv_cardboardbox_qty_2 = OrderLines::where('order_header_id', $promotion->order_header_id)->first();
                    $apv_carton_qty_2 = OrderLines::where('order_header_id', $promotion->order_header_id)->first();

                    if ($promotion->pick_release_status == 'Confirm') {
                        $doc_ref_code = $promotion->pick_release_no ?? '';
                        $consignment_header_id = '';
                        $pick_release_approve_date = $promotion->pick_release_approve_date;

                        if($promotion->product_type_code == '10') {
                            $apv_cardboardbox_qty = $promotion->approve_cardboardbox;
                            $apv_carton_qty = $promotion->approve_carton;
                        }else {
                            $apv_cardboardbox_qty_1 = OrderLines::where('uom_code','!=', 'CL1')->where('order_header_id', $promotion->order_header_id)->sum('approve_quantity');
                            $apv_carton_qty_1 = OrderLines::where('uom_code', 'CL1')->where('order_header_id', $promotion->order_header_id)->sum('approve_quantity');
                            $apv_cardboardbox_qty = $this->convertToCS1($apv_cardboardbox_qty_2->uom_code, $apv_cardboardbox_qty_1);
                            $apv_carton_qty = $this->convertToCS1($apv_carton_qty_2->uom_code, $apv_carton_qty_1);
                        }
                    } else {
                        $doc_ref_code = '';
                        $consignment_header_id = '';
                        $pick_release_approve_date = $promotion->pick_release_approve_date;
                        $apv_cardboardbox_qty = 0;
                        $apv_carton_qty = 0;
                    }

                    if ($promotion->product_type_code == "10") {
                        $carfare_apv_amount = ($apv_cardboardbox_qty * $cigarette_delivery_rates) + ($apv_carton_qty * ($cigarette_delivery_rates / 50));
                        $carfare_pro_amount = ($apv_cardboardbox_qty * $cigarette_delivery_rates) + ($apv_carton_qty * ($cigarette_delivery_rates / 50));
                    } elseif ($promotion->product_type_code == "20") {
                        $carfare_apv_amount = ($apv_cardboardbox_qty * $leaf_delivery_rates) + (($apv_carton_qty * $leaf_delivery_rates) * (12 / 120));
                        // $carfare_apv_amount = ($apv_cardboardbox_qty * $leaf_delivery_rates) + ($apv_carton_qty * ($leaf_delivery_rates / 50));
                        $carfare_pro_amount = ($apv_cardboardbox_qty * $leaf_delivery_rates) + (($apv_carton_qty * $leaf_delivery_rates) * (120 / 12));
                    } else {
                        $carfare_apv_amount = ($apv_cardboardbox_qty * $other_delivery_rates) + ($apv_carton_qty * ($other_delivery_rates / 50));
                        $carfare_pro_amount = (convertToCount(1, $promotion->approve_quantity) * $other_delivery_rates) + (convertToCount(2, $promotion->approve_quantity) * ($other_delivery_rates / 50));
                    }

                    array_push($arr_invoice_batch, $invoice_bb);

                    if ($promotion->pick_release_status != 'cancelled' || $promotion->pick_release_status != 'cancel') {
                        
                        TranspotReportModel::create([
                            'group_id' => $input['groupID'],
                            'interface_module' => 'AP',
                            'from_program_code' => 'OMP0042',
                            'interface_name' => 'ค่าขนส่งส่งเสริม',
                            'invoice_batch' => $invoice_bb,
                            'batch_date' => date_format(date_create($input['end']), 'Y-m-d'),
                            'invoice_source' => 'SALE',
                            'org_id' => $vendor->operating_unit ?? '',
                            'operating_unit' => $vendor->organization_code ?? '',
                            'invoice_type' => 'STANDARD',
                            'document_category' => 'SALE',
                            'vendor_id' => $vendor->vendor_id ?? '',
                            'vendor_num' => $vendor->vendor_code ?? '',
                            'vendor_name' => $vendor->vendor_name ?? '',
                            'vendor_site_id' => $vendor->vendor_site_id ?? '',
                            'vendor_site_code' => $vendor->vendor_site_code ?? '',
                            'vendor_site_name' => $vendor->vendor_site_code ?? '',
                            'invoice_date' => $max[0]->order_date ?? '',
                            'gl_date' => $max[0]->order_date ?? '',
                            'invoice_currency' => $promotion->currency,
                            'header_description' => 'ค่าขนส่งส่งเสริม' . $promotion->meaning . $promotion->region_thai . 'วันที่ ' . $d . '-' . $dd . '/' . $m . '/' . $y,
                            'line_number' => '1',
                            'line_type' => 'ITEM',
                            'line_description' => 'ค่าขนส่งส่งเสริม' . $promotion->meaning . $promotion->region_thai . 'วันที่ ' . $d . '-' . $dd . '/' . $m . '/' . $y,
                            'doc_ref_id' => $promotion->pick_release_id,
                            'doc_ref_code' => $doc_ref_code,
                            'consignment_headers_id' => $consignment_header_id,
                            'doc_ref_date' => $pick_release_approve_date,
                            'doc_ref_status' => $promotion->pick_release_status == 'cancelled' || $promotion->pick_release_status == 'cancel' ? '' : $promotion->pick_release_status,
                            'region_code' => $promotion->region_thai,
                            'customer_id' => $promotion->customer_id,
                            'product_type_code' => 'ค่าขนส่ง' . $meaning,
                            'leaf_delivery_rates' => $leaf_delivery_rates,
                            'cigarette_delivery_rates' => $cigarette_delivery_rates,
                            'other_delivery_rates' => $other_delivery_rates,
                            'pro_cardboardbox_qty' => $apv_cardboardbox_qty == 0 ? '' : $apv_cardboardbox_qty,
                            'pro_carton_qty' => $apv_carton_qty == 0 ? '' : $apv_carton_qty,
                            'carfare_pro_amount' =>  $carfare_pro_amount == 0 ? '' : str_replace(',', '', number_format($carfare_pro_amount, 6)),
                            'program_code' => 'OMP0042',
                            'created_by' => getDefaultData('/users')->user_id,
                            'last_updated_by' => getDefaultData('/users')->user_id,
                            'expense_account_id' => $this->exp_segment('account_id', $meaning, ''),
                            'expense_account_code' => $this->exp_segment('account_code', $meaning, ''),
                            'exp_segment1' => $this->exp_segment(1, $meaning, $promotion->order_date),
                            'exp_segment2' => $this->exp_segment(2, $meaning, $promotion->order_date),
                            'exp_segment3' => $this->exp_segment(3, $meaning, $promotion->order_date),
                            'exp_segment4' => $this->exp_segment(4, $meaning, $promotion->order_date),
                            'exp_segment5' => $this->exp_segment(5, $meaning, $promotion->order_date),
                            'exp_segment6' => $this->exp_segment(6, $meaning, $promotion->order_date),
                            'exp_segment7' => $this->exp_segment(7, $meaning, $promotion->order_date),
                            'exp_segment8' => $this->exp_segment(8, $meaning, $promotion->order_date),
                            'exp_segment9' => $this->exp_segment(9, $meaning, $promotion->order_date),
                            'exp_segment10' => $this->exp_segment(10, $meaning, $promotion->order_date),
                            'exp_segment11' => $this->exp_segment(11, $meaning, $promotion->order_date),
                            'exp_segment12' => $this->exp_segment(12, $meaning, $promotion->order_date),
                            'exp_account_combine' => $this->exp_segment('exp_account_combine', $meaning, $promotion->order_date),
                            'order_header_id' => $promotion->order_header_id
                        ]);
                    }
                }
            }

            if ($input['normal'] == 0 && $input['promotion'] == 0) {
                $datamsg = 'เสร็จสิ้น ไม่พบรายการจัดเตรียมข้อมูลเจ้าหนี้';
            } else {
                if ($input['promotion'] == 0 && $input['normal'] == 0) {
                    $datamsg = 'เสร็จสิ้น ไม่พบรายการจัดเตรียมข้อมูลเจ้าหนี้';
                } else {
                    $datamsg = 'จัดเตรียมข้อมูลเจ้าหนี้' . $input['vendor']['vendor_name'] . 'ระหว่างวันที่ ' . $d . '-' . $dd . '/' . $m . '/' . $y . ' เรียบร้อยแล้ว ค่าขนส่งปกติ ' . $input['normal'] . ' รายการ และ ค่าขนส่งส่งเสริม ' . $input['promotion'] . ' รายการ';
                }
                DB::commit();
            }


            return response()->json(['status' => 'success', 'datamsg' => $datamsg, 'group_id' => $input['groupID'], 'arr_group' => $arr_invoice_batch], 200);
        }
        return back()->withErrors('Method invalid : อนุญาตการเข้าถึงด้วย Ajax เท่านั้น');
    }

    public function createDatathree(Request $request)
    {
        set_time_limit(0);
        $data = $request->data;
        $group_id = $data['group_id'] ?? $data['groupID'];
        $datamsg = $data['datamsg'] ?? $data['msg'];
        $arr_group = $request->arr_group;

        $updateinvoice_numbers = TranspotReportModel::where('group_id', $group_id)->groupBy(['line_description'])->get(['line_description']);
        if (!empty($updateinvoice_numbers)) {
            foreach ($updateinvoice_numbers as $invoice_number) {
                $in_number = invoiceNumberForTest(Carbon::now()->format('Y-m-d'));
                TranspotReportModel::where('group_id', $group_id)->where('line_description', $invoice_number->line_description)->update(['invoice_number' => $in_number]);
            }
        }

        $data = TranspotReportModel::where('group_id', $group_id)->groupBy(['group_id', 'invoice_batch', 'vendor_num', 'interface_name', 'region_code'])->get(['group_id', 'invoice_batch', 'vendor_num', 'interface_name', 'region_code', DB::raw("SUM(CARFARE_APV_AMOUNT) CARFARE_APV_AMOUNT"), DB::raw("SUM(CARFARE_PRO_AMOUNT) CARFARE_PRO_AMOUNT")]);

        if (!empty($data)) {
            foreach ($data as $k) {
                if ($k->interface_name == 'ค่าขนส่งส่งเสริม') {
                    TranspotReportModel::where('group_id', $k->group_id)->where('invoice_batch', $k->invoice_batch)->where('vendor_num', $k->vendor_num)->where('interface_name', $k->interface_name)->where('region_code', $k->region_code)->update(['line_amount_excluded_vat' => str_replace(',', '', number_format($k->carfare_pro_amount, 2)), 'invoice_amount_included_vat' => str_replace(',', '', number_format($k->carfare_pro_amount, 2))]);
                } else {
                    TranspotReportModel::where('group_id', $k->group_id)->where('invoice_batch', $k->invoice_batch)->where('vendor_num', $k->vendor_num)->where('interface_name', $k->interface_name)->where('region_code', $k->region_code)->update(['line_amount_excluded_vat' => str_replace(',', '', number_format($k->carfare_apv_amount, 2)), 'invoice_amount_included_vat' => str_replace(',', '', number_format($k->carfare_apv_amount, 2))]);
                }
            }
        }

        return response()->json(['status' => 'success', 'datamsg' => $datamsg, 'group_id' => $group_id, 'arr_group' => $arr_group], 200);
    }


    public function createDataToAP(Request $request)
    {
        $webBN = Carbon::now()->format('YmdHis');
        $interface_name = $request->interfaceName;
        $group_id = explode(',', $request->group_id);

        $t = TranspotReportModel::whereIn('invoice_batch', $group_id)->where('interface_name', $interface_name)->update(['web_batch_no' => $webBN]);

        OracleCall::callpakcages($webBN);

        
        $update_batch_deliverys = TranspotReportModel::where('invoice_batch', $group_id)->where('interface_name', $interface_name)->groupBy(['order_header_id', 'consignment_headers_id', 'interfaced_msg', 'interface_status'])->get(['order_header_id', 'consignment_headers_id', 'interfaced_msg', 'interface_status']);
        if (!empty($update_batch_deliverys)) {
            foreach ($update_batch_deliverys as $ubd) {
                if (strtoupper($ubd->interface_status) == 'C') {
                    if ($ubd->consignment_headers_id == null) {
                        //update ptom_order_headers.DELIVERY_WEB_BATCH_NO
                        if ($ubd->order_header_id != null) {
                            OrderHeader::where('order_header_id', $ubd->order_header_id)->update(['delivery_web_batch_no' => 'Y']);
                        }
                    } else {
                        //update ptom_consignment_headers.DELIVERY_WEB_BATCH_NO
                        ConsignmentHeader::where('consignment_header_id', $ubd->consignment_headers_id)->update(['delivery_web_batch_no' => 'Y']);
                        if ($ubd->order_header_id != null) {
                            OrderHeader::where('order_header_id', $ubd->order_header_id)->update(['delivery_web_batch_no' => 'Y']);
                        }
                    }
                }
            }
        }

        $msg = TranspotReportModel::where('invoice_batch', $group_id)->where('interface_name', $interface_name)->where('interface_status', '!=', 'C')->whereNotNull('interfaced_msg')->first();
        if (empty($msg)) {
            $msg = TranspotReportModel::where('invoice_batch', $group_id)->where('interface_name', $interface_name)->whereNotNull('interfaced_msg')->first();
        }

        return response()->json(['status' => 'success', 'msg' => $msg->interfaced_msg ?? '', 't' => $t, 'group_id' => $group_id], 200);
    }

    private function exp_segment($number, $type, $invoice_date)
    {
        if ($type == 'บุหรี่ส่งเสริม') {
            $ac_id = DB::select("SELECT * FROM PTOM_MAPPING_ACCOUNT_CODE_GL WHERE ACCOUNT_CODE = 'TRX-DOM-AP Invoice-05'");
        }elseif ($type == 'ยาเส้นส่งเสริม') {
            $ac_id = DB::select("SELECT * FROM PTOM_MAPPING_ACCOUNT_CODE_GL WHERE ACCOUNT_CODE = 'TRX-DOM-AP Invoice-06'");
        }elseif ($type == 'บุหรี่') {
            $ac_id = DB::select("SELECT * FROM PTOM_MAPPING_ACCOUNT_CODE_GL WHERE ACCOUNT_CODE = 'TRX-DOM-AP Invoice-02'");
        } else {
            $ac_id = DB::select("SELECT * FROM PTOM_MAPPING_ACCOUNT_CODE_GL WHERE ACCOUNT_CODE = 'TRX-DOM-AP Invoice-03'");
        }

        if (empty($ac_id)) {
            return '';
        }

        if ($number == 'account_id') {
            return $ac_id[0]->account_id;
        } elseif ($number == 'account_code') {
            return $ac_id[0]->account_code;
        }

        if ($number == 1) {
            return $ac_id[0]->segment1 ?? '';
        } elseif ($number == 2) {
            return $ac_id[0]->segment2 ?? '';
        } elseif ($number == 3) {
            return $ac_id[0]->segment3 ?? '';
        } elseif ($number == 4) {
            return $ac_id[0]->segment4 ?? '';
        } elseif ($number == 5) {
            if ($ac_id[0]->segment5 == null || $ac_id[0]->segment5 == '') {
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
        } elseif ($number == 6) {
            return $ac_id[0]->segment6 ?? '';
        } elseif ($number == 7) {
            return $ac_id[0]->segment7 ?? '';
        } elseif ($number == 8) {
            return $ac_id[0]->segment8 ?? '';
        } elseif ($number == 9) {
            return $ac_id[0]->segment9 ?? '';
        } elseif ($number == 10) {
            return $ac_id[0]->segment10 ?? '';
        } elseif ($number == 11) {
            return $ac_id[0]->segment11 ?? '';
        } elseif ($number == 12) {
            return $ac_id[0]->segment12 ?? '';
        } else {
            if ($ac_id[0]->segment5 == null || $ac_id[0]->segment5 == '') {
                $m = Carbon::parse($invoice_date)->format('m');
                $y = Carbon::parse($invoice_date)->format('Y');
                $yy = substr($y + 543, 2);
                if ($m == 10 || $m == 11 || $m == 12) {
                    $yyy = $yy + 1;
                } else {
                    $yyy = $yy;
                }
            } else {
                $yyy = $ac_id[0]->segment5 ?? '';
            }
            return $ac_id[0]->segment1 . '.' . $ac_id[0]->segment2 . '.' . $ac_id[0]->segment3 . '.' . $ac_id[0]->segment4 . '.' . $yyy . '.' . $ac_id[0]->segment6 . '.' . $ac_id[0]->segment7 . '.' . $ac_id[0]->segment8 . '.' . $ac_id[0]->segment9 . '.' . $ac_id[0]->segment10 . '.' . $ac_id[0]->segment11 . '.' . $ac_id[0]->segment12;
        }
    }

    public function print()
    {
        $start = request()->start;
        $end = request()->end;
        $group_id = request()->group_id;
        $invoice_batch = request()->invoice_batch;
        // if ($start == '' || $end == '' || $group_id == '') {
        //     return 'Parameters invalid';
        // }

        $new_start = FormatDate::convertThaidateFromSplash($start);
        $new_end = FormatDate::convertThaidateFromSplash($end);

        $data_1 = [];
        $data_2 = [];
        $data_3 = [];
        $data_4 = [];


        $data1 = DB::select("
            SELECT REGION_CODE 
            FROM PTOM_AP_INTERFACES 
            WHERE 1=1
            AND GROUP_ID = nvl('$group_id', GROUP_ID) 
            AND INVOICE_BATCH = nvl('$invoice_batch', INVOICE_BATCH)
            AND PRODUCT_TYPE_CODE = 'ค่าขนส่งบุหรี่ปกติ' 
            AND INTERFACE_NAME = 'ค่าขนส่งปกติ' 
            AND FROM_PROGRAM_CODE = 'OMP0042' 
            GROUP BY REGION_CODE 
            ORDER BY REGION_CODE ASC
        ");

        foreach ($data1 as $d1) {
            $data[$d1->region_code] = $this->getInfoDataAP($d1->region_code, $group_id, 'ค่าขนส่งบุหรี่ปกติ', 'ค่าขนส่งปกติ', $invoice_batch);
            array_push($data_1, $data);
        }

        $data2 = DB::select("
            SELECT REGION_CODE 
            FROM PTOM_AP_INTERFACES 
            WHERE 1=1
            AND GROUP_ID = nvl('$group_id', GROUP_ID)
            AND INVOICE_BATCH = nvl('$invoice_batch', INVOICE_BATCH) 
            AND PRODUCT_TYPE_CODE = 'ค่าขนส่งบุหรี่ส่งเสริม' 
            AND INTERFACE_NAME = 'ค่าขนส่งส่งเสริม' 
            AND FROM_PROGRAM_CODE = 'OMP0042' 
            GROUP BY REGION_CODE 
            ORDER BY REGION_CODE ASC
        ");

        foreach ($data2 as $d2) {
            $data[$d2->region_code] = $this->getInfoDataAP($d2->region_code, $group_id, 'ค่าขนส่งบุหรี่ส่งเสริม', 'ค่าขนส่งส่งเสริม', $invoice_batch);
            array_push($data_2, $data);
        }

        $data3 = DB::select("
            SELECT REGION_CODE 
            FROM PTOM_AP_INTERFACES 
            WHERE 1=1
            AND GROUP_ID = nvl('$group_id', GROUP_ID) 
            AND INVOICE_BATCH = nvl('$invoice_batch', INVOICE_BATCH)
            AND PRODUCT_TYPE_CODE = 'ค่าขนส่งยาเส้นปกติ' 
            AND INTERFACE_NAME = 'ค่าขนส่งปกติ' 
            AND FROM_PROGRAM_CODE = 'OMP0042' 
            GROUP BY REGION_CODE 
            ORDER BY REGION_CODE ASC
        ");

        foreach ($data3 as $d3) {
            $data[$d3->region_code] = $this->getInfoDataAP($d3->region_code, $group_id, 'ค่าขนส่งยาเส้นปกติ', 'ค่าขนส่งปกติ', $invoice_batch);
            array_push($data_3, $data);
        }

        $data4 = DB::select("
            SELECT REGION_CODE 
            FROM PTOM_AP_INTERFACES 
            WHERE 1=1
            AND GROUP_ID = nvl('$group_id', GROUP_ID) 
            AND INVOICE_BATCH = nvl('$invoice_batch', INVOICE_BATCH)
            AND PRODUCT_TYPE_CODE = 'ค่าขนส่งยาเส้นส่งเสริม' 
            AND INTERFACE_NAME = 'ค่าขนส่งส่งเสริม' 
            AND FROM_PROGRAM_CODE = 'OMP0042' 
            GROUP BY REGION_CODE 
            ORDER BY REGION_CODE ASC
        ");

        foreach ($data4 as $d4) {
            $data[$d4->region_code] = $this->getInfoDataAP($d4->region_code, $group_id, 'ค่าขนส่งยาเส้นส่งเสริม', 'ค่าขนส่งส่งเสริม', $invoice_batch);
            array_push($data_4, $data);
        }

        $new_data_1 = count($data_1) > 0 ? end($data_1) : $data_1;
        $new_data_2 = count($data_2) > 0 ? end($data_2) : $data_2;
        $new_data_3 = count($data_3) > 0 ? end($data_3) : $data_3;
        $new_data_4 = count($data_4) > 0 ? end($data_4) : $data_4;

        // $pages = array();
        $openwindow = '<script>';
        if (count($new_data_1) > 0) {
            // $pages1 = View::make('om.transpot_report.print_1', compact('new_data_1'));

            // $pdf = SnappyPdf::loadView('om.transpot_report.print_1', compact('new_data_1'));
            // $pdf->setPaper('a4')->setOrientation('landscape')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setTimeout(300);

            // return $pdf->inline();
            $openwindow .= " window.open('/om/transpot-report/print_1?group_id={$group_id}&start={$start}&end=$end&invoice_batch=$invoice_batch'); ";
        }
        if (count($new_data_2) > 0) {
            // $pages2 = View::make('om.transpot_report.print_2', compact('new_data_2'));
            $openwindow .= " window.open('/om/transpot-report/print_2?group_id={$group_id}&start={$start}&end=$end&invoice_batch=$invoice_batch'); ";
        }
        if (count($new_data_3) > 0) {
            // $pages3 = View::make('om.transpot_report.print_3', compact('new_data_3'));
            $openwindow .= " window.open('/om/transpot-report/print_3?group_id={$group_id}&start={$start}&end=$end&invoice_batch=$invoice_batch'); ";
        }
        if (count($new_data_4) > 0) {
            // $pages4 = View::make('om.transpot_report.print_4', compact('new_data_4'));
            $openwindow .= " window.open('/om/transpot-report/print_4?group_id={$group_id}&start={$start}&end=$end&invoice_batch=$invoice_batch'); ";
        }


        if (count($new_data_1) == 0 && count($new_data_2) == 0 && count($new_data_3) == 0 && count($new_data_4) == 0) {
            return 'Not data to preview';
        } else {
            // $pdf = SnappyPdf::loadView('om.transpot_report.print', ['pages' => $pages]);
            // $pdf->setPaper('a4')->setOrientation('landscape')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setTimeout(300);

            // return $pdf->inline();

            // return view('om.transpot_report.print', ['pages' => $pages]);
        }
        $openwindow .= '</script>';
        echo $openwindow;
        exit();
    }
    function convertToCS1($uom_code, $count)
    {
        if($uom_code == 'CS1') {
            return $count;
        } elseif ($uom_code == 'PTN') {
            return ceil($count  * (1/120));
        } elseif ($uom_code == 'E00') {
            return ceil($count * (1/120));
        } elseif ($uom_code == 'CL1') {
            return $count;
        } elseif ($uom_code == 'CGK') {
            return ceil($count * (1/120));
        } else {
            return 1;
        }
    }
    public function print_1()
    {
        $start = request()->start;
        $end = request()->end;
        $group_id = request()->group_id;
        $invoice_batch = request()->invoice_batch;
        // if ($start == '' || $end == '' || $group_id == '') {
        //     return 'Parameters invalid';
        // }

        // $new_start = FormatDate::convertThaidateFromSplash($start);
        // $new_end = FormatDate::convertThaidateFromSplash($end);

        $data_1 = [];

        $data1 = DB::select("
            SELECT REGION_CODE 
            FROM PTOM_AP_INTERFACES 
            WHERE 1=1
            AND GROUP_ID = nvl('$group_id', GROUP_ID) 
            AND INVOICE_BATCH = nvl('$invoice_batch', INVOICE_BATCH)
            AND PRODUCT_TYPE_CODE = 'ค่าขนส่งบุหรี่ปกติ' 
            AND INTERFACE_NAME = 'ค่าขนส่งปกติ' 
            AND FROM_PROGRAM_CODE = 'OMP0042' 
            GROUP BY REGION_CODE 
            ORDER BY REGION_CODE ASC
        ");

        foreach ($data1 as $d1) {
            $data[$d1->region_code] = collect($this->getInfoDataAP($d1->region_code, $group_id, 'ค่าขนส่งบุหรี่ปกติ', 'ค่าขนส่งปกติ', $invoice_batch))->sortBy(function($i) {
                return $i['doc_ref_date'].$i['doc_ref_code'];
            });
            array_push($data_1, $data);
        }

        $new_data_1 = count($data_1) > 0 ? end($data_1) : $data_1;
        if (count($new_data_1) > 0) {
            $pdf = SnappyPdf::loadView('om.transpot_report.print_1', compact('new_data_1'));
            $pdf->setPaper('a4')->setOrientation('landscape')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setTimeout(300);

            return $pdf->inline();
        }

        if (count($new_data_1) == 0) {
            return 'Not data to preview';
        }
    }

    public function print_2()
    {
        $start = request()->start;
        $end = request()->end;
        $group_id = request()->group_id;
        $invoice_batch = request()->invoice_batch;
        // if ($start == '' || $end == '' || $group_id == '') {
        //     return 'Parameters invalid';
        // }

        // $new_start = FormatDate::convertThaidateFromSplash($start);
        // $new_end = FormatDate::convertThaidateFromSplash($end);
        $data_2 = [];
        $data2 = DB::select("
            SELECT REGION_CODE 
            FROM PTOM_AP_INTERFACES 
            WHERE 1=1
            AND GROUP_ID = nvl('$group_id', GROUP_ID)
            AND INVOICE_BATCH = nvl('$invoice_batch', INVOICE_BATCH) 
            AND PRODUCT_TYPE_CODE = 'ค่าขนส่งบุหรี่ส่งเสริม' 
            AND INTERFACE_NAME = 'ค่าขนส่งส่งเสริม' 
            AND FROM_PROGRAM_CODE = 'OMP0042' 
            GROUP BY REGION_CODE 
            ORDER BY REGION_CODE ASC
        ");

        foreach ($data2 as $d2) {
            $data[$d2->region_code] = collect($this->getInfoDataAP2($d2->region_code, $group_id, 'ค่าขนส่งบุหรี่ส่งเสริม', 'ค่าขนส่งส่งเสริม', $invoice_batch))->sortBy(function($i) {
                return $i['doc_ref_date'].$i['doc_ref_code'];
            });
            array_push($data_2, $data);
        }

        $new_data_2 = count($data_2) > 0 ? end($data_2) : $data_2;

        if (count($new_data_2) > 0) {
            $pdf = SnappyPdf::loadView('om.transpot_report.print_2', compact('new_data_2'));
            $pdf->setPaper('a4')->setOrientation('landscape')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setTimeout(300);

            return $pdf->inline();
        }

        if (count($new_data_2) == 0) {
            return 'Not data to preview';
        }
    }

    public function print_3()
    {
        $start = request()->start;
        $end = request()->end;
        $group_id = request()->group_id;
        $invoice_batch = request()->invoice_batch;
        // if ($start == '' || $end == '' || $group_id == '') {
        //     return 'Parameters invalid';
        // }

        // $new_start = FormatDate::convertThaidateFromSplash($start);
        // $new_end = FormatDate::convertThaidateFromSplash($end);

        $data_3 = [];
        $data3 = DB::select("
            SELECT REGION_CODE 
            FROM PTOM_AP_INTERFACES 
            WHERE 1=1
            AND GROUP_ID = nvl('$group_id', GROUP_ID) 
            AND INVOICE_BATCH = nvl('$invoice_batch', INVOICE_BATCH)
            AND PRODUCT_TYPE_CODE = 'ค่าขนส่งยาเส้นปกติ' 
            AND INTERFACE_NAME = 'ค่าขนส่งปกติ' 
            AND FROM_PROGRAM_CODE = 'OMP0042' 
            GROUP BY REGION_CODE 
            ORDER BY REGION_CODE ASC
        ");

        foreach ($data3 as $d3) {
            $data[$d3->region_code] = collect($this->getInfoDataAP($d3->region_code, $group_id, 'ค่าขนส่งยาเส้นปกติ', 'ค่าขนส่งปกติ', $invoice_batch))->sortBy(function($i) {
                return $i['doc_ref_date'].$i['doc_ref_code'];
            });
            array_push($data_3, $data);
        }

        $new_data_3 = count($data_3) > 0 ? end($data_3) : $data_3;
        if (count($new_data_3) > 0) {
            $pdf = SnappyPdf::loadView('om.transpot_report.print_3', compact('new_data_3'));
            $pdf->setPaper('a4')->setOrientation('landscape')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setTimeout(300);

            return $pdf->inline();
        }

        if (count($new_data_3) == 0) {
            return 'Not data to preview';
        }
    }

    public function print_4()
    {
        $start = request()->start;
        $end = request()->end;
        $group_id = request()->group_id;
        $invoice_batch = request()->invoice_batch;
        // if ($start == '' || $end == '' || $group_id == '') {
        //     return 'Parameters invalid';
        // }

        // $new_start = FormatDate::convertThaidateFromSplash($start);
        // $new_end = FormatDate::convertThaidateFromSplash($end);
        $data_4 = [];
        $data4 = DB::select("
            SELECT REGION_CODE 
            FROM PTOM_AP_INTERFACES 
            WHERE 1=1
            AND GROUP_ID = nvl('$group_id', GROUP_ID) 
            AND INVOICE_BATCH = nvl('$invoice_batch', INVOICE_BATCH)
            AND PRODUCT_TYPE_CODE = 'ค่าขนส่งยาเส้นส่งเสริม' 
            AND INTERFACE_NAME = 'ค่าขนส่งส่งเสริม' 
            AND FROM_PROGRAM_CODE = 'OMP0042' 
            GROUP BY REGION_CODE 
            ORDER BY REGION_CODE ASC
        ");

        foreach ($data4 as $d4) {
            $data[$d4->region_code] = collect($this->getInfoDataAP2($d4->region_code, $group_id, 'ค่าขนส่งยาเส้นส่งเสริม', 'ค่าขนส่งส่งเสริม', $invoice_batch))->sortBy(function($i) {
                return $i['doc_ref_date'].$i['doc_ref_code'];
            });
            array_push($data_4, $data);
        }

        $new_data_4 = count($data_4) > 0 ? end($data_4) : $data_4;
        if (count($new_data_4) > 0) {
            $pdf = SnappyPdf::loadView('om.transpot_report.print_4', compact('new_data_4'));
            $pdf->setPaper('a4')->setOrientation('landscape')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setTimeout(300);

            return $pdf->inline();
        }

        if (count($new_data_4) == 0) {
            return 'Not data to preview';
        }
    }

    private function getInfoDataAP2($region_code, $group_id, $product_type, $interface, $invoice_batch)
    {
        $newdata = [];
        $data = TranspotReportModel::whereRaw("ptom_ap_interfaces.group_id = nvl('$group_id', ptom_ap_interfaces.group_id)")
        ->whereRaw("ptom_ap_interfaces.invoice_batch = nvl('$invoice_batch', ptom_ap_interfaces.invoice_batch)")
        ->where('ptom_ap_interfaces.region_code', $region_code)
        ->leftjoin('ptom_order_headers', 'ptom_order_headers.pick_release_no', '=','ptom_ap_interfaces.doc_ref_code')
        ->leftJoin('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_ap_interfaces.customer_id')
        ->where('ptom_ap_interfaces.product_type_code', $product_type)
        ->where('ptom_ap_interfaces.interface_name', $interface)
        ->where('ptom_ap_interfaces.from_program_code', 'OMP0042')
        ->selectRaw('ptom_ap_interfaces.*, ptom_customers.*, ptom_order_headers.product_type_code order_product_type_code')
        ->orderBy('ptom_ap_interfaces.doc_ref_date', 'ASC')
        ->get();

        foreach ($data as $d) {
            $dd['doc_ref_date'] = Carbon::parse($d->doc_ref_date)->format('Y-m-d');
            $dd['doc_ref_code'] = $d->doc_ref_code;
            $dd['leaf_delivery_rates'] =number_format($d->leaf_delivery_rates, 6);
            $dd['leaf_delivery_rates2'] =number_format($d->leaf_delivery_rates * (12 / 120), 6);
            $dd['product_type_code'] = $d->product_type_code;
            $dd['invoice_batch'] = $d->invoice_batch;
            $customer = Customers::find($d->customer_id);
            $dd['customer_name'] = $customer->customer_name ?? '';
            $dd['province_name'] = $customer->market ?? '';
            $dd['sum_apv_cardbroadbox_qty'] = ($d->pro_cardboardbox_qty * 10) + ($d->pro_carton_qty / 5);
            $dd['apv_cardbroadbox_qty'] = $d->pro_cardboardbox_qty;
            $dd['apv_carton_qty'] = $d->pro_carton_qty;
            $dd['cigarette_delivery_rates'] = number_format($d->cigarette_delivery_rates, 6);
            $dd['cigarette_delivery_rates2'] = number_format($d->cigarette_delivery_rates / 50, 6);
            if($d->order_product_type_code == 10) {
                $dd['sum'] =( $d->pro_cardboardbox_qty * $d->cigarette_delivery_rates) + ( $d->pro_carton_qty * ($d->cigarette_delivery_rates / 50));
            } elseif($d->order_product_type_code == 20) {
                $dd['sum'] = ($d->pro_cardboardbox_qty * $d->leaf_delivery_rates) + ($d->pro_carton_qty * ($d->leaf_delivery_rates / 10));
            } else {
                $dd['sum'] = ($d->pro_cardboardbox_qty *$d->other_delivery_rates);

            }

            array_push($newdata, $dd);
        }
        return $newdata;
    }

    private function getInfoDataAP($region_code, $group_id, $product_type, $interface, $invoice_batch)
    {
        $newdata = [];
        $data = TranspotReportModel::whereRaw("ptom_ap_interfaces.group_id = nvl('$group_id', ptom_ap_interfaces.group_id)")
        ->whereRaw("ptom_ap_interfaces.invoice_batch = nvl('$invoice_batch', ptom_ap_interfaces.invoice_batch)")
        ->where('ptom_ap_interfaces.region_code', $region_code)
        ->select('ptom_ap_interfaces.*', 'ptom_customers.market')
        ->leftJoin('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_ap_interfaces.customer_id')
        ->where('ptom_ap_interfaces.product_type_code', $product_type)
        ->where('ptom_ap_interfaces.interface_name', $interface)
        ->where('ptom_ap_interfaces.from_program_code', 'OMP0042')
        ->orderBy('ptom_ap_interfaces.doc_ref_date', 'ASC')->get();

        foreach ($data as $d) {
            $dd['carfare_apv_amount'] = $d->carfare_apv_amount;
            $dd['doc_ref_date'] = Carbon::parse($d->doc_ref_date)->format('Y-m-d');
            $dd['doc_ref_code'] = $d->doc_ref_code;
            $dd['leaf_delivery_rates'] =number_format($d->leaf_delivery_rates, 6);
            $dd['leaf_delivery_rates2'] =number_format($d->leaf_delivery_rates * (12 / 120), 6);
            $dd['product_type_code'] = $d->product_type_code;
            $dd['invoice_batch'] = $d->invoice_batch;
            $customer = Customers::find($d->customer_id);
            $dd['customer_name'] = $customer->customer_name ?? '';
            $dd['province_name'] = $customer->market ?? '';
            $dd['sum_apv_cardbroadbox_qty'] = ($d->apv_cardboardbox_qty * 10) + ($d->apv_carton_qty / 5);
            $dd['apv_cardbroadbox_qty'] = $d->apv_cardboardbox_qty;
            $dd['apv_carton_qty'] = $d->apv_carton_qty;
            $dd['cigarette_delivery_rates'] = number_format($d->cigarette_delivery_rates, 6);
            $dd['cigarette_delivery_rates2'] = number_format($d->cigarette_delivery_rates / 50, 6);
            $dd['sum'] = $d->carfare_apv_amount + $d->carfare_pro_amount;

            array_push($newdata, $dd);
        }
        return $newdata;
    }
}
