<?php

namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomStatus extends Model
{
    use HasFactory;

    protected $table  = 'PTPD_BOM_STATUS';
    protected $primaryKey = 'lookup_code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['lookup_code', 'meaning', 'description', 'tag', 'start_date_active', 'end_date_active', 'enabled_flag'];
}
