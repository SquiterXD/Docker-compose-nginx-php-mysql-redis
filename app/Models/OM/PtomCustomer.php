<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomCustomer extends Model
{
    use HasFactory;
    protected $table = "ptom_customers";
    public $primaryKey = 'customer_id';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at'];
}
