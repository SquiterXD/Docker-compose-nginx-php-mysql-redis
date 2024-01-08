<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\QM\PtqmSpecificationV;

use DB;

class FndLookupValue extends Model
{
    use HasFactory;

    protected $table  = 'FND_LOOKUP_VALUES';

    public static function getGmdQcSampleDisp() {

        $sampleDisps = self::select(DB::raw('nvl(tag,description),lookup_code'))
            ->where('lookup_type', 'GMD_QC_SAMPLE_DISP')
            ->get();
        return $sampleDisps;

    }

    public function scopeGetListLeakPositions($query) {

        return $query->select(DB::raw('lookup_code as position_leak_value, meaning as position_leak_label, lookup_code, meaning, description'))
            ->where('lookup_type', 'PTQM_LEAK_POSITION_PACK_FILM')
            ->orderBy('meaning');

    }

}
