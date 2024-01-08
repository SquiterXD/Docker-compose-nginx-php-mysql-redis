<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OM\Settings\PtomNodeLine;

class PtomNodeHeader extends Model
{
    use HasFactory;
    protected $table = 'PTOM_NODE_HEADERS';
    protected $primaryKey = 'node_header_id';



    public function lines()
    {
        return $this->belongsTo(PtomNodeLine::class, 'node_header_id', 'node_header_id');
    }
}
