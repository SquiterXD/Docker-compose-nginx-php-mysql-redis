<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class GlLedger extends Model
{
    use HasFactory;
    protected $table = 'GL_LEDGERS';
}
