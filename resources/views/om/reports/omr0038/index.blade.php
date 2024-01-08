<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}

<title>สรุปใบเพิ่มหนี้ทางการค้า (Debit Note)</title>
@include('ct.reports.ctr0101._style')
    </head>
    <body>
    @include('om.reports.omr0038._header')
  
    <table width="100%" >
        <thead>
        <tr >
            <td width="5%"  style="text-align: center; vertical-align: middle;">ลำดับ</td>
            <td  style="text-align: center; vertical-align: middle;">เลขที่ใบเพิ่มหนี้</td>
            <td  style="text-align: center; vertical-align: middle;">วันที่</td>
            <td  style="text-align: center; vertical-align: middle;">รหัสร้านค้า</td>
            <td  style="text-align: center; vertical-align: middle;">ชื่อร้านค้า</td>
            <td  style="text-align: center; vertical-align: middle;">เดบิต บัญชี</td>
            <td  style="text-align: center; vertical-align: middle;">จำนวนเงิน</td>
            <td  style="text-align: center; vertical-align: middle;">เลขที่<br>ใบกำกับสินค้า</td>
            <td  style="text-align: center; vertical-align: middle;">ประเภทเดบิต<br> เจ้าหนี้ (บุหรี่)</td>
            <td  style="text-align: center; vertical-align: middle;">ประเภทเดบิต<br>เจ้าหนี้ (ยาเส้น)</td>
            <td  style="text-align: center; vertical-align: middle;">ประเภทเดบิต<br>ลูกหนี้เงินเชื่อ 7 วัน</td>
            <td  style="text-align: center; vertical-align: middle;">ประเภทเดบิต<br>ลูกหนี้เงินเชื่อ 28 วัน</td>
        </tr>
        </thead>
        <tbody>
            @php
                $countRow = 0;
                $sumAmount =0;
                $sumCR_TYPE_1   =   0;
                $sumCR_TYPE_2   =0;
                $sumCR_7        =   0;    
                $sumCR_28       =   0;  
            @endphp

        @foreach($dataLists as $dataListH)
            @php
                    $countRow = $countRow+1;
                    $CR_TYPE_1  =0;
                    $CR_TYPE_2  =0;
                    $CR_7       =0;
                    $CR_28      =0;
                    
                    if ($dataListH->due_days ==0 AND $dataListH->product_type_code==10 ){
                        $CR_TYPE_1 = $dataListH->pick_release_amount;
                    }
                    if ($dataListH->due_days ==0 AND $dataListH->product_type_code==20 ){
                        $CR_TYPE_2 = $dataListH->pick_release_amount;
                    }
                    if ($dataListH->due_days ==7 ){
                        $CR_7 = $dataListH->pick_release_amount;
                    }
                    if ($dataListH->due_days ==28 ){
                        $CR_28 = $dataListH->pick_release_amount;
                    }
                    $sumAmount=$dataListH->dn_amount+$sumAmount;
                    $sumCR_TYPE_1=$sumCR_TYPE_1+$CR_TYPE_1;
                    $sumCR_TYPE_2=$sumCR_TYPE_2+$CR_TYPE_2;
                    $sumCR_7=$sumCR_7+$CR_7;
                    $sumCR_28=$sumCR_28+$CR_28;
            @endphp
            <tr >
                <td style="text-align: center; vertical-align: middle;">{{$countRow }}</td>
                <td style="text-align: center; vertical-align: middle;">{{$dataListH->cn_number}}</td>
                <td style="text-align: center; vertical-align: middle;">{{$dataListH->cn_date}}</td>
                <td style="text-align: center; vertical-align: middle;">{{$dataListH->customer_number}}</td>
                <td style="text-align: left; vertical-align: middle;">{{$dataListH->customer_name}}</td>
                <td style="text-align: center; vertical-align: middle;">{{$dataListH->dr_account_code}}</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($dataListH->dn_amount,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$dataListH->pick_release_no}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$CR_TYPE_1==0?'':number_format($CR_TYPE_1,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$CR_TYPE_2==0?'':number_format($CR_TYPE_2,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$CR_7==0?'':number_format($CR_7,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$CR_28==0?'':number_format($CR_28,2)}}</td>
            </tr>
            
        @endforeach

            <tr >
                <td style="text-align: center; vertical-align: middle;" colspan="4">รวมจำนวนใบเพิ่มหนี้ทั้งหมด {{$countRow}} ใบ</td>
                <td style="text-align: center; vertical-align: middle;" colspan="2"></td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($sumAmount,2)}}</td>
                <td style="text-align: right; vertical-align: middle;"></td>
                <td style="text-align: right; vertical-align: middle;">{{$sumCR_TYPE_1==0?'-':number_format($sumCR_TYPE_1,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$sumCR_TYPE_2==0?'-':number_format($sumCR_TYPE_2,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$sumCR_7==0?'-':number_format($sumCR_7,2)}}</td>
                <td style="text-align: right; vertical-align: middle;">{{$sumCR_28==0?'-':number_format($sumCR_28,2)}}</td>
            </tr>
            <tr>
                <td style="height: 20px;" ></td>
            </tr>
            @php
                $sum_amount=0;
            @endphp
            @foreach($dataListsBOTTOM as $dataListsB)
            @php
                $sum_amount=$sum_amount+$dataListsB->sum_amount;
        
            @endphp
            <tr>
                <td colspan="5" ></td>
                <td colspan="1" style="text-align: center; vertical-align: middle;">{{$dataListsB->dr_account_code}}</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($dataListsB->sum_amount,2)}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5" ></td>
                <td colspan="1" style="text-align: center; vertical-align: middle;">รวม</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($sum_amount,2)}}</td>
                
            </tr>
            <tr>
                <td style="height: 30px;" ></td>
            </tr>
            
            <tr>
                <td colspan="6" style="text-align: LEFT; vertical-align: middle;">             {{$TEXT}}</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center; vertical-align: middle;"> จบรายงาน</td>
                <td colspan="6" style="text-align: right; vertical-align: middle;"> ผู้จัดทำ____________________ผู้รับรอง____________________</td>
            </tr>
        </tbody>
    </table>

   
    
    </body>
</html>
