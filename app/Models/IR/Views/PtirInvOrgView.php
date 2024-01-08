<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirInvOrgView extends Model
{
    use HasFactory;
    protected $table = "ptir_inv_org_v";
    public $primaryKey = 'organization_id';
    public $timestamps = false;

    public function getAllOrg($keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirInvOrgView::select('organization_id', 'organization_code', 'organization_name')
                                    ->whereRaw("organization_code like ? or organization_name like ?", 
                                               [$keyword, $keyword]) 
                                    ->orderBy('organization_code', 'asc')
                                    ->get();

        return $collection;
    }
}
