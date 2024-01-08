<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;

class PtirBudgetYearsView extends Model
{
    protected $table = "ptir_budget_years_v";

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('selectedColumn', function ($builder) {
            $builder->selectRaw("
                 to_char(bef_start_date, 'mm/yyyy', 'nls_calendar=''thai buddha'' nls_date_language=thai') bef_month_th_format
                , to_char(start_date, 'mm/yyyy', 'nls_calendar=''thai buddha'' nls_date_language=thai') month_th_format
                , ptir_budget_years_v.*
            ");
        });
    }
}
