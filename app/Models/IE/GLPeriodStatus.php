<?php

namespace App\Models\IE;
use Illuminate\Database\Eloquent\Model;

use DB;
use PDO;
use DateTime;

class GLPeriodStatus extends Model
{
    protected $table = 'ptie_gl_period_statuses_v';

    public function scopeGetGLPeriodStatusOpenByDate($query,$orgId,$date)
    {
    	$query->select(DB::raw("period_name,
							   set_of_books_id,
							   application_id,
							   closing_status,
							   org_id,
							   start_date,
							   end_date"));
    	$query->from('ptie_gl_period_statuses_v');
    	$query->where('application_id',101)
    		->where('closing_status','O')
    		->where('org_id',$orgId)
    		->whereRaw("TRUNC(TO_DATE('".$date."','RRRR-MM-DD')) BETWEEN TRUNC(NVL(START_DATE,SYSDATE)) AND TRUNC(NVL(END_DATE,SYSDATE))");

    	return $query;
    }

    public function scopeGetAPPeriodStatusOpenByDate($query,$orgId,$date)
    {
    	$query->select(DB::raw("period_name,
							   set_of_books_id,
							   application_id,
							   closing_status,
							   org_id,
							   start_date,
							   end_date"));
    	$query->from('ptie_gl_period_statuses_v');
    	$query->where('application_id',200)
    		->where('closing_status','O')
    		->where('org_id',$orgId)
    		->whereRaw("TRUNC(TO_DATE('".$date."','RRRR-MM-DD')) BETWEEN TRUNC(NVL(START_DATE,SYSDATE)) AND TRUNC(NVL(END_DATE,SYSDATE))");
    		
    	return $query;
    }
}
