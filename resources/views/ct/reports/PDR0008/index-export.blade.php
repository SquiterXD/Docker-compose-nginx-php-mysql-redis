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
    @endphp

    <body>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <td colspan="19" 
                        align="center">
                        คงคลังใบยาต่างประเทศทุกประเภท(รวมทุกโกดัง) 
                        {{ now()->addYears('543')->format('d/m/Y H:i') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="19" align="center">
                        ใช้ LLD ปี {{ $data['lld_year'] }} 
                        ประมาณการจำหน่ายปี {{ $data['sales_fiscal_year_th' ]}}/{{ $data['sales_fiscal_year_no'] }}
                    </td>
                    <td align="center"></td>
                    <td align="center"></td>
                </tr>
            
                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr class="border">
                    <th style="{{ $border }} {{ $bold }}">ประเทศ</th>
                    <th style="{{ $border }} {{ $bold }}">ใบยา</th>  
                    <th style="{{ $border }} {{ $bold }}">กลุ่ม</th>
                    <th style="{{ $border }} {{ $bold }}">เฉลี่ยใช้ใบยา</th>
                    @foreach($model->where('lot_number', '!=', "")
                                   ->sortBy('lot_number')
                                   ->groupBy('lot_number') as $lotNumber => $item)
                        <th style="{{ $border }} {{ $bold }}">&nbsp;{{$lotNumber}}</th>
                    @endforeach                    
                    <th style="{{ $border }} {{ $bold }}">รวมทั้งหมด</th>
                    <th style="{{ $border }} {{ $bold }}">คงเหลือใช้</th>
                </tr>

                <tr class="border">
                    <th style="{{ $border }} {{ $bold }}"></th>
                    <th style="{{ $border }} {{ $bold }}"></th>
                    <th style="{{ $border }} {{ $bold }}"></th>
                    <th style="{{ $border }} {{ $bold }}">(กก /เดือน)</th>
                    @foreach($model->where('lot_number', '!=', "")
                                   ->sortBy('lot_number')
                                   ->groupBy('lot_number') as $lotNumber => $item)
                        <th style="{{ $border }} {{ $bold }}"></th>
                    @endforeach
                    <th style="{{ $border }} {{ $bold }}">(กก)</th>
                    <th style="{{ $border }} {{ $bold }}">(เดือน)</th>
                </tr>
            </thead>

            <tbody class="br bl">
                @php 
                    $totalAllQTYUseMonth    = 0;   
                    $totalAllLot            = array();    
                    $totalAll               = 0;   
                    $onHandQtyAll           = 0;  
                    $totalAllSummary        = 0;
                    $totalAllAvailable      = 0;            
                @endphp
                @foreach ($model->sortBy('country')->groupBy('country') as $country => $dataGroupCountry)
                    @foreach ($dataGroupCountry->sortBy('item_att10')->groupBy('item_att10') as $itemAtt10 => $dataItemAtt10)  
                        @php
                            $totalQTYUseMonth   = 0;   
                            $totalLot           = array(); 
                            $totalSummary       = 0; 
                            $totalAvailable     = 0;                  
                        @endphp                        
                        @foreach ($dataItemAtt10->sortBy('medicinal_leaves')->groupBy('medicinal_leaves') as $mdicinalLeaves => $dataGroupMedi)
                            <tr>
                                @php
                                    $total = 0;                   
                                    $totalQTYUseMonth += $dataGroupMedi[0]['qty_use_month'] ? $dataGroupMedi[0]['qty_use_month'] : 0;                                    
                                @endphp
                                <td style="{{ $border }}">{{ $dataGroupCountry[0]['item_att11'] >= 4 ? '' : $country }}</td>
                                <td style="{{ $border }}">{{ $itemAtt10 }}</td>
                                <td style="{{ $border }}">{{ $mdicinalLeaves }}</td>  
                                <td style="{{ $border }}">
                                    {{ $dataGroupMedi[0]['qty_use_month'] ? $dataGroupMedi[0]['qty_use_month'] : 0 }}
                                </td>
                                @foreach($model->where('lot_number', '!=', "")
                                            ->sortBy('lot_number')
                                            ->groupBy('lot_number') as $lotNumber => $item)
                                    @php 
                                        $onHandQty = $dataGroupMedi->where('lot_number', $lotNumber)->sum('onhand_quantity');
                                        $total += $onHandQty;   
                                        @$totalLot[$lotNumber] += $onHandQty; 
                                        @$totalAllLot[$lotNumber] += $onHandQty;   
                                    @endphp
                                    <td style="{{ $border }}">
                                        {{ $dataGroupMedi->where('lot_number', $lotNumber)->sum('onhand_quantity') }}
                                    </td>
                                @endforeach 
                                <td style="{{ $border }}">{{ $total }}</td>
                                @if ($dataGroupMedi[0]['qty_use_month'] != 0)
                                    <td style="{{ $border }}">{{ $total/ $dataGroupMedi[0]['qty_use_month'] }}</td>                                      
                                @else
                                <td style="{{ $border }}">{{ 0 }}</td> 
                                @endif
                                @php
                                    $totalSummary += $total;
                                    // $totalAvailable += ($total / $dataGroupMedi[0]['qty_use_month']);                                                                        
                                @endphp
                            </tr>                                                    
                        @endforeach  
                        <tr>
                            <td style="{{ $border }}"></td>
                            <td style="{{ $border }} {{ $bold }}">
                                {{ 'Total' }}
                            </td>
                            <td style="{{ $border }}"></td>
                            <td style="{{ $border }} {{ $bold }}">{{ $totalQTYUseMonth }}</td>
                            @foreach($model->where('lot_number', '!=', "")
                                            ->sortBy('lot_number')
                                            ->groupBy('lot_number') as $lotNumber => $item)
                                <td style="{{ $border }} {{ $bold }}">
                                    {{ @$totalLot[$lotNumber] }}
                                </td>
                            @endforeach 
                            <td style="{{ $border }} {{ $bold }}">{{ $totalSummary }}</td>
                            <td style="{{ $border }} {{ $bold }}">{{ $totalSummary != 0 ? $totalSummary / $totalQTYUseMonth : 0 }}</td>
                            @php
                                $totalAllQTYUseMonth    += $totalQTYUseMonth;
                                $totalAllSummary        += $totalSummary;
                            @endphp
                        </tr>                      
                    @endforeach
                @endforeach
                <tr>
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
                </tr>                
            </tbody>
        </table>
    </body>
</html>
