<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            .border th, .border td {
                border: 1px solid #000;
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
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th     align="center" 
                            colspan="{{ (count($master_medicinal_leaves) * 2)+ 2}}">
                        <b>การยาสูบแห่งประเทศไทย</b>
                    </th>
                    <th></th>
                    <th></th>
                  </tr>
                <tr>
                    <th><b>รหัสโปรแกรม : PDR0007</b></th>
                    <th></th>
                    <th     align="center" 
                            colspan="{{ (count($master_medicinal_leaves) * 2)+ 2}}">
                        <b>รายงานสอบถามปริมาณวัตถุดิบตามประมาณการยอดจำหน่าย</b>
                    </th>
                    <th><b>วันที่พิมพ์ :</b> </th>
                    <th>{{ now()->addYears('543')->format('d/m/Y') }}</th>
                </tr>
                <tr>
                    <th>สั่งพิมพ์ : {{request()->yearNumber}}</th>
                    <th></th>
                    <th colspan="{{ (count($master_medicinal_leaves) * 2)+ 2}}" 
                        align="center">
                        ประมาณการใช้ {{ $ingredienTobaccoType['ingredien_tobacco_desc'] }}
                        กลุ่ม {{ $ingredienSpeciesType['tobacco_type_desc'] }} 
                        ปีงบประมาณการจำหน่าย {{ $data['sales_fiscal_year_th'] }} 
                        จากประมาณการจำหน่ายฝ่ายขายครั้งที่ {{ $data['sales_fiscal_year_no'] }}
                    </th>
                    <th><b>เวลา  :</b></th>
                    <th>{{ now()->addYears('543')->format('H:i') }}</th>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr class="border">
                    <th style="{{ $border }} {{ $bold }}" 
                        rowspan="2">
                    </th>
                    <th style="{{ $border }} {{ $bold }}" 
                        rowspan="2" 
                        align="center">ตรา
                    </th>
                    <th style="{{ $border }} {{ $bold }}" 
                        rowspan="2"
                        align="center">ปี {{request()->year}} <br> ล้านมวน
                    </th>
                    <th style="{{ $border }} {{ $bold }}" 
                        rowspan="2"
                        align="center">LLD ปี {{ $data['lld_year'] }} <br> กก/พันมวน
                    </th>
                    <th style="{{ $border }} {{ $bold }}" 
                        rowspan="2"
                        align="center">จำนวนที่ใช้ <br> กก
                    </th>
                    @foreach($master_medicinal_leaves as $k => $mml)
                    <th style="{{ $border }} {{ $bold }}; text-align: left" 
                        colspan="2"
                        align="center">{{ $k }}</th>
                    @endforeach
                </tr>

                <tr class="border">
                    @foreach($master_medicinal_leaves as $mml)
                        @if ($ingredienTobaccoType['ingredien_tobacco_type'] != '1004')
                            <th style="{{ $border }} {{ $bold }}"
                                if
                                align="center">%
                            </th>
                        @else
                            <th style="{{ $border }} {{ $bold }}"
                                if
                                align="center">ต่อ 1,000 ก.ก.
                            </th>
                        @endif
                        <th style="{{ $border }} {{ $bold }}"
                            align="center">ก.ก.
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="br bl">
                @php 
                    $sumQuantity            = 0;
                    $sumQtyLLD              = 0;
                    $sumQtyUseYear          = 0;
                    $sumMedicinalPercent    = [];
                    $sumMedicinal           = [];
                    $sumHalfQuantity        = 0;
                @endphp
                @foreach($model->groupBy('item_code') as $index => $item)
                    @php 
                        $itemGroupMedicinal     = $item->groupBy('medicinal_leaves');
                        $modelGroupMedicinal    = $model->sortBy('medicinal_leaves')->groupBy('medicinal_leaves');
                        $sumQuantity            += $item->first()->quantity;
                        $sumQtyLLD              += $item->first()->qty_lld;
                        $sumQtyUseYear          += $item->first()->qty_use_year;
                        $sumHalfQuantity        += $item->first()->quantity/2;
                    @endphp 
                
                    <tr>
                        <td style="{{ $border }}; text-align: left">
                            {{ $item->first()->item_code }}
                        </td>
                        <td style="{{ $border }}">
                            {{ $item->first()->item_description }}
                        </td>
                        <td style="{{ $border }}">
                            {{ $item->first()->quantity }}
                        </td>
                        <td style="{{ $border }}">
                            {{ $item->first()->qty_lld }}
                        </td>
                        <td style="{{ $border }}">
                            {{ $quantity = $item->first()->qty_use_year }}
                        </td>
                        
                        @foreach($master_medicinal_leaves as $k => $mml)
                            @php 
                                if($ingredienTobaccoType['ingredien_tobacco_type'] != '1004'){
                                    @$sumMedicinalPercent[$k]  += optional(optional(@$itemGroupMedicinal[$k])->first())->ingredien_percent_item ?? 0;
                                    @$sumMedicinal[$k]         += $quantity * (optional(optional(@$itemGroupMedicinal[$k])->first())->ingredien_percent_item / 100);
                                }else{
                                    // @$sumMedicinalPercent[$k]   += optional(optional(@$modelGroupMedicinal[$k])->first())->cal_leaves_qty_use ?? 0;
                                    // @$sumMedicinal[$k]          += (optional(optional(@$modelGroupMedicinal[$k])->first())->cal_leaves_qty_use);
                                    foreach ($modelGroupMedicinal[$k] as $key => $value) {
                                        if($value['item_code'] == $index){
                                            @$sumMedicinalPercent[$k] += $value->ingredien_percent_item ?? 0;
                                            @$sumMedicinal[$k] += $value->cal_leaves_qty_use ?? 0;
                                        }
                                    }
                                }
                            @endphp
                            <td style="{{ $border }}">
                                {{ optional(optional(@$itemGroupMedicinal[$k])->first())->ingredien_percent_item }}
                            </td>
                            <td style="{{ $border }} text-right">
                                @if ($ingredienTobaccoType['ingredien_tobacco_type'] != '1004')
                                    @if(optional(optional(@$itemGroupMedicinal[$k])->first())->ingredien_percent_item) 
                                        {{ $quantity * (optional(optional(@$itemGroupMedicinal[$k])->first())->ingredien_percent_item / 100) }}
                                    @endif
                                @else
                                    @foreach ($modelGroupMedicinal[$k] as $key => $value)
                                        @if ($value['item_code'] == $index)
                                            {{ $value->cal_leaves_qty_use }}
                                        @endif
                                    @endforeach
                                @endif                                
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <td style="{{ $border }}" colspan="2">ปริมาณการใช้ใบยารวม (๖ เดือน)</td>
                    <td style="{{ $border }}">{{ $sumQuantity / 2 }}</td>
                    <td style="{{ $border }}">{{ $sumQtyLLD / 2 }}</td>
                    <td style="{{ $border }}">{{ $sumQtyUseYear / 2 }}</td>
                    @foreach($master_medicinal_leaves as $k => $mml)
                        <td style="{{ $border }}">
                            {{@$sumMedicinalPercent[$k] / 2 }}
                        </td>
                        <td style="{{ $border }}">
                            {{@$sumMedicinal[$k] / 2 }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td style="{{ $border }}" colspan="2">ปริมาณการใช้ใบยารวมทั้งปี</td>
                    <td style="{{ $border }}">{{ $sumQuantity }}</td>
                    <td style="{{ $border }}">{{ $sumQtyLLD }}</td>
                    <td style="{{ $border }}">{{ $sumQtyUseYear }}</td>
                    @foreach($master_medicinal_leaves as $k => $mml)
                        <td style="{{ $border }}">
                            {{@$sumMedicinalPercent[$k]}}
                        </td>
                        <td style="{{ $border }}">
                            {{@$sumMedicinal[$k]}}
                        </td>
                    @endforeach
                    
                </tr>
                <tr>
                    <td style="{{ $border }}" colspan="2">อัตราการใช้ต่อเดือน</td>
                    <td style="{{ $border }}">{{ $sumQuantity / 12 }}</td>
                    <td style="{{ $border }}">{{ $sumQtyLLD / 12 }}</td>
                    <td style="{{ $border }}">{{ $sumQtyUseYear / 12 }}</td>
                    @foreach($master_medicinal_leaves as $k => $mml)
                        <td style="{{ $border }}">
                            {{@$sumMedicinalPercent[$k] / 12 }}
                        </td>
                        <td style="{{ $border }}">
                            {{@$sumMedicinal[$k] / 12 }}
                        </td>
                    @endforeach                
                </tr>
            </tbody>
        </table>
    </body>
</html>
