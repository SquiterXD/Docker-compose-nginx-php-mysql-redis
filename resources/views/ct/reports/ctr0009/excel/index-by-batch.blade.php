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
        $sysdate = Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i');
    @endphp

    @foreach ($datas->groupBy('batch_no') as $batchNo => $uData)
        @foreach ($uData->groupBy('f_transaction_date') as $date => $dataByDate)
            <table class="table">
                <thead>
                    @if ($loop->parent->first && $loop->first)
                        <tr>
                            <td style="{{ $font18 }}"> <b> โปรแกรม : CTR0004 </b>  </td>
                            <td style="{{ $font18 }}" colspan="5" align="center"> <b> การยาสูบแห่งประเทศไทย </b>  </td>
                            <td  align="center"  style="{{ $font18 }}"><b> วันที่พิมพ์ : </b> {{ $sysdate }} </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="{{ $font18 }}" colspan="5" align="center"> <b>รายงานบัตรต้นทุนประจำวัน  ({{ $cost->cost_code. ' ' . $cost->description }}) </b></td>
                            <td></td>
                        </tr>
                    @endif
                    <tr>
                        <td style="{{ $font18 }}"><b>  วันที่เริ่มผลิต : {{ Carbon\Carbon::create($datas[0]->plan_start_date)->addYear('543')->format('d/m/Y') }} </b></td>
                        <td style="{{ $font18 }}" colspan="5"></td>
                        <td style="{{ $font18 }}"> <b> ประจำวันที่ : {{ Carbon\Carbon::create($date)->addYear('543')->format('d/m/Y')  }} </b></td>
                    </tr>
                    <tr>
                        <td style="{{ $font18 }}"> <b>วันที่ผลิตเสร็จ : {{ Carbon\Carbon::create($datas[0]->plan_cmplt_date)->addYear('543')->format('d/m/Y') }} </b></td>
                        <td colspan="5"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="{{ $font18 }}"><b> เลขที่คำสั่งผลิต :{{ $batchNo }} </b></td>
                        <td colspan="5"></td>
                        <td></td>
                    </tr>
                    <tr >
                        <td style="{{ $font18 }}"> <b>  รหัสสินค้า/ชื่อสินค้า :
                            {{ $datas[0]->product_item_number . ' ' . $datas[0]->product_item_desc }} </b> </td>
                        <td colspan="5"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="center"  style="{{ $styleFont16  }}"  rowspan="2"><b> รายการ </b> </td>
                        <td align="center"  style="{{ $styleFont16 }}" colspan="2"><b> ต้นทุนคิดเข้างาน </b> </td>
                        <td align="center"  style="{{ $styleFont16 }}"><b>  {{ number_format($dataByDate[0]->wage_cost, 9) }}  </b> </td>
                        <td align="center"  style="{{ $styleFont16 }}"><b>  {{ number_format($dataByDate[0]->vary_cost, 9) }}  </b> </td>
                        <td align="center"  style="{{ $styleFont16 }}"><b>  {{ number_format($dataByDate[0]->fixed_cost, 9) }}  </b> </td>
                        <td align="center"  style="{{ $styleFont16 }}" rowspan="2"><b> รวมต้นทุนคิดเข้างาน </b> </td>
                    </tr>
                    <tr>
                        {{-- <td align="center" style="{{ $styleBorderLRBTFont16 }}" ></td> --}}
                        <td align="center" style="{{ $styleFont16 }}" ><b> ปริมาณ 1.00 พันมวน </b></td>
                        <td align="center" style="{{ $styleFont16 }}" ><b> วัตถุดิบ </b></td>
                        <td align="center" style="{{ $styleFont16 }}" ><b> ค่าแรง </b></td>
                        <td align="center" style="{{ $styleFont16 }}" ><b> ค่าใช้จ่ายผันแปร </b></td>
                        <td align="center" style="{{ $styleFont16 }}" ><b> ค่าใช้จ่ายคงที่ </b></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $tranferData = [];
                    @endphp
                    @foreach ($dataByDate->groupBy('oprn_code') as $wip => $dataByWip)
                        @php

                            $wageCostAmount = $dataByDate[0]->wage_cost * ($dataByWip[0]->dl_absorption_rate * 0.01);
                            $varyCostAmount = $dataByDate[0]->vary_cost * ($dataByWip[0]->dl_absorption_rate * 0.01);
                            $fixedCost = $dataByDate[0]->fixed_cost * ($dataByWip[0]->dl_absorption_rate * 0.01);

                            /////
                            $sumRawMaterial = 0;
                            $productWipV = productWipV($dataByDate[0]->batch_id, $wip, $date);
                            $receiveWip =  $productWipV->receive_wip / $dataByWip[0]->cost_quantity;


                            $sumMaterial =               $dataByWip->sum('sum_raw_material');
                            
                            if (!$loop->first){
                                $sumMaterial =  ($dataByWip->sum('sum_raw_material') + $c) + $tranferData[$dataByWip[0]->previous_wip]['tranfer_raw_mat'];
                            }
                                
                            $c  =  ($productWipV->conv_transaction_quantity  * ($receiveWip)) == 0 
                                    ? 0
                                    :  ($productWipV->conv_transaction_quantity  * ($receiveWip)) / $dataByWip->sum('sum_raw_material');

                            $g =    $dataByWip->sum('sum_raw_material') +
                                    ($productWipV->conv_transaction_quantity * $wageCostAmount) +
                                    ($productWipV->conv_transaction_quantity * $varyCostAmount) +
                                    ($productWipV->conv_transaction_quantity * $fixedCost);

                            $tranferQty =   $productWipV->transfer_qty / $dataByWip[0]->cost_quantity;
                            $sumTranfer = (($dataByWip->sum('sum_raw_material') + $c) * $tranferQty) / ($productWipV->conv_transaction_quantity + $receiveWip) +
                                            ($tranferQty * $wageCostAmount)+
                                            ($tranferQty * $varyCostAmount)+
                                            ($tranferQty * $fixedCost);

                            $tranferWip = $productWipV->transfer_wip /$dataByWip[0]->cost_quantity;

                            $tranferData[$wip]['tranfer_qty']        =  $tranferQty;
                            $tranferData[$wip]['tranfer_raw_mat']    =  (($dataByWip->sum('sum_raw_material') + $c) * $tranferQty) / ($productWipV->conv_transaction_quantity + $receiveWip);
                            $tranferData[$wip]['tranfer_wage']       =  $tranferQty * $wageCostAmount;
                            $tranferData[$wip]['tranfer_vary']       =  $tranferQty * $varyCostAmount;
                            $tranferData[$wip]['tranfer_fixed']      =  $tranferQty * $fixedCost;
                            $tranferData[$wip]['tranfer_sum']        =  $sumTranfer;

                        @endphp
                        <tr>
                            <td colspan="3"   style="{{ $styleFont16  }}"> <b> ขั้นตอน {{ $wip }} : {{ $dataByWip[0]->oprn_desc }} </b> </td>
                            <td  style="{{ $styleFont16  }}"> <b> {{ $dataByWip[0]->dl_absorption_rate }} %
                                ({{ $wageCostAmount }}) </b>
                            </td>
                            <td  style="{{ $styleFont16  }}"><b> {{ $dataByWip[0]->voh_absorption_rate }} %
                                ({{ $varyCostAmount }}) </b></td>
                            <td  style="{{ $styleFont16  }}"><b>  {{ $dataByWip[0]->foh_absorption_rate }} %
                                ({{ $fixedCost }})</b> </td>
                            <td  style="{{ $styleFont16  }}"></td>
                        </tr>
                        @if (!$loop->first)
                            <tr>
                                <td style="{{ $styleFont16 }}"> รับมาจากขั้นตอน {{ $dataByWip[0]->previous_wip }} </td>
                                <td style="{{ $styleFont16 }}"> {{ $tranferData[$dataByWip[0]->previous_wip]['tranfer_qty'] }} </td>
                                <td style="{{ $styleFont16 }}"> {{ $tranferData[$dataByWip[0]->previous_wip]['tranfer_raw_mat'] }} </td>
                                <td style="{{ $styleFont16 }}"> {{ $tranferData[$dataByWip[0]->previous_wip]['tranfer_wage'] }} </td>
                                <td style="{{ $styleFont16 }}"> {{ $tranferData[$dataByWip[0]->previous_wip]['tranfer_vary'] }} </td>
                                <td style="{{ $styleFont16 }}"> {{ $tranferData[$dataByWip[0]->previous_wip]['tranfer_fixed'] }} </td>
                                <td style="{{ $styleFont16 }}"> {{ $tranferData[$dataByWip[0]->previous_wip]['tranfer_sum'] }} </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="7"  style="{{ $styleBorderLRFont16 }}"> <b>วัตถุดิบใช้ไประหว่างงวด</b>  </td>
                        </tr>

                        @foreach ($dataByWip->sortBy('tobacco_group_code')->groupBy('tobacco_group_code') as $group => $dataByGroup)
                            @php
                                $sumRawMaterial += $dataByGroup->sum('sum_raw_material');
                            @endphp
                            <tr>
                                <td style="{{ $styleFont16 }}" > {{ $group }} {{ $dataByGroup[0]->tobacco_group }} </td>
                                <td style="{{ $styleFont16 }}"> {{ $dataByGroup->sum('transaction_quantity') }} </td>
                                <td style="{{ $styleFont16 }}"> {{ $dataByGroup->sum('sum_raw_material') }} </td>
                                <td style="{{ $styleFont16 }}"> </td>
                                <td style="{{ $styleFont16 }}"> </td>
                                <td style="{{ $styleFont16 }}"> </td>
                                <td style="{{ $styleFont16 }}"> </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="{{ $styleFont16 }}" ><b> รวมต้นทุนวัตถุดิบใช้ไปในงวด </b>  </td>
                            <td style="{{ $styleFont16 }}" > </td>
                            <td style="{{ $styleFont16 }}" > <b>{{ $dataByWip->sum('sum_raw_material') }}</b>  </td>
                            <td style="{{ $styleFont16 }}" > </td>
                            <td style="{{ $styleFont16 }}" > </td>
                            <td style="{{ $styleFont16 }}" > </td>
                            <td style="{{ $styleFont16 }}" > </td>
                        </tr>
                        <tr>
                            <td style="{{ $styleFont16 }}"> <b>สูญเสีย</b>  </td>
                            <td style="{{ $styleFont16 }}">
                                <b>{{ $productWipV->loss_qty }}</b>
                                
                            </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                        </tr>
                        <tr>
                            <td style="{{ $styleFont16 }}"> <b>ยอดผลิตได้ระหว่างงวด</b>  </td>
                            <td style="{{ $styleFont16 }}"> <b> {{ $productWipV->conv_transaction_quantity }} </b></td>
                            <td style="{{ $styleFont16 }}"> <b> {{ $dataByWip->sum('sum_raw_material') }}  </b></td>
                            <td style="{{ $styleFont16 }}"> <b> {{ $productWipV->conv_transaction_quantity * $wageCostAmount }}  </b></td>
                            <td style="{{ $styleFont16 }}"> <b> {{ $productWipV->conv_transaction_quantity * $varyCostAmount }} </b> </td>
                            <td style="{{ $styleFont16 }}"> <b> {{ $productWipV->conv_transaction_quantity * $fixedCost }} </b> </td>
                            <td style="{{ $styleFont16 }}"> <b> {{ $g }} </b>
                            </td>
                        </tr>
                        @if (!$loop->last)
                            <tr>
                                <td style="{{ $styleFont16 }}"><b> คงคลังเช้า </b></td>
                                <td style="{{ $styleFont16 }}"><b>  {{ $receiveWip }} </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ $c }} </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ $receiveWip * $wageCostAmount }} </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ $receiveWip * $varyCostAmount }} </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ $receiveWip * $fixedCost }} </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ $c +                                         
                                        ($receiveWip * $wageCostAmount) + 
                                        ($receiveWip * $varyCostAmount) + 
                                        ($receiveWip * $fixedCost)
                                    }} </b>
                                 </td>
                            </tr>
                        @endif

                        @if (!$loop->last)
                        {{-- {{ dd($tranferData, $dataByWip[0]->previous_wip) }} --}}
                        {{-- {{ $tranferData[$dataByWip[0]->previous_wip]['tranfer_raw_mat'] }} --}}
                            <tr>
                                <td style="{{ $styleFont16 }}"><b> รวมต้นทุนทั้งสิ้น </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ $productWipV->conv_transaction_quantity + $receiveWip }} </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ $sumMaterial }}</b></td>
                                <td style="{{ $styleFont16 }}"><b>
                                    @if (!$loop->first)
                                        {{ ($productWipV->conv_transaction_quantity * $wageCostAmount) +  
                                        ($receiveWip * $wageCostAmount) + 
                                        $tranferData[$dataByWip[0]->previous_wip]['tranfer_wage'] }} 
                                    @else
                                        {{ ($productWipV->conv_transaction_quantity * $wageCostAmount) +  
                                            ($receiveWip * $wageCostAmount) 
                                        }} 
                                    @endif
                                     </b>
                                </td>
                                <td style="{{ $styleFont16 }}"><b>
                                    @if (!$loop->first)
                                        {{ ($productWipV->conv_transaction_quantity * $varyCostAmount) +  
                                        ($receiveWip * $varyCostAmount) + 
                                        $tranferData[$dataByWip[0]->previous_wip]['tranfer_vary'] }} 
                                    @else
                                        {{ ($productWipV->conv_transaction_quantity * $varyCostAmount) +  ($receiveWip * $varyCostAmount) }} 
                                    @endif
                                    </b>
                                </td>
                                <td style="{{ $styleFont16 }}"><b>
                                    @if (!$loop->first)
                                        {{($productWipV->conv_transaction_quantity * $fixedCost) +  
                                        ($receiveWip * $fixedCost) + 
                                        $tranferData[$dataByWip[0]->previous_wip]['tranfer_fixed'] }} 
                                    @else
                                        {{($productWipV->conv_transaction_quantity * $fixedCost) +  ($receiveWip * $fixedCost) }} 
                                    @endif
                                    </b>
                                     {{-- {{($productWipV->conv_transaction_quantity * $fixedCost) +  ($receiveWip * $fixedCost) }}  --}}
                                </td>
                                <td style="{{ $styleFont16 }}"><b>
                                    @if (!$loop->first)
                                       {{  $g + $c +                                         
                                        ($receiveWip * $wageCostAmount) + 
                                        ($receiveWip * $varyCostAmount) + 
                                        ($receiveWip * $fixedCost) +
                                        $tranferData[$dataByWip[0]->previous_wip]['tranfer_sum']  }} 
                                    @else
                                        {{  $g + $c +                                         
                                        ($receiveWip * $wageCostAmount) + 
                                        ($receiveWip * $varyCostAmount) + 
                                        ($receiveWip * $fixedCost) 
                                        }} 
                                    @endif
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td style="{{ $styleFont16 }}"> <b> โอนไปขั้นตอน {{ $dataByWip[0]->next_wip }} บรรจุหีบ  </b> </td>
                                <td style="{{ $styleFont16 }}"> <b> {{ $tranferQty }}  </b> </td>
                                <td style="{{ $styleFont16 }}"> <b> {{ (($dataByWip->sum('sum_raw_material') + $c) * $tranferQty) / ($productWipV->conv_transaction_quantity + $receiveWip)   }}  </b> </td>
                                <td style="{{ $styleFont16 }}"> <b> {{ $tranferQty * $wageCostAmount  }}  </b> </td>
                                <td style="{{ $styleFont16 }}"> <b> {{ $tranferQty * $varyCostAmount}}  </b> </td>
                                <td style="{{ $styleFont16 }}"> <b> {{ $tranferQty * $fixedCost}} </b>  </td>
                                <td style="{{ $styleFont16 }}"> <b> {{ $sumTranfer }}  </b> </td>
                            </tr>
                            <tr>
                                <td style="{{ $styleFont16 }}"> <b> ยอดปลายงวด (ตามสูตร)  </b></td>
                                <td style="{{ $styleFont16 }}"> <b> {{ $tranferWip }} </b> </td>
                                <td style="{{ $styleFont16 }}"> <b> {{ (($dataByWip->sum('sum_raw_material') + $c) * $tranferWip) / ($productWipV->conv_transaction_quantity + $receiveWip) }}   </b></td>
                                <td style="{{ $styleFont16 }}"> <b> {{ $tranferWip* $wageCostAmount }}  </b></td>
                                <td style="{{ $styleFont16 }}"> <b> {{ $tranferWip* $varyCostAmount }} </b> </td>
                                <td style="{{ $styleFont16 }}"> <b> {{ $tranferWip* $fixedCost }}  </b> </td>
                                <td style="{{ $styleFont16 }}"> <b> {{ 
                                    (($dataByWip->sum('sum_raw_material') + $c) * $tranferWip) / ($productWipV->conv_transaction_quantity + $receiveWip) + 
                                    ($tranferWip* $wageCostAmount ) +
                                    ($tranferWip* $varyCostAmount)+
                                    ($tranferWip* $fixedCost)

                                    }}</b> </td>
                            </tr>
                        @endif
                        @if ($loop->last)
                            <tr>
                                <td style="{{ $styleFont16 }}"><b> ต้นทุนสินค้าสำเร็จรูป  </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ $productWipV->conv_transaction_quantity  }}  </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ $dataByWip->sum('sum_raw_material')   + $tranferData[$dataByWip[0]->previous_wip]['tranfer_raw_mat']}}  </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ ($productWipV->conv_transaction_quantity * $wageCostAmount )  + $tranferData[$dataByWip[0]->previous_wip]['tranfer_wage']}}  </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ ($productWipV->conv_transaction_quantity * $varyCostAmount )  + $tranferData[$dataByWip[0]->previous_wip]['tranfer_vary']}}  </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ ($productWipV->conv_transaction_quantity * $fixedCost) + $tranferData[$dataByWip[0]->previous_wip]['tranfer_fixed']}}  </b></td>
                                <td style="{{ $styleFont16 }}"><b> {{ $g + $tranferData[$dataByWip[0]->previous_wip]['tranfer_sum'] }} </b> </td>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="7"></th>
                        </tr>
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
