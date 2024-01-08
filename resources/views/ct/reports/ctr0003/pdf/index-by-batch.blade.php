<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
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
</head>

<body>
    @php
        $styleTh = 'border: 1px solid black !important;; line-height: 100px';
        $styleFont16= 'border: 1px solid black !important;; font-size: 16px';
        $styleFont18= 'border: 1px solid black !important;; font-size: 18px ' ;
        $styleFont14 = 'border: 1px solid black !important;; font-size: 14px';
        $font18 = 'font-size: 18px';
        $font16= 'font-size: 16px';
        $font14 = 'font-size: 14px';
        $styleBorderLRFont14 = 'border-left: 1px solid black; border-right: 1px solid black; font-size: 14px';
        $styleBorderLRFTont14 = 'border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;  font-size: 14px';
        $styleBorderLRBTFont14 = 'border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; font-size: 14px';
        $uData = [];
        $sysdate = Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i');
    @endphp
@foreach ($datas_level_1->groupBy('batch_no') as $batchNo => $dataByBatchs)
@php
    $dataBatch = $dataByBatchs->first();
    $sumBatchAQ = 0;
    $sumBatchAQSP = 0;
    $checkBatch = $datas_level_2->where('batch_no', $batchNo);
    if( !$checkBatch->count() ){
        continue;
    }
@endphp
    <div style="page-break-after:always; "> </div>

    <table width="100%">
        <thead border="0">
            <tr>
                <td colspan="8">
                    <table width="100%" >
                        <tr>
                            <td width="33%" align="left" style="{{ $font18 }}"><b> โปรแกรม : CTR0003 </b></td>
                            <td width="33%" align="center"  style="{{ $font18 }}"><b> การยาสูบแห่งประเทศไทย</b></td>
                            <td width="33%" style="{{ $font18 }}" align="right"><b>วันที่พิมพ์ : </b> {{ $sysdate }}  </td>
                        </tr>
                        <tr>
                            <td width="33%" align="left" style="{{ $font18 }}"><b> พิมพ์โดย : </b> {{$userProfile->user_name }} </td>
                            <td width="33%" align="center"  style="{{ $font18 }}"><b> กระดาษทำการคำนวณค่าวัตถุดิบ-คิดเข้างาน - แยกตามคำสั่งผลิต </b></td>
                            <td width="33%" style="{{ $font18 }}" align="right"><b>หน้าที่ :</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="33%" align="left" style="{{ $font18 }}">  </td>
                            <td width="33%" align="center"  style="{{ $font18 }}"><b> {{ ctDateText($dateFrom , $dateTo) }} </b></td>
                            <td width="33%" style="{{ $font18 }}"></td>
                        </tr>
                        <tr>
                            <td width="33%" align="left" style="{{ $font18 }}">  </td>
                            <td width="33%" align="center"  style="{{ $font18 }}"><b> {{ 'ศูนย์ต้นทุน '. $cost->cost_code. ' ' . $cost->description }} </b></td>
                            <td width="33%" style="{{ $font18 }}"></td>
                        </tr>
                        <tr>
                            <td width="33%" align="left" style="{{ $font18 }}" colspan="2"><b>หน่วยงาน :  {{ $cost->dept_code. ' ' . $cost->dept_code_desc}}</b></td>
                            <td width="33%" style="{{ $font18 }}"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th style="{{ $styleFont16 }}" align="center" rowspan="3"><b> รหัส </b> </th>
                <th style="{{ $styleFont16 }}" align="center" rowspan="3"><b> รายละเอียด </b> </th>
                <th style="{{ $styleFont16 }}" align="center" rowspan="3"><b> คำสั่งผลิต </b> </th>
                <th style="{{ $styleFont16 }}" align="center" rowspan="3"><b> หน่วยนับ </b> </th>
                <th style="{{ $styleFont16 }}" align="center"><b> ปริมาณผลผลิต </b> </th>
                <th style="{{ $styleFont16 }}" align="center" colspan="3"><b> ค่าวัตถุดิบ-คิดเข้างาน </b> </th>
            </tr>
            <tr>
                <th style="{{ $styleFont16 }}" align="center" rowspan="2"><b> (Output) </b> </th>
                <th style="{{ $styleFont16 }}" align="center"><b> ปริมาณ </b> </th>
                <th style="{{ $styleFont16 }}" align="center"><b> ราคาต่อหน่วย(บาท) </b> </th>
                <th style="{{ $styleFont16 }}" align="center"><b> ต้นทุน (บาท) </b> </th>
            </tr>
            <tr>
                <th style="{{ $styleFont16 }}" align="center"><b> AQ. </b></th>
                <th style="{{ $styleFont16 }}" align="center"><b> SP. </b></th>
                <th style="{{ $styleFont16 }}" align="center"><b> AQ.*SP </b></th>
            </tr>
        </thead>

        <tbody>
                <tr>
                    <td style="{{ $styleFont16 }}" align="left"><b> {{ optional($dataBatch)->item_number }} </b></td>
                    <td style="{{ $styleFont16 }}" align="left"><b> {{ optional($dataBatch)->item_description }} </b></td>
                    <td style="{{ $styleFont16 }}" align="left"><b> {{ $batchNo }} </b></td>
                    <td style="{{ $styleFont16 }}" align="left"><b> {{ optional($dataBatch)->transaction_uom }} </b></td>
                    <td style="{{ $styleFont16 }}"></td>
                    <td style="{{ $styleFont16 }}"></td>
                    <td style="{{ $styleFont16 }}"></td>
                    <td style="{{ $styleFont16 }}"></td>
                </tr>

                @foreach ($dataByBatchs->sortBy('wip_step')->groupBy('wip_step') as $wip => $dataByWip)
                    @php
                        $dataWip = $dataByWip->first();
                        $sumWipAQ = 0;
                        $sumWipAQSP = 0;
                        $checkWip = $checkBatch->where('wip_step', $wip);
                        if( !$checkWip->count() ){
                            continue;
                        }
                    @endphp
                    <tr>
                        <td style="{{ $styleFont16 }}" align="left"><b> {{ $wip }} {{ optional($dataWip)->wip_desc }} </b></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}" align="right"><b> {{ number_format($dataWip->transaction_quantity ?? 0, 6) }} </b></td> {{-- output --}}
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                    </tr>
                    @foreach ($datas_level_2->where('batch_no', $batchNo)->where('wip_step', $wip)->sortBy('tobacco_group_code')->groupBy('tobacco_group_code') as $tobaccoGroupCode => $dataByGroupCode)
                        @php
                            $dataGroupCode = $dataByGroupCode->first();
                            $sumAQ = 0;
                            $sumAQSP = 0;
                        @endphp
                        <tr>
                            <td style="{{ $styleFont16 }}" align="left"><b> {{ $tobaccoGroupCode }} </b></td>
                            <td style="{{ $styleFont16 }}" align="left"><b> {{ optional($dataGroupCode)->tobacco_group }} </b> </td>
                            <td style="{{ $styleFont16 }}"></td>
                            <td style="{{ $styleFont16 }}"></td>
                            <td style="{{ $styleFont16 }}"></td>
                            <td style="{{ $styleFont16 }}"></td>
                            <td style="{{ $styleFont16 }}"></td>
                            <td style="{{ $styleFont16 }}"></td>
                        </tr>
                        @foreach ($dataByGroupCode->sortBy('item_number') as $data)
                            @php
                                $sumAQ += $data->ingredient_quantity;
                                $sumAQSP += $data->ingredient_amount;
                            @endphp
                            <tr>
                                <td style="{{ $styleFont14 }}" align="left"> {{ $data->item_number }} </td>
                                <td style="{{ $styleFont14 }}" align="left"> {{ $data->item_description }} </td>
                                <td style="{{ $styleFont14 }}"></td>
                                <td style="{{ $styleFont14 }}"> {{ $data->transaction_uom }} </td>
                                <td style="{{ $styleFont14 }}"></td>
                                <td style="{{ $styleFont14 }}" align="right"> {{ number_format($data->ingredient_quantity ?? 0, 6) }} </td> {{-- AQ --}}
                                <td style="{{ $styleFont14 }}" align="right"> {{ number_format($data->ingredient_cost ?? 0, 9) }} </td> {{-- SP --}}
                                <td style="{{ $styleFont14 }}" align="right">{{ number_format($data->ingredient_amount ?? 0, 2) }} </td> {{-- AQ*SP --}}
                            </tr>
                            @if ($loop->last)
                                @php
                                    $sumWipAQ += $sumAQ;
                                    $sumWipAQSP += $sumAQSP;
                                @endphp
                                <tr>
                                    <td colspan="2" align="center" style="{{ $styleFont18 }}"><b>รวม {{ $tobaccoGroupCode }} {{ optional($dataGroupCode)->tobacco_group }}</b> </td>
                                    <td style="{{ $styleFont16 }}"></td>
                                    <td style="{{ $styleFont16 }}"></td>
                                    <td style="{{ $styleFont16 }}"></td>
                                    <td style="{{ $styleFont16 }}" align="right"><b> {{ number_format($sumAQ ?? 0, 9) }}</b> </td>
                                    <td style="{{ $styleFont16 }}"></td>
                                    <td style="{{ $styleFont16 }}" align="right"><b> {{ number_format($sumAQSP ?? 0, 2) }} </b> </td>
                                </tr>
                            @endif
                        @endforeach
                        @if ($loop->last)
                            @php
                                $sumBatchAQ += $sumWipAQ;
                                $sumBatchAQSP += $sumWipAQSP;
                            @endphp
                            <tr>
                                <td colspan="2" align="center" style="{{ $styleFont18 }}"><b> รวมตาม {{ $wip }} {{ optional($dataWip)->wip_desc }}</b></td>
                                <td style="{{ $styleFont16 }}"></td>
                                <td style="{{ $styleFont16 }}"></td>
                                <td style="{{ $styleFont16 }}"></td>
                                <td style="{{ $styleFont16 }}" align="right"><b> {{ number_format($sumWipAQ ?? 0, 9) }} </b></td>
                                <td style="{{ $styleFont16 }}"></td>
                                <td style="{{ $styleFont16 }}" align="right"><b> {{ number_format($sumWipAQSP ?? 0, 2) }} </b> </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
                <tr>
                    <td colspan="2" align="center" style="{{ $styleFont18 }}"><b>รวมตามคำสั่งผลิต {{ $batchNo }}</b> </td>
                    <td style="{{ $styleFont16 }}"></td>
                    <td style="{{ $styleFont16 }}"></td>
                    <td style="{{ $styleFont16 }}"></td>
                    <td style="{{ $styleFont16 }}" align="right"><b> {{ number_format($sumBatchAQ ?? 0, 9) }}  </b> </td>
                    <td style="{{ $styleFont16 }}"></td>
                    <td style="{{ $styleFont16 }}" align="right"><b> {{ number_format($sumBatchAQSP ?? 0, 2) }} </b> </td>
                </tr>
        </tbody>
    </table>
@endforeach
</body>

</html>
