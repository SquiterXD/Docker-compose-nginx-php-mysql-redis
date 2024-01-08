<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsignmentHeaders extends Model
{
    use HasFactory;
    
    protected $table = "ptom_consignment_headers";
    protected $primaryKey   = 'consignment_header_id';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'consignment_date'
    ];
}
