<?php

    function numberFormatDisplay($value, $decimal = 2)
    {
        $number = number_format(abs($value), $decimal);
        return $value >= 0 ? $number : '('.$number.')';
    }

    function numberFormatDisplayNotRound($value, $decimal = 2)
    {
        $number = number_format(floor( (abs($value) * pow(10, $decimal)) + 0.00000001 ) / pow(10, $decimal), $decimal);
        return $value >= 0 ? $number : '('.$number.')';
    }

    function convertToReadNumber($amount_number, $currency = 'THB')
    {
        $curr = $currency != 'THB' ? \DB::table('ptie_currencies_v')->where('currency_code', $currency)->first() : collect();

        $amount_number = number_format($amount_number, 2, ".","");
        $pt = strpos($amount_number , ".");
        $number = $fraction = "";
        if ($pt === false) 
            $number = $amount_number;
        else
        {
            $number = substr($amount_number, 0, $pt);
            $fraction = substr($amount_number, $pt + 1);
        }
        
        $ret = "";
        $baht = convertNumberToString($number);
        if ($baht != "")
            $ret .= $currency == 'THB' ? $baht . "บาท" : $baht." ".$curr->currency_name;
        
        $satang = convertNumberToString($fraction);
        if ($satang != "")
            $ret .= $currency == 'THB' ? $satang . "สตางค์" : $satang;
        else 
            $ret .= $currency == 'THB' ? "ถ้วน" : "";
        return $ret;
    }
 
    function convertNumberToString($number)
    {
        $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
        $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
        $number = $number + 0;
        $ret = "";
        if ($number == 0) return $ret;
        if ($number > 1000000)
        {
            $ret .= convertNumberToString(intval($number / 1000000)) . "ล้าน";
            $number = intval(fmod($number, 1000000));
        }
        
        $divider = 100000;
        $pos = 0;
        while($number > 0)
        {
            $d = intval($number / $divider);
            $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
                ((($divider == 10) && ($d == 1)) ? "" :
                ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
            $ret .= ($d ? $position_call[$pos] : "");
            $number = $number % $divider;
            $divider = $divider / 10;
            $pos++;
        }
        return $ret;
    }