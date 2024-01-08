<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\ImproveFine;

use App\Models\OM\Customers;
use App\Models\OM\ImproveFinesV;
use App\Models\OM\PaymentMatchInvoice;
use App\Models\OM\OrderHeaders;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ImproveFineController extends Controller
{
    const url = '/om/improve-fine';
    public function index()
    {
        $user                = auth()->user();
        $customerSearch      = request()->customer_id;
        $dueDateSearch       = request()->due_date ? parseFromDateTh(request()->due_date) : '';
        $invoiceNoSearch     = request()->invoice_no;
        $totalFineDue        = request()->total_fine_due ? parseFromDateTh(request()->total_fine_due) : '';
        $fineFlag            = request()->fine_flag;
        $checkFineFlag       = request()->fine_flag;
        $invoiceDate         = request()->invoice_date ? parseFromDateTh(request()->invoice_date) : '';
        
        $customer = Customers::where('sales_classification_code', 'Domestic')
                                ->where('status', 'Active')
                                ->where('customer_number', $user->username)
                                ->first();

        $customers = Customers::where('sales_classification_code', 'Domestic')
                                ->where('status', 'Active')
                                ->searchForImproveFine($customerSearch)
                                ->orderBy('customer_number', 'asc')
                                ->limit(20)
                                ->get();
        // dd(request()->all(), $customers);
        // $invoices = [];

        $data = ImproveFinesV::selectRaw("
                        distinct (case when customer_type_id not in (30, 40) and pick_release_no is not null then
                            pick_release_no
                        when customer_type_id in (30, 40) and consignment_no is not null then 
                            consignment_no
                        end) invoice_no,
                        
                        (case when customer_type_id not in (30, 40) and pick_release_no is not null then
                            pick_release_approve_date
                        when customer_type_id in (30, 40) and consignment_no is not null then 
                            consignment_date
                        end)  invoice_date")
                    ->where('pick_release_no', $invoiceNoSearch)
                    ->orWhere('consignment_no', $invoiceNoSearch)
                    ->limit(20)
                    ->get(); 

        $invoices = $data->whereNotNull('invoice_no');
        // dd($data->whereNotNull('invoice_no'));

        // $invoiceNormals = ImproveFinesV::selectRaw("distinct pick_release_no as invoice_no, pick_release_approve_date as invoice_date")
        //                 ->whereNotIn('customer_type_id', [30, 40])
        //                 ->whereNotNull('pick_release_no')
        //                 ->limit(20)
        //                 ->get();

        // $invoiceReleases = ImproveFinesV::selectRaw("distinct consignment_no as invoice_no, consignment_date as invoice_date")
        //                 ->whereIn('customer_type_id', [30, 40])
        //                 ->where('product_type_code', '!=', 10)
        //                 ->whereNotNull('pick_release_no')
        //                 ->limit(20)
        //                 ->get();

        // $invoiceConsignments = ImproveFinesV::selectRaw("distinct consignment_no as invoice_no, consignment_date as invoice_date")
        //                 ->whereIn('customer_type_id', [30, 40])
        //                 ->where('product_type_code', 10)
        //                 ->whereNotNull('consignment_no')
        //                 ->limit(20)
        //                 ->get();

        // dd($invoiceNormals, $invoiceReleases, $invoiceConsignments);

        // foreach ($invoiceNormals as $invoiceNormal) {
        //     array_push($invoices, $invoiceNormal);
        // }

        // foreach ($invoiceReleases as $invoiceRelease) {
        //     array_push($invoices, $invoiceRelease);
        // }

        // foreach ($invoiceConsignments as $invoiceConsignment) {
        //     array_push($invoices, $invoiceConsignment);
        // }

        $dataLists    = [];
        $dataLisTests = [];

        // dd($invoiceDate);
        if (request()->total_fine_due) {

            $fineFlag  = request()->fine_flag ? 'Y' : 'N';

            if (request()->fine_flag) {
                $datas = ImproveFinesV::search(request()->customer_id, $dueDateSearch, request()->invoice_no, $invoiceDate)
                                            ->orderBy('due_date', 'desc')
                                            ->orderBy('customer_number', 'asc')
                                            ->orderBy('prepare_order_number', 'asc')
                                            ->orderBy('credit_group_code', 'asc')
                                            ->get();

                foreach ($datas as $dataList) {
                    if (calFineFixDate($dataList, $totalFineDue) > 0) {
                        array_push($dataLisTests, $dataList);
                    }
                }

                $dataLists = $this->paginate($dataLisTests);

            } else {
                
                $dataLists = ImproveFinesV::search(request()->customer_id, $dueDateSearch, request()->invoice_no, $invoiceDate)
                                            ->orderBy('due_date', 'desc')
                                            ->orderBy('customer_number', 'asc')
                                            ->orderBy('prepare_order_number', 'asc')
                                            ->orderBy('credit_group_code', 'asc')
                                            ->paginate(15);
            }

        } else {
            
            if (request()->customer_id || $dueDateSearch || request()->invoice_no || $invoiceDate) {
            
                $fineFlag  = request()->fine_flag ? 'Y' : 'N';
                $dataLists = ImproveFinesV::search(request()->customer_id, $dueDateSearch, request()->invoice_no, $invoiceDate)
                                            ->orderBy('due_date', 'desc')
                                            ->orderBy('customer_number', 'asc')
                                            ->orderBy('prepare_order_number', 'asc')
                                            ->orderBy('credit_group_code', 'asc')
                                            ->paginate(15);
            }
    
        }

        if(!empty($dataLists)) {
            $fix_remaining = DB::table('ptom_order_remaining')->whereIn('order_header_id', $dataLists->pluck('order_header_id'))->get(['order_header_id', 'group2_amount', 'group2_remaining', 'group3_amount','group3_remaining']);
            $dataLists->getCollection()->transform(function ($item) use($fix_remaining) {
                $item->fix_remaining = $fix_remaining->where('order_header_id', $item->order_header_id)->first();
                $item->remaining_amount2 = !empty($item->fix_remaining) ? $item->fix_remaining->group2_remaining : 0;
                $item->remaining_amount3 = !empty($item->fix_remaining) ? $item->fix_remaining->group3_remaining : 0;
                return $item;
            });
        }
      
        
        return view('om.improve-fine.index', compact('customers', 'customer', 'invoices', 'dataLists', 'customerSearch', 'dueDateSearch', 'invoiceNoSearch', 'totalFineDue', 'fineFlag', 'checkFineFlag', 'invoiceDate'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // dd(request()->all());

        foreach (request()->cancel_flag as $key => $value) {
            
            $cancel          = explode('-' , $key);
            $customerTypeId  = $cancel[0];
            $productTypeCode = $cancel[1];
            $invoice         = $cancel[2];
            $creditGroupCode = $cancel[3];

            // dd($cancel);

            if ($customerTypeId == 30 || $customerTypeId == 40 && $productTypeCode == 10) {
                $data                = ImproveFinesV::where('consignment_no', $invoice)
                                                ->where('credit_group_code', $creditGroupCode)
                                                ->first();

               $invoiceId     = $data->consignment_header_id;
               $invoiceNumber = $data->consignment_no;

            } else {
                $data                = ImproveFinesV::where('order_header_id', $invoice)
                                        ->where('credit_group_code', $creditGroupCode)
                                        ->first();

                $invoiceId     = $data->order_header_id;
                $invoiceNumber = $data->pick_release_no;
            }
            
            

            // dd(request()->all(), $data, $invoiceId);

            // $data                = ImproveFinesV::where('order_header_id', $orderHeaderId)
            //                                     ->where('credit_group_code', $creditGroupCode)
            //                                     ->first();

            // dd($data, request()->all());

            $paymentMatchInvoice = PaymentMatchInvoice::where('prepare_order_number', $data->prepare_order_number)->first();
            $orderHeader         = OrderHeaders::find($data->order_header_id);
            // dd(request()->all(), $data, $paymentMatchInvoice, $orderHeader );

            // $invoiceId = $data->customer_type_id == 40 ? $data->consignment_header_id : $data->order_header_id;

            // dd($invoiceId);

            $improveFine                        = new ImproveFine;
            $improveFine->period_id             = $data->period_id;
            $improveFine->invoice_id            = $invoiceId;
            $improveFine->invoice_number        = $invoiceNumber;
            $improveFine->invoice_amount        = $data->outstanding_debt;
            $improveFine->remaining_amount      = $data->remaining_amount;
            $improveFine->order_date            = $data->order_date;
            $improveFine->due_date              = $data->due_date;
            $improveFine->credit_group_code     = $data->credit_group_code;
            $improveFine->except_interest_days  = $data->due_days;
            $improveFine->total_fine            = request()->total_fine;
            $improveFine->total_fine_due        = request()->total_fine_due;
            $improveFine->cancel_flag           = 'Y';
            $improveFine->program_code          = 'OMP0023';
            $improveFine->created_by            = $user->user_id;
            $improveFine->created_by_id         = $user->user_id;
            $improveFine->last_updated_by       = $user->user_id;
            $improveFine->save();
        }

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options = ["path" => url()->current(),
                    "pageName" => "page"];
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
