<?php

namespace App\Http\Controllers\OM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\ItemGroup;
use App\Models\OM\Settings\ItemV;

use App\Models\OM\Settings\SequenceEcom;

class SequenceEcomItemController extends Controller
{
    public function getItemCate()
    {
        // dd('getItemCate', request()->all());
        $data = ItemGroup::where('categorys', request()->item_category)->get();

        // dd(request()->all(), $data);
        return response()->json($data);
    }
    public function getItem()
    {
        // dd('getItem', request()->all());
        // $text  = request()->get('query');
        $text = strtoupper(request()->get('query'));

        if (request()->item_category) {
            $data = ItemV::where('categorys', request()->item_category)
                            ->where('groups', request()->item_group)
                            ->when($text, function ($query, $text) {
                                return $query->where(function($r) use ($text) {
                                    $r->where('item_code', 'like', "%${text}%")
                                    ->orWhere('inventory_item_id', 'like', "%${text}%")
                                    ->orWhereRaw('UPPER(item_description)  like ?', "%{$text}%");
                                        // ->orWhere('item_description', 'like', "${text}%");
                                });
                            })
                            ->orderBy('item_code')
                            ->limit(30)
                            ->get();

        }else {
            $data = ItemV::when($text, function ($query, $text) {
                    return $query->where(function($r) use ($text) {
                        $r->where('item_code', 'like', "%${text}%")
                        ->orWhere('inventory_item_id', 'like', "%${text}%")
                        ->orWhereRaw('UPPER(item_description)  like ?', "%{$text}%");
                    });
                })
                ->orderBy('item_code')
                ->limit(30)
                ->get();       
        }

        return response()->json($data);
    }

    public function getItemSearch()
    {
        $salesType   = request()->sales_type;
        $productType = request()->product_type;


        $data = SequenceEcom::when($salesType, function($q) use($salesType){
                            $q->where('sale_type_code', $salesType);
                        })->when($productType, function($q) use($productType){
                            $q->where('product_type_code', $productType);
                        })->get()->unique('item_code');
        // dd(request()->all(), $data);

        return response()->json($data);
    }
}
