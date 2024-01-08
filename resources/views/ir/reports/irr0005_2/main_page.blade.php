<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>รายงานรายละเอียดค่าเบี้ยประกันภัยยานพาหนะ รายเดือน</title>
    @include('ir.reports.irr0005_2._style')
</head>

<body>
    @php
        $page_no = 0;
        $group_name = '';
        $department_name = '';
        $vehicle_name = '';
        $renew_type = '';
        $month_start_th = '';
        $start_date_to_th = '';
        $group_count = 0;

        $group_sum_total = 0;
        $group_sum_1 = 0;
        $group_sum_2 = 0;
        $group_sum_3 = 0;
        $group_sum_4 = 0;
        $group_sum_5 = 0;
        $group_sum_6 = 0;
        $group_sum_7 = 0;
        $group_sum_8 = 0;
        $group_sum_9 = 0;
        $group_sum_10 = 0;
        $group_sum_11 = 0;
        $group_sum_12 = 0;
        $group_sum_13 = 0;

        $desum_total = 0;
        $desum_1 = 0;
        $desum_2 = 0;
        $desum_3 = 0;
        $desum_4 = 0;
        $desum_5 = 0;
        $desum_6 = 0;
        $desum_7 = 0;
        $desum_8 = 0;
        $desum_9 = 0;
        $desum_10 = 0;
        $desum_11 = 0;
        $desum_12 = 0;
        $desum_13 = 0;
        $department_name = '';

        $sum_total = 0;
        $sum_1 = 0;
        $sum_2 = 0;
        $sum_3 = 0;
        $sum_4 = 0;
        $sum_5 = 0;
        $sum_6 = 0;
        $sum_7 = 0;
        $sum_8 = 0;
        $sum_9 = 0;
        $sum_10 = 0;
        $sum_11 = 0;
        $sum_12 = 0;
        $sum_13 = 0;
        $car_count = 0;
    @endphp
    {{-- @foreach ($groupDatas as $page => $assetGroups) --}}
    @foreach ($groupDatas as $key => $groupList)
        @php
            if (isset($groupList['group_name'])) {
                $department_name = '';
                $vehicle_name = '';
                $renew_type = '';
                $month_start_th = '';
                $start_date_to_th = '';
                $group_name = $groupList['group_name'];
                $group_count++;
            }
            $renew_type = isset($groupList['renew_type']) ? $groupList['renew_type'] : $renew_type;
            $month_start_th = isset($groupList['month_start_th']) ? $groupList['month_start_th'] : $month_start_th;
            $start_date_to_th = isset($groupList['start_date_to_th']) ? $groupList['start_date_to_th'] : $start_date_to_th;
            $page_no++;
        @endphp
        <div style="page-break-after: always;"> </div>
        @include('ir.reports.irr0005_2.header')

        <table width="100%">
            <thead>
                <tr>
                    <th class="text-center" style="width: 18%;">
                        สถานที่ - ยี่ห้อ
                    </th>
                    <th class="text-center" style="width: 8%;">
                        ทะเบียน
                    </th>
                    {{-- <th class="text-center" style="width: 6%;">
                            บริษัทประกันภัย
                        </th> --}}
                    {{-- <th class="text-center" style="width: 5%;">
                            เลขที่กรมธรรม์
                        </th> --}}
                    <th class="text-center" style="width: 6%">
                        ค่าเบี้ยประกัน
                    </th>
                    @isset($groupList['month_list'])
                        @foreach ($groupList['month_list'] as $month_list)
                            <th class="text-center" style="width: 5%;">
                                {{ $month_list }}
                            </th>
                        @endforeach
                    @endisset
                </tr>
            </thead>
            <tbody>
                @php
                    $department = isset($groupList['department']) ? $groupList['department'] : '';
                @endphp
                @if (is_array($department) || is_object($department))
                    @foreach ($department as $assetDepartment => $departmentDescription)
                        @php
                            // if (isset($departmentDescription['department_name'])) {
                            //     $desum_total = 0;
                            //     $desum_1 = 0;
                            //     $desum_2 = 0;
                            //     $desum_3 = 0;
                            //     $desum_4 = 0;
                            //     $desum_5 = 0;
                            //     $desum_6 = 0;
                            //     $desum_7 = 0;
                            //     $desum_8 = 0;
                            //     $desum_9 = 0;
                            //     $desum_10 = 0;
                            //     $desum_11 = 0;
                            //     $desum_12 = 0;
                            //     $desum_13 = 0;
                            //     $car_count = 0;
                            //     $department_name = '';
                            // }
                        @endphp
                        @php
                            //$department_name = isset($departmentDescription['department_name']) ? $departmentDescription['department_name'] : '-';
                            if (isset($departmentDescription['department_name']) && $departmentDescription['department_name'] != '') {
                                $department_name = $departmentDescription['department_name'];
                            } elseif (isset($departmentDescription['department_name'])) {
                                $department_name = '-';
                            }

                        @endphp
                        @if (isset($departmentDescription['department_name']))
                            <tr>
                                <td style="font-weight: bold;">
                                    {{-- สถานที่ - ยี่ห้อ --}}
                                    &nbsp;{{ $department_name }}
                                </td>
                                <td>
                                    {{-- ทะเบียน --}}
                                </td>
                                {{-- <td> --}}
                                {{-- บริษัทประกันภัย --}}
                                {{-- </td> --}}
                                {{-- <td> --}}
                                {{-- เลขที่กรมธรรม์ --}}
                                {{-- </td> --}}
                                <td>
                                    {{-- ค่าเบี้ยประกัน --}}
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
                                    {{-- ต.ค. 61 --}}
                                </td>
                            </tr>
                        @endif
                        @isset($departmentDescription['vehicle'])
                            @foreach ($departmentDescription['vehicle'] as $assetVehicle => $vehicleDescription)
                                @php
                                    $vehicle_name = isset($vehicleDescription['vehicle_name']) ? $vehicleDescription['vehicle_name'] : '';
                                    // if (isset($vehicleDescription['vehicle_name']) && !empty($vehicleDescription['vehicle_name'])) {
                                    //     $vehicle_name = $vehicleDescription['vehicle_name'];
                                    // } elseif (isset($vehicleDescription['vehicle_name']) && empty($vehicleDescription['vehicle_name'])) {
                                    //     $vehicle_name = '-';
                                    // }
                                @endphp
                                @if (isset($vehicleDescription['vehicle_name']))
                                    <tr>
                                        <td>
                                            {{-- สถานที่ - ยี่ห้อ --}}
                                            &nbsp; {{ $vehicle_name }}
                                        </td>
                                        <td class="text-right">
                                            {{-- ทะเบียน --}}
                                        </td>
                                        {{-- <td class="text-right"> --}}
                                        {{-- บริษัทประกันภัย --}}
                                        {{-- </td> --}}
                                        {{-- <td class="text-right"> --}}
                                        {{-- เลขที่กรมธรรม์ --}}
                                        {{-- </td> --}}
                                        <td class="text-right">
                                            {{-- ค่าเบี้ยประกัน --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- ต.ค. 60 --}}
                                            {{-- {{ number_format($lines->sum('period_name_1') * $rate, 2) }} --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- พ.ย. 60 --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- ธ.ค. 60 --}}
                                            {{-- {{ number_format($lines->sum('period_name_3') * $rate, 2) }} --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- ม.ค. 61 --}}
                                            {{-- {{ number_format($lines->sum('period_name_4') * $rate, 2) }} --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- ก.พ. 61 --}}
                                            {{-- {{ number_format($lines->sum('period_name_5') * $rate, 2) }} --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- มี.ค. 61 --}}
                                            {{-- {{ number_format($lines->sum('period_name_6') * $rate, 2) }} --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- เม.ย. 61 --}}
                                            {{-- {{ number_format($lines->sum('period_name_7') * $rate, 2) }} --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- พ.ค. 61 --}}
                                            {{-- {{ number_format($lines->sum('period_name_8') * $rate, 2) }} --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- มิ.ย. 61 --}}
                                            {{-- {{ number_format($lines->sum('period_name_9') * $rate, 2) }} --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- ก.ค. 61 --}}
                                            {{-- {{ number_format($lines->sum('period_name_10') * $rate, 2) }} --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- ส.ค. 61 --}}
                                            {{-- {{ number_format($lines->sum('period_name_11') * $rate, 2) }} --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- ก.ย. 61 --}}
                                            {{-- {{ number_format($lines->sum('period_name_12') * $rate, 2) }} --}}
                                        </td>
                                        <td class="text-right">
                                            {{-- ต.ค. 61 --}}
                                            {{-- {{ number_format($lines->sum('period_name_12') * $rate, 2) }} --}}
                                        </td>
                                    </tr>
                                    @php
                                        // $sum_total = 0;
                                        // $sum_1 = 0;
                                        // $sum_2 = 0;
                                        // $sum_3 = 0;
                                        // $sum_4 = 0;
                                        // $sum_5 = 0;
                                        // $sum_6 = 0;
                                        // $sum_7 = 0;
                                        // $sum_8 = 0;
                                        // $sum_9 = 0;
                                        // $sum_10 = 0;
                                        // $sum_11 = 0;
                                        // $sum_12 = 0;
                                        // $sum_13 = 0;
                                        // $car_count = 0;
                                    @endphp
                                @endif
                                @isset($vehicleDescription['cars'])
                                    @foreach ($vehicleDescription['cars'] as $carDescription => $lines)
                                        @php
                                            $car_count++;
                                        @endphp
                                        <tr>
                                            <td>
                                                {{-- สถานที่ - ยี่ห้อ --}}
                                                &nbsp;&nbsp; {{ $car_count }}. &nbsp; {{ $lines['label4'] }}
                                                &nbsp;({{ $lines['label5'] }})

                                            </td>
                                            <td class="text-center">
                                                {{-- ทะเบียน --}}
                                                {{ $lines['label6'] }}
                                            </td>
                                            {{-- <td class="text-center"> --}}
                                            {{-- บริษัทประกันภัย --}}
                                            {{-- $lines['company_name'] --}}
                                            {{-- </td> --}}
                                            {{-- <td class="text-center"> --}}
                                            {{-- เลขที่กรมธรรม์ --}}
                                            {{-- $lines['policy_number'] --}}
                                            {{-- </td> --}}
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- ค่าเบี้ยประกัน --}}
                                                {{ number_format($lines['insurance_expense'], 2, '.', ',') }}
                                                @php
                                                    $sum_total += $lines['insurance_expense'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- ต.ค. 60 --}}
                                                {{ number_format($lines['label81'], 2, '.', ',') }}
                                                @php
                                                    $sum_1 += $lines['label81'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- พ.ย. 60 --}}
                                                {{ number_format($lines['label82'], 2, '.', ',') }}
                                                @php
                                                    $sum_2 += $lines['label82'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- ธ.ค. 60 --}}
                                                {{ number_format($lines['label83'], 2, '.', ',') }}
                                                @php
                                                    $sum_3 += $lines['label83'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- ม.ค. 61 --}}
                                                {{ number_format($lines['label84'], 2, '.', ',') }}
                                                @php
                                                    $sum_4 += $lines['label84'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- ก.พ. 61 --}}
                                                {{ number_format($lines['label85'], 2, '.', ',') }}
                                                @php
                                                    $sum_5 += $lines['label85'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- มี.ค. 61 --}}
                                                {{ number_format($lines['label86'], 2, '.', ',') }}
                                                @php
                                                    $sum_6 += $lines['label86'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- เม.ย. 61 --}}
                                                {{ number_format($lines['label87'], 2, '.', ',') }}
                                                @php
                                                    $sum_7 += $lines['label87'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- พ.ค. 61 --}}
                                                {{ number_format($lines['label88'], 2, '.', ',') }}
                                                @php
                                                    $sum_8 += $lines['label88'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- มิ.ย. 61 --}}
                                                {{ number_format($lines['label89'], 2, '.', ',') }}
                                                @php
                                                    $sum_9 += $lines['label89'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- ก.ค. 61 --}}
                                                {{ number_format($lines['label810'], 2, '.', ',') }}
                                                @php
                                                    $sum_10 += $lines['label810'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- ส.ค. 61 --}}
                                                {{ number_format($lines['label811'], 2, '.', ',') }}
                                                @php
                                                    $sum_11 += $lines['label811'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- ก.ย. 61 --}}
                                                {{ number_format($lines['label812'], 2, '.', ',') }}
                                                @php
                                                    $sum_12 += $lines['label812'];
                                                @endphp
                                            </td>
                                            <td class="text-right {{ $loop->last ? 'border_bottom' : '' }}">
                                                {{-- ต.ค. 61 --}}
                                                {{ number_format($lines['label813'], 2, '.', ',') }}
                                                @php
                                                    $sum_13 += $lines['label813'];
                                                @endphp
                                            </td>
                                        </tr>

                                        @if (isset($lines['vehicle_end']) || isset($lines['department_end']))
                                            <tr>
                                                <td class="text-underline">
                                                    {{-- สถานที่ - ยี่ห้อ --}}
                                                    รวม {{ $vehicle_name }}
                                                </td>
                                                <td class="text-right">
                                                    {{-- ทะเบียน --}}
                                                </td>
                                                {{-- <td class="text-right"> --}}
                                                {{-- บริษัทประกันภัย --}}
                                                {{-- </td> --}}
                                                {{-- <td class="text-right"> --}}
                                                {{-- เลขที่กรมธรรม์ --}}
                                                {{-- </td> --}}
                                                <td class="text-right border_double">
                                                    {{-- ค่าเบี้ยประกัน --}}
                                                    {{ number_format($sum_total, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- ต.ค. 60 --}}
                                                    {{ number_format($sum_1, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- พ.ย. 60 --}}
                                                    {{ number_format($sum_2, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- ธ.ค. 60 --}}
                                                    {{ number_format($sum_3, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- ม.ค. 61 --}}
                                                    {{ number_format($sum_4, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- ก.พ. 61 --}}
                                                    {{ number_format($sum_5, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- มี.ค. 61 --}}
                                                    {{ number_format($sum_6, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- เม.ย. 61 --}}
                                                    {{ number_format($sum_7, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- พ.ค. 61 --}}
                                                    {{ number_format($sum_8, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- มิ.ย. 61 --}}
                                                    {{ number_format($sum_9, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- ก.ค. 61 --}}
                                                    {{ number_format($sum_10, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- ส.ค. 61 --}}
                                                    {{ number_format($sum_11, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- ก.ย. 61 --}}
                                                    {{ number_format($sum_12, 2, '.', ',') }}
                                                </td>
                                                <td class="text-right border_double">
                                                    {{-- ต.ค. 61 --}}
                                                    {{ number_format($sum_13, 2, '.', ',') }}
                                                </td>
                                            </tr>
                                            @php
                                                $desum_total += $sum_total;
                                                $desum_1 += $sum_1;
                                                $desum_2 += $sum_2;
                                                $desum_3 += $sum_3;
                                                $desum_4 += $sum_4;
                                                $desum_5 += $sum_5;
                                                $desum_6 += $sum_6;
                                                $desum_7 += $sum_7;
                                                $desum_8 += $sum_8;
                                                $desum_9 += $sum_9;
                                                $desum_10 += $sum_10;
                                                $desum_11 += $sum_11;
                                                $desum_12 += $sum_12;
                                                $desum_13 += $sum_13;

                                                $sum_total = 0;
                                                $sum_1 = 0;
                                                $sum_2 = 0;
                                                $sum_3 = 0;
                                                $sum_4 = 0;
                                                $sum_5 = 0;
                                                $sum_6 = 0;
                                                $sum_7 = 0;
                                                $sum_8 = 0;
                                                $sum_9 = 0;
                                                $sum_10 = 0;
                                                $sum_11 = 0;
                                                $sum_12 = 0;
                                                $sum_13 = 0;

                                            @endphp
                                        @endif
                                    @endforeach
                                @endisset

                                {{-- @if ($loop->last && isset($department[$assetDepartment + 1]['department_name'])) --}}
                                @if (isset($lines['department_end']))
                                    @php
                                        $group_sum_total += $desum_total;
                                        $group_sum_1 += $desum_1;
                                        $group_sum_2 += $desum_2;
                                        $group_sum_3 += $desum_3;
                                        $group_sum_4 += $desum_4;
                                        $group_sum_5 += $desum_5;
                                        $group_sum_6 += $desum_6;
                                        $group_sum_7 += $desum_7;
                                        $group_sum_8 += $desum_8;
                                        $group_sum_9 += $desum_9;
                                        $group_sum_10 += $desum_10;
                                        $group_sum_11 += $desum_11;
                                        $group_sum_12 += $desum_12;
                                        $group_sum_13 += $desum_13;
                                    @endphp
                                    <tr>
                                        <td class="text-underline">
                                            {{-- สถานที่ - ยี่ห้อ --}}
                                            รวม {{ $department_name }}
                                        </td>
                                        <td class="text-right">
                                            {{-- ทะเบียน --}}
                                        </td>
                                        {{-- <td class="text-right"> --}}
                                        {{-- บริษัทประกันภัย --}}
                                        {{-- </td> --}}
                                        {{-- <td class="text-right"> --}}
                                        {{-- เลขที่กรมธรรม์ --}}
                                        {{-- </td> --}}
                                        <td class="text-right border_double bg-gray">
                                            {{-- ค่าเบี้ยประกัน --}}
                                            {{ number_format($desum_total, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- ต.ค. 60 --}}
                                            {{ number_format($desum_1, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- พ.ย. 60 --}}
                                            {{ number_format($desum_2, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- ธ.ค. 60 --}}
                                            {{ number_format($desum_3, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- ม.ค. 61 --}}
                                            {{ number_format($desum_4, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- ก.พ. 61 --}}
                                            {{ number_format($desum_5, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- มี.ค. 61 --}}
                                            {{ number_format($desum_6, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- เม.ย. 61 --}}
                                            {{ number_format($desum_7, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- พ.ค. 61 --}}
                                            {{ number_format($desum_8, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- มิ.ย. 61 --}}
                                            {{ number_format($desum_9, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- ก.ค. 61 --}}
                                            {{ number_format($desum_10, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- ส.ค. 61 --}}
                                            {{ number_format($desum_11, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- ก.ย. 61 --}}
                                            {{ number_format($desum_12, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right border_double bg-gray">
                                            {{-- ต.ค. 61 --}}
                                            {{ number_format($desum_13, 2, '.', ',') }}
                                        </td>
                                    </tr>
                                    @php
                                        $desum_total = 0;
                                        $desum_1 = 0;
                                        $desum_2 = 0;
                                        $desum_3 = 0;
                                        $desum_4 = 0;
                                        $desum_5 = 0;
                                        $desum_6 = 0;
                                        $desum_7 = 0;
                                        $desum_8 = 0;
                                        $desum_9 = 0;
                                        $desum_10 = 0;
                                        $desum_11 = 0;
                                        $desum_12 = 0;
                                        $desum_13 = 0;
                                        $car_count = 0;
                                        $department_name = '';
                                    @endphp
                                @endif
                            @endforeach
                        @endisset
                    @endforeach

                    @if (isset($groupDatas[$key + 1]['renew_type']) || $page_no == $pageAll)
                        @php
                            $group_sum_total += $desum_total;
                            $group_sum_1 += $desum_1;
                            $group_sum_2 += $desum_2;
                            $group_sum_3 += $desum_3;
                            $group_sum_4 += $desum_4;
                            $group_sum_5 += $desum_5;
                            $group_sum_6 += $desum_6;
                            $group_sum_7 += $desum_7;
                            $group_sum_8 += $desum_8;
                            $group_sum_9 += $desum_9;
                            $group_sum_10 += $desum_10;
                            $group_sum_11 += $desum_11;
                            $group_sum_12 += $desum_12;
                            $group_sum_13 += $desum_13;
                        @endphp

                        <tr>
                            <td colspan="2" class="text-total border_top">
                                {{-- สถานที่ - ยี่ห้อ --}}
                                รวมทั้งสิ้น : {{ $renew_type }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- ค่าเบี้ยประกัน --}}
                                {{ number_format($group_sum_total, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- ต.ค. 60 --}}
                                {{ number_format($group_sum_1, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- พ.ย. 60 --}}
                                {{ number_format($group_sum_2, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- ธ.ค. 60 --}}
                                {{ number_format($group_sum_3, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- ม.ค. 61 --}}
                                {{ number_format($group_sum_4, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- ก.พ. 61 --}}
                                {{ number_format($group_sum_5, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- มี.ค. 61 --}}
                                {{ number_format($group_sum_6, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- เม.ย. 61 --}}
                                {{ number_format($group_sum_7, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- พ.ค. 61 --}}
                                {{ number_format($group_sum_8, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- มิ.ย. 61 --}}
                                {{ number_format($group_sum_9, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- ก.ค. 61 --}}
                                {{ number_format($group_sum_10, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- ส.ค. 61 --}}
                                {{ number_format($group_sum_11, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- ก.ย. 61 --}}
                                {{ number_format($group_sum_12, 2, '.', ',') }}
                            </td>
                            <td class="text-right border_double bg-gray">
                                {{-- ต.ค. 61 --}}
                                {{ number_format($group_sum_13, 2, '.', ',') }}
                            </td>
                        </tr>
                        @php
                            $group_sum_total = 0;
                            $group_sum_1 = 0;
                            $group_sum_2 = 0;
                            $group_sum_3 = 0;
                            $group_sum_4 = 0;
                            $group_sum_5 = 0;
                            $group_sum_6 = 0;
                            $group_sum_7 = 0;
                            $group_sum_8 = 0;
                            $group_sum_9 = 0;
                            $group_sum_10 = 0;
                            $group_sum_11 = 0;
                            $group_sum_12 = 0;
                            $group_sum_13 = 0;
                        @endphp
                    @endif
                @else
                    <tr>
                        <td colspan="16" class="text-center">
                            ไม่พบข้อมูล
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    @endforeach

</body>

</html>
