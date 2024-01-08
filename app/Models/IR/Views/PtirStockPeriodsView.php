<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PtirStockPeriodsView extends Model
{
    use HasFactory;
    protected $table = "ptir_stock_periods_v";
    public $primaryKey = 'application_id';
    public $timestamps = false;

    private $limit = 50;

    public function getPeriodsLov()
    {
        $collection = PtirStockPeriodsView::select('period_name', DB::raw("to_char(add_months(period_from, 6515), 'mm/yyyy') as period_from , 
                                                    to_char(add_months(period_to, 6515), 'mm/yyyy') as period_to "))
                                           ->orderBy('period_name', 'asc')
                                           ->get();

        return $collection;
    }
}
