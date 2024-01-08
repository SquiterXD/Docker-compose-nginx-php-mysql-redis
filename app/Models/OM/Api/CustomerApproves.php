<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerApproves extends Model
{
    use HasFactory;
    protected $table = 'PTOM_CUSTOMER_APPROVES';
    public $primaryKey = 'approve_id';
    public $timestamps = false;
    protected $dates = ['creation_date'];
}
