<?php

namespace App\Http\Controllers\EAM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EAM\PMPlanLineV;
use App\Models\EAM\WorkRequestV;
use App\Models\EAM\LOV\ActivityPriority;
use App\Models\EAM\WorkOrderHV;
use App\Models\EAM\LOV\AssetNumber;
use App\Models\EAM\NotificationV;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationController extends Controller
{
    public function setDataMaintenancePending()
    {
        $nowDate = date("Y-m-d");
        $profile = getDefaultData('/eam/notification#maintenancePending');
        $substrDepartmentCode = substr($profile->department_code,0,6);
        $arrMaintenancePendingAssetNumber = [];
        $dateNotification = NotificationV::whereRaw("meaning like '%".$substrDepartmentCode."%'")
                                        ->value('attribute2');
        $maintenancePendingAssetNumber = AssetNumber::whereRaw("department like '%".$substrDepartmentCode."%'")
                                                    ->get('asset_number');

        foreach ($maintenancePendingAssetNumber as $key => $value) {
            array_push($arrMaintenancePendingAssetNumber,$value['asset_number']);
        }

        $dataPlanList1 = PMPlanLineV::where('status_plan', 'Confirm')
                                    ->whereNull('wip_entity_id')
                                    ->whereNull('wip_entity_name')
                                    ->whereIn('asset_number', $arrMaintenancePendingAssetNumber);

        $dataPlanList = PMPlanLineV::where('status_plan', 'Confirm')
                                    ->whereRaw("receiving_department_code like '%".$substrDepartmentCode."%'")
                                    ->whereNull('wip_entity_id')
                                    ->whereNull('wip_entity_name')
                                    ->union($dataPlanList1)
                                    ->get();     

        $dataPlanList->map(function ($item, $key) use($dateNotification) {
            $item->scheduled_start_date_th = parseToDateTh($item->scheduled_start_date);
            $item->scheduled_start_date_th = $this->getMonth($item->scheduled_start_date_th);
            $item->scheduled_completion_date_th = parseToDateTh($item->scheduled_completion_date);
            $item->scheduled_completion_date_th = $this->getMonth($item->scheduled_completion_date_th);

            $date = strtotime($item->scheduled_start_date);
            $date = strtotime("-".$dateNotification."days", $date);
            $item->before_scheduled_start_date = date("Y-m-d", $date);
        });

        $dataPlanList = $dataPlanList->where('before_scheduled_start_date', '<=', $nowDate);
        $dataPlanList = $dataPlanList->sortBy([
                                                ['year_plan', 'desc'],
                                                ['version_plan', 'desc'],
                                            ]);
        $dataPlanList = NotificationController::paginate($dataPlanList);

        return response()->json(['data' => $dataPlanList], 200);
    }

    public function searchTableMaintenancePending(Request $request)
    {
        $nowDate = date("Y-m-d");
        $profile = getDefaultData('/eam/notification#maintenancePending');
        $substrDepartmentCode = substr($profile->department_code,0,6);
        $arrMaintenancePendingAssetNumber = [];
        $dateNotification = NotificationV::whereRaw("meaning like '%".$substrDepartmentCode."%'")
                                        ->value('attribute2');
        $maintenancePendingAssetNumber = AssetNumber::whereRaw("department like '%".$substrDepartmentCode."%'")
                                        ->get('asset_number');

        foreach ($maintenancePendingAssetNumber as $key => $value) {
            array_push($arrMaintenancePendingAssetNumber,$value['asset_number']);
        }

        $lines1 = PMPlanLineV::where('status_plan', 'Confirm')
                            ->whereNull('wip_entity_id')
                            ->whereNull('wip_entity_name')
                            ->whereIn('asset_number', $arrMaintenancePendingAssetNumber);   

        $lines = PMPlanLineV::searchTableMaintenancePending($request->all())
                            ->where('status_plan', 'Confirm')
                            ->whereRaw("receiving_department_code like '%".$substrDepartmentCode."%'")
                            ->whereNull('wip_entity_id')
                            ->whereNull('wip_entity_name')
                            ->union($lines1)
                            ->get();

        $lines->map(function ($item, $key) use($dateNotification) {
            $item->scheduled_start_date_th = parseToDateTh($item->scheduled_start_date);
            $item->scheduled_start_date_th = $this->getMonth($item->scheduled_start_date_th);
            $item->scheduled_completion_date_th = parseToDateTh($item->scheduled_completion_date);
            $item->scheduled_completion_date_th = $this->getMonth($item->scheduled_completion_date_th);

            $date = strtotime($item->scheduled_start_date);
            $date = strtotime("-".$dateNotification."days", $date);
            $item->before_scheduled_start_date = date("Y-m-d", $date);
        });

        $lines = $lines->where('before_scheduled_start_date', '<=', $nowDate);
        $lines = $lines->sortBy([
                                    ['year_plan', 'desc'],
                                    ['version_plan', 'desc'],
                                ]);
        $lines = NotificationController::paginate($lines);
                                    
        return response()->json(['data' => $lines], 200);
    }

    public function setDataMaintenanceSucceed()
    {
        $profile = getDefaultData('/eam/notification#maintenancePending');
        $substrDepartmentCode = substr($profile->department_code,0,6);
        $arrMaintenancePendingAssetNumber = [];

        $maintenancePendingAssetNumber = AssetNumber::whereRaw("department like '%".$substrDepartmentCode."%'")
                                                    ->get('asset_number');

        foreach ($maintenancePendingAssetNumber as $key => $value) {
            array_push($arrMaintenancePendingAssetNumber,$value['asset_number']);
        }

        $dataPlanList = PMPlanLineV::where('status_plan', 'Confirm')
                                    ->whereRaw("receiving_department_code like '%".$substrDepartmentCode."%'")
                                    ->whereNotNull('wip_entity_id')
                                    ->whereNotNull('wip_entity_name')
                                    ->whereIn('asset_number', $arrMaintenancePendingAssetNumber)
                                    ->paginate(20);

        $dataPlanList->map(function ($item, $key) {
            $item->scheduled_start_date_th = parseToDateTh($item->scheduled_start_date);
            $item->scheduled_start_date_th = $this->getMonth($item->scheduled_start_date_th);
            $item->scheduled_completion_date_th = parseToDateTh($item->scheduled_completion_date);
            $item->scheduled_completion_date_th = $this->getMonth($item->scheduled_completion_date_th);
        });
                                    
        return response()->json(['data' => $dataPlanList], 200);
    }

    static function getMonth($date)
    {
        $arrExplodeDate = explode('/',$date);
        $month_list = array();
        $strDateTH = $arrExplodeDate['0'];
        $strYearTH = substr($date,6) ? substr($date,6) : '';
        $strMonth = $arrExplodeDate['1'];
        $strMonthCut = Array(   "",
                                "ม.ค.",
                                "ก.พ.",
                                "มี.ค.",
                                "เม.ย.",
                                "พ.ค.",
                                "มิ.ย.",
                                "ก.ค.",
                                "ส.ค.",
                                "ก.ย.",
                                "ต.ค.",
                                "พ.ย.",
                                "ธ.ค.");

        for($i=0; $i < 13; $i++){
            $month_num = $strMonth+$i;
            if($month_num > 12){
                $month_num = $month_num-12;
            }
            $strMonthThai = $strMonthCut[$month_num];
            $dateConverterMonthThai = $strDateTH.' '.$strMonthThai.' '.$strYearTH;
        }

        return $dateConverterMonthThai;
    }

    public function setDataOpenJobPending()
    {
        $profile = getDefaultData('/eam/notification#maintenancePending');
        $substrDepartmentCode = substr($profile->department_code,0,6);

        $dataWorkRequestList = WorkRequestV::where('work_request_status_desc', 'Awaiting Work Order')
                                            ->whereRaw("receiving_dept_code like '%".$substrDepartmentCode."%'")
                                            ->whereNull('wip_entity_id')
                                            ->paginate(20); 

        $dataWorkRequestList->map(function ($item, $key) {
            $item->expected_start_date_th = parseToDateTh($item->expected_start_date);
            $item->expected_start_date_th = $this->getMonth($item->expected_start_date_th);
            $item->code_color_priority = ActivityPriority::where('meaning', $item->work_request_priority_desc)
                                                        ->value('tag');
        });
                                    
        return response()->json(['data' => $dataWorkRequestList], 200);
    }

    public function setDataOpenJobSucceed()
    {
        $profile = getDefaultData('/eam/notification#maintenancePending');
        $substrDepartmentCode = substr($profile->department_code,0,6);

        $dataWorkRequestList = WorkRequestV::whereNotNull('wip_entity_id')
                                            ->whereRaw("receiving_dept_code like '%".$substrDepartmentCode."%'")
                                            ->paginate(20); 

        $dataWorkRequestList->map(function ($item, $key) {
            $item->expected_start_date_th = parseToDateTh($item->expected_start_date);
            $item->expected_start_date_th = $this->getMonth($item->expected_start_date_th);
            $item->code_color_priority = ActivityPriority::where('meaning', $item->work_request_priority_desc)
                                                        ->value('tag');
        });
                                    
        return response()->json(['data' => $dataWorkRequestList], 200);
    }

    public function searchTableOpenJobPending(Request $request)
    {
        $profile = getDefaultData('/eam/notification#maintenancePending');
        $substrDepartmentCode = substr($profile->department_code,0,6);

        $dataWorkRequestList = WorkRequestV::searchTableOpenJobPending($request->all())
                                            ->whereRaw("receiving_dept_code like '%".$substrDepartmentCode."%'")
                                            ->whereNull('wip_entity_id')
                                            ->paginate(20); 

        $dataWorkRequestList->map(function ($item, $key) {
            $item->expected_start_date_th = parseToDateTh($item->expected_start_date);
            $item->expected_start_date_th = $this->getMonth($item->expected_start_date_th);
            $item->code_color_priority = ActivityPriority::where('meaning', $item->work_request_priority_desc)
                                                        ->value('tag');
        });
                                    
        return response()->json(['data' => $dataWorkRequestList], 200);
    }


    public function setDataCloseJobPending()
    {
        $profile = getDefaultData('/eam/notification#maintenancePending');
        $substrDepartmentCode = substr($profile->department_code,0,6);

        $dataWorkOrderList = WorkOrderHV::where('material_flag', 'Y')
                                            ->where('labor_flag', 'Y')
                                            ->where('complete_flag', 'Y')
                                            ->whereRaw("owning_department_code like '%".$substrDepartmentCode."%'")
                                            ->where('status_desc', 'Complete')
                                            ->paginate(20); 
                        
        $dataWorkOrderList->map(function ($item, $key) {
            $item->code_color_priority = ActivityPriority::where('meaning', $item->work_request_priority_desc)
                                                        ->value('tag');
        });
                                    
        return response()->json(['data' => $dataWorkOrderList], 200);
    }

    public function setDataCloseJobSucceed()
    {
        $profile = getDefaultData('/eam/notification#maintenancePending');
        $substrDepartmentCode = substr($profile->department_code,0,6);

        $dataWorkOrderList = WorkOrderHV::where('status_desc', 'Closed')
                                        ->whereRaw("owning_department_code like '%".$substrDepartmentCode."%'")
                                        ->paginate(20); 
                        
        $dataWorkOrderList->map(function ($item, $key) {
            $item->code_color_priority = ActivityPriority::where('meaning', $item->work_request_priority_desc)
                                                        ->value('tag');
        });
                                    
        return response()->json(['data' => $dataWorkOrderList], 200);
    }

    public function searchTableCloseJobPending(Request $request)
    {
        $profile = getDefaultData('/eam/notification#maintenancePending');
        $substrDepartmentCode = substr($profile->department_code,0,6);

        $dataWorkOrderList = WorkOrderHV::searchTableCloseJobPending($request->all())
                                        ->where('material_flag', 'Y')
                                        ->where('labor_flag', 'Y')
                                        ->where('complete_flag', 'Y')
                                        ->whereRaw("owning_department_code like '%".$substrDepartmentCode."%'")
                                        ->where('status_desc', 'Complete')
                                        ->paginate(20); 
                                                
        $dataWorkOrderList->map(function ($item, $key) {
            $item->code_color_priority = ActivityPriority::where('meaning', $item->work_request_priority_desc)
                                                        ->value('tag');
        });
                                    
        return response()->json(['data' => $dataWorkOrderList], 200);
    }

    public function paginate($items, $perPage = 20, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options = ["path" => url()->current(),
                    "pageName" => "page"];
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
