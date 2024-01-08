<?php

namespace App\Models\Planning\OverTimesPlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Planning\OverTimesPlan\OTPlanBiWeeklyV;

class OTPlanBiWeekly extends Model
{
    use HasFactory;
    protected $table = "PTPP_OVERTIME_BIWEEKLY";

    public function callPackageCreateOTPlanBiWeekly($otMain, $param)
    {
        $userId = auth()->user()->fnd_user_id;
        $db = \DB::connection('oracle')->getPdo();
        $sql = "DECLARE
                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(1000) := NULL;
                    P_OT_MAIN_ID            NUMBER := 0;

                    BEGIN
                        dbms_output.put_line (' ---------------- S T A R T .-----------------');
                        P_OT_MAIN_ID := {$otMain->ot_main_id};
                            PTPP_OVERTIME_PLAN_PKG.CREATE_OVERTIME(P_OT_MAIN_ID         => P_OT_MAIN_ID
                                                                , P_USER_ID             => {$userId}
                                                                , P_RETURN_STATUS       => :P_RETURN_STATUS
                                                                , P_RETURN_MESSAGE      => :P_RETURN_MESSAGE);

                        dbms_output.put_line (' ---------------- E N D .-----------------');
                        EXCEPTION WHEN OTHERS THEN 
                        dbms_output.put_line ('***Error-'||sqlerrm);
                    END; ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);

        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public function callPackageUpdateOTPercent($param)
    {
        $userId = auth()->user()->fnd_user_id;
        $result = ['status' => 'S'];
        foreach ($param['otPercent'] as $index => $otPercent) {
            $explode = explode('|', $index);
            $time = $explode[0];
            $dept = $explode[1];
            $employee_type= $explode[2];
            $otPlan = OTPlanBiWeeklyV::where('working_hour_desc', $time)
                                            ->where('department_code', $dept)
                                            ->where('employee_type', $employee_type)
                                            ->first();

            $db = \DB::connection('oracle')->getPdo();
            $sql = "DECLARE
                        P_RETURN_STATUS         varchar2(1) := NULL;
                        P_RETURN_MESSAGE        varchar2(1000) := NULL;
                        v_update_rec            PTPP_OVERTIME_PLAN_PKG.WEB_UPDATE_OVERTIME_REC;

                        BEGIN
                            dbms_output.put_line (' ---------------- S T A R T .-----------------');
                            v_update_rec                    := NULL;
                            v_update_rec.OT_PLAN_ID         := {$otPlan->ot_plan_id};
                            v_update_rec.UPD_OT_PERCENT     := {$otPercent};
                            v_update_rec.USER_ID            := {$userId};

                            PTPP_OVERTIME_PLAN_PKG.UPDATE_OVERTIME(P_UPD_OT_REC       => v_update_rec
                                                                , P_RETURN_STATUS     => :P_RETURN_STATUS
                                                                , P_RETURN_MESSAGE    => :P_RETURN_MESSAGE);

                            dbms_output.put_line (' ---------------- E N D .-----------------');
                            EXCEPTION WHEN OTHERS THEN 
                            dbms_output.put_line ('***Error-'||sqlerrm);
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
