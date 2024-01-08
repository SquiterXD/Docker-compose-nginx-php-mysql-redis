<?php

namespace App\Http\Controllers\PD\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationErrorMessages;
use App\Models\PD\PtpdInvMaterialItem;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDO;


class PD0004ApiController extends Controller
{
    const PROGRAM_CODE = '/pd/inv-material-items';
    //const PROGRAM_CODE_FOR_STORE = 'PDP0001';

    public function store(Request $request): JsonResponse
    {
        $rawMaterialItem = $request->get('inv_material_item');
        $defaultData = (array)getDefaultData($this::PROGRAM_CODE);
        $webBatchNo = $this->generateWebBatchNo();
        $currentDateTime = date('Y-m-d H:i:s');

        $rawMaterialItem = [
            'raw_material_type_code' => $rawMaterialItem['raw_material_type_code'],
            'raw_material_type' => $rawMaterialItem['raw_material_type'],
            'inventory_item_code' => $rawMaterialItem['inventory_item_code'],
            'description' => $rawMaterialItem['description'],
            'web_batch_no' => $webBatchNo,
            'blend_no' => $rawMaterialItem['blend_no'],
            'program_code' => $defaultData['program_code'],
            'record_type' => 'INSERT',
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
            'created_by_id' => $defaultData['user_id'],
            'updated_by_id' => $defaultData['user_id'],
        ];

        PtpdInvMaterialItem::create([
            'raw_material_type_code' => $rawMaterialItem['raw_material_type_code'],
            'raw_material_type' => $rawMaterialItem['raw_material_type'],
            'inventory_item_code' => $rawMaterialItem['inventory_item_code'],
            'description' => $rawMaterialItem['description'],
            'web_batch_no' => $webBatchNo,
            'blend_no' => $rawMaterialItem['blend_no'],
            'program_code' => $defaultData['program_code'],
            'record_type' => 'INSERT',
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
            'created_by_id' => $defaultData['user_id'],
            'updated_by_id' => $defaultData['user_id'],
        ]);

        $packageResponse = $this->callPackage($webBatchNo);
        if (strcmp($packageResponse['v_status'], 'S') === 0) {
            //if package success, we can retrieve newly create item
            $newRawMaterialItem = PtpdInvMaterialItem::query()
                ->where('web_batch_no', '=', $webBatchNo)
                ->first();

            return response()->json([
                'inv_material_item' => $newRawMaterialItem,
            ]);
        } else {
            return response()->json($packageResponse, 500);
        }
    }

    private function generateWebBatchNo(): string
    {
        return date('YmdHis') . substr(strval(round(microtime(true) * 1000)), -4);
    }

    private function callPackage($webBatchNo): array
    {
        $defaultData = (array)getDefaultData($this::PROGRAM_CODE);
        $programCode = $defaultData['program_code'];
        $userName = $defaultData['fnd_user_name'];

        $sql = "
            declare
                v_status          varchar2(20);
                v_err_msg         varchar2(2000);

            begin
                ptpd_main_pkg.create_item(
                    p_program_code => '$programCode',
                    p_web_batch_no => '$webBatchNo',
                    p_user_name => '$userName',
                    p_status => :v_status,
                    p_err_msg => :v_err_msg);

                dbms_output.put_line('status : ' || :v_status);
                dbms_output.put_line('error : ' || :v_err_msg);
            end;
        ";

        $packageResponse = [];

        $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
        $stmt->bindParam(":v_status", $packageResponse['v_status'], PDO::PARAM_STR, 20);
        $stmt->bindParam(":v_err_msg", $packageResponse['v_err_msg'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $packageResponse;
    }

    public function show($inventoryItemId): JsonResponse
    {
        try {

            $validator = Validator::make(
                ['inventory_item_id' => $inventoryItemId],
                ['inventory_item_id' => ['required']],
                ValidationErrorMessages::TEMPLATES,
                ['inventory_item_id' => 'inventory_item_id'],
            );
            if ($validator->fails()) {
                return response()->json([
                    'inventory_item_id' => 'invalid inventory item id'
                ], 400);
            }

            $newInvMaterialItem = PtpdInvMaterialItem::query()
                ->where('inventory_item_id', '=', $inventoryItemId)
                ->first();

            if (!isset($newInvMaterialItem)) {
                return response()->json('Not Found', 404);
            }

            return response()->json([
                'inv_material_item' => $newInvMaterialItem,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function update(Request $request, $rawMaterialId): JsonResponse
    {
        $rawMaterialItem = $request->get('inv_material_item');
        $validator = $this->updateValidation($request, $rawMaterialId);

        if ($validator->fails()) {
            return response()->json(array_merge(
                $validator->messages()->toArray(),
                [
                    'inv_material_item' => $rawMaterialItem,
                ]), 400);
        }

        if (intval($rawMaterialId) !== intval($rawMaterialItem['raw_material_id'])) {
            return response()->json(
                ['inv_material_item', 'the id provided in path mismatch the id in request object'],
                409);
        }

        try {
            $existingRawMaterialItem = PtpdInvMaterialItem::query()
                ->where('raw_material_id', '=', $rawMaterialId)
                ->firstOrFail();
            if (!isset($existingRawMaterialItem)) {
                return response()->json('Not Found', 404);
            }

            $defaultData = (array)getDefaultData($this::PROGRAM_CODE);
            $currentDateTime = date('Y-m-d H:i:s');

            $rawMaterialItem = array_merge($rawMaterialItem, [
                'description' => trim($rawMaterialItem['description']),
                'record_type' => 'UPDATE',
                'interface_status' => null,
                'web_batch_no' => $existingRawMaterialItem['web_batch_no'],
                'updated_at' => $currentDateTime,
                'updated_by_id' => $defaultData['user_id'],
            ]);

            PtpdInvMaterialItem::query()
                ->where('raw_material_id', '=', $rawMaterialId)
                ->update($rawMaterialItem);

            $packageResponse = $this->callPackage($rawMaterialItem['web_batch_no']);
            if (strcmp($packageResponse['v_status'], 'S') === 0) {
                //retrieve updated item and return
                $updatedRawMaterialItem = PtpdInvMaterialItem::query()
                    ->where('raw_material_id', '=', $rawMaterialId)
                    ->first()
                    ->toArray();

                // get all items
                $query = "select *
                    from oapd.PTPD_INV_MATERIAL_ITEM
                    where raw_material_type_code in ('06', '07', '91', '90', '12')
                    order by inventory_item_code asc";

                $existedItems = DB::select($query);

                return response()->json([
                    'inv_material_item' => $updatedRawMaterialItem,
                    'existed_items' => $existedItems,
                ]);
            } else {
                return response()->json($packageResponse, 500);
            }

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function updateValidation(Request $request, $rawMaterialId): \Illuminate\Contracts\Validation\Validator
    {
        $pathIdValidator = Validator::make(
            ['raw_material_id' => $rawMaterialId],
            ['raw_material_id' => ['required', 'numeric', 'integer']],
            ValidationErrorMessages::TEMPLATES,
            ['raw_material_id' => 'raw_material_id'],
        );
        if ($pathIdValidator->fails()) {
            return $pathIdValidator;
        }

        $rawMaterialItem = $request->get('inv_material_item');

        $validatingRules = [
            'raw_material_id' => ['required', 'numeric', 'integer'],
            //'description' => 'required',
        ];

        $attributeNames = [
            'raw_material_id' => 'รหัสวัตถุดิบ',
            //'description' => 'รายละเอียดบุหรี่ทดลองต้องมีค่า',
        ];

        return Validator::make(
            $rawMaterialItem,
            $validatingRules,
            ValidationErrorMessages::TEMPLATES,
            $attributeNames,
        );
    }
}
