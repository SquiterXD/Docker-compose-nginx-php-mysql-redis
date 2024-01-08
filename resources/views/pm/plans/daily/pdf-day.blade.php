<style type="text/css">
    @font-face{
        font-family: 'SarabunSans';
        font-style: 'normal';
        src: url("file://{!! public_path('/fonts/Sarabun-Regular.ttf') !!}") format('truetype');
    }
    .page {
        overflow: hidden;
        page-break-after: always;
        position: relative;
        min-height: 1050px;
    }
    .page:last-of-type {
        page-break-after: auto
    }
    body {
        font-family: 'SarabunSans';
        font-size: 10px!important;
    }
    .td-day {
        width: 33.3333%;
        vertical-align: top;
        border: solid 1px #000;
    }
    .td-item {
        border: solid 1px #000;
    }
    .text-right {
        text-align: right!important;
    }
    .text-center {
        text-align: center!important;
    }
    .item {
        overflow: hidden!important;
        position: relative;
        border: solid 0px #000;
        /*background-color:  salmon;*/
        /*height: 313px;*/
        font-family: 'SarabunSans';
        font-size: 10px!important;
        height: 325px;
    }

    table tr td {
        font-family: 'SarabunSans';
        font-size: 10px!important;
        font:  red;
    }

    .container {
      display: table;
      width: 100%;
      border: 1px solid #000;
    }
    .container div {
      display: table-cell;
      border: 1px solid #000;
    }

    .grid-container-element { 
    display: grid; 
    grid-template-columns: 1fr 1fr; 
    grid-gap: 20px; 
    border: 1px solid black; 
    width: 50%; 
} 
.grid-child-element { 
    margin: 10px; 
    border: 1px solid red; 
}
</style>
@foreach ($machineData as $page)
@php
    $rows = $page->rows;
    $planHeader = $page->planHeader;
    $planLine = $page->planLine;
    $uomCodes = $page->uomCodes;
    $weeklyNum = $page->weeklyNum;
    $status = '-';
    if (count($planStatuses)) {
        $status = optional(optional($planStatuses->where('lookup_code', $planHeader->status))->first())->description ?? '';
    }
@endphp
<div style="page-break-before:always;">
<table border="0" width="100%">
    <tr>
        <td colspan="3" class="text-center">
            <div style="font-size: 12px"><strong>GRAVURE WEEK PLAN</strong></div>
            <div><strong>ปักษ์ที่ {{ $planHeader->biweekly }}/{{ $weeklyNum }}  edit {{ $planHeader->version }}</strong></div>
        </td>
    </tr>
    <tr>
        <td width="33.33%">
            <strong>
                เครื่องจักร: {{ optional($planLine->first())->machine_name }}
            </strong>
        </td>
        <td width="33.33%" class="text-center">
            <strong>
                สถานะ: {{ $status }}
            </strong>
        </td>
        <td width="33.33%" class="text-right">
            <strong>
                FM-PDP-03/01 (Rev.{{ str_pad($planHeader->version ?? 0, 2, 0, STR_PAD_LEFT) }})
            </strong>
        </td>
    </tr>
</table>
<table width="100%" heightx="98%"  border="1" style="border: solid 1px #000;" cellpadding="5" cellspacing="0" >
    <tbody>
        @foreach ($rows as $row)
        <tr>
            @foreach ($row as $dy)
            {{-- @foreach ([2] as $dy) --}}
            <td style="" class="">
                <div class="item">
                @php
                    $planDay = $planLine->where('dy', $dy);
                    if (count($planDay)) {
                        // $planDay = $planDay->groupBy('inventory_item_id');
                    }
                @endphp
                @if (count($planDay))
                    @foreach ($planDay->groupBy('inventory_item_id') as $groupItems)
                            @if ($loop->first)
                                <table  width="100%" border="0" style="border: solid 0px #000;" cellspacing="0">
                                    <tr>
                                        <td width="50%">
                                            <strong>
                                                {{ $groupItems->first()->day_name_th }} {{ $groupItems->first()->date_th }}
                                            </strong>
                                        </td>
                                        <td width="50%" class="text-right">
                                            <strong>
                                                {{ optional($groupItems->first()->planTime)->description }}
                                            </strong>
                                        </td>
                                    </tr>
                                </table>
                                {{-- <tr>
                                    <td class="text-center" colspan="7">
                                        {{ optional($groupItems->first()->planTime)->description }}
                                    </td>
                                </tr> --}}
                            @endif
                        <table width="100%" style="border: solid 1px #000; margin-bottom: 2px; " border="1" style="border: solid 1px #000;" cellspacing="0" cellpadding="1">
                            @foreach ($groupItems->groupBy('plan_time') as $planTimeData)
                                @foreach ($planTimeData as $item)
                                    <tr class="">
                                        <td class="text-center"> Item </td>
                                        <td class="text-center"> Brand </td>
                                        <td class="text-center"> Product </td>
                                        <td class="text-center"> Quantity </td>
                                        <td class="text-center"> UOM </td>
                                        <td class="text-center"> Job Number</td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-center"> {{ optional($item->invItem)->item_number }} </td>
                                        <td class="text-center" style="background-color: {{ $item->colors ?? '#fff' }}">
                                            <strong>{{ $item->brand }}</strong>
                                        </td>
                                        <td class="text-center" style="background-color: {{ $item->attribute12 ?? '#fff' }}">
                                            <strong>{{ $item->product }}</strong>
                                        </td>
                                        <td class="text-center"> {{ $item->qty }} </td>
                                        {{-- <td class="text-center"> {{ $uomCodes->where('uom_code_value', $item->) }} xx</td> --}}
                                        <td class="text-center"> {{ '' }} </td>
                                        <td class="text-center"> {{ $item->request_number }}</td>
                                        {{-- <td class="text-center td-item"> {{ $item->colors }} </td> --}}
                                    </tr>
                                    <tr class="">
                                        <td class="" colspan="7">
                                            {{ optional($item->invItem)->item_desc }}
                                        </td>
                                    </tr>
                                    <tr class="">

                                        <td class="" colspan="7">
                                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="25%">เวลาเริ่ม: </td>
                                                    <td width="25%">
                                                        {{ $item->mes_starttime ? \Carbon\Carbon::parse($item->mes_starttime)->format('H:i') : '-' }}
                                                    </td>
                                                    <td width="25%">เวลาสิ้นสุด: </td>
                                                    <td width="25%">
                                                        {{ $item->mes_endtime ? \Carbon\Carbon::parse($item->mes_endtime)->format('H:i') : '-' }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td class="" colspan="7">
                                            หมายเหตุ: {{ $item->remark ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    @endforeach
                @endif
                </div>
            </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endforeach