<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

<title>OMR0085 การบันทึกลูกหนี้ค่าบุหรี่(เงินเชื่อ) </title>
@include('ct.reports.ctr0101._style')

    </head>
    <body>
        <style>
      

            tr, td,th {
            border: 0.5px solid ;
            }
            table, tr, td, th, tbody, thead, tfoot {
                page-break-inside: avoid !important;
            }
        
       
        
        </style>
        <!-- style="page-break-after:always; " -->
        <table  width="100%"  >
            <thead >
                    
                    <tr style =" border: 0.5px solid; border-top: 2px solid;">
                    <th width="10%"  style="text-align: center; vertical-align: middle;">ลำดับที่</th>
                    <th width="50%" style="text-align: center; vertical-align: middle;">ชื่อร้าน</th>
                    <th width="20%" style="text-align: center; vertical-align: middle;">ใบเสร็จรับเงินเลขที่</th>
                    <th width="20%" style="text-align: center; vertical-align: middle;">จำนวนเงิน<br>บาท</th>
                </tr>
            </thead>
            <tbody>
            @php
                $cntLine =0; 
                $sum=0;
            @endphp  
            @foreach($dataLists as $dataListH)
            @php
                $cntLine +=1; 
                $sum+=$dataListH->total_amount_with_vat;
            @endphp
            <tr>
                <td style="text-align: center; vertical-align: middle;">{{$cntLine}}</td>
                <td style="text-align: left; vertical-align: middle;">{{$customer}}</td>
                <td style="text-align: center; vertical-align: middle;">{{$dataListH->payment_number}}</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($dataListH->total_amount_with_vat,2,".",",")}}</td>   
            </tr>
            @endforeach
            <tr style="border-style: dotted;">
                <td style="border-style: dotted;text-align: center; vertical-align: middle;"></td>
                <td style="border-style: dotted;text-align: left; vertical-align: middle;"></td>
                <td style="border-style: dotted;text-align: center; vertical-align: middle; font-weight: bold;">ยอดรวม</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($sum,2,".",",")}}</td>   
            </tr> 
   

            
            <tr style="border-style: dotted; ">
                <td style="border-style: dotted;text-align: center; vertical-align: middle;"></td>
                <td style="border-style: dotted;text-align: right; vertical-align: middle; font-weight: bold;margin-top=50px;">จบราบงาน</td>
                <td style="border-style: dotted;text-align: center; vertical-align: middle; "></td>

            </tr>            
            </tbody>
            
        
        </table>
     
       
    </body>
</html>

