<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PtBiweeklyView extends Model
{
    protected $table = "pt_biweekly_v";

    private $limit = 50;

     /**
     * Get all budget detail 
     */
    public function getYear($periodName)
    {
        $collection = PtBiweeklyView::select(DB::raw("to_number(thai_year)-543 period_year, period_year period_year2"))
					    ->whereRaw("to_char(to_date(period_name, 'Mon-yy'), 'mm/yyyy') = ?", $periodName)
                                            ->first();

        return $collection;
    }


    public function getDate($year) {
        $collection = PtBiweeklyView::select(DB::raw("to_char(start_date, 'dd/mm/yyyy') start_date, to_char(end_date, 'dd/mm/yyyy') end_date"))
                                    ->where('period_year', $year)
                                    ->first();

        return $collection;
    }
}
