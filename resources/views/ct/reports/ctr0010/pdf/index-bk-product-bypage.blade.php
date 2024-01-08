<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
    <style>
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
            /*border: 1px solid black !important;*/
        }
        div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }
        tbody
        {
            page-break-after: always;
            page-break-inside: avoid;
            /*color: blueviolet !important;*/
        }
        .border {
            border-top:1px solid #000 !important;
            border-bottom:1px solid #000 !important;
        }

    </style>
</head>

<body>
    @php
        $styleTh = 'border:  1px solid black; line-height: 100px';
        $styleFont16 = 'border:  1px solid black; font-size: 16px';
        $styleFont14 = 'border:  1px solid black; font-size: 14px';
        $font18 = 'font-size: 18px';
        $font16 = 'font-size: 16px';
        $font14 = 'font-size: 14px';
        $styleBorderLRFont14 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 14px';
        $styleBorderLRFTont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 14px';
        $styleBorderLRBTFont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 14px';
        $styleBorderLRFont16 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 16px';
        $styleBorderLRFTont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 16px';
        $styleBorderLRBTFont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 16px';
        $styleBorderTBFont16 = 'border-top:  1px solid black; border-bottom:  1px solid black; font-size: 16px';
        $uData = [];
        // dd('xxxxxxxxxxxxxxxxxxxxxxxxx');
    @endphp
@foreach ($datas->sortBy('product_item_number')->groupBy('product_item_number') as $productItemNumber => $groupProducts)
<div style="page-break-after:always;  border: 0px solid #000;">
    <table>
        <thead>
            <tr>
                <td colspan="7">
                    <table  width="100%"  style="background-color: salmon;">
                        <thead>
                            <tr>
                                <td width="33%"  align="left"  style="{{ $font18 }}"><b>โปรแกรม : </b>  CTR0010</td>
                                <td width="33%"  align="center"  style="{{ $font18 }}"><b> การยาสูบแห่งประเทศไทย </b></td>
                                <td width="33%"  align="right" valign="top"  style="{{ $font18 }}"><b> วันที่พิมพ์ : </b> {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }} </td>
                            </tr>
                            <tr>
                                <td width="33%"  align="left"    style="{{ $font18 }}"></td>
                                <td width="33%"  align="center"  style="{{ $font18 }}"><b> รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามผลิตภัณฑ์ </b></td>
                                <td width="33%"  align="center"  style="{{ $font18 }}"> </td>
                            </tr>
                            <tr>
                                <td width="33%"  align="left"     style="{{ $font18 }}"><b> {{  'ศูนย์ต้นทุน '. $cost->cost_code. ' ' . $cost->description  }}</b></td>
                                <td width="33%"  align="center"  style="{{ $font18 }}"><b> {{ ctDateText($dateFrom , $dateTo) }}  </b></td>
                                <td width="33%"  align="center"  style="{{ $font18 }}"> </td>
                            </tr>
                            <tr>
                                <td  align="left" style="{{ $font18 }}" colspan="3"><b>หน่วยงาน : </b> {{ $cost->dept_code. ' ' . $cost->dept_code_desc}}  </td>
                            </tr>
                        </thead>
                    </table>
                </td>
            </tr>
            {{-- <tr>
                <td  align="left"     style="{{ $font18 }}"><b>โปรแกรม : </b>  CTR0010</td>
                <td  align="center" colspan="5"  style="{{ $font18 }}"><b> การยาสูบแห่งประเทศไทย </b></td>
                <td  align="center"  style="{{ $font18 }}"><b> วันที่พิมพ์ : </b> {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }} </td>
            </tr>
            <tr>
                <td  align="left"     style="{{ $font18 }}"></td>
                <td  align="center" colspan="5"  style="{{ $font18 }}"><b> รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามผลิตภัณฑ์ </b></td>
                <td  align="center"  style="{{ $font18 }}"> </td>
            </tr>
            <tr>
                <td  align="left"     style="{{ $font18 }}"><b> {{  'ศูนย์ต้นทุน '. $cost->cost_code. ' ' . $cost->description  }}</b></td>
                <td  align="center" colspan="5"  style="{{ $font18 }}"><b> {{ ctDateText($dateFrom , $dateTo) }}  </b></td>
                <td  align="center"  style="{{ $font18 }}"> </td>
            </tr>
            <tr>
                <td  align="left" style="{{ $font18 }}" colspan="7"><b>หน่วยงาน : </b> {{ $cost->dept_code. ' ' . $cost->dept_code_desc}}  </td>
        <tbody style="background-color: {{  '#' . dechex(rand(0x000000, 0xFFFFFF)) }}; page-break-after: always !important;">
            </tr> --}}
        </thead>
        {{-- <tbody > --}}
        <tbody style="background-color: {{  '#' . dechex(rand(0x000000, 0xFFFFFF)) }};">
            <tr >
                <td  align="left"   colspan="2"  style="{{ $font18 }}"><b>  กลุ่มผลิตภัณฑ์  {{ $groupProducts[0]->product_group_desc }} </b></td>
                <td  align="left" colspan="4"  style="{{ $font18 }}"><b> รหัสผลิตภัณฑ์ : {{$groupProducts[0]->product_item_number}} {{ $groupProducts[0]->product_item_desc }}  </b></td>
                <td  align="center"  style="{{ $font18 }}"> จำนวนที่ผลิต :  {{ number_format($datas->first()->total_product_qty , 2) }} </td>
            </tr>
            <tr>
                <th align="center" style="{{ $styleBorderTBFont16 }}" rowspan="2"><b>  รหัสวัตถุดิบ </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}" rowspan="2"><b> รายละเอียด </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}" rowspan="2"><b> หน่วยนับ </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}" colspan="3"><b> จริง </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}" rowspan="2"><b> หมายเหตุ </b></th>
            </tr>
            <tr>
                <th align="center" style="{{ $styleBorderTBFont16 }}"><b> จำนวน </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}"><b> ราคา </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}"><b> จำนวนเงิน </b></th>
            </tr>
                @foreach ($groupProducts->sortBy('item_number')->groupBy('item_number') as $itemNumber => $items)
                    <tr>
                        <td style="{{ $font16 }}" align="left"> {{ $itemNumber }} </td>
                        <td style="{{ $font16 }}"> {{ $items[0]->item_desc }} </td>
                        <td style="{{ $font16 }}" align="center"> {{ $items[0]->primary_uom_code }}</td>
                        <td style="{{ $font16 }}"> {{ $items->sum('transaction_quantity') }}</td>
                        <td style="{{ $font16 }}" > {{ $items->sum('transaction_cost') }} </td>
                        <td style="{{ $font16 }}">{{  $items->sum('transaction_amount') }} </td>
                        <td >
                        </td>
                    </tr>
                @endforeach
            {{-- <tr>
                <td style="border-bottom: 1px solid black; font-size: 16px " colspan="2" align="center" ><b>  สรุปการใช้วัตถุดิบ ผลิต ตามศูนย์ต้นทุน: 30 มวน  </b></td>
                <td style="border-bottom: 1px solid black; font-size: 16px " align="center" ><b> ปริมาณจริง </b></td>
                <td style="border-bottom: 1px solid black; font-size: 16px " align="center" ><b> จำนวนเงินจริง </b></td>
                <td></td>
                <td></td>
                <td></td>
            </tr> --}}
            <tr>
                <td style="{{ $styleBorderTBFont16 }}" colspan="3" align="center"> <b> รวม รหัสผลิตภัณฑ์ :  {{ $groupProducts[0]->product_item_desc }}</b> </td>
                <td style="{{ $styleBorderTBFont16 }}"><b></b></td>
                <td style="{{ $styleBorderTBFont16 }}"></td>
                <td style="{{ $styleBorderTBFont16 }}"> <b>{{ $groupProducts->sum('transaction_amount') }} </b></td>
                <td style="{{ $styleBorderTBFont16 }}"></td>
            </tr>
            @foreach ($groupProducts->sortBy('')->groupBy('tobacco_group_code') as $groupCode => $dataBygroup)
                <tr>
                    <td style="{{ $font16 }}"> <b> {{$groupCode}} </b>  </td>
                    <td style="{{ $font16 }}"> <b> {{ $dataBygroup[0]->tobacco_group }} </b></td>
                    <td style="{{ $font16 }}"> <b> {{ $dataBygroup->sum('transaction_quantity')}}</b> </td>
                    <td style="{{ $font16 }}" align="right" ><b>  {{ number_format($dataBygroup->sum('transaction_amount'), 2) }} </b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @if ($loop->last)
                <tr>
                    <td style="border-bottom: 1px solid black "></td>
                    <td style="border-bottom: 1px solid black "> </td>
                    <td style="border-bottom: 1px solid black "></td>
                    <td style="border-bottom: 1px solid black "></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>

</div>
@endforeach

     {{-- <div style="page-break-after:always; position: relative; border: 0px solid #000; height: 1080px;"> --}}

</body>

</html>
