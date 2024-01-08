<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirExpTypeCarGasView extends Model
{
    use HasFactory;
    protected $table = "ptir_exp_type_car_gas_v";

    public function getTypeCarGas($id, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirExpTypeCarGasView::select(DB::raw('distinct(lookup_code)'), 'meaning', 'description')
                                            ->whereRaw("lookup_code = nvl(?, lookup_code)
                                                        and (meaning like ? or description like ?)",
                                                        [$id, $keyword, $keyword])
                                            ->orderBy('meaning', 'asc')
                                            ->get();

        return $collection;                                            
    }
}
