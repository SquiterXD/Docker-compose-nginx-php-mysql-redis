<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onhand extends Model
{
    use HasFactory;

    protected $table = 'PTOM_ONHAND_V';
    public $primaryKey = 'INVENTORY_ITEM_ID';
    public $timestamps = false;


}
