<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirSubGroupView extends Model
{
    use HasFactory;
    protected $table = "ptir_sub_group_v";
    public $primaryKey = 'sub_group_id';
    public $timestamps = false;

    public function getAllSubGroupCode($policyId, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirSubGroupView::select('sub_group_code', 'sub_group_description', 'policy_set_description')
                                        ->whereRaw("policy_set_header_id = nvl(?, policy_set_header_id)
                                                    and (sub_group_code like ? or sub_group_description like ?)", [$policyId, $keyword, $keyword])
                                        ->groupBy('sub_group_code', 'sub_group_description', 'policy_set_description')
                                        ->orderBy('sub_group_code', 'asc')
                                        ->get();

        return $collection;
    }
}
