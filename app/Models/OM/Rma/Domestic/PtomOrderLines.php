<?php

namespace App\Models\OM\Rma\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomOrderLines extends Model
{
    use HasFactory;

    protected $table = 'PTOM_ORDER_LINES';
    protected $primaryKey = 'ORDER_LINE_ID';

    public function ptomOrderHeader()
    {
        return $this->belongsTo(PtomOrderHeaders::class);
    }
}
