<?php

namespace App\Models\OM\Promotions\Oaom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemv extends Model
{
    use HasFactory;
    protected $table = "PTOM_ITEM_V";
    public $timestamps = false;

    public function uomV()
    {
        return $this->hasOne('App\Models\OM\Promotions\UomV', 'uom_code', 'uom');
    }
}
