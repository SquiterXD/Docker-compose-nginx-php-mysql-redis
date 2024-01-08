<?php

namespace App\Models\Planning\Setup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPS0012V extends Model
{
    use HasFactory;
    protected $table = "PTPPS012_SETUP_V";

    public function callPackageUpdatePPS0012($data, $code)
    {   
        $past_days = $data->past_days ?? 0;
        $db = \DB::connection('oracle')->getPdo();
        $sql = "DECLARE
                    V_RETURN_FLAG  VARCHAR2(10);
                    V_RETURN_MSG   VARCHAR2(1000);
                    L_VALUE        PTPP_SETUP_PKG.PPS012_PARAM_REC ;
                    BEGIN
                        L_VALUE.DAY_CODE        := '{$code}';
                        L_VALUE.PAST_DAYS       := {$past_days};
                        PTPP_SETUP_PKG.WEB_PPS0012 (P_PARAM_DATA => L_VALUE);

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
