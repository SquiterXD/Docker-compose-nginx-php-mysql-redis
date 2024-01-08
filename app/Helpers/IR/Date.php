<?php

use Carbon\Carbon;
// Piyawut A. 20211111
use App\Models\IR\Views\PtglCoaCompanyView;
use App\Models\IR\Views\PtglCoaEvmView;
use App\Models\IR\Views\PtglCoaDeptCodeView;
use App\Models\IR\Views\PtglCoaCostCenterView;
use App\Models\IR\Views\PtglCoaBudgetYearView;
use App\Models\IR\Views\PtglCoaBudgetTypeView;
use App\Models\IR\Views\PtglCoaBudgetDetailView;
use App\Models\IR\Views\PtglCoaBudgetReasonView;
use App\Models\IR\Views\PtglCoaMainAccountView;
use App\Models\IR\Views\PtglCoaSubAccountView;
use App\Models\IR\Views\PtglCoaReserved1View;
use App\Models\IR\Views\PtglCoaReserved2View;

function convertMonthAndYearDate($date, $day)
{
    if($date != '')
    {
        $dateMonthArray = explode('/', $date);
        $month = $dateMonthArray[0];
        $year  = $dateMonthArray[1];
        $date  = '';


        if($day == 'start')
        {
            $date = Carbon::createFromDate($year, $month, '01')->startOfMonth();
        }
        else if($day == 'end')
        {
            $date = Carbon::createFromDate($year, $month, '01')->endOfMonth();
        }

        return $date;
    };
}

function convertMonthAndYearDateToThai($date, $day)
{
    if($date != '')
    {
        $dateMonthArray = explode('/', $date);
        $month = $dateMonthArray[0];
        $year  = convertYearToAD($dateMonthArray[1]);
        $date  = '';

        if($day == 'start')
        {
            $date = Carbon::createFromDate($year, $month)->startOfMonth();
        }
        else if($day == 'end')
        {
            $date = Carbon::createFromDate($year, $month)->endOfMonth();
        }

        return $date;
    };
}

function convertYearToBBE($year)
{
    $year = (int)$year + 543;

    return $year;
}

function convertYearToAD($year)
{
    $year = (int)$year - 543;

    return $year;
}

function toDate($date, $newDateFormat = 'Y-m-d', $timeFormat = false) {

    if (empty($date)) {
        return '';
    }

    $newDate = new stdClass();
    $formatDateTime = dateFormatList();

    foreach ($formatDateTime as $dateFormat) {
        if (validateDate($date, $dateFormat)) {
            $newDate = \Carbon\Carbon::createFromFormat($dateFormat, $date);
            break;
        }
    }

    if (is_object($newDate) && get_class($newDate) === 'Carbon\Carbon') {
        $newDate = $newDate;
    } elseif (is_object($date) && get_class($date) === 'Illuminate\Support\Carbon') {
        $newDate = $date;
    }

    if ((get_class($newDate) === 'Carbon\Carbon') || (get_class($newDate) === 'Illuminate\Support\Carbon')) {
        if ($timeFormat) {
            // return dateToDateString($newDate, trans('date.format'). ' '. $timeFormat);
            return dateToDateString($newDate, $newDateFormat. ' '. $timeFormat);
        }
        // return dateToDateString($newDate, trans('date.format'));
        return dateToDateString($newDate, $newDateFormat);
    }

    return '';
}

function getMonthTh($index) {
    $monthLists = [
        'Jan' => 'มกราคม',
        'Feb' => 'กุมภาพันธ์',
        'Mar' => 'มีนาคม',
        'Apr' => 'เมษายน',
        'May' => 'พฤษภาคม',
        'Jun' => 'มิถุนายน',
        'Jul' => 'กรกฎาคม',
        'Aug' => 'สิงหาคม',
        'Sep' => 'กันยายน',
        'Oct' => 'ตุลาคม',
        'Nov' => 'พฤศจิกายน',
        'Dec' => 'ธันวาคม'
    ];

    return $monthLists[$index];
}

function days_in_month($month, $year)
{
    // calculate number of days in a month
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

function getMonthDesc($index) {
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

function convertToFormatMail($date)
{
    $month = getMonthDesc(date('m', strtotime($date)));
    $year = (int)date('Y', strtotime($date)) + 543;
    $result = date('d', strtotime($date)).' '.$month.' '.$year;

    return $result;
}

function convertDateFormatToQuery($date){
    $datex = \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    return $datex;
}


function periodFromToIR($from , $to)
{


    $yearFrom = date('Y',  strtotime($from)) +  543;
    $yearTo = date('Y',  strtotime($to))+  543;

    $monthFrom  = date('m',  strtotime($from));
    $monthTo  = date('m',  strtotime($to));

    $dateFrom  =  date('d',  strtotime($from));
    $dateTo =  date('d',  strtotime($to));

    $periodFrom = $dateFrom . ' '. getMonthDesc($monthFrom). ' '. $yearFrom;
    $periodTo = $dateTo . ' '. getMonthDesc($monthTo). ' '. $yearTo;

    return $periodFrom. ' - ' . $periodTo;

}

if (! function_exists('dateFormatShortThaiString')) {
    function dateFormatShortThaiString($date)
    {
        $date = date('Y-m-d',strtotime($date));
        $monthTH = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
        $exp = explode('-',$date);
        return $exp[2].' '.$monthTH[intval($exp[1])].' '.substr($exp[0]+543, 2);
    }
}
