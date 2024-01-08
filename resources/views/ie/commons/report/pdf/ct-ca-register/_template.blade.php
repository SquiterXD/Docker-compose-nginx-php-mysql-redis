<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ie.commons.report.pdf.ct-ca-register._style')
    </head>
    <body>
        @php
            $cal = null;
            $count_month = 0;
            $sum_total_amount = 0;
            $sum_total_month1 = 0;
            $sum_total_month2 = 0;
            $sum_total_month3 = 0;
            $sum_total_over = 0;
            $sum_amount = 0;
            $sum_month1 = 0;
            $sum_month2 = 0;
            $sum_month3 = 0;
            $sum_over = 0;
            $searchRangeDate = $startSearchDate->format('j')
                                .' '.$txtMonth[$startSearchDate->format('n')]
                                .' '.((int)($startSearchDate->format('Y'))+543)
                                .' - '.$endSearchDate->format('j')
                                .' '.$txtMonth[$endSearchDate->format('n')]
                                .' '.((int)($endSearchDate->format('Y'))+543);
        @endphp
        @foreach ($data as $page => $groupMonth)
            <div style="margin-bottom: 1rem; font-size: 17px; font-weight: bold;">
                <div class="inline-block" style="width: 33%;">
                    <div>

                    </div>
                </div>
                <div class="inline-block text-center" style="width: 33%;">
                    <div>
                        การยาสูบแห่งประเทศไทย
                    </div>
                    <div>
                        ทะเบียนคุมเงินทดรองส่วนกลาง (ในประเทศ)
                    </div>
                    <div>
                        สำหรับวันที่ {{ $searchRangeDate }}
                    </div>
                </div>
                <div class="inline-block text-right" style="width: 33%;">
                    <div>

                    </div>
                </div>
            </div>
            <table width="100%">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center" width="5.5%">
                            เลขที่เอกสาร
                        </th>
                        <th rowspan="2" class="text-center" width="5%">
                            เลขที่ใบยืม
                        </th>
                        <th rowspan="2" class="text-center" width="5%">
                            วันที่ยืม
                        </th>
                        <th rowspan="2" class="text-center" width="11%">
                            ชื่อผู้ยืม
                        </th>
                        <th rowspan="2" class="text-center" width="13%">
                            หน่วยงาน
                        </th>
                        <th rowspan="2" class="text-center">
                            คำอธิบาย
                        </th>
                        <th rowspan="2" class="text-center" width="6.5%">
                            จำนวนเงินยืม
                        </th>
                        <th colspan="3" class="text-center" width="19.5%">
                            วันที่เคลียร์
                        </th>
                        <th colspan="2" class="text-center" width="12%">
                            หมายเหตุ
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center" width="7%">
                            {{ $shortTxtMonth[$startMonth] }}
                        </th>
                        <th class="text-center" width="7%">
                            {{ (int)$startMonth+1 > 12 ? $shortTxtMonth[(((int)$startMonth)+1)%12] : $shortTxtMonth[((int)$startMonth)+1] }}
                        </th>
                        <th class="text-center" width="7%">
                            {{ (int)$startMonth+2 > 12 ? $shortTxtMonth[(((int)$startMonth)+2)%12] : $shortTxtMonth[((int)$startMonth)+2] }}
                        </th>
                        <th class="text-center" width="7%">
                            ยอดค้าง
                        </th>
                        <th class="text-center">
                            วันที่เคลียร์
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupMonth as $monthYear => $lines)
                        @foreach ($lines as $ca)
                            @php
                                $count_month++;
                                $sum_total_amount += $ca->amount;
                                $sum_amount += $ca->amount;
                                $cashAdvance = $ca->interfaces->where('request_from', 'CASH-ADVANCE')->first();
                                $clear = $ca->interfaces->where('request_from', 'CLEARING')->first();
                                if(!$clear){
                                    $sum_total_over += $ca->amount;
                                    $sum_over += $ca->amount;
                                }else {
                                    $m = \Carbon\Carbon::parse($ca->clearing_gl_date)->format('n'); //$clear->creation_date->format('n');
                                    $cal = $m-$startMonth;
                                    if( $cal == 0){
                                        $sum_month1 += $clear->invoice_amount;
                                        $sum_total_month1 += $clear->invoice_amount;
                                    }else if($cal == 1){ 
                                        $sum_month2 += $clear->invoice_amount;
                                        $sum_total_month2 += $clear->invoice_amount;
                                    }else if($cal == 2) {
                                        $sum_month3 += $clear->invoice_amount;
                                        $sum_total_month3 += $clear->invoice_amount;
                                    }
                                }
                            @endphp
                            <tr>
                                <td class="text-center">
                                    {{-- เลขที่เอกสาร --}}
                                    {{ $ca->document_no }}
                                </td>
                                <td class="text-center">
                                    {{-- เลขที่ใบยืม --}}
                                    {{ $ca->invoice_no }}
                                </td>
                                <td class="text-center">
                                    {{-- วันที่ยืม --}}
                                    {{ $ca ? \Carbon\Carbon::parse($ca->request_date)->format('j-M-y') : '' }}
                                </td>
                                <td>
                                    {{-- ชื่อผู้ยืม --}}
                                    {{ $ca->account_name }}
                                </td>
                                <td>
                                    {{-- หน่วยงาน --}}
                                    {{ $ca->department ? $ca->department->description : '' }}
                                </td>
                                <td>
                                    {{-- คำอธิบาย --}}
                                    {{ $ca->reason }}
                                </td>
                                <td class="text-right">
                                    {{-- จำนวนเงินยืม --}}
                                    {{ numberFormatDisplay($ca->amount) }}
                                </td>
                                <td class="text-right">
                                    {{-- ต.ค. --}}
                                    {{ $cal == 0 && $clear ? numberFormatDisplay($clear->invoice_amount) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- พ.ย. --}}
                                    {{ $cal == 1 && $clear ? numberFormatDisplay($clear->invoice_amount) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- ธ.ค. --}}
                                    {{ $cal == 2 && $clear ? numberFormatDisplay($clear->invoice_amount) : '' }}
                                </td>
                                <td class="text-right">
                                    {{-- ยอดค้าง --}}
                                    {{ !!$clear ? '' : numberFormatDisplay($ca->amount) }}
                                </td>
                                <td class="text-center">
                                    {{-- วันที่เคลียร์ --}}
                                    {{ !!$clear ? '' : date('j-M-y', strtotime($ca->clearing_gl_date ?? $ca->finish_date)) }}
                                </td>
                            </tr>
                        @endforeach
                        @php
                            $arr = explode('-', $monthYear);
                            $monthNo = $arr[0];
                            $yearNo = $arr[1];
                        @endphp
                        @if ($count_month == $countInMonth[$monthYear])
                            <tr>
                                <td colspan="6" class="text-right">
                                    <b>
                                        เงินยืมทดรองเดือน {{ $txtMonth[$monthNo] }} {{ (int)($yearNo)+543 }}
                                    </b>
                                </td>
                                <td class="text-right">
                                    {{-- จำนวนเงินยืม --}}
                                    <b>
                                        {{ numberFormatDisplay($sum_amount) }}
                                    </b>
                                </td>
                                <td class="text-right">
                                    {{-- ม.ค. --}}
                                    <b>
                                        {{ $sum_month1 ? numberFormatDisplay($sum_month1) : '-' }}
                                    </b>
                                </td>
                                <td class="text-right">
                                    {{-- ก.พ. --}}
                                    <b>
                                        {{ $sum_month2 ? numberFormatDisplay($sum_month2) : '-' }}
                                    </b>
                                </td>
                                <td class="text-right">
                                    {{-- มี.ค. --}}
                                    <b>
                                        {{ $sum_month3 ? numberFormatDisplay($sum_month3) : '-' }}
                                    </b>
                                </td>
                                <td class="text-right">
                                    {{-- ยอดค้าง --}}
                                    <b>
                                        {{ $sum_over ? numberFormatDisplay($sum_over) : '-' }}
                                    </b>
                                </td>
                                <td class="text-center">
                                    {{-- วันที่เคลียร์ --}}
                                </td>
                            </tr>
                            @php
                                $sum_amount = 0;
                                $sum_month1 = 0;
                                $sum_month2 = 0;
                                $sum_month3 = 0;
                                $sum_over = 0;
                                $count_month = 0;
                            @endphp
                        @endif
                    @endforeach
                    @if ($loop->last)
                        <tr>
                            <td colspan="6" class="text-right">
                                <b>
                                    รวมเงินยืมทดรองวันที่ {{ $searchRangeDate }}
                                </b>
                            </td>
                            <td class="text-right">
                                {{-- จำนวนเงินยืม --}}
                                <b>
                                    {{ numberFormatDisplay($sum_total_amount) }}
                                </b>
                            </td>
                            <td class="text-right">
                                {{-- ม.ค. --}}
                                <b>
                                    {{ $sum_total_month1 ? numberFormatDisplay($sum_total_month1) : '-'  }}
                                </b>
                            </td>
                            <td class="text-right">
                                {{-- ก.พ. --}}
                                <b>
                                    {{ $sum_total_month2 ? numberFormatDisplay($sum_total_month2) : '-'  }}
                                </b>
                            </td>
                            <td class="text-right">
                                {{-- มี.ค. --}}
                                <b>
                                    {{ $sum_total_month3 ? numberFormatDisplay($sum_total_month3) : '-'  }}
                                </b>
                            </td>
                            <td class="text-right">
                                {{-- ยอดค้าง --}}
                                <b>
                                    {{ $sum_total_over ? numberFormatDisplay($sum_total_over) : '-' }}
                                </b>
                            </td>
                            <td class="text-center">
                                {{-- วันที่เคลียร์ --}}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="page-break"></div>

        @endforeach
    </body>
</html>