<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
        @include('om.reports._style')
    </head>
    <body>
@php
    $colspan=18;
@endphp

@foreach ($data->groupBy('group_comp') as $company_name => $company)
    @php
        $comp=$company->first();
        $comp_percent=$comp->comp_percent;
        $insur_percent=$comp->insur_percent;
    @endphp
    <div class="page-break">
        <div class="page-break"></div>
        <table class="table" >
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">

                        <div class="row">
                            <div style="width:20%;text-align:left;font-weight:bold;" class="b">
                                โปรแกรม : {{ $programCode }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}<br>
                                <br>
                                <br>
                                สถานะ : {{ $status }}<br>

                            </div>
                            <div style="width:60%;text-align:center;font-weight:bold;" class="b">
                                การยาสูบแห่งประเทศไทย<br>
                                {{ $progTitle }}<br>
                                {{ $repTitle }}
                                @php
                                    echo $company_name."<br>";
                                    foreach($progPara as $para){
                                        echo $para."<br>";
                                    }
                                @endphp
                            </div>
                            <div style="width:20%;text-align:right;font-weight:bold;" class="b">
                                วันที่ : {{ parseToDateTh(now()) }}<br>
                                เวลา :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                                 <br>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:50px;font-weight:bold;">
                    <th style="border-right:1px solid #000;border-left:1px solid #000;width:50px;text-align:center;font-weight:bold;"><b>ลำดับ</b><br></th>
                    <th style="border-right:1px solid #000;min-width:100px;text-align:center;font-weight:bold;">รายการ<br></th>
                    <th style="border-right:1px solid #000;text-align:center;font-weight:bold;">มูลค่าทุนประกัน<br>(บาท) {{ $comp_percent }}%</th>
                    <th style="border-right:1px solid #000;text-align:center;font-weight:bold;">อัตราเบี้ย<br>ประกัน</th>
                    <th style="border-right:1px solid #000;width:150px;text-align:center;font-weight:bold;">ค่าเบี้ยประกัน<br>{{ $insur_percent }}%<br>(บาท)</th>
                    <th style="border-right:1px solid #000;width:150px;text-align:center;font-weight:bold;">คำนวน<br>ปิดบัญชี<br>(บาท)</th>
                    @foreach($months as $month)
                        <th style="border-right:1px solid #000;width:150px;text-align:center;font-weight:bold;">ค่าเบี้ยเฉลี่ย<br>{{ $month->mth_th }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @php
                $i=0;
            @endphp
            @if(count($company)>0)
                @foreach ($company->groupBy('group_01') as $group => $cats)
                    @php
                        $i++;
                        $ii=0;
                    @endphp
                <tr style="height:30px;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;width:80px;text-align:center;vertical-align:top;font-weight:bold;">{{ $i }}.<br></td>
                    <td style="border-right:1px solid #000;font-weight:bold;text-align:left;vertical-align:top;font-weight:bold;">{{ $group }}<br></td>
                    @for($j=0;$j<=15;$j++)
                        <td style="border-right:1px solid #000;"><br></td>
                    @endfor
                </tr>
                @foreach ($cats->groupBy('group_02') as $cat => $lines)
                    @php
                        $ii++;
                    @endphp
                <tr style="height:30px;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;width:80px;text-align:center;vertical-align:top;font-weight:bold;">{{ $i }}.{{ $ii }}<br></td>
                    <td style="border-right:1px solid #000;font-weight:bold;text-align:left;vertical-align:top;font-weight:bold;">{{ $cat }}<br></td>
                    @for($j=0;$j<=15;$j++)
                        <td style="border-right:1px solid #000;"><br></td>
                    @endfor
                </tr>
                    @foreach ($lines as $line )
                        @if($line->cat_title<>"")
                <tr style="height:25px;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;"></td>
                    <td style="border-right:1px solid #000;text-align: left;">{{ $line->cat_title }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($line->amt_cost,2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;"></td>
                    <td style="border-right:1px solid #000;text-align: right;"></td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($line->amt_insure,2) }}</td>
                            @foreach($months as $month)
                                @php
                                    $m="amt_{$month->mth_code}";
                                @endphp
                                <td style="border-right:1px solid #000;text-align: right;">{{ number_format($line->$m,2) }}</td>
                            @endforeach
                </tr>
                        @endif
                    @endforeach
                <!-- sub total -->
                <tr style="border-bottom:1px solid #000;border-top:1px solid #000;height:25px;font-weight:bold;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;"></td>
                    <td style="border-right:1px solid #000;text-align: center;font-weight:bold;">รวม</td>
                    <td style="border-right:1px solid #000;text-align: right;font-weight:bold;">{{ number_format($lines->sum("amt_cost"),2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;font-weight:bold;">{{ number_format($lines->max("rate_set"),5) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;font-weight:bold;">{{ number_format($lines->sum("amt_insure"),2)  }}</td>
                    <td style="border-right:1px solid #000;text-align: right;font-weight:bold;">{{ number_format($lines->sum("amt_close"),2) }}</td>
                    @foreach($months as $month)
                    <td style="border-right:1px solid #000;text-align: right;font-weight:bold;">{{ number_format($lines->sum("amt_{$month->mth_code}"),2) }}</td>
                    @endforeach
                </tr>

                    @endforeach

                @endforeach
                <!--  Grand Total -->
                <tr style="border-bottom:1px solid #000;height:30px;font-weight:bold;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;text-align: center;font-weight:bold;" colspan=2>รวมทั้งสิ้น</td>
                    <td style="border-right:1px solid #000;text-align: right;font-weight:bold;">{{ number_format($company->sum("amt_cost"),2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;font-weight:bold;">{{ number_format($company->max("rate_set"),5) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;font-weight:bold;">{{ number_format($company->sum("amt_insure"),2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;font-weight:bold;">{{ number_format($company->sum("amt_close"),2) }}</td>
                    @foreach($months as $month)
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($company->sum('amt_'.$month->mth_code),2) }}</td>
                    @endforeach
                </tr>
            @php
                $total=$company->sum("amt_insure");
                $duty=$company->sum("amt_duty");
                $tax=$company->sum("amt_vat");
                //$duty=$total*1/100;
                //$tax=$totalwithduty*7/100;
                $totalwithduty=$total+$duty;
                $net=$totalwithduty+$tax;
            @endphp
                <tr>
                    <td colspan=4 style="text-align: right;font-weight:bold;">ค่าเบี้ยประกันภัยก่อนคำนวณภาษีมูลค่าเพิ่ม</td>
                    <td style="text-align: right;border:1px solid #000;font-weight:bold;">{!! number_format($total,2) !!}</td>
                    <td style="text-align: right;"></td>
                    <td colspan="{{ count($months) }}"></td>
                </tr>
                <tr>
                    <td colspan=4 style="text-align: right;font-weight:bold;">ค่าอากรแสตมป์</td>
                    <td style="text-align: right;border:1px solid #000;font-weight:bold;">{!! number_format($duty,2) !!}</td>
                    <td style="text-align: right;"></td>
                    <td colspan="{{ count($months) }}"></td>
                </tr>
                <tr>
                    <td colspan=4 style="text-align: right;font-weight:bold;">รวมเบี้ยบวกอากรแสตมป์</td>
                    <td style="text-align: right;border:1px solid #000;font-weight:bold;">{!! number_format($totalwithduty,2) !!}</td>
                    <td style="text-align: right;"></td>
                    <td colspan="{{ count($months) }}"></td>
                </tr>
                <tr>
                    <td colspan=4 style="text-align: right;font-weight:bold;">ภาษีมูลค่าเพิ่ม</td>
                    <td style="text-align: right;border:1px solid #000;font-weight:bold;">{!! number_format($tax,2) !!}</td>
                    <td style="text-align: right;"></td>
                    <td colspan="{{ count($months) }}"></td>
                </tr>
                <tr>
                    <td colspan=4 style="text-align: right;font-weight:bold;">รวมค่าเบี้ยบวกอากรแสตมป์และภาษีมูลค่าเพิ่ม</td>
                    <td style="text-align: right;border:1px solid #000;font-weight:bold;">{!! number_format($net,2) !!}</td>
                    <td style="text-align: right;"></td>
                    <td colspan="{{ count($months) }}"></td>
                </tr>

            @else
                <tr style="height:100px;">
                    <td colspan="{{ $colspan }}" style="text-align:center;font-weight:bold;"> ไม่มีข้อมูลตามเงื่อนไขที่ท่านเลือก </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endforeach
</body>
</html>
