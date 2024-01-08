<?php

namespace App\Models\OM\Saleorder\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiWeeklyPeriodsModel extends Model
{
    use HasFactory;

    protected $table = 'PTOM_BIWEEKLY_PERIODS';
    public $primaryKey = 'BIWEEKLY_ID';
    public $timestamps = false;
}
