<!DOCTYPE html>
<html>
    <head>
        @php
            $tcode = "t".$typecode;
            if($typecode==20){ $programCode.="_L"; }
        @endphp
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports._style')
        <style>
            tr { page-break-inside: avoid !important; }
        </style>
    </head>
    <body>
        <div class="page-break"></div>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="9">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}<br>
                                <br>
                                เลขประจำตัวผู้เสียภาษี 0994000164769<br>
                            </div>
                            <div style="width:60%;text-align:center" class="b">
                                การยาสูบแห่งประเทศไทย(สำนักงานใหญ่)<br>
                                {{ $progTitle }}<br>
                                @php
                                    foreach($progPara as $para){
                                        echo $para."<br>";
                                    }
                                @endphp
                            </div>
                            <div style="width:20%;text-align:right;" class="b">
                                วันที่ : {{ parseToDateTh(now()) }}<br>
                                เวลา :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                                หน่วย : พันมวน
                                 <br>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:50px;">
                    <th style="width:80px;text-align:left">ใบกำกับภาษี<br>เลขที่</th>
                    <th style="min-width:200px;text-align:left;padding-left:5px"> ชื่อร้านค้า<br></th>
                    <th style="width:100px;text-align:left">เลขประจำตัว<br>ผู้เสียภาษี</th>
                    <th style="width:110px;text-align:left">สถานประกอบการ<br></th>
                    <th style="width:100px;text-align:right"> {!! $progUnit[$tcode] !!}</th>
                    <th style="width:130px;text-align:right"> มูลค่าสินค้า<br>จำนวนเงิน</th>
                    <th style="width:130px;text-align:right"> มูลค่าสินค้า<br>(ราคาปลีก - VAT)</th>
                    <th style="width:100px;text-align:right"> ภาษีมูลค่าเพิ่ม<br></th>
                    <th style="width:130px;text-align:right"> ราคาขายปลีก<br></th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalQty = 0;
                $totalAmt = 0;
                $totalSale = 0;
                $totalVat = 0;
                $totalNonVat = 0;
            @endphp
            
            @foreach ($data->groupBy('zone_name') as $group => $lines)
                @php
                    $sumQty = 0;
                    $sumAmt = 0;
                    $sumSale = 0;
                    $sumNonVat = 0;
                    $sumVat = 0;
                @endphp
             @if(!$loop->first)
             </tbody>
                </table>
                     <p style="page-break-after: always;"></p>
                     <table>
                        <thead>
                            <tr>
                                <th colspan="9">
            
                                    <div class="row">
                                        <div style="width:20%;text-align:left" class="b">
                                            โปรแกรม : {{ $programCode }}<br>
                                            สั่งพิมพ์ : {{ optional(auth()->user())->username }}<br>
                                            <br>
                                            เลขประจำตัวผู้เสียภาษี 0994000164769<br>
                                        </div>
                                        <div style="width:60%;text-align:center" class="b">
                                            การยาสูบแห่งประเทศไทย(สำนักงานใหญ่)<br>
                                            {{ $progTitle }}<br>
                                            @php
                                                foreach($progPara as $para){
                                                    echo $para."<br>";
                                                }
                                            @endphp
                                        </div>
                                        <div style="width:20%;text-align:right;" class="b">
                                            วันที่ : {{ parseToDateTh(now()) }}<br>
                                            เวลา :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                            หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                                            หน่วย : พันมวน
                                             <br>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:50px;">
                                <th style="width:80px;text-align:left">ใบกำกับภาษี<br>เลขที่</th>
                                <th style="min-width:200px;text-align:left;padding-left:5px"> ชื่อร้านค้า<br></th>
                                <th style="width:100px;text-align:left">เลขประจำตัว<br>ผู้เสียภาษี</th>
                                <th style="width:110px;text-align:left">สถานประกอบการ<br></th>
                                <th style="width:100px;text-align:right"> {!! $progUnit[$tcode] !!}</th>
                                <th style="width:130px;text-align:right"> มูลค่าสินค้า<br>จำนวนเงิน</th>
                                <th style="width:130px;text-align:right"> มูลค่าสินค้า<br>(ราคาปลีก - VAT)</th>
                                <th style="width:100px;text-align:right"> ภาษีมูลค่าเพิ่ม<br></th>
                                <th style="width:130px;text-align:right"> ราคาขายปลีก<br></th>
                            </tr>
                        </thead>
                        <tbody>
                 @endif
                <tr style="height:20px;">
                    <th colspan="9" ></th>
                </tr>
                
                @if($lines->first()->svat_group_code != null)
                <tr style="height:20px;">
                    <th style="font-weight:bold;text-align:left;" colspan="2" ></th>
                    <th style="font-weight:bold;text-align:left;" colspan="7" >@if($lines->first()->svat_group_code != null) เลขที่เอกสาร : {{$lines->first()->svat_group_code}}{{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_f)->format('dmy') }} @endif</th>
                </tr>
                @endif
                <tr>
                    <th style="font-weight:bold;text-align:left;" colspan="2" > {{ $group }}</th>
                    <th style="font-weight:bold;text-align:left;" colspan="7" ></th>
                </tr>
                @foreach ($lines->groupBy('so_no') as $line )

                @if($line->first()->cus_name<>"" && $line->first()->so_no<>"")
                    @php
                        if($line->first()->zone_name == "ยอดขาย(บุหรี่ไม่คิดมูลค่า)") {
                            $tax_amount = $line->sum('tax_order_header');
                        } else {
                            $tax_amount = $line->sum('tax_amount');
                        }
                        $totalQty += $line->sum('qty');
                        $totalAmt += $line->sum('amt');
                        $totalSale += $line->sum('sale_amt');
                        $totalVat += round($tax_amount, 2);
                        $totalNonVat += round($line->sum('sale_amt')-($tax_amount), 2);
                        $sumQty += $line->sum('qty');
                        $sumAmt += $line->sum('amt');
                        $sumVat += round($tax_amount, 2);
                        $sumNonVat += round($line->sum('sale_amt')-($tax_amount), 2);
                        $sumSale += $line->sum('sale_amt');
                    @endphp
                <tr style="height:20px;">
                    <td>{{ $line->first()->so_no }}</td>
                    <td style="text-align: left;">{{ $line->first()->cus_name }}</td>
                    <td>{{ $line->first()->tax_no }}</td>
                   
                    <td>
                        {{-- @if($line->pick_release_no == '66I000641')
                        สาขา 00001
                        @elseif($line->pick_release_no == '66I000642')
                        สำนักงานใหญ่
                        @else --}}
                        @if($line->first()->attribute6 == '1')
                            @if($line->first()->customer_number == "D00003") 
                                สาขา 00567
                            @else
                            {{ $line->first()->ship_to_site_name }}
                            @endif

                        @else
                            @if($line->first()->customer_number == "D00003") 
                                สาขา 00047
                            @else
                            {{ $line->first()->branch }}
                            @endif
                        @endif
                        {{-- @endif --}}
                    </td>
                    <td style="text-align: right;">
                        {{ ($line->sum('qty')<>0)?number_format($line->sum('qty'),2):'' }}
                    </td>
                    <td style="text-align: right;">{{ ($line->sum('amt')<> 0)?number_format($line->sum('amt'),2):'' }}</td>
                    <td style="text-align: right;">{{ ($line->sum('amt')<> 0)?number_format($line->sum('sale_amt')-($tax_amount),2):'' }}</td>
                    <td style="text-align: right;">{{ ($tax_amount<> 0 ) ? number_format($tax_amount, 2) : '' }}</td>
                    {{-- <td style="text-align: right;">{{ ($line->sale_amt<>0)? number_format($line->sale_amt*7/107,2):'' }}</td> --}}
                    <td style="text-align: right;">{{ ($line->sum('sale_amt')<>0)?number_format($line->sum('sale_amt'),2):'' }}</td>
                </tr>
                @endif
                @endforeach
                <tr style="height:5px;">
                    <td colspan="9"></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:30px;">
                    <td colspan=4 style="text-align: left;">ยอดรวม</td>
                    <td style="text-align: right;">{{ number_format($sumQty,2) }}</td>
                    <td style="text-align: right;">{{ number_format($sumAmt,2) }}</td>
                    <td style="text-align: right;">{{ number_format($sumNonVat,2) }}</td>
                    <td style="text-align: right;">{{ number_format($sumVat,2) }}</td>
                    <td style="text-align: right;">{{ number_format($sumSale,2) }}</td>
                </tr>
               
                
                @endforeach
            
                <tr style="height:15px;">
                    <td colspan="9"></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:30px;">
                    <td colspan=4 style="text-align: left;">ยอดรวมทั้งสิ้น</td>
                    <td style="text-align: right;">{{ number_format($totalQty,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalAmt,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalNonVat,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalVat,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalSale,2) }}</td>
                </tr>
            </tbody>
        </table>
        @if(count($getRMA->where('orderHeader.product_type_code', $typecode)) > 0) 
        <div class="page-break"></div>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="9">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}<br>
                                <br>
                                เลขประจำตัวผู้เสียภาษี 0994000164769<br>
                            </div>
                            <div style="width:60%;text-align:center" class="b">
                                การยาสูบแห่งประเทศไทย(สำนักงานใหญ่)<br>
                                {{ $progTitle }}<br>
                                @php
                                    foreach($progPara as $para){
                                        echo $para."<br>";
                                    }
                                @endphp
                            </div>
                            <div style="width:20%;text-align:right;" class="b">
                                วันที่ : {{ parseToDateTh(now()) }}<br>
                                เวลา :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                                หน่วย : พันมวน
                                 <br>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:50px;">
                    <th style="width:80px;text-align:left">ใบกำกับภาษี<br>เลขที่</th>
                    <th style="min-width:200px;text-align:left;padding-left:5px"> ชื่อร้านค้า<br></th>
                    <th style="width:100px;text-align:left">เลขประจำตัว<br>ผู้เสียภาษี</th>
                    <th style="width:110px;text-align:left">สถานประกอบการ<br></th>
                    <th style="width:100px;text-align:right"> {!! $progUnit[$tcode] !!}</th>
                    <th style="width:130px;text-align:right"> มูลค่าสินค้า<br>จำนวนเงิน</th>
                    <th style="width:130px;text-align:right"> มูลค่าสินค้า<br>(ราคาปลีก - VAT)</th>
                    <th style="width:100px;text-align:right"> ภาษีมูลค่าเพิ่ม<br></th>
                    <th style="width:130px;text-align:right"> ราคาขายปลีก<br></th>
                </tr>
            </thead>
            <tbody>
            @php
            $getRMA = $getRMA->where('orderHeader.product_type_code', $typecode);
                $getRMA = $getRMA->map(function($i) {
                    $i->vat_code = $i->orderHeader->tax > 0 ? '04' : '02';
                    return $i;
                });
            @endphp
            @foreach ($getRMA->groupBy('vat_code') as $vat_code => $lines)
                @php
                    $sumQty = 0;
                    $sumAmt = 0;
                    $sumSale = 0;
                    $sumNonVat = 0;
                    $sumVat = 0;
                @endphp
             @if(!$loop->first)
             </tbody>
                </table>
                     <p style="page-break-after: always;"></p>
                     <table>
                        <thead>
                            <tr>
                                <th colspan="9">
            
                                    <div class="row">
                                        <div style="width:20%;text-align:left" class="b">
                                            โปรแกรม : {{ $programCode }}<br>
                                            สั่งพิมพ์ : {{ optional(auth()->user())->username }}<br>
                                            <br>
                                            เลขประจำตัวผู้เสียภาษี 0994000164769<br>
                                        </div>
                                        <div style="width:60%;text-align:center" class="b">
                                            การยาสูบแห่งประเทศไทย(สำนักงานใหญ่)<br>
                                            {{ $progTitle }}<br>
                                            @php
                                                foreach($progPara as $para){
                                                    echo $para."<br>";
                                                }
                                            @endphp
                                        </div>
                                        <div style="width:20%;text-align:right;" class="b">
                                            วันที่ : {{ parseToDateTh(now()) }}<br>
                                            เวลา :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                            หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                                            หน่วย : พันมวน
                                             <br>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:50px;">
                                <th style="width:80px;text-align:left">ใบกำกับภาษี<br>เลขที่</th>
                                <th style="min-width:200px;text-align:left;padding-left:5px"> ชื่อร้านค้า<br></th>
                                <th style="width:100px;text-align:left">เลขประจำตัว<br>ผู้เสียภาษี</th>
                                <th style="width:110px;text-align:left">สถานประกอบการ<br></th>
                                <th style="width:100px;text-align:right"> {!! $progUnit[$tcode] !!}</th>
                                <th style="width:130px;text-align:right"> มูลค่าสินค้า<br>จำนวนเงิน</th>
                                <th style="width:130px;text-align:right"> มูลค่าสินค้า<br>(ราคาปลีก - VAT)</th>
                                <th style="width:100px;text-align:right"> ภาษีมูลค่าเพิ่ม<br></th>
                                <th style="width:130px;text-align:right"> ราคาขายปลีก<br></th>
                            </tr>
                        </thead>
                        <tbody>
                 @endif
                <tr style="height:20px;">
                    <th colspan="9" ></th>
                </tr>
                
                <tr style="height:20px;">
                    <th style="font-weight:bold;text-align:left;" colspan="2" ></th>
                    <th style="font-weight:bold;text-align:left;" colspan="7" > เลขที่เอกสาร : {{$vat_code}}{{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_f)->format('dmy') }}</th>
                </tr>
                <tr>
                    <th style="font-weight:bold;text-align:left;" colspan="2" >ใบลดหนี้</th>
                    <th style="font-weight:bold;text-align:left;" colspan="7" ></th>
                </tr>
                @foreach($lines as $line) 
                @php 
                    $rmaAmount = $line->lines->sum(function($i) {
                        return $i->rma_quantity * $i->orderLine->unit_price;
                    });
                    $rmaQuantity = $line->lines->sum('rma_quantity');
                    $rmaPrice = $line->lines->sum(function($i) {
                        return $i->rma_quantity * $i->orderLine->attribute1;
                    });
                    $rmaVat = ($rmaPrice * 7) / 107;
                    $rmaCost = $rmaPrice - $rmaVat;

                    $sumQty += $rmaQuantity;
                    $sumAmt += $rmaAmount;
                    $sumSale += $rmaPrice;
                    $sumNonVat += $rmaCost;
                    $sumVat += $rmaVat;
                @endphp
                <tr >
                    <td>{{ ($line->credit_note_number) }}</td>
                    <td>{{ $line->customer->customer_name }}</td>
                    <td></td>
                    <td></td>
                    <td align="right">({{number_format($rmaQuantity, 2)}})</td>
                    <td align="right">({{number_format($rmaAmount, 2)}})</td>
                    <td align="right">({{number_format($rmaCost, 2)}})</td>
                    <td align="right">({{number_format($rmaVat, 2)}})</td>
                    <td align="right">({{number_format($rmaPrice, 2)}})</td>
                </tr>
                @endforeach
                <tr style="height:5px;">
                    <td colspan="9"></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:30px;">
                    <td colspan=4 style="text-align: left;">ยอดรวม</td>
                    <td style="text-align: right;">({{ number_format($sumQty,2) }})</td>
                    <td style="text-align: right;">({{ number_format($sumAmt,2) }})</td>
                    <td style="text-align: right;">({{ number_format($sumNonVat,2) }})</td>
                    <td style="text-align: right;">({{ number_format($sumVat,2) }})</td>
                    <td style="text-align: right;">({{ number_format($sumSale,2) }})</td>
                </tr>
               
                
                @endforeach
            
                <tr style="height:15px;">
                    <td colspan="9"></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:30px;">
                    <td colspan=4 style="text-align: left;">ยอดรวมทั้งสิ้น</td>
                    <td style="text-align: right;">{{ number_format($totalQty - $sumQty,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalAmt - $sumAmt,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalNonVat- $sumNonVat,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalVat - $sumVat,2) }}</td>
                    <td style="text-align: right;">{{ number_format($totalSale - $sumSale,2) }}</td>
                </tr>
            </tbody>
        </table>
        @endif
        <div style="padding-top:10px;">หมายเหตุรายการ : {{ $remark }}</div>
        <div style="float:right;width-min:300px;line-height:2">
            ผู้จัดทำ <span style="width:130px;border-bottom:1px solid #ccc;display:inline-block"></span>หัวหน้าส่วนงาน<span style="width:130px;border-bottom:1px solid #ccc;display:inline-block"></span> <br>
            หัวหน้ากองบริหารขาย <span style="width:130px;border-bottom:1px solid #ccc;display:inline-block"></span> สำเนาหัวหน้ากองบริหารขาย <br>
            <div style="text-align: center"> - กองภาษี</div>
        </div>
     </div>
    </body>
</html>
