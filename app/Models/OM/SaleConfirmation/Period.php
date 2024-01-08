<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $table = 'PTOM_PERIOD_V';
    public $primaryKey = 'PERIOD_LINE_ID';
    public $timestamps = false;


}
