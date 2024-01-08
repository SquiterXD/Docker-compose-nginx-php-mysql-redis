<?php

use  App\Models\Planning\ProductType;
use  App\Models\Planning\MachineV;
use  App\Models\Planning\PPAlertOnhandV;
use  App\Models\Lookup\ValueSetup;
use  App\Models\PP\PMStampHeader;
use  App\Models\PP\PMStampIncomV;
use  App\Models\Planning\StampFollow\StampFollowDailyV;
use  App\Models\PP\PPStampFollowBalance;
use  App\Models\TTMEmpPostion;
use App\Models\IR\Views\PtglCoaDeptCodeView;
use App\Models\IR\Views\PtglCoaBudgetTypeView;
use App\Models\IR\Views\PtglCoaBudgetDetailView;
use App\Models\IR\Views\PtglCoaBudgetReasonView;
use App\Models\IR\Views\PtglCoaMainAccountView;
use App\Models\IR\Views\PtglCoaSubAccountView;

function getProductName($val)
{
    $name = ProductType::where('lookup_code', $val)->first();
    return $name? $name->meaning: null;
}

function machineDesc($val)
{
    $desc = MachineV::where('machine_group', $val)->first();
    return $desc? $desc: null;
}

function getCigaretteColor($efficiencies, $itemDesc)
{
    $result = '#e9ecef';
    foreach ($efficiencies as $efficiency) {
        if ($efficiency->item_description == $itemDesc) {
            $result = cigaretteColorSetup($efficiency->item_id);
            return $result;
        }
    }
    return $result;
}

function cigaretteColorSetup($itemId)
{
    $color = [];
    if (!$itemId) {
        return '#e9ecef';
    }
    $color = ValueSetup::where('lookup_type', 'PTPP_DEFINE_COLOR_OF_CIGARETTE')->where('attribute1', $itemId)->first();
    $color = optional($color)->meaning ?? null;
    if (!$color) {
        $colors = ['#3099a1', '#ffd700', '#dd6a5c', '#4f53ca', '#98bd54', '#1ab394', '#fbb924', '#f87171', '#34d399', '#60a5fa', '#55bad8', '#ff00a7', '#d63bb8', '#ff9bec', '#ffc5f1', '#ff0074', '#7a72bd', '#fce9ff', '#fd6468', '#ffd583', '#369694', '#b0bfdf', '#89a3d0', '#598ac1', '#0a72b3', '#86d2c1', '#ff966a', '#ff5668', '#ae1f6c', '#ff7d24', '#ff9d39', '#feff68', '#5edfae', '#26a5d6'];
        $index = array_rand($colors);
        $color = $colors[$index];
    }

    return $color;
}

function getSummaryEfficiency($sumEff, $itemDesc, $machineGroupDesc)
{
    $lineNo = substr($itemDesc, 0, 1);
    $itemDesc = substr($itemDesc, 1);
    if ($sumEff) {
        foreach ($sumEff as $key => $eff) {
            if ($eff->item_description === $itemDesc && $eff->machine_group_desc === $machineGroupDesc && $eff->line_no == $lineNo) {
                return '('.number_format($eff->efficiency_product, 2).')';
            }
        }
    }
    return '';
}

function checkIsADateOrIsADesc($itemDesc)
{
    $itemDesc = substr($itemDesc, 1);
    if (strtotime($itemDesc)) {
        return '';
    }
    return $itemDesc;
}

function convertFormatDateToThai($date)
{
    $resDisplayPlanDate = App\Models\Planning\MachineYearlyHeader::convertFormatDate($date);
    return $resDisplayPlanDate['v_display_plan_date'];
}

function colorTotalForSale($itemId, $totalForSale)
{
    $color = '#212529';
    $alertOnhandV = PPAlertOnhandV::where('attribute1', $itemId)->first();
    if ($alertOnhandV) {
        if ($totalForSale < $alertOnhandV->attribute2) {
            $color = '#c72a4e';
        }elseif ($totalForSale >= $alertOnhandV->attribute3) {
            $color = '#2135a5';
        }
    }

    return $color;
}

function convertFormatDateToFullThai($date, $type)
{
    $result = '';
    $month_arr = ["1"=>"มกราคม", "2"=>"กุมภาพันธ์", "3"=>"มีนาคม", "4"=>"เมษายน", "5"=>"พฤษภาคม", "6"=>"มิถุนายน",  "7"=>"กรกฎาคม", "8"=>"สิงหาคม", "9"=>"กันยายน", "10"=>"ตุลาคม", "11"=>"พฤศจิกายน", "12"=>"ธันวาคม" ];

    $month_short_arr = ["1"=>"ม.ค.", "2"=>"ก.พ.", "3"=>"มี.ค.", "4"=>"เม.ย.", "5"=>"พ.ค.", "6"=>"มิ.ย.",  "7"=>"ก.ค.", "8"=>"ส.ค.", "9"=>"ก.ย.", "10"=>"ต.ค.", "11"=>"พ.ย.", "12"=>"ธ.ค." ];

    $result = date("d", strtotime($date))." ".$month_arr[date("n", strtotime($date))]." ".(date("Y", strtotime($date)) +543);
    if ($type == 'short_format') {
        $result = date("d", strtotime($date))."-".$month_short_arr[date("n", strtotime($date))]."-".(date("Y", strtotime($date)) +543);
    }

    return $result;
}

function getSumStampDailyFormat($data, $followStampId, $field, $digit = 4)
{
    $total = $data->where('follow_stamp_id', $followStampId)->sum($field);
    if ($digit === 0) {
        return $total ?? 0;
    }
    return number_format($total ?? 0 , $digit);
}

function checkPublicHoliday($date)
{
    $date = date('d-m-Y', strtotime($date));
    $holiday = App\Models\Planning\HolidayV::whereRaw("trunc(hol_date) = TO_DATE('{$date}', 'DD-MM-YYYY')")->first();
    return $holiday? 'Y': 'N' ;
}

function getMonthDescPlanning($index) {
    $monthLists = [
        '01' => 'มกราคม',
        '02' => 'กุมภาพันธ์',
        '03' => 'มีนาคม',
        '04' => 'เมษายน',
        '05' => 'พฤษภาคม',
        '06' => 'มิถุนายน',
        '07' => 'กรกฎาคม',
        '08' => 'สิงหาคม',
        '09' => 'กันยายน',
        '10' => 'ตุลาคม',
        '11' => 'พฤศจิกายน',
        '12' => 'ธันวาคม'
    ];

    return $monthLists[$index];
}

function getSumFormatP10($datas)
{
    $total = 0;
    foreach ($datas as $data) {
        $total += $data['ot_amount'];
    }
    return $total;
}

function getDepertmentGroup($planDept)
{
    $exp_dept = explode('  ', $planDept);
    $result = $exp_dept[1] == ''? $planDept: $exp_dept[1];

    return $result;
}

// for PPR0005
function getSumStampMonthlyFormat($data, $monthId, $field, $digit = 2)
{
    $total = $data->sum($field);
    if ($digit === 0) {
        return $total ?? 0;
    }
    return number_format($total ?? 0 , $digit);
}

// for PPR0007
function thainumDigit($data) {
    $result = str_replace(array('0' , '1' , '2' , '3' , '4' , '5' , '6' ,'7' , '8' , '9')
                        , array("o" , "๑" , "๒" , "๓" , "๔" , "๕" , "๖" , "๗" , "๘" , "๙")
                        , $data);
    return $result;
}

// for PPR0010
function calPMStamp($st, $ed, $group, $stamps) {
    $result = [];
    // PM
    $pmStamps = PMStampHeader::selectRaw("sum(actual_used) actual_used, sum(loss) loss, sum(broken) broken, used_date")
                            ->whereRaw("trunc(used_date) BETWEEN TO_DATE('{$st}','dd-mm-YYYY') AND TO_DATE('{$ed}','dd-mm-YYYY')")
                            ->where('item_code2', $group)
                            ->whereIn('description1', $stamps->pluck('cigarettes_description')->toArray())
                            ->orderBy('used_date')
                            ->groupBy('used_date')
                            ->get();

    $pmStampIncom = StampFollowDailyV::selectRaw('sum(incompleted_qty) incompleted_qty, follow_date')
                            ->whereRaw("trunc(follow_date) BETWEEN TO_DATE('{$st}','dd-mm-YYYY') AND TO_DATE('{$ed}','dd-mm-YYYY')")
                            ->where('stamp_code', $group)
                            ->orderBy('follow_date')
                            ->groupBy('follow_date')
                            ->get();

    $stampBalances = PPStampFollowBalance::selectRaw("sum(qty) bal_qty, follow_date")
                            ->whereRaw("trunc(follow_date) BETWEEN TO_DATE('{$st}','dd-mm-YYYY') AND TO_DATE('{$ed}','dd-mm-YYYY')")
                            ->where('stamp_code', $group)
                            ->whereIn('cigarettes_code', $stamps->pluck('cigarettes_code')->toArray())
                            ->orderBy('follow_date')
                            ->groupBy('follow_date')
                            ->get();

    $date = date('Y-m-d', strtotime($st));
    $bf = date("Y-m-d", strtotime("-1 day",strtotime($date)));
    $onhandForward = PPStampFollowBalance::selectRaw("sum(qty) bal_qty")
                            ->whereRaw("trunc(follow_date) = TO_DATE('{$bf}','YYYY-MM-DD')")
                            ->where('stamp_code', $group)
                            ->whereIn('cigarettes_code', $stamps->pluck('cigarettes_code')->toArray())
                            ->first();

    $actualUsed = $pmStamps->groupBy('used_date')->mapWithKeys(function ($item, $group) {
        $groupName = $item->first()->used_date;
        return [$groupName => $item->pluck('actual_used')->all()];
    })->toArray();

    $loss = $pmStamps->groupBy('used_date')->mapWithKeys(function ($item, $group) {
        $groupName = $item->first()->used_date;
        return [$groupName => $item->pluck('loss')->all()];
    })->toArray();

    $broken = $pmStamps->groupBy('used_date')->mapWithKeys(function ($item, $group) {
        $groupName = $item->first()->used_date;
        return [$groupName => $item->pluck('broken')->all()];
    })->toArray();

    $incomplete = $pmStampIncom->groupBy('follow_date')->mapWithKeys(function ($item, $group) {
        $groupName = $item->first()->follow_date;
        return [$groupName => $item->pluck('incompleted_qty')->all()];
    })->toArray();

    $balance = $stampBalances->groupBy('follow_date')->mapWithKeys(function ($item, $group) {
        $groupName = $item->first()->follow_date;
        return [$groupName => $item->pluck('bal_qty')->all()];
    })->toArray();

    $result = [
            'actualUsed' => $actualUsed
            , 'loss' => $loss
            , 'broken' => $broken
            , 'incomplete' => $incomplete
            , 'balance' => $balance
            , 'onhandForward' => $onhandForward->qty
        ];
    return $result;
}

function countPagePPR0010($itemCigarettes)
{
    $calPage = 0;
    foreach ($itemCigarettes as $group => $stamps) {
        $calPage += count(array_chunk($stamps->toArray(), 6)) ?? 0;
    }

    return $calPage;
}

function countSummaryByItem($receiveQtyP09, $item, $followDate)
{
    $result = [];
    foreach ($receiveQtyP09 as $index => $stamps) {
        if ($index == $followDate.'|'.$item) {
            if (!array_key_exists($item, $result)) {
                $result[$item] = $receiveQtyP09[$followDate.'|'.$item]
                            ? $receiveQtyP09[$followDate.'|'.$item][0]
                            : 0;
            }else{
                $result[$item] += $receiveQtyP09[$followDate.'|'.$item]
                            ? $receiveQtyP09[$followDate.'|'.$item][0]
                            : 0;
            }
        }
    }
    return $result;
}

function getPRPOStampAcc($budgetAcc)
{
    $res = [];
    $acc = explode('.', $budgetAcc);
    $budgetYear = $acc[4];
    $budgetCode = $acc[2].'.'.$acc[5].'.'.$acc[6].'.'.$acc[7].'.'.$acc[8].'.'.$acc[9];
    // Description
    $department = (new PtglCoaDeptCodeView)->departmentDesc(getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE', $acc[2], $acc[2]);
    $budgetType = (new PtglCoaBudgetTypeView)->budgetTypeDesc(getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE', $acc[5], $acc[5]);
    $budgetDetail = (new PtglCoaBudgetDetailView)->budgetDetailDesc(getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL', $acc[6], $acc[6], $acc[5]);
    $budgetReason = (new PtglCoaBudgetReasonView)->budgetReasonDesc(getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON', $acc[7], $acc[7]);
    $mainAccount = (new PtglCoaMainAccountView)->mainAccountDesc(getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT', $acc[8], $acc[8]);
    $subAccount = (new PtglCoaSubAccountView)->subAccountDesc(getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT', $acc[9], $acc[9], $acc[8]);
    $desc = optional($department)->description.'.'.optional($budgetType)->description.'.'.optional($budgetDetail)->description.'.'.optional($budgetReason)->description.'.'.optional($mainAccount)->description.'.'.optional($subAccount)->description;

    $res = ['budgetYear' => $budgetYear, 'budgetCode' => $budgetCode, 'desc' => $desc];
    return $res;
}

function getUserDetail($name)
{
    $res = [];
    $position = '';
    $empPos = TTMEmpPostion::where('pnps_psnl_no', $name)->first();
    $department = optional($empPos)->pndp_division_name.' '.optional($empPos)->pndp_sector_name;

    // Condition check position
    if ($empPos->pnpm_pos_name == 'หัวหน้าส่วน' || $empPos->pnpm_pos_name == 'หัวหน้ากอง') {
        $position = 'หัวหน้า'.' '.optional($empPos)->pndp_division_name.' '.optional($empPos)->pndp_sector_name;
    }elseif ($empPos->pnpm_pos_name == 'ผู้อำนวยการฝ่าย' || $empPos->pnpm_pos_name == 'ผู้อำนวยการฝ่าย') {
        $position = 'ผู้อำนวยการ'.' '.optional($empPos)->pndp_division_name.' '.optional($empPos)->pndp_sector_name;
    } elseif ($empPos->pnpm_pos_name == 'รองผู้อำนวยการฝ่าย' || $empPos->pnpm_pos_name == 'รองผู้อำนวยการสำนัก') {
        $position = 'รองผู้อำนวยการ'.' '.optional($empPos)->pndp_division_name.' '.optional($empPos)->pndp_sector_name;
    }elseif ($empPos->pnpm_pos_name == 'ผู้ช่วยหัวหน้ากอง') {
        $position = 'ผู้ช่วยหัวหน้า'.' '.optional($empPos)->pndp_division_name.' '.optional($empPos)->pndp_sector_name;
    }elseif ($empPos->pnpm_pos_name == 'รองหัวหน้าส่วน') {
        $position = 'รองหัวหน้า'.' '.optional($empPos)->pndp_division_name.' '.optional($empPos)->pndp_sector_name;
    }else{
        $position = $empPos->pnpm_pos_name;
    }

    $res = [
        'name' => optional($empPos)->pnps_title.' '.optional($empPos)->pnps_psnl_name.' '.optional($empPos)->pnps_psnl_surname
        , 'department' => $department
        , 'position' => $position
    ];
    return $res;
}