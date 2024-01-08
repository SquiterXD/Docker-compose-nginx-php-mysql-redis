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
        $firstWip = $wipList->first();
        $lastWip = $wipList->last();
    @endphp

    @php 
    $dataLevel1 = $datas->where('level_no', 1);
    @endphp
    @foreach ($dataLevel1->sortBy('transaction_date')->groupBy('transaction_date') as $date => $uData)
    @foreach ($uData->sortBy('item_number')->groupBy('batch_no') as $batchNo => $dataByDate)
    @php 
    $sysdate = Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i');
    $firstLine = $dataByDate->first();
    $costDesc = $firstLine->cost_code . " " . $firstLine->cost_description;
    $deptDesc = $firstLine->department_code . " " . $firstLine->department_description;
    @endphp
    <table class="table">
                <thead>
                    {{-- @if ($loop->parent->first && $loop->first) --}}
                        <tr>
                            <td style="{{ $font18 }}"> <b> โปรแกรม : CTR0004 </b> </td>
                            <td style="{{ $font18 }}" colspan="5" align="center"> <b> การยาสูบแห่งประเทศไทย </b>
                            </td>
                            <td style="{{ $font18 }}" align="right">
                                <b> วันที่พิมพ์ : </b> {{ $sysdate }}<br>
                            </td>
                        </tr>
                        <tr>
                            <td style="{{ $font18 }}">
                                <b> วันที่เริ่มผลิต :
                                {{ parseToDateTh($dataByDate[0]->batch_start_date) }}
                            </b>
                            </td>
                            <td style="{{ $font18 }}" colspan="5" align="center"> <b>รายงานบัตรต้นทุนประจำวัน
                                    ({{ $costDesc }})
                                </b></td>
                        </tr>
                        <tr>
                            <td style="{{ $font18 }}">
                                <b>วันที่ผลิตเสร็จ :
                                    {{ parseToDateTh($dataByDate[0]->batch_end_date) }}
                                </b>
                            </td>
                            <td  style="{{ $font18 }}"  colspan="5" align="center"><b> ประจำวันที่ :
                                {{ Carbon\Carbon::create($date)->addYear('543')->format('d/m/Y') }} </b></td>
                        </tr>
                    {{-- @endif --}}
                    <tr>
                        <td style="{{ $font18 }}"><b> เลขที่คำสั่งผลิต :{{ $batchNo }} </b></td>
                        <td style="{{ $font18 }}" colspan="5"></td>
                        <td style="{{ $font18 }}"> </td>
                    </tr>
                    <tr>
                        <td style="{{ $font18 }}">
                            <b> รหัสสินค้า/ชื่อสินค้า : {{ $dataByDate[0]->item_number . ' ' . $dataByDate[0]->item_description }} </b>
                        </td>
                        <td style="{{ $font18 }}" colspan="5" align="center">
                            <b>หน่วยงาน: {{ $deptDesc }}</b>
                        </td>
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
                        <td align="center" style="{{ $styleFont16 }}"><b> ปริมาณ {{number_format($dataByDate[0]->cost_quantity, 2)}} {{$dataByDate[0]->cost_uom}} </b></td>
                        <td align="center" style="{{ $styleFont16 }}"><b> วัตถุดิบ </b></td>
                        <td align="center" style="{{ $styleFont16 }}"><b> ค่าแรง </b></td>
                        <td align="center" style="{{ $styleFont16 }}"><b> ค่าใช้จ่ายผันแปร </b></td>
                        <td align="center" style="{{ $styleFont16 }}"><b> ค่าใช้จ่ายคงที่ </b></td>
                    </tr>
                </thead>

                <tbody>
                    @php 
                        $totalWage = 0;
                        $totalFixed = 0;
                        $totalVary = 0;
                        $wipStep = $datas->where('level_no', '2')->where('batch_no',$batchNo)->where('transaction_date', $date)->sortBy('wip_step');
                    @endphp
                    @foreach($wipStep as $k => $wip)
                    @php 
                
                        $dlAbsorptionAmount = $dataByDate[0]->wage_cost * $wip->dl_absorption_rate / 100;
                        $vohAbsorbtionAmount = $dataByDate[0]->vary_cost * $wip->voh_absorption_rate / 100;
                        $fohAbsorptionAmount = $dataByDate[0]->fixed_cost * $wip->foh_absorption_rate / 100;
                    @endphp
                    <tr>
                        <td style="{{ $styleFont16 }}"><b>ขั้นตอน {{$wip->wip_step}} {{$wip->wip_desc}}</b></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}">{{$wip->dl_absorption_rate}}% ({{ $dlAbsorptionAmount }})</td>
                        <td align="right" style="{{ $styleFont16 }}">{{$wip->voh_absorption_rate}}% ({{ $vohAbsorbtionAmount }})</td>
                        <td align="right" style="{{ $styleFont16 }}">{{$wip->foh_absorption_rate}}% ({{ $fohAbsorptionAmount }})</td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                    </tr>
                    @if(in_array(request()->cost_code, ['11', '12', '42']) && $wip->wip_step == $firstWip->wip_step)
                    {{-- @if(in_array(request()->cost_code, ['11', '12', '42']) && $loop->first) --}}
                        <tr>
                            <td style="{{ $styleFont16 }}">ยอดยกมาต้นงวด</td>
                            <td align="right" style="{{ $styleFont16 }}">{{ $wip->beginning_qty ?? 0}}</td>
                            <td align="right" style="{{ $styleFont16 }}">{{ $wip->beginning_amount ?? 0 }}</td>
                            <td align="right" style="{{ $styleFont16 }}">{{ $wip->begin_wage_amount }}</td>
                            <td align="right" style="{{ $styleFont16 }}">{{ $wip->begin_vary_amount }}</td>
                            <td align="right" style="{{ $styleFont16 }}">{{ $wip->begin_fixed_amount }}</td>
                            <td align="right" style="{{ $styleFont16 }}">{{ $wip->beginning_amount + $wip->begin_wage_amount + $wip->begin_vary_amount + $wip->begin_fixed_amount }}</td>
                        </tr>
                    @endif
                   
                    @if($wip->wip_step != $firstWip->wip_step)
                    <tr>
                        <td style="{{ $styleFont16 }}">รับมาจากขั้นตอน {{optional(@$wipStep[$k-1])->wip_step ?? 'WIP0'. (substr($wip->wip_step,4,1) - 1)}} {{optional(@$wipStep[$k-1])->wip_desc}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{$wip->receive_qty ?? 0}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{$wip->receive_amount ?? 0}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{optional(@$wipStep[$k-1])->confirm_iss_wage_amount ?? 0}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{optional(@$wipStep[$k-1])->confirm_iss_vary_amount ?? 0}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{optional(@$wipStep[$k-1])->confirm_iss_fixed_amount ?? 0}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->receive_amount+ optional(@$wipStep[$k-1])->confirm_iss_wage_amount +  optional(@$wipStep[$k-1])->confirm_iss_vary_amount + optional(@$wipStep[$k-1])->confirm_iss_fixed_amount }}</td>

                    </tr>
                    @endif
                     <tr>
                        <td style="{{ $styleFont16 }}">วัตถุดิบใช้ไประหว่างงวด</td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>

                    </tr>
                    @php 
                        $itemWip = $datas->where('level_no', '3')->where('batch_no', $batchNo)->where('transaction_date', $date)->where('wip_step', $wip->wip_step)->sortBy('tobacco_group_code');
                    @endphp
                    @foreach ($itemWip as $item)
                    <tr>
                        <td  style="{{ $styleFont16 }}">{{ $item->tobacco_group_code }} {{ $item->tobacco_group }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{$item->ingredient_quantity}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $item->ingredient_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>

                    </tr>
                    @endforeach
                    <tr>
                        <td style="{{ $styleFont16 }}">รวมต้นทุนวัตถุดิบใช้ไปในงวด</td>
                        <td align="right" style="{{ $styleFont16 }}">{{$wip->ingredient_quantity}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ingredient_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>

                    </tr>
                    @if(in_array(request()->cost_code, ['11']) && $wip->wip_step == $firstWip->wip_step)
                        <tr>
                            <td style="{{ $styleFont16 }}">สารหอม</td>
                            <td style="{{ $styleFont16 }}">{{ $wip->ingredient_quantity - $wip->confirm_qty }}</td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                        </tr>
                    @endif
                    <tr>
                        <td style="{{ $styleFont16 }}">สูญเสีย</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->loss_qty }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->loss_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                    </tr>
                    <tr>
                        <td style="{{ $styleFont16 }}">ยอดผลิตได้ระหว่างงวด</td>
                        @php 
                            $totalWage += $wip->confirm_wage_amount;
                            $totalVary += $wip->confirm_vary_amount;
                            $totalFixed += $wip->confirm_fixed_amount;
                        @endphp 
                        <td align="right" style="{{ $styleFont16 }}">{{$wip->confirm_qty }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_wage_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_vary_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_fixed_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_amount + $wip->confirm_wage_amount + $wip->confirm_vary_amount + $wip->confirm_fixed_amount }}</td>
                    </tr>
                    @if(!in_array(request()->cost_code, ['11', '12', '42', '14']) || $wip->wip_step != $firstWip->wip_step)
                    <tr>
                        <td style="{{ $styleFont16 }}">คงคลังเช้า</td>
                        <td align="right" style="{{ $styleFont16 }}">{{$wip->beginning_qty ?? 0}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->beginning_amount ?? 0 }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->begin_wage_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->begin_vary_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->begin_fixed_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->beginning_amount + $wip->begin_wage_amount  + $wip->begin_vary_amount + $wip->begin_fixed_amount}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="{{ $styleFont16 }}">
                            @if(in_array(request()->cost_code, [13]) && $wip->wip_step == $lastWip->wip_step)
                            ต้นทุนสินค้าสำเร็จรูป
                            @else
                            รวมต้นทุนทั้งสิ้น
                            @endif
                        </td>
                        <td align="right" style="{{ $styleFont16 }}">{{$wip->wip_total_qty}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->wip_total_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->wip_total_wage_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->wip_total_vary_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->wip_total_fixed_amount }}</td>
                        {{-- <td align="right" style="{{ $styleFont16 }}">{{ $totalWage }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $totalVary }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $totalFixed }}</td> --}}
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->wip_total_amount + $wip->wip_total_wage_amount + $wip->wip_total_vary_amount + $wip->wip_total_fixed_amount }}</td>
                    </tr>
                    {{-- <tr>
                        <td style="{{ $styleFont16 }}">รวมต้นทุนทั้งสิ้น</td>
                        <td align="right" style="{{ $styleFont16 }}">{{$wip->confirm_issue_qty}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_issue_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_iss_wage_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_iss_vary_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_iss_fixed_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}"></td>
                    </tr> --}}
                    {{-- @if(!$loop->last) --}}
                    <tr>
                        <td style="{{ $styleFont16 }}">โอนไปขั้นตอน {{ optional(@$wipStep[$k+1])->wip_step}} {{ optional(@$wipStep[$k+1])->wip_desc}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{$wip->confirm_issue_qty}}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_issue_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_iss_wage_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_iss_vary_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_iss_fixed_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->confirm_issue_amount+$wip->confirm_iss_wage_amount + $wip->confirm_iss_vary_amount+ $wip->confirm_iss_fixed_amount   }}</td>
                    </tr>
                    {{-- @endif --}}
                    @if(in_array(request()->cost_code, [13]))
                    @if($wip->wip_step != $lastWip->wip_step)
                    <tr>
                        <td style="{{ $styleFont16 }}">ยอดปลายงวด (ตามสูตร)</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_qty }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_wage_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_vary_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_fixed_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_amount + $wip->ending_wage_amount + $wip->ending_vary_amount  + $wip->ending_fixed_amount  }}</td>
                    </tr>
                    @endif
                    @else 
                    <tr>
                        <td style="{{ $styleFont16 }}">ยอดปลายงวด (ตามสูตร)</td>
                        
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_qty }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_wage_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_vary_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_fixed_amount }}</td>
                        <td align="right" style="{{ $styleFont16 }}">{{ $wip->ending_amount + $wip->ending_wage_amount + $wip->ending_vary_amount  + $wip->ending_fixed_amount  }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>


                {{-- <tbody>
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
                            
                            $c = $confirmQty * $receiveWip == 0 ? 0 : ($confirmQty * $receiveWip) / optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material');
                            
                            $g = optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') + $confirmQty * $wageCostAmount + $confirmQty * $varyCostAmount + $confirmQty * $fixedCost;
                            
                            $sumMaterial = optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material');
                            
                            if (!$loop->first) {
                                $sumMaterial = optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') + $c + @$tranferData[optional(@$dataByOprnCode[$bathMaster->wip_step][0])->previous_wip]['tranfer_raw_mat'];
                            }
                            // dd(optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material'));
                            if (optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') > 0) {
                                // $sumTranfer = ((optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') + $c) * $tranferQty) / ($confirmQty + $receiveWip) + ($tranferQty * $wageCostAmount) + ($tranferQty * $varyCostAmount) + ($tranferQty * $fixedCost);
                            }
                            if (optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity > 0) {
                                // $tranferWip = $confirmQty / optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity;
                            }

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
                        @endphp
                        @if(in_array($cost->cost_code, ['11', '12', '42']) && $loop->first)
                        <tr>
                            <td style="{{ $styleFont16 }}">ยอดยกมาต้นงวด</td>
                            <td style="{{ $styleFont16 }}">
                                {{ $receiveWip }}
                            </td>
                            <td style="{{ $styleFont16 }}">
                                {{ $c }}
                            </td>
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
                                    ({{ $masterHumanCost['value']  }})
                                </b>
                            </td>
                            <td style="{{ $styleFont16 }}; font-weight: bold">
                                <b>{{ $masterAfCost['percent'] =optional(@$masterCostWip[0])->voh_absorption_rate }}
                                    %
                                    ({{ $masterAfCost['value']  }}) </b>
                            </td>
                            <td style="{{ $styleFont16 }}; font-weight: bold">
                                <b>{{ $masterFixedCost['percent'] =optional(@$masterCostWip[0])->foh_absorption_rate }}
                                    %
                                    ({{ $masterFixedCost['value'] }}) </b>
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
                                    {{ $dataByGroup[0]->tobacco_group }} </td>
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

                        <tr>
                            <td style="{{ $styleFont16 }}">รวมต้นทุนวัตถุดิบใช้ไปในงวด</td>
                            <td style="{{ $styleFont16 }}">{{ $sumRawQty }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $sumRawMaterial }} </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                        </tr>
                        @if(in_array($cost->cost_code, ['11']) && $bathMaster->wip_step == "WIP01")
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
                        @if(!in_array($cost->cost_code, ['11', '12', '42', '14']) || !$loop->first)
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
                </tbody> --}}
                {{-- @if ($loop->parent->first && $loop->first)
                    <tr>
                        <td colspan="7"> </td>
                    </tr>
                    <tr>
                        <td colspan="7"> </td>
                    </tr>
                    <tr>
                        <td colspan="7"> </td>
                    </tr>
                @endif --}}

            </table>
        @endforeach
    @endforeach
</body>

</html>
