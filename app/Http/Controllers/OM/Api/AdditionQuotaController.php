<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\AdditionQuotaHeader;
use App\Models\OM\Api\AdditionQuotaLine;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\OrderHeaders;
use App\Models\OM\PTOM_AUTHORITY_LISTS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\OM\Api\Postpone;

class AdditionQuotaController extends Controller
{
    public function request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_number'   => 'required',
            'order_number'      => 'required'
        ], [
            'customer_number.required'  => 'ข้อมูลไม่ถูกต้อง',
            'order_number.required'     => 'ข้อมูลไม่ถูกต้อง'
        ]);
        if ($validator->fails()) {
            $jsonData = [
                'data'  => $validator->errors()->first(),
                'group' => 'error',
                'owner' => 'error'
            ];
            return response()->json($jsonData);
        }

        $order_header_id    = [];
        $lookup_code        = [];
        $meaning            = [];
        $received_quota     = [];
        $remaining_quota    = [];
        $order_quantity     = [];
        $orderB             = [];

        $dataFormOrder = DB::select("SELECT PTOM_CUSTOMERS.CUSTOMER_NAME,
                                            PTOM_CUSTOMERS.CUSTOMER_ID,
                                            PTOM_CUSTOMERS.CUSTOMER_NUMBER,
                                            PTOM_CUSTOMERS.BILL_TO_SITE_NAME,
                                            PTOM_CUSTOMERS.BILL_TO_SITE_ID,
                                            PTOM_CUSTOMERS.ADDRESS_LINE1,
                                            PTOM_CUSTOMERS.ADDRESS_LINE2,
                                            PTOM_CUSTOMERS.ADDRESS_LINE3,
                                            P.PROVINCE_THAI,A.CITY_THAI,
                                            T.TAMBON_THAI,PTOM_CUSTOMERS.ALLEY,
                                            PTOM_CUSTOMERS.POSTAL_CODE,
                                            PTOM_CUSTOMERS.CONTACT_PHONE,
                                            PTOM_CUSTOMERS.DELIVERY_DATE 
                                    FROM    PTOM_CUSTOMERS 
                                    LEFT JOIN PTOM_THAILAND_TERRITORY_V P ON PTOM_CUSTOMERS.PROVINCE_CODE = P.PROVINCE_ID 
                                    LEFT JOIN PTOM_THAILAND_TERRITORY_V A ON PTOM_CUSTOMERS.CITY_CODE = A.CITY_CODE 
                                    LEFT JOIN PTOM_THAILAND_TERRITORY_V T ON PTOM_CUSTOMERS.DISTRICT_CODE = T.TAMBON_ID 
                                    WHERE PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . $request->customer_number . "' FETCH FIRST 1 ROWS ONLY");

        $order_dates = DB::select(" SELECT ORDER_HEADER_ID,ORDER_DATE,DELIVERY_DATE,PERIOD_ID 
                                    FROM PTOM_ORDER_HEADERS 
                                    WHERE ORDER_HEADER_ID = '" . $request->order_number . "' FETCH FIRST 1 ROWS ONLY");

        $date = Carbon::parse($order_dates[0]->order_date)->format('Y-m-d');

        $ptom_quota_groups = DB::select("   SELECT LOOKUP_CODE, MEANING 
                                            FROM PTOM_QUOTA_GROUP 
                                            WHERE ENABLED_FLAG = 'Y' 
                                            AND TAG = 'Y'
                                            AND START_DATE_ACTIVE <= DATE '" . Carbon::now()->format('Y-m-d') . "' 
                                            AND (END_DATE_ACTIVE >= DATE '".Carbon::now()->format('Y-m-d')."' 
                                            OR END_DATE_ACTIVE IS NULL) 
                                            ORDER BY LOOKUP_CODE ASC ");

        foreach ($ptom_quota_groups as $ptom_quota_group) {
            $dataLines = DB::select("   SELECT SUM(PTOM_ORDER_LINES.ORDER_QUANTITY) ORDER_QUANTITY,PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING 
                                        FROM PTOM_ORDER_LINES 
                                        LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID 
                                        LEFT JOIN PTOM_QUOTA_AND_CREDIT_GROUP ON PTOM_ORDER_LINES.QUOTA_CREDIT_ID = PTOM_QUOTA_AND_CREDIT_GROUP.QUOTA_CREDIT_ID 
                                        LEFT JOIN PTOM_QUOTA_GROUP ON PTOM_QUOTA_AND_CREDIT_GROUP.QUOTA_GROUP_CODE = PTOM_QUOTA_GROUP.LOOKUP_CODE 
                                        WHERE PTOM_ORDER_HEADERS.ORDER_HEADER_ID = '" . $request->order_number . "' AND PTOM_QUOTA_GROUP.LOOKUP_CODE = '" . $ptom_quota_group->lookup_code . "' GROUP BY PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING ORDER BY PTOM_QUOTA_GROUP.LOOKUP_CODE ASC");

            $from_headers = Postpone::whereRaw("TO_PERIOD_DATE = DATE '" . Carbon::parse($order_dates[0]->delivery_date)
                                    ->format('Y-m-d') . "'")
                                    ->where('customer_id', $dataFormOrder[0]->customer_id)
                                    ->where('from_period_id', $order_dates[0]->period_id)
                                    ->first();

            if (!empty($from_headers)) {
                $period_id = $from_headers->from_period_id;
                $todaycountquota = Carbon::parse($from_headers->from_period_date)->format('Y-m-d');
            } else {
                $todaycountquota = Carbon::parse($order_dates[0]->delivery_date)->format('Y-m-d');
                $period_id = $order_dates[0]->period_id;
            }

            if (empty($dataLines)) {
                if ($dataFormOrder[0]->delivery_date == 'ทุกวัน') {
                    $dataQuota = DB::select("SELECT PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING,SUM(PTOM_CUSTOMER_QUOTA_LINES.RECEIVED_QUOTA) RECEIVED_QUOTA,SUM(PTOM_CUSTOMER_QUOTA_LINES.REMAINING_QUOTA) REMAINING_QUOTA FROM PTOM_CUSTOMER_QUOTA_LINES LEFT JOIN PTOM_QUOTA_AND_CREDIT_GROUP ON PTOM_CUSTOMER_QUOTA_LINES.ITEM_CODE = PTOM_QUOTA_AND_CREDIT_GROUP.ITEM_CODE LEFT JOIN PTOM_QUOTA_GROUP ON PTOM_QUOTA_AND_CREDIT_GROUP.QUOTA_GROUP_CODE = PTOM_QUOTA_GROUP.LOOKUP_CODE WHERE PTOM_CUSTOMER_QUOTA_LINES.QUOTA_HEADER_ID IN (SELECT QUOTA_HEADER_ID FROM PTOM_CUSTOMER_QUOTA_HEADERS WHERE CUSTOMER_ID = '" . $dataFormOrder[0]->customer_id . "' AND START_DATE <= DATE '" . $todaycountquota . "' AND END_DATE >= DATE '" . $todaycountquota . "' AND UPPER(STATUS) = 'ACTIVE' AND DELETED_AT IS NULL) AND PTOM_QUOTA_GROUP.LOOKUP_CODE = '" . $ptom_quota_group->lookup_code . "' GROUP BY PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING ORDER BY PTOM_QUOTA_GROUP.LOOKUP_CODE ASC");
                } else {
                    $dataQuota = DB::select("SELECT PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING,SUM(PTOM_CUSTOMER_QUOTA_LINES.RECEIVED_QUOTA) RECEIVED_QUOTA,SUM(PTOM_CUSTOMER_QUOTA_LINES.REMAINING_QUOTA) REMAINING_QUOTA FROM PTOM_CUSTOMER_QUOTA_LINES LEFT JOIN PTOM_QUOTA_AND_CREDIT_GROUP ON PTOM_CUSTOMER_QUOTA_LINES.ITEM_CODE = PTOM_QUOTA_AND_CREDIT_GROUP.ITEM_CODE LEFT JOIN PTOM_QUOTA_GROUP ON PTOM_QUOTA_AND_CREDIT_GROUP.QUOTA_GROUP_CODE = PTOM_QUOTA_GROUP.LOOKUP_CODE WHERE PTOM_CUSTOMER_QUOTA_LINES.QUOTA_HEADER_ID IN (SELECT QUOTA_HEADER_ID FROM PTOM_CUSTOMER_QUOTA_HEADERS WHERE CUSTOMER_ID = '" . $dataFormOrder[0]->customer_id . "' AND START_DATE <= DATE '" . $todaycountquota . "' AND END_DATE >= DATE '" . $todaycountquota . "' AND UPPER(STATUS) = 'ACTIVE' AND DELETED_AT IS NULL) AND PTOM_QUOTA_GROUP.LOOKUP_CODE = '" . $ptom_quota_group->lookup_code . "' GROUP BY PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING ORDER BY PTOM_QUOTA_GROUP.LOOKUP_CODE ASC");
                }

                array_push($order_header_id, $order_dates[0]->order_header_id);
                array_push($lookup_code, $ptom_quota_group->lookup_code);
                array_push($meaning, $ptom_quota_group->meaning);
                array_push($received_quota, $dataQuota[0]->received_quota);
                array_push($remaining_quota, "0");
                array_push($order_quantity, "0");
                array_push($orderB, "0");
            } else {
                foreach ($dataLines as $key => $value) {

                    $received_quotanumber = 0;
                    $remaining_quotanumber = 0;
                    $look = strlen($value->lookup_code) == 2 ? $value->lookup_code : '0' . $value->lookup_code;
                    $l = strlen($value->lookup_code) == 2 ? substr($value->lookup_code, 1) : $value->lookup_code;

                    if ($dataFormOrder[0]->delivery_date == 'ทุกวัน') {
                        $dataQuota = DB::select("SELECT PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING,SUM(PTOM_CUSTOMER_QUOTA_LINES.RECEIVED_QUOTA) RECEIVED_QUOTA,SUM(PTOM_CUSTOMER_QUOTA_LINES.REMAINING_QUOTA) REMAINING_QUOTA FROM PTOM_CUSTOMER_QUOTA_LINES LEFT JOIN PTOM_QUOTA_AND_CREDIT_GROUP ON PTOM_CUSTOMER_QUOTA_LINES.ITEM_CODE = PTOM_QUOTA_AND_CREDIT_GROUP.ITEM_CODE LEFT JOIN PTOM_QUOTA_GROUP ON PTOM_QUOTA_AND_CREDIT_GROUP.QUOTA_GROUP_CODE = PTOM_QUOTA_GROUP.LOOKUP_CODE WHERE PTOM_CUSTOMER_QUOTA_LINES.QUOTA_HEADER_ID IN (SELECT QUOTA_HEADER_ID FROM PTOM_CUSTOMER_QUOTA_HEADERS WHERE CUSTOMER_ID = '" . $dataFormOrder[0]->customer_id . "' AND START_DATE <= DATE '" . $todaycountquota . "' AND END_DATE >= DATE '" . $todaycountquota . "' AND UPPER(STATUS) = 'ACTIVE' AND DELETED_AT IS NULL) AND PTOM_QUOTA_GROUP.LOOKUP_CODE = '" . $look . "' GROUP BY PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING ORDER BY PTOM_QUOTA_GROUP.LOOKUP_CODE ASC");
                    } else {
                        $dataQuota = DB::select("SELECT PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING,SUM(PTOM_CUSTOMER_QUOTA_LINES.RECEIVED_QUOTA) RECEIVED_QUOTA,SUM(PTOM_CUSTOMER_QUOTA_LINES.REMAINING_QUOTA) REMAINING_QUOTA FROM PTOM_CUSTOMER_QUOTA_LINES LEFT JOIN PTOM_QUOTA_AND_CREDIT_GROUP ON PTOM_CUSTOMER_QUOTA_LINES.ITEM_CODE = PTOM_QUOTA_AND_CREDIT_GROUP.ITEM_CODE LEFT JOIN PTOM_QUOTA_GROUP ON PTOM_QUOTA_AND_CREDIT_GROUP.QUOTA_GROUP_CODE = PTOM_QUOTA_GROUP.LOOKUP_CODE WHERE PTOM_CUSTOMER_QUOTA_LINES.QUOTA_HEADER_ID IN (SELECT QUOTA_HEADER_ID FROM PTOM_CUSTOMER_QUOTA_HEADERS WHERE CUSTOMER_ID = '" . $dataFormOrder[0]->customer_id . "' AND START_DATE <= DATE '" . $todaycountquota . "' AND END_DATE >= DATE '" . $todaycountquota . "' AND UPPER(STATUS) = 'ACTIVE' AND DELETED_AT IS NULL) AND PTOM_QUOTA_GROUP.LOOKUP_CODE = '" . $look . "' GROUP BY PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING ORDER BY PTOM_QUOTA_GROUP.LOOKUP_CODE ASC");
                    }


                    if (!empty($dataQuota)) {
                        if ($value->order_quantity > $dataQuota[0]->received_quota || $dataQuota[0]->remaining_quota <= 0 || $value->order_quantity > $dataQuota[0]->remaining_quota) {
                            $received_quotanumber = $dataQuota[0]->received_quota;
                            $remaining_quotanumber = $dataQuota[0]->remaining_quota;
                            if ($received_quotanumber != 0) {
                                array_push($order_header_id, $order_dates[0]->order_header_id);
                                array_push($lookup_code, $look);
                                array_push($meaning, $value->meaning);
                                array_push($received_quota, $received_quotanumber);
                                array_push($remaining_quota, $remaining_quotanumber);
                                array_push($order_quantity, $value->order_quantity);
                            }

                            $now = Carbon::parse($order_dates[0]->delivery_date);
                            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
                            $weekEndDate = $now->endOfWeek()->format('Y-m-d');

                            $orderBF = DB::select("SELECT PTOM_ADDITION_QUOTA_LINES.APPROVE_QUANTITY FROM PTOM_ADDITION_QUOTA_LINES LEFT JOIN PTOM_ADDITION_QUOTA_HEADERS ON PTOM_ADDITION_QUOTA_LINES.QUOTA_HEADER_ID = PTOM_ADDITION_QUOTA_HEADERS.QUOTA_HEADER_ID WHERE PTOM_ADDITION_QUOTA_HEADERS.ORDER_HEADER_ID IN (SELECT ORDER_HEADER_ID FROM PTOM_ORDER_HEADERS WHERE CUSTOMER_ID = '" . $dataFormOrder[0]->customer_id . "' AND PERIOD_ID = '" . $order_dates[0]->period_id . "') AND PTOM_ADDITION_QUOTA_HEADERS.CREATION_DATE BETWEEN DATE '" . $weekStartDate . "' AND DATE '" . $weekEndDate . "' AND PTOM_ADDITION_QUOTA_HEADERS.APPROVE_STATUS = 'อนุมัติ' AND PTOM_ADDITION_QUOTA_LINES.QUOTA_GROUP_ID = '" . $l . "' AND PTOM_ADDITION_QUOTA_HEADERS.CUSTOMER_ID = '" . $dataFormOrder[0]->customer_id . "' ORDER BY PTOM_ADDITION_QUOTA_HEADERS.QUOTA_HEADER_ID DESC FETCH FIRST 1 ROWS ONLY");

                            $orderBB = $orderBF[0]->approve_quantity ?? '-';


                            array_push($orderB, $orderBB);
                        } else {
                            array_push($order_header_id, $order_dates[0]->order_header_id);
                            array_push($lookup_code, $look);
                            array_push($meaning, $value->meaning);
                            array_push($received_quota, $dataQuota[0]->received_quota);
                            array_push($remaining_quota, "0");
                            array_push($order_quantity, "0");
                            array_push($orderB, "0");
                        }
                    }
                }
            }
        }

        $dataOwner = DB::select("SELECT PTOM_CUSTOMER_OWNERS.OWNER_NO,PTOM_CUSTOMER_OWNERS.PREFIX,PTOM_CUSTOMER_OWNERS.OWNER_FIRST_NAME,PTOM_CUSTOMER_OWNERS.OWNER_LAST_NAME FROM PTOM_CUSTOMER_OWNERS,PTOM_CUSTOMERS WHERE PTOM_CUSTOMER_OWNERS.STATUS <> 'INACTIVE' AND PTOM_CUSTOMER_OWNERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID AND PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . $dataFormOrder[0]->customer_number . "' ORDER BY PTOM_CUSTOMER_OWNERS.OWNER_NO ASC FETCH FIRST 1 ROWS ONLY");

        $jsonData = [
            'data' => $dataFormOrder[0],
            'group' => [
                'order_header_id' => $order_header_id,
                'lookup_code' => $lookup_code,
                'meaning' => $meaning,
                'received_quota' => $received_quota,
                'remaining_quota' => $remaining_quota,
                'order_quantity' => $order_quantity,
            ],
            'owner' => $dataOwner,
            'orderdate' => Carbon::parse($order_dates[0]->delivery_date)->format('Y-m-d') ?? '',
            'orderB' => $orderB
        ];
        return response()->json($jsonData);
    }

    public function store(Request $request)
    {
        $order_header_id = AdditionQuotaHeader::where('order_header_id', $request->order_header_id)
                                                ->count();
        if ($order_header_id > 0) {
            return response()->json(['data' => 'error', 'message' => 'ออเดอร์ใบนี้ได้ดำเนินการขอเพิ่มเพดานแล้ว']);
        } else {

            $sum = 0;
            if ($request->request_quantity) {
                foreach ($request->request_quantity as $key => $value) {
                    if ($value != 0 || $value != '' || $value != null) {
                        $sum += intval($value);
                    }
                }
            }

            $datePeriod = Carbon::parse(now())->format('Y-m-d');
            $emp_approve = DB::select(" SELECT * 
                                        FROM PTOM_OVER_QUOTA_APPROVALS 
                                        WHERE CBB_RANGE_FROM <= $sum 
                                        AND CBB_RANGE_TO >= $sum        
                                        AND START_DATE <= TO_DATE('" . $datePeriod . "','YYYY-MM-DD') 
                                        AND END_DATE IS NULL OR END_DATE >= TO_DATE('" . $datePeriod . "','YYYY-MM-DD')");

            if (empty($emp_approve)) {
                return response()->json(['data' => 'error', 'message' => 'เกิดข้อผิดพลาดการคำนวณสายผู้อนุมัติ กรุณาลองใหม่อีกครั้ง']);
            }

            $org_id = DB::select("SELECT ORGANIZATION_ID FROM OAOM.PTOM_OPERATING_UNITS_V WHERE SHORT_CODE = 'TOAT'");

            $id = AdditionQuotaHeader::create([
                'org_id'                        => !empty($org_id) ? $org_id[0]->organization_id : '',
                'order_header_id'               => $request->order_header_id,
                'over_quota_id'                 => empty($emp_approve) ? '' : $emp_approve[0]->over_quota_id,
                'customer_id'                   => $request->customer_id,
                'bill_to_site_id'               => $request->bill_to_site_id,
                'customer_contact_id2'           => str_replace('-', '', $request->contact_phone),
                'reason'                        => $request->reason,
                'employee_approve1'             => empty($emp_approve) ? '' : $emp_approve[0]->authority_id1,
                'employee_approve2'             => empty($emp_approve) ? '' : $emp_approve[0]->authority_id2,
                'employee_approve3'             => empty($emp_approve) ? '' : $emp_approve[0]->authority_id3,
                'program_code'                  => $request->program_code,
                'approve_status'                => 'ขออนุมัติ',
                'employee_sales_division'       => empty($emp_approve) ? '' : $emp_approve[0]->sales_division_id,
                'created_by'                    => $request->created_by,
                'last_updated_by'               => $request->last_updated_by,
                'creation_date'                 => Carbon::now()->timezone('Asia/Bangkok'),
                'last_update_date'              => Carbon::now()->timezone('Asia/Bangkok'),
                'sales_division_additional'     => empty($emp_approve) ? '' : $emp_approve[0]->sales_division_additional,
                'authority_id1_additional'      => empty($emp_approve) ? '' : $emp_approve[0]->authority_id1_additional,
                'authority_id2_additional'      => empty($emp_approve) ? '' : $emp_approve[0]->authority_id2_additional,
                'authority_id3_additional'      => empty($emp_approve) ? '' : $emp_approve[0]->authority_id3_additional,
            ]);

            if (!$id) {
                return response()->json(['data' => 'error', 'message' => 'ไม่สามารถบันทึกข้อมูลได้']);
            }

            if ($request->quota_group) {
                foreach ($request->quota_group as $key => $quota) {
                    AdditionQuotaLine::create([
                        'quota_header_id'       => $id->quota_header_id,
                        'quota_group_id'        => strlen($quota) == 2 ? $quota : '0' . $quota,
                        'quota_quantity'        => $request->quota_quantity[$key],
                        'last_approve_quantity' => $request->last_approve_quantity[$key] == null ? 0 : $request->last_approve_quantity[$key],
                        'request_quantity'      => $request->request_quantity[$key],
                        'total_quantity'        => $request->total_quantity[$key],
                        'program_code'          => $request->program_code,
                        'created_by'            => $request->created_by,
                        'last_updated_by'       => $request->last_updated_by,
                        'creation_date'         => Carbon::now()->timezone('Asia/Bangkok'),
                        'last_update_date'      => Carbon::now()->timezone('Asia/Bangkok')
                    ]);
                }
            }

            $jsonData = [
                'data' => 'success',
                'message' => '',
            ];

            return response()->json($jsonData);
        }
    }
}
