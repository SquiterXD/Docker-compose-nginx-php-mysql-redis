<?php

namespace App\Http\Controllers\EAM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EAM\AssetT;
use App\Models\EAM\AssetV;
use App\Models\EAM\AssetCategoryV;
use App\Models\EAM\AssetInterface;

use App\Http\Requests\EAM\AssetRequest;
use App\Http\Requests\EAM\StoreWorkOrderRequest;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ResourceAssetController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($assetNumber)
    {
        $datas = AssetV::where('asset_number',$assetNumber)
            ->select(
                'pteam_asset_v.*', 
                'pteam_departments_v.description as owning_department_desc',
                'pteam_operation_v.process_qty_uom as wip_process_qty_uom',
                'pteam_operation_v.unit_of_measure as wip_unit_of_measure'
                )
            ->leftJoin('pteam_departments_v', 'pteam_asset_v.owning_department', '=', 'pteam_departments_v.department_code')
            ->leftJoin('pteam_operation_v', 'pteam_asset_v.work_procedure', '=', 'pteam_operation_v.wip_id')
            ->first();
        $datas->machine_installation_date = parseToDateTh($datas->machine_installation_date);
        return response()->json(['data' => $datas]);
    }

    public function assetCategory(AssetRequest $request)
    {
        $assetGroup = AssetCategoryV::where('application_column_name','SEGMENT1')->get();
        $brand = AssetCategoryV::where('application_column_name','SEGMENT3')->get();
        $machineType = AssetCategoryV::where('application_column_name','SEGMENT4')->get();
        $series = AssetCategoryV::where('application_column_name','SEGMENT5')->get();
        return response()->json(
            [
                'data' => [
                    'assetGroup' => $assetGroup,
                    'brand' => $brand,
                    'machineType' => $machineType,
                    'series' => $series
                ]
            ]
        );
    }

    public function assetCategorySubgroup(AssetRequest $request)
    {
        $parentFlexValue = $request->p_parent_flex_value ?? '';
        $assetSubGroup = AssetCategoryV::where('application_column_name','SEGMENT2')
            ->where('parent_flex_value_low', $parentFlexValue)
            ->get();
        return response()->json(['data' => $assetSubGroup]);
    }

    public function assetCategorySubMachine(AssetRequest $request)
    {
        $parentFlexValue = $request->p_parent_flex_value ?? '';
        $assetSubMachine = AssetCategoryV::where('application_column_name','SEGMENT6')
            ->where('parent_flex_value_low', $parentFlexValue)
            ->get();
        return response()->json(['data' => $assetSubMachine]);
    }

    public function store(StoreWorkOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $asset = AssetT::saveData($request->all());
            $interface = $this->interface($asset->web_batch_no);
            if ($interface['status'] == 'E') {
                DB::rollback();
                $code = 400;
            } else {
                DB::commit();
                $code = 200;
            }
            $response = AssetT::where('asset_number', $asset->asset_number)
                                ->select('pteam_asset_t.asset_id',
                                        'pteam_asset_t.eam_organization',
                                        'pteam_asset_t.active_status',
                                        'pteam_asset_t.asset_number',
                                        'pteam_asset_t.asset_description',
                                        'pteam_asset_t.asset_group',
                                        'pteam_asset_t.asset_serial_number',
                                        'pteam_asset_t.asset_category',
                                        'pteam_asset_t.owning_department',
                                        'pteam_asset_t.area',
                                        'pteam_asset_t.wip_accounting_class',
                                        'pteam_asset_t.parent_asset_number',
                                        'pteam_asset_t.production_organization',
                                        'pteam_asset_t.jp_status',
                                        'pteam_asset_t.resource_code',
                                        'pteam_asset_t.resource_description',
                                        'pteam_asset_t.usage_uom',
                                        'pteam_asset_t.usage_uom_desc',
                                        'pteam_asset_t.locator',
                                        'pteam_asset_t.work_procedure',
                                        'pteam_asset_t.machine_type',
                                        'pteam_asset_t.machine_speed',
                                        'pteam_asset_t.performance_percent',
                                        'pteam_asset_t.machine_installation_date',
                                        'pteam_asset_t.attribute1',
                                        'pteam_asset_t.attribute2',
                                        'pteam_asset_t.attribute3',
                                        'pteam_asset_t.attribute4',
                                        'pteam_asset_t.attribute5',
                                        'pteam_asset_t.attribute6',
                                        'pteam_asset_t.attribute7',
                                        'pteam_asset_t.attribute8',
                                        'pteam_asset_t.attribute9',
                                        'pteam_asset_t.attribute10',
                                        'pteam_asset_t.attribute11',
                                        'pteam_asset_t.attribute12',
                                        'pteam_asset_t.attribute13',
                                        'pteam_asset_t.attribute14',
                                        'pteam_asset_t.attribute15',
                                        'pteam_asset_t.or_eam_organization_id',
                                        'pteam_asset_t.or_production_organization_id',
                                        'pteam_asset_t.or_inventory_item_id',
                                        'pteam_asset_t.or_instance_id',
                                        'pteam_asset_t.program_code',
                                        'pteam_asset_t.created_by_id',
                                        'pteam_asset_t.updated_by_id',
                                        'pteam_asset_t.deleted_by_id',
                                        'pteam_asset_t.created_by',
                                        'pteam_asset_t.last_updated_by',
                                        'pteam_asset_t.creation_date',
                                        'pteam_asset_t.last_update_date',
                                        'pteam_asset_t.file_name',
                                        'pteam_asset_t.interface_name',
                                        'pteam_asset_t.tran_id',
                                        'pteam_asset_t.stg_no',
                                        'pteam_asset_t.web_batch_no',
                                        'pteam_asset_t.web_status',
                                        'pteam_asset_t.interface_status',
                                        'pteam_asset_t.interface_msg',
                                        'pteam_departments_v.description as owning_department_desc',
                                        'pteam_operation_v.process_qty_uom as wip_process_qty_uom',
                                        'pteam_operation_v.unit_of_measure as wip_unit_of_measure')
                                ->leftJoin('pteam_departments_v', 'pteam_asset_t.owning_department', '=', 'pteam_departments_v.department_code')
                                ->leftJoin('pteam_operation_v', 'pteam_asset_t.work_procedure', '=', 'pteam_operation_v.wip_id')
                                ->first();
            if(isset($response)){
            	$response->machine_installation_date = parseToDateTh($response->machine_installation_date);
            }
            $st = $response->web_status == 'CREATE'? "CREATE SUCCESS": "UPDATE SUCCESS";
            return response()->json(
                [
                    'code' => $code,
                    'data' => $response,
                    'message' => $code == 400? $interface['message']: $st
                ],$code
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function interface($batchNo)
    {
        $result = (new AssetInterface)->Import($batchNo);
        return $result;
    }
    
}