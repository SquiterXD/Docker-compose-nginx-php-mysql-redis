<?php

namespace App\Models\Planning\StampFollow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StampFollowMain extends Model
{
    use HasFactory;
    protected $table = "ptpp_stamp_follow_main";
    public $primaryKey = 'follow_stamp_main_id';
    protected $appends = [
        'created_at_format',
        'updated_at_format',
        'creation_date_format',
        'last_update_date_format',
        'as_of_date_format',
        'current_date_format',
        'interface_pr_date_format',
    ];

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by_id');
    }

    public function ppPeriod()
    {
        return $this->hasOne(\App\Models\Planning\PtppPeriodsV::class, 'period_name', 'period_name');
    }

    public function getCreatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getUpdatedAtFormatAttribute()
    {
        return parseToDateTh($this->updated_at);
    }

    public function getAsOfDateFormatAttribute()
    {
        return parseToDateTh($this->as_of_date);
    }

    public function getLastUpdateDateFormatAttribute()
    {
        return parseToDateTh($this->last_update_date);
    }

    public function getCreationDateFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getCurrentDateFormatAttribute()
    {
        return parseToDateTh(date('d-m-Y'));
    }

    public function getInterfacePrDateFormatAttribute()
    {
        return parseToDateTh($this->interface_pr_date);
    }

    public function callCreatePackage($stampFollowMainId)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = " declare
                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(1000) := NULL;
                    P_follow_stamp_main_id  NUMBER :=0;
                    P_PERIOD_NAME           VARCHAR2(30) :=0;
                    v_debug                 NUMBER :=0;
                    v_msg                   varchar2(500) := NULL;
                    v_stamp_info            PTPP_STAMP_FOLLOW_MAIN_V%ROWTYPE;
                    v_web_param             PTPP_STAMP_FOLLOW_PKG.WEB_PARAMETERS ;

                    BEGIN
                        dbms_output.put_line (v_debug||' ---------------- START -----------------');
                        p_follow_stamp_main_id := {$stampFollowMainId};
                        BEGIN
                            select *
                                into  v_stamp_info
                            from ptpp_stamp_follow_main_v
                            where 1=1
                            and p_follow_stamp_main_id  = follow_stamp_main_id;
                        END;
                        --------------------------------------------------------
                        v_web_param.follow_stamp_main_id  := p_follow_stamp_main_id;
                        --------------------------------------------------------
                        ptpp_stamp_follow_pkg.main( p_main_rec          => v_web_param
                                                  , p_return_status     => :p_return_status 
                                                  , p_return_message    => :p_return_message );

                        dbms_output.put_line (v_debug||' ---------------- E N D .-----------------');
                    EXCEPTION WHEN OTHERS THEN 
                        dbms_output.put_line (v_debug||'***Error-'||sqlerrm);
                    END; ";

        logger($sql);
        # $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public function callUpdatePackage($stampFollowMain, $case)
    {
        $db = \DB::connection('oracle')->getPdo();
        $stampId = $case->follow_stamp_id;
        $fndUserId = $stampFollowMain->created_by;
        $followDate = Carbon::parse($case->follow_date);
        $followDate = $followDate->format('d/m/Y');


        $weeklyReceiveQty = $case->weekly_receive_qty;
        $receiveRollQty = $case->receive_roll_qty;

        if (!$weeklyReceiveQty) {
            $weeklyReceiveQty = 0;
        }
        if (!$receiveRollQty) {
            $receiveRollQty = 0;
        }

        $sql = " declare
                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(1000) := NULL;
                    v_debug                 NUMBER :=0;
                    v_msg                   varchar2(500) := NULL;
                    v_item_rec              PTPP_STAMP_FOLLOW_ITEMs_V%ROWTYPE;
                    P_UPD_DATA_REC          PTPP_STAMP_FOLLOW_PKG.WEB_UPDATE_DATA_REC;
                    BEGIN
                        dbms_output.put_line (v_debug||' ---------------- S T A R T .-----------------');
                        P_UPD_DATA_REC.FOLLOW_STAMP_ID          := {$stampId};
                        P_UPD_DATA_REC.FOLLOW_DATE              := to_date('{$followDate}','DD/MM/YYYY');
                        P_UPD_DATA_REC.USER_ID                  := {$fndUserId};
                        P_UPD_DATA_REC.UPD_WEEKLY_RECEIVE_QTY   := {$weeklyReceiveQty};   --P9-A3
                        P_UPD_DATA_REC.UPD_RECEIVE_ROLL_QTY     := {$receiveRollQty};     --P9-A4

                        BEGIN
                            SELECT *
                            into v_item_rec
                            FROM PTPP_STAMP_FOLLOW_ITEMs_V
                            WHERE 1=1
                            AND  FOLLOW_STAMP_ID = P_UPD_DATA_REC.FOLLOW_STAMP_ID ;
                        END;

                        PTPP_STAMP_FOLLOW_PKG.UPDATE_DATA (P_UPD_DATA_REC           => P_UPD_DATA_REC
                                                            , P_RETURN_STATUS       => :P_RETURN_STATUS
                                                            , P_RETURN_MESSAGE      => :P_RETURN_MESSAGE  );

                        dbms_output.put_line (v_debug||' ---------------- E N D .-----------------');
                        EXCEPTION WHEN OTHERS THEN 
                        dbms_output.put_line (v_debug||'***Error-'||sqlerrm);
                    END; ";

        logger($sql);
        $stmt = $db->prepare($sql);

        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public function callRefreshStampPackage($stampFollowMainId)
    {
        $db = \DB::connection('oracle')->getPdo();
        $fndUserId = \Auth::user()->fnd_user_id;
        $date = date('d/m/Y');

        $sql = "declare
                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(1000) := NULL;
                    P_follow_stamp_main_id  NUMBER :=0;
                    v_debug                 NUMBER :=0;
                    v_msg                   varchar2(500) := NULL;

                    BEGIN
                        dbms_output.put_line (v_debug||' ---------------- S T A R T - PPP0009:FOLLOW STAMP-REFRESH-----------------');
                        p_follow_stamp_main_id := {$stampFollowMainId};

                        ptpp_stamp_follow_pkg.WEB_REFRESH_DAILY( P_FOLLOW_STAMP_MAIN_ID => P_follow_stamp_main_id 
                                                                , P_USER_ID           => {$fndUserId}
                                                                , P_AS_OF_DATE        => to_date('{$date}','DD/MM/YYYY')
                                                                , P_RETURN_STATUS     => :P_RETURN_STATUS
                                                                , P_RETURN_MESSAGE    => :P_RETURN_MESSAGE
                                                            );

                        dbms_output.put_line ('--------------------------------------------------------');
                        dbms_output.put_line ('WEB STATUS : '|| P_RETURN_STATUS );
                        dbms_output.put_line ('WEB MSG    : '|| P_RETURN_MESSAGE);
                        dbms_output.put_line (v_debug||' ---------------- E N D .-----------------');
                    EXCEPTION WHEN OTHERS THEN
                        dbms_output.put_line (v_debug||'***Error-'||sqlerrm);
                    END;";

        logger($sql);
        $stmt = $db->prepare($sql);

        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public function callRefreshStampOnhandPackage($stampFollowMainId)
    {
        $db = \DB::connection('oracle')->getPdo();
        $fndUserId = \Auth::user()->fnd_user_id;
        $date = date('d/m/Y');

        $sql = "declare
                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(1000) := NULL;
                    P_follow_stamp_main_id  NUMBER :=0;
                    v_debug                 NUMBER :=0;
                    v_msg                   varchar2(500) := NULL;

                    BEGIN
                        dbms_output.put_line (v_debug||' ---------------- S T A R T - PPP0009:FOLLOW STAMP-REFRESH Onhand-----------------');
                        P_follow_stamp_main_id     := {$stampFollowMainId};

                        ptpp_stamp_follow_pkg.WEB_REFRESH_ONHAND( P_FOLLOW_STAMP_MAIN_ID => P_follow_stamp_main_id
                                                            , P_USER_ID           => {$fndUserId}
                                                            , P_AS_OF_DATE        => to_date('{$date}','DD/MM/YYYY')
                                                            , P_RETURN_STATUS     => :P_RETURN_STATUS
                                                            , P_RETURN_MESSAGE    => :P_RETURN_MESSAGE);

                        dbms_output.put_line ('--------------------------------------------------------');
                        dbms_output.put_line ('WEB STATUS : '|| P_RETURN_STATUS );
                        dbms_output.put_line ('WEB MSG    : '|| P_RETURN_MESSAGE);
                        dbms_output.put_line (v_debug||' ---------------- E N D .-----------------');
                    EXCEPTION WHEN OTHERS THEN 
                        dbms_output.put_line (v_debug||'***Error-'||sqlerrm);
                    END;";

        logger($sql);
        $stmt = $db->prepare($sql);

        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    // Display follow date
    public static function convertFormatDate($date)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    v_display_plan_date  varchar2(1000) := null;
                begin
                    :v_display_plan_date := pt_utilities_pkg.convert_sht_mon_to_thai_char('{$date}');
                end;
            ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);

        $stmt->bindParam(':v_display_plan_date', $result['v_display_plan_date'], \PDO::PARAM_STR, 1000);
        $stmt->execute();

        return $result;
    }

    public function insertDataBackup($mainId)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    begin
                        insert into ptpp_FOLLOW_DAILY09_TEMP (
                            SELECT ITM.follow_stamp_main_id
                                , ITM.stamp_code
                                , ITM.stamp_description
                                ,ITM.follow_stamp_id
                                , cigarettes_code
                                , cigarettes_description
                                , d.follow_date
                                , weekly_receive_qty
                                , receive_roll_qty
                                , receipt_amount
                            FROM PTPP_STAMP_FOLLOW_ITEMS    ITM
                               , PTPP_STAMP_FOLLOW_DAILY    D
                            WHERE 1=1
                            AND ITM.follow_stamp_id          = D.follow_stamp_id
                            AND ITM.FOLLOW_STAMP_MAIN_ID     = {$mainId}
                        );
                    commit;
                end;
            ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);
        $stmt->execute();

        return 'S';
    }
}
