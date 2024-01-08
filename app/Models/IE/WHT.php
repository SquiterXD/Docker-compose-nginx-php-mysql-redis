<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class WHT extends Model
{
    protected $table = "PTIE_WHTS_V";
    public $primaryKey = 'pay_awt_group_id';

    public function scopeActive($q)
    {
        return $q->where(function($p){
            return $p->whereNull('inactive_date')
            ->orWhere('inactive_date', '>=', \Carbon\Carbon::today());
        })->where(function($p){
            return $p->whereNull('end_date')
            ->orWhere(function($r){
                return $r->where('start_date', '<=', \Carbon\Carbon::today())
                ->where('end_date', '>=', \Carbon\Carbon::today());
            });
        });
    }
}