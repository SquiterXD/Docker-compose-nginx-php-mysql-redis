<!-- 
<style>
    table, th, td {
  border: 1px solid;
}
</style> -->



<table  width="100%" style="margin: 0px auto;"  >
            <thead  >
                    <tr> 
                        <th ></th>
                        <th ></th>
                        <th ></th>
                        <th  style="text-align: left; ">ปีงบประมาณ {{$Year}}</th>
                        <td > </td>
                        @if($groupA == "กลุ่มบุหรี่ไม่คิดมูลค่า")
                        <th colspan="2" style="text-align: left; ">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;หน่วย : พันมวน</th>
                        @else
                        <th colspan="2" style="text-align: left; ">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;หน่วย : {{$uom}}</th>
                        @endif
                    </tr>
                    <tr>
                       <th>{{$groupA}}</th> 
                    </tr>
                    
                    <tr style ="border-top: .5px solid; border-bottom: 0.5px solid;">
                    <th width="13%"  style="text-align: center; vertical-align: middle;">ตรา</th>
                    <th width="10%" style="text-align: center; vertical-align: middle;">พันมวน</th>
                    <th width="10%"  style="text-align: center; vertical-align: middle;">หีบ</th>
                    <th width="10%" style="text-align: center; vertical-align: middle;">จำนวนเงิน</th>
                    <th width="10%" style="text-align: center; vertical-align: middle;">มูลค่าสินค้า <br> (ราคาปลีก - Vat)</th>
                    <th width="10%" style="text-align: center; vertical-align: middle;">ภาษีมูลค่าเพิ่ม</th>
                    <th width="10%" style="text-align: center; vertical-align: middle;">ราคาปลีก</th>
                    </tr>
                    <tr>
                       <th>{{$groupB}}</th> 
                    </tr>
            </thead>

        <tbody>
        @php
            $sumQuantity1   =0;
            $sumQuantity    =0;
            $sumAmount      =0;
            $sumBase_vat    =0;
            $sumTax_amount     =0;
            $sumRetail_amount     =0;
        @endphp

        @foreach($dataListsX as $dataListx)
            <tr>
                <td style="text-align: left; vertical-align: middle;">{{$dataListx->item_description}}</td>
                <td style="text-align: right; vertical-align: middle;">{{isset($dataListx->quantity1)?number_format($dataListx->quantity1,2,".",","):''}}</td>
                <td style="text-align: right; vertical-align: middle;">{{isset($dataListx->quantity)?number_format($dataListx->quantity,2,".",","):''}}</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($dataListx->amount,2,".",",")}}</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($dataListx->base_vat,2,".",",")}}</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($dataListx->tax_amount,2,".",",")}}</td>
                <td style="text-align: right; vertical-align: middle;">{{number_format($dataListx->retail_amount,2,".",",")}}</td>
                
            </tr>
            @php
                $sumQuantity1       +=  isset($dataListx->quantity1)?$dataListx->quantity1:0;
                $sumQuantity        +=  isset($dataListx->quantity)?$dataListx->quantity:0; 
                $sumAmount          +=  $dataListx->amount;
                $sumBase_vat        +=  $dataListx->base_vat;
                $sumTax_amount      +=  $dataListx->tax_amount;
                $sumRetail_amount   +=  $dataListx->retail_amount;
            @endphp

        @endforeach
        <tr style ="border-top: .5px solid; border-bottom: 0.5px solid;">
                <td style="text-align: left; vertical-align: middle;"><b>รวม</b> </td>
                <td style="text-align: right; vertical-align: middle;"><b>{{$sumQuantity1==0?'':number_format($sumQuantity1,2,".",",")}}</b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{$sumQuantity==0?'':number_format($sumQuantity,2,".",",")}}</b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumAmount,2,".",",")}}</b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumBase_vat,2,".",",")}}</b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumTax_amount,2,".",",")}}</b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumRetail_amount,2,".",",")}}</b></td>
                
        </tr>
        @if ($checkSumCustomerType =='Y')

        @php
            $sumQuantity1   =0;
            $sumQuantity    =0;
            $sumAmount      =0;
            $sumBase_vat    =0;
            $sumTax_amount     =0;
            $sumRetail_amount     =0;
            //dd($dataListsY);
        @endphp

        @foreach($dataListsY as $dataListx)

        @php
                $sumQuantity1       +=  isset($dataListx->quantity1)?$dataListx->quantity1:0;
                $sumQuantity        +=  isset($dataListx->quantity)?$dataListx->quantity:0; 
                $sumAmount          +=  $dataListx->amount;
                $sumBase_vat        +=  $dataListx->base_vat;
                $sumTax_amount      +=  $dataListx->tax_amount;
                $sumRetail_amount   +=  $dataListx->retail_amount;
                $rmaLinesGroupBy = collect();
            @endphp

        @endforeach


        {{-- rma --}}
        
        @switch($case)
            @case(3)
                @php 
                    $rma = $getRMA->where('customer.customer_type_id', 20);
                    $rmaLines = collect();
                    foreach($rma->pluck('lines') as $rmaLine)  {
                        $rmaLines = $rmaLines->merge($rmaLine);
                    }
                    $rmaLinesGroupBy = $rmaLines->groupBy('orderLine.item_id') ?? collect();
                @endphp
                   
                @break
            @case(2)
                
                @break
            @default
        @endswitch
        @php 
                $sumRmaQty       = 0;
                $sumRmaAmount    = 0;
                $sumRmCostSubVat = 0;
                $sumRmVat        = 0;
                $sumRmCost       = 0;
            @endphp
        @if(count($rmaLinesGroupBy) > 0)
            @php 
                $rmaQtyTotal = 0;
                $rmaAmountTotal = 0;
            @endphp
            
            @foreach($rmaLinesGroupBy as $line)
            @php 
                $rmaQty = $line->sum('rma_quantity');
                $rmaAmount = $line->sum(function($i){
                    return $i->rma_quantity * $i->orderLine->unit_price;
                });
                $rmaQtyTotal = $rmaQty;
                $rmaAmountTotal = $rmaAmount;
                $rmaCost = $line->sum(function($i) {
                    return $i->rma_quantity * $i->orderLine->attribute1;
                });
                $rmaVat = ($rmaCost * 7) / 107;

                $sumRmaQty       += $rmaQtyTotal;
                $sumRmaAmount    += $rmaAmountTotal;
                $sumRmCostSubVat += $rmaCost - $rmaVat;
                $sumRmVat        += $rmaVat;
                $sumRmCost       += $rmaCost;
            @endphp
            <tr>
                <td style="text-align: left; vertical-align: middle;">{{ $line->first()->orderLine->item_description }}</td>
                <td style="text-align: right; vertical-align: middle;">({{ number_format($rmaQtyTotal, 2) }})</td>
                <td style="text-align: right; vertical-align: middle;"></td>
                <td style="text-align: right; vertical-align: middle;">({{ number_format($rmaAmount, 2)}})</td>
                <td style="text-align: right; vertical-align: middle;">({{ number_format($rmaCost - $rmaVat, 2) }})</td>
                <td style="text-align: right; vertical-align: middle;">({{ number_format($rmaVat, 2) }})</td>
                <td style="text-align: right; vertical-align: middle;">({{ number_format($rmaCost, 2) }})</td>
            </tr>
            @endforeach
        @endif
        {{-- end --}}
        <tr style ="border-top: .5px solid; border-bottom: 0.5px solid;">
                <td style="text-align: left; vertical-align: middle;"><b>รวม {{$groupA }}</b> </td>
                <td style="text-align: right; vertical-align: middle;"><b>{{$sumQuantity1 - $sumRmaQty==0?'':number_format($sumQuantity1 - $sumRmaQty,2,".",",")}}</b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{$sumQuantity ==0?'':number_format($sumQuantity ,2,".",",")}}</b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumAmount - $sumRmaAmount,2,".",",")}}</b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumBase_vat - $sumRmCostSubVat,2,".",",")}}</b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumTax_amount - $sumRmVat,2,".",",")}}</b></td>
                <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumRetail_amount - $sumRmCost,2,".",",")}}</b></td>
                
        </tr>
        @endif

        @if ($checkSum =='Y')

            @php
                $sumQuantity1   =0;
                $sumQuantity    =0;
                $sumAmount      =0;
                $sumBase_vat    =0;
                $sumTax_amount     =0;
                $sumRetail_amount   =0;
                //dd($dataListsY);
            @endphp

            @foreach($dataLists1->merge($dataLists2)->merge($dataLists3)->merge($dataLists4)->merge($dataLists5)->merge($dataLists6)->merge($dataLists7)->merge($dataLists8)->merge($dataLists9)->merge($dataLists10)->merge($dataLists11)->merge($dataLists12)->merge($dataLists13)->merge($dataLists14) as $dataListx)

            @php
                $sumQuantity1       +=  isset($dataListx->quantity1)?$dataListx->quantity1:0;
                $sumQuantity        +=  isset($dataListx->quantity)?$dataListx->quantity:0; 
                $sumAmount          +=  $dataListx->amount;
                $sumBase_vat        +=  $dataListx->base_vat;
                $sumTax_amount      +=  $dataListx->tax_amount;
                $sumRetail_amount   +=  $dataListx->retail_amount;
            @endphp

            @endforeach

            <tr style ="border-top: .5px solid; border-bottom: 0.5px solid;">
                    <td style="text-align: left; vertical-align: middle;"><b>รวม (บุหรี่+ยาเส้น)</b> </td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{$sumQuantity1==0?'':number_format($sumQuantity1,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{$sumQuantity==0?'':number_format($sumQuantity,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumAmount,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumBase_vat,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumTax_amount,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumRetail_amount,2,".",",")}}</b></td>
            </tr>

            @php
                $sumQuantity1   =0;
                $sumQuantity    =0;
                $sumAmount      =0;
                $sumBase_vat    =0;
                $sumTax_amount     =0;
                $sumRetail_amount   =0;
                //dd($dataListsY);
            @endphp

            @foreach($dataLists15->merge($dataLists16) as $dataListx)

            @php
                $sumQuantity1       +=  isset($dataListx->quantity1)?$dataListx->quantity1:0;
                $sumQuantity        +=  isset($dataListx->quantity)?$dataListx->quantity:0; 
                $sumAmount          +=  $dataListx->amount;
                $sumBase_vat        +=  $dataListx->base_vat;
                $sumTax_amount      +=  $dataListx->tax_amount;
                $sumRetail_amount   +=  $dataListx->retail_amount;
            @endphp

            @endforeach

            <tr style ="border-top: .5px solid; border-bottom: 0.5px solid;" >
                    <td style="text-align: left; vertical-align: middle;"><b>รวม (บุหรี่+ยาเส้น ไม่คิดมูลค่า)</b> </td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{$sumQuantity1==0?'':number_format($sumQuantity1,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{$sumQuantity==0?'':number_format($sumQuantity,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumAmount,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumBase_vat,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumTax_amount,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumRetail_amount,2,".",",")}}</b></td>
            </tr>

            @php
                $sumQuantity1   =0;
                $sumQuantity    =0;
                $sumAmount      =0;
                $sumBase_vat    =0;
                $sumTax_amount     =0;
                $sumRetail_amount   =0;
                //dd($dataListsY);
            @endphp

            @foreach($dataListsZ as $dataListx)

            @php
                $sumQuantity1       +=  isset($dataListx->quantity1)?$dataListx->quantity1:0;
                $sumQuantity        +=  isset($dataListx->quantity)?$dataListx->quantity:0; 
                $sumAmount          +=  $dataListx->amount;
                $sumBase_vat        +=  $dataListx->base_vat;
                $sumTax_amount      +=  $dataListx->tax_amount;
                $sumRetail_amount   +=  $dataListx->retail_amount;
            @endphp

            @endforeach

            <tr style ="border-top: .5px solid; border-bottom: 0.5px solid;">
                    <td style="text-align: left; vertical-align: middle;"><b>รวมทั้งสิ้น</b> </td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{$sumQuantity1==0?'':number_format($sumQuantity1,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{$sumQuantity==0?'':number_format($sumQuantity,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumAmount,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumBase_vat,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumTax_amount,2,".",",")}}</b></td>
                    <td style="text-align: right; vertical-align: middle;"><b>{{number_format($sumRetail_amount,2,".",",")}}</b></td>
            </tr>
        @endif
    

        </tbody>
        </table>
