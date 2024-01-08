<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirInvoiceTypeView extends Model
{
    use HasFactory;
    protected $table = "ptir_invoice_type_v";
    public $timestamps = false;

    private $limit = 50;

    public function getAllInvoiceType()
    {
        $collection = PtirInvoiceTypeView::select('invoice_type')
                                          ->orderBy('invoice_type', 'asc')
                                          ->get();

        return $collection;
    }
}
