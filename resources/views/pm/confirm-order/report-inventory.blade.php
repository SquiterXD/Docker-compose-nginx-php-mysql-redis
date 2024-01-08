<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ptpm Batch Transaction V</title>

    <link rel="stylesheet" href="{{ asset('css/report.css') }}">

    <style type="text/css">
        body{
            font-size: 11px;
        }
    </style>

</head>
<body>
    <div class="row">
        <div class="col-lg-12 header">
            <div class="row">
                <div class="table-responsive">
                    <table class="table" style="width: 100%">
                        <thead>
                            <tr style="text-align: center">
                                <th>ลำดับ</th>
                                <th>คลังย่อย</th>
                                <th>รหัสวัตถุดิบ</th>
                                <th>รายละเอียด</th>
                                <th>LOT. NO.</th>
                                {{-- <th>LEAF FORMULA</th> --}}
                                <th>ปริมาณการใช้จริง</th>
                                <th>หน่วยนับ</th>
                                <th>ปริมาณคงคลังที่เหลือ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                                $sumTotal = 0;
                            @endphp
                            @foreach ($ptpmItems->sortBy('seq') as $item)
                            @php
                                $sumTotal = $sumTotal + $item->conversionUom("total_non_tax")->sumTotalQty;
                            @endphp
                            <tr>
                                @php
                                    if($item->transaction_type_name == "WIP Issue"){
                                        $item->transaction_quantity =  abs($item->transaction_quantity);
                                    }
                                @endphp
                                <td style="text-align: center">{{ ++$i }}</td>
                                <td>{{ str_replace($item->subinventory_code.'.'," ",$item->locator_code) }}</td>
                                <td>{{ $item->item_no }}</td>
                                <td>{{ $item->item_desc }}</td>
                                <td>{{ $item->lot_number }}</td>
                                {{-- <td>{{ $item->leaf_fomula }}</td> --}}
                                <td style="text-align: right">
                                    {{ number_format($item->conversionUom("total")->sumTotalQty,6) }}
                                </td>
                                <td style="text-align: center">
                                    {{-- @if ($issueHeader->program_code == 'PMP0007' || $issueHeader->program_code == 'PMP0048')
                                        {{ $item->conversionUom("uom")->productUnitOfMeasure }}
                                    @else
                                    @endif --}}
                                    {{ $item->uom_name }}
                                </td>
                                <td style="text-align: right">
                                    @if ($issueHeader->program_code == 'PMP0007' || $issueHeader->program_code == 'PMP0048')
                                        {{ number_format($item->composOnhand($lines, $item->lot_number ,$item->formulaline_id), 6)}}
                                    @else
                                        {{ number_format($item->onhand,6) }}
                                    @endif
                                </td>
                            </tr>
                            @if ($loop->last && $issueHeader->program_code == 'PMP0007')
                                <tr>
                                    <td colspan="5" style="text-align: right ; border-top: 1px solid black">รวม</td>
                                    <td style="text-align: right ; border-top: 1px solid black">{{ number_format($sumTotal,6) }}</td>
                                    <td style="text-align: center ; border-top: 1px solid black">กิโลกรัม</td>
                                    <td style="text-align: right ; border-top: 1px solid black"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <td colspan="7" style="text-align: right">รวม</td>
                                <td style="text-align: right">{{ number_format($sumTotal,6) }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot> --}}
                    </table>
                    <hr>
                    <div align="center" class="mt-4"> <b>จบรายงาน</b></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
