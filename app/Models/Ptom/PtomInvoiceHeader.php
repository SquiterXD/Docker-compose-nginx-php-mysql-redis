<?php

namespace App\Models\Ptom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomInvoiceHeader extends Model
{
    use HasFactory;
    protected $table = "ptom_invoice_headers";
    public $primaryKey = 'invoice_headers_id';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
