<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Model;

class PtirCalculateInsurances extends Model
{
    protected $table = "PTIR_CALCULATE_INSURANCES";
    public $primaryKey = 'calculate_id';

    public function policy()
    {
        return $this->belongsTo('App\Models\IR\Settings\PtirPolicySetHeaders', 'policy_set_header_id')->orderBy('policy_set_header_id');
    }

    public function header()
    {
        return $this->belongsTo('App\Models\IR\PtirStockHeaders', 'header_id')->orderBy('header_id');
    }

    public function line()
    {
        return $this->belongsTo('App\Models\IR\PtirStockLines', 'line_id')->orderBy('line_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\IR\Settings\PtirCompanies', 'company_code', 'company_number')->orderBy('company_number');
    }

    public function assetGroup()
    {
        return $this->belongsTo('App\Models\IR\Settings\AssetGroupV', 'asset_group_code', 'value')->orderBy('value');
    }
}
