<?php

namespace App\Http\Controllers\OM;

use App\Models\OM\OverdueDebt\OrderHeaders;
use App\Models\OM\OverdueDebt\ProformaInvoiceHeaders;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\OverdueDebt\PaymentHeaders;
use App\Models\OM\OverdueDebt\PaymentMatchInvoices;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\CreditGroup;
use App\Models\OM\OverdueDebt\PaymentApplyCNDN;
use App\Models\OM\SaleConfirmation\OrderLines;
use DateTime;
use Illuminate\Http\Request;

class OverdueDebtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $menu = Menu::where('program_code', 'OMP0065')->first();
        // dd($menu);
        view()->share('menu', $menu);
    }

    public function index()
    {

        $customerList = Customers::where('status', 'Active')->where('sales_classification_code', 'Export')->whereNull('deleted_at')->orderBy('customer_number', 'asc')->get();

        return view('om.overdue_debt.index', compact('customerList'));
        // return view('om.overdue_debt.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
