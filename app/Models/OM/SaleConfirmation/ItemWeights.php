<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemWeights extends Model
{
    use HasFactory;

    protected $table = 'PTOM_ITEM_WEIGHTS';
    public $primaryKey = 'WEIGHT_ID';
    public $timestamps = false;


}
