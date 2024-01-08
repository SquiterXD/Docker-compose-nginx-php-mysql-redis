<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartonQuantityV extends Model
{
    use HasFactory;

    protected $table = 'ptom_carton_quantity_v';
    public $primaryKey = 'lookup_code';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
}
