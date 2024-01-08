<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ProductBiweeklyMain extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "PTPP_PRODUCT_BIWEEKLY_MAIN";
    public $primaryKey = 'product_main_id';
    // protected $appends = [
    //     'created_at_format',
    //     'approved_at_format',
    //     'as_of_date_format'
    // ];

    public function ppBiWeekly()
    {
        return $this->hasOne(BiWeeklyV::class, 'biweekly_id', 'biweekly_id');
    }

    public function plans()
    {
        return $this->hasMany(\App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyPlan::class, 'product_main_id', 'product_main_id');
    }

    public function scopeByBiweely($q)
    {
        return $q->where('main_type', 'BIWEEKLY');
    }

    public function scopeisAdjustment($q)
    {
        return $q->where('main_type', 'ADJUSTMENT');
    }

    public function scopeIsApproved($q)
    {
        return $q->whereRaw("upper(approved_status) = 'APPROVED'");
    }

    // public function biWeekly()
    // {
    //     return $this->hasOne(BiWeeklyV::class, 'biweekly_id', 'biweekly_id');
    // }

    // public function machine()
    // {
    //     return $this->hasMany(ProductionPlanMachine::class, 'product_plan_id', 'product_plan_id');
    // }

    // public function user()
    // {
    //     return $this->hasOne(User::class, 'id', 'created_by_id');
    // }

    // public function scopeSearch($q, $param)
    // {
    //     if ($param) {
    //         //get biWeekly
    //         $biWeekly = BiWeeklyV::getBiWeeklyPlan($param)->get();
    //         if (count($biWeekly) > 1) {
    //             $biWeekly = $biWeekly->pluck('biweekly_id');
    //             $q->whereIn('biweekly_id', $biWeekly);
    //         }else{
    //             $biWeekly = $biWeekly->first();
    //             $q->where('biweekly_id', optional($biWeekly)->biweekly_id);
    //         }
    //         return $q;
    //     }
    //     return $q;
    // }

    // public function getCreatedAtFormatAttribute()
    // {
    //     return parseToDateTh($this->creation_date);
    // }

    // public function getApprovedAtFormatAttribute()
    // {
    //     return parseToDateTh($this->approved_date);
    // }

    // public function getAsOfDateFormatAttribute()
    // {
    //     return parseToDateTh($this->as_of_date);
    // }

    public function getNextPlanSeq()
    {
        $nextPlanSeq = \DB::select("select ptpp_product_biweekly_main_s.nextval from dual");
        return ['product_main_id' => $nextPlanSeq[0]];
    }

    public function maxVersion()
    {
        $data = self::where('biweekly_id', $this->biweekly_id)
                    ->where('ref_om_org_id', $this->ref_om_org_id)
                    ->where('ref_om_biweekly_id', $this->ref_om_biweekly_id)
                    ->get();
        // dd('aa', $data, $this->biweekly_id, $this->ref_om_org_id, $this->ref_om_biweekly_id);

        $maxVersion = optional($data)->max('version_no') ?? 0;
        $maxVersion = ($maxVersion < 0)? 0 : $maxVersion;
        $maxVersion = $maxVersion + 1;
        return $maxVersion;
    }

    public function callPackage($header)
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = " declare
                    v_header_info  PTPP_PRODUCT_BIWEEKLY_MAIN%ROWTYPE;
                    v_status       VARCHAR2(10);
                    v_err_msg      VARCHAR2(4000);
                    BEGIN
                        v_header_info.product_main_id       := {$header->product_main_id};
                        v_header_info.biweekly_id           := {$header->biweekly_id};
                        v_header_info.ref_om_biweekly_id    := {$header->ref_om_biweekly_id};
                        v_header_info.machine_biweekly_id    := {$header->machine_biweekly_id};
                        --v_header_info.product_type          := {$header->product_type};
                        v_header_info.version_no            := {$header->version_no};
                        v_header_info.approved_status       := '{$header->approved_status}';
                        v_header_info.ref_om_org_id         := {$header->ref_om_org_id};
                        --v_header_info.define_product_cigaret := '{$header->define_product_cigaret}';
                        v_header_info.program_code          := '{$header->program_code}';
                        PTPP_PLAN_PRODUCT_PKG.MAIN (p_plan_info         => v_header_info
                                                    , P_RETURN_STATUS    => :v_status
                                                    , P_RETURN_MESSAGE   => :v_err_msg
                                                );
                    END;";

        $sql = "
                DECLARE
                        P_RETURN_STATUS         varchar2(1) := NULL;
                        P_RETURN_MESSAGE        varchar2(4000) := NULL;
                        P_PRODUCT_MAIN_ID       NUMBER :=0;


                        v_debug     NUMBER :=0;
                        v_msg       varchar2(500) := NULL;


                        v_main_info     PTPP_PRODUCT_BIWEEKLY_MAIN%ROWTYPE;
                BEGIN
                  dbms_output.put_line (v_debug||' ---------------- S T A R T - TAB1.-----------------');
                  P_PRODUCT_MAIN_ID     := {$header->product_main_id} ;


                 --------------------------------------------------------
                  BEGIN
                    SELECT *
                        INTO  v_main_info
                    FROM PTPP_PRODUCT_BIWEEKLY_MAIN
                    WHERE 1=1
                       AND product_main_id = P_PRODUCT_MAIN_ID;
                  END;

                    PTPP_PLAN_PRODUCT_PKG.MAIN( P_PLAN_INFO    =>  v_main_info
                                             , P_RETURN_STATUS    => :P_RETURN_STATUS
                                             , P_RETURN_MESSAGE    => :P_RETURN_MESSAGE  );

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

    public function updatePackage($line)
    {
        $userId = auth()->user()->fnd_user_id;
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                P_RETURN_STATUS         varchar2(1) := NULL;
                P_RETURN_MESSAGE        varchar2(4000) := NULL;



                v_debug     NUMBER :=0;
                v_msg       varchar2(500) := NULL;


                v_upd_data      PTPP_PLAN_PRODUCT_PKG.WEB_UPDATE_DATA_REC;
            BEGIN
                    v_upd_data := NULL;
                    v_upd_data.PRODUCT_MAIN_ID              := {$line->product_main_id};
                    --v_upd_data.PRODUCT_PLAN_ID              := null;
                    --v_upd_data.pp_biweekly_id               := null;
                    v_upd_data.PRODUCT_PLAN_ID              := '{$line->product_plan_id}';
                    v_upd_data.BIWEEKLY_ID                  := '{$line->biweekly_id}';
                    v_upd_data.ITEM_ID                      := '{$line->item_id}';      --- case1
                    v_upd_data.ITEM_ID                      := '{$line->item_id}';      --- case1
                    v_upd_data.D1_CALCULATE_TYPE            := '{$line->d1_calculate_type}';      --- case1
                    v_upd_data.D5_CALCULATE_TYPE            := '{$line->d5_calculate_type}';        ---case2
                    v_upd_data.D12_OLD_NEXT_ONHAND_QTY      := '{$line->d12_old_next_onhand_qty}';        ---case2
                    v_upd_data.D12_NEXT_ONHAND_QTY          := '{$line->d12_next_onhand_qty}';        ---case3
                   --v_upd_data.D7_PLANNING_QTY             := null;

                    PTPP_PLAN_PRODUCT_PKG.UPDATE_DATA(P_UPD_DATA_REC             => v_upd_data
                                                            , P_USER_ID           => {$userId}
                                                            , P_RETURN_STATUS     => :P_RETURN_STATUS
                                                            , P_RETURN_MESSAGE    => :P_RETURN_MESSAGE  );
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


    public function adjustPackage($header)
    {
        $userId = auth()->user()->fnd_user_id;
        $date = date('d/m/Y');
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                P_RETURN_STATUS         varchar2(1) := NULL;
                P_RETURN_MESSAGE        varchar2(4000) := NULL;
                P_PRODUCT_MAIN_ID       NUMBER :=0;


                v_debug     NUMBER :=0;
                v_msg       varchar2(500) := NULL;


                v_main_info     PTPP_PRODUCT_BIWEEKLY_MAIN%ROWTYPE;


                P_PARAM              PTPP_ADJUSTMENT_PKG.WEB_PARAMETER_REC;
            BEGIN
              dbms_output.put_line (v_debug||' ---------------- S T A R T -TEST.-----------------');

              P_PRODUCT_MAIN_ID     := {$header->product_main_id} ;


              --------------------------------------------------------
              ----- Paramters :
                       P_PARAM.PRODUCT_MAIN_ID      := P_PRODUCT_MAIN_ID;
                       P_PARAM.ADJUST_NO            := {$header->adjust_no};
                       P_PARAM.AS_OF_DATE           := TO_DATE('{$date}','DD/MM/YYYY');
                       P_PARAM.USER_ID              := {$userId};
                       P_PARAM.BIWEEKLY_ID          := {$header->biweekly_id};
             --------------------------------------------------------
              BEGIN
                SELECT *
                    INTO  v_main_info
                FROM PTPP_PRODUCT_BIWEEKLY_MAIN
                WHERE 1=1
                    AND MAIN_TYPE           = 'BIWEEKLY'
                    AND approved_status     = '{$header->approved_status}'
                    AND product_main_id     = P_PARAM.PRODUCT_MAIN_ID
                    --AND ADJUST_NO           = P_PARAM.ADJUST_NO
                    ;
              END;

             --------------------------------------------------------
             ------ Call Package :
                PTPP_ADJUSTMENT_PKG.MAIN(P_ADJUST_REC           => P_PARAM
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
        // $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $result = [];
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public function adjUpdatePackage($line)
    {
        $userId = auth()->user()->fnd_user_id;
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                P_RETURN_STATUS         varchar2(1) := NULL;
                P_RETURN_MESSAGE        varchar2(4000) := NULL;

                v_debug     NUMBER :=0;
                v_msg       varchar2(500) := NULL;


                v_upd_data      PTPP_PLAN_PRODUCT_PKG.WEB_UPDATE_DATA_REC;
            BEGIN
                    v_upd_data := NULL;
                    v_upd_data.PRODUCT_MAIN_ID              := {$line->product_main_id};
                    v_upd_data.BIWEEKLY_ID                  := {$line->pp_biweekly_id};
                    v_upd_data.PRODUCT_PLAN_ID              := {$line->product_plan_id};

                    v_upd_data.ITEM_ID                      := {$line->item_id};      --- case1

                    v_upd_data.D7_PLANNING_QTY              := {$line->value};

                    PTPP_PLAN_PRODUCT_PKG.UPDATE_DATA(P_UPD_DATA_REC             => v_upd_data
                                                            , P_USER_ID           => {$userId}
                                                            , P_RETURN_STATUS     => :P_RETURN_STATUS
                                                            , P_RETURN_MESSAGE    => :P_RETURN_MESSAGE  );
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
