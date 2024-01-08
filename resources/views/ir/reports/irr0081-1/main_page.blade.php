<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <title> รายงานรายละเอียดส่วนเฉลี่ยค่าเบี้ยประกันภัยความเสี่ยงภัยสินค้า ประจำเดือน โดยการประกันแบบ Declarative Policy </title>
    @include('ir.reports.irr0081-1._style')
</head>
<body> 
    <div class="row">
        <div class="col-md-12">
            <div style="margin-top: 10px;">
                @foreach ($data as $location => $departmentLists)
                    @php
                        $sumAccrued = 0;
                        $companies  = getCompanyList($location);

                        $policy            = $companies->first();
                        $policyDescription = $policy ? $policy->policy_set_description : '';
                    @endphp
                    <div class="flexrow">
                        <div class="text-center" style="font-size: 18px;"><strong> ชุดที่ : {{ $location }} {{ $policyDescription }} </strong></div>
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
                    <br>
                    @foreach ($departmentLists as $department => $groupLists)
                        <div class="flexrow">
                            <div style="font-size: 18px;">
                                <strong> 
                                    หน่วยงาน: {{ $department }} : {{ getDepartmentNameStock($department) }}
                                </strong>
                            </div>
                        </div>
                        <table class="table" style="margin-top: 10px; margin-bottom: 10px;">
                            <thead>
                                <tr style="background-color: #c4c4c4; border-top: 0.5px solid #000; border-bottom: 0.5px solid #000;">
                                    <th style="width: 20px; height: 10px; border-right:0.5px solid #000; border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;">
                                        <strong>ลำดับ</strong>
                                    </th>
                                    <th style="width: 250px; height: 10px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;">
                                        <strong>รายการ</strong>
                                    </th>
                                    <th style="width: 80px; height: 10px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;">
                                        <strong>มูลค่าทุนประกัน</strong>
                                    </th>
                                    <th style="width: 80px; height: 10px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;">
                                        <strong>อัตราค่าเบี้ย</strong>
                                    </th>
                                    <th style="width: 80px; height: 10px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;">
                                        <strong>ค่าเบี้ยเฉลี่ย</strong>
                                    </th>
                                </tr>
                            </thead>
                            <tbody> 
                                @php
                                    $totalCoverageAmount = 0;
                                    $totalInsuAmount     = 0;
                                    $premiumRate         = 0;
                                    $totalDutyAmount     = 0;
                                    $totalVatAmount      = 0;
                                @endphp
                                @foreach ($groupLists as $group => $stockLists)
                                    @if (!$loop->first)
                                        <tr>
                                            <td style="text-align: center; border-right:0.05px solid #000;border-left:0.05px solid #000;">
                                            </td>
                                            <td style="border-right:0.05px solid #000;border-left:0.05px solid #000;">
                                            </td>
                                            <td style="text-align: right; border-right:0.05px solid #000;border-left:0.05px solid #000;">
                                            </td>
                                            <td style="text-align: right; border-right:0.05px solid #000;border-left:0.05px solid #000;"> 
                                            </td>
                                            <td style="text-align: right; border-right:0.05px solid #000;border-left:0.05px solid #000;"> 
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td style="text-align: center; border-right:0.05px solid #000;border-left:0.05px solid #000;">
                                            <div>
                                                <strong>{{ $loop->iteration }}</strong>
                                            </div>
                                        </td>
                                        <td style="border-right:0.05px solid #000;border-left:0.05px solid #000;">
                                            {{ getGroupStock($group) }}
                                        </td>
                                        <td style="text-align: right; border-right:0.05px solid #000;border-left:0.05px solid #000;">
                                        </td>
                                        <td style="text-align: right; border-right:0.05px solid #000;border-left:0.05px solid #000;"> 
                                        </td>
                                        <td style="text-align: right; border-right:0.05px solid #000;border-left:0.05px solid #000;"> 
                                        </td>
                                    </tr>
                                    @foreach ($stockLists as $stockDescription => $lists)
                                    @php
                                        $coverageAmount      = $lists->sum('coverage_amount');
                                        $totalCoverageAmount += $coverageAmount;
                                        $list                = $lists->first();
                                        $header              = $list->ptirStockHeader;
                                        $totalInsuAmount     = $header->total_insu_amount;
                                        $premiumRate         = $list->premium_rate;
                                        $totalDutyAmount     = $header->total_duty_amount;
                                        $totalVatAmount      = $header->total_vat_amount;
                                    @endphp
                                        <tr>
                                            <td style="text-align: center; border-right:0.05px solid #000;border-left:0.05px solid #000;">
                                                <div>
                                                    <strong>{{$loop->parent->iteration}}.{{ $loop->iteration }}</strong>
                                                </div>
                                            </td>
                                            <td style="border-right:0.05px solid #000;border-left:0.05px solid #000;">
                                                <div style="margin-left: 10px;">
                                                    {{ $stockDescription }}
                                                </div>
                                            </td>
                                            <td style="text-align: right; border-right:0.05px solid #000;border-left:0.05px solid #000;"> 
                                                {{ number_format($coverageAmount, 2) }}
                                            </td>
                                            <td style="text-align: right; border-right:0.05px solid #000;border-left:0.05px solid #000;"> 
                                            </td>
                                            <td style="text-align: right; border-right:0.05px solid #000;border-left:0.05px solid #000;"> 
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                <tr style="background-color: #e6e6e6;">
                                    <td style="text-align: center; border: 0.5px solid #000" colspan="2">
                                        <strong>รวมทั้งสิ้น</strong>
                                    </td>
                                    <td style="text-align: right; border: 0.5px solid #000"> 
                                        <strong>{{ number_format($totalCoverageAmount, 2) }}</strong>
                                    </td>
                                    <td style="text-align: right; border: 0.5px solid #000"> 
                                        <strong>{{ number_format($premiumRate, 5) }} %</strong>
                                    </td>
                                    <td style="text-align: right; border: 0.5px solid #000"> 
                                        <strong>{{ number_format($totalInsuAmount, 2) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table" style="margin-top: 10px;">
                            @php
                                $totalCal = $totalInsuAmount + $totalDutyAmount;
                            @endphp
                            <tr>
                                <td style="text-align: right;" colspan="4">
                                    ค่าเบี้ยประกันภัยก่อนคำนวณภาษีมูลค่าเพิ่ม
                                </td>
                                <td style="text-align: right; width: 160px;"> 
                                    {{ number_format($totalInsuAmount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;" colspan="4">
                                    ค่าอากรแสตมป์
                                </td>
                                <td style="text-align: right; width: 160px;"> 
                                    {{ number_format($totalDutyAmount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;" colspan="4">
                                    รวมค่าเบี้ยบวกอากรแสตมป์
                                </td>
                                <td style="text-align: right; width: 160px;"> 
                                    {{ number_format($totalCal, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;" colspan="4">
                                    ภาษีมูลค่าเพิ่ม
                                </td>
                                <td style="text-align: right; width: 160px;"> 
                                    {{ number_format($totalVatAmount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;" colspan="4">
                                    รวมค่าเบี้ย อากรแสตมป์ ภาษีมูลค่าเพิ่ม
                                </td>
                                <td style="text-align: right; width: 160px;"> 
                                    {{ number_format($totalCal + $totalVatAmount, 2) }}
                                </td>
                            </tr>
                        </table>
                    @if (!$loop->last)
                        <div class="page-break"></div>
                    @endif
                    @endforeach
                    @if (!$loop->last)
                        <div class="page-break"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
