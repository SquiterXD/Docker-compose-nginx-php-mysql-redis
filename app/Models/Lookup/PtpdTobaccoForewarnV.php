<?php

namespace App\Models\PD\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TobaccoForewarnV extends Model
{
    use HasFactory;

    protected $table  = 'ptpd_tobacco_forewarn_v';

    public function ohhandTobaccoForewarn() 
    {
        return $this->hasOne(OhhandTobaccoForewarn::class, 'inventory_item_id' ,'inventory_item_id');
    }
}
