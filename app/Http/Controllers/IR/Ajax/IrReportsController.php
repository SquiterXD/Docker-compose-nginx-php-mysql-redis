<?php

namespace App\Http\Controllers\IR\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IR\Settings\PtirReportInfos;
use App\Models\ProgramInfo;

use DB;
class IrReportsController extends Controller
{
    public function getInfo()
    {
        $q = request()->query;

        $ptirReportInfos = PtirReportInfos::get();
        $programs =     ProgramInfo::where('program_type_name', 'R1')
                        ->orderBy('program_code')
                        ->get();

        return response()->json([
                'ptirReportInfos' =>  $ptirReportInfos->groupBy('program_code'),
                'programs'          => $programs ,
            ]);
    }

    public function getInfoAttribute()
    {
        // dd('xxx');
        $programCode = request()->program_code;

        $ptirReportInfos = PtirReportInfos::where('program_code' , $programCode)
                            ->element()
                            ->orderBy('seq')
                            ->get();
        // dd($ptirReportInfos);
        $functionName   = PtirReportInfos::where('program_code' , $programCode)
                        ->function()
                        ->orderBy('seq')
                        ->first();


        
        $programs           =     ProgramInfo::selectRaw('program_code, description, program_type_name,module_name')
                            ->where('program_type_name', 'R1')
                            ->where('program_code', $programCode)
                            ->orderBy('program_code')
                            ->limit(30)
                            ->get()
                            ->mapWithKeys(function ($item, $key) {
                                return [$item['program_code'] => $item];
                            });
        
        return response()->json([
                'reportInfor' =>  $ptirReportInfos,
                'functionName'  => $functionName ? $functionName->function : null,
                'functionReport'  => $functionName,
                'programs'      => $programs
            ]);
    }

    public function getParam()
    {
        $code =  request()->program_code;
        dd(substr($code, 0 ,2));

        // return  substr($txt, 2 ,3)
    }

    public function irReportSubmit()
    {
        // $request = request()->all();

        $code =  request()->program_code;
        dd(substr($code, 0 ,2));
    }


}
