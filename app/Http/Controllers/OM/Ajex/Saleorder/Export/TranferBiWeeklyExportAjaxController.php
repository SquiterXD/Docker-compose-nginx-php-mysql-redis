<?php

namespace App\Http\Controllers\OM\Ajex\Saleorder\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\OM\Saleorder\Domestic\TransferBiWeeklyModel;
use App\Models\OM\Saleorder\Domestic\BiWeeklyPeriodsModel;
use App\Models\OM\Saleorder\Domestic\SequenceEcomsModel;
use App\Models\OM\Saleorder\Domestic\ProductItemModel;
use App\Models\OM\Saleorder\Domestic\ProductCategoryCodeModel;
use App\Models\OM\Saleorder\Domestic\ProductTypeExportModel;
use App\Models\OM\Saleorder\Domestic\UomModel;

use App\Imports\OM\Saleorder\Domestic\TransferBiWeeklyImportController;
use Maatwebsite\Excel\Facades\Excel;

class TranferBiWeeklyExportAjaxController extends Controller
{

    public function seachBiWeekly(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'budget_year'       => 'required',
            'version'           => 'required',
            'biweekly_no'       => 'required',
            'biweekly_to'       => 'required',
        ],[
            'budget_year.required'      => 'กรุณากรอกปีงบประมาณ',
            'version.required'          => 'กรุณากรอกครั้งที่',
            'biweekly_no.required'      => 'กรุณากรอกปักษ์ที่',
            'biweekly_to.required'      => 'กรุณากรอกถึงปักษ์ที่',
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

            $data = TransferBiWeeklyModel::leftJoin('ptom_sequence_ecoms','ptom_sequence_ecoms.item_code','=','ptom_sales_forecast.item_code')
                                            ->where('ptom_sequence_ecoms.screen_number','!=','0')
                                            ->where('ptom_sequence_ecoms.start_date','<=',date('Y-m-d'))
                                            ->where(function ($query) {
                                                $query->where('ptom_sequence_ecoms.end_date','>=',date('Y-m-d'));
                                                $query->orWhereNull('ptom_sequence_ecoms.end_date');
                                            })
                                            ->where('ptom_sales_forecast.budget_year',$year)
                                            ->where('ptom_sales_forecast.version',$request->version)
                                            ->where('ptom_sales_forecast.biweekly_no','>=',$request->biweekly_no)
                                            ->where('ptom_sales_forecast.biweekly_no','<=',$request->biweekly_to)
                                            ->where('ptom_sales_forecast.sales_class_type','EXPORT')
                                            ->orderBy('ptom_sequence_ecoms.forecast_screen_no','asc')
                                            ->get();

            $biweek = BiWeeklyPeriodsModel::where('budget_year',$year)
                                            ->where('biweekly_no','>=',$request->biweekly_no)
                                            ->where('biweekly_no','<=',$request->biweekly_to)
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

            // foreach($data as $id_item){
            //     $list_code[] = $id_item->item_code;
            // }

            foreach($biweek as $biweek_item){
                $datestartnotime    =    explode(' ',$biweek_item->start_date_period);
                $dateendnotime      =    explode(' ',$biweek_item->end_date_period);
                $datestart          =    explode('-',$datestartnotime[0]);
                $dateend            =    explode('-',$dateendnotime[0]);

                $data_list['biweeklist'][$biweek_item->biweekly_no] = [
                    'dayfotsale'    => $biweek_item->day_for_sale,
                    'year'          => $biweek_item->budget_year + 543,
                    'date'          => $datestart[2].'-'.$dateend[2],
                    'mount'         => $dateend[1]
                ];
            }

            $cate_code = ProductCategoryCodeModel::all();
            foreach($cate_code as $item_cate_code){
                $cate_list[$item_cate_code->lookup_code] = [
                    'description'   => $item_cate_code->description
                ];
            }

            foreach($data as $data_item){

                $taste_code = SequenceEcomsModel::where('item_code',$data_item->item_code)->first();
                if(!empty($taste_code)){
                    $taste = DB::table('ptom_taste_v')->where('value',$taste_code->taste_code)->first();
                }else{
                    $taste = '';
                }

                $data_list['item'][$data_item->forecast_screen_no][$data_item->item_code] = [
                    'item_code'         => $data_item->item_code,
                    'item_description'  => $data_item->item_description,
                    'biweekly_no'       => $data_item->biweekly_no,
                    'version'           => $data_item->version,
                    'type'              => !empty($cate_list[$data_item->forecast_stamp])? $cate_list[$data_item->forecast_stamp]['description'] : 'อื่นๆ',
                    'taste'             => !empty($taste->description)? $taste->description : 'ไม่ระบุ',
                    'type_item'         => !empty($taste_code->filter_flag)? ($taste_code->filter_flag == 'Y')? 'มีก้นกรอง' : 'ไม่มีก้นกรอง' : '',
                    'approve'           => $data_item->approve_flag,
                    'screen'            => $data_item->forecast_screen_no
                ];

                if(!empty($data_item->approve_date)){
                    $date = \explode(' ',$data_item->approve_date);
                    $date_th = explode('-',$date[0]);
                    $year = $date_th[0];
                    $year += 543;

                    $appr_date = $date_th[2].'/'.$date_th[1].'/'.$year;
                    $data_list['detail']['approve'] = $date_th[2].'/'.$date_th[1].'/'.$year;
                }else{
                    $appr_date = '';
                    $data_list['detail']['approve'] = '';
                }

                $data_list['biweekly'][$data_item->biweekly_no][$data_item->item_code] = [
                    'biweekly_no'           => $data_item->biweekly_no,
                    'amount'                => number_format($data_item->amount,2,'.',','),
                    'quantity'              => number_format($data_item->quantity,2,'.',','),
                    'amount_change'         => $data_item->amount,
                    'quantity_change'       => $data_item->quantity,
                    'sales_forecast_id'     => $data_item->sales_forecast_id,
                    'approve'               => $data_item->approve_flag,
                    'approve_date'          => $appr_date,
                    'type'                  => $data_item->sales_forecast_type
                ];

                if(!isset( $data_list['total'][$data_item->sales_forecast_type][$data_item->biweekly_no])){
                    $data_list['total'][$data_item->sales_forecast_type][$data_item->biweekly_no] = 0;
                }

                $data_list['total'][$data_item->sales_forecast_type][$data_item->biweekly_no] += $data_item->quantity;

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

    public function approve_biweek(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'budget_year'                   => 'required',
            'version'                       => 'required',
            'biweekly_no'                   => 'required',
            'biweekly_to'                   => 'required',
            // 'approve_date'                  => 'required'
        ],[
            'budget_year.required'          => 'กรุณากรอกปีงบประมาณ',
            'version.required'              => 'กรุณากรอกครั้งที่',
            'biweekly_no.required'          => 'กรุณากรอกปักษ์ที่',
            'biweekly_to.required'          => 'กรุณากรอกถึงปักษ์ที่',
            // 'approve_date.required'         => 'กรุณาเลือกวันที่อนุมัติ'
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

            if(!empty($request->approve_date)){
                $year_ex    = \explode('/',$request->approve_date);
                $year_ap    = $year_ex[2] - 543;
                $newdate    = $year_ap.'-'.$year_ex[1].'-'.$year_ex[0];
            }


            DB::beginTransaction();
            try{
                foreach($request->input_col as $key => $value){
                    $update = [
                        'approve_flag'          => !empty($request->approve_date) ? 'Y' : 'N',
                        'approve_date'          => !empty($request->approve_date) ? $newdate : '',
                        'quantity'              => str_replace(',','',$value),
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d H:i:s'),
                    ];

                    TransferBiWeeklyModel::where('sales_forecast_id',$key)->update($update);
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
        }
    }

    public function sendFactory(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'budget_year'   => 'required',
            'version'       => 'required',
            'biweekly_no'   => 'required',
            'biweekly_to'   => 'required',
        ],[
            'budget_year.required'      => 'กรุณากรอกปีงบประมาน',
            'version.required'          => 'กรุณากรอกครั้งที่',
            'biweekly_no.required'      => 'กรุณากรอกปักษ์ที่',
            'biweekly_to.required'      => 'กรุณากรอกถึงปักษ์ที่',
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

            $update = [
                'mfg_flag'              => 'Y',
                'mfg_date'              => date('Y-m-d'),
                'last_updated_by'       => optional(auth()->user())->user_id,
                'last_update_date'      => date('Y-m-d H:i:s'),
            ];

            if(TransferBiWeeklyModel::where('budget_year',$year)
                                    ->where('version',$request->version)
                                    ->where('biweekly_no','>=',$request->biweekly_no)
                                    ->where('biweekly_no','<=',$request->biweekly_to)
                                    ->where('sales_class_type','EXPORT')
                                    ->update($update)){
                if($request->version != '1'){
                    $update_old = [
                        'mfg_flag'              => 'C',
                        'mfg_date'              => date('Y-m-d'),
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d H:i:s'),
                    ];
                    TransferBiWeeklyModel::where('budget_year',$year)
                                            ->where('version','<',$request->version)
                                            ->where('biweekly_no','>=',$request->biweekly_no)
                                            ->where('biweekly_no','<=',$request->biweekly_to)
                                            ->where('sales_class_type','EXPORT')
                                            ->update($update_old);
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

    public function versionListBiweek(Request $request)
    {
        $year = $request->year;
        $year -= 543;

        $list = TransferBiWeeklyModel::select('version','approve_flag','mfg_flag')
                                        ->where('sales_class_type','EXPORT')
                                        ->where('budget_year',$year)
                                        ->groupBy('version','approve_flag','mfg_flag')
                                        ->orderBy('version','asc')
                                        ->get();

        foreach($list as $biweek_item){

            if($biweek_item->approve_flag == 'Y'){
                $approve['Y'] = 'Y';
            }elseif($biweek_item->approve_flag == 'N'){
                $approve['N'] = 'N';
            }

            if($biweek_item->mfg_flag == 'Y'){
                $factory['Y'] = 'Y';
            }elseif($biweek_item->mfg_flag == 'N' || empty($biweek_item->mfg_flag)){
                $factory['N'] = 'N';
            }elseif($biweek_item->mfg_flag == 'C'){
                $factory['C'] = 'C';
            }

            $approvelabel = '';
            if(!empty($approve['Y']) && !empty($approve['N']) && empty($factory['C'])){
                $approvelabel   = 'อนุมัติ/ไม่อนุมัติ';
            }elseif(!empty($approve['Y']) && !empty($factory['N']) && empty($factory['C'])){
                $approvelabel   = 'อนุมัติ';
            }elseif(!empty($approve['Y']) && !empty($factory['Y'])){
                $approvelabel   = 'ส่งข้อมูลแล้ว';
            }elseif(!empty($approve['Y']) && !empty($factory['C'])){
                $approvelabel   = 'ยกเลิกการส่งข้อมูลแล้ว';
            }elseif(!empty($approve['N']) && !empty($factory['N']) && !empty($factory['C'])){
                $approvelabel   = 'ไม่อนุมัติ';
            }

            $data_list[$biweek_item->version] = [
                'version'   => $biweek_item->version,
                'approve'   => $approvelabel
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

    public function yearListBiweek(Request $request)
    {
        $year = $request->year;
        $year -= 543;

        $list =  BiWeeklyPeriodsModel::where('budget_year',$year)->orderBy('biweekly_no','asc')->get();

        foreach($list as $biweek_item){
            $biweek_list[$biweek_item->biweekly_no] = [
                'id'    => $biweek_item->biweekly_id
            ];

            $data_list[] = [
                'biweekly_no'   => $biweek_item->biweekly_no,
                'budget_year'   => $biweek_item->budget_year + 543
            ];
        }

        if($list){
            $rest = [
                'status'    => true,
                'data'      => $data_list,
                'ta'        => $biweek_list
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
