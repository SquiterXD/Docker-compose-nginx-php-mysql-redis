<?php

namespace App\Http\Controllers\OM\Ajex\Saleorder\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\OM\Saleorder\Domestic\MonthlyDistributeModel;
use App\Models\OM\Saleorder\Domestic\SequenceEcomsModel;
use App\Models\OM\Saleorder\Domestic\ProductItemModel;
use App\Models\OM\Saleorder\Domestic\ProductCategoryCodeModel;
use App\Models\OM\Saleorder\Domestic\ProductTypeExportModel;
use App\Models\OM\Saleorder\Domestic\UomModel;

use App\Imports\OM\Saleorder\Domestic\MonthlyDistributeImport;
use Maatwebsite\Excel\Facades\Excel;

class MonthlyDistributeExportAjaxController extends Controller
{
    public function seachMonthly(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'budget_year'       => 'required',
            'version'           => 'required',
        ],[
            'budget_year.required'      => 'กรุณากรอกปีงบประมาณ',
            'version.required'          => 'กรุณากรอกครั้งที่',
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

            $data_head = MonthlyDistributeModel::where('ptom_monthly_sale_forecast.budget_year',$year)
                                            ->where('ptom_monthly_sale_forecast.version',$request->version)
                                            ->where('ptom_monthly_sale_forecast.sales_class_type','EXPORT')
                                            ->get();

            $data = MonthlyDistributeModel::where('ptom_monthly_sale_forecast.budget_year',$year)
                                            ->where('ptom_monthly_sale_forecast.version',$request->version)
                                            ->leftJoin('ptom_sequence_ecoms','ptom_sequence_ecoms.item_code','=','ptom_monthly_sale_forecast.item_code')
                                            ->where('ptom_sequence_ecoms.screen_number','!=','0')
                                            ->where('ptom_sequence_ecoms.start_date','<=',date('Y-m-d'))
                                            ->where('ptom_monthly_sale_forecast.sales_class_type','EXPORT')
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

            $data_list['month_header_sort'] = [
                '1' => [
                    '10' => monthname(10)
                ],
                '2' => [
                    '11' => monthname(11)
                ],
                '3' => [
                    '12' => monthname(12)
                ],
                '4' => [
                    '1' => monthname(1)
                ],
                '5' => [
                    '2' => monthname(2)
                ],
                '6' => [
                    '3' => monthname(3)
                ],
                '7' => [
                    '4' => monthname(4)
                ],
                '8' => [
                    '5' => monthname(5)
                ],
                '9' => [
                    '6' => monthname(6)
                ],
                '10' => [
                    '7' => monthname(7)
                ],
                '11' => [
                    '8' => monthname(8)
                ],
                '12' => [
                    '9' => monthname(9)
                ],
            ];

            foreach($data_head as $key_month => $month_item){
                $data_list['month_header'][$month_item->month_no] = monthname($month_item->month_no);
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


                $data_list['data'][$data_item->item_code][$data_item->month_no] = [
                    'quantity'      => number_format($data_item->quantity,2,'.',','),
                    'amount'        => number_format($data_item->amount,2,'.',','),
                    'monthly_id'    => $data_item->monthly_id,
                    'type'          => $data_item->sales_forecast_type
                ];

                if(!isset( $data_list['total_item'][$data_item->item_code])){
                    $data_list['total_item'][$data_item->item_code] = 0;
                }
                $data_list['total_item'][$data_item->item_code] += $data_item->quantity;

                if(!isset( $data_list['total_item_amount'][$data_item->item_code])){
                    $data_list['total_item_amount'][$data_item->item_code] = 0;
                }
                $data_list['total_item_amount'][$data_item->item_code] += $data_item->amount;

                if(!isset( $data_list['total'][$data_item->sales_forecast_type][$data_item->month_no])){
                    $data_list['total'][$data_item->sales_forecast_type][$data_item->month_no] = 0;
                }
                $data_list['total'][$data_item->sales_forecast_type][$data_item->month_no] += $data_item->quantity;

                if(!isset( $data_list['total_amount'][$data_item->sales_forecast_type][$data_item->month_no])){
                    $data_list['total_amount'][$data_item->sales_forecast_type][$data_item->month_no] = 0;
                }
                $data_list['total_amount'][$data_item->sales_forecast_type][$data_item->month_no] += $data_item->amount;

                if($data_item->approve_flag == 'Y'){
                    $approve['Y'] = 'Y';
                }elseif($data_item->approve_flag == 'N'){
                    $approve['N'] = 'N';
                }

                if($data_item->mfg_flag == 'Y'){
                    $factory['Y'] = 'Y';
                }elseif($data_item->mfg_flag == 'N'){
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

            if(MonthlyDistributeModel::where('monthly_id',$request->id)->update($update)){
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

    public function approve_Monthly(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'budget_year'   => 'required',
            'version'       => 'required',
            // 'approve_date'  => 'required',
        ],[
            'budget_year.required'      => 'กรุณากรอกปีงบประมาน',
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
            if(!empty($request->approve_date)){
                $year_ex    = \explode('/',$request->approve_date);
                $year_ap    = $year_ex[2] - 543;
                $newdate    = $year_ap.'-'.$year_ex[1].'-'.$year_ex[0];
            }

            $year       = $request->budget_year;
            $year       -= 543;

            $check      = MonthlyDistributeModel::where('budget_year',$year)->where('sales_class_type','EXPORT')->where('version',$request->version)->count();

            if($check > 0){
                DB::beginTransaction();
                try{
                    if($request->show == 'quantity'){
                        foreach($request->input_col_qunti as $key => $value){
                            $update = MonthlyDistributeModel::where('monthly_id',$key)->first();
                            $update->approve_flag      =  !empty($request->approve_date) ? 'Y' : 'N';  
                            $update->approve_date      =  !empty($request->approve_date) ? $newdate : '';    
                            $update->quantity          =  str_replace(',','',$value);
                            // $update->amount            =  $request->input_col_amount[$key];      
                            $update->remark            =  !empty($request->approve_note) ? $request->approve_note : '';
                            $update->last_updated_by   =  optional(auth()->user())->user_id;
                            $update->last_update_date  =  date('Y-m-d H:i:s');
                            $update->save();
                            // $update = [
                            //     'approve_flag'          => !empty($request->approve_date) ? 'Y' : 'N',
                            //     'approve_date'          => !empty($request->approve_date) ? $newdate : '',
                            //     'quantity'              => $value,
                            //     'amount'                => $request->input_col_amount[$key],
                            //     'remark'                => !empty($request->approve_note) ? $request->approve_note : '',
                            //     'last_updated_by'       => optional(auth()->user())->user_id,
                            //     'last_update_date'      => date('Y-m-d H:i:s'),
                            // ];
    
                            // MonthlyDistributeModel::where('monthly_id',$key)->update($update);
                        }
                    }else{
                        foreach($request->input_col_amount as $key => $value){
                            $update = MonthlyDistributeModel::where('monthly_id',$key)->first();
                            $update->approve_flag      =  !empty($request->approve_date) ? 'Y' : 'N';  
                            $update->approve_date      =  !empty($request->approve_date) ? $newdate : '';    
                            // $update->quantity          =  $value;
                            $update->amount            =  str_replace(',','',$value);      
                            $update->remark            =  !empty($request->approve_note) ? $request->approve_note : '';
                            $update->last_updated_by   =  optional(auth()->user())->user_id;
                            $update->last_update_date  =  date('Y-m-d H:i:s');
                            $update->save();
                            // $update = [
                            //     'approve_flag'          => !empty($request->approve_date) ? 'Y' : 'N',
                            //     'approve_date'          => !empty($request->approve_date) ? $newdate : '',
                            //     'quantity'              => $value,
                            //     'amount'                => $request->input_col_amount[$key],
                            //     'remark'                => !empty($request->approve_note) ? $request->approve_note : '',
                            //     'last_updated_by'       => optional(auth()->user())->user_id,
                            //     'last_update_date'      => date('Y-m-d H:i:s'),
                            // ];
    
                            // MonthlyDistributeModel::where('monthly_id',$key)->update($update);
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
                return response()->json(['data'=>$rest]);
            }
        }
    }

    public function sendFactory(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'budget_year'   => 'required',
            'version'       => 'required',
            // 'approve_date'  => 'required',
        ],[
            'budget_year.required'      => 'กรุณากรอกปีงบประมาน',
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
            $year_ex    = \explode('/',$request->approve_date);
            $year_ap    = $year_ex[2] - 543;
            $date       = $year_ap.'-'.$year_ex[1].'-'.$year_ex[0];

            $year       = $request->budget_year;
            $year       -= 543;

            $update = [
                'mfg_flag'              => 'Y',
                'mfg_date'              => date('Y-m-d'),
                'last_updated_by'       => optional(auth()->user())->user_id,
                'last_update_date'      => date('Y-m-d H:i:s'),
            ];

            if(MonthlyDistributeModel::where('budget_year',$year)->where('sales_class_type','EXPORT')->where('version',$request->version)->update($update)){

                if($request->version != '1'){
                    $update_old = [
                        'mfg_flag'              => 'C',
                        'mfg_date'              => date('Y-m-d'),
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d H:i:s'),
                    ];
                    MonthlyDistributeModel::where('budget_year',$year)->where('sales_class_type','EXPORT')->where('version','<',$request->version)->update($update_old);
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

    public function versionListMonthly(Request $request)
    {
        $year = $request->year;
        $year -= 543;

        $list = MonthlyDistributeModel::select('version','approve_flag','mfg_flag')
                                        ->where('budget_year',$year)
                                        ->where('sales_class_type','EXPORT')
                                        ->groupBy('version','approve_flag','mfg_flag')
                                        ->orderBy('version','asc')
                                        ->get();

        foreach($list as $monthly_item){

            if($monthly_item->approve_flag == 'Y'){
                $approve_arr['Y'] = 'Y';
            }elseif($monthly_item->approve_flag == 'N'){
                $approve_arr['N'] = 'N';
            }

            if($monthly_item->mfg_flag == 'Y'){
                $factory['Y'] = 'Y';
            }elseif($monthly_item->mfg_flag == 'N'){
                $factory['N'] = 'N';
            }elseif($monthly_item->mfg_flag == 'C'){
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

            $data_list[$monthly_item->version] = [
                'version'   => $monthly_item->version,
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
