<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $programCode_Output }} - {{ $progTitle }}</title>
    @include('ir.reports.irr0003_2._style')
</head>

<body>
    @php
        $colspan = 6;
    @endphp
    @foreach ($data->groupBy('policy_set') as $ps)
        @foreach ($ps->groupBy('group_comp') as $company_name => $company)
            @php
                $data_array_grand_total = array('amt_cost' => 0, 'amt_insure' => 0);
                $comp = $company->first();
                $comp_percent = $comp->comp_percent;
                $insur_percent = $comp->insur_percent;
                $program_title = $comp->program_title;
                $comp_status = $comp->status;
                $comp_name = $comp->group_comp;
                $policy_set = $comp->policy_set;
                $comp_code = $comp->group_comp_code;
            @endphp
            <div class="page-break">
                <div class="page-break"></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="{{ $colspan }}">
                                <div class="row">
                                    <div style="width:20%; text-align:left;">
                                        <b>โปรแกรม :</b> {{ $programCode_Output }}<br>
                                        <b>สั่งพิมพ์ :</b> {{ optional(auth()->user())->username }}<br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <b>สถานะ :</b> {{ $comp_status }}<br>
                                    </div>
                                    <div style="width:60%; text-align:center; font-weight:bold;">
                                        การยาสูบแห่งประเทศไทย<br>
                                        {{ $program_title }}<br>
                                        {{ $repTitle }}<br>
                                        กับ {{ $comp_name }}<br>
                                        @php
                                        foreach ($progPara as $para) {
                                            echo $para . '<br>';
                                        }
                                    @endphp
                                </div>
                                    <div style="width:20%; text-align:right;">
                                        <b>วันที่ :</b> {{ parseToDateTh(now()) }}<br>
                                        <b>เวลา :</b> &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }} <br>
                                        <b>หน้า :</b> <span class="pagenum">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                                        <br>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr
                            style=" background-color: #c4c4c4;border-top: 0.05px solid #000;border-bottom: 0.05px solid #000;height:50px;font-weight:bold;">
                            <th
                                style="border-right:0.05px solid #000;border-left:0.05px solid #000;width:40px;text-align:center;font-weight:bold;">
                                <b>ลำดับ</b><br>
                            </th>
                            <th style="border-right:0.05px solid #000;min-width:100px;text-align:center;font-weight:bold;">
                                รายการ<br></th>
                            <th style="border-right:0.05px solid #000;min-width:90px;text-align:center;font-weight:bold;">
                                มูลค่าทุนประกัน<br>(บาท) {{ $comp_percent }}%</th>
                            <th style="border-right:0.05px solid #000;width:50px;text-align:center;font-weight:bold;">
                                อัตราเบี้ย<br>ประกัน</th>
                            <th style="border-right:0.05px solid #000;width:100px;text-align:center;font-weight:bold;">
                                ค่าเบี้ยประกัน<br>{{ $insur_percent }}%<br>(บาท)</th>
                            <th style="border-right:0.05px solid #000;width:100px;text-align:center;font-weight:bold;">
                                คำนวน<br>ปิดบัญชี<br>(บาท)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @if (count($company) > 0)
                            @foreach ($company->groupBy('receivable_name') as $receivable => $groups)
                                @if (strlen($receivable) > 0)
                                    <tr
                                        style="background-color:#d0cece; border-bottom:0.05px solid #000;height:30px;font-weight:bold;">
                                        <td colspan="{{ $colspan }}"
                                            style="border-left:0.05px solid #000;border-right:0.05px solid #000;">
                                            รายการเรียกเก็บ : {{ $receivable }}</td>
                                    </tr>
                                @endif
                                @foreach ($groups->groupBy('group_01') as $group => $cats)
                                    @php
                                        $i++;
                                        $ii = 0;
                                    @endphp
                                    <tr style="height:30px;">
                                        <td style="border-right:0.05px solid #000;border-left:0.05px solid #000;width:40px;text-align:center;vertical-align:top;font-weight:bold;">{{ $i }}.<br></td>
                                        <td style="border-right:0.05px solid #000;font-weight:bold;text-align:left;vertical-align:top;font-weight:bold;">{{ $group }}<br></td>
                                        @for ($j = 0; $j <= 3; $j++)
                                            <td style="border-right:0.05px solid #000;"><br></td>
                                        @endfor
                                    </tr>
                                    @foreach ($cats->groupBy('cat_title') as $cat_title => $lines)
                                        @if ($cat_title != '')
                                            <tr style="height:25px;">
                                                <td style="border-right:0.05px solid #000;border-left:0.05px solid #000;"></td>
                                                <td style="border-right:0.05px solid #000;text-align: left;">&nbsp;&nbsp;&nbsp;{{ $cat_title }}</td>
                                                <td style="border-right:0.05px solid #000;text-align: right;">{{ number_format($lines->sum('amt_cost'), 2) }}</td>
                                                <td style="border-right:0.05px solid #000;text-align: right;"></td>
                                                <td style="border-right:0.05px solid #000;text-align: right;"></td>
                                                <td style="border-right:0.05px solid #000;text-align: right;">
                                                    {{ strlen($receivable) > 0 ? ' ' : number_format($lines->sum('amt_close'), 2) }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <!-- sub total -->
                                    <tr
                                        style="background-color:#f3f3f3; border-bottom:0.05px solid #000;border-top:0.05px solid #000;height:25px;font-weight:bold;">
                                        <td style="border-right:0.05px solid #000;border-left:0.05px solid #000;"></td>
                                        <td
                                            style="border-right:0.05px solid #000;text-align: center;font-weight:bold;">
                                            รวม</td>
                                        <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                            {{ number_format($cats->sum('amt_cost'), 2) }}
                                        </td>
                                        <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                            {{ number_format($cats->max('rate_set'), 5) }}</td>
                                        <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                            {{ number_format($cats->sum('amt_insure'), 2) }}</td>
                                        <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                            {{ strlen($receivable) > 0 ? ' ' : number_format($cats->sum('amt_close'), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <!--  Receivable Total -->
                                <tr
                                    style="background-color:#f3f3f3; border-bottom:0.05px solid #000;border-top:0.05px solid #000;height:25px;font-weight:bold;">
                                    <td colspan="2"
                                        style="border-right:0.05px solid #000;border-left:0.05px solid #000;text-align: center;font-weight:bold;">
                                        รวม : {{ strlen($receivable) > 0 ? $receivable : $groups->first()->group_name }}</td>
                                    <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                        {{ number_format($groups->sum('amt_cost'), 2) }}</td>
                                    <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                        {{ number_format($groups->max('rate_set'), 5) }}</td>
                                    <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                        {{ number_format($groups->sum('amt_insure'), 2) }}</td>
                                    <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                        {{ strlen($receivable) > 0 ? ' ' : number_format($groups->sum('amt_close'), 2) }}
                                    </td>
                                    @php
                                        $data_array_grand_total["amt_cost"] += round($groups->sum("amt_cost"),2);
                                        $data_array_grand_total["amt_insure"] += round($groups->sum("amt_insure"),2);
                                    @endphp
                                </tr>
                            @endforeach
                            @php
                                $null_receivable_filter = array_filter(json_decode(json_encode($company), true), function ($value) {
                                    return strlen($value['receivable_name']) <= 0;
                                });
                                $cnt_null_receivable = count($null_receivable_filter);
                                $total = $data_array_grand_total["amt_insure"];
                                $duty = $company->sum("amt_duty");
                                $tax = $company->sum("amt_vat");
                                //$duty=$total*1/100;
                                //$tax=$totalwithduty*7/100;

                                //recalculate for diff 0.01
                                if (count($data_diff_array_grand_total) > 0 && $data_diff_array_grand_total[$policy_set]['default_company'] == $comp_code){
                                    $duty += $data_diff_array_grand_total[$policy_set]['amt_duty'];
                                    $tax += $data_diff_array_grand_total[$policy_set]['amt_vat'];
                                }

                                $totalwithduty = $total + $duty;
                                $net = $totalwithduty + $tax;
                            @endphp
                            <!--  Grand Total -->
                            <tr
                                style="background-color:#f3f3f3; border-bottom:0.05px solid #000;height:30px;font-weight:bold;">
                                <td style="border-right:0.05px solid #000;border-left:0.05px solid #000;text-align: center;font-weight:bold;"
                                    colspan=2>รวมทั้งสิ้น</td>
                                <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                    {{ number_format($data_array_grand_total["amt_cost"] ,2) }}</td>
                                <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                    {{ number_format($company->max('rate_set'), 5) }}</td>
                                <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                    {{ number_format($company->sum('amt_insure'), 2) }}</td>
                                <td style="border-right:0.05px solid #000;text-align: right;font-weight:bold;">
                                    {{ number_format($company->sum('amt_close'), 2) }}
                                </td>
                            </tr>
                            {{-- @php
                                $total = $company->sum('amt_insure');
                                $duty = $company->sum('amt_duty');
                                $tax = $company->sum('amt_vat');
                                //$duty=$total*1/100;
                                //$tax=$totalwithduty*7/100;
                                $totalwithduty = $total + $duty;
                                $net = $totalwithduty + $tax;
                            @endphp --}}
                            <tr>
                                <td colspan=4 style="text-align: right;font-weight:bold;">
                                    ค่าเบี้ยประกันภัยก่อนคำนวณภาษีมูลค่าเพิ่ม</td>
                                <td style="text-align: right;border:0.05px solid #000;font-weight:bold;">
                                    {!! number_format($total, 2) !!}</td>
                                <td style="text-align: right;"></td>
                            </tr>
                            <tr>
                                <td colspan=4 style="text-align: right;font-weight:bold;">ค่าอากรแสตมป์</td>
                                <td style="text-align: right;border:0.05px solid #000;font-weight:bold;">
                                    {!! number_format($duty, 2) !!}</td>
                                <td style="text-align: right;"></td>
                            </tr>
                            <tr>
                                <td colspan=4 style="text-align: right;font-weight:bold;">รวมเบี้ยบวกอากรแสตมป์</td>
                                <td style="text-align: right;border:0.05px solid #000;font-weight:bold;">
                                    {!! number_format($totalwithduty, 2) !!}</td>
                                <td style="text-align: right;"></td>
                            </tr>
                            <tr>
                                <td colspan=4 style="text-align: right;font-weight:bold;">ภาษีมูลค่าเพิ่ม</td>
                                <td style="text-align: right;border:0.05px solid #000;font-weight:bold;">
                                    {!! number_format($tax, 2) !!}</td>
                                <td style="text-align: right;"></td>
                            </tr>
                            <tr>
                                <td colspan=4 style="text-align: right;font-weight:bold;">
                                    รวมค่าเบี้ยบวกอากรแสตมป์และภาษีมูลค่าเพิ่ม</td>
                                <td style="text-align: right;border:0.05px solid #000;font-weight:bold;">
                                    {!! number_format($net, 2) !!}</td>
                                <td style="text-align: right;"></td>
                            </tr>
                        @else
                            <tr style="height:100px;">
                                <td colspan="{{ $colspan }}" style="text-align:center;font-weight:bold;">
                                    ไม่มีข้อมูลตามเงื่อนไขที่ท่านเลือก </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @endforeach
    @endforeach
</body>

</html>