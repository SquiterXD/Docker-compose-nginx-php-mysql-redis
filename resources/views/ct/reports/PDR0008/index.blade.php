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

            td, th {
                padding: 1px 5px;
            }

            .border th, .border td {
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
                    <td colspan="19" align="center">
                        คงคลัง{{ $ingredienTobaccoType['ingredien_tobacco_desc'] }} 
                        {{ $ingredienSpeciesType['tobacco_type_desc'] }}(รวมทุกโกดัง) 
                        {{ now()->addYears('543')->format('d/m/Y H:i') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="19" align="center">
                        ใช้ LLD ปี {{ $data['lld_year'] }} 
                        ประมาณการจำหน่ายปี {{ $data['sales_fiscal_year_th' ]}} 
                        จากประมาณการจำหน่ายฝ่ายขายครั้ง {{ $data['sales_fiscal_year_no'] }}
                    </td>
                </tr>
            
                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr class="border">
                    <th style="{{ $border }} {{ $bold }}"></th>
                    <th style="{{ $border }} {{ $bold }}">กลุ่ม </th>
                    <th style="{{ $border }} {{ $bold }}">เฉลี่ยใช้ใบยา</th>
                    @foreach($model->sortBy('shot_sub_inv')->groupBy('shot_sub_inv') as $korgCode => $dataShotSubInv)
                        @foreach($dataShotSubInv->sortBy('lot_number')->groupBy('lot_number') as $lotNumber => $item)
                            @if ($korgCode != null)
                                <th style="{{ $border }} {{ $bold }}">{{$korgCode}}</th>
                            @endif
                        @endforeach
                        @if ($korgCode != null)
                            <th style="{{ $border }} {{ $bold }}">รวม</th>
                        @endif
                    @endforeach                    
                    <th style="{{ $border }} {{ $bold }}">รวมทั้งหมด</th>
                    <th style="{{ $border }} {{ $bold }}">คงเหลือใช้</th>
                </tr>

                <tr class="border">
                    <th style="{{ $border }} {{ $bold }}"></th>
                    <th style="{{ $border }} {{ $bold }}"></th>
                    <th style="{{ $border }} {{ $bold }}">(กก /เดือน)</th>
                    @foreach($model->sortBy('shot_sub_inv')->groupBy('shot_sub_inv') as $korgCode => $dataShotSubInv)
                        @foreach($dataShotSubInv->sortBy('lot_number')->groupBy('lot_number') as $lotNumber => $item)
                            @if ($korgCode != null)
                                <th style="{{ $border }} {{ $bold }}">&nbsp;{{$lotNumber}}</th>
                            @endif
                        @endforeach
                        @if ($korgCode != null)
                            <th></th>
                        @endif
                    @endforeach
                    <th style="{{ $border }} {{ $bold }}">(กก)</th>
                    <th style="{{ $border }} {{ $bold }}">(เดือน)</th>
                </tr>
            </thead>

            <tbody class="br bl">
                @php
                    $summaryTotalBalance        = 0;                       
                    $totalBalance               = 0;    
                    $summaryQtyUse              = 0;    
                    $summaryAtt11Summarize      = array();   
                    $summaryTotalAtt11Summarize = array();
                    $summaryQtyUseSummarize     = 0;                               
                @endphp

                @foreach ($model->groupBy('item_att11') as $itemAtt11 => $dataGroupitemAtt11)
                    @php
                        $totalQtyUseMonthAtt11  = 0;   
                        $totalAtt11             = array();    
                        $summaryTotalAtt11      = array();    
                        $summaryTotalSummarize  = 0;  
                        $summaryQtyUseSummarize = 0;  
                        $totalBalanceSummarize  = 0;
                    @endphp
                    @foreach ($dataGroupitemAtt11->groupBy('medicinal_leaves') as $mdicinalLeaves => $dataGroupMedi)                        
                        <tr>
                            @php
                                $qtyUseMonth = $dataGroupMedi[0]['qty_use_month'] ? $dataGroupMedi[0]['qty_use_month'] : 0;
                                $totalQtyUseMonthAtt11 += $qtyUseMonth;
                            @endphp
                            <td style="{{ $border }}">{{ $itemAtt11 }}</td>
                            <td style="{{ $border }}">{{ $mdicinalLeaves }}</td>
                            <td style="{{ $border }}">
                                {{ $dataGroupMedi[0]['qty_use_month'] ? $dataGroupMedi[0]['qty_use_month'] : 0 }}
                            </td>
                            
                            @foreach($model->sortBy('shot_sub_inv')->groupBy('shot_sub_inv') as $korgCode => $dataShotSubInv)
                                @foreach($dataShotSubInv->sortBy('lot_number')->groupBy('lot_number') as $lotNumber => $item)
                                    @if ($korgCode != null)
                                        @php 
                                            $totalOnHandQty = 0;                                                                       
                                        @endphp
                                        <td style="{{ $border }}">
                                            @php                                 
                                                $onHandQty = $dataGroupMedi->where('shot_sub_inv', $korgCode)
                                                                            ->where('lot_number', $lotNumber)
                                                                            ->sum('onhand_quantity');                                                                        
                                                $totalOnHandQty += $onHandQty;
                                                @$totalAtt11[$korgCode][$lotNumber] += $totalOnHandQty;
                                            @endphp
                                            {{ $dataGroupMedi->where('shot_sub_inv', $korgCode)
                                                            ->where('lot_number', $lotNumber)
                                                            ->sum('onhand_quantity') }}
                                        </td>    
                                        @php
                                            @$summaryTotalAtt11[$korgCode] += $totalOnHandQty;
                                        @endphp          
                                    @endif                                                  
                                @endforeach
                                @if ($korgCode != null)
                                    @php
                                        $totalOnHandByShotSubInv = $dataGroupMedi->where('shot_sub_inv', $korgCode)
                                                                                ->sum('onhand_quantity');
                                    @endphp
                                    <td style="{{ $border }} {{ $bold }}"> {{ $totalOnHandByShotSubInv }} </td>   
                                @endif         
                            @endforeach

                            @php
                                $totalColOnHandKG = $dataGroupMedi->sum('onhand_quantity');
                                if($dataGroupMedi[0]['qty_use_month'] != 0){
                                    $totalBalance = $totalColOnHandKG/$dataGroupMedi[0]['qty_use_month'];
                                }else{
                                    $totalBalance = 0;
                                }                                
                            @endphp                            
                            <td style="{{ $border }} {{ $bold }}"> {{ $totalColOnHandKG }} </td>   
                            <td style="{{ $border }} {{ $bold }}"> {{ $totalBalance }} </td>    
                        </tr>                         
                    @endforeach
                        <tr>                 
                            <td style="{{ $border }} {{ $bold }}">Total</td>
                            <td style="{{ $border }}"></td>
                            <td style="{{ $border }} {{ $bold }}">{{ $totalQtyUseMonthAtt11 }}</td>        
                            @foreach($model->sortBy('shot_sub_inv')->groupBy('shot_sub_inv') as $korgCode => $dataShotSubInv)
                                @foreach($dataShotSubInv->sortBy('lot_number')->groupBy('lot_number') as $lotNumber => $item)
                                    @if ($korgCode != null)
                                        <td style="{{ $border }} {{ $bold }}">
                                            {{ @$totalAtt11[$korgCode][$lotNumber] }}
                                        </td>
                                    @endif
                                @endforeach
                                @if ($korgCode != null)
                                    <td style="{{ $border }} {{ $bold }}">
                                        {{ @$summaryTotalAtt11[$korgCode] }}
                                    </td>
                                @endif                      
                            @endforeach          
                            @php
                                $summaryTotal = 0;
                                $summaryBalance = 0;
                                $summaryQtyUse = 0;
                                foreach ($dataGroupitemAtt11->groupBy('medicinal_leaves') as $mdicinalLeaves => $dataGroupMedi) {
                                    $summaryTotal += $dataGroupMedi->sum('onhand_quantity');
                                    $summaryQtyUse += $dataGroupMedi[0]['qty_use_month'];
                                } 

                                if($summaryQtyUse != 0){
                                    $summaryBalance = $summaryTotal / $summaryQtyUse;
                                }else{
                                    $summaryBalance = 0;
                                }
                                
                            @endphp                   
                            <td style="{{ $border }} {{ $bold }}"> {{ $summaryTotal }} </td> 
                            <td style="{{ $border }} {{ $bold }}"> {{ $summaryBalance }} </td>      
                        </tr> 
                        
                        @if ($itemAtt11 == 3)
                            @php              
                                foreach ($model->groupBy('item_att11') as $itemAtt11 => $dataGroupitemAtt11) {                                    
                                    foreach ($dataGroupitemAtt11->groupBy('medicinal_leaves') as $mdicinalLeaves => $dataGroupMedi) {
                                        if ($itemAtt11 != 4) {
                                            $summaryTotalSummarize += $dataGroupMedi->sum('onhand_quantity');
                                            $summaryQtyUseSummarize += $dataGroupMedi[0]['qty_use_month'];

                                            foreach ($model->sortBy('shot_sub_inv')->groupBy('shot_sub_inv') as $korgCode => $dataShotSubInv) {
                                                foreach ($dataShotSubInv->sortBy('lot_number')->groupBy('lot_number') as $lotNumber => $item) {
                                                    if($korgCode != null){
                                                        $onHandQty = $dataGroupMedi->where('shot_sub_inv', $korgCode)
                                                                            ->where('lot_number', $lotNumber)
                                                                            ->sum('onhand_quantity');
                                                        @$summaryAtt11Summarize[$korgCode][$lotNumber] += $onHandQty;
                                                    }
                                                }
                                                if($korgCode != null){
                                                    $onHandQty = $dataGroupMedi->where('shot_sub_inv', $korgCode)
                                                                                ->sum('onhand_quantity');
                                                    @$summaryTotalAtt11Summarize[$korgCode] += $onHandQty;
                                                }
                                            }

                                            $totalBalanceSummarize = $summaryTotalSummarize/$summaryQtyUseSummarize;
                                        }                    
                                    }
                                }
                            @endphp
                            <tr style="{{ $border }}">
                                <td style="{{ $border }} {{ $bold }}">Summary</td>
                                <td style="{{ $border }}"></td>
                                <td style="{{ $border }} {{ $bold }}">{{ $summaryQtyUseSummarize }}</td>  
                                @foreach($model->sortBy('shot_sub_inv')->groupBy('shot_sub_inv') as $korgCode => $dataShotSubInv)
                                    @foreach($dataShotSubInv->sortBy('lot_number')->groupBy('lot_number') as $lotNumber => $item)
                                        @if ($korgCode != null)
                                            <td style="{{ $border }} {{ $bold }}">
                                                {{ @$summaryAtt11Summarize[$korgCode][$lotNumber] }}
                                            </td>
                                        @endif
                                    @endforeach
                                    @if ($korgCode != null)
                                        <td style="{{ $border }} {{ $bold }}">
                                            {{ @$summaryTotalAtt11Summarize[$korgCode] }}
                                        </td>
                                    @endif                      
                                @endforeach     
                                <td style="{{ $border }} {{ $bold }}"> {{ $summaryTotalSummarize }} </td>        
                                <td style="{{ $border }} {{ $bold }}"> {{ $totalBalanceSummarize }} </td>                                                       
                            </tr>
                        @endif   
                @endforeach
            </tbody>
            
        </table>
    </body>
</html>
