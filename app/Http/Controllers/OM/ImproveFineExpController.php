<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Customers;
use App\Models\OM\ImproveFinesExpV;
use App\Models\OM\PaymentMatchInvoice;
use App\Models\OM\ImproveFine;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ImproveFineExpController extends Controller
{
    const url = '/om/improve-fine-exp';

    public function index()
    {
        if (request()->action === 'search_get_param') {
            return $this->getParam(request());
        }

        $user = auth()->user();

        $customer = Customers::where('sales_classification_code', 'Export')
                                ->where('status', 'Active')
                                ->where('customer_number', $user->username)
                                ->first();

        $dataSearch = (object)[]; 
        $dataSearch->total_fine_due = request()->total_fine_due;
        $dataSearch->order_number   = request()->order_number;
        $dataSearch->sa_number      = request()->sa_number;
        $dataSearch->due_date       = request()->due_date;
        $dataSearch->pi_number      = request()->pi_number;
        $dataSearch->invoice_no     = request()->invoice_no;
        $dataSearch->customer_id    = request()->customer_id;
        
        $orderNumber     = request()->get('order_number', false);
        $saNumber        = request()->get('sa_number', false);
        $piNumber        = request()->get('pi_number', false);
        $invoiceNo       = request()->get('invoice_no', false);
        $customerId      = request()->get('customer_id', false);
        $totalFineDue    = request()->get('total_fine_due', false);
        $dueDate         = request()->get('due_date', false);
        $checkSearch     = request()->get('check_search', false);

        $fineFlag        = request()->fine_flag;

        $searchData = [
            'order_number'   => $orderNumber,
            'sa_number'      => $saNumber,
            'pi_number'      => $piNumber,
            'invoice_no'     => $invoiceNo,
            'customer_id'    => $customerId,
            'total_fine_due' => $totalFineDue,
            'due_date'       => $dueDate,
            'check_search'   => $checkSearch,
            'fine_flag'   => $fineFlag,
            'search_url'     => route('om.improve-fine-exp.index')
        ];

        if (request()->check_search) {

            if (request()->fine_flag) {

                $dataLisTests = [];

                $datas = ImproveFinesExpV::search($dataSearch)
                                            ->orderBy('due_date', 'desc')
                                            ->orderBy('customer_number', 'asc')
                                            ->get();

                foreach ($datas as $dataList) {

                    // dd(calFineExpFixDate($dataList, $totalFineDue));

                    if (!checkCancelExp($dataList)) {
                        if (calFineExpFixDate($dataList, $totalFineDue) > 0) {
                            array_push($dataLisTests, $dataList);
                        }
                    }
                    
                }

                $dataLists = $this->paginate($dataLisTests);
                // dd($dataLisTests, $totalFineDue);

            }else {
                $dataLists = ImproveFinesExpV::search($dataSearch)
                                            ->orderBy('due_date', 'desc')
                                            ->orderBy('customer_number', 'asc')
                                            ->paginate(25);
            }
            
        } else {
            $dataLists = [];
        }

        return view('om.improve-fine-exp.index', compact('customer', 'dataLists', 'searchData', 'totalFineDue'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        foreach (request()->cancel_flag as $key => $value) {
            
            $cancel          = explode('-' , $key);
            $orderHeaderId   = $cancel[0];
            $pickReleaseNo   = $cancel[1];

            $data                = ImproveFinesExpV::where('order_header_id', $orderHeaderId)
                                                ->where('pick_release_no', $pickReleaseNo)
                                                ->first();

            $paymentMatchInvoice = PaymentMatchInvoice::where('prepare_order_number', $data->prepare_order_number)->first();
            $invoiceId           = $data->order_header_id;


            $improveFine                        = new ImproveFine;
            $improveFine->invoice_id            = $invoiceId;
            $improveFine->invoice_number        = $data->pick_release_no;
            $improveFine->invoice_amount        = $data->outstanding_debt;
            $improveFine->order_date            = $data->order_date;
            $improveFine->due_date              = $data->due_date;
            $improveFine->except_interest_days  = $data->due_days;
            $improveFine->total_fine            = request()->total_fine[$key];
            $improveFine->total_fine_due        = request()->total_fine_due[$key];
            $improveFine->cancel_flag           = 'Y';
            $improveFine->program_code          = 'OMP0071';
            $improveFine->created_by            = $user->user_id;
            $improveFine->created_by_id         = $user->user_id;
            $improveFine->last_updated_by       = $user->user_id;
            $improveFine->save();
        }

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function getParam(Request $request)
    {
        $orderNumberList = [];
        $saNumberList    = [];
        $piNumberList    = [];
        $invoiceNoList   = [];
        $customerList    = Customers::where('sales_classification_code', 'Export')
                            ->where('status', 'Active')
                            ->orderBy('customer_number', 'asc')
                            ->get();

        $data        = ImproveFinesExpV::whereNotNull('order_header_id');

        $orderNumber = request()->get('order_number', false);
        $saNumber    = request()->get('sa_number', false);
        $piNumber    = request()->get('pi_number', false);
        $invoiceNo   = request()->get('invoice_no', false);
        $customerId  = request()->get('customer_id', false);

        if ($orderNumber || $saNumber || $piNumber || $invoiceNo || $customerId) {
            $data = $data->when($orderNumber, function($q) use ($orderNumber) {
                $q->where('order_number', $orderNumber);
            })->when($saNumber, function($q) use ($saNumber) {
                $q->where('sa_number', $saNumber);
            })->when($piNumber, function($q) use ($piNumber) {
                $q->where('pi_number', $piNumber);
            })->when($invoiceNo, function($q) use ($invoiceNo) {
                $q->where('pick_release_no', $invoiceNo);
            })->when($customerId, function($q) use ($customerId) {
                $q->where('customer_id', $customerId);
            });
        }

        $orderNumberData = clone $data;
        $saNumberData    = clone $data;
        $piNumberData    = clone $data;
        $invoiceNoData   = clone $data;
        $customerIdData  = clone $data;
        $data            = $data->count();

        if ($data) {
            $orderNumberData  = $orderNumberData->selectRaw("distinct order_number as value")->get();
            $saNumberData     = $saNumberData->selectRaw("distinct sa_number as value")->get();
            $piNumberData     = $piNumberData->selectRaw("distinct pi_number as value")->get();
            $invoiceNoData    = $invoiceNoData->selectRaw("distinct pick_release_no as value")->get();

            if (count($orderNumberData)) {
                $orderNumberList = array_merge($orderNumberList, $orderNumberData->toArray());
            }

            if (count($saNumberData)) {
                $saNumberList = array_merge($saNumberList, $saNumberData->toArray());
            }

            if (count($piNumberData)) {
                $piNumberList = array_merge($piNumberList, $piNumberData->toArray());
            }

            if (count($invoiceNoData)) {
                $invoiceNoList = array_merge($invoiceNoList, $invoiceNoData->toArray());
            }
        }

        $data = [
            'order_number_list' => $orderNumberList,
            'sa_number_list'    => $saNumberList,
            'pi_number_list'    => $piNumberList,
            'invoice_no_list'   => $invoiceNoList,
            'customer_list'     => $customerList,
        ];

        return $data;
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
