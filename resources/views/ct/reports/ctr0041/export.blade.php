<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        @include('ct.Reports.ctr0041._style')
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
                    <th colspan="11" align="center" style="vertical-align: middle;"> <strong> การยาสูบแห่งประเทศไทย </strong> </th>
                    <th>วันที่ : <strong> {{ date('d/m/Y', strtotime('+543 years')) }} </strong> </th>
                </tr>
                <tr>
                    <th>สั่งพิมพ์ : <strong> {{ Auth::user()->name }} </strong> </th>
                    <th colspan="11" align="center" style="vertical-align: middle;"> <strong> รายงานปรับปรุงราคาคงคลัง ประจำปี {{ $year+543 }} </strong> </th>
                    <th>เวลา : <strong> {{ date('H:i') }} </strong></th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="11" align="center" style="vertical-align: middle;"> 
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
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="6">น้ำหนักคงคลัง</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="6">ปรับปรุงราคาคงคลัง</th>
                </tr>
                <tr>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">Org. -A04</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">Org. -BAN</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">Org. -DEN</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">Org. -MAE</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">Org. -PHR</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" rowspan="2">รวม</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">Org. -A04</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">Org. -BAN</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">Org. -DEN</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">Org. -MAE</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">Org. -PHR</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;" rowspan="2">รวม</th>
                </tr>
                <tr>	
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">สินค้ากึ่งสำเร็จรูป-ใบยา</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บ้านไผ่</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">เด่นชัย</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">แม่โจ้</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">แพร่</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">สินค้ากึ่งสำเร็จรูป-ใบยา</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">บ้านไผ่</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">เด่นชัย</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">แม่โจ้</th>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;">แพร่</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grand_total_a04_qty     = 0;
                    $grand_total_ban_qty     = 0;
                    $grand_total_den_qty     = 0;
                    $grand_total_mae_qty     = 0;
                    $grand_total_phr_qty     = 0;
                    $grand_total_total_qty   = 0;
                    $grand_total_a04_new_amt = 0;
                    $grand_total_ban_new_amt = 0;
                    $grand_total_den_new_amt = 0;
                    $grand_total_mae_new_amt = 0;
                    $grand_total_phr_new_amt = 0;
                    $grand_total_total_amt   = 0;
                @endphp
                @foreach ($data as $type => $lists)
                    @php
                        $sub_total_a04_qty     = $lists->sum('a04_qty');
                        $sub_total_ban_qty     = $lists->sum('ban_qty');
                        $sub_total_den_qty     = $lists->sum('den_qty');
                        $sub_total_mae_qty     = $lists->sum('mae_qty');
                        $sub_total_phr_qty     = $lists->sum('phr_qty');
                        $sub_total_total_qty   = $lists->sum('total_qty');
                        $sub_total_a04_new_amt = $lists->sum('a04_new_amt');
                        $sub_total_ban_new_amt = $lists->sum('ban_new_amt');
                        $sub_total_den_new_amt = $lists->sum('den_new_amt');
                        $sub_total_mae_new_amt = $lists->sum('mae_new_amt');
                        $sub_total_phr_new_amt = $lists->sum('phr_new_amt');
                        $sub_total_total_amt   = $lists->sum('total_amt');

                        $grand_total_a04_qty     += $sub_total_a04_qty;
                        $grand_total_ban_qty     += $sub_total_ban_qty;
                        $grand_total_den_qty     += $sub_total_den_qty;
                        $grand_total_mae_qty     += $sub_total_mae_qty;
                        $grand_total_phr_qty     += $sub_total_phr_qty;
                        $grand_total_total_qty   += $sub_total_total_qty;
                        $grand_total_a04_new_amt += $sub_total_a04_new_amt;
                        $grand_total_ban_new_amt += $sub_total_ban_new_amt;
                        $grand_total_den_new_amt += $sub_total_den_new_amt;
                        $grand_total_mae_new_amt += $sub_total_mae_new_amt;
                        $grand_total_phr_new_amt += $sub_total_phr_new_amt;
                        $grand_total_total_amt   += $sub_total_total_amt;
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
                    </tr>
                    @foreach ($lists as $list)
                        <tr>                                
                            <td style="border: 1px solid black;">{{ $list->item_number }}</td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->a04_qty >= 0)
                                    {{number_format($list->a04_qty, 2)}}
                                @else
                                    ( {{ number_format(abs($list->a04_qty), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->ban_qty >= 0)
                                    {{number_format($list->ban_qty, 2)}}
                                @else
                                    ( {{ number_format(abs($list->ban_qty), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->den_qty >= 0)
                                    {{number_format($list->den_qty, 2)}}
                                @else
                                    ( {{ number_format(abs($list->den_qty), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->mae_qty >= 0)
                                    {{number_format($list->mae_qty, 2)}}
                                @else
                                    ( {{ number_format(abs($list->mae_qty), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->phr_qty >= 0)
                                    {{number_format($list->phr_qty, 2)}}
                                @else
                                    ( {{ number_format(abs($list->phr_qty), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->total_qty >= 0)
                                    {{number_format($list->total_qty, 2)}}
                                @else
                                    ( {{ number_format(abs($list->total_qty), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->a04_new_amt >= 0)
                                    {{number_format($list->a04_new_amt, 2)}}
                                @else
                                    ( {{ number_format(abs($list->a04_new_amt), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->ban_new_amt >= 0)
                                    {{number_format($list->ban_new_amt, 2)}}
                                @else
                                    ( {{ number_format(abs($list->ban_new_amt), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->den_new_amt >= 0)
                                    {{number_format($list->den_new_amt, 2)}}
                                @else
                                    ( {{ number_format(abs($list->den_new_amt), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->mae_new_amt >= 0)
                                    {{number_format($list->mae_new_amt, 2)}}
                                @else
                                    ( {{ number_format(abs($list->mae_new_amt), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->phr_new_amt >= 0)
                                    {{number_format($list->phr_new_amt, 2)}}
                                @else
                                    ( {{ number_format(abs($list->phr_new_amt), 2) }} )
                                @endif
                            </td>
                            <td style="border: 1px solid black; text-align: right;">
                                @if ($list->total_amt >= 0)
                                    {{number_format($list->total_amt, 2)}}
                                @else
                                    ( {{ number_format(abs($list->total_amt), 2) }} )
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #eaeaea;"> รวม {{ $type }} </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_a04_qty >= 0)
                                {{number_format($sub_total_a04_qty, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_a04_qty), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_ban_qty >= 0)
                                {{number_format($sub_total_ban_qty, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_ban_qty), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_den_qty >= 0)
                                {{number_format($sub_total_den_qty, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_den_qty), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_mae_qty >= 0)
                                {{number_format($sub_total_mae_qty, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_mae_qty), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_phr_qty >= 0)
                                {{number_format($sub_total_phr_qty, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_phr_qty), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_total_qty >= 0)
                                {{number_format($sub_total_total_qty, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_total_qty), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_a04_new_amt >= 0)
                                {{number_format($sub_total_a04_new_amt, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_a04_new_amt), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_ban_new_amt >= 0)
                                {{number_format($sub_total_ban_new_amt, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_ban_new_amt), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_den_new_amt >= 0)
                                {{number_format($sub_total_den_new_amt, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_den_new_amt), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_mae_new_amt >= 0)
                                {{number_format($sub_total_mae_new_amt, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_mae_new_amt), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_phr_new_amt >= 0)
                                {{number_format($sub_total_phr_new_amt, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_phr_new_amt), 2) }} )
                            @endif
                        </th>
                        <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                            @if ($sub_total_total_amt >= 0)
                                {{number_format($sub_total_total_amt, 2)}}
                            @else
                                ( {{ number_format(abs($sub_total_total_amt), 2) }} )
                            @endif
                        </th>
                    </tr>
                @endforeach
                <tr>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #eaeaea;"> รวมทั้งสิ้น </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_a04_qty >= 0)
                            {{number_format($grand_total_a04_qty, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_a04_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_ban_qty >= 0)
                            {{number_format($grand_total_ban_qty, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_ban_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_den_qty >= 0)
                            {{number_format($grand_total_den_qty, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_den_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_mae_qty >= 0)
                            {{number_format($grand_total_mae_qty, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_mae_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_phr_qty >= 0)
                            {{number_format($grand_total_phr_qty, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_phr_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_total_qty >= 0)
                            {{number_format($grand_total_total_qty, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_total_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_a04_new_amt >= 0)
                            {{number_format($grand_total_a04_new_amt, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_a04_new_amt), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_ban_new_amt >= 0)
                            {{number_format($grand_total_ban_new_amt, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_ban_new_amt), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_den_new_amt >= 0)
                            {{number_format($grand_total_den_new_amt, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_den_new_amt), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_mae_new_amt >= 0)
                            {{number_format($grand_total_mae_new_amt, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_mae_new_amt), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_phr_new_amt >= 0)
                            {{number_format($grand_total_phr_new_amt, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_phr_new_amt), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($grand_total_total_amt >= 0)
                            {{number_format($grand_total_total_amt, 2)}}
                        @else
                            ( {{ number_format(abs($grand_total_total_amt), 2) }} )
                        @endif
                    </th>
                </tr>

                {{-- ---------- ยาเส้น RYO ---------- --}}
                <tr>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold;"> ยาเส้น RYO </th>
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
                @php
                    $ryo_total_a04_qty     = $data_ryo->sum('a04_qty');
                    $ryo_total_ban_qty     = $data_ryo->sum('ban_qty');
                    $ryo_total_den_qty     = $data_ryo->sum('den_qty');
                    $ryo_total_mae_qty     = $data_ryo->sum('mae_qty');
                    $ryo_total_phr_qty     = $data_ryo->sum('phr_qty');
                    $ryo_total_total_qty   = $data_ryo->sum('total_qty');
                    $ryo_total_a04_new_amt = $data_ryo->sum('a04_new_amt');
                    $ryo_total_ban_new_amt = $data_ryo->sum('ban_new_amt');
                    $ryo_total_den_new_amt = $data_ryo->sum('den_new_amt');
                    $ryo_total_mae_new_amt = $data_ryo->sum('mae_new_amt');
                    $ryo_total_phr_new_amt = $data_ryo->sum('phr_new_amt');
                    $ryo_total_total_amt   = $data_ryo->sum('total_amt');
                @endphp
                @foreach ($data_ryo as $list)
                    <tr>                                
                        <td style="border: 1px solid black;">{{ $list->item_number }}</td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->a04_qty >= 0)
                                {{number_format($list->a04_qty, 2)}}
                            @else
                                ( {{ number_format(abs($list->a04_qty), 2) }} )
                            @endif
                        </td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->ban_qty >= 0)
                                {{number_format($list->ban_qty, 2)}}
                            @else
                                ( {{ number_format(abs($list->ban_qty), 2) }} )
                            @endif
                        </td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->den_qty >= 0)
                                {{number_format($list->den_qty, 2)}}
                            @else
                                ( {{ number_format(abs($list->den_qty), 2) }} )
                            @endif
                        </td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->mae_qty >= 0)
                                {{number_format($list->mae_qty, 2)}}
                            @else
                                ( {{ number_format(abs($list->mae_qty), 2) }} )
                            @endif
                        </td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->phr_qty >= 0)
                                {{number_format($list->phr_qty, 2)}}
                            @else
                                ( {{ number_format(abs($list->phr_qty), 2) }} )
                            @endif
                        </td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->total_qty >= 0)
                                {{number_format($list->total_qty, 2)}}
                            @else
                                ( {{ number_format(abs($list->total_qty), 2) }} )
                            @endif
                        </td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->a04_new_amt >= 0)
                                {{number_format($list->a04_new_amt, 2)}}
                            @else
                                ( {{ number_format(abs($list->a04_new_amt), 2) }} )
                            @endif
                        </td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->ban_new_amt >= 0)
                                {{number_format($list->ban_new_amt, 2)}}
                            @else
                                ( {{ number_format(abs($list->ban_new_amt), 2) }} )
                            @endif
                        </td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->den_new_amt >= 0)
                                {{number_format($list->den_new_amt, 2)}}
                            @else
                                ( {{ number_format(abs($list->den_new_amt), 2) }} )
                            @endif
                        </td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->mae_new_amt >= 0)
                                {{number_format($list->mae_new_amt, 2)}}
                            @else
                                ( {{ number_format(abs($list->mae_new_amt), 2) }} )
                            @endif
                        </td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->phr_new_amt >= 0)
                                {{number_format($list->phr_new_amt, 2)}}
                            @else
                                ( {{ number_format(abs($list->phr_new_amt), 2) }} )
                            @endif
                        </td>
                        <td style="border: 1px solid black; text-align: right;">
                            @if ($list->total_amt >= 0)
                                {{number_format($list->total_amt, 2)}}
                            @else
                                ( {{ number_format(abs($list->total_amt), 2) }} )
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #eaeaea;"> รวมยาเส้น RYO </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_a04_qty >= 0)
                            {{number_format($ryo_total_a04_qty, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_a04_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_ban_qty >= 0)
                            {{number_format($ryo_total_ban_qty, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_ban_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_den_qty >= 0)
                            {{number_format($ryo_total_den_qty, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_den_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_mae_qty >= 0)
                            {{number_format($ryo_total_mae_qty, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_mae_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_phr_qty >= 0)
                            {{number_format($ryo_total_phr_qty, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_phr_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_total_qty >= 0)
                            {{number_format($ryo_total_total_qty, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_total_qty), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_a04_new_amt >= 0)
                            {{number_format($ryo_total_a04_new_amt, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_a04_new_amt), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_ban_new_amt >= 0)
                            {{number_format($ryo_total_ban_new_amt, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_ban_new_amt), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_den_new_amt >= 0)
                            {{number_format($ryo_total_den_new_amt, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_den_new_amt), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_mae_new_amt >= 0)
                            {{number_format($ryo_total_mae_new_amt, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_mae_new_amt), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_phr_new_amt >= 0)
                            {{number_format($ryo_total_phr_new_amt, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_phr_new_amt), 2) }} )
                        @endif
                    </th>
                    <th style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #eaeaea;">
                        @if ($ryo_total_total_amt >= 0)
                            {{number_format($ryo_total_total_amt, 2)}}
                        @else
                            ( {{ number_format(abs($ryo_total_total_amt), 2) }} )
                        @endif
                    </th>
                </tr>
            </tbody>
        </table>
    </body>
</html>