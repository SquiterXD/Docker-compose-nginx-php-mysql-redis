<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineBiWeeklyHeaderV extends Model
{
    use HasFactory;
    protected $table = "ptpp_machine_biweekly_head_v";
    public $primaryKey = 'res_plan_h_id';
    protected $appends = [
        'created_at_format',
        'updated_at_format'
    ];

    public function scopeSearch($q, $param, $biWeekly)
    {
        if ($param) {
            if (array_key_exists('product_type', $param)) {
                if ( $param['product_type'] != null || $param['product_type'] != '') {
                    $q->where('product_type', $param['product_type']);
                }
                $q;
            }else{
                $q;
            }

            $q->where('budget_year', $biWeekly->period_year_thai)
                ->where('period_num', $param['month'])
                ->where('biweekly', $param['bi_weekly']);
        }

        return $q;
    }

    public function scopeSearchDaily($q, $param)
    {
        if ($param) {
            //get biWeekly
            $biWeekly = BiWeeklyV::getBiWeeklyPlan($param)->first();
            $q->where('biweekly_id', optional($biWeekly)->biweekly_id);
            return $q;
        }
        return $q;
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by_id');
    }

    public function ppBiWeekly()
    {
        return $this->hasOne(BiWeeklyV::class, 'biweekly_id', 'biweekly_id');
    }

    public function ptBiWeekly()
    {
        return $this->hasOne(PtBiweeklyV::class, 'biweekly_id', 'biweekly_id');
    }

    public function getWithData($resPlanId)
    {
        return (new self)->with(['ptBiWeekly', 'ppBiWeekly', 'createdBy', 'updatedBy'])->where('res_plan_h_id', $resPlanId)->first();
    }

    public function getCreatedAtFormatAttribute()
    {
        return parseToDateTh($this->created_at);
    }

    public function getUpdatedAtFormatAttribute()
    {
        return parseToDateTh($this->updated_at);
    }
}
