<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>OMR0027 - รายงานจำนวนจำหน่ายยาสูบ/ยาเส้น ประจำเดือน (รต/10)</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports.OMR0027._style')
    </head>
    <body>
        @php
            $old_region = null;
        @endphp
        @foreach ($data as $page => $groupRegion)
            @php
                $total_page = $loop->count;
            @endphp
            @foreach ($groupRegion as $region => $groupItems)
                @php
                    $allData = $groupItems["datas"];
                    if($old_region != $region){
                        $old_region = $region;
                        $totals = array('' => '');
                        $qty = array('' => '');
                        $sum_cig_qty = array('' => '');
                        $sum_cig_amt = array('' => '');
                        $sum_tobacco_qty = array('' => '');
                        $sum_tobacco_amt = array('' => '');
                        $sum_total_amt = array('' => '');

                        //toat_edit
                        $sum_cig_qty_rma=0;
                        $sum_cig_amt_rma=0;
                        $total_qty_rma=0;
                        $total_amt_rma=0;
                        //toat_edit


                        $total_sum_cig_qty = 0;
                        $total_sum_cig_amt = 0;
                        $total_sum_tobacco_qty = 0;
                        $total_sum_tobacco_amt = 0;
                        $total_sum_total_amt = 0;
                        foreach($all_headers as $key => $desc){ 
                            $qty[$desc] = 0;
                            $totals[$desc] = 0;
                        }

                        $groupCustomer = $allData->groupBy("customer_name");

                        foreach($groupCustomer as $customer_name => $groups){
                            $sum_cig_qty[$customer_name] = $groups->where('product_type_code', '10')
                            ->sum(function ($item) {
                                return in_array($item->customer_type_id, ['30', '40']) ? $item->consignment_quantity : $item->approve_quantity;
                            });

                            $sum_cig_amt[$customer_name] = $groups->where('product_type_code', '10')
                            ->sum(function ($item) {
                                return in_array($item->customer_type_id, ['30', '40']) ? $item->consignment_amount : $item->amount;
                            });

                            $sum_tobacco_qty[$customer_name] = $groups->where('product_type_code', '20')
                            ->sum("approve_quantity");

                            $sum_tobacco_amt[$customer_name] = $groups->where('product_type_code', '20')
                            ->sum("amount");

                            $sum_total_amt[$customer_name] = $sum_cig_amt[$customer_name]+$sum_tobacco_amt[$customer_name];
                            
                            $total_sum_cig_qty += $sum_cig_qty[$customer_name];
                            $total_sum_cig_amt += $sum_cig_amt[$customer_name];
                            $total_sum_tobacco_qty += $sum_tobacco_qty[$customer_name];
                            $total_sum_tobacco_amt += $sum_tobacco_amt[$customer_name];
                            $total_sum_total_amt += $sum_total_amt[$customer_name];
                        }
                    }
                    $count_h = $groupItems["last_page"] ? count($groupItems["header"])+5 : count($groupItems["header"]);
                    $width_h = round(720/$count_h, 2);
                @endphp
                <table class="table">
                    <thead>
                        <tr style="border-top: 0px; border-bottom: 0px; page-break-inside:avoid;">
                            <td colspan="99">
                                <div class="b" style="font-size: 16px;">
                                    <div class="inline-block" style="width: 22%">
                                        <div>
                                            โปรแกรม : OMR0027
                                        </div>
                                        <div>
                                            สั่งพิมพ์ : {{ \Auth::user()->username }}
                                        </div>
                                    </div>
                                    <div class="inline-block text-center" style="width: 55%">
                                        <div>
                                            การยาสูบแห่งประเทศไทย
                                        </div>
                                        <div>
                                            รายงานจำนวนจำหน่ายยาสูบ/ยาเส้น ประจำเดือน (รต/10)
                                        </div>
                                        <div style="margin-top: 0.2rem;">
                                            ตั้งแต่วันที่ {{ dateFormatThai($start_date) }} ถึงวันที่ {{ dateFormatThai($end_date) }}
                                        </div>
                                    </div>
                                    <div class="inline-block text-right" style="width: 22%">
                                        <div>
                                            วันที่ {{ dateFormatThai(date('d-M-Y')) }}
                                        </div>
                                        <div>
                                            เวลา {{ strtoupper(date('H:i')) }}
                                        </div>
                                        <div>
                                            {{-- หน้า : <span class="page-number"></span> --}}
                                            หน้า {{ $page+1 }} / {{ $total_page }}
                                        </div>
                                    </div>
                                </div>
                                <div class="b">
                                    {{ $region }}
                                </div>
                            </td>
                        </tr>
                        <tr class="b" style="page-break-inside:avoid;">
                            <td class="text-center">
                                ตลาด<br>
                                ชื่อร้านขายส่ง
                            </td>
                            <td class="text-center" style="width:10px">
                                
                            </td>
                            @foreach ($groupItems["header"] as $key => $desc)
                                <td class="text-center" style="width:{{$width_h}}px;">
                                    {{ $desc }}
                                </td>
                            @endforeach
                            @if ($groupItems["last_page"])
                                <td class="text-center" style="width:{{$width_h}}px;">
                                    ยอดรวม<br>
                                    บุหรี่
                                </td>
                                <td class="text-center" style="width:{{$width_h}}px;">
                                    จำนวนเงินบุหรี่
                                </td>
                                <td class="text-center" style="width:{{$width_h}}px;">
                                    ยอดรวม<br>
                                    ยาเส้น
                                </td>
                                <td class="text-center" style="width:{{$width_h}}px;">
                                    จำนวนเงินยาเส้น
                                </td>
                                <td class="text-center" style="width:{{$width_h}}px;">
                                    จำนวนเงินทั้งสิ้น
                                </td>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        
                        @php 
                        $sumRMA = [];
                        @endphp
                        
                        @foreach ($groupItems["lines"] as $market => $groupCustomer)
                            <tr class="b" style="page-break-inside:avoid;">
                                <td>
                                    {{ $market }}
                                </td> 
                            </tr>
                            @foreach ($groupCustomer as $customer_name => $items)
                                @php
                                   
                                    foreach($groupItems["header"] as $key => $desc){
                                        $qty[$desc] = $items[$desc]->sum(function ($item) {
                                            return in_array($item->customer_type_id, ['30', '40']) 
                                            ? $item->consignment_quantity : $item->approve_quantity;
                                        });
                                        $totals[$desc] += $qty[$desc];
                                    }
                                    
                                    $rma  = $getRMA->where('customer.customer_name', $customer_name);
                                    dd($rma);
                                   
                                @endphp
                                <tr style="page-break-inside:avoid;">
                                    <td>
                                        &emsp; {{ $customer_name }}
                                    </td>
                                    <td>
                                        {{ $region != 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? 'ส่ง' : '' }} 
                                    </td>
                                    @foreach ($groupItems["header"] as $key => $desc)
                                        <td class="text-right">
                                            {{ round($qty[$desc], 2) > 0 ? number_format($qty[$desc], 2) : '' }}
                                        </td>
                                    @endforeach
                                    @if ($groupItems["last_page"])
                                        <td class="text-right">
                                            {{ round($sum_cig_qty[$customer_name], 2) > 0 ? number_format($sum_cig_qty[$customer_name], 2) : '' }}
                                        </td>
                                        <td class="text-right">
                                            {{ round($sum_cig_amt[$customer_name], 2) > 0 ? number_format($sum_cig_amt[$customer_name], 2) : '' }}
                                        </td>
                                        <td class="text-right">
                                            {{ round($sum_tobacco_qty[$customer_name], 2) > 0 ? number_format($sum_tobacco_qty[$customer_name], 2) : '' }}
                                        </td>
                                        <td class="text-right">
                                            {{ round($sum_tobacco_amt[$customer_name], 2) > 0 ? number_format($sum_tobacco_amt[$customer_name], 2) : '' }}
                                        </td>
                                        <td class="text-right">
                                            {{ round($sum_total_amt[$customer_name], 2) > 0 ? number_format($sum_total_amt[$customer_name], 2) : '' }}
                                        </td>
                                    @endif
                                </tr>
                                
                                @if(count($rma) > 0) 
                                
                                <tr>
                                    <td>&emsp; ลดหนี้ </td>
                                    <td>
                                    </td>
                                    @php  
                                       // dd($groupItems["header"]); 
                                    @endphp
                                    @foreach ($groupItems["header"] as $key => $desc)
                                    @php 
                                    
                                    $rmaLines = collect();
                                    //print_r($rma->pluck('lines'));

                                    //dd($rma->pluck('lines'));
                                    foreach($rma->pluck('lines') as $rmaI) {
                                        $rmaLines = $rmaLines->merge($rmaI);
                                    }

                                    //dd($rmaLines);
                                    //$rmaItem = $rmaLines->where('orderLine.item_description', $desc);
                                   $rmaItem = $rmaLines->where('orderLine.item_description', $desc);
                                                //->where('customer.customer_name', $customer_name);
                                    //dd($rmaItem);
                                    //$rmaAmt = $rmaLines->where('orderLine.item_description', $desc);
                                    $rmaQty[$desc] = 0;
                                    
                                    if(count($rmaItem) > 0) {
                                        $rmaQty[$desc] = $rmaItem->sum('rma_quantity');

                                        $sum_cig_qty_rma += $rmaItem->sum('rma_quantity');
                                        $sum_cig_amt_rma += $rmaItem->sum('rma_quantity') * $rmaItem->sum('orderLine.unit_price'); 
                                    }
                                    //echo $desc.' '.$rmaQty[$desc]."<br>";
                                    @$sumRMA[$desc] +=  $rmaQty[$desc];
                                    
                                    @endphp
                                        <td class="text-right">
                                            @if($rmaQty[$desc] != 0)
                                            ({{ number_format($rmaQty[$desc], 2) }}) 
                                            @endif
                                        </td>
                                    @endforeach
                                    @php 
                                    //echo $sum_cig_qty_rma;
                                    //dd(@$sumRMA);
                                    @endphp
                                   
                                    
                                    
                                    {{--toat edit--}}
                                    @if ($groupItems["last_page"])
                                        <td class="text-right">
                                            ({{ round($sum_cig_qty_rma,2) > 0 ? number_format($sum_cig_qty_rma, 2) : '' }})
                                        </td>
                                        <td class="text-right">
                                            ({{ round($sum_cig_amt_rma, 2) > 0 ? number_format($sum_cig_amt_rma, 2) : '' }})
                                        </td>
                                        <td class="text-right">
                                            {{round($sum_tobacco_qty[$customer_name], 2) > 0 ? number_format($sum_tobacco_qty[$customer_name], 2) : '' }}
                                        </td>
                                        <td class="text-right">
                                            {{round($sum_tobacco_amt[$customer_name], 2) > 0 ? number_format($sum_tobacco_amt[$customer_name], 2) : ''}}
                                        </td>
                                        <td class="text-right">
                                            ({{round($sum_cig_amt_rma, 2) > 0 ? number_format($sum_cig_amt_rma, 2) : '' }})
                                        </td>
                                     @endif
                                    {{-- end toat edit--}}
                                </tr>
                                @endif
                            @endforeach
                        @endforeach
                        @if ($groupItems["show_sum"])
                            <tr style="border-top: 0.5px solid rgb(100, 100, 100); border-bottom: 0.5px solid rgb(100, 100, 100); page-break-inside:avoid;">
                                <td class="b">
                                    รวมบุหรี่/ยาเส้น มีมูลค่า ส่ง
                                </td>
                                <td class="text-right">
                                    
                                </td>
                                @foreach ($groupItems["header"] as $key => $desc)
                                    <td class="text-right">
                                        {{ number_format( $region != 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $totals[$desc] - @$sumRMA[$desc]: 0 , 2) }}
                                    </td>
                                @endforeach
                                @if ($groupItems["last_page"])
                                    <td class="text-right">
                                        {{ number_format( $region != 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $total_sum_cig_qty - $sum_cig_qty_rma: 0 , 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format( $region != 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $total_sum_cig_amt - $sum_cig_amt_rma: 0 , 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format( $region != 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $total_sum_tobacco_qty : 0 , 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format( $region != 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $total_sum_tobacco_amt : 0 , 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format( $region != 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $total_sum_total_amt - $sum_cig_amt_rma: 0 , 2) }}
                                    </td>
                                @endif
                            </tr>
                            <tr style="border-top: 0.5px solid rgb(100, 100, 100); border-bottom: 0.5px solid rgb(100, 100, 100); page-break-inside:avoid;">
                                <td class="b">
                                    รวมบุหรี่/ยาเส้น ไม่มีมูลค่า ส่ง
                                </td>
                                <td class="text-right">
                                    
                                </td>
                                @foreach ($groupItems["header"] as $key => $desc)
                                    <td class="text-right">
                                        {{ number_format( $region == 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $totals[$desc]  - @$sumRMA[$desc] : 0 , 2) }}
                                    </td>
                                @endforeach
                                @if ($groupItems["last_page"])
                                    <td class="text-right">
                                        {{ number_format( $region == 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $total_sum_cig_qty : 0 , 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format( $region == 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $total_sum_cig_amt : 0 , 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format( $region == 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $total_sum_tobacco_qty : 0 , 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format( $region == 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $total_sum_tobacco_amt : 0 , 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format( $region == 'บุหรี่/ยาเส้นไม่มีมูลค่า' ? $total_sum_total_amt : 0 , 2) }}
                                    </td>
                                @endif
                            </tr>
                            <tr style="border-top: 0.5px solid rgb(100, 100, 100); border-bottom: 0.5px solid rgb(100, 100, 100); page-break-inside:avoid;">
                                <td class="b">
                                    รวมบุหรี่/ยาเส้น ทั้งสิ้น ส่ง
                                </td>
                                <td class="text-right">
                                    
                                </td>
                                @foreach ($groupItems["header"] as $key => $desc)
                                    <td class="text-right">
                                        {{ number_format($totals[$desc]  - @$sumRMA[$desc], 2) }}
                                    </td>
                                @endforeach
                                @if ($groupItems["last_page"])
                                    <td class="text-right">
                                        {{ number_format($total_sum_cig_qty - $sum_cig_qty_rma, 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($total_sum_cig_amt - $sum_cig_amt_rma, 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($total_sum_tobacco_qty, 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($total_sum_tobacco_amt, 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($total_sum_total_amt - $sum_cig_amt_rma, 2) }}
                                    </td>
                                @endif
                            </tr>
                        @endif
                    </tbody>
                </table>

                @if ($total_page == $page+1)
                    <div style="padding-left: 1rem; margin-top: 1rem;">
                        หมายเหตุรายการ : {{ $remark }}
                    </div>
                    <div>
                        <div class="inline-block" style="width: 22%">
                            <div>
                            </div>
                        </div>
                        <div class="inline-block text-center" style="width: 55%">
                            จบรายงาน 
                        </div>
                        <div class="inline-block text-right" style="width: 22%">
                            <div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 0.5rem;">
                        <div class="inline-block" style="width: 11%">
                            <div>
                            </div>
                        </div>
                        <div class="inline-block text-center" style="width: 77%">
                            <div class="inline-block text-center">
                                ผู้จัดทำ _______________________________________
                            </div>
                            <div class="inline-block text-center" style="margin-left: 0.5rem">
                                ผู้ตรวจทาน _______________________________________
                            </div>
                            <div class="inline-block text-center" style="margin-left: 0.5rem">
                                รับรองถูกต้อง _______________________________________
                            </div>
                        </div>
                        <div class="inline-block text-right" style="width: 11%">
                            <div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="page-break"></div>
            @endforeach
        @endforeach
    </body>
</html>