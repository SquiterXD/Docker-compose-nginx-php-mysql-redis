<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
        <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew Bold.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        thead{display: table-header-group;}
        tfoot {display: table-row-group;}
        tr {page-break-inside: avoid;}

        body {
            font-family: "THSarabunNew" !important;
        }
        table {
            width:100%;
            border-collapse: collapse;
        }
        td {
            border:none !important;
            /*border: 1px solid #000 !important;*/
        }
        div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }
        .border {
            border-top:1px solid #000 !important;
            border-bottom:1px solid #000 !important;
        }

        tbody tr td {
            line-height: 1.1 !important;
            vertical-align: bottom !important;
        }

        thead tr td {
            line-height: 1.2 !important;
        }

    </style>
    <body style="">
        @php
            $styleTh = 'border:  1px solid black !important; line-height: 100px; ';
            $styleFont16 = 'border:  1px solid black !important; font-size: 16px; font-weight: bold;';
            $styleFont14 = 'border:  1px solid black !important; font-size: 14px; ';
            $font18 = 'font-size: 18px; ';
            $font16 = 'font-size: 16px; ';
            $font14 = 'font-size: 14px; ';
            $border = 'border:  1px solid black !important; ';
            $borderLR = 'border-left:  1px solid black !important; border-right:  1px solid black !important; ';
            // $fontWeight = "font-weight: bold; ";
            $lineNo = 0;
        @endphp
        <table style="padding-top: 20px;">
            <thead>
                <tr>
                    <td><b>บุหรี่ทั้งหมด</b></td>
                </tr>
                <tr>
                    <td  align="center" rowspan="3"  style="{{ $styleFont16 }}">วันที่</td>
                    <td  align="center" colspan="10" style="{{ $styleFont16 }}">ผลผลิตบุหรี่ด้าน {{ $wipStep->wip_step_desc }}</td>
                </tr>
                <tr>
                    <td  align="center" rowspan="2"  style="{{ $styleFont16 }}">ตราบุหรี่</td>
                    <td  align="center" colspan="2" style="{{ $styleFont16 }}">ผลผลิตปกติ</td>
                    <td  align="center" colspan="4" style="{{ $styleFont16 }}">ผลผลิตล่วงเวลา</td>
                    <td  align="center" colspan="3" style="{{ $styleFont16 }}">รวมผลผลิต</td>
                </tr>
                <tr>
                    <td  align="center" style="{{ $styleFont16 }}">7.30-<br>11.30 น.<br>(มวน)</td>
                    <td  align="center" style="{{ $styleFont16 }}">12.30-<br>16.30 น.<br>(มวน)</td>
                    <td  align="center" style="{{ $styleFont16 }}">7.30-<br>11.30 น.<br>(มวน)</td>
                    <td  align="center" style="{{ $styleFont16 }}">11.30-<br>12.30 น.<br>(มวน)</td>
                    <td  align="center" style="{{ $styleFont16 }}">12.30-<br>16.30 น.<br>(มวน)</td>
                    <td  align="center" style="{{ $styleFont16 }}">16.30-<br>20.30 น.<br>(มวน)</td>
                    <td  align="center" style="{{ $styleFont16 }}">ปกติ<br>(มวน)</td>
                    <td  align="center" style="{{ $styleFont16 }}">ล่วงเวลา<br>(มวน)</td>
                    <td  align="center" style="{{ $styleFont16 }}">รวม<br>(มวน)</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas->groupBy('product_date_char') as $productDateChar => $dates)
                    @foreach ($dates->sortBy('item_code') as $line)
                        <tr>
                            <td align="center" style="{{ $font14 }} {{ $borderLR }}" >
                                @if ($loop->first)
                                    {{ parseToDateTh($productDateChar) }}
                                @endif
                            </td>
                            <td align="left" style="{{ $font14 }} {{ $borderLR }}"> {{ $line->item_desc }}</td>
                            <td align="right" style="{{ $font14 }} {{ $borderLR }}">{{ ($line->t0730_1130 ?? 0) ? number_format($line->t0730_1130 ?? 0) : '' }}</td>
                            <td align="right" style="{{ $font14 }} {{ $borderLR }}">{{ ($line->t1230_1630 ?? 0) ? number_format($line->t1230_1630 ?? 0) : '' }}</td>
                            <td align="right" style="{{ $font14 }} {{ $borderLR }}"></td>
                            <td align="right" style="{{ $font14 }} {{ $borderLR }}">{{ ($line->t1130_1230 ?? 0) ? number_format($line->t1130_1230 ?? 0) : '' }}</td>
                            <td align="right" style="{{ $font14 }} {{ $borderLR }}"></td>
                            <td align="right" style="{{ $font14 }} {{ $borderLR }}">{{ ($line->t1630_2030 ?? 0) ? number_format($line->t1630_2030 ?? 0) : '' }}</td>
                            <td align="right" style="{{ $font14 }} {{ $borderLR }}">{{ ($line->regular ?? 0) ? number_format($line->regular ?? 0) : '' }}</td>
                            <td align="right" style="{{ $font14 }} {{ $borderLR }}">{{ ($line->ot ?? 0) ? number_format($line->ot ?? 0) : '' }}</td>
                            <td align="right" style="{{ $font14 }} {{ $borderLR }}">{{ ($line->total ?? 0) ? number_format($line->total ?? 0) : '' }}</td>
                        </tr>
                    @endforeach
                @endforeach
                @foreach ($summary as $key => $items)
                    @php
                        $itemDesc = $items->item_desc;
                        $sum_t0730_1130 = $items->t0730_1130;
                        $sum_t1230_1630 = $items->t1230_1630;
                        $sum_t1130_1230 = $items->t1130_1230;
                        $sum_t1630_2030 = $items->t1630_2030;
                        $sum_regular = $items->regular;
                        $sum_ot = $items->ot;
                        $sum_total = $items->total;
                    @endphp
                    <tr>
                        <td align="left" style="{{ $font14 }} {{ $border }}" colspan="2" >
                           {{ $itemDesc }}
                        </td>
                        <td align="right" style="{{ $font14 }} {{ $border }}">{{ ($sum_t0730_1130 ?? 0) ? number_format($sum_t0730_1130) : '' }}</td>
                        <td align="right" style="{{ $font14 }} {{ $border }}">{{ ($sum_t1230_1630 ?? 0) ? number_format($sum_t1230_1630) : '' }}</td>
                        <td align="right" style="{{ $font14 }} {{ $border }}"></td>
                        <td align="right" style="{{ $font14 }} {{ $border }}">{{ ($sum_t1130_1230 ?? 0) ? number_format($sum_t1130_1230) : '' }}</td>
                        <td align="right" style="{{ $font14 }} {{ $border }}"></td>
                        <td align="right" style="{{ $font14 }} {{ $border }}">{{ ($sum_t1630_2030 ?? 0) ? number_format($sum_t1630_2030) : '' }}</td>
                        <td align="right" style="{{ $font14 }} {{ $border }}">{{ ($sum_regular ?? 0) ? number_format($sum_regular) : '' }}</td>
                        <td align="right" style="{{ $font14 }} {{ $border }}">{{ ($sum_ot ?? 0) ? number_format($sum_ot) : '' }}</td>
                        <td align="right" style="{{ $font14 }} {{ $border }}">{{ ($sum_total ?? 0) ? number_format($sum_total) : '' }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td align="center" style="{{ $font14 }} {{ $border }}" colspan="2" >
                        รวมทั้งสิ้น
                    </td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ number_format($summary->sum('t0730_1130') ?? 0) }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ number_format($summary->sum('t1230_1630') ?? 0) }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ number_format(0) }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ number_format($summary->sum('t1130_1230') ?? 0) }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ number_format(0) }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ number_format($summary->sum('t1630_2030') ?? 0) }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ number_format($summary->sum('regular') ?? 0) }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ number_format($summary->sum('ot') ?? 0) }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ number_format($summary->sum('total') ?? 0) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11">
                        <table border="0">
                            <tr>
                                <td width="10%" ></td>
                                <td width="80%" style="" align="center">
                                    <br><br>
                                    <table border="0">
                                        <tr>
                                            <td width="33.33%" align="center">
                                                <div><b>(............................................)</b></div>
                                                <div><b>ผู้บันทึกรายการ</b></div
                                            </td>
                                            <td width="33.33%" align="center">
                                                <div><b>(............................................)</b></div></div>
                                                <div><b>หัวหน้ากอง</b></div
                                            </td>
                                            <td width="33.33%" align="center">
                                                <div><b>(............................................)</b></div>
                                                <div><b>ผู้อำนวยการฝ่ายโรงงานผลิตยาสูบ</b></div
                                            </td>
                                        </tr>
                                    </table>
                                    <br><br>
                                    <b>จบรายงาน</b>
                                </td>
                                <td width="10%"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
