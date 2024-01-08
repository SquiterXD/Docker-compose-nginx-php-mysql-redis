<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimStatusV extends Model
{
    use HasFactory;

    protected $table        = 'PTOM_CLAIM_STATUS_V';
    protected $primaryKey   = 'lookup_code';
}
