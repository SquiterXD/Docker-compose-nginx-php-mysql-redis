<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title> รายงานการแจ้งเหตุเคลมประกันภัย </title>
        @include('ir.reports.irr9140._style')
    </head>
    <body>
        @php
            // Date
            $startDate = $request['accident_start_date']? date('Y-m-d', strtotime(convertDateFormatToQuery($request['accident_start_date']))): $period->start_date;
            $endDate = $request['accident_end_date']? date('Y-m-d', strtotime(convertDateFormatToQuery($request['accident_end_date']))): $period->end_date;
            $sumClaimAmount  = 0;
            $sumTotalClaimAmount = 0;
            $totalClaimAmount = 0;
            $totalAReceivedAmount = 0;
        @endphp
        <div>
            <span style="font-size: 20px;"><strong>รวมการเรียกชดใช้จากบริษัทประกัน : </strong></span>
            <br>
            <span style="font-size: 18px;"><strong>รวมจำนวนเงิน เรียกชดใช้ทั้งสิ้น {{ number_format($claims->sum('ar_invoice_amount'), 2) }} </strong></span>
            <br>
            <span style="font-size: 18px;"><strong>รวมจำนวนเงิน ที่ได้รับชดใช้ทั้งสิ้น {{ number_format(AllAReceivedAmount($details), 2) }}</strong></span>
        </div>

        @foreach ($claims as $claim)
            @php
                $sumClaimAmount += $claim->claim_amount;
                $sumTotalClaimAmount += $claim->total_claim_amount;
            @endphp
            <br>
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-4">
                    <span style="font-size: 18px;"><strong>เลขที่เอกสาร : {{ $claim->document_number }}</strong></span>
                    <br>
                    <span style="font-size: 18px;"><strong>หัวข้อการเกิดเหตุ : {{ $claim->claim_title }}</strong></span>
                    <br>
                    <span style="font-size: 18px;"><strong>ผู้แจ้งเหตุ : {{ $claim->requestor_name }}</strong></span>
                    <br>
                    <span style="font-size: 18px;"><strong>หน่วยงานผู้แจ้งเหตุ : {{ $claim->department_code.' : '.$claim->department_name }}</strong></span>
                    <br>
                    <span style="font-size: 18px;"><strong>เบอร์โทรผู้แจ้งเหตุ : {{ $claim->requestor_tel }}</strong></span>
                    <br>
                </div>
                <div class="col-md-4">
                    <span style="font-size: 18px;">
                        <strong>วันที่เกิดเหตุ : {{ $claim->accident_date ? parseToDateTh(date('d-m-Y', strtotime($claim->accident_date))) : '' }}</strong>
                    </span>
                    <br>
                    <span style="font-size: 18px;">
                        <strong>เวลาเกิดเหตุ : {{ $claim->accident_time ? date('H:i', strtotime($claim->accident_time)).' น.': '' }}</strong>
                    </span>
                    <br>
                    <span style="font-size: 18px;"><strong>สถานที่เกิดเหตุ : {{ $claim->location_name }}</strong></span>
                    <br>
                    <span style="font-size: 18px;"><strong>สถานะปัจจุบัน : {{ $claim->irp0011_insurance_status }}</strong></span>
                    <br>
                    <span style="font-size: 18px;">
                        <strong>วันที่แจ้งบริษัทประกันภัย : {{ $claim->insurance_date ? parseToDateTh(date('d-m-Y', strtotime($claim->insurance_date))) : '' }}</strong>
                    </span>
                    <br>
                </div>
                <div class="col-md-4"></div>
            </div>
            <div>
                <span style="font-size: 18px;"><strong>รายละเอียดเหตุการณ์ : {{ $claim->remarks }}</strong></span>
            </div>
            <br>
            @foreach ($details as $desc => $datas)
                @php
                dd($desc , $datas);
                    $sumClaimAmount = 0;
                    $sumAReceivedAmount = 0;
                @endphp
                @if (count($datas) > 0)
                    <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid #ddd; page-break-before: avoid; page-break-after: auto; padding: 0px; {{ !$loop->first ? 'margin-top: 25px;' : '' }}">
                        <tr style="border: #000000 solid 1px">
                            <th colspan="9">รายละเอียดความเสียหาย : {{ $desc }}</th>
                        </tr>
                        <tr style="background-color: #C7CCC5; border: #000000 solid 1px;">
                            <th width="10%" class="report_header" style="border: #000000 solid 1px">
                                บริษัทประกันภัย
                            </th>
                            <th width="12%" wclass="report_header" style="border: #000000 solid 1px">
                                กลุ่มกรมธรรม์
                            </th>
                            <th width="15%" class="report_header" style="border: #000000 solid 1px">
                                ชุดกรมธรรม์
                            </th>
                            <th width="6%" wclass="report_header" style="border: #000000 solid 1px">
                                เลขที่กรมธรรม์
                            </th>
                            <th width="6%" class="report_header" style="border: #000000 solid 1px">
                                จำนวนเงิน<br>ที่ได้รับชดใช้
                            </th>
                            <th width="8%" class="report_header" style="border: #000000 solid 1px">
                                เลขที่ใบแจ้งหนี้
                            </th>
                            <th width="8%" class="report_header" style="border: #000000 solid 1px">
                                วันที่<br>ใบเสร็จรับเงิน
                            </th>
                            <th width="8%" class="report_header" style="border: #000000 solid 1px">
                                เลขที่<br>ใบเสร็จรับเงิน
                            </th>
                        </tr>
                        @foreach ($datas as $data)
                            @php
                                $companies          = $data->claimApplyCompany->sortBy('company_id');
                                $sumPolicyAmount    = 0;
                                $countCompany       = count($companies);
                            @endphp
                            @foreach ($companies as $company)
                                @php
                                    $policyGroup        = $company->claimPolicyGroup;
                                    $policySet          = $policyGroup ? $policyGroup->claimPolicySetHeader : '';
                                    $arReceivedAmount   = $company->ar_received_amount ? $company->ar_received_amount * $company->amount_ratio / 100 : 0;

                                    $sumPolicyAmount    += $policyGroup ? $policyGroup->amount : 0;
                                    $sumClaimAmount     += $company->claim_amount;
                                    $sumAReceivedAmount += $arReceivedAmount;

                                    $totalClaimAmount     += $company->claim_amount;
                                    $totalAReceivedAmount += $arReceivedAmount;
                                @endphp
                                <tr style="border: #000000 solid 1px">
                                    <td style="border: #000000 solid 1px">
                                        {{ $company->company_name }}
                                    </td>
                                    <td style="border: #000000 solid 1px">
                                        {{ $policyGroup ? $policyGroup->group_code . ' : ' .  $policyGroup->group_description : '' }}
                                    </td>
                                    <td style="border: #000000 solid 1px">
                                        {{ $policySet ? $policySet->policy_set_number . ' : ' .  $policySet->policy_set_description : '' }}
                                    </td>
                                    <td style="border: #000000 solid 1px; text-align: center;">
                                        {{ $company->policy_number }}
                                    </td>
                                    <td style="border: #000000 solid 1px; text-align: right;">
                                        {{ $arReceivedAmount ? number_format($arReceivedAmount, 2) : ''}}
                                    </td>
                                    <td style="border: #000000 solid 1px; text-align: center;">
                                        {{ $company->ar_invoice_num }}
                                    </td>
                                    <td style="border: #000000 solid 1px; text-align: center;">
                                        {{ $company->ar_receipt_date ? date('d-m-Y', strtotime($company->ar_receipt_date)) : '' }}
                                    </td>
                                    <td style="border: #000000 solid 1px; text-align: center;">
                                        {{ $company->ar_receipt_number }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        <tr style="border: #000000 solid 1px">
                            <th style="border: #000000 solid 1px; text-align: center;" colspan="4">รวม</th>
                            <th style="border: #000000 solid 1px; text-align: right;">{{ number_format($sumAReceivedAmount, 2) }}</th>
                        </tr>
                        @if ($loop->last)
                            <tr style="border: #000000 solid 1px;">
                                <th style="border: #000000 solid 1px; text-align: center;" colspan="4">รวมทั้งสิ้น</th>
                                <th style="border: #000000 solid 1px; text-align: right;">{{ number_format($totalAReceivedAmount, 2) }}</th>
                            </tr>
                        @endif
                    </table>
                @endif
            @endforeach
        @endforeach
    </body>
</html>
