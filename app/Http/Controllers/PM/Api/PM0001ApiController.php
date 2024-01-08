<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\Lookup\PtpmItemConvUomVLookup;
use App\Models\PM\PtpmProcessRequestsT;
use App\Models\PM\PtpmSummaryBatchV;
use DateTime;
use Illuminate\Http\Request;
use App\Models\PM\Lookup\PtpmBatchStatus;
use App\Models\PM\Lookup\PtpmJobType;
use App\Models\PM\PtInvUomV;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use PDO;

class PM0001ApiController extends Controller
{
    const url = '/pm/production-order';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    public function batchStatus()
    {
        $data = PtpmBatchStatus::select(['lookup_code', 'meaning'])->where('lookup_code', '!=', '0')->get();

        return response()->json(['data' => $data]);
    }

    public function jobType()
    {
        $data = PtpmJobType::select(['lookup_code', 'description'])->get();

        return response()->json(['data' => $data]);
    }

    public function search(Request $request)
    {
        if($request->action == 'search_get_param') {
            $data = $this->searchGetParam($request);
            $data = [
                'status' => 'S',
                'data' => $data
            ];
            return $data;
        }
        $profile = getDefaultData(self::url);
        DB::connection()->enableQueryLog();

        $batchStatusTable = PtpmBatchStatus::query()->getModel()->getTable();
        $summaryBatchTable = PtpmSummaryBatchV::query()->getModel()->getTable();
        $summaryBatch = PtpmSummaryBatchV::query()
            ->where('organization_id', $profile->organization_id)
            ->join($batchStatusTable, function ($join) use ($batchStatusTable, $summaryBatchTable) {
                $join->on("$batchStatusTable.lookup_code", '=', "$summaryBatchTable.web_batch_status_code");
            });

        if ($request->get('batch_id', false)) {
            $summaryBatch->where('batch_id', $request->get('batch_id'));
        }

        if ($request->get('inventory_item_id', false)) {
            $summaryBatch->where('inventory_item_id', $request->get('inventory_item_id'));
        }

        if ($request->get('item_no', false)) {
            $summaryBatch->where('item_no', 'like', "%{$request->get('item_no')}%");
        }

//        if ($request->has('actual_start_date_from')) {
//            $summaryBatch->whereDate('actual_start_date', '>=', Carbon::parse($request->get('actual_start_date_from'))->format('Y-m-d'));
//        }

        if ($request->get('plan_start_date_from', false)) {
            $summaryBatch->whereDate('plan_start_date', '>=', Carbon::parse($request->get('plan_start_date_from'))->format('Y-m-d'));
        }

//        if ($request->has('actual_start_date_to')) {
//            $summaryBatch->whereDate('actual_start_date', '<=', Carbon::parse($request->get('actual_start_date_to'))->format('Y-m-d'));
//        }

        if ($request->get('plan_start_date_to', false)) {
            $summaryBatch->whereDate('plan_start_date', '<=', Carbon::parse($request->get('plan_start_date_to'))->format('Y-m-d'));
        }

        if ($request->get('web_batch_status_code', false)) {
            $summaryBatch->where('web_batch_status_code', $request->get('web_batch_status_code'));
        }

//        print_r(DB::getQueryLog());
        return response()->json([
            'summaryBatch' => $summaryBatch
                ->orderby('batch_no', 'DESC')
                ->get(),
        ]);
    }
    public function searchGetParam(Request $request)
    {
        $profile = getDefaultData(self::url);

        $planStartDateFrom  = $request->get('plan_start_date_from', false);
        $planStartDateTo    = $request->get('plan_start_date_to', false);
        $inventoryItemId    = $request->get('inventory_item_id', false);
        $webBatchStatusCode = $request->get('web_batch_status_code', false);
        $batchId            = $request->get('batch_id', false);

        // $columns = [
        //     "inventory_item_id",
        //     "item_no",
        //     "item_desc",
        //     "web_batch_status_code",
        //     "web_batch_status",
        //     "batch_id",
        //     "batch_no"
        // ];
        $inventoryItemIdList[] = ['value' => '', 'label' => 'ท้ังหมด'];
        $webBatchStatusCodedList[] = ['value' => '', 'label' => 'ท้ังหมด'];
        $batchIdListList[] = ['value' => '', 'label' => 'ท้ังหมด'];

        $batchStatusTable = (new PtpmBatchStatus)->getTable();
        $summaryBatchTable = (new PtpmSummaryBatchV)->getTable();
        $summaryBatch = PtpmSummaryBatchV::where('organization_id', $profile->organization_id);

        if ($planStartDateFrom || $planStartDateTo || $batchId || $inventoryItemId || $webBatchStatusCode) {

            if ($planStartDateFrom) {
                $planStartDateFrom = Carbon::parse($planStartDateFrom)->format('Y-m-d');
            }
            if ($planStartDateTo) {
                $planStartDateTo = Carbon::parse($planStartDateTo)->format('Y-m-d');
            }

            $summaryBatch = $summaryBatch->when($planStartDateFrom, function($q) use($planStartDateFrom) {
                    $q->whereDate('plan_start_date', '>=', $planStartDateFrom);
                })
                ->when($planStartDateTo, function($q) use($planStartDateTo) {
                    $q->whereDate('plan_start_date', '<=', $planStartDateTo);
                })
                ->when($inventoryItemId, function($q) use($inventoryItemId) {
                    $q->where("inventory_item_id", $inventoryItemId);
                })
                ->when($webBatchStatusCode, function($q) use($webBatchStatusCode) {
                    $q->where("web_batch_status_code", $webBatchStatusCode);
                })
                ->when($batchId, function($q) use($batchId) {
                    $q->where("batch_id", $batchId);
                });
        }
        $summaryBatch               = $summaryBatch->orderBy('batch_no', 'desc')->get();
        if (count($summaryBatch)) {
            $inventoryItemIdData        = $summaryBatch;
            $webBatchStatusCodedData    = $summaryBatch;
            $batchIdListData            = $summaryBatch;

            $inventoryItemIdData = $inventoryItemIdData->groupBy('inventory_item_id')->map(function ($group) {
                $line = $group->first();
                $data = [];
                $data['value'] = $line->inventory_item_id;
                $data['label'] = "$line->item_no : $line->item_desc";
                return $data;
            });
            $webBatchStatusCodedData = $webBatchStatusCodedData->groupBy('web_batch_status_code')->map(function ($group) {
                $line = $group->first();
                $data = [];
                $data['value'] = $line->web_batch_status_code;
                $data['label'] = $line->web_batch_status;
                return $data;
            });
            $batchIdListData = $batchIdListData->groupBy('batch_id')->map(function ($group) {
                $line = $group->first();
                $data = [];
                $data['value'] = $line->batch_id;
                $data['label'] = $line->batch_no;
                return $data;
            });

            if (count($inventoryItemIdData)) {
                $inventoryItemIdData = $inventoryItemIdData->sortByDesc('label')->toArray();
                $inventoryItemIdList = array_merge($inventoryItemIdList, $inventoryItemIdData);
            }
            if (count($webBatchStatusCodedData)) {
                $webBatchStatusCodedData = $webBatchStatusCodedData->sortBy('label')->toArray();
                $webBatchStatusCodedList = array_merge($webBatchStatusCodedList, $webBatchStatusCodedData);
            }
            if (count($batchIdListData)) {
                $batchIdListData = $batchIdListData->sortByDesc('label')->toArray();
                $batchIdListList = array_merge($batchIdListList, $batchIdListData);
            }

            $summaryBatch = $summaryBatch->sortByDesc('batch_no');
        }

        return [
            'inventory_item_id_list' => $inventoryItemIdList,
            'web_batch_status_code_list' => $webBatchStatusCodedList,
            'batch_id_list' => $batchIdListList,
            'summary_batch' => $summaryBatch
        ];
    }

    public function uom(Request $request)
    {
        $organizationId = $request->get('organization_id');
        $inventoryItemId = $request->get('inventory_item_id');

        $uom = PtpmItemConvUomVLookup::query()
            ->where('organization_id', $organizationId)
            ->where('inventory_item_id', $inventoryItemId)
            ->get();

        $ptUom = PtInvUomV::whereIn('uom_code', optional($uom->pluck('from_uom_code'))->all() ?? [])->get();
        $uom = $uom->map(function ($row) use ($ptUom) {
            $data = $ptUom->where('uom_code', $row->from_uom_code)->first();
            $row->from_unit_of_measure = optional($data)->unit_of_measure;
            return $row;
        });
        return response()->json([
            'uom' => $uom,
        ]);
    }

    public function store(Request $request)
    {
        $processRequestData = $request->input('processRequest');

        $web_batch_no = $this->generateWebBatchNo();
        $user = auth()->user();
        $departmentCode = $user->department_code;
        $profile = getDefaultData(self::url);
        $programCode = optional($profile)->program_code;

        $requestDate = new DateTime($processRequestData['request_date']);
        $startDate = Carbon::parse($processRequestData['start_date'])->format('Y-m-d');
        $endDate = Carbon::parse($processRequestData['end_date'])->format('Y-m-d');

        $sysdate = now();
        $requestDate = $startDate;
        if (Carbon::parse($processRequestData['start_date']) > now()) {
            $requestDate = now()->format('Y-m-d');
        }

        PtpmProcessRequestsT::query()
            ->create([
                'request_date' => $requestDate,
                'department_code' => $departmentCode,
                'request_status' => $processRequestData['request_status'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'request_type' => data_get($processRequestData, 'request_type', ''),
                'inventory_item_id' => $processRequestData['inventory_item_id'],
                'request_quantity' => $processRequestData['request_quantity'],
                'request_uom' => $processRequestData['request_uom'],
                'organization_id' => $processRequestData['organization_id'],
                'record_type' => 'INSERT',
                'web_batch_no' => $web_batch_no,
                'program_code' => $programCode,
                'creation_date' => $sysdate,
                'last_update_date' => $sysdate,

                'created_at' => $sysdate,
                'updated_at' => $sysdate,
                'created_by_id' => $profile->user_id,
                'updated_by_id' => $profile->user_id,
                'created_by' => $profile->fnd_user_id,
                'last_updated_by' => $profile->fnd_user_id,
                // 'biweekly_id' => data_get($processRequestData, 'biweekly_id', ''),
            ]);
        try {
            $sql = "
            declare
                v_status    varchar2(5);
                v_err_msg   varchar2(2000);
            begin
                apps.ptpm_main.create_job(p_program_code => '$programCode',
                    p_web_batch_no => '$web_batch_no',
                    p_user_name => '$profile->fnd_user_name',
                    p_status => :v_status,
                    p_err_msg => :v_err_msg);
                dbms_output.put_line(:v_status);
                dbms_output.put_line(:v_err_msg);
            end;
        ";

            $response = [];

            $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
            $stmt->bindParam(":v_status", $response['v_status'], PDO::PARAM_STR, 5);
            $stmt->bindParam(":v_err_msg", $response['v_err_msg'], PDO::PARAM_STR, 2000);
            $stmt->execute();

            $processRequest = PtpmProcessRequestsT::query()
                ->where('web_batch_no', $web_batch_no)
                ->first();

            return response()->json([
                'web_batch_no' => $web_batch_no,
                'processRequest' => $processRequest,
                'response' => $response,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $processRequestData = $request->input('processRequest');
        $requestAll = request()->all();
        $web_batch_no = $this->generateWebBatchNo();
        $requestAll['web_batch_no'] = $web_batch_no;

        $oldData = PtpmSummaryBatchV::where('batch_no', $processRequestData['batch_no'])
                        ->where('organization_id', $processRequestData['organization_id'])
                        ->where('inventory_item_id', $processRequestData['inventory_item_id'])
                        ->first();

        // batch_status_code == 1 : Pending
        // request_status  == 1 : แก้ไขข้อมูลและปรับปรุง
        if ($oldData &&
            $oldData->batch_status_code == 1 &&
            $processRequestData['request_status'] == 1
        ) {
            $oldRequestDate = Carbon::parse($oldData->actual_start_date)->format('Y-m-d');
            $oldStartDate = Carbon::parse($oldData->plan_start_date)->format('Y-m-d');
            $oldEndDate = Carbon::parse($oldData->plan_cmplt_date)->format('Y-m-d');
            $oldRequestQuantity = $oldData->plan_qty;


            $newRequestDate = Carbon::parse($processRequestData['request_date'])->format('Y-m-d');
            $newStartDate = Carbon::parse($processRequestData['start_date'])->format('Y-m-d');
            $newEndDate = Carbon::parse($processRequestData['end_date'])->format('Y-m-d');
            $newRequestQuantity = $processRequestData['request_quantity'];
            // Auto เปลี่ยนสถานะเป็น Wip (กำลังผลิตให้)

            if ($oldRequestDate != $newRequestDate ||
                $oldStartDate != $newStartDate ||
                $oldEndDate != $newEndDate ||
                $oldRequestQuantity != $newRequestQuantity
            ) {
                data_set($requestAll, 'processRequest.request_status', 2);
            }
        }

        $response = $this->updateJob($requestAll);

        $processRequest = PtpmProcessRequestsT::query()
            ->where('web_batch_no', $web_batch_no)
            ->first();

        return response()->json([
            'web_batch_no' => $web_batch_no,
            'processRequest' => $processRequest,
            'response' => $response,
        ]);
    }
    private function updateJob($requestAll)
    {
        $processRequestData = data_get($requestAll, 'processRequest');
        $web_batch_no = $requestAll['web_batch_no'];
        $user = auth()->user();
        $departmentCode = $user->department_code;
        $profile = getDefaultData(self::url);
        $programCode = optional($profile)->program_code;
        $sysdate = now();

        $startDate = Carbon::parse($processRequestData['start_date'])->format('Y-m-d');
        $endDate = Carbon::parse($processRequestData['end_date'])->format('Y-m-d');

        PtpmProcessRequestsT::create([
                'request_number' => $processRequestData['batch_no'],
                'request_date' => $processRequestData['request_date'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'department_code' => $departmentCode,
                'request_status' => $processRequestData['request_status'],
                'request_type' => $processRequestData['request_type'],
                'inventory_item_id' => $processRequestData['inventory_item_id'],
                'request_quantity' => $processRequestData['request_quantity'],
                'request_uom' => $processRequestData['request_uom'],
                'organization_id' => $processRequestData['organization_id'],
                'record_type' => 'UPDATE',
                'web_batch_no' => $web_batch_no,
                'program_code' => $programCode,
                'last_update_date' => $sysdate,
                'created_at' => $sysdate,
                'updated_at' => $sysdate,
                'created_by_id' => $profile->user_id,
                'updated_by_id' => $profile->user_id,
                'created_by' => $profile->fnd_user_id,
                'last_updated_by' => $profile->fnd_user_id,
            ]);

        $sql = "
            declare
                v_status    varchar2(5);
                v_err_msg   varchar2(2000);
            begin
                apps.ptpm_main.create_job(p_program_code => '$programCode',
                    p_web_batch_no => '$web_batch_no',
                    p_user_name => '$profile->fnd_user_name',
                    p_status => :v_status,
                    p_err_msg => :v_err_msg);
                dbms_output.put_line(:v_status);
                dbms_output.put_line(:v_err_msg);
            end;
        ";

        $response = [];
        $response['web_batch_no'] = $web_batch_no;

        $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
        $stmt->bindParam(":v_status", $response['v_status'], PDO::PARAM_STR, 5);
        $stmt->bindParam(":v_err_msg", $response['v_err_msg'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $response;
    }

    private function generateWebBatchNo()
    {
        return date('YmdHis') . substr(strval(round(microtime(true) * 1000)), -4);
    }
}
