<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class PurposeSetup extends Model
{
    protected $table = 'ptw_purpose_setups';
    public $primaryKey = 'purpose_setup_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public static function getPurpose($object = null)
    {
        $purposes = PurposeSetup::select('seq','purpose')->orderBy('seq')->get();
        $dataSet = [];

        foreach($purposes as $key => $purpose)
        {
            if($object){
                $dataSet[$purpose->purpose] = $purpose->purpose;
            }else {
                $dataSet = $purposes;
            }
        }

        return $dataSet;
    }
}