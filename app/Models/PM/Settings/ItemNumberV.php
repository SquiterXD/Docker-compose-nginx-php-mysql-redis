<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemNumberV extends Model
{
    use HasFactory;

    protected $table = 'ptpm_item_number_v';
    public $primaryKey = false;

    public function scopeSearch($q, $search)
    {
        if($search){
            if(isset($search['itemcat'])){
                $itemcatArray = explode('.', $search['itemcat']);
                $tobaccoGroupCode = $itemcatArray[0];
                $tobaccoTypeCode = $itemcatArray[1];                  
            }else {
                $tobaccoTypeCode = '';
                $tobaccoGroupCode = '';
            }

            if(isset($search['itemNumber'])){
                $itemNumber = $search['itemNumber'];
            }else{
                $itemNumber = '';
            }
        }else {
            $tobaccoTypeCode = '';
            $itemNumber = '';
        }

        if ($search){
            if ($tobaccoGroupCode != null) {
                $q->where('tobacco_group_code', $tobaccoGroupCode);
            }

            if ($tobaccoTypeCode != null) {
                $q->where('tobacco_type_code', $tobaccoTypeCode);
            }

            if ($itemNumber != null) {
                $q->where('inventory_item_id', $itemNumber);
            }
        }

        return $q;
    }

}
