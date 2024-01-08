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
                    <td colspan="5" width="39.33%" align="center"   style="{{ $font18 }}"><b> {{ $reportData->name1 }} </b></td>
                    <td colspan="4" width="30.33%" align="right"  style="{{ $font18 }}"><b>วันที่พิมพ์ : </b> {{ $reportData->date }} </td>
                </tr>
                <tr>
                    <td colspan="4" width="30.33%" align="left"   style="{{ $font18 }}"><b>สั่งพิมพ์ : </b> {{ $profile->user_name }}</td>
                    <td colspan="5" width="39.33%" align="center"   style="{{ $font18 }}"><b> {{ $reportData->name2 }} </b></td>
                    <td colspan="4" width="30.33%" align="right"  style="{{ $font18 }}"><b> เวลา : </b> {{ $reportData->time }}  </td>
                </tr>
                <tr>
                    <td colspan="4" width="30.33%" align="left"   style="{{ $font18 }}"></td>
                    <td colspan="5" width="39.33%" align="center"   style="{{ $font18 }}"><b>{{ $reportData->name3 }}</b></td>
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
                    <td  align="center" style="{{ $styleFont16 }}">กลุ่มวัตถุดิบ</td>
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
                        $loopFirst = true;
                        $firstLine = $lines->first();
                        $sumTotalCostByProdduct = $lines->sum('total_cost');
                    @endphp
                        @foreach ($lines->groupBy('cat_mat') as $catMatKey => $catMat)
                            @foreach ($catMat as $line)
                            @php
                                $loopCatMatFirst = $loop->first;
                            @endphp
                                <tr>
                                    <td align="center" style="{{ $font14 }} {{ $borderLR }}" >
                                        @if ($loopFirst)
                                            {{ parseToDateTh($dateChar) }}
                                        @endif
                                    </td>
                                    <td align="left" style="{{ $font14 }} {{ $borderLR }}" >
                                        @if ($loopFirst)
                                            {{ $firstLine->product_code }}
                                        @endif
                                    </td>
                                    <td align="left" style="{{ $font14 }} {{ $borderLR }}" >
                                        @if ($loopFirst)
                                            {{ $firstLine->product_desc }}
                                        @endif
                                    </td>
                                    <td align="right" style="{{ $font14 }} {{ $borderLR }}" >
                                        @if ($loopFirst)
                                            {{ number_format($firstLine->product_qty ?? 0, 2) }}
                                        @endif
                                    </td>
                                    <td align="center" style="{{ $font14 }} {{ $borderLR }}" >
                                        @if ($loopFirst)
                                            {{ $firstLine->product_uom }}
                                        @endif
                                    </td>
                                    <td align="right" style="{{ $font14 }} {{ $borderLR }}" >
                                        @if ($loopFirst)
                                            @if (!$sumTotalCostByProdduct || !$firstLine->product_qty)
                                                {{ number_format(0, 9) }}
                                            @else
                                                {{ number_format($sumTotalCostByProdduct / $firstLine->product_qty, 9) }}
                                            @endif
                                        @endif
                                    </td>
                                    <td align="left" style="{{ $font14 }} {{ $borderLR }}" >
                                        @if ($loopCatMatFirst)
                                            {{ $catMatKey }}
                                        @endif
                                    </td>
                                    <td align="center" style="{{ $font14 }} {{ $borderLR }}" >
                                        {{ $line->mat_code }}
                                    </td>
                                    <td align="left" style="{{ $font14 }} {{ $borderLR }}" >
                                        {{ $line->mat_desc }}
                                    </td>
                                    <td align="right" style="{{ $font14 }} {{ $borderLR }}" >
                                        {{ number_format($line->mat_qty ?? 0, 6) }}
                                    </td>
                                    <td align="center" style="{{ $font14 }} {{ $borderLR }}" >
                                        {{ $line->mat_uom }}
                                    </td>
                                    <td align="right" style="{{ $font14 }} {{ $borderLR }}" >
                                        {{ number_format($line->actual_cost ?? 0, 9) }}
                                    </td>
                                    <td align="right" style="{{ $font14 }} {{ $borderLR }}" >
                                        {{ number_format($line->total_cost ?? 0, 2) }}
                                    </td>
                                </tr>
                                @php
                                    $loopFirst = false;
                                @endphp
                            @endforeach
                            <tr>
                                <td height="5" colspan="13"></td>
                            </tr>
                            <tr height="20">
                                <td  colspan="9" align="right" style="{{ $font15 }} "><b>รวมค่ากลุ่มวัตถุดิบ</b></td>
                                <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b>{{ number_format($catMat->sum('mat_qty'), 6) }}</b></td>
                                <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b></b></td>
                                <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b></b></td>
                                <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b>{{ number_format($catMat->sum('total_cost'), 2) }}</b></td>
                            </tr>
                            <tr>
                                <td height="5" colspan="13"></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td height="5" colspan="13"></td>
                        </tr>
                        <tr height="20">
                            <td  colspan="9" align="right" style="{{ $font15 }} "><b>รวมค่าผลผลิต</b></td>
                            <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b>{{ number_format($lines->sum('mat_qty'), 6) }}</b></td>
                            <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b></b></td>
                            <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b></b></td>
                            <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 3px double !important;  "><b>{{ number_format($lines->sum('total_cost'), 2) }}</b></td>
                        </tr>
                    @endforeach
                @endforeach
                @if (count($datas))
                <tr>
                    <td height="5" colspan="13"></td>
                </tr>
                <tr height="20">
                    <td  colspan="2" align="right" style="{{ $font15 }} border-top: 1px solid black !important; border-bottom: 1px solid !important;"><b>รวมค่าวัตถุดิบ</b></td>
                    <td  align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 1px solid !important;  ">{{ number_format($sumTotalCost ?? 0, 2) }}</td>
                    <td  colspan="10" align="right" style="{{ $font15 }}  border-top: 1px solid black !important; border-bottom: 1px solid !important;  "></td>
                </tr>
                @endif
            </tbody>
        </table>
        <table style="margin-top: 30px;">
            <tr>
                <td colspan="4" align="center" width="33.33%">
                    <div><b>หัวหน้ากอง............................................</b></div>
                </td>
                <td colspan="5" align="center" width="33.33%">
                    <div><b>รองผู้จัดการ............................................</b></div>
                </td>
                <td colspan="4" align="center" width="33.33%">
                    <div><b>ผู้จัดการ............................................</b></div>
                </td>
            </tr>
            <tr>
                <td height="30" align="center" colspan="13">
                    <b>จบรายงาน</b>
                </td>
            </tr>
        </table>
    </body>
</html>
