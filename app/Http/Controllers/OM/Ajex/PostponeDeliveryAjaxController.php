<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\PostponeOrders;
use App\Models\OM\PeriodV;
use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\PrepareSaleOrder\OperationUnitsModel;
use Illuminate\Support\Facades\DB;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;

class PostponeDeliveryAjaxController extends Controller
{

    public function store(Request $request)
    {
        $resp       = [];
        $error      = false;
        $response   = [];
        foreach ($request->all()[0]['postpone'] as $key => $v) {
            $customer = DB::table('ptom_customers')
                            ->select('customer_id')
                            ->where('customer_number',$v['customer_number'])
                            ->orderBy('customer_id','desc')
                            ->first();

            $from_date  = date('Y-m-d',strtotime(parseFromDateTh($v['from_date'])));
            $to_date    = date('Y-m-d',strtotime(parseFromDateTh($v['to_date'])));

            if($from_date == '1970-01-01') {
                $from_date = Carbon::parse($v['from_date'])->timezone('Asia/Bangkok')->addYears('-543')->format('Y-m-d');
            }
            if($v['postpone_order_id'] == 0){
                $checkDataDuplicate = PostponeOrders::where('customer_id', $customer->customer_id)
                                                    ->where('from_period_date', $from_date)
                                                    ->where('to_period_date', $to_date)
                                                    ->whereNull('deleted_at')
                                                    ->get();

                if(count($checkDataDuplicate) != 0){
                    $error = true;
                    return response()->json(['data'=>[],'status'=>true,'error'=>$error]);
                }
            }

            $resp['from_date'][]    = $from_date;
            $resp['to_date'][]      = $to_date;

            $from_period_id = DB::table('ptom_period_v')
                                ->select('period_line_id')
                                ->whereDate('start_period','<=',$from_date)
                                ->whereDate('end_period','>=',$from_date)
                                ->orderBy('period_id','asc')
                                ->first();     
            $resp[] = isset($from_period_id->period_line_id) ? $from_period_id->period_line_id : '';

            $to_period_id = DB::table('ptom_period_v')
                                ->select('period_line_id')
                                ->whereDate('start_period','<=',$to_date)
                                ->whereDate('end_period','>=',$to_date)
                                ->orderBy('period_id','asc')
                                ->first();
            $resp[] = isset($to_period_id->period_line_id) ? $to_period_id->period_line_id : '';

            $orgId = OperationUnitsModel::select('ORGANIZATION_ID')
                                ->where('SHORT_CODE', 'TOAT')
                                ->value('organization_id');

            if(!$from_period_id || !$to_period_id){
                $error = true;
            }else{
                if($v['postpone_order_id'] != 0){
                    $postpone = PostponeOrders::where('postpone_order_id',$v['postpone_order_id'])
                                                ->where('approve_status','อนุมัติ')
                                                ->first();
                }else{
                    $postpone = new PostponeOrders();
                    $postpone->order_quantity   = '0';
                    $postpone->uom              = '';
                    $postpone->reason           = '';
                }

                $postpone->org_id               = $orgId;
                $postpone->org_name             = '';
                $postpone->customer_id          = $customer->customer_id;
                $postpone->from_period_id       = $from_period_id->period_line_id;
                $postpone->to_period_id         = $to_period_id->period_line_id;
                $postpone->from_period_date     = $from_date;
                $postpone->to_period_date       = $to_date;
                $postpone->approve_status       = 'อนุมัติ';
                $postpone->created_by           = optional(auth()->user())->user_id ?? -1;
                $postpone->last_updated_by      = optional(auth()->user())->user_id ?? -1;
                $postpone->program_code         = 'OMP0009';
                $postpone->save();

                $response['postpone_order_id'][$key] = $postpone->getKey();
            }

        }

        return response()->json(['data'=>$response,'status'=>true,'error'=>$error]);
    }

    public function periodByBudgetYear($year)
    {
        $period = PeriodV::where('budget_year',$year)->get();

        return response()->json(['data'=>$period,'status'=>true,'message'=>'']);
    }

    public function dateByNo($customer_number,$period_no)
    {
        $period = PeriodV::where('period_line_id',$period_no)->first();

        $customer = Customers::where('customer_number',$customer_number)->whereRaw("lower(sales_classification_code) = 'domestic'")->whereRaw("lower(status) = 'active'")->first('delivery_date');

        $days = compareDaysTH($customer->delivery_date);

        $periodDate = new DatePeriod(
            new DateTime($period->start_period),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime('+1 day', strtotime($period->end_period))))
        );

        $response = '';

        foreach ($periodDate as $key => $value) {
            $dayofweek = date('w', strtotime($value->format('Y-m-d')));
            if($days == $dayofweek){
                $response = dateFormatThai($value->format('Y-m-d'));
            }
        }

        return response()->json(['data'=>$response,'status'=>true,'message'=>'']);
    }

    public function nextDate($customer_number)
    {
        $customer = DB::table('ptom_customers')->select('delivery_date')->where('customer_number',$customer_number)->first();
        $fromDate = nextDaysOfWeek(compareDaysTH($customer->delivery_date));
        return response()->json(['data'=>$fromDate]);
    }

    public function search(Request $request)
    {
        $response = [];

        $postpone = DB::table('ptom_postpone_orders as po')
        ->select('po.postpone_order_id','po.from_period_id','po.from_period_id','po.from_period_date','po.to_period_date','c.customer_number','c.customer_name','po.from_period_date as from_date','po.to_period_date as to_date','pvt.budget_year','pvf.period_no')
        ->join('ptom_customers as c', 'c.customer_id', '=', 'po.customer_id')
        ->join('ptom_period_v as pvf', 'pvf.period_line_id', '=', 'po.from_period_id')
        ->join('ptom_period_v as pvt', 'pvt.period_line_id', '=', 'po.to_period_id')
        ->where('po.approve_status','อนุมัติ')
        ->where(function($query) use ($request) {
            if($request->customer_number && $request->customer_number != ''){
                $query->where('c.customer_number', $request->customer_number);
            }

            if($request->date){
                $query->where('po.from_period_date', date('Y-m-d',strtotime(dateConvertThaiEng($request->date))));
            }

            if($request->installment && $request->installment != '' && $request->installment != 'all'){
                $query->where('po.from_period_id', $request->installment);
            }

            if($request->year && $request->year != '' && $request->year != 'all'){
                $query->where('pvf.budget_year', $request->year);
            }
            $query->whereNull('po.deleted_at');
        })
        ->orderBy('po.creation_date','DESC')
        ->get();

        $budgetYear = PeriodV::groupBy('budget_year')->get('budget_year');

        foreach($postpone as $val){
            $response[] = [
                'postpone_order_id' => $val->postpone_order_id,
                'customer_number'   => $val->customer_number,
                'customer_name'     => $val->customer_name,
                'year'              => $val->budget_year,
                'installment'       => $val->from_period_id,
                'from_date'         => dateFormatThai($val->from_period_date),
                'to_date'           => dateFormatThai($val->to_period_date),
                'budgetYear'        => $budgetYear,
                'period'            => PeriodV::where('budget_year',$val->budget_year)->get(),
                'fix'               => (date('Y-m-d', strtotime($val->to_period_date)) < date('Y-m-d')) ? false : true,
                'old'               => true,
                'selected'          => 0,
            ];
        }

        return response()->json(['data'=>$response]);
    }

    public function years()
    {
        $period = DB::table('ptom_period_v')->distinct()->orderBy('budget_year','asc')->get(['budget_year']);
        return response()->json(['data'=>$period]);
    }

    public function installments($year)
    {
        $period = DB::table('ptom_period_v')->where('budget_year',$year)->get();
        return response()->json(['data'=>$period]);
    }

    public function remove(Request $request)
    {
        try {
            if(isset($request->all()[0]['postpone'])){
                foreach ($request->all()[0]['postpone'] as $key => $v) {
                    if($v['selected'] != 0){
                        $postpone = PostponeOrders::where('postpone_order_id',$v['postpone_order_id'])->first();
                        $postpone->deleted_by_id = optional(auth()->user())->user_id ?? -1;
                        $postpone->deleted_at = now();
                        $postpone->save();
                    }
                }
            }else{
                foreach ($request->all() as $key => $v) {
                    if($v['selected'] != 0){
                        $postpone = PostponeOrders::where('postpone_order_id',$v['postpone_order_id'])->first();
                        $postpone->deleted_by_id = optional(auth()->user())->user_id ?? -1;
                        $postpone->deleted_at = now();
                        $postpone->save();
                    }
                }
            }            
        } catch (\Throwable $th) {
            //throw $th;
        }

        return response()->json(['data'=>[],'status'=>true]);
    }

    public function getCustomers(Request $request, $date)
    {
        $customers = Customers::where('delivery_date', $date)->get();
        $nowDate = date('m-d-Y', strtotime(Carbon::now()));
        $defaultPeriod = collect(\DB::select("
                            SELECT  *
                            FROM    PTOM_PERIOD_V
                            WHERE   1=1
                            AND start_period <= TO_DATE('{$nowDate}', 'MM/DD/YYYY')
                            AND end_period >= TO_DATE('{$nowDate}', 'MM/DD/YYYY')
                        "));

        return response()->json(['data' => $customers]);
    }

    public function getPeriodPostPone(Request $request, $year)
    {
        $periods = PeriodV::where('budget_year', $year)->get();
        $nowDate = date('m-d-Y', strtotime(Carbon::now()));
        $defaultPeriod = collect(\DB::select("
                            SELECT  *
                            FROM    PTOM_PERIOD_V
                            WHERE   1=1
                            AND budget_year = '{$year}'
                            AND start_period <= TO_DATE('{$nowDate}', 'MM/DD/YYYY')
                            AND end_period >= TO_DATE('{$nowDate}', 'MM/DD/YYYY')
                        "));
        $days = compareDaysTH($request['days']);
        $periodDate = new DatePeriod(
            new DateTime($defaultPeriod[0]->start_period),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime('+1 day', strtotime($defaultPeriod[0]->end_period))))
        );
        foreach ($periodDate as $key => $value) {
            $dayofweek = date('w', strtotime($value->format('Y-m-d')));
            if($days == $dayofweek){
                $response = dateFormatThai($value->format('Y-m-d'));
                $datePeriod = $value->format('Y-m-d');
            }
        }

        $customersPostpone = PostponeOrders::where('from_period_id', $defaultPeriod[0]->period_line_id)
                                            // ->where('to_period_id', $defaultPeriod[0]->period_line_id)
                                            ->where('approve_status', 'อนุมัติ')
                                            ->whereNull('deleted_at')
                                            ->whereRaw("from_period_date = TO_DATE('$datePeriod','YYYY-MM-DD')")
                                            ->get();
                        
        $customersPostpone->map(function ($item, int $key) {
            $customers = Customers::where('customer_id', $item['customer_id'])->first();
            $item->customer_number = $customers['customer_number'];
            $item->customer_name = $customers['customer_name'];
            $item->to_period_date = dateFormatThai($item->to_period_date);
        });
                        
        return response()->json([   'data'  => $periods, 
                                    'data2' => $defaultPeriod,
                                    'data3' => $response,
                                    'data4' => $customersPostpone]);
    }

    public function getDateByPeriodPostPone(Request $request)
    {
        $date       = date('m/d/Y', strtotime( parseFromDateTh($request['days']) ));
        $timestamp  = strtotime($date);
        $result     = getdate($timestamp);
        $dayThai    = ENcompareDaysTH($result['weekday']);      
        $daysArr    = explode("/",$date);
        $year       = $daysArr[2];
        $days       = compareDaysTH($dayThai);
        $period     = collect(\DB::select("
                                SELECT  *
                                FROM    PTOM_PERIOD_V
                                WHERE   1=1
                                AND budget_year = '{$year}'
                                AND start_period <= TO_DATE('{$date}', 'MM/DD/YYYY')
                                AND end_period >= TO_DATE('{$date}', 'MM/DD/YYYY')
                            "));
        $customers  = Customers::where('delivery_date', $dayThai)->get();


        $periodDate = new DatePeriod(
            new DateTime($period[0]->start_period),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime('+1 day', strtotime($period[0]->end_period))))
        );
        foreach ($periodDate as $key => $value) {
            $dayofweek = date('w', strtotime($value->format('Y-m-d')));
            if($days == $dayofweek){
                $response = dateFormatThai($value->format('Y-m-d'));
                $datePeriod = $value->format('Y-m-d');
            }
        }

        $customersPostpone = PostponeOrders::where('from_period_id', $period[0]->period_line_id)
                                            // ->where('to_period_id', $period[0]->period_line_id)
                                            ->where('approve_status', 'อนุมัติ')
                                            ->whereNull('deleted_at')
                                            ->whereRaw("from_period_date = TO_DATE('$datePeriod','YYYY-MM-DD')")
                                            ->get();

        $customersPostpone->map(function ($item, int $key) {
            $customers              = Customers::where('customer_id', $item['customer_id'])->first();
            $item->customer_number  = $customers['customer_number'];
            $item->customer_name    = $customers['customer_name'];
            $item->to_period_date   = dateFormatThai($item->to_period_date);
        });

        return response()->json([   'data'  => $period, 
                                    'data2' => $dayThai,
                                    'data3' => $customers,
                                    'data4' => $customersPostpone]);
    }

    public function getPeriodPostPoneByDate(Request $request)
    {
        $date = PeriodV::where('period_line_id', $request['period'])->first();
        $days = compareDaysTH($request['days']);        
        $periodDate = new DatePeriod(
            new DateTime($date['start_period']),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime($date['end_period'])))
        );
        foreach ($periodDate as $key => $value) {
            $dayofweek = date('w', strtotime($value->format('Y-m-d')));
            if($days == $dayofweek){
                $response = dateFormatThai($value->format('Y-m-d'));
                $datePeriod = $value->format('Y-m-d');
            }
        }

        $customersPostpone = PostponeOrders::where('from_period_id', $date->period_line_id)
                                            // ->where('to_period_id', $date->period_line_id)
                                            ->where('approve_status', 'อนุมัติ')
                                            ->whereNull('deleted_at')
                                            ->whereRaw("from_period_date = TO_DATE('$datePeriod','YYYY-MM-DD')")
                                            ->get();
                        
        $customersPostpone->map(function ($item, int $key) {
            $customers              = Customers::where('customer_id', $item['customer_id'])->first();
            $item->customer_number  = $customers['customer_number'];
            $item->customer_name    = $customers['customer_name'];
            $item->to_period_date   = dateFormatThai($item->to_period_date);
        });

        return response()->json(['data' => $response, 'data2' => $customersPostpone]);
    }
}