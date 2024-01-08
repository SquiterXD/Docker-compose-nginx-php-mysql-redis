<?php

use Carbon\Carbon;

class FormatDate
{

    public static function DateThaiwithTime($strDate)
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

    public static function DateThai($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

    public static function DateThaiNumericWithSplash($strDate)
    {
        if ($strDate == '') {
            return '';
        }

        // $strYear = date("Y", strtotime($strDate)) + 543;
        // $strMonth = strlen(date("m", strtotime($strDate)) == 1) ? '0'.date("m", strtotime($strDate)) : date("m", strtotime($strDate));
        // $strDay = strlen(date("d", strtotime($strDate)) == 1) ? '0'.date("d", strtotime($strDate)) : date("d", strtotime($strDate));

        $months = [
            1 => '01',
            2 => '02',
            3 => '03',
            4 => '04',
            5 => '05',
            6 => '06',
            7 => '07',
            8 => '08',
            9 => '09',
            10 => '10',
            11 => '11',
            12 => '12',
        ];

        $date = Carbon::parse($strDate);
        $month = $months[$date->month];
        $year = $date->year + 543;

        // return "$strDay/$strMonth/$strYear";
        return $date->format("d/$month/$year");
    }

    public static function DateThaiNumericWithSplashwithout543($strDate)
    {
        if ($strDate == '') {
            return '';
        }
        $months = [
            1 => '01',
            2 => '02',
            3 => '03',
            4 => '04',
            5 => '05',
            6 => '06',
            7 => '07',
            8 => '08',
            9 => '09',
            10 => '10',
            11 => '11',
            12 => '12',
        ];

        $date = Carbon::parse($strDate);
        $month = $months[$date->month];
        $year = $date->year;
        return $date->format("d/$month/$year");
    }

    public static function datetimethaitoomp0040($arg)
    {
        $thai_months = [
            1 => '01',
            2 => '02',
            3 => '03',
            4 => '04',
            5 => '05',
            6 => '06',
            7 => '07',
            8 => '08',
            9 => '09',
            10 => '10',
            11 => '11',
            12 => '12',
        ];
        $date = Carbon::parse($arg);
        $month = $thai_months[$date->month];
        $year = $date->year + 543;
        return $date->format("d/$month/$year H:i:s");
    }

    public static function Dayonly($strDate)
    {
        $strDay = date("j", strtotime($strDate));
        return "$strDay";
    }

    public static function Monthonly($strDate)
    {
        $strMonth = date("n", strtotime($strDate));
        $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strMonthThai";
    }

    public static function Yearonly($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        return "$strYear";
    }

    public static function dateFormatThaiString($date)
    {
        $daysTH = ['', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

        $search = array_search($date, $daysTH);

        $monthTH = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

        return $monthTH[$search];
    }

    public static function convertThaidateFromSplash($data)
    {
        if ($data == '') {
            return '';
        }

        $exp = explode('/', $data);
        $d = $exp[0];
        $m = $exp[1];
        $y = $exp[2] - 543;

        return $y . '-' . $m . '-' . $d;
    }
}
