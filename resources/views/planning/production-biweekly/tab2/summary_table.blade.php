
<div class="table-responsive m-t">
    <table class="table text-nowrap table-bordered table-hover">
        <thead>
            <tr>
                <th>ลำดับ</th>
                {{-- <th>ตรา</th> --}}
                <th>รหัสบุหรี่</th>
                <th>ตราบุหรี่</th>
                <th class="text-center">ประมาณการจำหน่าย<br>(พันมวน)</th>
                <th class="text-center">ประมาณการจำหน่าย<br>(ล้านมวน)</th>
                <th class="text-center">เฉลี่ยประมาณการจำหน่ายต่อวัน<br>(ล้านมวน)</th>
                <th class="text-center">เฉลี่ยยอดจำหน่ายต่อวัน<br>(ล้านมวน)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($summaries ?? [] as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                {{-- <td class="text-center">{{ $item->stamp_desc }}</td> --}}
                <td>{{ $item->item_code }}</td>
                <td>{{ $item->item_description }}</td>
                <td class="text-right">{{ $item->forecast_qty_format }}</td>
                <td class="text-right">{{ $item->forecast_million_qty_format }}</td>
                <td class="text-right">{{ $item->average_forecast_qty_format }}</td>
                <td class="text-right">
                    {{ $item->actual_forecast_qty_format }}
                    {{-- For Demo --}}
                    {{-- @php
                        $demo = rand(0.1, 20);
                        $avg = ($avg ?? 0) + $demo;
                    @endphp
                    {{ number_format($demo, 3) }} --}}
                </td>
            </tr>
            @endforeach
            <tr>
                <th colspan="3" class="text-right">รวม</th>
                <th style="background-color: #34d399;" class="text-right text-white">
                    {{ getSumFormat($summaries, 'forecast_qty', 2) }}
                </th>
                <th style="background-color: #34d399;" class="text-right text-white">
                    {{ getSumFormat($summaries, 'forecast_million_qty', 2) }}
                </th>
                <th style="background-color: #34d399;" class="text-right text-white">
                    {{ getSumFormat($summaries, 'average_forecast_qty', 2) }}
                </th>
                <th style="background-color: #34d399;" class="text-right text-white">
                    {{ getSumFormat($summaries, 'actual_forecast_qty', 2) }}

                    {{-- For Demo --}}
                    {{-- @if (count($summaries))
                        {{ number_format($avg, 3) }}
                    @endif --}}
                </th>
            </tr>
        </tbody>
    </table>
</div>
