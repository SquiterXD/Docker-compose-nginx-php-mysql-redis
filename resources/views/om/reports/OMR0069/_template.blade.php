<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>OMR0069 - รายการฝากขายสโมสร</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports.OMR0069._style')
    </head>
    <body>
        @php
            $total_qty = 0;
            $total_amt = 0;
            $total_tax = 0;
            $total_base = 0;
            $total_retail = 0;
        @endphp
        @foreach ($data as $page => $group)
                @php
                    $total_page = $loop->count;
                    $count_h = 8;
                    $width_h = round(720/$count_h, 2);
                    $sum_qty = 0;
                    $sum_amt = 0;
                    $sum_tax = 0;
                    $sum_base = 0;
                    $sum_retail = 0;
                @endphp
                <table class="table">
                    <thead>
                        <tr style="border-top: 0px; border-bottom: 0px; page-break-inside:avoid;">
                            <td colspan="99">
                                <div class="b" style="font-size: 16px;">
                                    <div class="inline-block" style="width: 22%">
                                        <div>
                                            โปรแกรม : OMR0069
                                        </div>
                                        <div>
                                            สั่งพิมพ์ : {{ \Auth::user()->username }}
                                        </div>
                                        <div>
                                            {!! $group['title'] !!}
                                        </div>
                                    </div>
                                    <div class="inline-block text-center" style="width: 55%">
                                        <div>
                                            การยาสูบแห่งประเทศไทย
                                        </div>
                                        <div>
                                            รายการฝากขายสโมสร
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
                                            หน่วย พันมวน
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr style="page-break-inside:avoid;">
                            <th class="text-center" style="width:{{$width_h}}px;">
                                ตรา
                            </th>
                            <th class="text-center" style="width:{{$width_h}}px;">
                                จำนวนห่อ
                            </th>
                            <th class="text-center" style="width:{{$width_h}}px;">
                                ยอดมวน
                            </th>
                            <th class="text-center" style="width:{{$width_h}}px;">
                                ยอดซอง
                            </th>
                            <th class="text-center" style="width:{{$width_h}}px;">
                                จำนวนเงิน
                            </th>
                            <th class="text-center" style="width:{{$width_h}}px;">
                                ภาษีมูลค่าเพิ่ม
                            </th>
                            <th class="text-center" style="width:{{$width_h}}px;">
                                มูลค่าสินค้า
                            </th>
                            <th class="text-center" style="width:{{$width_h}}px;">
                                ราคาปลีก
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group['lines'] as $item_desc => $items)
                            @php
                                $qty = $items->sum('consignment_quantity');
                                $amt = $items->sum('consignment_amount');
                                $tax = $items->sum('tax_amount');
                                $base = $items->sum('base_vat');
                                $retail = $items->sum('retail_amount');
                                $sum_qty += $qty;
                                $sum_amt += $amt;
                                $sum_tax += $tax;
                                $sum_base += $base;
                                $sum_retail += $retail;
                                $total_qty += $qty;
                                $total_amt += $amt;
                                $total_tax += $tax;
                                $total_base += $base;
                                $total_retail += $retail;
                            @endphp
                            <tr>
                                <td>
                                    {{-- ตรา --}}
                                    {{ $item_desc }}
                                </td>
                                <td class="text-right">
                                    {{-- จำนวนห่อ --}}
                                    {{ $qty != 0 ? number_format($qty * 5, 2) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- ยอดมวน --}}
                                    {{ $qty != 0 ? number_format($qty, 2)  : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- ยอดซอง --}}
                                    {{-- {{ number_format(0, 2) }} --}}
                                </td>
                                <td class="text-right">
                                    {{-- จำนวนเงิน --}}
                                    {{ $amt != 0 ? number_format($amt, 2) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- ภาษีมูลค่าเพิ่ม --}}
                                    {{ $tax != 0 ? number_format($tax, 2) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- มูลค่าสินค้า --}}
                                    {{ $base != 0 ? number_format($base, 2) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- ราคาปลีก --}}
                                    {{ $retail != 0 ? number_format($retail, 2) : '' }}
                                </td>
                            </tr>
                        @endforeach
                        <tr style="border-top: 0.5px solid rgb(100, 100, 100); border-bottom: 0.5px solid rgb(100, 100, 100); page-break-inside:avoid;">
                            <td class="text-right">
                                รวม
                            </td>
                            <td class="text-right">
                                {{-- จำนวนห่อ --}}
                                {{ $sum_qty != 0 ? number_format($sum_qty * 5, 2) : '' }}
                            </td>
                            <td class="text-right">
                                {{-- ยอดมวน --}}
                                {{ $sum_qty != 0 ? number_format($sum_qty, 2) : '' }}
                            </td>
                            <td class="text-right">
                                {{-- ยอดซอง --}}
                                {{-- {{ number_format(0, 2) }} --}}
                            </td>
                            <td class="text-right">
                                {{-- จำนวนเงิน --}}
                                {{ $sum_amt != 0 ? number_format($sum_amt, 2) : '' }}
                            </td>
                            <td class="text-right">
                                {{-- ภาษีมูลค่าเพิ่ม --}}
                                {{ $sum_tax != 0 ? number_format($sum_tax, 2) : '' }}
                            </td>
                            <td class="text-right">
                                {{-- มูลค่าสินค้า --}}
                                {{ $sum_base != 0 ? number_format($sum_base, 2) : '' }}
                            </td>
                            <td class="text-right">
                                {{-- ราคาปลีก --}}
                                {{ $sum_retail != 0 ? number_format($sum_retail, 2) : '' }}
                            </td>
                        </tr>
                        @if ($group['show_sum'])
                            <tr style="border-top: 0.5px solid rgb(100, 100, 100); border-bottom: 0.5px solid rgb(100, 100, 100); page-break-inside:avoid;">
                                <td class="text-right">
                                    รวมทั้งสิ้น
                                </td>
                                <td class="text-right">
                                    {{-- จำนวนห่อ --}}
                                    {{ $total_qty != 0 ? number_format($total_qty * 5, 2) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- ยอดมวน --}}
                                    {{ $total_qty != 0 ? number_format($total_qty, 2) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- ยอดซอง --}}
                                    {{-- {{ number_format(0, 2) }} --}}
                                </td>
                                <td class="text-right">
                                    {{-- จำนวนเงิน --}}
                                    {{ $total_amt != 0 ? number_format($total_amt, 2) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- ภาษีมูลค่าเพิ่ม --}}
                                    {{ $total_tax != 0 ? number_format($total_tax, 2) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- มูลค่าสินค้า --}}
                                    {{ $total_base != 0 ? number_format($total_base, 2) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- ราคาปลีก --}}
                                    {{ $total_retail != 0 ? number_format($total_retail, 2) : '' }}
                                </td>
                            </tr>
                            @php
                                $total_qty = 0;
                                $total_amt = 0;
                                $total_tax = 0;
                                $total_base = 0;
                                $total_retail = 0;
                            @endphp
                        @endif
                    </tbody>
                </table>
                <div style="padding-left: 1rem; margin-top: 0.5rem;">
                    หมายเหตุ * หน่วยเป็นของ <br>
                    {!! $group['footer'] !!}
                </div>
                @if ($group['show_sum'])
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