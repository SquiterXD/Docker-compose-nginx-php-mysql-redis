<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebFuelDist extends Model
{
    use HasFactory;
    protected $table = 'PTINV_WEB_FUEL_DIST';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $guarded = [];

    public function webFuelOils()
    {
        return $this->belongsTo('App\Models\INV\WebFuelOil', 'transaction_id', 'transaction_id');
    }
}
