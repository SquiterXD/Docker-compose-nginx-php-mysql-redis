<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormOrderHeader extends Model
{
    use HasFactory;

    protected $table = 'ptom_form_order_headers';
    public $primaryKey = 'form_header_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    protected $guarded = [];

}
