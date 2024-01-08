@php
    $sumTotal_ct_dm_aq_inwip = 0;
    $sumTotal_ct_dm_aqsp_inwip = 0;
    $array = [];
@endphp
@foreach ($CTList->groupBy('ct_batch_no') as $item => $batchNoDetail)
    @foreach ($batchNoDetail->groupBy('ct_accounting_date') as $date => $dateDetail)
    <br>
    <table style="border: 1px solid #000000;">
        <tr>
            <td rowspan="2" style="text-align: center; border: 1px solid #000000;">
                รายการ
            </td>
            <td colspan="5" style="text-align: center; border: 1px solid #000000;">
                ต้นทุนคิดเข้างาน
            </td>
            <td rowspan="2" style="border: 1px solid #000000;">รวมต้นทุนคิดเข้างาน</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000; text-align: center;">ปริมาณ 1000 มวน</td>
            <td style="border: 1px solid #000000; text-align: center;">วัตถุดิบ</td>
            <td style="border: 1px solid #000000; text-align: center;">ค่าแรง</td>
            <td style="border: 1px solid #000000; text-align: center;">ค่าใช้จ่ายผันแปร</td>
            <td style="border: 1px solid #000000; text-align: center;">ค่าใช้จ่ายคงที่</td>
        </tr>
        <tbody>
            @foreach ($dateDetail->groupBy('ct_wip_code') as $key => $wipDetail)
                @php
                    $firstWipDetail = $wipDetail->first();
                    $array[$loop->parent->iteration] = $dateDetail;
                @endphp
                <tr>
                    <td style="border: 1px solid #000000;">
                        <strong><u>ขั้นตอน</u></strong>
                        {{ $key }}
                        {{ $firstWipDetail['ct_wip_name'] }}
                    </td>
                    <td style="border: 1px solid #000000;">
                        
                    </td>
                    <td style="border: 1px solid #000000;">
    
                    </td>
                    <td style="border: 1px solid #000000; text-align: right">
                        {{ $firstWipDetail->ct_percent_finish_dl }} %
                        ({{ $firstWipDetail->ct_percent_finish_dl_rate ?? 0 }})
                    </td>
                    <td style="border: 1px solid #000000; text-align: right">
                        {{ $firstWipDetail->ct_percent_finish_voh }} %
                        ({{ $firstWipDetail->ct_percent_finish_voh_rate ?? 0 }})
                    </td>
                    <td style="border: 1px solid #000000; text-align: right">
                        {{ $firstWipDetail->ct_percent_finish_foh }} %
                        ({{ $firstWipDetail->ct_percent_finish_foh_rate ?? 0 }})
                    </td>
                    <td style="border: 1px solid #000000;">
    
                    </td>
                </tr>
                @if ($key == 'WIP01')
                    <tr>
                        @php
                            $firstWipDetail = $wipDetail->first();
                        @endphp
                        <td style="border: 1px solid #000000;">
                            ยอดยกมาต้นงวด
                        </td>
                        <td style="border: 1px solid #000000; text-align: right">
                            {{ $firstWipDetail['ct_prd_aq_wipbegin'] ?? 0 }}
                        </td>
                        @if ($loop->parent->iteration > 1)
                            <td style="border: 1px solid #000000; text-align: right">
                                {{ $totalEndPeriodRM ?? 0 }}
                            </td>
                        @else
                            <td style="border: 1px solid #000000; text-align: right">
                                {{ $firstWipDetail['ct_dm_aqsp_wipbegin'] ?? 0 }}
                            </td>
                        @endif

                        <td style="border: 1px solid #000000; text-align: right">
                            {{ $firstWipDetail['ct_dl_aqsp_wipbegin'] ?? 0 }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right">
                            {{ $firstWipDetail['ct_voh_aqsp_wipbegin'] ?? 0 }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right">
                            {{ $firstWipDetail['ct_foh_aqsp_wipbegin'] ?? 0 }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right">
                            @php
                                $sumTotalWipbegin = 0;
                                // $sumTotalWipbegin = $firstWipDetail['ct_prd_aq_wipbegin'] + 
                                //                     $firstWipDetail['ct_dm_aqsp_wipbegin'] +
                                //                     $firstWipDetail['ct_dl_aqsp_wipbegin'] + 
                                //                     $firstWipDetail['ct_voh_aqsp_wipbegin'] + 
                                //                     $firstWipDetail['ct_foh_aqsp_wipbegin']
                                $sumTotalWipbegin = $firstWipDetail['ct_dm_aqsp_wipbegin'] +
                                                    $firstWipDetail['ct_dl_aqsp_wipbegin'] + 
                                                    $firstWipDetail['ct_voh_aqsp_wipbegin'] + 
                                                    $firstWipDetail['ct_foh_aqsp_wipbegin']
                            @endphp
                            {{ $sumTotalWipbegin }}
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            วัตถุดิบใช้ไประหว่างงวด
                        </td>
                        <td style="border: 1px solid #000000;">
                            
                        </td>
                        <td style="border: 1px solid #000000;">
                            
                        </td>
                        <td style="border: 1px solid #000000;">
                            
                        </td>
                        <td style="border: 1px solid #000000;">
                            
                        </td>
                        <td style="border: 1px solid #000000;">
                            
                        </td>
                        <td style="border: 1px solid #000000;">
                            
                        </td>
                    </tr>

                    @foreach ($wipDetail->whereNotNull('ct_dm_group')->groupBy('ct_dm_group', 'ct_dm_group_name')->sortKeys() as $index => $groupDetail)
                        @php
                            $firstGroupDetail = $groupDetail->first(); 
                            $sumTotal_ct_dm_aq_inwip += $groupDetail->sum('ct_dm_aq_inwip');
                            $sumTotal_ct_dm_aqsp_inwip += $groupDetail->sum('ct_dm_aqsp_inwip');
                        @endphp  
                        <tr>
                            <td style="border: 1px solid #000000;">
                                {{ $firstGroupDetail['ct_dm_group'] }} 
                                {{ $firstGroupDetail['ct_dm_group_name'] }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ $groupDetail->sum('ct_dm_aq_inwip') }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ $groupDetail->sum('ct_dm_aqsp_inwip') }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                        </tr>    
                    @endforeach

                    <tr>
                        <td style="border: 1px solid #000000;">
                            รวมต้นทุนวัตถุดิบใช้ไปในงวด
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $sumTotal_ct_dm_aq_inwip }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $sumTotal_ct_dm_aqsp_inwip }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            สารหอม
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalFlavor = 0;
                                //ระหว่างเรื่องการ sum ของ ct_prd_aq_inwip และ ct_prd_aq_loss
                                $totalFlavor =  ($sumTotal_ct_dm_aq_inwip-$groupDetail->sum('ct_prd_aq_inwip'))-$groupDetail->sum('ct_prd_aq_loss');
                            @endphp
                            {{ $totalFlavor }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;" >

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            สูญเสีย
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{-- ระหว่างเรื่องการ sum ของ ct_prd_aq_loss --}}
                            {{ $groupDetail->sum('ct_prd_aq_loss') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;" >

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            ต้นทุนผลิตระหว่างงวด
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $groupDetail->sum('ct_prd_aq_inwip') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $sumTotal_ct_dm_aqsp_inwip }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $groupDetail->sum('ct_dl_aqsp_inwip') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $groupDetail->sum('ct_voh_aqsp_inwip') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;" >
                            {{ $groupDetail->sum('ct_foh_aqsp_inwip') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalCostDuring = 0;
                                $totalCostDuring =  $sumTotal_ct_dm_aqsp_inwip +
                                                    $groupDetail->sum('ct_dl_aqsp_inwip') +
                                                    $groupDetail->sum('ct_voh_aqsp_inwip') +
                                                    $groupDetail->sum('ct_foh_aqsp_inwip')
                            @endphp
                            {{ $totalCostDuring }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            รวมต้นทุนทั้งสิ้น
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                //ระหว่างเรื่องการ sum ของ ct_prd_aq_inwip และ ct_prd_aq_wipbegin
                                $totalCost1000Cigarettes = 0;
                                $totalCost1000Cigarettes = $groupDetail->sum('ct_prd_aq_inwip') + $groupDetail->sum('ct_prd_aq_wipbegin');
                            @endphp
                            {{ $totalCost1000Cigarettes }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                //ระหว่างเรื่องการ sum ของ ct_dm_aqsp_wipbegin
                                $totalCostRM = 0;
                                $totalCostRM = $sumTotal_ct_dm_aqsp_inwip + $groupDetail->sum('ct_dm_aqsp_wipbegin')
                            @endphp
                            {{ $totalCostRM }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $groupDetail->sum('ct_dl_aqsp_total') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $groupDetail->sum('ct_voh_aqsp_total') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;" >
                            {{ $groupDetail->sum('ct_foh_aqsp_total') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalCost = 0;
                                $totalCost =    $totalCostRM + 
                                                $groupDetail->sum('ct_dl_aqsp_total') +
                                                $groupDetail->sum('ct_voh_aqsp_total') +
                                                $groupDetail->sum('ct_foh_aqsp_total')
                            @endphp
                            {{ $totalCost }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            ยอดยกไปขั้นตอนต่อไป
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $groupDetail->sum('ct_prd_aq_issue') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalBalanceCarriedNextRM = 0;
                                // $totalBalanceCarriedNextRM = ($totalCostRM*$groupDetail->sum('ct_prd_aq_issue'))/$totalCost1000Cigarettes;
                            @endphp
                            {{ $totalBalanceCarriedNextRM }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $groupDetail->sum('ct_dl_aqsp_issue') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $groupDetail->sum('ct_voh_aqsp_issue') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;" >
                            {{ $groupDetail->sum('ct_foh_aqsp_issue') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalBalanceCarriedNext = 0;
                                $totalBalanceCarriedNext =  $totalBalanceCarriedNextRM +
                                                            $groupDetail->sum('ct_dl_aqsp_issue') + 
                                                            $groupDetail->sum('ct_voh_aqsp_issue') +
                                                            $groupDetail->sum('ct_foh_aqsp_issue')
                            @endphp
                            {{ $totalBalanceCarriedNext }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            ยอดปลายงวด
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalEndPeriod1000Cigarettes = 0;
                                $totalEndPeriod1000Cigarettes = $totalCost1000Cigarettes-$groupDetail->sum('ct_prd_aq_issue');
                            @endphp
                                {{ $totalEndPeriod1000Cigarettes }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalEndPeriodRM = 0;
                                $totalEndPeriodRM = $totalCostRM-$totalBalanceCarriedNext;
                            @endphp
                            {{ $totalEndPeriodRM }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $groupDetail->sum('ct_dl_aqsp_wipend') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $groupDetail->sum('ct_voh_aqsp_wipend') }}
                        </td>   
                        <td style="border: 1px solid #000000; text-align: right;" >
                            {{ $groupDetail->sum('ct_foh_aqsp_wipend') }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalEndPeriod = 0;
                                $totalEndPeriod =   $totalEndPeriodRM +
                                                    $groupDetail->sum('ct_dl_aqsp_wipend') + 
                                                    $groupDetail->sum('ct_voh_aqsp_wipend') +
                                                    $groupDetail->sum('ct_foh_aqsp_wipend')
                            @endphp
                            {{ $totalEndPeriod }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            ต้นทุนรวมสำเร็จรูป
                        </td>
                        @if ($key == 'WIP01' && $firstWipDetail['ct_cc_code'] == 10)
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ 0 }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ 0 }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ 0 }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ 0 }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;" >
                                {{ 0 }}
                            </td>   
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ 0 }}
                            </td>
                        @else
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;" >

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                        @endif
                    </tr>  

                @else
                    <tr>
                        <td style="border: 1px solid #000000;">
                            ยอดยกมาจากขั้นตอน 01 ใบยาหมัก
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $fistWipDetail = $wipDetail->first();
                                $arrWipCode = $dateDetail->groupBy('ct_wip_code');
                            @endphp
                            {{ $fistWipDetail['ct_prev_wip_prd_aq_issue'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_prev_wip_dm_aqsp_issue'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_prev_wip_dl_aqsp_issue'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_prev_wip_voh_aqsp_issue'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_prev_wip_foh_aqsp_issue'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalPrevWip =     $fistWipDetail['ct_prev_wip_prd_aq_issue'] +
                                                    $fistWipDetail['ct_prev_wip_dm_aqsp_issue'] +
                                                    $fistWipDetail['ct_prev_wip_dl_aqsp_issue'] +
                                                    $fistWipDetail['ct_prev_wip_voh_aqsp_issue'] +
                                                    $fistWipDetail['ct_prev_wip_foh_aqsp_issue']
                            @endphp
                            {{ $totalPrevWip }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            วัตถุดิบใช้ไประหว่างงวด
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            
                        </td>
                        @if ($key == 'WIP01')
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ $sumTotal_ct_dm_aqsp_inwip }}
                            </td>
                        @else
                            <td style="border: 1px solid #000000; text-align: right;">
                                
                            </td>
                        @endif
                        <td style="border: 1px solid #000000; text-align: right;">
                            
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            
                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            รวมต้นทุนวัตถุดิบใช้ไปในงวด
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ 0 }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            สูญเสีย
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_prd_aq_loss'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;" >

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            ต้นทุนผลิตระหว่างงวด
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_prd_aq_inwip'] }}
                        </td>
                        @if ($key == 'WIP01')
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ $sumTotal_ct_dm_aqsp_inwip }}
                            </td>
                        @else
                            <td style="border: 1px solid #000000; text-align: right;">
                                @php
                                    $sumTotal_ct_dm_aqsp_inwip = 0;
                                @endphp
                                {{ 0 }}
                            </td>
                        @endif
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_dl_aqsp_inwip'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_voh_aqsp_inwip'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;" >
                            {{ $fistWipDetail['ct_foh_aqsp_inwip'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalInwip =   $fistWipDetail['ct_prd_aq_inwip'] +
                                                $fistWipDetail['ct_dl_aqsp_inwip'] +
                                                $fistWipDetail['ct_voh_aqsp_inwip'] +
                                                $fistWipDetail['ct_foh_aqsp_inwip']
                            @endphp
                            {{ $totalInwip }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            คลังเช้า
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_prd_aq_wipbegin'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_dm_aqsp_wipbegin'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_dl_aqsp_wipbegin'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right">
                            {{ $fistWipDetail['ct_voh_aqsp_wipbegin'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right">
                            {{ $fistWipDetail['ct_foh_aqsp_wipbegin'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            รวมต้นทุนทั้งสิ้น
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalAnotherWipCost1000 = 0;
                                $totalAnotherWipCost1000 = (float)($fistWipDetail['ct_prd_aq_inwip'])+(float)$fistWipDetail['ct_prd_aq_wipbegin'];
                            @endphp
                            {{ $totalAnotherWipCost1000 }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalAnotherWipCostRM = 0;
                                $totalAnotherWipCostRM =    (float)$fistWipDetail['ct_dm_aqsp_wipbegin'] + 
                                                            (float)$fistWipDetail['ct_prev_wip_dm_aqsp_issue'] +
                                                            (float)$sumTotal_ct_dm_aqsp_inwip
                            @endphp
                            {{ $totalAnotherWipCostRM }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_dl_aqsp_total'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_voh_aqsp_total'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;" >
                            {{ $fistWipDetail['ct_foh_aqsp_total'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalAnotherWip = 0;
                                $totalAnotherWip =      $totalAnotherWipCostRM + 
                                                        (float)$fistWipDetail['ct_dl_aqsp_total'] +
                                                        (float)$fistWipDetail['ct_voh_aqsp_total'] +
                                                        (float)$fistWipDetail['ct_foh_aqsp_total']
                            @endphp
                            {{ $totalAnotherWip }}
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="border: 1px solid #000000;">
                            ยอดยกไปขั้นตอนต่อไป
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ (float) $fistWipDetail['ct_prd_aq_issue'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalBalanceCarriedNextRMAnotherWip = 0;
                                $totalBalanceCarriedNextRMAnotherWip 
                                = ($totalAnotherWipCostRM*(float)$fistWipDetail['ct_prd_aq_issue'])/$totalAnotherWipCostRM;
                            @endphp
                                {{ $totalBalanceCarriedNextRMAnotherWip }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_dl_aqsp_issue'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ $fistWipDetail['ct_voh_aqsp_issue'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;" >
                            {{ $fistWipDetail['ct_foh_aqsp_issue'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalBalanceCarriedNextAnotherWip = 0;
                                $totalBalanceCarriedNextAnotherWip =    $totalBalanceCarriedNextRMAnotherWip +
                                                                        (float)$fistWipDetail['ct_dl_aqsp_issue'] + 
                                                                        (float)$fistWipDetail['ct_voh_aqsp_issue'] +
                                                                        (float)$fistWipDetail['ct_foh_aqsp_issue'];
                            @endphp
                            {{ $totalBalanceCarriedNextAnotherWip }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;">
                            ยอดปลายงวด
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalEndPeriod1000CigarettesAnotherWip = 0;
                                $totalEndPeriod1000CigarettesAnotherWip = $totalAnotherWipCost1000-(float)$fistWipDetail['ct_prd_aq_issue'];
                            @endphp
                                {{ $totalEndPeriod1000CigarettesAnotherWip }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalEndPeriodRMAnotherWip = 0;
                                $totalEndPeriodRMAnotherWip = $totalAnotherWipCostRM-$totalBalanceCarriedNextAnotherWip;
                            @endphp
                            {{ $totalEndPeriodRMAnotherWip }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ (float)$fistWipDetail['ct_dl_aqsp_wipend'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            {{ (float)$fistWipDetail['ct_voh_aqsp_wipend'] }}
                        </td>   
                        <td style="border: 1px solid #000000; text-align: right;" >
                            {{ (float)$fistWipDetail['ct_foh_aqsp_wipend'] }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            @php
                                $totalEndPeriodAnotherWip = 0;
                                $totalEndPeriodAnotherWip =     $totalEndPeriodRMAnotherWip +
                                                                (float)$fistWipDetail['ct_dl_aqsp_wipend'] + 
                                                                (float)$fistWipDetail['ct_voh_aqsp_wipend'] +
                                                                (float)$fistWipDetail['ct_foh_aqsp_wipend']
                            @endphp
                            {{ $totalEndPeriodAnotherWip }}
                        </td>
                    </tr>
                    
                    @if ($key == 'WIP02' && $fistWipDetail['ct_cc_code'] == 10) 
                        <tr>
                            <td style="border: 1px solid #000000;">
                                ต้นทุนรวมสำเร็จรูป
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ (float)$fistWipDetail['ct_prd_aq_inwip'] }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ (float)$totalAnotherWipCostRM }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ (float)$fistWipDetail['ct_dl_aqsp_total'] }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">
                                {{ (float)$fistWipDetail['ct_voh_aqsp_total'] }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;" >
                                {{ (float)$fistWipDetail['ct_foh_aqsp_total'] }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">
                                @php
                                    $totalCostFinishedProduct = 0;
                                    $totalCostFinishedProduct =    $totalAnotherWipCostRM +
                                                                    (float)$fistWipDetail['ct_dl_aqsp_total'] +
                                                                    (float)$fistWipDetail['ct_voh_aqsp_total'] +
                                                                    (float)$fistWipDetail['ct_foh_aqsp_total'];
                                @endphp
                                {{ $totalCostFinishedProduct }}
                            </td>
                        </tr>     
                    @else
                        <tr>
                            <td style="border: 1px solid #000000;">
                                ต้นทุนรวมสำเร็จรูป
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">
                                
                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;" >

                            </td>
                            <td style="border: 1px solid #000000; text-align: right;">

                            </td>
                        </tr>     
                    @endif
                @endif
            @endforeach
        </tbody>
    </table>
    @endforeach
@endforeach

