<?php

namespace App\Http\Controllers\QM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Models\QM\Settings\CheckPointsT;
use App\Models\QM\Settings\CheckPointsV;
use App\Models\QM\Settings\Attachments;
use App\Models\QM\Settings\ProgramsInfoV;
use App\Models\QM\Settings\SubinventoriesV;
use App\Models\QM\Settings\LocatorSegment1V;
use App\Models\QM\Settings\LocatorSegment2V;

class CheckPointsTobaccoLeafController extends Controller
{
    public function index()
    {
        $profile = getDefaultData('/qm/settings/check-points-tobacco-leaf');
        $search = request()->search;
        $btnTrans = trans('btn');
        $checkPoints = CheckPointsV::select(    'organization_id', 'organization_code', 'subinventory_code', 'inventory_location_id', 
                                                'locator_code', 'locator_desc', 'building_code',
                                                'building_desc', 'location_code', 'location_desc', 'qm_test_type_code' , 'qm_test_type',
                                                'qm_group', 'build_name', 'department_name', 'machine_set', 'moisture_point', 'enabled_flag',
                                                'disable_date' )
                                    ->SearchLeaf($search)
                                    ->where('qm_test_type_code','1')
                                    ->groupBy(  'organization_id', 'organization_code', 'subinventory_code', 'inventory_location_id', 
                                                'locator_code', 'locator_desc', 'building_code',
                                                'building_desc', 'location_code', 'location_desc', 'qm_test_type_code' , 'qm_test_type',
                                                'qm_group', 'build_name', 'department_name', 'machine_set', 'moisture_point', 'enabled_flag',
                                                'disable_date')
                                    ->get();
        $listSearchLocationDesc = CheckPointsV::where('qm_test_type_code','1')
                                        ->whereNotNull('location_desc')
                                        ->selectRaw('distinct location_desc')
                                        ->orderBy('location_desc')
                                        ->get();
        $listSearchLocatorDesc = CheckPointsV::where('qm_test_type_code','1')
                                            ->whereNotNull('locator_desc')
                                            ->selectRaw('distinct locator_desc')
                                            ->orderBy('locator_desc')
                                            ->get();
        $listSearchQmGroup = CheckPointsV::where('qm_test_type_code','1')
                                            ->whereNotNull('qm_group')
                                            ->selectRaw('distinct qm_group')
                                            ->orderBy('qm_group')
                                            ->get();     
        $checkPoints->map(function ($item, $key){
            $item->attachments = Attachments::where('table_source_id', $item['inventory_location_id'])
                                            ->where('table_source_name', 'MTL_ITEM_LOCATIONS')
                                            ->get();
            $item->isAttachments = count($item['attachments']) == 0 ? true : false;             
        });                           
        return view('qm.settings.check-points-tobacco-leaf.index',compact(  'checkPoints', 'search', 'listSearchLocationDesc',
                                                                            'listSearchLocatorDesc', 'listSearchQmGroup', 'btnTrans',
                                                                            'profile' ));
    }

    public function create()
    {
        $btnTrans = trans('btn');
        $workList = collect(\DB::select("
                                                select * 
                                                from PTWEB_LOOKUP_VALUE_SETUP_V
                                                where lookup_type = 'PTQM_MOISTURE_POINTS_GROUP'
                                                and enabled_flag = 'Y'
                                                                                                    "));
        return view('qm.settings.check-points-tobacco-leaf.create',compact('btnTrans', 'workList'));
    }

    public function store(Request $request)
    {
        $profile = getDefaultData('/qm/settings/check-points-tobacco-leaf');
        $this->validate($request,[
            'location_desc' => 'required', 
            'locator_desc' => 'required',
            'group_code' => 'required',
        ],[
            'location_desc.required' => 'กรุณากรอกชื่อจุดตรวจสอบ', 
            'locator_desc.required' => 'กรุณากรอกรายละเอียดจุดตรวจสอบ',
            'group_code.required' => 'กรุณาเลือกกลุ่มงาน',
        ]);

        $subinventoryCode = SubinventoriesV::where('organization_id',$profile->organization_id)
                                                ->value('subinv');
        $warehouseCode  = LocatorSegment1V::where('attribute23', $subinventoryCode)
                                                ->value('warehouse_code');

        $isDuplicate = CheckPointsV::where('location_desc', $request['location_desc'])
                                    ->where('qm_test_type_code','1')
                                    ->first();

        if($isDuplicate){
            return response()->json([   'data' => "ชื่อจุดตรวจสอบ: ". $request->location_desc ." มีอยู่ในระบบแล้ว",
                                        'status' => 'Duplicate'  ]);
        }

        \DB::beginTransaction();
        try {
            if(isset($request['files'])){
                foreach ($request['files'] as $key => $value){     
                    if($key == '0'){
                        $checkPoints = new CheckPointsT();
                        $checkPoints->organization_id       = $profile->organization_id;
                        $checkPoints->subinventory_code     = $subinventoryCode;
                        $checkPoints->warehouse_code        = $warehouseCode;
                        $checkPoints->location_desc         = $request->location_desc;
                        $checkPoints->location_code         = $request->location_code;
                        $checkPoints->locator_desc          = $request->locator_desc;
                        $checkPoints->group_code            = $request->group_code;
                        $checkPoints->enable_flag           = $request->enable_flag == "true" ? 'Y' : 'N' ;
                        $checkPoints->record_type           = "INSERT";
                        $checkPoints->web_batch_no          = date("YmdHis");
                        $checkPoints->program_code          = $profile->program_code;
                        $checkPoints->created_by_id         = $profile->user_id;
                        $checkPoints->created_by            = $profile->user_id;
                        $checkPoints->creation_date         = now();
                        $checkPoints->last_updated_by       = $profile->user_id;
                        $checkPoints->last_update_date      = now();
                        $checkPoints->qm_test_type          = 1;
                        $checkPoints->save();
                    
                        if(isset($request['files'])){
                            $attachment = new Attachments;
                            $attachment->createCheckPoints($checkPoints, $value);
                        }

                        $resultFund = (new CheckPointsT)->checkPoint($checkPoints);
                    }
                    
                    if($key > 0){
                        $checkPoints = new CheckPointsT();
                        $checkPoints->organization_id       = $profile->organization_id;
                        $checkPoints->subinventory_code     = $subinventoryCode;
                        $checkPoints->warehouse_code        = $warehouseCode;
                        $checkPoints->location_desc         = $request->location_desc;
                        $checkPoints->location_code         = $request->location_code;
                        $checkPoints->locator_desc          = $request->locator_desc;
                        $checkPoints->group_code            = $request->group_code;
                        $checkPoints->enable_flag           = $request->enable_flag == "true" ? 'Y' : 'N' ;
                        $checkPoints->record_type           = "UPDATE";
                        $checkPoints->web_batch_no          = date("YmdHis");
                        $checkPoints->program_code          = $profile->program_code;
                        $checkPoints->created_by_id         = $profile->user_id;
                        $checkPoints->created_by            = $profile->user_id;
                        $checkPoints->creation_date         = now();
                        $checkPoints->last_updated_by       = $profile->user_id;
                        $checkPoints->last_update_date      = now();
                        $checkPoints->qm_test_type          = 1;

                        $checkPoints->save();

                        if(isset($request['files'])){
                            $attachment = new Attachments;
                            $attachment->createCheckPoints($checkPoints, $value);
                        }

                        $resultFund = (new CheckPointsT)->checkPoint($checkPoints);
                    }
                }
            }else{
                $checkPoints = new CheckPointsT();
                $checkPoints->organization_id       = $profile->organization_id;
                $checkPoints->subinventory_code     = $subinventoryCode;
                $checkPoints->warehouse_code        = $warehouseCode;
                $checkPoints->location_desc         = $request->location_desc;
                $checkPoints->location_code         = $request->location_code;
                $checkPoints->locator_desc          = $request->locator_desc;
                $checkPoints->group_code            = $request->group_code;
                $checkPoints->enable_flag           = $request->enable_flag == "true" ? 'Y' : 'N' ;
                $checkPoints->record_type           = "INSERT";
                $checkPoints->web_batch_no          = date("YmdHis");
                $checkPoints->program_code          = $profile->program_code;
                $checkPoints->created_by_id         = $profile->user_id;
                $checkPoints->created_by            = $profile->user_id;
                $checkPoints->creation_date         = now();
                $checkPoints->last_updated_by       = $profile->user_id;
                $checkPoints->last_update_date      = now();
                $checkPoints->qm_test_type          = 1;

                $checkPoints->save();

                $resultFund = (new CheckPointsT)->checkPoint($checkPoints);
            }

            \DB::commit();

            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                return $result;
            }

        } catch (\Exception $e) {
            // ERROR CREATE
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                \Log::error($e->getMessage());
                return abort('403');
            }  
        }

        // return redirect()->route('qm.settings.check-points-tobacco-leaf.index')->with('success','ทำการเพิ่มรายการเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $btnTrans = trans('btn');
        $checkPoints = CheckPointsV::where('inventory_location_id',$id)
                                    ->get();            
        $workList = collect(\DB::select("
                                            select * 
                                            from PTWEB_LOOKUP_VALUE_SETUP_V
                                            where lookup_type = 'PTQM_MOISTURE_POINTS_GROUP'
                                            and enabled_flag = 'Y'
                                                                                                ")); 
        $checkPoints->map(function ($item, $key){
            $item->attachments = Attachments::where('table_source_id', $item['inventory_location_id'])
                                            ->where('table_source_name', 'MTL_ITEM_LOCATIONS')
                                            ->get();
            $item->limitImage = 5 - count($item['attachments']);
            $item->isUploadFlag = $item['limitImage'] == 0 ? true : false ;          
        });                                             
        return view('qm.settings.check-points-tobacco-leaf.edit', compact('checkPoints', 'btnTrans', 'workList'));
    }

    public function update(Request $request)
    {
        $profile = getDefaultData('/qm/settings/check-points-tobacco-leaf');
        $this->validate($request,[
            'location_desc' => 'required', 
            'locator_desc' => 'required',
            'group_code' => 'required',
        ],[
            'location_desc.required' => 'กรุณากรอกชื่อจุดตรวจสอบ', 
            'locator_desc.required' => 'กรุณากรอกรายละเอียดจุดตรวจสอบ',
            'group_code.required' => 'กรุณาเลือกกลุ่มงาน',
        ]);
        \DB::beginTransaction();
        try {
            if(isset($request['files'])){
                foreach ($request['files'] as $key => $value){
                    $checkPoints = new CheckPointsT();
                    $checkPoints->organization_id       = $profile->organization_id;
                    $checkPoints->subinventory_code     = $request->subinventory_code;
                    $checkPoints->warehouse_code        = $request->warehouse_code;
                    $checkPoints->location_desc         = $request->location_desc;
                    $checkPoints->location_code         = $request->location_code;
                    $checkPoints->locator_desc          = $request->locator_desc;
                    $checkPoints->group_code            = $request->group_code;
                    $checkPoints->enable_flag           = $request->enable_flag == "true" ? 'Y' : 'N' ;
                    $checkPoints->record_type           = "UPDATE";
                    $checkPoints->web_batch_no          = date("YmdHis");
                    $checkPoints->program_code          = $profile->program_code;
                    $checkPoints->created_by_id         = $profile->user_id;
                    $checkPoints->created_by            = $profile->user_id;
                    $checkPoints->creation_date         = now();
                    $checkPoints->last_updated_by       = $profile->user_id;
                    $checkPoints->last_update_date      = now();
                    $checkPoints->qm_test_type          = 1;

                    $checkPoints->save();
                
                    if(isset($request['files'])){
                        $attachment = new Attachments;
                        $attachment->createCheckPoints($checkPoints, $value);
                    }

                    $resultFund = (new CheckPointsT)->checkPoint($checkPoints);
                }
            }else{
                $checkPoints = new CheckPointsT();
                $checkPoints->organization_id       = $profile->organization_id;
                $checkPoints->subinventory_code     = $request->subinventory_code;
                $checkPoints->warehouse_code        = $request->warehouse_code;
                $checkPoints->location_desc         = $request->location_desc;
                $checkPoints->location_code         = $request->location_code;
                $checkPoints->locator_desc          = $request->locator_desc;
                $checkPoints->group_code            = $request->group_code;
                $checkPoints->enable_flag           = $request->enable_flag == "true" ? 'Y' : 'N' ;
                $checkPoints->record_type           = "UPDATE";
                $checkPoints->web_batch_no          = date("YmdHis");
                $checkPoints->program_code          = $profile->program_code;
                $checkPoints->created_by_id         = $profile->user_id;
                $checkPoints->created_by            = $profile->user_id;
                $checkPoints->creation_date         = now();
                $checkPoints->last_updated_by       = $profile->user_id;
                $checkPoints->last_update_date      = now();
                $checkPoints->qm_test_type          = 1;

                $checkPoints->save();

                $resultFund = (new CheckPointsT)->checkPoint($checkPoints);
            }
            \DB::commit();

            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                return $result;
            }

        } catch (\Exception $e) {
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                \Log::error($e->getMessage());
                return abort('403');
            }  
        }

        // return redirect()->route('qm.settings.check-points-tobacco-leaf.index')->with('success','ทำการเปลี่ยนข้อมูลเรียบร้อยแล้ว');
    }

}
