<?php

    function getDefaultData($menuUrl = '') {
        $menu = getMenu($menuUrl);
        $user = auth()->user();
        $fndUser = $user->fndUser;

        $data['program_code'] = optional($menu)->program_code;
        $data['user_id'] = $user->user_id;
        $data['user_name'] = $user->username;
        $data['fnd_user_id'] = optional($fndUser)->user_id;
        $data['fnd_user_name'] = optional($fndUser)->user_name;

        // select * from mtl_parameters where organization_code ='A32';
        // centrillion
        if ($user->organization_id) {
            $org    = \DB::connection('oracle')->table('org_organization_definitions')
                    ->where('organization_id', $user->organization_id)
                    ->first();
        } else {
            $org    = \DB::connection('oracle')->table('org_organization_definitions')
                    ->where('organization_code', 'MG6')
                    ->first();
        }

        $personaldeptlocation = $user->getOperatingUnit();

        $data['bu_id'] = optional($personaldeptlocation)->organization_id;
        $data['bu_code'] = optional($personaldeptlocation)->name;
        $data['bu_name'] = optional($personaldeptlocation)->short_code;

        // $data['organization_id'] = optional($org)->organization_id ?? 180 ;
        // $data['organization_code'] = optional($org)->organization_code ?? 'A32';
        // $data['organization_name'] = optional($org)->organization_name;
        // $data['organization_list'] = [];

        $data['organization_id'] = session()->get('organization_id');
        $data['organization_code'] = session()->get('organization_code');
        $data['organization_name'] = session()->get('organization_name');
        $data['organization_list'] = session()->get('organization_list');

        $department = session('current_department', false) ;
        $data['department'] = $department;
        $data['department_code'] = $department ? $department->department_code : $user->department_code;
        $data['department_code_list'] = [];

        $data['attachment_path'] = null;
        $data['response_name'] = 'Quality Manager';
        $data['app_short_name'] = 'GMD';

        $programCode = 'WBP0001';
        $year = date('Y');
        $month = date('m');
        $data['archive_directory'] = "{$programCode}/archive/{$year}/{$month}";
        $data['output_directory'] = "{$programCode}/output/{$year}/{$month}";
        $data['error_directory'] = "{$programCode}/error/{$year}/{$month}";
        $data['log_directory'] = "{$programCode}/log/{$year}/{$month}";


        //แจ้งเตือนปริมาณคงคลังสารปรุง
        $data['subinventory_code'] = 'RESBKK01';
        $data['locator_code'] = 'RESBKK01.ZONE02';
        if (optional($menu)->program_code == 'PMP0039') {
            $data['subinventory_code'] = 'RESBKK01';
            $data['locator_code'] = 'RESBKK01.ZONE02';
        }

        $data['upload_max_files'] = 5;
        $data['upload_max_file_size'] = 2; //MB
        $data['upload_file_type'] = "jpg,bmp,png,pdf"; // laravel:mimes:jpg,bmp,png,pdf

        return (object)$data;
    }


    function parseToDateTh($date, $timeFormat = false) {
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
            $newDate = $newDate->addYears(543)->timezone('Asia/Bangkok');
            if ($timeFormat) {
                return dateToDateString($newDate, trans('date.format'). ' '. $timeFormat);
            }
            return dateToDateString($newDate, trans('date.format'));
        }

        return '';
    }

    function parseFromDateTh($date, $timeFormat = false) {

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
            $newDate = $newDate->subYears(543)->timezone('Asia/Bangkok');
            if ($timeFormat) {
                // return dateToDateString($newDate, trans('date.format'). ' '. $timeFormat);
                return dateToDateString($newDate, 'Y-m-d'. ' '. $timeFormat);
            }
            // return dateToDateString($newDate, trans('date.format'));
            return dateToDateString($newDate, 'Y-m-d');
        }

        return '';
    }


    function validateDate($date, $format) {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    function dateFormatList() {
        $allFormat = [];
        $formatDateTime = [
            'd/m/Y H:i:s',//20/03/2021 07:02:00
            'd/m/Y H:i', //20/03/2021 07:02
            'd/n/Y H:i:s', //20/3/2021 07:02:00
            'd/n/Y H:i', //20/3/2021 07:02
            'd/m/Y', //20/03/2021
            'd/n/Y', //20/3/2021
            'j/n/Y', //20/3/2021 // day of the month without leading zeros

            'Y/m/d H:i:s',//20/03/2021 07:02:00
            'Y/m/d H:i', //20/03/2021 07:02
            'Y/n/d H:i:s', //20/3/2021 07:02:00
            'Y/n/d H:i', //20/3/2021 07:02
            'Y/m/d', //20/03/2021
            'Y/n/d', //20/3/2021
            'Y/n/j', //20/3/2021 // day of the month without leading zeros
        ];

        $symbols = ['/', '-'];

        foreach ($symbols as $key => $symbol) {

            foreach ($formatDateTime as $key => $format) {
                $allFormat[] = str_replace("/", $symbol, $format);
            }
        }

        return $allFormat;
    }

    function getSumFormat($data, $field, $digit = 2)
    {
        $total = $data->sum($field);
        if ($digit === 0) {
            return $total ?? 0;
        }
        return number_format($total ?? 0 , $digit);
    }

    function dateToDateString($date, $format) {
        return $date->format($format);
    }

    function multiArraySearch($array, $search) {

        // Create the result array
        $result = array();

        // Iterate over each array element
        foreach ($array as $key => $value) {

            // Iterate over each search condition
            foreach ($search as $k => $v){

                // If the array element does not meet the search condition then continue to the next element
                if (!isset($value[$k]) || $value[$k] != $v) {
                    continue 2;
                }

            }

            // Add the array element's key to the result array
            $result[] = $key;

        }

        // Return the result array
        return $result;
    }

    //Budget Inquiry funds--Piyawut A. 28042021
    function balanceType($val) {
        if($val == 1){
            $result = 'Budget';
        }elseif ($val == 2) {
            $result = 'Encumbrance';
        }else {
            $result = 'Actual';
        }

        return $result;
    }

    // get prefix value set value account--Piyawut A. 06072021
    function getPrefixValueSetName() {
        $prefix = 'TOAT';
        if (session('db_name') == 'UAT' || session('db_name') == 'DEV3' || session('db_name') == 'PROD') {
            $prefix = 'TOAT';
        }

        return $prefix;
    }

    function getInvOrgForOM() {
        $org    = \DB::connection('oracle')->table('mtl_parameters')
                    ->where('organization_code', 'A01')
                    ->first();
        return $org;
    }

    function formatDateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

    function formatLongDateThai($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        
        $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        
        $strMonthThai = $strMonthCut[$strMonth];
        
        return "$strDay $strMonthThai $strYear";
    }
    
    function formatDateTimeThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear $strHour:$strMinute";
    }

    function isActiveRoute($strPath, $output = 'active')
    {
        $strPath = strtoupper($strPath);
        $currentPath = strtoupper(request()->path());
        // \Log::info('isActiveRoute =======> ', [$strPath, $currentPath, \Str::contains($strPath, $currentPath)]);
        if ($currentPath != '/' && \Str::contains($strPath, $currentPath)) {
            return $output;
        }
    }

    // CT Format number: abs 20230104
    function absFormat($value, $digit=null)
    {
        $result = 0;
        $result = $value >= 0? $value: '('.number_format(abs($value), $digit).')';

        return $result;
    }
