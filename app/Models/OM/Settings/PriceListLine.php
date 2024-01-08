<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceListLine extends Model
{
    use HasFactory;

    protected $table = 'ptom_list_lines';
    protected $primaryKey = 'list_line_id';

    public function sequenceEcom()
    {
        return $this->belongsTo(SequenceEcom::class, 'product_value', 'item_id');
    }

}
