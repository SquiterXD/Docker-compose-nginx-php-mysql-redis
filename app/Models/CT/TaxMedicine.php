<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxMedicine extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_TAX_MEDICINES';
    public $primaryKey = "tax_medicine_id";
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

	protected $guarded = [];
}
