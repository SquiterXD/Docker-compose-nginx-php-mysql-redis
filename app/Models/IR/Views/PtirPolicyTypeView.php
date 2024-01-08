<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirPolicyTypeView extends Model
{
    use HasFactory;

    protected $table = "ptir_policy_type";
    public $timestamps = false;

    private $limit = 50;

    public function getPolicyTypeLov()
    {
        $collection = PtirPolicyTypeView::select('lookup_code as policy_type_code', 'meaning', 'description as policy_type_description')
                                         ->orderBy('lookup_code', 'asc')
                                         ->get();

        return $collection;
    }
}
