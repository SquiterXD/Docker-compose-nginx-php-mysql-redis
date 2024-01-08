<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CT\Ajax\TaxMedicineController AS AjaxTaxMedicine;
use Illuminate\Http\Request;

use App\Models\CT\TaxMedicine;

class TaxMedicineController extends Controller
{
    public function index()
    {
        return view('ct.tax_medicine.index');
    }

    public function create()
    {
        return view('ct.tax_medicine.create',
        [
            "is_edit" => false
        ]);
    }

    public function edit($tax_medicine)
    {
        $taxMedicine = new AjaxTaxMedicine;
        $item_number = TaxMedicine::find($tax_medicine)->item_number;
        $taxMedicine = $taxMedicine->show($item_number)->getData();
        return view('ct.tax_medicine.edit',
        [
            "is_edit" => true,
            "tax_medicine" => $taxMedicine
        ]);
    }
}
