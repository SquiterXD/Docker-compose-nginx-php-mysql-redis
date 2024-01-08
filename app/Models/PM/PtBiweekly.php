<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtBiweekly extends Model
{
    use HasFactory;

    protected $table = 'PT_BIWEEKLY';
    protected $primaryKey = 'BIWEEKLY_ID';
}
