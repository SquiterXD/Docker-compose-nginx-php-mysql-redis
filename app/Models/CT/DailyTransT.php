<?php

namespace App\Models\ct;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PtglCoaDeptCodeV;
use App\Models\CT\PtctCostCenter;

class DailyTransT extends Model
{
    use HasFactory;
    protected $table = 'PTCT_DAILY_TRANS_T';

    public function PtglCoaDeptCodeV(){
        return $this->hasMany(PtglCoaDeptCodeV::class,'department_code','dept_code');
    }
    public function PtctCostCenter(){
        return $this->hasMany(PtctCostCenter::class,'cost_code','cc_code');
    }
}
