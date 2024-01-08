<div class="table-responsive m-t">
    <table class="table text-nowrap table-bordered table-hover" style="position: sticky;">
        {{-- <thead> --}}
            <tr>
                @php
                    $i = -1;
                @endphp
                <th rowspan="2" class="text-center" style="position: sticky; background-color: #f5f5f6; z-index: 9999; width: 150px; min-width: 70px; max-width: 150px; left: 0px;">
                    ลำดับ
                </th>
                <th rowspan="2" class="text-center" style="position: sticky; background-color: #f5f5f6; z-index: 9999; width: 150px; min-width: 135px; max-width: 150px; left: 68px;">
                    รหัสก้นกรอง
                </th>
                <th rowspan="2" class="text-center" style="position: sticky; background-color: #f5f5f6; z-index: 9999; width: 250px; min-width: 420px; max-width: 250px; left: 202px;">
                    รายละเอียด
                </th>
                @foreach ($periods as $period_no => $thai_month)
                    @php
                        $i = $i >= 4? 0: $i+1;
                    @endphp
                    <th colspan="2" class="text-center" style="background-color: {{ $yearlyColorCode[$i] }}; border-right: 3px solid #646464;">{{ $thai_month }}</th>
                @endforeach
                <th colspan="2" class="text-center" style="background-color: #35d399;">
                    รวมทั้งปีงบประมาณ
                </th>
            </tr>
            <tr>
                @foreach ($periods as $thai_month)
                    <th class="text-center" style="background-color: #f5f5f6;">ประมาณการผลิต<br>(ล้านชิ้น)</th>
                    <th class="text-center" style="border-right: 3px solid #646464; background-color: #f5f5f6;">ประมาณการใช้<br>(ล้านชิ้น)</th>
                @endforeach
                <th class="text-center" style="background-color: #f5f5f6;">
                    รวมประมาณการผลิต<br>(ล้านชิ้น)
                </th>
                <th class="text-center" style="background-color: #f5f5f6;">
                    รวมประมาณการใช้<br>(ล้านชิ้น)
                </th>
            </tr>
        {{-- </thead> --}}
        <tbody>
            @foreach ($itemList as $item)
                <tr>
                    <td class="text-center" style="position: sticky; background-color: white; z-index: 9999; width: 150px; min-width: 70px; max-width: 150px; left: 0px;">
                        {{ $loop->iteration }}
                    </td>
                    <td class="text-center" style="position: sticky; background-color: white; z-index: 9999; width: 150px; min-width: 135px; max-width: 150px; left: 68px;">
                        {{ $item->item_code }}
                    </td>
                    <td style="position: sticky; background-color: white; z-index: 9999; width: 250px; min-width: 165px; max-width: 250px; left: 202px;">
                        {{ $item->item_description }}
                    </td>
                    @foreach ($periods as $period_no => $thai_month)
                        <td class="text-right">
                            {{ number_format($estByBrand[$period_no][$item->item_code]->estimate_product, 2) }}
                        </td>
                        <td class="text-right" style="border-right: 3px solid #646464;">
                            {{ number_format($estByBrand[$period_no][$item->item_code]->estimate_used, 2) }}
                        </td>
                    @endforeach
                    <td class="text-right">
                        {{ number_format($item->estimate_product, 2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format($item->estimate_used, 2) }}
                    </td>
                </tr>
            @endforeach
            <tr >
                <th colspan="3" class="text-right" style="width: 200px; min-width: 150px; max-width: 200px; left: 0px; position: sticky; background-color: white; z-index: 9999;">
                    <strong> รวม </strong>
                </th>
                @foreach ($periods as $period_no => $thai_month)
                    <th style="background-color: #34d399;" class="text-right text-white">
                        {{ $summaryByPeriod[$period_no]->estimate_product }}
                    </th>
                    <th style="background-color: #34d399; border-right: 3px solid #646464;" class="text-right text-white">
                        {{ $summaryByPeriod[$period_no]->estimate_used }}
                    </th>
                @endforeach
                <th style="background-color: #34d399;" class="text-right text-white">
                    {{ $summaryTotal['total_estimate_product'] }}
                </th>
                <th style="background-color: #34d399;" class="text-right text-white">
                    {{ $summaryTotal['total_estimate_used'] }}
                </th>
            </tr>
        </tbody>
    </table>
</div>