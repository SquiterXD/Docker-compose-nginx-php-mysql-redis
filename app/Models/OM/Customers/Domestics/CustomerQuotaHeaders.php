<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerQuotaHeaders extends Model
{
    use HasFactory;

    protected $table = "PTOM_CUSTOMER_QUOTA_HEADERS";
    public $primaryKey = 'QUOTA_HEADER_ID';
    public $timestamps = false;
    // protected $dates = ['CREATED_BY', 'LAST_UPDATE_DATE'];

    // protected $fillable = [
    //     'CUSTOMER_NAME'
    // ];
}
