<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class GlPeriodYearView extends Model
{
    protected $table = "gl_periods_v";

    private $limit = 50;

     /**
     * Get all budget detail 
     */
    public function getYear($periodName)
    {
        $collection = GlPeriodYearView::select('period_year')
					                    ->whereRaw("period_name = to_char(to_date(?, 'mm/yyyy'), 'Mon-yy')", $periodName)
                                        ->first();

        return $collection;
    }

    public function getByYear($year) {
        $data = GlPeriodYearView::select('start_date', 'end_date')
                                ->where('period_year', $year)
                                ->first();
        return $data;
    }
}
