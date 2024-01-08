<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

use App\Models\CT\AccountDeptV;
use App\Models\CT\AccountDept;

class AccountDeptVController extends Controller
{
    public function index(Request $request)
    {
        $accountDeptV = AccountDeptV::query()
            ->selectRaw("
                DISTINCT acc_code, sub_acc_code, account_type, account_type_desc, transfer_account_flag, coa_id , account_code_disp,
                apps.PTCT_UTILITIES_PKG.GL_ACC_DESC (ptct_account_dept_v.coa_id , ptct_account_dept_v.acc_code  ) acc_desc,
                apps.PTCT_UTILITIES_PKG.GL_SUBACC_DESC (ptct_account_dept_v.coa_id , ptct_account_dept_v.acc_code , ptct_account_dept_v.sub_acc_code)    sub_acc_desc
            ")
            ->when($request->period_year, function ($query) use ($request) {
                $query->where('period_year', $request->period_year);
            })
            ->orderByRaw('1, 2')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $accountDeptV
        ], 200);
    }

    public function findDept(Request $request)
    {
        $rs = AccountDept::query()
          ->selectRaw("DISTINCT ptct_account_dept.account_code_disp, ptct_account_dept.acc_code, ptct_account_dept.sub_acc_code, ptct_account_dept.dept_code, ptct_account_dept_v.COA_ID
          , apps.gl_flexfields_pkg.get_description_sql (ptct_account_dept_v.COA_ID, 3,  ptct_account_dept.DEPT_CODE) AS Dept_desc
          , apps.gl_flexfields_pkg.get_description_sql  (ptct_account_dept_v.COA_ID, 9, ptct_account_dept.ACC_CODE) AS Acc_desc
          , apps.gl_flexfields_pkg.get_description_sql  (ptct_account_dept_v.COA_ID, 10, ptct_account_dept.SUB_ACC_CODE) AS Sub_acc_desc
          , ptct_account_dept.account_group_type, ptct_account_dept.account_type
          , ptct_account_dept.transfer_account_flag , ptct_account_dept.allocation_criteria_flag
          , ptct_account_dept.enabled_flag
          ")
          ->join('ptct_account_dept_v', 'ptct_account_dept.account_code_disp', '=', 'ptct_account_dept_v.account_code_disp')
          ->where('ptct_account_dept.acc_code', $request->acc_code)
          ->where('ptct_account_dept.sub_acc_code', $request->sub_acc_code)
          ->orderBy('ptct_account_dept.DEPT_CODE')
          ->get();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $rs
        ], 200);
    }

    public function findAddAccount(Request $request) 
    {   
      $not_in =  AccountDept::selectRaw('DISTINCT ptct_account_dept.dept_code')
                ->where('ptct_account_dept_v.acc_code', $request->acc_code)
                ->where('ptct_account_dept_v.sub_acc_code', $request->sub_acc_code)
                ->join('ptct_account_dept_v', 'ptct_account_dept.account_code_disp', '=', 'ptct_account_dept_v.account_code_disp')
                ->get();

      $not_in_arr = array();

      
      foreach ($not_in as $element) {
        array_push($not_in_arr, $element->dept_code);
      }
                            
      $rs = AccountDeptV::query()
            ->selectRaw("DISTINCT ptct_account_dept_v.dept_code
            , apps.gl_flexfields_pkg.get_description_sql (ptct_account_dept_v.COA_ID, 3,  ptct_account_dept_v.DEPT_CODE) AS dept_desc")
            ->where('ptct_account_dept_v.acc_code', $request->acc_code)
            ->where('ptct_account_dept_v.sub_acc_code', $request->sub_acc_code)
            ->whereNotIn('ptct_account_dept_v.dept_code', $not_in)
            ->whereNotNull('ptct_account_dept_v.dept_code')
            ->orderBy('ptct_account_dept_v.DEPT_CODE')
            ->get();

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => $rs
    ], 200);
    }

    public function addDeptCode(Request $request)
    {
      $account_code = $request->account_code_disp;

      $accDept = AccountDeptV::selectRaw("DISTINCT PTCT_ACCOUNT_DEPT_V.ACCOUNT_CODE_DISP  ,
                  PTCT_ACCOUNT_DEPT_V.account_type,
                  PTCT_ACCOUNT_DEPT_V.transfer_account_flag,
                  PTCT_ACCOUNT_DEPT_V.enabled_flag
                  ")
                ->join('PTCT_ACCOUNT_DEPT', 'PTCT_ACCOUNT_DEPT.account_code_disp', '=', 'PTCT_ACCOUNT_DEPT_V.ACCOUNT_CODE_DISP')
                ->where('PTCT_ACCOUNT_DEPT_V.account_code_disp', $account_code)
                ->first();

      $account_type = $accDept->account_type;
      $transfer_account_flag = $accDept->transfer_account_flag;
      $enabled_flag = $accDept->enabled_flag;

      
      foreach ($request->selection_add_dept as $dept_code) {

        $result = [];
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
        DECLARE
            v_debug           NUMBER :=0;
            v_status          varchar2(1);
            v_message         varchar2(4000);

            v_main_rec        apps.ptct_m004_pkg.web_main_parameters;
            O_main_rec        apps.ptct_m004_pkg.web_main_parameters;
            
            
        BEGIN
            v_main_rec := NULL;
            v_main_rec.account_code          := :ACCOUNT_CODE;
            v_main_rec.dept_code             := :DEPT_CODE;
            v_main_rec.account_type          := :ACCOUNT_TYPE;
            v_main_rec.transfer_account_flag := :TRANSFER_ACCOUNT_FLAG;
            v_main_rec.enabled_flag          := :ENABLED_FLAG;
            v_main_rec.flag                  := 'New';
        
            O_main_rec := apps.PTCT_M004_PKG.UPDATE_DATA(P_MAIN_PARAM  => v_main_rec);
            
            :v_status := O_main_rec.return_status;
            :v_message := O_main_rec.return_message;

            dbms_output.put_line('OUTPUT : '||O_main_rec.return_status );
            dbms_output.put_line('OUTPUT : '||O_main_rec.return_message );
            
        EXCEPTION
            WHEN OTHERS THEN
              dbms_output.put_line('***Error-'||sqlerrm);
        END;
        ";


        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        
        $result = false;
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':ACCOUNT_CODE', $account_code, PDO::PARAM_STR, 100);
        $stmt->bindParam(':DEPT_CODE', $dept_code, PDO::PARAM_STR, 100);
        $stmt->bindParam(':ACCOUNT_TYPE', $account_type, PDO::PARAM_STR, 100);
        $stmt->bindParam(':TRANSFER_ACCOUNT_FLAG', $transfer_account_flag, PDO::PARAM_STR, 100);
        $stmt->bindParam(':ENABLED_FLAG', $enabled_flag, PDO::PARAM_STR, 100);

        $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 1);
        $stmt->bindParam(':v_message', $result['message'], PDO::PARAM_STR, 4000);
        \Log::info($result);
        $stmt->execute();

        \Log::info($result['status']);
        var_dump($dept_code);

        if ($result['status'] != "S") {
          return response()->json([
              'msg' => "pkg wrong"
          ], 500);
        } 
      }

      return response()->json([
          'msg' => "success"
      ], 200);  
    }

    public function updateDeptCode(Request $request)
    {
      $account_code = $request->account_code_disp;
      $dept_code = $request->dept_code;
      $account_type = $request->account_type;
      $transfer_account_flag = $request->transfer_account_flag;
      $enabled_flag = $request->enabled_flag;

      DB::beginTransaction();
      try {

        $result = [];
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
        DECLARE
            P_RETURN_STATUS         VARCHAR2(1) := NULL;
            P_RETURN_MESSAGE        VARCHAR2(4000) := NULL;

            v_main_rec        apps.ptct_m004_pkg.web_main_parameters;
            O_main_rec        apps.ptct_m004_pkg.web_main_parameters;
            
        BEGIN
            v_main_rec := NULL;
            v_main_rec.account_code          := :ACCOUNT_CODE;
            v_main_rec.dept_code             := :DEPT_CODE;
            v_main_rec.account_type          := :ACCOUNT_TYPE;
            v_main_rec.transfer_account_flag := :TRANSFER_ACCOUNT_FLAG;
            v_main_rec.enabled_flag          := :ENABLED_FLAG;
            v_main_rec.flag                  := 'Update';
        
            O_main_rec := apps.PTCT_M004_PKG.UPDATE_DATA(P_MAIN_PARAM  => v_main_rec);

            :P_RETURN_STATUS :=  O_main_rec.RETURN_STATUS;
            :P_RETURN_MESSAGE :=  O_main_rec.RETURN_MESSAGE;

            dbms_output.put_line('***RETURN_STATUS-'|| O_main_rec.RETURN_STATUS);
            dbms_output.put_line('***RETURN_MESSAGE-'|| O_main_rec.RETURN_MESSAGE);
            
        EXCEPTION WHEN OTHERS THEN
          dbms_output.put_line('***Error-'||sqlerrm);
        END;
        ";


        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        
        $result = false;
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':ACCOUNT_CODE', $account_code, PDO::PARAM_STR, 100);
        $stmt->bindParam(':DEPT_CODE', $dept_code, PDO::PARAM_STR, 100);
        $stmt->bindParam(':ACCOUNT_TYPE', $account_type, PDO::PARAM_STR, 100);
        $stmt->bindParam(':TRANSFER_ACCOUNT_FLAG', $transfer_account_flag, PDO::PARAM_STR, 100);
        $stmt->bindParam(':ENABLED_FLAG', $enabled_flag, PDO::PARAM_STR, 100);

        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 1);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], PDO::PARAM_STR, 4000);
        \Log::info($result);
        $stmt->execute();

        \Log::info($result['status']);
        // $rs = AccountDept::where('account_code_disp', $account_code)
        //     ->where('dept_code', $request->dept_code)
        //     ->update([
        //       'account_type' => $request->account_type,
        //       'transfer_account_flag' => $request->transfer_account_flag,
        //       'enabled_flag'  => $request->enabled_flag
        //     ]);
      DB::commit();

        return response()->json([
          "message" => "success",

        ], 200);
      } catch (\Exception $e) {
          DB::rollBack();

          return response()->json([
              'msg' => 'error',
              'error' => $e->getMessage()
          ], 403);
      }

    }

    public function store(Request $request)
    {
        $result = [];
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE 
                v_debug                 NUMBER :=0;
                v_data_rec              apps.PTCT_UPDATE_MASTER_PKG.CT04_PARAM_REC;

                P_RETURN_STATUS         varchar2(1) := NULL;
                P_RETURN_MESSAGE        varchar2(4000) := NULL;
            BEGIN
                dbms_output.put_line('------  S T A R T ------');
                
                v_data_rec  := NULL;
                
                v_data_rec.MAIN_ACCOUNT             := '{$request->acc_code}';
                v_data_rec.SUB_ACCOUNT              := '{$request->sub_acc_code}';
                v_data_rec.account_type             := '{$request->account_type}';
                v_data_rec.transfer_account_flag    := '{$request->transfer_account_flag}';
                
                v_data_rec.RETURN_STATUS            := NULL; 
                v_data_rec.RETURN_MESSAGE           := NULL;
                
                apps.PTCT_UPDATE_MASTER_PKG.WEB_CTM04( P_PARAM_DATA       => v_data_rec);
                        
                dbms_output.put_line('Output : interface_name = '||v_data_rec.INTERFACE_NAME );
                dbms_output.put_line('Output : return_status = '||v_data_rec.RETURN_status );
                dbms_output.put_line('Output : message       = '||v_data_rec.RETURN_MESSAGE );

                :P_RETURN_STATUS :=  v_data_rec.RETURN_STATUS;
                :P_RETURN_MESSAGE :=  v_data_rec.RETURN_MESSAGE;
            
                dbms_output.put_line('------  E N D ------');
                    EXCEPTION WHEN OTHERS THEN
                dbms_output.put_line('***Error-'||sqlerrm);
            END;
        ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 1);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        if ($result['status'] === "C") {
            return response()->json([
                'msg' => "success"
            ], 200);
        } else {
            return response()->json([
                'error' => $result,
                'msg' => "error"
            ], 404);
        }
    }
}
