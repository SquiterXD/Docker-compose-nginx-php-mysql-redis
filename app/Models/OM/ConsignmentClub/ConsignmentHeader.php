<?php

namespace App\Models\OM\ConsignmentClub;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsignmentHeader extends Model
{
    use HasFactory;

    protected $table = 'PTOM_CONSIGNMENT_HEADERS';
    public $primaryKey = 'CONSIGNMENT_HEADER_ID';
    public $timestamps = false;


}
