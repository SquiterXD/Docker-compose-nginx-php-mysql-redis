<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        @include('ct.Reports.ctr0038._style')
        <style>
            .table>thead>tr>th {
                text-align: center;
                vertical-align: middle;
                border: 1px solid #000000;
                word-wrap: break-word;

            }
            .table>tbody>tr>td {
                border: 1px solid #000000;
                vertical-align: middle;
                word-wrap: break-word;

            }
            .table>tbody>tr>th {
                vertical-align: middle;
                border: 1px solid #000000;
                word-wrap: break-word;
            }
            .text-center{
                text-align: center;
            }
            .wrap-text {
                word-wrap: break-word;
            }
            .table-noborder td,
            .table-noborder th,
            .table-noborder thead th,
            .table-noborder tbody + tbody {
                border: 0;
                text-align: center;
                vertical-align: middle;
                word-wrap: break-word;
            }
            .table-border td,
            .table-border th,
            .table-border thead th,
            .table-border tbody + tbody {
                border: 1 solid black;
                vertical-align: middle;
                word-wrap: break-word;
            }
            
        </style>
    </head>
    <body>
        <table class="table-noborder">
            <thead>
                <tr>
                    <th>โปรแกรม : <strong> {{ $programCode }} </strong> </th>
                    <th colspan="14" align="center" style="vertical-align: middle;"> <strong> การยาสูบแห่งประเทศไทย </strong> </th>
                    <th>วันที่ : <strong> {{ date('d/m/Y', strtotime('+543 years')) }} </strong> </th>
                </tr>
                <tr>
                    <th>สั่งพิมพ์ : <strong> {{ Auth::user()->name }} </strong> </th>
                    <th colspan="14" align="center" style="vertical-align: middle;"> <strong> รายงานปันส่วนผลต่าง - ใบยาอบแล้ว/ทำความสะอาดแล้ว รวมทุกศูนย์ต้นทุน ประจำปี {{ $year+543 }} </strong> </th>
                    <th>เวลา : <strong> {{ date('H:i') }} </strong></th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="14" align="center" style="vertical-align: middle;"> 
                        <strong> วันที่ {{ Carbon\Carbon::create($query_date[0]->start_date)->addYear('543')->format('d/m/Y') }} ถึงวันที่ {{ Carbon\Carbon::create($query_date[0]->end_date)->addYear('543')->format('d/m/Y') }} </strong>
                    </th>
                    <th></th>
                </tr>
            </thead>
        </table>
        <table class="table table-responsive-sm table-bordered">
            <thead>
                <tr>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" rowspan="3">Item</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" rowspan="3">ปริมาณผลผลิต</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="3" rowspan="2">ต้นทุนมาตรฐาน</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" rowspan="2">ต้นทุนผลิตรวม</th>
                    <th style="border: 1px solid black; font-weight: bold;" rowspan="2"></th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" rowspan="2">ราคาต่อหน่วย</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="3">ปันส่วนผลต่าง</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" rowspan="2">ผลต่างรวม</th>
                    <th style="border: 1px solid black; font-weight: bold;" rowspan="2"></th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" rowspan="2">ผลต่าง</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" rowspan="2">ต้นทุนผลิตจริง</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" rowspan="2">ราคาต่อหน่วย</th>
                </tr>
                <tr>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="3">ต้นทุนจริง สูงกว่า/ (ต่ำกว่า) มาตรฐาน</th>
                </tr>
                <tr>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">วัตถุดิบ</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">ค่าแรงงาน</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">ค่าใช้จ่ายผลิต</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">มาตรฐาน</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">DL OH มาตรฐาน</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">มาตรฐาน</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">วัตถุดิบ</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">ค่าแรงงานทางตรง</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">ค่าใช้จ่ายผลิต</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">(DM+DL+OH)</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">DL OH ผลต่าง</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">ต่อหน่วย</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">(หลังปรับผลต่าง)</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">(หลังปรับผลต่าง)</th>
                </tr>
                <tr>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">ก.ก</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บาท</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grand_total_wip_complete_qty   = 0;
                    $grand_total_std21_amount       = 0;
                    $grand_total_std22_amount       = 0;
                    $grand_total_std2324_amount     = 0;
                    $grand_total_std29_amount       = 0;
                    $grand_total_std_dl_oh_amount   = 0;
                    $grand_total_std_price          = 0;
                    $grand_total_dm_variance_amount = 0;
                    $grand_total_dl_variance_amount = 0;
                    $grand_total_oh_variance_amount = 0;
                    $grand_total_total_variance     = 0;
                    $grand_total_dl_oh_amount       = 0;
                    $grand_total_diff_amount        = 0;
                    $grand_total_actual_cost_amount = 0;
                    $grand_total_unit_price         = 0;

                    $tt_total_wip_complete_qty   = 0;
                    $tt_total_std21_amount       = 0;
                    $tt_total_std22_amount       = 0;
                    $tt_total_std2324_amount     = 0;
                    $tt_total_std29_amount       = 0;
                    $tt_total_std_dl_oh_amount   = 0;
                    $tt_total_std_price          = 0;
                    $tt_total_dm_variance_amount = 0;
                    $tt_total_dl_variance_amount = 0;
                    $tt_total_oh_variance_amount = 0;
                    $tt_total_total_variance     = 0;
                    $tt_total_dl_oh_amount       = 0;
                    $tt_total_diff_amount        = 0;
                    $tt_total_actual_cost_amount = 0;
                    $tt_total_unit_price         = 0;
                @endphp
                @foreach ($data as $type => $dataProducts)
                    @php
                        $sub_total_wip_complete_qty   = $dataProducts->sum('wip_complete_qty');
                        $sub_total_std21_amount       = $dataProducts->sum('std21_amount');
                        $sub_total_std22_amount       = $dataProducts->sum('std22_amount');
                        $sub_total_std2324_amount     = $dataProducts->sum('std2324_amount');
                        $sub_total_std29_amount       = $dataProducts->sum('std29_amount');
                        $sub_total_std_dl_oh_amount   = $dataProducts->sum('std_dl_oh_amount');
                        $sub_total_std_price          = $dataProducts->sum('std_price');
                        $sub_total_dm_variance_amount = $dataProducts->sum('dm_variance_amount');
                        $sub_total_dl_variance_amount = $dataProducts->sum('dl_variance_amount');
                        $sub_total_oh_variance_amount = $dataProducts->sum('oh_variance_amount');
                        $sub_total_total_variance     = $dataProducts->sum('total_variance');
                        $sub_total_dl_oh_amount       = $dataProducts->sum('dl_oh_amount');
                        $sub_total_diff_amount        = $dataProducts->sum('diff_amount');
                        $sub_total_actual_cost_amount = $dataProducts->sum('actual_cost_amount');
                        $sub_total_unit_price         = $dataProducts->sum('unit_price');

                        $grand_total_wip_complete_qty   += $sub_total_wip_complete_qty;
                        $grand_total_std21_amount       += $sub_total_std21_amount;
                        $grand_total_std22_amount       += $sub_total_std22_amount;
                        $grand_total_std2324_amount     += $sub_total_std2324_amount;
                        $grand_total_std29_amount       += $sub_total_std29_amount;
                        $grand_total_std_dl_oh_amount   += $sub_total_std_dl_oh_amount;
                        $grand_total_std_price          += $sub_total_std_price;
                        $grand_total_dm_variance_amount += $sub_total_dm_variance_amount;
                        $grand_total_dl_variance_amount += $sub_total_dl_variance_amount;
                        $grand_total_oh_variance_amount += $sub_total_oh_variance_amount;
                        $grand_total_total_variance     += $sub_total_total_variance;
                        $grand_total_dl_oh_amount       += $sub_total_dl_oh_amount;
                        $grand_total_diff_amount        += $sub_total_diff_amount;
                        $grand_total_actual_cost_amount += $sub_total_actual_cost_amount;
                        $grand_total_unit_price         += $sub_total_unit_price;

                        if ($type == 'เบอร์เลย์' || $type == 'เวอร์ยิเนีย') {
                            $tt_total_wip_complete_qty   += $sub_total_wip_complete_qty;
                            $tt_total_std21_amount       += $sub_total_std21_amount;
                            $tt_total_std22_amount       += $sub_total_std22_amount;
                            $tt_total_std2324_amount     += $sub_total_std2324_amount;
                            $tt_total_std29_amount       += $sub_total_std29_amount;
                            $tt_total_std_dl_oh_amount   += $sub_total_std_dl_oh_amount;
                            $tt_total_std_price          += $sub_total_std_price;
                            $tt_total_dm_variance_amount += $sub_total_dm_variance_amount;
                            $tt_total_dl_variance_amount += $sub_total_dl_variance_amount;
                            $tt_total_oh_variance_amount += $sub_total_oh_variance_amount;
                            $tt_total_total_variance     += $sub_total_total_variance;
                            $tt_total_dl_oh_amount       += $sub_total_dl_oh_amount;
                            $tt_total_diff_amount        += $sub_total_diff_amount;
                            $tt_total_actual_cost_amount += $sub_total_actual_cost_amount;
                            $tt_total_unit_price         += $sub_total_unit_price;
                        }

                    @endphp
                    <tr>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"> {{ $type }} </th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                    </tr>
                    @foreach ($dataProducts->groupBy('product_group') as $text => $lists)
                        @php
                            $sum_wip_complete_qty   = $lists->sum('wip_complete_qty');
                            $sum_std21_amount       = $lists->sum('std21_amount');
                            $sum_std22_amount       = $lists->sum('std22_amount');
                            $sum_std2324_amount     = $lists->sum('std2324_amount');
                            $sum_std29_amount       = $lists->sum('std29_amount');
                            $sum_std_dl_oh_amount   = $lists->sum('std_dl_oh_amount');
                            $sum_std_price          = $lists->sum('std_price');
                            $sum_dm_variance_amount = $lists->sum('dm_variance_amount');
                            $sum_dl_variance_amount = $lists->sum('dl_variance_amount');
                            $sum_oh_variance_amount = $lists->sum('oh_variance_amount');
                            $sum_total_variance     = $lists->sum('total_variance');
                            $sum_dl_oh_amount       = $lists->sum('dl_oh_amount');
                            $sum_diff_amount        = $lists->sum('diff_amount');
                            $sum_actual_cost_amount = $lists->sum('actual_cost_amount');
                            $sum_unit_price         = $lists->sum('unit_price');
                        @endphp
                        @foreach ($lists as $list)
                            <tr>                                
                                <td style="border: 1px solid black;">{{ $list->product_item_no }}</td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->wip_complete_qty >= 0)
                                        {{number_format($list->wip_complete_qty, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->wip_complete_qty), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->std21_amount >= 0)
                                        {{number_format($list->std21_amount, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->std21_amount), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->std22_amount >= 0)
                                        {{number_format($list->std22_amount, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->std22_amount), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->std2324_amount >= 0)
                                        {{number_format($list->std2324_amount, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->std2324_amount), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->std29_amount >= 0)
                                        {{number_format($list->std29_amount, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->std29_amount), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->std_dl_oh_amount >= 0)
                                        {{number_format($list->std_dl_oh_amount, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->std_dl_oh_amount), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->std_price >= 0)
                                        {{number_format($list->std_price, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->std_price), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->dm_variance_amount >= 0)
                                        {{number_format($list->dm_variance_amount, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->dm_variance_amount), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->dl_variance_amount >= 0)
                                        {{number_format($list->dl_variance_amount, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->dl_variance_amount), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->oh_variance_amount >= 0)
                                        {{number_format($list->oh_variance_amount, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->oh_variance_amount), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->total_variance >= 0)
                                        {{number_format($list->total_variance, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->total_variance), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->dl_oh_amount >= 0)
                                        {{number_format($list->dl_oh_amount, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->dl_oh_amount), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->diff_amount >= 0)
                                        {{number_format($list->diff_amount, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->diff_amount), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->actual_cost_amount >= 0)
                                        {{number_format($list->actual_cost_amount, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->actual_cost_amount), 2) }} )
                                    @endif
                                </td>
                                <td style="border: 1px solid black; text-align: right;">
                                    @if ($list->unit_price >= 0)
                                        {{number_format($list->unit_price, 2)}}
                                    @else
                                        ( {{ number_format(abs($list->unit_price), 2) }} )
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th style="border: 1px solid black; text-align: center; font-weight: bold;"> รวม - {{ $text }} </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_wip_complete_qty >= 0)
                                    {{number_format($sum_wip_complete_qty, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_wip_complete_qty), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_std21_amount >= 0)
                                    {{number_format($sum_std21_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_std21_amount), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_std22_amount >= 0)
                                    {{number_format($sum_std22_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_std22_amount), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_std2324_amount >= 0)
                                    {{number_format($sum_std2324_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_std2324_amount), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_std29_amount >= 0)
                                    {{number_format($sum_std29_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_std29_amount), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_std_dl_oh_amount >= 0)
                                    {{number_format($sum_std_dl_oh_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_std_dl_oh_amount), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @php
                                    $res = $sum_std29_amount / $sum_wip_complete_qty ;
                                @endphp
                                @if ($res >= 0)
                                    {{number_format($res, 2)}}
                                @else
                                    ( {{ number_format(abs($res), 2) }} )
                                @endif
                                {{-- @if ($sum_std_price >= 0)
                                    {{number_format($sum_std_price, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_std_price), 2) }} )
                                @endif --}}
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_dm_variance_amount >= 0)
                                    {{number_format($sum_dm_variance_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_dm_variance_amount), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_dl_variance_amount >= 0)
                                    {{number_format($sum_dl_variance_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_dl_variance_amount), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_oh_variance_amount >= 0)
                                    {{number_format($sum_oh_variance_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_oh_variance_amount), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_total_variance >= 0)
                                    {{number_format($sum_total_variance, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_total_variance), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_dl_oh_amount >= 0)
                                    {{number_format($sum_dl_oh_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_dl_oh_amount), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_diff_amount >= 0)
                                    {{number_format($sum_diff_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_diff_amount), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @if ($sum_actual_cost_amount >= 0)
                                    {{number_format($sum_actual_cost_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_actual_cost_amount), 2) }} )
                                @endif
                            </th>
                            <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                                @php
                                    $res2 = $sum_actual_cost_amount / $sum_wip_complete_qty ;
                                @endphp
                                @if ($res2 >= 0)
                                    {{number_format($res2, 2)}}
                                @else
                                    ( {{ number_format(abs($res2), 2) }} )
                                @endif
                                {{-- @if ($sum_unit_price >= 0)
                                    {{number_format($sum_unit_price, 2)}}
                                @else
                                    ( {{ number_format(abs($sum_unit_price), 2) }} )
                                @endif --}}
                            </th>
                        </tr>
                    @endforeach
                    <tr>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #eaeaea;"> รวม {{ $type }} </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_wip_complete_qty >= 0)
                                {{number_format($sub_total_wip_complete_qty, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_wip_complete_qty), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_std21_amount >= 0)
                                {{number_format($sub_total_std21_amount, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_std21_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_std22_amount >= 0)
                                {{number_format($sub_total_std22_amount, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_std22_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_std2324_amount >= 0)
                                {{number_format($sub_total_std2324_amount, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_std2324_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_std29_amount >= 0)
                                {{number_format($sub_total_std29_amount, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_std29_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_std_dl_oh_amount >= 0)
                                {{number_format($sub_total_std_dl_oh_amount, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_std_dl_oh_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @php
                                $ressub = $sub_total_std29_amount / $sub_total_wip_complete_qty ;
                            @endphp
                            @if ($ressub >= 0)
                                {{number_format($ressub, 2)}}
                            @else
                                ( {{ number_format(abs($ressub), 2) }} )
                            @endif
                            {{-- @if ($sub_total_std_price >= 0)
                                {{number_format($sub_total_std_price, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_std_price), 2) }} )
                            @endif --}}
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_dm_variance_amount >= 0)
                                {{number_format($sub_total_dm_variance_amount, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_dm_variance_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_dl_variance_amount >= 0)
                                {{number_format($sub_total_dl_variance_amount, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_dl_variance_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_oh_variance_amount >= 0)
                                {{number_format($sub_total_oh_variance_amount, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_oh_variance_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_total_variance >= 0)
                                {{number_format($sub_total_total_variance, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_total_variance), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_dl_oh_amount >= 0)
                                {{number_format($sub_total_dl_oh_amount, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_dl_oh_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_diff_amount >= 0)
                                {{number_format($sub_total_diff_amount, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_diff_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_actual_cost_amount >= 0)
                                {{number_format($sub_total_actual_cost_amount, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_actual_cost_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @php
                                $ressub2 = $sub_total_actual_cost_amount / $sub_total_wip_complete_qty ;
                            @endphp
                            @if ($ressub2 >= 0)
                                {{number_format($ressub2, 2)}}
                            @else
                                ( {{ number_format(abs($ressub2), 2) }} )
                            @endif
                            {{-- @if ($sub_total_unit_price >= 0)
                                {{number_format($sub_total_unit_price, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_unit_price), 2) }} )
                            @endif --}}
                        </th>
                    </tr>
                    @if ($type == 'เบอร์เลย์')
                        <tr>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #eaeaea;">
                            รวมเวอร์ยิเนีย-เบอร์เลย์
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_wip_complete_qty >= 0)
                                {{number_format($tt_total_wip_complete_qty, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_wip_complete_qty), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_std21_amount >= 0)
                                {{number_format($tt_total_std21_amount, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_std21_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_std22_amount >= 0)
                                {{number_format($tt_total_std22_amount, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_std22_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_std2324_amount >= 0)
                                {{number_format($tt_total_std2324_amount, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_std2324_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_std29_amount >= 0)
                                {{number_format($tt_total_std29_amount, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_std29_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_std_dl_oh_amount >= 0)
                                {{number_format($tt_total_std_dl_oh_amount, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_std_dl_oh_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @php
                                $restt = $tt_total_std29_amount / $tt_total_wip_complete_qty ;
                            @endphp
                            @if ($restt >= 0)
                                {{number_format($restt, 2)}}
                            @else
                                ( {{ number_format(abs($restt), 2) }} )
                            @endif
                            {{-- @if ($tt_total_std_price >= 0)
                                {{number_format($tt_total_std_price, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_std_price), 2) }} )
                            @endif --}}
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_dm_variance_amount >= 0)
                                {{number_format($tt_total_dm_variance_amount, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_dm_variance_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_dl_variance_amount >= 0)
                                {{number_format($tt_total_dl_variance_amount, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_dl_variance_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_oh_variance_amount >= 0)
                                {{number_format($tt_total_oh_variance_amount, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_oh_variance_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_total_variance >= 0)
                                {{number_format($tt_total_total_variance, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_total_variance), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_dl_oh_amount >= 0)
                                {{number_format($tt_total_dl_oh_amount, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_dl_oh_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_diff_amount >= 0)
                                {{number_format($tt_total_diff_amount, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_diff_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($tt_total_actual_cost_amount >= 0)
                                {{number_format($tt_total_actual_cost_amount, 2)}}
                            @else
                                ( {{ number_format(abs($tt_total_actual_cost_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @php
                                $restt = $tt_total_actual_cost_amount / $tt_total_wip_complete_qty ;
                            @endphp
                            @if ($restt >= 0)
                                {{number_format($restt, 2)}}
                            @else
                                ( {{ number_format(abs($restt), 2) }} )
                            @endif
                        </th>
                    </tr>
                    @endif
                @endforeach
                <tr>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #eaeaea;"> รวมทั้งสิ้น </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_wip_complete_qty >= 0)
                            {{number_format($grand_total_wip_complete_qty, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_wip_complete_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_std21_amount >= 0)
                            {{number_format($grand_total_std21_amount, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_std21_amount), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_std22_amount >= 0)
                            {{number_format($grand_total_std22_amount, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_std22_amount), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_std2324_amount >= 0)
                            {{number_format($grand_total_std2324_amount, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_std2324_amount), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_std29_amount >= 0)
                            {{number_format($grand_total_std29_amount, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_std29_amount), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_std_dl_oh_amount >= 0)
                            {{number_format($grand_total_std_dl_oh_amount, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_std_dl_oh_amount), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @php
                            $resgrand = $grand_total_std29_amount / $grand_total_wip_complete_qty ;
                        @endphp
                        @if ($resgrand >= 0)
                            {{number_format($resgrand, 2)}}
                        @else
                            ( {{ number_format(abs($resgrand), 2) }} )
                        @endif
                       {{--  @if ($grand_total_std_price >= 0)
                            {{number_format($grand_total_std_price, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_std_price), 2) }} )
                        @endif --}}
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_dm_variance_amount >= 0)
                            {{number_format($grand_total_dm_variance_amount, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_dm_variance_amount), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_dl_variance_amount >= 0)
                            {{number_format($grand_total_dl_variance_amount, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_dl_variance_amount), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_oh_variance_amount >= 0)
                            {{number_format($grand_total_oh_variance_amount, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_oh_variance_amount), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_total_variance >= 0)
                            {{number_format($grand_total_total_variance, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_total_variance), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_dl_oh_amount >= 0)
                            {{number_format($grand_total_dl_oh_amount, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_dl_oh_amount), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_diff_amount >= 0)
                            {{number_format($grand_total_diff_amount, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_diff_amount), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_actual_cost_amount >= 0)
                            {{number_format($grand_total_actual_cost_amount, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_actual_cost_amount), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @php
                            $resgrand2 = $grand_total_actual_cost_amount / $grand_total_wip_complete_qty ;
                        @endphp
                        @if ($resgrand2 >= 0)
                            {{number_format($resgrand2, 2)}}
                        @else
                            ( {{ number_format(abs($resgrand2), 2) }} )
                        @endif
                        {{-- @if ($grand_total_unit_price >= 0)
                            {{number_format($grand_total_unit_price, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_unit_price), 2) }} )
                        @endif --}}
                    </th>
                </tr>
                {{-- ------------------------------------------------------------- --}}
                <tr>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">ผลต่างการผลิต / ต้นทุนผลิตจริง</th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">                        
                        @if ($grand_total_dm_variance_amount >= 0)
                            {{number_format(($grand_total_dm_variance_amount / $grand_total_actual_cost_amount) * 100,2)}} % 
                        @else
                            ( {{number_format(($grand_total_dm_variance_amount / $grand_total_actual_cost_amount) * 100,2)}} % )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        @if ($grand_total_dl_variance_amount >= 0)
                            {{number_format(($grand_total_dl_variance_amount / $grand_total_actual_cost_amount) * 100,2)}} % 
                        @else
                            ( {{number_format(($grand_total_dl_variance_amount / $grand_total_actual_cost_amount) * 100,2)}} % )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        @if ($grand_total_oh_variance_amount >= 0)
                            {{number_format(($grand_total_oh_variance_amount / $grand_total_actual_cost_amount) * 100,2)}} % 
                        @else
                            ( {{number_format(($grand_total_oh_variance_amount / $grand_total_actual_cost_amount) * 100,2)}} % )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        @if ($grand_total_total_variance >= 0)
                            {{number_format(($grand_total_total_variance / $grand_total_actual_cost_amount) * 100,2)}} % 
                        @else
                            ( {{number_format(($grand_total_total_variance / $grand_total_actual_cost_amount) * 100,2)}} % )
                        @endif
                    </th>
                    
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        @if ($grand_total_dl_oh_amount >= 0)
                            {{number_format(($grand_total_dl_oh_amount / $grand_total_actual_cost_amount) * 100,2)}} % 
                        @else
                            ( {{number_format(($grand_total_dl_oh_amount / $grand_total_actual_cost_amount) * 100,2)}} % )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        @if ($grand_total_diff_amount >= 0)
                            {{number_format(($grand_total_diff_amount / $grand_total_actual_cost_amount) * 100,2)}} % 
                        @else
                            ( {{number_format(($grand_total_diff_amount / $grand_total_actual_cost_amount) * 100,2)}} % )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">100%</th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                </tr>

                @php
                    $ryo_sum_wip_complete_qty   = 0;
                    $ryo_sum_std21_amount       = 0;
                    $ryo_sum_std22_amount       = 0;
                    $ryo_sum_std2324_amount     = 0;
                    $ryo_sum_std29_amount       = 0;
                    $ryo_sum_std_dl_oh_amount   = 0;
                    $ryo_sum_std_price          = 0;
                    $ryo_sum_dm_variance_amount = 0;
                    $ryo_sum_dl_variance_amount = 0;
                    $ryo_sum_oh_variance_amount = 0;
                    $ryo_sum_total_variance     = 0;
                    $ryo_sum_dl_oh_amount       = 0;
                    $ryo_sum_diff_amount        = 0;
                    $ryo_sum_actual_cost_amount = 0;
                    $ryo_sum_unit_price         = 0;
                @endphp
                @foreach ($data_ryo->groupBy('product_group') as $text => $lists)
                    <tr>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"> {{ $text }} </th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold;"></th>
                    </tr>
                    @foreach ($lists as $list)
                        @php
                            $ryo_sum_wip_complete_qty   += $list->wip_complete_qty;
                            $ryo_sum_std21_amount       += $list->std21_amount;
                            $ryo_sum_std22_amount       += $list->std22_amount;
                            $ryo_sum_std2324_amount     += $list->std2324_amount;
                            $ryo_sum_std29_amount       += $list->std29_amount;
                            $ryo_sum_std_dl_oh_amount   += $list->std_dl_oh_amount;
                            $ryo_sum_std_price          += $list->std_price;
                            $ryo_sum_dm_variance_amount += $list->dm_variance_amount;
                            $ryo_sum_dl_variance_amount += $list->dl_variance_amount;
                            $ryo_sum_oh_variance_amount += $list->oh_variance_amount;
                            $ryo_sum_total_variance     += $list->total_variance;
                            $ryo_sum_dl_oh_amount       += $list->dl_oh_amount;
                            $ryo_sum_diff_amount        += $list->diff_amount;
                            $ryo_sum_actual_cost_amount += $list->actual_cost_amount;
                            $ryo_sum_unit_price         += $list->unit_price;
                        @endphp
                        <tr>                                
                            <td style="border: 1px solid black;">{{ $list->product_item_no }}</td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->wip_complete_qty >= 0)
                                    {{number_format($list->wip_complete_qty, 2)}}
                                @else
                                    ( {{ number_format(abs($list->wip_complete_qty), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->std21_amount >= 0)
                                    {{number_format($list->std21_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($list->std21_amount), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->std22_amount >= 0)
                                    {{number_format($list->std22_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($list->std22_amount), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->std2324_amount >= 0)
                                    {{number_format($list->std2324_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($list->std2324_amount), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->std29_amount >= 0)
                                    {{number_format($list->std29_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($list->std29_amount), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->std_dl_oh_amount >= 0)
                                    {{number_format($list->std_dl_oh_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($list->std_dl_oh_amount), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->std_price >= 0)
                                    {{number_format($list->std_price, 2)}}
                                @else
                                    ( {{ number_format(abs($list->std_price), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->dm_variance_amount >= 0)
                                    {{number_format($list->dm_variance_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($list->dm_variance_amount), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->dl_variance_amount >= 0)
                                    {{number_format($list->dl_variance_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($list->dl_variance_amount), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->oh_variance_amount >= 0)
                                    {{number_format($list->oh_variance_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($list->oh_variance_amount), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->total_variance >= 0)
                                    {{number_format($list->total_variance, 2)}}
                                @else
                                    ( {{ number_format(abs($list->total_variance), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->dl_oh_amount >= 0)
                                    {{number_format($list->dl_oh_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($list->dl_oh_amount), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->diff_amount >= 0)
                                    {{number_format($list->diff_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($list->diff_amount), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->actual_cost_amount >= 0)
                                    {{number_format($list->actual_cost_amount, 2)}}
                                @else
                                    ( {{ number_format(abs($list->actual_cost_amount), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->unit_price >= 0)
                                    {{number_format($list->unit_price, 2)}}
                                @else
                                    ( {{ number_format(abs($list->unit_price), 2) }} )
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #eaeaea;"> รวม{{ $text }} </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_wip_complete_qty >= 0)
                                {{number_format($ryo_sum_wip_complete_qty, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_wip_complete_qty), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_std21_amount >= 0)
                                {{number_format($ryo_sum_std21_amount, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_std21_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_std22_amount >= 0)
                                {{number_format($ryo_sum_std22_amount, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_std22_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_std2324_amount >= 0)
                                {{number_format($ryo_sum_std2324_amount, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_std2324_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_std29_amount >= 0)
                                {{number_format($ryo_sum_std29_amount, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_std29_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_std_dl_oh_amount >= 0)
                                {{number_format($ryo_sum_std_dl_oh_amount, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_std_dl_oh_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @php
                                $resryo = $ryo_sum_std29_amount / $ryo_sum_wip_complete_qty ;
                            @endphp
                            @if ($resryo >= 0)
                                {{number_format($resryo, 2)}}
                            @else
                                ( {{ number_format(abs($resryo), 2) }} )
                            @endif
                            {{-- @if ($ryo_sum_std_price >= 0)
                                {{number_format($ryo_sum_std_price, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_std_price), 2) }} )
                            @endif --}}
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_dm_variance_amount >= 0)
                                {{number_format($ryo_sum_dm_variance_amount, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_dm_variance_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_dl_variance_amount >= 0)
                                {{number_format($ryo_sum_dl_variance_amount, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_dl_variance_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_oh_variance_amount >= 0)
                                {{number_format($ryo_sum_oh_variance_amount, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_oh_variance_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_total_variance >= 0)
                                {{number_format($ryo_sum_total_variance, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_total_variance), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_dl_oh_amount >= 0)
                                {{number_format($ryo_sum_dl_oh_amount, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_dl_oh_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_diff_amount >= 0)
                                {{number_format($ryo_sum_diff_amount, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_diff_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($ryo_sum_actual_cost_amount >= 0)
                                {{number_format($ryo_sum_actual_cost_amount, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_actual_cost_amount), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @php
                                $resryo2 = $ryo_sum_actual_cost_amount / $ryo_sum_wip_complete_qty ;
                            @endphp
                            @if ($resryo2 >= 0)
                                {{number_format($resryo2, 2)}}
                            @else
                                ( {{ number_format(abs($resryo2), 2) }} )
                            @endif
                            {{-- @if ($ryo_sum_unit_price >= 0)
                                {{number_format($ryo_sum_unit_price, 2)}}
                            @else
                                ( {{ number_format(abs($ryo_sum_unit_price), 2) }} )
                            @endif --}}
                        </th>
                    </tr>
                @endforeach


                <tr>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">ผลต่างการผลิต / ต้นทุนผลิตจริง</th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        @if ($ryo_sum_dm_variance_amount >= 0)
                            {{number_format(($ryo_sum_dm_variance_amount / $ryo_sum_actual_cost_amount) * 100, 2)}} %
                        @else
                            ( {{number_format(($ryo_sum_dm_variance_amount / $ryo_sum_actual_cost_amount) * 100, 2)}} % )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        @if ($ryo_sum_dl_variance_amount >= 0)
                            {{number_format(($ryo_sum_dl_variance_amount / $ryo_sum_actual_cost_amount) * 100, 2)}} %
                        @else
                            ( {{number_format(($ryo_sum_dl_variance_amount / $ryo_sum_actual_cost_amount) * 100, 2)}} % )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        @if ($ryo_sum_oh_variance_amount >= 0)
                            {{number_format(($ryo_sum_oh_variance_amount / $ryo_sum_actual_cost_amount) * 100, 2)}} %
                        @else
                            ( {{number_format(($ryo_sum_oh_variance_amount / $ryo_sum_actual_cost_amount) * 100, 2)}} % )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        @if ($ryo_sum_total_variance >= 0)
                            {{number_format(($ryo_sum_total_variance / $ryo_sum_actual_cost_amount) * 100, 2)}} %
                        @else
                            ( {{number_format(($ryo_sum_total_variance / $ryo_sum_actual_cost_amount) * 100, 2)}} % )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        @if ($ryo_sum_dl_oh_amount >= 0)
                            {{number_format(($ryo_sum_dl_oh_amount / $ryo_sum_actual_cost_amount) * 100, 2)}} %
                        @else
                            ( {{number_format(($ryo_sum_dl_oh_amount / $ryo_sum_actual_cost_amount) * 100, 2)}} % )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        @if ($ryo_sum_diff_amount >= 0)
                            {{number_format(($ryo_sum_diff_amount / $ryo_sum_actual_cost_amount) * 100, 2)}} %
                        @else
                            ( {{number_format(($ryo_sum_diff_amount / $ryo_sum_actual_cost_amount) * 100, 2)}} % )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;">
                        100%
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold;"></th>
                </tr>
            </tbody>
        </table>
    </body>
</html>