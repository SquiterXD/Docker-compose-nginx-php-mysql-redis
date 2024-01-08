<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxAccountModel extends Model
{
    use HasFactory;
    protected $table = "ptom_tax_accounts_v";
    public $timestamps = false;
}
