<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtmesTobaccoTransactionsR01 extends Model
{
    use HasFactory;

    protected $table  = 'PTMES_TOBACCO_TRANSACTIONS_R01';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;


    public function scopeGetListAllBatchItems($query, $searchBatchKeyword, $blendDateFrom, $blendDateTo)
    {

        $query = $query->select(DB::raw("SCADA_BATCH_ID AS OPT_ID, SCADA_BATCH_ID AS BATCH_ID, NULL AS MOISTURE_POINT, MIN(CREATION_DATE) AS BLEND_DATE, NULL AS FEEDER_NAME"))
            ->whereNotNull("SCADA_BATCH_ID")
            ->where("ORGANIZATION_CODE","M03");

        if($searchBatchKeyword) {
            $query->where('SCADA_BATCH_ID', 'LIKE', "%{$searchBatchKeyword}%");
        }

        if($blendDateFrom) {
            $query = $query->whereRaw("TO_DATE(TO_CHAR(CREATION_DATE,'YYYY-MM-DD'),'YYYY-MM-DD') >= TO_DATE('{$blendDateFrom}','YYYY-MM-DD')");
        }
        if($blendDateTo) {
            $query = $query->whereRaw("TO_DATE(TO_CHAR(CREATION_DATE,'YYYY-MM-DD'),'YYYY-MM-DD') <= TO_DATE('{$blendDateTo}','YYYY-MM-DD')");
        }

        $query = $query->groupBy('SCADA_BATCH_ID')->orderByRaw('MIN(CREATION_DATE) DESC')->orderBy('SCADA_BATCH_ID');

        return $query;
    }

    public static function getListMesBatchItems($searchBatchKeyword, $blendDateFrom, $blendDateTo)
    {

        $results = DB::select(
			"SELECT BATCHID AS OPT_ID, BATCHID AS BATCH_ID, NULL AS MOISTURE_POINT, MIN(START_DATE) AS BLEND_DATE, NULL AS FEEDER_NAME
            FROM MES_PRIMARY_MACHINE_REPORT
            WHERE 1=1
            AND BATCHID LIKE '%{$searchBatchKeyword}%'
            AND TO_DATE(TO_CHAR(START_DATE,'YYYY-MM-DD'),'YYYY-MM-DD') >= TO_DATE('{$blendDateFrom}','YYYY-MM-DD')
            AND TO_DATE(TO_CHAR(START_DATE,'YYYY-MM-DD'),'YYYY-MM-DD') <= TO_DATE('{$blendDateTo}','YYYY-MM-DD')
            AND (BLEND_NO LIKE '%DIET%' or BLEND_NO LIKE '%EL%')
            GROUP BY BATCHID, START_DATE
            ORDER BY MIN(START_DATE) DESC, BATCHID ASC"
        );

        return $results;

    }

}
