<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CT\PtPeriodsV;

class StampAdj extends Model
{
    use HasFactory;

    protected $table = 'ptpm_stamp_adj';
    public $primaryKey = "stamp_adj_id";

    public function ProductType()
    {
        return $this->belongsTo(ProductTypeDomestic::class, 'stamp_type', 'lookup_code');
    }
}
