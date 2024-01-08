<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnHandV extends Model
{
    use HasFactory;

    protected $table = 'ptom_onhand_v';
    public $primaryKey = 'onhand_id';
}
