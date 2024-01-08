<?php

function compareDaysTH($days){
    $daysTH = ['ทุกวัน','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์','อาทิตย์'];

    $search = array_search($days, $daysTH);

    if(!$search){
        $daysTH = ['ทุกวัน','วันจันทร์','วันอังคาร','วันพุธ','วันพฤหัสบดี','วันศุกร์','วันเสาร์','วันอาทิตย์'];
        return array_search($days, $daysTH);
    }

    return $search;
}

function compareMonthTH($days){
    $mTH = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    $search = array_search($days, $mTH);

    $mnumber = ['01','02','03','04','05','06','07','08','09','10','11','12'];

    return $mnumber[$search];
}

function nextOfWeek($numberDays)
{
    $days = ['All','monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

    if($numberDays == 0){
        $numberDays = date('w',strtotime(date('Y-m-d')));
        // return date('Y-m-d', strtotime("+1 days"));
        return date('Y-m-d', strtotime("next week {$days[$numberDays]}"));
    }else{
        return date('Y-m-d', strtotime("next week {$days[$numberDays]}"));
    }

}

function nextDaysOfWeek($numberDays)
{
    $days = ['All','monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

    if($numberDays == 0){
        return date('Y-m-d', strtotime("+1 days"));
    }else{
        return date('Y-m-d', strtotime("next {$days[$numberDays]}"));
    }

}

function nextDaysOfWeekNotPlus($numberDays)
{
    $days = ['All','monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

    if($numberDays == 0){
        return date('Y-m-d');
    }else{
        return date('Y-m-d', strtotime("{$days[$numberDays]}"));
    }

}


function dateFormatThaiString($date)
{
    $date = date('Y-m-d',strtotime($date));
    $monthTH = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
    $exp = explode('-',$date);
    return $exp[2].' '.$monthTH[intval($exp[1])].' '.($exp[0]+543);
}

function dateFormatThai($date)
{
    $date = date('Y-m-d',strtotime($date));
    $exp = explode('-',$date);
    return $exp[2].'/'.$exp[1].'/'.($exp[0]+543);
}

function dateConvertThaiEng($date)
{
    if(strpos($date, '/')) {
        $exp = explode('/',$date);
        return ($exp[2]-543).'-'.$exp[1].'-'.$exp[0];
    } else {
        $exp = explode('-',$date);
        return $exp[0].'-'.$exp[1].'-'.$exp[2];
    }
}

function dateFormatEngString($date)
{
    $date = date('Y-m-d',strtotime($date));
    $monthTH = ['','JAN','FEB','MAR','APR','MAY','JUNE','JULY','AUG','SEPT','OCT','NOV','DEC'];
    $exp = explode('-',$date);
    return $exp[2].' '.$monthTH[intval($exp[1])].' '.($exp[0]);
}

function dateFormatDMY($date,$str='/')
{
    if(!$date){ return ''; }
    $date = date('Y-m-d',strtotime($date));
    $exp = explode('-',$date);
    return $exp[2].$str.$exp[1].$str.($exp[0]+543);
}

function dateFormatDMYDefault($date,$str='/')
{
    if(!$date){ return ''; }
    $date = date('Y-m-d',strtotime($date));
    $exp = explode('-',$date);
    return $exp[2].$str.$exp[1].$str.($exp[0]);
}

function monthFormatThaiString($month)
{
    $monthTH = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
    return $monthTH[$month];
}
// Format Date is : 'yyyy-mm-dd'
function checkDateOverlap($startDate1, $endDate1, $startDate2, $endDate2) {
    return (($startDate1) <  ($endDate2) && ($startDate2) < ($endDate1) ? 'overlap' : 'none');
}

function removeTimeOnDate($date){
    if(!empty($date)){
        $dateArr    = explode(' ', $date);

        $dateTime = strtotime($dateArr[0]);
        $resultDate = date('Y-m-d',$dateTime);
    }else{
        $resultDate = '';
    }

    return $resultDate;
}

function dateTimeFormatThaiString($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("d", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array("", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay/$strMonthThai/$strYear $strHour:$strMinute:$strSeconds";
}

function ENcompareDaysTH($day)
{
    $dayTH          = '';
    $strtolowerDay  = strtolower($day);

    if($strtolowerDay == 'sunday'){
        $dayTH = 'อาทิตย์';
    }elseif ($strtolowerDay == 'monday') {
        $dayTH = 'จันทร์';
    }elseif ($strtolowerDay == 'tuesday') {
        $dayTH = 'อังคาร';
    }elseif ($strtolowerDay == 'wednesday') {
        $dayTH = 'พุธ';
    }elseif ($strtolowerDay == 'thursday') {
        $dayTH = 'พฤหัสบดี';
    }elseif ($strtolowerDay == 'friday') {
        $dayTH = 'ศุกร์';
    }elseif ($strtolowerDay == 'saturday') {
        $dayTH = 'เสาร์';
    }
    
    return $dayTH;
}

