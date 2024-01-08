<?php

namespace App\Models\Planning\OverTimesPlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPlan extends Model
{
    use HasFactory;
    protected $table = "PTPP_OVERTIME_PLAN";
    public $timestamps = false;
    protected $appends = [
        'working_date_at_format'
    ];

    public function getWorkingDateAtFormatAttribute()
    {
        return parseToDateTh($this->working_date);
    }

    public function callPackageUpdateOTPlan($otMain, $param)
    {
        $userId = auth()->user()->fnd_user_id;
        foreach ($param['workingHour'] as $index => $workingHour) {
            $values = explode('|', $index);
            $biWeekly = $values[0];
            $department = $values[1];
            $date = date('d/m/Y', strtotime($values[2]));

            $db = \DB::connection('oracle')->getPdo();
            $sql = "DECLARE
                        P_RETURN_STATUS         varchar2(1) := NULL;
                        P_RETURN_MESSAGE        varchar2(4000) := NULL;
                        v_upd_holiday           PTPP_OVERTIME_PLAN_PKG.WEB_UPDATE_HOLIDAY_REC;

                        BEGIN
                            v_upd_holiday                   := NULL;
                            v_upd_holiday.OT_MAIN_ID        := {$otMain->ot_main_id};
                            v_upd_holiday.DIVISION_CODE     := '{$department}';
                            v_upd_holiday.working_date      := to_date('{$date}','DD/MM/YYYY');
                            v_upd_holiday.working_hour      := {$workingHour};
                            v_upd_holiday.USER_ID           := {$userId};

                            PTPP_OVERTIME_PLAN_PKG.UPDATE_HOLIDAY(P_UPD_HOL_REC         => v_upd_holiday
                                                                , P_RETURN_STATUS       => :P_RETURN_STATUS
                                                                , P_RETURN_MESSAGE      => :P_RETURN_MESSAGE);
                        END; ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            logger($sql);

            $result = [];
            $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
            $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
            $stmt->execute();
        }

        return $result;
    }
}
