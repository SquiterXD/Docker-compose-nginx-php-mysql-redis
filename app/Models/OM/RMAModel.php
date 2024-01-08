<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RMAModel extends Model
{
    use HasFactory;

    protected $table = "PTOM_CLAIM_HEADERS";
    public $primaryKey = 'CLAIM_HEADER_ID';
    public $timestamps = false;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
