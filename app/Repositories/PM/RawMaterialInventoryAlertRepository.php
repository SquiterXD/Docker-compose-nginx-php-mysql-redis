<?php

namespace App\Repositories\PM;

use App\Models\PM\PtpmOnhandNotice;
// use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB ;

class RawMaterialInventoryAlertRepository
{
    function getList($params)
    {
        $items = PtpmOnhandNotice::with(['uomV', 'uomVP'])
            ->where('organization_code', 'M12')
            // ->where('concatenated_segments','RESBKK01.ZONE01')
            ->when(!empty($params['concatenated_segments']), function ($item) use($params){
                return $item->where('concatenated_segments', $params['concatenated_segments']);
            })
            ->where('subinventory_code',  'RESBKK01')
            // ->where('organization_code', $params['organization_code'])
            // ->where('subinventory_code',  $params['subinventory_code'])
            // ->where('concatenated_segments', $params['locator_code'])
            ->where('item_type', 'RM');
        if(@$params['selectBox'] === true) {
            $items->select(DB::raw("distinct inventory_item_id as value,segment1, description , segment1 || ' : '  || description as label"));
        }
        $items = $items->get();

        return $items;
    }
}
