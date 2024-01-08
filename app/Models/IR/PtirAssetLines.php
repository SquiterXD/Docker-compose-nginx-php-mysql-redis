<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirAssetLines extends Model
{
    use HasFactory;
    protected $table = "ptir_asset_lines";
    public $primaryKey = 'line_id';
    public $timestamps = false;
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'header_id',
        'line_number',
        'status',
        'asset_status',
        'year',
        'insurance_start_date',
        'insurance_end_date',
        'policy_set_header_id',
        'policy_set_description',
        'department_location_code',
        'department_location_desc',
        'department_cost_code',
        'department_cost_desc',
        'account_id',
        'account_code',
        'account_code_desc',
        'asset_number',
        'department_code',
        'department_name',
        'location_id',
        'location_code',
        'location_name',
        'category_code',
        'category_description',
        'quantity',
        'adjustment_source_type',
        'adjustment_date',
        'adjustment_amount',
        'adjustment_line_id',
        'adjustment_cost',
        'current_cost',
        'coverage_amount',
        'insurance_amount',
        'vat_amount',
        'net_amount',
        'receivable_code',
        'receivable_name',
        'calculate_start_date',
        'calculate_end_date',
        'expense_flag',
        'premium_rate',
        'revenue_stamp',
        'prepaid_insurance',
        'tax',
        'line_type',
        'duty_amount',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
        'end_month_28_365',
        'end_month_29_366',
        'end_month_30_365',
        'end_month_30_366',
        'end_month_31_365',
        'end_month_31_366',
        'include_tax_flag',
    ];
    
    public function updateAssetLines($data)
    {
        $db = PtirAssetLines::find($data['line_id']);
        $db->status                    = $data['status'];
        $db->asset_status              = $data['asset_status'];
        $db->year                      = $data['year'];
        $db->insurance_start_date      = $data['insurance_start_date'];
        $db->insurance_end_date        = $data['insurance_end_date'];
        $db->policy_set_header_id      = $data['policy_set_header_id'];
        $db->policy_set_description    = $data['policy_set_description'];
        $db->department_location_code  = $data['department_location_code'];
        $db->department_location_desc  = $data['department_location_desc'];
        $db->department_cost_code      = $data['department_cost_code'];
        $db->department_cost_desc      = $data['department_cost_desc'];
        $db->account_id                = $data['account_id'];
        $db->account_code              = $data['account_code'];
        $db->account_code_desc         = $data['account_code_desc'];
        $db->asset_number              = $data['asset_number'];
        $db->department_code           = $data['department_code'];
        $db->department_name           = $data['department_name'];
        $db->location_id               = $data['location_id'];
        $db->location_code             = $data['location_code'];
        $db->location_name             = $data['location_name'];
        $db->category_code             = $data['category_code'];
        $db->category_description      = $data['category_description'];
        $db->adjustment_amount         = $data['adjustment_amount'];
        $db->adjustment_line_id        = $data['adjustment_line_id'];
        $db->adjustment_cost           = $data['adjustment_cost'];
        $db->current_cost              = $data['current_cost'];
        $db->line_type                 = $data['line_type'];
        $db->adjustment_source_type    = $data['adjustment_source_type'];
        $db->adjustment_amount    = $data['adjustment_amount'];
        $db->adjustment_date           = $data['adjustment_date'];
        $db->coverage_amount           = $data['coverage_amount'];
        $db->insurance_amount          = $data['insurance_amount'];
        $db->net_amount                = $data['net_amount'];
        $db->receivable_code           = $data['receivable_code'];
        $db->receivable_name           = $data['receivable_name'];
        $db->expense_flag              = $data['expense_flag'];
        $db->vat_amount                = $data['vat_amount'];
        $db->duty_amount               = $data['duty_amount'];
        $db->premium_rate              = $data['premium_rate'];
        $db->revenue_stamp             = $data['revenue_stamp'];
        $db->tax                       = $data['tax'];
        $db->prepaid_insurance         = $data['prepaid_insurance'];
        $db->last_updated_by           = $data['last_updated_by'];
        $db->updated_at                = $data['updated_at'];
        $db->last_update_date          = $data['last_update_date'];
        $db->save();
    }

    
}
