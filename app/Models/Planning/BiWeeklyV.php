<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiWeeklyV extends Model
{
    use HasFactory;
    protected $table = "ptpp_biweekly_v";
    public $primaryKey = 'biweekly_id';

    public function scopeGetBiWeeklyPlan($q, $param)
    {
        if ($param) {
            if ($param['budget_year']) {
                $q->where('period_year_thai', $param['budget_year']);
            }else{
                $q;
            }

            if ($param['month']) {
                $q->where('period_num', $param['month']);
            }else{
                $q;
            }

            if ($param['bi_weekly']) {
                $q->where('biweekly', $param['bi_weekly']);
            }else{
                $q;
            }
            return $q;
        }
        return $q;
    }

    public function scopePlanDaily($q, $productBiweekly)
    {
        if ($productBiweekly) {
            $q->where('biweekly_id', $productBiweekly->machine_biweekly_id);
        }
        return $q;
    }

    public function getMonthDetail($budgetYear)
    {
        $data = collect(\DB::select("
                with pp_biweekly_v as (
                    select min(start_date) min_start_date, max(end_date) max_end_date, period_year_thai, period_year, period_num, thai_month
                    from ptpp_biweekly_v
                    where period_year_thai = '{$budgetYear}'
                    group by period_year_thai, period_year, period_num, thai_month, period_year_thai
                )
                select min_start_date
                    , max_end_date
                    , period_year_thai thai_year
                    , period_year
                    , period_num
                    , thai_month
                    , TO_CHAR(to_date(min_start_date), 'DD', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI')
                        ||'-'||TO_CHAR(to_date(max_end_date), 'DD', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI')
                        ||' '||TRIM(TO_CHAR(to_date(min_start_date), 'MONTH', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI'))
                        ||' '||TO_CHAR(to_date(min_start_date), 'RRRR', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') thai_full_date
                from pp_biweekly_v
            "));

        return $data;
    }

    public function getDateByMonth($budgetYear, $month)
    {
        $budgetYear = $budgetYear-543;
        $data = self::selectRaw('min(start_date) start_date, max(end_date) end_date, period_year_thai thai_year, period_year, period_num, thai_month')
                            ->where('period_year', $budgetYear)
                            ->where('period_num', $month)
                            ->groupBy('period_year_thai', 'period_year', 'period_num', 'thai_month')
                            ->first();
        return $data;
    }
}