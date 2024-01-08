<?php

namespace App\Models\Planning\ProductionDaily;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProductionDailyMachine extends Model
{
    use HasFactory;
    protected $table = "ptpp_plan_daily_machine";

    public function itemDesc()
    {
        return $this->hasOne(ItemCigarette::class, 'item_code', 'item_code');
    }

    // package นี้จะทำงาน โดยจะ Insert/update Machine และ Onhand
    public function callDailyPlanUpdate($batchNo)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = " declare
                    v_status       varchar2(10);
                    v_err_msg      varchar2(4000) ;
                    begin
                        v_err_msg := NULL;
                        ptpp_plan_daily_pkg.update_plan( p_batch_no        => '{$batchNo}'
                                                        , p_return_status  => :v_status 
                                                        , p_return_message => :v_err_msg
                                                    );
                    end;
                ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger('-----Update Machine '.$batchNo);
        logger($sql);

        $result = [];
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    // Package get efficiency
    public function getEfficiencyProduct($resPlanId, $machineGroup, $startDate, $endDate)
    {
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));
        $db  = \DB::reconnect('oracle')->getPdo();
        $sql = " declare
                        v_result     varchar2(100) := null;
                    begin
                        :v_result := ptpp_plan_daily_pkg.get_mc_eff_product( p_res_plan_h_id    => {$resPlanId}
                                                                            , p_machine_group   => '{$machineGroup}'
                                                                            , p_start_date      => '{$startDate}'
                                                                            , p_end_date        => '{$endDate}'
                                                                        );
                    end;
                ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':v_result', $result['v_efficiency'], \PDO::PARAM_INT);
        $stmt->execute();

        return $result;
    }
}
