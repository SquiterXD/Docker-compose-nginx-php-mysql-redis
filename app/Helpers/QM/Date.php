<?php

if (! function_exists('parse_from_date_th')) {
    function parse_from_date_th($value) {

        // date_th format is datetime => return datetime
        $date_time = DateTime::createFromFormat('d/m/Y H:i:s', $value);
        if($date_time){
            return $date_time->modify('-543 years')->format('Y-m-d H:i:s');
        }

        // date_th format is date => return date
        $date = DateTime::createFromFormat('d/m/Y', $value);
        if($date){
            return $date->modify('-543 years')->format('Y-m-d');
        }

        return ;

    }
}

if (! function_exists('parse_to_date_th')) {
    function parse_to_date_th($value) {

        // date format is datetime => return datetime
        $date_time = DateTime::createFromFormat('Y-m-d H:i:s', $value);
        if($date_time){
            return $date_time->modify('+543 years')->format('d/m/Y H:i:s');
        }

        // date format is date => return date
        $date = DateTime::createFromFormat('Y-m-d', $value);
        if($date){
            return $date->modify('+543 years')->format('d/m/Y');
        }

        return ;

    }
}
