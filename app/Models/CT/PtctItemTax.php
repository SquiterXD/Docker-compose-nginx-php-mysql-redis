<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtctItemTax extends Model
{
    use HasFactory;

    protected $table = 'OACT.PTCT_ITEM_TAX';
    public $primaryKey = false;
	protected $guarded = [];
}
