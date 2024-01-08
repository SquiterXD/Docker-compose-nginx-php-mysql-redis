<?php

namespace App\Models\OM;

use App\Models\OM\Api\OrderLines;
use App\Models\OM\Api\ProductTypeExport;
use App\Models\OM\OverdueDebt\ProformaInvoiceHeaders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class OrderDirectDebit extends Model
{
    use HasFactory;

    protected $table = 'ptom_order_direct_debit';
    public $primaryKey = 'order_direct_debit_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];

}