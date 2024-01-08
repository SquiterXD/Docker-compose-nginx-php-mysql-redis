<?php

namespace App\Http\Controllers\OM\GenerateFile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OM\Api\Customer;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\OM\CustomerContractGroup;
use App\Models\OM\ReportBalanceTXTFile;
use App\Models\OM\ReportCreditTXTFile;
use App\Models\OM\DebtDomV;
use App\Models\OM\Order;
use App\Models\OM\PeriodV;

class GenerateFileContrller extends Controller
{
    public function index()
    {
        return view('om.generate-file.index');
    }
    public function genFileBalance()
    {
        $date = Carbon::createFromFormat('Y-m-d', request()->date)->format('Y-m-d');
        $period = PeriodV::whereRaw("to_date('".$date."', 'YYYY-MM-DD')  BETWEEN  trunc(start_period)  AND trunc(end_period)")->first();
        $customer = ReportBalanceTXTFile::where('period_line_id', $period->period_line_id)
                                        ->orderBy('customer_code_tm')
                                        ->get();
        $customer = $customer->filter(function($i) {
            return $i->due_date != '';
        })->map(function ($i) {
            $delivery_date = Carbon::createFromFormat('Y-m-d H:i:s', $i->due_date)->format('d-m-Y');
            return implode(',', [$i->customer_code_tm, @$delivery_date, @$i->outstanding_debt.';']);
        });


        $file_name = 'BALANCE_UPDATE.txt';
        $content = $customer->join(PHP_EOL);
        Storage::disk('local')->put($file_name, $content);

        $file_path = 'BALANCE_UPDATE.txt';
        return Storage::download($file_path);
    }

    public function genFileCredit()
    {
        $customer = ReportCreditTXTFile::whereNotNull('customer_code_tm')
                                    ->orderBy('customer_code_tm')
                                    ->get();
        $customer = $customer->map(function ($i) {
            return implode(',', [$i->customer_code_tm, @$i->credit_group_code, $i->credit_percentage ?? 0, @$i->credit_amount, $i->remaining_amount, null.';']);
        });

        $file_name = 'CREDIT_UPDATE.txt';
        $content = $customer->join(PHP_EOL);
        Storage::disk('local')->put($file_name, $content);

        $file_path = 'CREDIT_UPDATE.txt';
        return Storage::download($file_path);
    }

    public function genFileDebt()
    {
        // $date = now()->format('Y-m-d');
        $date = Carbon::createFromFormat('Y-m-d', request()->date)->format('Y-m-d');
        // $period = PeriodV::whereRaw("to_date('".$date."', 'YYYY-MM-DD')  BETWEEN  trunc(start_period)  AND trunc(end_period)")->first();
        // whereRaw("ptom_debt_dom_v.due_date >= TO_DATE('{$date}', 'YYYY-MM-DD')")
        $customer = DebtDomV::leftjoin('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_debt_dom_v.customer_id')
                    ->leftjoin('ptom_order_headers', 'ptom_order_headers.order_header_id', '=', 'ptom_debt_dom_v.order_header_id')
                    ->leftjoin('ptom_period_v', 'ptom_period_v.period_line_id', '=', 'ptom_order_headers.period_id')
                    ->where('ptom_debt_dom_v.credit_group_code', '<>', '0')
                    ->whereNotNull('ptom_debt_dom_v.pick_release_no')
                    ->where('ptom_debt_dom_v.outstanding_debt', '>', '0')
                    ->where('ptom_debt_dom_v.customer_type_id', '<>', '20')
                    // ->where('ptom_period_v.period_line_id', "{$period->period_line_id}")
                    ->select('ptom_debt_dom_v.*', 'ptom_customers.customer_code_tm', 'ptom_period_v.period_no')
                    ->orderBy('customer_code_tm')
                    ->orderBy('ptom_debt_dom_v.credit_group_code')
                    ->get();

        $customer = $customer->map(function ($i) {
            $dueDate = Carbon::createFromFormat('Y-m-d H:i:s', $i->due_date)->format('Y-m-d');
            $periodNo = PeriodV::whereRaw("to_date('".$dueDate."', 'YYYY-MM-DD')  BETWEEN  trunc(start_period)  AND trunc(end_period)")->first();
            $budgetYear = $periodNo->budget_year+543;
            return implode(',', [$i->customer_code_tm, $i->credit_group_code, $i->outstanding_debt, Carbon::createFromFormat('Y-m-d H:i:s', $i->due_date)->format('d-m-Y'), $i->pick_release_no, $periodNo->period_no , $budgetYear.';']);
        });

        $file_name = 'DEBT_UPDATE.txt';
        $content = $customer->join(PHP_EOL);
        Storage::disk('local')->put($file_name, $content);

        $file_path = 'DEBT_UPDATE.txt';
        return Storage::download($file_path);
    }
    public function genFileCarrier()
    {
        // $date = now()->format('Y-m-d');
        $date = Carbon::createFromFormat('Y-m-d', request()->date)->format('Y-m-d');
        $customer = Order::whereRaw("ptom_order_headers.delivery_date = TO_DATE('{$date}', 'YYYY-MM-DD')")
                    ->leftjoin('ptom_order_lines', 'ptom_order_headers.order_header_id', '=', 'ptom_order_lines.order_header_id')
                    ->leftjoin('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
                    ->select('ptom_order_headers.order_date','ptom_order_headers.pick_release_no', 'ptom_order_headers.delivery_date', 'ptom_customers.customer_code_tm', 'ptom_order_lines.*')
                    ->where('order_status', 'Confirm')
                    ->whereNotNull('ptom_order_headers.pick_release_no')
                    ->whereIn('ptom_customers.customer_type_id', [10, 40])
                    ->where('ptom_order_headers.product_type_code', 10)
                    ->orderBy('customer_code_tm')
                    ->get();
        $listLine = DB::table('PTOM_LIST_LINES')->whereIn('list_header_id', [1,3,2])->get();
        $customer = $customer->map(function ($i) use($listLine) {
            $price1 = $listLine->filter(function($q) use($i) {
                if($q->product_code == $i->item_code && $q->list_header_id == 1) return $q;
            });
            $price2 = $listLine->filter(function($q) use($i) {
                if($q->product_code == $i->item_code && $q->list_header_id == 3) return $q;
            });
            $price3 = $listLine->filter(function($q) use($i) {
                if($q->product_code == $i->item_code && $q->list_header_id == 2) return $q;
            });
            
            $price1 = !empty($price1) ? $price1->first()->value : 0.00;
            $price2 = !empty($price2) ? $price2->first()->value : 0.00;
            $price3 = !empty($price3) ? $price3->first()->value : 0.00;
            return implode(',', [$i->customer_code_tm, 
            $i->pick_release_no,
             Carbon::createFromFormat('Y-m-d H:i:s', $i->delivery_date)->format('d-m-Y'), 
             substr($i->item_code,4)
             ,$i->approve_quantity
             ,$price1/5
             ,$price2/5
             ,$price3/5
             ,null
             ,';'
            ]);
        });
        $file_name = 'CARRIER_.txt';
        $content = $customer->join(PHP_EOL);
        Storage::disk('local')->put($file_name, $content);

        $file_path = 'CARRIER_.txt';
        return Storage::download($file_path);
    }
    public function genFileCarrierBkk()
    {
        // $date = now()->format('Y-m-d');
        $date = Carbon::createFromFormat('Y-m-d', request()->date)->format('Y-m-d');
        $customer = Order::whereRaw("ptom_order_headers.delivery_date = TO_DATE('{$date}', 'YYYY-MM-DD')")
                    ->leftjoin('ptom_order_lines', 'ptom_order_headers.order_header_id', '=', 'ptom_order_lines.order_header_id')
                    ->leftjoin('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
                    ->select('ptom_order_headers.order_date','ptom_order_headers.pick_release_no', 'ptom_order_headers.delivery_date', 'ptom_customers.customer_code_tm', 'ptom_order_lines.*')
                    ->where('order_status', 'Confirm')
                    ->whereNotNull('ptom_order_headers.pick_release_no')
                    ->whereIn('ptom_customers.customer_type_id', [30])
                    ->where('ptom_order_headers.product_type_code', 10)
                    ->orderBy('customer_code_tm')
                    ->get();
        $listLine = DB::table('PTOM_LIST_LINES')->whereIn('list_header_id', [1,3,2])->get();
        $customer = $customer->map(function ($i) use($listLine) {
            $price1 = $listLine->filter(function($q) use($i) {
                if($q->product_code == $i->item_code && $q->list_header_id == 1) return $q;
            });
            $price2 = $listLine->filter(function($q) use($i) {
                if($q->product_code == $i->item_code && $q->list_header_id == 3) return $q;
            });
            $price3 = $listLine->filter(function($q) use($i) {
                if($q->product_code == $i->item_code && $q->list_header_id == 2) return $q;
            });
            
            $price1 = !empty($price1) ? $price1->first()->value : 0.00;
            $price2 = !empty($price2) ? $price2->first()->value : 0.00;
            $price3 = !empty($price3) ? $price3->first()->value : 0.00;
            return implode(',', [$i->customer_code_tm, 
            $i->pick_release_no,
             Carbon::createFromFormat('Y-m-d H:i:s', $i->delivery_date)->format('d-m-Y'), 
             substr($i->item_code,4)
             ,$i->approve_quantity
             ,$price1/5
             ,$price2/5
             ,$price3/5
             ,null
             ,';'
            ]);
        });
        $file_name = 'CARRIER_BKK.txt';
        $content = $customer->join(PHP_EOL);
        Storage::disk('local')->put($file_name, $content);

        $file_path = 'CARRIER_BKK.txt';
        return Storage::download($file_path);
    }
    public function genFile(Request $req)
    {

        switch ($req->type) {
            case 'BALANCE_UPDATE':
                return $this->genFileBalance();
                break;
            case 'CREDIT_UPDATE':
                return $this->genFileCredit();
                break;
            case 'DEBT_UPDATE':
                return $this->genFileDebt();
                break;
            case 'CARRIER_UPDATE':
                return $this->genFileCarrier();
                break;
            case 'CARRIER_BKK_UPDATE':
                return $this->genFileCarrierBkk();
                break;
            default:
                # code...
                break;
        }
    }
}
