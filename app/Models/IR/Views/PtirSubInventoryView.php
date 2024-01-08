<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirSubInventoryView extends Model
{
    use HasFactory;
    protected $table = "ptir_subinventory_v";
    public $timestamps = false;

    public function getAllSubInventory($orgId, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirSubInventoryView::select('subinventory_code', 'subinventory_desc')
                                          ->whereRaw("organization_id = nvl(?, organization_id)
                                                      and (subinventory_code like ? or subinventory_desc like ?)", [$orgId, $keyword, $keyword])
                                          ->orderBy('subinventory_code', 'asc')
                                          ->get();

        return $collection;
    }
}
