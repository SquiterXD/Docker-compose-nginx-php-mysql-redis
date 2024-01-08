<?php

use Carbon\Carbon;

function thaiDateMonth($arg,$format = 'd M y')
{
    $thai_months = [
        1 => 'ม.ค.',
        2 => 'ก.พ.',
        3 => 'มี.ค.',
        4 => 'เม.ย.',
        5 => 'พ.ค.',
        6 => 'มิ.ย.',
        7 => 'ก.ค.',
        8 => 'ส.ค.',
        9 => 'ก.ย.',
        10 => 'ต.ค.',
        11 => 'พ.ย.',
        12 => 'ธ.ค.',
    ];
    $date = Carbon::parse($arg);
    $month = $thai_months[$date->month];
    $format = str_replace(['m','M'],$month,$format);
    return $date->format($format);
}
