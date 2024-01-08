<?php

namespace App\Http\Controllers\EAM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\EAM\LOV\Activity;
use App\Models\EAM\LOV\ActivityPriority;
use App\Models\EAM\LOV\Area;
use App\Models\EAM\LOV\AssetGroup;
use App\Models\EAM\LOV\AssetNumber;
use App\Models\EAM\LOV\Departments;
use App\Models\EAM\LOV\DepResource;
use App\Models\EAM\LOV\Employee;
use App\Models\EAM\LOV\StatusYN;
use App\Models\EAM\LOV\WipClass;
use App\Models\EAM\LOV\WorkRequestStatus;
use App\Models\EAM\LOV\workReceiptStatus;
use App\Models\EAM\LOV\WorkRequestType;
use App\Models\EAM\LOV\WorkRequest;
use App\Models\EAM\LOV\ItemInventory;
use App\Models\EAM\LOV\ItemNonstock;
use App\Models\EAM\LOV\MaterialType;
use App\Models\EAM\LOV\Suvinventory;
use App\Models\EAM\LOV\locatorV;
use App\Models\EAM\LOV\AssetActivity;
use App\Models\EAM\LOV\Issue;
use App\Models\EAM\LOV\WorkOrderStatus;
use App\Models\EAM\LOV\WorkOrderType;
use App\Models\EAM\LOV\ShutdownType;
use App\Models\EAM\LOV\WorkOrderHVid;
use App\Models\EAM\LOV\MtlParameter;
use App\Models\EAM\LOV\MachineUomV;
use App\Models\EAM\LOV\LocatorPmV;
use App\Models\EAM\LOV\OperationV;
use App\Models\EAM\LOV\MachineType;
use App\Models\EAM\LOV\WoMtLot;
use App\Models\EAM\LOV\OrganizationV;
use App\Models\EAM\LOV\DepartmentResourcesV;
use App\Models\EAM\LOV\ResourceV;
use App\Models\EAM\LOV\JobStatusV;
use App\Models\EAM\LOV\ResourceEmployeeV;
use App\Models\EAM\LOV\DepartmentEmployeeV;
use App\Models\EAM\LOV\PTWUsers;
use App\Models\EAM\LOV\FaAssetV;
use App\Models\EAM\LOV\ReasonsV;

use App\Models\EAM\WorkOrderHV;
use App\Models\EAM\WorkOrderMtV;
use App\Models\EAM\WorkOrderOpV;
use App\Models\EAM\WorkOrderReV;
use App\Models\EAM\AssetV;
use App\Models\EAM\LOV\PreiodV;
use App\Models\EAM\LOV\PtglPeriodV;
use App\Models\EAM\LOV\RequestStatusV;
use App\Models\EAM\LOV\WebUserV;
use App\Models\EAM\RequestEquipHV;
use App\Models\EAM\CheckOnHandV;
use App\Models\EAM\RequestMatNonV;
use App\Models\EAM\MtlParametersView;

use Session;

class LovController extends Controller
{
    private $limit = 20;
    /**
     * LOV: Asset Number
     *
     */
    public function assetNumber(Request $request)
    {
        try {
            $service = new AssetNumber();
            $data = $service->search($request);
            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function assetVassetNumber(Request $request)
    {
        try {
            $service = new AssetV();
            $data = $service->searchAssetNumber($request);
            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function childAssetNumber(Request $request, $parent)
    {
        $limit          = $request->p_limit ??  $this->limit;
        $data = AssetNumber::where('parent', $parent)->select('pteam_asset_number_v.*', 'pteam_asset_v.jp_status', 'pteam_departments_v.description as department_description')
                            ->leftJoin('pteam_asset_v', 'pteam_asset_number_v.asset_number', '=', 'pteam_asset_v.asset_number')
                            ->leftJoin('pteam_departments_v', 'pteam_asset_number_v.department', '=', 'pteam_departments_v.department_code')
                            ->paginate($limit);
        return response()->json(['data' => $data]);
    }

    public function departments(Request $request)
    {
        $limit          = $request->p_limit ??  $this->limit;
        $code           = trim($request->p_department_code ?? '%');
        $description    = trim($request->p_description ?? '%');
        $setDefault     = trim($request->p_set_default ?? null);

        $data = Departments::whereRaw("lower(department_code) like lower('{$code}') ")
                            ->whereRaw("lower(description) like lower('{$description}') ");
        if($request->select2 == 1) {
            $data = $data->whereRaw("CONCAT(department_code, CONCAT(' : ', lower(description))) LIKE '%". $request->select ."%'");
        }
        if($setDefault != null){
            $data = $data->where('attribute2', 'Yes');
        }

        $data = $data->paginate($limit);
        return response()->json($data);
    }

    public function departments2(Request $request)
    {
        $searchParam    = trim($request->search_param ?? '%');

        $query = Departments::select('department_code','description');
        if ($searchParam != '%') {
            $query = $query->where(function ($squery) use ($searchParam) {
                $squery->where('department_code', 'like', '%' . $searchParam . '%')
                    ->orWhere('description', 'like', '%' . $searchParam . '%');
            });
        }
        $data = $query->paginate();


        return response()->json($data);
    }

    public function workRequestStatus()
    {
        $data = WorkRequestStatus::get();
        return response()->json(['data' => $data]);
    }


    public function workReceiptStatus(Request $request)
    {
        // $data = workReceiptStatus::get();
        $search = (isset($request->p_search)) ? $request->p_search : '';
        $q = ' ';

        if ($search != '') {
            $q = " WHERE wip_entity_name LIKE '%$search%' OR  description LIKE '%$search%' ";
        }

        $data = collect(DB::select("
        SELECT
            wip_entity_id,
            wip_entity_name,
            description,
            wip_entity_name ||' : '|| description AS name
        FROM
            pteam_work_order_h_v
        $q
        ORDER BY
            wip_entity_name,
            description
        FETCH FIRST 30 ROWS ONLY
        "));


        return response()->json(['data' => $data]);
    }

    public function employee(Request $request)
    {
        $limit          = $request->p_limit ??  $this->limit;
        $fullName       = trim($request->p_full_name ?? '%');
        $employeeNumber = trim($request->p_employee_number ?? '%');
        if($request['select2'] == '1'){
            $data = Employee::whereRaw("LOWER(CONCAT(employee_number, CONCAT(' : ', full_name))) LIKE LOWER('%". $request['select'] ."%')")
                            ->paginate($limit);
        }else{
            $data = Employee::whereRaw("lower(full_name) like lower('{$fullName}') ")
                        ->whereRaw("lower(employee_number) like lower('{$employeeNumber}') ")
                        ->paginate($limit);
        }

        return response()->json($data);
    }

    public function workRequestType()
    {
        $data = WorkRequestType::get();
        return response()->json(['data' => $data]);
    }

    public function activityPriority()
    {
        $data = ActivityPriority::get();
        return response()->json(['data' => $data]);
    }

    public function workRequestView(Request $request)
    {
        $limit              = $request->p_limit ?? $this->limit;
        $workRequestNumber  = trim($request->p_work_request_number ?? '%');
        if($request['select2'] == '1'){
            $data = WorkRequest::whereRaw("lower(work_request_number) LIKE LOWER('%". $request['select'] ."%')")
                                ->paginate($limit);
        }else{
            $data = WorkRequest::whereRaw("lower(work_request_number) like lower('{$workRequestNumber}') ")
                                ->paginate($limit);
        }
        
        foreach ($data as $value) {
            $value->creation_date = parseToDateTh($value->creation_date);
        }
        return response()->json($data);
    }

    public function workOrderHVId(Request $request)
    {
        $wipEntityName = (isset($request->p_wip_entity_name)) ? $request->p_wip_entity_name : '%';
        $limit          = $request->p_limit ??  $this->limit;
        $data = WorkOrderHVid::where('WIP_ENTITY_NAME', 'LIKE', '%'.$wipEntityName.'%')->paginate($limit);
        return response()->json(['data' => $data]);
    }

    public function WorkOrderOpVseqnum(Request $request)
    {
        $wipEntityId = (isset($request->p_wip_entity_id)) ? $request->p_wip_entity_id : '%';
        $datas = WorkOrderOpV::where('wip_entity_id', $wipEntityId)
            ->select('pteam_work_order_op_v.*', 'pteam_departments_v.department_code')
            ->leftJoin('pteam_departments_v', 'pteam_work_order_op_v.department_description', '=', 'pteam_departments_v.description')
            ->orderBy('operation_seq_num', 'ASC')
            ->get();
        return response()->json(['data' => $datas]);
    }

    public function WorkOrderReVseqnum(Request $request)
    {
        $wipEntityId = (isset($request->p_wip_entity_id)) ? $request->p_wip_entity_id : '%';
        $datas = WorkOrderReV::where('wip_entity_id', $wipEntityId)->orderBy('resource_seq_num', 'ASC')->get();
        return response()->json(['data' => $datas]);
    }

    public function WorkOrderReVResource(Request $request)
    {
        $wipEntityId = (isset($request->p_wip_entity_id)) ? $request->p_wip_entity_id : '%';
        $operationSeqNum = (isset($request->p_operation_seq_num)) ? $request->p_operation_seq_num : '%';
        $query = WorkOrderReV::select('pteam_work_order_re_v.operation_seq_num', 'pteam_work_order_re_v.RESOURCE_CODE', 'pteam_work_order_re_v.resource_seq_num', 'pteam_resource_v.description', 'pteam_resource_v.resource_id')
            ->distinct()
            ->leftJoin('pteam_resource_v', 'pteam_work_order_re_v.resource_code', '=', 'pteam_resource_v.resource_code');

        if ($wipEntityId != '%') {
            $query = $query->where('wip_entity_id', $wipEntityId);
        }
        if ($operationSeqNum != '%') {
            $query = $query->where('operation_seq_num', $operationSeqNum);
        }
        $datas = $query->get();
        return response()->json(['data' => $datas]);
    }

    public function wipClass(Request $request)
    {
        $description = (isset($request->description)) ? $request->description : '%';
        $classCode = (isset($request->class_code)) ? $request->class_code : '%';
        $departmentCode = (isset($request->department_code)) ? $request->department_code : '%';
        $limit          = $request->p_limit ??  $this->limit;

        if($request['select2'] == '1'){
            $data = WipClass::whereRaw("LOWER(CONCAT(class_code, CONCAT(' : ', description))) LIKE LOWER('%". $request['select'] ."%')")
                            ->paginate($limit);
        }else{
            $data = WipClass::where('description', 'like', $description)
                            ->where('class_code', 'like', $classCode)
                            ->where('department', 'like', $departmentCode)
                            ->paginate($limit);
        }

        return response()->json(['data' => $data]);
    }

    public function depResource(Request $request)
    {
        $departmentCode = (isset($request->department_code)) ? $request->department_code : '%';
        $data = DepResource::where('department_code', 'like', $departmentCode)
                            ->select('pteam_dep_resource_v.*', 'pteam_resource_v.resource_id')
                            ->leftJoin('pteam_resource_v', 'pteam_resource_v.resource_code', '=', 'pteam_dep_resource_v.resource_code')
                            ->get();
        return response()->json(['data' => $data]);
    }

    public function statusYN()
    {
        $data = StatusYN::select('flex_value', 'flex_value_meaning', 'description')->get();
        return response()->json(['data' => $data]);
    }

    public function periodYear()
    {
        $data = PtglPeriodV::get();
        return response()->json(['data' => $data]);
    }

    public function periodYear2(Request $request)
    {
        $searchParam    = trim($request->search_param ?? '%');

        $query = DB::table('PT_YEARS_V')->select('year_thai');
        if ($searchParam != '%') {
            $query = $query->where(function ($squery) use ($searchParam) {
                $squery->where('year_thai', 'like', '%' . $searchParam . '%');
            });
        }
        $data = $query->paginate();


        return response()->json($data);
    }

    public function activity()
    {
        $data = Activity::get();
        return response()->json(['data' => $data]);
    }

    public function ItemInventory(Request $request)
    {
        if($request['select2'] == '1'){
            $result = ItemInventory::whereRaw("LOWER(CONCAT(item_code, CONCAT(' : ', item_description))) LIKE LOWER('%". $request['select'] ."%')")
                                    ->paginate('1000');
            return response()->json($result);
        }else{
            try {
                $result = (new ItemInventory())->Search($request->all());
                return response()->json($result);
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }        
    }

    public function ItemNonstock(Request $request)
    {
        try {
            if($request['select2'] == '1'){
                $data = ItemNonstock::whereRaw("LOWER(CONCAT(item_code, CONCAT(' : ', item_description))) LIKE LOWER('%". $request['select'] ."%')")
                                    ->paginate('1000');
            }else{
                $data = (new ItemNonstock())->Search($request->all());
            }
            return response()->json($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function ItemNonstockMtv(Request $request)
    {
        try {

            $itemCode = (isset($request->item_code)) ? $request->item_code : '%';

            $data = WorkOrderMtV::select('item_code', 'item_description')->distinct()
                ->where('item_code', 'like', $itemCode)
                ->get();

            return response()->json($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function MaterialType()
    {
        $data = MaterialType::get();
        return response()->json(['data' => $data]);
    }

    public function Suvinventory(Request $request)
    {
        $current_department = optional(\Session::get('current_department'))->department_code;

        $departmentCode = (isset($request->p_department_code)) ? $request->p_department_code : '%';

        $query = Suvinventory::select('*');
        // $query = $query->where('department_code', 'like', $current_department);
        if ($departmentCode != '%') {
            $query = $query->where('department_code', $departmentCode);
        }
        $data = $query->get();
        return response()->json(['data' => $data]);
    }

    public function LocatorV(Request $request)
    {
        $subinventoryName = (isset($request->p_subinventory_name)) ? $request->p_subinventory_name : '%';
        $data = LocatorV::where('subinventory_name', 'like', $subinventoryName)
            ->get();
        return response()->json(['data' => $data]);
    }

    public function AssetActivity(Request $request)
    {
        $assetNumber = (isset($request->p_asset_number)) ? $request->p_asset_number : '%';
        $data = AssetActivity::where('asset_number', 'like', $assetNumber)->get();
        return response()->json(['data' => $data]);
    }

    public function Issue()
    {
        $data = Issue::get();
        return response()->json(['data' => $data]);
    }

    public function WorkOrderStatus()
    {
        $data = WorkOrderStatus::get();
        return response()->json(['data' => $data]);
    }

    public function WorkOrderType()
    {
        $data = WorkOrderType::get();
        return response()->json(['data' => $data]);
    }

    public function ShutdownType()
    {
        $data = ShutdownType::get();
        return response()->json(['data' => $data]);
    }

    public function Area(Request $request)
    {
        $code           = trim($request->p_code ?? '%');
        $description    = trim($request->p_description ?? '%');
        $limit          = $request->p_limit ??  $this->limit;
        if($request['select2'] == '1'){
            $data = Area::whereRaw("LOWER(CONCAT(area, CONCAT(' : ', description))) LIKE LOWER('%". $request['select'] ."%')")
                        ->paginate($limit);
        }else{
            $data = Area::whereRaw("lower(area) like lower('{$code}') ")
                        ->whereRaw("lower(description) like lower('{$description}') ")
                        ->paginate($limit);
        }
        
        return response()->json($data);
    }

    public function assetVNumber(Request $request)
    {
        $assetNumber = (isset($request->p_asset_number)) ? $request->p_asset_number : '%';
        $limit          = $request->p_limit ??  $this->limit;
        $data = AssetV::where('asset_number', 'like', $assetNumber)
                        ->paginate($limit);
        return response()->json(['data' => $data]);
    }

    public function assetGroup()
    {
        $data = AssetGroup::get();
        return response()->json(['data' => $data]);
    }
    public function productionOrganization()
    {
        $data = MtlParameter::select('organization_code')->distinct()->get();
        return response()->json(['data' => $data]);
    }

    public function usageUom()
    {
        $data = MachineUomV::get();
        return response()->json(['data' => $data]);
    }

    public function resAssetLocator(Request $request)
    {
        $organizationCode = (isset($request->p_organization_code)) ? $request->p_organization_code : '%';
        $data = LocatorPmV::where('organization_code', 'like', $organizationCode)
            ->get();
        return response()->json(['data' => $data]);
    }

    public function operation()
    {
        $data = OperationV::get();
        return response()->json(['data' => $data]);
    }

    public function machineType()
    {
        $operation = (isset($request->p_operation)) ? $request->p_operation : '%';
        $data = MachineType::where('description', 'like', $operation)->get();
        return response()->json(['data' => $data]);
    }

    public function woMtLot()
    {
        $wipEntityName      = (isset($request->p_wip_entity_name)) ? 
                                     $request->p_wip_entity_name : '%';
        $inventoryItemId    = (isset($request->p_inventory_item_id)) ? 
                                     $request->p_inventory_item_id : '%';
        $subinventory       = (isset($request->p_supply_subinventory)) ? 
                                     $request->p_supply_subinventory : '%';
        $locatorCode        = (isset($request->p_supply_locator_code)) ?
                                     $request->p_supply_locator_code : '%';
        $data = WoMtLot::where('wip_entity_name', 'like', $wipEntityName)
                        ->where('inventory_item_id', 'like', $inventoryItemId)
                        ->where('subinventory_code', 'like', $subinventory)
                        ->where('locator_code', 'like', $locatorCode)
                        ->get();
        return response()->json(['data' => $data]);
    }

    public function organization()
    {
        $data = OrganizationV::get();
        return response()->json(['data' => $data]);
    }

    public function departmentResourcesV(Request $request)
    {
        $data = DepartmentResourcesV::get();
        return response()->json(['data' => $data]);
    }

    public function assetVResource(Request $request)
    {
        $data = AssetV::select('resource_code', 'resource_description')->distinct()
                        ->whereNotNull('resource_code')
                        ->get();
        return response()->json(['data' => $data]);
    }
    public function requestEquipNo(Request $request)
    {
        $requestEquipNo = (isset($request->p_request_equip_no)) ? $request->p_request_equip_no : '%';
        $limit          = $request->p_limit ??  $this->limit;
        if($request['select2'] == '1'){
            $data = RequestEquipHV::whereRaw("LOWER(CONCAT(request_equip_no, CONCAT(' : ', request_status))) LIKE LOWER('%". $request['select'] ."%')")
                        ->paginate($limit);
        }else{
            $data = RequestEquipHV::select('request_equip_h_id', 'request_equip_no', 'request_status', 'department_code', 'department_desc', 'to_subinventory', 'to_locator_code')
                                    ->where('request_equip_no', 'like', $requestEquipNo)
                                    ->paginate($limit);
        }
        
        return response()->json(['data' => $data]);
    }

    public function requestStatus()
    {
        $data = RequestStatusV::get();
        return response()->json(['data' => $data]);
    }

    public function periodName()
    {
        $data = PreiodV::get();
        return response()->json(['data' => $data]);
    }

    public function resourceV()
    {
        $data = ResourceV::get();
        return response()->json(['data' => $data]);
    }

    public function jobStatusV()
    {
        $data = JobStatusV::get();
        return response()->json(['data' => $data]);
    }

    public function resourceEmployeeV(Request $request)
    {
        $limit          = $request->p_limit ?? $this->limit;
        $fullName       = trim($request->p_full_name ?? '%');
        $employeeNumber = trim($request->p_employee_number ?? '%');
        $resourceCode   = trim($request->p_resource_code ?? '%');
        if($request['select2'] == '1'){
            $data = ResourceEmployeeV::whereRaw("LOWER(CONCAT(employee_number, CONCAT(' : ', full_name))) LIKE LOWER('%". $request['select'] ."%')")
                                    ->paginate($limit);
        }else{
            $data = ResourceEmployeeV::select('pteam_resource_employee_v.*')
                                    ->whereRaw("lower(full_name) like lower('{$fullName}') ")
                                    ->whereRaw("lower(employee_number) like lower('{$employeeNumber}') ")
                                    ->whereRaw("lower(resource_code) like lower('{$resourceCode}') ")
                                    ->paginate($limit);
        }
        
        return response()->json(['data' => $data]);
    }

    public function departmentEmployeeV(Request $request)
    {
        $limit          = $request->p_limit ??  $this->limit;
        $fullName       = trim($request->p_full_name ?? '%');
        $employeeNumber = trim($request->p_employee_number ?? '%');
        $departmentCode = trim($request->p_department_code ?? '%');
        $data = DepartmentEmployeeV::whereRaw("lower(full_name) like lower('{$fullName}') ")
                                    ->whereRaw("lower(employee_number) like lower('{$employeeNumber}') ")
                                    ->whereRaw("lower(department_code) like lower('{$departmentCode}') ")
                                    ->paginate($limit);
        return response()->json($data);
    }

    public function webUserV(Request $request)
    {
        $limit  = $request->p_limit ??  $this->limit;
        if($request['select2'] == '1'){
            if($request['p_department_code'] != null){
                $data = WebUserV::whereRaw("LOWER(CONCAT(username, CONCAT(' : ', name))) LIKE LOWER('%". $request['select'] ."%')")
                                ->where('department_code', $request['p_department_code'])
                                ->paginate($limit);
            }else{
                $data = WebUserV::whereRaw("LOWER(CONCAT(username, CONCAT(' : ', name))) LIKE LOWER('%". $request['select'] ."%')")
                                ->paginate($limit);
            }
        }else{
            $userId         = $request->p_user_id ??  '%';
            $name           = trim($request->p_name ?? '%');
            $departmentCode = trim($request->p_department_code ?? '%');
            $data = WebUserV::whereRaw("lower(name) like lower('%{$name}%') ")
                            ->whereRaw("lower(department_code) like lower('{$departmentCode}')")
                            ->whereRaw("user_id like '{$userId}' ")
                            ->paginate($limit);
        }
        
        return response()->json($data);
    }

    public function ptwUsers(Request $request)
    {
        $limit          = $request->p_limit ??  $this->limit;
        $searchParam    = trim($request->search_param ?? '%');

        $query = PTWUsers::select('*');
        if ($searchParam != '%') {
            $query = $query->where(function ($squery) use ($searchParam) {
                $squery->where('username', 'like', '%' . $searchParam . '%')
                        ->orWhere('name', 'like', '%' . $searchParam . '%');
            });
        }
        $data = $query->paginate($limit);


        return response()->json($data);
    }

    public function faAssetV(Request $request)
    {
        $limit          = $request->p_limit ??  $this->limit;
        $searchParam    = trim($request->search_param ?? '%');

        $query = FaAssetV::select('*');

        if ($searchParam != '%') {
            $query = $query->where(function ($squery) use ($searchParam) {
                $squery->where('asset_number', $searchParam)
                        ->orWhere('description', 'like', '%' . $searchParam . '%');
            });
        }
        
        // $query = $query->where('asset_id', $request['search_param']);
        $data = $query->paginate($limit);

        return response()->json($data);
    }

    public function ReasonsV()
    {
        $data = ReasonsV::get();
        return response()->json(['data' => $data]);
    }

    public function Subinventory_WorkOrder(Request $request)
    {
        $current_department = optional(\Session::get('current_department'))->department_code;
        $departmentCode = (isset($request->p_department_code)) ? $request->p_department_code : '%';
        $query = Suvinventory::select('*');
        // $query = $query->where('department_code', 'like', $current_department);
        $query = $query->whereRaw("department_code like '%".substr($current_department,0,6)."%'");
        $data = $query->get();

        if($data->count() == 0){
            $query = Suvinventory::select('*');
            $query = $query->whereNull('department_code');
            $data = $query->get();
        }

        return response()->json(['data' => $data]);
    }

    public function getSubinventory()
    {
        $query = Suvinventory::select('*');
        $data = $query->get();
        return response()->json(['data' => $data]);
    }

    public function getLocator()
    {
        $query = LocatorV::select('*');
        $data = $query->get();
        return response()->json(['data' => $data]);
    }

    public function requestStatusList(Request $request)
    {
        $limit = $request->p_limit ?? $this->limit;    
        if($request['select2'] == '1'){
            $data = RequestStatusV::whereRaw("LOWER(CONCAT(meaning, CONCAT(' : ', description))) LIKE LOWER('%". $request['select'] ."%')")
                                    ->paginate($limit);
        }else{
            $data = RequestStatusV::paginate($limit);
        }
        return response()->json($data);
    }

    public function getCheckOnHandMachine01()
    {
        $query = CheckOnHandV::selectRaw("DISTINCT machine_01")
                            ->whereNotNull('machine_01')
                            ->orderBy('machine_01', 'ASC');
        $data = $query->get();
        return response()->json(['data' => $data]);
    }

    public function getCheckOnHandMachine02()
    {
        $query = CheckOnHandV::selectRaw("DISTINCT machine_02")
                            ->whereNotNull('machine_02')
                            ->orderBy('machine_02', 'ASC');
        $data = $query->get();
        return response()->json(['data' => $data]);
    }

    public function getRequestMatNon()
    {
        $query = RequestMatNonV::selectRaw("DISTINCT PR_NUMBER")
                            ->orderBy('PR_NUMBER', 'ASC');
        $data = $query->get();
        return response()->json(['data' => $data]);
    }

    public function getOrganization()
    {
        $query = MtlParametersView::select('organization_id', 'organization_code')
                                ->where('eam_enabled_flag', 'Y')
                                ->orderBy('organization_code', 'ASC');
        $defaultOrg = MtlParametersView::select('organization_id', 'organization_code')
                                        ->where('eam_enabled_flag', 'Y')
                                        ->first();
        $data = $query->get();
        return response()->json(['data' => $data,
                                 'defaultOrg' => $defaultOrg]);
    }
}
