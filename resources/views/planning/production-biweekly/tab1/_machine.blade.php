@if ($showBiweekly && count($machineGroup))
    <div class="form-group row">
        <label class="col-lg-1 col-form-label text-left">
        </label>
        <label class="col-lg-11 col-form-label text-left">
            {{ $machineGroup->first()->display->biweekly }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {{ $machineGroup->first()->display->biweekly_date }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {{ $machineGroup->first()->display->machine_efficiency_product }}
        </label>
    </div>
@endif

<div class="table-responsive m-t">
    <table class="table text-nowrap table-bordered table-hover" border="1" style="position: sticky;">
        <thead>
            <tr>
                <th colspan="{{ (count($workingHrs) * 3) + 5 }}" class="text-center"> ประมาณกำลังการผลิตเครื่องจักร </th>
            </tr>
            <tr>
                <th rowspan="3" rowspan="2" style="width: 10%; vertical-align: middle; width: 150px; min-width: 100px; max-width: 150px; left: 0px; position: sticky; background-color: #f7f7f7; z-index: 9999;" class="text-center">
                   <div> ขอบเขตเครื่องจักร </div>
                </th>
                <th  rowspan="2" style="width: 10%; vertical-align: middle;" class="text-center">
                   <div> รายละเอียดขอบเขตเครื่องจักร </div>
                </th>
                @foreach ($groupDesclist as $key => $groupDesc)
                    <th  style="width: 10%;" class="text-center"
                        colspan="{{ in_array($key, $groupShowWkh) ? count($workingHrs) : 1 }}"
                        rowspan="{{ in_array($key, $groupShowWkh) ? 1 : 2 }}">
                        <div>
                            @if ($productType == 'KK')
                                {!! str_replace('มวน', 'ชิ้น', str_replace(" (", "<br>(", $groupDesc)) !!}
                            @else
                                {!! str_replace(" (", "<br>(", $groupDesc) !!} </div>
                            @endif
                        </div>
                    </th>
                @endforeach
            </tr>
            <tr>
                @foreach ($groupDesclist as $key => $groupDesc)
                    @if (in_array($key, $groupShowWkh))
                        @foreach ($workingHrs as $workingHr)
                            <th  style="width: 7%;" class="text-center" >
                                {{ str_replace("ทำงาน", "", $workingHr->meaning) }}
                            </th>
                        @endforeach
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($machineGroup as $machine)
                <tr>
                    <td style="width: 170px; min-width: 100px; max-width: 170px; left: 0px; position: sticky; background-color: #f7f7f7; z-index: 9999;">
                        {{ $machine->machine_group_desc }}
                    </td>
                    <td>{{ $machine->machine_description }}</td>
                    @foreach ($groupDesclist as $key => $groupDesc)
                        @if (in_array($key, $groupShowWkh))
                            @foreach ($workingHrs as $workingHr)
                            <td class="text-right" >
                                {{ data_get($machine->group_no_list, "{$key}.{$workingHr->lookup_code}") }}
                            </td>
                            @endforeach
                        @else
                            <td class="text-right" >
                                @if ($key == 4)
                                    <div class="text-warning">
                                        {{ data_get($machine->group_no_list, $key) }}
                                    </div>
                                @elseif($key == 5)
                                    <div class="text-danger">
                                        {{ data_get($machine->group_no_list, $key) }}
                                    </div>
                                @else
                                    {{ data_get($machine->group_no_list, $key) }}
                                @endif
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="text-right text-white" >
                <th style="background-color: #34d399; width: 170px; min-width: 100px; max-width: 170px; left: 0px; position: sticky; left: 0px; position: sticky;"> </th>
                <th style="background-color: #34d399;" class="text-right">
                    รวมกำลังผลิต
                </th>
                @foreach ($groupDesclist as $key => $groupDesc)
                    @if (in_array($key, $groupShowWkh))
                        @foreach ($workingHrs as $workingHr)
                        <th style="background-color: #34d399;" >
                            {{ data_get($summary, "{$key}.{$workingHr->lookup_code}") }}
                        </th>
                        @endforeach
                    @else
                        <th  style="background-color: #34d399;" >
                            {{ data_get($summary, $key) }}
                        </th>
                    @endif
                @endforeach
            </tr>
        </tfoot>
    </table>
</div>

<style type="text/css">
    .sticky-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 9999;
    }

    .first-col {
        width: 150px;
        min-width: 100px;
        max-width: 150px;
        left: 0px;
    }
</style>
