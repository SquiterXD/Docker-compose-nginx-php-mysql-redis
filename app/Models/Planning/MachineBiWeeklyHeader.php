<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use PDO;

class MachineBiWeeklyHeader extends Model
{
    use HasFactory;
    protected $table = "ptpp_machine_biweekly_headers";
    public $primaryKey = 'res_plan_h_id';

    public function getNextSeqResPlan()
    {
        $nextSeqBatches = \DB::select("select ptpp_machine_biweekly_heads_s.nextval from dual");
        return ['seqResPlan' => $nextSeqBatches[0]];
    }

    public function callPackageCreateLineDetail($header, $programProfile)
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "declare
                    v_status         VARCHAR2(10);
                    v_err_msg        VARCHAR2(1000);
                    BEGIN
                        PTPP_PLAN_MACHINE_PKG.MAIN (p_res_plan_h_id      => {$header->res_plan_h_id}
                                                    , P_RETURN_STATUS    => :v_status
                                                    , P_RETURN_MESSAGE   => :v_err_msg
                                                );
                    END;";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);

        $result = [];
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public function callPackageUpdateData($headerId, $param)
    {
        //Convert type param
        $machine_eamperformance = $param->machine_eamperformance === null? 'NULL': (int)$param->machine_eamperformance ;
        $efficiency_product = $param->efficiency_product === null? 'NULL': (int)$param->efficiency_product ;
        // $date = date('d-m-Y', strtotime($date));
        // $res_plan_date = $date === null? 'NULL': "to_date('{$date}','DD/MM/YYYY')" ;

        $db = DB::connection('oracle')->getPdo();
        $sql = " declare
                    P_UPD_DATA_REC      PTPP_PLAN_MACHINE_PKG.WEB_UPDATE_DATA_REC;
                    v_status            VARCHAR2(10);
                    v_err_msg           VARCHAR2(1000);
                    BEGIN
                        P_UPD_DATA_REC.RES_PLAN_H_ID            := {$headerId};
                        P_UPD_DATA_REC.EFFICIENCY_PRODUCT       := {$efficiency_product}; 
                        P_UPD_DATA_REC.EFFICIENCY_MACHINE       := {$machine_eamperformance};
                        P_UPD_DATA_REC.RES_PLAN_DATE            := NULL;
                        P_UPD_DATA_REC.WORKING_HOUR             := NULL;
                        P_UPD_DATA_REC.MACHINE_NAME             := NULL;
                        P_UPD_DATA_REC.MACHINE_EAMPERFORMANCE   := NULL;
                        PTPP_PLAN_MACHINE_PKG.UPDATE_DATA (P_UPD_DATA_REC   => P_UPD_DATA_REC
                                                    , P_RETURN_STATUS       => :v_status
                                                    , P_RETURN_MESSAGE      => :v_err_msg
                                                );
                    END;";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        // logger($sql);

        $result = [];
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }


    public function callPackageUpdateDataLines($machineHeader, $workingHours, $efficiencyMachines, $note)
    {
        // Plan Date
        $result = ['status' => 'W'];

        if (count($workingHours)) {
            foreach ($workingHours as $date => $hour) {
                $date = date('d/m/Y', strtotime($date));
                $db = DB::connection('oracle')->getPdo();
                $sql = " declare
                            P_UPD_DATA_REC      PTPP_PLAN_MACHINE_PKG.WEB_UPDATE_DATA_REC;
                            v_status            VARCHAR2(10);
                            v_err_msg           VARCHAR2(1000);
                            BEGIN
                                P_UPD_DATA_REC.RES_PLAN_H_ID            := {$machineHeader->res_plan_h_id};
                                P_UPD_DATA_REC.EFFICIENCY_PRODUCT       := NULL; 
                                P_UPD_DATA_REC.RES_PLAN_DATE            := to_date('{$date}','DD/MM/YYYY') ;
                                P_UPD_DATA_REC.WORKING_HOUR             := {$hour};
                                P_UPD_DATA_REC.MACHINE_NAME             := NULL;
                                P_UPD_DATA_REC.MACHINE_EAMPERFORMANCE   := NULL;
                                PTPP_PLAN_MACHINE_PKG.UPDATE_DATA (P_UPD_DATA_REC   => P_UPD_DATA_REC
                                                            , P_RETURN_STATUS       => :v_status
                                                            , P_RETURN_MESSAGE      => :v_err_msg
                                                        );
                            END;";

                $sql = preg_replace("/[\r\n]*/","",$sql);
                $stmt = $db->prepare($sql);
                logger($sql);
                $result = [];
                $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
                $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
                $stmt->execute();
            }
        }

        // Efficiency Machine
        if (count($efficiencyMachines)) {
            foreach ($efficiencyMachines as $machine_name => $val) {
                $machineName = trim($machine_name);
                $db = DB::connection('oracle')->getPdo();
                $sql = " declare
                            P_UPD_DATA_REC      PTPP_PLAN_MACHINE_PKG.WEB_UPDATE_DATA_REC;
                            v_status            VARCHAR2(10);
                            v_err_msg           VARCHAR2(1000);
                            BEGIN
                                P_UPD_DATA_REC.RES_PLAN_H_ID            := {$machineHeader->res_plan_h_id};
                                P_UPD_DATA_REC.EFFICIENCY_PRODUCT       := NULL; 
                                P_UPD_DATA_REC.RES_PLAN_DATE            := NULL;
                                P_UPD_DATA_REC.WORKING_HOUR             := NULL;
                                P_UPD_DATA_REC.MACHINE_NAME             := '{$machineName}';
                                P_UPD_DATA_REC.MACHINE_EAMPERFORMANCE   := {$val};
                                PTPP_PLAN_MACHINE_PKG.UPDATE_DATA (P_UPD_DATA_REC   => P_UPD_DATA_REC
                                                            , P_RETURN_STATUS       => :v_status
                                                            , P_RETURN_MESSAGE      => :v_err_msg
                                                        );
                            END;";

                $sql = preg_replace("/[\r\n]*/","",$sql);
                $stmt = $db->prepare($sql);
                logger($sql);
                $result = [];
                $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
                $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
                $stmt->execute();
            }
        }

        if ($note) {
            if ($machineHeader->note_description != $note) {
                // Update Note in header
                MachineBiWeeklyHeader::where('res_plan_h_id', $machineHeader->res_plan_h_id)->update(['note_description' => $note]);
                $result = ['status' => 'S'];
            }
        }

        return $result;
    }
}
