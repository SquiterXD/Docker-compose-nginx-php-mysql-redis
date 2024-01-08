<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeDomestic extends Model
{
    use HasFactory;

    protected $table = "PTOM_CUSTOMER_TYPE_DOMESTIC";
    public $primaryKey = 'CUSTOMER_TYPE';
    public $timestamps = false;
    // protected $dates = ['CREATED_BY', 'LAST_UPDATE_DATE'];

    // protected $fillable = [
    //     'CUSTOMER_NAME'
    // ];
}
