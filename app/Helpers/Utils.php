<?php


namespace App\Helpers;

use DateTime;

class Utils
{
    public static function isValidDate($date, $format = 'Y-m-d H:i:s'): bool
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function getArrayValueOrDefault($array, $key, $default = null){
        return isset($array[$key]) ? $array[$key] : $default;
    }
}
