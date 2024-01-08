<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>OMR0125 - รายงานการส่งออกบุหรี่ต่างประเทศ</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports.OMR0125._style')
    </head>
    <body>
        @forelse ($data as $page => $group)
            @php
                $total_page = $loop->count;
            @endphp
            <table class="table">
                <thead>
                    <tr style="border-top: 0px; border-bottom: 0px; page-break-inside:avoid;">
                        <td colspan="99">
                            <div class="b" style="font-size: 16px;">
                                <div>
                                    การยาสูบแห่งประเทศไทย
                                </div>
                                <div>
                                    รายงานการขายบุหรี่ส่งออกต่างประเทศประจำปีงบประมาณ {{ request()->budget_year + 543 }} ( {{ dateFormatThaiString($start_date) }} - {{ dateFormatThaiString($end_date) }}  )
                                </div>
                                <div>
                                    วันที่ : {{ dateFormatThai(date('d-M-Y')) }}
                                </div>
                                <div>
                                    สั่งพิมพ์ : {{ \Auth::user()->username }} เวลา : {{ strtoupper(date('H:i')) }}
                                </div>
                                <div class="text-right">
                                    ปริมาณ({{ $group['uom'] }})
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr style="page-break-inside:avoid;">
                        <th style="width: 20px;">
                            Inv No.
                        </th>
                        <th >
                            บริษัท
                        </th>
                        <th style="width: 20px;">
                            ประเทศ
                        </th>
                        <th style="width: 20px;">
                            วันที่ส่งออก
                        </th>
                        @foreach ($group['all_headers'] as $item_code => $desc)
                            <th>
                                {{ $desc }}
                            </th>
                        @endforeach
                        <th style="width: 50px;">
                            รวมทุกตรา
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($group['lines'] as $pick_no => $items)
                        {{-- @php
                            dd($items);
                        @endphp --}}
                        <tr style="page-break-inside:avoid;">
                            <td>
                                {{ $pick_no }}
                            </td>
                            <td>
                                {{ $items['customer_name'] }}
                            </td>
                            <td>
                                {{ $items['country_name'] }}
                            </td>
                            <td>
                                {{ dateFormatThai($items['pick_release_approve_date']) }}
                            </td>
                            @foreach ($group['all_headers'] as $item_code => $desc)
                                @php
                                    $qty = $items['headers'][$item_code]->sum('quantity');
                                @endphp
                                <td class="text-right">
                                    {{ showNumber($qty) ?: '-' }}
                                </td>
                            @endforeach
                            @php
                                $sum_qty = $items['data']->sum('quantity');
                            @endphp
                            <td class="text-right">
                                {{ showNumber($sum_qty) ?: '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="page-break"></div>

            <table class="table">
                <thead>
                    <tr style="border-top: 0px; border-bottom: 0px; page-break-inside:avoid;">
                        <td colspan="99">
                            <div class="b" style="font-size: 16px;">
                                <div>
                                    การยาสูบแห่งประเทศไทย
                                </div>
                                <div>
                                    รายงานการขายบุหรี่ส่งออกต่างประเทศประจำปีงบประมาณ {{ request()->budget_year + 543 }} ( {{ dateFormatThaiString($start_date) }} - {{ dateFormatThaiString($end_date) }}  )
                                </div>
                                <div>
                                    วันที่ : {{ dateFormatThai(date('d-M-Y')) }}
                                </div>
                                <div>
                                    สั่งพิมพ์ : {{ \Auth::user()->username }} เวลา : {{ strtoupper(date('H:i')) }}
                                </div>
                                <div class="text-right">
                                    มูลค่า(บาท)
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr style="page-break-inside:avoid;">
                        <th style="width: 20px;">
                            Inv No.
                        </th>
                        <th >
                            บริษัท
                        </th>
                        <th style="width: 20px;">
                            ประเทศ
                        </th>
                        <th style="width: 20px;">
                            วันที่ส่งออก
                        </th>
                        @foreach ($group['all_headers'] as $item_code => $desc)
                            <th>
                                {{ $desc }}
                            </th>
                        @endforeach
                        <th style="width: 50px;">
                            รวมทุกตรา
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_amount = [];
                        foreach ($group['all_headers'] as $item_code => $desc){
                            $total_amount[$desc] = 0;
                        }
                        $total_sum_amount = 0;
                    @endphp
                    @foreach ($group['lines'] as $pick_no => $items)
                        {{-- @php
                            dd($items);
                        @endphp --}}
                        <tr style="page-break-inside:avoid;">
                            <td>
                                {{ $pick_no }}
                            </td>
                            <td>
                                {{ $items['customer_name'] }}
                            </td>
                            <td>
                                {{ $items['country_name'] }}
                            </td>
                            <td>
                                {{ dateFormatThai($items['pick_release_approve_date']) }}
                            </td>
                            @foreach ($group['all_headers'] as $item_code => $desc)
                                @php
                                    $amount = $items['headers'][$item_code]->sum('amount');
                                    $total_amount[$desc] += $amount;
                                @endphp
                                <td class="text-right">
                                    {{ numberFormatDisplay($amount) ?: '-' }}
                                </td>
                            @endforeach
                            @php
                                $sum_amount = $items['data']->sum('amount');
                                $total_sum_amount += $sum_amount;
                            @endphp
                            <td class="text-right">
                                {{ numberFormatDisplay($sum_amount) ?: '-' }}
                            </td>
                        </tr>
                    @endforeach
                    <tr style="page-break-inside:avoid;">
                        <td colspan="4" class="text-right">
                            <b>รวมทั้งสิ้น</b>
                        </td>
                        @foreach ($group['all_headers'] as $item_code => $desc)
                            <td class="text-right">
                                {{ numberFormatDisplay($total_amount[$desc]) ?: '-' }}
                            </td>
                        @endforeach
                        <td class="text-right">
                            {{ numberFormatDisplay($total_sum_amount) ?: '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
    
            <div class="page-break"></div>
        @empty
            ไม่มีข้อมูล
        @endforelse
    </body>
</html>