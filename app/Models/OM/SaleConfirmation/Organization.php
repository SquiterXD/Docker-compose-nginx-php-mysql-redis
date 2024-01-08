<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'PTOM_ORGANIZATION_V';
    public $primaryKey = 'ORGANIZATION_ID';
    public $timestamps = false;


}
