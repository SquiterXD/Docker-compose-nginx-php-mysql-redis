<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ModulePaths;
use App\Http\Controllers\ValidationErrorMessages;
use App\Models\PM\PtpmExpirationCheck;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDO;

class PM0041ApiController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $sql = "
                declare
                    l_status    varchar2(100);
                    l_message   varchar2(1000);

                begin
                    PTPM_MICS_PKG.insert_expiration(
                        V_STATUS    => l_status,
                        V_MESSAGE   => l_message);

                    dbms_output.put_line(:l_status);
                    dbms_output.put_line(:l_message);
                end;
            ";

            $response = [];
            $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
            $stmt->bindParam(":l_status", $response['l_status'], PDO::PARAM_STR, 100);
            $stmt->bindParam(":l_message", $response['l_message'], PDO::PARAM_STR, 1000);
            $stmt->execute();

            if (isset($response['l_status']) && $response['l_status'] === 'E') {
                return response()->json(['errorMessage', 'Call package failed'], 500);
            }

//            $expiredItems = PtpmExpirationCheck::query()
//                ->whereRaw("trunc(creation_date) <= to_date(?, 'yyyy/mm/dd')", date('Y-m-d'))
//                ->orderBy('origination_date')
//                ->orderBy('expire_date')
//                ->orderBy('item_code')
//                ->get()
//                ->toArray();

            $expiredItems = DB::select("SELECT P.* ,
                                                U.UNIT_OF_MEASURE
                                                FROM  PTPM_EXPIRATION_CHECK P
                                                LEFT JOIN  APPS.MTL_UNITS_OF_MEASURE_VL U
                                                ON U.UOM_CODE = P.UOM");

            return response()->json([
                'expired_items' => $expiredItems,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function updateExamineCasing(Request $request): JsonResponse
    {
        try {
            $validator = $this->updateExamineCasingValidation($request);
            if ($validator->fails()) {
                return response()->json($validator->messages()->toArray(), 400);
            }

            $defaultData = getDefaultData(ModulePaths::PM_0041);
            $data = $request->all();
            $isAccepted = $data['is_accepted'];
            $expiredItems = $data['expired_items'];
            $newExpiredDate = $data['new_expired_date'];

            $expiredItemIds = array_map(function ($item) {
                return $item['expiration_id'];
            }, $expiredItems);

            $status = $isAccepted ? 'ผ่าน' : 'ไม่ผ่าน';

            if ($isAccepted){

                PtpmExpirationCheck::query()
                    ->whereIn('expiration_id', $expiredItemIds)
                    ->update([
                        'status' => $status,
                        'approved_by' => $defaultData->user_id,
                        'expire_date_new' => $newExpiredDate,
                        'expire_date_status' => 'รออนุมัติ',
                    ]);

            }
            else {
                PtpmExpirationCheck::query()
                    ->whereIn('expiration_id', $expiredItemIds)
                    ->update([
                        'status' => $status,
                        'approved_by' => $defaultData->user_id,
                        'expire_date_new' => $newExpiredDate == '' ? null : $newExpiredDate,
                    ]);
            }

            $updatedItems = PtpmExpirationCheck::query()
                ->whereIn('expiration_id', $expiredItemIds)
                ->get()
                ->toArray();

            $lov_status = DB::select("SELECT STATUS
                                        FROM ((SELECT DISTINCT STATUS
                                               FROM APPS.PTPM_EXPIRATION_CHECK
                                                     WHERE STATUS IS NOT NULL
                                              ) UNION
                                              (SELECT 'แสดงทั้งหมด'
                                               FROM DUAL
                                              )
                                             ) S
                                        ORDER BY
                                            CASE STATUS
                                            WHEN 'แสดงทั้งหมด' THEN 1
                                            WHEN 'รอลงผล' THEN 2
                                            WHEN 'ผ่าน' THEN 3
                                            WHEN 'ไม่ผ่าน' THEN 4
                                            ELSE 5 END");

            $lov_expire_date_status = DB::select("SELECT EXPIRE_DATE_STATUS
                                        FROM ((SELECT DISTINCT EXPIRE_DATE_STATUS
                                               FROM APPS.PTPM_EXPIRATION_CHECK
                                                     WHERE EXPIRE_DATE_STATUS IS NOT NULL
                                              ) UNION
                                              (SELECT 'แสดงทั้งหมด'
                                               FROM DUAL
                                              )
                                             ) S
                                        ORDER BY
                                            CASE EXPIRE_DATE_STATUS
                                            WHEN 'แสดงทั้งหมด' THEN 1
                                            WHEN 'รออนุมัติ' THEN 2
                                            WHEN 'ผ่าน' THEN 3
                                            WHEN 'ไม่ผ่าน' THEN 4
                                            ELSE 5 END");


            return response()->json([
                'expired_items' => $updatedItems,
                'lov_status' => $lov_status,
                'lov_expire_date_status' => $lov_expire_date_status,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    private function updateExamineCasingValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $requestBody = $request->all();

        $validatingRules = [
            'is_accepted' => ['required', 'boolean'],
            'expired_items' => ['present', 'array'],
            'expired_items.*.expiration_id' => ['required', 'numeric', 'integer'],
        ];

        $attributeNames = [
            'is_accepted' => 'การยอมรับ',
            'expired_items.*.expiration_id' => 'รหัสของสารหอมที่หมดอายุ',
        ];

        return Validator::make(
            $requestBody,
            $validatingRules,
            ValidationErrorMessages::TEMPLATES,
            $attributeNames,
        );
    }

    public function updateExpirationDate(Request $request): JsonResponse
    {
        try {
            $validator = $this->updateExpirationDateValidation($request);
            if ($validator->fails()) {
                return response()->json($validator->messages()->toArray(), 400);
            }

            $defaultData = getDefaultData(ModulePaths::PM_0041);
            $data = $request->all();
            $expiredItems = $data['expired_items'];

            $expiredItemIds = array_map(function ($item) {
                return $item['expiration_id'];
            }, $expiredItems);

            DB::beginTransaction();

            foreach ($expiredItems as $expiredItem) {
                PtpmExpirationCheck::query()
                    ->where('expiration_id', '=', $expiredItem['expiration_id'])
                    ->update([
                        'expire_date_status' => 'รออนุมัติ',
                        'expire_date_new' => $expiredItem['expire_date_new'],
                        'approved_by' => $defaultData->user_id,
                    ]);
            }

            $updatedItems = PtpmExpirationCheck::query()
                ->whereIn('expiration_id', $expiredItemIds)
                ->get()
                ->toArray();

            DB::commit();

            $lov_status = DB::select("SELECT STATUS
                                        FROM ((SELECT DISTINCT STATUS
                                               FROM APPS.PTPM_EXPIRATION_CHECK
                                                     WHERE STATUS IS NOT NULL
                                              ) UNION
                                              (SELECT 'แสดงทั้งหมด'
                                               FROM DUAL
                                              )
                                             ) S
                                        ORDER BY
                                            CASE STATUS
                                            WHEN 'แสดงทั้งหมด' THEN 1
                                            WHEN 'รอลงผล' THEN 2
                                            WHEN 'ผ่าน' THEN 3
                                            WHEN 'ไม่ผ่าน' THEN 4
                                            ELSE 5 END");

            $lov_expire_date_status = DB::select("SELECT EXPIRE_DATE_STATUS
                                        FROM ((SELECT DISTINCT EXPIRE_DATE_STATUS
                                               FROM APPS.PTPM_EXPIRATION_CHECK
                                                     WHERE EXPIRE_DATE_STATUS IS NOT NULL
                                              ) UNION
                                              (SELECT 'แสดงทั้งหมด'
                                               FROM DUAL
                                              )
                                             ) S
                                        ORDER BY
                                            CASE EXPIRE_DATE_STATUS
                                            WHEN 'แสดงทั้งหมด' THEN 1
                                            WHEN 'รออนุมัติ' THEN 2
                                            WHEN 'ผ่าน' THEN 3
                                            WHEN 'ไม่ผ่าน' THEN 4
                                            ELSE 5 END");

            return response()->json([
                'expired_items' => $updatedItems,
                'lov_status' => $lov_status,
                'lov_expire_date_status' => $lov_expire_date_status,
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    private function updateExpirationDateValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $requestBody = $request->all();

        $validatingRules = [
            'expired_items' => ['present', 'array'],
            'expired_items.*.expiration_id' => ['required', 'numeric', 'integer'],
            'expired_items.*.expire_date_new' => ['required', 'date'],
        ];

        $attributeNames = [
            'expired_items' => 'รายการสินค้า',
            'expired_items.*.expiration_id' => 'รหัสของสารหอมที่หมดอายุ',
            'expired_items.*.expire_date_new' => 'วันหมดอายุใหม่',
        ];

        return Validator::make(
            $requestBody,
            $validatingRules,
            ValidationErrorMessages::TEMPLATES,
            $attributeNames,
        );
    }
}
