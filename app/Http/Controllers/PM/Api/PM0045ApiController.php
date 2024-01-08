<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use App\Helpers\Utils;
use Exception;
use Illuminate\Http\JsonResponse;

class PM0045ApiController extends Controller
{
    public function update(Request $request, $id)
    {
//        $affected = DB::update("UPDATE PTPM_PROCESS_REQUESTS_T SET ATTRIBUTE1 = TO_DATE(?, 'YYYY-MM-DD') WHERE REQUEST_PROCESS_ID = ?", [$request->input('exp'), $id]);
//
//        return response()->json(['affected' => $affected]);
    }

    public function approveRequest(Request $request): JsonResponse
    {
        $body = $request->all();
        $checkedRequest = $body['checked_request'];
        $departmentCode = $checkedRequest['department_code'];
        $requestNumber = $checkedRequest['request_number'];
        $requestProcessId = $checkedRequest['request_process_id'];
        $newExp = $checkedRequest['new_expire_date'];

        try {
            DB::beginTransaction();
            $sql = "
                        declare
                            v_status                varchar2(5);
                            v_err_msg               varchar2(2000);
                        begin
                            apps.PTPM_MICS_PKG.PRODUCT_TEST(p_request_number => '$requestNumber',
                                            p_department_code => '$departmentCode',
                                            p_expire_date => '$newExp',
                                            x_status => :v_status,
                                            x_message => :v_err_msg);
                            dbms_output.put_line(:v_status);
                            dbms_output.put_line(:v_err_msg);
                        end;
                ";

            $response = [];
            $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
            $stmt->bindParam(":v_status", $response['v_status'], PDO::PARAM_STR, 5);
            $stmt->bindParam(":v_err_msg", $response['v_err_msg'], PDO::PARAM_STR, 2000);
            $stmt->execute();

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'err' => $e,
            ], 500);
        }

        $updatedRequests = DB::select("select v.request_process_id,
                                        v.request_number,
                                        v.department_code,
                                        v.item_code,
                                        v.item_description,
                                        v.request_quantity,
                                        v.product_qty,
                                        v.request_uom,
                                        to_char(v.creation_date, 'YYYY-MM-DD') creation_date,
                                        v.expire_date,
                                        v.check_flag

        from apps.ptpm_request_summary_v v
        where v.product_qty is not null
        --and v.check_flag = 0
        and v.department_code = '31000400'
        order by v.request_number desc
        ");

        $updatedRow = DB::select("select v.request_process_id,
                                        v.request_number,
                                        v.department_code,
                                        v.item_code,
                                        v.item_description,
                                        v.request_quantity,
                                        v.product_qty,
                                        v.request_uom,
                                        to_char(v.creation_date, 'YYYY-MM-DD') creation_date,
                                        v.expire_date,
                                        v.check_flag

        from apps.ptpm_request_summary_v v
        where v.product_qty is not null
        and v.request_process_id = $requestProcessId
        --and v.department_code = '31000400'
        order by v.request_number desc
        ");

        return response()->json([
            'response' => $response,
            'updated_requests' => $updatedRequests,
            'updated_row' => $updatedRow,
        ], 200);
    }

    public function cancelRequest(Request $request): JsonResponse
    {
        $body = $request->all();
        $checkedRequest = $body['checked_request'];
        $departmentCode = $checkedRequest['department_code'];
        $requestNumber = $checkedRequest['request_number'];
        $requestProcessId = $checkedRequest['request_process_id'];
        $newExp = "";

        try {
            DB::beginTransaction();
            $sql = "
                        declare
                            v_status                varchar2(5);
                            v_err_msg               varchar2(2000);
                        begin
                            apps.PTPM_MICS_PKG.PRODUCT_TEST(p_request_number => '$requestNumber',
                                            p_department_code => '$departmentCode',
                                            p_expire_date => '',
                                            x_status => :v_status,
                                            x_message => :v_err_msg);
                            dbms_output.put_line(:v_status);
                            dbms_output.put_line(:v_err_msg);
                        end;
                ";

            $response = [];
            $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
            $stmt->bindParam(":v_status", $response['v_status'], PDO::PARAM_STR, 5);
            $stmt->bindParam(":v_err_msg", $response['v_err_msg'], PDO::PARAM_STR, 2000);
            $stmt->execute();

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'err' => $e,
            ], 500);
        }

        $updatedRequests = DB::select("select v.request_process_id,
                                        v.request_number,
                                        v.department_code,
                                        v.item_code,
                                        v.item_description,
                                        v.request_quantity,
                                        v.product_qty,
                                        v.request_uom,
                                        to_char(v.creation_date, 'YYYY-MM-DD') creation_date,
                                        v.expire_date,
                                        v.check_flag

        from apps.ptpm_request_summary_v v
        where v.product_qty is not null
        --and v.check_flag = 0
        and v.department_code = '31000400'
        order by v.request_number desc
        ");

        $updatedRow = DB::select("select v.request_process_id,
                                        v.request_number,
                                        v.department_code,
                                        v.item_code,
                                        v.item_description,
                                        v.request_quantity,
                                        v.product_qty,
                                        v.request_uom,
                                        to_char(v.creation_date, 'YYYY-MM-DD') creation_date,
                                        v.expire_date,
                                        v.check_flag

        from apps.ptpm_request_summary_v v
        where v.product_qty is not null
        and v.request_process_id = $requestProcessId
        --and v.department_code = '31000400'
        order by v.request_number desc
        ");

        return response()->json([
            'response' => $response,
            'updated_requests' => $updatedRequests,
            'updated_row' => $updatedRow,
        ], 200);
    }
}
