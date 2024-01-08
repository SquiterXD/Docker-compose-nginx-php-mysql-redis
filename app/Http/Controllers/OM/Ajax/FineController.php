<?php

namespace App\Http\Controllers\OM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\ImproveFinesV;
use App\Models\OM\Customers;

class FineController extends Controller
{
    public function getFineList()
    {
        // dd('getFineList', request()->all());

        $data = ImproveFinesV::where('customer_id', request()->customer_id)->get();

        // dd($data);
        return response()->json($data);
    }

    public function getInvoiceList()
    {
        // dd('getInvoiceList', request()->all());
        $query = request()->get('query');
        $text = strtoupper($query);
        // dd($text);
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
                    // ->where('pick_release_no', 'like', "%${text}%")
                    // ->orWhere('consignment_no', 'like', "%${text}%")
                    ->whereRaw("UPPER(pick_release_no) like '%".$text."%'")
                    ->orWhereRaw("UPPER(consignment_no) like '%".$text."%'")
                    ->limit(20)
                    ->get(); 
        // dd('getInvoiceList', request()->all(), $data);

        return response()->json($data);
    }

    public function getCustomerList()
    {
        $text = request()->get('query');
        $data = Customers::where('sales_classification_code', 'Domestic')
                                ->where('status', 'Active')
                                ->searchForImproveFine($text)
                                ->orderBy('customer_number', 'asc')
                                ->limit(20)
                                ->get();

        return response()->json($data);
    }
}
