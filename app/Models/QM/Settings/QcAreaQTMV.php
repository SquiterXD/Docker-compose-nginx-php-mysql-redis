<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcAreaQTMV extends Model
{
    use HasFactory;

    protected $table = 'ptqm_qc_area_qtm_v';
    public $primaryKey = false;
    public $timestamps = false;

    public function scopeSearch($q, $request)
    {
        if ($request){
  
            if(array_key_exists('step_description',$request)){
                if ($request['step_description'] != null) {
                    $q->where('step_description', $request['step_description'])->get();
                } else {
                    $q;
                }
            }
            

            if(array_key_exists('machine_description',$request)){
                if ($request['machine_description'] != null) {
                    $q->where('machine_description', $request['machine_description'])->get();
                } else {
                    $q;
                }
            }
            
            if(array_key_exists('machine_set',$request)){
                if ($request['machine_set'] != null) {
                    $q->where('machine_set', $request['machine_set'])->get();
                } else {
                    $q;
                }
            }else{
                $q;
            }
            
            if(array_key_exists('qc_area_qtm',$request)){
                if ($request['qc_area_qtm'] != null) {
                    $q->where('qc_area_qtm', $request['qc_area_qtm'])->get();
                } else {
                    $q;
                }  
            }

            if(array_key_exists('status',$request)){
                if ($request['status'] != null) {
                    $q->where('qm_enable_flag', $request['status'])->get();
                } else {
                    $q;
                }
            }

        }

        return  $q;
    }
}
