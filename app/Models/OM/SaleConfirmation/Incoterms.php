<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incoterms extends Model
{
    use HasFactory;

    protected $table = 'PTOM_INCOTERMS';
    public $primaryKey = 'LOOKUP_CODE';
    public $timestamps = false;


}
