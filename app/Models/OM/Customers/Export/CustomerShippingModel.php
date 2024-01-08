<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerShippingModel extends Model
{
    use HasFactory;

    protected $table = "PTOM_CUSTOMER_SHIP_SITES";
    public $primaryKey = 'SHIP_TO_SITE_ID';
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'ship_to_site_code',
        'site_no',
        'ship_to_site_name',
        'ship_contact_name',
        'ship_contact_position',
        'country_code',
        'country_name',
        'address_line1',
        'address_line2',
        'address_line3',
        'region_id',
        'region_code',
        'city',
        'city_code',
        'district_code',
        'state',
        'province_code',
        'province_id',
        'province_name',
        'district',
        'alley',
        'postal_code',
        'status',
        'attribute1',
        'program_code',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
    ];
}
