<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomCustomerInfoV extends Model
{
    use HasFactory;

    protected $table = 'ptom_customers_info_v';
    public $primaryKey = 'customer_id';
    public $timestamps = false;
    protected $guarded = [];

   
}