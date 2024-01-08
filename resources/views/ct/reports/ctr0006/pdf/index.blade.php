<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงานรายละเอียดวัตถุดิบใช้ไปจริง</title>
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
            border-collapse: collapse;
            /*page-break-inside: avoid;
            page-break-after: auto;*/
        }

        td {
            /* padding: 3px 25px; */
            line-height: 19px;
        }

        .page-break {
            page-break-after: always;
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
@foreach ($datas->sortBy('transaction_date')->groupBy('transaction_date') as $transaction_date => $groupTransactionDate)
    @foreach ($groupTransactionDate->sortBy('product_item_number')->groupBy('product_item_number') as $product_item_number => $groupByProductItemNumber)
        @foreach ($groupByProductItemNumber->groupBy('batch_no') as $batch_no => $groupByBatch)

        @php
            $months_th = ['01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน', '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม', '09' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'];
            $transaction_date = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $transaction_date); //
            $transactionYear = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $transaction_date)->addYears(543)->format('Y'); //
            $sysdate = now()->addYears(543)->format('d/m/Y H:i');
            $firstLine = $groupByBatch->first();
        @endphp
        @if ($loop->parent->parent->first)
            <div style="page-break-after:always; ">
            </div>
        @else
        @endif
        {{-- <div style="page-break-after:avoid; border: 2px solid #000; background-color: burlywood;"> --}}
        <div style="">
            {{-- <h1>xxxxxx {{  $batch_no }}</h1> --}}
            <table style="width:100%;">
                <thead>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            {{-- <table style="width:100%; border-collapse: collapse">
                                <tr>
                                    <td style="vertical-align: top">
                                        <b>รหัสโปรแกรม</b> : CTR0006 <br>
                                        <b>สั่งพิมพ์</b> :{{ auth()->user()->username }} <br>
                                        <b>หน่วยงาน</b> : {{ $firstLine->dept_code . ' ' . $firstLine->dept_desc }} <br>
                                        <b>ศูนย์ต้นทุน</b> : {{ $firstLine->cost_code }} {{ $firstLine->cost_desc }} <br>
                                        <b>ชื่อสินค้า</b> : {{ $product_item_number . ' ' .   $firstLine->product_item_desc }} <br>
                                        <b>เลขที่คำสั่งผลิต</b> : {{ $batch_no }}
                                    </td>
                                    <td align="center" style="vertical-align: top">
                                        <b>การยาสูบแห่งประเทศไทย</b> <br>
                                        <b>รายงานรายละเอียดวัตถุดิบใช้ไปจริง</b> <br>
                                        <b>ประจำวันที่</b>
                                        : {{ $transaction_date->format('d') }}
                                        {{ $months_th[$transaction_date->format('m')] }}
                                        {{ $transactionYear }}
                                    </td>
                                    <td align="right" style="vertical-align: top">
                                        <b>หน้าที่</b> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
                                        <b>วันที่พิมพ์</b>  :  {{ $sysdate }}
                                    </td>
                                </tr>
                            </table> --}}
                            <div style="height: 120px; width: 33.33%; float: left; border: 0px solid #fff; ;">
                                <span style="width: 100%;float: left; ">
                                    <b>รหัสโปรแกรม</b> : CTR0006 <br>
                                    <b>สั่งพิมพ์</b> :{{ auth()->user()->username }} <br>
                                    <b>หน่วยงาน</b> : {{ $firstLine->dept_code . ' ' . $firstLine->dept_desc }} <br>
                                    <b>ศูนย์ต้นทุน</b> : {{ $firstLine->cost_code }} {{ $firstLine->cost_desc }} <br>
                                    <b>ชื่อสินค้า</b> : <span style="font-size: 14px;"> {{ $product_item_number.' '.$firstLine->product_item_desc }}</span><br>
                                    <b>เลขที่คำสั่งผลิต</b> : {{ $batch_no }}
                                </span>
                            </div>
                            <div style="height: 120px; width: 33.33%; float: left; border: 0px solid #fff; ;">
                                <span style="width: 100%;float: left;  text-align: center;">
                                    <b>การยาสูบแห่งประเทศไทย</b> <br>
                                    <b>รายงานรายละเอียดวัตถุดิบใช้ไปจริง</b> <br>
                                    <b>ประจำวันที่</b>
                                    : {{ $transaction_date->format('d') }}
                                    {{ $months_th[$transaction_date->format('m')] }}
                                    {{ $transactionYear }}
                                </span>
                            </div>
                            <div style="height: 120px; width: 33.33%; float: left; border: 0px solid #fff; ;">
                                <span style="width: 100%;float: left;  text-align: right;">
                                    <b>หน้าที่</b> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
                                    <b>วันที่พิมพ์</b>  :  {{ $sysdate }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr style="font-weight: bold">
                        <th rowspan="2"
                            style="text-align:center; vertical-align: middle;border-top:1px solid #000;border-bottom:1px solid #000">
                            รหัสวัตถุดิบ</th>
                        <th rowspan="2"
                            style="text-align:center; vertical-align: middle;border-top:1px solid #000;border-bottom:1px solid #000">
                            รายละเอียด</th>
                        <th rowspan="2"
                            style="text-align:center; vertical-align: middle;border-top:1px solid #000;border-bottom:1px solid #000">
                            UOM </th>
                        <th colspan="3"
                            style="text-align:center; vertical-align: top;border-top:1px solid #000;border-bottom:1px solid #000">
                            จริง </th>
                        <th rowspan="2"
                            style="text-align:center; vertical-align: middle;border-top:1px solid #000;border-bottom:1px solid #000">
                            %
                            สูญเสีย </th>
                    </tr>
                    <tr>
                        <th style="border-bottom:1px solid #000;width:150px;text-align:center;">จำนวน</th>
                        <th style="border-bottom:1px solid #000;width:150px;text-align:center;">ราคา</th>
                        <th style="border-bottom:1px solid #000;width:150px;text-align:center;">จำนวนเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupByBatch->sortBy('oprn_class_desc')->groupBy('oprn_class_desc') as $wipStep => $groupByWip)
                        <tr>
                            <td colspan="2">
                                <b> ขั้นตอน</b> :{{ $wipStep }} - {{ $groupByWip->first()->oprn_desc }}
                            </td>
                        </tr>
                        @foreach ($groupByWip->sortBy('request_number')->groupBy('request_number') as $request_number => $groupRequestNumber)
                            {{-- {{dump($groupRequestNumber)}} --}}
                            <tr>
                                <td colspan="2">
                                    <b> เลขที่ใบเบิก</b> :{{ $request_number }}
                                </td>
                                <td style="white-space: nowrap;"><b> จำนวนที่ผลิตได้</b> : </td>
                                <td style="white-space: nowrap;">
                                    &nbsp;{{ number_format($groupRequestNumber->first()->opt_plan_qty, 6) }}</td>
                                <td style="white-space: nowrap;"><b> UOM :</b>
                                    {{ $groupRequestNumber->first()->primary_unit_of_measure }}</td>
                                <td style="white-space: nowrap;"><b> ราคาต่อหน่วย :</b></td>
                                <td style="white-space: nowrap; text-align: right;">
                                    {{number_format($groupRequestNumber->first()->std_cost, 9)}}
                                </td>
                            </tr>
                            @php
                                $transaction_amount = 0;
                            @endphp
                            @foreach ($groupRequestNumber->sortBy('item_number') as $item)
                                @php
                                    $transaction_amount += $item->transaction_amount;
                                @endphp
                                <tr>
                                    <td stlye="padding:5px 2px; text-align:center">
                                        {{ $item->item_number }}
                                    </td>
                                    <td style="white-space: nowrap">
                                        {{ $item->item_desc }}
                                    </td>
                                    <td style="text-align:center">{{ $item->th_detail_unit_of_measure }}</td>
                                    <td style="text-align:right">
                                        {{ number_format($item->transaction_quantity, 6) }}</td>
                                    <td style="text-align:right">{{ number_format($item->transaction_cost, 9) }}
                                    </td>
                                    <td style="text-align:right">{{ number_format($item->transaction_amount, 2) }}
                                    </td>
                                    <td style="text-align:right">{{ number_format(0, 2) }}</td>
                                </tr>
                            @endforeach
                            {{-- end for items --}}
                            <tr>
                                <td colspan="4" style="border-top:1px solid #000; border-bottom:1px solid #000">
                                </td>
                                <td style="border-top:1px solid #000; border-bottom:1px solid #000"><b> รวม</b>
                                </td>
                                <td align="right" style="border-top:1px solid #000; border-bottom:1px solid #000">
                                    {{ number_format($transaction_amount, 2) }}</td>
                                <td colspan="4" style="border-top:1px solid #000; border-bottom:1px solid #000">
                                </td>
                            </tr>
                        @endforeach
                        {{-- end Group By request_number --}}
                    @endforeach
                    {{-- end Group by Wip step --}}

                    <tr>
                        <td colspan="3" style="border-top:1px solid #000; border-bottom:1px solid #000">
                            สรุปการใช้วัตถุดิบ ผลิต ตามเลขที่คำสั่งผลิต  :  {{ $batch_no }}</td>
                        <td style="border-top:1px solid #000; border-bottom:1px solid #000;text-align:right;">ปริมาณจริง</td>
                        <td style="border-top:1px solid #000; border-bottom:1px solid #000;text-align:right;">จำนวนเงินจริง</td>
                    </tr>
                    @foreach ($groupByBatch->sortBy('oprn_class_desc')->groupBy('oprn_class_desc') as $wipStep => $groupByWip)
                        <tr>
                            <td colspan="5" style="border-top:1px solid #000; border-bottom:1px solid #000">ขั้นตอน  :
                                {{ $wipStep }} - {{ $groupByWip->first()->oprn_desc }}</td>
                        </tr>
                        @foreach ($groupByWip->sortBy('tobacco_group_code')->groupBy('tobacco_group_code') as $tobaccoGroupCode => $groupByTobacco)
                            @if ($loop->last)
                                <tr style="">
                                    <td colspan="3" style="border-bottom:1px solid #000">
                                        {{ $groupByTobacco->first()->tobacco_group }}</td>
                                    <td style="border-bottom:1px solid #000;text-align:right;">
                                        {{ number_format($groupByTobacco->sum('transaction_quantity'),2) }}</td>
                                    <td style="border-bottom:1px solid #000;text-align:right;">
                                        {{ number_format($groupByTobacco->sum('transaction_amount'), 2) }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="3">{{ $groupByTobacco->first()->tobacco_group }}</td>
                                    <td style="text-align:right;">{{ number_format($groupByTobacco->sum('transaction_quantity'), 2) }}</td>
                                    <td style="text-align:right;">{{ number_format($groupByTobacco->sum('transaction_amount'), 2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                        {{-- end group Tobacco Group --}}
                    @endforeach
                    {{-- endwip //2 --}}
                </tbody>
            </table>
        </div>
        @if ($loop->last)
            {{-- <div style="page-break-after:always; ">xx</div> --}}
        @endif

        @endforeach
    @endforeach
@endforeach
</body>

</html>
