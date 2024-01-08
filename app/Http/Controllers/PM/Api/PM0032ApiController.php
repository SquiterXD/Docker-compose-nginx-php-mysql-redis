<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmStampHeader;
use App\Models\PM\PtpmStampLine;
use App\Models\PM\PtpmMfgFormulaV;
use App\Models\PM\PtpmStampTransfer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0032ApiController extends Controller
{

    public function index(): JsonResponse
    {
        $headers = PtpmStampHeader::query()->get();
        return response()->json($headers);
    }

    public function show($stampHeaderId, $afterHeader = null): JsonResponse
    {
        $header = PtpmStampHeader::query()
            ->where('stamp_header_id', $stampHeaderId)
            ->first();

        $header->log_transfer = PtpmStampTransfer::where('stamp_header_id_from', $header->stamp_header_id)
        ->select('ptpm_stamp_transfer.*', 'ptpm_stamp_header.machine_group')
        ->leftjoin('ptpm_stamp_header', 'ptpm_stamp_header.stamp_header_id', '=', 'ptpm_stamp_transfer.stamp_header_id_to')
        ->get();
        $header->sum_transfer =  count($header->log_transfer) > 0 ? $header->log_transfer->sum('transfer') : 0;
        $header->log_receive = PtpmStampTransfer::query()
        ->leftjoin('ptpm_stamp_header', 'ptpm_stamp_header.stamp_header_id', '=', 'ptpm_stamp_transfer.stamp_header_id_from')
        ->select('ptpm_stamp_transfer.transfer', 'ptpm_stamp_header.machine_group')
        ->where('ptpm_stamp_transfer.stamp_header_id_to', $header->stamp_header_id)->get();
        $header->sum_receive =  count($header->log_receive) > 0 ? $header->log_receive->sum('transfer') : 0;
        $header->transfer = $header->sum_transfer;
        $header->receive = $header->sum_receive;

        if (!empty($afterHeader)) {
            $lineAfter = PtpmStampLine::query()
                ->whereDate('used_date', '=', $afterHeader->used_date)
                ->where('machine_group', $afterHeader->machine_group)
                ->where('description1', $afterHeader->description1)
                ->where('stamp_header_id', $afterHeader->stamp_header_id)
                ->get();
            $lineAfter = $lineAfter->map(function ($item) {
                $item->last_number = $item->current_number;
                $item->current_number = 0;
                $item->remaining = 0;
                return $item;
            });
        }

        if (!$header && empty($afterHeader)) {
            return response()->json([
                'message' => 'data not found',
            ], 404);
        } else if (!empty($afterHeader) && empty($header)) {
            return response()->json([
                'header' => null,
                'lines' => $lineAfter,
                'machineGroups' => null,
            ]);
        }

        $lines1 = PtpmStampLine::query()
            ->where('stamp_header_id', $header->stamp_header_id)
            ->get();

        $lines2 = PtpmStampLine::query()
            ->whereDate('used_date', '=', $header->used_date)
            ->where('machine_group', $header->machine_group)
            ->where('description1', $header->description1)
            ->where('stamp_header_id', $header->stamp_header_id)
            ->get();


        $lines = array_merge($lines1->toArray(), $lines2->toArray());
        $lines = $lines2;

        $machineGroups = PtpmStampHeader::query()
            ->where('stamp_header_id', '!=', $stampHeaderId)
            ->whereDate('used_date', '=', $header->used_date)
            //->where('machine_group', $header->machine_group)
            ->where('description1', $header->description1)
            ->get();

        return response()->json([
            'header' => $header,
            'lines' => $lines,
            'machineGroups' => $machineGroups,
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        if (request()->get('action') == 'get-brands') {
            $profile = getDefaultData('/pm/0032');
            $usedDate = request()->get('used_date');
            $data = [];
            if ($usedDate) {
                $data = \App\Models\PM\PtpmRequestIngredientsV::selectRaw("
                            distinct
                            item_desc value,
                            item_desc label
                        ")
                    ->whereRaw("
                            TRUNC(to_date('$usedDate', 'YYYY-MM-DD')) between TRUNC(PLAN_START_DATE) and TRUNC(PLAN_CMPLT_DATE)
                        ")
                    ->where('organization_code', $profile->organization_code)
                    ->orderBy('label')
                    ->get();
            }
            return response()->json($data);
        }
        $usedDate = $request->get('used_date');
        $machineGroup = $request->get('machine_group');
        $description1 = $request->get('description1');

        $headerAfter = PtpmStampHeader::query()
            ->where('machine_group', $machineGroup)
            ->where('description1', $description1)
            ->where('used_date', '<', $usedDate)
            ->orderBy('used_date', 'desc')
            ->first();

        $header = PtpmStampHeader::query()
            ->whereDate('used_date', '=', $usedDate)
            ->where('machine_group', $machineGroup)
            ->where('description1', $description1)
            ->first();


        if ($header) $stampHeaderId = $header->stamp_header_id;

        else $stampHeaderId = -1;

        return $this->show($stampHeaderId, $headerAfter);
    }

    public function store(Request $request)
    {
        $headerData = $request->get('header');
        $linesData = $request->get('lines');
        $user = auth()->user();
        $profile = getDefaultData('/pm/0032');



        $item = collect(\DB::select(
            "
                SELECT  distinct inventory_item_id
                FROM    mtl_system_items_b
                WHERE   description = ?
            ",
            [data_get($headerData, 'description1')]
        ))->first();

        // แสตมป์
        $item2 = $this->getItem2($profile->organization_id, optional($item)->inventory_item_id ?? '');

        $headerData = array_merge($headerData, [
            'created_by'            => $user->user_id,
            'created_at'            => date('Y-m-d H:i:s'),
            'organization_id'       => $profile->organization_id,
            'inventory_item_id1'    => optional($item)->inventory_item_id ?? null,
            'inventory_item_id2'    => optional($item2)->inventory_item_id ?? null,
            'item_code2'            => optional($item2)->item_number ?? null,
            'description2'          => optional($item2)->item_desc ?? null,
        ]);

        DB::beginTransaction();
        try {
            // dd($headerData, $headerData['used_date'], $headerData['machine_group'], $headerData['description1']);
            $checkData = PtpmStampHeader::query()
                ->where('machine_group', $headerData['machine_group'])
                ->where('description1', $headerData['description1'])
                ->whereRaw("used_date > TO_DATE('" . $headerData['used_date'] . "', 'yyyy-mm-dd')")
                ->first();
            if (!empty($checkData)) {
                throw new \Exception("มีข้อมูลวันที่ล่าสุดอยู่แล้ว", 1);
            }
            $header = PtpmStampHeader::query()
                ->create($headerData);

            $header = PtpmStampHeader::query()
                ->where('used_date', $header->used_date)
                ->where('machine_group', $header->machine_group)
                ->where('description1', $header->description1)
                ->first();

            $lines = [];
            foreach ($linesData as $lineData) {
                $lineData = $this->bindHeaderToLine($header, $lineData);
                $line = PtpmStampLine::query()->create($lineData);
                $lines[] = $line;
            }

            DB::commit();
            return response([
                'header' => $header,
                'lines' => $lines,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'message' => $e->getTraceAsString(),
            ], 500);
        }
    }

    public function update(Request $request, $stampHeaderId)
    {
        // dd('xxx', $stampHeaderId);
        //if id not exist -> create new one
        if (!intval($stampHeaderId) || $stampHeaderId == 'null') return $this->store($request);

        $headerData = $request->get('header');
        $linesData = $request->get('lines');
        $user = auth()->user();
        $headerData = array_merge($headerData, [
            'updated_by_id' => $user->user_id,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::beginTransaction();
        try {
            $header = PtpmStampHeader::query()
                ->where('stamp_header_id', $stampHeaderId)
                ->first();
            $header->update($headerData);

            PtpmStampLine::query()
                //->where('stamp_header_id', $stampHeaderId)
                ->where('used_date', $header->used_date)
                ->where('machine_group', $header->machine_group)
                ->where('description1', $header->description1)
                ->delete();

            $lines = [];
            foreach ($linesData as $lineData) {
                $lineData = $this->bindHeaderToLine($header, $lineData);
                \Log::info("save Line", $lineData);
                $line = PtpmStampLine::query()->create($lineData);
                $lines[] = $line;
            }

            DB::commit();
            return response([
                'header' => $header,
                'lines' => $lines,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'message' => $e->getTraceAsString(),
            ], 500);
        }
    }

    public function deleteLines(Request $request)
    {
        $ids = $request->get('ids');
        // $usedDate = $request->get('used_date');
        // $machineGroup = $request->get('machine_group');
        // $description1 = $request->get('description1');

        DB::beginTransaction();
        try {
            $res = PtpmStampLine::query()
                // ->where('used_date', $usedDate)
                // ->where('machine_group', $machineGroup)
                // ->where('description1', $description1)
                ->whereIn('stamp_line_id', $ids)
                ->delete();

            DB::commit();
            return response([
                'res' => $res,
                '$query' => PtpmStampLine::query()
                    // ->where('used_date', $usedDate)
                    // ->where('machine_group', $machineGroup)
                    // ->where('description1', $description1)
                    ->whereIn('stamp_line_id', $ids)->toSql(),
                // '$params' => [$usedDate, $machineGroup, $description1],
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function transferStamp(Request $request)
    {
        DB::beginTransaction();
        try {

            $usedDate = $request->get('used_date');
            $fromMachineGroup = $request->get('machine_group');
            $description1 = $request->get('description1');
            $toMachineGroup = $request->get('targetMachineGroup');
            $transferAmount = $request->get('transferAmount');

            $from = PtpmStampHeader::query()
                ->where('used_date', $usedDate)
                ->where('machine_group', $fromMachineGroup)
                ->where('description1', $description1)
                ->first();
            // dd($from->toSql());
            $to = PtpmStampHeader::query()
                ->where('used_date', $usedDate)
                ->where('machine_group', $toMachineGroup)
                ->where('description1', $description1)
                ->first();
            #ตรวจสอบข้อมูลเครื่องปลายทางว่ามีใน used date นั้นหรือยัง
            if (!$to) {
                $insertData = [
                    'machine_group' => $toMachineGroup,
                    'used_date' => $usedDate,
                    'description1' => $description1,
                    'receive' => $transferAmount,
                ];
                $insertData = array_merge($from->toArray(), $insertData);
                unset($insertData['stamp_header_id'], $insertData['transfer']);
                $to = new PtpmStampHeader($insertData);
                $to->save();
            } else {
                $to->receive = $to->receive + $transferAmount;
                $to->save();
            }

            if (!$from || !$to) return response()->json([
                'message' => 'เครื่องไม่มีอยู่ในระบบ',
            ], 404);

            // $from->receive = $transferAmount;
            // $from->save();
            // $to->transfer = $transferAmount;
            // $to->save();

            $from->transfer =  $from->transfer + $transferAmount;
            $from->save();

            $logs = [
                'organization_id' => $from->organization_id,
                'stamp_header_id_from' => $from->stamp_header_id,
                'stamp_header_id_to' => $to->stamp_header_id,
                'transfer' => $transferAmount,
            ];

            $stampTransection = PtpmStampTransfer::query()
                ->where('stamp_header_id_from', $from->stamp_header_id)
                ->where('stamp_header_id_to', $to->stamp_header_id)
                ->first();
            if (!empty($stampTransection)) {
                $stampTransection->transfer = $transferAmount;
                $stampTransection->save();
            } else {
                $stampTransfer = new PtpmStampTransfer($logs);
                $stampTransfer->save();
            }


            DB::commit();
            return response()->json([
                'from' => $from,
                'to' => $to,
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'e' => $th->getMessage()
            ], 500);
        }
    }

    private function bindHeaderToLine($header, $lineData)
    {
        $lineData['stamp_header_id'] = $header->stamp_header_id;  // trigger อัพเดทให้อยู่แล้ว
        $lineData['used_date'] = $header->used_date; //require;
        $lineData['machine_group'] = $header->machine_group; //require;
        $lineData['description1'] = $header->description1; //require;
        $lineData['inventory_item_id'] = $header->inventory_item_id1;  //require;
        $lineData['empty'] = isset($lineData['empty']) ? $lineData['empty'] : false;
        $lineData['not_used'] = isset($lineData['not_used']) ? $lineData['not_used'] : false;
        return $lineData;
    }


    private function getItem2($organizationId, $inventoryItemId)
    {
        // แสตมป์
        $item2 = PtpmMfgFormulaV::select(['inventory_item_id', 'item_number', 'item_desc'])
            ->where('organization_id', $organizationId)
            ->where('product_item_id', $inventoryItemId ?? '')
            ->whereRaw("
                        RECEIPE_TYPE_CODE = '2' --fix
                        and     FORMULA_STATUS = '700' --fix
                        and     TOBACCO_GROUP_CODE = '1013' --fix
                    ")
            ->first();
        return $item2;
    }
}
