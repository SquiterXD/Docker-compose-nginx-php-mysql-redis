<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachinePowerTemp extends Model
{
    use HasFactory;
    
    protected $table = "ptpm_machine_power_temp";
    public $primaryKey = false;
    public $timestamps = false;
    public $incrementing = false;

    public function uomV()
    {
        return $this->hasOne(PtinvUomV::class, 'uom_code', 'uom');
    }
}
