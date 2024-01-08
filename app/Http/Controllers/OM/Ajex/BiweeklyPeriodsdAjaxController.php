<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Models\OM\BiweeklyPeriods;

use App\Http\Controllers\Controller;
use App\Models\OM\Holiday;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BiweeklyPeriodsdAjaxController extends Controller
{
    public function updateBiweeklyPeriods(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $validate = Validator::make($request->all(),[
            'budget_year'       => 'required|string',
            'start_buget_year'  => 'required|string',
            'biweekly_no'       => 'required:array',
            'start_date_period' => 'required|array',
            'end_date_period'   => 'required|array'
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            if(!empty($request->biweekly_no)){

                // BiweeklyPeriods::where('budget_year', $request->budget_year)->delete();

                $budgetYear = $request->budget_year - 543;

                // วันที่เริ่มต้นงบประมาณ
                if(!empty($request->start_buget_year)){
                    $replaceBuget = str_replace('/', '-', $request->start_buget_year);
                    $startBudget = strtotime($replaceBuget);

                    $calBudget = date('Y/m/d',$startBudget);
                    $arrBudget = explode('/', $calBudget);
                    $changeYear = $arrBudget[0] - 543;
                    $startBudgetYear = $changeYear.'/'.$arrBudget[1].'/'.$arrBudget[2];
                }else{
                    $startBudgetYear = '';
                }

                foreach ($request->biweekly_no as $key => $value) {

                    // วันที่เริ่มใช้
                    if(!empty($request->start_date_period[$key])){
                        $replaceStart = str_replace('/', '-', $request->start_date_period[$key]);
                        $startPeriod = strtotime($replaceStart);

                        $calStart = date('Y/m/d',$startPeriod);
                        $arrStart = explode('/', $calStart);
                        $changeStart = $arrStart[0] - 543;
                        $startDate = $changeStart.'/'.$arrStart[1].'/'.$arrStart[2];
                    }else{
                        $startDate = '';
                    }

                    // ถึงวันที่
                    if(!empty($request->end_date_period[$key])){
                        $replaceEnd = str_replace('/', '-', $request->end_date_period[$key]);
                        $endPeriod = strtotime($replaceEnd);

                        $calEnd = date('Y/m/d',$endPeriod);
                        $arrEnd = explode('/', $calEnd);
                        $changeEnd = $arrEnd[0] - 543;
                        $endDate = $changeEnd.'/'.$arrEnd[1].'/'.$arrEnd[2];
                    }else{
                        $endDate = '';
                    }

                    // echo '<pre>';
                    // print_r($update);
                    // echo '<pre>';
                    // exit();

                    $getData = BiweeklyPeriods::where('budget_year', $budgetYear)->where('biweekly_no', $value)->get();

                    if (!$getData->isEmpty()) {
                        $update = [
                            'start_buget_year'      => $startBudgetYear,
                            'start_date_period'     => $startDate,
                            'end_date_period'       => $endDate,
                            'day_for_sale'          => $request->day_for_sale[$key],
                            'program_code'          => 'OMP0054',
                            'last_updated_by'       => optional(auth()->user())->user_id,
                            'last_update_date'      => date('Y-m-d H:i:s'),
                        ];

                        BiweeklyPeriods::where('budget_year', $budgetYear)->where('biweekly_no', $value)->update($update);
                    }else{

                        $org = DB::table('ptom_operating_units_v')->where('short_code','TOAT')->first();
                        if($org){
                            $org_id = $org->organization_id;
                        }else{
                            $org_id = 121;
                        }

                        $update = [
                            'org_id'                => $org_id,
                            'budget_year'           => $budgetYear,
                            'start_buget_year'      => $startBudgetYear,
                            'biweekly_no'           => $value,
                            'start_date_period'     => $startDate,
                            'end_date_period'       => $endDate,
                            'day_for_sale'          => $request->day_for_sale[$key],
                            'program_code'          => 'OMP0054',
                            'created_by'            => optional(auth()->user())->user_id,
                            'creation_date'          => date('Y-m-d H:i:s'),
                            'last_updated_by'       => optional(auth()->user())->user_id,
                            'last_update_date'      => date('Y-m-d H:i:s'),
                        ];

                        // echo '<pre>';
                        // print_r($update);
                        // echo '<pre>';
                        // exit();

                        BiweeklyPeriods::insert($update);
                    }
                }

                $rest = [
                    'status'    => true,
                    'data'      => 'Success',
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function getHoliday($budgetYear)
    {
        $budgetYear = $budgetYear - 543;
        $nextYear = $budgetYear++;
        $getData = Holiday::where('hol_date', 'like', '%' . $budgetYear . '%')->orWhere('hol_date', 'like', '%' . $nextYear . '%')->get();

        // echo '<pre>';
        // print_r($id);
        // echo '</pre>';
        // exit();

        $data = [];
        if(!empty($getData)){
            foreach ($getData as $key => $value) {

                if(!empty($value->hol_date)){
                    $replaceHoliday = str_replace('/', '-', $value->hol_date);
                    $formatHoliday = strtotime($replaceHoliday);
                    $holiday = date('d/m/Y',$formatHoliday);
                }else{
                    $holiday = '';
                }

                $data[$key] = [
                    'hol_date'  => $holiday,
                ];
            }

            $rest = [
                'status'    => 'success',
                'data'      => $data,
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function searchBiweeklyPeriods($budgetYear)
    {
        if($budgetYear != 0){
            $budgetYear = $budgetYear - 543;
            $getData = BiweeklyPeriods::select('budget_year', 'biweekly_id', 'biweekly_no', 'start_date_period', 'end_date_period', 'day_for_sale')
                                        ->where('budget_year', $budgetYear)
                                        ->where('budget_year', '<=', 2400)
                                        ->whereNull('deleted_at')
                                        ->orderBy('budget_year', 'ASC')
                                        ->orderBy('biweekly_no', 'ASC')->get();
        }else{
            $getData = BiweeklyPeriods::select('budget_year', 'biweekly_id', 'biweekly_no', 'start_date_period', 'end_date_period', 'day_for_sale')
                                        ->where('budget_year', '<=', 2400)
                                        ->whereNull('deleted_at')
                                        ->orderBy('budget_year', 'ASC')
                                        ->orderBy('biweekly_no', 'ASC')->get();
        }

        // echo '<pre>';
        // print_r($getData);
        // echo '</pre>';
        // exit();

        $minBudgetYear = BiweeklyPeriods::orderBy('budget_year', 'asc')->pluck('budget_year')->first();
        $minBudgetYear = !empty($minBudgetYear) ? (int)$minBudgetYear + 543 : '';

        $maxBudgetYear = BiweeklyPeriods::orderBy('budget_year', 'desc')->pluck('budget_year')->first();
        $maxBudgetYear = !empty($maxBudgetYear) ? (int)$maxBudgetYear + 543 : '';

        $data = [];
        if(!empty($getData)){
            foreach ($getData as $key => $value) {

                // START BUDGET YEAR
                if(!empty($value->start_date_period)){
                    $replaceStart   = str_replace('/', '-', $value->start_date_period);
                    $formatStart    = strtotime($replaceStart);
                    $startPeriod     = date('d/m/Y',$formatStart);

                    $arrBudget = explode('/', $startPeriod);
                    $changeStart = $arrBudget[2] + 543;
                    $startDatePeriods = $arrBudget[0].'/'.$arrBudget[1].'/'.$changeStart;
                }else{
                    $startDatePeriods = '';
                }

                // END DATE PERIOD
                if(!empty($value->end_date_period)){
                    $replaceEnd   = str_replace('/', '-', $value->end_date_period);
                    $formatEnd    = strtotime($replaceEnd);
                    $endPeriod     = date('d/m/Y',$formatEnd);

                    $arrBudget = explode('/', $endPeriod);
                    $changeEnd = $arrBudget[2] + 543;
                    $endDatePeriods = $arrBudget[0].'/'.$arrBudget[1].'/'.$changeEnd;
                }else{
                    $endDatePeriods = '';
                }

                $data[$key] = [
                    'biweekly_id'           => $value->biweekly_id,
                    'biweekly_no'           => $value->biweekly_no,
                    'start_date_period'     => $startDatePeriods,
                    'end_date_period'       => $endDatePeriods,
                    'day_for_sale'          => $value->day_for_sale
                ];
            }

            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            // exit();

            $rest = [
                'status'    => 'success',
                'data'      => $data,
                'minBudgetYear' => $minBudgetYear,
                'maxBudgetYear' => $maxBudgetYear
            ];
        }else{
            $rest = [
                'status'        => 'false',
                'data'          => $data,
                'minBudgetYear' => $minBudgetYear,
                'maxBudgetYear' => $maxBudgetYear
            ];
        }

        return response()->json(['data' => $rest]);
    }
}
