<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interfaces extends Model
{
    use HasFactory;

    protected $table = 'PTOM_INTERFACES';
    public $primaryKey = 'INTERFACE_ID';
    public $timestamps = false;


}
