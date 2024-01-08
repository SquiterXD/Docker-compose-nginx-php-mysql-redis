<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodBalanceV extends Model
{
    use HasFactory;
    protected $table        = 'ptbg_period_balance_v';
    protected $connection   = 'oracle';

    // support get period year form biweekly
    public function getPeriodYear($period)
    {
        //pt_biweekly_v @UAT2DEV2
        $biweekly = \App\Models\Budget\GLPeriodV::selectRaw('period_year, period_num')
                        ->where('period_name', $period)
                        ->first();

        $periodYear = optional($biweekly)->period_year ?? '';
        $periodNum = optional($biweekly)->period_num ?? '';
        return ['year' => $periodYear, 'month' => $periodNum];
    }
}
