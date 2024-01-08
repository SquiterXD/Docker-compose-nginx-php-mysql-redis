<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoLinesAll extends Model
{
    use HasFactory;
    protected $table = 'po_lines_all';

    public function systemItem()
    {
        return $this->belongsTo('App\Models\INV\SystemItemB', 'item_id', 'inventory_item_id');
    }
}
