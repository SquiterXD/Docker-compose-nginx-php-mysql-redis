

<div class="page-break">
    <div class="page-break"></div>
    {{-- <div>
        <div class="row">
            <div class="col-md-4">
                <div></div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <b> ชุดที่:  {{ $policySetDes }} </b>
                </div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div> --}}
    <table class="table" width="100%" >
        <thead>
            <tr>
                <th align="left" width="29%" colspan="2"> {{ ucfirst($reportType) }} </th>
                <th align="center" colspan="3"> <b>  ชุดที่:  {{ $policySetDes }} </b> </th>
                <th></th>
                <th align="right" colspan="2"><b></th>
            </tr>
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
                <th colspan="2"> 
                    <div style="margin-top: -16px">
                        <div style="text-align: right; margin-right: 22px; "><b> หน้า : </b></div>
                    </div>
                </th>
            </tr>
            <tr>
                <th align="left" colspan="2"></th>
                <th align="center" colspan="3">
                    <b> @foreach ($companies as $company)
                    @if ($loop->last)
                        {{ " และ "  }}
                    @endif
                    {{  $company->company_name  }}
                @endforeach </b>  </th>
                <th></th>
                <th align="right"></th>
                <th align="left"></th>
            </tr>
            <tr>
                <th colspan="2"> </th>
                <th align="center" colspan="3"> <b> ปีงบประมาณ {{ $periodYear ? $periodYear + 543 : '' }} </b>  </th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                @php
                    $ex_sDate = explode('/' ,$periodDate[0]);
                    $ex_eDate = explode('/' ,$periodDate[1]);
                @endphp
                <th align="left" colspan="2"> <b> {{ ucfirst($reportType) }} </b> </th>
                <th align="center" colspan="3"> <b> สำหรับวันที่ {{ $ex_sDate[0] . ' ' . $thaimonths[$ex_sDate[1]] . ' ' . $ex_sDate[2] }} ถึง {{ $ex_eDate[0] . ' ' . $thaimonths[$ex_eDate[1]] . ' ' . $ex_eDate[2] }} </b>  </th>
                <th></th>
                <th></th>
            </tr> --}}
        <tr style="background-color: #c4c4c4">
            <th style="border: 1px solid black" align="center" width="4%">ลำดับ</th>
            <th style="border: 1px solid black" align="center" colspan="2">รายการ</th>
            <th style="border: 1px solid black" align="center" width="15%">มูลค่าทุนประกัน</th>
            <th style="border: 1px solid black" align="center" width="15%">อัตราเบี้ยประกัน</th>
            <th style="border: 1px solid black" align="center" width="15%">ค่าเบี้ยประกัน 100% </th>
            <th style="border-top: 1px solid black; border-left: 1px solid black; border-bottom:  1px solid black; border-right: 2px solid black;" align="center" width="13%" colspan="2">คำนวณปิดบัญชี</th>
        </tr>
        </thead>
        <tbody>
            @php
                $totalCA  = 0;
                $totalItemAccountClosing = 0;
            @endphp

            @foreach ($ptirStockHeader->sortBy('asset_group_code')->groupBy(function($item) {
                return $item->asset_group_code ." : ". $item->asset_group_desc;
            })
            as $assetGroups =>  $assetGroupLines)
            @php
                $sumCA = 0;
                $sumItemAccountClosing = 0;                
            @endphp
                <tr>
                    <td style="border-left: 1px solid #000" align="center">{{ $loop->iteration }}</td>
                    <td style="border-left: 1px solid #000;" colspan="2"> {{$assetGroups }}</td>
                    <td class="td-b-rl"> </td>
                    <td class="td-b-rl"></td>
                    <td class="td-b-rl"></td>
                    <td class="td-b-r" colspan="2" style="border-right: 2px solid black;"></td>
                </tr>
                @foreach ($assetGroupLines->groupBy('stock_list_description') as $subInvDes => $subInvLines)
                @php
                    $CA     = $subInvLines->sum('coverage_amount');
                    $itemAccountClosing = $subInvLines->sum(function($item)use ($policyGroupLine) {
                                return  $item->interestRate($policyGroupLine->first(), $rate=null);
                            });

                    $sumCA  += $CA;
                    $sumItemAccountClosing +=  $itemAccountClosing;
                @endphp
                    <tr>
                        <td style="border-left: 1px solid #000" align="center">{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                        <td style="border-left: 1px solid #000" colspan="2"> {{$subInvDes }}</td>
                        <td class="td-b-rl" align="right"> {{ number_format($CA , 2) }} </td>
                        <td class="td-b-rl"></td>
                        <td class="td-b-rl"></td>
                        <td class="td-b-r" align="right" colspan="2" style="border-right: 2px solid black;"> {{ number_format($itemAccountClosing, 2)  }} </td>
                    </tr>
                    @if ($loop->last)
                        @php
                            $totalCA  += $sumCA;
                            $totalItemAccountClosing += $sumItemAccountClosing;
                        @endphp
                        <tr>
                            <td style="border-left: 1px solid #000" align="center"></td>
                            <td style="border-left: 1px solid #000;  border-right: 1px solid #000;" align="center" colspan="2"> รวม </td>
                            <td class="td-b-rl td-b-bt" align="right"> {{ number_format($sumCA, 2) }} </td>
                            <td class="td-b-rl">  </td>
                            <td class="td-b-rl" align="right"></td>
                            <td class="td-b-rl td-b-bt" align="right" colspan="2" style="border-right: 2px solid black;">{{ number_format($sumItemAccountClosing, 2)  }} </td>
                        </tr>
                    @endif
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
                    @if ($loop->iteration == 2)
                    {{-- {{ dd("====" , $loop->iteration) }} --}}
                        <div class="page-break"></div>
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
