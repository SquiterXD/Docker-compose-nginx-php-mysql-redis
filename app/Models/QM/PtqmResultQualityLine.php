<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtqmResultQualityLine extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table  = 'PTQM_RESULT_QUALITY_LINES';
    
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [ 'result_header_id','result_line_id','result_id','std_value','result_value','edit_flag',
                            'attribute_category','program_code','line_no','test_id','attribute1','attribute2',
                            'attribute3','attribute4','attribute5','attribute6','attribute7','attribute8',
                            'attribute9','attribute10','attribute11','attribute12','attribute13','attribute14',
                            'attribute15','tran_id','stg_no','file_name','interface_name','record_status',
                            'interface_msg','creation_date','last_updated_by','last_update_date','created_at',
                            'updated_at','deleted_at','created_by_id','updated_by_id','deleted_by_id',
                            'web_batch_no','interface_status','interfaced_msg','created_by' ];

}
