<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class GmdSample extends Model
{
    use HasFactory;

    protected $table  = 'GMD_SAMPLES';

    protected $primaryKey = 'sample_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'sampling_event_id' ,'step_no' ,'step_id' ,'sample_id' ,'sample_no' ,'sample_desc' ,'type' ,'qc_lab_orgn_code' ,'item_id' ,'location' ,'expiration_date' ,'lot_id' ,'lot_no' ,'batch_id' ,'recipe_id' ,'formula_id' ,'formulaline_id' ,'routing_id' ,'oprn_id' ,
        'charge' ,'cust_id' ,'order_id' ,'order_line_id' ,'org_id' ,'supplier_id' ,'sample_qty' ,'sample_uom' ,'source' ,'sampler_id' ,'date_drawn' ,'source_comment' ,'storage_whse' ,'storage_location' ,'external_id' ,'sample_approver_id' ,'inv_approver_id' ,'priority' ,'sample_inv_trans_ind' ,'delete_mark' ,'text_code' ,
        'attribute_category' ,'attribute1' ,'attribute2' ,'attribute3' ,'attribute4' ,'attribute5' ,'attribute6' ,'attribute7' ,'attribute8' ,'attribute9' ,'attribute10' ,'attribute11' ,'attribute12' ,'attribute13' ,'attribute14' ,'attribute15' ,'attribute16' ,'attribute17' ,'attribute18' ,'attribute19' ,'attribute20' ,'attribute21' ,'attribute22' ,'attribute23' ,'attribute24' ,'attribute25' ,'attribute26' ,'attribute27' ,'attribute28' ,'attribute29' ,'attribute30' ,
        'creation_date' ,'created_by' ,'last_updated_by' ,'last_update_date' ,'last_update_login' ,'supplier_site_id' ,'whse_code' ,'orgn_code' ,'po_header_id' ,'po_line_id' ,'receipt_id' ,'receipt_line_id' ,'sample_disposition' ,'ship_to_site_id' ,'supplier_lot_no' ,'lot_retest_ind' ,'sample_instance' ,'sublot_no' ,'source_whse' ,'source_location' ,'date_received' ,'date_required' ,
        'instance_id' ,'resources' ,'retrieval_date' ,'sample_type' ,'time_point_id' ,'variant_id' ,'remaining_qty' ,'retain_as' ,'inventory_item_id' ,'lab_organization_id' ,'locator_id' ,'lot_number' ,'organization_id' ,'parent_lot_number' ,'revision' ,'sample_qty_uom' ,'source_locator_id',
        'source_subinventory' ,'storage_locator_id' ,'storage_organization_id' ,'storage_subinventory' ,'subinventory' ,'migrated_ind' ,'material_detail_id' ,'update_all_locations_ind' ,'lpn_id' ,'internal_orders_ind' ,'source_org_id' ,'requisition_header_id' ,'requisition_line_id'
    ];

    public function results()
    {
        return $this->hasMany(GmdResult::class, 'sample_id', 'sample_id');
    }

}
