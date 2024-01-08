<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirPolicyCategoryView extends Model
{
    use HasFactory;

    protected $table = "ptir_policy_category_v";
    public $timestamps = false;

    private $limit = 50;

    public function getAllPolicyCategory($id)
    {
        $collection = PtirPolicyCategoryView::select('lookup_code', 'meaning', 'description')
                                            ->whereRaw('lookup_code = nvl(?, lookup_code)', [$id])
                                            ->orderBy('lookup_code', 'asc')
                                            ->get();

        return $collection;
    }
}
