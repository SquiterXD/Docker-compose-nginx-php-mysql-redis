<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockBalanceReport extends Model
{
    use HasFactory;

    protected $table = "oair.ptir_stock_balance_report";

    public function policyType()
    {
        return $this->belongsTo('App\Models\IR\Views\PtirPolicyTypeView', 'policy_type_code', 'lookup_code');
    }

    public function stocklines()
    {
        return $this->belongsTo(PtirStockLines::class, 'document_line_id', 'line_id');
    }
}
