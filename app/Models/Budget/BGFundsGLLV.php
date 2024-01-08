<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BGFundsGLLV extends Model
{
    use HasFactory;
    protected $table        = 'ptbg_inq_gll_v';
    protected $connection   = 'oracle';
}
