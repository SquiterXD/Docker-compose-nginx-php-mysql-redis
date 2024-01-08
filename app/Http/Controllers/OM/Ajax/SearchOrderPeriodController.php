<?php

namespace App\Http\Controllers\OM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\OrderPeriodHeaders;

class SearchOrderPeriodController extends Controller
{
    public function index()
    {
        // dd(request()->all());

        // $header = OrderPeriodHeaders::where('budget_year', request()->budget_year - 543)->first();

        $header = OrderPeriodHeaders::where('budget_year', request()->budget_year)->first();

        if ($header) {
            $orderPeriod   = $header->orderPeriodLines;

            $html = view('om.settings.order-period._table', compact('header'))->render();
            $data = [
                'html'        => $html,
                'orderPeriod' => $orderPeriod
            ];
            return response()->json($data);

        } else {

            // $header = '';

            $html = view('om.settings.order-period._table', compact('header'))->render();

            $orderPeriod = [];

            $data = [
                'html'        => $html,
                'orderPeriod' => $orderPeriod,
            ];

            return response()->json($data);
        }
        

        

        // dd(request()->all(), $data, $data->orderPeriodLines);

        // $data = PoVendorsV::when($text, function ($query, $text) {
        //             return $query->where(function($r) use ($text) {
        //                 $r->where('vendor_code', 'like', "%${text}%")
        //                     ->orWhere('vendor_name', 'like', "${text}%");
        //             });
        //         })
        //         ->limit(30)
        //         ->get();

        
    }

    public function getHoliday($dateInput)
    {
        $date = date('Y-m-d', strtotime($dateInput));

        // dd($test); 
        $db     =   \DB::connection('oracle')->getPdo();
        $sql = "
                    DECLARE
                        v_flag   varchar2(1000) := NULL;
                    BEGIN
                        :v_flag  := PTPP_UTILITIES_PKG.GET_WEEKEND_FLAG('{$date}');
                    
                    END;
                ";

        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':v_flag', $result['v_flag'], \PDO::PARAM_STR, 1000);
        $stmt->execute();
        \Log::info($result);

        return $result['v_flag'];
    }

    public function getOrder()
    {
        
        $year     = request()->budget_year - 543;

        $old = OrderPeriodHeaders::where('budget_year', $year)->first();

        // dd($old);

        if ($old) {
            return response()->json(['message' => 'ปีงบประมาณนี้มีอยู่แล้ว']);
        }

        $lastYear = $year - 1;

        $startDate = $lastYear . '-09-30';
        $endDate   = $year . '-09-30';
        
        
        $countDate = 366;
        $xxx = 1;
        // $i = $startDate;
        
        $list = [];
        $listStart = [];

        $j = 1;

        for ($i=1; $i <= $countDate; $i++) { 

            $addDate  = $i . " days";
            $dateTest = date_create($startDate);

            date_add($dateTest, date_interval_create_from_date_string($addDate));

            $test = date_format($dateTest, "Y-m-d");


            // dd(date('Y-m-d', strtotime($test)), date('Y-m-d', strtotime($endDate)));

            

            // dd($this->getHoliday(date_format($dateTest, "Y-m-d")));

            // dd(date('l', strtotime('2020-10-2')));

            if (date('Y-m-d', strtotime($test)) <= date('Y-m-d', strtotime($endDate))) {
                
                if (date('l', strtotime($test)) == 'Friday') {
                    if ($listStart) {
                        $xtest = ['period_no' => $j, 'start_period' => parseToDateTh($listStart[0]), 'end_period' => parseToDateTh($test)];

                        array_push($list, $xtest);

                        $listStart = [];
                        $j += 1;

                        continue;
                    } else {
                        $xtest = ['period_no' => $j, 'start_period' => parseToDateTh($test), 'end_period' => parseToDateTh($test)];
                    // $xxtest = ['end_period' => $test];

                        array_push($list, $xtest);

                        $listStart = [];
                        $j += 1;

                        continue;
                    }

                    // dd($listStart[0]);
                    
                } 
                else {
                    if (!$this->getHoliday(date_format($dateTest, "Y-m-d"))) {
                        array_push($listStart, $test);
                    }
                    
                    if (date('Y-m-d', strtotime($test)) == date('Y-m-d', strtotime($endDate)) && !$this->getHoliday(date_format($dateTest, "Y-m-d"))) {
                        $xtest = ['period_no' => $j, 'start_period' => parseToDateTh($listStart[0]), 'end_period' => parseToDateTh($test)];

                        array_push($list, $xtest);

                        $listStart = [];
                        $j += 1;
                    }

                    // $xtest = ['period_no' => $i, 'start_period' => $test]
                    // $xtest = ['start_period' => $test];
                    // $listStart['start_period'] = $test;
                    
                }
            }

            // if ($this->getHoliday(date_format($dateTest, "Y-m-d"))) {
            //     $xxtest = ['end_period' => $test];

            //     array_push($list, $xxtest);

            //     continue;
            // }

            // $data['period_no']   = $i;
            // $data['start_period'] = $test;


            // $checkDate = $this->getHoliday(date_format($dateTest, "Y-m-d"));


        }

        // dd($list);

        $data = $list;

        // for ($test <= $endDate) { 
        //     $xxx += 1; 
        //     $test2 = date_format($test, "Y-m-d");

        // }

        // dd($xxx, $addDate, $test, $list);


        // dd('xxxx', $this->getHoliday(date_format($dateTest, "Y-m-d")));
        // $this->getHoliday();

        return response()->json($data);
    }
}
