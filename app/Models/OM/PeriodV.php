<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodV extends Model
{
    use HasFactory;
    protected $table = "PTOM_PERIOD_V";
    public $primaryKey = 'period_id';
    public $timestamps = false;
}