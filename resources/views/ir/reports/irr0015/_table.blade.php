@php
    $daysInYear = 0;
    $sumCoverageCentral = 0;
    $sumCoverageRegion = 0;
    $sumAllCoverage = 0;
    $sumAllActualCoverage = 0;
    $sumInsuranceCentral = 0;
    $sumInsuranceRegion = 0;
    $sumAllInsurance = 0;
    $sumPaidCentral = 0;
    $sumPaidRegion = 0;
    $sumAllPaid = 0;
@endphp
<table width="100%">
    <thead>
        <tr>
            <th colspan="3">
                มูลค่าทุนประกัน
            </th>
            <th></th>
            <th></th>
            <th colspan="3">
                ค่าเบี้ยประกันแท้จริง {{ array_key_exists(0, $premiumRate) ? $premiumRate[0] : 0 }}%
            </th>
        </tr>
        <tr>
            <th>
                ส่วนกลาง
            </th>
            <th>
                ส่วนภูมิภาค
            </th>
            <th>
                รวม
            </th>
            <th>
                วัน
            </th>
            <th>
                ทุนประกันแท้จริง
            </th>
            <th>
                ส่วนกลาง
            </th>
            <th>
                ส่วนภูมิภาค
            </th>
            <th>
                รวม
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center" style="font-size: 14px;">
                บาท
            </td>
            <td class="text-center" style="font-size: 14px;">
                บาท
            </td>
            <td class="text-center" style="font-size: 14px;">
                บาท
            </td>
            <td></td>
            <td></td>
            <td class="text-center" style="font-size: 14px;">
                บาท
            </td>
            <td class="text-center" style="font-size: 14px;">
                บาท
            </td>
            <td class="text-center" style="font-size: 14px;">
                บาท
            </td>
        </tr>
        @for ($loop = 0; $loop < 12; $loop++)
            @php
                $month = (($loop+9)%12)+1;
                $daysInMonth = days_in_month($month, $month > 9 ? $year-1 : $year);
                $daysInYear += $daysInMonth;

                //// ส่วนกลาง ////
                $central = array_key_exists($month, $groupData) ? (array_key_exists('CENTRAL', $groupData[$month]) ? $groupData[$month]['CENTRAL'] : null) : null;
                $coverageCentral = $central ? $central->sum(function ($item) {
                    return $item->coverage_amount;
                }) : 0;
                $actualCoverageCentral = $central ? $central->sum(function ($item) {
                    return $item->actual_coverage_amount;
                }) : 0;

                //// ภูมิภาค ////
                $region = array_key_exists($month, $groupData) ? (array_key_exists('REGION', $groupData[$month]) ? $groupData[$month]['REGION'] : null) : null;
                $coverageRegion = $region ? $region->sum(function ($item) {
                    return $item->coverage_amount;
                }) : 0;
                $actualCoverageRegion = $region ? $region->sum(function ($item) {
                    return $item->actual_coverage_amount;
                }) : 0;

                //// รวม ////
                $sumCoverage = $coverageCentral + $coverageRegion;
                $sumActualCoverage = $actualCoverageCentral + $actualCoverageRegion;
                $sumCoverageCentral += $coverageCentral;
                $sumCoverageRegion += $coverageRegion;
                $sumAllCoverage += $sumCoverage;
                $sumAllActualCoverage += $sumActualCoverage;
            @endphp
            <tr>
                <td class="text-right">
                    {{-- ส่วนกลาง --}}
                    {{ $coverageCentral ? number_format($coverageCentral, 2) : '' }}
                </td>
                <td class="text-right">
                    {{-- ส่วนภูมิภาค --}}
                    {{ $coverageRegion ? number_format($coverageRegion, 2) : ''  }}
                </td>
                <td class="text-right">
                    {{-- รวม --}}
                    {{ $sumCoverage ? number_format($sumCoverage, 2) : '' }}
                </td>
                <td class="text-right">
                    {{-- จำนวนวัน --}}
                    {{ $daysInMonth }}
                </td>
                <td class="text-right">
                    {{-- ทุนประกันแท้จริง --}}
                    {{ number_format($sumActualCoverage, 2) }}
                </td>
                <td class="text-right">
                    {{-- ส่วนกลาง --}}
                    {{-- {{ number_format($insuranceCentral, 2) }} --}}
                </td>
                <td class="text-right">
                    {{-- ส่วนภูมิภาค --}}
                    {{-- {{ number_format($insuranceRegion, 2) }} --}}
                </td>
                <td class="text-right">
                    {{-- รวม --}}
                    {{-- {{ number_format($sumInsurance, 2) }} --}}
                </td>
            </tr>
        @endfor
        @php
            $sumInsuranceCentral = $insuAmount['CENTRAL'];
            $sumInsuranceRegion = $insuAmount['REGION'];
            $sumAllInsurance = $sumInsuranceCentral + $sumInsuranceRegion;
        @endphp
        <tr>
            <td class="text-right">
                {{-- รวมส่วนกลาง --}}
                {{ number_format($sumCoverageCentral, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมส่วนภูมิภาค --}}
                {{ number_format($sumCoverageRegion, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมรวม --}}
                {{ number_format($sumAllCoverage, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมวัน --}}
                {{ $daysInYear }}
            </td>
            <td class="text-right">
                {{-- รวมทุนประกันแท้จริง --}}
                {{ number_format($sumAllActualCoverage, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมส่วนกลาง --}}
                {{ number_format($sumInsuranceCentral, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมส่วนภูมิภาค --}}
                {{ number_format($sumInsuranceRegion, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมรวม --}}
                {{ number_format($sumAllInsurance, 2) }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                ค่าเบี้ยประกันภัย - แท้จริง
                {{-- <div class="inline-block" style="width: 74%">
                    ค่าเบี้ยประกันภัย - แท้จริง <span class="text-danger">(ทุนประกันแท้จริงเศษหลักร้อยเกินห้าร้อยปัดขึ้น)</span>
                </div>
                <div class="inline-block text-right" style="width: 25%">
                    รวมทุนประกันแท้จริง
                </div> --}}
            </td>
            <td class="text-right">
                {{-- รวมส่วนกลาง --}}
                {{ number_format($sumInsuranceCentral, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมส่วนภูมิภาค --}}
                {{ number_format($sumInsuranceRegion, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมรวม --}}
                {{ number_format($sumAllInsurance, 2) }}
            </td>
        </tr>
        <tr>
            @php
                ///// ส่วนกลาง /////
                $central = array_key_exists('CENTRAL', $paidData) ? $paidData['CENTRAL'] : [];
                $paidCentral = $paidAmount['CENTRAL'];

                ///// ภูมิภาค /////
                $region = array_key_exists('REGION', $paidData) ? $paidData['REGION'] : [];
                $paidRegion = $paidAmount['REGION'];

                $sumPaidCentral += $paidCentral;
                $sumPaidRegion += $paidRegion;
                $sumPaid = $paidCentral + $paidRegion;
                $sumAllPaid += $sumPaid;

                $sumPaybackCentral = $sumInsuranceCentral - $sumPaidCentral;
                $sumPaybackRegion = $sumInsuranceRegion - $sumPaidRegion;
                $sumAllPayback = $sumPaybackCentral + $sumPaybackRegion;

                $centralTaxFlag = array_key_exists('CENTRAL', $policyTaxFlag) ? $policyTaxFlag['CENTRAL'] : [];
                $regionTaxFlag = array_key_exists('REGION', $policyTaxFlag) ? $policyTaxFlag['REGION'] : [];

                if($centralTaxFlag == 'Y'){
                    $taxCentral = $sumPaybackCentral * $vatRate / ($vatRate + 100);
                    $dutyCentral = ($sumPaybackCentral - $taxCentral) * $dutyRate / ($dutyRate + 100);
                    $InsuCentral = $sumPaybackCentral - $dutyCentral - $taxCentral;
                    $topupCentral = $InsuCentral + $dutyCentral + $taxCentral;
                }else {
                    $dutyCentral = $sumPaybackCentral * $dutyRate / ($dutyRate + 100);
                    $InsuCentral = $sumPaybackCentral - $dutyCentral;
                    $taxCentral = ($InsuCentral + $dutyCentral) * $vatRate / 100;
                    $topupCentral = $InsuCentral + $dutyCentral + $taxCentral;
                }

                if($regionTaxFlag == 'Y'){
                    $taxRegion = $sumPaybackRegion * $vatRate / ($vatRate + 100);
                    $dutyRegion = ($sumPaybackRegion - $taxRegion) * $dutyRate / ($dutyRate + 100);
                    $InsuRegion = $sumPaybackRegion - $dutyRegion - $taxRegion;
                    $topupRegion = $InsuRegion + $dutyRegion + $taxRegion;
                }else {
                    $dutyRegion = $sumPaybackRegion * $dutyRate / ($dutyRate + 100);
                    $InsuRegion = $sumPaybackRegion - $dutyRegion;
                    $taxRegion = ($InsuRegion + $dutyRegion) * $vatRate / 100;
                    $topupRegion = $InsuRegion + $dutyRegion + $taxRegion;
                }

                $sumAllduty = $dutyCentral + $dutyRegion;
                $sumAllInsu = $InsuCentral + $InsuRegion;
                $sumAlltax = $taxCentral + $taxRegion;
                $sumAlltopup = $topupCentral + $topupRegion;
            @endphp
            <td colspan="5">
                หัก ค่าเบี้ยประกันภัยจ่ายล่วงหน้า 50%
            </td>
            <td class="text-right">
                {{-- รวมส่วนกลาง --}}
                {{ number_format($sumPaidCentral, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมส่วนภูมิภาค --}}
                {{ number_format($sumPaidRegion, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมรวม --}}
                {{ number_format($sumAllPaid, 2) }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                ค่าเบี้ยประกันภัย - จ่ายเพิ่ม (รับคืน)
            </td>
            <td class="text-right">
                {{-- รวมส่วนกลาง --}}
                {{ number_format($sumPaybackCentral, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมส่วนภูมิภาค --}}
                {{ number_format($sumPaybackRegion, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมรวม --}}
                {{ number_format($sumAllPayback, 2) }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                ค่าเบี้ยประกันภัย
            </td>
            <td class="text-right">
                {{-- รวมส่วนกลาง --}}
                {{ number_format($InsuCentral, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมส่วนภูมิภาค --}}
                {{ number_format($InsuRegion, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมรวม --}}
                {{ number_format($sumAllInsu, 2) }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                บวก อากร {{ $dutyRate }}%
            </td>
            <td class="text-right">
                {{-- รวมส่วนกลาง --}}
                {{ number_format($dutyCentral, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมส่วนภูมิภาค --}}
                {{ number_format($dutyRegion, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมรวม --}}
                {{ number_format($sumAllduty, 2) }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                
            </td>
            <td class="text-right">
                {{-- รวมส่วนกลาง --}}
                {{ number_format($InsuCentral + $dutyCentral, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมส่วนภูมิภาค --}}
                {{ number_format($InsuRegion + $dutyRegion, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมรวม --}}
                {{ number_format($sumAllInsu + $sumAllduty, 2) }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                บวก ภาษีมูลค่าเพิ่ม {{ $vatRate }}%
            </td>
            <td class="text-right">
                {{-- รวมส่วนกลาง --}}
                {{ number_format($taxCentral, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมส่วนภูมิภาค --}}
                {{ number_format($taxRegion, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมรวม --}}
                {{ number_format($sumAlltax, 2) }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                รวมจ่ายเพิ่มปี {{ (int)$year+543 }} (รวมอากรและภาษีมูลค่าเพิ่ม)
            </td>
            <td class="text-right">
                {{-- รวมส่วนกลาง --}}
                {{ number_format($topupCentral, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมส่วนภูมิภาค --}}
                {{ number_format($topupRegion, 2) }}
            </td>
            <td class="text-right">
                {{-- รวมรวม --}}
                {{ number_format($sumAlltopup, 2) }}
            </td>
        </tr>
        <tr>
            @php
                $groupCompany = $insurances->get()
                    ->whereNotNull('company_code')
                    ->sortBy('company_code')
                    ->groupBy('company_code');
            @endphp
            <td colspan="4">
                
            </td>
            <td class="text-center">
                ค่าเบี้ยประกันจ่ายเพิ่ม
            </td>
            <td class="text-center">
                อากรแสตมป์ ({{ $dutyRate }}%)
            </td>
            <td class="text-center">
                ภาษีมูลค่าเพิ่ม ({{ $vatRate }}%)
            </td>
            <td class="text-center">
                รวม
            </td>
        </tr>
        @php
            $sumAllInsuCompany = 0;
            $sumAllDutyCompany = 0;
            $sumAllTaxCompany = 0;
            $sumAllCompany = 0;
        @endphp
        @foreach ($groupCompany as $items)
            @php
                $item = $items->first();
                $company_name = $item->company_name;
                $rate = $item->percent_remaining;
                $sumAllInsuCompany += $insuCompany = $sumAllInsu * $rate / 100;
                $sumAllDutyCompany += $dutyCompany = $insuCompany * $dutyRate / 100;
                $sumAllTaxCompany += $taxCompany = ($insuCompany + $dutyCompany) * $vatRate / 100;
                $sumAllCompany += $sumCompany = $insuCompany + $dutyCompany + $taxCompany;
            @endphp
            <tr>
                <td colspan="4">
                    {{ $company_name }} {{ $rate }}%
                </td>
                <td class="text-right">
                    {{ number_format($insuCompany, 2) }}
                </td>
                <td class="text-right">
                    {{ number_format($dutyCompany, 2) }}
                </td>
                <td class="text-right">
                    {{ number_format($taxCompany, 2) }}
                </td>
                <td class="text-right">
                    {{ number_format($sumCompany, 2) }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4">
                
            </td>
            <td class="text-right">
                {{ number_format($sumAllInsuCompany, 2) }}
            </td>
            <td class="text-right">
                {{ number_format($sumAllDutyCompany, 2) }}
            </td>
            <td class="text-right">
                {{ number_format($sumAllTaxCompany, 2) }}
            </td>
            <td class="text-right">
                {{ number_format($sumAllCompany, 2) }}
            </td>
        </tr>
    </tbody>
</table>
