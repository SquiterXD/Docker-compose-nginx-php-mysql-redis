<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>OMR0029 - รายการจำหน่ายยาสูบสุทธิสะสมรายภาค (รต/11)</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports.OMR0029._style')
    </head>
    <body>
        @php
            $qty        = array('' => '');
            $sum_qty    = array('' => '');
            $amt        = array('' => '');
            $sum_amt    = array('' => '');
        @endphp
        @foreach ($data as $page => $groupItems)
            @php
                $total_page = $loop->count;

                $count_h = $groupItems["last_page"] ? count($groupItems["header"])+2 : count($groupItems["header"]);
                $width_h = round(720/$count_h, 2);
            @endphp
                <table class="table">
                    <thead>
                        <tr style="border-top: 0px; border-bottom: 0px; page-break-inside:avoid;">
                            <td colspan="99">
                                <div class="b" style="font-size: 16px;">
                                    <div class="inline-block" style="width: 22%">
                                        <div>
                                            โปรแกรม : OMR0029
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
                                            รายการจำหน่ายยาสูบสุทธิสะสมรายภาค (รต/11)
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
                                            หน่วย : พันมวน/บุหรี่ หีบ/ยาเส้น
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="b" style="page-break-inside:avoid;">
                            <td class="text-center">
                                ตรา
                            </td>
                            @foreach ($groupItems["header"] as $key => $desc)
                                <td class="text-center" style="width:{{$width_h}}px;">
                                    {{ $desc }}
                                </td>
                            @endforeach
                            @if ($groupItems["last_page"])
                                @if ($groupItems['product_type_code'] != 10)
                                    <td class="text-center" style="width:{{$width_h}}px;">
                                        หีบ
                                    </td>
                                @else
                                    <td class="text-center" style="width:{{$width_h}}px;">
                                        พันมวน
                                    </td>
                                @endif
                                <td class="text-center" style="width:{{$width_h}}px;">
                                    รวมบาท
                                </td>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            foreach($all_headers as $key => $desc){ 
                                $qty[$desc]         = 0;
                                $sum_qty[$desc]     = 0;
                                $amt[$desc]         = 0;
                                $sum_amt[$desc]     = 0;
                            }

                            $total_brand_qty = 0;
                            $total_brand_amt = 0;
                        @endphp
                        @foreach ($groupItems["lines"] as $brand => $groupRegions)
                            @php
                                foreach($groupItems["header"] as $key => $desc){
                                    $qty[$desc] = $groupRegions[$desc]->sum(function ($item) {
                                        if(in_array($item->product_type_code, ['10'])){
                                            if(in_array($item->customer_type_id, ['30', '40'])){
                                                return $item->consignment_quantity;
                                            }elseif(!in_array($item->customer_type_id, ['30', '40', '80'])){
                                                return $item->approve_quantity;
                                            }else return 0;
                                        }elseif(in_array($item->product_type_code, ['20'])){
                                            if(!in_array($item->customer_type_id, ['80'])){
                                                return $item->approve_quantity;
                                            }else return 0;
                                        }else return 0;
                                    });
                                    $sum_qty[$desc] += $qty[$desc];

                                    $amt[$desc] = $groupRegions[$desc]->sum(function ($item) {
                                        if(in_array($item->product_type_code, ['10'])){
                                            if(in_array($item->customer_type_id, ['30', '40'])){
                                                return $item->consignment_amount;
                                            }elseif(!in_array($item->customer_type_id, ['30', '40', '80'])){
                                                return $item->amount;
                                            }else return 0;
                                        }elseif(in_array($item->product_type_code, ['20'])){
                                            if(!in_array($item->customer_type_id, ['80'])){
                                                return $item->amount;
                                            }else return 0;
                                        }else return 0;
                                    });
                                    $sum_amt[$desc] += $amt[$desc];
                                }
                                $brand_qty = 0;
                                $brand_amt = 0;
                                foreach($groupRegions as $region => $items){

                                    $brand_qty += $items->sum(function ($item) {
                                        if(in_array($item->product_type_code, ['10'])){
                                            if(in_array($item->customer_type_id, ['30', '40'])){
                                                return $item->consignment_quantity;
                                            }elseif(!in_array($item->customer_type_id, ['30', '40', '80'])){
                                                return $item->approve_quantity;
                                            }else return 0;
                                        }elseif(in_array($item->product_type_code, ['20'])){
                                            if(!in_array($item->customer_type_id, ['80'])){
                                                return $item->approve_quantity;
                                            }else return 0;
                                        }else return 0;
                                    });

                                    $brand_amt += $items->sum(function ($item) {
                                        if(in_array($item->product_type_code, ['10'])){
                                            if(in_array($item->customer_type_id, ['30', '40'])){
                                                return $item->consignment_amount;
                                            }elseif(!in_array($item->customer_type_id, ['30', '40', '80'])){
                                                return $item->amount;
                                            }else return 0;
                                        }elseif(in_array($item->product_type_code, ['20'])){
                                            if(!in_array($item->customer_type_id, ['80'])){
                                                return $item->amount;
                                            }else return 0;
                                        }else return 0;
                                    });
                                }
                                $total_brand_qty += $brand_qty;
                                $total_brand_amt += $brand_amt;
                            @endphp
                            <tr style="page-break-inside:avoid;">
                                <td>
                                    &emsp; {{ $brand }}
                                </td>
                                @foreach ($groupItems["header"] as $key => $desc)
                                    <td class="text-right">
                                        {{ round($qty[$desc], 2) > 0 ? number_format($qty[$desc], 2) : '' }}
                                    </td>
                                @endforeach
                                @if ($groupItems["last_page"])
                                    <td class="text-right">
                                        {{ round($brand_qty, 2) > 0 ? number_format($brand_qty, 2) : '' }}
                                    </td>
                                    <td class="text-right">
                                        {{ round($brand_amt, 2) > 0 ? number_format($brand_amt, 2) : '' }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        @if ($groupItems["show_sum"])
                            <tr style="border-top: 0.5px solid rgb(100, 100, 100); border-bottom: 0.5px solid rgb(100, 100, 100); page-break-inside:avoid;">
                                @if ($groupItems['product_type_code'] != 10)
                                    <td class="b">
                                        รวมยาเส้น
                                    </td>
                                @else
                                    <td class="b">
                                        รวมบุหรี่
                                    </td>
                                @endif
                                @foreach ($groupItems["header"] as $key => $desc)
                                    <td class="text-right">
                                        {{ number_format($sum_qty[$desc], 2) }}
                                    </td>
                                @endforeach
                                @if ($groupItems["last_page"])
                                    <td class="text-right">
                                        {{ number_format($total_brand_qty, 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{-- {{ number_format($total_brand_amt, 2) }} --}}
                                    </td>
                                @endif
                            </tr>
                            <tr style="border-top: 0.5px solid rgb(100, 100, 100); border-bottom: 0.5px solid rgb(100, 100, 100); page-break-inside:avoid;">
                                <td class="b">
                                    จำนวนเงิน
                                </td>
                                @foreach ($groupItems["header"] as $key => $desc)
                                    <td class="text-right">
                                        {{ number_format($sum_amt[$desc], 2) }}
                                    </td>
                                @endforeach
                                @if ($groupItems["last_page"])
                                    <td class="text-right">
                                        {{-- {{ number_format($total_brand_qty, 2) }} --}}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($total_brand_amt, 2) }}
                                    </td>
                                @endif
                            </tr>
                        @endif
                    </tbody>
                </table>

                @if ($total_page == $page+1)
                    <div style="padding-left: 1rem; margin-top: 0.5rem;">
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
    </body>
</html>