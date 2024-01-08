<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirAssetReceivableChargeView extends Model
{
    use HasFactory;
    protected $table = "ptir_asset_receivable_charge_v";
    public $primaryKey = 'line_id';
    public $timestamps = false;

    private $limit = 50;

    public function getAllAssetReceivableCharge($id, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirAssetReceivableChargeView::select('value', 'meaning', 'description')
                                                    ->whereRaw('meaning = nvl(?, meaning)
                                                                and description like ?', [$id, $keyword])
                                                    ->take($this->limit)
                                                    ->orderBy('meaning', 'asc')
                                                    ->get();
                                                
        return $collection;
    }
}
