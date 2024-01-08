<?php

namespace App\Http\Controllers\PD\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PD\GradeRepresentationV;
use App\Models\PD\MedicinalLeafTypeHV;

class PDR0005Controller extends Controller
{
    public function export($programCode, $request)
    {
        if($request->Date_from && $request->Date_from == 'Invalid date'){
            return back()->withErrors('กรุณาเลือก วันที่เริ่มต้น');
        }   

        if($request->Date_to && $request->Date_to == 'Invalid date'){
            return back()->withErrors('กรุณาเลือก วันที่สิ้นสุด');
        }   

        if($request->Date_from && $request->Date_from != 'Invalid date' && $request->Date_to && $request->Date_to != 'Invalid date'){
            $data = GradeRepresentationV::whereRaw("TRUNC(date_instead_grades) BETWEEN TO_DATE('{$request->Date_from}', 'dd/mm/YYYY') AND TO_DATE('{$request->Date_to}', 'dd/mm/YYYY')")
                                        ->get();
                                        
            $data->map(function ($item, $key) {
                $item['approved_date']          = parseToDateTh($item['approved_date']);
                $item['date_instead_grades']    = parseToDateTh($item['date_instead_grades']);
            });
        }else{
            if($request->Date_from && $request->Date_from != 'Invalid date'){
                $data = GradeRepresentationV::whereRaw("TRUNC(date_instead_grades) >= TO_DATE('{$request->Date_from}', 'dd/mm/YYYY')")
                                            ->get();
            }else{
                if($request->Date_to && $request->Date_to != 'Invalid date'){
                    $data = GradeRepresentationV::whereRaw("TRUNC(date_instead_grades) <= TO_DATE('{$request->Date_to}', 'dd/mm/YYYY')")
                                            ->get();
                }
            }

            $data->map(function ($item, $key) {
                $item['approved_date']          = parseToDateTh($item['approved_date']);
                $item['date_instead_grades']    = parseToDateTh($item['date_instead_grades']);
            });
        }

        $medicinalLeafDomestic  = MedicinalLeafTypeHV::where('category_code_1', '1001')->first();
        $medicinalLeafExport    = MedicinalLeafTypeHV::where('category_code_1', '1002')->first();

        $dataHeader = compact('programCode');
        $dataIndex  = compact('programCode', 'data', 'medicinalLeafDomestic', 'medicinalLeafExport');
        
        $html = view('pd.reports.PDR0005.index', $dataIndex)->render();
        return \PDF::loadHTML($html)
                    ->setPaper('a4')
                    ->setOption('header-html', 
                        view('pd.reports.PDR0005.header', $dataHeader)->render())
                    ->setOrientation('landscape')
                    ->setOption('margin-top', '30')
                    ->setOption('margin-left', '0.7cm')
                    ->setOption('margin-right', '0.7cm')
                    ->setOption('header-spacing', 5)
                    ->inline();
    }
}
