<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPrevious extends Model
{
    use HasFactory;

    protected $table = "PTOM_CUSTOMER_PREVIOUS";
    public $primaryKey = 'PREVIOUS_ID';
    public $timestamps = false;
    // protected $dates = ['CREATED_BY', 'LAST_UPDATE_DATE'];

    // protected $fillable = [
    //     'CUSTOMER_NAME'
    // ];
}
