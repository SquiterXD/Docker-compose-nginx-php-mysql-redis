<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

<title>OMR0047 รายงานแสดงจำนวนค่าบุหรี่ไปต่างประเทศ</title>
@include('ct.reports.ctr0101._style')

    </head>
    <body>
        <style>
      


            table, tr, td, th, tbody, thead, tfoot {
                page-break-inside: avoid !important;
            }
        
       
        
        </style>
        <!-- style="page-break-after:always; " -->
        <table  width="100%" style="margin: 0px auto;"  >
            <thead  >
                    
                    <tr style ="border-top: 2px solid; border-bottom: 0.5px solid;">
                    <th width="15%"  style="text-align: left; vertical-align: middle;">วันที่ใบเสร็จ</th>
                    <th width="15%"  style="text-align: left; vertical-align: middle;">เลขที่ใบเสร็จ</th>
                    <th width="35%"  style="text-align: left; vertical-align: middle;">ชื่อ</th>
                    <th  style="text-align: right; vertical-align: middle;">ขายเงินสด</th>
                    <th  style="text-align: right; vertical-align: middle;">ขายเงินเชื่อ</th>
                    <th  style="text-align: right; vertical-align: middle;">รวมจำนวนเงิน</th>
            
                </tr>
            </thead>
        <tbody>
            @php
                
                $count          = 0;  
                $sumTotal       = 0;      
                $sumCashTotal   = 0; 
                $sumCreditTotal = 0; 
                $sumAllTotal    = 0;
            @endphp
        @foreach($dataListDate->sortBy(function($i) {return $i->payment_date.$i->payment_number;}) as $dataListH)
        
            @php
            $SumCredit      = 0;
                $SumCash        = 0;
                $SumAll         = 0;
                $count      +=1;
                $Credit     = $dataListCredit->where('payment_date', $dataListH->payment_date)->where('customer_id', $dataListH->customer_id)->where('payment_number', $dataListH->payment_number)->all();
                foreach ($Credit as $key => $data) {
                    $Credit     = isset($data->payment_amount) ? $data->payment_amount * $data->conversion_rate: 0;
                    $SumCredit += $Credit;
                }     

                $Cash      = $dataListCash->where('payment_date', $dataListH->payment_date)->where('customer_id', $dataListH->customer_id)->where('payment_number', $dataListH->payment_number)->all();
                foreach ($Cash as $key => $data) {
                    $Cash       = isset($data->payment_amount)? $data->payment_amount * $data->conversion_rate : 0;
                    $SumCash   += $Cash;
                }                
                
                $sumTotal           = $SumCredit + $SumCash;
                $sumCashTotal       += $SumCash;
                $sumCreditTotal     += $SumCredit;
                $sumAllTotal        += $sumTotal;
            @endphp
            <tr>
                <td style="text-align: left; vertical-align: middle;">{{parseTODateTH($dataListH->payment_date)}}</td>
                <td style="text-align: left; vertical-align: middle;">{{($dataListH->payment_number)}}</td>
                <td style="text-align: left; vertical-align: middle;">{{($dataListH->customer_name)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($SumCash,2,".",",")}}</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($SumCredit,2,".",",")}}</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($sumTotal,2,".",",")}}</td>
            </tr>
        @endforeach
            <tr style ="border-top: 0.5px solid; border-bottom: 0.5px solid;">
                <td style="text-align: right; vertical-align: middle;"><b> รวม</b></td>
                <td style="text-align: right; vertical-align: middle;"><b> </b></td>
                <td style="text-align: right; vertical-align: middle;"><b> </b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumCashTotal,2,".",",")}}    </b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumCreditTotal,2,".",",")}}   </b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumAllTotal,2,".",",")}}  </b></td>
            </tr>


        </tbody>
        <table width="100%">
            <tr><br>
                <td style="text-align: left; vertical-align: middle;">{{$TEXT}}</td>
                <td></td>
            </tr>
            <tr>
                
                <td style="text-align: center   ; vertical-align: middle;"><b>จบรายงาน</b></td>
               
            </tr>
            
        </table>   
        <table width="100%">
            <tr>
            
                <td width="33%"style="vertical-align: middle;text-align: CENTER;" height="100"><b>ผู้ตรวจทาน ____________________________</b> </td>
                <td width="33%"style="vertical-align: middle;text-align: CENTER;" height="100"><b>รับรองถูกต้อง  ____________________________</b></td>
                <td width="33%"style="vertical-align: middle;text-align: CENTER;" height="100"><b>หัวหน้าส่วนงาน ____________________________</b></td>
            </tr>
        </table>        
    </body>
</html>

