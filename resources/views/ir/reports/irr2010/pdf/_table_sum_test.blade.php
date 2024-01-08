<div class="page-break">
    <div class="page-break"></div>
{{-- @include('ir.reports._style') --}}
@php
    $totalCA = 0;
    $totalItemAccountClosing = 0;
@endphp
{{-- ########################## loop 1 ################################ --}}

@foreach ($ptirStockHeader->sortBy('asset_group_code')->groupBy('asset_group_desc') as $assetGroups => $assetGroupLines)
    @php
        $sumCA = 0;
        $sumItemAccountClosing = 0;
    @endphp
{{-- ########################## loop 2 ################################ --}}
        @foreach ($assetGroupLines->groupBy('stock_list_description') as $subInvDes => $subInvLines)
            @php
                $CA = $subInvLines->sum('coverage_amount');
                $itemAccountClosing = $subInvLines->sum(function ($item) use ($policyGroupLine) {
                    return $item->interestRate($policyGroupLine->first(), $rate = null);
                });

                $sumCA += $CA;
                $sumItemAccountClosing += $itemAccountClosing;
            @endphp

            <table class="table" width="100%">
                    @if($loop->parent->first)
                        <tr>
                            <td style="border: 1px solid black" align="center" width="5%">ลำดับ</td>
                            <td style="border: 1px solid black" align="center" width="35%">รายการ</td>
                            <td style="border: 1px solid black" align="center" width="15%">มูลค่าทุนประกัน</td>
                            <td style="border: 1px solid black" align="center" width="15%">อัตราเบี้ยประกัน</td>
                            <td style="border: 1px solid black" align="center" width="15%">ค่าเบี้ยประกัน 100% </td>
                            <td style="border: 1px solid black" align="center" width="15%">คำนวณปิดบัญชี</td>
                        </tr>
                    @endif
                    @if($loop->first)
                        <tr>                        
                            <td style="border-left: 1px solid #000" align="center" width="5%">{{ $loop->parent->iteration }}</td>
                            <td style="border-left: 1px solid #000" width="35%">{{ $assetGroups }}</td>
                            <td class="td-b-rl"  width="15%"></td>
                            <td class="td-b-rl"  width="15%"></td>
                            <td class="td-b-rl"  width="15%"></td>
                            <td class="td-b-r"   width="15%"></td>
                        </tr>
                    @endif
                    <tr>
                        <td style="border-left: 1px solid #000" align="center" width="5%">
                            {{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                        <td style="border-left: 1px solid #000;  " width="35%"> {{ $subInvDes }}</td>
                        <td class="td-b-rl" align="right" width="15%"> {{ number_format($CA, 2) }} </td>
                        <td class="td-b-rl" width="15%"></td>
                        <td class="td-b-rl" width="15%"></td>
                        <td class="td-b-r" align="right" width="15%"> {{ number_format($itemAccountClosing, 2) }} </td>
                    </tr>
                    @if ($loop->last)
                        @php
                            $totalCA += $sumCA;
                            $totalItemAccountClosing += $sumItemAccountClosing;
                        @endphp
                        <tr>
                            <td style="border-left: 1px solid #000" align="center" width="5%"></td>
                            <td style="border-left: 1px solid #000;  border-right: 1px solid #000;" align="center" width="35%"> รวม
                            </td>
                            <td class="td-b-rl td-b-bt" align="right" width="15%"> {{ number_format($sumCA, 2) }} </td>
                            <td class="td-b-rl" width="15%"> </td>
                            <td class="td-b-rl" align="right" width="15%"></td>
                            <td class="td-b-rl td-b-bt" align="right" width="15%">{{ number_format($sumItemAccountClosing, 2) }}
                            </td>
                        </tr>
                    @endif
                    @if ($loop->parent->last)
                        <tr>
                            <td class="td-b-b" style="border-left: 1px solid #000" align="center"></td>
                            <td class="td-b-rl td-b-bt" style="border-left: 1px solid #000;" align="center"> รวมทั้งสิ้น
                            </td>
                            <td class="td-b-rl td-b-b" align="right"> {{ number_format($totalCA, 2) }} </td>
                            <td class="td-b-rl td-b-bt" align="center"> {{ $policyGroupLine->first()->premium_rate }} %
                            </td>
                            <td class="td-b-rl td-b-bt" align="right"> {{ number_format($totalItemAccountClosing, 2) }}
                            </td>
                            <td class="td-b-b td-b-r" align="right"> {{ number_format($totalItemAccountClosing, 2) }}
                            </td>
                        </tr>
                    @endif
                    
            @if ($loop->parent->last)
                @php
                    $stampDuty = $totalItemAccountClosing * ($policyGroupLine[0]->revenue_stamp * 0.01);
                    $sumStampDuty = $totalItemAccountClosing + $totalItemAccountClosing * ($policyGroupLine[0]->revenue_stamp * 0.01);
                    $tax = $sumStampDuty * ($policyGroupLine[0]->tax * 0.01);
                    $total = $sumStampDuty + $tax;
                @endphp
                <tr>
                    <td colspan="4" align="right"> ค่าเบี้ยประกันภัยก่อนคำนวณภาษีมูลค่าเพิ่ม </td>
                    <td align="right"> {{ number_format($totalItemAccountClosing, 2) }} </td>
                    <td align="right"> </td>
                </tr>
                <tr>
                    <td colspan="4" align="right"> ค่าอากรแสตมป์ </td>
                    <td align="right"> {{ number_format($stampDuty, 2) }} </td>
                    <td align="right"> </td>
                </tr>
                <tr>
                    <td colspan="4" align="right"> รวมเบี้ยบวกอากรแสตมป์ </td>
                    <td align="right"> {{ number_format($sumStampDuty, 2) }} </td>
                    <td align="right"> </td>
                </tr>
                <tr>
                    <td colspan="4" align="right"> ภาษีมูลค่าเพิ่ม </td>
                    <td align="right"> {{ number_format($tax, 2) }} </td>
                    <td align="right"> </td>
                </tr>
                <tr>
                    <td colspan="4" align="right"> รวมเบี้ยบวกอากรแสตมป์ ภาษีมูลค่าเพิ่ม </td>
                    <td align="right"> {{ number_format($total, 2) }} </td>
                    <td align="right"> </td>
                </tr>
            @endif
        </table>

{{-- 
        @if ($loop->parent->iteration ==4)
            <div class="page-break"></div>
            @if ($loop->first)
                @include('ir.reports.irr2010.pdf._header')
            @endif
        @endif --}}
    @endforeach

@endforeach
</div>