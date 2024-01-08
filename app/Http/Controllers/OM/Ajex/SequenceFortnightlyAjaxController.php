<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Models\OM\SequenceEcoms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SequenceFortnightlyAjaxController extends Controller
{
    public function sequenceEcoms()
    {
        $sequenceEcoms = DB::table('ptom_sequence_ecoms as se')
        ->join('ptom_taste_v as t', 't.value', '=', 'se.taste_code')
        ->whereRaw("nvl(se.start_date,sysdate+1) < sysdate")
        ->whereRaw("nvl(se.end_date,sysdate+1) > sysdate")
        ->orderBy('se.forecast_screen_no','asc')
        ->get(['se.sequence_ecom_id', 'se.item_code', 'se.item_description', 'se.forecast_screen_no', 'se.forecast_stamp', 'se.filter_flag', 'se.taste_code', 't.description']);

        foreach ($sequenceEcoms as $key => $value) {
            $value->filter_flag = $value->filter_flag == 'Y' ? 'มีก้นกรอง' : 'ไม่มีก้นกรอง';
        }

        // echo '<pre>';
        // print_r($sequenceEcoms);
        // echo '</pre>';
        // exit();

        return response()->json(['data'=>$sequenceEcoms]);
    }

    public function updateSequenceEcoms(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $validate = Validator::make($request->all(),[
            'forecast_screen_no' => 'required|min:1',
            'forecast_stamp'         => 'required|array',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            if(!empty($request->sequence_ecom_id)){
                foreach ($request->sequence_ecom_id as $key => $value) {
                    $update = [
                        'forecast_screen_no'     => $request->forecast_screen_no[$key],
                        'forecast_stamp'             => $request->forecast_stamp[$key],
                        'program_code'      => 'OMP0053',
                        'last_updated_by'   => optional(auth()->user())->user_id,
                        'last_update_date'  => date('Y-m-d H:i:s'),
                    ];

                    // echo '<pre>';
                    // print_r($update);
                    // echo '<pre>';
                    // exit();

                    SequenceEcoms::where('sequence_ecom_id', $value)->update($update);


                }

                $dataList = DB::table('ptom_sequence_ecoms as se')
                ->join('ptom_taste_v as t', 't.value', '=', 'se.taste_code')
                ->where(function($query) use($request) {
                    if(!empty($request->sale_type_code == 1)) {
                        $query->where('se.sale_type_code', 'DOMESTIC');
                    }
                    if(!empty($request->sale_type_code == 2)) {
                        $query->where('se.sale_type_code', 'EXPORT');
                    }
                })
                ->whereRaw("nvl(se.start_date,sysdate+1) < sysdate")
                ->whereRaw("nvl(se.end_date,sysdate+1) > sysdate")
                ->whereNull('se.deleted_at')
                ->orderBy('se.forecast_screen_no','asc')
                ->get(['se.sequence_ecom_id', 'se.item_code', 'se.item_description', 'se.forecast_screen_no', 'se.forecast_stamp', 'se.filter_flag', 'se.taste_code', 't.description']);

                foreach ($dataList as $key => $value) {
                    $value->filter_flag = $value->filter_flag == 'Y' ? 'มีก้นกรอง' : 'ไม่มีก้นกรอง';
                }

                $rest = [
                    'status'    => true,
                    'data'      => 'Success',
                    'dataList'  => $dataList
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }

            // echo '<pre>';
            // print_r($request->item_id);
            // echo '<pre>';
            // exit();
        }

        return response()->json(['data' => $rest]);
    }

    public function deleteSequenceEcoms(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        if(!empty($request->sequence_ecom_id)){
            foreach ($request->sequence_ecom_id as $key => $value) {

                if(!empty($request->select_sequence[$key])){
                    $delete = [
                        'sequence_ecom_id'  => $value,
                        'program_code'      => 'OMP0053',
                        'deleted_at'        => date('Y-m-d H:i:s'),
                        'deleted_by_id'     => optional(auth()->user())->user_id,
                    ];

                    // echo '<pre>';
                    // print_r($delete);
                    // echo '<pre>';
                    // exit();

                    SequenceEcoms::where('sequence_ecom_id', $value)->update($delete);
                }


            }

            $dataList = DB::table('ptom_sequence_ecoms as se')
            ->join('ptom_taste_v as t', 't.value', '=', 'se.taste_code')
            ->where(function($query) use($request) {
                if(!empty($request->sale_type_code == 1)) {
                    $query->where('se.sale_type_code', 'DOMESTIC');
                }
                if(!empty($request->sale_type_code == 2)) {
                    $query->where('se.sale_type_code', 'EXPORT');
                }
            })
            ->whereRaw("nvl(se.start_date,sysdate+1) < sysdate")
            ->whereRaw("nvl(se.end_date,sysdate+1) > sysdate")
            ->whereNull('se.deleted_at')
            ->orderBy('se.forecast_screen_no','asc')
            ->get(['se.sequence_ecom_id', 'se.item_code', 'se.item_description', 'se.forecast_screen_no', 'se.forecast_stamp', 'se.filter_flag', 'se.taste_code', 't.description']);

            foreach ($dataList as $key => $value) {
                $value->filter_flag = $value->filter_flag == 'Y' ? 'มีก้นกรอง' : 'ไม่มีก้นกรอง';
            }

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }

        // echo '<pre>';
        // print_r($request->item_id);
        // echo '<pre>';
        // exit();

        return response()->json(['data' => $rest]);
    }

    public function filterSequenceEcoms(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $dataList = DB::table('ptom_sequence_ecoms as se')
                ->join('ptom_taste_v as t', 't.value', '=', 'se.taste_code')
                ->where(function($query) use($request) {
                    if(!empty($request->sale_type_code == 1)) {
                        $query->where('se.sale_type_code', 'DOMESTIC');
                    }
                    if(!empty($request->sale_type_code == 2)) {
                        $query->where('se.sale_type_code', 'EXPORT');
                    }
                })
                ->whereRaw("nvl(se.start_date,sysdate+1) < sysdate")
                ->whereRaw("nvl(se.end_date,sysdate+1) > sysdate")
                ->whereNull('se.deleted_at')
                ->orderBy('se.forecast_screen_no','asc')
                ->get(['se.sequence_ecom_id', 'se.item_code', 'se.item_description', 'se.forecast_screen_no', 'se.forecast_stamp', 'se.filter_flag', 'se.taste_code', 't.description']);

        foreach ($dataList as $key => $value) {
            $value->filter_flag = $value->filter_flag == 'Y' ? 'มีก้นกรอง' : 'ไม่มีก้นกรอง';
        }

        $rest = [
            'status'    => true,
            'data'      => 'Success',
            'dataList'  => $dataList
        ];
      return response()->json(['data' => $rest]);
    }
}
