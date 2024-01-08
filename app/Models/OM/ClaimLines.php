<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OM\UomV;

class ClaimLines extends Model
{
    use HasFactory;

    protected $table        = 'PTOM_CLAIM_LINES';
    protected $primaryKey   = 'claim_line_id';

    public function uom()
    {
        return $this->hasMany(UomV::class, 'uom_code', 'uom_code');
    }
}
