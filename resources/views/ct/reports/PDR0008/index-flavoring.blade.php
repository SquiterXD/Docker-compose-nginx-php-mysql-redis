<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            table {
                border-collapse: collapse;
            }

            td,
            th {
                padding: 1px 5px;
            }

            .border th,
            .border td {
                border: 1px solid #000;
                /* border-top:1px solid #ccc; */
            }

            .bt {
                border-top: 1px solid #000;

            }

            .bb {
                border-bottom: 1px solid #000;

            }

            .br td {
                border-right: 1px solid #000;
            }

            .bl td {
                border-left: 1px solid #000;

            }

            .bold {
                font-weight: bold;

            }
        </style>
    </head>
    @php
        $border         = 'border:1px solid #000;';
        $borderLeft     = 'border-left:1px solid #000;';
        $borderRight    = 'border-right:1px solid #000;';
        $borderTop      = 'border-top:1px solid #000;';
        $borderBottom   = 'border-bottom:1px solid #000;';
        $bold           = 'font-weight: bold;';
        $alignMiddle    = 'vertical-align: middle;';
        $textCenter     = 'text-align: center;';
    @endphp

    <body>
        <table style="width: 100%;">

            <thead>
                <tr>
                    <td colspan="19" 
                        align="center">
                        คงคลังเครื่องบุหรี่(รวมทุกโกดัง) 
                        {{ now()->addYears('543')->format('d/m/Y H:i') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="19" align="center">
                        ใช้ LLD ปี {{ $data['lld_year'] }} 
                        ปรับครั้งที่ {{ $data['sales_fiscal_year_revision' ]}}
                    </td>
                    <td align="center"></td>
                    <td align="center"></td>
                </tr>
            
                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr class="border">
                    <th rowspan="2" 
                        style="{{ $border }} {{ $bold }} {{ $alignMiddle }} {{ $textCenter }}">
                        เครื่องปรุงบุหรี่
                    </th>
                    <th style="{{ $border }} {{ $bold }}">อัตราการใช้ต่อเดือน (ก.ก./เดือน)</th>
                    @foreach ($model->where('subinventory_code', '!=', "")
                                    ->sortBy('subinventory_code')
                                    ->groupBy('subinventory_code') as $subinventoryCode => $item)
                        <th style="{{ $border }} {{ $bold }}"></th>
                    @endforeach
                    <th rowspan="2" 
                        style="{{ $border }} {{ $bold }} {{$alignMiddle}}">รวมทั้งหมด</th>
                    <th rowspan="2" 
                        style="{{ $border }} {{ $bold }} {{$alignMiddle}}">เหลือคงใช้ (เดือน)</th>                    
                </tr>

                <tr class="border">
                    <th style="{{ $border }} {{ $bold }}">(กก /เดือน)</th>
                    @foreach ($model->where('subinventory_code', '!=', "")
                                    ->sortBy('subinventory_code')
                                    ->groupBy('subinventory_code') as $subinventoryCode => $item)
                        <th style="{{ $border }} {{ $bold }}"> {{ $subinventoryCode }} </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="br bl">
                @foreach ($model->where('subinventory_code', '!=', "")
                                ->sortBy('medicinal_leaves')
                                ->groupBy('medicinal_leaves') as $indexLine => $uLine)
                    @php 
                        $totalByRow     = 0; 
                        $remainingByRow = 0; 
                    @endphp

                    <tr>
                        <td style="{{ $border }} {{ $bold }}">{{ $indexLine }}</td>
                        <td style="{{ $border }} {{ $bold }}">
                            {{ $uLine[0]['qty_use_month'] ? $uLine[0]['qty_use_month'] : 0 }}
                        </td>
                        @foreach ($subinventoryCodeTr as $index => $cl)
                            <td style="{{ $border }} {{ $bold }}">
                                {{  
                                    isset($mapLines[$indexLine.''.$index]) ? 
                                    $mapLines[$indexLine.''.$index]['onhand_quantity'] :
                                    0  
                                }}
                            </td>
                            @php
                                $totalByRow +=  isset($mapLines[$indexLine.''.$index]) ? 
                                                $mapLines[$indexLine.''.$index]['onhand_quantity'] :
                                                0                                         
                            @endphp
                        @endforeach
                        <td style="{{ $border }} {{ $bold }}">
                            {{ $totalByRow }}
                        </td>
                        <td style="{{ $border }} {{ $bold }}">
                            {{ $remainingByRow = $totalByRow / $uLine[0]['qty_use_month'] }}
                        </td>
                    </tr>
                @endforeach

                {{-- <tr>
                    <td style="{{ $border }} {{ $bold }}">
                        {{ 'TotalALL' }}
                    </td>
                    <td style="{{ $border }}"></td>                    
                    <td style="{{ $border }}"></td>
                    <td style="{{ $border }} {{ $bold }}">{{ $totalAllQTYUseMonth }}</td>
                    @foreach($model->where('lot_number', '!=', "")
                                            ->sortBy('lot_number')
                                            ->groupBy('lot_number') as $lotNumber => $item)
                        <td style="{{ $border }} {{ $bold }}">
                            {{ @$totalAllLot[$lotNumber] }}
                        </td>
                    @endforeach 
                    <td style="{{ $border }} {{ $bold }}">{{ $totalAllSummary }}</td>
                    <td style="{{ $border }} {{ $bold }}">{{ $totalAllSummary != 0 ? $totalAllSummary / $totalAllQTYUseMonth : 0 }}</td>
                </tr> --}}
            </tbody>

        </table>
    </body>
</html>
