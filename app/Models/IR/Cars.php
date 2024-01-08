<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cars extends Model
{
    use HasFactory;

    public function callGetCars(
        $year,
        $renewType,
        $groupCode,
        $licensePlate,
        $deptFrom,
        $deptTo,
        $dateFrom = null,
        $dateTo = null
    ) {
        $tyear = $year;
        $pyear = $year-543;
        $pDateFrom = null;
        $pDateTo = null;

        if ($dateFrom) {
            //----date-from-----
            list($day, $month, $year) = explode('/', $dateFrom);
            $year = $year - 543;
            $date = new \DateTime("$year-$month-$day");
            $dateFrom = $date->format('d-M-Y');
            $pDateFrom = $date->format('Y-m-d');
        } else {
            $dateFrom = null;
        }
        if ($dateTo) {
            //----date-to-----
            list($day, $month, $year) = explode('/', $dateTo);
            $year = $year - 543;
            $date = new \DateTime("$year-$month-$day");
            $dateTo = $date->format('d-M-Y');
            $pDateTo = $date->format('Y-m-d');
        } else {
            $dateTo = null;
        }

        $remove_new_cars = PtirCars::where(function ($q){
            return $q->where('status', 'NEW')
            ->whereNull('document_number');
        })
        ->when(!!$pyear, function($q) use($pyear){
            return $q->where('year', $pyear);
        })
        ->when(!!$renewType, function($q) use($renewType){
            return $q->where('renew_type', $renewType);
        })
        ->when(!!$groupCode, function($q) use($groupCode){
            return $q->where('group_code', $groupCode);
        })
        ->when(!!$licensePlate, function($q) use($licensePlate){
            return $q->where('license_plate', $licensePlate);
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
        ->when(!!$pDateFrom || !!$pDateTo, function($q) use($pDateFrom, $pDateTo){
            if($pDateFrom && $pDateTo){
                return $q->whereDate('end_date', '>=', $pDateFrom)
                ->whereDate('end_date', '<=', $pDateTo);
            }else if($pDateFrom){
                return $q->whereDate('end_date', '>=', $pDateFrom);
            }else if($pDateTo){
                return $q->whereDate('end_date', '<=', $pDateTo);
            }else {
                return $q;
            }
        })
        ->delete();

        // dd('---test---', $dateFrom, $dateTo);
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      varchar2(100)   :=  NULL;
                lv_return_msg         varchar2(4000)  :=  NULL;
            BEGIN

            PTIR_WEB_UTILITIES_PKG.GET_CAR
            (
                 I_USER_ID                   =>  25
                , I_YEAR                      => to_number(:year)-543
                , I_RENEW_TYPE_CODE           => :renew_type_code
                , I_GROUP_CODE                => :group_code
                , I_LICENSE_PLATE             => :license_plate
                , I_DEPT_CODE_FROM            => :dept_code_from
                , I_DEPT_CODE_TO              => :dept_code_to
                , I_ACTIVE_FLAG               =>  'Y'
                , I_INSURANCE_EXPIRE_DATE_FR =>  :date_from
                , I_INSURANCE_EXPIRE_DATE_TO =>  :daet_to
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
        $stmt->bindParam(':year', $tyear, \PDO::PARAM_STR);
        $stmt->bindParam(':renew_type_code', $renewType, \PDO::PARAM_STR);
        $stmt->bindParam(':group_code', $groupCode, \PDO::PARAM_STR);
        $stmt->bindParam(':license_plate', $licensePlate, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_from', $deptFrom, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_to', $deptTo, \PDO::PARAM_STR);

        $stmt->bindParam(':date_from', $dateFrom, \PDO::PARAM_STR);
        $stmt->bindParam(':daet_to', $dateTo, \PDO::PARAM_STR);

        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        return $result;
    }
}
