<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        @include('ir.reports.irr2060._style')
    </head>
    <body>
        @foreach ($groupDatas as $page => $assetGroups)

            <div style="margin-bottom: 1rem; font-size: 18px;">
                <div class="inline-block" style="width: 22%">
                    <div >
                        กรมธรรม์เลขที่ ชุด 
                        @foreach ($insuranceNos as $insuranceNo)
                            {{ $insuranceNo }}
                            {{ !$loop->last ? '-' : '' }}
                        @endforeach
                        ปี {{ $thYear }} 
                        @foreach ($companies as $company)
                            {{ $company->company_name }}
                            {{ !$loop->last ? 'และ' : '' }}
                        @endforeach
                    </div>
                </div>
                <div class="inline-block text-center" style="width: 55%">
                    <div>
                        การยาสูบแห่งประเทศไทย
                    </div>
                    <div>
                        รายงานทุนประกันแท้จริง และส่วนที่เหลือ (จ่ายเพิ่ม/รับคืน) 
                        @foreach ($stocks as $stock)
                            {{ $stock }}
                            {{ !$loop->last ? 'และ' : '' }}
                        @endforeach
                    </div>
                    <div>
                        ตั้งแต่วันที่ {{ $dateStart }} ถึงวันที่ {{ $dateEnd }}
                    </div>
                </div>
                <div class="inline-block text-right" style="width: 22%">
                    <div>
                        วันที่ {{ date('d/m/').convertYearToBBE(date('Y')) }}
                    </div>
                    <div>
                        เวลา {{ strtoupper(date('H:i')) }}
                    </div>
                    <div>
                        หน้า {{ $page }}
                    </div>
                </div>
            </div>

            <table width="100%">
                <thead>
                    <tr>
                        <th rowspan="3" class="text-center">
                            สถานที่/ทรัพย์สินที่เอาประกัน
                        </th>
                        <th rowspan="3" class="text-center">
                            ทุนประกัน <br> แท้จริง
                        </th>
                        <th colspan="16" class="text-center">
                            ค่าเบี้ยประกัน (อัตราเบี้ยประกัน {{ array_key_exists(0, $premiumRate) ? $premiumRate[0] : 0 }}%)
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="text-center">
                            แท้จริง
                        </th>
                        <th rowspan="2" class="text-center">
                            จ่ายแล้ว <br> 50%
                        </th>
                        <th rowspan="2" class="text-center">
                            ส่วนที่เหลือ <br> จ่ายเพิ่ม(รับคืน)
                        </th>
                        <th colspan="12" class="text-center">
                            งวดบัญชี
                        </th>
                        <th rowspan="2" class="text-center">
                            รวม <br> ต.ค. {{ (int)substr($thYear, -2)-1 }} - ก.ย. {{ (int)substr($thYear, -2)}}
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center">
                            ต.ค. {{ (int)substr($thYear, -2)-1 }}
                        </th>
                        <th class="text-center">
                            พ.ย. {{ (int)substr($thYear, -2)-1 }}
                        </th>
                        <th class="text-center">
                            ธ.ค. {{ (int)substr($thYear, -2)-1 }}
                        </th>
                        <th class="text-center">
                            ม.ค. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            ก.พ. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            มี.ค. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            เม.ย. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            พ.ค. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            มิ.ย. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            ก.ค. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            ส.ค. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            ก.ย. {{ (int)substr($thYear, -2)}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assetGroups as $groupAsset => $groupDescriptions)
                        <tr>
                            <td style="font-weight: bold;">
                                {{-- สถานที่/ทรัพย์สินที่เอาประกัน --}}
                                {{ $groupAsset }}
                            </td>
                            <td>
                                {{-- ทุนประกันแท้จริง --}}
                            </td>
                            <td>
                                {{-- แท้จริง --}}
                            </td>
                            <td>
                                {{-- จ่ายแล้ว 50% --}}
                            </td>
                            <td>
                                {{-- ส่วนที่เหลือ จ่ายเพิ่ม(รับคืน) --}}
                            </td>
                            <td>
                                {{-- ต.ค. 60 --}}
                            </td>
                            <td>
                                {{-- พ.ย. 60 --}}
                            </td>
                            <td>
                                {{-- ธ.ค. 60 --}}
                            </td>
                            <td>
                                {{-- ม.ค. 61 --}}
                            </td>
                            <td>
                                {{-- ก.พ. 61 --}}
                            </td>
                            <td>
                                {{-- มี.ค. 61 --}}
                            </td>
                            <td>
                                {{-- เม.ย. 61 --}}
                            </td>
                            <td>
                                {{-- พ.ค. 61 --}}
                            </td>
                            <td>
                                {{-- มิ.ย. 61 --}}
                            </td>
                            <td>
                                {{-- ก.ค. 61 --}}
                            </td>
                            <td>
                                {{-- ส.ค. 61 --}}
                            </td>
                            <td>
                                {{-- ก.ย. 61 --}}
                            </td>
                            <td>
                                {{-- รวม --}}
                            </td>
                        </tr>
                        @foreach ($groupDescriptions as $groupDescription => $lines)
                            <tr>
                                <td>
                                    {{-- สถานที่/ทรัพย์สินที่เอาประกัน --}}
                                    &nbsp; {{ $groupDescription }}
                                </td>
                                <td class="text-right">
                                    {{-- ทุนประกันแท้จริง --}}
                                    {{ number_format($lines->where('type', 'IRP0002')->sum('actual_coverage_amount') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- แท้จริง --}}
                                    {{ number_format($lines->sum('insurance_amount') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- จ่ายแล้ว 50% --}}
                                    {{ number_format($lines->sum('paid_amount'), 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ส่วนที่เหลือ จ่ายเพิ่ม(รับคืน) --}}
                                    {{ number_format( ($lines->sum('insurance_amount') * $rate) - $lines->sum('paid_amount'), 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ต.ค. 60 --}}
                                    {{ number_format($lines->sum('period_name_1') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- พ.ย. 60 --}}
                                    {{ number_format($lines->sum('period_name_2') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ธ.ค. 60 --}}
                                    {{ number_format($lines->sum('period_name_3') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ม.ค. 61 --}}
                                    {{ number_format($lines->sum('period_name_4') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ก.พ. 61 --}}
                                    {{ number_format($lines->sum('period_name_5') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- มี.ค. 61 --}}
                                    {{ number_format($lines->sum('period_name_6') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- เม.ย. 61 --}}
                                    {{ number_format($lines->sum('period_name_7') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- พ.ค. 61 --}}
                                    {{ number_format($lines->sum('period_name_8') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- มิ.ย. 61 --}}
                                    {{ number_format($lines->sum('period_name_9') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ก.ค. 61 --}}
                                    {{ number_format($lines->sum('period_name_10') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ส.ค. 61 --}}
                                    {{ number_format($lines->sum('period_name_11') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ก.ย. 61 --}}
                                    {{ number_format($lines->sum('period_name_12') * $rate, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- รวม --}}
                                    {{ number_format(
                                        ($lines->sum('period_name_1')
                                        + $lines->sum('period_name_2')
                                        + $lines->sum('period_name_3')
                                        + $lines->sum('period_name_4')
                                        + $lines->sum('period_name_5')
                                        + $lines->sum('period_name_6')
                                        + $lines->sum('period_name_7')
                                        + $lines->sum('period_name_8')
                                        + $lines->sum('period_name_9')
                                        + $lines->sum('period_name_10')
                                        + $lines->sum('period_name_11')
                                        + $lines->sum('period_name_12'))
                                        * $rate
                                    , 2) }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    
                    @if ($loop->last)
                        <tr>
                            <td>
                                {{-- สถานที่/ทรัพย์สินที่เอาประกัน --}}
                            </td>
                            <td class="text-right">
                                {{-- ทุนประกันแท้จริง --}}
                                {{ number_format($insurances->where('type', 'IRP0002')->sum('actual_coverage_amount') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- แท้จริง --}}
                                {{ number_format($insurances->sum('insurance_amount') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- จ่ายแล้ว 50% --}}
                                {{ number_format($insurances->sum('paid_amount'), 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ส่วนที่เหลือ จ่ายเพิ่ม(รับคืน) --}}
                                {{ number_format( ($insurances->sum('insurance_amount') * $rate) - $insurances->sum('paid_amount'), 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ต.ค. 60 --}}
                                {{ number_format($insurances->sum('period_name_1') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- พ.ย. 60 --}}
                                {{ number_format($insurances->sum('period_name_2') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ธ.ค. 60 --}}
                                {{ number_format($insurances->sum('period_name_3') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ม.ค. 61 --}}
                                {{ number_format($insurances->sum('period_name_4') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ก.พ. 61 --}}
                                {{ number_format($insurances->sum('period_name_5') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- มี.ค. 61 --}}
                                {{ number_format($insurances->sum('period_name_6') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- เม.ย. 61 --}}
                                {{ number_format($insurances->sum('period_name_7') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- พ.ค. 61 --}}
                                {{ number_format($insurances->sum('period_name_8') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- มิ.ย. 61 --}}
                                {{ number_format($insurances->sum('period_name_9') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ก.ค. 61 --}}
                                {{ number_format($insurances->sum('period_name_10') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ส.ค. 61 --}}
                                {{ number_format($insurances->sum('period_name_11') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ก.ย. 61 --}}
                                {{ number_format($insurances->sum('period_name_12') * $rate, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- รวม --}}
                                {{ number_format(
                                    ($insurances->sum('period_name_1')
                                    + $insurances->sum('period_name_2')
                                    + $insurances->sum('period_name_3')
                                    + $insurances->sum('period_name_4')
                                    + $insurances->sum('period_name_5')
                                    + $insurances->sum('period_name_6')
                                    + $insurances->sum('period_name_7')
                                    + $insurances->sum('period_name_8')
                                    + $insurances->sum('period_name_9')
                                    + $insurances->sum('period_name_10')
                                    + $insurances->sum('period_name_11')
                                    + $insurances->sum('period_name_12'))
                                    * $rate
                                , 2) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif

        @endforeach

    </body>
</html>