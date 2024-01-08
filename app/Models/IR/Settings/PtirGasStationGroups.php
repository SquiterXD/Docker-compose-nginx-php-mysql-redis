<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirGasStationGroups extends Model
{
    use HasFactory;
    protected $table = "ptir_gas_station_groups";
    public $primaryKey = 'lookup_code';
    public $timestamps = false;

    private $limit = 50;

    /**
     * Lov search gas station type
     */
    public function getGasStaionGroupsLov()
    {
        $collection = PtirGasStationGroups::select('lookup_code', 'meeaning', 'description')
                                            ->orderBy('lookup_code', 'asc')
                                            ->get();

        return $collection;
    }
}
