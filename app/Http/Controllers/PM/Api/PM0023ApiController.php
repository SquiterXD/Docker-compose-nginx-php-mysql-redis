<?php /** @noinspection DuplicatedCode */

namespace App\Http\Controllers\PM\Api;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationErrorMessages;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDO;

class PM0023ApiController extends Controller
{
    public function showRawMaterial($id): JsonResponse
    {
        $id = trim($id);

        $validator = $this->showRawMaterialValidation($id);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }

        try {
            $sql = "
                    declare
                        l_ID                varchar2(100);
                        l_DESCRIPTION       varchar2(500);
                        l_status            varchar2(500);

                    begin
                        PTPM_TRANSACTION_PKG.QR_CODE
                        (
                            P_QR_CODE_1         => $id
                            , P_QR_CODE_2       => ''
                            , P_FLAG            => ''
                            , V_ID              => :l_ID
                            , V_DESCRIPTION     => :l_DESCRIPTION
                            , V_STATUS          => :l_status
                        );

                        dbms_output.put_line(:l_ID);
                        dbms_output.put_line(:l_DESCRIPTION);
                        dbms_output.put_line(:l_status);
                    end;
                ";

            $response = [];

            $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
            $stmt->bindParam(":l_ID", $response['id'], PDO::PARAM_STR, 100);
            $stmt->bindParam(":l_DESCRIPTION", $response['description'], PDO::PARAM_STR, 500);
            $stmt->bindParam(":l_status", $response['status'], PDO::PARAM_STR, 500);
            $stmt->execute();

            //we have to bind all params as it is mandatory for Oracle
            //the 'status' key never use, so we unset it here
            unset($response['status']);

            if (!isset($response['id'])) {
                return response()->json('Not Found', 404);
            } else {
                return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json([
                'err' => $e,
            ], 500);
        }
    }

    private function showRawMaterialValidation($rawMaterialId): \Illuminate\Contracts\Validation\Validator
    {
        $NAME_RAW_MATERIAL_ID = 'rawMaterialId';

        $validatingData = [
            $NAME_RAW_MATERIAL_ID => $rawMaterialId,
        ];

        $validatingRules = [
            $NAME_RAW_MATERIAL_ID => 'required|numeric|integer',
        ];

        $attributeNames = [
            $NAME_RAW_MATERIAL_ID => 'รหัสวัตถุดิบ',
        ];

        return Validator::make(
            $validatingData,
            $validatingRules,
            ValidationErrorMessages::TEMPLATES,
            $attributeNames,
        );
    }

    public function compareRequestAndOnShelfRawMaterial(Request $request): JsonResponse
    {
        $queryString = $request->all();
        $requestRawMaterialId = Utils::getArrayValueOrDefault($queryString, 'rawMaterialId');
        $onShelfRawMaterialId = Utils::getArrayValueOrDefault($queryString, 'onShelfRawMaterialId');

        $validator = $this->compareRequestAndOnShelfRawMaterialValidation($requestRawMaterialId, $onShelfRawMaterialId);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }

        try {
            $sql = "
                    declare
                        l_ID              varchar2(100);
                        l_DESCRIPTION     varchar2(500);
                        l_status          varchar2(500);
                    begin
                        PTPM_TRANSACTION_PKG.QR_CODE(
                        P_QR_CODE_1 => $requestRawMaterialId
                        , P_QR_CODE_2 => $onShelfRawMaterialId
                        , P_FLAG => 'CHECK'
                        , V_ID => :l_ID
                        , V_DESCRIPTION => :l_DESCRIPTION
                        , V_STATUS => :l_status);

                        dbms_output.put_line(:l_ID);
                        dbms_output.put_line(:l_DESCRIPTION);
                        dbms_output.put_line(:l_status);
                    end;
                ";

            $response = [];

            $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
            $stmt->bindParam(":l_ID", $response['id'], PDO::PARAM_STR, 100);
            $stmt->bindParam(":l_DESCRIPTION", $response['description'], PDO::PARAM_STR, 500);
            $stmt->bindParam(":l_status", $status, PDO::PARAM_STR, 500);
            $stmt->execute();

            $response['status'] = boolval($status);

            if (!isset($response['id'])) {
                return response()->json('Not Found', 404);
            } else {
                return response()->json($response);
            }

        } catch (Exception $e) {
            return response()->json([
                'err' => $e,
            ], 500);
        }
    }

    private function compareRequestAndOnShelfRawMaterialValidation($requestRawMaterialId, $onShelfRawMaterialId): \Illuminate\Contracts\Validation\Validator
    {
        $NAME_REQUEST_RAW_MATERIAL_ID = 'requestRawMaterialId';
        $NAME_ON_SHELF_RAW_MATERIAL_ID = 'onShelfRawMaterialId';

        $validatingData = array(
            $NAME_REQUEST_RAW_MATERIAL_ID => $requestRawMaterialId,
            $NAME_ON_SHELF_RAW_MATERIAL_ID => $onShelfRawMaterialId,
        );

        $validatingRules = array(
            $NAME_REQUEST_RAW_MATERIAL_ID => 'required|numeric|integer',
            $NAME_ON_SHELF_RAW_MATERIAL_ID => 'required|numeric|integer',
        );

        $attributeNames = array(
            $NAME_REQUEST_RAW_MATERIAL_ID => 'รหัสวัตถุดิบ',
            $NAME_ON_SHELF_RAW_MATERIAL_ID => 'รหัสวัตถุดิบบนชั้นวาง',
        );

        return Validator::make(
            $validatingData,
            $validatingRules,
            ValidationErrorMessages::TEMPLATES,
            $attributeNames,
        );
    }
}
