<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLBalance extends Model
{
    use HasFactory;
    protected $table        = 'gl_balances';
    protected $connection   = 'oracle';

    public function getPeriodAdjust($year)
    {
        $glBalance = self::where('period_year', $year)
                        ->where('period_num', 13)
                        ->first();

        $periodName = optional($glBalance)->period_name ?? '';
        return $periodName;
    }
}
