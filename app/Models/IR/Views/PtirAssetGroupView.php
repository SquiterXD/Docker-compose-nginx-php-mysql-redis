<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirAssetGroupView extends Model
{
    use HasFactory;
    protected $table = "ptir_asset_group_v";
    public $timestamps = false;

    public function getGroup($id, $keyword)
    {
	    $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection =  PtirAssetGroupView::select('value', 'meaning', 'description')
                                                ->whereRaw('meaning = nvl(?, meaning)
                                                            and (meaning like ? or description like ?)', [$id, $keyword, $keyword])
                                                ->orderBy('meaning', 'asc')
                                                ->get();

        return $collection;
    }

    public function getGroupByProduct($id, $keyword, $policy_set_header_id)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection =  PtirAssetGroupView::select('value', 'meaning', 'description')
            ->whereRaw('meaning = nvl(?, meaning)
                and (meaning like ? or description like ?)
                and value in 
                    (select asset_group_code 
                    from ptir_group_products 
                    where policy_set_header_id = nvl(?, policy_set_header_id))', 
            [$id, $keyword, $keyword, $policy_set_header_id])
            ->orderBy('meaning', 'asc')
            ->get();

        return $collection;
    }
}
