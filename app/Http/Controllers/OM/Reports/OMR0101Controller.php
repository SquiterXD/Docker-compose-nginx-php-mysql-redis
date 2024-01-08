<?php

namespace App\Http\Controllers\OM\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OM\Api\Customer;
use App\Models\OM\ARInvoiceReportTemp;
use App\Models\OM\ARReceiptInfReport;
use App\Models\OM\GLInterfacesReport;
use PDF;
use Illuminate\Support\Facades\DB;

class OMR0101Controller extends Controller
{


    /**
     * OMR0101
     *
     * @param  Text $program_code
     * @param  Illuminate\Http\Request $request
     * @return PDF
     */
    public function OMR0101($program_code, $request)
    {
        $customer_number = request()->customer_number_from;
        $date = Carbon::createFromFormat('d/m/Y',request()->date_from);
        $result_2 = $this->buildQuery($customer_number, 2, $date->format('Y-m-d'));
        $result_3 = $this->buildQuery($customer_number, 3, $date->format('Y-m-d'));
        $result_0 = $this->buildQuery($customer_number, 0, $date->format('Y-m-d'));

        $customer = Customer::where('customer_number', $customer_number)->first();
        $data = compact(
            'result_2'
            , 'result_3'
            , 'result_0'
            , 'customer'
            , 'date'
        );
        // dd($result_2, $result_3, $result_0);
        $pdf = PDF::loadView(
            'om.reports.omr0101.pdf.index'
            , $data
        )
            ->setPaper('a4')
            // ->setOrientation('landscape')
            ->setOption('viewport-size', '210mm')
            ->setOption('margin-top', 0)
            ->setOption('margin-right', 0)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0);
            // ->setOption('dpi', 600);
            // ->setOption('disable-smart-shrinking', true);


        return $pdf->stream($program_code . '.pdf');
        return view('om.reports.omr0101.pdf.index', $data);
    }

    
    /**
     * buildQuery
     *
     * @param  String $customer_number
     * @param  Integer $credit_group_code
     * @param  Date $date Y-m-d 
     * @return DB::select
     */
    public function buildQuery($customer_number, $credit_group_code, $date)
    {
        $sql = "select  
                    'othor' data_ty,    
                    c.* 
                FROM    
                    (   
                        SELECT  
                            customer_id,    
                            customer_name,  
                            customer_number,    
                            (   
                                SELECT  
                                    sum(debt_amount)    
                                FROM    
                                    ptom_debt_dom_v 
                                WHERE   
                                    1 = 1   
                                    AND customer_id = c.customer_id 
                                    AND credit_group_code = '{$credit_group_code}'   
                                    AND TRUNC(pick_release_approve_date) <= to_date('{$date}', 'yyyy-mm-dd')  
                            ) debt_amount,  
                            (   
                                SELECT  
                                    sum(payment_amount) 
                                FROM    
                                    ptom_payment_dom_v  
                                WHERE   
                                    1 = 1   
                                    AND customer_id = c.customer_id 
                                    AND credit_group_code = '{$credit_group_code}'  
                                    AND TRUNC(payment_date) <= to_date('{$date}', 'yyyy-mm-dd')   
                            ) payment_amount    
                        FROM    
                            ptom_customers c    
                        WHERE 1=1   
                        AND  customer_number = '{$customer_number}'
                        ) c 
                    WHERE 1=1   
                    AND debt_amount > 0 OR Payment_amount> 0    ";
        return DB::select($sql);
    }
}
