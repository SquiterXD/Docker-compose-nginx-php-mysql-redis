<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Mail\MailSender;
use App\Models\OM\AdditionQuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OM\Api\Customer;
use App\Models\OM\EmployeePosV;
use Illuminate\Support\Facades\Validator;
use App\Models\OM\AttachFiles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use App\Models\OM\AdditionQuotaLines;
use App\Models\OM\Api\AdditionQuotaHeader;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\Api\OrderLines;
use App\Models\OM\Api\OrderStatusHistory;
use App\Models\OM\CreditNote\CustomerContractGroupModel;
use App\Models\OM\Customers\Domestics\CustomerQuotaHeaders;
use App\Models\OM\OrderHeaders;
use App\Models\OM\PTOM_AUTHORITY_LISTS;
use App\Models\OM\PtomOrderHeader;
use App\Models\OM\PtomOrderLine;
use App\Models\OM\SaleConfirmation\OrderHistory;
use App\Models\OM\Saleorder\Domestic\CustomerQuotaLineModel;
use App\Models\User;
use App\Repositories\OM\GenerateNumberRepo;
use App\Repositories\OM\OrderRepo;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Mail;
use App\Models\OM\Api\AdditionQuotaLine;
use Illuminate\Support\Facades\Log;
use App\Models\OM\Settings\OverQuotaApproval;

class AdditionQuotaController extends Controller
{
    public function index()
    {
        $emp_array = [];
        $statusforapprove = false;
        $emps = DB::select("SELECT EMPLOYEE_APPROVE1,EMPLOYEE_APPROVE2,EMPLOYEE_APPROVE3,EMPLOYEE_SALES_DIVISION FROM PTOM_ADDITION_QUOTA_HEADERS WHERE APPROVE_STATUS = 'รอการอนุมัติ'");
        if (!empty($emps)) {
            foreach ($emps as $key => $emp) {
                if ($emp->employee_approve1 != null) {
                    if (!in_array($emp->employee_approve1, $emp_array)) {
                        array_push($emp_array, $emp->employee_approve1);
                    }
                }
                if ($emp->employee_approve2 != null) {
                    if (!in_array($emp->employee_approve2, $emp_array)) {
                        array_push($emp_array, $emp->employee_approve2);
                    }
                }
                if ($emp->employee_approve3 != null) {
                    if (!in_array($emp->employee_approve3, $emp_array)) {
                        array_push($emp_array, $emp->employee_approve3);
                    }
                }
                if ($emp->employee_sales_division != null) {
                    if (!in_array($emp->employee_sales_division, $emp_array)) {
                        array_push($emp_array, $emp->employee_sales_division);
                    }
                }
            }
        }

        if (request()->all()) {
            if (request()->customer_number != null || request()->order_number != null || request()->period_id != null || request()->status != null || request()->period_date != null) {
                $condition = " WHERE";
                $condition2 = false;
                if (request()->customer_number && request()->customer_number != null) {
                    if ($condition2) {
                        $condition .= " AND PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . request()->customer_number . "'";
                    } else {
                        $condition .= " PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . request()->customer_number . "'";
                        $condition2 = true;
                    }
                }

                if (request()->order_number && request()->order_number != null) {
                    if ($condition2) {
                        $condition .= " AND PTOM_ORDER_HEADERS.ORDER_NUMBER = '" . request()->order_number . "'";
                    } else {
                        $condition .= " PTOM_ORDER_HEADERS.ORDER_NUMBER = '" . request()->order_number . "'";
                        $condition2 = true;
                    }
                }

                if (request()->period_id && request()->period_id != null) {
                    $numberOfM = monthToNumber(request()->period_id);
                    if ($condition2) {
                        $condition .= " AND EXTRACT(MONTH FROM PTOM_ORDER_HEADERS.DELIVERY_DATE) IN " . $numberOfM . "";
                    } else {
                        $condition .= " EXTRACT(MONTH FROM PTOM_ORDER_HEADERS.DELIVERY_DATE) IN " . $numberOfM . "";
                        $condition2 = true;
                    }
                }

                if (request()->period_date && request()->period_date != null) {
                    if ($condition2) {
                        $condition .= " AND PTOM_ORDER_HEADERS.DELIVERY_DATE = DATE '" . parseFromDateTh(request()->period_date) . "'";
                    } else {
                        $condition .= " PTOM_ORDER_HEADERS.DELIVERY_DATE = DATE '" . parseFromDateTh(request()->period_date) . "'";
                        $condition2 = true;
                    }
                }

                if (request()->status && request()->status != null) {
                    if (request()->status != 'รอการอนุมัติ') {
                        if ($condition2) {
                            $condition .= " AND QUOTA_HEADERS.APPROVE_STATUS = '" . request()->status . "'";
                        } else {
                            $condition .= " QUOTA_HEADERS.APPROVE_STATUS = '" . request()->status . "'";
                            $condition2 = true;
                        }
                        $statusforapprove = false;
                    } else {
                        $user_number = PTOM_AUTHORITY_LISTS::whereIn('authority_id', $emp_array)->get(['employee_number']);
                        $number = [];
                        foreach ($user_number as $key => $value) {
                            array_push($number, $value->employee_number);
                        }
                        $getID = User::whereIn('username', $number)->get(['user_id']);

                        $valueUserID = [];
                        foreach ($getID as $key => $value) {
                            array_push($valueUserID, $value->user_id);
                        }

                        if (count($valueUserID) == 0) {
                            $statusforapprove = false;
                            if ($condition2) {
                                $condition .= " AND QUOTA_HEADERS.APPROVE_STATUS = '" . request()->status . "'";
                            } else {
                                $condition .= " QUOTA_HEADERS.APPROVE_STATUS = '" . request()->status . "'";
                                $condition2 = true;
                            }
                        } else {
                            if (in_array(getDefaultData('/users')->user_id, $valueUserID) || optional(auth()->user())->username == 'sysadmin') {
                                $statusforapprove = true;
                                if ($condition2) {
                                    $condition .= " AND QUOTA_HEADERS.APPROVE_STATUS = 'รอการอนุมัติ'";
                                } else {
                                    $condition .= " QUOTA_HEADERS.APPROVE_STATUS = 'รอการอนุมัติ'";
                                    $condition2 = true;
                                }
                            } else {
                                $statusforapprove = false;
                                if ($condition2) {
                                    $condition .= " AND QUOTA_HEADERS.APPROVE_STATUS = '" . request()->status . "'";
                                } else {
                                    $condition .= " QUOTA_HEADERS.APPROVE_STATUS = '" . request()->status . "'";
                                    $condition2 = true;
                                }
                            }
                        }
                    }
                } else {
                    $statusforapprove = false;
                }
            } else {
                $condition = "";
            }
        } else {
            $user_number = PTOM_AUTHORITY_LISTS::whereIn('authority_id', $emp_array)->get(['employee_number']);
            $number = [];
            foreach ($user_number as $key => $value) {
                array_push($number, $value->employee_number);
            }
            $getID = User::whereIn('username', $number)->get(['user_id']);

            $valueUserID = [];
            foreach ($getID as $key => $value) {
                array_push($valueUserID, $value->user_id);
            }

            // dd($valueUserID);
            $condition2 = false;
            if (count($valueUserID) == 0) {
                $statusforapprove = false;
                $condition = "";
            } else {
                if (request()->customer_number == null || request()->order_number == null || request()->period_id == null || request()->status == null || request()->period_date == null) {
                    if (in_array(getDefaultData('/users')->user_id, $valueUserID) || optional(auth()->user())->username == 'sysadmin') {
                        $statusforapprove = true;
                        $condition = " WHERE QUOTA_HEADERS.APPROVE_STATUS = 'รอการอนุมัติ'";
                    } else {
                        $statusforapprove = false;
                        $condition = "";
                    }
                } else {
                    $statusforapprove = false;
                    $condition = "";
                }
            }
        }

        $waittings = DB::select("SELECT QUOTA_HEADERS.QUOTA_HEADER_ID,PTOM_ORDER_HEADERS.ORDER_NUMBER,PTOM_ORDER_HEADERS.DELIVERY_DATE DELIVERY_DATE2,PTOM_CUSTOMERS.DELIVERY_DATE,QUOTA_HEADERS.EMPLOYEE_APPROVE1 EMPLOYEE_APPROVE1,QUOTA_HEADERS.EMPLOYEE_APPROVE2 EMPLOYEE_APPROVE2,QUOTA_HEADERS.EMPLOYEE_APPROVE3 EMPLOYEE_APPROVE3,QUOTA_HEADERS.EMPLOYEE_SALES_DIVISION EMPLOYEE_SALES_DIVISION,(SELECT EMPLOYEE_NAME FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V WHERE EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_APPROVE1) EMPLOYEE_POS1,(SELECT EMPLOYEE_NAME FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V WHERE EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_APPROVE2) EMPLOYEE_POS2,(SELECT EMPLOYEE_NAME FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V WHERE EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_APPROVE3) EMPLOYEE_POS3,(SELECT EMPLOYEE_NAME FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V WHERE EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_SALES_DIVISION) EMPLOYEE_DIVISION,QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE1,QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE2,QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE3,QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE4,QUOTA_HEADERS.APPROVE_STATUS,QUOTA_HEADERS.APPROVE_DATE,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_PERIOD_V.START_PERIOD,PTOM_ORDER_HEADERS.ORDER_DATE,PTOM_ORDER_HEADERS.CUSTOMER_ID FROM PTOM_ADDITION_QUOTA_HEADERS QUOTA_HEADERS LEFT JOIN PTOM_ORDER_HEADERS ON QUOTA_HEADERS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID LEFT JOIN PTOM_CUSTOMERS ON QUOTA_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID LEFT JOIN PTOM_PERIOD_V ON PTOM_ORDER_HEADERS.PERIOD_ID = PTOM_PERIOD_V.PERIOD_LINE_ID " . $condition . " ORDER BY QUOTA_HEADERS.QUOTA_HEADER_ID DESC");
        // dd($waittings);
        if ($statusforapprove && optional(auth()->user())->username != 'sysadmin') {
            $ordersinarray = [];
            $customersinarray = [];
            foreach ($waittings as $wor) {
                if (!in_array($wor->order_number, $ordersinarray)) {
                    if ($wor->approve_status == 'รอการอนุมัติ') {
                        array_push($ordersinarray, $wor->order_number);
                    }
                }
                if (!in_array($wor->customer_id, $customersinarray)) {
                    if ($wor->approve_status == 'รอการอนุมัติ') {
                        array_push($customersinarray, $wor->customer_id);
                    }
                }
            }

            $orders = AdditionQuota::join('ptom_order_headers', 'ptom_addition_quota_headers.order_header_id', 'ptom_order_headers.order_header_id', 'left')->whereIn('ptom_order_headers.order_number', $ordersinarray)->orderBy('ptom_order_headers.order_number', 'DESC')->get(['ptom_order_headers.order_number', 'ptom_order_headers.delivery_date']);

            $customers = Customer::whereIn('customer_id', $customersinarray)->where('sales_classification_code', 'Domestic')->orderBy('customer_number', 'ASC')->get();
        } else {
            $orders = DB::select("SELECT PTOM_ORDER_HEADERS.ORDER_NUMBER,PTOM_ORDER_HEADERS.DELIVERY_DATE FROM PTOM_ADDITION_QUOTA_HEADERS LEFT JOIN PTOM_ORDER_HEADERS ON PTOM_ADDITION_QUOTA_HEADERS.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID ORDER BY PTOM_ORDER_HEADERS.ORDER_NUMBER DESC");

            $customers = Customer::where('sales_classification_code', 'Domestic')->orderBy('customer_number', 'ASC')->get();
        }

        return view('om.addition_quota.index', compact('waittings', 'customers', 'orders', 'statusforapprove'));
    }

    private function sendmailtoapprover($id, $step)
    {
        $datainfo = AdditionQuota::with(array('files' => function ($query) {
            $query->where('ptom_attachments.program_code', '=', 'OMP0015');
        }))->leftJoin('ptom_order_headers', 'ptom_addition_quota_headers.order_header_id', '=', 'ptom_order_headers.order_header_id')->leftJoin('ptom_order_lines', 'ptom_order_headers.order_header_id', '=', 'ptom_order_lines.order_header_id')->where('ptom_addition_quota_headers.quota_header_id', '=', $id)->groupBy('ptom_addition_quota_headers.customer_id', 'ptom_addition_quota_headers.order_header_id', 'ptom_addition_quota_headers.quota_header_id', 'ptom_addition_quota_headers.employee_approve1', 'ptom_addition_quota_headers.employee_approve2', 'ptom_addition_quota_headers.employee_approve3', 'ptom_addition_quota_headers.employee_sales_division', 'ptom_addition_quota_headers.acting_position1', 'ptom_addition_quota_headers.acting_position2', 'ptom_addition_quota_headers.acting_position3', 'ptom_addition_quota_headers.acting_position_sale')->get(['ptom_addition_quota_headers.customer_id', 'ptom_addition_quota_headers.order_header_id', 'ptom_addition_quota_headers.quota_header_id', 'ptom_addition_quota_headers.employee_approve1', 'ptom_addition_quota_headers.employee_approve2', 'ptom_addition_quota_headers.employee_approve3', 'ptom_addition_quota_headers.employee_sales_division', 'ptom_addition_quota_headers.acting_position1', 'ptom_addition_quota_headers.acting_position2', 'ptom_addition_quota_headers.acting_position3', 'ptom_addition_quota_headers.acting_position_sale']);

        if (empty($datainfo)) return back()->withErrors('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');

        $addtion = AdditionQuota::find($id);
        $customer = DB::select("select  ptom_customers.customer_name, ptom_customers.customer_number, ptom_customers.delivery_date, 
                                        ptom_thailand_territory_v.province_thai, ptom_period_v.start_period 
                                from    ptom_order_headers 
                                left join ptom_customers on ptom_order_headers.customer_id = ptom_customers.customer_id 
                                left join ptom_period_v on ptom_order_headers.period_id = ptom_period_v.period_line_id 
                                left join ptom_thailand_territory_v on ptom_customers.province_code = ptom_thailand_territory_v.province_id 
                                where ptom_order_headers.order_header_id = $addtion->order_header_id 
                                group by    ptom_customers.customer_name, 
                                            ptom_customers.customer_number,
                                            ptom_thailand_territory_v.province_thai,
                                            ptom_period_v.start_period,
                                            ptom_customers.delivery_date");
        $approvers = DB::select("SELECT QUOTA_HEADERS.EMPLOYEE_APPROVE1 EMPLOYEE_APPROVE1,
                                        QUOTA_HEADERS.EMPLOYEE_APPROVE2 EMPLOYEE_APPROVE2,
                                        QUOTA_HEADERS.EMPLOYEE_APPROVE3 EMPLOYEE_APPROVE3,
                                        QUOTA_HEADERS.EMPLOYEE_SALES_DIVISION EMPLOYEE_SALES_DIVISION,
                                    (   SELECT EMPLOYEE_NAME 
                                        FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V 
                                        WHERE EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_APPROVE1) EMPLOYEE_POS1,
                                    (   SELECT EMPLOYEE_NAME 
                                        FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V 
                                        WHERE EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_APPROVE2) EMPLOYEE_POS2,
                                    (   SELECT EMPLOYEE_NAME 
                                        FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V 
                                        WHERE EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_APPROVE3) EMPLOYEE_POS3,
                                    (   SELECT EMPLOYEE_NAME 
                                        FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V 
                                        WHERE EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_SALES_DIVISION) EMPLOYEE_DIVISION, 
                                        QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE4,
                                        QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE1,
                                        QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE2,
                                        QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE3,
                                        QUOTA_HEADERS.COMMENT_SALES,
                                        QUOTA_HEADERS.COMMENT_EMPLOYEE1,
                                        QUOTA_HEADERS.COMMENT_EMPLOYEE2,
                                        QUOTA_HEADERS.COMMENT_EMPLOYEE3 
                                FROM PTOM_ADDITION_QUOTA_HEADERS QUOTA_HEADERS 
                                WHERE QUOTA_HEADERS.QUOTA_HEADER_ID = $id");
        $page = 'om.addition_quota.email';
        $emails = [];

        if ($approvers[0]->employee_sales_division != null) {
            $salePTOM_AUTHORITY_LISTS = PTOM_AUTHORITY_LISTS::where('authority_id', $approvers[0]->employee_sales_division)->first(['employee_number']);
            $salePTW_USERS = User::where('username', $salePTOM_AUTHORITY_LISTS->employee_number)->first(['email']);
            if (!empty($salePTW_USERS) && $salePTW_USERS->email != null) {
                array_push($emails, $salePTW_USERS->email);
            }
        }

        if ($approvers[0]->employee_approve1 != null) {
            $emp1PTOM_AUTHORITY_LISTS = PTOM_AUTHORITY_LISTS::where('authority_id', $approvers[0]->employee_approve1)->first(['employee_number']);
            $emp1PTW_USERS = User::where('username', $emp1PTOM_AUTHORITY_LISTS->employee_number)->first(['email']);
            if (!empty($emp1PTW_USERS) && $emp1PTW_USERS->email != null) {
                array_push($emails, $emp1PTW_USERS->email);
            }
        }

        if ($approvers[0]->employee_approve2 != null) {
            $emp2PTOM_AUTHORITY_LISTS = PTOM_AUTHORITY_LISTS::where('authority_id', $approvers[0]->employee_approve2)->first(['employee_number']);
            $emp2PTW_USERS = User::where('username', $emp2PTOM_AUTHORITY_LISTS->employee_number)->first(['email']);
            if (!empty($emp2PTW_USERS) && $emp2PTW_USERS->email != null) {
                array_push($emails, $emp2PTW_USERS->email);
            }
        }

        if ($approvers[0]->employee_approve3 != null) {
            $emp3PTOM_AUTHORITY_LISTS = PTOM_AUTHORITY_LISTS::where('authority_id', $approvers[0]->employee_approve3)->first(['employee_number']);
            $emp3PTW_USERS = User::where('username', $emp3PTOM_AUTHORITY_LISTS->employee_number)->first(['email']);
            if (!empty($emp3PTW_USERS) && $emp3PTW_USERS->email != null) {
                array_push($emails, $emp3PTW_USERS->email);
            }
        }

        $data = [
            'addtion'   => $addtion,
            'customer'  => $customer
        ];

        if (count($emails) > 0) {
            try {
                Mail::to($emails)->send(new MailSender('ขออนุมัติเพดานการจำหน่าย '.$data['customer'][0]->customer_number.' '. $data['customer'][0]->customer_name, $data, $page));
            } catch (\Throwable $th) {
                Log::error('ส่งเมลไม่ผ่าน ในDEV4 ชื่อ: ขออนุมัติเพดานการจำหน่าย '.$data['customer'][0]->customer_number.' '. $data['customer'][0]->customer_name );
            }
        }
    }

    public function stepone($id, $step)
    {
        $datainfo = AdditionQuota::with(array('files' => function ($query) {
            $query->where('ptom_attachments.program_code', '=', 'OMP0015');
        })) ->leftJoin('ptom_order_headers', 'ptom_addition_quota_headers.order_header_id', '=', 'ptom_order_headers.order_header_id')
            ->leftJoin('ptom_order_lines', 'ptom_order_headers.order_header_id', '=', 'ptom_order_lines.order_header_id')
            ->where('ptom_addition_quota_headers.quota_header_id', '=', $id)
            ->groupBy(  'ptom_addition_quota_headers.customer_id', 
                        'ptom_addition_quota_headers.order_header_id', 
                        'ptom_addition_quota_headers.quota_header_id', 
                        'ptom_addition_quota_headers.employee_approve1', 
                        'ptom_addition_quota_headers.employee_approve2', 
                        'ptom_addition_quota_headers.employee_approve3', 
                        'ptom_addition_quota_headers.employee_sales_division', 
                        'ptom_addition_quota_headers.acting_position1', 
                        'ptom_addition_quota_headers.acting_position2', 
                        'ptom_addition_quota_headers.acting_position3', 
                        'ptom_addition_quota_headers.acting_position_sale')
            ->get([ 'ptom_addition_quota_headers.customer_id', 
                    'ptom_addition_quota_headers.order_header_id', 
                    'ptom_addition_quota_headers.quota_header_id', 
                    'ptom_addition_quota_headers.employee_approve1', 
                    'ptom_addition_quota_headers.employee_approve2', 
                    'ptom_addition_quota_headers.employee_approve3', 
                    'ptom_addition_quota_headers.employee_sales_division', 
                    'ptom_addition_quota_headers.acting_position1', 
                    'ptom_addition_quota_headers.acting_position2', 
                    'ptom_addition_quota_headers.acting_position3', 
                    'ptom_addition_quota_headers.acting_position_sale'      ]);

        $datainfoss = AdditionQuota::where('ptom_addition_quota_headers.quota_header_id', '=', $id)
                                    ->first([   'ptom_addition_quota_headers.acting_position1', 
                                                'ptom_addition_quota_headers.acting_position2', 
                                                'ptom_addition_quota_headers.acting_position3', 
                                                'ptom_addition_quota_headers.acting_position_sale'  ]);
        if (empty($datainfo)) return back()->withErrors('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
        
        $customerId             = $datainfo[0]['customer_id'];   
        $customerDeliveryType   = Customer::where('customer_id',$customerId)->value('delivery_date');
        $addtion                = AdditionQuota::find($id);
        $order_dates            = DB::select("  SELECT  ORDER_HEADER_ID,ORDER_DATE,DELIVERY_DATE,
                                                        CUSTOMER_ID,PERIOD_ID 
                                                FROM PTOM_ORDER_HEADERS 
                                                WHERE ORDER_HEADER_ID = " . $datainfo[0]->order_header_id . " 
                                                ORDER BY ORDER_HEADER_ID DESC FETCH FIRST 1 ROWS ONLY ");
        $periodId   = $order_dates[0]->period_id;
        $sql = "
            SELECT      ROWNUM,
                        OH.ORDER_DATE,
                        OH.PERIOD_ID,
                        PV.START_PERIOD,
                        AQH.QUOTA_HEADER_ID,
                        AQH.APPROVE_STATUS,
                        OH.ORDER_HEADER_ID,
                        OH.DELIVERY_DATE
            FROM        PTOM_ADDITION_QUOTA_HEADERS AQH,
                        PTOM_ORDER_HEADERS          OH,
                        PTOM_PERIOD_V               PV
            WHERE       1=1
            AND         AQH.ORDER_HEADER_ID = OH.ORDER_HEADER_ID
           -- AND         AQH.APPROVE_STATUS = 'อนุมัติ'
            AND         OH.PERIOD_ID = PV.PERIOD_LINE_ID
            AND         OH.CUSTOMER_ID = '{$customerId}'
            AND         OH.PERIOD_ID = '{$periodId}'
            ORDER BY    OH.ORDER_HEADER_ID
        ";
        $arrPeriod      = DB::select($sql);

        $sqlCheckPer = "
            SELECT      ROWNUM,
                        OH.ORDER_DATE,
                        OH.PERIOD_ID,
                        PV.START_PERIOD,
                        AQH.QUOTA_HEADER_ID,
                        AQH.APPROVE_STATUS,
                        OH.ORDER_HEADER_ID,
                        OH.DELIVERY_DATE
            FROM        PTOM_ADDITION_QUOTA_HEADERS AQH,
                        PTOM_ORDER_HEADERS          OH,
                        PTOM_PERIOD_V               PV
            WHERE       1=1
            AND         AQH.ORDER_HEADER_ID = OH.ORDER_HEADER_ID
            AND         AQH.APPROVE_STATUS = 'อนุมัติ'
            AND         OH.PERIOD_ID = PV.PERIOD_LINE_ID
            AND         OH.CUSTOMER_ID = '{$customerId}'
            AND         OH.PERIOD_ID = '{$periodId}'
            ORDER BY    OH.ORDER_HEADER_ID
        ";
        $arrPeriodCheckPers      = DB::select($sqlCheckPer);
        $pers = 1;
        foreach ($arrPeriodCheckPers as $key => $value) {
            if($order_dates[0]->order_header_id == $value->order_header_id){
                $pers = $value->rownum;
            }
        }

        // dd($arrPeriod);
        if($order_dates){
            $date = Carbon::parse($order_dates[0]->delivery_date)->format('Y-m-d');
            $customerrrr = DB::select("select delivery_date from ptom_customers where customer_id = '" . $order_dates[0]->customer_id . "'");
            $valuedate = dayTHcompare($customerrrr[0]->delivery_date, $order_dates[0]->order_date);
            $dataLines = DB::table('ptom_addition_quota_lines')
                            ->select(   'quota_line_id', 'quota_header_id', 'quota_quantity', 
                                        'last_approve_quantity', 'request_quantity', 'total_quantity', 
                                        'last_total_quantity', 'quota_group_id', 'approve_quantity'     )
                            ->where('quota_header_id', '=', $id)
                            ->get();
            $order2last = DB::select("  SELECT ORDER_HEADER_ID,ORDER_DATE,PERIOD_ID,CUSTOMER_ID 
                                        FROM PTOM_ORDER_HEADERS 
                                        WHERE CUSTOMER_ID = '" . $order_dates[0]->customer_id . "' 
                                        AND ORDER_STATUS = 'Confirm' 
                                        ORDER BY ORDER_HEADER_ID DESC FETCH FIRST 2 ROWS ONLY");
        }
        $orders = DB::select("  SELECT ORDER_DATE,DELIVERY_DATE , ORDER_HEADER_ID, CUSTOMER_ID
                                FROM PTOM_ORDER_HEADERS 
                                WHERE ORDER_HEADER_ID = '" . $addtion->order_header_id . "' FETCH FIRST 1 ROWS ONLY");
        $order_lasted  = DB::table('PTOM_ORDER_HEADERS')->where('order_status','Confirm')->where('order_header_id', '<',  $addtion->order_header_id)->where('customer_id', $addtion->customer_id)->orderBy('order_header_id', 'desc')->first();
        
        if ($orders[0]->delivery_date == null) {
            $last_datr  = '';
        } else {
            if($customerDeliveryType == 'ทุกวัน'){
                $seq = $pers - 1;
                if($seq == 0){

                    $searchLastOrder = OrderHeaders::where('order_header_id', '<', $orders[0]->order_header_id)
                    ->where('pick_release_status', 'Confirm')
                    ->where('customer_id', $orders[0]->customer_id)
                    ->orderBy('order_header_id', 'desc')
                    ->first();
                    $last_datr = Carbon::createFromFormat('Y-m-d H:i:s',$searchLastOrder->delivery_date)->format('Y-m-d');

                }else {
                    foreach ($arrPeriod as $key => $value) {
                        if((int)$value->rownum == $seq){
                            $last_datr = Carbon::parse($value->delivery_date)->format('Y-m-d');
                        }
                    }
                     $last_datr =  Carbon::parse($order_lasted->order_date)->format('Y-m-d');

                }
            }else{
                // $last_datr = Carbon::parse($orders[0]->delivery_date)->subDays(7)->format('Y-m-d');
                $last_datr =  Carbon::parse($order_lasted->order_date)->format('Y-m-d');
            }
        }


        $lookupcodes            = [];
        $headers                = [];
        $meaning                = [];
        $line_id                = [];
        $received_quota         = [];
        $order_quantity         = [];
        $order_approve          = [];
        $last_approve_quantity  = [];
        $emp_approve            = [];
        $emp_approve1           = [];
        $emp_approve2           = [];
        $emp_approve3           = [];
        $emp_division           = [];
        $actingg                = [];
        $actingg1               = [];
        $actingg2               = [];
        $actingg3               = [];
        $arraylastinfosumorder  = [];
        $orderB                 = [];
        $before_quantity        = [];
        $total_approve_amount   = 0;

        foreach ($dataLines as $key => $value) {
            array_push($line_id, $value->quota_line_id);
            array_push($lookupcodes, $value->quota_group_id);
            array_push($order_quantity, $value->request_quantity);
            array_push($before_quantity, $value->last_approve_quantity);
            if ($value->approve_quantity != null || $value->approve_quantity != '') {
                array_push($order_approve, $value->approve_quantity);

                $total_approve_amount = $total_approve_amount + $value->approve_quantity;
            } else {
                array_push($order_approve, $value->request_quantity);
                $total_approve_amount = $total_approve_amount + $value->request_quantity;
            }
            array_push($last_approve_quantity, $value->last_approve_quantity);

            $look = strlen($value->quota_group_id) == 2 ? $value->quota_group_id : '0' . $value->quota_group_id;
            $l = strlen($value->quota_group_id) == 2 ? substr($value->quota_group_id, 1) : $value->quota_group_id;

            if ($orders[0]->delivery_date == null) {
                array_push($arraylastinfosumorder, '-');
                array_push($orderB, '-');
            } else {
                $arr_distance = [];
                $distance = DB::select("SELECT DISTINCT ITEM_ID FROM PTOM_ORDER_LINES INNER JOIN PTOM_ORDER_HEADERS ON PTOM_ORDER_LINES.ORDER_HEADER_ID = PTOM_ORDER_HEADERS.ORDER_HEADER_ID WHERE PTOM_ORDER_LINES.ITEM_ID IN (SELECT ITEM_ID FROM PTOM_QUOTA_AND_CREDIT_GROUP WHERE QUOTA_GROUP_CODE = '" . $look . "') AND PTOM_ORDER_HEADERS.ORDER_DATE = DATE '" . $last_datr . "'");
                foreach ($distance as $key => $value) {
                    array_push($arr_distance, $value->item_id);
                }
                $orderidsss = PtomOrderHeader::whereRaw("ORDER_DATE = DATE '" . $last_datr . "'")->where('order_status', 'Confirm')->where('customer_id', '=', $order_dates[0]->customer_id)->pluck('order_header_id')->toArray();
                $arraylastinfosumorders = PtomOrderLine::whereIn('order_header_id', $orderidsss)->whereIn('item_id', $arr_distance)->sum('approve_quantity');

                array_push($arraylastinfosumorder, $arraylastinfosumorders);

                $orderBF = DB::select("SELECT PTOM_ADDITION_QUOTA_LINES.APPROVE_QUANTITY FROM PTOM_ADDITION_QUOTA_LINES LEFT JOIN PTOM_ADDITION_QUOTA_HEADERS ON PTOM_ADDITION_QUOTA_LINES.QUOTA_HEADER_ID = PTOM_ADDITION_QUOTA_HEADERS.QUOTA_HEADER_ID WHERE PTOM_ADDITION_QUOTA_HEADERS.ORDER_HEADER_ID IN (SELECT ORDER_HEADER_ID FROM PTOM_ORDER_HEADERS WHERE CUSTOMER_ID = '" . $order_dates[0]->customer_id . "' AND ORDER_DATE = DATE '" . $last_datr . "') AND PTOM_ADDITION_QUOTA_HEADERS.APPROVE_STATUS = 'อนุมัติ' AND PTOM_ADDITION_QUOTA_LINES.QUOTA_GROUP_ID = '" . $look . "' AND PTOM_ADDITION_QUOTA_HEADERS.CUSTOMER_ID = '" . $order_dates[0]->customer_id . "' ORDER BY PTOM_ADDITION_QUOTA_HEADERS.QUOTA_HEADER_ID DESC FETCH FIRST 1 ROWS ONLY");
                $orderBB = $orderBF[0]->approve_quantity ?? '-';
                array_push($orderB, $orderBB);
            }

            if ($customerrrr[0]->delivery_date == 'ทุกวัน') {
                $todaycountquota = Carbon::parse($order_dates[0]->delivery_date)->format('Y-m-d');

                $dataQuota = DB::select("SELECT PTOM_QUOTA_GROUP.LOOKUP_CODE,
                                                PTOM_QUOTA_GROUP.MEANING,
                                                SUM(PTOM_CUSTOMER_QUOTA_LINES.RECEIVED_QUOTA) RECEIVED_QUOTA,
                                                SUM(PTOM_CUSTOMER_QUOTA_LINES.REMAINING_QUOTA) REMAINING_QUOTA 
                                        FROM PTOM_CUSTOMER_QUOTA_LINES 
                                        LEFT JOIN PTOM_QUOTA_AND_CREDIT_GROUP 
                                        ON PTOM_CUSTOMER_QUOTA_LINES.ITEM_CODE = PTOM_QUOTA_AND_CREDIT_GROUP.ITEM_CODE 
                                        LEFT JOIN PTOM_QUOTA_GROUP 
                                        ON PTOM_QUOTA_AND_CREDIT_GROUP.QUOTA_GROUP_CODE = PTOM_QUOTA_GROUP.LOOKUP_CODE 
                                        WHERE PTOM_CUSTOMER_QUOTA_LINES.QUOTA_HEADER_ID 
                                        IN (SELECT QUOTA_HEADER_ID 
                                            FROM PTOM_CUSTOMER_QUOTA_HEADERS 
                                            WHERE CUSTOMER_ID = '" . $order_dates[0]->customer_id . "' 
                                            AND START_DATE <= DATE '" . $todaycountquota . "' 
                                            AND END_DATE >= DATE '" . $todaycountquota . "' 
                                            AND UPPER(STATUS) = 'ACTIVE' AND DELETED_AT IS NULL) 
                                            AND PTOM_QUOTA_GROUP.LOOKUP_CODE = '" . $look . "' 
                                            GROUP BY PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING 
                                            ORDER BY PTOM_QUOTA_GROUP.LOOKUP_CODE ASC");
            } else {
                $todaycountquota = Carbon::parse($order_dates[0]->delivery_date)->format('Y-m-d');

                $dataQuota = DB::select("SELECT PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING,SUM(PTOM_CUSTOMER_QUOTA_LINES.RECEIVED_QUOTA) RECEIVED_QUOTA,SUM(PTOM_CUSTOMER_QUOTA_LINES.REMAINING_QUOTA) REMAINING_QUOTA FROM PTOM_CUSTOMER_QUOTA_LINES LEFT JOIN PTOM_QUOTA_AND_CREDIT_GROUP ON PTOM_CUSTOMER_QUOTA_LINES.ITEM_CODE = PTOM_QUOTA_AND_CREDIT_GROUP.ITEM_CODE LEFT JOIN PTOM_QUOTA_GROUP ON PTOM_QUOTA_AND_CREDIT_GROUP.QUOTA_GROUP_CODE = PTOM_QUOTA_GROUP.LOOKUP_CODE WHERE PTOM_CUSTOMER_QUOTA_LINES.QUOTA_HEADER_ID IN (SELECT QUOTA_HEADER_ID FROM PTOM_CUSTOMER_QUOTA_HEADERS WHERE CUSTOMER_ID = '" . $order_dates[0]->customer_id . "' AND START_DATE <= DATE '" . $todaycountquota . "' AND END_DATE >= DATE '" . $todaycountquota . "' AND UPPER(STATUS) = 'ACTIVE' AND DELETED_AT IS NULL) AND PTOM_QUOTA_GROUP.LOOKUP_CODE = '" . $look . "' GROUP BY PTOM_QUOTA_GROUP.LOOKUP_CODE,PTOM_QUOTA_GROUP.MEANING ORDER BY PTOM_QUOTA_GROUP.LOOKUP_CODE ASC");
            }

            array_push($meaning, $dataQuota[0]->meaning);
            array_push($received_quota, $dataQuota[0]->received_quota);

            $now = Carbon::parse($order_dates[0]->delivery_date);
            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d');

            $beforeQuotas = AdditionQuotaHeader::where('customer_id', $order_dates[0]->customer_id)->whereBetween('approve_date', [$weekStartDate, $weekEndDate])->where('quota_header_id', '!=', $id)->first();
        }
        array_push($headers, $id);
        array_push($emp_approve1, $datainfo[0]->employee_approve1);
        array_push($emp_approve2, $datainfo[0]->employee_approve2);
        array_push($emp_approve3, $datainfo[0]->employee_approve3);
        array_push($emp_division, $datainfo[0]->employee_sales_division);
        array_push($actingg, $datainfo[0]->acting_position_sale);
        array_push($actingg1, $datainfo[0]->acting_position1);
        array_push($actingg2, $datainfo[0]->acting_position2);
        array_push($actingg3, $datainfo[0]->acting_position3);
        array_push($emp_approve, returnUserID($datainfo[0]->employee_approve1));
        array_push($emp_approve, returnUserID($datainfo[0]->employee_approve2));
        array_push($emp_approve, returnUserID($datainfo[0]->employee_approve3));
        array_push($emp_approve, returnUserID($datainfo[0]->employee_sales_division));
        $employs = PTOM_AUTHORITY_LISTS::get();

        $nameemptitle = EmployeePosV::whereIn('employee_id', $emp_approve3)->first(['employee_name']);

        $customer = DB::select("select ptom_customers.customer_name,ptom_customers.delivery_date,ptom_thailand_territory_v.province_thai,ptom_period_v.start_period from ptom_order_headers left join ptom_customers on ptom_order_headers.customer_id = ptom_customers.customer_id left join ptom_period_v on ptom_order_headers.period_id = ptom_period_v.period_line_id left join ptom_thailand_territory_v on ptom_customers.province_code = ptom_thailand_territory_v.province_id where ptom_order_headers.order_header_id = $addtion->order_header_id group by ptom_customers.customer_name,ptom_thailand_territory_v.province_thai,ptom_period_v.start_period,ptom_customers.delivery_date");
        $totalAditionQuota = array_sum($order_quantity) ?? 0;

        if (is_null($datainfo[0]->employee_approve1) || 
            is_null($datainfo[0]->employee_approve2) || 
            is_null($datainfo[0]->employee_approve3)    ) {
            $datePeriod = Carbon::parse($customer[0]->start_period)->format('Y-m-d');
            $empApprove = DB::select("  SELECT  SALES_DIVISION_ID, 
                                                OVER_QUOTA_ID, 
                                                AUTHORITY_ID1, 
                                                AUTHORITY_ID2, 
                                                AUTHORITY_ID3 
                                        FROM PTOM_OVER_QUOTA_APPROVALS 
                                        WHERE CBB_RANGE_FROM <= {$totalAditionQuota} 
                                        AND CBB_RANGE_TO >= {$totalAditionQuota} 
                                        AND START_DATE <= TO_DATE('" . $datePeriod . "','YYYY-MM-DD') 
                                        AND END_DATE IS NULL OR END_DATE >= TO_DATE('" . $datePeriod . "','YYYY-MM-DD') ");

            if (empty($empApprove) || $empApprove == null || $empApprove == '') return back()->withErrors('ไม่พบรายชื่อผ้อนุมัติ หรือ ข้อมลรายชื่อผ้อนุมัติไม่ถกต้อง');

            $emp_approve1[0] = $empApprove[0]->authority_id1;
            $emp_approve2[0] = $empApprove[0]->authority_id2;
            $emp_approve3[0] = $empApprove[0]->authority_id3;
            $emp_division[0] = $empApprove[0]->sales_division_id;
        }

        $actings        = DB::select("SELECT LOOKUP_CODE,MEANING FROM PTOM_ACTING_POSITION_V WHERE ENABLED_FLAG = 'Y'");

        $approvers      = DB::select("SELECT    QUOTA_HEADERS.EMPLOYEE_APPROVE1 EMPLOYEE_APPROVE1,
                                                QUOTA_HEADERS.EMPLOYEE_APPROVE2 EMPLOYEE_APPROVE2,
                                                QUOTA_HEADERS.EMPLOYEE_APPROVE3 EMPLOYEE_APPROVE3,
                                                QUOTA_HEADERS.EMPLOYEE_SALES_DIVISION EMPLOYEE_SALES_DIVISION,
                                    (   SELECT EMPLOYEE_NAME 
                                        FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V 
                                        WHERE EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_APPROVE1) EMPLOYEE_POS1,

                                    (   SELECT EMPLOYEE_NAME 
                                        FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V 
                                        WHERE EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_APPROVE2) EMPLOYEE_POS2,

                                    (   SELECT EMPLOYEE_NAME 
                                        FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V 
                                        WHERE EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_APPROVE3) EMPLOYEE_POS3,
                                    
                                    (   SELECT EMPLOYEE_NAME 
                                        FROM PTOM_PO_EMPLOYEE_POS_V EMPLOYEE_POS_V 
                                        WHERE   EMPLOYEE_POS_V.EMPLOYEE_ID = EMPLOYEE_SALES_DIVISION) EMPLOYEE_DIVISION, 
                                                QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE4,
                                                QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE1,
                                                QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE2,
                                                QUOTA_HEADERS.STATUS_EMPOLYEE_APPROVE3,
                                                QUOTA_HEADERS.COMMENT_SALES,
                                                QUOTA_HEADERS.COMMENT_EMPLOYEE1,
                                                QUOTA_HEADERS.COMMENT_EMPLOYEE2,
                                                QUOTA_HEADERS.COMMENT_EMPLOYEE3,
                                                QUOTA_HEADERS.SALES_DIVISION_ADDITIONAL,
                                                QUOTA_HEADERS.AUTHORITY_ID1_ADDITIONAL,
                                                QUOTA_HEADERS.AUTHORITY_ID2_ADDITIONAL,
                                                QUOTA_HEADERS.AUTHORITY_ID3_ADDITIONAL
                                        FROM PTOM_ADDITION_QUOTA_HEADERS QUOTA_HEADERS 
                                        WHERE QUOTA_HEADERS.QUOTA_HEADER_ID = $id"                                          );
                        
        $empmyseft      = PTOM_AUTHORITY_LISTS::leftJoin('ptw_users', 'ptom_authority_lists.employee_number', 'ptw_users.username')
                                                ->where('ptw_users.user_id', getDefaultData('/users')->user_id)
                                                ->first(['ptom_authority_lists.employee_name', 'ptom_authority_lists.position_name']);

        $datacustomer   = DB::select("SELECT PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_CUSTOMERS.CUSTOMER_ID,PTOM_CUSTOMERS.CUSTOMER_NUMBER,PTOM_CUSTOMERS.BILL_TO_SITE_NAME,PTOM_CUSTOMERS.ADDRESS_LINE1,PTOM_CUSTOMERS.ADDRESS_LINE2,PTOM_CUSTOMERS.ADDRESS_LINE3,P.PROVINCE_THAI,A.CITY_THAI,T.TAMBON_THAI,PTOM_CUSTOMERS.ALLEY,PTOM_CUSTOMERS.POSTAL_CODE,PTOM_CUSTOMERS.CONTACT_PHONE FROM PTOM_CUSTOMERS LEFT JOIN PTOM_THAILAND_TERRITORY_V P ON PTOM_CUSTOMERS.PROVINCE_CODE = P.PROVINCE_ID LEFT JOIN PTOM_THAILAND_TERRITORY_V A ON PTOM_CUSTOMERS.CITY_CODE = A.CITY_CODE LEFT JOIN PTOM_THAILAND_TERRITORY_V T ON PTOM_CUSTOMERS.DISTRICT_CODE = T.TAMBON_ID WHERE PTOM_CUSTOMERS.CUSTOMER_ID = '" . $order_dates[0]->customer_id . "' FETCH FIRST 1 ROWS ONLY");

        $empsale        = PTOM_AUTHORITY_LISTS::where('authority_id', $approvers[0]->employee_sales_division)
                                                ->leftJoin('PTOM_ADDITION_QUOTA_HEADERS', 'PTOM_ADDITION_QUOTA_HEADERS.EMPLOYEE_SALES_DIVISION', 'PTOM_AUTHORITY_LISTS.AUTHORITY_ID')
                                                ->whereRaw("PTOM_ADDITION_QUOTA_HEADERS.QUOTA_HEADER_ID = $id")
                                                ->first(['employee_name', 'position_name', 'sales_division_additional']);

        $emp1           = PTOM_AUTHORITY_LISTS::where('authority_id', $approvers[0]->employee_approve1)
                                                ->leftJoin('PTOM_ADDITION_QUOTA_HEADERS', 'PTOM_ADDITION_QUOTA_HEADERS.EMPLOYEE_APPROVE1', 'PTOM_AUTHORITY_LISTS.AUTHORITY_ID')
                                                ->whereRaw("PTOM_ADDITION_QUOTA_HEADERS.QUOTA_HEADER_ID = $id")
                                                ->first(['employee_name', 'position_name', 'authority_id1_additional']);

        $emp2           = PTOM_AUTHORITY_LISTS::where('authority_id', $approvers[0]->employee_approve2)
                                                ->leftJoin('PTOM_ADDITION_QUOTA_HEADERS', 'PTOM_ADDITION_QUOTA_HEADERS.EMPLOYEE_APPROVE2', 'PTOM_AUTHORITY_LISTS.AUTHORITY_ID')
                                                ->whereRaw("PTOM_ADDITION_QUOTA_HEADERS.QUOTA_HEADER_ID = $id")
                                                ->first(['employee_name', 'position_name', 'authority_id2_additional']);

        $emp3           = PTOM_AUTHORITY_LISTS::where('authority_id', $approvers[0]->employee_approve3)
                                                ->leftJoin('PTOM_ADDITION_QUOTA_HEADERS', 'PTOM_ADDITION_QUOTA_HEADERS.EMPLOYEE_APPROVE3', 'PTOM_AUTHORITY_LISTS.AUTHORITY_ID')
                                                ->whereRaw("PTOM_ADDITION_QUOTA_HEADERS.QUOTA_HEADER_ID = $id")
                                                ->first(['employee_name', 'position_name', 'authority_id3_additional']);

        $dataOwner      = DB::select("SELECT PTOM_CUSTOMER_OWNERS.OWNER_NO,PTOM_CUSTOMER_OWNERS.PREFIX,PTOM_CUSTOMER_OWNERS.OWNER_FIRST_NAME,PTOM_CUSTOMER_OWNERS.OWNER_LAST_NAME FROM PTOM_CUSTOMER_OWNERS,PTOM_CUSTOMERS WHERE PTOM_CUSTOMER_OWNERS.STATUS <> 'INACTIVE' AND PTOM_CUSTOMER_OWNERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID AND PTOM_CUSTOMER_OWNERS.DELETED_AT is null AND PTOM_CUSTOMERS.CUSTOMER_ID = '" . $order_dates[0]->customer_id . "' ORDER BY PTOM_CUSTOMER_OWNERS.OWNER_NO DESC FETCH FIRST 1 ROWS ONLY");

        if ($step != 0) {
            $dbsql = DB::select("SELECT LAST_UPDATED_BY,LAST_UPDATE_DATE FROM PTOM_ADDITION_QUOTA_HEADERS WHERE QUOTA_HEADER_ID = '" . $id . "'");
            $sqluserfrom = DB::select("SELECT PTW_USERS.NAME FROM PTW_USERS WHERE USER_ID = '" . $dbsql[0]->last_updated_by . "'");
            $sqluserto = DB::select("SELECT PTW_USERS.NAME FROM PTW_USERS WHERE USER_ID = '" . getDefaultData('/users')->user_id . "'");
        } else {
            $dbsql          = [];
            $sqluserfrom    = [];
            $sqluserto      = [];
        }

        $files = AttachFiles::where('header_id', $id)->where('program_code', 'OMP0015')->get();

        $datacompacts = ['meaning', 'received_quota', 'order_quantity', 
                        'last_approve_quantity', 'addtion', 'employs', 
                        'customer', 'emp_approve1', 'emp_approve2', 
                        'emp_approve3', 'emp_division', 'datainfo', 
                        'actings', 'nameemptitle', 'step', 'empmyseft', 
                        'lookupcodes', 'headers', 'approvers', 'line_id', 
                        'datacustomer', 'orders', 'empsale', 'emp1', 'emp2', 'emp3', 
                        'dataOwner', 'order_dates', 'sqluserfrom', 'sqluserto', 'dbsql', 
                        'order_approve', 'arraylastinfosumorder', 'order2last', 'datainfoss', 'files', 
                        'actingg', 'actingg1', 'actingg2', 'actingg3', 'pers', 'before_quantity', 
                        'total_approve_amount', 'last_datr', 'orderB'];

        if ($addtion->approve_status == 'ขออนุมัติ') {
            if ($step == 6) {
                $pdf = SnappyPdf::loadView('om.addition_quota/print', compact($datacompacts));
                $pdf->setPaper('a4')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setTimeout(300);

                return $pdf->inline();
            } else {
                $page = 'om.addition_quota.stepone';
            }
        } elseif ($addtion->approve_status == 'อนุมัติ' || $addtion->approve_status == 'ไม่อนุมัติ') {
            $page = 'om.addition_quota.print';

            $pdf = SnappyPdf::loadView('om.addition_quota/print', compact($datacompacts));
            $pdf->setPaper('a4')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setOption("enable-local-file-access", true)->setTimeout(300);

            return $pdf->inline();
        } else {
            if (in_array(getDefaultData('/users')->user_id, $emp_approve) || optional(auth()->user())->username == 'sysadmin') {
                $page = 'om.addition_quota.steptwo';
            } else {
                if ($step == 5) {
                    $page = 'om.addition_quota.steptwo';
                } elseif ($step == 6) {
                    $pdf = SnappyPdf::loadView('om.addition_quota/print', compact($datacompacts));
                    $pdf->setPaper('a4')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setTimeout(300);

                    return $pdf->inline();
                } else {
                    $page = 'om.addition_quota.stepone';
                }
            }
        }

        return view($page, compact($datacompacts));
    }

    public function onprint(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ], [
            'id.required' => 'เกิดข้อผิดพลาดระหว่างดำเนินการ',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => $validator->errors()->first()]);
        }

        $datamain = [
            'employee_sales_division'       => $request->sale,
            'employee_approve1'             => $request->emp1,
            'employee_approve2'             => $request->emp2,
            'employee_approve3'             => $request->emp3,
            'acting_position_sale'          => $request->sale_acting,
            'acting_position1'              => $request->emp1_acting,
            'acting_position2'              => $request->emp2_acting,
            'acting_position3'              => $request->emp3_acting,
            'last_updated_by'               => getDefaultData('/users')->user_id,
            'last_update_date'              => Carbon::now()->timezone('Asia/Bangkok'),
            'sales_division_additional'     => $request->sales_division_additional,
            'authority_id1_additional'      => $request->authority_id1_additional,
            'authority_id2_additional'      => $request->authority_id2_additional,
            'authority_id3_additional'      => $request->authority_id3_additional
        ];

        $saddition = AdditionQuota::find($request->id)->update($datamain);
        if (!$saddition) {
            return response()->json(['status' => 'error', 'msg' => 'กรุณาลองใหม่อีกครั้ง']);
        }

        return response()->json(['status' => 'success', 'msg' => '']);
    }

    public function upload(Request $request)
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
                $program_code = 'OMP0015';
                try {
                    $attachment = $this->uploadAttachmentSingle($file, null, $program_code);
                    $fileInfo = [
                        'attachment_id' => $attachment->attachment_id,
                        'file_name' => $file->getClientOriginalName(),
                        'path_name' => getDefaultData('/users')->archive_directory,
                        'program_code' => $program_code
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
                    $responseUploadFile['message'] = 'เกิดข้อผิดพลาดระหว่างการอัปโหลดไฟล์ ' . $file->getClientOriginalName();
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

    public function stepupdate(Request $request)
    {
        // dd($request->all());
        $addtion = AdditionQuota::find($request->addition_id);

        if (empty($addtion)) {
            return redirect()->back()->withErrors('ข้อมูลใบขอเพิ่มเพดานไม่ถูกต้อง')->withInput($request->all());
        }
        $addtion_line = AdditionQuotaLines::where('quota_header_id', '=', $request->addition_id)->get();
        if (empty($addtion_line)) {
            return redirect()->back()->withErrors('ข้อมูลใบขอเพิ่มเพดานไม่ถูกต้อง')->withInput($request->all());
        }

        // เพิ่มเช็ค status ตอนส่งคำขอนุวัติ กรณีมีการกดใบเดียวกัน W.14/02/23
        if ($request->status_approve == $addtion->approve_status) {
            return redirect()->route('om.addition-index')->with('error', 'มีการทำการขออนุมัติใบนี้แล้ว');
        }

        if ($addtion->approve_status == 'ขออนุมัติ') {
            $validator = Validator::make($request->all(), [
                'addition_id'   => 'required',
                'emp3'          => 'required',
            ], [
                'addition_id.required'  => 'เกิดข้อผิดพลาดไม่พบข้อมูลขอเพิ่มเพดาน',
                'emp3.required'         => 'กรุณาเลือกผู้อนุมัติลำดับที่ 3'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first())->withInput($request->all());
            }

            // update header_id file_upload
            if (request()->files_uploadsId && request()->files_uploadsId != '') {
                $attachmentIDs = explode(",", request()->files_uploadsId);
                foreach ($attachmentIDs as $value) {
                    $AttachFile = AttachFiles::where('attachment_id', $value)->first();
                    if ($AttachFile) {
                        $AttachFile->header_id = $request->addition_id;
                        $AttachFile->save();
                    }
                }
            }
            // update header_id file_upload
            foreach ($request->line_id as $key => $line) {
                $data = [
                    'last_total_quantity' => str_replace(',', '', $request->before_quantity[$key]),
                    'approve_quantity' => str_replace(',', '', $request->approve_number[$key])
                ];
                AdditionQuotaLines::find($line)->update($data);
            }

            if ($request->status_approve == 'ไม่อนุมัติ') {
                $datamain = [
                    'employee_sales_division'       => $request->division,
                    'employee_approve1'             => $request->emp1,
                    'employee_approve2'             => $request->emp2,
                    'employee_approve3'             => $request->emp3,
                    'approve_status'                => $request->status_approve,
                    'approve_date'                  => Carbon::now()->timezone('Asia/Bangkok'),
                    'acting_position_sale'          => $request->acting,
                    'acting_position1'              => $request->acting1,
                    'acting_position2'              => $request->acting2,
                    'acting_position3'              => $request->acting3,
                    'last_updated_by'               => getDefaultData('/users')->user_id,
                    'last_update_date'              => Carbon::now()->timezone('Asia/Bangkok'),
                    'sales_division_additional'     => $request->sales_division_additional,
                    'authority_id1_additional'      => $request->authority_id1_additional,
                    'authority_id2_additional'      => $request->authority_id2_additional,
                    'authority_id3_additional'      => $request->authority_id3_additional
                ];
            } else {
                $datamain = [
                    'employee_sales_division'       => $request->division,
                    'employee_approve1'             => $request->emp1,
                    'employee_approve2'             => $request->emp2,
                    'employee_approve3'             => $request->emp3,
                    'approve_status'                => $request->status_approve,
                    'acting_position_sale'          => $request->acting,
                    'acting_position1'              => $request->acting1,
                    'acting_position2'              => $request->acting2,
                    'acting_position3'              => $request->acting3,
                    'last_updated_by'               => getDefaultData('/users')->user_id,
                    'last_update_date'              => Carbon::now()->timezone('Asia/Bangkok'),
                    'sales_division_additional'     => $request->sales_division_additional,
                    'authority_id1_additional'      => $request->authority_id1_additional,
                    'authority_id2_additional'      => $request->authority_id2_additional,
                    'authority_id3_additional'      => $request->authority_id3_additional
                ];
            }
            $addtion->update($datamain);

            if (env('APP_ENV') == 'production') {
                $this->sendmailtoapprover($request->addition_id, $request->step);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'approve_quantity.*'        => 'required',
                'lookupcodes_hidden.*'      => 'required',
                'order_quantity_hidden.*'   => 'required',
                'addition_id'               => 'required',
            ], [
                'approve_quantity.*.required'       => 'ข้อมูลการอนุมัติไม่ถูกต้อง :1',
                'lookupcodes_hidden.*.required'     => 'ข้อมูลการอนุมัติไม่ถูกต้อง :2',
                'order_quantity_hidden.*.required'  => 'ข้อมูลการอนุมัติไม่ถูกต้อง :3',
                'addition_id.required'              => 'ข้อมูลการอนุมัติไม่ถูกต้อง :4',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first())->withInput($request->all());
            }
            if (request()->approve_quantity && request()->approve_quantity != '') {
                foreach ($request->approve_quantity as $key => $value) {
                    $order_quantity_hidden = str_replace(',', '', $request->order_quantity_hidden[$key]);
                    if (str_replace(',', '', $value) > $order_quantity_hidden) {
                        return redirect()->back()->withErrors('จำนวนอนุมัติต้องไม่มากกว่ายอดที่ขอเพิ่ม');
                    }
                }
            }

            if ($request->status_approve == 'อนุมัติ') {
                foreach ($addtion_line as $key => $line) {
                    $headers_hidden = $request->line_id[$key];
                    $lookupcodes_hidden = $request->lookupcodes_hidden[$key];
                    $data = [
                        'approve_quantity' => str_replace(',', '', $request->approve_quantity[$key]),
                    ];
                    AdditionQuotaLines::where('quota_line_id', $headers_hidden)->where('quota_group_id', $lookupcodes_hidden)->update($data);
                }

                if ($request->step == 3) {
                    $orderlines = OrderLines::where('order_header_id', $addtion->order_header_id)->get();
                    foreach ($orderlines as $orderline) {
                        $roderupdate = [
                            'approve_quantity' => $orderline->order_quantity
                        ];
                        OrderLines::find($orderline->order_line_id)->update($roderupdate);
                    }
                }
            } else {
                $approve_new = [
                    'order_status' => 'Draft'
                ];
                OrderHeader::where('order_header_id', $addtion->order_header_id)->update($approve_new);
            }

            $status_app = $request->status_approve == 'อนุมัติ' ? 'A' : 'U';
            if ($request->step == 4) {
                $datamain = [
                    'approve_date'                  => Carbon::now()->format('Y-m-d H:i:s'),
                    'status_empolyee_approve4'      => $status_app,
                    'comment_sales'                 => $request->approvecomment,
                    'attribute1'                    => Carbon::now()->format('Y-m-d H:i:s'),
                    'last_updated_by'               => getDefaultData('/users')->user_id,
                    'last_update_date'              => Carbon::now()->timezone('Asia/Bangkok')
                ];
            } elseif ($request->step == 1) {
                $datamain = [
                    'approve_date'                  => Carbon::now()->format('Y-m-d H:i:s'),
                    'status_empolyee_approve1'      => $status_app,
                    'comment_employee1'             => $request->approvecomment,
                    'attribute2'                    => Carbon::now()->format('Y-m-d H:i:s'),
                    'last_updated_by'               => getDefaultData('/users')->user_id,
                    'last_update_date'              => Carbon::now()->timezone('Asia/Bangkok')
                ];
            } elseif ($request->step == 2) {
                $datamain = [
                    'approve_date'              => Carbon::now()->format('Y-m-d H:i:s'),
                    'status_empolyee_approve2'  => $status_app,
                    'comment_employee2'         => $request->approvecomment,
                    'attribute3'                => Carbon::now()->format('Y-m-d H:i:s'),
                    'last_updated_by'           => getDefaultData('/users')->user_id,
                    'last_update_date'          => Carbon::now()->timezone('Asia/Bangkok')
                ];
            } else {
                $datamain = [
                    'approve_date'              => Carbon::now()->format('Y-m-d H:i:s'),
                    'status_empolyee_approve3'  => $status_app,
                    'comment_employee3'         => $request->approvecomment,
                    'approve_status'            => $request->status_approve,
                    'attribute4'                => Carbon::now()->format('Y-m-d H:i:s'),
                    'last_updated_by'           => getDefaultData('/users')->user_id,
                    'last_update_date'          => Carbon::now()->timezone('Asia/Bangkok')
                ];
            }

            $addtion->update($datamain);

            if ($status_app == 'U') {
                AdditionQuota::find($request->addition_id)->update(['approve_status' => 'ไม่อนุมัติ']);
            }

            if ($request->step == 3 && $request->status_approve == 'อนุมัติ') {
                $statusorder = true;

                if ($statusorder) {
                    //gen prepare_order_number and update order header
                    $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_CG_DOM', 'prepare_order_number');
                    $approve_new = [
                        'prepare_order_number' => $prepareNumber,
                        'order_status' => 'Draft'
                    ];
                    OrderHeader::where('order_header_id', $addtion->order_header_id)->update($approve_new);

                    //update order lines
                    $linesorder = OrderLines::where('order_header_id', $addtion->order_header_id)->get();
                    foreach ($linesorder as $key => $line) {
                        OrderLines::find($line->order_line_id)->update(['approve_quantity' => $line->order_quantity]);
                    }

                    $orderHH = OrderHeader::where('order_header_id', $addtion->order_header_id)->first();
                    $rd = Carbon::parse($orderHH->order_date)->format('Y-m-d');
                    $orderLinesForupdate1 = OrderLines::where('order_header_id', $addtion->order_header_id)->get();
                    foreach ($orderLinesForupdate1 as $olf) {
                        //update remaining quota PTOM_CUSTOMER_QUOTA_LINES
                        $CustomerQuotaH = CustomerQuotaHeaders::where('customer_id', $orderHH->customer_id)->whereRaw("START_DATE <= DATE '" . $rd . "'")->whereRaw("END_DATE >= DATE '" . $rd . "'")->get();
                        if (!empty($CustomerQuotaH)) {
                            foreach ($CustomerQuotaH as $ch) {
                                $CustomerQuotaLine = CustomerQuotaLineModel::where('quota_header_id', $ch->quota_header_id)->where('item_id', $olf->item_id)->where('item_code', $olf->item_code)->first();
                                if (!empty($CustomerQuotaLine)) {
                                    if ($CustomerQuotaLine->remaining_quota != 0) {
                                        $CustomerQuotaLine->remaining_quota = $CustomerQuotaLine->remaining_quota - $olf->order_quantity;
                                        $CustomerQuotaLine->save();
                                    }
                                }
                            }
                        }

                        //update remaining amount PTOM_CUSTOMER_CONTRACT_GROUP
                        $CustomerContractGroup = CustomerContractGroupModel::whereNull('deleted_at')->where('customer_id', $addtion->customer_id)->where('credit_group_code', $olf->credit_group_code)->first();
                        if (!empty($CustomerContractGroup)) {
                            if ($CustomerContractGroup->remaining_amount != 0) {
                                $remaining_amount = $CustomerContractGroup->remaining_amount - $olf->amount;
                                $CustomerContractGroups = CustomerContractGroupModel::find($CustomerContractGroup->contract_group_id);
                                $CustomerContractGroups->remaining_amount = (($remaining_amount < 0) ? 0 : $remaining_amount);
                                $CustomerContractGroups->save();
                            }
                        }
                    }

                    //create record PTOM_ORDER_HISTORY
                    $ptomorderhistory = OrderHeaders::where('order_header_id', $addtion->order_header_id)->first();
                    if (!empty($ptomorderhistory)) {
                        OrderRepo::insertOrdersHistoryv2($ptomorderhistory, 'Release');
                    }
                }
            }
        }

        return redirect()->route('om.addition-index')->with('success', 'บันทึกเรียบร้อยแล้ว');
    }

    public function download($id)
    {
        $attachment = AttachFiles::find($id);

        $path = public_path() . '//' . $attachment->path_name;

        if (file_exists($path)) {
            return response()->download($path);
        }
    }

    public function getDetailSalesDivision(Request $request)
    {
        $data = AdditionQuotaHeader::find($request['quota_header_id']);
        $salesDivisionAdditional = OverQuotaApproval::where('sales_division_id', $request['user_id'])
                                                    ->whereNotNull('sales_division_additional')
                                                    ->value('sales_division_additional');
                
        if($salesDivisionAdditional){
            return response()->json(['data' => $salesDivisionAdditional]);
        }else{
            $salesDivisionAdditional = PTOM_AUTHORITY_LISTS::where('authority_id', $request['user_id'])
                                                            ->value('position_name');
            return response()->json(['data' => $salesDivisionAdditional]);
        }         
    }

    public function getDetailAuthorityId1(Request $request)
    {
        $data = AdditionQuotaHeader::find($request['quota_header_id']);
        $authorityId1Additional = OverQuotaApproval::where('authority_id1_additional', $request['user_id'])
                                                    ->whereNotNull('authority_id1_additional')
                                                    ->value('authority_id1_additional');
                
        if($authorityId1Additional){
            return response()->json(['data' => $authorityId1Additional]);
        }else{
            $authorityId1Additional = PTOM_AUTHORITY_LISTS::where('authority_id', $request['user_id'])
                                                            ->value('position_name');
            return response()->json(['data' => $authorityId1Additional]);
        }         
    }

    public function getDetailAuthorityId2(Request $request)
    {
        $data = AdditionQuotaHeader::find($request['quota_header_id']);
        $authorityId2Additional = OverQuotaApproval::where('authority_id2_additional', $request['user_id'])
                                                    ->whereNotNull('authority_id2_additional')
                                                    ->value('authority_id2_additional');
                
        if($authorityId2Additional){
            return response()->json(['data' => $authorityId2Additional]);
        }else{
            $authorityId2Additional = PTOM_AUTHORITY_LISTS::where('authority_id', $request['user_id'])
                                                            ->value('position_name');
            return response()->json(['data' => $authorityId2Additional]);
        }         
    }

    public function getDetailAuthorityId3(Request $request)
    {
        $data = AdditionQuotaHeader::find($request['quota_header_id']);
        $authorityId3Additional = OverQuotaApproval::where('authority_id3_additional', $request['user_id'])
                                                    ->whereNotNull('authority_id3_additional')
                                                    ->value('authority_id3_additional');
                
        if($authorityId3Additional){
            return response()->json(['data' => $authorityId3Additional]);
        }else{
            $authorityId3Additional = PTOM_AUTHORITY_LISTS::where('authority_id', $request['user_id'])
                                                            ->value('position_name');
            return response()->json(['data' => $authorityId3Additional]);
        }         
    }
}
