<?php
use App\Models\PM\PtpmItemNumberV;

function getUomDesc($data)
{
    $item  = PtpmItemNumberV::whereIn('user_item_type', ['Raw Material', 'Semi Finished Goods'])
                ->where('organization_code', $data->organization_code)
                ->where('inventory_item_id', $data->ingredient_item_id)
                ->first();

    if ($item) {
        return $item->primary_unit_of_measure;
    }else {
        return null;
    }

    // dd($data->org_id, $item);
}

function showNumber($value, $decimal = 2)
{
    list($integer, $fraction) = explode(".", (string)number_format($value, $decimal));

    return $fraction != str_pad('', $decimal, '0', STR_PAD_LEFT) ? number_format($value, $decimal) : number_format($value);
}