<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <title> รายงานดุลค่าเบี้ยประกันภัยสินค้า ประจำเดือน </title>
    @include('ir.reports.irr0081-3._style')
</head>
<body> 
    <div class="row">
        <div class="col-md-12">
            <div style="margin-top: 10px;">
                @foreach ($data as $location => $lists)
                    @php
                        $sumAccrued = 0;
                        $companies  = getCompanyList($location);

                        $policy            = $lists->first();
                        $policyDescription = $policy ? $policy->policy_set_description : '';
                        // dd($location, $lists, $lists->first());
                    @endphp
                    <div class="flexrow">
                        <div style="font-size: 18px;"><strong> ชุดที่ {{ $location }} {{ $policyDescription }}</strong></div>
                    </div>
                    <div class="flexrow">
                        <div style="font-size: 18px;">
                            <strong>
                                บริษัทประกันภัย: 
                                @foreach ($companies as $detail)
                                    @if ($loop->last)
                                        {{ $detail->company_name }}
                                    @else
                                        {{ $detail->company_name }} ,
                                    @endif
                                @endforeach
                            </strong>
                        </div>
                    </div>
                    <div class="flexrow">
                        <div style="font-size: 18px;">
                            <strong> 
                                เลขที่กรมธรรม์: 
                                @foreach ($companies as $detail)
                                    @if ($detail->comments)
                                        @if ($loop->last)
                                            {{ $detail->user_policy_number }}
                                        @else
                                            {{ $detail->user_policy_number }} ,
                                        @endif
                                    @endif
                                @endforeach
                            </strong>
                        </div>
                    </div>
                    <div class="flexrow">
                        <div style="font-size: 18px;">
                            <strong> 
                                เลขที่สลักหลัง: 
                                @foreach ($companies as $detail)
                                    @if ($detail->comments)
                                        @if ($loop->last)
                                            {{ $detail->comments }}
                                        @else
                                            {{ $detail->comments }} ,
                                        @endif
                                    @endif
                                @endforeach
                            </strong>
                        </div>
                    </div>
                    <table class="table" style="margin-top: 10px;">
                        <thead>
                            <tr style="background-color: #c4c4c4; border-top: 0.5px solid #000; border-bottom: 0.5px solid #000;">
                                @php
                                    $lm = date("m",strtotime("-1 months",strtotime($month)));

                                    $last    = date('Y', strtotime($month)) . '-' . $lm . '-' . '01';
                                    $lastDay = date("t", strtotime($last));
                                @endphp
                                <th rowspan="2" style="width: 300px; height: 10px; border-right:0.5px solid #000; border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;">
                                    รายการ
                                </th>
                                <th rowspan="2" style="width: 250px; height: 10px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;"">
                                    รหัสบัญชี
                                </th>
                                <th rowspan="2" style="width: 80px; height: 10px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;"">
                                    ดุล 
                                    <br>
                                    {{ $lastDay }} {{ $thaishortmonths[$lm]}}  {{ date('Y', strtotime($month))+543 }}
                                </th>
                                <th colspan="2" style="width: 80px; height: 10px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;"">
                                    {{ $thaimonths[date('m', strtotime($month))]}}  {{ date('Y', strtotime($month))+543 }}
                                </th>
                                <th rowspan="2" style="width: 80px; height: 10px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;"">
                                    ดุล 
                                    <br>
                                    {{ date("t", strtotime($month)) }} {{ $thaishortmonths[date('m', strtotime($month))]}}  {{ date('Y', strtotime($month))+543 }}
                                    <br>
                                    รับคืน
                                </th>
                                <th rowspan="2" style="width: 80px; height: 10px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;"">
                                    ค้างจ่าย
                                </th>
                            </tr>
                            <tr style="background-color: #c4c4c4;">
                                <th style="width: 80px; height: 10px; border:0.5px solid #000;">ลูกหนี้</th>
                                <th style="width: 80px; height: 10px; border:0.5px solid #000;">เจ้าหนี้</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;">
                                    <div>
                                        <strong> ประกันแบบ {{ $policy->policyType ? $policy->policyType->description : '' }}  </strong>
                                    </div>
                                </td>
                                <td style="text-align: center; border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000}">
                                </td>
                                <td style="text-align: center; border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000}">
                                </td>
                                <td style="text-align: right; border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;"> 
                                </td>
                                <td style="text-align: right; border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;"> 
                                </td>
                                <td style="text-align: right; border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;"> 
                                </td>
                                <td style="text-align: right; border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;"> 
                                </td>
                            </tr>
                            @foreach ($lists as $list)
                                <tr>
                                    <td style="{{ $loop->last ? 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #000; border-left:0.5px solid #000; border-right:0.5px solid #000;' : 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;' }}">
                                        <div style="margin-left: 10px;">
                                            <strong>{{ $list->department_name }}</strong>
                                        </div>
                                    </td>
                                    <td style="text-align: center; {{ $loop->last ? 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #000; border-left:0.5px solid #fff; border-right:0.5px solid #000;' : 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;' }}">
                                        {{ $list->expense_account }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #000; border-left:0.5px solid #fff; border-right:0.5px solid #000;' : 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;' }}"> 
                                        {{ number_format($list->beginning_amount, 2) }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #000; border-left:0.5px solid #fff; border-right:0.5px solid #000;' : 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;' }}"> 
                                        {{ number_format($list->activity_ap_amount, 2) }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #000; border-left:0.5px solid #fff; border-right:0.5px solid #000;' : 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;' }}"> 
                                        {{ number_format($list->net_amount, 2) }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #000; border-left:0.5px solid #fff; border-right:0.5px solid #000;' : 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;' }}"> 
                                        {{ number_format($list->ending_amount, 2) }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #000; border-left:0.5px solid #fff; border-right:0.5px solid #000;' : 'border-top: 0.5px solid #fff; border-bottom: 0.5px solid #fff; border-left:0.5px solid #000; border-right:0.5px solid #000;' }}"> 
                                        @if ($list->ending_amount < 0)
                                            @php
                                                $sumAccrued += $list->ending_amount;
                                            @endphp
                                            {{ number_format($list->ending_amount, 2) }}
                                        @else
                                            0.00
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr style="background-color: #e6e6e6;">
                                <td style="text-align: center; border: 0.5px solid #000" colspan="2">
                                    <strong>รวมทั้งสิ้น</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($lists->sum('beginning_amount'), 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($lists->sum('activity_ap_amount'), 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($lists->sum('net_amount'), 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($lists->sum('ending_amount'), 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($sumAccrued, 2) }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @if (!$loop->last)
                        <div class="page-break"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
