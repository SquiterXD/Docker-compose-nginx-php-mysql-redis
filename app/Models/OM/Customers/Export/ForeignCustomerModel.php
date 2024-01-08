<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForeignCustomerModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_CUSTOMERS";
    public $primaryKey = 'CUSTOMER_ID';
    public $timestamps = false;
    // protected $dates = ['creation_date', 'last_update_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_code_tm',
        'currency',
        'sales_classification_code',
        'customer_type_id',
        'customer_name',
        'bill_to_site_name',
        'customer_short_name',
        'country_code',
        'country_name',
        'address_line1',
        'address_line2',
        'address_line3',
        'state',
        'province_code',
        'province_name',
        'city',
        'citi_code',
        'region_code',
        'district_code',
        'postal_code',
        'tax_register_number',
        'branch',
        'vat_code',
        'payment_method',
        'payment_method_id',
        'payment_term_id',
        'payment_terms',
        'shipment_by_id',
        'shipment_condition',
        'shipment_by',
        'formula_id',
        'formula',
        'order_type_id',
        'order_type',
        'incoterms_code',
        'price_list_id',
        'price_list',
        'payment_type',
        'payment_type_id',
        'sales_channel_id',
        'sales_channel',
        'status',
        'last_updated_by',
        'last_update_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    public function scopeSearch($query,$search)
    {
        $columns = [
            'customer_name',
            'request_number',
            'customer_number',
            'customer_code_tm',
            'tax_register_number',
            // 'taxpayer_id',
            // 'customer_type_id',
            'contact_first_name',
            'contact_last_name',
            'contact_phone',
            'address_line1',
            'address_line2',
            'city',
            'state',
            // 'postal_code',
            // 'region_code',
            // 'province_code',
            // 'country_code',
            // 'status'
        ];
        if(!empty($search)){
            foreach($search as $key => $value){
                $value = trim($value);
                if($value){
                    if(in_array($key,$columns)){
                        $query->whereRaw("lower({$key}) like lower('%{$value}%')");
                    }
                    if($key == 'status'){
                        $query->where($key,$value);
                    }
                    if($key == 'postal_code'){
                        $query->where($key,$value);
                    }
                    if($key == 'region_code'){
                        $query->where($key,$value);
                    }
                    if($key == 'province_code'){
                        $query->where($key,$value);
                    }
                    if($key == 'country_code'){
                        $query->where($key,$value);
                    }
                    if($key == 'customer_type_id'){
                        $query->where($key,$value);
                    }
                    if($key == 'taxpayer_id'){
                        $query->where($key,$value);
                    }
                }
            }
        }else{
            $query = null;
        }


        return $query;
    }
}
