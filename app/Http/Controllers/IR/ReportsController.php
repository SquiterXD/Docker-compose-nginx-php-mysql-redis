<?php

namespace App\Http\Controllers\IR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IR\PtirStockHeaderExport;
use App\Exports\IR\IRR2010;
use App\Exports\IR\IRR6010;
use App\Models\IR\Views\PtirStockHeadersView;
use App\Models\IR\Views\PtirStockLinesView;
use App\Repositories\Report\ReportRepo;
use App\Models\IR\PtirStockHeaders;
use App\Models\IR\PtirStockLines;
use App\Models\IR\Settings\PtirPolicyGroupSets;
use App\Models\IR\Settings\PtirPolicyGroupDists;
use App\Models\IR\Settings\PtirCompanies;
use App\Models\IR\PtirPolicyGroupLine;
use App\Models\Lookup\ValueSetup;
use App\Models\IR\Views\PtirReportStockV;
use App\Models\IR\Views\PtirReportAssetV;
use App\Models\ProgramInfo;

use FormatDate;
use Carbon\Carbon;

use Illuminate\Support\Facades\Cache;
use PDF;


class ReportsController extends Controller
{
    public function index()
    {
        // dd(route('ir.ajax.ir-report-get-info'));
        $url = (Object)[];
        $url->getInfor = route('ir.ajax.ir-report-get-info');

        $url->getInfoAttribute =route('ir.ajax.ir-report-get-info-attribute');
        $url->getParam = route('ir.report.get-param');

        return view('ir.reports.index', [
            'url' => $url,

        ]);
    }

    public function export($programCode, $request)
    {

        if ($programCode=='IRR1110') {
            return  $this->exportPdf($programCode, $request);
            // return \Excel::download(new PtirStockHeaderExport, $programCode.'.xlsx');
        }

        if ($programCode=='IRR0003') {
            return  $this->IRR0003($programCode, $request);
            // return \Excel::download(new IRR2010, $programCode.'.xlsx');
        }

        if ($programCode=='IRR0015') {
            return  (new \App\Http\Controllers\IR\Reports\IRR0015Controller)->export($programCode, $request);
            // return \Excel::download(new IRR2010, $programCode.'.xlsx');
        }

        if ($programCode=='IRR2060') {
            return  (new \App\Http\Controllers\IR\Reports\IRR2060Controller)->export($programCode, $request);
            // return \Excel::download(new IRR2010, $programCode.'.xlsx');
        }

        // return \Excel::download(new PtirStockHeaderExport, $programCode.'.xlsx');

    }

    public function report()
    {
        $programCode='IRR1010';
        $year=null;
        $policySetHeaderId=null;

        $ptirStockHeaders = PtirStockHeadersView::where('program_code', 'IRP0001')
                                ->get()
                                ->groupBy('policy_set_header_id');
                        return view('ir.reports.irr1010.excel', compact('ptirStockHeaders'));

        if ($programCode=='IRR1010') {
            return \Excel::download(new PtirStockHeaderExport, $programCode.'.xlsx');
        }

        // return \Excel::download(new PtirStockHeaderExport, $programCode.'.xlsx');

    }

    public function getParam()
    {
        $code =  request()->program_code;
        $module = substr($code, 0, 2);
        return (new ReportRepo)->mapReport($module,$code, request());
    }

    public function exportPdf($programCode, $request)
    {   
        // dd('xxx');
        $timeStart = microtime(true);
        $request            = (object)$request;
        ini_set('max_execution_time', 1000);
        set_time_limit(1000);
        $date = [];
        $yearHT = FormatDate::Yearonly($request->period_year);
        $program =  ProgramInfo::where('program_code', $request->program_code)->first();

        // dd(FormatDate::dateFormatThaiString('02'));
        $month = 'ปีงบประมาณ '.$yearHT;
        $date['year'] = $yearHT;
        $date['month'] = $month;

        $period = ValueSetup::where('LOOKUP_TYPE', "PTIR_EFFECTIVE_DATE")
                ->where('LOOKUP_CODE', $request->period_year)
                ->orderBy('LOOKUP_CODE')
                ->first();

        $valueSet =  explode(' - ' ,$period->meaning);
        $fromDate =Carbon::createFromFormat('d/m/Y', $valueSet[0])->format('Y-m-d') ;
        $endDate  = Carbon::createFromFormat('d/m/Y', $valueSet[1])->format('Y-m-d') ;


        $data = [];
        $userProfile        = getDefaultData('/ir/reports');
        $hasCompanyAll      = $request->company_from    && $request->company_to;
        $noCompany          = !$request->company_from   && !$request->company_to;
        $startCompany       = $request->company_from    && !$request->company_to;
        $toCompany          = !$request->company_from    && $request->company_to;

        $companies = null;
        // dd($request);
        $header = [];

       
        $reportStocks = PtirReportStockV::
                    where('program_code', 'IRP0001')
                    // ->whereRaw('rownum <= 10')
                    ->where('status' , '!=', 'CANCELLED')
                    ->where('year', $request->period_year)
                    ->whereBetween('department_code', [(int)$request->dept_from, (int)$request->dept_to])
                    ->when($request->policy_set, function($q) use($request) {
                        $q->where('policy_set_header_id', $request->policy_set);
                    })
                    ->when($request->inv, function($q) use($request) {
                        $q->where('sub_inventory_code', $request->inv);
                    })
                    ->when($request->location, function($q) use($request) {
                        $q->where('location_code', $request->location);
                    })
                    // ->when($request->transaction_type, function($q) use($request) {
                    //     $q->where('line_type', $request->transaction_type);
                    // })
                    // ->when($request->status, function($q) use($request) {
                    //     $q->where('status_head', $request->status);
                    // })
                    ->when($hasCompanyAll, function($q) use($request) {
                        $q->where('company_id', '>=', $request->company_from)
                            ->where('company_id', '<=', $request->company_from);
                    })
                    ->when($startCompany, function($q) use($request) {
                        $q->where('company_id', '>=', $request->company_from);
                    })
                    ->when($toCompany, function($q) use($request) {
                        $q->where('company_id', '<=', $request->company_to);
                    })
                    ->get();

        // dd($reportStocks);


                    // dd($reportStocks->pluck('line_type'));
                    // dd($reportStocks->groupBy(function($q) {
                    //     return $q->item_code.'_'.$q->line_type;
                    //     }));
        // $reportStocks = $reportStocks->unique('line_id');
        // $reportStocks = $reportStocks->where('location_code', '060')
        //                                 ->where('department_code', '33000500')
        //                                 ->where('sub_inventory_code', 'PURROJ04')
        //                                 ->where('year', '2022');
        // dd($reportStocks->sum('coverage_amount'));
        // dd($reportStocks->unique('line_id'));



            // dd(periodFromToIR());

                if($request->company_from ||  $request->company_to){
                    $companies =  $reportStocks->unique('company_id');
                }

                if(count($reportStocks) == 0){
                    return view('ir.reports.irr1110.not-found');
                }

                // dd(date('Y-m-d', strtotime($fromDate)) ,  Carbon::createFromDate($fromDate)->format('M'));
                // dd($reportStocks);

                $periodFromToIR =  periodFromToIR($reportStocks[0]->period_from , $reportStocks[0]->period_to);
                // dd($periodFromToIR);
                $period =  periodFromToIR($reportStocks[0]->start_year_period , $reportStocks[0]->end_year_period);
                // return view('ir.reports.irr1110.pdf.index',compact('reportStocks', 'companies', 'date', 'programCode', 'periodFromToIR', 'program','userProfile','userProfile'));
                $pdf = \PDF::loadView('ir.reports.irr1110.pdf.index',compact('reportStocks', 'companies', 'date', 'programCode', 'periodFromToIR', 'program','userProfile','userProfile'))
                    // ->setOption('header-html',view('ir.reports.irr1110.pdf.header',compact('reportStocks', 'companies', 'date', 'programCode', 'userProfile', 'periodFromToIR', 'program')))
                    // ->setOption('footer-html', view('ir.reports.irr1010.pdf.header',compact('reportStocks')))
                    ->setOption('margin-top','5')
                    // ->setOption('margin-bottom','40')
                    ->setOption('encoding','UTF-8')

                    ->setOption('javascript-delay', 5000)
                    ->setOption('debug-javascript', true)
                    ->setOption('no-stop-slow-scripts', true)
                    ->setOption('header-font-size', 9)
                    ->setOption('header-right',"\n\n\n\n[page]/[topage]\t\t\t\t\t\t\t\t\t\t\t\t")
                    ->setOption('orientation', "Landscape")
                    ->setPaper('a4');
                return $pdf->stream($program->program_code. '.pdf');

    }

    public function IRR1010($programCode, $request)
    {       
        // dd($programCode, $request);
        $data = [];

        $request            = (object)$request;
        $hasCompanyAll      = $request->company_from    && $request->company_to;
        $noCompany          = !$request->company_from   && !$request->company_to;
        $startCompany       = $request->company_from    && !$request->company_to;
        $toCompany          = !$request->company_from    && $request->company_to;
        $userProfile        = getDefaultData('/ir/reports');

        $program =  ProgramInfo::where('program_code', $request->program_code)->first();
        ini_set('max_execution_time', 1000);
        set_time_limit(1000);
        $date = [];

        $start = date('Y-d-m', strtotime($request->from_month));

        $yearFrom = date('Y', strtotime($request->from_month))+543;
        // $period = ValueSetup::where('LOOKUP_TYPE', "PTIR_EFFECTIVE_DATE")
        //         ->where('LOOKUP_CODE', date('Y', strtotime($request->from_month)))
        //         ->orderBy('LOOKUP_CODE')
        //         ->first();
        // dd( $period);
        $startMonth = Carbon::createFromDate($start)->format('M');
        $backTOMonth    =  Carbon::createFromDate($start)->addMonths(-1)->format('M');

        $periodName  = Carbon::createFromDate($start)->format('M-y');
        $periodBackName  = Carbon::createFromDate($start)->format('M-y');

        $fromMonth = FormatDate::Monthonly($startMonth);
        $backMonth = FormatDate::Monthonly($backTOMonth);
        // $endMonth = FormatDate::Monthonly($endMonth);

        $month = 'เดือนปิดบัญชี '. $fromMonth. ' '. $yearFrom;
        $periodBackName =  'ข้อมูลคงคลังย้อนหลังของเดือน '.$backMonth.' '. (Carbon::createFromDate($start)->addMonths(-1)->format('Y')+543);
        $date['month'] = $month;
        $date['month_off'] = $periodBackName;

        // dd(strtoupper($periodName));
        $companies = null;

        $header = [];
        
        $reportStocks = PtirReportStockV::where('program_code', 'IRP0002')
                    // ->whereRaw('rownum <= 20')
                    ->where('status' , '!=', 'CANCELLED')
                    ->when($request->policy_set, function($q) use($request) {
                        $q->where('policy_set_header_id', $request->policy_set);
                    })
                    ->where('period_name', strtoupper($periodName))
                    ->whereBetween('department_code', [(int)$request->dept_from, (int)$request->dept_to])

                    ->when($request->inv, function($q) use($request) {
                        $q->where('sub_inventory_code', $request->inv);
                    })
                    ->when($request->location, function($q) use($request) {
                        $q->where('location_code', $request->location);
                    })
                    ->when($request->transaction_type, function($q) use($request) {
                        $q->where('line_type', $request->transaction_type);
                    })
                    // ->when($request->status, function($q) use($request) {
                    //     $q->where('status_head', $request->status);
                    // })
                    ->when($hasCompanyAll, function($q) use($request) {
                        $q->where('company_id', '>=', $request->company_from)
                            ->where('company_id', '<=', $request->company_from);
                    })
                    ->when($startCompany, function($q) use($request) {
                        $q->where('company_id', '>=', $request->company_from);
                    })
                    ->when($toCompany, function($q) use($request) {
                        $q->where('company_id', '<=', $request->company_to);
                    })
                    ->get();


                    if($request->company_from ||  $request->company_to){
                        $companies =  $reportStocks->unique('company_id');
                    }

                    // dd($companies);
                    if(count($reportStocks) == 0){
                        return view('ir.reports.irr1010.not-found');
                    }
        // dd($reportStocks->pluck('year'));

                $pdf = \PDF::loadView('ir.reports.irr1010.pdf.index',compact('reportStocks', 'companies', 'date', 'programCode', 'userProfile', 'program'))
                    // ->setOption('header-html',view('ir.reports.irr1010.pdf.header',compact('reportStocks', 'companies', 'date', 'programCode', 'userProfile', 'program')))
                    // ->setOption('footer-html', view('ir.reports.irr1010.pdf.header',compact('reportStocks')))
                    ->setOption('margin-top','7')
                    ->setOption('margin-bottom','6')
                    ->setOption('encoding','UTF-8')
                    ->setOption('lowquality', false)
                    ->setOption('disable-smart-shrinking', false)
                    ->setOption('print-media-type', true)
                   ->setOption('orientation', "Landscape")
                   ->setOption('header-font-size', 8)
                   ->setOption('header-right',"\n\n\n\n\n[page]/[topage]\t\t\t\t\t\t\t\t\t\t\t\t\t")
                    ->setPaper('a4');
                return $pdf->stream($program->program_code. '.pdf');

    
    }

    public function IRR0003($programCode, $request)
    {
        ini_set('max_execution_time', 1000);
        set_time_limit(1000);


        $request = (object)request()->all();

        $program =  ProgramInfo::where('program_code', $request->program_code)->first();

        $splitCompany = $request->policy_type == 'yes' ? true :false;
        $reportType = $request->report_type;
        $company = $request->company;
        $policySetSelected = $request->policy_set;
        $period = ValueSetup::where('LOOKUP_TYPE', "PTIR_EFFECTIVE_DATE")
                ->where('LOOKUP_CODE', $request->period_year)
                ->orderBy('LOOKUP_CODE')
                ->first();
        $periodDate =  explode(' - ' ,$period->description);
        $fromDate = $periodDate[0];
        $endDate  = $periodDate[1];

        $periodYear =  $request->period_year;
      
        $ptirStockHeaders = PtirStockHeaders::where('program_code', 'IRP0001')
        ->where('year', $period->lookup_code)
        ->when($policySetSelected, function($q) use ($policySetSelected) {
            $q->where('policy_set_header_id', $policySetSelected);
        })
        ->when($request->status, function($q) use ($request){
            $q->where('status', $request->status);
        })
        ->when(!$request->status, function($q) use ($request){
            $q->where('status', "!=", "CANCELLED");
        })
        ->get();

        $policyGroupSet =  PtirPolicyGroupSets::whereIn('policy_set_header_id', $ptirStockHeaders->groupBy('policy_set_header_id')->keys())
                                                ->get(['group_set_id',
                                                    'group_header_id',
                                                    'policy_set_header_id'
                                                ])
                                                ->groupBy('group_header_id');

        $ptirPolicyGroupDists = PtirPolicyGroupDists::whereIn('group_header_id',  $policyGroupSet->keys())
                                ->when($company, function($q) use ($company) {
                                    $q->where('company_id', $company);
                                })
                                ->get();


        $policyGroupLine = PtirPolicyGroupLine::where('year', $period->lookup_code)
                       -> whereIn('group_header_id', $policyGroupSet->keys())
                        ->get();

        $companies = PtirCompanies::whereIn('company_id', $ptirPolicyGroupDists->pluck('company_id'))
                                    ->where('active_flag', 'Y')
                                    ->get();


        $ptirStockHeaders = $ptirStockHeaders->sortBy('policy_set_header_id')
            ->groupBy(function($item, $key){
                return $item->policy_set_header_id. ' '.$item->policy_set_description;
            });


        $data = [];
        foreach ($ptirStockHeaders as $key => $value) {
            // $data[$key] = PtirStockLines::whereIn('header_id', $value->pluck('header_id'))->get();
             $data[$key] = PtirStockLinesView::whereIn('header_id', $value->pluck('header_id'))
                            // ->where("numrow <= 100")
                            ->get();
        }

        $ptirStockHeaders = $data;

        $thaimonths = ['01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม','06'=>'มิถุนายน',
                       '07'=>'กรกฎาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม'];

        // $pdf = PDF::loadView('ir.reports.irr2010.pdf.index',
        //                 compact(
        //                     'ptirStockHeaders',
        //                     'programCode',
        //                     'companies',
        //                     'policyGroupLine',
        //                     'ptirPolicyGroupDists',
        //                     'splitCompany',
        //                     'reportType',
        //                     'company',
        //                     'period',
        //                     'program',
        //                     'periodYear', 
        //                     'periodDate',
        //                     'thaimonths',
        //                 ))
        //             // ->setOption('header-html',view('ir.reports.irr2010.pdf._header',compact('programCode')))
        //             ->setOption('encoding','UTF-8')
        //             ->setOption('margin-top','10')
        //             ->setOption('margin-bottom','10')
        //             ->setOption('print-media-type', true)
        //             ->setPaper('a4')
        //             // ->setOrientation('landscape')
        //             ->setOption('header-font-size', 9)
        //             ->setOption('header-right',"\n\n\n\n\n[page]/[topage]\t");
        //             // ->setOption('footer-center', 'Page [page] of [toPage]');

    $pdf = \PDF::loadView('ir.reports.irr2010.new.index',compact('ptirStockHeaders', 'programCode', 'companies', 'policyGroupLine', 'ptirPolicyGroupDists', 'splitCompany', 'reportType', 'company', 'period', 'program', 'periodYear', 'periodDate', 'thaimonths'))
                ->setOption('header-html',view('ir.reports.irr2010.new.header',compact('ptirStockHeaders', 'programCode', 'companies', 'policyGroupLine', 'ptirPolicyGroupDists', 'splitCompany', 'reportType', 'company', 'period', 'program', 'periodYear', 'periodDate', 'thaimonths')))
                ->setOption('margin-top','50')
                ->setOption('margin-bottom','25')
                ->setOption('encoding','UTF-8')
                ->setOption('lowquality', false)
                ->setOption('disable-javascript', true)
                ->setOption('disable-smart-shrinking', false)
                ->setOption('print-media-type', true)
                ->setPaper('a4');


        return $pdf->stream($program->program_code. '.pdf');
    }

    public function IRR6010($programCode, $request)
    {       
            ini_set('max_execution_time', 1000);
            set_time_limit(1000);

            $data = [];
            $request            = (object)request()->all();
            // dd( $request );
            $hasCompanyAll      = $request->company_from    && $request->company_to;
            $noCompany          = !$request->company_from   && !$request->company_to;
            $startCompany       = $request->company_from    && !$request->company_to;
            $toCompany          = !$request->company_from    && $request->company_to;
            $hasCompany         = $request->company_from    || $request->company_to;

            // +"company_from": "2"
            // +"company_to": "7"

            // dd($request,$hasCompanyAll,$noCompany ,$startCompany,  $toCompany ,$hasCompany);
            // $assetsByPolicy = PtirReportAssetV::where('program_code','IRP0003')
            //             ->whereBetween('policy_set_number', [(int)$request->policy_set_header_from, (int)$request->policy_set_header_to])
            //             ->where('year_head' ,$request->period_year)
            //             ->when($hasCompanyAll, function($q) use($request) {
            //                 $q->whereBetween('company_id', [(int)$request->company_from, (int)$request->company_to]);
            //             })
            //             ->when($startCompany, function($q) use($request) {
            //                 $q->where('company_id', '>=', $request->company_from);
            //             })
            //             ->when($toCompany, function($q) use($request) {
            //                 $q->where('company_id', '<=', $request->company_to);
            //             })
            //             ->when($request->status, function($q) use($request){
            //                 $q->where('status' , $request->status);
            //             })
            //             ->when($request->location_code_from ,function($q) use($request){
            //                 $q->where('location_code', '=>' ,  $request->location_code_from);
            //             })
            //             ->when($request->location_code_to ,function($q) use($request){
            //                 $q->where('location_code', '=>' ,  $request->location_code_to);
            //             })
            //             ->where('company_active_flag', 'Y')
            //             ->orderBy('policy_set_number')
            //             ->get() ;


            // if(count($assetsByPolicy) == 0){
            //     return view('ir.reports.irr1010.not-found');
            // }

            // $strDate = FormatDate::DateThai($assetsByPolicy[0]->start_year_period);
            // $endDate = FormatDate::DateThai($assetsByPolicy[0]->end_year_period);
            // $dateDisplay =  $strDate. ' - ' . $endDate;

            // if($hasCompany){
            //     $companies = $assetsByPolicy->unique('company_code');
            //     return view('ir.reports.irr6010.excel-company', compact('assetsByPolicy', 'companies', 'dateDisplay'));
            // } else {
            //     return view('ir.reports.irr6010.excel', compact('assetsByPolicy', 'dateDisplay'));
            // }
 
        return \Excel::download(new IRR6010, $programCode.'.xlsx');


    }

    
}
