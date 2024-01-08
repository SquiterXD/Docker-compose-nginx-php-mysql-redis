<?php
function toperioddate($perioddate)
{  //dd-mm-yyyy-dd-mm-yyyy
    if ($perioddate == '-') {
        return $perioddate;
    } else {
        $thaishortmonths = ['01' => 'ม.ค.', '02' => 'ก.พ.', '03' => 'มี.ค.', '04' => 'เม.ย.', '05' => 'พ.ค.', '06' => 'มิ.ย.', '07' => 'ก.ค.', '08' => 'ส.ค.', '09' => 'ก.ย.', '10' => 'ต.ค.', '11' => 'พ.ย.', '12' => 'ธ.ค.',];
        $x = explode('-', $perioddate);
        // dd($x); exit();
        if (count($x) == 6) {
            list($sd, $sm, $sy, $ed, $em, $ey) = $x;
            return $sd . ' ' . $thaishortmonths[$sm] . ' ' . ($sy + 543) . '-' . $ed . ' ' . $thaishortmonths[$em] . ' ' . ($ey + 543);
        } else {
            return $perioddate;
        }
    }
}

function numberformat($number, $decimals, $sp = '')
{
    if ($number) {
        return number_format($number, $decimals);
    } else {
        if ($sp) {
            return $sp;
        }
        return "";
    }
}