<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctYearControl extends Model
{
    use HasFactory;

    protected $table = 'PTCT_YEAR_CONTROL';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('period_year', $this->getAttribute('period_year'))
            ->where('prdgrp_year_id', $this->getAttribute('prdgrp_year_id'))
            ->where('cost_code', $this->getAttribute('cost_code'))
            ->where('plan_version_no', $this->getAttribute('plan_version_no'))
            ->where('version_no', $this->getAttribute('version_no'));

        return $query;
    }

    public function costCenter()
	{
		return $this->belongsTo(PtctCostCenterV::class, 'cost_code', 'cost_code');
	}

    public static function updateApprovedStatus($periodYear, $prdgrpYearId, $allocateYearId, $ct14AllocateYearId, $costCode, $status) {

        $resResult = [
            "status"        => "C",
            "message"       => "",
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();

        // $sql = "
        // DECLARE
        //     v_status        varchar2(100);
        //     v_msg           varchar2(100);
        // BEGIN
        //     PTCT_M018_PKG.CHANGE_STATUS(P_year_main_id  => {$yearMainId}
        //                     ,p_period_year              => {$periodYear}
        //                     ,p_cost_code                => '{$costCode}'
        //                     ,p_status                   => '{$status}'
        //                     ,x_status                   => :v_status
        //                     ,x_message                  => :v_msg
        //     );

        //     dbms_output.put_line('OUTPUT :' || :v_status || ' MSG :' || :v_msg  );

        // END;
        // ";

        // $sql = preg_replace("/[\r\n]*/", "", $sql);
        // $stmt = $db->prepare($sql);

        // $stmt->bindParam(':v_status', $resResult['status'], \PDO::PARAM_STR, 100);
        // $stmt->bindParam(':v_msg', $resResult['message'], \PDO::PARAM_STR, 100);

        $sql = "
        DECLARE 
            v_debug                 NUMBER :=0;
            P_RETURN_STATUS         VARCHAR2(1) := NULL;
            P_RETURN_MESSAGE        VARCHAR2(4000) := NULL;
            P_YEAR_MAIN_ID          NUMBER :=0;
            v_main_rec              APPS.PTCT_M018_PKG.WEB_MAIN_PARAMETERS;
            O_main_rec              APPS.PTCT_M018_PKG.WEB_MAIN_PARAMETERS;
        BEGIN


            v_main_rec  := NULL;

            v_main_rec.PERIOD_YEAR          := {$periodYear};
            v_main_rec.PRDGRP_YEAR_ID       := {$prdgrpYearId};
            v_main_rec.ALLOCATE_YEAR_ID     := {$allocateYearId};
            v_main_rec.CT14_ALLOCATE_YEAR_ID := {$ct14AllocateYearId};
            v_main_rec.COST_CODE            := '{$costCode}'; 

            v_main_rec.PROGRAM_CODE         := 'CTM0018';

            v_main_rec.RETURN_STATUS        := NULL; 
            v_main_rec.RETURN_MESSAGE       := NULL;

            APPS.PTCT_M018_PKG.CHANGE_STATUS(P_MAIN_PARAM       => v_main_rec
                                            ,p_status           => '{$status}'
                                            ,x_status           => :P_RETURN_STATUS
                                            ,x_message          => :P_RETURN_MESSAGE);

        EXCEPTION WHEN OTHERS THEN
            dbms_output.put_line('***Error-'||sqlerrm);
        END;
        ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':P_RETURN_STATUS', $resResult['status'], \PDO::PARAM_STR, 1);
        $stmt->bindParam(':P_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 4000);


        $stmt->execute();

        return $resResult;

    }


    public static function updateActiveNewItem($periodYear, $prdgrpYearId, $allocateYearId, $ct14AllocateYearId, $costCode, $productInventoryItemId) {

        $resResult = [
            "status"        => "C",
            "message"       => "",
        ];
        $db     = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE 
            v_debug                 NUMBER :=0;
            P_RETURN_STATUS         VARCHAR2(1) := NULL;
            P_RETURN_MESSAGE        VARCHAR2(4000) := NULL;
            P_YEAR_MAIN_ID          NUMBER :=0;
            v_main_rec        apps.PTCT_M018_PKG.WEB_MAIN_PARAMETERS;
            O_main_rec        apps.PTCT_M018_PKG.WEB_MAIN_PARAMETERS;
        BEGIN


            v_main_rec  := NULL;

            v_main_rec.PERIOD_YEAR          := {$periodYear};
            v_main_rec.PRDGRP_YEAR_ID       := {$prdgrpYearId};
            v_main_rec.ALLOCATE_YEAR_ID     := {$allocateYearId};
            v_main_rec.CT14_ALLOCATE_YEAR_ID := {$ct14AllocateYearId};
            v_main_rec.COST_CODE            := '{$costCode}'; 

            v_main_rec.PROGRAM_CODE         := 'CTM0018';

            v_main_rec.RETURN_STATUS        := NULL; 
            v_main_rec.RETURN_MESSAGE       := NULL;

            apps.PTCT_M018_PKG.ACTIVE_NEW_ITEM(P_MAIN_PARAM     => v_main_rec
                                            ,p_product_inventory_item_id  => '{$productInventoryItemId}'
                                            ,x_status           => :P_RETURN_STATUS
                                            ,x_message          => :P_RETURN_MESSAGE);


            dbms_output.put_line(:P_RETURN_MESSAGE);
            dbms_output.put_line(:P_RETURN_STATUS);

        EXCEPTION WHEN OTHERS THEN
            dbms_output.put_line('***Error-'||sqlerrm);
        END;
        ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':P_RETURN_STATUS', $resResult['status'], \PDO::PARAM_STR, 1);
        $stmt->bindParam(':P_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 4000);


        $stmt->execute();

        return $resResult;

    }

}
