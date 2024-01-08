<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WipStep extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_wip_step_t';
    protected $primaryKey = 'wip_step_id';

    public function routing()
    {
        return $this->belongsTo(Routing::class, 'rout_id', 'rout_id');
    }

    public function ptinvUom()
    {
        return $this->belongsTo(PtinvUomV::class, 'uom_code', 'uom_code');
    }

    public function organization()
    {
        return $this->belongsTo(OrganizationCodeV::class, 'organization_code', 'organization_code');
    }
    
    public function openClass()
    {
        return $this->belongsTo(OpenClassV::class, 'wip_step', 'oprn_class');
    }

    public function interfaceDelete($batchno, $routingno, $oprnno)
    {
        // dd($batchno, $routingno, $oprnno);
        $db = \DB::connection('oracle')->getPdo();
        $sql = " 
                    DECLARE 
                        V_STATUS  VARCHAR2(10);
                        V_MSG  VARCHAR2(4000);
                    
                    BEGIN
                        PTOPM_WIP_STEP_PKG.DELETE_ROUTING_STEP(P_WEB_BATCH_NO  => :batchno
                                                , P_ROUTING_NO          => :routingno
                                                , P_OR_OPRN_NO          => :oprnno
                                                , P_INTERFACE_STATUS    => :V_STATUS
                                                , P_INTERFACE_MSG       => :V_MSG) ;
                    
                    
                    END;
                ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':batchno', $batchno, \PDO::PARAM_STR);
        $stmt->bindParam(':routingno', $routingno, \PDO::PARAM_STR);
        $stmt->bindParam(':oprnno', $oprnno, \PDO::PARAM_STR);
        $stmt->bindParam(':V_STATUS', $result['V_STATUS'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':V_MSG', $result['V_MSG'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info($result);
        

        return $result;

        // PTOPM_WIP_STEP_PKG.DELETE_ROUTING_STEP(P_WEB_BATCH_NO  => 'PMS000406-01-2021 10:11:51'
        // , P_ROUTING_NO          => 'WEBRTT07'
        // , P_OR_OPRN_NO          => 'WP01-WEBRTT06'
        // , P_INTERFACE_STATUS    => :V_STAUTS
        // , P_INTERFACE_MSG       => :V_MSG) ;
    }

    // public function interface($batchno)
    // {
    //     // dd($bathNo);

        
    //     $db = \DB::connection('oracle')->getPdo();
    //     $sql = " 
    //                 DECLARE

    //                     V_STATUS        VARCHAR2(10);
    //                     V_MSG           VARCHAR2(4000);
                    
    //                 BEGIN
    //                     PTOPM_WIP_STEP_PKG.MAIN(P_WEB_BATCH_NO       => :batchno
    //                                             ,P_INTERFACE_STATUS  => :V_STATUS
    //                                             ,P_INTERFACE_MSG     => :V_MSG   );
                    
                    
    //                 END;
    //             ";

    //     $sql = preg_replace("/[\r\n]*/","",$sql);
    //     \Log::info($sql);
    //     $stmt = $db->prepare($sql);
    //     $stmt->bindParam(':batchno', $batchno);
    //     $stmt->bindParam(':V_STATUS', $result['V_STATUS'], \PDO::PARAM_STR, 4000);
    //     $stmt->bindParam(':V_MSG', $result['V_MSG'], \PDO::PARAM_STR, 4000);
    //     $stmt->execute();
    //     \Log::info($result);
        

    //     return $result;
    // }
}
