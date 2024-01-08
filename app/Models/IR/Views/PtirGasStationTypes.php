<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirGasStationTypes extends Model
{
    use HasFactory;
    protected $table = "ptir_gas_station_types";
    public $timestamps = false;

    private $limit = 50;

    /**
     * Lov search gas station type
     */
    public function getGasStaionsTypeLov($keyword)
    {
        $keyword            = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtirGasStationTypes::select('lookup_code', 'meaning', 'description')
                                         ->where('description', 'like', $keyword)
                                         ->where('enabled_flag', 'Y')
                                         ->take($this->limit)
                                         ->orderBy('lookup_code', 'asc')
                                         ->get();

        return $collection;
    }
}
