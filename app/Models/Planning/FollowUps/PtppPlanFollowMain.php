<?php

namespace App\Models\Planning\FollowUps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

use App\Models\Planning\ProductBiweeklyMainV;

class PtppPlanFollowMain extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "PTPP_PLAN_FOLLOW_MAIN";
    public $primaryKey = 'follow_main_id';

    public function products()
    {
        return $this->hasMany(ProductBiweeklyMainV::class, 'biweekly_id', 'biweekly_id');
    }

    public function followPackage($follow, $asOfDate)
    {
        // $date = date('d/m/Y');
        // $date = $header->as_of_date->format('d/m/Y');

        $products = $follow->products;
        if (!$products) {
            $header = ProductBiweeklyMainV::find($products->first()->product_main_id);
        } else {
            $header = ProductBiweeklyMainV::isApproved()
                        ->where('biweekly_id', $follow->biweekly_id)
                        ->orderBy('product_main_id', 'desc')
                        ->first();
        }

        $productMain = $header->product_main_id ?? 0;
        $approvedStatus = $header->approved_status ?? 'Approved';

        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                P_RETURN_STATUS         varchar2(1) := NULL;
                P_RETURN_MESSAGE        varchar2(1000) := NULL;

                P_BIWEEKLY_ID           NUMBER :=0;
                P_PRODUCT_MAIN_ID       NUMBER :=0;

                FOUND_DATA              EXCEPTION;
                v_debug                 NUMBER :=0;
                v_msg                   varchar2(500) := NULL;

                v_main_info             PTPP_PLAN_FOLLOW_MAIN%ROWTYPE;
                P_PARAM                 PTPP_PLAN_FOLLOW_PKG.WEB_PARAMETERS ;

            BEGIN
                dbms_output.put_line (v_debug||' ---------------- S T A R T -TEST.-----------------');
                P_BIWEEKLY_ID         := {$follow->biweekly_id} ;        --<<<<<<< »Ñ¡Éì4
                P_PRODUCT_MAIN_ID     := {$productMain};


                BEGIN
                        SELECT MAX(M.PRODUCT_MAIN_ID)
                            INTO P_PRODUCT_MAIN_ID
                        FROM PTPP_PRODUCT_BIWEEKLY_MAIN M
                        WHERE 1=1
                          AND M.approved_status   = '{$approvedStatus}'
                          AND M.BIWEEKLY_ID       = P_BIWEEKLY_ID  ;       --<<<<<<<<<<<<,  »Ñ¡Éì4
                END;

                --------------------------------------------------------
                ----- Paramters :
                P_PARAM.FOLLOW_MAIN_ID      := {$follow->follow_main_id}               ;--  NUMBER   --***Require
                P_PARAM.BIWEEKLY_ID         := P_BIWEEKLY_ID      ;--  NUMBER   --***Require          -- Current only  3
                P_PARAM.PRODUCT_MAIN_ID     := P_PRODUCT_MAIN_ID  ;--  NUMBER   --***Require          -- ã¹»Ñ¡ÉìÊÃéÒ§   4
                P_PARAM.AS_OF_DATE          := TO_DATE('{$asOfDate}','YYYY-MM-DD')   ;--  DATE     --***Require
                P_PARAM.USER_ID             := {$follow->created_by}               ;--  NUMBER
                --------------------------------------------------------
                BEGIN
                    SELECT *
                        INTO  v_main_info
                    FROM PTPP_PLAN_FOLLOW_MAIN
                    WHERE 1=1
                        AND FOLLOW_MAIN_ID = P_PARAM.FOLLOW_MAIN_ID ;



                    exception WHEN no_data_found THEN
                            RAISE FOUND_DATA ;
                END;

                --------------------------------------------------------
                ------ Call Package :
                PTPP_PLAN_FOLLOW_PKG.MAIN( P_FOLLOW_REC             => P_PARAM
                                          , P_RETURN_STATUS     => :P_RETURN_STATUS
                                          , P_RETURN_MESSAGE    => :P_RETURN_MESSAGE  );


                dbms_output.put_line ('--------------------------------------------------------');
                dbms_output.put_line ('WEB STATUS : '|| P_RETURN_STATUS );
                dbms_output.put_line ('WEB MSG    : '|| P_RETURN_MESSAGE);
                dbms_output.put_line (v_debug||' ---------------- E N D .-----------------');
            EXCEPTION WHEN FOUND_DATA  THEN
                dbms_output.put_line (v_debug||' Script :Not Found data on MAIN');
                    WHEN OTHERS THEN
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
