<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    <body>
        @php
            $styleTh = 'border:  1px solid black; line-height: 100px';
            $styleFont16 = 'border:  1px solid black; font-size: 16px';
            $styleFont14 = 'border:  1px solid black; font-size: 14px';
            $font18 = 'font-size: 18px; ';
            $font16 = 'font-size: 16px; ';
            $font14 = 'font-size: 14px; ';
            $border = 'border:  1px solid black; ';
            $fontBold = 'font-weight: bold; ';
            $textUnderline = 'text-decoration: underline; ';
            $lineNo = 0;
        @endphp
        <table border="1">
            <tr>
                <td  align="left"   height="30" colspan="2"  style="{{ $font18 }}"></td>
                <td  align="center" height="30" colspan="3"  style="{{ $font18 }}"><b> {{ $reportData->name }} </b></td>
                <td  align="right"  height="30" colspan="2" style="{{ $font18 }}"> </td>
            </tr>
            <tr>
                <td  align="left"   height="30" colspan="2"  style="{{ $font18 }}"><b>โปรแกรม : </b>&nbsp; {{ request()->program_code }}</td>
                <td  align="center" height="30" colspan="3"  style="{{ $font18 }}"><b> ผลผลิตด้าน {{ $reportData->wip_desc }} </b></td>
                <td  align="right"  height="30" colspan="2" style="{{ $font18 }}"><b>วันที่พิมพ์ : </b> {{ $reportData->date }} </td>
            </tr>
            <tr>
                <td  align="left"   height="30" colspan="2"  style="{{ $font18 }}"></td>
                <td  align="center" height="30" colspan="3"  style="{{ $font18 }}"><b>{{ $reportData->data_range_th }}</b></td>
                <td  align="right" height="30" colspan="2" style="{{ $font18 }}"></td>
            </tr>
            <tr>
                <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>ลำดับที่</b></td>
                <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>รหัส</b></td>
                <td  align="center" height="30"  style="{{ $styleFont16 }}" colspan="2"><b>ตราบุหรี่</b></td>
                <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>ผลผลิตปกติ/มวน</b></td>
                <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>ผลผลิตบุหรี่ล่วงเวลา/มวน</b></td>
                <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>รวม/มวน</b></td>
            </tr>
            @php
                $allProductType = [];
            @endphp
            @foreach ($datas->groupBy('product_size') as $keyProductSize => $products)
                @php
                    $productsFirst = $products->first();
                    $sizeDesc = str_replace("บุหรี่", "", $productsFirst->size_desc);
                    $allProductType[] = $sizeDesc;
                @endphp
                @foreach ($products as $keyProduct => $product)
                <tr>
                    <td align="center" style="{{ $font14 }} {{ $border }}">{{ $keyProduct + 1 }}</td>
                    <td align="center"  style="{{ $font14 }} {{ $border }}">{{ $product->item_code }}</td>
                    <td  style="{{ $font14 }} {{ $border }}" colspan="2">{{ $product->item_desc }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ ($product->regular ?? 0) ? $product->regular : '' }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ ($product->ot ?? 0) ? $product->ot : '' }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ ($product->total ?? 0) ? $product->total : '' }}</td>
                </tr>
                @endforeach
                <tr>
                    <td style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"><b>รวม</b></td>
                    <td colspan="2" style="{{ $font14 }} {{ $border }}"><b>บุหรี่ก้นกรองและตัวอย่าง ขนาด {{ $sizeDesc }}</b></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"><b>{{ $products->sum('regular') }}</b></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"><b>{{ $products->sum('ot') }}</b></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"><b>{{ $products->sum('total') }}</b></td>
                </tr>
                @if ($loop->last)
                <tr>
                    <td style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }} {{ $fontBold }} {{ $textUnderline }}">รวมทั้งหมด</td>
                    <td colspan="2" style="{{ $font14 }} {{ $border }} {{ $fontBold }} {{ $textUnderline }}">บุหรี่ก้นกรองและตัวอย่าง ขนาด {{ \Str::replaceLast(', ', ' และ ', implode(", ", $allProductType)) }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }} {{ $fontBold }} {{ $textUnderline }}">{{ $datas->sum('regular') }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }} {{ $fontBold }} {{ $textUnderline }}">{{ $datas->sum('ot') }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }} {{ $fontBold }} {{ $textUnderline }}">{{ $datas->sum('total') }}</td>
                </tr>
                @endif
            @endforeach

            @if (count($samples))
                @foreach ($samples  as $keySample => $sample)
                <tr>
                    <td align="center" style="{{ $font14 }} {{ $border }}">{{ $keySample + 1 }}</td>
                    <td align="center"  style="{{ $font14 }} {{ $border }}">{{ $sample->item_code }}</td>
                    <td  style="{{ $font14 }} {{ $border }}" colspan="2">{{ $sample->item_desc }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ $sample->sample_qty }}</td>
                </tr>
                @endforeach
                <tr>
                    <td style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"><b>รวม</b></td>
                    <td colspan="2" style="{{ $font14 }} {{ $border }}">บุหรี่ตัวอย่าง</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ $samples->sum('sample_qty') }}</td>
                </tr>
            @endif

            @if (count($free))
                @foreach ($free  as $key => $line)
                <tr>
                    <td align="center" style="{{ $font14 }} {{ $border }}">{{ $key + 1 }}</td>
                    <td align="center"  style="{{ $font14 }} {{ $border }}">{{ $line->item_code }}</td>
                    <td  style="{{ $font14 }} {{ $border }}" colspan="2">{{ $line->item_desc }}</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ $line->transaction_qty }}</td>
                </tr>
                @endforeach
                <tr>
                    <td style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"><b>รวม</b></td>
                    <td colspan="2" style="{{ $font14 }} {{ $border }}">บุหรี่แจก</td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}"></td>
                    <td align="right" style="{{ $font14 }} {{ $border }}">{{ $free->sum('transaction_qty') }}</td>
                </tr>
            @endif
            <tfoot>
                <tr>
                    <td colspan="7"></td>
                </tr>
                <tr>
                    <td ></td>
                    <td height="50" colspan="2" style="text-align: center; {{ $font14 }}">
                        <b>(............................................)</b><br>
                        <b>ผู้บันทึกรายการ</b>
                    </td>
                    <td height="50" colspan="2" style="text-align: center; {{ $font14 }}">
                        <b>(............................................)</b><br>
                        <b>หัวหน้ากอง</b>
                    </td>
                    <td height="50" colspan="2" style="text-align: center; {{ $font14 }}">
                        <b>(............................................)</b><br>
                        <b>ผู้อำนวยการฝ่ายผลิตภัณฑ์สำเร็จรูป</b>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
