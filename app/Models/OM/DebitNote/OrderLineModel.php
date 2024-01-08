<?php

namespace App\Models\OM\DebitNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLineModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_order_lines';
}
