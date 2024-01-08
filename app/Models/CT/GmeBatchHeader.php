<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GmeBatchHeader extends Model
{
    use HasFactory;
    protected $table = 'GME_BATCH_HEADER';
    public $timestamps = false;

    protected $guarded = [];
    
}
