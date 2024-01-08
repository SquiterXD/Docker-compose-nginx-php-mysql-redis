<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtglPeriodV extends Model
{
    use HasFactory, Notifiable;

    // protected $table = "ptgl_period_v";
    protected $table = "PT_YEARS_V";

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('selectcolumn', function ($builder) {
            $builder->select(
                'year_thai as period_year',
            )->orderBy('period_year');
        });
    }
}
