<?php

namespace App\Models\Planning\OverTimesPlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTMain extends Model
{
    use HasFactory;
    protected $table = "PTPP_OVERTIME_MAIN";
    public $primaryKey = 'ot_main_id';
    public $timestamps = false;

    public function ppBiWeekly()
    {
        return $this->hasOne(\App\Models\Planning\BiWeeklyV::class, 'biweekly_id', 'biweekly_id');
    }

    public function callPackageCreateOTPlan($otMain)
    {
        $userId = auth()->user()->fnd_user_id;
        $db = \DB::connection('oracle')->getPdo();
        $sql = "DECLARE
                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(1000) := NULL;

                    BEGIN
                        dbms_output.put_line (' ---------------- S T A R T .-----------------');
                        PTPP_OVERTIME_PLAN_PKG.CREATE_PLAN_HOLIDAY( P_OT_MAIN_ID            => {$otMain->ot_main_id}
                                                                    , P_USER_ID             => {$userId}
                                                                    , P_RETURN_STATUS       => :P_RETURN_STATUS 
                                                                    , P_RETURN_MESSAGE      => :P_RETURN_MESSAGE);
                        dbms_output.put_line (' ---------------- E N D .-----------------');
                        EXCEPTION WHEN OTHERS THEN 
                        dbms_output.put_line ('***Error-'||sqlerrm);
                    END;";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);

        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }
}
