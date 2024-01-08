<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\QM\Settings\ResultSeverity;

class TestsV extends Model
{
    use HasFactory;

    protected $table = 'ptqm_tests_v';
    public $primaryKey = false;
    public $timestamps = false;

    public function scopeSearch($q, $request)
    {
        if ($request){
            if ($request['testDesc'] != null) {
                $q->where('test_desc', $request['testDesc'])->get();
            } else {
                $q;
            }
                       
            if ($request['units'] != null) {
                $q->where('test_unit_code', $request['units'])->get();
            } else {
                $q;
            } 
        
            if ($request['resultSeverites'] != null) {
                $q->where('serverity_code', $request['resultSeverites'])->get();
            } else {
                $q;
            }    
        
            if ($request['enableFlag'] != null) {
                $q->where('enable_flag', $request['enableFlag'])->get();
            } else {
                $q;
            }

            if(isset($request['entity'])){
                if ($request['entity'] != null) {
                    $q->where('check_list_code', $request['entity'])->get();
                } else {
                    $q;
                }    
            }

            if(isset($request['process'])){
                if ($request['process'] != null && isset($request['process'])) {
                    $q->where('qm_process_code', $request['process'])->get();
                } else {
                    $q;
                }
            }       
        }

        return  $q;
    }


}
