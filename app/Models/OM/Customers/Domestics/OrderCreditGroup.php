<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCreditGroup extends Model
{
    use HasFactory;

    protected $table = "PTOM_ORDER_CREDIT_GROUPS";
    public $primaryKey = 'ORDER_GROUP_ID';
    public $timestamps = false;
    protected $fillable = [''];
    // protected $dates = ['CREATED_BY', 'LAST_UPDATE_DATE'];

    // protected $fillable = [
    //     'CUSTOMER_NAME'
    // ];
}