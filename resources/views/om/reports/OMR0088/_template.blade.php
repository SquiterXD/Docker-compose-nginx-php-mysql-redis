<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports.OMR0088._style')
    </head>
    <body>
        @php
            $total_case_credit_2 = 0;
            $total_case_credit_3 = 0;
            $total_case_consign_bkk = 0;
            $total_case_consign_region = 0;
            $total_case_cig = 0;
            $total_case_tobacco = 0;
            $total_case_total = 0;
            $total_case_cig_qty = 0;
            $total_case_tobacco_qty = 0;

            function set_number($number, $digi) {
            if($number < 0) {
                $number = "(".number_format(abs($number), $digi).")";
            } else {
                $number = number_format(abs($number), $digi);
            }

            return $number;
        }
        @endphp
        @foreach ($data as $page => $items)
            <div class="b" style="margin-bottom: 0.7rem; font-size: 16px;">
                <div class="inline-block" style="width: 22%">
                    <div>
                        โปรแกรม : OMR0088
                    </div>
                    <div>
                        สั่งพิมพ์ : {{ \Auth::user()->username }}
                    </div>
                    {{-- <div style="margin-top: 0.7rem;">
                        เลขที่ประจำตัวผู้เสียภาษี : {{ $tax_payer_id }}
                    </div> --}}
                </div>
                <div class="inline-block text-center" style="width: 55%">
                    <div>
                        การยาสูบแห่งประเทศไทย
                    </div>
                    <div>
                        สรุปยอดเงินจำหน่ายยาสูบแยกตามกลุ่มวงเงินเชื่อ
                    </div>
                    <div style="margin-top: 0.2rem;">
                        ตั้งแต่วันที่ {{ dateFormatThai($start_date) }} ถึงวันที่ {{ dateFormatThai($end_date) }}
                    </div>
                </div>
                <div class="inline-block text-right" style="width: 22%">
                    <div>
                        วันที่ {{ dateFormatThai(date('d-M-Y')) }}
                    </div>
                    <div>
                        เวลา {{ strtoupper(date('H:i')) }}
                    </div>
                    <div>
                        หน้า {{ $page+1 }} / {{ $loop->count }}
                    </div>
                </div>
            </div>
            <table class="table">
                <thead class="b">
                    <tr>
                        <td class="text-center">
                            วันที่
                        </td>
                        <td class="text-center">
                            กลุ่มเงินเชื่อ 2
                        </td>
                        <td class="text-center">
                            กลุ่มเงินเชื่อ 3
                        </td>
                        <td class="text-center">
                            ฝากขาย กทมฯ
                        </td>
                        <td class="text-center">
                            ฝากขาย ภูมิภาค
                        </td>
                        <td class="text-center">
                            เงินสด(บุหรี่)
                        </td>
                        <td class="text-center">
                            เงินสด(ยาเส้น)
                        </td>
                        <td class="text-center">
                            รวมเงิน
                        </td>
                        <td class="text-center">
                            บุหรี่<br>
                            (พันมวน)
                        </td>
                        <td class="text-center">
                            ยาเส้น<br>
                            (หีบ)
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $key => $item)
                        @php
                           
                            $case_credit_2 = $item["credit_2_amt"];
                            $case_credit_3 = $item["credit_3_amt"];
                            $case_consign_bkk = $item["consign_bkk_amt"];
                            $case_consign_region = $item["consign_region_amt"];
                            $case_cig = $item["cig_amt"] ;
                            $case_tobacco = $item["tobacco_amt"] ;
                            $case_total = $case_credit_2+ $case_credit_3 + $case_consign_bkk + $case_consign_region + $case_cig + $case_tobacco;
                            // $case_total = $item["total_amt"];
                            $case_cig_qty = $item["cig_qty"];
                            $case_tobacco_qty = $item["tobacco_qty"] ;

                            $total_case_credit_2 += $case_credit_2;
                            $total_case_credit_3 += $case_credit_3;
                            $total_case_consign_bkk += $case_consign_bkk;
                            $total_case_consign_region += $case_consign_region;
                            $total_case_cig += $case_cig;
                            $total_case_tobacco += $case_tobacco;
                            $total_case_total += $case_total;
                            $total_case_cig_qty += $case_cig_qty;
                            $total_case_tobacco_qty += $case_tobacco_qty;
                        @endphp
                        <tr>
                            <td class="text-center">
                                {{ dateFormatThai($item["date"]) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($case_credit_2, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($case_credit_3, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($case_consign_bkk, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($case_consign_region, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($case_cig, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($case_tobacco, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($case_total, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($case_cig_qty, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($case_tobacco_qty, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    @if($loop->last)
                        <tr style="border-top: 0.5px solid rgb(100, 100, 100);
                            border-bottom: 0.5px solid rgb(100, 100, 100);">
                            <td class="text-right">
                                ยอดรวม
                            </td>
                            <td class="text-right">
                                {{ number_format($total_case_credit_2, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($total_case_credit_3, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($total_case_consign_bkk, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($total_case_consign_region, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($total_case_cig, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($total_case_tobacco, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($total_case_total, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($total_case_cig_qty, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($total_case_tobacco_qty, 2) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if(count($getRMA) > 0) 
            <h4>รายการลดหนี้</h4>
            <table class="table" style="margin-top:15px">
                <thead class="b">
                    <tr>
                        <td class="text-center">
                            วันที่
                        </td>
                        <td class="text-center">
                            กลุ่มเงินเชื่อ 2
                        </td>
                        <td class="text-center">
                            กลุ่มเงินเชื่อ 3
                        </td>
                        <td class="text-center">
                            ฝากขาย กทมฯ
                        </td>
                        <td class="text-center">
                            ฝากขาย ภูมิภาค
                        </td>
                        <td class="text-center">
                            เงินสด(บุหรี่)
                        </td>
                        <td class="text-center">
                            เงินสด(ยาเส้น)
                        </td>
                        <td class="text-center">
                            รวมเงิน
                        </td>
                        <td class="text-center">
                            บุหรี่<br>
                            (พันมวน)
                        </td>
                        <td class="text-center">
                            ยาเส้น<br>
                            (หีบ)
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @php 
                    $total_rma_case_credit_2=0;
$total_rma_case_credit_3 = 0;
$total_rma_case_consign_bkk = 0;
$total_rma_case_consign_region = 0;
$total_rma_case_cig = 0;
$total_rma_case_tobacco = 0;
$total_rma_case_total = 0;
$total_rma_case_cig_qty = 0;
$total_rma_case_tobacco_qty = 0;
                    @endphp
                    @foreach ($getRMA->groupBy(function($i) {
                        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$i->rma_date)->format('Y-m-d');
                    }) as $key => $rma)
                        @php
                            $rmaAmountCG2 = 0;
                            $rmaAmountCG3 = 0;
                            $rmaCashCigarate = 0;
                            $rmaCashTobbaco = 0;
                            $rmaQtyCigarate = 0;
                            $rmaQtyTobbaco = 0;

                            // if(count($rma) > 0) {
                                $rmaAmountCG2 = $rma->sum(function($item) {
                                    return ($item->paymentApply->attribute1 == 'Y' && $item->paymentApply->credit_group_code == '2') ? $item->paymentApply->invoice_amount * -1: 0;
                                });
                                $rmaAmountCG3 = $rma->sum(function($item) {
                                    return ($item->paymentApply->attribute1 == 'Y' && $item->paymentApply->credit_group_code == '3') ? $item->paymentApply->invoice_amount * -1: 0;
                                });

                                $rmaCashCigarate = $rma->sum(function($item) {
                                    if($item->orderHeader->product_type_code == 10 && ($item->paymentApply->credit_group_code == null || $item->paymentApply->credit_group_code == 0)) {
                                        return $item->lines->sum(function($i) {
                                            return $i->rma_quantity * $i->orderLine->unit_price  * (-1);
                                        });
                                    } else {
                                        return 0;
                                    }
                                });
                                $rmaCashTobbaco  = $rma->sum(function($item) {
                                    if($item->orderHeader->product_type_code == 20  && ($item->paymentApply->credit_group_code == null || $item->paymentApply->credit_group_code == 0)) {
                                        return $item->lines->sum(function($i) {
                                            return $i->rma_quantity * $i->orderLine->unit_price * (-1);
                                        });
                                    } else {
                                        return 0;
                                    }
                                });
                                $rmaQtyCigarate = $rma->sum(function($item) {
                                    if($item->orderHeader->product_type_code == 10) {
                                        return $item->lines->sum(function($i) {
                                            return $i->rma_quantity * (-1);
                                        });
                                    } else {
                                        return 0;
                                    }
                                });
                                $rmaQtyTobbaco  = $rma->sum(function($item) {
                                    if($item->orderHeader->product_type_code == 20) {
                                        return $item->lines->sum(function($i) {
                                            return $i->rma_quantity * (-1);
                                        });
                                    } else {
                                        return 0;
                                    }
                                });
                        //    }
                            $case_credit_2 =  $rmaAmountCG2;
                            $case_credit_3 =  $rmaAmountCG3;
                            $case_consign_bkk = 0;
                            $case_consign_region = 0;
                            $case_cig = 0 ;
                            $case_tobacco = 0;
                            $case_total = $case_credit_2+ $case_credit_3 + $case_consign_bkk + $case_consign_region + $case_cig + $case_tobacco+ $rmaCashCigarate + $rmaCashTobbaco;
                            // // $case_total = $item["total_amt"];
                            $case_cig_qty =  $rmaQtyCigarate;
                            $case_tobacco_qty =$rmaQtyTobbaco;

                            $total_rma_case_credit_2 += $case_credit_2;
                            $total_rma_case_credit_3 += $case_credit_3;
                            $total_rma_case_consign_bkk += $case_consign_bkk;
                            $total_rma_case_consign_region += $case_consign_region;
                            $total_rma_case_cig += $case_cig;
                            $total_rma_case_tobacco += $case_tobacco;
                            $total_rma_case_total += $case_total;
                            $total_rma_case_cig_qty += $case_cig_qty;
                            $total_rma_case_tobacco_qty += $case_tobacco_qty;
                        @endphp
                        <tr>
                            <td class="text-center">
                                {{ dateFormatThai($rma->first()->rma_date) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($case_credit_2, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($case_credit_3, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($case_consign_bkk, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($case_consign_region, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($case_cig, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($case_tobacco, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($case_total, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($case_cig_qty, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($case_tobacco_qty, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    @if($loop->last)
                        <tr style="border-top: 0.5px solid rgb(100, 100, 100);
                            border-bottom: 0.5px solid rgb(100, 100, 100);">
                            <td class="text-right">
                                ยอดรวม
                            </td>
                            <td class="text-right">
                                {{ set_number($total_rma_case_credit_2, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($total_rma_case_credit_3, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($total_rma_case_consign_bkk, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($total_rma_case_consign_region, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($total_rma_case_cig, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($total_rma_case_tobacco, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($total_rma_case_total, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($total_rma_case_cig_qty, 2) }}
                            </td>
                            <td class="text-right">
                                {{ set_number($total_rma_case_tobacco_qty, 2) }}
                            </td>
                        </tr>
                        <tr style="border-top: 0.5px solid rgb(100, 100, 100);
                        border-bottom: 0.5px solid rgb(100, 100, 100);">
                        <td class="text-right">
                            ยอดรวมทั้งสิ้น
                        </td>
                        <td class="text-right">
                            {{ set_number($total_case_credit_2 + $total_rma_case_credit_2, 2) }}
                        </td>
                        <td class="text-right">
                            {{ set_number($total_case_credit_3 + $total_rma_case_credit_3, 2) }}
                        </td>
                        <td class="text-right">
                            {{ set_number($total_case_consign_bkk + $total_rma_case_consign_bkk, 2) }}
                        </td>
                        <td class="text-right">
                            {{ set_number($total_case_consign_region + $total_rma_case_consign_region, 2) }}
                        </td>
                        <td class="text-right">
                            {{ set_number($total_case_cig + $total_rma_case_cig, 2) }}
                        </td>
                        <td class="text-right">
                            {{ set_number($total_case_tobacco + $total_rma_case_tobacco, 2) }}
                        </td>
                        <td class="text-right">
                            {{ set_number($total_case_total + $total_rma_case_total, 2) }}
                        </td>
                        <td class="text-right">
                            {{ set_number($total_case_cig_qty + $total_rma_case_cig_qty, 2) }}
                        </td>
                        <td class="text-right">
                            {{ set_number($total_case_tobacco_qty + $total_rma_case_tobacco_qty, 2) }}
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            @endif
            @if ($loop->last)
                <div style="padding-left: 1rem; margin-top: 1rem;">
                    หมายเหตุรายการ : 
                    @if(count($getRMA) > 0)
                    เลขที่ใบลดหนี้ {{ ($getRMA->pluck('credit_note_number')->join(',')) }}
                    @endif
                    {{ $remark }} 
                    
                </div>
                <div>
                    <div class="inline-block" style="width: 22%">
                        <div>
                        </div>
                    </div>
                    <div class="inline-block text-center" style="width: 55%">
                        จบรายงาน 
                    </div>
                    <div class="inline-block text-right" style="width: 22%">
                        <div>
                        </div>
                    </div>
                </div>
                {{-- <div style="margin-top: 2rem;">
                    <div class="inline-block" style="width: 22%">
                        <div>
                        </div>
                    </div>
                    <div class="inline-block text-center" style="width: 44%">
                    </div>
                    <div class="inline-block text-right" style="width: 33%">
                        <div class="b">
                            ผู้จัดทำ __________________________________________
                        </div>
                    </div>
                </div> --}}

                <div style="margin-top: 2rem;">
                    <div class="inline-block" style="width: 5%">
                        <div>
                        </div>
                    </div>
                    <div class="inline-block text-center" style="width: 44%">
                    </div>
                    <div class="inline-block text-right" style="width: 33%">
                        <div class="b">
                            หัวหน้าส่วนงาน __________________________________________
                        </div>
                    </div>
                </div>
                {{-- <div>
                    <div class="inline-block" style="width: 22%">
                        <div>
                        </div>
                    </div>
                    <div class="inline-block text-center" style="width: 55%">
                        ผู้จัดทำ __________________________________________ 
                    </div>
                    <div class="inline-block text-right" style="width: 22%">
                        <div>
                        </div>
                    </div>
                </div> --}}
                <div style="margin-top: 2rem;">
                    <div class="inline-block" style="width: 5%">
                        <div>
                        </div>
                    </div>
                    <div class="inline-block text-center" style="width: 44%">
                        <div class="b">
                            ผู้จัดทำ __________________________________________
                        </div>
                    </div>
                    <div class="inline-block text-right" style="width: 33%">
                        <div class="b">
                            หัวหน้ากองบริหารขาย __________________________________________
                        </div>
                    </div>
                </div>
            @endif

            <div class="page-break"></div>

        @endforeach
    </body>
</html>