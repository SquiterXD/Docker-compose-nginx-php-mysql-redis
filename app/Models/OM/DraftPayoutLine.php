<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftPayoutLine extends Model
{
    use HasFactory;

    protected $table = 'ptom_order_lines';
    public $primaryKey = 'order_line_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
}
