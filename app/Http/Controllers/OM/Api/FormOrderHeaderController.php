<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\FormOrderHeader;
use App\Models\OM\Api\FormOrderLine;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\Holiday;
use App\Models\OM\SaleConfirmation\OrderLines;
use Carbon\Carbon;
use FormatDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormOrderHeaderController extends Controller
{
    public function search($keyword)
    {
        $quota = DB::table('ptom_form_order_lines')->select('ptom_form_order_lines.item_id', 'ptom_form_order_lines.item_code')->where('item_description', $keyword)->first();

        $jsonData = [
            'data' => $quota,
        ];

        return response()->json($jsonData);
    }

    public function request(Request $request)
    {
        $dataFormOrder = DB::table('ptom_customers')->select('ptom_customers.customer_name', 'ptom_thailand_territory_v.province_thai', 'ptom_customers.delivery_date', 'ptom_customers.address_line1', 'ptom_customers.address_line2', 'ptom_customers.address_line3', 'ptom_customers.alley', 'ptom_customers.district', 'ptom_customers.city', 'ptom_customers.postal_code')->join('ptom_thailand_territory_v', 'ptom_customers.province_code', '=', 'ptom_thailand_territory_v.province_id', 'left')->where(function ($q) use ($request) {
            $q->where('ptom_customers.customer_number', $request->customer_number);
        })->first();

        $int_date = !empty($dataFormOrder) ? compareDaysTH($dataFormOrder->delivery_date) : compareDaysTH(date('Y-m-d'));
        $period_date = nextDaysOfWeek($int_date);

        $date = Carbon::createFromFormat('Y-m-d', $period_date)->format('l');
        if ($date == 'Saturday') {
            $new_date = Carbon::parse($period_date)->addDays(2)->format('Y-m-d');
        } elseif ($date == 'Sunday') {
            $new_date = Carbon::parse($period_date)->addDay()->format('Y-m-d');
        } else {
            $holiday = Holiday::whereDate('hol_date', $period_date)->count();
            if ($holiday > 0) {
                $n = Carbon::parse($period_date)->addDay();
                $date1 = Carbon::createFromFormat('Y-m-d', $n->format('Y-m-d'))->format('l');
                if ($date1 == 'Saturday') {
                    $new_date = Carbon::parse($n)->addDays(2)->format('Y-m-d');
                } elseif ($date1 == 'Sunday') {
                    $new_date = Carbon::parse($n)->addDay()->format('Y-m-d');
                } else {
                    $new_date = Carbon::parse($n)->format('Y-m-d');
                }
            } else {
                $new_date = Carbon::parse($period_date)->format('Y-m-d');
            }
        }

        $quota = DB::select("SELECT DISTINCT PTOM_SEQUENCE_ECOMS.ITEM_ID,PTOM_SEQUENCE_ECOMS.ITEM_CODE,PTOM_SEQUENCE_ECOMS.ECOM_ITEM_DESCRIPTION ITEM_DESCRIPTION,PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER 
                FROM PTOM_CUSTOMERS,PTOM_SEQUENCE_ECOMS,PTOM_PRICE_LIST_HEAD_V,PTOM_PRICE_LIST_LINE_V 
                WHERE PTOM_CUSTOMERS.PRICE_LIST_ID = PTOM_PRICE_LIST_HEAD_V.LIST_HEADER_ID 
                AND PTOM_PRICE_LIST_HEAD_V.LIST_HEADER_ID = PTOM_PRICE_LIST_LINE_V.LIST_HEADER_ID 
                AND PTOM_PRICE_LIST_LINE_V.ITEM_ID = PTOM_SEQUENCE_ECOMS.ITEM_ID 
                AND PTOM_SEQUENCE_ECOMS.SALE_TYPE_CODE = 'DOMESTIC' 
                AND PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . $request->customer_number . "' 
                AND PTOM_SEQUENCE_ECOMS.ITEM_ID IS NOT NULL AND PTOM_SEQUENCE_ECOMS.ITEM_CODE IS NOT NULL 
                AND PTOM_SEQUENCE_ECOMS.ECOM_ITEM_DESCRIPTION IS NOT NULL ORDER BY PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER ASC");

        $actings = DB::select("SELECT PTOM_CUSTOMER_OWNERS.OWNER_NO,PTOM_CUSTOMER_OWNERS.PREFIX,PTOM_CUSTOMER_OWNERS.OWNER_FIRST_NAME,PTOM_CUSTOMER_OWNERS.OWNER_LAST_NAME FROM PTOM_CUSTOMER_OWNERS,PTOM_CUSTOMERS WHERE PTOM_CUSTOMER_OWNERS.STATUS <> 'INACTIVE' AND PTOM_CUSTOMER_OWNERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID AND PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . $request->customer_number . "' ORDER BY PTOM_CUSTOMER_OWNERS.OWNER_NO ASC FETCH FIRST 1 ROWS ONLY");

        $jsonData = [
            'data' => $dataFormOrder,
            'stocks' => $quota ? $quota : [],
            'emp' => $actings ? $actings[0] : '',
            'new_date' => $new_date
        ];

        return response()->json($jsonData);
    }

    public function requests(Request $request)
    {
        $dataFormOrder = DB::table('ptom_customers')->select('ptom_customers.customer_name', 'ptom_thailand_territory_v.province_thai', 'ptom_customers.delivery_date', 'ptom_customers.address_line1', 'ptom_customers.address_line2', 'ptom_customers.address_line3', 'ptom_customers.alley', 'ptom_customers.district', 'ptom_customers.city', 'ptom_customers.postal_code')->join('ptom_thailand_territory_v', 'ptom_customers.province_code', '=', 'ptom_thailand_territory_v.province_id', 'left')->where(function ($q) use ($request) {
            $q->where('ptom_customers.customer_number', $request->customer_number);
        })->first();

        $int_date = !empty($dataFormOrder) ? compareDaysTH($dataFormOrder->delivery_date) : compareDaysTH(date('Y-m-d'));
        $period_date = nextDaysOfWeek($int_date);

        $date = Carbon::createFromFormat('Y-m-d', $period_date)->format('l');
        if ($date == 'Saturday') {
            $new_date = Carbon::parse($period_date)->addDays(2)->format('Y-m-d');
        } elseif ($date == 'Sunday') {
            $new_date = Carbon::parse($period_date)->addDay()->format('Y-m-d');
        } else {
            $holiday = Holiday::whereDate('hol_date', $period_date)->count();
            if ($holiday > 0) {
                $n = Carbon::parse($period_date)->addDay();
                $date1 = Carbon::createFromFormat('Y-m-d', $n->format('Y-m-d'))->format('l');
                if ($date1 == 'Saturday') {
                    $new_date = Carbon::parse($n)->addDays(2)->format('Y-m-d');
                } elseif ($date1 == 'Sunday') {
                    $new_date = Carbon::parse($n)->addDay()->format('Y-m-d');
                } else {
                    $new_date = Carbon::parse($n)->format('Y-m-d');
                }
            } else {
                $new_date = Carbon::parse($period_date)->format('Y-m-d');
            }
        }

        $header_id = DB::table('ptom_customer_quota_headers')->select('ptom_customer_quota_headers.quota_header_id')->join('ptom_customers', 'ptom_customer_quota_headers.customer_id', '=', 'ptom_customers.customer_id', 'left')->where('ptom_customers.customer_number', $request->customer_number)->whereRaw("PTOM_CUSTOMER_QUOTA_HEADERS.START_DATE <= DATE '" . $new_date . "' AND PTOM_CUSTOMER_QUOTA_HEADERS.END_DATE >= DATE '" . $new_date . "'")->get();

        if (!empty($header_id)) {
            $id = array();
            foreach ($header_id as $hid) {
                array_push($id, $hid->quota_header_id);
            }
            $quota = DB::select("SELECT DISTINCT PTOM_SEQUENCE_ECOMS.ITEM_ID,PTOM_SEQUENCE_ECOMS.ITEM_CODE,PTOM_SEQUENCE_ECOMS.ECOM_ITEM_DESCRIPTION ITEM_DESCRIPTION,PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER FROM PTOM_PRICE_LIST_HEAD_V LEFT JOIN PTOM_CUSTOMERS ON PTOM_CUSTOMERS.PRICE_LIST_ID = PTOM_PRICE_LIST_HEAD_V.LIST_HEADER_ID LEFT JOIN PTOM_PRICE_LIST_LINE_V ON PTOM_PRICE_LIST_HEAD_V.LIST_HEADER_ID = PTOM_PRICE_LIST_LINE_V.LIST_HEADER_ID LEFT JOIN PTOM_SEQUENCE_ECOMS ON PTOM_PRICE_LIST_LINE_V.ITEM_ID =PTOM_SEQUENCE_ECOMS.ITEM_ID WHERE PTOM_SEQUENCE_ECOMS.SALE_TYPE_CODE = 'DOMESTIC' AND PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . $request->customer_number . "' AND PTOM_SEQUENCE_ECOMS.ITEM_ID IS NOT NULL AND PTOM_SEQUENCE_ECOMS.ITEM_CODE IS NOT NULL AND PTOM_SEQUENCE_ECOMS.ECOM_ITEM_DESCRIPTION IS NOT NULL ORDER BY PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER ASC");
        }

        $actings = DB::select("SELECT PTOM_CUSTOMER_OWNERS.OWNER_NO,PTOM_CUSTOMER_OWNERS.PREFIX,PTOM_CUSTOMER_OWNERS.OWNER_FIRST_NAME,PTOM_CUSTOMER_OWNERS.OWNER_LAST_NAME FROM PTOM_CUSTOMER_OWNERS,PTOM_CUSTOMERS WHERE PTOM_CUSTOMER_OWNERS.STATUS <> 'INACTIVE' AND PTOM_CUSTOMER_OWNERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID AND PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . $request->customer_number . "' ORDER BY PTOM_CUSTOMER_OWNERS.OWNER_NO ASC FETCH FIRST 1 ROWS ONLY");

        $jsonData = [
            'data' => $dataFormOrder,
            'stocks' => $quota ? $quota : '',
            'emp' => $actings ? $actings[0] : '',
            'new_date' => $new_date
        ];

        return response()->json($jsonData);
    }

    public function getInfo(Request $request)
    {
        $info = DB::table('ptom_form_order_headers')->select('ptom_form_order_headers.attribute1', 'ptom_form_order_headers.province', 'ptom_customers.customer_number', 'ptom_customers.address_line1', 'ptom_customers.address_line2', 'ptom_customers.address_line3', 'ptom_customers.alley', 'ptom_customers.district', 'ptom_customers.city', 'ptom_customers.postal_code', 'ptom_form_order_headers.reason', 'ptom_form_order_headers.approve_status', 'ptom_form_order_headers.approve_date', 'ptom_form_order_headers.creation_date', 'ptom_form_order_headers.from_period_date', 'ptom_form_order_headers.to_period_date', 'ptom_customers.customer_name', 'ptom_form_order_headers.last_updated_by')->join('ptom_customers', 'ptom_form_order_headers.customer_id', '=', 'ptom_customers.customer_id', 'left')->where('ptom_form_order_headers.form_header_id', $request->form_header_id)->first();
        $quota = DB::table('ptom_form_order_lines')->select('form_number', 'item_description', 'serial', 'quantity', 'approve_quantity', 'attribute1', 'attribute2')->where('form_header_id', $request->form_header_id)->orderBy('form_number', 'ASC')->get();

        $actings = DB::select("SELECT PTOM_CUSTOMER_OWNERS.OWNER_NO,PTOM_CUSTOMER_OWNERS.PREFIX,PTOM_CUSTOMER_OWNERS.OWNER_FIRST_NAME,PTOM_CUSTOMER_OWNERS.OWNER_LAST_NAME FROM PTOM_CUSTOMER_OWNERS,PTOM_CUSTOMERS WHERE PTOM_CUSTOMER_OWNERS.STATUS <> 'INACTIVE' AND PTOM_CUSTOMER_OWNERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID AND PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . $info->customer_number . "' ORDER BY PTOM_CUSTOMER_OWNERS.OWNER_NO ASC FETCH FIRST 1 ROWS ONLY");

        $emp_name = DB::select("SELECT NAME EMPLOYEE_NAME FROM PTW_USERS WHERE USER_ID = '" . $info->last_updated_by . "'");

        $jsonData = [
            'data' => $info,
            'stocks' => $quota,
            'emp' => $actings[0],
            'emp_name' => 'กองบริหารขาย' ?? ''
        ];

        return response()->json($jsonData);
    }

    public function getInfoS(Request $request)
    {
        $queryInfo = DB::table('ptom_form_order_headers')->select(
            'ptom_form_order_headers.attribute1',
            'ptom_form_order_headers.attribute2',
            'ptom_form_order_headers.employee_approve1',
            'ptom_form_order_headers.employee_approve2',
            'ptom_form_order_headers.employee_approve3',
            'ptom_form_order_headers.employee_approve4',
            'ptom_form_order_headers.acting_position_approve1',
            'ptom_form_order_headers.acting_position_approve2',
            'ptom_form_order_headers.acting_position_approve3',
            'ptom_form_order_headers.acting_position_approve4',
            'ptom_form_order_headers.form_header_id',
            'ptom_form_order_headers.province',
            'ptom_form_order_headers.reason',
            'ptom_form_order_headers.approve_status',
            'ptom_form_order_headers.approve_date',
            'ptom_form_order_headers.creation_date',
            'ptom_form_order_headers.from_period_date',
            'ptom_form_order_headers.to_period_date',
            'ptom_form_order_headers.to_period_id',
            'ptom_customers.customer_number',
            'ptom_customers.customer_name',
            'ptom_customers.address_line1',
            'ptom_customers.address_line2',
            'ptom_customers.address_line3',
            'ptom_customers.alley',
            'ptom_customers.district',
            'ptom_customers.city',
            'ptom_customers.postal_code'
        )->join('ptom_customers', 'ptom_form_order_headers.customer_id', '=', 'ptom_customers.customer_id', 'left')
        ->where('ptom_form_order_headers.form_header_id', $request->id);
        $info   = $queryInfo->first();
        $quotas = DB::table('ptom_form_order_lines')->select(
            'form_line_id',
            'form_number',
            'item_description',
            'quantity',
            'approve_quantity',
            'attribute1',
            'attribute2'
        )->where('form_header_id', $request->id)
        ->orderBy('form_number', 'ASC')
        ->get();
        $emps       = DB::table('ptom_authority_lists')->select('authority_id', 'employee_name', 'position_name')->get();
        $actings    = DB::select("SELECT    PTOM_CUSTOMER_OWNERS.OWNER_NO,
                                            PTOM_CUSTOMER_OWNERS.PREFIX,
                                            PTOM_CUSTOMER_OWNERS.OWNER_FIRST_NAME,
                                            PTOM_CUSTOMER_OWNERS.OWNER_LAST_NAME 
                                FROM    PTOM_CUSTOMER_OWNERS,PTOM_CUSTOMERS 
                                WHERE PTOM_CUSTOMER_OWNERS.STATUS <> 'INACTIVE' 
                                AND PTOM_CUSTOMER_OWNERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
                                AND PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . $info->customer_number . "' 
                                ORDER BY PTOM_CUSTOMER_OWNERS.OWNER_NO ASC FETCH FIRST 1 ROWS ONLY");
        $act        = $actings[0];
        $toPeriodId = $info->to_period_id;
        $arrFormOrderHeaders    = DB::select("  SELECT  rownum,
                                                        form_header_id,
                                                        customer_number,
                                                        approve_status,
                                                        form_type,
                                                        program_code,
                                                        from_period_id,
                                                        from_period_date,
                                                        to_period_id,
                                                        to_period_date
                                                FROM        ptom_form_order_headers
                                                WHERE       1=1
                                                AND         customer_number = '{$info->customer_number}'
                                                AND         to_period_id    = '{$toPeriodId}'
                                                AND         form_type       = 'SPECIAL'
                                                ORDER BY    form_header_id");

        $budgetYear     = DB::table('PTOM_PERIOD_V')
                            ->select('BUDGET_YEAR')
                            ->where('period_line_id', $toPeriodId)
                            ->first()
                            ->BUDGET_YEAR ?? date("Y");

        foreach ($arrFormOrderHeaders as $key => $value) {
            if($value->form_header_id == $request->id){
                $countFromHeaderId = $value->rownum;
            }
        }

        $actingddd = DB::table('ptom_acting_position_v')->select('lookup_code', 'meaning')->where('enabled_flag', 'Y')->get();

        $emp_name = DB::select("SELECT EMPLOYEE_NAME FROM PTOM_AUTHORITY_LISTS WHERE AUTHORITY_ID = '" . $info->employee_approve3 . "'");

        $jsonData = [
            'info'              => $info,
            'quotas'            => $quotas,
            'emps'              => $emps,
            'act'               => $act,
            'actingddd'         => $actingddd,
            'budgetYear'        => FormatDate::Yearonly($budgetYear),
            'countFromHeaderId' => $countFromHeaderId,
            'emp_name'          => $emp_name[0]->employee_name ?? ''
        ];

        return response()->json($jsonData);
    }

    public function report($id)
    {
        $queryInfo = DB::table('ptom_form_order_headers')->select(
                                'ptom_form_order_headers.attribute1',
                                'ptom_form_order_headers.attribute2',
                                'ptom_form_order_headers.employee_approve1',
                                'ptom_form_order_headers.employee_approve2',
                                'ptom_form_order_headers.employee_approve3',
                                'ptom_form_order_headers.employee_approve4',
                                'ptom_form_order_headers.acting_position_approve1',
                                'ptom_form_order_headers.acting_position_approve2',
                                'ptom_form_order_headers.acting_position_approve3',
                                'ptom_form_order_headers.acting_position_approve4',
                                'ptom_form_order_headers.form_header_id',
                                'ptom_form_order_headers.province',
                                'ptom_form_order_headers.reason',
                                'ptom_form_order_headers.approve_status',
                                'ptom_form_order_headers.approve_date',
                                'ptom_form_order_headers.creation_date',
                                'ptom_form_order_headers.from_period_date',
                                'ptom_form_order_headers.to_period_date',
                                'ptom_form_order_headers.to_period_id',
                                'ptom_form_order_headers.status_empolyee_approve1',
                                'ptom_form_order_headers.status_empolyee_approve2',
                                'ptom_form_order_headers.status_empolyee_approve3',
                                'ptom_customers.customer_number',
                                'ptom_customers.customer_name',
                                'ptom_customers.address_line1',
                                'ptom_customers.address_line2',
                                'ptom_customers.address_line3',
                                'ptom_customers.alley',
                                'ptom_customers.district',
                                'ptom_customers.city',
                                'ptom_customers.postal_code',
                                'ptom_customers.customer_id',
                                'ptom_customers.contact_phone'
        )->join('ptom_customers', 'ptom_form_order_headers.customer_id', '=', 'ptom_customers.customer_id', 'left')
         ->where('ptom_form_order_headers.form_header_id', $id);
        $info = $queryInfo->first();
        $quota      = DB::table('ptom_form_order_lines')
                        ->select('form_line_id', 'form_number', 'item_description', 'quantity', 'approve_quantity', 'item_id', 'item_code', 'attribute1', 'attribute2')
                        ->where('form_header_id', $id)
                        ->orderBy('form_number', 'ASC')
                        ->get();
        $actings    = DB::select("SELECT    PTOM_CUSTOMER_OWNERS.OWNER_NO,
                                            PTOM_CUSTOMER_OWNERS.PREFIX,
                                            PTOM_CUSTOMER_OWNERS.OWNER_FIRST_NAME,
                                            PTOM_CUSTOMER_OWNERS.OWNER_LAST_NAME 
                                FROM PTOM_CUSTOMER_OWNERS,PTOM_CUSTOMERS 
                                WHERE PTOM_CUSTOMER_OWNERS.STATUS <> 'INACTIVE' 
                                AND PTOM_CUSTOMER_OWNERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
                                AND PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . $info->customer_number . "' 
                                ORDER BY PTOM_CUSTOMER_OWNERS.OWNER_NO ASC FETCH FIRST 1 ROWS ONLY");
        $act        = $actings[0];        
        $emps1 = DB::table('ptom_authority_lists')
                    ->select('ptom_authority_lists.employee_name', 'ptom_authority_lists.position_name', 'ptw_users.name')
                    ->join('ptw_users', 'ptw_users.username', '=', 'ptom_authority_lists.employee_number', 'left')
                    ->where('authority_id', $info->employee_approve1)
                    ->get();
        $emps2 = DB::table('ptom_authority_lists')
                    ->select('ptom_authority_lists.employee_name', 'ptom_authority_lists.position_name', 'ptw_users.name')
                    ->join('ptw_users', 'ptw_users.username', '=', 'ptom_authority_lists.employee_number', 'left')
                    ->where('authority_id', $info->employee_approve2)
                    ->get();
        $emps3 = DB::table('ptom_authority_lists')
                    ->select('ptom_authority_lists.employee_name', 'ptom_authority_lists.position_name', 'ptw_users.name')
                    ->join('ptw_users', 'ptw_users.username', '=', 'ptom_authority_lists.employee_number', 'left')
                    ->where('authority_id', $info->employee_approve3)
                    ->get();
        $emps4 = DB::table('ptom_authority_lists')
                    ->select('ptom_authority_lists.employee_name', 'ptom_authority_lists.position_name', 'ptw_users.name')
                    ->join('ptw_users', 'ptw_users.username', '=', 'ptom_authority_lists.employee_number', 'left')
                    ->where('authority_id', $info->employee_approve4)
                    ->get();
        
        $emps1->map(function ($item, $key) use($info) {
            $acting1 = $info->acting_position_approve1;
            $acting1 = DB::select("SELECT MEANING FROM PTOM_ACTING_POSITION_V WHERE LOOKUP_CODE = '$acting1'");
            $item->acting_position_approve1 = $acting1 ? $acting1[0]->meaning : '';
        });

        $emps2->map(function ($item, $key) use($info) {
            $acting2 = $info->acting_position_approve2;
            $acting2 = DB::select("SELECT MEANING FROM PTOM_ACTING_POSITION_V WHERE LOOKUP_CODE = '$acting2'");
            $item->acting_position_approve2 = $acting2 ? $acting2[0]->meaning : '';
        });

        $emps3->map(function ($item, $key) use($info) {
            $acting3 = $info->acting_position_approve3;
            $acting3 = DB::select("SELECT MEANING FROM PTOM_ACTING_POSITION_V WHERE LOOKUP_CODE = '$acting3'");
            $item->acting_position_approve3 = $acting3 ? $acting3[0]->meaning : '';
        });

        $emps4->map(function ($item, $key) use($info) {
            $acting4 = $info->acting_position_approve4;
            $acting4 = DB::select("SELECT MEANING FROM PTOM_ACTING_POSITION_V WHERE LOOKUP_CODE = '$acting4'");
            $item->acting_position_approve4 = $acting4 ? $acting4[0]->meaning : '';
        });

        $to_period_id       = $info->to_period_id;
        $budgetYear         = DB::table('PTOM_PERIOD_V')->select('BUDGET_YEAR')->where('period_line_id', $to_period_id)->first()->BUDGET_YEAR ?? date("Y");
        $countFromHeaderId = $queryInfo->count();

        $quotas = [];
        foreach($quota as $q) {
            $quotas[] = [
                'form_line_id'      => $q->form_line_id,
                'form_number'       => $q->form_number,
                'item_description'  => $q->item_description,
                'quantity'          => $q->quantity,
                'approve_quantity'  => $q->approve_quantity,
                'item_id'           => $q->item_id,
                'item_code'         => $q->item_code,
                'attribute1'        => $q->attribute1 == null ? null : $q->attribute1,
                'attribute2'        => $q->attribute2 == null ? null : $q->attribute2,
            ];
        }

        $jsonData = [
            'info' => $info,
            'quotas' => $quotas,
            'act' => $act,
            'emp1' => $emps1,
            'emp2' => $emps2,
            'emp3' => $emps3,
            'emp4' => $emps4,
            'budgetYear' => FormatDate::Yearonly($budgetYear),
            'countFromHeaderId' => $countFromHeaderId
        ];

        return response()->json($jsonData);
    }

    public function savebeforeapproveS(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_approve1'     => 'required',
            'employee_approve2'     => 'required',
            // 'employee_approve3' => 'required',
            'employee_approve4'     => 'required',
        ], [
            'employee_approve1.required'    => 'กรุณาเลือกผู้ทำการกองบริหารการขาย',
            'employee_approve2.required'    => 'กรุณาเลือกผู้ทำการโปรดพิจารณา',
            // 'employee_approve3.required' => 'กรุณาเลือกผู้ทำการโปรดพิจารณา',
            'employee_approve4.required'    => 'กรุณาเลือกผู้ทำการผู้อนุมัติ',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => $validator->errors()->first()]);
        }

        $approve = FormOrderHeader::find($request->id);
        if (!$approve) {
            return response()->json(['status' => 'error', 'msg' => 'ไม่พบข้อมูล']);
        }

        $approve->employee_approve1         = $request->employee_approve1;
        $approve->employee_approve2         = $request->employee_approve2;
        $approve->employee_approve3         = $request->employee_approve3;
        $approve->employee_approve4         = $request->employee_approve4;
        $approve->acting_position_approve1  = $request->acting1;
        $approve->acting_position_approve2  = $request->acting2;
        $approve->acting_position_approve3  = $request->acting3;
        $approve->acting_position_approve4  = $request->acting4;
        $approve->save();

        $approve2 = FormOrderHeader::find($request->id);
        if ($approve2->approve_status != 'อนุมัติ') {
            foreach ($request->form_line_id as $key => $formid) {
                FormOrderLine::find($formid)->update(['approve_quantity' => $request->approve_quantity[$key], 'attribute2' => $request->approve_quantity2[$key], 'last_update_date' => now()]);
            }
        }

        return response()->json(['status' => 'success', 'msg' => 'เรียบร้อยแล้ว']);
    }

    public function approveS(Request $request)
    {
        if ($request->updateStatus == 'อนุมัติ') {
            $validator = Validator::make($request->all(), [
                'employee_approve1' => 'required',
                'employee_approve2' => 'required',
                // 'employee_approve3' => 'required',
                'employee_approve4' => 'required',
            ], [
                'employee_approve1.required' => 'กรุณาเลือกผู้ทำการกองบริหารการขาย',
                'employee_approve2.required' => 'กรุณาเลือกผู้ทำการโปรดพิจารณา',
                // 'employee_approve3.required' => 'กรุณาเลือกผู้ทำการโปรดพิจารณา',
                'employee_approve4.required' => 'กรุณาเลือกผู้ทำการผู้อนุมัติ',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'msg' => $validator->errors()->first()]);
            }
        }
        $approve = FormOrderHeader::find($request->id);
        if (!$approve) {
            return response()->json(['status' => 'error', 'msg' => 'ไม่พบข้อมูล']);
        }
        $approve->approve_status = $request->updateStatus;
        $approve->approve_date = date('Y-m-d');
        $approve->employee_approve1 = $request->updateStatus == 'อนุมัติ' ? $request->employee_approve1 : '';
        $approve->employee_approve2 = $request->updateStatus == 'อนุมัติ' ? $request->employee_approve2 : '';
        $approve->employee_approve3 = $request->updateStatus == 'อนุมัติ' ? $request->employee_approve3 : '';
        $approve->employee_approve4 = $request->updateStatus == 'อนุมัติ' ? $request->employee_approve4 : '';
        $approve->acting_position_approve1 = $request->acting1;
        $approve->acting_position_approve2 = $request->acting2;
        $approve->acting_position_approve3 = $request->acting3;
        $approve->acting_position_approve4 = $request->acting4;
        $approve->status_empolyee_approve1 = $request->updateStatus == 'อนุมัติ' ? 'A' : '';
        $approve->status_empolyee_approve2 = $request->updateStatus == 'อนุมัติ' ? 'A' : '';
        $approve->status_empolyee_approve3 = $request->updateStatus == 'อนุมัติ' ? 'A' : '';
        $approve->last_updated_by = $request->user_id;
        $approve->last_update_date = now();
        $approve->save();

        if ($request->updateStatus == 'อนุมัติ') {
            foreach ($request->form_line_id as $key => $formid) {
                FormOrderLine::find($formid)->update(['approve_quantity' => $request->approve_quantity[$key], 'attribute2' => $request->approve_quantity2[$key], 'last_update_date' => now()]);
            }
            $YN = 'Y';

            DB::table('ptom_grant_special_case')->insert([
                'customer_id' => $approve->customer_id,
                'grant_special_flag' => $YN,
                'allowed_order_date' => $approve->to_period_date,
                'start_date' => $approve->created_at,
                'program_code' => 'OMP0013',
                'created_by' => '1',
                'form_header_id' => $request->id,
                'creation_date' => now(),
                'last_updated_by' => '1',
                'last_update_date' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return response()->json(['status' => 'success', 'msg' => $request->updateStatus . ' เรียบร้อยแล้ว']);
    }

    public function store(Request $request)
    {

        $from = Carbon::parse($request->from_period_date)->format('Y-m-d');
        // $from_period_id = DB::table('ptom_period_v')
        //     ->select('period_line_id')
        //     ->whereRaw("START_PERIOD <= DATE '" . $from . "' AND END_PERIOD >= DATE '" . $from . "'")
        //     ->first();
        $from_period_id = DB::select("SELECT * FROM PTOM_PERIOD_V WHERE START_PERIOD <= DATE '" . $from . "' AND END_PERIOD >= DATE '" . $from . "'");

        $to = Carbon::parse($request->to_period_date)->format('Y-m-d');
        // $to_period_id = DB::table('ptom_period_v')
        //     ->select('period_line_id')
        //     ->whereRaw("START_PERIOD <= DATE '" . $to . "' AND END_PERIOD >= DATE '" . $to . "'")
        //     ->first();

        $to_period_id = DB::select("SELECT * FROM PTOM_PERIOD_V WHERE START_PERIOD <= DATE '" . $to . "' AND END_PERIOD >= DATE '" . $to . "'");

        if (empty($from_period_id)) {
            return response()->json(['data' => 'error', 'message' => 'ไม่พบข้อมูลงวดที่วันที่สั่งซื้อ']);
        }

        if (empty($to_period_id)) {
            return response()->json(['data' => 'error', 'message' => 'ไม่พบข้อมูลงวดที่การสั่งซื้อครั้งถัดไป']);
        }

        $org_id = DB::select("SELECT ORGANIZATION_ID FROM OAOM.PTOM_OPERATING_UNITS_V WHERE SHORT_CODE = 'TOAT'");

        $id = FormOrderHeader::create([
            'org_id' => !empty($org_id) ? $org_id[0]->organization_id : '',
            'org_name' => '',
            'customer_id' => $request->customer_id,
            'customer_number' => $request->customer_number,
            'province' => $request->province,
            'period_name' => '-',
            'reason' => $request->reason,
            'uom' => $request->uom,
            'reason' => $request->reason,
            'approve_status' => $request->approve_status,
            'form_type' => $request->form_type,
            'program_code' => $request->program_code,
            'created_by' => $request->created_by,
            'last_updated_by' => $request->last_updated_by,
            'from_period_id' => $from_period_id[0]->period_line_id,
            'to_period_id' => $to_period_id[0]->period_line_id,
            'from_period_date' => date_format(date_create($request->from_period_date), "Y-m-d"),
            'to_period_date' => date_format(date_create($request->to_period_date), "Y-m-d"),
        ]);

        if (!$id) {
            return response()->json(['data' => 'error', 'message' => 'ไม่สามารถบันทึกข้อมูลได้']);
        }

        if ($request->item_id) {
            foreach ($request->item_id as $key => $item) {
                FormOrderLine::create([
                    'form_header_id' => $id->form_header_id,
                    'form_number' => $key + 1,
                    'item_id' => $item,
                    'item_code' => $request->item_code[$key],
                    'item_description' => $request->item_description[$key],
                    'serial' => $request->item_serial ? $request->item_serial[$key] : null,
                    'quantity' => intval(str_replace(',', '', $request->item_quantity[$key])),
                    'attribute1' => intval(str_replace(',', '', $request->item_quantity2[$key])),
                    'program_code' => $request->program_code,
                    'created_by' => $request->created_by,
                    'last_updated_by' => $request->last_updated_by,
                ]);
            }
        }

        $jsonData = [
            'data' => 'success',
            'message' => '',
        ];

        return response()->json($jsonData);
    }

    public function follow(Request $request)
    {
        $follows = new FormOrderHeader();
        $follows = $follows->join('ptom_customers', 'ptom_form_order_headers.customer_id', '=', 'ptom_customers.customer_id', 'left');
        if ($request->customer_number) {
            $follows = $follows->where('ptom_form_order_headers.customer_number', $request->customer_number);
        }
        if ($request->period_date) {
            $follows = $follows->whereRaw("PTOM_FORM_ORDER_HEADERS.TO_PERIOD_DATE = DATE '" . $request->period_date . "'");
        }
        if ($request->approve_status) {
            $follows = $follows->where('ptom_form_order_headers.approve_status', $request->approve_status);
        }
        $follows = $follows->where('ptom_form_order_headers.form_type', $request->form_type)->orderBy('form_header_id', 'DESC')->get(['ptom_form_order_headers.form_header_id', 'ptom_customers.customer_number', 'ptom_customers.customer_name', 'ptom_form_order_headers.approve_status', 'ptom_form_order_headers.from_period_date', 'ptom_form_order_headers.to_period_date', 'ptom_form_order_headers.reason', 'ptom_form_order_headers.creation_date', 'ptom_form_order_headers.attribute1']);

        return response()->json(['data' => $follows]);
    }

    public function approve(Request $request)
    {
        $approve = FormOrderHeader::find($request->id);
        if (!$approve) {
            return response()->json(['data' => [], 'status' => false, 'message' => 'ไม่พบข้อมูล']);
        }
        $approve->approve_status = $request->status;
        $approve->approve_date = date('Y-m-d');
        $approve->last_updated_by = $request->user_id;
        $approve->last_update_date = now();
        $approve->save();
        return response()->json(['data' => $approve, 'status' => true, 'message' => 'สำเร็จ']);
    }

    public function lastorder(Request $request)
    {
        $item_id        = $request->itemID;
        $item_code      = $request->itemCODE;
        $customer_id    = $request->customer_id;
        $orderID        = OrderHeader::where('customer_id', $customer_id)
                                    ->where('order_status', 'Confirm')
                                    ->orderBy('order_header_id', 'DESC')
                                    ->first();
        if (empty($orderID)) {
            return response()->json(['data' => '-']);
        }

        $lastorder      = OrderLines::where('order_header_id', $orderID->order_header_id)
                                    ->where('item_id', $item_id)
                                    ->where('item_code', $item_code)
                                    ->first();
        if (empty($lastorder)) {
            return response()->json(['data' => '-']);
        }


        return response()->json(['data'     => $lastorder->approve_quantity]);
    }

    public function lastOrderDate(Request $request)
    {
        $customer_id = $request->customer_id;
        $order = OrderHeader::where('customer_id', $customer_id)
                            ->where(function ($q) {
                                $q->where('order_status', '!=', 'Cancel');
                                $q->orWhere('order_status', '!=', 'Reject');
                            })
                            ->whereNotNull('pick_release_no')
                            ->orderBy('order_header_id', 'desc')
                            ->first();
        if (empty($order)) {
            return response()->json(['data' => '-']);
        }
        return response()->json(['data' => $order->creation_date]);
    }

    public function attribute1(Request $request)
    {
        foreach ($request->id as $key => $id) {
            $approve = FormOrderHeader::find($id);
            $approve->attribute1 = $request->attribute1[$key];
            $approve->last_update_date = Carbon::now();
            $approve->save();
        }

        return response()->json(['data' => 's']);
    }
}
