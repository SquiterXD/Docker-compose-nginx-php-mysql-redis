<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtmesTobaccoMoistureTrx extends Model
{
    use HasFactory;

    protected $table  = 'PTMES_TOBACCO_MOISTURE_TRX';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;


    public function scopeGetListBatchItems($query, $blendDate, $blendTimeMeridiem, $moisturePoints)
    {
        $query = $query->select(DB::raw("BATCH_ID ||':'|| MOISTURE_POINT AS OPT_ID, BATCH_ID, MOISTURE_POINT, MIN(CREATED_AT) AS BLEND_DATE, NULL AS FEEDER_NAME"))
                ->whereNotNull("BATCH_ID")
                ->whereRaw("LENGTH(BATCH_ID) < 30")
                ->where("MOISTURE_VALUE",">=", 1)
                ->whereIn('MOISTURE_POINT', $moisturePoints)
                ->whereRaw("TO_DATE(TO_CHAR(CREATED_AT,'YYYY-MM-DD'),'YYYY-MM-DD') = TO_DATE('{$blendDate}','YYYY-MM-DD')");

        if($blendTimeMeridiem == "AM") {
            $query = $query->whereRaw("TO_TIMESTAMP(TO_CHAR(CREATED_AT,'HH24:MI:SS'),'HH24:MI:SS') >= TO_TIMESTAMP('00:00:00','HH24:MI:SS') AND TO_TIMESTAMP(TO_CHAR(CREATED_AT,'HH24:MI:SS'),'HH24:MI:SS') < TO_TIMESTAMP('12:00:00','HH24:MI:SS')");
        }
        if($blendTimeMeridiem == "PM") {
            $query = $query->whereRaw("TO_TIMESTAMP(TO_CHAR(CREATED_AT,'HH24:MI:SS'),'HH24:MI:SS') >= TO_TIMESTAMP('12:00:00','HH24:MI:SS')");
        }

        $query = $query->groupBy('BATCH_ID', 'MOISTURE_POINT')->orderByRaw('MIN(CREATED_AT) ASC')->orderBy('BATCH_ID');

        return $query;
    }

    public function scopeGetAllTimeBatchItems($query, $blendDate, $batchId, $moisturePoint)
    {
        $query = $query->select(DB::raw("BATCH_ID ||':'|| MOISTURE_POINT AS OPT_ID, BATCH_ID, MOISTURE_POINT, CREATED_AT AS BLEND_DATE, NULL AS FEEDER_NAME, MOISTURE_VALUE"))
                ->whereNotNull("BATCH_ID")
                ->whereRaw("LENGTH(BATCH_ID) < 30")
                ->where("MOISTURE_VALUE",">=", 1)
                ->where('BATCH_ID', $batchId)
                ->where('MOISTURE_POINT', $moisturePoint)
                ->whereRaw("TO_DATE(TO_CHAR(CREATED_AT,'YYYY-MM-DD'),'YYYY-MM-DD') = TO_DATE('{$blendDate}','YYYY-MM-DD')");

        $query = $query->orderBy('CREATED_AT');

        return $query;
    }

    public function scopeGetListAllBatchItems($query, $searchBatchKeyword, $blendDateFrom, $blendDateTo)
    {

        $query = $query->select(DB::raw("BATCH_ID AS OPT_ID, BATCH_ID, NULL AS MOISTURE_POINT, MIN(CREATED_AT) AS BLEND_DATE, NULL AS FEEDER_NAME"))
            ->whereNotNull("BATCH_ID")
            ->whereNotNull("MOISTURE_POINT")
            ->whereRaw("LENGTH(BATCH_ID) < 30")
            ->where("MOISTURE_VALUE",">=", 1);

        if($searchBatchKeyword) {
            $query->where('BATCH_ID', 'LIKE', "%{$searchBatchKeyword}%");
        }

        if($blendDateFrom) {
            $query = $query->whereRaw("TO_DATE(TO_CHAR(CREATED_AT,'YYYY-MM-DD'),'YYYY-MM-DD') >= TO_DATE('{$blendDateFrom}','YYYY-MM-DD')");
        }
        if($blendDateTo) {
            $query = $query->whereRaw("TO_DATE(TO_CHAR(CREATED_AT,'YYYY-MM-DD'),'YYYY-MM-DD') <= TO_DATE('{$blendDateTo}','YYYY-MM-DD')");
        }

        $query = $query->groupBy('BATCH_ID')->orderByRaw('MIN(CREATED_AT) DESC')->orderBy('BATCH_ID');

        return $query;
    }

}
