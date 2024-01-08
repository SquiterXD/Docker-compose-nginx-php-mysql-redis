<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctStdCostInquiryV extends Model
{
    use HasFactory;

    protected $table = 'OACT.PTCT_STD_COST_INQUIRY_V';
    protected $primaryKey   = false;
    public $timestamps = false;
    
}
