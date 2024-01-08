<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        @include('om.transfer_txt_to_bank.report.pdf._style')
        <style>
            thead{display: table-header-group;}
tfoot {display: table-row-group;}
tr {page-break-inside: avoid;}
        </style>
    </head>
    <body>
        @php
            $max = 19;
            $page = ceil($data->count() / $max );
            $total_qty = 0;
            $total_amount = 0;
        @endphp
        @for ($i = 0; $i < $page; $i++)
            @php
                $show = $data->slice($i * $max , $max);
            @endphp
            <div style="margin-bottom: 1rem; font-size: 18px;">
                <div class="inline-block" style="width: 22%">
                    <div >
                        โปรแกรม : OMR0099
                    </div>
                    <div>
                        สั่งพิมพ์ : {{ \Auth::user()->username }}
                    </div>
                </div>
                <div class="inline-block text-center" style="width: 55%">
                    <div>
                        การยาสูบแห่งประเทศไทย
                    </div>
                    <div>
                        รายงานภาษี อบจ. {{ $customer_type === 'p1' ? 'ร้านค้า ป.1' : 'Modern Trade' }} ที่นำส่งธนาคาร ประจำวันที่ {{ $start_date }} ถึง {{ $end_date }}
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
                        หน้า {{ $i+1 }}
                    </div>
                </div>
            </div>
            <table class="table" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">
                            ลำดับ
                        </th>
                        <th class="text-center">
                            ร้านค้า
                        </th>
                        <th class="text-center">
                            สำนักงานพื้นที่
                        </th>
                        <th class="text-center">
                            ซอย ถนน ตำบล
                        </th>
                        <th class="text-center">
                            อำเภอ จังหวัด รหัส
                        </th>
                        <th class="text-center">
                            พันมวน
                        </th>
                        <th colspan="2" class="text-center">
                            เงินภาษี อบจ.
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($show as $index => $item)
                        @php
                            $total_qty += (float)$item['quantity'];
                            $total_amount += (float)$item['pao_tax_amount'];
                        @endphp
                        <tr>
                            <td class="text-center">
                                {{-- ลำดับ --}}
                                {{ $index+1 }}
                            </td>
                            <td>
                                {{-- ร้านค้า --}}
                                &nbsp;{{ $item['customer_name'] }}
                            </td>
                            <td>
                                {{-- สำนักงานพื้นที่ --}}
                                {{ $item['pao_account_name'] }}
                            </td>
                            <td>
                                {{-- ซอย ถนน ตำบล --}}
                                {{ $item['district'] }}
                            </td>
                            <td>
                                {{-- อำเภอ จังหวัด รหัส --}}
                                {{ $item['postal'] }}
                            </td>
                            <td class="text-right">
                                {{-- พันมวน --}}
                                {{ number_format($item['quantity'], 2) }}
                            </td>
                            <td colspan="2" class="text-right">
                                {{-- เงินภาษี อบจ. --}}
                                {{ number_format($item['pao_tax_amount'], 2) }}
                            </td>
                        </tr>
                    @endforeach
                    @if ($page == ($i+1))
                        <tr style="border: 0 !important;">
                            <td class="text-right" style="border: 0 !important;" colspan="5">
                                {{-- ลำดับ --}}
                                รวม
                            </td>
                            <td class="text-right" style="border-bottom: 4px double black !important; border-top: 0 !important; border-left: 0 !important; border-right: 0 !important;">
                                {{-- พันมวน --}}
                                {{ number_format($total_qty, 2) }}
                            </td>
                            <td class="text-right" style="border: 0 !important;"></td>
                            <td class="text-right" style="border-bottom: 4px double black !important; border-top: 0 !important; border-left: 0 !important; border-right: 0 !important;">
                                {{-- เงินภาษี อบจ. --}}
                                {{ number_format($total_amount, 2) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="page-break"></div>
        @endfor
    </body>
</html>