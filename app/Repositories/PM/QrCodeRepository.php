<?php
namespace App\Repositories\PM;

use DB;
use Illuminate\Database\Eloquent\Collection;
use App\Models\PM\Lookup\PtpmItemConvUomV;

class QrCodeRepository
{
    function mtlPlan($orgId, $planDate)
    {
        $data = collect(DB::select("
            SELECT ptp.organization_id -- use
                    , ptp.period_name
                    , ptp.biweekly
                    , ptrm.step_num
                    , ptmfg.oprn_desc
                    , ptp.plan_date -- use
                    , ptmfg.inventory_item_id -- use
                    , ptmfg.item_number -- use
                    , ptmfg.item_desc           as description -- use
                    , ptmfg.qty                 as plan_quantity -- use
                    , ptmfg.detail_uom          as uom_code -- use
                    , uom.unit_of_measure       as unit_of_measure -- use
                    , sum((ptp.plan_quantity/mc.machineset_count)*ratio_require_per_unit) b
            from ptmes_biweekly_plan_jobs_v ptp
                ,ptpm_mfg_formula_v ptmfg
                ,ptpm_machine_relation ptrm
                ,ptpm_itemcat_request_seg2 ptc
                ,ptpm_qrcode_interface_t qr
                ,( select organization_id,machine_group,count(*) machineset_count
                    from(select distinct organization_id,machine_group,machine_set
                        from ptpm_machine_relation
                        where organization_id = {$orgId})
                    group by organization_id,machine_group) mc
                , ptinv_uom_v uom
            where ptp.plan_date = to_date('{$planDate}','yyyy-mm-dd')
                and ptp.organization_id = {$orgId}
                and ptp.plan_quantity > 0
                and ptmfg.qty > 0
                and ptp.inventory_item_id   = ptmfg.product_item_id
                and ptp.organization_id     = ptmfg.organization_id

                and ptp.scope_machine       = ptrm.machine_group
                and ptp.organization_id     = ptrm.organization_id
                and nvL(ptmfg.machine_type_code,'1')   = nvL(ptrm.machine_type,'1')

                and ptmfg.tobacco_group_code  = ptc.item_cat_code
                and ptc.request_mat_flag is null

                and ptp.organization_id = mc.organization_id
                and ptp.scope_machine = mc.machine_group

                and ptmfg.organization_id   = qr.organization_id(+)
                and ptmfg.inventory_item_id = qr.inventory_item_id(+)
                and ptp.plan_date           = qr.plan_date(+)
                and ptrm.machine_group      = qr.machine_group(+)
                and ptrm.machine_name       =  qr.machine_name(+)

                and ptmfg.detail_uom        = uom.uom_code
            group by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.plan_date,ptrm.step_num, ptmfg.oprn_desc,
                    ptmfg.inventory_item_id,ptmfg.item_number,ptmfg.item_desc,ptmfg.qty, ptmfg.detail_uom, uom.unit_of_measure
            order by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.plan_date,ptrm.step_num,ptmfg.item_number
        "));

        return $data;
    }
}
