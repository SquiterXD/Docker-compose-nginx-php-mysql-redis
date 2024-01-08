<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center" style="vertical-align: middle;">
               <div> ลำดับ </div> 
            </th>
            <th class="text-center" style="vertical-align: middle;">
               <div> ขอบเขตเรื่องจักร </div>
            </th>
            @foreach ($planDates as $res_plan_date => $working)
                <th class="text-center" style="vertical-align: middle;">
                    <div class="mb-2">
                        <small style="color: #000" class="mb-2 tw-font-bold">
                            <div>{{ Arr::get($planDateDayOfWeek, "$res_plan_date.$res_plan_date", '') }}</div>
                            {{ convertFormatDateToThai(date('Y-M-d', strtotime($res_plan_date))) }} <br>
                            WH:
                            @php
                                $labelClass = '';
                                if ($working[$res_plan_date] == 8) {
                                    $labelClass = 'label-success';
                                } elseif ($working[$res_plan_date] == 9) {
                                    $labelClass = 'label-warning';
                                } elseif ($working[$res_plan_date] == 13) {
                                    $labelClass = 'label-danger';
                                }
                            @endphp
                            <small>
                                <span style="font-size: 9px;" class="label {{ $labelClass }}">{{ $working[$res_plan_date] ?? 0 }}</span>
                            </small>
                        </small>
                    </div>
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @if (count($machines) == 0)
            <tr>
                <td colspan="6" class="text-center" style="vertical-align: middle;">
                    <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                </td>
            </tr>
        @else
            @foreach ($machines as $machine_desc => $lines)
                <tr title="{{ $machine_desc }}">
                    <td rowspan="2" class="text-center">
                        <div style="width: 20px;"> {{ $loop->iteration }} </div>
                    </td>
                    <td rowspan="2" class="text-left">
                        <div style="width: 100px;"> {{ $machine_desc }} </div>
                    </td>
                    <td colspan="{{ count($planDates) }}" style="padding: 3px;">
                        <div class="progress" style="height: 25px; padding: 1px;">
                            {{-- @foreach ($lines as $line) --}}
                                @foreach ($progress as $machine_desc_prog => $progs)
                                    @foreach ($progs as $item_desc => $prog)
                                        @if ($machine_desc_prog == $machine_desc)
                                            @php
                                                $result = getSummaryEfficiency($sumEfficiencyMachines, $item_desc, $machine_desc);
                                            @endphp
                                            <div class="progress-bar" style="width: {{ $prog }}%;
                                                background-color: {!! getCigaretteColor($efficiencyMachines, $item_desc) !!}"
                                                title="{!! '[ '.$machine_desc.'] -- '.checkIsADateOrIsADesc($item_desc).' '.$result !!}" 
                                                role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="9999">
                                                {{ checkIsADateOrIsADesc($item_desc).' '.$result }}
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            {{-- @endforeach --}}
                        </div>
                    </td>
                    </tr>
                    @foreach ($lines as $line)
                        @foreach ($planDates as $res_plan_date => $working)
                            @if ($res_plan_date == $line->daily_date && $machineDowntimes[$res_plan_date][$line->machine_group_desc] == 'Y')
                                <td class="text-right" style="background-color: #e02b1e;">
                                    <div style="width: 70px;"> 0.00 </div>
                                </td>
                            @elseif($res_plan_date == $line->daily_date && $machineMaintenances[$res_plan_date][$line->machine_group_desc] == 'Y')
                                <td class="text-right" style="background-color: #ffc107;">
                                    <div style="width: 70px;"> 0.00 </div>
                                </td>
                            @elseif($res_plan_date == $line->daily_date && $holidays[$res_plan_date][$line->machine_group_desc] == 'Y')
                                @if ($line->ot_flag == 'P')
                                    <td class="text-right" style="background-color: #878788;">
                                        <div style="width: 70px;"> {{ number_format($line->date_efficiency_product, 2) }} </div>
                                    </td>
                                @else
                                    <td class="text-right" style="background-color: {{ checkPublicHoliday($line->daily_date) == 'Y'? '#878788;': '#cccccc;'  }}">
                                        <div style="width: 70px;"> 0.00 </div>
                                    </td>
                                @endif
                            @elseif($res_plan_date == $line->daily_date
                                && $machineDowntimes[$res_plan_date][$line->machine_group_desc] != 'Y' 
                                && $machineMaintenances[$res_plan_date][$line->machine_group_desc] != 'Y' 
                                && $holidays[$res_plan_date][$line->machine_group_desc] != 'Y')
                                <td>
                                    <div class="text-right" style="width: 70px;">
                                        {{ number_format($line->date_efficiency_product, 2) }}
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    @endforeach
                </tr>
            @endforeach
        @endif
    </tbody>
</table>