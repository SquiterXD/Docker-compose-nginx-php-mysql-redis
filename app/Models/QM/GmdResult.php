<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class GmdResult extends Model
{
    use HasFactory;

    protected $table  = 'GMD_RESULTS';

    protected $primaryKey = 'result_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'update_instance_id', 'result_id', 'sample_id', 'test_id', 'test_replicate_cnt', 'qc_lab_orgn_code', 'result_value_num', 'result_date', 'test_kit_item_id', 'test_kit_lot_no', 'test_kit_sublot_no', 'tester', 'tester_id', 'test_provider_id', 'ad_hoc_print_on_coa_ind', 'seq', 'result_value_char', 'test_provider_code', 'assay_retest', 'delete_mark', 'text_code', 
        'attribute_category', 'attribute1', 'attribute2', 'attribute3', 'attribute4', 'attribute5', 'attribute6', 'attribute7', 'attribute8', 'attribute9', 'attribute10', 'attribute11', 'attribute12', 'attribute13', 'attribute14', 'attribute15', 'attribute16', 'attribute17', 'attribute18', 'attribute19', 'attribute20', 'attribute21', 'attribute22', 'attribute23', 'attribute24', 'attribute25', 'attribute26', 'attribute27', 'attribute28', 'attribute29', 'attribute30', 
        'creation_date', 'created_by', 'last_updated_by', 'last_update_date', 'last_update_login', 'actual_resource', 'actual_resource_instance', 'planned_resource', 'planned_resource_instance', 'planned_result_date', 'test_by_date', 'consumed_qty', 'parent_result_id', 'reserve_sample_id', 'test_method_id', 'test_qty', 'test_uom', 'organization_id', 'test_qty_uom', 'lab_organization_id', 'test_kit_lot_number', 'test_kit_inv_item_id', 'migrated_ind'
    ];

    public function sample()
    {
        return $this->belongsTo(GmdSample::class, 'sample_id', 'sample_id');
    }

    public function test()
    {
        return $this->belongsTo(PtqmTestsV::class, 'test_id', 'test_id');
    }

}
