<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltyRateDomesticV extends Model
{
    use HasFactory;
    protected $table = "PTOM_PENALTY_RATE_DOMESTIC_V";
    public $primaryKey = 'lookup_code';
    public $timestamps = false;
}
