<?php

namespace App\Models\OM\DomesticMatching;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHeaders extends Model
{
    use HasFactory;

    protected $table = 'ptom_order_headers';
    public $primaryKey = 'order_header_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';
}
