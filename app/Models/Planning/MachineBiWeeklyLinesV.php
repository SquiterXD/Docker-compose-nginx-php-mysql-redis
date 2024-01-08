<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineBiWeeklyLinesV extends Model
{
    use HasFactory;
    protected $table = "ptpp_machine_biweekly_lines_v";

    public function scopeSearch($q, $param)
    {
        if ($param) {
            $q->where('budget_year', $param['year_budget'])
                ->where('product_type', $param['product_type'])
                ->where('biweekly', $param['biweekly'])
                ->where('period_num', $param['month']);
        }
        return $q;
    }

    public function scopeWorkingDate($q, $biWeekly, $startDate = null, $endDate = null)
    {
        // current date
        $currDate = date('Y-m-d', strtotime('2021-10-08'));
        $st = date('Y-m-d', strtotime($biWeekly->start_date));
        $en = date('Y-m-d', strtotime($biWeekly->end_date));

        if ($currDate >= $st && $startDate == null) {
            $q->whereRaw("TRUNC(res_plan_date) > TO_DATE('{$currDate}','YYYY-mm-dd')");
        }elseif ($currDate >= $st && $currDate == $startDate && $endDate) {
            $q->whereRaw("TRUNC(res_plan_date) BETWEEN TO_DATE('{$currDate}','YYYY-mm-dd') AND TO_DATE('{$endDate}','YYYY-mm-dd')");
        }elseif ($currDate >= $st && $startDate && $endDate) {
            $q->whereRaw("TRUNC(res_plan_date) BETWEEN TO_DATE('{$startDate}','YYYY-mm-dd') AND TO_DATE('{$endDate}','YYYY-mm-dd')");
        }elseif ($currDate >= $st && $startDate && $endDate == null) {
            $q->whereRaw("TRUNC(res_plan_date) BETWEEN TO_DATE('{$startDate}','YYYY-mm-dd') AND TO_DATE('{$en}','YYYY-mm-dd')");
        }elseif ($currDate < $st && $startDate && $endDate) {
            $q->whereRaw("TRUNC(res_plan_date) BETWEEN TO_DATE('{$startDate}','YYYY-mm-dd') AND TO_DATE('{$endDate}','YYYY-mm-dd')");
        }elseif ($currDate < $st && $startDate && $endDate == null) {
            $q->whereRaw("TRUNC(res_plan_date) BETWEEN TO_DATE('{$startDate}','YYYY-mm-dd') AND TO_DATE('{$en}','YYYY-mm-dd')");
        }

        return $q;
    }
}
