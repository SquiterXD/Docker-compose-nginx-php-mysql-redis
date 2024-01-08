<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> ใบแจ้งรายการสั่งซื้อแสตมป์แยกตามกลุ่มราคา </title>
    @include('pp.reports.PPR0006._style')
</head>
<body>
    @include('pp.reports.PPR0006.header')
    <br>
    <table class="table table-bordered mt-3" style="border-collapse: collapse; border: 0.5px solid #ddd; padding: 0px; margin: 0px;">
        <thead>
            <tr>
                <th width="10%" class="stamp-header">
                    สั่งซื้อตามความต้องการใช้
                </th>
                <td width="20%" colspan="2" class="stamp-header">
                    <strong> {{ count($stampItems)? $stampItems->first()->stamp_description: 'แสตมป์กลุ่มราคา' }} </strong>
                    <br><div style="padding: 3px;" class="text-center"> {{ $items }} </div>
                </td>
                <th width="10%" colspan="3" class="stamp-header">
                    หมายเหตุ
                </th>
            </tr>
        </thead>
        @php
            $quantityRecRoll = 0;
            $totalPrice = 0;
        @endphp
        <tbody>
            @foreach ($stampItems as $line)
                @php
                    $quantityRecRoll = $line->receive_roll_qty * $line->stamp_per_roll;
                    $totalPrice = ($line->receive_roll_qty * $line->stamp_per_roll) * $line->unit_price;
                    $per29 = ($totalPrice * $setupStamp[3][0]) / 100; //สสส
                    $per32 = ($totalPrice * $setupStamp[2][0]) / 100; //สสท
                    $per35 = ($totalPrice * $setupStamp[4][0]) / 100; //กกท
                    $per38 = ($totalPrice * $setupStamp[6][0]) / 100; //ผส
                    $per41 = ($totalPrice * $setupStamp[5][0]) / 100; //มหาดไทย
                    $totalPercent = $per29 + $per32 + $per35 + $per38 + $per41;
                @endphp
                <tr>
                    <td rowspan="3" style="font-size: 16px; border: 0.5px solid #000000; text-align: center; padding: 4px; height: 10px;">
                        {{ convertFormatDateToFullThai($line->plan_date, 'short_format') }}
                    </td>
                        <td class="text-center" style="font-size: 16px; border: 0.5px solid #000000; text-align: center; padding: 4px; height: 10px;">
                            ชนิดม้วน <br> (ม้วน)
                        </td>
                        <td class="text-center" style="font-size: 16px; border: 0.5px solid #000000; text-align: center; padding: 4px; height: 10px;">
                            ชนิดแผ่น <br> (เล่ม)
                        </td>
                        <td style="border-bottom: 0.5px solid #fff;" class="stamp-qty"> </td>
                    </tr>
                        <td class="stamp-qty">
                            {{ number_format($line->receive_roll_qty, 2) }}
                        </td>
                        <td class="stamp-qty"> </td>
                        <td style="border-bottom: 0.5px solid #fff;" class="stamp-qty"> </td>
                    </tr>
                        <td class="stamp-qty">
                            {{ number_format($line->receive_roll_qty * $line->stamp_per_roll, 2) }}
                        </td>
                        <td class="stamp-qty">
                            {{ number_format($line->weekly_receive_qty, 2) }}
                        </td>
                        <td rowspan="3" class="text-center stamp-qty">
                            หน่วย (ดวง)
                        </td>
                    </tr>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-12 text-right">
        <h4> ราคา/ดวง : {{ count($stampItems)? $stampItems->first()->unit_price: '' }} บาท</h4>
    </div>
    {{-- Summary 1 --}}
    <div class="col-12 text-right">
        <table class="table table-bordered mt-1" style="border-collapse: collapse; border: 0.5px solid #FFF; padding: 0px; margin: 0px; font-size: 18px; font-weight: bold;">
            <tbody>
                @foreach ($stampItems as $line)
                    <tr>
                        <td style="border: 0.5px solid #FFF; text-align: right; padding: 4px; height: 10px; width: 18%;">
                            รวมแสมป์ ชนิดแผ่น
                        </td>
                        <td class="text-rigth" style="border: 0.5px solid #FFF; padding: 4px; height: 10px; width: 10%;">
                            -
                        </td>
                        <td class="text-center" style="border: 0.5px solid #FFF; padding: 4px; height: 10px; width: 10%;">
                            ดวง
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-left"> เป็นเงิน </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> - </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-center"> บาท </td>
                    </tr>
                    <tr>
                        <td style="border: 0.5px solid #FFF; text-align: right; padding: 4px; height: 10px; width: 18%;">
                            รวมแสมป์ ชนิดม้วน
                        </td>
                        <td class="text-right" style="border: 0.5px solid #FFF; padding: 4px; height: 10px; width: 10%;">
                            <u> {{ number_format($quantityRecRoll, 2) }} </u>
                        </td>
                        <td class="text-center" style="border: 0.5px solid #FFF; padding: 4px; height: 10px; width: 10%;">
                            ดวง
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-left"> เป็นเงิน </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> <u> {{ number_format($totalPrice, 2) }} </u> </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-center"> บาท </td>
                    </tr>
                    <tr>
                        <td style="border: 0.5px solid #FFF; text-align: right; padding: 4px; height: 10px; width: 18%;">
                            รวมแสมป์ทั้งหมด
                        </td>
                        <td class="text-right u-double" style="border: 0.5px solid #FFF; padding: 4px; height: 10px; width: 10%;">
                            <span style="border-bottom: 3px double #000;"> {{ number_format($quantityRecRoll, 2) }} </span>
                        </td>
                        <td class="text-center" style="border: 0.5px solid #FFF; padding: 4px; height: 10px; width: 10%;">
                            ดวง
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-left"> รวมเป็นเงิน </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right">
                            <span style="border-bottom: 3px double #000;"> {{ number_format($totalPrice, 2) }} </span>
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-center"> บาท </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Summary 2 --}}
    <br><br>
    <div class="col-12 text-right">
        <table class="table table-bordered mt-1" style="border-collapse: collapse; border: 0.5px solid #FFF; padding: 0px; margin: 0px; font-size: 18px; font-weight: bold;">
            <tbody>
                @foreach ($stampItems as $line)
                    <tr>
                        <td colspan="2" style="border: 0.5px solid #FFF; text-align: right; padding: 4px; height: 10px; width: 27%;">
                            สสส.
                        </td>
                        <td class="text-rigth" style="border: 0.5px solid #FFF; padding: 4px; height: 10px; width: 10%;">
                            ร้อยละ
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> {{ number_format($setupStamp[3][0], 2) }} </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> {{ number_format($per29, 2) }} </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-center"> บาท </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: 0.5px solid #FFF; text-align: right; padding: 4px; height: 10px; width: 27%;">
                            สสท.
                        </td>
                        <td class="text-rigth" style="border: 0.5px solid #FFF; padding: 4px; height: 10px; width: 10%;">
                            ร้อยละ
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> {{ number_format($setupStamp[2][0], 2) }} </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> {{ number_format($per32, 2) }} </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-center"> บาท </td>
                    </tr>
                    <tr>
                        <td  colspan="2" style="border: 0.5px solid #FFF; text-align: right; padding: 4px; height: 10px; width: 27%;">
                            กกท.
                        </td>
                        <td class="text-rigth" style="border: 0.5px solid #FFF; padding: 4px; height: 10px; width: 10%;">
                            ร้อยละ
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> {{ number_format($setupStamp[4][0], 2) }} </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> {{ number_format($per35, 2) }} </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-center"> บาท </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: 0.5px solid #FFF; text-align: right; padding: 4px; height: 10px; width: 27%;">
                            ผส.
                        </td>
                        <td class="text-rigth" style="border: 0.5px solid #FFF; padding: 4px; height: 10px; width: 10%;">
                            ร้อยละ
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> {{ number_format($setupStamp[6][0], 2) }} </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> {{ number_format($per38, 2) }} </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-center"> บาท </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border: 0.5px solid #FFF; text-align: right; padding: 4px; height: 10px; width: 27%;">
                            ภาษีเก็บเพิ่มเพื่อราชการส่วนท้องถิ่นร้อยละ {{ $setupStamp[5][0] }}
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> <u> {{ number_format($per41, 2) }} </u> </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-center"> บาท </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border: 0.5px solid #FFF; text-align: right; padding: 4px; height: 10px; width: 27%;">
                            รวมกองทุนและภาษีเก็บเพิ่ม
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right"> 
                            <u> {{ number_format($totalPercent, 2) }} </u>
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-center"> บาท </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border: 0.5px solid #FFF; text-align: right; padding: 4px; height: 60px; width: 27%;">
                            รวม
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-right">
                            <span style="border-bottom: 3px double #000;"> {{ number_format($totalPercent + $totalPrice, 2) }} </span>
                        </td>
                        <td style="border: 0.5px solid #fff; width: 10%;" class="text-center"> บาท </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
