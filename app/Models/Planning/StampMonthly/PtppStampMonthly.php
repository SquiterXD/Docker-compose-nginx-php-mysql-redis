<?php

namespace App\Models\Planning\StampMonthly;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use PDO;
use Carbon\Carbon;

class PtppStampMonthly extends Model
{
    use HasFactory;
    protected $table = "ptpp_stamp_monthly";
    public $primaryKey = 'monthly_id';

    protected $appends = [
        'can',
        'created_at_format',
        'updated_at_format',
        'creation_date_format',
        'last_update_date_format',
        'approved_at_format',
        'as_of_date_format',
        'status_lable_html'
    ];

    public function ppPeriod()
    {
        return $this->hasOne(\App\Models\Planning\PtppPeriodsV::class, 'period_name', 'period_name');
    }

    public function scopeIsApproved($q)
    {
        return $q->whereRaw("upper(approved_status) = 'APPROVED'");
    }

    public function getCreatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getUpdatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getApprovedAtFormatAttribute()
    {
        return parseToDateTh($this->approved_date);
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

    public function getCanAttribute()
    {
        $can = (object)[];
        $status = trim($this->approved_status);
        switch (strtoupper($status)) {
            case 'ACTIVE':
                $can->edit = false;
                $can->approve = false;
                break;
            case 'APPROVED':
                $can->edit = false;
                $can->approve = false;
                break;
            case 'INACTIVE':
                $can->edit = true;
                $can->approve = true;
                break;
            case 'CANCEL':
                $can->edit = false;
                $can->approve = false;
                break;
            default:
                $can->edit = true;
                $can->approve = true;
                break;
        }

        return $can;
    }

    public function getStatusLableHtmlAttribute()
    {
        return view('planning.production-biweekly._lable_status', ['status' => trim($this->approved_status)])->render();
    }

    public function callCreatePackage($stampMonthly)
    {
        $userId = auth()->user()->fnd_user_id;
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                P_RETURN_STATUS         varchar2(1) := NULL;
                P_RETURN_MESSAGE        varchar2(1000) := NULL;
                P_MONTHLY_ID            NUMBER :=0;
                P_USER_ID               NUMBER :=0;
                v_debug                 NUMBER :=0;
                v_msg                   varchar2(500) := NULL;

                v_stamp_info           PTPP_STAMP_MONTHLY%ROWTYPE;
                v_web_param            PTPP_STAMP_MONTHLY_PKG.WEB_PARAMETERS ;
            BEGIN
                dbms_output.put_line (v_debug||' ---------------- S T A R T - PPP0008-STAMP.-----------------');
                P_MONTHLY_ID     := {$stampMonthly->monthly_id};
                P_USER_ID        := {$userId};

                --------------------------------------------------------
                BEGIN
                    SELECT *
                        INTO  v_stamp_info
                    FROM PTPP_STAMP_MONTHLY
                    WHERE 1=1
                       AND monthly_id = P_MONTHLY_ID;
                    END;
                --------------------------------------------------------


                v_web_param.MONTHLY_ID    := P_MONTHLY_ID;
                v_web_param.USER_ID       := P_USER_ID;


                --------------------------------------------------------
                PTPP_STAMP_MONTHLY_PKG.MAIN( P_MONTHLY_REC       => v_web_param
                                          , P_RETURN_STATUS     => :P_RETURN_STATUS
                                          , P_RETURN_MESSAGE    => :P_RETURN_MESSAGE  );

                dbms_output.put_line ('--------------------------------------------------------');
                dbms_output.put_line ('WEB STATUS : '|| P_RETURN_STATUS );
                dbms_output.put_line ('WEB MSG    : '|| P_RETURN_MESSAGE);
                dbms_output.put_line (v_debug||' ---------------- E N D .-----------------');
            EXCEPTION WHEN OTHERS THEN
              dbms_output.put_line (v_debug||'***Error-'||sqlerrm);
            END;
        ";



        logger($sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public function updatePackage($case)
    {
        $db = DB::connection('oracle')->getPdo();
        $userId = auth()->user()->fnd_user_id;
        $monthlyId = $case->monthly_id;
        $stampId = $case->stamp_id;
        $planDate = Carbon::parse($case->plan_date);
        $planDate = $planDate->format('d/m/Y');

        $weeklyReceiveQty = $case->weekly_receive_qty;
        $receiveRollQty = $case->receive_roll_qty;

        if (!$weeklyReceiveQty) {
            $weeklyReceiveQty = 0;
        }
        if (!$receiveRollQty) {
            $receiveRollQty = 0;
        }


        $sql = "
            DECLARE
                P_RETURN_STATUS         varchar2(1) := NULL;
                P_RETURN_MESSAGE        varchar2(4000) := NULL;
                v_debug         NUMBER :=0;
                v_msg           varchar2(500) := NULL;
                v_upd_data      PTPP_STAMP_MONTHLY_PKG.WEB_UPDATE_DATA_REC;
            BEGIN
              dbms_output.put_line (v_debug||' ---------------- S T A R T - CALL.-----------------');
             v_debug := 2;
             --------------------------------------------------------
             --- ** Require
                    v_upd_data := NULL;
                    v_upd_data.MONTHLY_ID               := '{$monthlyId}'  ;
                    v_upd_data.STAMP_ID                 := '{$stampId}'   ;
                    v_upd_data.PLAN_DATE                := to_date('{$planDate}','DD/MM/YYYY') ;
                    v_upd_data.USER_ID                  := {$userId}  ;

             --------------------------------------------------------
                        ---- CASE1 : P8-A7
                    v_upd_data.A7_WEEKLY_RECEIVE_QTY    := {$weeklyReceiveQty};   -- P8-A7     614400
                        ---- CASE2 : P8-A8
                    v_upd_data.A8_RECEIVE_ROLL_QTY     := {$receiveRollQty};       -- P8-A8      10.24


             --------------------------------------------------------
            v_debug := 7;
            BEGIN
                SELECT ' Found data for update...'
                     INTO v_msg
                FROM PTPP_STAMP_DAILY_V DY
                WHERE 1=1
                    AND DY.MONTHLY_ID   = v_upd_data.MONTHLY_ID
                    AND DY.STAMP_ID     = v_upd_data.STAMP_ID
                    AND DY.PLAN_DATE    = v_upd_data.PLAN_DATE ;
            END;
            dbms_output.put_line(v_debug||v_msg);
            v_debug := 9;
                    PTPP_STAMP_MONTHLY_PKG.UPDATE_DATA(P_UPD_DATA_REC              => v_upd_data
                                                            , P_RETURN_STATUS     => :P_RETURN_STATUS
                                                            , P_RETURN_MESSAGE    => :P_RETURN_MESSAGE  );


               dbms_output.put_line ('--------------------------------------------------------');
               dbms_output.put_line ('WEB STATUS : '|| P_RETURN_STATUS );
               dbms_output.put_line ('WEB MSG    : '|| P_RETURN_MESSAGE);

              dbms_output.put_line (v_debug||' ---------------- E N D .-----------------');
            EXCEPTION WHEN OTHERS THEN
              dbms_output.put_line (v_debug||'***Error-'||sqlerrm);
            END;
        ";



        logger($sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public function updateEstPackage(PtppStampMonthly $ptppStampMonthly, $stampId)
    {
        $db = DB::connection('oracle')->getPdo();
        $userId = auth()->user()->fnd_user_id;
        $monthlyId = $ptppStampMonthly->monthly_id;
        $stampId = $stampId;
        $sql = "
            DECLARE
                P_RETURN_STATUS         varchar2(1) := NULL;
                P_RETURN_MESSAGE        varchar2(4000) := NULL;
                v_debug         NUMBER :=0;
                v_msg           varchar2(500) := NULL;
                v_upd_data      PTPP_STAMP_MONTHLY_PKG.WEB_UPDATE_DATA_REC;
            BEGIN
              dbms_output.put_line (v_debug||' ---------------- S T A R T - CALL.-----------------');
             v_debug := 2;
             --------------------------------------------------------
             --- ** Require
                    v_upd_data := NULL;
                    v_upd_data.MONTHLY_ID               := '{$monthlyId}'  ;
                    v_upd_data.STAMP_ID                 := '{$stampId}'   ;
                    v_upd_data.USER_ID                  := {$userId}  ;
             --------------------------------------------------------
                    v_upd_data.UPDATE_A10_FLAG          := 'Y';
            v_debug := 9;
                    PTPP_STAMP_MONTHLY_PKG.UPDATE_DATA(P_UPD_DATA_REC              => v_upd_data
                                                            , P_RETURN_STATUS     => :P_RETURN_STATUS
                                                            , P_RETURN_MESSAGE    => :P_RETURN_MESSAGE  );


               dbms_output.put_line ('--------------------------------------------------------');
               dbms_output.put_line ('WEB STATUS : '|| P_RETURN_STATUS );
               dbms_output.put_line ('WEB MSG    : '|| P_RETURN_MESSAGE);

              dbms_output.put_line (v_debug||' ---------------- E N D .-----------------');
            EXCEPTION WHEN OTHERS THEN
              dbms_output.put_line (v_debug||'***Error-'||sqlerrm);
            END;
        ";

        logger($sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }
}
