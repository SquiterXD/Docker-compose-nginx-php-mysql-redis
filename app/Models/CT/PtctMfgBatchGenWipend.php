<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtctMfgBatchGenWipend extends Model
{
    use HasFactory;
    protected $table = "ptct_mfg_batch_gen_wipend";
    public $primaryKey = 'TRANSACTION_ID';
    // protected $casts = [
    //     'ct_accounting_date' => 'date',
    // ];
    
    public function scopeSelectField($q)
    {
        return  $q->selectRaw("
                    to_number(REPLACE(ct_dm_aq_inwip,',','')) ct_dm_aq_inwip, 
                    ct_batch_no, 
                    ct_accounting_date, 
                    ct_wip_code, 
                    ct_wip_name,
                    to_number(REPLACE(ct_prd_aq_wipbegin,',','')) ct_prd_aq_wipbegin,
                    ct_dm_aqsp_wipbegin, 
                    ct_dl_aqsp_wipbegin,
                    ct_voh_aqsp_wipbegin, 
                    ct_foh_aqsp_wipbegin, 
                    ct_dm_group,
                    ct_dm_group_name,
                    ct_percent_finish_dl_rate,
                    ct_percent_finish_voh_rate,
                    ct_percent_finish_foh_rate,
                    ct_percent_finish_dl,
                    ct_percent_finish_voh,
                    ct_percent_finish_foh,
                    to_number(REPLACE(ct_dm_aqsp_inwip,',','')) ct_dm_aqsp_inwip,
                    ct_prd_aq_loss,
                    to_number(REPLACE(ct_prd_aq_inwip,',','')) ct_prd_aq_inwip,
                    ct_cc_code,
                    to_number(REPLACE(ct_dl_aqsp_inwip,',','')) ct_dl_aqsp_inwip,
                    to_number(REPLACE(ct_voh_aqsp_inwip,',','')) ct_voh_aqsp_inwip,
                    to_number(REPLACE(ct_foh_aqsp_inwip,',','')) ct_foh_aqsp_inwip,
                    to_number(REPLACE(ct_prd_aq_wipcomplete,',','')) ct_prd_aq_wipcomplete,
                    ct_std_dl_per_ccunit,
                    ct_std_voh_per_ccunit,
                    ct_std_foh_per_ccunit,
                    ct_std_prd_per_ccunit,
                    ct_product_code,
                    ct_product_name,
                    ct_product_uom_name,
                    ct_inv_org_dm,
                    ct_inv_org_dm_name,
                    ct_dm_code,
                    ct_dm_lot_inwip,
                    ct_dm_name,
                    ct_dm_uom,
                    to_number(REPLACE(ct_std_dm_qty,',','')) ct_std_dm_qty,
                    to_number(REPLACE(ct_std_dm_per_ccunit,',','')) ct_std_dm_per_ccunit,
                    to_number(REPLACE(ct_dm_sq_inwip,',','')) ct_dm_sq_inwip,
                    to_number(REPLACE(ct_dm_sqsp_inwip,',','')) ct_dm_sqsp_inwip,
                    ct_cc_name
            ");
    }


}
