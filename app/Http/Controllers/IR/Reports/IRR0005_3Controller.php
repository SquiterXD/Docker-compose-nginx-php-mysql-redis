<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use PDF;

use App\Models\ProgramInfo;
use App\Models\IR\Views\PtirVehiclesView;
use App\Models\IR\Views\PtirRenewCarInsurancesView;
use App\Models\IR\Views\PtglCoaDeptCodeView;
class IRR0005_3Controller extends Controller
{
    public function getGroupCode()
    {
        $month =  date('Y-m-d', strtotime(request()->month));
        $monthFromTh = parseFromDateTh($month);

        $monthText = date('Y', strtotime($monthFromTh)).date('m', strtotime($monthFromTh));
        
        $sql = "
        select distinct group_code as value, group_desc as label
        from oair.ptir_vehicles_v 
        where to_char(insurance_expire_date , 'YYYYMM') = '{$monthText}'
        or to_char(license_plate_expire_date , 'YYYYMM') = '{$monthText}'
        or to_char(acts_expire_date , 'YYYYMM') = '{$monthText}'
        or to_char(car_inspection_expire_date , 'YYYYMM') = '{$monthText}'
        ";

        $data =  \DB::select($sql);

        return response()->json([
            'data'          => $data,
        ]);
    }

    public function getCarInsurance()
    {
        $month = parseFromDateTh(date('Y-m-d', strtotime(request()->month)));

        $monthText = date('Y', strtotime($month)).date('m', strtotime($month));

        $groupCode = request()->group_code;

        $lists = PtirVehiclesView::whereRaw("to_char(insurance_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(license_plate_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(acts_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(car_inspection_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->get();

        $insurance_type_code     = $lists->whereNotnull('insurance_type_code')->pluck('insurance_type_code')->unique()->toArray();
        $renew_car_act           = $lists->whereNotnull('renew_car_act')->pluck('renew_car_act')->unique()->toArray();
        $renew_car_license_plate = $lists->whereNotnull('renew_car_license_plate')->pluck('renew_car_license_plate')->unique()->toArray();
        $renew_car_inspection    = $lists->whereNotnull('renew_car_inspection')->pluck('renew_car_inspection')->unique()->toArray();

        $insurance_type_code_arr     = implode(',', $insurance_type_code);
        $renew_car_act_arr           = implode(',', $renew_car_act);
        $renew_car_license_plate_arr = implode(',', $renew_car_license_plate);
        $renew_car_inspection_arr    = implode(',', $renew_car_inspection);

        $collection = "
                select 
                    lookup_code  || ':' || lookup_type value, 
                    meaning as label,
                    description,
                    lookup_type,
                    tag,
                    enabled_flag,
                    (case when lookup_type = 'PTIR_RENEW_CAR_INSURANCES' then
                        'IRS0002'
                    when lookup_type = 'PTIR_RENEW_CAR_ACT' then 
                        'IRS0003'
                    when lookup_type = 'PTIR_RENEW_CAR_LICENSE_PLATE' then 
                        'IRS0004'
                    when lookup_type = 'PTIR_RENEW_CAR_INSPECTION' then 
                        'IRS0005'
                    else 
                        lookup_type
                    end) renew_program_code
                from ptir_renew_car_insurances
                where 1=1
                and enabled_flag = 'Y'
                and (   lookup_code in ($insurance_type_code_arr)  and 
                        lookup_type = 'PTIR_RENEW_CAR_INSURANCES'
                        or lookup_code in ($renew_car_act_arr) and 
                        lookup_type = 'PTIR_RENEW_CAR_ACT'
                        or lookup_code in ($renew_car_license_plate_arr) and 
                        lookup_type = 'PTIR_RENEW_CAR_LICENSE_PLATE'
                        or lookup_code in ($renew_car_inspection_arr) 
                        and lookup_type = 'PTIR_RENEW_CAR_INSPECTION'
                    )
            ";
        $data =  \DB::select($collection);

        return response()->json([
            'data'          => $data,
        ]);
    }

    public function getDepartment()
    {
        $month     = parseFromDateTh(date('Y-m-d', strtotime(request()->month)));
        $monthText = date('Y', strtotime($month)).date('m', strtotime($month));
        $groupCode = request()->group_code;
        $keyWords  = explode(':' , request()->car_insurance);

        $count = count($keyWords);
                    
        $data = PtirVehiclesView::selectRaw("distinct location_code as value, location_code || ' : ' || location_description as label")
                                        ->whereRaw("to_char(insurance_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(license_plate_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(acts_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(car_inspection_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->when($groupCode , function($q) use ($groupCode ) {
                                            $q->where('group_code', $groupCode);
                                        })
                                        ->when($count , function($q) use ($keyWords) {
                                            $q->when($keyWords[1] == 'PTIR_RENEW_CAR_INSURANCES' , function($q) use ($keyWords) {
                                                $q->where('insurance_type_code', $keyWords[0]);
                                            })->when($keyWords[1] == 'PTIR_RENEW_CAR_ACT' , function($q) use ($keyWords) {
                                                $q->where('renew_car_act', $keyWords[0]);
                                            })->when($keyWords[1] == 'PTIR_RENEW_CAR_LICENSE_PLATE' , function($q) use ($keyWords) {
                                                $q->where('renew_car_license_plate', $keyWords[0]);
                                            })->when($keyWords[1] == 'PTIR_RENEW_CAR_INSPECTION' , function($q) use ($keyWords) {
                                                $q->where('renew_car_inspection', $keyWords[0]);
                                            });
                                        })
                                        ->orderBy('location_code', 'asc')
                                        ->get();
        return response()->json([
            'data'          => $data,
        ]);
    }

    // public function getDepartmentTo()
    // {
    //     $month                = parseFromDateTh(date('Y-m-d', strtotime(request()->month)));
    //     $monthText            = date('Y', strtotime($month)).date('m', strtotime($month));
    //     $groupCode            = request()->group_code;
    //     $department_code_from = request()->department_code_from;

    //     $keyWords  = explode(':' , request()->car_insurance);

    //     $count = count($keyWords);
        
        
    //     $data = PtirVehiclesView::selectRaw("location_code as value, location_code || ' : ' || location_description as label")
    //                                     // ->whereRaw("location_code > '{$department_code_from}'")
    //                                     // ->whereRaw("location_code > ? '{$department_code_from}'")
    //                                     ->where("location_code", ">", $department_code_from)
    //                                     ->when($monthText , function($m) use ($monthText) {
    //                                         $m->whereRaw("to_char(insurance_expire_date, 'YYYYMM')  = '{$monthText}'")
    //                                             ->orWhereRaw("to_char(license_plate_expire_date, 'YYYYMM')  = '{$monthText}'")
    //                                             ->orWhereRaw("to_char(acts_expire_date, 'YYYYMM')  = '{$monthText}'")
    //                                             ->orWhereRaw("to_char(car_inspection_expire_date, 'YYYYMM')  = '{$monthText}'");
    //                                     })
                                        
    //                                     ->when($groupCode , function($q) use ($groupCode ) {
    //                                         $q->where('group_code', $groupCode);
    //                                     })
    //                                     ->when($count , function($q) use ($keyWords) {
    //                                         $q->when($keyWords[1] == 'PTIR_RENEW_CAR_INSURANCES' , function($q) use ($keyWords) {
    //                                             $q->where('insurance_type_code', $keyWords[0]);
    //                                         })->when($keyWords[1] == 'PTIR_RENEW_CAR_ACT' , function($q) use ($keyWords) {
    //                                             $q->where('renew_car_act', $keyWords[0]);
    //                                         })->when($keyWords[1] == 'PTIR_RENEW_CAR_LICENSE_PLATE' , function($q) use ($keyWords) {
    //                                             $q->where('renew_car_license_plate', $keyWords[0]);
    //                                         })->when($keyWords[1] == 'PTIR_RENEW_CAR_INSPECTION' , function($q) use ($keyWords) {
    //                                             $q->where('renew_car_inspection', $keyWords[0]);
    //                                         });
    //                                     })
    //                                     // ->when($department_code_from , function($d) use ($department_code_from){
    //                                     //     $d->whereRaw("location_code > {$department_code_from}");
    //                                     // })
    //                                     ->orderBy('location_code', 'asc')
    //                                     ->get();

    //     // $data = clone  $xxx;
    //     // $data->whereRaw("value > '51020200'");
    //     // $data->where('value', '51020200')
    //     dd($data);
    //     return response()->json([
    //         'data'          => $data,
    //     ]);
    // }

    public function export($programCode, $request)
    {
        // dd($request->all());
        // dd('IRR0005_3Controller', request()->all());
        $data                 = [];
        $carInsurance         = [];
        $carAct               = [];
        $carLicense           = [];
        $carInspection        = [];
        $month                = request()->month_value;
        $group_code           = request()->group_code;
        $car_insurance        = request()->car_insurance;
        $department_code_from = request()->department_code_from;
        $department_code_to   = request()->department_code_to;
        $program_code         = request()->program_code;
        $function_name        = request()->function_name;
        $monthText            = date('Y', strtotime($month)).date('m', strtotime($month));

        $searchData = [
            'month'                => date('Y', strtotime($month)).date('m', strtotime($month)),
            'group_code'           => request()->group_code,
            'car_insurance'        => request()->car_insurance,
            'department_code_from' => request()->department_code_from,
            'department_code_to'   => request()->department_code_to,
        ];

        $car_insurance_key   = '';
        $car_insurance_value = '';
        $renewCarDesc = '';
        if ($car_insurance) {
            $arrayWord           = explode(":", $car_insurance);
            $car_insurance_key   = $arrayWord[0];
            $car_insurance_value = $arrayWord[1];
            
            
            $renewCar     = PtirRenewCarInsurancesView::where('lookup_type', $car_insurance_value)->where('lookup_code', $car_insurance_key)->first();
            $renewCarDesc = $renewCar ? $renewCar->description : '';
        }
        // dd($car_insurance, $arrayWord, $carInsurance, $renewCarDesc);

        $IdAll = PtirVehiclesView::whereRaw("to_char(insurance_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(license_plate_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(acts_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(car_inspection_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->get()
                                        ->pluck('vehicle_id');      
        $count = count($IdAll);;

        if ($count) {

            if ($group_code || $car_insurance || $department_code_from || $department_code_to) {

                $dataCheck = PtirVehiclesView::when($group_code, function($q) use ($group_code) {
                                            $q->where('group_code', $group_code);
                                        })->when($car_insurance, function($q) use ($car_insurance) {

                                            $arrayWord           = explode(":", $car_insurance);
                                            $car_insurance_key   = $arrayWord[0];
                                            $car_insurance_value = $arrayWord[1];

                                            if ($car_insurance_value == 'PTIR_RENEW_CAR_INSURANCES') {
                                                $q->where('insurance_type_code', $car_insurance_key);
                                            }

                                            if ($car_insurance_value == 'PTIR_RENEW_CAR_ACT') {
                                                $q->where('renew_car_act', $car_insurance_key);
                                            }

                                            if ($car_insurance_value == 'PTIR_RENEW_CAR_LICENSE_PLATE') {
                                                $q->where('renew_car_license_plate', $car_insurance_key);
                                            }

                                            if ($car_insurance_value == 'PTIR_RENEW_CAR_INSPECTION') {
                                                $q->where('renew_car_inspection', $car_insurance_key);
                                            }
                                        })
                                        ->when($department_code_from || $department_code_to, function($q) use ($department_code_from, $department_code_to) {
                                            if ($department_code_from && $department_code_to) {
                                                $q->whereBetween('location_code', [$department_code_from, $department_code_to]);
                                            } elseif ($department_code_from && !$department_code_to) {
                                                $q->where('location_code', $department_code_from);
                                            } elseif (!$department_code_from && $department_code_to) {
                                                $q->where('location_code', '<=', $department_code_to);
                                            }
                                        })
                                        ->whereIn('vehicle_id', $IdAll)
                                        ->get();

                $data = $dataCheck->groupBy('group_desc');
    
            }else{

                $dataCheck = PtirVehiclesView::when($group_code, function($q) use ($group_code) {
                    $q->where('group_code', $group_code);
                        
                })
                ->whereIn('vehicle_id', $IdAll)
                ->get();

                $data = PtirVehiclesView::whereRaw("to_char(insurance_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(license_plate_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(acts_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->orWhereRaw("to_char(car_inspection_expire_date, 'YYYYMM')  = '{$monthText}'")
                                        ->get()
                                        ->groupBy('group_desc');
            }
        }
        if ($renewCarDesc) {
            if ($car_insurance_value == 'PTIR_RENEW_CAR_INSURANCES') {
                $carInsurance  = $dataCheck->whereNotNull('insurance_type_desc')
                                            ->groupBy(['group_desc', 'insurance_type_desc', 'location_description', 'vehicle_type_name']);
            }

            if ($car_insurance_value == 'PTIR_RENEW_CAR_ACT') {
                $carAct = $dataCheck->whereNotNull('renew_car_act_desc')
                                    ->groupBy(['group_desc', 'renew_car_act_desc', 'location_description', 'vehicle_type_name']);
            }

            if ($car_insurance_value == 'PTIR_RENEW_CAR_LICENSE_PLATE') {
                $carLicense = $dataCheck->whereNotNull('renew_car_license_plate_desc')
                                        ->groupBy(['group_desc', 'renew_car_license_plate_desc', 'location_description', 'vehicle_type_name']);
            }

            if ($car_insurance_value == 'PTIR_RENEW_CAR_INSPECTION') {
                $carInspection = $dataCheck->whereNotNull('renew_car_inspection_desc')
                                            ->groupBy(['group_desc', 'renew_car_inspection_desc', 'location_description', 'vehicle_type_name']);
            }
        }else {
            $carInsurance  = $dataCheck->whereNotNull('insurance_type_desc')
                                        ->groupBy(['group_desc', 'insurance_type_desc', 'location_description', 'vehicle_type_name']);
            $carAct        = $dataCheck->whereNotNull('renew_car_act_desc')
                                        ->groupBy(['group_desc', 'renew_car_act_desc', 'location_description', 'vehicle_type_name']);
            $carLicense    = $dataCheck->whereNotNull('renew_car_license_plate_desc')
                                        ->groupBy(['group_desc', 'renew_car_license_plate_desc', 'location_description', 'vehicle_type_name']);
            $carInspection = $dataCheck->whereNotNull('renew_car_inspection_desc')
                                        ->groupBy(['group_desc', 'renew_car_inspection_desc', 'location_description', 'vehicle_type_name']);
        }

        $location = PtirVehiclesView::where('group_code', $group_code)->first();

        $thaimonths = ['01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม','06'=>'มิถุนายน',
                       '07'=>'กรกฎาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม'];

        $fileName = date('Ymdhms');

        $pdf = \PDF::loadView('ir.reports.irr0005-3.main_page',compact('data', 'programCode', 'thaimonths', 'month', 'location', 'renewCarDesc', 'carInsurance', 'carAct', 'carLicense', 'carInspection'))
                ->setOption('header-html',view('ir.reports.irr0005-3.header',compact('request', 'programCode', 'thaimonths', 'month', 'location', 'renewCarDesc', 'carInsurance', 'carAct', 'carLicense', 'carInspection')))
                ->setOption('margin-top','40')
                ->setOption('margin-bottom','25')
                ->setOption('encoding','UTF-8')
                ->setOption('lowquality', false)
                ->setOption('disable-javascript', true)
                ->setOption('disable-smart-shrinking', false)
                ->setOption('print-media-type', true)
                ->setPaper('a4');

        return $pdf->stream();
    }
}