<?php

namespace App\Http\Controllers\OM\Ajex\Saleorder\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\OM\Saleorder\Domestic\YearDistributeModel;
use App\Models\OM\Saleorder\Domestic\SequenceEcomsModel;
use App\Models\OM\Saleorder\Domestic\ProductItemModel;
use App\Models\OM\Saleorder\Domestic\ProductCategoryCodeModel;
use App\Models\OM\Saleorder\Domestic\ProductTypeExportModel;
use App\Models\OM\Saleorder\Domestic\UomModel;

use App\Imports\OM\Saleorder\Domestic\YearDistributeImport;
use Maatwebsite\Excel\Facades\Excel;

class YearDistributeExportAjaxController extends Controller
{
    public function seachYear(Request $request){

        $validate = Validator::make($request->all(),[
            'budget_year'       => 'required',
            'version'           => 'required',
            'budget_year_to'    => 'required',
        ],[
            'budget_year.required'      => 'กรุณากรอกปีงบประมาณ',
            'version.required'          => 'กรุณากรอกครั้งที่',
            'budget_year_to.required'   => 'กรุณากรอกปีงบประมาณสิ้นสุด',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json(['data'=>$rest]);
        }else{

            $year = $request->budget_year;
            $year -= 543;

            $year_to = $request->budget_year_to;
            $year_to -= 543;

            $data = YearDistributeModel::where('ptom_yearly_sales_forecast.budget_year','>=',$year)
                                        ->where('ptom_yearly_sales_forecast.budget_year','<=',$year_to)
                                        ->where('ptom_yearly_sales_forecast.version',$request->version)
                                        ->where('ptom_yearly_sales_forecast.sales_class_type','EXPORT')
                                        ->leftJoin('ptom_sequence_ecoms','ptom_sequence_ecoms.item_code','=','ptom_yearly_sales_forecast.item_code')
                                        ->where('ptom_sequence_ecoms.screen_number','!=','0')
                                        ->where('ptom_sequence_ecoms.start_date','<=',date('Y-m-d'))
                                        ->where(function ($query) {
                                            $query->where('ptom_sequence_ecoms.end_date','>=',date('Y-m-d'));
                                            $query->orWhereNull('ptom_sequence_ecoms.end_date');
                                        })
                                        ->orderBy('ptom_sequence_ecoms.screen_number','asc')
                                        ->get();

            $producttype = ProductTypeExportModel::all();
            $uom = UomModel::all();

            foreach($uom as $item_uom){
                $data_uom[$item_uom->uom_code] = [
                    'uom'               => $item_uom->uom_code,
                    'description'       => $item_uom->description,
                ];
            }

            foreach($producttype as $producttype_item){
                if(!empty($producttype_item->tag)){
                    $data_list['producttype'][$producttype_item->lookup_code] = [
                        'description'   => $producttype_item->description.' ('.$data_uom[$producttype_item->tag]['description'].')',
                    ];
                }
            }

            foreach($data as $id_item){
                $list_code[] = $id_item->item_code;
            }

            $cate_code = ProductCategoryCodeModel::all();
            foreach($cate_code as $item_cate_code){
                $cate_list[$item_cate_code->lookup_code] = [
                    'description'   => $item_cate_code->description
                ];
            }

            foreach($data as $key_year => $year_item){
                $data_list['year_header'][$year_item->budget_year] = $year_item->budget_year + 543;
            }

            foreach($data as $key_item => $data_item){

                $taste_code = SequenceEcomsModel::where('item_code',$data_item->item_code)->first();
                if(!empty($taste_code)){
                    $taste = DB::table('ptom_taste_v')->where('value',$taste_code->taste_code)->first();
                }else{
                    $taste = '';
                }

                $data_list['item'][$data_item->item_code] = [
                    'item_code'         => $data_item->item_code,
                    'item_description'  => $data_item->item_description,
                    'taste'             => !empty($taste->description)? $taste->description : 'ไม่ระบุ',
                    'type'              => !empty($taste_code->filter_flag)? ($taste_code->filter_flag == 'Y')? 'มีก้นกรอง' : 'ไม่มีก้นกรอง' : '',
                    'approve'           => $data_item->approve_flag
                ];

                if(!empty($data_item->approve_date)){
                    $date = \explode(' ',$data_item->approve_date);
                    $date_th = explode('-',$date[0]);
                    $year = $date_th[0];
                    $year += 543;

                    $data_list['detail'] = [
                        'approve'   => $date_th[2].'/'.$date_th[1].'/'.$year,
                        'remark'    => $data_item->remark
                    ];

                }else{
                    $data_list['detail'] = 'false';
                }


                $data_list['data'][$data_item->item_code][$data_item->budget_year] = [
                    'quantity'      => number_format($data_item->quantity,2,'.',','),
                    'amount'        => number_format($data_item->amount,2,'.',','),
                    'yearly_id'     => $data_item->yearly_id,
                    'approve'       => $data_item->approve_flag,
                    'type'          => $data_item->sales_forecast_type
                ];

                if(!isset( $data_list['total'][$data_item->sales_forecast_type][$data_item->budget_year])){
                    $data_list['total'][$data_item->sales_forecast_type][$data_item->budget_year] = 0;
                }
                $data_list['total'][$data_item->sales_forecast_type][$data_item->budget_year] += $data_item->quantity;

                if(!isset( $data_list['total_amount'][$data_item->sales_forecast_type][$data_item->budget_year])){
                    $data_list['total_amount'][$data_item->sales_forecast_type][$data_item->budget_year] = 0;
                }
                $data_list['total_amount'][$data_item->sales_forecast_type][$data_item->budget_year] += $data_item->amount;

                if($data_item->approve_flag == 'Y'){
                    $approve['Y'] = 'Y';
                }elseif($data_item->approve_flag == 'N'){
                    $approve['N'] = 'N';
                }else{
                    $approve['N'] = 'N';
                }

                if($data_item->mfg_flag == 'Y'){
                    $factory['Y'] = 'Y';
                }elseif($data_item->mfg_flag == 'N'){
                    $factory['N'] = 'N';
                }else{
                    $factory['N'] = 'N';
                }

                if(!empty($approve['Y']) && !empty($approve['N'])){
                    $data_list['approve']   = 'อนุมัติ/ไม่อนุมัติ';
                    $data_list['app_color'] = 'text-warning';
                }elseif(!empty($approve['Y']) && !empty($factory['N'])){
                    $data_list['approve']   = 'อนุมัติ';
                    $data_list['app_color'] = 'text-success';
                }elseif(!empty($approve['N']) && !empty($factory['N'])){
                    $data_list['approve']   = 'ไม่อนุมัติ';
                    $data_list['app_color'] = 'text-danger';
                }elseif(!empty($approve['Y']) && !empty($factory['Y'])){
                    $data_list['approve']   = 'ส่งข้อมูลแล้ว';
                    $data_list['app_color'] = 'text-info';
                }

            }

            if($data->count() > 0){
                $rest = [
                    'status'    => true,
                    'data'      => $data_list,
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => []
                ];
            }
            return response()->json(['data' => $rest]);
        }
    }

    public function saveValue(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'quantity'  => 'required',
        ],[
            'quantity.required'     => 'กรุณากรอกจำนวน',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json(['data'=>$rest]);
        }else{
            $update = [
                'quantity'              => $request->quantity,
                'last_updated_by'       => optional(auth()->user())->user_id,
                'last_update_date'      => date('Y-m-d H:i:s'),
            ];

            if(YearDistributeModel::where('yearly_id',$request->id)->update($update)){
                $rest = [
                    'status'    => true,
                    'message'   => 'success'
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'message'   => 'Error'
                ];
            }

            return response()->json($rest);
        }
    }

    public function approve_Yearly(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'budget_year'       => 'required',
            'budget_year_to'    => 'required',
            'version'           => 'required',
            // 'approve_date'      => 'required',
        ],[
            'budget_year.required'      => 'กรุณากรอกปีงบประมาน',
            'budget_year_to.required'   => 'กรุณากรอกปีงบประมานสิ้นสุด',
            'version.required'          => 'กรุณากรอกครั้งที่',
            // 'approve_date.required'     => 'กรุณาเลือกวันที่อนุมัติ',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json(['data'=>$rest]);
        }else{
            try {
                if(!empty($request->approve_date)){
                    $year_ex    = \explode('/',$request->approve_date);
                    $year_ap    = $year_ex[2] - 543;
                    $newdate    = $year_ap.'-'.$year_ex[1].'-'.$year_ex[0];
                }

                $year       = $request->budget_year;
                $year       -= 543;

                $year_to       = $request->budget_year_to;
                $year_to       -= 543;

                $check      = YearDistributeModel::where('budget_year','>=',$year)->where('sales_class_type','EXPORT')->where('budget_year','<=',$year_to)->where('version',$request->version)->count();

                if($check > 0){

                    DB::beginTransaction();
                    try{
                        if($request->show == 'quantity'){
                            foreach($request->input_col_qunti as $key => $value){
                                $update = [
                                    'approve_flag'          => !empty($request->approve_date) ? 'Y' : 'N',
                                    'approve_date'          => !empty($request->approve_date) ? $newdate : '',
                                    'quantity'              => str_replace(',','',$value),
                                    // 'amount'                => $request->input_col_amount[$key],
                                    'remark'                => !empty($request->approve_note) ? $request->approve_note : '',
                                    'last_updated_by'       => optional(auth()->user())->user_id,
                                    'last_update_date'      => date('Y-m-d H:i:s'),
                                ];
                            
                                YearDistributeModel::where('yearly_id',$key)->update($update);
                            }
                        }else{
                            foreach($request->input_col_amount as $key => $value){
                                $update = [
                                    'approve_flag'          => !empty($request->approve_date) ? 'Y' : 'N',
                                    'approve_date'          => !empty($request->approve_date) ? $newdate : '',
                                    // 'quantity'              => $value,
                                    'amount'                => str_replace(',','',$value),
                                    'remark'                => !empty($request->approve_note) ? $request->approve_note : '',
                                    'last_updated_by'       => optional(auth()->user())->user_id,
                                    'last_update_date'      => date('Y-m-d H:i:s'),
                                ];
                            
                                YearDistributeModel::where('yearly_id',$key)->update($update);
                            }
                        }
                        DB::commit();
                        $rest = [
                            'status'    => true,
                            'data'      => 'success'
                        ];
                        return response()->json(['data'=>$rest]);
                    }catch (\Exception $e) {
                        DB::rollBack();
    
                        $rest = [
                            'status'    => false,
                            'data'      => $e->getMessage()
                        ];
    
                        return response()->json(['data'=>$rest]);
                    }

                }else{
                    $rest = [
                        'status'    => false,
                        'message'   => 'ไม่พบข้อมูลที่อนุมัติ'
                    ];
                }
            } catch (\Exception  $em) {
                $rest = [
                    'status'    => false,
                    'message'   => 'ผิดผลาด',
                    'data'      => $em->getMessage()
                ];
            }

            return response()->json(['data'=>$rest]);
        }
    }

    public function sendFactory(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'budget_year'       => 'required',
            'version'           => 'required',
            'budget_year_to'    => 'required',
        ],[
            'budget_year.required'      => 'กรุณากรอกปีงบประมาน',
            'version.required'          => 'กรุณากรอกครั้งที่',
            'budget_year_to.required'   => 'กรุณากรอกปีงบประมานสิ้นสุด',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json(['data'=>$rest]);
        }else{

            $year       = $request->budget_year;
            $year       -= 543;

            $year_to    = $request->budget_year_to;
            $year_to    -= 543;

            $update = [
                'mfg_flag'              => 'Y',
                'mfg_date'              => date('Y-m-d'),
                'last_updated_by'       => optional(auth()->user())->user_id,
                'last_update_date'      => date('Y-m-d H:i:s'),
            ];

            if(YearDistributeModel::where('budget_year','>=',$year)->where('sales_class_type','EXPORT')->where('budget_year','<=',$year_to)->where('version',$request->version)->update($update)){

                if($request->version != '1'){
                    $update_old = [
                        'mfg_flag'              => 'C',
                        'mfg_date'              => date('Y-m-d'),
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d H:i:s'),
                    ];
                    YearDistributeModel::where('budget_year','>=',$year)->where('sales_class_type','EXPORT')->where('budget_year','<=',$year_to)->where('version','<',$request->version)->update($update_old);
                }

                $rest = [
                    'status'    => true,
                    'message'   => 'success'
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'message'   => 'Error'
                ];
            }
            return response()->json(['data'=>$rest]);
        }
    }

    public function versionListYear(Request $request)
    {
        $year = $request->year;
        $year -= 543;

        $year_to = $request->year_to;
        $year_to -= 543;

        $list = YearDistributeModel::select('version','approve_flag','mfg_flag')
                                    ->where('sales_class_type','EXPORT')
                                    ->where('budget_year','>=',$year)
                                    ->where('budget_year','<=',$year_to)
                                    ->groupBy('version','approve_flag','mfg_flag')
                                    ->orderBy('version','asc')
                                    ->get();

        foreach($list as $yeardis_item){

            if($yeardis_item->approve_flag == 'Y'){
                $approve_arr['Y'] = 'Y';
            }elseif($yeardis_item->approve_flag == 'N'){
                $approve_arr['N'] = 'N';
            }

            if($yeardis_item->mfg_flag == 'Y'){
                $factory['Y'] = 'Y';
            }elseif($yeardis_item->mfg_flag == 'N' || empty($yeardis_item->mfg_flag)){
                $factory['N'] = 'N';
            }elseif($yeardis_item->mfg_flag == 'C'){
                $factory['C'] = 'C';
            }

            $approve = '';
            if(!empty($approve_arr['Y']) && !empty($approve_arr['N']) && empty($factory['C'])){
                $approve   = 'อนุมัติ/ไม่อนุมัติ';
            }elseif(!empty($approve_arr['Y']) && !empty($factory['N']) && empty($factory['C'])){
                $approve   = 'อนุมัติ';
            }elseif(!empty($approve_arr['N']) && !empty($factory['N']) && !empty($factory['C'])){
                $approve   = 'ไม่อนุมัติ';
            }elseif(!empty($approve_arr['Y']) && !empty($factory['Y'])){
                $approve   = 'ส่งข้อมูลแล้ว';
            }elseif(!empty($approve_arr['Y']) && !empty($factory['C'])){
                $approve   = 'ยกเลิกการส่งข้อมูลแล้ว';
            }

            $data_list[$yeardis_item->version] = [
                'version'   => $yeardis_item->version,
                'approve'   => $approve
            ];
        }

        if($list){
            $rest = [
                'status'    => true,
                'data'      => $data_list,
            ];
        }else{
            $rest = [
                'status' => false,
                'data' => 'No Data'
            ];
        }
        return response()->json($rest);
    }
}
