<?php

// use DB;
use App\Repositories\PM\IngredientPreparationRepository;

function getLineDetail($orgId, $planDate, $item) {

    $data = (new IngredientPreparationRepository)->LineDetail($orgId,  $planDate, $item);

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
    //     from PTPM_Machine_Range PTMA,
    //         PTPM_QRCODE_INTERFACE_V QR,
            
    //         (select ptp.organization_id,ptp.period_name,ptp.biweekly,ptp.scope_machine,ptp.machine,ptp.plan_quantity,ptp.plan_date,
    //                 PTRM.machine_set,PTRM.machine_description,PTRM.machine_type,PTRM.step_num,  
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
    //                     where organization_id = {$orgId})
    //                 group by organization_id,machine_group) MC
    //         where ptp.plan_date = to_date('{$planDate}','dd-mon-yyyy')
    //             and PTMFG.inventory_item_id = {$item}
    //             and ptp.organization_id = {$orgId}
    //             and ptp.plan_quantity > 0
    //             and PTMFG.qty > 0
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
    //                 PTRM.machine_set,PTRM.machine_description,PTRM.machine_type,PTRM.step_num,
    //                 PTMFG.product_item_id,PTMFG.product_item_number,PTMFG.product_item_desc,PTMFG.product_qty,
    //                 PTMFG.inventory_item_id,PTMFG.item_number,PTMFG.item_desc,PTMFG.qty, PTMFG.detail_uom, PTMFG.oprn_desc) PTPLAN
    //     where   PTPLAN.organization_id   = PTMA.organization_id(+)
    //         and PTPLAN.inventory_item_id = PTMA.inventory_item_id(+)
            
    //         and PTPLAN.organization_id   = QR.organization_id(+)
    //         and PTPLAN.inventory_item_id = QR.inventory_item_id(+)
    //         and PTPLAN.plan_date           = QR.plan_date(+)
    //         and PTPLAN.scope_machine      = QR.machine_group(+)
    //         and PTPLAN.machine_description       =  QR.machine_name(+)
    //     order by PTPLAN.organization_id,PTPLAN.period_name,PTPLAN.biweekly,PTPLAN.plan_date,
    //         PTPLAN.step_num, PTPLAN.item_number,PTPLAN.scope_machine,PTPLAN.machine_set
    // "));

    return $data;

}