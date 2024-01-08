<html>
    <head>
        <title>รายงานผลผลิต</title>
        <style type="text/css">
            @font-face{
                font-family: 'SarabunSans';
                font-style: 'normal';
                src: url("file://{!! public_path('/fonts/Sarabun-Regular.ttf') !!}") format('truetype');
            }

            body {
                font-family: 'SarabunSans';
                font-size: 10px;
            }

            .table-content {
                border-collapse: collapse;
                font-size: 10px;
                page-break-inside:auto;
            }

            .table-header {
                text-align: center;
            }

            .table-content tr {
                page-break-inside:avoid;
                page-break-after:auto;
            }

            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }

            /*#PDR1150 .col-1  { width: 40px; }*/
            #PDR1150 .transaction_date  { width: 75px; }
            #PDR1150 .batch_no  { width: 80px; }
            #PDR1150 .blend_no  { width: 60px; }
            #PDR1150 .item_desc  { width: 170px; }
            #PDR1150 .wip_step  { width: 50px; }
            #PDR1150 .col-7  { width: 60px; }
            #PDR1150 .col-8  { width: 100px; }
            #PDR1150 .col-9  { width: 100px; }
            #PDR1150 .col-10 { width: 100px; }
            #PDR1150 .col-11  { width: 100px; }
            #PDR1150 .col-12  { width: 100px; }
            #PDR1150 .col-13  { width: 40px; }

            #PDR1180 .col-1  { width: 100px; }
            #PDR1180 .col-2  { width: 100px; }
            /*#PDR1180 .col-3  { width: 100px; }*/
            #PDR1180 .col-4  { width: 100px; }
            #PDR1180 .col-5  { width: 150px; }
            #PDR1180 .col-6  { width: 100px; }
            /*#PDR1180 .col-7  { width: 60px; }*/
            #PDR1180 .col-8  { width: 100px; }
            #PDR1180 .col-9  { width: 100px; }
            #PDR1180 .col-10 { width: 100px; }
            #PDR1180 .col-11  { width: 100px; }
            #PDR1180 .col-12  { width: 100px; }
            #PDR1180 .col-13  { width: 100px; }

            #PDR2040 .col-1  { width: 100px; }
            /*#PDR2040 .col-2  { width: 100px; }*/
            /*#PDR2040 .col-3  { width: 100px; }*/
            #PDR2040 .col-4  { width: 100px; }
            #PDR2040 .col-5  { width: 200px; }
            #PDR2040 .col-6  { width: 100px; }
            /*#PDR2040 .col-7  { width: 60px; }*/
            #PDR2040 .col-8  { width: 100px; }
            #PDR2040 .col-9  { width: 100px; }
            #PDR2040 .col-10 { width: 100px; }
            #PDR2040 .col-11  { width: 100px; }
            #PDR2040 .col-12  { width: 100px; }
            #PDR2040 .col-13  { width: 100px; }

            .table-main {
                border-collapse: collapse;
                font-size: 10px;
                page-break-inside:auto;
            }
            .table-main thead tr td {
                text-align: center;
            }
            .table-main tr {
                page-break-inside:avoid;
                page-break-after:auto;
            }

        </style>
    </head>
    <body>
        @if($reportCode == 'PDR1150')
        @php
            $isGroupByOpt = (request()->report_type == 'group_by_opt');
            $isGroupByWip = (request()->report_type ==  'group_by_WIP');

            if ($isGroupByWip) {
                $showItemNo = ((session('organization_code') == 'M02' || session('organization_code') == 'M03'));
            } else {
                $showItemNo = (session('organization_code') != 'M02' && session('organization_code') != 'M03');
            }
        @endphp
        <table class="table-content">
            <thead>
                <tr>
                    <td colspan="13">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header" id="PDR1150">
                    {{-- <td class="col-1">ลำดับที่</td> --}}
                    <td class="transaction_date">วันที่ได้ผลผลิต</td>
                    {{-- @if(($batchNoFrom && $batchNoFrom != 'ALL') || ($batchNoTo && $batchNoTo != 'ALL' )) --}}
                    <td class="batch_no">คำสั่งผลิตเลขที่</td>
                    {{-- @endif --}}
                    <td class="blend_no">
                        @if ($showItemNo)
                            Item No.
                        @else
                            Blend No.
                        @endif
                    </td>
                    <td class="item_desc">รายละเอียด</td>
                    <td class="wip_step">WIP</td>
                    <td class="col-7">OPT</td>
                    <td class="col-8">คงคลังเช้า</td>
                    <td class="col-9">สูญเสีย</td>
                    <td class="col-10">ผลผลิตที่ได้/รับโอน</td>
                    <td class="col-11">จ่ายออก/โอนออก</td>
                    <td class="col-12">คงคลังเย็น</td>
                    <td class="col-13">หนว่ยนับ</td>
                </tr>
                <tr>
                    <td colspan="13">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalConfirmQtyAmount = 0;
                @endphp
                @foreach($datas->groupBy('trns_date_only') as $key => $data)
                    @php
                        $countDataRow = 0;
                    @endphp
                    @foreach($data->groupBy('batch_no') as $batchs)
                        {{-- @foreach($batchs->groupBy('blend_no') as $blends) --}}
                        {{-- @foreach($userOrgCode == 'MG6' ? $batchs->groupBy('blend_no2') : $batchs->groupBy('blend_no') as $blends) --}}
                        @foreach($userOrgCode == 'M02' ? $batchs->groupBy('blend_no') : $batchs->groupBy('item_number') as $blends)
                            @php
                                $countBlendRow = 0;
                            @endphp
                            @foreach($blends->groupBy('opt') as $opts)
                                @foreach($opts as $opt)
                                    @if($opt->beginning_qty > 0 || $opt->loss_qty > 0 || $opt->confirm_qty > 0 || $opt->confirm_issue_qty > 0 || $opt->ending_qty > 0 )
                                    <tr>
                                        <td class="text-center">
                                            @if( $countDataRow == 0)
                                                {{ formatDateThai($opt->transaction_date) }}
                                            @endif
                                        </td>
                                        {{-- @if(($batchNoFrom && $batchNoFrom != 'ALL') || ($batchNoTo && $batchNoTo != 'ALL' )) --}}
                                        <td class="text-center">
                                            @if( $countBlendRow == 0)
                                                {{ ($opt->batch_no) }}
                                            @endif
                                        </td>
                                        {{-- @endif --}}
                                        <td class="text-center">
                                            @if( $countBlendRow == 0)
                                                @if ($showItemNo)
                                                    {{ $opt->item_number }}
                                                @else
                                                    {{ isset($opt->blend_no) ? $opt->blend_no : $opt->blend_no2 }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if( $countBlendRow == 0)
                                                {{ $opt->item_desc }}
                                            @endif
                                        </td>
                                        <td>{{ $opt->wip_step }}</td>
                                        <td>{{ $opt->opt }}</td>
                                        <td class="text-right">{{ $opt->beginning_qty ? number_format($opt->beginning_qty,3) : '0.000' }}</td>
                                        <td class="text-right">{{ $opt->loss_qty ? number_format($opt->loss_qty,3) : '0.000' }}</td>
                                        <td class="text-right">{{ $opt->confirm_qty ? number_format($opt->confirm_qty,3) : '0.000' }}</td>
                                        <td class="text-right">{{ $opt->confirm_issue_qty ? number_format($opt->confirm_issue_qty,3) : '0.000' }}</td>
                                        <td class="text-right">{{ $opt->ending_qty ? number_format($opt->ending_qty,3) : '0.000' }}</td>
                                        {{-- <td class="text-center">{{ $opt->plan_uom }}</td> --}}
                                        <td class="text-center">{{ $opt->product_unit_of_measure }}</td>
                                    </tr>
                                    @php
                                        $countBlendRow = $countBlendRow + 1;
                                        $countDataRow = $countDataRow + 1;
                                        if ($maxWipStep && $maxWipStep == $opt->wip_step) {
                                            $totalConfirmQtyAmount = $totalConfirmQtyAmount + $opt->confirm_qty;
                                        }
                                    @endphp
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                    @if($loop->last)
                        @if($userOrgCode == 'M02' || $userOrgCode == 'M03')
                        <tr>
                            <td colspan="13">
                            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-right">รวมผลผลิตที่ได้ &nbsp;&nbsp;: </td>
                            <td class="text-right">{{ $totalConfirmQtyAmount ? number_format($totalConfirmQtyAmount,3) : '0.000' }}</td>
                            <td colspan="3"></td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="13">
                            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                            </td>
                        </tr>
                        <tr>
                            <table class="table-content" style="width: 100%;">
                                <tbody>
                                    <tr style="height: 10px"></tr>
                                    <tr style="width: 100%;">
                                        <td style="text-align: center;">(.......................................................)</td>
                                        <td style="text-align: center;">(.......................................................)</td>
                                        <td style="text-align: center;">(.......................................................)</td>
                                        <td style="text-align: center;">(.......................................................)</td>
                                    </tr>
                                    <tr style="width: 100%;">
                                        <td style="text-align: center;">ผู้บันทึกรายการ</td>
                                        <td style="text-align: center;">หัวหน้ากอง</td>
                                        <td style="text-align: center;">รองผู้อำนวยการฝ่ายโรงงานผลิตยาสูบ</td>
                                        <td style="text-align: center;">ผู้อำนวยการฝ่ายโรงงานผลิตยาสูบ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </tr>
                    @endif
                @endforeach

                {{-- @php
                    $preLoopDate = null;
                    $currentLoopDate = null;
                @endphp
                @foreach($datas ?? '' as $row => $data)
                @php
                    $currentLoopDate = $data->transaction_date;
                @endphp
                <tr>
                    @if($preLoopDate != $currentLoopDate)
                        <td class="text-center">{{ formatDateThai($data->transaction_date) }}</td>
                    @else
                        <td class="text-center"></td>
                    @endif
                    @if(($batchNoFrom && $batchNoFrom != 'ALL') || ($batchNoTo && $batchNoTo != 'ALL' ))
                    <td class="text-center">{{ $data->batch_no }}</td>
                    @endif
                    <td class="text-center">{{ $data->blend_no }}</td>
                    <td>{{ $data->item_desc }}</td>
                    <td>{{ $data->wip_step }}</td>
                    <td>{{ $data->opt }}</td>
                    <td class="text-right">{{ $data->beginning_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->loss_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->confirm_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->confirm_issue_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->ending_qty ?? 0 }}</td>
                    <td class="text-center">{{ $data->plan_uom }}</td>
                </tr>
                @php
                    $preLoopDate = $data->transaction_date;
                @endphp
                @endforeach --}}
            </tbody>
        </table>
        @endif

        @if($reportCode == 'PDR1180')
        <table class="table-content">
            <thead>
                <tr>
                    <td colspan="11">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header" id="PDR1180">
                    {{-- <td class="col-1">ลำดับที่</td> --}}
                    <td class="col-2">วันที่ได้ผลผลิต</td>
                    {{-- <td class="col-3">คำสั่งผลิตเลขที่</td> --}}
                    <td class="col-4">รหัสสินค้า</td>
                    <td class="col-5">ชื่อสินค้า</td>
                    <td class="col-6">WIP</td>
                    {{-- <td class="col-7">OPT</td> --}}
                    <td class="col-8">คงคลังเช้า</td>
                    <td class="col-9">สูญเสีย</td>
                    <td class="col-10">ผลผลิตที่ได้/รับโอน</td>
                    <td class="col-11">จ่ายออก/โอนออก</td>
                    <td class="col-12">คงคลังเย็น</td>
                    <td class="col-13">หนว่ยนับ</td>
                </tr>
                <tr>
                    <td colspan="11">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalConfirmQtyAmount = 0;
                @endphp
                @foreach($datas->groupBy('trns_date_only') as $key => $data)
                    @php
                        $countDataRow = 0;
                    @endphp
                    {{-- @foreach($data->groupBy('blend_no') as $blends) --}}
                    {{-- @foreach($userOrgCode == 'MG6' ? $data->groupBy('blend_no2') : $data->groupBy('blend_no') as $blends) --}}
                    @foreach($userOrgCode == 'M02' ? $data->groupBy('blend_no') : $data->groupBy('item_number') as $blends)
                        @php
                            $countBlendRow = 0;
                        @endphp
                        @foreach($blends->sortBy('wip_step')->groupBy('wip_step') as $key => $wipsteps)
                            @if($wipsteps->sum('beginning_qty') > 0 || $wipsteps->sum('loss_qty') > 0 || $wipsteps->sum('confirm_qty') > 0 || $wipsteps->sum('confirm_issue_qty') > 0 || $wipsteps->sum('ending_qty') > 0 )
                            <tr>
                                <td class="text-center">
                                    @if( $countDataRow == 0)
                                        {{ formatDateThai($wipsteps[0]->transaction_date) }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if( $countBlendRow == 0)
                                        {{-- {{ isset($wipsteps[0]->blend_no) ? $wipsteps[0]->blend_no : $wipsteps[0]->blend_no2 }} --}}
                                        {{ $wipsteps[0]->item_number }}
                                    @endif
                                </td>
                                <td>
                                    @if( $countBlendRow == 0)
                                        {{ $wipsteps[0]->item_desc }}
                                    @endif
                                </td>
                                <td>{{ $wipsteps[0]->wip_step }}</td>
                                <td class="text-right">{{ $wipsteps->sum('beginning_qty') > 0 ? number_format($wipsteps->sum('beginning_qty'),3) : '0.000' }}</td>
                                <td class="text-right">{{ $wipsteps->sum('loss_qty') > 0 ? number_format($wipsteps->sum('loss_qty'),3) : '0.000' }}</td>
                                <td class="text-right">{{ $wipsteps->sum('confirm_qty') > 0 ? number_format($wipsteps->sum('confirm_qty'),3) : '0.000' }}</td>
                                <td class="text-right">{{ $wipsteps->sum('confirm_issue_qty') > 0 ? number_format($wipsteps->sum('confirm_issue_qty'),3) : '0.000' }}</td>
                                <td class="text-right">{{ $wipsteps->sum('ending_qty') > 0 ? number_format($wipsteps->sum('ending_qty'),3) : '0.000' }}</td>
                                {{-- <td class="text-center">{{ $wipsteps[0]->plan_uom }}</td> --}}
                                <td class="text-center">{{ $wipsteps[0]->product_unit_of_measure }}</td>
                            </tr>
                            @php
                                $countBlendRow = $countBlendRow + 1;
                                $countDataRow = $countDataRow + 1;
                                if ($maxWipStep && $maxWipStep == $wipsteps[0]->wip_step) {
                                    $totalConfirmQtyAmount = $totalConfirmQtyAmount + ($wipsteps->sum('confirm_qty') > 0 ? $wipsteps->sum('confirm_qty') : 0);
                                }
                            @endphp
                            @endif
                        @endforeach
                        {{-- @foreach($opts as $opt)
                            @if($opt->beginning_qty > 0 || $opt->loss_qty > 0 || $opt->confirm_qty > 0 || $opt->confirm_issue_qty > 0 || $opt->ending_qty > 0 )
                            <tr>
                                <td class="text-center">
                                    @if( $countDataRow == 0)
                                        {{ formatDateThai($opt->transaction_date) }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if( $countBlendRow == 0)
                                        {{ $opt->blend_no }}
                                    @endif
                                </td>
                                <td>
                                    @if( $countBlendRow == 0)
                                        {{ $opt->item_desc }}
                                    @endif
                                </td>
                                <td>{{ $opt->wip_step }}</td>
                                <td class="text-right">{{ $opt->beginning_qty ? number_format($opt->beginning_qty,3) : '0.000' }}</td>
                                <td class="text-right">{{ $opt->loss_qty ? number_format($opt->loss_qty,3) : '0.000' }}</td>
                                <td class="text-right">{{ $opt->confirm_qty ? number_format($opt->confirm_qty,3) : '0.000' }}</td>
                                <td class="text-right">{{ $opt->confirm_issue_qty ? number_format($opt->confirm_issue_qty,3) : '0.000' }}</td>
                                <td class="text-right">{{ $opt->ending_qty ? number_format($opt->ending_qty,3) : '0.000' }}</td>
                                <td class="text-center">{{ $opt->plan_uom }}</td>
                            </tr>
                            @php
                                $countBlendRow = $countBlendRow + 1;
                                $countDataRow = $countDataRow + 1;
                                $totalConfirmQtyAmount = $totalConfirmQtyAmount + $opt->confirm_qty;
                            @endphp
                            @endif
                        @endforeach --}}
                    @endforeach
                    @if($loop->last)
                        {{-- @if($userOrgCode == 'M02' || $userOrgCode == 'M03') --}}
                        <tr>
                            <td colspan="11">
                            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right">รวมผลผลิตที่ได้ &nbsp;&nbsp;: </td>
                            <td class="text-right">{{ $totalConfirmQtyAmount ? number_format($totalConfirmQtyAmount,3) : '0.000' }}</td>
                            <td colspan="3"></td>
                        </tr>
                        {{-- @endif --}}
                        <tr>
                            <td colspan="11">
                            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                            </td>
                        </tr>
                        <tr>
                            <table class="table-content" style="width: 100%;">
                                <tbody>
                                    <tr style="height: 10px"></tr>
                                    <tr style="width: 100%;">
                                        <td style="text-align: center;">(.......................................................)</td>
                                        <td style="text-align: center;">(.......................................................)</td>
                                        <td style="text-align: center;">(.......................................................)</td>
                                        <td style="text-align: center;">(.......................................................)</td>
                                    </tr>
                                    <tr style="width: 100%;">
                                        <td style="text-align: center;">ผู้บันทึกรายการ</td>
                                        <td style="text-align: center;">หัวหน้ากอง</td>
                                        <td style="text-align: center;">รองผู้อำนวยการฝ่ายโรงงานผลิตยาสูบ</td>
                                        <td style="text-align: center;">ผู้อำนวยการฝ่ายโรงงานผลิตยาสูบ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            {{-- <tbody>
                @php
                    $preLoopDate = null;
                    $currentLoopDate = null;
                @endphp
                @foreach($datas ?? '' as $row => $data)
                @php
                    $currentLoopDate = $data->transaction_date;
                @endphp
                <tr>
                    @if($preLoopDate != $currentLoopDate)
                        <td class="text-center">{{ formatDateThai($data->transaction_date) }}</td>
                    @else
                        <td class="text-center"></td>
                    @endif
                    <td class="text-center">{{ $data->blend_no }}</td>
                    <td>{{ $data->item_desc }}</td>
                    <td>{{ $data->wip_step }}</td>
                    <td class="text-right">{{ $data->beginning_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->loss_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->confirm_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->confirm_issue_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->ending_qty ?? 0 }}</td>
                    <td class="text-center">{{ $data->plan_uom }}</td>
                </tr>
                @php
                    $preLoopDate = $data->transaction_date;
                @endphp
                @endforeach
            </tbody> --}}
        </table>
        @endif

        @if($reportCode == 'PDR2040')
        @php
            $forM02AndM03 = ($userOrgCode == 'M02' || $userOrgCode == 'M03');
        @endphp
        <table class="table-content">
            <thead>
                <tr>
                    <td colspan="9">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header" id="PDR2040">
                    {{-- <td class="col-1">ลำดับที่</td> --}}
                    {{-- <td class="col-2">วันที่ได้ผลผลิต</td> --}}
                    {{-- <td class="col-3">คำสั่งผลิตเลขที่</td> --}}
                    <td class="col-4">
                        @if ($forM02AndM03)
                            Blend No.
                        @else
                            Item No.
                        @endif
                    </td>
                    <td class="col-5">
                        @if ($forM02AndM03)
                            รหัสสินค้า
                        @else
                            รายละเอียด
                        @endif
                    </td>
                    <td class="col-6">WIP</td>
                    {{-- <td class="col-7">OPT</td> --}}
                    <td class="col-8">คงคลังเช้า</td>
                    <td class="col-9">สูญเสีย</td>
                    <td class="col-10">ผลผลิตที่ได้/รับโอน</td>
                    <td class="col-11">จ่ายออก/โอนออก</td>
                    <td class="col-12">คงคลังเย็น</td>
                    <td class="col-13">หนว่ยนับ</td>
                </tr>
                <tr>
                    <td colspan="9">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalConfirmQtyAmount = 0;
                @endphp
                {{-- @foreach($datas->groupBy('blend_no') as $blends) --}}
                {{-- @foreach($userOrgCode == 'MG6' ? $datas->groupBy('blend_no2') : $datas->groupBy('blend_no') as $blends) --}}
                @foreach($userOrgCode == 'M02' ? $datas->groupBy('blend_no') : $datas->groupBy('item_number') as $blends)
                    @php
                        $countBlendRow = 0;
                    @endphp
                    @foreach($blends->groupBy('wip_step') as $key => $wipsteps)
                        @if($wipsteps->sum('beginning_qty') > 0 || $wipsteps->sum('loss_qty') > 0 || $wipsteps->sum('confirm_qty') > 0 || $wipsteps->sum('confirm_issue_qty') > 0 || $wipsteps->sum('ending_qty') > 0 )
                        <tr>
                            <td class="text-center">
                                @if( $countBlendRow == 0)
                                    @if ($forM02AndM03)
                                        @if (isset($wipsteps[0]->blend_no) && $wipsteps[0]->blend_no)
                                            {{ $wipsteps[0]->blend_no }}
                                        @endif
                                    @else
                                        {{ $wipsteps[0]->item_number }}
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if( $countBlendRow == 0)
                                    {{ $wipsteps[0]->item_desc }}
                                @endif
                            </td>
                            <td>{{ $key }}</td>
                            <td class="text-right">{{ $wipsteps->sum('beginning_qty') > 0 ? number_format($wipsteps->sum('beginning_qty'),3) : '0.000' }}</td>
                            <td class="text-right">{{ $wipsteps->sum('loss_qty') > 0 ? number_format($wipsteps->sum('loss_qty'),3) : '0.000' }}</td>
                            <td class="text-right">{{ $wipsteps->sum('confirm_qty') > 0 ? number_format($wipsteps->sum('confirm_qty'),3) : '0.000' }}</td>
                            <td class="text-right">{{ $wipsteps->sum('confirm_issue_qty') > 0 ? number_format($wipsteps->sum('confirm_issue_qty'),3) : '0.000' }}</td>
                            <td class="text-right">{{ $wipsteps->sum('ending_qty') > 0 ? number_format($wipsteps->sum('ending_qty'),3) : '0.000' }}</td>
                            {{-- <td class="text-center">{{ $wipsteps[0]->plan_uom }}</td> --}}
                            <td class="text-center">{{ $wipsteps[0]->product_unit_of_measure }}</td>
                        </tr>
                        @php
                            $countBlendRow = $countBlendRow + 1;

                            if ($maxWipStep && $maxWipStep == $wipsteps[0]->wip_step) {
                                $totalConfirmQtyAmount = $totalConfirmQtyAmount + ($wipsteps->sum('confirm_qty') > 0 ? $wipsteps->sum('confirm_qty') : 0);
                            }
                        @endphp
                        @endif
                    {{-- @foreach($wipsteps as $data)
                        @if($data->beginning_qty > 0 || $data->loss_qty > 0 || $data->confirm_qty > 0 || $data->confirm_issue_qty > 0 || $data->ending_qty > 0 )
                        <tr>
                            <td class="text-center">
                                @if( $countBlendRow == 0)
                                    {{ $data->blend_no }}
                                @endif
                            </td>
                            <td>
                                @if( $countBlendRow == 0)
                                    {{ $data->item_desc }}
                                @endif
                            </td>
                            <td>{{ $data->wip_step }}</td>
                            <td class="text-right">{{ $data->beginning_qty ? number_format($data->beginning_qty,3) : '0.000' }}</td>
                            <td class="text-right">{{ $data->loss_qty ? number_format($data->loss_qty,3) : '0.000' }}</td>
                            <td class="text-right">{{ $data->confirm_qty ? number_format($data->confirm_qty,3) : '0.000' }}</td>
                            <td class="text-right">{{ $data->confirm_issue_qty ? number_format($data->confirm_issue_qty,3) : '0.000' }}</td>
                            <td class="text-right">{{ $data->ending_qty ? number_format($data->ending_qty,3) : '0.000' }}</td>
                            <td class="text-center">{{ $data->plan_uom }}</td>
                        </tr>
                        @php
                            $countBlendRow = $countBlendRow + 1;
                            $totalConfirmQtyAmount = $totalConfirmQtyAmount + $data->confirm_qty;
                        @endphp
                        @endif
                    @endforeach --}}
                    @endforeach
                    @if($loop->last)
                        @if($userOrgCode == 'M02' || $userOrgCode == 'M03')
                        <tr>
                            <td colspan="9">
                            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right">รวมผลผลิตที่ได้ &nbsp;&nbsp;: </td>
                            <td class="text-right">{{ $totalConfirmQtyAmount ? number_format($totalConfirmQtyAmount,3) : '0.000' }}</td>
                            <td colspan="3"></td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="9">
                            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                            </td>
                        </tr>
                        <tr>
                            <table class="table-content" style="width: 100%;">
                                <tbody>
                                    <tr style="height: 10px"></tr>
                                    <tr style="width: 100%;">
                                        <td style="text-align: center;">(.......................................................)</td>
                                        <td style="text-align: center;">(.......................................................)</td>
                                        <td style="text-align: center;">(.......................................................)</td>
                                        <td style="text-align: center;">(.......................................................)</td>
                                    </tr>
                                    <tr style="width: 100%;">
                                        <td style="text-align: center;">ผู้บันทึกรายการ</td>
                                        <td style="text-align: center;">หัวหน้ากอง</td>
                                        <td style="text-align: center;">รองผู้อำนวยการฝ่ายโรงงานผลิตยาสูบ</td>
                                        <td style="text-align: center;">ผู้อำนวยการฝ่ายโรงงานผลิตยาสูบ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            {{-- <tbody>
                @foreach($datas ?? '' as $row => $data)
                <tr>
                    <td class="text-center">{{ $data->blend_no }}</td>
                    <td>{{ $data->item_desc }}</td>
                    <td>{{ $data->wip_step }}</td>
                    <td class="text-right">{{ $data->beginning_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->loss_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->confirm_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->confirm_issue_qty ?? 0 }}</td>
                    <td class="text-right">{{ $data->ending_qty ?? 0 }}</td>
                    <td class="text-center">{{ $data->plan_uom }}</td>
                </tr>
                @endforeach
            </tbody> --}}
        </table>
        @endif

    </body>
</html>
