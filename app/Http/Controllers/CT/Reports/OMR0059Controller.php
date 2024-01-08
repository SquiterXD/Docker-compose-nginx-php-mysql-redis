<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\OM\OMR0059;
use App\Http\Controllers\Controller;
use App\Models\OM\ARInterface;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class OMR0059Controller extends Controller
{


    public function OMR0059($programcode, Request $request)
    {
        $dateFrom = Carbon::createFromFormat('d/m/Y H:i:s', $request->month_from);
        $dateTo = Carbon::createFromFormat('d/m/Y H:i:s', $request->month_to);

        $numberMonth = $dateTo->diffInMonths($dateFrom);

        $months_th = ['', '01'=>"มกราคม", '02'=>"กุมภาพันธ์", '03'=>"มีนาคม", '04'=>"เมษายน", '05'=>"พฤษภาคม", '06'=>"มิถุนายน", '07'=>"กรกฎาคม", '08'=>"สิงหาคม", '09'=>"กันยายน", '10'=>"ตุลาคม", '11'=>"พฤศจิกายน", '12'=>"ธันวาคม"];
        $results = [];
        for($i =$dateFrom->copy() ; $dateTo >= $i ; $i->addMonth('1')) {
            #### ---------------------- Section 1
            $parm = new \stdClass;
            $parm->month = $i->format('d/m/Y H:i:s');
            $results['sheet1-2']['section1'][$i->format('mY')] = (new OMR0062Controller)->queryData('', $parm);
            foreach($results['sheet1-2']['section1'][$i->format('mY')]['data'] as $k => $item) {
                    @$results['sheet1']['section1']['columns'][] = $item->report_item_display;
            }
            @$results['sheet1-2']['section1'][$i->format('mY')]['taxAdjust'] = ARInterface::selectRaw('nvl(sum(oaom_tax_adjust), 0) total, item_code')
            ->where('interface_type', 'Invoice')
            ->where('interface_status', 'C')
            ->whereRaw("trunc(invoice_date) between TO_DATE('{$i->copy()->startOfMonth()->format("Y-m-d")}','YYYY-mm-dd') and TO_DATE('{$i->copy()->endOfMonth()->format("Y-m-d")}','YYYY-mm-dd')")
            ->groupBy('item_code')
            ->get()->pluck('total', 'item_code')->toArray();

            #### ---------------------- Section 2
            $parm = new \stdClass;
            $parm->date_from = $i->copy()->startOfMonth()->format('d/m/Y');
            $parm->date_to = $i->copy()->endOfMonth()->format('d/m/Y');
            $data = (new OMR0082Controller)->queryData('', $parm);
            $group = $data['data']->where('product_type_code', '10')->pluck('lines');
            $setJoin = [];
            foreach($group as  $item) {
                foreach($item as $loot) {
                    @$results['sheet1']['section2']['columns'][] = $loot->item_description;
                    $header = $data['data']->where('pi_header_id', $loot->pi_header_id)->first();
                    $loot->pick_exchange_rate = $header->pick_exchange_rate;
                    $setJoin[] = $loot;
                }
            }
            $setJoin = collect($setJoin);
            $setJoin = $setJoin->map(function($i){
                $i->approve_quantity = $i->approve_quantity *10;
                return $i;
            });
            @$results['sheet1-2']['section2'][$i->format('mY')]['data'] = collect($setJoin);
           
            ########### sheet3 
            $sheet3 = $this->sheet3Query($i->copy()->startOfMonth()->format("Y-m-d"), $i->copy()->endOfMonth()->format("Y-m-d"));
            @$results['sheet3_data'][$i->format('mY')] = collect($sheet3);
            foreach($results['sheet3_data'][$i->format('mY')] as $k => $item) {
                    @$results['sheet3']['columns'][] = $item->item_description;
            }
        }
       
        $results['sheet1']['section1']['columns'] = collect($results['sheet1']['section1']['columns'])->unique();
        $results['sheet1']['section2']['columns'] = collect($results['sheet1']['section2']['columns'])->unique();
        $results['sheet3']['columns'] = collect($results['sheet3']['columns'])->unique()->sortBy(function($i) {
            switch ($i) {
                case 'LINE':
                    return 1;
                    break;
                case 'อีแต๋น 1':
                    return 2;
                    break;
                case 'อีแต๋น 2':
                    return 3;
                    break;
                default:
                    # code...
                    break;
            }
        });

        $compact = compact('numberMonth'
                            ,'dateFrom'
                            ,'dateTo'
                            ,'results'
                            ,'months_th'
                            );
        return Excel::download(new OMR0059($programcode, $request, $compact), $programcode.'.xlsx');
    }
    public function sheet3Query($dateFrom, $dateTo) {
        $sql = "with tbl AS (select item_code,item_description,sum(approve_quantity) as Qty,sum(retail_amount) as Retail_Amount , max(unit_price) max_price                    
        from   ptom_so_outstanding_v                        
        where customer_type_id in ('10','20')                       
        and product_type_code='20'                      
        and trunc(pick_release_approve_date) between to_date('{$dateFrom}', 'YYYY-MM-DD')                        
                                and to_date('{$dateTo}', 'YYYY-MM-DD')                     
        group by item_code,item_description                  
        union                       
        select item_code,item_description,sum(approve_quantity) as Qty,sum(retail_amount) as Retail_Amount  , max(unit_price) max_price                   
        from   ptom_so_outstanding_v                        
        where customer_type_id in ('30','40')                       
        and product_type_code='20'                      
        and trunc(pick_release_approve_date) between to_date('{$dateFrom}', 'YYYY-MM-DD')                        
                                and to_date('{$dateTo}', 'YYYY-MM-DD')                     
        group by item_code,item_description)
        
        SELECT item_code, item_description, sum(qty) qty, sum(qty) *  max_price retail_amount  FROM tbl GROUP BY item_code, item_description, max_price";
        return DB::select($sql);
    }
}
