<?php

namespace App\Models\Planning\StampFollow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLLedger extends Model
{
    use HasFactory;
    protected $table        = 'gl_ledgers';
    protected $connection   = 'oracle';
}
