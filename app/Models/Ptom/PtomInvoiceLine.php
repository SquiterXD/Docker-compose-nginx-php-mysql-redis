<?php

namespace App\Models\Ptom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomInvoiceLine extends Model
{
    use HasFactory;
    protected $table = "ptom_invoice_lines";
    public $primaryKey = 'invoice_line_id';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
