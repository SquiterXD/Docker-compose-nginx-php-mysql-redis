<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirExpenseStockAssets extends Model
{
    use HasFactory;
    protected $table = "ptir_expense_stock_assets";
    public $primaryKey = 'expense_id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        // 'document_number',
        'document_header_id',
        'document_line_id',
        'expense_type_code',
        'policy_set_header_id',
        'policy_set_description',
        'group_code',
        'department_code',
        'department_name',
        'sector_code',
        'sector_name',
        'asset_id',
        'asset_number',
        'insurance_premium',
        'expense_account_id',
        'expense_account',
        'expense_account_desc',
        'prepaid_account_id',
        'prepaid_account',
        'prepaid_account_desc',
        'coverage_amount',
        'insurance_amount',
        'coverage_amount_cal',
        'insurance_amount_cal',
        'net_amount',
        'expense_flag',
        'reference_header_id',
        'reference_line_id',
        'reference_document_number',
        'document_header_id2',
        'document_line_id2', 
        'period_name',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
    ]; 

    public static function duplicateCheck($id, $type)
    {
        $collection = PtirExpenseStockAssets::where('document_line_id', $id)
                                            ->where('expense_type_code', $type)
                                            ->first();

        if ($collection == null) 
        {
            return true;
        }

        return false;
    }

    public function scopeSearch($q, $param, $period_name)
    {
        if ($param) {
            if ($param->period_name) {
                $q->where('period_name', $period_name);
            }

            if ($param->insurance_type) {
                $q->where('expense_type_code', $param->insurance_type);
            }

            if ($param->expense_type) {
                // $q->where('prepaid_account_id', $param->expense_type);
                $q->where('group_code', $param->expense_type);
            }
        }
        return $q;
    }

    public function typeAssetStock()
    {
        return $this->hasOne('App\Models\IR\Views\PtirExpTypeAssetStockView', 'lookup_code', 'expense_type_code');
    }

    public function policy()
    {
        return $this->hasOne('App\Models\IR\Settings\PtirPolicySetHeaders', 'policy_set_header_id', 'policy_set_header_id');
    }

    public function group()
    {
        return $this->hasOne('App\Models\IR\Views\PtirGroupsView', 'lookup_code', 'group_code');
    }

    public function getExpenseTypeDescAttribute()
    {
        return optional($this->typeAssetStock)->description;
    }

    public function getPolicySetNumberAttribute()
    {
        return optional($this->policy)->policy_set_number;
    }

    public function getGroupNameAttribute()
    {
        return optional($this->group)->meaning;
    }
}