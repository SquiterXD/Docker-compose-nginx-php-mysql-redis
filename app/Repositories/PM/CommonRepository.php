<?php
namespace App\Repositories\PM;

use DB;
use PDO;
use Illuminate\Database\Eloquent\Collection;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\PtInvUomV;

class CommonRepository
{
    function getSecUomList($params)
    {
        $secUomList = PtpmItemConvUomV::with(['fromUom'])
                        ->where('inventory_item_id', $params->inventory_item_id)
                        ->where('organization_id',  $params->organization_id)
                        ->where('to_uom_code', $params->to_uom_code)
                        ->get();

        return $secUomList;
    }

    // public function ptInvUomV($uomCode)
    // {
    //     $data = PtInvUomV::whereFirst('uom_code', $uomCode);

    //     dd('xx', $uomCode, $data);
    // }

    function costValidate($inventoryItemId, $organizationId, $period)
    {
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "

            declare
                v_status         varchar2(5);
                v_err_msg        varchar2(2000);
            begin

                           PTPM_MICS_PKG.cost_validate(  p_inventory_item_id    => $inventoryItemId
                                                        ,p_organization_id      => $organizationId
                                                        ,P_YEAR         => '$period'
                                                        ,x_status       => :v_status
                                                        ,x_message      => :v_err_msg);

                            dbms_output.put_line('Status : ' || v_status);
                            dbms_output.put_line('MSG : ' || v_err_msg);
            end;
        ";

        \Log::info("costValidate INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_err_msg', $result['msg'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("costValidate INF", [$result]);
        return $result;
    }

    function freezeBatchStatus($batchNo = '')
    {
        $freezeData = (object) [
            'is_freeze_flag' => false,
            'freeze_msg' => '',
            'freeze_flag_date' => ''
        ];
        if ($batchNo == '') {
            return $freezeData;
        }

        $data = collect(DB::connection('oracle')->select("
            SELECT
                ptpm_main.freeze_batch_status('$batchNo') freeze_flag from dual
        "));

        if (count($data)) {
            $freezeFlag = $data->first()->freeze_flag;
            if ($freezeFlag) {
                $freezeData->is_freeze_flag = true;
                $freezeData->freeze_msg = "กองบริหารต้นทุนนำไปใช้แล้ว";
                $freezeData->freeze_flag_date = $freezeFlag;                
            }
        }

        return $freezeData;
    }
}
