<?php

namespace App\Models\OM\Saleorder\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodModel extends Model
{
    use HasFactory;
    protected $table = 'PTOM_PERIOD_V';
    public $timestamps = false;
}
