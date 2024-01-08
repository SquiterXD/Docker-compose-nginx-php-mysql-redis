<div class="table-responsive m-t">
    <table class="table text-nowrap table-bordered table-hover" border="1">
        <thead>
            <tr>
                <th colspan="{{ count($monthlists)+ 2}}" class="text-center"> แผนการซ่อมบำรุงและลดกำลังการผลิต </th>
            </tr>
            <tr>
                <th style="width: 10%; vertical-align: middle;" class="text-center">
                   <div>  </div>
                </th>
                @foreach ($monthlists as $key => $month)
                    <th  style="width: 10%;" class="text-center">
                        <div>
                            {!! $month !!}
                        </div>
                    </th>
                @endforeach
                <th style="width: 10%; vertical-align: middle;" class="text-center">
                   <div> รวม </div>
                </th>
            </tr>
        </thead>
        <tbody>
            {{-- PM --}}
            <tr>
                <td class="tw-font-bold text-center">
                    @if ($productType == 'KK')
                        {!! str_replace('มวน', 'ชิ้น', str_replace(" (", "<br>(", 'กำหนดการหยุดซ่อมบำรุงประจำปี (ล้านมวน)')) !!}
                    @else
                        {!! str_replace(" (", "<br>(", 'กำหนดการหยุดซ่อมบำรุงประจำปี (ล้านมวน)') !!} </div>
                    @endif
                </td>
                @foreach ($monthlists as $key => $month)
                    <td class="text-right text-warning">
                        {{ number_format($machinePm[$key], 2) }}
                    </td>
                @endforeach
                <td class="text-right" style="color: #34d399;">
                    {{ number_format(array_sum($machinePm), 2) }}
                </td>
            </tr>
            {{-- DT --}}
            <tr>
                <td class="tw-font-bold text-center">
                    @if ($productType == 'KK')
                        {!! str_replace('มวน', 'ชิ้น', str_replace(" (", "<br>(", 'ลดกำลังการผลิต (ล้านมวน)')) !!}
                    @else
                        {!! str_replace(" (", "<br>(", 'ลดกำลังการผลิต (ล้านมวน)') !!} </div>
                    @endif
                </td>
                @foreach ($monthlists as $key => $month)
                    <td class="text-right text-danger">
                        {{ number_format($machineDt[$key], 2) }}
                    </td>
                @endforeach
                <td class="text-right" style="color: #34d399;">
                    {{ number_format(array_sum($machineDt), 2) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>