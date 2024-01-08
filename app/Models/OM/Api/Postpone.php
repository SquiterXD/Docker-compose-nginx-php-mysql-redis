<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postpone extends Model
{
    use HasFactory;
    protected $table = 'PTOM_POSTPONE_ORDERS as po';
    public $primaryKey = 'postpone_order_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
}