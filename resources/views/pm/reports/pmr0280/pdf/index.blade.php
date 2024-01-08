<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode->program_code }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports._style')
        <style>
            table th, table td {
                font-size: 14px;
            }
            tfoot {
                line-height: 1.5;
            }
        </style>
    </head>
    <body>
    @php
        $colspan=14;
        $sum_receive_wip03_first = 0;
        $sum_receive_wip04_first = 0;
        $sum_receive_wip06_first = 0;
        $sum_receive_wip_total_first = 0;
        $sum_product_wip03 = 0;
        $sum_product_wip04 = 0;
        $sum_product_wip06 = 0;
        $sum_sendQty = 0;
        $sum_exampleQty04 = 0;
        $sum_transfer_wip03_last = 0;
        $sum_transfer_wip04_last = 0;
        $sum_transfer_wip06_last = 0;
        $sum_transfer_wip_total_last = 0;

        $styleBorderLR = 'border-right:1px solid #000 !important; border-left:1px solid #000 !important;';
        $styleBorderAll = 'border-top:1px solid #000 !important; border-bottom:1px solid #000 !important; border-right:1px solid #000 !important; border-left:1px solid #000 !important;';
    @endphp
        <table class="table" border="0">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode->program_code }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}
                            </div>
                            <div style="width:60%;text-align:center" class="b">
                                การยาสูบแห่งประเทศไทย<br>
                                {{ $progTitle }} {{ $monthTh }} {{ $month->format("Y")}}<br>
                                ฝ่ายผลิตภัณฑ์สำเร็จรูป {{ $departmentDesc }}<br>

                            </div>
                            <div style="width:20%;text-align:right;" class="b">
                                วันที่ : {{ parseToDateTh(now()) }}<br>
                                เวลา :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>

                            </div>
                        </div>
                    </th>
                </tr>
                <tr>
                    <td colspan="7">สาขาโรจนะ</td>
                    <td colspan="7" style="text-align: right">หน่วย : มวน</td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <th align="center" style="{{ $styleBorderLR }} " rowspan="2">รายการ</th>
                    <th align="center" style="{{ $styleBorderLR }} " colspan="4">คงคลังวันที่ 1 {{$monthTh}} {{ $month->format("Y")}}</th>
                    <th align="center" style="{{ $styleBorderLR }} " colspan="3">ผลิตขึ้นในเดือน {{$monthTh}} {{ $month->format("Y")}}</th>
                    <th align="center" style="{{ $styleBorderLR }} " rowspan="2">ส่งโกดังขาย</th>
                    <th align="center" style="{{ $styleBorderLR }} " rowspan="2">บุหรี่แจกและตัวอย่าง</th>
                    <th align="center" style="{{ $styleBorderLR }} " colspan="4">คงคลังวันที่ {{ $maxDay }} {{$monthTh}} {{ $month->format("Y")}}</th>
                </tr>
                <tr style="{{ $styleBorderLR }} border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <th style="{{ $styleBorderLR }} text-align:center; width: 65px; max-width: 65px;"> มวน</th>
                    <th style="{{ $styleBorderLR }} text-align:center; width: 65px; max-width: 65px;"> ซอง/ห่อ<br>(20 มวน/ซอง)<br>(200 มวน/ห่อ)</th>
                    <th style="{{ $styleBorderLR }} text-align:center; width: 65px; max-width: 65px;"> หีบ<br>(10,000 <br>มวน/หีบ)</th>
                    <th style="{{ $styleBorderLR }} text-align:center; width: 65px; max-width: 65px;"> รวม</th>
                    <th style="{{ $styleBorderLR }} text-align:center; width: 65px; max-width: 65px;"> มวน</th>
                    <th style="{{ $styleBorderLR }} text-align:center; width: 65px; max-width: 65px;"> ซอง/ห่อ<br>(20 มวน/ซอง)<br>(200 มวน/ห่อ)</th>
                    <th style="{{ $styleBorderLR }} text-align:center; width: 65px; max-width: 65px;"> หีบ<br>(10,000 <br>มวน/หีบ)</th>
                    <th style="{{ $styleBorderLR }} text-align:center; width: 65px; max-width: 65px;"> มวน</th>
                    <th style="{{ $styleBorderLR }} text-align:center; width: 65px; max-width: 65px;"> ซอง/ห่อ<br>(20 มวน/ซอง)<br>(200 มวน/ห่อ)</th>
                    <th style="{{ $styleBorderLR }} text-align:center; width: 65px; max-width: 65px;"> หีบ<br>(10,000 <br>มวน/หีบ)</th>
                    <th style="{{ $styleBorderLR }} text-align:center; width: 65px; max-width: 65px;"> รวม</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $group => $lists)
                <tr>
                    <td style="{{ $styleBorderLR }}"><u>{{$group}}</u></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                </tr>
                    @foreach($lists->groupBy('item_desc') as $list)
                    {{-- {{ dd('========1', $list, $items) }} --}}
                    @php
                    $minDate = $list->min('product_date');
                    $maxDate = $list->max('product_date');

                    $receive_wip03_first = $list->where('product_date', $minDate)->sum('receive_wip03');
                    $receive_wip04_first = $list->where('product_date', $minDate)->sum('receive_wip04');
                    $receive_wip06_first = $list->where('product_date', $minDate)->sum('receive_wip06');
                    $receive_wip_total_first = $receive_wip03_first + $receive_wip04_first + $receive_wip06_first;

                    // $receive_wip03 = $list->sum('receive_wip03');
                    // $receive_wip04 = $list->sum('receive_wip04');
                    // $receive_wip05 = $list->sum('receive_wip05');
                    // $receive_wip06 = $list->sum('receive_wip06');
                    $product_wip03 = $list->sum('product_qty_wip03');
                    $product_wip04 = $list->sum('product_qty_wip04');
                    $product_wip06 = $list->sum('product_qty_wip06');
                    $product_wip06 = $product_wip06 - $list->sum('example_qty04');
                    // dd('xx', $lists->groupBy('item_desc'), $product_wip03, $list);

                    $sendQty = $list->first()->transfer_v;
                    $exampleQty04 = $list->sum('example_qty04');

                    // $transfer_wip03_last = $list->where('product_date', $list->max('product_date'))->sum('receive_wip03');
                    // $transfer_wip04_last = $list->where('product_date', $list->max('product_date'))->sum('transfer_wip04');
                    // $transfer_wip05_last = $list->where('product_date', $list->max('product_date'))->sum('transfer_wip05');
                    // $transfer_wip06_last = $list->where('product_date', $list->max('product_date'))->sum('transfer_wip06');
                    // $transfer_wip_total_last = $transfer_wip03_last + $transfer_wip04_last + $transfer_wip05_last + $transfer_wip06_last;

                    $transfer_wip03_last = $list->where('product_date', $maxDate)->sum('transfer_wip03');
                    $transfer_wip04_last = $list->where('product_date', $maxDate)->sum('transfer_wip04');
                    $transfer_wip06_last = $list->where('product_date', $maxDate)->sum('transfer_wip06');
                    $transfer_wip_total_last = $transfer_wip03_last + $transfer_wip04_last;

                    $sum_receive_wip03_first    = $sum_receive_wip03_first + $receive_wip03_first;
                    $sum_receive_wip04_first    = $sum_receive_wip04_first + $receive_wip04_first;
                    $sum_receive_wip06_first    = $sum_receive_wip06_first + $receive_wip06_first;
                    $sum_receive_wip_total_first = $sum_receive_wip_total_first + $receive_wip_total_first;
                    $sum_product_wip03          = $sum_product_wip03 + $product_wip03;
                    $sum_product_wip04          = $sum_product_wip04 + $product_wip04;
                    $sum_product_wip06          = $sum_product_wip06 + $product_wip06;
                    $sum_sendQty                = $sum_sendQty + $sendQty;
                    $sum_exampleQty04           = $sum_exampleQty04 + $exampleQty04;
                    $sum_transfer_wip03_last    = $sum_transfer_wip03_last + $transfer_wip03_last;
                    $sum_transfer_wip04_last    = $sum_transfer_wip04_last + $transfer_wip04_last;
                    $sum_transfer_wip06_last    = $sum_transfer_wip06_last + $transfer_wip06_last;
                    $sum_transfer_wip_total_last = $sum_transfer_wip_total_last + $transfer_wip_total_last;

                    @endphp
                    <tr>
                        <td style="{{ $styleBorderLR }}">{{ $list->first()->item_desc }}</td>
                        {{-- คงคลังวันที่ 1 ตุลาคม 2565 --}}
                        <td style="{{ $styleBorderLR }}"  align="right">{{ $receive_wip03_first > 0 ?        number_format($receive_wip03_first) : '' }}</td>
                        <td style="{{ $styleBorderLR }}"  align="right">{{ ($receive_wip04_first) > 0 ?      number_format($receive_wip04_first): '' }}</td>
                        <td style="{{ $styleBorderLR }}"  align="right">{{ $receive_wip06_first > 0 ?        number_format($receive_wip06_first) : '' }}</td>
                        <td style="{{ $styleBorderLR }}"  align="right">{{ $receive_wip_total_first > 0 ?    number_format($receive_wip_total_first) : '' }}</td>

                        {{-- ผลิตขึ้นในเดือน ตุลาคม 2565 --}}
                        <td style="{{ $styleBorderLR }}" align="right">{{ $product_wip03 > 0 ?  number_format($product_wip03) : ''  }}</td>
                        <td style="{{ $styleBorderLR }}" align="right">{{ $product_wip04 > 0 ?  number_format($product_wip04) : ''  }}</td>
                        <td style="{{ $styleBorderLR }}" align="right">{{ $product_wip06 > 0 ?  number_format($product_wip06) : ''  }}</td>

                        {{-- ส่งโกดังขาย --}}
                        <td style="{{ $styleBorderLR }}" align="right">{{ $sendQty > 0 ?  number_format($sendQty) : ''  }}</td>
                        {{-- บุหรี่แจกและตัวอย่าง --}}
                        <td style="{{ $styleBorderLR }}" align="right">{{ $exampleQty04 > 0 ?  number_format($exampleQty04) : ''  }}</td>

                        {{-- คงคลังวันที่ 31 ตุลาคม 2565 --}}
                        <td style="{{ $styleBorderLR }}"  align="right">{{ $transfer_wip03_last > 0 ?        number_format($transfer_wip03_last) : '' }}</td>
                        <td style="{{ $styleBorderLR }}"  align="right">{{ ($transfer_wip04_last) > 0 ?      number_format($transfer_wip04_last): '' }}</td>
                        <td style="{{ $styleBorderLR }}"  align="right">{{ $transfer_wip06_last > 0 ?        number_format($transfer_wip06_last) : '' }}</td>
                        <td style="{{ $styleBorderLR }}"  align="right">{{ $transfer_wip_total_last > 0 ?    number_format($transfer_wip_total_last) : '' }}</td>
                    </tr>
                    @endforeach
            @endforeach
                <tr>
                    <td style="{{ $styleBorderLR }}"><u>บุหรี่แจก</u></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                </tr>
                @foreach($items_free->groupBy('item_desc') as $group => $item)
                <tr>
                    <td style="{{ $styleBorderLR }}">{{ $group }}</td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}" align="right">{{ $item->sum('transaction_qty') > 0 ? number_format($item->sum('transaction_qty')) : '' }}</td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}" align="right">{{ $item->sum('transaction_qty') > 0 ? number_format($item->sum('transaction_qty')) : '' }}</td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                </tr>
                @endforeach
                <tr>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}" align="right">{{ $items_free->sum('transaction_qty') > 0 ? number_format($items_free->sum('transaction_qty')) : '' }}</td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}" align="right">{{ $items_free->sum('transaction_qty') > 0 ? number_format($items_free->sum('transaction_qty')) : '' }}</td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                    <td style="{{ $styleBorderLR }}"></td>
                </tr>
                <tr>
                    <td style="{{ $styleBorderAll }}">รวม</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_receive_wip03_first > 0 ? number_format($sum_receive_wip03_first) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_receive_wip04_first > 0 ? number_format($sum_receive_wip04_first) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_receive_wip06_first > 0 ? number_format($sum_receive_wip06_first) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_receive_wip_total_first > 0 ? number_format($sum_receive_wip_total_first) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_product_wip03 > 0 ? number_format($sum_product_wip03) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_product_wip04 > 0 ? number_format($sum_product_wip04) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_product_wip06 > 0 ? number_format($sum_product_wip06) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_sendQty > 0 ? number_format($sum_sendQty) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_exampleQty04 > 0 ? number_format($sum_exampleQty04) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_transfer_wip03_last > 0 ? number_format($sum_transfer_wip03_last) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_transfer_wip04_last > 0 ? number_format($sum_transfer_wip04_last) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_transfer_wip06_last > 0 ? number_format($sum_transfer_wip06_last) : '-' }}</td>
                    <td style="{{ $styleBorderAll }}" align="right">{{ $sum_transfer_wip_total_last > 0 ? number_format($sum_transfer_wip_total_last) : '-' }}</td>
                </tr>
                <tr>
                    <td colspan="14" height="20"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="14">
                        <table width="100%" border="0">
                            <tr>
                                <td width="10%" align="right" valign="top">
                                    <div>ต้นฉบับ </div>
                                    <div>สำเนาถูกต้อง </div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    @if ($showRemark)
                                        <div>หมายเหตุ </div>
                                    @endif
                                </td>
                                <td width="20%" align="left" valign="top">
                                    <div>- กองบัญชีต้นทุน</div>
                                    <div>- ฝ่ายผลิตภัณฑ์สำเร็จรูป กองมวนและบรรจุ</div>
                                    <div>- กองวิเคราะห์ต้นทุนและการเงิน</div>
                                    <div>- เก็บ</div>
                                    <div>&nbsp;</div>
                                    @if ($showRemark)
                                        <div>- บุหรี่ส่งผ่า มวนและบรรจุ {{ number_format($sumLoss ?? 0) }} มวน</div>
                                    @endif
                                </td>
                                <td width="25%" align="center">
                                </td>
                                <td width="55%" align="center">
                                    <div style="text-align: left !important;">(บุหรี่แจกพนักงานยาสูบภายในบริเวณโรงงานตามบันทึกที่ผ/ท/189 ลงวันที่ 25 สค. 2530)</div>
                                    <div>ฝ่ายวางแผนการผลิตขอรับรองว่าในเย็นวันที่ 31 ตุลาคม 2565 มีบุหรี่คงเหลือ {{ $sum_transfer_wip_total_last > 0 ? $sum_transfer_wip_total_last : 0  }} มวน ({{ $sum_transfer_wip_total_last > 0 ? ReadNumber($sum_transfer_wip_total_last) : 'ศูนย์' }}บาท มวน)</div>
                                    <br>
                                    <div>(............................................)</div>
                                    <div>ผู้อำนวยการฝ่ายวางแผนการผลิต</div>
                                    <div>{{ formatLongDateThai(date('Ymd')) }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tfoot>
        </table>

    </body>
</html>
