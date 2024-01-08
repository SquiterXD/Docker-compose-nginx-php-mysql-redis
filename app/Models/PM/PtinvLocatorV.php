<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtinvLocatorV extends Model
{
    use HasFactory;

    protected $table = 'PTINV_LOCATOR_V';
    public $timestamps = false;

    protected $guarded = [];
}
