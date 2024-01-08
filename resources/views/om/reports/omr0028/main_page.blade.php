<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ยอดการจำหน่ายยาสูบ/ยาเส้น (สโมสร)</title>
</head>
<style>
    @include('om.reports.omr0028._set_font');
    body {
        font-size: 16px;
        font-weight: normal;
    }
</style>

<body>
    @php
        $l = 0;
    @endphp
    @for ($idx = 0; $idx < $count_arr; $idx++)
        <div class="row col-lg-12" style="position: relative; height: 120px;">
            <div class="col-md-4"
                style="font-size: 16px; text-align: left; width: 150px; position: absolute; top: 0; left: 0;">
                <div style="margin-bottom: 5px;">
                    <strong> โปรแกรม : {{ $pg_code }}</strong>
                </div>
                <div style="margin-bottom: 5px;">
                    <strong> สั่งพิมพ์ : {{ optional(auth()->user())->name }}</strong>
                </div>
            </div>
            <div class="col-md-4"
                style="font-size: 20px; text-align: center; font-weight: bold; position: absolute; top: 0; left: 39.5%;">
                <div style="margin-bottom: 5px;"> การยาสูบแห่งประเทศไทย</div>
                <div style="margin-bottom: 5px;"> ยอดการจำหน่ายยาสูบ/ยาเส้น (สโมสร)</div>
                <div style="margin-bottom: 5px;"> ประจำเดือน {{ DateThaiMonthYear($start_dt) }}</div>
                <div style="margin-bottom: 5px;"> ปีงบประมาณ {{ $my }}</div>
            </div>
            <div class="col-md-4" style="font-size: 16px; position: absolute; top: 0; right: 0; width: 90px;">
                <div class="row">
                    <div style="margin-bottom: 1px; display: inline;"><strong> วันที่ : </strong></div>
                    <div style="display: inline; text-align: right;"><strong>{{ $dt_now }}</strong></div>
                </div>
                <div class="row">
                    <div style="margin-bottom: 1px; display: inline-block;"><strong> เวลา : </strong></div>
                    <div style="display: inline-block; width: 56px; text-align: right;">
                        <strong>{{ date('H:i') }}</strong></div>
                </div>
                <div class="row">
                    <div style="margin-top: 2px; display: inline-block;"><strong> หน้า : </div>
                    <div style="padding-top: 3px; display: inline-block; width: 56px; text-align: right;">
                        {{ $idx + 1 }}/{{ $count_arr }}</div>
                </div>
            </div>
        </div>
        <div>
            <div style="margin-top: -40px; text-align: left; ">
                <div style="margin-bottom: 10px; font-size: 16px; font-weight: bold;"> *** ฝากสโมสรยาสูบขาย ***</div>
                <div style="margin-bottom: 10px; font-size: 20px; font-weight: bold;"> ร้านค้า : {{ (isset($result_arr[$idx][$l]['customer_name'] ))? $result_arr[$idx][$l]['customer_name']  : '' }}</div>
            </div>
        </div>
        @php 
        $rma = $getRMA->where('customer.customer_name', $result_arr[$idx][$l]['customer_name']);
        $rmaLines = collect();
        foreach($rma->pluck('lines') as $rmaLine)  {
            $rmaLines = $rmaLines->merge($rmaLine);
        }
        $rmaLinesGroupBy = $rmaLines->groupBy('orderLine.item_id') ?? collect();
       
        @endphp
        <table class="table table-bordered" style="border-collapse: collapse; padding: 5px; margin: 0px;">
            <thead>
                <tr
                    style="border-top: 0.5px solid #000000; border-bottom: 0.5px solid #000000; padding-top: 10px; padding-bottom:7px">
                    <th width="8%" class="report_header">
                        ตรา
                    </th>
                    <th width="6%" class="report_header" style="text-align: right">
                        พันมวน
                    </th>
                    <th width="10%" class="report_header" style="text-align: right">
                        จำนวนเงิน
                    </th>
                    <th width="10%" class="report_header" style="text-align: right">
                        มูลค่าสินค้า <br />
                        (ราคาปลีก - VAT)
                    </th>
                    <th width="10%" class="report_header" style="text-align: right">
                        ภาษีมูลค่าเพิ่ม
                    </th>
                    <th width="7%" class="report_header" style="text-align: right">
                        ราคาปลีก
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (count($result_arr[$idx]) > 0)
                    @php
                        $i = 1;
                        $style = 'font-weight: bold;';
                        $style2 = '';
                    @endphp
                    @foreach ($result_arr[$idx] as $item)
                        @if (isset($item['item_code']) && $item['item_code'] == 'TOTAL')
                            <?php
                            $style2 = 'border-top: 0.5px solid #000000; border-bottom: 0.5px solid #000000; padding-top: 7px; padding-bottom:7px';
                            $style = 'font-weight: bold;';
                            $l = 0;
                            ?>
                        @else
                            @php
                                $style2 = 'padding-top: 3px; padding-bottom:3px';
                                $style = '';
                                $l++;
                            @endphp
                        @endif
                        <tr style="{{ $style }}">
                            <td style="font-size: 16px; text-align: left; {{ $style2 }}">
                                {{ (isset($item['item_description']))? $item['item_description'] : '' }}
                            </td>
                            <td style="font-size: 16px; text-align: right;{{ $style2 }}">
                                {{ (isset($item['consignment_quantity']))? number_format((float)$item['consignment_quantity'], 2) : '' }}
                            </td>
                            <td style="font-size: 16px; text-align: right;{{ $style2 }}">
                                {{ (isset($item['consignment_amount']))? number_format((float)$item['consignment_amount'], 2) : '' }}
                            </td>
                            <td style="font-size: 16px; text-align: right;{{ $style2 }}">
                                {{ (isset($item['base_vat']))? number_format((float)$item['base_vat'], 2) : '' }}
                                {{-- {{ (isset($item['EXCLUED_VAT']))? number_format((float)$item['EXCLUED_VAT'], 2) : '' }} --}}
                            </td>
                            <td style="font-size: 16px; text-align: right;{{ $style2 }}">
                                {{ (isset($item['tax_amount']))? number_format((float)$item['tax_amount'], 2) : '' }}
                                {{-- {{ (isset($item['vat']))? number_format((float)$item['vat'], 2) : '' }} --}}
                            </td>

                            <td style="font-size: 16px; text-align: right;{{ $style2 }}">
                                {{ (isset($item['retail_amount']))? number_format((float)$item['retail_amount'], 2) : '' }}
                                {{-- |{{ (isset($item['operand']))? number_format((float)$item['operand'], 2) : '' }} --}}
                            </td>
                            <?php $i++; ?>
                        </tr>
                    @endforeach
                    @if(count($rmaLinesGroupBy) > 0)
                    @php 
                        $rmaQtyTotal = 0;
                        $rmaAmountTotal = 0;
                    @endphp
                    
                    @foreach($rmaLinesGroupBy as $line)
                    @php 
                        $rmaQty = $line->sum('rma_quantity');
                        $rmaAmount = $line->sum(function($i){
                            return $i->rma_quantity * $i->orderLine->unit_price;
                        });
                        $rmaQtyTotal = $rmaQty;
                        $rmaAmountTotal = $rmaAmount;
                        $rmaCost = $line->sum(function($i) {
                            return $i->rma_quantity * $i->orderLine->attribute1;
                        });
                        $rmaVat = ($rmaCost * 7) / 107;
        
                        $sumRmaQty       += $rmaQtyTotal;
                        $sumRmaAmount    += $rmaAmountTotal;
                        $sumRmCostSubVat += $rmaCost - $rmaVat;
                        $sumRmVat        += $rmaVat;
                        $sumRmCost       += $rmaCost;
                    @endphp
                    <tr>
                        <td style="text-align: left; vertical-align: middle;">{{ $line->first()->orderLine->item_description }}</td>
                        <td style="text-align: right; vertical-align: middle;">({{ number_format($rmaQtyTotal, 2) }})</td>
                        <td style="text-align: right; vertical-align: middle;"></td>
                        <td style="text-align: right; vertical-align: middle;">({{ number_format($rmaAmount, 2)}})</td>
                        <td style="text-align: right; vertical-align: middle;">({{ number_format($rmaCost - $rmaVat, 2) }})</td>
                        <td style="text-align: right; vertical-align: middle;">({{ number_format($rmaVat, 2) }})</td>
                        <td style="text-align: right; vertical-align: middle;">({{ number_format($rmaCost, 2) }})</td>
                    </tr>
                    @endforeach
                @endif
                @else
                <tr>
                    <td colspan="6" class="text-center">
                        ไม่พบข้อมูล
                    </td>
                </tr>
                @endif
                @if (isset($note_list) && !empty($note_list) && $idx == ($count_arr-1))
                <tr>
                    <td colspan="6" style="font-size: 16px; padding-top: 7px;" class="text-left">
                        หมายเหตุรายการ: {{ $note_list }}
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        <br>
        <div>
            <div style="padding-top:1px;text-align:center">จบรายงาน</div>
            <div style="padding-top:1px;text-align:right">
                <div>หัวหน้าส่วนงาน _____________________________ <br><br>
            </div>
            <div style="padding-top:1px;text-align:right">
                <div>ผู้จัดทำ _____________________________ &nbsp; &nbsp; &nbsp; &nbsp; หัวหน้ากองบริหารขาย _____________________________ <br><br>
            </div>
        </div>
        <div style="page-break-after: always;"></div>
    @endfor
@if ($count_arr <= 0)
<div class="col-md-4"
style="font-size: 20px; text-align: center; font-weight: bold; position: absolute; top: 0; left: 39.5%;">
<div style="margin-bottom: 5px;"> ไม่พบข้อมูล</div>
</div>
@endif
    @php

        function DateThaiMonthYear($strDate)
        {
            $strYear = date('Y', strtotime($strDate)) + 543;
            $strMonth = date('n', strtotime($strDate));
            $strDay = date('j', strtotime($strDate));
            $strHour = date('H', strtotime($strDate));
            $strMinute = date('i', strtotime($strDate));
            $strSeconds = date('s', strtotime($strDate));
            $strMonthCut = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
            $strMonthThai = $strMonthCut[$strMonth];
            //return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
            return "$strMonthThai พ.ศ. $strYear";
        }
    @endphp
</body>

</html>
