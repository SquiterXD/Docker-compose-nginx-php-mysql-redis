<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckPointsV extends Model
{
    use HasFactory;

    protected $table = 'oaqm.ptqm_check_points_v';
    public $primaryKey = false;
    public $timestamps = false;


    public function attachments()
    {
        return $this->hasMany(\App\Models\QM\Settings\CheckPointsV::class, 'location_desc', 'location_desc');
    }

    public function scopeSearchLeaf($q, $request)
    {
        if ($request){
            if(array_key_exists('location_desc',$request)){
                if ($request['location_desc'] != null) {
                    $q->where('location_desc', $request['location_desc'])->get();
                } else {
                    $q;
                }
            }          
            if(array_key_exists('locator_desc',$request)){
                if ($request['locator_desc'] != null) {
                    $q->where('locator_desc', $request['locator_desc'])->get();
                } else {
                    $q;
                } 
            }            
            if(array_key_exists('qm_group',$request)){
                if ($request['qm_group'] != null) {
                    $q->where('qm_group', $request['qm_group'])->get();
                } else {
                    $q;
                }    
            }            
            if(array_key_exists('status',$request)){
                if ($request['status'] != null) {
                    $q->where('enabled_flag', $request['status'])->get();
                } else {
                    $q;
                }
            }            
        }
        return  $q;
    }

    public function scopeSearchBeetle($q, $request)
    {
        if ($request){
            if(array_key_exists('build_name',$request)){
                if ($request['build_name'] != null) {
                    $q->where('build_name', $request['build_name'])->get();
                } else {
                    $q;
                }
            }            
            if(array_key_exists('department_name',$request)){
                if ($request['department_name'] != null) {
                    $q->where('department_name', $request['department_name'])->get();
                } else {
                    $q;
                }
            }
            if(array_key_exists('locator_desc',$request)){
                if ($request['locator_desc'] != null) {
                    $q->where('locator_desc', $request['locator_desc'])->get();
                } else {
                    $q;
                }
            }
            if(array_key_exists('location_desc',$request)){
                if ($request['location_desc'] != null) {
                    $q->where('location_desc', $request['location_desc'])->get();
                } else {
                    $q;
                }
            }            
            if(array_key_exists('status',$request)){
                if ($request['status'] != null) {
                    $q->where('enabled_flag', $request['status'])->get();
                } else {
                    $q;
                }
            }            
        }
        return  $q;
    }

}
