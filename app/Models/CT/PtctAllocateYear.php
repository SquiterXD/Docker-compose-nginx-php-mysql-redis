<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctAllocateYear extends Model
{
    use HasFactory;

    protected $table = 'PTCT_ALLOCATE_YEAR';
    protected $primaryKey   = 'allocate_year_id';
    public $timestamps = false;

    protected $fillable = [
        'allocate_year_id'
        ,'period_year'
        ,'version_no'
        ,'approved_status'
        ,'approved_date'
        ,'file_name'
        ,'budget_year'
        ,'program_code'
        ,'created_at'
        ,'updated_at'
        ,'deleted_at'
        ,'created_by_id'
        ,'updated_by_id'
        ,'deleted_by_id'
        ,'created_by'
        ,'creation_date'
        ,'last_update_date'
        ,'last_updated_by'
        ,'last_update_login'
    ];

    public static function getListPeriodYears() {

        $results = DB::select(
			"SELECT CT15.PERIOD_YEAR, CT15.PERIOD_YEAR_THAI
            FROM PTCT_STDCOST_YEAR_V CT15
            WHERE CT15.LAST_PERIOD_FLAG <> 'Y'
            AND NOT EXISTS (
                SELECT 'X' FROM PTCT_YEAR_CONTROL CT18
                WHERE CT18.YEAR_MAIN_ID         = CT15.YEAR_MAIN_ID
                    AND CT18.PERIOD_YEAR        = CT15.PERIOD_YEAR
                    AND CT18.PRDGRP_YEAR_ID     = CT15.PRDGRP_YEAR_ID
                    AND CT18.ALLOCATE_YEAR_ID   = CT15.ALLOCATE_YEAR_ID
                    AND CT18.VERSION_NO         = CT15.VERSION_NO)
            AND CT15.TOTAL_MONTH = (
                SELECT MAX(CT.TOTAL_MONTH) FROM PTCT_STDCOST_YEAR CT
                WHERE CT.PERIOD_YEAR        = CT15.PERIOD_YEAR
                AND CT.PRDGRP_YEAR_ID     = CT15.PRDGRP_YEAR_ID
                AND CT.ALLOCATE_YEAR_ID   = CT15.ALLOCATE_YEAR_ID
                AND CT.VERSION_NO         = CT15.VERSION_NO )
            GROUP BY CT15.PERIOD_YEAR, CT15.PERIOD_YEAR_THAI
            ORDER BY CT15.PERIOD_YEAR DESC"
		);

        return $results;

    }

}
