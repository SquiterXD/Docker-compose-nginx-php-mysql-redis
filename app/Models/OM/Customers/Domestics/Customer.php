<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "PTOM_CUSTOMERS";
    public $primaryKey = 'CUSTOMER_ID';
    public $timestamps = false;

    protected $fillable = [
        'payment_method_id',
        'shipment_by_id',
        'order_type_id',
        'payment_type_id',
        'payment_type_id',
        'last_updated_by',
        'last_update_date'
    ];

    public function scopeSearch($q, $search, $whereColumns, $likeColumns)
    {

        if(!empty($search)){
            foreach ($search as $key => $value) {
                $value = trim(strtolower($value));
                if($value){
                    if(in_array($key, $whereColumns)){
                        $q->whereRaw("lower({$key}) like '{$value}' ");
                    }
                    else if(in_array($key, $likeColumns)){
                        $q->whereRaw("lower({$key}) like '%{$value}%' ");
                    }
                }
            }
        }else{
            $q = null;
        }

        return $q;

    }
}
