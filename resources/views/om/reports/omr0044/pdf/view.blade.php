
    <div class="page-break">
        <div class="page-break"></div>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">
                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}
                            </div>
                            <div style="width:60%;text-align:center" class="b">
                                การยาสูบแห่งประเทศไทย<br>
                                {{ $progTitle }}<br>
                                @php
                                    foreach($progPara as $para){
                                        echo $para."<br>";
                                    }

                                    $count=count($company);
                                    if($count>0){
                                        echo $company->first()->cs_customer_name."<br>";
                                    }else{
                                        "<br>";
                                    }
                                @endphp
                            </div>
                            <div style="width:20%;text-align:right;" class="b">
                                วันที่ : {{ parseToDateTh(now()) }}<br>
                                เวลา :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                                 <br>

                            </div>
                        </div>

                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000; margin: 0px; padding: 0px;height:50px;">
                    <th style="width:50px;"></th>
                    <th style="text-align:left"> วันที่ฝากขาย</th>
                    <th style="text-align:left"> เลขที่ใบฝากขาย</th>
                    <th style="text-align:right"> ราคา 2</th>
                    <th style="text-align:right"> ราคา 1</th>
                    <th style="text-align:right"> ผลต่างราคา</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($company->groupBy('cs_product') as $group => $lines)
                <tr style="height:40px;">
                    <th style="font-weight:bold;text-align:left;" colspan="{{ $colspan }}" ><br><br>{{ $group }}</th>
                </tr>
                @foreach ($lines as $line )
                <tr style="height:25px;">
                    <td></td>
                    <td style="text-align: left;">{{ $line->cs_date_th }}</td>
                    <td>{{ $line->cs_no }}</td>
                    <td style="text-align: right;">{{ number_format($line->cs_price2,2) }}</td>
                    <td style="text-align: right;">{{ number_format($line->cs_price1,2) }}</td>
                    <td style="text-align: right;">{{ number_format($line->cs_diff,2) }}</td>
                </tr>
                @endforeach
                <tr style="height:10px;">
                    <td colspan={{ $colspan }}></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000; margin: 0px; padding: 0px;height:40px;">
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">รวม</td>
                    <td style="text-align: right;">{{ number_format($lines->sum('cs_price2'),2) }}</td>
                    <td style="text-align: right;">{{ number_format($lines->sum('cs_price1'),2) }}</td>
                    <td style="text-align: right;">{{ number_format($lines->sum('cs_diff'),2) }}</td>
                </tr>
            @endforeach
                <tr style="height:20px;">
                    <td colspan={{ $colspan }}></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">รวมทั้งสิ้น</td>
                    <td style="text-align: right;">{{ number_format($company->sum('cs_price2'),2) }}</td>
                    <td style="text-align: right;">{{ number_format($company->sum('cs_price1'),2) }}</td>
                    <td style="text-align: right;">{{ number_format($company->sum('cs_diff'),2) }}</td>
                </tr>
            </tbody>
        </table>
        <div style="text-align:center;margin:20px;">
            <table style="width:320px;padding-top:20px;" align=center>
                <tr>
                    <td align="left" width=150>ค่าตอบแทน 95%</td>
                    <td align="center" width=20>=</td>
                    <td align="right" width=150>{{ number_format($company->sum('cs_diff')*95/100,2) }}</td>
                </tr>
                <tr>
                    <td align="left">VAT</td>
                    <td align="center">=</td>
                    <td align="right">{{ number_format(($company->sum('cs_diff')*95/100)*7/107,2) }}</td>
                </tr>
                <tr>
                    <td align="left">มูลค่า</td>
                    <td align="center">=</td>
                    <td align="right">{{ number_format(($company->sum('cs_diff')*95/100)-(($company->sum('cs_diff')*95/100)*7/107),2) }}</td>
                </tr>
            </table>
        </div>
        <div style="padding-top:10px;">หมายเหตุรายการ :  {{ $remark }}</div>
     </div>
