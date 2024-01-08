<?php
namespace App\Repositories\PM;

use DB;
use Illuminate\Database\Eloquent\Collection;

class IngredientPreparationRepository
{
    function HeaderDetail($orgId, $planDate)
    {
        // $data = collect(DB::select("
        //         SELECT ptp.organization_id -- use
        //             , ptp.period_name
        //             , ptp.biweekly
        //             , ptrm.step_num
        //             , ptmfg.oprn_desc
        //             , ptp.plan_date -- use
        //             , ptmfg.inventory_item_id -- use
        //             , ptmfg.item_number -- use
        //             , ptmfg.item_desc           as description -- use
        //             , ptmfg.qty                 as plan_quantity -- use
        //             , ptmfg.detail_uom          as uom_code -- use
        //             , uom.unit_of_measure       as unit_of_measure -- use
        //             , sum((ptp.plan_quantity/mc.machineset_count)*ratio_require_per_unit) b
        //         from ptmes_biweekly_plan_jobs_v ptp
        //             ,ptpm_mfg_formula_v ptmfg
        //             ,ptpm_machine_relation ptrm
        //             ,ptpm_itemcat_request_seg2 ptc
        //             ,ptpm_qrcode_interface_t qr
        //             ,( select organization_id,machine_group,count(*) machineset_count
        //                 from(select distinct organization_id,machine_group,machine_set
        //                     from ptpm_machine_relation
        //                     where organization_id = {$orgId})
        //                 group by organization_id,machine_group) mc
        //             , ptinv_uom_v uom
        //         where ptp.plan_date = to_date('{$planDate}','yyyy-mm-dd')
        //             and ptp.organization_id = {$orgId}
        //             and ptp.plan_quantity > 0
        //             and ptmfg.qty > 0
        //             and ptp.inventory_item_id   = ptmfg.product_item_id
        //             and ptp.organization_id     = ptmfg.organization_id

        //             and ptp.scope_machine       = ptrm.machine_group
        //             and ptp.organization_id     = ptrm.organization_id
        //             and nvL(ptmfg.machine_type_code,'1')   = nvL(ptrm.machine_type,'1')

        //             and ptmfg.tobacco_group_code  = ptc.item_cat_code
        //             and ptc.request_mat_flag is null

        //             and ptp.organization_id = mc.organization_id
        //             and ptp.scope_machine = mc.machine_group

        //             and ptmfg.organization_id   = qr.organization_id(+)
        //             and ptmfg.inventory_item_id = qr.inventory_item_id(+)
        //             and ptp.plan_date           = qr.plan_date(+)
        //             and ptrm.machine_group      = qr.machine_group(+)
        //             and ptrm.machine_name       =  qr.machine_name(+)

        //             and ptmfg.detail_uom        = uom.uom_code
        //         group by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.plan_date,ptrm.step_num, ptmfg.oprn_desc,
        //                 ptmfg.inventory_item_id,ptmfg.item_number,ptmfg.item_desc,ptmfg.qty, ptmfg.detail_uom, uom.unit_of_measure
        //         order by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.plan_date,ptrm.step_num,ptmfg.item_number
        // "));

        // ----------------------------------------------------------------------------------------------------

        // $sql = "
        //     SELECT ptp.organization_id -- use
        //             , ptp.period_name
        //             , ptp.biweekly
        //             , ptrm.step_num
        //             , ptmfg.oprn_desc
        //             , ptp.plan_date -- use
        //             , ptmfg.inventory_item_id -- use
        //             , ptmfg.item_number -- use
        //             , ptmfg.item_desc           as description -- use
        //             , max(ptmfg.qty)                 as plan_quantity -- use
        //             , ptmfg.detail_uom          as uom_code -- use
        //             , uom.unit_of_measure       as unit_of_measure -- use
        //             , sum((ptp.plan_quantity/mc.machineset_count)*ratio_require_per_unit) b
        //     from ptmes_biweekly_plan_jobs_v ptp
        //         ,ptpm_mfg_formula_v ptmfg
        //         ,ptpm_machine_relation ptrm
        //         ,ptpm_itemcat_request_seg2 ptc
        //         ,ptpm_qrcode_interface_t qr
        //         ,( select organization_id,machine_group,count(*) machineset_count
        //             from(select distinct organization_id,machine_group,machine_set
        //                 from ptpm_machine_relation
        //                 where organization_id = $orgId)
        //             group by organization_id,machine_group) mc
        //         , ptinv_uom_v uom
        //     where ptp.plan_date = to_date('{$planDate}','yyyy-mm-dd')
        //         and ptp.organization_id = $orgId
        //         and ptp.plan_quantity > 0
        //         and ptmfg.qty > 0
        //         and ptmfg.receipe_type_code = '1'
        //         and ptp.inventory_item_id   = ptmfg.product_item_id
        //         and ptp.organization_id     = ptmfg.organization_id

        //         and ptp.scope_machine       = ptrm.machine_group
        //         and ptp.organization_id     = ptrm.organization_id
        //         and nvL(ptmfg.machine_type_code,'1')   = nvL(ptrm.machine_type,'1')

        //         and ptmfg.tobacco_group_code  = ptc.item_cat_code
        //         and ptc.request_mat_flag is null

        //         and ptp.organization_id = mc.organization_id
        //         and ptp.scope_machine = mc.machine_group

        //         and ptmfg.organization_id   = qr.organization_id(+)
        //         and ptmfg.inventory_item_id = qr.inventory_item_id(+)
        //         and ptp.plan_date           = qr.plan_date(+)
        //         and ptrm.machine_group      = qr.machine_group(+)
        //         and ptrm.machine_name       =  qr.machine_name(+)

        //         and ptmfg.detail_uom        = uom.uom_code
        //     group by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.plan_date,ptrm.step_num, ptmfg.oprn_desc,
        //             ptmfg.inventory_item_id,ptmfg.item_number,ptmfg.item_desc, ptmfg.detail_uom, uom.unit_of_measure
        //     order by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.plan_date,ptrm.step_num,ptmfg.item_number
        // ";

        // ----------------------------------------------------------------------------------------------------

        $sql = "
            SELECT ptp.organization_id -- use
                    , ptp.period_name
                    , ptp.biweekly
                    , ptrm.step_num
                    , ptmfg.oprn_desc
                    , ptp.plan_date -- use
                    , ptmfg.inventory_item_id -- use
                    , ptmfg.item_number -- use
                    , ptmfg.item_desc           as description -- use
                    , max(ptmfg.qty)                 as plan_quantity -- use
                    , ptmfg.detail_uom          as uom_code -- use
                    , uom.unit_of_measure       as unit_of_measure -- use
                    , sum((ptp.plan_quantity/mc.machineset_count)*ratio_require_per_unit) b
            from ptmes_biweekly_plan_jobs_v ptp
                ,ptpm_mfg_formula_v ptmfg
                ,ptpm_machine_relations_v ptrm
                ,ptpm_itemcat_request_seg2 ptc
                ,ptpm_qrcode_interface_t qr
                ,( select organization_id,machine_group,count(*) machineset_count
                    from(select distinct organization_id,machine_group,machine_set
                        from ptpm_machine_relations_v
                        where organization_id = {$orgId})
                    group by organization_id,machine_group) mc
                , ptinv_uom_v uom
            where ptp.plan_date = to_date('{$planDate}','yyyy-mm-dd')
                and ptp.organization_id = {$orgId}
                and ptp.plan_quantity > 0
                and ptmfg.qty > 0
                and ptmfg.receipe_type_code = '1'
                
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
                and substr(ptmfg.item_number,1,4) not in(select distinct FV.flex_value
                                                        from FND_FLEX_VALUES_VL FV
                                                            ,fnd_flex_value_sets FVS
                                                        where FV.flex_value_set_id = FVS.flex_value_set_id
                                                        and flex_value_set_name = 'TOAT_INV_ITEM_CATEGORIES_TOAT2-SEGMENT1'
                                                        and FV.attribute3 = 'N')
                and ptmfg.detail_uom        = uom.uom_code
            group by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.plan_date,ptrm.step_num, ptmfg.oprn_desc,
                    ptmfg.inventory_item_id,ptmfg.item_number,ptmfg.item_desc, ptmfg.detail_uom, uom.unit_of_measure
            order by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.plan_date,ptrm.step_num,ptmfg.item_number
        ";


        $data = collect(DB::select($sql));


        // $data = collect(\DB::select("
        //     SELECT ptp.organization_id -- use
        //             , ptp.period_name
        //             , ptp.biweekly
        //             , ptrm.step_num
        //             , ptmfg.oprn_desc
        //             , ptp.plan_date -- use
        //             , ptmfg.inventory_item_id -- use
        //             , ptmfg.item_number -- use
        //             , ptmfg.item_desc           as description -- use
        //             , max(ptmfg.qty)                 as plan_quantity -- use
        //             , ptmfg.detail_uom          as uom_code -- use
        //             , uom.unit_of_measure       as unit_of_measure -- use
        //             , sum((ptp.plan_quantity/mc.machineset_count)*ratio_require_per_unit) b
        //     from ptmes_biweekly_plan_jobs_v ptp
        //         ,ptpm_mfg_formula_v ptmfg
        //         ,ptpm_machine_relation ptrm
        //         ,ptpm_itemcat_request_seg2 ptc
        //         ,ptpm_qrcode_interface_t qr
        //         ,( select organization_id,machine_group,count(*) machineset_count
        //             from(select distinct organization_id,machine_group,machine_set
        //                 from ptpm_machine_relation
        //                 where organization_id = {$orgId})
        //             group by organization_id,machine_group) mc
        //         , ptinv_uom_v uom
        //     where ptp.plan_date = to_date('{$planDate}','yyyy-mm-dd')
        //         and ptp.organization_id = {$orgId}
        //         and ptp.plan_quantity > 0
        //         and ptmfg.qty > 0
        //         and ptmfg.receipe_type_code = '1'
                
        //         and ptp.inventory_item_id   = ptmfg.product_item_id
        //         and ptp.organization_id     = ptmfg.organization_id

        //         and ptp.scope_machine       = ptrm.machine_group
        //         and ptp.organization_id     = ptrm.organization_id
        //         and nvL(ptmfg.machine_type_code,'1')   = nvL(ptrm.machine_type,'1')

        //         and ptmfg.tobacco_group_code  = ptc.item_cat_code
        //         and ptc.request_mat_flag is null

        //         and ptp.organization_id = mc.organization_id
        //         and ptp.scope_machine = mc.machine_group

        //         and ptmfg.organization_id   = qr.organization_id(+)
        //         and ptmfg.inventory_item_id = qr.inventory_item_id(+)
        //         and ptp.plan_date           = qr.plan_date(+)
        //         and ptrm.machine_group      = qr.machine_group(+)
        //         and ptrm.machine_name       =  qr.machine_name(+)
        //         and substr(ptmfg.item_number,1,4) not in(select distinct FV.flex_value
        //                                                 from FND_FLEX_VALUES_VL FV
        //                                                     ,fnd_flex_value_sets FVS
        //                                                 where FV.flex_value_set_id = FVS.flex_value_set_id
        //                                                 and flex_value_set_name = 'TOAT_INV_ITEM_CATEGORIES_TOAT2-SEGMENT1'
        //                                                 and FV.attribute3 = 'N')
        //         and ptmfg.detail_uom        = uom.uom_code
        //     group by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.plan_date,ptrm.step_num, ptmfg.oprn_desc,
        //             ptmfg.inventory_item_id,ptmfg.item_number,ptmfg.item_desc, ptmfg.detail_uom, uom.unit_of_measure
        //     order by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.plan_date,ptrm.step_num,ptmfg.item_number
        // "));

        return $data;
    }

    function LineDetail($orgId, $planDate, $item) {

        // dd($orgId, $planDate, $item);
        // {$planDate}

        // $data = collect(\DB::select("
        //         select PTPLAN.used_qty - nvl(QR.transaction_quantity,0) request_qty,
        //             0 machine_qty, nvl(ptma.max_machine,0) max_machine,
        //             case when PTPLAN.used_qty - nvl(QR.transaction_quantity,0) > nvl(PTMA.max_machine,0) then
        //                 nvl(ptma.max_machine,0) - 0
        //             else
        //                 PTPLAN.used_qty - nvl(QR.transaction_quantity,0)
        //             end remaining_qty,
        //             PTPLAN.*
        //         from PTPM_Machine_Range PTMA,
        //             PTPM_QRCODE_INTERFACE_V QR,

        //             (select ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.scope_machine,ptp.machine,ptp.plan_quantity,ptp.plan_date,
        //                     PTRM.machine_set,PTRM.machine_description,PTRM.machine_type,PTRM.step_num,
        //                     PTMFG.product_item_id,PTMFG.product_item_number,PTMFG.product_item_desc,PTMFG.product_qty,
        //                     PTMFG.inventory_item_id,PTMFG.item_number,PTMFG.item_desc,PTMFG.qty, PTMFG.detail_uom,( select UNIT_OF_MEASURE
        //                     from ptinv_uom_v uom where uom.UOM_CODE = PTMFG.detail_uom) detail_uom_desc,
        //                     PTMFG.oprn_desc,
        //                     sum((ptp.plan_quantity/MC.MACHINESET_COUNT)*ratio_require_per_unit) used_qty
        //             from ptmes_biweekly_plan_jobs_v ptp
        //                 ,PTPM_MFG_FORMULA_V PTMFG
        //                 ,PTPM_Machine_Relation PTRM
        //                 ,PTPM_ITEMCAT_REQUEST_SEG2 PTC
        //                 ,( select organization_id,machine_group,count(*) MACHINESET_COUNT
        //                     from(select distinct organization_id,machine_group,machine_set
        //                         from PTPM_Machine_Relation
        //                         where organization_id = {$orgId})
        //                     group by organization_id,machine_group) MC
        //             where ptp.plan_date = to_date('{$planDate}','dd-mon-yyyy')
        //                 and PTMFG.inventory_item_id = {$item}
        //                 and ptp.organization_id = {$orgId}
        //                 and ptp.plan_quantity > 0
        //                 and PTMFG.qty > 0
        //                 and ptp.inventory_item_id   = PTMFG.product_item_id
        //                 and ptp.organization_id     = PTMFG.organization_id

        //                 and ptp.scope_machine       = PTRM.machine_group
        //                 and ptp.organization_id     = PTRM.organization_id
        //                 and nvL(ptmfg.machine_type_code,'1')   = nvL(ptrm.machine_type,'1')

        //                 and PTMFG.tobacco_group_code  = ptc.item_cat_code
        //                 and ptc.request_mat_flag is null

        //                 and ptp.organization_id = MC.organization_id
        //                 and ptp.scope_machine = MC.machine_group
        //             group by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.scope_machine,ptp.machine,ptp.plan_quantity,ptp.plan_date,
        //                     PTRM.machine_set,PTRM.machine_description,PTRM.machine_type,PTRM.step_num,
        //                     PTMFG.product_item_id,PTMFG.product_item_number,PTMFG.product_item_desc,PTMFG.product_qty,
        //                     PTMFG.inventory_item_id,PTMFG.item_number,PTMFG.item_desc,PTMFG.qty, PTMFG.detail_uom, PTMFG.oprn_desc) PTPLAN
        //         where   PTPLAN.organization_id   = PTMA.organization_id(+)
        //             and PTPLAN.inventory_item_id = PTMA.inventory_item_id(+)

        //             and PTPLAN.organization_id   = QR.organization_id(+)
        //             and PTPLAN.inventory_item_id = QR.inventory_item_id(+)
        //             and PTPLAN.plan_date           = QR.plan_date(+)
        //             and PTPLAN.scope_machine      = QR.machine_group(+)
        //             and PTPLAN.machine_description       =  QR.machine_name(+)
        //         order by PTPLAN.organization_id,PTPLAN.period_name,PTPLAN.biweekly,PTPLAN.plan_date,
        //             PTPLAN.step_num, PTPLAN.item_number,PTPLAN.scope_machine,PTPLAN.machine_set
        // "));

        // ---------------------------------------------------------------------------------------------------

        // $sql = "
        //     SELECT sum(x.request_qty) request_qty,
        //             sum(x.machine_qty) machine_qty,
        //             x.max_machine,
        //             sum(x.remaining_qty) remaining_qty,
        //             sum(x.used_qty) used_qty,
        //             x.organization_id,
        //             x.period_name,
        //             x.biweekly,
        //             x.scope_machine,
        //             x.machine,
        //             x.plan_date,
        //             x.machine_set,
        //             x.machine_description,
        //             x.machine_type,
        //             x.step_num,
        //             x.inventory_item_id,
        //             x.item_number,
        //             x.item_desc,
        //             x.detail_uom,
        //             x.th_detail_unit_of_measure detail_uom_desc,
        //             x.oprn_desc
        //     from
        //     (select PTPLAN.used_qty - nvl(QR.transaction_quantity,0) request_qty,
        //             0 machine_qty, nvl(ptma.max_machine,0) max_machine,
        //             case when PTPLAN.used_qty - nvl(QR.transaction_quantity,0) > nvl(PTMA.max_machine,0) then
        //                 nvl(ptma.max_machine,0) - 0
        //             else
        //                 PTPLAN.used_qty - nvl(QR.transaction_quantity,0)
        //             end remaining_qty,
        //             PTPLAN.*
        //     from PTPM_Machine_Range PTMA,
        //         PTPM_QRCODE_INTERFACE_V QR,

        //         (select ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.scope_machine,ptp.machine,ptp.plan_quantity,ptp.plan_date,
        //                 PTRM.machine_set,PTRM.machine_description,PTRM.machine_type,PTRM.step_num,PTMFG.th_detail_unit_of_measure,
        //                 PTMFG.product_item_id,PTMFG.product_item_number,PTMFG.product_item_desc,PTMFG.product_qty,
        //                 PTMFG.inventory_item_id,PTMFG.item_number,PTMFG.item_desc,PTMFG.qty, PTMFG.detail_uom, PTMFG.oprn_desc,
        //                 sum((ptp.plan_quantity/MC.MACHINESET_COUNT)*ratio_require_per_unit) used_qty
        //         from ptmes_biweekly_plan_jobs_v ptp
        //             ,PTPM_MFG_FORMULA_V PTMFG
        //             ,PTPM_Machine_Relation PTRM
        //             ,PTPM_ITEMCAT_REQUEST_SEG2 PTC
        //             ,( select organization_id,machine_group,count(*) MACHINESET_COUNT
        //                 from(select distinct organization_id,machine_group,machine_set
        //                     from PTPM_Machine_Relation
        //                     where organization_id = $orgId)
        //                 group by organization_id,machine_group) MC
        //         where ptp.plan_date = to_date('{$planDate}','dd-mon-yyyy')
        //             and PTMFG.inventory_item_id = $item
        //             and ptp.organization_id = $orgId
        //             and ptp.plan_quantity > 0
        //             and PTMFG.qty > 0
        //             and ptmfg.receipe_type_code = '1'
        //             and ptp.inventory_item_id   = PTMFG.product_item_id
        //             and ptp.organization_id     = PTMFG.organization_id

        //             and ptp.scope_machine       = PTRM.machine_group
        //             and ptp.organization_id     = PTRM.organization_id
        //             and nvL(ptmfg.machine_type_code,'1')   = nvL(ptrm.machine_type,'1')

        //             and PTMFG.tobacco_group_code  = ptc.item_cat_code
        //             and ptc.request_mat_flag is null

        //             and ptp.organization_id = MC.organization_id
        //             and ptp.scope_machine = MC.machine_group
        //         group by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.scope_machine,ptp.machine,ptp.plan_quantity,ptp.plan_date,
        //                 PTRM.machine_set,PTRM.machine_description,PTRM.machine_type,PTRM.step_num,PTMFG.th_detail_unit_of_measure,
        //                 PTMFG.product_item_id,PTMFG.product_item_number,PTMFG.product_item_desc,PTMFG.product_qty,
        //                 PTMFG.inventory_item_id,PTMFG.item_number,PTMFG.item_desc,PTMFG.qty, PTMFG.detail_uom, PTMFG.oprn_desc) PTPLAN
        //     where   PTPLAN.organization_id   = PTMA.organization_id(+)
        //         and PTPLAN.inventory_item_id = PTMA.inventory_item_id(+)

        //         and PTPLAN.organization_id   = QR.organization_id(+)
        //         and PTPLAN.inventory_item_id = QR.inventory_item_id(+)
        //         and PTPLAN.plan_date           = QR.plan_date(+)
        //         and PTPLAN.scope_machine      = QR.machine_group(+)
        //         and PTPLAN.machine_description       =  QR.machine_name(+)
        //     ) x
        //     group by x.max_machine,
        //             x.organization_id,
        //             x.period_name,
        //             x.biweekly,
        //             x.scope_machine,
        //             x.machine,
        //             x.plan_date,
        //             x.machine_set,
        //             x.machine_description,
        //             x.machine_type,
        //             x.step_num,
        //             x.inventory_item_id,
        //             x.item_number,
        //             x.item_desc,
        //             x.detail_uom,
        //             x.th_detail_unit_of_measure,
        //             x.oprn_desc
        //     order by x.organization_id,x.period_name,x.biweekly,x.plan_date,
        //         x.step_num, x.item_number,x.scope_machine,x.machine_set
        // ";

        // ---------------------------------------------------------------------------------------------------

        $sql = "
            select sum(x.request_qty) request_qty,
                    sum(x.machine_qty) machine_qty,
                    x.max_machine,
                    sum(x.remaining_qty) remaining_qty,
                    sum(x.used_qty) used_qty,
                    x.organization_id,
                    x.period_name,
                    x.biweekly,
                    x.scope_machine,
                    x.machine,
                    x.plan_date,
                    x.machine_set,
                    x.machine_description,
                    x.machine_type,
                    x.step_num,
                    x.inventory_item_id,
                    x.item_number,
                    x.item_desc,
                    x.detail_uom,
                    x.th_detail_unit_of_measure detail_uom_desc,
                    x.oprn_desc
            from 
            (select PTPLAN.used_qty - nvl(QR.transaction_quantity,0) request_qty,
                    0 machine_qty, nvl(ptma.max_machine,0) max_machine,
                    case when PTPLAN.used_qty - nvl(QR.transaction_quantity,0) > nvl(PTMA.max_machine,0) then
                        nvl(ptma.max_machine,0) - 0
                    else
                        PTPLAN.used_qty - nvl(QR.transaction_quantity,0)
                    end remaining_qty,
                    PTPLAN.*
            from PTPM_Machine_Range PTMA,
                PTPM_QRCODE_INTERFACE_V QR,
                
                (select ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.scope_machine,ptp.machine,ptp.plan_quantity,ptp.plan_date,
                        PTRM.machine_set,PTRM.machine_description,PTRM.machine_type,PTRM.step_num,PTMFG.th_detail_unit_of_measure,
                        PTMFG.product_item_id,PTMFG.product_item_number,PTMFG.product_item_desc,PTMFG.product_qty,
                        PTMFG.inventory_item_id,PTMFG.item_number,PTMFG.item_desc,PTMFG.qty, PTMFG.detail_uom, PTMFG.oprn_desc,
                        sum((ptp.plan_quantity/MC.MACHINESET_COUNT)*ratio_require_per_unit) used_qty
                from ptmes_biweekly_plan_jobs_v ptp
                    ,PTPM_MFG_FORMULA_V PTMFG
                    ,ptpm_machine_relations_v PTRM
                    ,PTPM_ITEMCAT_REQUEST_SEG2 PTC
                    ,( select organization_id,machine_group,count(*) MACHINESET_COUNT 
                        from(select distinct organization_id,machine_group,machine_set
                            from ptpm_machine_relations_v
                            where organization_id = $orgId)
                        group by organization_id,machine_group) MC
                where ptp.plan_date = to_date('{$planDate}','dd-mon-yyyy')
                    and PTMFG.inventory_item_id = $item
                    and ptp.organization_id = $orgId
                    and ptp.plan_quantity > 0
                    and PTMFG.qty > 0
                    and ptmfg.receipe_type_code = '1'
                    and ptp.inventory_item_id   = PTMFG.product_item_id
                    and ptp.organization_id     = PTMFG.organization_id
                    
                    and ptp.scope_machine       = PTRM.machine_group
                    and ptp.organization_id     = PTRM.organization_id
                    and nvL(ptmfg.machine_type_code,'1')   = nvL(ptrm.machine_type,'1')
                    
                    and PTMFG.tobacco_group_code  = ptc.item_cat_code
                    and ptc.request_mat_flag is null
                    and substr(ptmfg.item_number,1,4) not in(select distinct FV.flex_value
                                                        from FND_FLEX_VALUES_VL FV
                                                            ,fnd_flex_value_sets FVS
                                                        where FV.flex_value_set_id = FVS.flex_value_set_id
                                                        and flex_value_set_name = 'TOAT_INV_ITEM_CATEGORIES_TOAT2-SEGMENT1'
                                                        and FV.attribute3 = 'N')
                    and ptp.organization_id = MC.organization_id
                    and ptp.scope_machine = MC.machine_group
                group by ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.scope_machine,ptp.machine,ptp.plan_quantity,ptp.plan_date,
                        PTRM.machine_set,PTRM.machine_description,PTRM.machine_type,PTRM.step_num,PTMFG.th_detail_unit_of_measure,
                        PTMFG.product_item_id,PTMFG.product_item_number,PTMFG.product_item_desc,PTMFG.product_qty,
                        PTMFG.inventory_item_id,PTMFG.item_number,PTMFG.item_desc,PTMFG.qty, PTMFG.detail_uom, PTMFG.oprn_desc) PTPLAN
            where   PTPLAN.organization_id   = PTMA.organization_id(+)
                and PTPLAN.inventory_item_id = PTMA.inventory_item_id(+)
                
                and PTPLAN.organization_id   = QR.organization_id(+)
                and PTPLAN.inventory_item_id = QR.inventory_item_id(+)
                and PTPLAN.plan_date           = QR.plan_date(+)
                and PTPLAN.scope_machine      = QR.machine_group(+)
                and PTPLAN.machine_description       =  QR.machine_name(+)
            ) x
            group by x.max_machine,
                    x.organization_id,
                    x.period_name,
                    x.biweekly,
                    x.scope_machine,
                    x.machine,
                    x.plan_date,
                    x.machine_set,
                    x.machine_description,
                    x.machine_type,
                    x.step_num,
                    x.inventory_item_id,
                    x.item_number,
                    x.item_desc,
                    x.detail_uom,
                    x.th_detail_unit_of_measure,
                    x.oprn_desc
            order by x.organization_id,x.period_name,x.biweekly,x.plan_date,
                x.step_num, x.item_number,x.scope_machine,x.machine_set                                  
        ";

        \Log::info($sql);

        $data = collect(DB::select($sql));

        return $data;
    }

    public function M05Detail($planDate)
    {
        $date = date('d-M-Y', strtotime($planDate));
        // dd($planDate, $date, date('d-M-Y', strtotime($planDate)));
        // $sql = "
        //     select mfg.inventory_item_id, sum(mes.product_qty/mfg.product_qty * nvl(mfg.require_qty,mfg.qty)) B
        //     from PTMES_PRODUCT_LINE MES, ptpm_mfg_formula_v mfg
        //     where MES.product_date = CASE WHEN to_char(to_date('{$date}','dd-MON-yyyy'),'DY') = 'MON' 
        //                             THEN to_date('{$date}','dd-MON-yyyy') - 2
        //                             ELSE to_date('{$date}','dd-MON-yyyy')
        //                         END
        //     and mfg.organization_code = 'M05'
        //     and mes.organization_id = mfg.organization_id
        //     and mes.inventory_item_id = mfg.product_item_id
        //     and mfg.product_flag = 'Y'
        //     group by mfg.inventory_item_id
        // ";

        $data = collect(\DB::select("
            select mfg.inventory_item_id, sum(mes.product_qty/mfg.product_qty * nvl(mfg.require_qty,mfg.qty)) B
            from PTMES_PRODUCT_LINE MES, ptpm_mfg_formula_v mfg
            where MES.product_date = CASE WHEN to_char(to_date('{$date}','dd-MON-yyyy'),'DY') = 'MON' 
                                    THEN to_date('{$date}','dd-MON-yyyy') - 2
                                    ELSE to_date('{$date}','dd-MON-yyyy')
                                END
            and mfg.organization_code = 'M05'
            and mes.organization_id = mfg.organization_id
            and mes.inventory_item_id = mfg.product_item_id
            and mfg.product_flag = 'Y'
            group by mfg.inventory_item_id
        "));
        // dd($xxx);

        // $data = collect(DB::select($sql));

        // dd($data);
        \Log::info('-------- M05 Start --------');
        \Log::info($date);
        \Log::info($data);
        \Log::info('-------- M05 End --------');

        return $data;
    }
}
