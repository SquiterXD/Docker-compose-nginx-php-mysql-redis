<?php

namespace App\Repositories\Report\Traits;
use  App\Http\Controllers\IR\ReportsController;
use  App\Http\Controllers\IR\Reports\IRR8010Controller;
use  App\Http\Controllers\IR\Reports\IRR8020Controller;
use  App\Http\Controllers\IR\Reports\IRR8030Controller;
use  App\Http\Controllers\IR\Reports\IRR2030AController;
use  App\Http\Controllers\IR\Reports\IRR9130Controller;
use  App\Http\Controllers\IR\Reports\IRR9140Controller;
use  App\Http\Controllers\IR\Reports\IRR0015Controller;
use  App\Http\Controllers\IR\Reports\IRR2060Controller;
use  App\Http\Controllers\CT\Reports\CTRP0097Controller;
use FormatDate;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\IR\PtirStockLines;
use App\Exports\IR\IRR0001;
use App\Exports\OM\OMR0072Ex;
use App\Models\OM\SequenceEcoms;
use App\Http\Controllers\CT\Reports\CTReports1Controller;

use  App\Http\Controllers\IR\Reports\IRR0005_3Controller;
use  App\Http\Controllers\IR\Reports\IRR0009_1Controller;
use  App\Http\Controllers\IR\Reports\IRR0009_2Controller;
use  App\Http\Controllers\IR\Reports\IRR0081_1Controller;
use  App\Http\Controllers\IR\Reports\IRR0009_3Controller;
use  App\Http\Controllers\IR\Reports\IRR0081_3Controller;
use  App\Http\Controllers\IR\Reports\IRR0006Controller;

use App\Http\Controllers\CT\Reports\CTR0038Controller;
use App\Http\Controllers\CT\Reports\CTR0041Controller;

trait ReportMcr {

    public function IRR0001($programCode, $request) {
        return   (new ReportsController)->export($programCode, $request->all());
    }

    public function IRR1110($programCode, $request) {
        // dd($programCode, $request);
        return   (new ReportsController)->export($request->function_name, $request->all());
    }
    public function IRR1010($programCode, $request) {
        return   (new ReportsController)->IRR1010($request->function_name, $request->all());
    }

    //Piyawut A. 16102021 -- Report IR
    // 1. AP Interface
    public function IRR8010($programCode, $request) {
        return (new IRR8010Controller)->export($programCode, $request);
    }

    // 2. GL Monthly
    public function IRR8020($programCode, $request) {
        return (new IRR8020Controller)->export($programCode, $request);
    }

    // 3. AR Interface
    public function IRR8030($programCode, $request) {
        return (new IRR8030Controller)->export($programCode, $request);
    }

    // 4. GL Average Monthly
    public function IRR2030A($programCode, $request) {
        return (new IRR2030AController)->export($programCode, $request);
    }

    // 5. IRR9130 claim agency
    public function IRR9130($programCode, $request) {
        return (new IRR9130Controller)->export($programCode, $request);
    }

    // 6. IRR9130 claim Finance
    public function IRR9140($programCode, $request) {
        return (new IRR9140Controller)->export($programCode, $request);
    }

    public function IRR0003($programCode, $request) {
        // dd($programCode, $request->function_name);
        return   (new ReportsController)->export($request->function_name, $request->all());
    }

    public function IRR0015($programCode, $request) {
        return (new IRR0015Controller)->export($programCode, $request);
    }

    public function IRR2060($programCode, $request) {
        return (new IRR2060Controller)->export($programCode, $request);
    }

    public function PDR0671($programCode, $request) {

        $profile = getDefaultData(\Request::path());

        $urlHost = request()->getHttpHost();
        $departmentCode = 61000200;

        $startDate  =  \Carbon\Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
        $endDate    =  \Carbon\Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
        $url = '/pm/sample-report-summary-pdf/'.$profile->organization_code.'/'.$startDate.'/'.$endDate;

        return redirect($url);
    }
    
    public function OMR0072Ex($programCode, $request) {

        // Export Excel
        return \Excel::download(new OMR0072Ex, $programCode.'.xlsx');

        // Export PDF
        $tests = SequenceEcoms::where('stamp', '20')->get();

        $pdf = PDF::loadView('om.reports.OMR0072Ex.index', compact('tests'))
                    ->setPaper('a4')
                    ->setOrientation('landscape')
                    ->setOption('margin-bottom', 10)
                    ->setOption('footer-center', 'Page [page] of [toPage]');

        return $pdf->stream($programCode. '.pdf');
    }


    public function IRR0001PDF($programCode, $request)
    {
        dd(request()->all());
        // $request  = parameter
        //log parameter  ex. dd($request->all())
        $date = [];

        $yearHT = FormatDate::Yearonly($request->period_year);

        $fromMonth = FormatDate::Monthonly('Jan');
        $endMonth = FormatDate::Monthonly('May');

        if ($request->from_month==null && $request->end_month==null) {
            $month = 'ปีงบประมาณ '.$yearHT;
        }else{
            $fromMonth = FormatDate::Monthonly('Jan');
            $endMonth = FormatDate::Monthonly('May');
            $month = 'เดือน '. $fromMonth. ' '. $yearHT.' ถึง '.$endMonth. ' '. $yearHT;
        }



        $date['year'] = $yearHT;
        $date['month'] = $month;

        // model , quire
        $ptirStockHeaders = PtirStockLines::where('program_code', 'IRP0001')
                            ->when($request->period_year, function($q) use($request) {
                                $q->where('year', $request->period_year);
                            })
                            ->when($request->policy_set, function($q) use($request) {
                                $q->where('policy_set_header_id', $request->policy_set);
                            })
                            ->when($request->inv, function($q) use($request) {
                                $q->where('sub_inventory_code', $request->inv);
                            })
                            ->when($request->location, function($q) use($request) {
                                $q->where('location_code', $request->location);
                            })
                            // ->when($request['transaction_type'], function($q) use($request) {
                            //     $q->where('line_type', $request['transaction_type']);
                            // })
                            ->where('status', '!=', 'CANCELLED')
                            ->get()
                            ->sortBy('ptirPolicySetHeader.policy_set_number')
                            ->groupBy(function($item, $key){
                                return $item->ptirPolicySetHeader->policy_set_number. ' '.$item->ptirPolicySetHeader->policy_set_description;
                            });

        // view balde , html
        $pdf = PDF::loadView('ir.reports.irr1010.pdf.index',
                        compact(
                            'ptirStockHeaders',
                            'programCode',
                            'date'
                        ))
                    ->setPaper('a4')
                    ->setOrientation('landscape')
                    ->setOption('margin-bottom', 10)
                    ->setOption('footer-center', 'Page [page] of [toPage]');

        return $pdf->stream($programCode. '.pdf');
    }

    public function IRR0001EXCEL($programCode, $request)
    {
        return \Excel::download(new IRR0001, $programCode.'.xlsx');
    }

    public function IRR6010($programCode, $request){
        return  (new ReportsController)->IRR6010($programCode, $request);
    }

    public function IRR0005_3($programCode, $request) {
        return (new IRR0005_3Controller)->export($programCode, $request);
    }

    public function IRR0009_1($programCode, $request) {
        return (new IRR0009_1Controller)->export($programCode, $request);
    }

    public function IRR0009_2($programCode, $request) {
        return (new IRR0009_2Controller)->export($programCode, $request);
    }

    public function IRR0081_1($programCode, $request) {
        return (new IRR0081_1Controller)->export($programCode, $request);
    }

    public function IRR0009_3($programCode, $request) {
        return (new IRR0009_3Controller)->export($programCode, $request);
    }

    public function IRR0081_3($programCode, $request) {
        return (new IRR0081_3Controller)->export($programCode, $request);
    }

    public function IRR0006($programCode, $request) {
        return (new IRR0006Controller)->export($programCode, $request);
    }

    // CT  #  //
    //CTRP0097 พี่ชมพู่
    public function CTRP0097($programCode, $request){
        return  (new CTRP0097Controller)->exportExcel($programCode, $request);
    }



    //CTR0001 
    public function CTR0001($programCode, $request){
        return  (new CTReports1Controller)->CTR0001Excel($programCode, $request);
    }

    //CTR0002 
    public function CTR0002($programCode, $request){
        return  (new CTReports1Controller)->CTR0002Excel($programCode, $request);
    }

    //CTR0003 
    public function CTR0003($programCode, $request){
        return  (new CTReports1Controller)->CTR0003Excel($programCode, $request);
    }

    //CTR0004 
    public function CTR0004($programCode, $request){
        return  (new CTReports1Controller)->CTR0004Excel($programCode, $request);
    }

    //CTR0008 
    public function CTR0008($programCode, $request){
        return  (new CTReports1Controller)->CTR0008Excel($programCode, $request);
    }

    //PDR1150 
    public function PDR1150($programCode, $request){
        $request = (object)$request->all();

        $param = [
            'report_code' =>  $request->program_code,
            'date_from' =>  Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d'),
            'date_to' =>  Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d'),
            'batch_no_from' =>  $request->batch_from ?? 'ALL',
            'batch_no_to' =>  $request->batch_to ?? 'ALL',
            'wip_step_from' =>  $request->wip_step_from ?? 'ALL',
            'wip_step_to' =>  $request->wip_step_to ?? 'ALL',
            'item_number' =>  $request->item_number ?? 'ALL',
            'org' =>  $request->org ?? null

        ];
        return redirect()->route('pm.wip-confirm.get-export-pdf', $param );

    }

    public function PDR1180($programCode, $request){
        $request = (object)$request->all();
        // dd($request);
        $param = [
            'report_code' =>  $request->program_code,
            'date_from' =>  Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d'),
            'date_to' =>  Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d'),
            'batch_no_from' =>  $request->batch_from ?? 'ALL',
            'batch_no_to' =>  $request->batch_to ?? 'ALL',
            'wip_step_from' =>  $request->wip_step_from ?? 'ALL',
            'wip_step_to' =>  $request->wip_step_to ?? 'ALL',
            'item_number' =>  $request->item_number ?? 'ALL',
            'org' =>  $request->org ?? null

        ];
        return redirect()->route('pm.wip-confirm.get-export-pdf', $param );

    }

    public function PDR2040($programCode, $request){
        $request = (object)$request->all();

        $param = [
            'report_code' =>  $request->program_code,
            'date_from' =>  Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d'),
            'date_to' =>  Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d'),
            'batch_no_from' =>  $request->batch_from ?? 'ALL',
            'batch_no_to' =>  $request->batch_to ?? 'ALL',
            'wip_step_from' =>  $request->wip_step_from ?? 'ALL',
            'wip_step_to' =>  $request->wip_step_to ?? 'ALL',
            'item_number' =>  $request->item_number ?? 'ALL',
            'org' =>  $request->org ?? null

        ];
        return redirect()->route('pm.wip-confirm.get-export-pdf', $param );

    }

    //CTR0009 
    public function CTR0009($programCode, $request){
        return  (new CTReports1Controller)->CTR0009Excel($programCode, $request);
    }

    //CTR0010 
    public function CTR0010($programCode, $request){
        return  (new CTReports1Controller)->CTR0010Excel($programCode, $request);
    }

    //CTR0011 
    public function CTR0011($programCode, $request){
        return  (new CTReports1Controller)->CTR0011Excel($programCode, $request);
    }

    //CTR0038 
    public function CTR0038($programCode, $request){
        return  (new CTR0038Controller)->CTR0038Excel($programCode, $request);
    }

    //CTR0041 
    public function CTR0041($programCode, $request){
        return  (new CTR0041Controller)->export($programCode, $request);
    }
}
