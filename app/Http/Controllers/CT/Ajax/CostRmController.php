<?php

namespace App\Http\Controllers\CT\Ajax;

use PDO;
use App\Http\Controllers\Controller;
use App\Models\CT\PtctCostRm;
use App\Models\CT\OrgInv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostRmController extends Controller
{
    public function index(Request $request)
    {
      $data = PtctCostRm::where('cost_code', $request['cost_code'])->get();
      return response()->json([
        "message" => 'success',
        'data'    => $data,
      ], 200);
    }

    public function store(Request $request)
    {
      $user = getDefaultData('/users');
      $createdBy = $user->fnd_user_id;
      $dataType = 'CREATE';
      $costCode = $request->cost_code;
      

      $orgList = $request->data;
      $result = [];
      // try {
        $db = DB::connection('oracle')->getPdo();
        foreach ($orgList as $key => $org) {
          $organization_code = $org['organization_code'];
          $organization_name = $org['organization_name'];

          $checkDuplicate = PtctCostRm::where('cost_code', $request['cost_code'])->where('org_ingredient', $organization_code)->first();
          if (!$checkDuplicate) {
            $sql = "
            DECLARE
                v_debug     NUMBER := 0;
                v_data_rec  apps.ptct_update_master_pkg.ct01_rm_param_rec;
            BEGIN
                v_data_rec := NULL;
                        
                ----***Require field
                v_data_rec.created_by   := :CREATED_BY; --USER_NAME => MERCURY
                v_data_rec.data_type    := :DATA_TYPE; --ADD/NEW,UPDATE/CREATE/DELETE/Del
                v_data_rec.cost_code    := :COST_CODE; ----** PTCT_COST_CENTER_V.COST_CODE
                v_data_rec.rm_org       := :ORGANIZATION_CODE; -----PTINV_ORGANIZATIONS_INFO.ORGANIZATION_CODE WHERE SOURCE_ITEM_COST IS NOT NULL
                v_data_rec.description  := :ORGANIZATION_NAME;

                ---- output
                v_data_rec.return_status := NULL;
                v_data_rec.return_message := NULL;
                apps.ptct_update_master_pkg.web_ctm01_rm(p_param_data => v_data_rec);

                dbms_output.put_line('Output : interface_name = ' || v_data_rec.interface_name);
                dbms_output.put_line('Output : return_status = ' || v_data_rec.return_status);
                dbms_output.put_line('Output : message = ' || v_data_rec.return_message);
                dbms_output.put_line('------ E N D ------');

                :P_RETURN_STATUS :=  v_data_rec.return_status;
                :P_RETURN_MESSAGE :=  v_data_rec.return_message;
                dbms_output.put_line('------  E N D ------');
            EXCEPTION
                WHEN OTHERS THEN
                    dbms_output.put_line('***Error-' || sqlerrm);
            END;
            ";

            $result = [];
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':CREATED_BY', $createdBy, PDO::PARAM_STR, 100);
            $stmt->bindParam(':DATA_TYPE', $dataType, PDO::PARAM_STR, 100);
            $stmt->bindParam(':COST_CODE', $costCode, PDO::PARAM_STR, 100);
            $stmt->bindParam(':ORGANIZATION_CODE', $organization_code, PDO::PARAM_STR, 100);
            $stmt->bindParam(':ORGANIZATION_NAME', $organization_name, PDO::PARAM_STR, 100);

            $stmt->bindParam(':P_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 1);
            $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], PDO::PARAM_STR, 4000);
            $stmt->execute();

            if ($result['status'] != 'C') {
                throw new \Exception($result['message']);
            }
          }
          
        }
      // } catch (\Exception $e) {
      //   $data = [
      //       'status' => 'E',
      //       'msg' => $e->getMessage()
      //   ];
    // }
    return response()->json([
      "status"  => true,
      "message" => "success"
    ], 200);

    }

    public function destroy(Request $request)
    {
      $user = getDefaultData('/users');
      $createdBy = $user->fnd_user_id;
      $dataType = 'DELETE';
      $costCode = $request->cost_code;
      $organization_code = $request->org_code;
      $organization_name = $request->org_name;
      
      $result = [];

      $db = DB::connection('oracle')->getPdo();

      $sql = "
            DECLARE
                v_debug     NUMBER := 0;
                v_data_rec  apps.ptct_update_master_pkg.ct01_rm_param_rec;
            BEGIN
                v_data_rec := NULL;
                        
                ----***Require field
                v_data_rec.created_by   := :CREATED_BY; --USER_NAME => MERCURY
                v_data_rec.data_type    := :DATA_TYPE; --ADD/NEW,UPDATE/CREATE/DELETE/Del
                v_data_rec.cost_code    := :COST_CODE; ----** PTCT_COST_CENTER_V.COST_CODE
                v_data_rec.rm_org       := :ORGANIZATION_CODE; -----PTINV_ORGANIZATIONS_INFO.ORGANIZATION_CODE WHERE SOURCE_ITEM_COST IS NOT NULL
                v_data_rec.description  := :ORGANIZATION_NAME;

                ---- output
                v_data_rec.return_status := NULL;
                v_data_rec.return_message := NULL;
                apps.ptct_update_master_pkg.web_ctm01_rm(p_param_data => v_data_rec);

                dbms_output.put_line('Output : interface_name = ' || v_data_rec.interface_name);
                dbms_output.put_line('Output : return_status = ' || v_data_rec.return_status);
                dbms_output.put_line('Output : message = ' || v_data_rec.return_message);
                dbms_output.put_line('------ E N D ------');

                :P_RETURN_STATUS :=  v_data_rec.return_status;
                :P_RETURN_MESSAGE :=  v_data_rec.return_message;
                dbms_output.put_line('------  E N D ------');
            EXCEPTION
                WHEN OTHERS THEN
                    dbms_output.put_line('***Error-' || sqlerrm);
            END;
            ";

            $result = [];
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':CREATED_BY', $createdBy, PDO::PARAM_STR, 100);
            $stmt->bindParam(':DATA_TYPE', $dataType, PDO::PARAM_STR, 100);
            $stmt->bindParam(':COST_CODE', $costCode, PDO::PARAM_STR, 100);
            $stmt->bindParam(':ORGANIZATION_CODE', $organization_code, PDO::PARAM_STR, 100);
            $stmt->bindParam(':ORGANIZATION_NAME', $organization_name, PDO::PARAM_STR, 100);

            $stmt->bindParam(':P_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 1);
            $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], PDO::PARAM_STR, 4000);
            $stmt->execute();

            if ($result['status'] != 'C') {
                throw new \Exception($result['message']);
            }

            return response()->json([
              "status"  => true,
              "message" => "success"
            ], 200);
    }
}
