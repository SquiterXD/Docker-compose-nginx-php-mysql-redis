<?php

namespace App\Models\OM\ConsignmentClub;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsignmentLines extends Model
{
    use HasFactory;

    protected $table = 'PTOM_CONSIGNMENT_LINES';
    public $primaryKey = 'CONSIGNMENT_LINE_ID';
    public $timestamps = false;


}
