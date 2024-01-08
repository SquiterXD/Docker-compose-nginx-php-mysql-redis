<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OMR0066 รายงานคุมภาษีขาย ต่างประเทศ</title>
    <style>
        @font-face {
           font-family: 'THSarabunNew';
           font-style: normal;
           font-weight: normal;
           src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
       }

       @font-face {
           font-family: 'THSarabunNew';
           font-style: normal;
           font-weight: bold;
           src: url("{{ base_path() }}/public/fonts/THSarabunNew Bold.ttf") format("truetype");
       }

       @font-face {
           font-family: 'THSarabunNew';
           font-style: italic;
           font-weight: normal;
           src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
       }
       
       @font-face {
           font-family: 'THSarabunNew';
           font-style: italic;
           font-weight: bold;
           src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
       }
       body {
           font-family: 'THSarabunNew'
       }
       thead{display: table-header-group;}
       tfoot {display: table-row-group;}
       tr {page-break-inside: avoid;}
       
       .border-tom-bottom {
           border-top: 1px solid #000;
           border-bottom: 1px solid #000;
       }

       table {
           border-collapse: collapse;
       }

       td,
       th {
           padding: 3px;
       }

       div.page {
           page-break-after: always;
           page-break-inside: avoid;
       }
       thead table * {
           padding: 0;
           margin:0;
       }
   </style>
</head>
<body>
    @foreach($results as $group)
        @if(!$loop->first)
        <div class="page">
        </div>
        @endif
        @foreach ($group->groupBy('doc_type') as $result)
        @if(!$loop->first)
        <div class="page">
        </div>
        @endif
        <table style="width:100%">
            <thead>
                <tr>
                    <td colspan="6" style="">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%;    vertical-align: top;" >โปรแกรม : OMR0066
                                <br>
                                สั่งพิมพ์ : {{ auth()->user()->username }}
                                </td>
                                <td align="center" style="vertical-align: top;">การยาสูบแห่งประเทศไทย (สำนักงานใหญ่) <br>
                                    รายงานทะเบียนคุมภาษีขาย <br>
                                    อัตรา 
                                    @if($result->first()->vat_type == "SVAT-G7")
                                    7%
                                    @elseif($result->first()->vat_type == "SVAT-G0")
                                    0%
                                    @else 
                                    -
                                    @endif
                                    : {{ $result->first()->product_type_desc }}<br>
                                    ตั้งแต่วันที่
                                    {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_start)->addYears('543')->format('d/m/Y') }}
                                    ถึง วันที่
                                    {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_end)->addYears('543')->format('d/m/Y') }}
                                </td>
                                <td style="width:20%;vertical-align: top;" align="right">วันที่ : {{ now()->addYears('543')->format('d/m/Y') }} <br>
                                    เวลา : {{ now()->addYears('543')->format('H:i') }} <br>
                                    หน้า : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- <tr>
                    <td colspan="5" style=" ">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%"></td>
                                <td align="center">รายงานทะเบียนคุมภาษีขาย
                                    <br>
                                    ({{($result->first()->product_type_desc)}} อัตรา {{ $result->first()->percentage_rate }}%)
                                </td>
                                <td style="width:20%">เวลา : {{ now()->addYears('543')->format('H:i') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="5" style=" ">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%"></td>
                                <td align="center">
                                    ตั้งแต่วันที่
                                    {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_start)->addYears('543')->format('d/m/Y') }}
                                    ถึง วันที่
                                    {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_end)->addYears('543')->format('d/m/Y') }}
                                </td>
                                <td style="width:20%">หน้า : </td>
                            </tr>
                        </table>
                    </td>
                </tr> --}}

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

                <tr>
                    <td colspan="6">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">เลขประจำตัวผู้เสียภาษี : {{ $tax_payer_id->tax_payer_id }}</td>
                                <td align="center">
                                </td>
                                <td style="width:20%"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th style="border-top:1px solid #000;border-bottom:1px solid #000;">ใบกำกับภาษี/ <br>ใบเสร็จรับเงิน</th>
                    <th style="border-top:1px solid #000;border-bottom:1px solid #000;">วันที่</th>
                    <th style="border-top:1px solid #000;border-bottom:1px solid #000;">ชื่อลูกค้า</th>
                    {{-- <th style="border-top:1px solid #000;border-bottom:1px solid #000;">จำนวน</th> --}}
                    <th style="border-top:1px solid #000;border-bottom:1px solid #000;">มูลค่าสินค้า</th>
                    <th style="border-top:1px solid #000;border-bottom:1px solid #000;">ภาษีมูลค่าเพิ่ม</th>
                    <th style="border-top:1px solid #000;border-bottom:1px solid #000;">จำนวนเงิน</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $sumary = ['approve_quantity'=> 0, 'base' => 0, 'vat' => 0, 'amount' => 0];
                @endphp
                @foreach($result->groupBy('doc') as $doc => $item)
                @php
                $sumary['approve_quantity'] += $item->first()->approve_quantity;
                $sumary['base'] += $item->sum(function($i){
                            return $i->base * $i->conversion_rate;
                        });
                $sumary['vat'] += $item->sum(function($i){
                    return $i->vat * $i->conversion_rate;
                });
                $sumary['amount'] += $item->sum(function($i){
                    return $i->amount * $i->conversion_rate;
                });
                @endphp
                <tr>
                    <td>
                        {{$doc}}
                    </td>
                    <td>
                        {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$item->first()->tax_date)->addYears(543)->format('d/m/Y')}}
                    </td>
                    <td>
                        {{-- 1 --}}
                        {{ Str::upper($item->first()->customer->customer_name) }}{{$item->first()->customer->head_office_flag == "Y" ? " (HEAD OFFICE)" : " (BRANCH NO.". Str::upper(str_replace(')','',str_replace('(','',$item->first()->customer->branch))) .")"}} <br>
                        {{-- 2 --}}
                        {{ Str::upper($item->first()->customer->address_line1)  }} {{ Str::upper($item->first()->customer->address_line2) }} {{ Str::upper($item->first()->customer->address_line3) }} {{ Str::upper($item->first()->customer->state) }} {{ Str::upper($item->first()->customer->city)  }}
                        {{ Str::upper($item->first()->customer->district) }} {{ Str::upper($item->first()->customer->province_name)  }} {{ Str::upper($item->first()->customer->postal_code) }}
                        {{-- 3 --}}
                        TAX ID NO.{{ Str::upper($item->first()->customer->tax_register_number) }}
                    </td>
                    {{-- <td style="text-align: right">
                    
                        {{number_format($item->first()->approve_quantity, 2)}}
                    </td> --}}
                    {{-- <td style="text-align: right">
                        {{number_format($item->sum(function($i){
                            return $i->base * $i->conversion_rate;
                        }), 2)}}
                    </td>
                    <td style="text-align: right">
                        {{number_format($item->sum(function($i){
                            return $i->vat * $i->conversion_rate;
                        }), 2)}}
                    </td>
                    <td style="text-align: right">
                        {{number_format($item->sum(function($i){
                            return $i->amount * $i->conversion_rate;
                        }), 2)}}
                    </td> --}}
                    <td style="text-align: right">
                        {{number_format($item->sum('convert_base'), 2)}}
                    </td>
                    <td style="text-align: right">
                        {{number_format($item->sum('convert_vat'), 2)}}
                    </td>
                    <td style="text-align: right">
                        {{number_format($item->sum('convert_amount'), 2)}}
                    </td>
                </tr>
                @endforeach
                <tr style="font-weight: bold">
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;">รวมทั้งสิ้น</td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
                    {{-- <td style="border-top:1px solid #000;border-bottom:1px solid #000; text-align:right">
                        {{number_format(@$sumary['approve_quantity'], 2)}}
                    </td> --}}
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000; text-align:right">
                        {{number_format(@$sumary['base'], 2)}}
                    </td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000; text-align:right">
                        {{number_format(@$sumary['vat'], 2)}}
                    </td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000; text-align:right">
                        {{number_format(@$sumary['amount'], 2)}}
                    </td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table style="width:100%">
                            <tr>
                                <td style="text-align: center">ผู้ตรวจทาน..............................................</td>
                                <td style="text-align: center">รับรองถูกต้อง..............................................</td>
                                <td style="text-align: center">หัวหน้าส่วนงาน..............................................</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        @endforeach
    @endforeach
</body>
</html>