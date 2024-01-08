<?php

namespace App\Http\Controllers\Planning\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\OverTimesPlan\OTMain;
use App\Models\Planning\OverTimesPlan\OTPlan;
use App\Models\Planning\OverTimesPlan\OTPlanBiWeekly;
use App\Models\Planning\OverTimesPlan\OTPlanBiWeeklyV;
use App\Models\Planning\OverTimesPlan\PNMRGDeptV;
use App\Models\Planning\OverTimesPlan\PP10SetupV;
use App\Models\Planning\OverTimesPlan\OTPlanBudget;

use App\Models\Planning\WorkingHourV;
use App\Models\Planning\ProductType;
use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProgramProfileV;

use Carbon\Carbon;

class OverTimesPlanController extends Controller
{
    public function createOtPlan(Request $request)
    {
        try {
            \DB::beginTransaction();
            $param = $request;
            $year = date('Y', strtotime($param['budget_year']))-543;
            $biWeekly = BiWeeklyV::where('period_year', $year)
                                ->where('period_num', $param['month'])
                                ->where('biweekly', $param['bi_weekly'])
                                ->first();
            $programProfile = ProgramProfileV::where('program_code', 'PPP0010')->first();
            $header = OTMain::where('biweekly_id', $biWeekly->biweekly_id)->first();
            $p10Setup = PP10SetupV::first();
            // Validate Create
            if ($header) {
                $data = [
                    'status' => 'E',
                    'msg' => 'มีข้อมูลประมาณการค่าใช้จ่ายล่วงเวลาประจำปักษ์นี้ในระบบแล้ว'
                ];
                return response()->json($data);
            }
            // Create Header Main
            $otMain                       = new OTMain;
            $otMain->biweekly_id          = $biWeekly->biweekly_id;
            $otMain->working_hour         = $param['working_hour'];
            $otMain->normal_working_hour  = $p10Setup->normal_working_hour; // Default normal_working_hour;
            $otMain->program_code         = $programProfile->program_code;
            $otMain->approved_plan_date   = now();
            $otMain->created_at           = now();
            $otMain->created_by_id        = auth()->user()->user_id;
            $otMain->created_by           = auth()->user()->fnd_user_id;
            $otMain->save();
            \DB::commit();

            // Call Package
            $result = (new OTMain)->callPackageCreateOTPlan($otMain);
            $redirectPath = route('planning.overtimes-plan.index').'?budget_year='.$param['budget_year'].'&month='.$param['month'].'&bi_weekly='.$param['bi_weekly'];
            $data = ['status' => 'S', 'redirectPath' => $redirectPath];
            if ($result['status'] == 'E') {
                \DB::rollback();
                $data = [
                    'status' => 'E',
                    'msg' => $result['message'] ?? 'มีข้อผิดพลาด'
                ];
            }
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
            return response()->json($data);
        }
    }

    public function getOTPlan(OTMain $otMain, Request $request)
    {
        $otPlans = [];
        $param = $request->params;
        //otPlan
        $otPlans = OTPlan::where('ot_main_id', $otMain->ot_main_id)
                    ->where('division_code', $param['department'])
                    ->get();
        // otPlan BiWeekly
        $data = OTPlanBiWeeklyV::selectRaw("period_year
                                            , biweekly
                                            , ot_plan_id
                                            , ot_main_id
                                            , division_code
                                            , department_code
                                            , employee_type
                                            , working_hour
                                            , working_hour_desc
                                            , biweekly_id
                                            , division_name
                                            , department_name
                                            , employee_type_name
                                            , employee_qty
                                            , ot_perhour
                                            , ot_hour
                                            , ot_holiday
                                            , ot_percent
                                            , hourly_wage
                                            , hour_increase
                                            , default_rate
                                            , ot_amount
                                            , department_code||'|'||employee_type employee_type_code
                                        ")
                                        ->where('ot_main_id', $otMain->ot_main_id)
                                        ->where('division_code', $param['department'])
                                        ->whereNotNull('working_hour_desc')
                                        ->orderBy('working_hour_desc')
                                        ->get();
        $otPercent = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('ot_percent', 'employee_type_code')->all()];
        })->toArray();

        $hourlyWage = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('hourly_wage', 'employee_type_code')->all()];
        })->toArray();

        $hourIncrease = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('hour_increase', 'employee_type_code')->all()];
        })->toArray();

        $defaultRate = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('default_rate', 'employee_type_code')->all()];
        })->toArray();

        $otAmount = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('ot_amount', 'employee_type_code')->all()];
        })->toArray();

        $otTimeDesc = array_values(array_unique($data->pluck('working_hour_desc')->toArray()));
        $summary = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->working_hour_desc;
                                $summary = (object)[
                                    'hourly_wage'   => getSumFormat($item, 'hourly_wage', 2),
                                    'hour_increase' => getSumFormat($item, 'hour_increase', 2),
                                    'default_rate'  => getSumFormat($item, 'default_rate', 2),
                                    'ot_amount'     => getSumFormat($item, 'ot_amount', 2)
                                ];
                                return [$groupKey => $summary];
                            });

        // Summary all departtment 21082022
        $dataOtMain = OTPlanBiWeeklyV::where('ot_main_id', $otMain->ot_main_id)
                                        ->whereNotNull('working_hour_desc')
                                        ->orderBy('working_hour_desc')
                                        ->get();
        $summaryAll = $dataOtMain->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->working_hour_desc;
                                $summary = (object)[
                                    'hourly_wage'   => getSumFormat($item, 'hourly_wage', 2),
                                    'hour_increase' => getSumFormat($item, 'hour_increase', 2),
                                    'default_rate'  => getSumFormat($item, 'default_rate', 2),
                                    'ot_amount'     => getSumFormat($item, 'ot_amount', 2)
                                ];
                                return [$groupKey => $summary];
                            });

        $otPlanBiWeekly = OTPlanBiWeeklyV::selectRaw("distinct department_name , employee_type_name, employee_type, employee_qty , ot_perhour , ot_hour , ot_holiday , department_code")
                                        ->where('ot_main_id', $otMain->ot_main_id)
                                        ->where('division_code', $param['department'])
                                        ->whereNotNull('working_hour_desc')
                                        ->orderByRaw('department_code, employee_type')
                                        ->get()
                                        ->groupBy('department_name');


        $data = [
            'status' => 'S'
            , 'otPlans' => $otPlans
            , 'otPlanBiWeekly' => $otPlanBiWeekly
            , 'otPercent' => $otPercent
            , 'hourlyWage' => $hourlyWage
            , 'hourIncrease' => $hourIncrease
            , 'defaultRate' => $defaultRate
            , 'otAmount' => $otAmount
            , 'otTimeDesc' => $otTimeDesc
            , 'summary' => $summary
            , 'summaryAll' => $summaryAll
        ];

        return response()->json($data);
    }

    public function updateOTPlan(OTMain $otMain, Request $request)
    {
        $otPlanBiWeekly = [];
        $param = $request->params;
        // ทำการ update Working Hour ของ department
        OTMain::where('ot_main_id', $otMain->ot_main_id)->update(['approved_plan_date' => now()]);
        // Call Package
        $result = (new OTPlan)->callPackageUpdateOTPlan($otMain, $param);
        if ($result['status'] == 'E') {
            $data = [
                'status' => 'E'
                , 'msg' => $result['message'] ?? 'มีข้อผิดพลาด'
            ];
            return response()->json($data);
        }
        // เมื่อทำการอัพเดตข้อมูล working hour เรียบร้อย จะเช็คว่ามีการข้อมูล ot plan biweekly หรือเปล่า ถ้ามีจะทำการลบและสร้างใหม่ -- Confirm 11082022
        $dataPlanBiWeekly = OTPlanBiWeeklyV::where('ot_main_id', $otMain->ot_main_id)
                                        ->where('division_code', $param['department'])
                                        ->whereNotNull('working_hour_desc')
                                        ->get();
        if (count($dataPlanBiWeekly) > 0) {
            OTPlanBiWeekly::where('division_code', $request['department'])->delete();
        }
        // ถ้าไม่มีข้อมูล ot plan biweekly ให้ทำการสร้างข้อมูล

        $result2 = (new OTPlanBiWeekly)->callPackageCreateOTPlanBiWeekly($otMain, $param);
        if ($result2['status'] == 'E') {
            $data = [
                'status' => 'E'
                , 'msg' => $result2['message'] ?? 'มีข้อผิดพลาด'
            ];
            return response()->json($data);
        }

        // เมื่อสร้างข้อมูลเสร็จ จะดึงข้อมูลไปแสดงที่ PPP0010
        // otPlan BiWeekly
        $data = OTPlanBiWeeklyV::selectRaw("period_year
                                            , biweekly
                                            , ot_plan_id
                                            , ot_main_id
                                            , division_code
                                            , department_code
                                            , employee_type
                                            , working_hour
                                            , working_hour_desc
                                            , biweekly_id
                                            , division_name
                                            , department_name
                                            , employee_type_name
                                            , employee_qty
                                            , ot_perhour
                                            , ot_hour
                                            , ot_holiday
                                            , ot_percent
                                            , hourly_wage
                                            , hour_increase
                                            , default_rate
                                            , ot_amount
                                            , department_code||'|'||employee_type employee_type_code
                                        ")
                                        ->where('ot_main_id', $otMain->ot_main_id)
                                        ->where('division_code', $param['department'])
                                        ->whereNotNull('working_hour_desc')
                                        ->orderBy('working_hour_desc')
                                        ->get();
        $otPercent = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('ot_percent', 'employee_type_code')->all()];
        })->toArray();

        $hourlyWage = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('hourly_wage', 'employee_type_code')->all()];
        })->toArray();

        $hourIncrease = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('hour_increase', 'employee_type_code')->all()];
        })->toArray();

        $defaultRate = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('default_rate', 'employee_type_code')->all()];
        })->toArray();

        $otAmount = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('ot_amount', 'employee_type_code')->all()];
        })->toArray();

        $otTimeDesc = array_values(array_unique($data->pluck('working_hour_desc')->toArray()));
        $summary = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->working_hour_desc;
                                $summary = (object)[
                                    'hourly_wage'   => getSumFormat($item, 'hourly_wage', 2),
                                    'hour_increase' => getSumFormat($item, 'hour_increase', 2),
                                    'default_rate'  => getSumFormat($item, 'default_rate', 2),
                                    'ot_amount'     => getSumFormat($item, 'ot_amount', 2)
                                ];
                                return [$groupKey => $summary];
                            });

        // Summary all departtment 21082022
        $dataOtMain = OTPlanBiWeeklyV::where('ot_main_id', $otMain->ot_main_id)
                                        ->whereNotNull('working_hour_desc')
                                        ->orderBy('working_hour_desc')
                                        ->get();
        $summaryAll = $dataOtMain->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->working_hour_desc;
                                $summary = (object)[
                                    'hourly_wage'   => getSumFormat($item, 'hourly_wage', 2),
                                    'hour_increase' => getSumFormat($item, 'hour_increase', 2),
                                    'default_rate'  => getSumFormat($item, 'default_rate', 2),
                                    'ot_amount'     => getSumFormat($item, 'ot_amount', 2)
                                ];
                                return [$groupKey => $summary];
                            });

        $otPlanBiWeekly = OTPlanBiWeeklyV::selectRaw("distinct department_name, employee_type_name, employee_type, employee_qty, ot_perhour, ot_hour, ot_holiday, department_code")
                                        ->where('ot_main_id', $otMain->ot_main_id)
                                        ->where('division_code', $param['department'])
                                        ->whereNotNull('working_hour_desc')
                                        ->orderByRaw('department_code, employee_type')
                                        ->get()
                                        ->groupBy('department_name');


        $data = [
            'status' => 'S'
            , 'otPlanBiWeekly' => $otPlanBiWeekly
            , 'otPercent' => $otPercent
            , 'hourlyWage' => $hourlyWage
            , 'hourIncrease' => $hourIncrease
            , 'defaultRate' => $defaultRate
            , 'otAmount' => $otAmount
            , 'otTimeDesc' => $otTimeDesc
            , 'summary' => $summary
            , 'summaryAll' => $summaryAll
        ];

        return response()->json($data);
    }

    public function UpdateOTPercent(OTMain $otMain, Request $request)
    {
        $otPlanBiWeekly = [];
        $param = $request->params;
        // update ot percent and re-calculate 15082022
        // Call Package
        $result = (new OTPlanBiWeekly)->callPackageUpdateOTPercent($param);
        if ($result['status'] == 'E') {
            $data = [
                'status' => 'E'
                , 'msg' => $result['message'] ?? 'มีข้อผิดพลาด'
            ];
            return response()->json($data);
        }

        // otPlan BiWeekly
        $data = OTPlanBiWeeklyV::selectRaw("period_year
                                            , biweekly
                                            , ot_plan_id
                                            , ot_main_id
                                            , division_code
                                            , department_code
                                            , employee_type
                                            , working_hour
                                            , working_hour_desc
                                            , biweekly_id
                                            , division_name
                                            , department_name
                                            , employee_type_name
                                            , employee_qty
                                            , ot_perhour
                                            , ot_hour
                                            , ot_holiday
                                            , ot_percent
                                            , hourly_wage
                                            , hour_increase
                                            , default_rate
                                            , ot_amount
                                            , department_code||'|'||employee_type employee_type_code
                                        ")
                                        ->where('ot_main_id', $otMain->ot_main_id)
                                        ->where('division_code', $param['department'])
                                        ->whereNotNull('working_hour_desc')
                                        ->orderBy('working_hour_desc')
                                        ->get();
        $otPercent = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('ot_percent', 'employee_type_code')->all()];
        })->toArray();

        $hourlyWage = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('hourly_wage', 'employee_type_code')->all()];
        })->toArray();

        $hourIncrease = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('hour_increase', 'employee_type_code')->all()];
        })->toArray();

        $defaultRate = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('default_rate', 'employee_type_code')->all()];
        })->toArray();

        $otAmount = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('ot_amount', 'employee_type_code')->all()];
        })->toArray();

        $otTimeDesc = array_values(array_unique($data->pluck('working_hour_desc')->toArray()));
        $summary = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->working_hour_desc;
                                $summary = (object)[
                                    'hourly_wage'   => getSumFormat($item, 'hourly_wage', 2),
                                    'hour_increase' => getSumFormat($item, 'hour_increase', 2),
                                    'default_rate'  => getSumFormat($item, 'default_rate', 2),
                                    'ot_amount'     => getSumFormat($item, 'ot_amount', 2)
                                ];
                                return [$groupKey => $summary];
                            });

        // Summary all departtment 21082022
        $dataOtMain = OTPlanBiWeeklyV::where('ot_main_id', $otMain->ot_main_id)
                                        ->whereNotNull('working_hour_desc')
                                        ->orderBy('working_hour_desc')
                                        ->get();
        $summaryAll = $dataOtMain->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->working_hour_desc;
                                $summary = (object)[
                                    'hourly_wage'   => getSumFormat($item, 'hourly_wage', 2),
                                    'hour_increase' => getSumFormat($item, 'hour_increase', 2),
                                    'default_rate'  => getSumFormat($item, 'default_rate', 2),
                                    'ot_amount'     => getSumFormat($item, 'ot_amount', 2)
                                ];
                                return [$groupKey => $summary];
                            });

        $otPlanBiWeekly = OTPlanBiWeeklyV::selectRaw("distinct department_name , employee_type_name, employee_type, employee_qty , ot_perhour , ot_hour , ot_holiday , department_code")
                                        ->where('ot_main_id', $otMain->ot_main_id)
                                        ->where('division_code', $param['department'])
                                        ->whereNotNull('working_hour_desc')
                                        ->orderByRaw('department_code, employee_type')
                                        ->get()
                                        ->groupBy('department_name');


        $data = [
            'status' => 'S'
            , 'otPlanBiWeekly' => $otPlanBiWeekly
            , 'otPercent' => $otPercent
            , 'hourlyWage' => $hourlyWage
            , 'hourIncrease' => $hourIncrease
            , 'defaultRate' => $defaultRate
            , 'otAmount' => $otAmount
            , 'otTimeDesc' => $otTimeDesc
            , 'summary' => $summary
            , 'summaryAll' => $summaryAll
        ];

        return response()->json($data);
    }

    public function budgetOtPlan(OTMain $otMain, Request $request)
    {
        try {
            \DB::beginTransaction();
            $otBudget = OTPlanBudget::where('ot_main_id', $otMain->ot_main_id)->get();
            // ถ้ามี Data ให้ทำการลบก่อน
            OTPlanBudget::where('ot_main_id', $otMain->ot_main_id)->delete();
            // ทำการบันทึกข้อมูล
            foreach ($request->budgetBiWeekly as $index => $value) {
                $explode = explode('|', $index);
                // get next sequence
                // $resSequence = (new OTPlanBudget)->getNextSeqResPlan();
                // $resSequence = $resSequence['seqResPlan']->nextval;
                // 'ot_main_id'            => $resSequence

                OTPlanBudget::insert([
                    'ot_main_id'            => $otMain->ot_main_id
                    , 'department_code'     => $explode[0]
                    , 'employee_type'       => $explode[1]
                    , 'budget_type'         => $explode[2]
                    , 'amount'              => $value
                    , 'created_at'          => Carbon::now()
                    , 'created_by_id'       => \Auth::user()->user_id
                    , 'created_by'          => \Auth::user()->user_id
                    , 'creation_date'       => Carbon::now()
                    , 'last_update_date'    => Carbon::now()
                ]);
            }
            \DB::commit();
            $data = ['status' => 'S'];
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];

        }
        return response()->json($data);

    }

    public function reportOtPlan(OTMain $otMain, Request $request)
    {
        $programProfile = ProgramProfileV::where('program_code', $otMain->program_code)->first();
        // ------------------------------------------------------------------------------------
        // otPlan BiWeekly
        $departments = PNMRGDeptV::selectRaw('distinct div_cd department_code, sector_name department_name')->orderBy('div_cd')->get();
        $data = OTPlanBiWeeklyV::selectRaw("period_year
                                            , biweekly
                                            , ot_plan_id
                                            , ot_main_id
                                            , division_code
                                            , department_code
                                            , employee_type
                                            , working_hour
                                            , working_hour_desc
                                            , biweekly_id
                                            , division_name
                                            , department_name
                                            , employee_type_name
                                            , employee_qty
                                            , ot_perhour
                                            , ot_hour
                                            , ot_holiday
                                            , ot_percent
                                            , hourly_wage
                                            , hour_increase
                                            , default_rate
                                            , ot_amount
                                            , department_code||'|'||employee_type employee_type_code
                                        ")
                                        ->where('ot_main_id', $otMain->ot_main_id)
                                        // ->where('division_code', $request->department)
                                        ->whereNotNull('working_hour_desc')
                                        ->orderBy('working_hour_desc')
                                        ->get();

        $otPercent = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('ot_percent', 'employee_type_code')->all()];
        })->toArray();

        $hourlyWage = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('hourly_wage', 'employee_type_code')->all()];
        })->toArray();

        $hourIncrease = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('hour_increase', "employee_type_code")->all()];
        })->toArray();

        $defaultRate = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('default_rate', 'employee_type_code')->all()];
        })->toArray();

        $otAmountTab1 = $data->groupBy('working_hour_desc')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->working_hour_desc;
            return [$groupName => $item->pluck('ot_amount', 'employee_type_code')->all()];
        })->toArray();

        $otTimeDesc = array_values(array_unique($data->pluck('working_hour_desc')->toArray()));
        $otPlanBiWeeklyTab1 = OTPlanBiWeeklyV::selectRaw("distinct division_code, department_name, employee_type_name, employee_type, employee_qty , ot_perhour , ot_hour , ot_holiday , department_code")
                                        ->where('ot_main_id', $otMain->ot_main_id)
                                        ->whereNotNull('working_hour_desc')
                                        // ->where('division_code', $request->department)
                                        ->orderByRaw('department_code, employee_type')
                                        ->get()
                                        ->groupBy(['division_code', 'department_name']);

        $summary = OTPlanBiWeeklyV::selectRaw("division_code, working_hour_desc, sum(hourly_wage) hourly_wage, sum(hour_increase) hour_increase, sum(ot_amount) ot_amount")
                                        ->where('ot_main_id', $otMain->ot_main_id)
                                        ->whereNotNull('working_hour_desc')
                                        // ->where('division_code', $request->department)
                                        ->orderBy('division_code')
                                        ->groupBy('division_code', 'working_hour_desc')
                                        ->get();
        $summary = $summary->groupBy(['division_code', 'working_hour_desc'])->toArray();
        // ----------------------------------------------------------------------------------------------------------------------
        // last page
        $otPlanBiWeeklyTab2 = OTPlanBiWeeklyV::selectRaw("distinct division_code, division_name, employee_type_name, employee_type")
                                        ->where('ot_main_id', $otMain->ot_main_id)
                                        ->whereNotNull('working_hour_desc')
                                        // ->where('division_code', $request->department)
                                        ->orderByRaw('division_code, employee_type')
                                        ->get()
                                        ->groupBy('division_code');

        // Get Plan budget
        $otPlanBudget = OTPlanBudget::where('ot_main_id', $otMain->ot_main_id)
                                ->get()
                                ->groupBy('department_code');

        $otBudget = $otPlanBudget->mapWithKeys(function ($items, $group) {
            $groupName = $group;
            return [$groupName => $items->groupBy('employee_type')];
        })->toArray();

        // Get OT Amount
        $getOtAmount = OTPlanBiWeeklyV::selectRaw("distinct division_code, employee_type, ot_amount")
                                        ->where('ot_main_id', $otMain->ot_main_id)
                                        ->whereNotNull('working_hour_desc')
                                        // ->where('division_code', $request->department)
                                        ->orderByRaw('division_code, employee_type')
                                        ->get()
                                        ->groupBy('division_code');

        $otAmountTab2 = $getOtAmount->mapWithKeys(function ($items, $group) {
            $groupName = $group;
            return [$groupName => $items->groupBy('employee_type')];
        })->toArray();

        $fileName = 'Overtimes Plan'.'_'.date('Ymdhms');
        $contentHtml = view('planning.overtimes-plan.report.ot_plan'
                    , compact('programProfile'
                    ,'otMain'
                    , 'departments'
                    , 'otPlanBiWeeklyTab1'
                    , 'otPercent'
                    , 'hourlyWage'
                    , 'hourIncrease'
                    , 'defaultRate'
                    , 'otAmountTab1'
                    , 'otTimeDesc'
                    , 'summary'
                    , 'otPlanBiWeeklyTab2'
                    , 'otBudget'
                    , 'otAmountTab2'
                )
            )->render();
        return \PDF::loadHtml($contentHtml)->setOrientation('landscape')->stream($fileName.'.pdf');
    }
}
