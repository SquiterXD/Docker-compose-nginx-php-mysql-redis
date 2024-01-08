<?php

namespace App\Models\Planning\Setup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPS0011V extends Model
{
    use HasFactory;
    protected $table = "PTPP_FORMULA_STAMP_V";

    public function cigarette()
    {
        return $this->hasOne(\App\Models\Planning\PtppItemCigarettesV::class, 'item_code', 'cigarette_code');
    }

    public function callPackageUpdatePPS0011($data, $pps0011, $item_id)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "DECLARE
                    V_RETURN_FLAG  VARCHAR2(10);
                    V_RETURN_MSG   VARCHAR2(1000);
                    L_VALUE        PTPP_SETUP_PKG.PPS011_PARAM_REC ;
                    BEGIN
                        L_VALUE.INVENTORY_ITEM_ID    := '{$item_id}';
                        L_VALUE.ORGANIZATION_ID      := {$pps0011->organization_id};
                        L_VALUE.STAMP_PER_ROLL       := {$data->stamp_per_roll};
                        PTPP_SETUP_PKG.WEB_PPS0011 (P_PARAM_DATA => L_VALUE);

                        :V_RETURN_FLAG := L_VALUE.RETURN_STATUS;
                        :V_RETURN_MSG := L_VALUE.RETURN_MESSAGE;

                    END;";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);

        $result = [];
        $stmt->bindParam(':V_RETURN_FLAG', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':V_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }
}
