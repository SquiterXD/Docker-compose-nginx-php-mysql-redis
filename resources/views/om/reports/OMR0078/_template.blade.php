<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports.OMR0078._style')
    </head>
    <body>
        @php
            $total_amount = 0;
            $total_tax = 0;
            $total_adjust = 0;
        @endphp
        @foreach ($data as $page => $items)
            <div style="margin-bottom: 0.7rem;">
                <div class="inline-block" style="width: 22%">
                    <div>
                        โปรแกรม : OMR0078
                    </div>
                    <div>
                        สั่งพิมพ์ : {{ \Auth::user()->username }}
                    </div>
                    <div style="margin-top: 0.7rem;">
                        เลขที่ประจำตัวผู้เสียภาษี : {{ $tax_payer_id }}
                    </div>
                </div>
                <div class="inline-block text-center" style="width: 55%">
                    <div>
                        การยาสูบแห่งประเทศไทย
                    </div>
                    <div>
                        สรุปรายการข้อมูลภาษีขาย สโมสร กทม. (หลังการปรับปรุง)
                    </div>
                    <div>
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
                <thead>
                    <tr style="border-bottom: 0px !important;">
                        <td colspan="2" class="text-center">
                            ทะเบียนคุมใบกำกับภาษีขาย
                        </td>
                        <td colspan="99">

                        </td>
                    </tr>
                    <tr style="border-top: 0px !important;">
                        <td class="text-center">
                            เลขที่
                        </td>
                        <td class="text-center">
                            วันที่
                        </td>
                        <td class="text-center">
                            รายการ
                        </td>
                        <td class="text-center">
                            มูลค่าสินค้าและบริการ
                        </td>
                        <td class="text-center">
                            ภาษีมูลค่าเพิ่มก่อนปรับปรุง
                        </td>
                        <td class="text-center">
                            ภาษีมูลค่าเพิ่มหลังปรับปรุง
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $key => $item)
                        @php
                            $amount = (float)($item->total_include_vat ?? 0);
                            $tax = (float)($item->vat_amount ?? 0);
                            $adjust = (float)(optional($item->adjustmentBkk)->tax_adjust_amount ?? ($item->vat_amount ?? 0));
                            $total_amount += $amount;
                            $total_tax += $tax;
                            $total_adjust += $adjust;
                        @endphp
                        <tr>
                            <td class="text-center">
                                {{ $item->consignment_no }}
                            </td>
                            <td>
                                {{ dateFormatThai($item->consignment_date) }}
                            </td>
                            <td>
                                ยอดจำหน่ายบุหรี่ ยาเส้น-สโมสร กทม.
                            </td>
                            <td class="text-right">
                                {{ number_format( $amount , 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format( $tax , 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format( $adjust , 2) }}
                            </td>
                        </tr>
                    @endforeach
                    @if($loop->last)
                        <tr style="border-top: 0.5px solid rgb(100, 100, 100);
                            border-bottom: 0.5px solid rgb(100, 100, 100);">
                            <td class="text-right" colspan="3">
                                รวม
                            </td>
                            <td class="text-right">
                                {{ number_format($total_amount, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($total_tax, 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($total_adjust, 2) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if ($loop->last)
                <div style="padding-left: 1rem; margin-top: 1rem;">
                    หมายเหตุรายการ : {{ $remark }}
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
            @endif

            <div class="page-break"></div>

        @endforeach
    </body>
</html>