<?php

namespace App\Http\Controllers\Report\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IR\Settings\PtirReportInfos;
use App\Models\ProgramInfo;
use Attribute;
use DB;
class ReportsController extends Controller
{
    public function getReportProgram()
    {
        // dd(request()->all());
        $profile            = getDefaultData(\Request::path());
        $db                 = \DB::connection('oracle')->getDatabaseName();
        $modules            = collect(request()->module);
        $allModule          = $modules[0] =="null";
        $query              = request()->uQuery;
        if ($db !=  "DEV") {
            $roles              = \App\Models\Role::whereIn('role_id', auth()->user()->role_options)
            ->pluck('module_name');
        }else{
            $roles = null;
        }  
        // dd(request()->all());
        $programs           =     ProgramInfo::selectRaw('program_code, description, program_type_name,module_name')
                                            ->where('program_type_name', 'R1')
                                            ->when(!$allModule, function($q) use ($modules) {
                                                $q->whereIn('module_name', $modules);
                                            })
                                            ->when($roles && $db != 'DEV', function($q) use ($roles) {
                                                return $q->whereIn('module_name',$roles);
                                            })
                                            ->where(function($q) use ($query) { 
                                                $q->where(\DB::raw('lower(program_code)'), 'LIKE', '%' . strtolower($query) . '%')
                                                    ->orWhere(\DB::raw('lower(description)'), 'LIKE', '%' . strtolower($query) . '%');
                                            })
                                            ->where('enable_flag', 'Y')
                                            ->orderBy('program_code')
                                            ->limit(30)
                                            ->get()
                                            ->mapWithKeys(function ($item, $key) {
                                                return [$item['program_code'] => $item];
                                            });

        return response()->json([
                'programs'          => $programs ,
            ]);
    }

    public function getInfo()
    {
        $q = request()->query;
        $ptirReportInfos = PtirReportInfos::selectRaw('program_code, description,program_type_name')
                            ->get();
        // $programs =     ProgramInfo::where('program_type_name', 'R1')
        //                 ->get();

        return response()->json([
                'ptirReportInfos' =>  $ptirReportInfos->groupBy('program_code'),
                // 'programs'          => $programs ,
            ]);
    }

    public function getInfoAttribute()
    {
        // dd('xxx');
        $programCode = request()->program_code;

        $ptirReportInfos = PtirReportInfos::where('program_code' , $programCode)
                            ->orderBy('seq')
                            ->get();

        // $programs           =     ProgramInfo::selectRaw('program_code, description, program_type_name,module_name')
        //                     ->where('program_type_name', 'R1')
        //                     ->where('program_code', $programCode)
        //                     ->orderBy('program_code')
        //                     ->limit(30)
        //                     ->get()
        //                     ->mapWithKeys(function ($item, $key) {
        //                         return [$item['program_code'] => $item];
        //                     });
        return response()->json([
                'reportInfor' =>  $ptirReportInfos,
                // 'programs'     => $programs
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

    public function getSubQuery()
    {
        $request = request();
        $reportInfos =  PtirReportInfos::whereIn('report_info_id', $request->ids)
                        ->get();

        if(!$reportInfos){
            return response()->json([
                'reportInfos' =>  []
            ]);
        }

        foreach ($reportInfos as $key => $info) {
            $subQuery = [];
            if ($info->attribute_7 == 'where') {
                $subQuery = $this->qWhere($info, $request);    
            }

            if($info->attribute_7 == 'whereBetween'){
                $subQuery = $this->qWhereBetween($info, $request);
            }

            $info->new_lists = $subQuery;

        }
        return response()->json([
            'reportInfos' =>  $reportInfos,
            // 'programs'     => $programs
        ]);

    }

    public function qWhere($info, $request)
    {
        $subQuery = [];
        $field =  $info->option_1["to_field"] ?? false;
        if($field){
            $subQuery = collect(DB::select($info->view_or_table))->where($field, $request->value);
        }
         else {
            $subQuery = collect(DB::select($info->view_or_table));
        }

        return $subQuery;
    }

    public function qWhereBetween($info, $request)
    {
        $subQuery = [];
        $field =  $info->option_2["to_field"] ?? false;

        if($field){
            if($request->value_start && !$request->value_end){
                $subQuery = collect(DB::select($info->view_or_table))->where($field, '>=', $request->value_start);
            }
            if($request->value_end && !$request->value_end){
                $subQuery = collect(DB::select($info->view_or_table))->where($field, '<=', $request->value_end);
            }

            if($request->value_end && $request->value_end){
                // dd('xxxxxxxxxxxxxxxx');
                $subQuery = collect(DB::select($info->view_or_table))->whereBetween($field, [$request->value_start , $request->value_end]);
            }

        }
         else {
            $subQuery = collect(DB::select($info->view_or_table));
        }

        return $subQuery;
    }
}
