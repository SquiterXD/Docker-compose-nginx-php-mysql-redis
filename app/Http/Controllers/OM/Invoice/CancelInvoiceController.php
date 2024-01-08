<?php

namespace App\Http\Controllers\OM\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Invoice\CancelInvoiceModel;

class CancelInvoiceController extends Controller
{
    public function index()
    {
        $list = CancelInvoiceModel::where(function($query){
                                        $query->where('ptom_invoice_headers.program_code','OMP0033');
                                        $query->orWhere('ptom_invoice_headers.program_code','OMP0034');
                                        $query->orWhere('ptom_invoice_headers.program_code','OMP0052');
                                    })
                                    ->where('ptom_invoice_headers.invoice_status','Confirm')
                                    ->orderBy('ptom_invoice_headers.creation_date','desc')
                                    ->get();

        return view('om.invoice.cancel_invoice',compact('list'));
    }
}
