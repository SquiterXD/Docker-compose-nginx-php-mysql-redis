<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiweeklyPeriod extends Model
{
    use HasFactory;
    protected $table = "ptom_biweekly_periods";


    // public function biWeekly()
    // {
    //     return $this->hasOne(BiWeeklyV::class, 'biweekly_id', 'biweekly_id');
    // }
    // om_biweekly_id
}
