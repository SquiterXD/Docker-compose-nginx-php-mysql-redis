<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountMappingModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_ACCOUNTS_MAPPING_V";
    public $timestamps = false;
}
