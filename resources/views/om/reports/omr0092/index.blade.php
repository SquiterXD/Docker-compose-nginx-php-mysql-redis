<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}

<title>รายงานยอดลูกหนี้ค่ายาสูบที่ยังไม่ได้ชำระเงินเมื่อถึงกำหนดชำระ</title>
@include('ct.reports.ctr0101._style')
<style>
    thead{display: table-header-group;}
tfoot {display: table-row-group;}
tr {page-break-inside: avoid;}
</style>
    </head>
    <body>
        <!-- <style>
            table, tr, td {
  border: 1px solid rgba(255,255,255,.5);
}

        </style> -->
   




    <table width="100%" style="page-break-after:always;" >
        <thead>
            <tr>
                <th></th>
            </tr>
        <tr style="border-bottom: 0.5px solid #000; border-top: 0.5px solid #000;" >
            <td width="5%"  style="text-align: center; vertical-align: middle;">ลำดับ</td>
            <td  style="text-align: center; vertical-align: middle;">รหัสร้านค้า</td>
            <td  style="text-align: center; vertical-align: middle;">ชื่อร้านค้า</td>
            <td  style="text-align: center; vertical-align: middle;">วันที่</td>
            <td  style="text-align: center; vertical-align: middle;">เลขที่ใบกำกับสินค้า</td>
            <td  style="text-align: center; vertical-align: middle;">เงินเชื่อ 28 วัน</td>
            <td  style="text-align: center; vertical-align: middle;">เงินเชื่อ 7 วัน</td>
            <td  style="text-align: center; vertical-align: middle;">เงินสด</td>
            <td  style="text-align: center; vertical-align: middle;">ฝากขาย</td>
            <td  style="text-align: center; vertical-align: middle;">ค่าปรับ / วัน (15%)</td>

        </tr>
        </thead>
        <tbody>
            @php
                $countRow = 0;
                $sumCR_0        =   0;
                $sumCR_7        =   0;    
                $sumCR_28       =   0; 
                $SumConsignmentA =   0; 
            @endphp

        @foreach($dataLists as $dataListH)
            @php
                    $countRow = $countRow+1;

                    if($dataListH->consignment_no ==null){
                        if($dataListH->due_days==0){
                            $CR_0       =$dataListH->debt_amount;   
                            $CR_7       =0;
                            $CR_28      =0;
                            $consignmentA =0;       

                        }elseif($dataListH->due_days==7){
                            $CR_0       =0;   
                            $CR_7       =$dataListH->debt_amount;
                            $CR_28      =0;
                            $consignmentA =0;       
                        }elseif($dataListH->due_days==28){
                            $CR_0       =0;   
                            $CR_7       =0;
                            $CR_28      =$dataListH->debt_amount;
                            $consignmentA =0;       
                        }
                        
                    }else{
                            $consignmentA =$dataListH->debt_amount;
                            $CR_0       =0;   
                            $CR_7       =0;
                            $CR_28      =0;
                        }
                
                $sumCR_0        += $CR_0 ;
                $sumCR_7        +=$CR_7;    
                $sumCR_28       +=$CR_28; 
                $SumConsignmentA +=$consignmentA;       
            @endphp
            <tr >
                <td style="text-align: center; vertical-align: middle;">{{$countRow }}</td>
                <td style="text-align: center; vertical-align: middle;">{{$dataListH->customer_number}}</td>
                <td style="text-align: left; vertical-align: middle;">{{$dataListH->customer_name}}</td>
                <td style="text-align: left; vertical-align: middle;">{{$dataListH->due_date}}</td>
                <td style="text-align: center; vertical-align: middle;">{{$dataListH->pick_release_no}}</td>

                <td style="text-align: right; vertical-align: middle;">{{$CR_28==0?'':number_format($CR_28,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$CR_7==0?'':number_format($CR_7,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$CR_0==0?'':number_format($CR_0,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$consignmentA==0?'':number_format($consignmentA,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($dataListH->debt_amount* 15/100 /365,2)}}</td>
          
            </tr>
            
        @endforeach
        <tr style="border-bottom: 0.5px solid #000; border-top: 0.5px solid #000;" >
                <td style="text-align: right; vertical-align: middle;" colspan="4">   </td>
                <td style="text-align: center; vertical-align: middle;" >รวม   </td>
                <td style="text-align: right; vertical-align: middle;">{{$sumCR_0==0?'':number_format($sumCR_0,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$sumCR_7==0?'':number_format($sumCR_7,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$sumCR_28==0?'':number_format($sumCR_28,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$SumConsignmentA==0?'':number_format($SumConsignmentA,2)}}</td>
                <td></td>            
            </tr>            
         
            <tr>
                <td style="height: 20px;" ></td>
            </tr>
            <tr>
                <td colspan="10" style="text-align: LEFT; vertical-align: middle;">             {{$TEXT}}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center; vertical-align: middle;"> </td>
                <td style="text-align: center; vertical-align: middle;"> จบรายงาน</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center; vertical-align: middle;"> </td>
                <td colspan="6" style="text-align: left; vertical-align: middle;">    ผู้จัดทำ____________________ผู้รับรอง____________________</td>
            </tr>
        </tbody>
    </table>
    </main>

    </body>
</html>
