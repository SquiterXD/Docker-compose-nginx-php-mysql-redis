<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\Lookup\PtpmItemNumberVLookup;
use App\Models\PM\PtpmIngredientRequestH;
use App\Models\PM\PtpmIngredientRequestL;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mock;
use Illuminate\Support\Facades\Validator;

class PM0020ApiController extends Controller
{
    const PROGRAM_ID = 'PM0020';

    public function show($id): JsonResponse
    {
        if (!intval($id)) {
            return response()->json('Not Found', 404);
        }

        $ingredientRequest = PtpmIngredientRequestH::query()
            ->where('ingreq_header_id', $id)
            ->with('ptpmItemNumberV')
            ->with('ptpmMachineGroups')
            ->with('ptpmManufactureStep')
            ->first();

        //TODO 2021-02-26: no org id available, hardcoded
        $user = Mock::getMockUser();
        $ingredientRequest->user_id = $user->user_id;
        $ingredientRequest->organization_id = $user->organization_id;

        if (!$ingredientRequest) return response()->json([
            'message' => 'data not found',
        ], 404);

        $lines = PtpmIngredientRequestL::query()
            ->where('ingreq_header_id', $id)
            ->with('ptpmItemNumberV')
            ->with('ptpmItemConvUomV')
            ->get();

        return response()->json([
            'user' => Mock::getMockUser(),
            'ingredientRequest' => $ingredientRequest,
            'lines' => $lines,
            'x' => 1,
        ]);
    }

    /** @noinspection DuplicatedCode
     * @noinspection PhpDocSignatureInspection
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'header' => 'required',
            'header.department_name' => 'required',
            'header.machine_group' => 'required',
            'header.item' => 'required',
            'header.user_id' => 'required',
            'header.request_date' => 'required',
            'header.manufacture_step' => 'required',
            'lines' => ['array'],
            'lines.*.request_item' => 'required',
            'lines.*.request_qty' => 'required',
            'lines.*.secondary_uom' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }

        $headerData = $request->input('header');
        $linesData = $request->input('lines');

        $user = Mock::getMockUser();
        $currentDate = date('Y-m-d H:i:s');

        $headerData = array_merge($headerData, [
            'user_id' => $user->user_id,
            'organization_id' => $user->organization_id,
            'program_id' => self::PROGRAM_ID,
            'request_date' => $currentDate,
            'created_by' => $user->user_id,
            'creation_date' => $currentDate,
            'last_updated_by' => $user->user_id,
            'last_update_date' => $currentDate,
        ]);

        DB::beginTransaction();
        try {
            $headerData = self::reFetchLookupDataHeader($headerData);

            $header = PtpmIngredientRequestH::query()
                ->create($headerData);
            $lines = [];

            foreach ($linesData as $lineData) {
                $lineData = array_merge($lineData, [
                    'program_id' => self::PROGRAM_ID,
                    'created_by' => $user->user_id,
                    'creation_date' => $currentDate,
                    'last_updated_by' => $user->user_id,
                    'last_update_date' => $currentDate,
                ]);

                $lineData = self::reFetchLookupDataLine($request, $lineData);
                $lines[] = PtpmIngredientRequestL::query()->create($lineData);
            }

            return response()->json([
                'user' => $user,
                'header' => $header,
                'lines' => $lines,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'header' => 'required',
            'header.department_name' => 'required',
            'header.request_num' => 'required',
            'header.machine_group' => 'required',
            'header.item' => 'required',
            'header.user_id' => 'required',
            'header.request_date' => 'required',
            'header.manufacture_step' => 'required',
            'lines' => ['array'],
            'lines.*.request_item' => 'required',
            'lines.*.request_qty' => 'required',
            'lines.*.secondary_uom' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }

        $user = Mock::getMockUser();
        $currentDate = date('Y-m-d H:i:s');

        $headerData = $request->get('header');
        $headerData = array_merge($headerData, [
            'program_id' => self::PROGRAM_ID,
            'last_updated_by' => $user->user_id,
            'last_update_date' => $currentDate,
        ]);

        $linesData = $request->input('lines');

        $user = Mock::getMockUser();
        $currentDate = date('Y-m-d H:i:s');

        DB::beginTransaction();
        try {
            $headerData = self::reFetchLookupDataHeader($headerData);

            $header = PtpmIngredientRequestH::query()
                ->where('ingreq_header_id', '=', $id)
                ->first();
            $header->update($headerData);

            //delete all lines
            PtpmIngredientRequestL::query()
                ->where('ingreq_header_id', $id)
                ->delete();

            //reinsert all lines
            $lines = [];
            foreach ($linesData as $lineData) {
                $lineData['ingreq_header_id'] = $header->ingreq_header_id;
                $lineData['program_id'] = self::PROGRAM_ID;
                $lineData['last_updated_by'] = $user->user_id;
                $lineData['last_update_date'] = $currentDate;

                $lineData = self::reFetchLookupDataLine($lineData, $header);
                $lines[] = PtpmIngredientRequestL::query()->create($lineData);
            }

            DB::commit();
            return response([
                'user' => $user,
                'header' => $header,
                'lines' => $lines,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    private function reFetchLookupDataHeader($headerData): array
    {
        // re-fetch data from database to ensure corrective
        $ptpmItemNumberV = PtpmItemNumberVLookup::query()
            ->where('item_number', '=', $headerData['item'])
            ->first();

        if (isset($ptpmItemNumberV)) {
            $headerData = array_merge($headerData, [
                'inventory_item_id' => $ptpmItemNumberV->inventory_item_id,
            ]);
        }
        return $headerData;
    }

    private function reFetchLookupDataLine($lineData, $header): array
    {
        // re-fetch data from database to ensure corrective
        $ptpmItemNumberV = PtpmItemNumberVLookup::query()
            ->where('item_number', '=', $header['item'])
            ->first();

        if (isset($ptpmItemNumberV)) {
            $lineData = array_merge($lineData, [
                'request_item_id' => $ptpmItemNumberV->inventory_item_id,
            ]);
        }

        return $lineData;
    }

    public function deleteLines(Request $request)
    {
        $ids = $request->get('ids');

        DB::beginTransaction();
        try {
            $res = PtpmIngredientRequestL::query()
                ->whereIn('ingreq_line_id', $ids)
                ->delete();

            DB::commit();
            return response([
                'res' => $res,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }
}
