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
        $font18 = 'font-size: 18px';
        $font16 = 'font-size: 16px';
        $font14 = 'font-size: 14px';
        $styleBorderLRFont14 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 14px';
        $styleBorderLRFTont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 14px';
        $styleBorderLRBTFont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 14px';
        $styleBorderLRFont16 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 16px';
        $styleBorderLRFTont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 16px';
        $styleBorderLRBTFont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 16px';
        $uData = [];
    @endphp
    {{-- {{dd($datas->groupBy('item_cat_code'))}} --}}
    @foreach ($datas->sortBy('f_transaction_date')->groupBy('product_item_number') as $productItemNum => $uData)
        @foreach ($uData->groupBy('f_transaction_date') as $date => $dataByDate)
    <table class="table">
                <thead>
                    {{-- @if ($loop->parent->first && $loop->first) --}}
                        <tr>
                            <td style="{{ $font18 }}"> <b> โปรแกรม : CTR0004 </b> </td>
                            <td style="{{ $font18 }}" colspan="5" align="center"> <b> การยาสูบแห่งประเทศไทย </b>
                            </td>
                            <td style="{{ $font18 }}"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="{{ $font18 }}" colspan="5" align="center"> <b>รายงานบัตรต้นทุนประจำวัน
                                    ({{ $cost->cost_code . ' ' . $cost->description }})
                                </b></td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td  style="{{ $font18 }}"  colspan="5" align="center"><b> ประจำวันที่ :
                                {{ Carbon\Carbon::create($date)->addYear('543')->format('d/m/Y') }} </b></td>
                        </tr>
                    {{-- @endif --}}
                    <tr>
                        <td style="{{ $font18 }}"><b> วันที่เริ่มผลิต :
                                {{ Carbon\Carbon::create($datas[0]->plan_start_date)->addYear('543')->format('d/m/Y') }}
                            </b></td>
                        <td style="{{ $font18 }}" colspan="5"></td>
                        <td style="{{ $font18 }}"> </td>
                    </tr>
                    <tr>
                        <td style="{{ $font18 }}"> <b>วันที่ผลิตเสร็จ :
                                {{ Carbon\Carbon::create($datas[0]->plan_cmplt_date)->addYear('543')->format('d/m/Y') }}
                            </b></td>
                        <td colspan="5"></td>
                        <td></td>
                    </tr>
                    {{-- <tr>
                        <td style="{{ $font18 }}"><b> เลขที่คำสั่งผลิต :{{ $batchNo }} </b></td>
                        <td colspan="5"></td>
                        <td></td>
                    </tr> --}}
                    <tr>
                        <td style="{{ $font18 }}"> <b> รหัสสินค้า/ชื่อสินค้า :
                                {{ $datas[0]->product_item_number . ' ' . $datas[0]->product_item_desc }} </b> </td>
                        <td colspan="5"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="center" style="{{ $styleFont16 }}" rowspan="2"><b> รายการ </b> </td>
                        <td align="center" style="{{ $styleFont16 }}" colspan="2"><b> ต้นทุนคิดเข้างาน </b> </td>
                        <td align="center" style="{{ $styleFont16 }}"><b>
                                <span style="color:#fff">&nbsp;</span> {{ number_format($dataByDate[0]->wage_cost, 9) }} </b> </td>
                        <td align="center" style="{{ $styleFont16 }}"><b>
                            <span style="color:#fff">&nbsp;</span> {{ number_format($dataByDate[0]->vary_cost, 9) }} </b> </td>
                        <td align="center" style="{{ $styleFont16 }}"><b>
                            <span style="color:#fff">&nbsp;</span> {{ number_format($dataByDate[0]->fixed_cost, 9) }} </b> </td>
                        <td align="center" style="{{ $styleFont16 }}" rowspan="2"><b> รวมต้นทุนคิดเข้างาน </b>
                        </td>
                    </tr>
                    <tr>
                        {{-- <td align="center" style="{{ $styleBorderLRBTFont16 }}" ></td> --}}
                        <td align="center" style="{{ $styleFont16 }}"><b> ปริมาณ {{number_format($datas[0]->cost_quantity, 2)}} {{$datas[0]->uom_desc}} </b></td>
                        <td align="center" style="{{ $styleFont16 }}"><b> วัตถุดิบ </b></td>
                        <td align="center" style="{{ $styleFont16 }}"><b> ค่าแรง </b></td>
                        <td align="center" style="{{ $styleFont16 }}"><b> ค่าใช้จ่ายผันแปร </b></td>
                        <td align="center" style="{{ $styleFont16 }}"><b> ค่าใช้จ่ายคงที่ </b></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $afterWipText = '';
                        $afterWipCode = '';
                        $dataByOprnCode = $dataByDate->groupBy('oprn_code');
                        $tranferData = [];
                        $masterHumanCost = [];
                        $masterAfCost = [];
                        $masterFixedCost = [];
                    @endphp
                    @foreach ($setupBath[$uData[0]->batch_id] as $k => $bathMaster)
                        @php
                            $productWipV = productWipV($dataByDate[0]->batch_id, $bathMaster->wip_step, $date);
                            if(!$loop->first) {
                                $afterStepWip = (int)str_replace('WIP','',$bathMaster->wip_step) - 1;
                                $afterStepWip = "WIP". sprintf('%02d', $afterStepWip);
                                $productAfterWipV = productWipV($dataByDate[0]->batch_id, $afterStepWip, $date);
                                $confirmIssueQtyAfter = $productAfterWipV->sum('confirm_issue_qty');
                            }
                            $tranferWip = $productWipV->sum('ending_qty') / $dataByDate[0]->cost_quantity;
                            // $confirmQty = $productWipV->sum('confirm_qty');
                            $confirmQty = $productWipV->sum('confirm_qty') / $dataByDate[0]->cost_quantity;
                            // $confirmQty = $productWipV->sum('confirm_qty');
                            $lossQty = $productWipV->sum('loss_qty');
                            $begining = $productWipV->sum('beginning_qty');

                            $masterCostWip = DB::select("select dl_absorption_rate,voh_absorption_rate,foh_absorption_rate 
                                                from PTCT_WIP_PROCESS_V
                                                where cost_code = '{$cost->cost_code}'
                                                    and wip_step = '{$bathMaster->wip_step}'");
                            $varyCostAmount = $dataByDate[0]->vary_cost * (optional(@optional($dataByTobaccoGroup)->first()[0])->dl_absorption_rate * 0.01);
                            if ($confirmQty > 0 && optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity > 0) {
                                $tranferQty = $confirmQty / optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity;
                            }
                            $tranferQty = productWipV($dataByDate[0]->batch_id, $bathMaster->wip_step, $date)->sum('confirm_issue_qty') / (optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity ?? 1);
                            $dataByTobaccoGroup = optional(optional(@$dataByOprnCode[$bathMaster->wip_step])->sortBy('item_cat_code'))->groupBy('tobacco_group_code') ?? [];
                            $wageCostAmount = $dataByDate[0]->wage_cost * optional($masterCostWip[0])->dl_absorption_rate * 0.01;
                            $varyCostAmount = $dataByDate[0]->vary_cost * optional($masterCostWip[0])->voh_absorption_rate * 0.01;
                            $fixedCost = $dataByDate[0]->fixed_cost * optional($masterCostWip[0])->foh_absorption_rate * 0.01;
                            if ($begining > 0 && optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity > 0) {
                                $receiveWip = $begining / optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity;
                            } else {
                                $receiveWip = 0;
                            }
                            
                            // $c = $confirmQty * $receiveWip == 0 ? 0 : ($confirmQty * $receiveWip) / optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material');
                            
                            $g = optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') + ($confirmQty) * $wageCostAmount + $confirmQty * $varyCostAmount + $confirmQty * $fixedCost;
                            
                            // $sumMaterial = optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material');
                            
                            // if (!$loop->first) {
                            //     $sumMaterial = optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') + $c + @$tranferData[optional(@$dataByOprnCode[$bathMaster->wip_step][0])->previous_wip]['tranfer_raw_mat'];
                            // }
                            // if (optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') > 0) {
                            //     $sumTranfer = ((optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') + $c) * $tranferQty) / ($confirmQty + $receiveWip) + $tranferQty * $wageCostAmount + $tranferQty * $varyCostAmount + $tranferQty * $fixedCost;
                            // }
                            // if (optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity > 0) {
                            //     $tranferWip = $confirmQty / optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity;
                            // }

                        @endphp
                        <tr>
                            <td colspan="3" style="{{ $styleFont16 }}"> <b> ขั้นตอน
                                    {{ $bathMaster->wip_step }} {{ $bathMaster->wip_step_desc }} </b> </td>
                            <td style="{{ $styleFont16 }}; font-wegiht: bold">
                                @if ($loop->first)
                                @php 
                                    
                                @endphp
                                    <b>{{ $masterHumanCost['percent'] = optional(@$masterCostWip[0])->dl_absorption_rate }}
                                        %
                                        ({{ $masterHumanCost['value'] = $wageCostAmount }})
                                    </b>
                                @else
                                <span style="color:#fff">&nbsp;</span>{{ number_format($dataByDate[0]->wage_cost, 9) }} 
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}; font-wegiht: bold">
                                @if ($loop->first)
                                    <b>{{ $masterAfCost['percent'] =optional(@$masterCostWip[0])->voh_absorption_rate }}
                                        %
                                        ({{ $masterAfCost['value'] = $varyCostAmount }}) </b>
                                @else
                                <span style="color:#fff">&nbsp;</span>{{ number_format($dataByDate[0]->vary_cost, 9) }}
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}; font-wegiht: bold">
                                @if ($loop->first)
                                    <b>{{ $masterFixedCost['percent'] = optional(@$masterCostWip[0])->foh_absorption_rate }}
                                        %
                                        ({{ $masterFixedCost['value'] = $fixedCost }})</b>
                                @else
                                    <span style="color:#fff">&nbsp;</span> {{ number_format($dataByDate[0]->fixed_cost, 9) }}
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}"></td>
                        </tr>
                    @php 
                    $masterHumanCost['value'] = $wageCostAmount;
                    $masterAfCost['value'] = $varyCostAmount;
                    $masterFixedCost['value'] = $fixedCost;
                    $tcw = transferCWip($bathMaster->wip_step, $bathMaster->batch_id, \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y'));
                            if(!empty($tcw)) {
                                $c = $tcw[0]->amount * ($receiveWip / ($tcw[0]->qty / $datas[0]->cost_quantity));
                            } else {
                                $c = 0;
                            }
                    // function ยอดยกมา ต้นงวด
                    // transferCWip($wip, )
                    @endphp
                   @if(in_array($cost->cost_code, ['10', '20', '21', '40']) && $loop->first)
                   <tr>
                       <td style="{{ $styleFont16 }}">ยอดยกมาต้นงวด</td>
                       <td style="{{ $styleFont16 }}">
                           {{ $receiveWip }}
                       </td>
                       <td style="{{ $styleFont16 }}">{{ $c }}</td>
                       <td style="{{ $styleFont16 }}">{{ $receiveWip * $masterHumanCost['value'] }} </td>
                       <td style="{{ $styleFont16 }}"> {{ $receiveWip * $masterAfCost['value'] }} </td>
                       <td style="{{ $styleFont16 }}"> {{ $receiveWip *  $masterFixedCost['value']  }}</td>
                       <td style="{{ $styleFont16 }}">
                           {{ $c + ( $receiveWip * $masterHumanCost['value']) + ($receiveWip * $masterAfCost['value']) + ( $receiveWip *  $masterFixedCost['value'])  }}
                       </td>
                   </tr>
                   @endif
                        @if (!$loop->first)
                        <tr>
                            <td style="{{ $styleFont16 }}"> 
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}; font-weight: bold">
                                <b>{{ $masterHumanCost['percent'] = optional(@$masterCostWip[0])->dl_absorption_rate }}
                                    %
                                    ({{ $masterHumanCost['value'] }})
                                </b>
                            </td>
                            <td style="{{ $styleFont16 }}; font-weight: bold">
                                <b>{{ $masterAfCost['percent'] =optional(@$masterCostWip[0])->voh_absorption_rate }}
                                    %
                                    ({{ $masterAfCost['value'] }}) </b>
                            </td>
                            <td style="{{ $styleFont16 }}; font-weight: bold">
                                <b>{{ $masterFixedCost['percent'] =optional(@$masterCostWip[0])->foh_absorption_rate }}
                                    %
                                    ({{ $masterFixedCost['value']  }}) </b>
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                        </tr>
                            <tr>
                                <td style="{{ $styleFont16 }}"> รับมาจากขั้นตอน {{ $afterWipText }}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{@$confirmIssueQtyAfter}}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{ $excel['c27'] = @$excel['c23'][$afterWipCode] }}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{ @$excel['d23'][$afterWipCode] }}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{ @$excel['e23'][$afterWipCode] }}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{ @$excel['f23'][$afterWipCode] }}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{ @$excel['g23'][$afterWipCode] }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td style="{{ $styleBorderLRFont16 }}">วัตถุดิบใช้ไประหว่างงวด</td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                        </tr>
                        @php
                            $sumRawMaterial = 0;
                            $sumRawQty = 0;
                        @endphp
                        @foreach ($dataByTobaccoGroup as $group => $dataByGroup)
                            @php
                                $sumRawMaterial += $dataByGroup->sum('sum_raw_material');
                                $sumRawQty += $dataByGroup->filter(function($i) { return $i->tobacco_group_code != '1080';})->sum('transaction_quantity');
                            @endphp
                            <tr>
                                <td style="{{ $styleFont16 }}"> {{ $group }}
                                    {{ $dataByGroup[0]->tobacco_group }} 
                                </td>
                                <td style="{{ $styleFont16 }}"> 
                                    @if($group == '1080')
                                        0
                                    @else
                                        {{ $dataByGroup->sum('transaction_quantity') }}
                                    @endif
                                </td>
                                <td style="{{ $styleFont16 }}"> {{ $dataByGroup->sum('sum_raw_material') }} </td>
                                <td style="{{ $styleFont16 }}"> </td>
                                <td style="{{ $styleFont16 }}"> </td>
                                <td style="{{ $styleFont16 }}"> </td>
                                <td style="{{ $styleFont16 }}"> </td>
                            </tr>
                        @endforeach
                        {{-- List Item --}}

                        <tr>
                            <td style="{{ $styleFont16 }}">รวมต้นทุนวัตถุดิบใช้ไปในงวด</td>
                            <td style="{{ $styleFont16 }}">{{ $sumRawQty }}</td>
                            <td style="{{ $styleFont16 }}"> {{ $sumRawMaterial }} </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                        </tr>
                        @if(in_array($cost->cost_code, ['10']) && $bathMaster->wip_step == "WIP01")
                        <tr>
                            <td style="{{ $styleFont16 }}">สารหอม</td>
                            <td style="{{ $styleFont16 }}">{{ $sumRawQty - $confirmQty }}</td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                        </tr>
                        @endif
                        <tr>
                            <td style="{{ $styleFont16 }}"> สูญเสีย </td>
                            <td style="{{ $styleFont16 }}"> {{ $lossQty }}
                            </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                        </tr>
                        <tr>
                            <td style="{{ $styleFont16 }}">ยอดผลิตได้ระหว่างงวด</td>
                            <td style="{{ $styleFont16 }}"> {{ $confirmQty }}</td>
                            <td style="{{ $styleFont16 }}">
                                {{ $excel['c20'] = $sumRawMaterial }}
                            </td>
                            <td style="{{ $styleFont16 }}">
                                {{ $excel['d20'] = $confirmQty * $masterHumanCost['value']  }}
                            </td>
                            <td style="{{ $styleFont16 }}">
                                {{ $excel['e20'] = $confirmQty * $masterAfCost['value'] }}
                            </td>
                            <td style="{{ $styleFont16 }}">
                                {{ $excel['f20'] = $confirmQty * $masterFixedCost['value'] }}

                            </td>
                            <td style="{{ $styleFont16 }}">
                                {{ $sumTotalWip = $sumRawMaterial + $excel['d20'] + $excel['e20'] + $excel['f20']  }}
                            </td>
                        </tr>
                        @if(!in_array($cost->cost_code, ['10', '20', '21', '40']) || !$loop->first)
                        <tr>
                            <td style="{{ $styleFont16 }}">คงคลังเช้า</td>
                            <td style="{{ $styleFont16 }}">
                                {{ $receiveWip }}
                            </td>
                            <td style="{{ $styleFont16 }}">{{ $c }}</td>
                            <td style="{{ $styleFont16 }}">{{ $receiveWip * $masterHumanCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $receiveWip * $masterAfCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $receiveWip *  $masterFixedCost['value']  }}</td>
                            <td style="{{ $styleFont16 }}">
                                {{ $c + ( $receiveWip * $masterHumanCost['value']) + ($receiveWip * $masterAfCost['value']) + ( $receiveWip *  $masterFixedCost['value'])  }}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td style="{{ $styleFont16 }}">รวมต้นทุนทั้งสิ้น </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['b22'] = $confirmQty + $receiveWip }} </td>
                            <td style="{{ $styleFont16 }}"> 
                                @php 
                                $excel['c22'] = $sumRawMaterial + $c;
                                @endphp 
                                @if(!$loop->first)
                                {{ $excel['c22'] = $excel['c27'] + $excel['c20'] }} 
                                @else 
                                {{ $excel['c22'] }} 
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                
                                    {{ @$excel['d23'][$afterWipCode] + $excel['d20'] }}
                                @else
                                    {{ $confirmQty * $wageCostAmount + $receiveWip * $wageCostAmount }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['e23'][$afterWipCode] + $excel['e20'] }}
                                @else
                                    {{ $confirmQty * $varyCostAmount + $receiveWip * $varyCostAmount }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['f23'][$afterWipCode] + $excel['f20'] }}
                                @else
                                    {{ $confirmQty * $fixedCost + $receiveWip * $fixedCost }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['g23'][$afterWipCode] + $sumTotalWip }}
                                @else
                                    {{ $g + $c + $receiveWip * $wageCostAmount + $receiveWip * $varyCostAmount + $receiveWip * $fixedCost }}
                                @endif

                            </td>
                        </tr>

                        @php
                            $berforeWipText = @$setupBath[$uData[0]->batch_id][$k + 1];
                        @endphp
                        <tr>
                            <td style="{{ $styleFont16 }}"> โอนไปขั้นตอน
                                {{ optional($berforeWipText)->wip_step }}
                                {{ optional($berforeWipText)->wip_step_desc }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['b23'] = $tranferQty }} </td>
                            <td style="{{ $styleFont16 }}">
                                @if(@$excel['c22'] > 0 && @$excel['b23'] > 0 && @$excel['b22'] > 0)
                                    {{ $excel['c23'][$bathMaster->wip_step] = $excel['c22'] * $excel['b23'] / @$excel['b22']}}
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['d23'][$bathMaster->wip_step]  = $tranferQty * $masterHumanCost['value'] }}</td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['e23'][$bathMaster->wip_step]  = $tranferQty * $masterAfCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['f23'][$bathMaster->wip_step]  = $tranferQty * $masterFixedCost['value'] }}</td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['g23'][$bathMaster->wip_step] = @$excel['c23'][$bathMaster->wip_step] + ( $tranferQty * $wageCostAmount) + ($tranferQty * $varyCostAmount) + ( $tranferQty * $fixedCost) }} </td>
                        </tr>
                        <tr>
                            <td style="{{ $styleFont16 }}"> ยอดปลายงวด (ตามสูตร) </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['b24'] = $tranferWip }} </td>
                            <td style="{{ $styleFont16 }}">
                                @if (@$excel['b24'] > 0 && $excel['c22'] > 0 && $excel['b22'] > 0)
                                    {{ $excel['c24'][$bathMaster->wip_step] = $excel['c22']* $excel['b24'] / $excel['b22'] }}
                                    
                                @else
                                    0
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}">{{ $excel['b24'] * $masterHumanCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['b24'] * $masterAfCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}">{{ $excel['b24'] * $masterFixedCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}">
                               {{ @$excel['c24'][$bathMaster->wip_step] + ($excel['b24'] *$masterHumanCost['value'] ) + ( $excel['b24'] * $masterAfCost['value']) + ($excel['b24'] * $masterFixedCost['value'])}}
                            </td>
                        </tr>
                        @if($loop->last)
                        <tr>
                            <td style="{{ $styleFont16 }}"> ต้นทุนสินค้าสำเร็จรูป </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['b22'] = $confirmQty + $receiveWip }} </td>
                            <td style="{{ $styleFont16 }}"> 
                                @php 
                                $excel['c22'] = $sumRawMaterial + $c;
                                @endphp 
                                @if(!$loop->first)
                                {{ $excel['c22'] = $excel['c27'] + $excel['c20'] }} 
                                @else 
                                {{ $excel['c22'] }} 
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                
                                    {{ @$excel['d23'][$afterWipCode] + $excel['d20'] }}
                                @else
                                    {{ $confirmQty * $wageCostAmount + $receiveWip * $wageCostAmount }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['e23'][$afterWipCode] + $excel['e20'] }}
                                @else
                                    {{ $confirmQty * $varyCostAmount + $receiveWip * $varyCostAmount }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['f23'][$afterWipCode] + $excel['f20'] }}
                                @else
                                    {{ $confirmQty * $fixedCost + $receiveWip * $fixedCost }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['g23'][$afterWipCode] + $sumTotalWip }}
                                @else
                                    {{ $g + $c + $receiveWip * $wageCostAmount + $receiveWip * $varyCostAmount + $receiveWip * $fixedCost }}
                                @endif

                            </td>
                        </tr>
                        @endif
                        @php
                            $afterWipText = $bathMaster->wip_step . $bathMaster->wip_step_desc;
                            $afterWipCode = $bathMaster->wip_step;
                        @endphp
                        @endforeach
                </tbody>
                @if ($loop->parent->first && $loop->first)
                    <tr>
                        <td colspan="7"> </td>
                    </tr>
                    <tr>
                        <td colspan="7"> </td>
                    </tr>
                    <tr>
                        <td colspan="7"> </td>
                    </tr>
                @endif

            </table>
        @endforeach
    @endforeach
</body>

</html>
