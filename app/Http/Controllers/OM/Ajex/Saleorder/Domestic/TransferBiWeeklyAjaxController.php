<?php

namespace App\Http\Controllers\OM\Ajex\Saleorder\Domestic;

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
use App\Models\OM\Saleorder\Domestic\ProductTypeModel;
use App\Models\OM\Saleorder\Domestic\ProductTypeExportModel;
use App\Models\OM\Saleorder\Domestic\UomModel;

use App\Imports\OM\Saleorder\Domestic\TransferBiWeeklyImportController;
use Maatwebsite\Excel\Facades\Excel;

class TransferBiWeeklyAjaxController extends Controller
{
    public function importExcel(Request $request)
    {

        $validate = Validator::make($request->all(),[
            'year'          => 'required',
            'version'       => 'required',
            'pung_no'       => 'required',
            'pung_to'       => 'required',
            'biweek_excel'  => 'required|file|max:10240|mimes:xlsx,xls',
        ],[
            'year.required'         => 'กรุณากรอกปีงบประมาณ',
            'version.required'      => 'กรุณากรอกครั้งที่',
            'pung_no.required'      => 'กรุณากรอกปักษ์ที่',
            'pung_to.required'      => 'กรุณากรอกถึงปักษ์ที่',
            'biweek_excel.required' => 'กรุณาเลือกไฟล์สำหรับอัพโหลด',
            'biweek_excel.mimes'    => 'กรุณาเลือกไฟล์ Excel (.xlsx)',
            'biweek_excel.size'     => 'กรุณาเลือกไฟล์ไม่เกิน 10Mb',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json(['data'=>$rest]);
        }else{

            if($request->pung_no > $request->pung_to){
                $rest = [
                    'status'    => false,
                    'type'      => 'validate',
                    'data'      => [ 'pung_no' => 'ปักษ์ที่ ต้องน้อยกว่า ถึงปักษ์ที่']
                ];
                return response()->json(['data'=>$rest]);
            }

            if($request->pung_to < $request->pung_no){
                $rest = [
                    'status'    => false,
                    'type'      => 'validate',
                    'data'      => [ 'pung_to' => 'ถึงปักษ์ที่ ต้องมากกว่า ปักษ์ที่']
                ];
                return response()->json(['data'=>$rest]);
            }

            for($pung = $request->pung_no ; $pung <=  $request->pung_to ; $pung ++ ){
                $data['pung'][] = $pung;
                if($pung > $request->pung_to){
                    throw new \Exception('Someting Worng:70');
                    break;
                }
            }


            $year = $request->year;
            $year -= 543;

            if(!empty($request->version)){
                $approveCheck = [];
                $listCheck = [];

                for($ck = $request->pung_no; $ck <= $request->pung_to; $ck++){
                    $check_appove = TransferBiWeeklyModel::where('budget_year',$year)
                                                            ->where('version',$request->version)
                                                            ->where('approve_flag','Y')
                                                            ->where('biweekly_no',$ck)
                                                            ->where('sales_class_type',$request->type)
                                                            ->first();
                    if(!empty($check_appove)){
                        if($check_appove->approve_flag == 'Y'){
                            $approveCheck[$ck] = true;
                            $listCheck[$ck] = $check_appove->biweekly_no;
                        }else{
                            $approveCheck[$ck] = false;
                        }
                    }else{
                        $approveCheck[$ck] = false;
                    }
                }

                $version = $request->version;
            }else{
                $check_appove = 0;
                $version_last = TransferBiWeeklyModel::where('budget_year',$year)->where('sales_class_type',$request->type)->where('sales_class_type','DOMESTIC')->orderBy('version','desc')->first();
                if(!empty($version_last)){
                    $version = $version_last->version + 1;
                }else{
                    $version = 1;
                }
            }

            if(in_array(true,$approveCheck)){
                $listPung = implode(',',$listCheck);
                $rest = [
                    'status'    => false,
                    'message'   => 'ปักษ์ที่เลือก '.$listPung.' มีการอนุมัติไปแล้ว ไม่สามารถอัพโหลดได้'
                ];
                return response()->json(['data'=>$rest]);
            }
            $product_type = SequenceEcomsModel::all();
            foreach($product_type as $product_type_item){
                $type[$product_type_item->item_code] = [
                    'type_code' => $product_type_item->product_type_code,
                ];
            }

            $product_code = ProductCategoryCodeModel::all();
            foreach($product_code as $product_code_item){
                $code_item[$product_code_item->lookup_code] = ['lookup'=>$product_code_item->lookup_code];
            }

            DB::beginTransaction();
            try {
                $excel = new TransferBiWeeklyImportController;
                Excel::import($excel,request()->file('biweek_excel'));

                $result = $excel->data;

                $biweek = BiWeeklyPeriodsModel::where('budget_year',$year)->get();
                if($biweek->count() > 0){
                    foreach($biweek as $biweek_item){
                        $biweek_list[$biweek_item->biweekly_no] = [
                            'id'    => $biweek_item->biweekly_id
                        ];
                    }
                }else{
                    throw new \Exception('biweek_list');
                }

                $data_logpart = getDefaultData('/users');
                if(!$result['status']){
                    throw new \Exception('Header');
                }
                $itemcodeemtry  = [];
                foreach($result['data'] as $data_key =>  $data_item){
                    foreach($data_item as $key_excel => $item_excel){
                        if(!in_array($key_excel,$data['pung'])){
                            throw new \Exception('PungHeadExcel');
                            break;
                        }

                        $check_data = TransferBiWeeklyModel::where('budget_year',$year)
                                                           ->where('version',$version)
                                                           ->where('biweekly_no',$key_excel)
                                                           ->where('item_code',trim($item_excel['item_code']))
                                                           ->where('sales_class_type',$request->type)
                                                           ->first();
                        if($check_data){
                            if(empty($item_excel['quantity']) && $item_excel['quantity'] != 0){
                                throw new \Exception('Quantity');
                            }
                            if(empty($item_excel['amount']) && $item_excel['amount'] != 0){
                                throw new \Exception('Amount');
                            }
                            if(empty($item_excel['item_code'])){
                                throw new \Exception('ItemCodeMain');
                            }
                            if(empty($item_excel['item_description'])){
                                throw new \Exception('ItemName');
                            }
                            $itemcode       = SequenceEcomsModel::where('item_code',trim($item_excel['item_code']))->first();
                            $codeproduct    = ProductItemModel::where('item_code',trim($item_excel['item_code']))->first();
                            if(empty($itemcode)){
                                throw new \Exception('ItemEmpty_'.$item_excel['item_code'].'_'.$item_excel['item_description']);
                            }
                            if(trim($itemcode->sale_type_code) != $request->type){
                                throw new \Exception('ItemType_'.$item_excel['item_code'].'_'.$item_excel['item_description']);
                            }
                            if($request->type == 'DOMESTIC' && $request->type_item == 'product_type'){
                                $type_uom = ProductTypeModel::where('lookup_code',$itemcode->product_type_code)->first();
                            }elseif($request->type == 'EXPORT' && $request->type_item == 'product_type'){
                                $type_uom = ProductTypeExportModel::where('lookup_code',$itemcode->product_type_code)->first();
                            }
                            if($request->type_item == 'product_type'){
                                if(empty($type_uom->tag)){
                                    throw new \Exception('ItemUom '.$type_uom->description);
                                }
                            }
                            if(empty($codeproduct)){
                                throw new \Exception('ItemCode '.trim($item_excel['item_code']));
                                // $itemcodeemtry[] = $item_excel['item_code'];
                            }else{
                                $update = [
                                    'budget_year'           => $year,
                                    'version'               => $version,
                                    'file_name'             => $request->file('biweek_excel')->getClientOriginalName(),
                                    'item_id'               => !empty($codeproduct->inventory_item_id)?$codeproduct->inventory_item_id : '0',
                                    'item_code'             => !empty($codeproduct->item_code)?$codeproduct->item_code : '0',
                                    'item_description'      => !empty($codeproduct->item_description)?$codeproduct->item_description : $item_excel['item_description'],
                                    'quantity'              => $item_excel['quantity'],
                                    'amount'                => $item_excel['amount'],
                                    'biweekly_no'           => $key_excel,
                                    'biweekly_id'           => $biweek_list[$key_excel]['id'],
                                    'uom'                   => ($request->type_item == 'product_type')? $type_uom->tag : $codeproduct->uom,
                                    'sales_class_type'      => trim($itemcode->sale_type_code),
                                    'sales_forecast_type'   => !empty($type[trim($item_excel['item_code'])])?$type[trim($item_excel['item_code'])]['type_code'] : '00',
                                    'product_category_code' => !empty($itemcode->product_type_code)? $code_item[$itemcode->product_type_code]['lookup'] : '30',
                                    'last_updated_by'       => optional(auth()->user())->user_id,
                                    'last_update_date'      => date('Y-m-d H:i:s'),
                                ];
                                TransferBiWeeklyModel::where('sales_forecast_id',$check_data->sales_forecast_id)->update($update);
                            }
                        }else{
                            $itemcode       = SequenceEcomsModel::where('item_code',trim($item_excel['item_code']))->first();
                            $codeproduct    = ProductItemModel::where('item_code',trim($item_excel['item_code']))->first();
                            if(empty($itemcode)){
                                throw new \Exception('ItemEmpty_'.$item_excel['item_code'].'_'.$item_excel['item_description']);
                            }
                            if(trim($itemcode->sale_type_code) != $request->type){
                                throw new \Exception('ItemType_'.$item_excel['item_code'].'_'.$item_excel['item_description']);
                            }
                            if($request->type == 'DOMESTIC' && $request->type_item == 'product_type'){
                                $type_uom = ProductTypeModel::where('lookup_code',$itemcode->product_type_code)->first();
                            }elseif($request->type == 'EXPORT' && $request->type_item == 'product_type'){
                                $type_uom = ProductTypeExportModel::where('lookup_code',$itemcode->product_type_code)->first();
                            }
                            if($request->type_item == 'product_type'){
                                if(empty($type_uom->tag)){
                                    throw new \Exception('ItemUom '.$type_uom->description);
                                }
                            }
                            if(empty($codeproduct)){
                                throw new \Exception('ItemCode '.trim($item_excel['item_code']));
                                // $itemcodeemtry[] = $item_excel['item_code'];
                            }else{

                                $org = DB::table('ptom_operating_units_v')->where('short_code','TOAT')->first();
                                if($org){
                                    $org_id = $org->organization_id;
                                }else{
                                    $org_id = 121;
                                }

                                $insert = [
                                    'org_id'                => $org_id,
                                    'budget_year'           => $year,
                                    'version'               => $version,
                                    'file_name'             => $request->file('biweek_excel')->getClientOriginalName(),
                                    'path_name'             => $data_logpart->log_directory,
                                    'item_id'               => !empty($codeproduct->inventory_item_id)?$codeproduct->inventory_item_id : '0',
                                    'item_code'             => !empty($codeproduct->item_code)?$codeproduct->item_code : '0',
                                    'item_description'      => !empty($codeproduct->item_description)?$codeproduct->item_description : $item_excel['item_description'],
                                    'quantity'              => $item_excel['quantity'],
                                    'amount'                => $item_excel['amount'],
                                    'biweekly_no'           => $key_excel,
                                    'biweekly_id'           => $biweek_list[$key_excel]['id'],
                                    'uom'                   => ($request->type_item == 'product_type')? $type_uom->tag : $codeproduct->uom,
                                    'sales_class_type'      => trim($itemcode->sale_type_code),
                                    'sales_forecast_type'   => !empty($type[trim($item_excel['item_code'])])?$type[trim($item_excel['item_code'])]['type_code'] : '00',
                                    'product_category_code' => !empty($itemcode->product_type_code)? $code_item[$itemcode->product_type_code]['lookup'] : '30',
                                    'approve_flag'          => 'N',
                                    'program_code'          => 'OMP0055',
                                    'mfg_flag'              => 'N',
                                    'created_by'            => optional(auth()->user())->user_id,
                                    'creation_date'         => date('Y-m-d H:i:s'),
                                    'last_updated_by'       => optional(auth()->user())->user_id,
                                    'last_update_date'      => date('Y-m-d H:i:s'),
                                ];

                                TransferBiWeeklyModel::create($insert);
                            }
                        }
                    }
                }

                DB::commit();
                $rest = [
                    'status'    => true,
                    'message'   => 'success',
                    'data'      => $itemcodeemtry
                ];
                return response()->json(['data'=>$rest]);
            } catch(\Exception $em){
                DB::rollBack();

                $message = $em->getMessage();

                if(strpos($message,'ItemUom') !== false){
                    $des    = explode(' ',$message);
                    $result = [
                        'status'    => false,
                        'type'      => 'itemuom',
                        'desc'      => $des[1]
                    ];
                    return response()->json(['data'=>$result]);
                }else{
                    $file = $request->file('biweek_excel')->getClientOriginalName();
                    $file_expol = \explode('.',$file);

                    $file_name = date('YmdHis').'-'.$file_expol[0].'.txt';

                    $result = [
                        'status'    => false,
                        'err_msg'   => $message.' Line:'.$em->getLine(),
                        'data'      => $file_name,
                        'type'      => 'file'
                    ];
                    
                    if(strpos($message,'Undefined offset:') !== false){
                        $log_content = 'เทมเพลตไฟล์ไม่ถูกต้อง กรุณาดาวน์โหลดไฟล์ตัวอย่างเพื่อนำเข้า';
                    }elseif(strpos($message,'Header') !== false){
                        $log_content = 'เทมเพลตไฟล์ไม่ถูกต้อง กรุณาดาวน์โหลดไฟล์ตัวอย่างเพื่อนำเข้า';
                    }elseif(strpos($message,'Quantity') !== false){
                        $log_content = 'โปรดตรวจสอบไฟล์ Excel เพิ่มข้อมูล/ตรวจสอบ จำนวนจำหน่ายให้ครบทุกปักษ์';
                    }elseif(strpos($message,'Amount') !== false){
                        $log_content = 'โปรดตรวจสอบไฟล์ Excel เพิ่มข้อมูล/ตรวจสอบ มูลค่าการจำหน่ายให้ครบทุกปักษ์';
                    }elseif(strpos($message,'ItemCodeMain') !== false){
                        $log_content = 'โปรดตรวจสอบไฟล์ Excel เพิ่มข้อมูล/ตรวจสอบ รหัสตราบุหรี่ให้ครบ';
                    }elseif(strpos($message,'ItemCode') !== false){
                        $log_content = 'โปรดตรวจสอบไฟล์ Excel เพิ่มข้อมูล/ตรวจสอบ รหัสตราบุหรี่'.$message;
                    }elseif(strpos($message,'ItemName') !== false){
                        $log_content = 'โปรดตรวจสอบไฟล์ Excel เพิ่มข้อมูล/ตรวจสอบ ตราบุหรี่ให้ครบ';
                    }elseif(strpos($message,'PungHeadExcel') !== false){
                        $log_content = 'กรุณาตรวจสอบปักษ์ที่เลือกให้ตรงกับในไฟล์ข้อมูล';
                    }elseif(strpos($message,'ItemType') !== false){
                        $log_content = 'ไม่พบรหัสสินค้านี้ในระบบ กรุณาตรวจสอบให้ถูกต้อง';
                    }elseif(strpos($message,'first_data') !== false){
                        $log_content = 'กรุณาระบุข้อมูล ประมาณการจำหน่าย มูลค่า หรือจำนวน ให้ครบถ้วน';
                    }if(strpos($message,'biweek_list') !== false){
                        $log_content = 'ไม่พบปีงบประมานที่เลือกในระบบ';
                    }elseif(strpos($message,'ItemEmpty')!== false){
                        $cutmsg = explode('_',$message);
                        $array = explode(',',$cutmsg[1]);
                        $log_content = 'ไม่พบรหัสสินค้านี้ในระบบ กรุณาตรวจสอบให้ถูกต้อง';
foreach($array as $item){
    $item_product = explode('/',$item);
    $log_content .= '
    รหัสสินค้า '.$item_product[0].':'.$item_product[1];
}
                    }
                    // else{
                    //     $log_content = 'ไฟล์ที่นำข้อมูลเข้าไม่ตรงกับตัวอย่าง กรุณาตรวจสอบให้ตรงตามรูปแบบ ตามไฟล์ตัวอย่างที่นำเข้า';
                    // }
                    $data = getDefaultData('/users');
                    Storage::disk('local')->put($data->log_directory.'/'.$file_name,$log_content);
                    return response()->json(['data'=>$result]);
                }
            }
        }
    }

    // public function testcash()
    // {
    //     try{
    //         return response()->json(['data' =>$aaa]);
    //     }catch (\Exception $e) {
    //         return response()->json(['data'=>$e->getMessage()]);
    //     }
    // }

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
                                            ->where('ptom_sales_forecast.sales_class_type','DOMESTIC')
                                            ->orderBy('ptom_sequence_ecoms.forecast_screen_no','asc')
                                            ->get();

            $biweek = BiWeeklyPeriodsModel::where('budget_year',$year)
                                            ->where('biweekly_no','>=',$request->biweekly_no)
                                            ->where('biweekly_no','<=',$request->biweekly_to)
                                            ->get();

            $producttype = ProductTypeModel::all();
            $uom = UomModel::all();

            foreach($uom as $item_uom){
                $data_uom[$item_uom->uom_code] = [
                    'uom'               => $item_uom->uom_code,
                    'unit_of_measure'   => $item_uom->unit_of_measure,
                ];
            }
            

            foreach($producttype as $producttype_item){
                $data_list['producttype'][$producttype_item->lookup_code] = [
                    'description'   => $producttype_item->description.' ('.$data_uom[$producttype_item->tag]['unit_of_measure'].')',
                    'tag'           => $producttype_item->tag,
                ];
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
                if(!empty($taste_code->filter_flag)){
                    if($taste_code->filter_flag == 'Y'){
                        $type_item = 'มีก้นกรอง';
                    }else{
                        $type_item = 'ไม่มีก้นกรอง';
                    }
                }else{
                    $type_item = '';
                }

                $data_list['item'][$data_item->forecast_screen_no][$data_item->item_code] = [
                    'item_code'         => $data_item->item_code,
                    'item_description'  => $data_item->item_description,
                    'biweekly_no'       => $data_item->biweekly_no,
                    'version'           => $data_item->version,
                    'type'              => !empty($cate_list[$data_item->forecast_stamp])? $cate_list[$data_item->forecast_stamp]['description'] : 'อื่นๆ',
                    'taste'             => !empty($taste->description)? $taste->description : 'ไม่ระบุ',
                    'type_item'         => $type_item,
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
                }elseif($data_item->mfg_flag == 'C'){
                    $factory['C'] = 'C';
                }

            }

            if(!empty($approve['Y']) && !empty($approve['N']) && empty($factory['C'])){
                $data_list['approve']   = 'อนุมัติ/ไม่อนุมัติ';
                $data_list['app_color'] = 'text-warning';
            }elseif(!empty($approve['Y']) && !empty($factory['N']) && empty($factory['C'])){
                $data_list['approve']   = 'อนุมัติ';
                $data_list['app_color'] = 'text-success';
            }elseif(!empty($approve['N']) && !empty($factory['N']) && !empty($factory['C'])){
                $data_list['approve']   = 'ไม่อนุมัติ';
                $data_list['app_color'] = 'text-danger';
            }elseif(!empty($approve['Y']) && !empty($factory['Y'])){
                $data_list['approve']   = 'ส่งข้อมูลแล้ว';
                $data_list['app_color'] = 'text-info';
            }elseif(!empty($approve['Y']) && !empty($factory['C'])){
                $data_list['approve']   = 'ยกเลิกการส่งข้อมูลแล้ว';
                $data_list['app_color'] = 'text-danger';
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

            if(TransferBiWeeklyModel::where('sales_forecast_id',$request->id)->update($update)){
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

                    $notShow = TransferBiWeeklyModel::leftJoin('ptom_sequence_ecoms','ptom_sequence_ecoms.item_code','=','ptom_sales_forecast.item_code')
                                            ->where('ptom_sequence_ecoms.screen_number','0')
                                            ->where('ptom_sales_forecast.budget_year',$year)
                                            ->where('ptom_sales_forecast.version',$request->version)
                                            ->where('ptom_sales_forecast.biweekly_no','>=',$request->biweekly_no)
                                            ->where('ptom_sales_forecast.biweekly_no','<=',$request->biweekly_to)
                                            ->where('ptom_sales_forecast.sales_class_type','DOMESTIC')
                                            ->where('ptom_sales_forecast.approve_flag','N')
                                            ->get();
                    if($notShow->count() > 0){
                        foreach($notShow as $show_item){
                            $update = [
                                'approve_flag'          => !empty($request->approve_date) ? 'Y' : 'N',
                                'approve_date'          => !empty($request->approve_date) ? $newdate : '',
                                'last_updated_by'       => optional(auth()->user())->user_id,
                                'last_update_date'      => date('Y-m-d H:i:s'),
                            ];
        
                            TransferBiWeeklyModel::where('sales_forecast_id',$show_item->sales_forecast_id)->update($update);
                        }
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
                                    ->whereIn('biweekly_no',$request->biweeky)
                                    ->where('sales_class_type','DOMESTIC')
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
                                            ->whereIn('biweekly_no',$request->biweeky)
                                            ->where('sales_class_type','DOMESTIC')
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
                                        ->where('sales_class_type',$request->type)
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

        if($list->count() > 0){
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

        if($list->count() > 0){
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
