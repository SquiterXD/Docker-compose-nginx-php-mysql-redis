<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Assets extends Model
{
    use HasFactory;

    public function callGetAssets($year,
                                  $insuranceStr,
                                  $insuranceEnd,
                                  $policyIdFrom, 
                                  $policyIdTo, 
                                  $asOfDate, 
                                  $locationCode) {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      varchar2(100)   :=  NULL;
                lv_return_msg         varchar2(4000)  :=  NULL;
            BEGIN
        
            PTIR_WEB_UTILITIES_PKG.GET_ASSET
            (
                I_USER_ID                   =>  25
            , I_YEAR                      =>  :year
            , I_INSURANCE_START_DATE      =>  to_char(to_date(:insurance_start_date, 'dd/mm/yyyy'), 'DD-MON-YYYY')     --Format 'DD-MON-YYYY'
            , I_INSURANCE_END_DATE        =>  to_char(to_date(:insurance_end_date, 'dd/mm/yyyy'), 'DD-MON-YYYY')     --Format 'DD-MON-YYYY'
            , I_POLICY_SET_HEADER_ID_FRM  =>  :policy_set_header_id_from
            , I_POLICY_SET_HEADER_ID_TO   =>  :policy_set_header_id_to
            , I_AS_OF_DATE                =>  to_char(to_date(:as_of_date, 'dd/mm/yyyy'), 'DD-MON-YYYY')     --Format 'DD-MON-YYYY'
            , I_ASSET_GROUP               =>  :asset_group
            , I_ACTIVE_FLAG               =>  'Y'
            , O_RETURN_STATUS             =>  :lv_return_status
            , O_RETURN_MSG                =>  :lv_return_msg
            );
            
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);

            commit;

        END;
    
        ";
        $result = [];
        // $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':insurance_start_date', $insuranceStr, \PDO::PARAM_STR);
        $stmt->bindParam(':insurance_end_date', $insuranceEnd, \PDO::PARAM_STR);
        $stmt->bindParam(':policy_set_header_id_from', $policyIdFrom, \PDO::PARAM_STR);
        $stmt->bindParam(':policy_set_header_id_to', $policyIdTo, \PDO::PARAM_STR);
        $stmt->bindParam(':as_of_date', $asOfDate, \PDO::PARAM_STR);
        $stmt->bindParam(':asset_group', $locationCode, \PDO::PARAM_STR);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info(" ----- callGetAssets ----- ");
        \Log::info($result['status']);
        \Log::info($result['msg']);
        \Log::info(" ----- callGetAssets ----- ");
        return $result;
    }

    public function callGetAssetsAdjustment($year,
                                            $policyIdFrom,
                                            $policyIdTo,
                                            $calculateStr, 
                                            $calculateEnd, 
                                            $adjustStr, 
                                            $adjustEnd, 
                                            $locationCode) 
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE
            lv_return_status      varchar2(100)   :=  NULL;
            lv_return_msg         varchar2(4000)  :=  NULL;
        BEGIN
        
            PTIR_WEB_UTILITIES_PKG.GET_ASSET_ADJUSTMENT
            (
            I_USER_ID                     =>  25
            , I_YEAR                      =>  :year
            , I_POLICY_SET_HEADER_ID_FRM  =>  :policy_set_header_id_from
            , I_POLICY_SET_HEADER_ID_TO   =>  :policy_set_header_id_to
            , I_CALCULATE_START_DATE      =>  to_char(to_date(:calculate_start_date, 'dd/mm/yyyy'), 'DD-MON-YYYY')    --Format 'DD-MON-YYYY'
            , I_CALCULATE_END_DATE        =>  to_char(to_date(:calculate_end_date, 'dd/mm/yyyy'), 'DD-MON-YYYY')    --Format 'DD-MON-YYYY'
            , I_ADJUSTMENT_START_DATE     =>  to_char(to_date(:adjustment_start_date, 'dd/mm/yyyy'), 'DD-MON-YYYY')    --Format 'DD-MON-YYYY'
            , I_ADJUSTMENT_END_DATE       =>  to_char(to_date(:adjustment_end_date, 'dd/mm/yyyy'), 'DD-MON-YYYY')    --Format 'DD-MON-YYYY'
            , I_ASSET_GROUP               =>  :asset_group
            , I_ACTIVE_FLAG               =>  'Y'
            , O_RETURN_STATUS             =>  :lv_return_status
            , O_RETURN_MSG                =>  :lv_return_msg
            );    
            
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);

            commit;
            
        END;
        ";
        $result = [];
        // $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':policy_set_header_id_from', $policyIdFrom, \PDO::PARAM_STR);
        $stmt->bindParam(':policy_set_header_id_to', $policyIdTo, \PDO::PARAM_STR);
        $stmt->bindParam(':calculate_start_date', $calculateStr, \PDO::PARAM_STR);
        $stmt->bindParam(':calculate_end_date', $calculateEnd, \PDO::PARAM_STR);
        $stmt->bindParam(':adjustment_start_date', $adjustStr, \PDO::PARAM_STR);
        $stmt->bindParam(':adjustment_end_date', $adjustEnd, \PDO::PARAM_STR);
        $stmt->bindParam(':asset_group', $locationCode, \PDO::PARAM_STR);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function callCheckDupAssets($year,
                                  $insuranceStr,
                                  $insuranceEnd,
                                  $policyIdFrom, 
                                  $policyIdTo, 
                                  $asOfDate, 
                                  $locationCode) {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      varchar2(100)   :=  NULL;
                lv_return_msg         varchar2(4000)  :=  NULL;
            BEGIN
        
            PTIR_WEB_UTILITIES_PKG.GET_ASSET_CHECK_DUP
            (
                I_USER_ID                   =>  25
            , I_YEAR                      =>  :year
            , I_INSURANCE_START_DATE      =>  to_char(to_date(:insurance_start_date, 'dd/mm/yyyy'), 'DD-MON-YYYY')     --Format 'DD-MON-YYYY'
            , I_INSURANCE_END_DATE        =>  to_char(to_date(:insurance_end_date, 'dd/mm/yyyy'), 'DD-MON-YYYY')     --Format 'DD-MON-YYYY'
            , I_POLICY_SET_HEADER_ID_FRM  =>  :policy_set_header_id_from
            , I_POLICY_SET_HEADER_ID_TO   =>  :policy_set_header_id_to
            , I_AS_OF_DATE                =>  to_char(to_date(:as_of_date, 'dd/mm/yyyy'), 'DD-MON-YYYY')     --Format 'DD-MON-YYYY'
            , I_ASSET_GROUP               =>  :asset_group
            , I_ACTIVE_FLAG               =>  'Y'
            , O_RETURN_STATUS             =>  :lv_return_status
            , O_RETURN_MSG                =>  :lv_return_msg
            );
            
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);

            commit;

        END;
    
        ";
        $result = [];
        // $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':insurance_start_date', $insuranceStr, \PDO::PARAM_STR);
        $stmt->bindParam(':insurance_end_date', $insuranceEnd, \PDO::PARAM_STR);
        $stmt->bindParam(':policy_set_header_id_from', $policyIdFrom, \PDO::PARAM_STR);
        $stmt->bindParam(':policy_set_header_id_to', $policyIdTo, \PDO::PARAM_STR);
        $stmt->bindParam(':as_of_date', $asOfDate, \PDO::PARAM_STR);
        $stmt->bindParam(':asset_group', $locationCode, \PDO::PARAM_STR);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info(" ----- callGetAssets ----- ");
        \Log::info($result['status']);
        \Log::info($result['msg']);
        \Log::info(" ----- callGetAssets ----- ");
        return $result;
    }
}
