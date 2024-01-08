<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\PM\Settings\TransactionTypes;
use App\Models\PM\Settings\CoaDeptCodeV;
use App\Models\PM\Settings\OrgTransfer;
use App\Models\PM\Settings\SetupMfgDepartmentsV;
use App\Models\PM\Settings\TobaccoItemcatSeg1V;
use App\Models\PM\Settings\Parameters;
use App\Models\PM\Settings\ItemLocationsKfv;
use App\Models\PM\Settings\LookupValues;
use App\Models\ProgramInfo;

use App\Repositories\PM\Settings\SavePublicationLayoutRepository;
use App\Models\PM\Settings\PtpmConvertItemsInfo;
use App\Models\PM\Settings\ItemNumberV;

class OrgTransferController extends Controller
{
    public function index(Request $request)
    {
       
        
        $organizationId = getDefaultData('/pm/settings/org-tranfer/create')->organization_id;
        $search = request()->search;
        $setupMfgDeprtments = SetupMfgDepartmentsV::search($search)
                                                ->where('organization_id', $organizationId)
                                                ->orderBy('id')
                                                ->skip($request->start)->take($request->length)->get();
                                                // ->appends(['search' => $search]);
        $setupMfgDeprtments->map(function ($item, $index) {
            $item->_html_enable_flag = "<div class='tw-text-center'>".view('shared._status_active', [
                'isActive' => $item->enable_flag == 'Y' ? true : false,
            ])->render() . "</div>";

            $item->_html_action = "<a href='" . route('pm.settings.org-tranfer.edit', $item->id) ."'
                                        class=\"btn btn-warning btn-sm\">
                                        <i class=\"fa fa-edit\"></i> แก้ไข
                                    </a>";
            $item->itemTypeTH = LookupValues::where('lookup_type','ITEM_TYPE')
                                            ->where('attribute10','YES')
                                            ->where('lookup_code',$item['inv_item_type'])
                                            ->value('attribute11');
        }); 

        if($request->ajax()) {
            $recordsFiltered = SetupMfgDepartmentsV::search($search)
                    ->where('organization_id', $organizationId)
                    ->orderBy('id')->count();
                    
            $recordsTotal = SetupMfgDepartmentsV::search($search)
                ->where('organization_id', $organizationId)
                ->orderBy('id')->count();
            return response()->json([
                'draw' => $request->draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $setupMfgDeprtments,
            ]);
        }
        $wipTransaction = TransactionTypes::where('attribute2', 'Y')
                                        ->orderBy('transaction_type_id')
                                        ->get();

        if(isset($search['querySearch'])){
            $transactionTypes = TransactionTypes::where('transaction_type_name', 'like', '%'.$search['querySearch'].'%')
                                                ->orderBy('transaction_type_id')
                                                // ->whereRaw("(attribute2 != 'Y' or attribute2 is null)")
                                                ->get();
        }else{
            $transactionTypes = TransactionTypes::orderBy('transaction_type_id')
                                    // ->whereRaw("(attribute2 != 'Y' or attribute2 is null)")
                                    // ->limit(100)
                                    ->get();
        }
 
        $tobaccoItemcats = TobaccoItemcatSeg1V::where('enabled_flag', 'Y')
                                        ->get();

        return view('pm.settings.org-tranfer.index',compact('setupMfgDeprtments', 'wipTransaction', 'transactionTypes',
                                                            'tobaccoItemcats', 'search', 'organizationId'));
    }

    public function create()
    {
        $organizationId = getDefaultData('/pm/settings/org-tranfer/create')->organization_id;
        // $orgM12 = Parameters::where('organization_code', 'M12')->first();
        $lookupValuesTable = (new LookupValues)->getTable();
        $deprtments = CoaDeptCodeV::where('enabled_flag', 'Y')
                                    ->get();
        $tobaccoItemcats = TobaccoItemcatSeg1V::where('enabled_flag', 'Y')
                                                ->get();
        $transactionTypes = TransactionTypes::orderBy('transaction_type_id')
                                            // ->whereRaw("(attribute2 != 'Y' or attribute2 is null)") // พี่บังคุยกับแจมแล้ว ให้แสดงทั้งหมดเลย เพราะจะตั้งค่า ข้าม item
                                            // ->limit(100)
                                            ->get();
        $wipTransaction = TransactionTypes::where('attribute2', 'Y')
                                        ->orderBy('transaction_type_id')
                                        ->get();

        $parameters = Parameters::with('HrAllOrganizationUnits')
                                ->orderBy('organization_code', 'asc')
                                ->get();

        $dataItemTypes = collect(\DB::select("
                                                select * 
                                                from    {$lookupValuesTable}
                                                where   lookup_type = 'ITEM_TYPE'
                                                and     attribute10 ='YES'          "));

        return  view('pm.settings.org-tranfer.create',
                compact('deprtments', 'tobaccoItemcats', 'transactionTypes', 'parameters', 'wipTransaction', 'organizationId', 'dataItemTypes'));
                // compact('deprtments', 'tobaccoItemcats', 'transactionTypes', 'parameters', 'wipTransaction', 'organizationId', 'dataItemTypes', 'orgM12'));
    }

    public function store(Request $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $organization_id = getDefaultData('/pm/settings/org-tranfer/store')->organization_id;
        // $orgM12 = Parameters::where('organization_code', 'M12')->first();
        // if($organization_id == $orgM12['organization_id']){
        //     $this->validate($request,[
        //         'item_type'                     => 'required',
        //         'from_organization_id'          => 'required',
        //         'from_locator_id'               => 'required',
        //         'to_organization_id'            => 'required',
        //         'to_locator_id'                 => 'required',
        //         'wip_transaction_type_id'       => 'required',
        //         'inv_item_type'                 => 'required',
        //     ], [
        //         'item_type.required'                => 'โปรดเลือก ประเภท Item',
        //         'from_organization_id.required'     => 'โปรดเลือก จากที่อยู่ organization',
        //         'from_locator_id.required'          => 'โปรดเลือก จากที่อยู่ สถานที่',
        //         'to_organization_id.required'       => 'โปรดเลือก ถึงที่อยู่ จากที่อยู่organization',
        //         'to_locator_id.required'            => 'โปรดเลือก ถึงที่อยู่ จากที่ สถานที่',
        //         'wip_transaction_type_id.required'  => 'โปรดเลือก คลังสำหรับทำรายการ', 
        //         'inv_item_type.required'            => 'โปรดเลือก ประเภทวัตถุดิบ',               
        //     ]);
        // }else {
            $this->validate($request,[
                'item_type'                     => 'required',
                'from_organization_id'          => 'required',
                'from_locator_id'               => 'required',
                'to_organization_id'            => 'required',
                'to_locator_id'                 => 'required',
                'transaction_type_id'           => 'required',
                'wip_transaction_type_id'       => 'required',
            ], [
                'item_type.required'                => 'โปรดเลือก ประเภท Item',
                'from_organization_id.required'     => 'โปรดเลือก จากที่อยู่ organization',
                'from_locator_id.required'          => 'โปรดเลือก จากที่อยู่ สถานที่',
                'to_organization_id.required'       => 'โปรดเลือก ถึงที่อยู่ จากที่อยู่organization',
                'to_locator_id.required'            => 'โปรดเลือก ถึงที่อยู่ จากที่ สถานที่',
                'transaction_type_id.required'      => 'โปรดเลือกประเภทการทำรายการ',
                'wip_transaction_type_id.required'  => 'โปรดเลือกคลังสำหรับทำรายการ',                
            ]);
        // }
        $subinventoryFrom = ItemLocationsKfv::select('subinventory_code')
                                                ->where('inventory_location_id',request()->from_locator_id)
                                                ->pluck('subinventory_code');
        $subinventoryTo = ItemLocationsKfv::select('subinventory_code')
                                                ->where('inventory_location_id',request()->to_locator_id)
                                                ->pluck('subinventory_code');
        $programCode = ProgramInfo::where('program_code','PMS0022')
                                    ->value('program_code');


        $checkLetterPageType = (new SavePublicationLayoutRepository)->isLetterPageType($transId = $request->transaction_type_id);
        if ($checkLetterPageType) {
            $error = $this->validateLetterPageType($request, $tobaccoGroupCode = $request->item_type);
            if ($error) {
                return redirect()->back()->withErrors($error)->withInput();
            }

        } else {
            $isDuplicate = OrgTransfer::where('item_type', $request->item_type)
                                    ->where('from_organization_id', $request->from_organization_id)
                                    ->where('from_locator_id', $request->from_locator_id)
                                    ->where('from_subinventory', $subinventoryFrom[0])
                                    ->where('to_organization_id', $request->to_organization_id)
                                    ->where('to_locator_id', $request->to_locator_id)
                                    ->where('to_subinventory', $subinventoryTo[0])
                                    ->where('transaction_type_id', $request->transaction_type_id)
                                    ->where('wip_transaction_type_id', $request->wip_transaction_type_id)
                                    ->where('organization_id', $organization_id)
                                    ->first();   
            if($isDuplicate){
                return redirect()->route('pm.settings.org-tranfer.create')->withErrors(['มีข้อมูลการบันทึกคลังสินค้าในการรับ-ส่งข้อมูลซ้ำ']);
            }  
        }


        

        \DB::beginTransaction();
        try {
            $orgTransfer                            = new OrgTransfer();
            $orgTransfer->item_type                 = $request->item_type;
            $orgTransfer->from_organization_id      = $request->from_organization_id;
            $orgTransfer->from_locator_id           = $request->from_locator_id;
            $orgTransfer->from_subinventory         = $subinventoryFrom[0];
            $orgTransfer->to_organization_id        = $request->to_organization_id;
            $orgTransfer->to_locator_id             = $request->to_locator_id;
            $orgTransfer->to_subinventory           = $subinventoryTo[0];
            $orgTransfer->transaction_type_id       = $request->transaction_type_id;
            $orgTransfer->enable_flag               = $request->enable_flag == "true" ? 'Y' : 'N';
            $orgTransfer->inv_item_type             = $request->inv_item_type ? $request->inv_item_type : '';
            $orgTransfer->program_id                = $programCode;
            $orgTransfer->created_by                = $userId;
            $orgTransfer->creation_date             = now(); 
            $orgTransfer->last_updated_by           = $userId;
            $orgTransfer->last_update_date          = now();
            $orgTransfer->wip_transaction_type_id   = $request->wip_transaction_type_id;
            $orgTransfer->organization_id           = $organization_id;

            $orgTransfer->save();
          
            // SUCCESS CREATE
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

        return redirect()->route('pm.settings.org-tranfer.index')->with('success','ทำการบันทึกข้อมูลเรียบร้อยแล้ว');

    }

    public function edit($id)
    {
        $dataSetup = SetupMfgDepartmentsV::find($id); 
        // $orgM12 = Parameters::where('organization_code', 'M12')->first();
        $lookupValuesTable = (new LookupValues)->getTable();
        $organizationId = getDefaultData('/pm/settings/org-tranfer/create')->organization_id;
        $wipTransaction = TransactionTypes::where('attribute2', 'Y')
                                        ->orderBy('transaction_type_id')
                                        ->get();
        $tobaccoItemcats = TobaccoItemcatSeg1V::where('enabled_flag', 'Y')
                                        ->get();  
        $transactionTypes = TransactionTypes::where('transaction_type_id',$dataSetup['transaction_type_id'])
                                        // ->whereRaw("(attribute2 != 'Y' or attribute2 is null)")
                                        ->orderBy('transaction_type_id')
                                        ->limit(100)
                                        ->get();
        $parameters = Parameters::with('HrAllOrganizationUnits')
                                ->orderBy('organization_code', 'asc')
                                ->get();
        
        $dataItemTypes = collect(\DB::select("
                                                select * 
                                                from    {$lookupValuesTable}
                                                where   lookup_type = 'ITEM_TYPE'
                                                and     attribute10 ='YES'          "));

        return  view('pm.settings.org-tranfer.edit',
                compact('dataSetup', 'wipTransaction', 'tobaccoItemcats', 'transactionTypes', 'parameters', 'organizationId', 'dataItemTypes'));
                // compact('dataSetup', 'wipTransaction', 'tobaccoItemcats', 'transactionTypes', 'parameters', 'organizationId', 'dataItemTypes', 'orgM12'));
    }

    public function update (Request $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $organization_id = getDefaultData('/pm/settings/org-tranfer/update')->organization_id;
        $subinventoryFrom = ItemLocationsKfv::select('subinventory_code')
                                                ->where('inventory_location_id',request()->from_locator_id)
                                                ->value('subinventory_code');
        $subinventoryTo = ItemLocationsKfv::select('subinventory_code')
                                                ->where('inventory_location_id',request()->to_locator_id)
                                                ->value('subinventory_code');
        $programCode = ProgramInfo::where('program_code','PMS0022')
                                ->value('program_code');
        // $orgM12 = Parameters::where('organization_code', 'M12')->first();
        // if($organization_id == $orgM12['organization_id']){
        //     $this->validate($request,[
        //         'tobacco_group_code'            => 'required',
        //         'from_organization_id'          => 'required',
        //         'from_locator_id'               => 'required',
        //         'to_organization_id'            => 'required',
        //         'to_locator_id'                 => 'required',
        //         'wip_transaction_type_id'       => 'required',
        //         'inv_item_type'                 => 'required',
        //     ], [
        //         'tobacco_group_code.required'       => 'โปรดเลือก ประเภท Item',
        //         'from_organization_id.required'     => 'โปรดเลือก จากที่อยู่ organization',
        //         'from_locator_id.required'          => 'โปรดเลือก จากที่อยู่ สถานที่',
        //         'to_organization_id.required'       => 'โปรดเลือก ถึงที่อยู่ จากที่อยู่organization',
        //         'to_locator_id.required'            => 'โปรดเลือก ถึงที่อยู่ จากที่ สถานที่',
        //         'wip_transaction_type_id.required'  => 'โปรดเลือกคลังสำหรับทำรายการ',     
        //         'inv_item_type.required'            => 'โปรดเลือก ประเภทวัตถุดิบ',                          
        //     ]);
        // }else {
            $this->validate($request,[
                'tobacco_group_code'            => 'required',
                'from_organization_id'          => 'required',
                'from_locator_id'               => 'required',
                'to_organization_id'            => 'required',
                'to_locator_id'                 => 'required',
                'transaction_type_id'           => 'required',
                'wip_transaction_type_id'       => 'required',
            ], [
                'tobacco_group_code.required'       => 'โปรดเลือก ประเภท Item',
                'from_organization_id.required'     => 'โปรดเลือก จากที่อยู่ organization',
                'from_locator_id.required'          => 'โปรดเลือก จากที่อยู่ สถานที่',
                'to_organization_id.required'       => 'โปรดเลือก ถึงที่อยู่ จากที่อยู่organization',
                'to_locator_id.required'            => 'โปรดเลือก ถึงที่อยู่ จากที่ สถานที่',
                'transaction_type_id.required'      => 'โปรดเลือกประเภทการทำรายการ',
                'wip_transaction_type_id.required'  => 'โปรดเลือกคลังสำหรับทำรายการ',                
            ]);
        // }
        $checkLetterPageType = (new SavePublicationLayoutRepository)->isLetterPageType($transId = $request->transaction_type_id);
        if ($checkLetterPageType) {

            $error = $this->validateLetterPageType($request
                , $tobaccoGroupCode = $request->tobacco_group_code
                , $orgTransferId = $request->id
            );
            if ($error) {
                return redirect()->back()->withErrors($error)->withInput();
            }

        }else{
            if($request->enable_flag == $request->old_enable_flag && $request->inv_item_type == $request->old_inv_item_type){
                $isDuplicate = OrgTransfer::where('item_type', $request->tobacco_group_code)
                                    ->where('from_organization_id', $request->from_organization_id)
                                    ->where('from_locator_id', $request->from_locator_id)
                                    ->where('from_subinventory', $subinventoryFrom)
                                    ->where('to_organization_id', $request->to_organization_id)
                                    ->where('to_locator_id', $request->to_locator_id)
                                    ->where('to_subinventory', $subinventoryTo)
                                    ->where('transaction_type_id', $request->transaction_type_id)
                                    ->where('wip_transaction_type_id', $request->wip_transaction_type_id)
                                    ->where('organization_id', $organization_id)
                                    ->first();   
                if($isDuplicate){
                    return redirect()->route('pm.settings.org-tranfer.index')->withErrors(['มีข้อมูลการบันทึกคลังสินค้าในการรับ-ส่งข้อมูลซ้ำ']);
                }
            }  
        }

        \DB::beginTransaction();
        try {
                $orgTransfer                                = OrgTransfer::find($request->id);
                $orgTransfer->item_type                     = $request['tobacco_group_code'];
                $orgTransfer->from_organization_id          = $request['from_organization_id'];
                $orgTransfer->from_locator_id               = $request['from_locator_id'];
                $orgTransfer->from_subinventory             = $subinventoryFrom;
                $orgTransfer->to_organization_id            = $request['to_organization_id'];
                $orgTransfer->to_locator_id                 = $request['to_locator_id'];
                $orgTransfer->to_subinventory               = $subinventoryTo;
                $orgTransfer->transaction_type_id           = $request['transaction_type_id'];
                $orgTransfer->enable_flag                   = $request['enable_flag'] == "true" ? 'Y' : 'N';
                $orgTransfer->end_date                      = $request['enable_flag'] == "true" ? '' : now();
                $orgTransfer->inv_item_type                 = $request['inv_item_type'] ? $request['inv_item_type'] : '';
                $orgTransfer->wip_transaction_type_id       = $request['wip_transaction_type_id'];
                $orgTransfer->organization_id               = $organization_id;
                $orgTransfer->last_updated_by               = $userId;
                $orgTransfer->last_update_date              = now();
                $orgTransfer->save();

                \DB::commit();

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

        return redirect()->route('pm.settings.org-tranfer.index')->with('success','ทำการเปลี่ยนข้อมูลบันทึกคลังสินค้าในการรับ-ส่งข้อมูลเรียบร้อยแล้ว');
    }


    public function validateLetterPageType($request, $tobaccoGroupCode, $orgTransferId = false)
    {
        $organizationId = getDefaultData('/pm/settings/org-tranfer/create')->organization_id;
        $isDuplicated = SetupMfgDepartmentsV::where('organization_id', $organizationId)
                            ->where('tobacco_group_code', $tobaccoGroupCode)
                            ->where('transaction_type_id', $request->transaction_type_id)
                            ->where('from_organization_id', $request->from_organization_id)
                            ->where('to_organization_id', $request->to_organization_id)
                            ->when($orgTransferId, function ($q) use ($orgTransferId) {
                                $q->where('id', '<>', $orgTransferId);
                            })
                            ->get();

        if (count($isDuplicated) > 0) {
            // $fmOrg = Parameters::where('organization_id', $request->from_organization_id)->first();
            // $toOrg = Parameters::where('organization_id', $request->to_organization_id)->first();
            return "มีข้อมูลการบันทึก Organization การรับ-ส่งข้อมูลซ้ำ";
        }

        if ($orgTransferId) {
            $convers = PtpmConvertItemsInfo::where('org_transfer_id', $orgTransferId)->where('enable_flag', 'Y')->get();

            if ($request->enable_flag != "true") {
                if (count($convers) > 0) {
                    $itemList = $convers->pluck('from_inventory_item_id', 'from_inventory_item_id')->all();
                    $items = ItemNumberV::where('organization_id', $organizationId)
                                ->whereIn('inventory_item_id', $itemList)
                                ->get();
                    $msg = "ไม่สามารถปิดการใช้งานได้ เนื่องจากผูกข้อมูการข้าม Item ดังนี้";
                    foreach ($items as $key => $item) {
                        $msg = $msg . $item->item_number . ": ". $item->item_desc . ', ';
                    }
                    return $msg;
                }
            }

            $setup = SetupMfgDepartmentsV::where('id', $orgTransferId)->first();
            foreach ($convers as $key => $conversion) {
                (new SavePublicationLayoutRepository)->conversionInfoUpdateSetup($conversion, $setup);
            }
        }

        return '';
    }
}
