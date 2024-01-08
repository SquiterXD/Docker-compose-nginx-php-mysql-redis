<?php

namespace App\Http\Controllers\PM\Api;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class PM0042ApiController extends Controller
{
    public function approveRequest(Request $request): JsonResponse
    {
        $body = $request->all();
        $checkedRequests = $body['checked_requests'];
        $packageResults = [];

        try {
            foreach ($checkedRequests as $checkedRequest) {
                $inventoryItemId = $checkedRequest['inventory_item_id'];
                $lotNumber = $checkedRequest['lot_number'];
                $expireDateNew = $checkedRequest['expire_date_new'];

                $sql = "
                        declare
                              v_status varchar2(1000);
                        begin
                            v_status := APPS.PTPM_MICS_PKG.change_expiration(p_inventory_item_id => '$inventoryItemId',
                            p_lot_number => '$lotNumber',
                            p_date => to_date('{$expireDateNew}', 'yyyy-mm-dd'));

                        dbms_output.put_line(v_status);

                        end;
                ";

                $response = [];
                $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
                //$stmt->bindParam(":v_status", $response['v_status'], PDO::PARAM_STR, 1000);

                $stmt->execute();

                $packageResults[] = $response;
            }

            return response()->json([
                'results' => $packageResults,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }

    }

    public function RejectRequest(Request $request): JsonResponse
    {
        $body = $request->all();
        $checkedRequests = $body['checked_requests'];
        $results = [];

        try {
            foreach ($checkedRequests as $checkedRequest) {
                $expirationId = $checkedRequest['expiration_id'];

                $results[] = DB::update("UPDATE OAPM.PTPM_EXPIRATION_CHECK
                                SET EXPIRE_DATE_STATUS = 'ไม่ผ่าน',
                                    EXPIRE_DATE_NEW = null
                                WHERE EXPIRATION_ID = ?", [$expirationId]);

            }
            return response()->json(['affected' => $results]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }
}
