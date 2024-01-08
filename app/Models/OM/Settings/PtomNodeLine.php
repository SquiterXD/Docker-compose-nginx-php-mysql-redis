<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomNodeLine extends Model
{
    use HasFactory;
    protected $table = 'PTOM_NODE_LINES';
    protected $primaryKey = 'node_line_id';
}
