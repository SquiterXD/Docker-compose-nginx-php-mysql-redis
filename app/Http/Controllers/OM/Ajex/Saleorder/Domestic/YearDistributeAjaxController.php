<?php

namespace App\Http\Controllers\OM\Ajex\SaleOrder\Domestic;

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
use App\Models\OM\Saleorder\Domestic\ProductTypeModel;
use App\Models\OM\Saleorder\Domestic\ProductTypeExportModel;
use App\Models\OM\Saleorder\Domestic\UomModel;

use App\Imports\OM\Saleorder\Domestic\YearDistributeImport;
use Maatwebsite\Excel\Facades\Excel;

class YearDistributeAjaxController extends Controller
{
    public function importexcel(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'year_to'       => 'required|numeric',
            'year'          => 'required|numeric',
            'import_excel'  => 'required|file|max:10240|mimes:xlsx,xls',
        ],[
            'year.required'         => 'กรุณากรอกปีงบประมาณ',
            'year_to.required'      => 'กรุณากรอกปีงบประมาณสุดท้าย',
            'year_to.numeric'       => 'กรุณากรอกปีงบประมาณเป็นตัวเลข',
            'year.numeric'          => 'กรุณากรอกปีงบประมาณเป็นตัวเลข',
            'import_excel.required' => 'กรุณาเลือกไฟล์สำหรับอัพโหลด',
            'import_excel.mimes'    => 'กรุณาเลือกไฟล์ Excel (.xlsx/.xls)',
            'import_excel.size'     => 'กรุณาเลือกไฟล์ไม่เกิน 10Mb',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json(['data'=>$rest]);
        }else{
            $year = $request->year;
            $year -= 543;
            $byear_no = $year - 1;

            $year_no = $request->year_to;
            $year_no -= 543;

            $chk = 0;
            $inputYear = [];
            for($i = $year; $i <= $year_no; $i++){
                $inputYear[$i] = $i;
            }

            if (!empty($request->version)) {
                $check_appove = YearDistributeModel::where('budget_year', '>=', $year)
                                                    ->where('budget_year', '<=', $year_no)
                                                    ->where('version', $request->version)
                                                    ->where('approve_flag', 'Y')
                                                    ->where('sales_class_type',$request->type)
                                                    ->count();
                $version = $request->version;
            }else{
                $check_appove = 0;
                $version_last = YearDistributeModel::where('budget_year', '>=',$year)->where('sales_class_type',$request->type)->where('budget_year', '<=', $year_no)->orderBy('version','desc')->first();
                if(!empty($version_last)){
                    $version = $version_last->version + 1;
                }else{
                    $version = 1;
                }
            }
            if($check_appove > 0){
                $rest = [
                    'status'    => false,
                    'message'   => 'ประมาณการรายปีครั้งที่ '.$request->version.' ถูกส่งข้อมูลแล้ว โปรดตรวจสอบข้อมูลให้ถูกต้อง'
                ];
                return response()->json(['data'=>$rest]);
                exit;
            }

            $product_type = SequenceEcomsModel::all();
            foreach($product_type as $product_type_item){
                $type[$product_type_item->item_code] = [
                    'type_code' => $product_type_item->product_type_code,
                ];
            }

            DB::beginTransaction();
            try {
                $excel = new YearDistributeImport;
                Excel::import($excel, request()->file('import_excel'));

                $result = $excel->data;

                $data_logpart = getDefaultData('/users');
                if(!$result['status']){
                    throw new \Exception('Header');
                }

                foreach($result['data'] as $data_key =>  $data_item){
                    foreach($data_item as $key_excel => $item_excel){
                        $excelYear = $item_excel['year'] - 543;
                        if(in_array($excelYear,$inputYear) !== true){
                            throw new \Exception('Year');
                        }
                        $check_data = YearDistributeModel::where('budget_year',$excelYear)
                                                            ->where('budget_year_no',$byear_no)
                                                            ->where('version',$version)
                                                            ->where('item_code',trim($item_excel['item_code']))
                                                            ->where('sales_class_type',$request->type)
                                                            ->first();
                        if($check_data){
                            if(empty($item_excel['quantity']) && $item_excel['quantity'] != 0 ){
                                throw new \Exception('Quantity');
                            }
                            if(empty($item_excel['amount']) && $item_excel['amount'] != 0 ){
                                throw new \Exception('Amount');
                            }
                            if(empty(trim($item_excel['item_code']))){
                                throw new \Exception('ItemCode');
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
                                    throw new \Exception('ItemTypeUom '.$type_uom->description);
                                }
                            }
                            if(empty($codeproduct)){
                                throw new \Exception('ItemCode');
                            }

                            $update = [
                                'budget_year'           => $excelYear,
                                'version'               => $version,
                                'file_name'             => $request->file('import_excel')->getClientOriginalName(),
                                'item_id'               => !empty($codeproduct->inventory_item_id)?$codeproduct->inventory_item_id : '0',
                                'item_code'             => !empty($codeproduct->item_code)?$codeproduct->item_code : '0',
                                'item_description'      => !empty($codeproduct->item_description)?$codeproduct->item_description : $item_excel['item_description'],
                                'quantity'              => $item_excel['quantity'],
                                'amount'                => $item_excel['amount'],
                                // 'budget_year_no'        => $key_excel,
                                'sales_class_type'      => trim($itemcode->sale_type_code),
                                'budget_year_no'        => $byear_no,
                                'attribute1'            => $key_excel,
                                'uom'                   => ($request->type_item == 'product_type')? $type_uom->tag : $codeproduct->uom,
                                'sales_forecast_type'   => !empty($type[trim($item_excel['item_code'])])?$type[trim($item_excel['item_code'])]['type_code'] : '00',
                                'last_updated_by'       => optional(auth()->user())->user_id,
                                'last_update_date'      => date('Y-m-d H:i:s'),
                            ];
                            YearDistributeModel::where('yearly_id',$check_data->yearly_id)->update($update);

                        }else{
                            $itemcode = SequenceEcomsModel::where('item_code',trim($item_excel['item_code']))->first();
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
                                    throw new \Exception('ItemTypeUom '.$type_uom->description);
                                }
                            }
                            if(empty($codeproduct)){
                                throw new \Exception('ItemCode');
                            }

                            $org = DB::table('ptom_operating_units_v')->where('short_code','TOAT')->first();
                            if($org){
                                $org_id = $org->organization_id;
                            }else{
                                $org_id = 121;
                            }

                            $insert = [
                                'org_id'                => $org_id,
                                'budget_year'           => $excelYear,
                                'version'               => $version,
                                'file_name'             => $request->file('import_excel')->getClientOriginalName(),
                                'path_name'             => $data_logpart->log_directory,
                                'item_id'               => !empty($codeproduct->inventory_item_id)?$codeproduct->inventory_item_id : '0',
                                'item_code'             => !empty($codeproduct->item_code)?$codeproduct->item_code : '0',
                                'item_description'      => !empty($codeproduct->item_description)?$codeproduct->item_description : $item_excel['item_description'],
                                'quantity'              => $item_excel['quantity'],
                                'amount'                => $item_excel['amount'],
                                // 'budget_year_no'        => $key_excel,
                                'sales_class_type'      => trim($itemcode->sale_type_code),
                                'budget_year_no'        => $byear_no,
                                'attribute1'            => $key_excel,
                                'month_no'              => 0,
                                'uom'                   => ($request->type_item == 'product_type')? $type_uom->tag : $codeproduct->uom,
                                'sales_forecast_type'   => !empty($type[trim($item_excel['item_code'])])?$type[trim($item_excel['item_code'])]['type_code'] : '00',
                                'approve_flag'          => 'N',
                                'program_code'          => 'OMP0057',
                                'created_by'            => optional(auth()->user())->user_id,
                                'creation_date'         => date('Y-m-d H:i:s'),
                                'last_updated_by'       => optional(auth()->user())->user_id,
                                'last_update_date'      => date('Y-m-d H:i:s'),
                            ];

                            YearDistributeModel::create($insert);

                        }
                    }
                }

               // pr($update);
               DB::commit();
               $rest = [
                   'status'    => true,
                   'message'   => 'success'
               ];
               return response()->json(['data'=>$rest]);
            } catch (\Exception $em) {
                DB::rollBack();
                $message = $em->getMessage();

                if(strpos($message,'ItemTypeUom') !== false){
                    $des    = explode(' ',$message);
                    $result = [
                        'status'    => false,
                        'type'      => 'itemuom',
                        'desc'      => $des[1]
                    ];
                    return response()->json(['data'=>$result]);
                }else{
                    $file = $request->file('import_excel')->getClientOriginalName();
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
                    }elseif(strpos($message,'ItemCode') !== false){
                        $log_content = 'โปรดตรวจสอบไฟล์ Excel เพิ่มข้อมูล/ตรวจสอบ รหัสตราบุหรี่ให้ครบ';
                    }elseif(strpos($message,'ItemName') !== false){
                        $log_content = 'โปรดตรวจสอบไฟล์ Excel เพิ่มข้อมูล/ตรวจสอบ ตราบุหรี่ให้ครบ';
                    }elseif(strpos($message,'Year') !== false){
                        $log_content = 'ปีงบประมาณใน Excel และใน inputไม่ตรงกัน';
                    }elseif(strpos($message,'ItemType') !== false){
                        $log_content = 'ไม่พบรหัสสินค้านี้ในระบบ กรุณาตรวจสอบให้ถูกต้อง';
                    }elseif(strpos($message,'ItemEmpty')!== false){
                        $cutmsg = explode('_',$message);
                        $array = explode(',',$cutmsg[1]);
                        $log_content = 'ไม่พบรหัสสินค้านี้ในระบบ กรุณาตรวจสอบให้ถูกต้อง';
foreach($array as $item){
    $item_product = explode('/',$item);
    $log_content .= '
    รหัสสินค้า '.$item_product[0].':'.$item_product[1];
}
                    }else{
                        $log_content = 'ไฟล์ที่นำข้อมูลเข้าไม่ตรงกับตัวอย่าง กรุณาตรวจสอบให้ตรงตามรูปแบบ ตามไฟล์ตัวอย่างที่นำเข้า';
                    }
                    $data = getDefaultData('/users');
                    Storage::disk('local')->put($data->log_directory.'/'.$file_name,$log_content);

                    return response()->json(['data'=>$result]);
                }
            }
        }
    }

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
                                        ->where('ptom_yearly_sales_forecast.sales_class_type','DOMESTIC')
                                        ->leftJoin('ptom_sequence_ecoms','ptom_sequence_ecoms.item_code','=','ptom_yearly_sales_forecast.item_code')
                                        ->where('ptom_sequence_ecoms.screen_number','!=','0')
                                        ->where('ptom_sequence_ecoms.start_date','<=',date('Y-m-d'))
                                        ->where(function ($query) {
                                            $query->where('ptom_sequence_ecoms.end_date','>=',date('Y-m-d'));
                                            $query->orWhereNull('ptom_sequence_ecoms.end_date');
                                        })
                                        ->orderBy('ptom_sequence_ecoms.screen_number','asc')
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

                if(!empty($taste_code->filter_flag)){
                    if($taste_code->filter_flag == 'Y'){
                        $type_item = 'มีก้นกรอง';
                    }else{
                        $type_item = 'ไม่มีก้นกรอง';
                    }
                }else{
                    $type_item = '';
                }

                $data_list['item'][$data_item->item_code] = [
                    'item_code'         => $data_item->item_code,
                    'item_description'  => $data_item->item_description,
                    'taste'             => !empty($taste->description)? $taste->description : 'ไม่ระบุ',
                    'type'              => $type_item,
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
                }elseif($data_item->mfg_flag == 'N' || empty($data_item->mfg_flag)){
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

                $check      = YearDistributeModel::where('budget_year','>=',$year)->where('sales_class_type','DOMESTIC')->where('budget_year','<=',$year_to)->where('version',$request->version)->count();

                if($check > 0){

                    DB::beginTransaction();
                    try{
                        if($request->show == 'quantity'){
                            if($request->input_col_qunti){
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
                            }
                            $notShow = YearDistributeModel::where('budget_year','>=',$year)
                                                ->where('sales_class_type','DOMESTIC')
                                                ->where('budget_year','<=',$year_to)
                                                ->where('version',$request->version)
                                                ->where('approve_flag','N')
                                                ->leftJoin('ptom_sequence_ecoms','ptom_sequence_ecoms.item_code','=','ptom_yearly_sales_forecast.item_code')
                                                ->where('ptom_sequence_ecoms.screen_number','0')
                                                ->get();
                            if($notShow->count() > 0){
                                foreach($notShow as $show_item){
                                    $update = [
                                        'approve_flag'          => !empty($request->approve_date) ? 'Y' : 'N',
                                        'approve_date'          => !empty($request->approve_date) ? $newdate : '',
                                        'quantity'              => $show_item->quantity,
                                        // 'amount'                => $request->input_col_amount[$key],
                                        'remark'                => !empty($request->approve_note) ? $request->approve_note : '',
                                        'last_updated_by'       => optional(auth()->user())->user_id,
                                        'last_update_date'      => date('Y-m-d H:i:s'),
                                    ];
 
                                    YearDistributeModel::where('yearly_id',$show_item->yearly_id)->update($update);
                                }
                            }
                        }else{
                            if($request->input_col_amount){
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

                            $notShow = YearDistributeModel::where('budget_year','>=',$year)
                                                ->where('sales_class_type','DOMESTIC')
                                                ->where('budget_year','<=',$year_to)
                                                ->where('version',$request->version)
                                                ->where('approve_flag','N')
                                                ->leftJoin('ptom_sequence_ecoms','ptom_sequence_ecoms.item_code','=','ptom_yearly_sales_forecast.item_code')
                                                ->where('ptom_sequence_ecoms.screen_number','0')
                                                ->get();
                            if($notShow->count() > 0){
                                foreach($notShow as $show_item){
                                    $update = [
                                        'approve_flag'          => !empty($request->approve_date) ? 'Y' : 'N',
                                        'approve_date'          => !empty($request->approve_date) ? $newdate : '',
                                        // 'quantity'              => $show_item->quantity,
                                        'amount'                => $show_item->amount,
                                        'remark'                => !empty($request->approve_note) ? $request->approve_note : '',
                                        'last_updated_by'       => optional(auth()->user())->user_id,
                                        'last_update_date'      => date('Y-m-d H:i:s'),
                                    ];

                                    YearDistributeModel::where('yearly_id',$show_item->yearly_id)->update($update);
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

            if(YearDistributeModel::where('budget_year','>=',$year)->where('sales_class_type','DOMESTIC')->where('budget_year','<=',$year_to)->where('version',$request->version)->where('approve_flag','Y')->update($update)){

                if($request->version != '1'){
                    $update_old = [
                        'mfg_flag'              => 'C',
                        'mfg_date'              => date('Y-m-d'),
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d H:i:s'),
                    ];
                    YearDistributeModel::where('budget_year','>=',$year)->where('sales_class_type','DOMESTIC')->where('budget_year','<=',$year_to)->where('version','<',$request->version)->update($update_old);
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
                                    ->where('sales_class_type',$request->type)
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
