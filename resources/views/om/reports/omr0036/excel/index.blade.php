<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OMR0036</title>
    @include('om.reports._style')
    <style>
        table {
            width: 100%;
            padding: 0;
            margin: 0;
            border-collapse: collapse
        }

        td,
        th {
            border: 1px solid;
            padding: 0px;
            margin: 0px;
            white-space: nowrap;
            padding: 3px;
        }

        .header {
            text-align: center;
        }

        tbody td {
            border: 1px solid #0000;
            text-align: center;
        }
    </style>
</head>

<body>
    <table style="width:100%; padding:0px; border:1px solid">
        <thead>
            <tr>
                @php
                    $sumary = 0;
                    $sumartCarboardbox = 0;
                    $sumartCarton = 0;
                    $totalColumns = 13 + $headerColumns->where('product_type_code', 10)->count() * 4 + $headerColumns->where('product_type_code', 20)->count() * 4;
                @endphp

                <td style="width:33%" colspan="{{ number_format($totalColumns / 3, 0) }}">
                    โปรแกรม : OMR0036
                </td>
                <td style="width:33%" align="center" colspan="{{ number_format($totalColumns / 3, 0) }}">
                    สรุปรายการของแถมตามโปรโมชัน
                </td>
                <td style="width:33%" colspan="{{ number_format($totalColumns / 3, 0) }}">
                    &nbsp; &nbsp; &nbsp; &nbsp;วันที่ : {{ parseToDateTh(now()) }}
                </td>

            </tr>
            <tr>
                <td style="width:33%" colspan="{{ number_format($totalColumns / 3, 0) }}">
                    สั่งพิมพ์ : {{ optional(auth()->user())->name }}
                </td>
                <td style="width:33%" align="center" colspan="{{ number_format($totalColumns / 3, 0) }}">
                    สรุปรายการของแถมตามโปรโมชัน
                    วันที่ {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_from)->addYears(543)->format('d/m/Y') }} ถึง {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_to)->addYears(543)->format('d/m/Y') }}
                </td>
                <td style="width:33%" colspan="{{ number_format($totalColumns / 3, 0) }}">
                    &nbsp; &nbsp; &nbsp; &nbsp;เวลา : &nbsp; &nbsp; &nbsp; &nbsp;
                    {{ date('H:i', strtotime(now())) }}
                </td>
            </tr>
            <tr>
                <td style="width:33%" colspan="{{ number_format($totalColumns / 3, 0) }}">
                </td>
                <td style="width:33%" align="center" colspan="{{ number_format($totalColumns / 3, 0) }}">
                    วันที่ {{ now()->addYears(543)->format('d/m/Y') }}
                </td>
                <td style="width:33%" colspan="{{ number_format($totalColumns / 3, 0) }}">
                </td>
            </tr>
            <tr class="header">
                <td rowspan="3" style="border:1px solid #000; text-align:center;">วันส่ง</td>
                <td rowspan="3" style="border:1px solid #000; text-align:center;">จังหวัด</td>
                <td rowspan="3" style="border:1px solid #000; text-align:center;">รหัส</td>
                <td rowspan="3" style="border:1px solid #000; text-align:center;">ชื่อร้านค้า</td>
                <td colspan="{{ $headerColumns->where('product_type_code', 10)->count() * 2 }}"
                    style="border:1px solid #000; text-align:center;">ยอดซื้อบุหรี่</td>
                <td colspan="{{ $headerColumns->where('product_type_code', 20)->count() * 2 }}"
                    style="border:1px solid #000; text-align:center;">ยอดซื้อยาเส้น</td>
                <td rowspan="2" colspan="3" style="border:1px solid #000; text-align:center;">รวมซื้อ</td>
                <td colspan="{{ $headerColumns->where('product_type_code', 10)->count() * 2 }}"
                    style="border:1px solid #000; text-align:center;">ของแถมบุหรี่</td>
                <td colspan="{{ $headerColumns->where('product_type_code', 20)->count() * 2 }}"
                    style="border:1px solid #000; text-align:center;">ของแถมยาเส้น</td>
                <td rowspan="2" colspan="3" style="border:1px solid #000; text-align:center;">รวมของแถมบุหรี่</td>
                <td rowspan="2" colspan="3" style="border:1px solid #000; text-align:center;">รวมของแถมยาเส้น</td>

                {{-- <td rowspan="2" colspan="3" style="border:1px solid #000; text-align:center;">รวมของแถม</td> --}}

            </tr>
            <tr class="header">
                @foreach ($headerColumns->where('product_type_code', 10) as $h)
                    <td colspan="2" style="border:1px solid #000; text-align:center;">
                        {{ $h['ecom_item_description'] }}</td>
                @endforeach
                @foreach ($headerColumns->where('product_type_code', 20) as $h)
                    <td colspan="2" style="border:1px solid #000; text-align:center;">
                        {{ $h['ecom_item_description'] }}</td>
                @endforeach
                @foreach ($headerColumns->where('product_type_code', 10) as $h)
                    <td colspan="2" style="border:1px solid #000; text-align:center;">
                        {{ $h['ecom_item_description'] }}</td>
                @endforeach
                @foreach ($headerColumns->where('product_type_code', 20) as $h)
                    <td colspan="2" style="border:1px solid #000; text-align:center;">
                        {{ $h['ecom_item_description'] }}</td>
                @endforeach
            </tr>
            <tr class="header">
                @foreach ($headerColumns->where('product_type_code', 10) as $h)
                    <td style="border:1px solid #000; text-align:center;">หีบ</td>
                    <td style="border:1px solid #000; text-align:center;">ห่อ</td>
                @endforeach
                @foreach ($headerColumns->where('product_type_code', 20) as $h)
                    <td style="border:1px solid #000; text-align:center;">หีบ</td>
                    <td style="border:1px solid #000; text-align:center;">ห่อ</td>
                @endforeach
                <td style="border:1px solid #000; text-align:center;">หีบ</td>
                <td style="border:1px solid #000; text-align:center;">ห่อ</td>
                <td style="border:1px solid #000; text-align:center;">คิดเป็นพันมวน</td>
                @foreach ($headerColumns->where('product_type_code', 10) as $h)
                    <td style="border:1px solid #000; text-align:center;">หีบ</td>
                    <td style="border:1px solid #000; text-align:center;">ห่อ</td>
                @endforeach
                @foreach ($headerColumns->where('product_type_code', 20) as $h)
                    <td style="border:1px solid #000; text-align:center;">หีบ</td>
                    <td style="border:1px solid #000; text-align:center;">ห่อ</td>
                @endforeach
                <td style="border:1px solid #000; text-align:center;">หีบ</td>
                <td style="border:1px solid #000; text-align:center;">ห่อ</td>
                <td style="border:1px solid #000; text-align:center;">คิดเป็นพันมวน</td>
                <td style="border:1px solid #000; text-align:center;">หีบ</td>
                <td style="border:1px solid #000; text-align:center;">ห่อ</td>
                {{-- <td style="border:1px solid #000; text-align:center;">คิดเป็นพันมวน</td> --}}
                {{-- <td style="border:1px solid #000; text-align:center;">หีบ</td>
                <td style="border:1px solid #000; text-align:center;">ห่อ</td>
                <td style="border:1px solid #000; text-align:center;">คิดเป็นพันมวน</td> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($promoHeader->sortBy('order_date')->groupBy(function ($i) {
        return $i->delivery_date . $i->customer_id;
    }) as $item)
                @php
                    $subtotal['cardboardbox'] = 0;
                    $subtotal['carton'] = 0;
                    $subtotalFree['cardboardbox'] = 0;
                    $subtotalFree['carton'] = 0;

                    $sum[0] = 0;
                    $sum[1] = 0;
                    $sum[2] = 0;
                    $sum[3] = 0;
                    $sum[4] = 0;

                @endphp
                <tr>
                    <td style="border:1px solid #000;">{{ $item->first()->customer->delivery_date }}
                    </td>
                    <td style="border:1px solid #000;">{{ $item->first()->customer->province_name }}</td>
                    <td style="border:1px solid #000;">{{ $item->first()->customer->customer_number }}</td>
                    <td style="border:1px solid #000;">{{ $item->first()->customer->customer_name }}</td>

                    @foreach ($headerColumns->where('product_type_code', 10) as $h)
                        @php
                            $subtotal['cardboardbox'] += $item->sum(function ($i) use ($h) {
                                return $i->lines
                                    ->where('promo_flag', null)
                                    ->where('item_code', $h->item_code)
                                    ->sum('order_cardboardbox');
                            });
                            $subtotal['carton'] += $item->sum(function ($i) use ($h) {
                                return $i->lines
                                    ->where('promo_flag', null)
                                    ->where('item_code', $h->item_code)
                                    ->sum('order_carton');
                            });
                        @endphp
                        <td style="border:1px solid #000;">
                            {{ $item->sum(function ($i) use ($h) {
                                return $i->lines->where('promo_flag', null)->where('item_code', $h->item_code)->sum('order_cardboardbox');
                            }) }}
                        </td>
                        <td style="border:1px solid #000;">
                            {{ $item->sum(function ($i) use ($h) {
                                return $i->lines->where('promo_flag', null)->where('item_code', $h->item_code)->sum('order_carton');
                            }) }}
                        </td>
                    @endforeach
                    @foreach ($headerColumns->where('product_type_code', 20) as $h)
                    
                        @php
                        $row_sumary = [];
                        $row_sumary[0] = 0;
                        $row_sumary[1] = 0;
                        $row_sumary[2] = 0;
                        $row_sumary[3] = 0;

                            $subtotal['cardboardbox'] += $item->sum(function ($i) use ($h) {
                                return $i->lines
                                    ->where('promo_flag', null)
                                    ->where('item_code', $h->item_code)
                                    ->where('uom_code', 'CS1')
                                    ->sum('approve_quantity');
                            });
                            $subtotal['carton'] += $item->sum(function ($i) use ($h) {
                                return $i->lines
                                    ->where('promo_flag', null)
                                    ->where('item_code', $h->item_code)
                                    ->where('uom_code', 'CL1')
                                    ->sum('approve_quantity');
                            });
                        @endphp
                        <td style="border:1px solid #000;">
                            {{ $item->sum(function ($i) use ($h) {
                                return $i->lines->where('promo_flag', null)->where('item_code', $h->item_code)->where('uom_code', 'CS1')->sum('approve_quantity');
                            }) }}
                        </td>
                        <td style="border:1px solid #000;">
                            {{ $item->sum(function ($i) use ($h) {
                                return $i->lines->where('promo_flag', null)->where('item_code', $h->item_code)->where('uom_code', 'CL1')->sum('approve_quantity');
                            }) }}
                        </td>
                    @endforeach
                    <td style="border:1px solid #000;">
                        {{ $subtotal['cardboardbox'] }}
                    </td>
                    <td style="border:1px solid #000;">
                        {{ $subtotal['carton'] }}
                    </td>
                    <td style="border:1px solid #000;">
                        {{ $subtotal['cardboardbox'] * 10 + $subtotal['carton'] * 0.2 }}

                    </td>
                    @foreach ($headerColumns->where('product_type_code', 10) as $h)
                        @php
                            $subtotalFree['cardboardbox'] += $item->sum(function ($i) use ($h) {
                                return $i->lines
                                    ->where('promo_flag', 'Y')
                                    ->where('item_code', $h->item_code)
                                    ->sum('order_cardboardbox');
                            });
                            $subtotalFree['carton'] += $item->sum(function ($i) use ($h) {
                                return $i->lines
                                    ->where('promo_flag', 'Y')
                                    ->where('item_code', $h->item_code)
                                    ->sum('order_carton');
                            });
                        @endphp
                        <td style="border:1px solid #000;">
                            @php 
                                $col1 = $item->sum(function ($i) use ($h) {
                                        return $i->lines->where('promo_flag', 'Y')->where('item_code', $h->item_code)->sum('order_cardboardbox');
                                    });
                                $row_sumary[0] += $col1;
                            @endphp
                            {{ $col1 }}
                        </td>
                        <td style="border:1px solid #000;">
                            @php 
                                $col2 =  $item->sum(function ($i) use ($h) {
                                            return $i->lines->where('promo_flag', 'Y')->where('item_code', $h->item_code)->sum('order_carton');
                                        });
                                $row_sumary[1] += $col2;
                            @endphp
                            {{  $col2 }}
                        </td>
                    @endforeach
                    @foreach ($headerColumns->where('product_type_code', 20) as $h)
                        @php
                            $subtotalFree['cardboardbox'] += $item->sum(function ($i) use ($h) {
                                return $i->lines
                                    ->where('promo_flag', 'Y')
                                    ->where('item_code', $h->item_code)
                                    ->where('uom_code', 'CS1')
                                    ->sum('approve_quantity');
                            });
                            $subtotalFree['carton'] += $item->sum(function ($i) use ($h) {
                                return $i->lines
                                    ->where('promo_flag', 'Y')
                                    ->where('item_code', $h->item_code)
                                    ->where('uom_code', 'CL1')
                                    ->sum('approve_quantity');
                            });
                        @endphp
                        <td style="border:1px solid #000;">
                            @php
                                $col3 = $item->sum(function ($i) use ($h) {
                                return $i->lines->where('promo_flag', 'Y')->where('item_code', $h->item_code)->where('uom_code', 'CS1')->sum('approve_quantity');
                            });
                                $row_sumary[2] += $col3;
                            @endphp
                            {{ $col3 }}
                        </td>
                        <td style="border:1px solid #000;">
                            @php
                                    $col4 = $item->sum(function ($i) use ($h) {
                                return $i->lines->where('promo_flag', 'Y')->where('item_code', $h->item_code)->where('uom_code', 'CL1')->sum('approve_quantity');
                            });
                                $row_sumary[3] += $col4;
                            @endphp
                            {{ $col4 }}
                        </td>
                    @endforeach
                    <td style="border:1px solid #000;">
                        @php 
                            $sum[0] += $row_sumary[0]
                        @endphp
                        {{$row_sumary[0]}}
                    </td>
                    <td style="border:1px solid #000;">
                        @php 
                            $sum[1] += $row_sumary[1]

                        @endphp
                        {{$row_sumary[1]}}
                    </td>
                    <td style="border:1px solid #000;">
                        @php 
                            $sum[2] +=  $row_sumary[0] * 10 + $row_sumary[1]  * 0.2
                        @endphp
                        {{ $row_sumary[0] * 10 + $row_sumary[1]  * 0.2 }}
                    </td>
                    <td style="border:1px solid #000;">
                        @php 
                            $sum[3] += $row_sumary[2]
                        @endphp
                        {{$row_sumary[2]}}
                    </td>
                    <td style="border:1px solid #000;">
                        @php 
                            $sum[4] += $row_sumary[3]
                        @endphp
                        {{$row_sumary[3]}}
                    </td>
                    {{-- <td style="border:1px solid #000;">
                        {{ $row_sumary[2] * 10 + $row_sumary[3]  * 0.2 }}
                    </td> --}}
                    {{-- <td style="border:1px solid #000;">
                        {{ $subtotalFree['cardboardbox'] }}
                    </td>
                    <td style="border:1px solid #000;">
                        {{ $subtotalFree['carton'] }}
                    </td>
                    <td style="border:1px solid #000;">
                        @php
                            $totalCardBoardbox = $subtotalFree['cardboardbox'];
                            $totalCarton = $subtotalFree['carton'];
                            $sumary += $totalCardBoardbox * 10 + $totalCarton * 0.2;
                            $sumartCarboardbox += $totalCardBoardbox;
                            $sumartCarton += $totalCarton;
                        @endphp
                        {{ $totalCardBoardbox * 10 + $totalCarton * 0.2 }}
                    </td> --}}
                </tr>
            @endforeach
            <tr>
                <td style="border:1px solid #000;"
                    colspan="{{ 7 + $headerColumns->where('product_type_code', 10)->count() * 4 + $headerColumns->where('product_type_code', 20)->count() * 4 }}">
                    รวม</td>
                <td style="border:1px solid #000;">{{ $sum[0] }}</td>
                <td style="border:1px solid #000;">{{ $sum[1] }}</td>
                <td style="border:1px solid #000;">{{ $sum[2] }}</td>

                <td style="border:1px solid #000;">{{ $sum[3] }}</td>
                <td style="border:1px solid #000;">{{ $sum[4] }}</td>
                {{-- <td style="border:1px solid #000;">{{ $sumary }}</td> --}}
            </tr>
        </tbody>
    </table>
</body>

</html>
