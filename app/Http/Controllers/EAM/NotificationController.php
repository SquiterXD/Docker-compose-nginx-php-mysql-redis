<?php

namespace App\Http\Controllers\EAM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EAM\LOV\ActivityPriority;
use App\Models\EAM\PMPlanLineV;
use App\Models\EAM\WorkRequestV;
use App\Models\EAM\WorkOrderHV;
use App\Models\EAM\LOV\AssetNumber;
use App\Models\EAM\NotificationV;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationController extends Controller
{
    public function index()
    {
        $nowDate = date("Y-m-d");
        $profile = getDefaultData('/eam/notification#maintenancePending');
        $substrDepartmentCode = substr($profile->department_code,0,6);
        $btnTrans = trans('btn');
        $arrMaintenancePendingAssetNumber = [];
        $colorTagHigh = ActivityPriority::where('lookup_code', '2')
                                        ->first();
        $dateNotification = NotificationV::whereRaw("meaning like '%".$substrDepartmentCode."%'")
                                        ->value('attribute2');
        $maintenancePendingAssetNumber = AssetNumber::whereRaw("department like '%".$substrDepartmentCode."%'")
                                        ->get('asset_number');

        foreach ($maintenancePendingAssetNumber as $key => $value) {
            array_push($arrMaintenancePendingAssetNumber,$value['asset_number']);
        }

        $lengthDataMaintenancePending1 = PMPlanLineV::where('status_plan', 'Confirm')
                                                    ->whereNull('wip_entity_id')
                                                    ->whereNull('wip_entity_name')
                                                    ->whereIn('asset_number', $arrMaintenancePendingAssetNumber);
                                                    
        $lengthDataMaintenancePending = PMPlanLineV::where('status_plan', 'Confirm')
                                                    ->whereRaw("receiving_department_code like '%".$substrDepartmentCode."%'")
                                                    ->whereNull('wip_entity_id')
                                                    ->whereNull('wip_entity_name')
                                                    ->union($lengthDataMaintenancePending1)
                                                    ->paginate(20);            

        $lengthDataMaintenancePending->map(function ($item, $key) use($dateNotification) {
            $date = strtotime($item->scheduled_start_date);
            $date = strtotime("-".$dateNotification."days", $date);
            $item->before_scheduled_start_date = date("Y-m-d", $date);
        });

        $lengthDataMaintenancePending = $lengthDataMaintenancePending->where('before_scheduled_start_date', '<=', $nowDate);
        $lengthDataMaintenancePending = NotificationController::paginate($lengthDataMaintenancePending);
        $lengthDataMaintenancePending = $lengthDataMaintenancePending->total();

        $lengthDataOpenJobPending = WorkRequestV::where('work_request_status_desc', 'Awaiting Work Order')
                                                ->whereRaw("receiving_dept_code like '%".$substrDepartmentCode."%'")
                                                ->whereNull('wip_entity_id')
                                                ->paginate(20); 
        $lengthDataOpenJobPending = $lengthDataOpenJobPending->total();

        $lengthDataCloseJobPending = WorkOrderHV::where('material_flag', 'Y')
                                                ->whereRaw("owning_department_code like '%".$substrDepartmentCode."%'")
                                                ->where('labor_flag', 'Y')
                                                ->where('complete_flag', 'Y')
                                                ->where('status_desc', 'Complete')
                                                ->paginate(20); 
        $lengthDataCloseJobPending = $lengthDataCloseJobPending->total();

        return  view('eam.notification.index', 
                compact('btnTrans', 'colorTagHigh', 'lengthDataMaintenancePending',
                        'lengthDataOpenJobPending', 'lengthDataCloseJobPending'));
    }

    static function calculateNumberNotification(){
        $nowDate = date("Y-m-d");
        $profile = getDefaultData('/eam/notification#maintenancePending');
        $substrDepartmentCode = substr($profile->department_code,0,6);
        $btnTrans = trans('btn');
        $arrMaintenancePendingAssetNumber = [];
        $colorTagHigh = ActivityPriority::where('lookup_code', '2')
                                        ->first();
        $dateNotification = NotificationV::whereRaw("meaning like '%".$substrDepartmentCode."%'")
                                        ->value('attribute2');
        $maintenancePendingAssetNumber = AssetNumber::whereRaw("department like '%".$substrDepartmentCode."%'")
                                                    ->get('asset_number');

        foreach ($maintenancePendingAssetNumber as $key => $value) {
            array_push($arrMaintenancePendingAssetNumber,$value['asset_number']);
        }

        $lengthDataMaintenancePending1 = PMPlanLineV::where('status_plan', 'Confirm')
                                                    ->whereNull('wip_entity_id')
                                                    ->whereNull('wip_entity_name')
                                                    ->whereIn('asset_number', $arrMaintenancePendingAssetNumber);
                                                    
        $lengthDataMaintenancePending = PMPlanLineV::where('status_plan', 'Confirm')
                                                    ->whereRaw("receiving_department_code like '%".$substrDepartmentCode."%'")
                                                    ->whereNull('wip_entity_id')
                                                    ->whereNull('wip_entity_name')
                                                    ->union($lengthDataMaintenancePending1)
                                                    ->paginate(20);            

        $lengthDataMaintenancePending->map(function ($item, $key) use($dateNotification) {
            $date = strtotime($item->scheduled_start_date);
            $date = strtotime("-".$dateNotification."days", $date);
            $item->before_scheduled_start_date = date("Y-m-d", $date);
        });

        $lengthDataMaintenancePending = $lengthDataMaintenancePending->where('before_scheduled_start_date', '<=', $nowDate);
        $lengthDataMaintenancePending = NotificationController::paginate($lengthDataMaintenancePending);
        $lengthDataMaintenancePending = $lengthDataMaintenancePending->total();

        $lengthDataOpenJobPending = WorkRequestV::where('work_request_status_desc', 'Awaiting Work Order')
                                                ->whereRaw("receiving_dept_code like '%".$substrDepartmentCode."%'")
                                                ->whereNull('wip_entity_id')
                                                ->paginate(20); 
        $lengthDataOpenJobPending = $lengthDataOpenJobPending->total();

        $lengthDataCloseJobPending = WorkOrderHV::where('material_flag', 'Y')
                                                ->whereRaw("owning_department_code like '%".$substrDepartmentCode."%'")
                                                ->where('labor_flag', 'Y')
                                                ->where('complete_flag', 'Y')
                                                ->where('status_desc', 'Complete')
                                                ->paginate(20); 
        $lengthDataCloseJobPending = $lengthDataCloseJobPending->total();

        return $lengthDataMaintenancePending+$lengthDataOpenJobPending+$lengthDataCloseJobPending;
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
