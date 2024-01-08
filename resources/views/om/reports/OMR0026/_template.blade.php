<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>OMR0026 - ยอดจำหน่ายบุหรี่ยาเส้น รต5</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports.OMR0026._style')
    </head>
    <body>
        @php
            $total_qty = collect();
            $total_amt = collect();
            foreach ($headers as $day_of_week => $desc) {
                $total_qty->put($day_of_week, 0);
                $total_amt->put($day_of_week, 0);
            }
            $total_qty->put('total', 0);
            $total_amt->put('total', 0);
        @endphp
        @foreach ($data as $page => $group)
                @php
                    $rma = $getRMA->where('orderHeader.product_type_code', $group['product_type_code']);
                    $rmaLines = collect();
                    foreach($rma->pluck('lines') as $rmaLine)  {
                        $rmaLines = $rmaLines->merge($rmaLine);
                    }
                    $rmaLinesGroupBy = $rmaLines->groupBy('orderLine.item_id') ?? collect();
                    $total_page = $loop->count;
                    $count_h = count($headers)+2;
                    $width_h = round(720/$count_h, 2);
                    $sum_qty = collect();
                    $sum_amt = collect();
                    foreach ($headers as $day_of_week => $desc) {
                        $sum_qty->put($day_of_week, 0);
                        $sum_amt->put($day_of_week, 0);
                    }
                    $sum_qty->put('total', 0);
                    $sum_amt->put('total', 0);
                @endphp
                <table class="table">
                    <thead>
                        <tr style="border-top: 0px; border-bottom: 0px; page-break-inside:avoid;">
                            <td colspan="99">
                                <div class="b" style="font-size: 16px;">
                                    <div class="inline-block" style="width: 22%">
                                        <div>
                                            โปรแกรม : OMR0026
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
                                            ยอดจำหน่ายบุหรี่ยาเส้น รต5
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
                                        <div>
                                            หน่วย {{ $group['product_type_code'] == 10 ? 'พันมวน/บุหรี่' : 'หีบ/ยาเส้น' }} 
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr style="page-break-inside:avoid;">
                            <th class="text-center" style="width:{{$width_h}}px;">
                                ตราบุหรี่
                            </th>
                            @foreach ($headers as $key => $desc)
                                <th colspan="2" class="text-center" style="width:{{$width_h}}px;">
                                    {{ $desc }}
                                </th>
                            @endforeach
                            <th colspan="2" class="text-center" style="width:{{$width_h}}px;">
                                รวม
                            </th>
                        </tr>
                        <tr style="page-break-inside:avoid;">
                            <th class="text-center">
                            </th>
                            @foreach ($headers as $key => $desc)
                                <th class="text-center">
                                    {{-- พันมวน --}}
                                    {{ $group['product_type_code'] == 10 ? 'พันมวน' : 'หีบ' }} 
                                </th>
                                <th class="text-center">
                                    บาท
                                </th>
                            @endforeach
                            <th class="text-center">
                                {{-- พันมวน --}}
                                {{ $group['product_type_code'] == 10 ? 'พันมวน' : 'หีบ' }} 
                            </th>
                            <th class="text-center">
                                บาท
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group['lines'] as $item_desc => $items)
                            @php
                                $qty = collect();
                                $amt = collect();
                                foreach ($headers as $day_of_week => $desc) {
                                    $qty->put($day_of_week, $items->where('day_of_week', $day_of_week)->sum('qty'));
                                    $amt->put($day_of_week, $items->where('day_of_week', $day_of_week)->sum('amount'));
                                    $sum_qty[$day_of_week] += $qty[$day_of_week];
                                    $sum_amt[$day_of_week] += $amt[$day_of_week];
                                    $total_qty[$day_of_week] += $qty[$day_of_week];
                                    $total_amt[$day_of_week] += $amt[$day_of_week];
                                }
                                $qty->put('total', $items->sum('qty'));
                                $amt->put('total', $items->sum('amount'));
                                $sum_qty['total'] += $qty['total'];
                                $sum_amt['total'] += $amt['total'];
                                $total_qty['total'] += $qty['total'];
                                $total_amt['total'] += $amt['total'];
                            @endphp
                            <tr>
                                <td>
                                    {{ $item_desc }}
                                </td>
                                @foreach ($headers as $day_of_week => $desc)
                                    <td class="text-right">
                                        {{ number_format($qty[$day_of_week], 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($amt[$day_of_week], 2) }}
                                    </td>
                                @endforeach
                                <td class="text-right">
                                    {{ number_format($qty['total'], 2) }}
                                </td>
                                <td class="text-right">
                                    {{ number_format($amt['total'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr style="border-top: 0.5px solid rgb(100, 100, 100); border-bottom: 0.5px solid rgb(100, 100, 100); page-break-inside:avoid;">
                            <td class="text-right">
                                รวม
                            </td>
                            @foreach ($headers as $day_of_week => $desc)
                                <td class="text-right">
                                    {{ number_format($sum_qty[$day_of_week], 2) }}
                                </td>
                                <td class="text-right">
                                    {{ number_format($sum_amt[$day_of_week], 2) }}
                                </td>
                            @endforeach
                            <td class="text-right">
                                {{ number_format($sum_qty['total'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($sum_amt['total'], 2) }}
                            </td>
                        </tr>
                        @if ($total_page == $page+1)
                            <tr style="border-top: 0.5px solid rgb(100, 100, 100); border-bottom: 0.5px solid rgb(100, 100, 100); page-break-inside:avoid;">
                                <td class="text-right">
                                    รวมทั้งสิ้น
                                </td>
                                @foreach ($headers as $day_of_week => $desc)
                                    <td class="text-right">
                                        {{-- {{ number_format($total_qty[$day_of_week], 2) }} --}}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($total_amt[$day_of_week], 2) }}
                                    </td>
                                @endforeach
                                <td class="text-right">
                                    {{-- {{ number_format($total_qty['total'], 2) }} --}}
                                </td>
                                <td class="text-right">
                                    {{ number_format($total_amt['total'], 2) }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if(count($rmaLinesGroupBy) > 0)
                <h4>รายการใบลดหนี้</h4>
                <table style="width:100%">
                    <tr>
                        <th style="width:102.86px;">ตราบุหรี่</th>
                        @foreach ($headers as $key => $desc)
                            <th>พันมวน</th>
                            <th>บาท</th>
                        @endforeach
                        <th>พันมวน</th>
                        <th>บาท</th>
                    </tr>
                    @php 
                        $rmaQtyTotal = [];
                        $rmaAmountTotal = [];
                    @endphp
                    @foreach($rmaLinesGroupBy as $line)
                    @php 
                        $rmaQtySum = 0;
                        $rmaAmountSum = 0;
                    @endphp
                    <tr>
                        <td >{{ ($line->first()->orderLine->item_description) }}</td>
                        @foreach ($headers as $key => $desc)
                        @php 
                            $rmaQty = $line->where('dayTxt', $key)->sum('rma_quantity');
                            $rmaAmount = $line->where('dayTxt', $key)->sum(function($i){
                                return $i->rma_quantity * $i->orderLine->unit_price;
                            });
                            $rmaQtySum += $rmaQty;
                            $rmaAmountSum += $rmaAmount;
                            @$rmaQtyTotal[$key] += $rmaQty;
                            @$rmaAmountTotal[$key] += $rmaAmount;
                        @endphp
                        <td align="right">({{ number_format($rmaQty, 2) }})</td>
                        <td align="right">({{ number_format($rmaAmount, 2) }})</td>
                        @endforeach
                        <td align="right">({{ number_format($rmaQtySum, 2) }})</td>
                        <td align="right">({{ number_format($rmaAmountSum, 2) }})</td>
                    </tr>
                    @endforeach
                    <tr style="border-top: 0.5px solid rgb(100, 100, 100); border-bottom: 0.5px solid rgb(100, 100, 100); page-break-inside:avoid;">
                        <td style="border-top: 0.5px solid rgb(100, 100, 100);border-bottom: 0.5px solid rgb(100, 100, 100);">
                            รวม
                        </td>
                        @foreach ($headers as $key => $desc)
                        <td style="border-top: 0.5px solid rgb(100, 100, 100);border-bottom: 0.5px solid rgb(100, 100, 100);text-align: right">({{ number_format($rmaQtyTotal[$key], 2) }})</td>
                        <td style="border-top: 0.5px solid rgb(100, 100, 100);border-bottom: 0.5px solid rgb(100, 100, 100);text-align: right">({{ number_format($rmaAmountTotal[$key], 2) }})</td>
                        @endforeach
                        <td style="border-top: 0.5px solid rgb(100, 100, 100);border-bottom: 0.5px solid rgb(100, 100, 100);text-align: right">({{number_format(array_sum($rmaQtyTotal), 2)}})</td>
                        <td style="border-top: 0.5px solid rgb(100, 100, 100);border-bottom: 0.5px solid rgb(100, 100, 100);text-align: right">({{number_format(array_sum($rmaAmountTotal), 2)}})</td>
                    </tr>
                    <tr style="border-top: 0.5px solid rgb(100, 100, 100); border-bottom: 0.5px solid rgb(100, 100, 100); page-break-inside:avoid;">
                        <td style="border-bottom: 0.5px solid rgb(100, 100, 100);" >
                            รวมทั้งสิ้น
                        </td>
                        @foreach ($headers as $day_of_week => $desc)
                            <td class="text-right" style="border-bottom: 0.5px solid rgb(100, 100, 100);"  >
                                {{ number_format($sum_qty[$day_of_week] - $rmaQtyTotal[$day_of_week] , 2) }}
                            </td>
                            <td class="text-right" style="border-bottom: 0.5px solid rgb(100, 100, 100);" >
                                {{ number_format($sum_amt[$day_of_week] -$rmaAmountTotal[$day_of_week] , 2) }}
                            </td>
                        @endforeach
                        <td class="text-right" style="border-bottom: 0.5px solid rgb(100, 100, 100);" >
                            {{ number_format($sum_qty['total'], 2) }}
                        </td>
                        <td class="text-right" style="border-bottom: 0.5px solid rgb(100, 100, 100);" >
                            {{ number_format($sum_amt['total'], 2) }}
                        </td>
                    </tr>
                </table>
                @endif
                @if ($total_page == $page+1)
                    <div style="padding-left: 1rem; margin-top: 1rem;">
                        หมายเหตุรายการ : 
                        @if(count($getRMA) > 0)
                        {{ "เลขที่ใบลดหนี้ " .($getRMA->pluck('credit_note_number')->join(', '))}}
                        @endif
                        {{ $remark }}
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
    </body>
</html>