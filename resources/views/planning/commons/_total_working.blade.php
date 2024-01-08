@if ($isKkProdusct && false)
    {{-- expr --}}
@else

    <div class="row mb-4">
        <div class="col-lg-6">
            <dl class="row mb-0">
                <div class="col-6 text-sm-right">
                    <dt>จำนวนวันขาย:</dt>
                </div>
                <div class="col-6 text-sm-left">
                    <dd class="mb-1">
                        <span class="pull-right label label-default">
                            {{ number_format($firstItem->om_day_for_sale ?? 0, 2) }}
                            วัน
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
        <div class="col-lg-6" >
            <dl class="row mb-0">
                <div class="col-6 text-sm-right">
                    <dt>&nbsp;</dt>
                </div>
                <div class="col-6 text-sm-left">
                    <dd class="mb-1">&nbsp;</dd>
                </div>
            </dl>
        </div>
    </div>

    @foreach ($workingHour as $hour)
    @php
        if (!isset($tab22WKHData)) {
            $tab22WKH = null;
        } else {
            $tab22WKH = optional($tab22WKHData->where('working_hour', $hour->lookup_code))->first();
        }
    @endphp
    <div class="row mb-2">
        <div class="col-lg-6 ">
            <dl class="row mb-0">
                <div class="col-6 text-sm-right">
                    <dt>ทำงาน {{ $hour->meaning }}:</dt>
                </div>
                <div class="col-6 text-sm-left">
                    <dd class="mb-1">
                        <span class="pull-right label label-default">
                            {{-- {{ $firstItem->getAttribute("total_wk{$hour->lookup_code}_day") }} --}}
                            {{ optional($tab22WKH)->total_wk_day }}
                            วัน
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="col-lg-6" >
            <dl class="row mb-0">
                @if ($hour->lookup_code != 8)
                    <div class="col-6 text-sm-right">
                        <dt>
                            @if ($hour->lookup_code == 9)
                                ผลผลิตล่วงเวลากลางวัน
                            @else
                                ผลผลิตล่วงเวลา
                            @endif
                        </dt>
                    </div>
                    <div class="col-6 text-sm-left">
                        <dd class="mb-1">
                            <span class="pull-right label label-default">
                                {{-- {{ $firstItem->getAttribute("total_wk{$hour->lookup_code}_ot_qty") }} ล้านมวน --}}
                                {{ optional($tab22WKH)->total_wkot_qty }} ล้านมวน
                            </span>
                        </dd>
                    </div>
                @else
                    <div class="col-6 text-sm-right">
                        <dt>&nbsp;</dt>
                    </div>
                    <div class="col-6 text-sm-left">
                        <dd class="mb-1">&nbsp;</dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
    @endforeach

    <div class="row mb-2 mt-4">
        <div class="col-lg-6">
            <dl class="row mb-0">
                <div class="col-6 text-sm-right">
                    <dt>ประมาณกำลังผลิตสูงสุด:</dt>
                </div>
                <div class="col-6 text-sm-left">
                    <dd class="mb-1">
                        <span class="pull-right label label-default">
                            {{ number_format($firstItem->max_planning_qty ?? 0, 4) }} ล้านมวน
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
        <div class="col-lg-6" >
            <dl class="row mb-0">
                <div class="col-6 text-sm-right">
                    <dt>จำนวนชุดสูงสุด:</dt>
                </div>
                <div class="col-6 text-sm-left">
                    <dd class="mb-1">
                        <span class="pull-right label label-default">
                            {{ number_format($firstItem->total_qty ?? 0, 4) }} ชุด
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- @if ($firstItem->current_flag != 'Y')
        <div class="row mb-3">
            <div class="col-lg-6">
                <dl class="row mb-0">
                    <div class="col-6 text-sm-right">
                        <dt>กำลังผลิตคั่วใบยาสูงสุด:</dt>
                    </div>
                    <div class="col-6 text-sm-left">
                        <dd class="mb-1">
                            <span class="pull-right label label-default">
                                {{ number_format($firstItem->max_qty ?? 0, 4) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="col-lg-6" >
                <dl class="row mb-0">
                    <div class="col-6 text-sm-right">
                        <dt>&nbsp;</dt>
                    </div>
                    <div class="col-6 text-sm-left">
                        <dd class="mb-1">&nbsp;</dd>
                    </div>
                </dl>
            </div>
        </div>
    @endif --}}



    {{-- <h3 class="mb-2 text-center" :style="'color: ' + biweeklyColorCode[index]">
        <strong> ปักษ์ที่ {{ $firstItem->ppBiWeekly->biweekly }}</strong>
    </h3> --}}
    {{-- <table class="table table-hover  no-margins">
        <tbody>
            <tr>
                <td class="text-left" width="50%">
                    จำนวนวันขาย
                    <span class="pull-right">
                        <span class="pull-right label label-default">
                            {{ number_format($firstItem->om_day_for_sale ?? 0, 2) }}
                            วัน
                        </span>
                    </span>
                </td>
                <td  width="50%">
                </td>
            </tr>
            @foreach ($workingHour as $hour)
                <tr >
                    <td class="text-left">
                        ทำงาน {{ $hour->meaning }}
                        <span class="pull-right label label-default">
                            {{ $firstItem->getAttribute("total_wk{$hour->lookup_code}_day") }}
                            วัน
                        </span>
                    </td>
                    <td>
                        @if ($hour->lookup_code != 8)
                            ผลผลิตล่วงเวลา
                            <span class="pull-right label label-default">
                                {{ $firstItem->getAttribute("total_wk{$hour->lookup_code}_ot_qty") }}
                                ล้านมวน
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="text-left">
                    ประมาณกำลังผลิตสูงสุด
                    <span class="pull-right label label-default">
                        {{ number_format($firstItem->max_planning_qty ?? 0, 4) }}
                        ล้านมวน
                    </span>
                </td>
                <td>
                    จำนวนชุดสูงสุด
                    <span class="pull-right label label-default">
                        {{ number_format($firstItem->total_qty ?? 0, 4) }}
                        ชุด
                    </span>
                </td>
            </tr>
            <tr>
                @if ($firstItem->current_flag != 'Y')
                    <td colspan="2" class="text-left" >
                        กำลังผลิตคั่วใบยาสูงสุด
                        <span class=" label label-default">
                            {{ number_format($firstItem->max_qty ?? 0, 4) }}
                        </span>
                    </td>
                @else
                    <td colspan="2" v-else>
                        &nbsp;
                    </td>
                @endif
            </tr>
        </tbody>
    </table> --}}
@endif

