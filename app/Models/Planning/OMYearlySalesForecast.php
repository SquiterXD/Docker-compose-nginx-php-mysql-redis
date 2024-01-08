<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OMYearlySalesForecast extends Model
{
    use HasFactory;
    protected $table = "PTOM_YEARLY_SALES_FORECAST";

    protected $appends = [
        'approve_date_format',
    ];

    public function getApproveDateFormatAttribute()
    {
        if ($this->approve_date) {
            return parseToDateTh($this->approve_date);
        }
        return '';
    }
}
