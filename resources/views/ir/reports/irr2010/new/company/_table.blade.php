<div class="page-break">
    <div class="page-break"></div>
<table class="table" width="100%">
    <thead>
        {{-- <tr>
            <th align="left" width="29%" colspan="2"> <b> โปรแกรม : {{$program->program_code}} </b> </th>
            <th align="center" colspan="3"> <b> การยาสูบแห่งประเทศไทย </b> </th>
            <th></th>
            <th align="right" colspan="2"><b> วันที่ : {{ ' '. parseToDateTh(now()) }}</b> </th>
        </tr>
        <tr>
            <th align="left" colspan="2"> <b> สั่งพิมพ์ : {{ Auth::user()->username }} </b> </th>
            <th align="center" colspan="3"> <b> ชุดที่:  {{ $policySetDes }}</b>  </th>
            <th></th>
            <th align="right" colspan="2"> <b> เวลา : {{ date('H:i', strtotime(now())) }}</b> </th>
        </tr>
        <tr>
            <th colspan="2"> </th>
            <th align="center" colspan="3"> <b> {{$program->description}} </b>  </th>
            <th></th>
            <th align="right" style="padding-top:-10px; padding-right: 30px; vertical-align: top;" colspan="2"> <b> หน้า : </b> </th>
        </tr>
        <tr>
            <th align="left" colspan="2"> <b> {{ ucfirst($reportType) }} </b> </th>
            <th align="center" colspan="3">
                <b> {{ $companies->where('company_id', $companyId)->first()->company_name }}</b>  
            </th>
            <th></th> 
            <th align="right"></th>
            <th align="left"></th>
        </tr> --}}
        <tr>
            <th align="left" width="29%" colspan="2"> {{ ucfirst($reportType) }} </th>
            <th align="center" colspan="3"> <b>  ชุดที่:  {{ $policySetDes }} </b> </th>
            <th></th>
            <th align="right" colspan="2"><b></th>
        </tr>
        <tr style="background-color: #c4c4c4">
            <th style="border: 1px solid black" align="center" width="4%">ลำดับ</th>
            <th style="border: 1px solid black" align="center" colspan="2">รายการ</th>
            <th style="border: 1px solid black" align="center" width="15%">มูลค่าทุนประกัน</th>
            <th style="border: 1px solid black" align="center" width="15%">อัตราเบี้ยประกัน</th>
            <th style="border: 1px solid black" align="center" width="15%">ค่าเบี้ยประกัน {{ $ptirPolicyGroupDist[0]->company_percent }}% </th>
            <th style="border-top: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; border-right: 2px solid black;" align="center" width="15%" colspan="2">คำนวณปิดบัญชี</th>
        </tr>
    </thead>
        <tbody>
            @php
                $totalCA  = 0;
                $totalItemAccountClosing = 0;
            @endphp
            @foreach ($ptirStockHeader->sortBy('asset_group_code')->groupBy(function($item) {
                return $item->asset_group_desc;
            })
            as $assetGroups =>  $assetGroupLines)
                <tr>
                    <td style="border-left: 1px solid #000" align="center">{{ $loop->iteration }}</td>
                    <td style="border-left: 1px solid #000;" colspan="2"> <b>{{$assetGroups }}</b> </td>
                    <td class="td-b-rl"> </td>
                    <td class="td-b-rl"></td>
                    <td class="td-b-rl"></td>
                    <td class="td-b-r" colspan="2" style="border-right: 2px solid black;"></td>
                </tr>

                @foreach ($assetGroupLines->groupBy('stock_list_description') as $subInvDes => $subInvLines)
                @php
                    $sumCA  = 0;
                    $sumItemAccountClosing = 0;
                @endphp
                    <tr>
                        <td style="border-left: 1px solid #000" align="center">{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                        <td style="border-left: 1px solid #000" colspan="2"> {{$subInvDes }}</td>
                        <td class="td-b-rl"></td>
                        <td class="td-b-rl"></td>
                        <td class="td-b-rl"></td>
                        <td class="td-b-r" colspan="2" style="border-right: 2px solid black;"></td>
                    </tr>
                    @foreach ($subInvLines->groupBy('sub_group_desc') as $location =>  $line)
                    @php
                    // $sumCA = 0;
                        $sumCA  += $line->sum('coverage_amount');
                        $itemAccountClosing = $line->sum(function($item)use ($policyGroupLine, $ptirPolicyGroupDist) {
                            return  $item->interestRate($policyGroupLine->first(), $ptirPolicyGroupDist[0]->company_percent*0.01);
                        });
                        $sumItemAccountClosing +=  $itemAccountClosing;
                    @endphp
                        <tr>
                            <td style="border-left: 1px solid #000" align="center"></td>
                            <td style="border-left: 1px solid #000 ;  border-right: 1px solid #000" colspan="2">
                                {{-- {{$line->item_description }} --}}
                                {{  $location   }}

                                {{-- @foreach ($line as $l)
                                    {{  $l->calculate_days  }} -
                                @endforeach --}}
                            </td>
                            <td align="right" class="td-b-rl">
                                {{ number_format($line->sum('coverage_amount'), 2) }}
                            </td>
                            <td class="td-b-rl">  </td>
                            <td align="right" class="td-b-rl">
                                {{-- {{ number_format($itemAccountClosing, 2) }} --}}
                            </td>
                            <td class="td-b-r" colspan="2" style="border-right: 2px solid black;"></td>
                        </tr>
                        @if ($loop->last)
                        @php
                            $totalCA  += $sumCA;
                            $totalItemAccountClosing += $sumItemAccountClosing;
                        @endphp
                        <tr>
                            <td style="border-left: 1px solid #000" align="center"></td>
                            <td style="border-left: 1px solid #000;  border-right: 1px solid #000;" align="center" colspan="2">  รวม </td>
                            <td class="td-b-rl td-b-bt" align="right"> {{ number_format($sumCA, 2) }} </td>
                            <td class="td-b-rl">  </td>
                            <td class="td-b-rl" align="right"></td>
                            <td class="td-b-rl td-b-bt" align="right" colspan="2" style="border-right: 2px solid black;">{{ number_format($sumItemAccountClosing, 2)  }} </td>
                        </tr>
                        @endif
                    @endforeach
                @endforeach
                    @if ($loop->last)
                        <tr>
                            <td class="td-b-b" style="border-left: 1px solid #000" align="center"></td>
                            <td class="td-b-rl td-b-bt" style="border-left: 1px solid #000;" align="center" colspan="2"> รวมทั้งสิ้น  </td>
                            <td  class="td-b-rl td-b-b" align="right">  {{number_format($totalCA, 2)  }} </td>
                            <td class="td-b-rl td-b-bt" align="center"> {{ $policyGroupLine->first()->premium_rate }} %</td>
                            <td class="td-b-rl td-b-bt" align="right">  {{number_format($totalItemAccountClosing, 2)  }}</td>
                            <td class="td-b-b td-b-r" align="right" colspan="2" style="border-right: 2px solid black;">  {{number_format($totalItemAccountClosing, 2)  }} </td>
                        </tr>
                    @endif
            @endforeach
            @php
                $stampDuty = $totalItemAccountClosing * ($policyGroupLine[0]->revenue_stamp * 0.01);
                $sumStampDuty = $totalItemAccountClosing + ($totalItemAccountClosing * ($policyGroupLine[0]->revenue_stamp * 0.01));
                $tax = $sumStampDuty * ($policyGroupLine[0]->tax * 0.01);
                $total = $sumStampDuty + $tax;
            @endphp
            <tr>
                <td colspan="5" align="right"> ค่าเบี้ยประกันภัยก่อนคำนวณภาษีมูลค่าเพิ่ม </td>
                <td align="right"> {{number_format($totalItemAccountClosing, 2)  }} </td>
                <td colspan="2" align="right">  </td>
            </tr>
            <tr>

                <td colspan="5" align="right"> ค่าอากรแสตมป์ </td>
                <td align="right"> {{number_format($stampDuty, 2)  }}   </td>
                <td colspan="2" align="right">  </td>
            </tr>
            <tr>
                <td colspan="5" align="right"> รวมเบี้ยบวกอากรแสตมป์ </td>
                <td align="right"> {{number_format($sumStampDuty, 2)  }} </td>
                <td colspan="2" align="right">  </td>
            </tr>
            <tr>
                <td colspan="5" align="right"> ภาษีมูลค่าเพิ่ม </td>
                <td align="right"> {{number_format($tax, 2)  }} </td>
                <td colspan="2" align="right">  </td>
            </tr>
            <tr>
                <td colspan="5" align="right"> รวมเบี้ยบวกอากรแสตมป์ ภาษีมูลค่าเพิ่ม </td>
                <td align="right"> {{number_format($total, 2)  }} </td>
                <td colspan="2" align="right">  </td>
            </tr>
        </tbody>
    </table>
</div>