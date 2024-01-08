<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\PeriodV;
use App\Models\OM\PostponeOrders;
use App\Models\OM\PnHolidayModel;
use App\Repositories\OM\OrderRepo;
use Illuminate\Support\Facades\DB;
use App\Models\OM\Settings\DayV;

class PostponeDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::whereNotNull('customer_number')
                            ->whereRaw("lower(sales_classification_code) = 'domestic'")
                            ->whereRaw("lower(status) = 'active'")
                            ->orderBy('customer_number','ASC')
                            ->get();
        $budgetYear = PeriodV::groupBy('budget_year')->get('budget_year');
        $periodActive = DB::table('ptom_period_v')
                            ->whereDate('end_period','>=',date('Y-m-d'))
                            ->orderBy('end_period','asc')
                            ->first();
        $period = DB::table('ptom_period_v')
                    ->where('budget_year',$periodActive->budget_year)
                    ->orderBy('period_no','asc')
                    ->get();
        $deliveryDates = DayV::orderBy('lookup_code','asc')
                            ->whereNotNull('tag')
                            ->where('enabled_flag', 'Y')
                            ->get();


        return  view('om.postpone_delivery.index',
                compact('customers', 'budgetYear', 'period', 'periodActive', 'deliveryDates'));
    }

    public function search(Request $request)
    {
        $customers = Customer::whereNotNull('customer_number')->whereRaw("lower(sales_classification_code) = 'domestic'")->whereRaw("lower(status) = 'active'")->orderBy('customer_number','ASC')->get();
        $postpone = [];
        $budgetYear = PeriodV::groupBy('budget_year')->get('budget_year');
        $periodActive =  DB::table('ptom_period_v')
                            ->whereDate('end_period','>=',date('Y-m-d'))
                            ->orderBy('end_period','asc')
                            ->first();         
        $period =  DB::table('ptom_period_v')
                    ->where('budget_year',$periodActive->budget_year)
                    ->orderBy('period_no','asc')
                    ->get();

        if($request->year){
            $period = PeriodV::where('budget_year',$request->year)->get();
        }
        $deliveryDates = DayV::orderBy('lookup_code','asc')
                            ->whereNotNull('tag')
                            ->where('enabled_flag', 'Y')
                            ->get();


        return  view('om.postpone_delivery.search',
                compact('customers', 'postpone', 'budgetYear', 'period', 'periodActive', 'deliveryDates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
