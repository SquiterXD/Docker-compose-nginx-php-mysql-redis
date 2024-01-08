<?php

namespace App\Models\OM\Rma\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomConsignmentLines extends Model
{
    use HasFactory;

    protected $table = 'PTOM_CONSIGNMENT_LINES';
    protected $primaryKey = 'CONSIGNMENT_LINE_ID';

    public function ptomConsignmentHeader()
    {
        return $this->belongsTo(PtomConsignmentHeaders::class);
    }
}
