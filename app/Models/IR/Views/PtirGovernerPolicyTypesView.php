<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirGovernerPolicyTypesView extends Model
{
    use HasFactory;
    protected $table = "ptir_governer_policy_types";
    public $timestamps = false;

    public function getAllGovernerPolicyType($keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirGovernerPolicyTypesView::select('lookup_code', 'description', 'tag')
                                                  ->where('description', 'like', $keyword)
                                                  ->orderBy('lookup_code', 'asc')
                                                  ->get();

        return $collection;
    }
}
