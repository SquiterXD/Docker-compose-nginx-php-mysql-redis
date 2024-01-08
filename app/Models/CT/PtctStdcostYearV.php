<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctStdcostYearV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_STDCOST_YEAR_V';
    public $timestamps = false;

    protected $guarded = [];

    /**
	 * Relationship to accs
	 *
	 * @return void
	 */
	public function accs()
	{
		return $this->hasMany(PtctStdcostYearAccV::class, 'year_main_id');
	}

	public static function getListReadyStdcostYears() {

		// $results = DB::select(
		// 	"SELECT CT15.PERIOD_YEAR, CT15.PRDGRP_YEAR_ID, CT15.ALLOCATE_YEAR_ID, CT15.PLAN_VERSION_NO, CT15.VERSION_NO 
        //     FROM PTCT_STDCOST_YEAR_V CT15
        //     WHERE CT15.LAST_PERIOD_FLAG <> 'Y'
        //     AND NOT EXISTS (
        //         SELECT 'X' FROM PTCT_YEAR_CONTROL CT18
        //         WHERE CT18.YEAR_MAIN_ID         = CT15.YEAR_MAIN_ID
        //             AND CT18.PERIOD_YEAR        = CT15.PERIOD_YEAR
        //             AND CT18.PRDGRP_YEAR_ID     = CT15.PRDGRP_YEAR_ID
        //             AND CT18.ALLOCATE_YEAR_ID   = CT15.ALLOCATE_YEAR_ID
        //             AND CT18.VERSION_NO         = CT15.VERSION_NO)
        //     AND CT15.TOTAL_MONTH = (
        //         SELECT MAX(CT.TOTAL_MONTH) FROM PTCT_STDCOST_YEAR CT
        //         WHERE CT.PERIOD_YEAR        = CT15.PERIOD_YEAR
        //         AND CT.PRDGRP_YEAR_ID     = CT15.PRDGRP_YEAR_ID
        //         AND CT.ALLOCATE_YEAR_ID   = CT15.ALLOCATE_YEAR_ID
        //         AND CT.VERSION_NO         = CT15.VERSION_NO )"
		// );

        $results = DB::select(
            "SELECT CT15.PERIOD_YEAR, CT15.PLAN_VERSION_NO, CT15.PRDGRP_YEAR_ID, CT15.ALLOCATE_YEAR_ID, CT14.ALLOCATE_YEAR_ID CT14_ALLOCATE_YEAR_ID, CT14.VERSION_NO CT14_VERSION_NO ,CT14.COST_CODE, CT14.COST_CODE AS COST_CODE_VALUE, CC.COST_CODE || ' : ' || CC.DESCRIPTION AS COST_CODE_LABEL
            FROM PTCT_STDCOST_YEAR_V CT15, 
            PTCT_STD_COST_HEADS_V CT14,
            PTCT_COST_CENTER_V CC
            WHERE CT15.PRDGRP_YEAR_ID = CT14.PRDGRP_YEAR_ID
            AND CT15.PERIOD_YEAR  = CT14.PERIOD_YEAR
            AND CT14.COST_CODE  = CC.COST_CODE
            AND CT14.APPROVED_FLAG = 'Y' 
            AND NOT EXISTS (
                SELECT 'X' FROM PTCT_YEAR_CONTROL CT18
                WHERE CT18.YEAR_MAIN_ID         = CT15.YEAR_MAIN_ID
                AND CT18.PERIOD_YEAR        = CT15.PERIOD_YEAR
                AND CT18.PRDGRP_YEAR_ID     = CT15.PRDGRP_YEAR_ID
                AND CT18.VERSION_NO         = CT15.VERSION_NO
                AND CT18.CT14_ALLOCATE_YEAR_ID = CT14.ALLOCATE_YEAR_ID
            )
            AND CT15.TOTAL_MONTH = (
                SELECT MAX(CT.TOTAL_MONTH) FROM PTCT_STDCOST_YEAR CT
                WHERE CT.PERIOD_YEAR        = CT15.PERIOD_YEAR
                AND CT.PRDGRP_YEAR_ID     = CT15.PRDGRP_YEAR_ID
                AND CT.VERSION_NO         = CT15.VERSION_NO 
            )
            AND CT15.VERSION_NO = (
                SELECT MAX(X.VERSION_NO) FROM PTCT_ALLOCATE_YEAR X
                WHERE X.PERIOD_YEAR = CT15.PERIOD_YEAR)
            ORDER BY CT15.PERIOD_YEAR, CT15.PLAN_VERSION_NO, CT15.PRDGRP_YEAR_ID, CT15.ALLOCATE_YEAR_ID"
        );



        return $results;

    }

}
