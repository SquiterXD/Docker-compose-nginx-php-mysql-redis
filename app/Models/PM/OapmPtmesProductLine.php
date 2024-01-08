<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OapmPtmesProductLine extends Model
{
    use HasFactory;
    protected $table = 'oapm.ptmes_product_line';
    protected $primaryKey = 'product_line_id';
    public $incrementing = false;
    public $timestamps = false;
}
