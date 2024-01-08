<?php

namespace App\Models\Planning\ProductionYearly;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductYearlyMain extends Model
{
    use HasFactory;
    protected $table = "PTPP_PRODUCT_YEARLY_MAIN";
    protected $dates = ['as_of_date', 'creation_date'];
    public $primaryKey = 'yearly_main_id';
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

    public function omBiWeekly()
    {
        return $this->hasOne(\App\Models\Planning\BiweeklyPeriod::class, 'biweekly_id', 'ref_om_biweekly_id');
    }

    public function firstSalesForecast()
    {
        return $this->hasOne(\App\Models\Planning\OMSalesForecast::class, 'budget_year', 'ref_om_budget_year')
                        ->orderBy('creation_date', 'desc')
                        ->where('approve_flag', 'Y');
    }

    public function plans()
    {
        return $this->hasMany(\App\Models\Planning\ProductionYearly\ProductYearlyPlan::class, 'yearly_main_id', 'yearly_main_id');
    }

    public function tab1()
    {
        return $this->hasMany(
            \App\Models\Planning\ProductionYearly\ProductYearlyTab1::class, 'yearly_main_id', 'yearly_main_id'
        );
    }

    // public function machine()
    // {
    //     return $this->hasMany(ProductionPlanMachine::class, 'product_plan_id', 'product_plan_id');
    // }

    // public function dailyBiWeekly()
    // {
    //     return $this->hasOne(\App\Models\Planning\ProductionDaily\ProductionDailyPlan::class, 'biweekly_id', 'machine_biweekly_id');
    // }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by_id');
    }

    // public function scopeByBiweely($q)
    // {
    //     return $q->where('main_type', 'BIWEEKLY');
    // }

    // public function scopeisAdjustment($q)
    // {
    //     return $q->where('main_type', 'ADJUSTMENT');
    // }

    public function scopeIsApproved($q)
    {
        return $q->where('approved_status', 'Approved');
    }

    public function scopeSearch($q, $param)
    {
        if ($param) {
            return $q->where('budget_year', $param['budget_year']);
        }
        return $q;
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
        return view('planning.production-yearly._lable_status', ['status' => trim($this->approved_status)])->render();
    }


    public function getFindWithData($yearlyMainId)
    {
        return (new self)->with(['firstSalesForecast', 'omBiWeekly', 'tab1', 'createdBy', 'updatedBy'])->find($yearlyMainId);
    }

    public function maxVersion()
    {
        $data = self::where('budget_year', $this->budget_year)
                    ->where('ref_om_org_id', $this->ref_om_org_id)
                    ->where('ref_om_budget_year', $this->ref_om_budget_year)
                    ->get();

        $maxVersion = optional($data)->max('version_no') ?? 0;
        $maxVersion = ($maxVersion < 0)? 0 : $maxVersion;
        $maxVersion = $maxVersion + 1;
        return $maxVersion;
    }

    public function getNextYearlyMainSeq()
    {
        $nextPlanSeq = \DB::select("select oapp.ptpp_product_yearly_main_s.nextval from dual");
        return ['yearly_main_id' => $nextPlanSeq[0]];
    }

    public function callPackage($header)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "
                DECLARE
                P_RETURN_STATUS     varchar2(1) := NULL;
                P_RETURN_MESSAGE    varchar2(4000) := NULL;
                P_YEARLY_MAIN_ID    NUMBER :=0;

                v_debug             NUMBER :=0;
                v_msg               varchar2(500) := NULL;

                P_MAIN_REC          PTPP_YEARLY_PLAN_PKG.WEB_PARAMETERS ;
                v_main_info         PTPP_PRODUCT_YEARLY_MAIN%ROWTYPE;
                BEGIN
                    dbms_output.put_line (v_debug||' ---------------- S T A R T - PLAN.-----------------');
                    P_YEARLY_MAIN_ID                    := {$header->yearly_main_id};
                    --------------------------------------------------------
                    BEGIN
                        SELECT *
                            INTO  v_main_info
                        FROM PTPP_PRODUCT_YEARLY_MAIN
                        WHERE 1=1
                        AND YEARLY_MAIN_ID = P_YEARLY_MAIN_ID;
                    END;
                    --------------------------------------------------------
                    P_MAIN_REC.YEARLY_MAIN_ID := v_main_info.YEARLY_MAIN_ID;
                    --------------------------------------------------------
                    --- 0.MAIN is all
                        PTPP_YEARLY_PLAN_PKG.MAIN( P_MAIN_REC     => P_MAIN_REC
                                            , P_RETURN_STATUS     => :P_RETURN_STATUS
                                            , P_RETURN_MESSAGE    => :P_RETURN_MESSAGE); 

                   dbms_output.put_line('--------------------------------------------------------');
                   dbms_output.put_line ('WEB STATUS : '|| :P_RETURN_STATUS );
                   dbms_output.put_line ('WEB MSG    : '|| :P_RETURN_MESSAGE);
                   dbms_output.put_line (v_debug||' ---------------- E N D .-----------------');
                EXCEPTION WHEN OTHERS THEN 
                    dbms_output.put_line (v_debug||'***Error-'||sqlerrm);
                END;
        ";

        logger($sql);
        // $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    // Update 2 Case
    // 1 Begin Onhand Quantity
    public function callUpdateBeginOnhandQtyPackage($yearlyMainId, $plan, $itemTab22, $data, $profile, $periods)
    {
        foreach ($periods as $key => $period) {
            $db = \DB::connection('oracle')->getPdo();
            $sql = "
                    DECLARE
                    P_RETURN_STATUS     varchar2(1) := NULL;
                    P_RETURN_MESSAGE    varchar2(4000) := NULL;
                    P_YEARLY_MAIN_ID    NUMBER :=0;

                    v_debug             NUMBER :=0;
                    v_msg               varchar2(500) := NULL;

                    v_main_info         PTPP_PRODUCT_YEARLY_MAIN%ROWTYPE;
                    P_UPD_REC           PTPP_YEARLY_PLAN_PKG.WEB_UPDATE_DATA_REC;

                    BEGIN
                        dbms_output.put_line (v_debug||' --- S T A R T - PLAN.---');
                        P_YEARLY_MAIN_ID    := {$yearlyMainId};
                        BEGIN
                            SELECT *
                                INTO  v_main_info
                            FROM PTPP_PRODUCT_YEARLY_MAIN
                            WHERE 1=1
                            AND YEARLY_MAIN_ID = P_YEARLY_MAIN_ID;
                        END;

                        P_UPD_REC.YEARLY_MAIN_ID    := v_main_info.YEARLY_MAIN_ID;
                        P_UPD_REC.YEARLY_PLAN_ID    := {$plan->yearly_plan_id};
                        P_UPD_REC.PERIOD_NAME       := '{$period->period_name}';
                        P_UPD_REC.ITEM_ID           := {$itemTab22->item_id};

                        P_UPD_REC.BEGIN_ONHAND_QTY   := $data;  -- P2-T2-B8 คาดการณ์คงคลัง(ล้านมวน)
                        P_UPD_REC.PLANNING_QTY       := '';     -- P2-T2-B10 ประมาณการผลิต (ล้านมวน)

                        PTPP_YEARLY_PLAN_PKG.UPDATE_DATA ( P_UPD_DATA_REC  => P_UPD_REC 
                                                    , P_USER_ID            => {$profile->fnd_user_id}
                                                    , P_RETURN_STATUS      => :P_RETURN_STATUS 
                                                    , P_RETURN_MESSAGE     => :P_RETURN_MESSAGE
                                                ); 

                       dbms_output.put_line('-------------------------');
                       dbms_output.put_line ('WEB STATUS : '|| :P_RETURN_STATUS );
                       dbms_output.put_line ('WEB MSG    : '|| :P_RETURN_MESSAGE);  
                       dbms_output.put_line (v_debug||' --- E N D .---');
                    EXCEPTION WHEN OTHERS THEN 
                        dbms_output.put_line (v_debug||'***Error-'||sqlerrm);
                    END;
            ";

            logger($sql);
            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
            $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
            $stmt->execute();
        }

        return $result;
    }

    // 2 Total Quantity
    public function callUpdateTotalQtyPackage($yearlyMainId, $plan, $itemTab22, $period, $data, $profile)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "
                DECLARE
                    P_RETURN_STATUS     varchar2(1) := NULL;
                    P_RETURN_MESSAGE    varchar2(4000) := NULL;
                    P_YEARLY_MAIN_ID    NUMBER :=0;

                    v_debug             NUMBER :=0;
                    v_msg               varchar2(500) := NULL;

                    v_main_info         PTPP_PRODUCT_YEARLY_MAIN%ROWTYPE;
                    P_UPD_REC           PTPP_YEARLY_PLAN_PKG.WEB_UPDATE_DATA_REC;

                    BEGIN
                        dbms_output.put_line (v_debug||' --- S T A R T - PLAN.---');
                        P_YEARLY_MAIN_ID    := {$yearlyMainId};
                        BEGIN
                            SELECT *
                                INTO  v_main_info
                            FROM PTPP_PRODUCT_YEARLY_MAIN
                            WHERE 1=1
                            AND YEARLY_MAIN_ID = P_YEARLY_MAIN_ID;
                        END;

                        P_UPD_REC.YEARLY_MAIN_ID    := v_main_info.YEARLY_MAIN_ID;
                        P_UPD_REC.YEARLY_PLAN_ID    := {$plan->yearly_plan_id};
                        P_UPD_REC.PERIOD_NAME       := '{$period->period_name}';
                        P_UPD_REC.ITEM_ID           := {$itemTab22->item_id};

                        P_UPD_REC.BEGIN_ONHAND_QTY   := '';       -- P2-T2-B8 คาดการณ์คงคลัง(ล้านมวน)
                        P_UPD_REC.PLANNING_QTY       := {$data};  -- P2-T2-B10 ประมาณการผลิต (ล้านมวน)

                        PTPP_YEARLY_PLAN_PKG.UPDATE_DATA ( P_UPD_DATA_REC  => P_UPD_REC 
                                                    , P_USER_ID            => {$profile->fnd_user_id}
                                                    , P_RETURN_STATUS      => :P_RETURN_STATUS 
                                                    , P_RETURN_MESSAGE     => :P_RETURN_MESSAGE
                                                ); 

                       dbms_output.put_line('-------------------------');
                       dbms_output.put_line ('WEB STATUS : '|| :P_RETURN_STATUS );
                       dbms_output.put_line ('WEB MSG    : '|| :P_RETURN_MESSAGE);  
                       dbms_output.put_line (v_debug||' --- E N D .---');
                    EXCEPTION WHEN OTHERS THEN 
                        dbms_output.put_line (v_debug||'***Error-'||sqlerrm);
                    END;
            ";

        logger($sql);
        // $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }
}
