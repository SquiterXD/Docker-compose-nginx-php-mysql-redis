<?php

namespace App\Models\OM\DomesticMatching;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHeaders extends Model
{
    use HasFactory;

    protected $table = 'ptom_invoice_headers';
    public $primaryKey = 'invoice_headers_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';
}
