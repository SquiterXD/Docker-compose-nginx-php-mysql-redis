<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class MesSiloFinishTobaccoRec extends Model
{
    use HasFactory;

    protected $table  = 'MES_SILO_FINISH_TOBACCO_REC';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    public function scopeGetListBatchItems($query, $blendDate, $blendTimeMeridiem, $moisturePoints)
    {
        $query = $query->select(DB::raw("BATCHID ||':'|| NAME AS OPT_ID, BATCHID AS BATCH_ID, NAME AS MOISTURE_POINT, MIN(TIMESTAMP) AS BLEND_DATE, FEEDER_NAME"))
            ->whereNotNull("BATCHID")
            ->whereNotNull("FEEDER_NAME")
            ->where("SILO_PHASE_DESC","Silo Discharging")
            ->where("QUANTITY",">", 0)
            ->whereIn('NAME', $moisturePoints)
            ->whereRaw("TO_DATE(TO_CHAR(TIMESTAMP,'YYYY-MM-DD'),'YYYY-MM-DD') = TO_DATE('{$blendDate}','YYYY-MM-DD')");

        if($blendTimeMeridiem == "AM") {
            $query = $query->whereRaw("TO_TIMESTAMP(TO_CHAR(TIMESTAMP,'HH24:MI:SS'),'HH24:MI:SS') >= TO_TIMESTAMP('00:00:00','HH24:MI:SS') AND TO_TIMESTAMP(TO_CHAR(TIMESTAMP,'HH24:MI:SS'),'HH24:MI:SS') < TO_TIMESTAMP('12:00:00','HH24:MI:SS')");
        }
        if($blendTimeMeridiem == "PM") {
            $query = $query->whereRaw("TO_TIMESTAMP(TO_CHAR(TIMESTAMP,'HH24:MI:SS'),'HH24:MI:SS') >= TO_TIMESTAMP('12:00:00','HH24:MI:SS')");
        }
        
        $query = $query->groupBy('BATCHID', 'NAME', 'FEEDER_NAME')->orderByRaw('MIN(TIMESTAMP) DESC')->orderBy('BATCHID');

        return $query;
    }

    public function scopeGetListAllBatchItems($query, $searchBatchKeyword, $blendDateFrom, $blendDateTo)
    {

        $query = $query->select(DB::raw("BATCHID AS OPT_ID, BATCHID AS BATCH_ID, NULL AS MOISTURE_POINT, MIN(TIMESTAMP) AS BLEND_DATE, NULL AS FEEDER_NAME"))
            ->whereNotNull("BATCHID")
            ->whereNotNull("FEEDER_NAME")
            ->whereNotNull("NAME")
            ->where("SILO_PHASE_DESC","Silo Discharging")
            ->where("QUANTITY",">", 0);

        if($searchBatchKeyword) {
            $query->where('BATCHID', 'LIKE', "%{$searchBatchKeyword}%");
        }

        if($blendDateFrom) {
            $query = $query->whereRaw("TO_DATE(TO_CHAR(TIMESTAMP,'YYYY-MM-DD'),'YYYY-MM-DD') >= TO_DATE('{$blendDateFrom}','YYYY-MM-DD')");
        }
        if($blendDateTo) {
            $query = $query->whereRaw("TO_DATE(TO_CHAR(TIMESTAMP,'YYYY-MM-DD'),'YYYY-MM-DD') <= TO_DATE('{$blendDateTo}','YYYY-MM-DD')");
        }

        $query = $query->groupBy('BATCHID')->orderByRaw('MIN(TIMESTAMP) DESC')->orderBy('BATCHID');

        return $query;

    }

}
