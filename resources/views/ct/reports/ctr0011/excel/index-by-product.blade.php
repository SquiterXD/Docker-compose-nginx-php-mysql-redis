<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}

</head>

<body>
    @php
        $styleTh = 'border:  1px solid black; line-height: 100px';
        $styleFont16 = 'border:  1px solid black; font-size: 16px';
        $styleFont14 = 'border:  1px solid black; font-size: 14px';
        $font18 = 'font-size: 18px; ';
        $font16 = 'font-size: 16px; ';
        $font14 = 'font-size: 14px; ';
        $fontBold = ' font-weight: bold;';
        $bTbB = 'border-top:  1px solid black; border-bottom:  1px solid black; ';

        $styleBorderLRFont14 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 14px';
        $styleBorderLRFTont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 14px';
        $styleBorderLRBTFont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 14px';
        $styleBorderLRFont16 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 16px';
        $styleBorderLRFTont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 16px';
        $styleBorderLRBTFont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 16px';
        $styleBorderTBFont16 = 'border-top:  1px solid black; border-bottom:  1px solid black; font-size: 16px; ';
        $uData = [];
        $sysdate = Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i');
    @endphp
<table width="100%" border="1">
    <thead>
        <tr>
            <th colspan="2"></th>
            <th align="center" colspan="10" style="{{ $font18 . $fontBold  }}">การยาสูบแห่งประเทศไทย</th>
            <th></th>
            <th></th>
        </tr>
        <tr >
            <th colspan="2" style="{{ $font18 . $fontBold  }}">รหัสโปรแกรม : {{ data_get($data->report_header, 'program_code') }}</th>
            <th align="center" colspan="10" style="{{ $font18 . $fontBold  }}">{{ data_get($data->report_header, 'report_name') }}</th>
            <th align="right" style="{{ $font18 . $fontBold  }}">วันที่พิมพ์ :</th>
            <th style="{{ $font18 . $fontBold  }}">{{ $sysdate }}</th>
        </tr>
        <tr>
            <th colspan="2" style="{{ $font18 . $fontBold  }}">ศูนย์ต้นทุน : {{ data_get($data->cost_code_data, 'cost_code') }} {{ data_get($data->cost_code_data, 'description') }} </th>
            <th align="center" colspan="10" style="{{ $font18 . $fontBold  }}">ณ วันที่ : {{  data_get($data->period, 'thai_date', '-') }} </th>
        </tr>

        <tr>
            <th align="center" rowspan="2" style="{{ $styleBorderTBFont16 . $fontBold }}">หน่วยงาน</th>
            <th align="center" rowspan="2" style="{{ $styleBorderTBFont16 . $fontBold }}">ผลิตภัณฑ์</th>
            <th align="center" rowspan="2" colspan="3" style="{{ $styleBorderTBFont16 . $fontBold }}">รายละเอียด</th>
            {{-- <th align="center" rowspan="2" style="{{ $styleBorderTBFont16 . $fontBold }}">เลขที่คำสั่งผลิต</th> --}}
            {{-- <th align="center" rowspan="2" style="{{ $styleBorderTBFont16 . $fontBold }}">ขั้นตอน</th> --}}
            <th align="center" rowspan="2" style="{{ $styleBorderTBFont16 . $fontBold }}">Org.</th>

            <th align="center" colspan="6" style="{{ $styleBorderTBFont16 . $fontBold }}">ใบยาระหว่างผลิต</th>
            <th align="center" rowspan="2" style="{{ $styleBorderTBFont16 . $fontBold }}">รวม</th>
            <th align="center" rowspan="2" style="{{ $styleBorderTBFont16 . $fontBold }}">เฉลี่ยต่อหน่วย</th>
        </tr>
        <tr>
            <th align="right" style="{{ $styleBorderTBFont16 . $fontBold }}">ผลผลิตที่ได้</th>
            <th align="right" style="{{ $styleBorderTBFont16 . $fontBold }}">ปริมาณวัตถุดิบ</th>
            <th align="right" style="{{ $styleBorderTBFont16 . $fontBold }}">วัตถุดิบ</th>
            <th align="right" style="{{ $styleBorderTBFont16 . $fontBold }}">ค่าแรง</th>
            <th align="right" style="{{ $styleBorderTBFont16 . $fontBold }}">ค่าใช้จ่ายผันแปร</th>
            <th align="right" style="{{ $styleBorderTBFont16 . $fontBold }}">ค่าใช้จ่ายคงที่</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data->lines as $line)
            <tr >
                <td style="{{ $font16  }}"></td>
                <td align="left" style="{{ $font16  }}">{{ $line->product_item_number }}</td>
                <td colspan="3" style="{{ $font16  }}">{{ $line->product_item_desc }}</td>
                {{-- <td style="{{ $font16  }}">{{ $line->batch_no }}</td> --}}
                {{-- <td style="{{ $font16  }}">{{ $line->oprn_code }} {{ $line->oprn_desc }}</td> --}}
                <td style="{{ $font16  }}"></td>
                <td style="{{ $font16  }}">{{ $line->sum_tran_qty }}</td>
                <td style="{{ $font16  }}">{{ $line->sum_qty }}</td>
                <td style="{{ $font16  }}">{{ $line->sum_cost }}</td>
                <td style="{{ $font16  }}">{{ $line->wage_cost }}</td>
                <td style="{{ $font16  }}">{{ $line->vary_cost }}</td>
                <td style="{{ $font16  }}">{{ $line->fixed_cost }}</td>
                <td style="{{ $font16  }}">{{ $line->sum_all }}</td>
                <td style="{{ $font16  }}">{{ $line->avg_per_unit }}</td>
            </tr>
            @foreach ($line->organizations as $org)
                <tr>
                    <td colspan="5" style="{{ $font16  }}"></td>
                    <td  style="{{ $font16  }}">{{ $org->organization_format }}</td>
                    <td  style="{{ $font16  }}"></td>
                    <td  style="{{ $font16  }}">{{ $org->qty }}</td>
                    <td  style="{{ $font16  }}">{{ $org->cost }}</td>
                    <td colspan="6" style="{{ $font16   }}"></td>
                </tr>
            @endforeach
            <tr >
                <td colspan="6" align="left" style="{{ $font16 . $fontBold . $bTbB  }}">รวมตามผลิตภัณฑ์ {{ $line->product_item_number .' '. $line->product_item_desc }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}" >{{ data_get($data->summary->product, "$line->product_item_number.sum_tran_qty") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}" >{{ data_get($data->summary->product, "$line->product_item_number.sum_qty") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}" >{{ data_get($data->summary->product, "$line->product_item_number.sum_cost") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}" >{{ data_get($data->summary->product, "$line->product_item_number.wage_cost") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}" >{{ data_get($data->summary->product, "$line->product_item_number.vary_cost") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}" >{{ data_get($data->summary->product, "$line->product_item_number.fixed_cost") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}" >{{ data_get($data->summary->product, "$line->product_item_number.sum_all") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}" >{{ data_get($data->summary->product, "$line->product_item_number.avg_per_unit") }}</td>
            </tr>
        @endforeach
        @foreach (data_get($data->summary, 'cost_code', []) as $key => $costCode)
            <tr >
                <td colspan="6" align="left" style="{{ $font16 . $fontBold . $bTbB  }}">รวมตามศูนย์ต้นทุน {{ $key  .' '. $costCode->description }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}">{{ data_get($costCode, "sum_tran_qty") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}">{{ data_get($costCode, "sum_qty") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}">{{ data_get($costCode, "sum_cost") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}">{{ data_get($costCode, "wage_cost") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}">{{ data_get($costCode, "vary_cost") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}">{{ data_get($costCode, "fixed_cost") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}">{{ data_get($costCode, "sum_all") }}</td>
                <td style="{{ $font16 . $fontBold . $bTbB  }}">{{ data_get($costCode, "avg_per_unit") }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
