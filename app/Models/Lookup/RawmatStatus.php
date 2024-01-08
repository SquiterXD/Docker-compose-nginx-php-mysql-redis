<?php

namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawmatStatus extends Model
{
    use HasFactory;

    protected $table  = 'ptpd_rawmat_status_v';
    protected $primaryKey = 'lookup_code';
}
