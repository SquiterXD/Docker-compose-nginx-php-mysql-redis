<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    <body style="">
        @php
            $styleTh = 'border:  1px solid black !important; line-height: 100px; ';
            $styleFont16 = 'border-bottom:  1px solid black !important; border-top:  1px solid black !important; font-size: 16px; font-weight: bold;';
            $styleFont14 = 'border:  1px solid black !important; font-size: 14px; ';
            $font18 = 'font-size: 18px; ';
            $font16 = 'font-size: 16px; ';
            $font14 = 'font-size: 14px; vertical-align:top !important; ';
            $font15 = 'font-size: 15px; vertical-align:middle !important; ';
            $border = 'border:  1px solid black !important; ';
            $borderLR = 'border-left:  1px solid black !important; border-right:  1px solid black !important; ';
            $borderLR = ' ';
            // $fontWeight = "font-weight: bold; ";
            $lineNo = 0;
            $sumTotalCost = $datas->sum('total_cost');
        @endphp
        <table  width="100%"  style="padding-left: 5px; padding-right: 5px;"   >
            <thead>
                <tr>
                    <td colspan="4" width="30.33%" align="left"   style="{{ $font18 }}"><b>โปรแกรม : </b> {{ request()->program_code }}</td>
                    <td colspan="4" width="39.33%" align="center"   style="{{ $font18 }}"><b> {{ $reportData->name1 }} </b></td>
                    <td colspan="4" width="30.33%" align="right"  style="{{ $font18 }}"><b>วันที่พิมพ์ : </b> {{ $reportData->date }} </td>
                </tr>
                <tr>
                    <td colspan="4" width="30.33%" align="left"   style="{{ $font18 }}"><b>สั่งพิมพ์ : </b> {{ $profile->user_name }}</td>
                    <td colspan="4" width="39.33%" align="center"   style="{{ $font18 }}"><b> {{ $reportData->name2 }} </b></td>
                    <td colspan="4" width="30.33%" align="right"  style="{{ $font18 }}"><b> เวลา : </b> {{ $reportData->time }}  </td>
                </tr>
                <tr>
                    <td colspan="4" width="30.33%" align="left"   style="{{ $font18 }}"></td>
                    <td colspan="4" width="39.33%" align="center"   style="{{ $font18 }}"><b>{{ $reportData->name3 }}</b></td>
                    <td colspan="4" width="30.33%" align="right"  style="{{ $font18 }}"></td>
                </tr>
            </thead>
        </table>
        <table style="padding-top: 20px;">
            <thead>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td  align="center" style="{{ $styleFont16 }}">วันที่</td>
                    <td  align="center" style="{{ $styleFont16 }}">ผลผลิต</td>
                    <td  align="center" style="{{ $styleFont16 }}"></td>
                    <td  align="right" style="{{ $styleFont16 }}">จำนวน</td>
                    <td  align="center" style="{{ $styleFont16 }}">หน่วย</td>
                    <td  align="right" style="{{ $styleFont16 }}">ราคาต่อหน่วย</td>
                    <td  align="center" style="{{ $styleFont16 }}">วัตถุดิบ</td>
                    <td  align="center" style="{{ $styleFont16 }}"></td>
                    <td  align="right" style="{{ $styleFont16 }}">ปริมาณที่ใช้</td>
                    <td  align="center" style="{{ $styleFont16 }}">หน่วย</td>
                    <td  align="right" style="{{ $styleFont16 }}">ราคาต่อหน่วย</td>
                    <td  align="right" style="{{ $styleFont16 }}">ราคารวม</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas->groupBy('transaction_date_char') as $dateChar => $dates)
                    @foreach ($dates->sortBy('product_code')->groupBy('product_code') as $lines)
                    @php
                        $sumTotalCostByProdduct = $lines->sum('total_cost');
                        $firstLine = $lines->first();
                    @endphp
                        @foreach ($lines as $line)
                        @php
                            $loopFirst = $loop->first;
                        @endphp
                            <tr>
                                <td align="center" style="{{ $font14 }} {{ $borderLR }} " >
                                    @if ($loopFirst)
                                        {{ parseToDateTh($dateChar) }}
                                    @endif
                                </td>
                                <td align="left" style="{{ $font14 }} {{ $borderLR }} " >
                                    @if ($loopFirst)
                                        {{ $firstLine->product_code }}
                                    @endif
                                </td>
                                <td align="left" style="{{ $font14 }} {{ $borderLR }}" >
                                    @if ($loopFirst)
                                        {{ $firstLine->product_desc }}
                                    @endif
                                </td>
                                <td align="right" style="{{ $font14 }} {{ $borderLR }} " >
                                    @if ($loopFirst)
                                        {{ ($firstLine->product_qty) }}
                                    @endif
                                </td>
                                <td align="center" style="{{ $font14 }} {{ $borderLR }} " >
                                    @if ($loopFirst)
                                        {{ $firstLine->product_uom }}
                                    @endif
                                </td>
                                <td align="right" style="{{ $font14 }} {{ $borderLR }} " >
                                    @if ($loopFirst)
                                        @if (!$sumTotalCostByProdduct || !$firstLine->product_qty)
                                            {{ (0) }}
                                        @else
                                            {{ ($sumTotalCostByProdduct / $firstLine->product_qty) }}
                                        @endif
                                    @endif
                                </td>
                                <td align="center" style="{{ $font14 }} {{ $borderLR }} " >
                                    {{ $line->mat_code }}
                                </td>
                                <td align="left" style="{{ $font14 }} {{ $borderLR }} " >
                                    {{ $line->mat_desc }}
                                </td>
                                <td align="right" style="{{ $font14 }} {{ $borderLR }} " >
                                    {{ ($line->mat_qty) }}
                                </td>
                                <td align="center" style="{{ $font14 }} {{ $borderLR }} " >
                                    {{ $line->mat_uom }}
                                </td>
                                <td align="right" style="{{ $font14 }} {{ $borderLR }} " >
                                    {{ ($line->actual_cost) }}
                                </td>
                                <td align="right" style="{{ $font14 }} {{ $borderLR }} " >
                                    {{ ($line->total_cost) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr height="20">
                            <td  colspan="8" align="right" style="{{ $font15 }} "><b>รวมค่าวัตถุดิบ</b></td>
                            <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b>{{ ($lines->sum('mat_qty')) }}</b></td>
                            <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b></b></td>
                            <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b></b></td>
                            <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b>{{ ($lines->sum('total_cost')) }}</b></td>
                        </tr>
                    @endforeach
                @endforeach
                @if (count($datas))
                <tr>
                    <td height="5" colspan="12"></td>
                </tr>
                <tr height="20">
                    <td  colspan="2" align="right" style="{{ $font15 }} border-top: 1px solid black !important; border-bottom: 1px solid !important;"><b>รวมค่าวัตถุดิบ</b></td>
                    <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 1px solid !important;  ">{{ ($sumTotalCost) }}</td>
                    <td  colspan="9" align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 1px solid !important;  "></td>
                </tr>
                @endif
            </tbody>
        </table>
        <table style="margin-top: 30px;">
            <tr>
                <td colspan="4" align="center" width="33.33%" style="{{ $font18 }}">
                    <div><b>หัวหน้ากอง............................................</b></div>
                </td>
                <td colspan="4" align="center" width="33.33%" style="{{ $font18 }}">
                    <div><b>รองผู้จัดการ............................................</b></div>
                </td>
                <td colspan="4" align="center" width="33.33%" style="{{ $font18 }}">
                    <div><b>ผู้จัดการ............................................</b></div>
                </td>
            </tr>
            <tr>
                <td height="30" align="center" colspan="12" style="{{ $font18 }}" >
                    <b>จบรายงาน</b>
                </td>
            </tr>
        </table>
    </body>
</html>
