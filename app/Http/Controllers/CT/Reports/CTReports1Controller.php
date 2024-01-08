<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CT\PtctCostTransactionsV;
use App\Exports\CT\CTR0001;
use App\Exports\CT\CTR0002ByBatch;
use App\Exports\CT\CTR0002ByItem;
use App\Exports\CT\CTR0003Detail;
use App\Exports\CT\CTR0003;
use App\Exports\CT\CTR0004;
use App\Exports\CT\CTR0004ByItem;
use App\Exports\CT\CTR0008;
use App\Exports\CT\CTR0009;
use App\Exports\CT\CTR0010;
use App\Exports\CT\CTR0011;
use App\Models\CT\PtctTtctrp97;
use App\Models\CT\PrctCtr0004;
use App\Models\CT\PtctCtr0009;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use PDO;

class CTReports1Controller extends Controller
{
    public function CTR0001Excel($programCode, $request)
    {
        // $request = (object)$request->all();

        // $data = [];
        // $request            = (object)request()->all();
        // $dateFrom           = $request->transaction_date_from;
        // $dateTo             = $request->transaction_date_to;
        // $userProfile        = getDefaultData('/ct/reports');
        // $cost =  costCenter($request->cost_code);

        // $transactions = PtctCostTransactionsV::
        //                 whereRaw("to_date(period_name, 'Mon-YY') BETWEEN  to_date('".$request->transaction_date_from."', 'Mon-YY')  AND to_date('".$request->transaction_date_to."', 'Mon-YY')")
        //                 ->when($request->cost_code, function($q) use ($request) {
        //                     $q->where('cost_code' , $request->cost_code);
        //                 })
        //                 ->when($request->status, function($q) use ($request) {
        //                     $q->where('gl_interface_flag' , $request->status);
        //                 })  
        //                 ->orderBy('seq')
        //                 ->get();

        // return view('ct.Reports.ctr0001.excel.index', compact('transactions', 'userProfile', 'cost'));
        return \Excel::download(new CTR0001, $programCode . '.xlsx');
    }


    public function CTR0002Excel($programCode, $request)
    {
        if ($request->product_type == 'yes') {
            // return (new CTR0002ByItem)->view();
            return \Excel::download(new CTR0002ByItem, $programCode . '.xlsx');
        } else {
            // return (new CTR0002ByBatch)->view();
            return \Excel::download(new CTR0002ByBatch, $programCode . '.xlsx');
        }
       
    }


    public function CTR0003Excel($programCode, $request)
    {
        if($request->output == 'pdf') {
            return (new CTR0003)->pdf($programCode);
        }
        return (new CTR0003)->excel($programCode);
    }

    public function CTR0004Excel($programCode, $request)
    {
        
        $request            = (object)request()->all();

        $dateFrom   =  $request->date_from;
        $dateTo     = $request->date_to;
        $userProfile = getDefaultData('/ct/reports');
        // $formDate = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        // $toDate = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        if($request->output == 'pdf') {
            return (new CTR0004)->pdf($programCode);
        }
        // return (new CTR0004)->view();
        return \Excel::download(new CTR0004, $programCode . '.xlsx');
    }

    public function CTR0008Excel($programCode, $request)
    {
        return \Excel::download(new CTR0008, $programCode . '.xlsx');
        
        $request            = (object)request()->all();
        // // dd($request, $programCode);
        $userProfile = getDefaultData('/ct/reports');
        $cost =  costCenter($request->cost_code);
        $datas = PrctCtr0004::where('cost_code', $request->cost_code)
                ->where('period_year',  $request->period_year)
                ->whereDate('transaction_date', '>=', date('Y-m-d', strtotime($request->date_from) ))
                ->whereDate('transaction_date', '<=',  date('Y-m-d', strtotime($request->date_to)) )
                ->orderBy('tobacco_group_code')
                ->where('transaction_date', '!=', null)
                ->get();
        // dd( $datas );
        $datas->map(function ($item, $key) {
            $item->total_transaction_quantity = $item->transaction_quantity * $item->transaction_cost;
            $item->group_by_uom = $item->tobacco_group_code.'-'.$item->detail_uom;
        }); 
        // // dd( $datas->pluck('sum_transaction_quantity') );
        return view('ct.Reports.ctr0008.excel.index', compact('datas', 'userProfile', 'cost'));
        // // return \Excel::download(new CTR0008, $programCode . '.xlsx');
    }

    public function CTR0009Excel($programCode, $request)
    {

        return \Excel::download(new CTR0009, $programCode . '.xlsx');

        $request            = (object)request()->all();
        $dateFrom           = $request->date_from;
        $dateTo             = $request->date_to;

        $formDate = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $toDate = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');

        $cost =  costCenter($request->cost_code);
    
        $datas = PtctCtr0009::
            // selectCtr009Raw()
                whereRaw("trunc(transaction_date) BETWEEN to_date('$formDate', 'YYYY/MM/DD') AND to_date('$toDate', 'YYYY/MM/DD')")
                // whereDate('transaction_date', '>=', date('Y-d-m', strtotime($request->date_from)))
                // ->whereDate('transaction_date', '<=',  date('Y-d-m', strtotime($request->date_to)))
                ->when($request->product_from, function($q) use($request) {
                    $q->where('product_item_number', '>=', $request->product_from);
                })
                ->when($request->product_to, function($q) use($request) {
                    $q->where('product_item_number', '<=', $request->product_to);
                })
                ->where('cost_code', $request->cost_code)
                ->where('period_year',  $request->period_year)
                ->orderBy('product_item_number')
                ->where('transaction_date', '!=', null)
                ->get();

        // dd($datas);
        $datas->map(function ($item, $key) {
            $item->total_transaction_quantity = $item->transaction_quantity * $item->transaction_cost;
            $item->group_by_uom = $item->tobacco_group_code.'-'.$item->detail_uom;
        }); 


        // // dd( $datas->pluck('sum_transaction_quantity') );
        return view('ct.Reports.ctr0009.excel.index', compact('datas', 'dateFrom', 'dateTo', 'cost'));
        // // return \Excel::download(new CTR0008, $programCode . '.xlsx');
    }


    public function CTR0010Excel($programCode, $request)
    {
        if($request->output == 'pdf') {
            return (new CTR0010)->pdf($programCode);
        }
        // dd($programCode, $request);
        return \Excel::download(new CTR0010, $programCode . '.xlsx');

        // $request            = (object)request()->all();
        // $dateFrom           = $request->date_from;
        // $dateTo             =  $request->date_to;

        // $datas = PrctCtr0004::selectCtr009Raw()
        //         ->whereDate('transaction_date', '>=', date('Y-d-m', strtotime($request->date_from)))
        //         ->whereDate('transaction_date', '<=',  date('Y-d-m', strtotime($request->date_to)))
        //         ->when($request->product_from, function($q) use($request) {
        //             $q->where('product_item_number', '>=', $request->product_from);
        //         })
        //         ->when($request->product_to, function($q) use($request) {
        //             $q->where('product_item_number', '<=', $request->product_to);
        //         })
        //         ->where('cost_code', $request->cost_code)
        //         ->where('period_year',  $request->period_year)
        //         ->orderBy('product_item_number')
        //         ->where('transaction_date', '!=', null)
        //         ->get();

        // $datas->map(function ($item, $key) {
        //     $item->total_transaction_quantity = $item->transaction_quantity * $item->transaction_cost;
        //     $item->group_by_uom = $item->tobacco_group_code.'-'.$item->detail_uom;
        // }); 


        // // // dd( $datas->pluck('sum_transaction_quantity') );
        // return view('ct.Reports.ctr0010.excel.index', compact('datas', 'dateFrom', 'dateTo'));
        // // return \Excel::download(new CTR0008, $programCode . '.xlsx');
    }

    public function CTR0011Excel($programCode, $request)
    {

        // $data = (new CTR0011)->getData();
        // if ($data->type_report == 'batch_no') {
        //     return view('ct.Reports.ctr0011.excel.index-by-batch', compact('data'));
        // } else if ($data->type_report == 'product') {
        //     return view('ct.Reports.ctr0011.excel.index-by-product', compact('data'));
        // }
        // return (new CTR0011)->view();
        return \Excel::download(new CTR0011, $programCode . '.xlsx');
    }
}
