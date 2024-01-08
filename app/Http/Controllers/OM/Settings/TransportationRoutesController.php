<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\Settings\TransportationRoute;

use App\Models\OM\Settings\DayV;
use App\Models\OM\Settings\CustomerShipSiteV;
use App\Models\OM\Settings\Customer;


class TransportationRoutesController extends Controller
{
    public function index()
    {
        // $tranSportRoutes = TransportationRoute::get();
        
        // $tranSportRoutes2 = TransportationRoute::with('customer', function ($q) {
        //     $q->orderBy('customer_number', 'asc');
        // })->get();

        // $header      = TransportationRoute::with('customer')->orderBy('customer.customer_number', 'asc')->get();

        // $tranSportRoutes =  \DB::table('ptom_transport_routes')
        //             ->select('ptom_transport_routes.*', 'ptom_customers.customer_number')
        //             ->join('ptom_customers', 'ptom_customers.customer_id','=','ptom_transport_routes.customer_id')
        //             // ->join('ptw_projects', 'ptw_projects.id','=','ptw_project_alignments.project_id')
        //             // ->whereHas('project')
        //             ->orderBy('ptom_customers.customer_number', 'asc')
        //             ->get();

        $tranSportRoutes = TransportationRoute::with(['customer' => function ($q){
                        $q->orderBy('customer_number', 'asc');
                    }])
                    ->get();


        // dd($header);
        return view('om.settings.transportation-routes.index', compact('tranSportRoutes'));
    }


    public function create()
    {
        $days = DayV::where('enabled_flag', 'Y')->orderBy('lookup_code', 'asc')->get();
        $customers = Customer::where('sales_classification_code', 'Domestic')
                                ->where('status', 'Active')
                                ->orderBy('customer_number', 'asc')
                                ->get();

        // dd($customers);

        return view('om.settings.transportation-routes.create', compact('days',  'customers'));
    }


    public function store(Request $request)
    {
        request()->validate([
            'customer_id'             => 'required',
            'time_of_day'             => 'required',
            // 'standard_transport_day'  => 'required',
            // 'standard_transport_time' => 'required',
        ], [
            'customer_id.required'             => 'เลือก ร้านค้า',
            'time_of_day.required'             => 'เลือก ช่วงเวลามาตราฐานการส่งมอบ',
            // 'standard_transport_day.required'  => 'เลือก วันมาตราฐานการส่งมอบ',
            // 'standard_transport_time.required' => 'เลือก เวลามาตราฐานการส่งมอบ',
        ]);

        // dd('xxx', request()->all());

        if (request()->start_date && request()->end_date) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                // return redirect()->back()->with('error', 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้');
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        $old = TransportationRoute::where('customer_id', request()->customer_id)->orderBy('transport_id', 'desc')->first();

        if ($old) {
            if ($old->end_date) {
                if (date('Y-m-d', strtotime(request()->start_date)) <= date('Y-m-d', strtotime($old->end_date))) {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'ไม่สามารถเลือกร้านค้าเดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                    ]);
                }
            } else {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกร้านค้าเดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                ]);
            }
        }

        $user                 = auth()->user();
        $standardTransportDay = DayV::where('lookup_code', request()->standard_transport_day)->first();
        $customer             = Customer::find(request()->customer_id);

        $tranSportRoute                          = new TransportationRoute;
        $tranSportRoute->customer_id             = request()->customer_id;
        $tranSportRoute->transport_day           = $customer->delivery_date;
        $tranSportRoute->time_of_day             = request()->time_of_day;
        $tranSportRoute->standard_transport_day  = request()->standard_transport_day;
        $tranSportRoute->standard_transport_time = request()->standard_transport_time;
        $tranSportRoute->program_code            = 'OMS0028';
        $tranSportRoute->created_by              = $user->user_id;
        $tranSportRoute->last_updated_by         = $user->user_id;
        $tranSportRoute->start_date              = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $tranSportRoute->end_date                = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';
        $tranSportRoute->save();

        return redirect()->route('om.settings.transportation-route.index')->with('success', 'บันทึกรายการเรียบร้อย');
    }

    public function edit($id)
    {
        $tranSportRoute  = TransportationRoute::find($id);
        $days            = DayV::where('enabled_flag', 'Y')->orderBy('lookup_code', 'asc')->get();
        $customers       = Customer::where('sales_classification_code', 'Domestic')
                                ->where('status', 'Active')
                                ->orderBy('customer_number', 'asc')
                                ->get();

        return view('om.settings.transportation-routes.edit', compact('tranSportRoute', 'days',  'customers'));
    }


    public function update(Request $request, $id)
    {
        // dd( request()->all());
        request()->validate([
            'time_of_day'             => 'required',
            // 'standard_transport_day'  => 'required',
            // 'standard_transport_time' => 'required',
        ], [
            'time_of_day.required'             => 'เลือก ช่วงเวลามาตราฐานการส่งมอบ',
            // 'standard_transport_day.required'  => 'เลือก วันมาตราฐานการส่งมอบ',
            // 'standard_transport_time.required' => 'เลือก เวลามาตราฐานการส่งมอบ',
        ]);

        if (request()->start_date && request()->end_date) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                // return redirect()->back()->with('error', 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้');
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        $user = auth()->user();
        // $standardTransportDay = DayV::where('lookup_code', request()->standard_transport_day)->first();

        $tranSportRoute                          = TransportationRoute::find($id);
        $tranSportRoute->time_of_day             = request()->time_of_day;
        $tranSportRoute->standard_transport_day  = request()->standard_transport_day;
        $tranSportRoute->standard_transport_time = request()->standard_transport_time;
        $tranSportRoute->last_updated_by         = $user->user_id;
        $tranSportRoute->start_date              = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $tranSportRoute->end_date                = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';
        $tranSportRoute->save();

        return redirect()->route('om.settings.transportation-route.index')->with('success', 'แก้ไขรายการเรียบร้อย');
    }
}
