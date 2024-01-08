<?php

namespace App\Models\IR;

use App\Models\IR\Views\PtirAssetGroupView;
use App\Models\IR\Views\PtirUomView;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\IR\PtirStockHeaders;
use App\Models\IR\Views\PtirStockLinesView;
use App\Models\IR\Settings\PtirPolicySetHeaders;
use App\Models\IR\Settings\PtirPolicyGroupSets;
use App\Models\IR\Settings\PtirPolicyGroupDists;
use App\Models\Lookup\PtpmItemNumberVLookup;
use App\Models\PM\MtlUnitsOfMeasureTl;
use App\Models\OrgOrganizationDefinition;


class PtirStockLines extends Model
{
    use HasFactory;
    protected $table = "ptir_stock_lines";
    public $primaryKey = 'line_id';
    public $timestamps = false;
    private $limit = 50; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'header_id',
        'line_number',
        'status',
        'year',
        'period_name',
        'period_from',
        'period_to',
        'policy_set_header_id',
        'policy_set_description',
        'department_code',
        'department_description',
        'org_id',
        'sub_inventory_code',
        'sub_inventory_desc',
        'location_code',
        'location_desc',
        'organization_id',
        'organization_code',
        'item_id',
        'item_code',
        'item_description',
        'uom_code',
        'original_quantity',
        'unit_price',
        'line_amount',
        'coverage_amount',
        'calculate_start_date',
        'calculate_end_date',
        'calculate_days',
        'line_type',
        'invent_creation_date',
        'invent_creation_by_id',
        'invent_creation_by_name',
        'item_exp_account_id',
        'item_exp_account',
        'expense_flag',
        'premium_rate',
        'revenue_stamp',
        'prepaid_insurance',
        'tax',
        'asset_group_code',
        'stock_list_description',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
    ];

    public function updateStockLines($data)
    {
        $db = PtirStockLines::find($data['line_id']);
        $db->status                = $data['status'];
        $db->year                  = $data['year'];
        $db->period_name           = $data['period_name'];
        $db->period_from           = $data['period_from'];
        $db->period_to             = $data['period_to'];
        $db->policy_set_header_id  = $data['policy_set_header_id'];
        $db->policy_set_description = $data['policy_set_description'];
        $db->department_code       = $data['department_code'];
        $db->department_description = $data['department_description'];
        $db->org_id                = $data['org_id'];
        $db->sub_inventory_code    = $data['sub_inventory_code'];
        $db->sub_inventory_desc    = $data['sub_inventory_desc'];
        $db->location_code         = $data['location_code'];
        $db->location_desc         = $data['location_desc'];
        $db->item_id               = $data['item_id'];
        $db->item_code             = $data['item_code'];
        $db->item_description      = $data['item_description'];
        $db->uom_code              = $data['uom_code'];
        $db->original_quantity     = $data['original_quantity'];
        $db->unit_price            = $data['unit_price'];
        $db->line_amount           = $data['line_amount'];
        $db->coverage_amount       = $data['coverage_amount'];
        $db->calculate_start_date  = $data['calculate_start_date'];
        $db->calculate_end_date    = $data['calculate_end_date'];
        $db->calculate_days        = $data['calculate_days'];
        $db->line_type             = $data['line_type'];
        $db->invent_creation_date  = $data['invent_creation_date'];
        $db->invent_creation_by_id = $data['invent_creation_by_id'];
        $db->invent_creation_by_name = $data['invent_creation_by_name'];
        $db->organization_id       = $data['organization_id'];
        $db->organization_code     = $data['organization_code'];
        $db->item_exp_account_id   = $data['item_exp_account_id'];
        $db->item_exp_account      = $data['item_exp_account'];
        $db->expense_flag          = $data['expense_flag'];
        $db->premium_rate          = $data['premium_rate'];
        $db->revenue_stamp         = $data['revenue_stamp'];
        $db->prepaid_insurance     = $data['prepaid_insurance'];
        $db->tax                   = $data['tax'];
        $db->asset_group_code      = $data['asset_group_code'];
        $db->stock_list_description= $data['stock_list_description'];
        $db->updated_at            = $data['update_at'];
        $db->last_updated_by       = $data['last_updated_by'];
        $db->last_update_date      = $data['last_update_date'];
        $db->save();
    }

    public function ptirStockHeader()
    {
        return $this->belongsTo(PtirStockHeaders::class, 'header_id', 'header_id');
    }


    public function lineView()
    {
        return $this->belongsTo(PtirStockLinesView::class, 'line_id', 'line_id');
    }

    public function ptirPolicySetHeader()
    {
        return $this->belongsTo(PtirPolicySetHeaders::class, 'policy_set_header_id', 'policy_set_header_id');
    }

    public function ptirPolicyGroupSet()
    {
        return $this->belongsTo(PtirPolicyGroupSets::class, 'policy_set_header_id', 'policy_set_header_id');
    }

    public function itemNumberV()
    {
        return $this->belongsTo(PtpmItemNumberVLookup::class,'item_code', 'item_number');
    }

    public function uom()
    {
        return $this->belongsTo(MtlUnitsOfMeasureTl::class,'uom_code', 'uom_code');
    }

    public function interestRate($policyLine, $rate=null)
    {
        // $rate = 100*0.01;
        if ($rate == null) {
            $rate = 100*0.01;
        }
        // (62,600.00 * (0.0849 * 0.01)) * 100% * 50%

        if ($this->line_type == 'INVENTORY') {
            $total = ($this->coverage_amount* ($policyLine->premium_rate * 0.01)) * $rate * (50*0.01);
            // $total = (($this->coverage_amount *  $policyLine->premium_rate) * (1)) * ($rate* $policyLine->prepaid_insurance*0.01);
            // dd($total , $policyLine->coverage_amount,  $policyLine->premium_rate);

            return $total;
        }
        // (62,600.00 * (0.0849 * 0.01)) * 150/365 * 100% * 50%
        $total = ($this->coverage_amount* ($policyLine->premium_rate * 0.01)) * ($this->calculate_days / 365) * $rate * (50*0.01);
        // $total = ($this->coverage_amount *  $policyLine->premium_rate) * ($this->calculate_days / 365) * ($rate* $policyLine->prepaid_insurance*0.01);
        return $total;
    }

    public function organizationView()
    {
        return $this->belongsTo(OrgOrganizationDefinition::class, 'organization_code', 'organization_code');
    }

    public function assetGroupView()
    {
        return $this->belongsTo(PtirAssetGroupView::class, 'asset_group_code', 'meaning');
    }

}
