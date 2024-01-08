<?php
namespace App\Models\PD\ExpFmls\Traits;

trait Scope {

    public function scopeSearchBlendOrFormula($query, $blendNo = '', $formulaId = '')
    {
        $query->where(function($q) use ($blendNo, $formulaId) {
                if ($formulaId) {
                    $q->where('formula_id', $formulaId);
                } else {
                    $q->where('blend_no', $blendNo);
                }
            });
        return $query;
    }
}