<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirExpTypeAssetStockView extends Model
{
    use HasFactory;
    protected $table = "ptir_exp_type_asset_stock_v";

    public function getTypeAssetStock($id, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirExpTypeAssetStockView::select('lookup_code', 'meaning', 'description')
                                                ->whereRaw("lookup_code = nvl(?, lookup_code)
                                                            and meaning like ? or description like ?", 
                                                            [$id, $keyword, $keyword])
                                                ->orderBy('meaning', 'asc')
                                                ->get();
                                                        
        return $collection;                                    
    }
}
