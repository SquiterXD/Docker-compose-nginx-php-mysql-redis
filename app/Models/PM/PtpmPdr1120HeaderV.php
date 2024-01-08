<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Model;

class PtpmPdr1120HeaderV extends Model
{
    protected $table = 'oapm.ptpm_pdr1120_header_v';
    public $primaryKey = '';
    public $timestamps = false;
    
    protected $dates = ['product_date'];
}
