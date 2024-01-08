<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title> รายงานการแจ้งเหตุเคลมประกันภัย </title>
        @include('ir.reports.irr9140._style')
    </head>
    <body>
        @php
            // $sumClaimAmount  = 0;
            $sumTotalClaimAmount = 0;
            $totalAReceivedAmount = 0;
        @endphp
        @foreach ($claims as $claim)
            @php
                // $sumClaimAmount += $claim->claim_amount;
                $sumTotalClaimAmount += $claim->total_claim_amount;
                
                $totalClaimAmount = 0;
            @endphp
            @if (count($claim->company) > 0)
                <div class="row" style="margin-top: 10px;">
                    {{-- {{ !$loop->first? 'page-break-before: always;': '' }} --}}
                    <div class="col-md-4">
                        <span style="font-size: 16px;"><strong>เลขที่เอกสาร : </strong> {{ $claim->document_number }} </span>
                        <br>
                        <span style="font-size: 16px;"><strong>หัวข้อการเกิดเหตุ : </strong> {{ $claim->claim_title }} </span>
                        <br>
                        <span style="font-size: 16px;"><strong>ผู้แจ้งเหตุ : </strong> {{ $claim->requestor_name }} </span>
                        <br>
                        <span style="font-size: 16px;"><strong>หน่วยงานผู้แจ้งเหตุ : </strong> {{ $claim->department_code.' : '.$claim->department_name }} </span>
                        <br>
                        <span style="font-size: 16px;"><strong>เบอร์โทรผู้แจ้งเหตุ : </strong> {{ $claim->requestor_tel }} </span>
                        <br>
                    </div>
                    <div class="col-md-4">
                        <span style="font-size: 16px;">
                            <strong>วันที่เกิดเหตุ : </strong> {{ $claim->accident_date ? parseToDateTh(date('d-m-Y', strtotime($claim->accident_date))) : '' }}
                        </span>
                        <br>
                        <span style="font-size: 16px;">
                            <strong>เวลาเกิดเหตุ : </strong> {{ $claim->accident_time ? date('H:i', strtotime($claim->accident_time)).' น.': '' }}
                        </span>
                        <br>
                        <span style="font-size: 16px;"><strong>สถานที่เกิดเหตุ : </strong> {{ $claim->location_name }}</span>
                        <br>
                        <span style="font-size: 16px;"><strong>สถานะปัจจุบัน : </strong> {{ $claim->irp0011_insurance_status }}</span>
                        <br>
                        <span style="font-size: 16px;">
                            <strong>วันที่แจ้งบริษัทประกันภัย : </strong> {{ $claim->insurance_date ? parseToDateTh(date('d-m-Y', strtotime($claim->insurance_date))) : '' }}
                        </span>
                        <br>
                    </div>
                    <div class="col-md-4">
                        <span style="font-size: 16px;">
                            <strong>รวมจำนวนเงิน เรียกชดใช้โดยประมาณ : </strong> {{ number_format($claim->claim_amount, 2) }}
                        </span>
                        <br>
                        <span style="font-size: 16px;">
                            <strong>รวมจำนวนเงิน เรียกชดใช้ : </strong> {{ number_format($claim->total_claim_amount, 2) }}
                        </span>
                        <br>
                        <span style="font-size: 16px;">
                            <strong>รวมจำนวนเงิน ที่ได้รับชดใช้ : </strong> {{ number_format(sumClaimAmount($claim), 2) }}
                        </span>
                        <br>
                    </div>
                </div>
                <div>
                    <span style="font-size: 16px;"><strong>รายละเอียดเหตุการณ์ : </strong> {{ $claim->remarks }}</span>
                </div>
                <br>
                @foreach ($claim->details->sortBy('claim_group_id')->groupBy('line_description') as $desc => $details)
                    <table class="table table-bordered" style=" border: #000000 solid 1px;  padding: 5px; {{ !$loop->first ? 'margin-top: 25px;' : '' }} page-break-inside:avoid; page-break-after:auto;" cellspacing="0" cellpadding="0">
                        {{-- <thead > --}}
                        <tbody >
                            <tr style="border: #000000 solid 1px;">
                                <th colspan="8" style="border: #000 solid 1px;">
                                    รายละเอียดความเสียหาย : {{ $desc }}
                                </th>
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
                        {{-- </thead> --}}
                        {{-- <tbody> --}}
                            @php
                                $sumPolicyAmount = 0;
                                $sumClaimAmount = 0;
                                $sumAReceivedAmount = 0;
                            @endphp
                            @foreach ($details->sortBy('claim_group_id') as $datail)
                                @foreach ($datail->claimApplyCompany as $company)
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
                                    <tr style="border: #000000 solid 1px;">
                                        <td style="border: #000000 solid 1px">
                                            {{ $company->company_name }}
                                        </td>
                                        <td style="border: #000000 solid 1px">
                                            {{ $policyGroup ? $policyGroup->group_code .' : '.$policyGroup->group_description: '' }}
                                        </td>
                                        <td style="border: #000000 solid 1px">
                                            {{ $policySet ? $policySet->policy_set_number.' : '.$policySet->policy_set_description: '' }}
                                        </td>
                                        <td style="border: #000000 solid 1px; text-align: center;">
                                            {{ $company->policy_number }}
                                        </td>
                                        <td style="border: #000000 solid 1px; text-align: right;">
                                            {{ number_format($company->claim_amount, 2) }}
                                        </td>
                                        <td style="border: #000000 solid 1px; text-align: center;">
                                            {{ $company->ar_invoice_num }}
                                        </td>
                                        <td style="border: #000000 solid 1px; text-align: center;">
                                            {{ $company->ar_receipt_date ? date('d-m-Y', strtotime($company->ar_receipt_date)): '' }}
                                        </td>
                                        <td style="border: #000000 solid 1px; text-align: center;">
                                            {{ $company->ar_receipt_number }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr style="border: #000000 solid 1px; page-break-after: auto;  page-break-inside: avoid;">
                                <th style="border: #000000 solid 1px; text-align: center;" colspan="4">รวม</th>
                                <th style="border: #000000 solid 1px; text-align: right;">{{ number_format($sumClaimAmount, 2) }}</th>
                            </tr>
                            @if ($loop->last)
                                <tr style="border: #000000 solid 1px;">
                                    <th style="border: #000000 solid 1px; text-align: center;" colspan="4">รวมทั้งสิ้น</th>
                                    <th style="border: #000000 solid 1px; text-align: right;">{{ number_format($totalClaimAmount, 2) }}</th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endforeach
            @endif
        @endforeach

        <div style="margin-top: 40px; page-break-after: auto; page-break-inside: avoid;">
            <span style="font-size: 20px;"><strong> รวมการเรียกชดใช้จากบริษัทประกัน : </strong></span>
            <table style="border: 1px solid #FFF;">
                <tr>
                    <td style="border: 1px solid #FFF;"> <strong> รวมจำนวนเงิน เรียกชดใช้โดยประมาณทั้งสิ้น </strong> </td>
                    <td class="text-right" style="border: 1px solid #FFF; padding-left: 60px;"> <strong> {{ number_format($claims->sum('claim_amount'), 2) }} </strong> </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #FFF;"> <strong> รวมจำนวนเงิน เรียกชดใช้ทั้งสิ้น </strong> </td>
                    <td class="text-right" style="border: 1px solid #FFF;"> <strong> {{ number_format($claims->sum('total_claim_amount'), 2) }} </strong> </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #FFF;"> <strong> รวมจำนวนเงิน ที่ได้รับชดใช้ทั้งสิ้น </strong> </td>
                    <td class="text-right" style="border: 1px solid #FFF;"> <strong> {{ number_format(allClaimAmount($claims), 2) }}  </strong> </td>
                </tr>
            </table>
        </div>
    </body>
</html>
