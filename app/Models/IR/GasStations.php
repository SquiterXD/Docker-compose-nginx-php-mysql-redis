<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GasStations extends Model
{
    use HasFactory;
    public function callGetGasStation($year, 
                                      $gasStationType,
                                      $groupCode,
                                      $deptFrom,
                                      $deptTo) 
    {
        $pyear = $year-543;

        $remove_new_gas_stations = PtirExtendGasStations::where(function ($q){
            return $q->where('status', 'NEW')
            ->whereNull('document_number');
        })
        ->when(!!$pyear, function($q) use($pyear){
            return $q->where('year', $pyear);
        })
        ->when(!!$gasStationType, function($q) use($gasStationType){
            return $q->where('type_code', $gasStationType);
        })
        ->when(!!$groupCode, function($q) use($groupCode){
            return $q->where('group_code', $groupCode);
        })
        ->when(!!$deptFrom || !!$deptTo, function($q) use($deptFrom, $deptTo){
            if($deptFrom && $deptTo){
                return $q->where('department_code', '>=', $deptFrom)
                ->where('department_code', '<=', $deptTo);
            }else if($deptFrom){
                return $q->where('department_code', '>=', $deptFrom);
            }else if($deptTo){
                return $q->where('department_code', '<=', $deptTo);
            }else {
                return $q;
            }
        })
        ->delete();

        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      varchar2(100)   :=  NULL;
                lv_return_msg         varchar2(4000)  :=  NULL;
            BEGIN
    
            PTIR_WEB_UTILITIES_PKG.GET_GAS_STATION
            (
                I_USER_ID                   =>  25
              , I_YEAR                      =>  to_number(:year)-543
              , I_GAS_STATION_TYPE          =>  :gas_station_type       
              , I_GROUP_CODE                =>  :group_code    
              , I_DEPT_CODE_FROM            =>  :dept_code_from       
              , I_DEPT_CODE_TO              =>  :dept_code_to        
              , O_RETURN_STATUS             =>  :lv_return_status
              , O_RETURN_MSG                =>  :lv_return_msg
            );
        
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);

            commit;

            END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':gas_station_type', $gasStationType, \PDO::PARAM_STR);
        $stmt->bindParam(':group_code', $groupCode, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_from', $deptFrom, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_to', $deptTo, \PDO::PARAM_STR);

        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        return $result;
    }
}