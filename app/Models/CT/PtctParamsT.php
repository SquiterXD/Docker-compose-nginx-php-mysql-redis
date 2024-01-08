<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctParamsT extends Model
{
    
    use HasFactory;
    protected $table = 'PTCT_PARAMS_T';

    public $primaryKey = 'param_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    protected $fillable = [
        'param_id'
        ,'process_step'
        ,'period_year'
        ,'period_name'
        ,'start_date'
        ,'end_date'
        ,'cc_code'
        ,'cost_code'
        ,'dept_code_from'
        ,'dept_code_to'
        ,'batch_no_from'
        ,'batch_no_to'
        ,'process_status'
        ,'posting_status'
        ,'period_number'
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

    public static function nextValParamId()
    {
        $result = DB::select( DB::raw("select PTCT_PARAMS_T_S.nextval as param_id from dual") );
        $paramId = $result ? $result[0]->param_id : null;

        return $paramId;
    }

}
