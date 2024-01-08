<?php

namespace App\Models\IR;

use App\Models\IR\Settings\PtirCustomerView;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirStockSummaryView extends Model
{
    use HasFactory;
    protected $table = "ptir_stock_summary_v";
    public $primaryKey = 'header_id';
    public $timestamps = false;

    private $limit = 50;

    // public function getStockYearLov()    
    // {
        // $collection = PtirCustomerView::select()
    // }

    public function getAllStockSummary($year, $policyId, $status)
    {
        $collection = PtirStockSummaryView::select('document_number', 'status', 'period_year', 'period_name',
                                                   'period_from', 'period_to', 'policy_set_header_id',
                                                   'policy_set_desciption', 'department_code', 'department_desc')
                                           ->where('period_year', 'like', $year) 
                                           ->where('policy_set_header_id', 'like', $policyId)
                                           ->where('status', 'like', $status)
                                        //    ->where('per')
                                           ->get();

        return $collection;
        
    }
}
