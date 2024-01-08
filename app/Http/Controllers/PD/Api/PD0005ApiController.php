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


class PD0005ApiController extends Controller
{
    const PROGRAM_CODE = 'PD0005';
    const PROGRAM_CODE_FOR_STORE = 'PDP0002';
    const RAW_MATERIAL_TYPE_CODE = '1590';

    public function store(Request $request): JsonResponse
    {
        $validator = $this->storeValidation($request);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }

        $exampleCigarette = $request->get('exampleCigarette');
        $defaultData = (array)getDefaultData($this::PROGRAM_CODE);
        $webBatchNo = $this->generateWebBatchNo();
        $currentDateTime = date('Y-m-d H:i:s');

        $exampleCigarette = [
            'raw_material_type_code' => $this::RAW_MATERIAL_TYPE_CODE,
            'description' => $exampleCigarette['description'],
            'web_batch_no' => $webBatchNo,
            'blend_no' => null,
            'program_code' => $this::PROGRAM_CODE_FOR_STORE,
            'record_type' => 'INSERT',

            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
            'created_by_id' => $defaultData['user_id'],
            'updated_by_id' => $defaultData['user_id'],
        ];

        if (isset($exampleCigarette['inventory_item_code'])) {
            $existingItem = PtpdInvMaterialItem::query()
                ->find($exampleCigarette['inventory_item_code']);
            if (isset($existingItem)) {
                return response()->json(
                    ['$example_cigarette', 'The id already exist in database. If you want to update use PUT instead.'],
                    409);
            }
        }

        PtpdInvMaterialItem::query()
            ->create($exampleCigarette)
            ->toArray();

        $packageResponse = $this->callPackage($webBatchNo);
        if (strcmp($packageResponse['v_status'], 'S') === 0) {
            //if package success, we can retrieve newly create item
            $newExampleCigarette = PtpdInvMaterialItem::query()
                ->where('web_batch_no', '=', $webBatchNo)
                ->first();

            return response()->json([
                'example_cigarette' => $newExampleCigarette,
            ]);
        } else {
            return response()->json($packageResponse, 500);
        }
    }

    private function storeValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $exampleCigarette = $request->get('exampleCigarette');

        $validatingRules = [
            'description' => 'required',
        ];

        $attributeNames = [
            'description' => 'รายละเอียดบุหรี่ทดลองต้องมีค่า',
        ];

        return Validator::make(
            $exampleCigarette,
            $validatingRules,
            ValidationErrorMessages::TEMPLATES,
            $attributeNames,
        );
    }

    public function show($inventoryItemCode): JsonResponse
    {
        try {
            $validator = Validator::make(
                ['inventory_item_code' => $inventoryItemCode],
                ['inventory_item_code' => ['required']],
                ValidationErrorMessages::TEMPLATES,
                ['inventory_item_code' => 'inventory_item_code'],
            );
            if ($validator->fails()) {
                return response()->json([
                    'inventory_item_code' => 'invalid inventory item code'
                ], 400);
            }

            $newExampleCigarette = PtpdInvMaterialItem::query()
                ->where('inventory_item_code', '=', $inventoryItemCode)
                ->first();

            if (!isset($newExampleCigarette)) {
                return response()->json('Not Found', 404);
            }

            return response()->json([
                'example_cigarette' => $newExampleCigarette,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function update(Request $request, $rawMaterialId): JsonResponse
    {
        $exampleCigarette = $request->get('example_cigarette');
        $validator = $this->updateValidation($request, $rawMaterialId);
        if ($validator->fails()) {
            return response()->json(array_merge(
                $validator->messages()->toArray(),
                [
                    'example_cigarette' => $exampleCigarette,
                ]), 400);
        }

        if (intval($rawMaterialId) !== intval($exampleCigarette['raw_material_id'])) {
            return response()->json(
                ['example_cigarette', 'the id provided in path mismatch the id in request object'],
                409);
        }

        try {
            $existingExampleCigarette = PtpdInvMaterialItem::query()
                ->where('raw_material_id', '=', $rawMaterialId)
                ->firstOrFail();
            if (!isset($existingExampleCigarette)) {
                return response()->json('Not Found', 404);
            }

            $defaultData = (array)getDefaultData($this::PROGRAM_CODE);
            $currentDateTime = date('Y-m-d H:i:s');

            $exampleCigarette = array_merge($exampleCigarette, [
                'description' => trim($exampleCigarette['description']),
                'record_type' => 'UPDATE',
                'interface_status' => null,

                'updated_at' => $currentDateTime,
                'updated_by_id' => $defaultData['user_id'],
            ]);

            PtpdInvMaterialItem::query()
                ->where('raw_material_id', '=', $rawMaterialId)
                ->update($exampleCigarette);

            $packageResponse = $this->callPackage($exampleCigarette['web_batch_no']);
            if (strcmp($packageResponse['v_status'], 'S') === 0) {
                //retrieve updated item and return
                $updatedExampleCigarette = PtpdInvMaterialItem::query()
                    ->where('raw_material_id', '=', $rawMaterialId)
                    ->first()
                    ->toArray();

                return response()->json([
                    'example_cigarette' => $updatedExampleCigarette,
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

        $exampleCigarette = $request->get('example_cigarette');

        $validatingRules = [
            'raw_material_id' => ['required', 'numeric', 'integer'],
            'description' => 'required',
        ];

        $attributeNames = [
            'raw_material_id' => 'รหัสสินค้า',
            'description' => 'รายละเอียดบุหรี่ทดลองต้องมีค่า',
        ];

        return Validator::make(
            $exampleCigarette,
            $validatingRules,
            ValidationErrorMessages::TEMPLATES,
            $attributeNames,
        );
    }

    private function callPackage($webBatchNo): array
    {
        $defaultData = (array)getDefaultData();
        $programCode = $this::PROGRAM_CODE_FOR_STORE;
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

    public function search(Request $request): JsonResponse
    {
        $queryString = $request->all();
        $query = PtpdInvMaterialItem::query();

        if (isset($queryString['inventory_item_code'])) {
            $inventoryItemCode = trim($queryString['inventory_item_code']);
            $query->whereRaw("LOWER(inventory_item_code) like ?", [strtolower("%$inventoryItemCode%")]);
        }

        if (isset($queryString['description'])) {
            $description = trim($queryString['description']);
            $query->whereRaw("LOWER(description) like ?", [strtolower("%$description%")]);
        }

        $exampleCigarettes = $query
            ->where('raw_material_type_code', '=', $this::RAW_MATERIAL_TYPE_CODE)
            ->take(30)
            ->get();

        return response()->json([
            'example_cigarettes' => $exampleCigarettes,
        ]);
    }

    private function generateWebBatchNo(): string
    {
        return date('YmdHis') . substr(strval(round(microtime(true) * 1000)), -4);
    }
}
