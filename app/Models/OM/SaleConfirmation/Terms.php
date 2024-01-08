<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    use HasFactory;

    protected $table = 'PTOM_TERMS_V';
    public $primaryKey = 'TERM_ID';
    public $timestamps = false;


}
