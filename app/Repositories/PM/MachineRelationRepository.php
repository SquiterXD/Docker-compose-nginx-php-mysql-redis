<?php

namespace App\Repositories\PM;

use Illuminate\Database\Eloquent\Collection;
use DB;

class MachineRelationRepository
{
    public function getMachineSpeedUnit($wipStepDesc)
    {
        $data = collect(DB::select("
            SELECT  distinct pu.UNIT_OF_MEASURE_TL UOM1
                    , pa.USAGE_UOM_DESC UOM2
                    , pu.UNIT_OF_MEASURE_TL || ' / ' || pa.USAGE_UOM_DESC value
                    --, pm.*
            from    ptpm_asset_v pa
            ,       ptpm_manufacture_step pm
            ,       ptinv_uom_v pu
            where   1=1
            and     pa.WIP_ID = pm.WIP_ID
            and     pm.PROCESS_QTY_UOM = pu.UOM_CODE
            and     pa.wip_step_desc = '$wipStepDesc'
        "));

        if ($data) {
            return optional($data->first())->value ?? '';
        }
    }

    public function getMachineSpeedUnitArr($wipStepDesc = [])
    {
        $data = collect([]);
        if (count($wipStepDesc) > 0) {
            $wipStepDesc = "'" . implode ( "', '", $wipStepDesc ) . "'";
            $data = collect(DB::select("
                SELECT  distinct pu.UNIT_OF_MEASURE_TL UOM1
                        , pa.USAGE_UOM_DESC UOM2
                        , pu.UNIT_OF_MEASURE_TL || ' / ' || pa.USAGE_UOM_DESC value
                        , pa.wip_step_desc
                        --, pm.*
                from    ptpm_asset_v pa
                ,       ptpm_manufacture_step pm
                ,       ptinv_uom_v pu
                where   1=1
                and     pa.WIP_ID = pm.WIP_ID
                and     pm.PROCESS_QTY_UOM = pu.UOM_CODE
                and     pa.wip_step_desc in ($wipStepDesc)
            "));
        }

        return $data;
    }
}
