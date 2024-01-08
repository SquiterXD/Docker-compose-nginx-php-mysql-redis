<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>OMR0020 - รายงานค่าขนส่งยาเส้นรายร้านค้า</title>
    <link rel="stylesheet" href="{{ public_path('css/omp0040/style-landscape.css') }}">
    {{--  <link rel="stylesheet" href="{{ asset('css/omp0040/style-landscape.css') }}">  --}}

    <style>
        .table-list tr.header td {padding:12px 0;}
        .table-list tr.header-top td {padding:10px 0 8px 0;}
        .table-list tr.header-bottom td {padding: 2px 0 10px 0;}
        .table-list tr.header td {padding: 12px 6px;}
        .table-list tr.list td {padding: 6px 6px;}
        .table-list tr.footer td {padding: 12px 6px;}

        .table-footer {width: 100%;margin-top: 2rem;}
        .table-footer tr td {padding: 12px 4px;}
        .table-signature {width: 400px;margin-left:auto;margin-right:auto;margin-top: 1rem;}
        .table-signature tr td {padding: 6px 0px;}
        .page {
            page-break-after: always;
        }
        .fit {
            white-space: nowrap;
            width:1%;
        }
        .space {
            padding-right: 0px;
            padding-left: 15px;
        }
        .list-total td {
            border-bottom: 1px dotted #000 !important; 
            border-top: 1px dotted #000 !important; 
        }
    </style>
</head>
<body class="font-thsarabun" style="padding:12px;">
    @php
        $page_no = 0;
        $tsum1 = 0;
        $tsum2 = 0;
        $tsum3 = 0;
        $tsum4 = 0;
        $countarray = count($new_data_3);
        $round = 0;
    @endphp
    @foreach ($new_data_3 as $k => $data_chunk)
    @php
        $round++;
        $key_number = 0;
    @endphp
        @php
            $data = $data_chunk->chunk(20);
            // $data = array_chunk($data_chunk,20);
        @endphp
        
        @php
        $sum1 = 0;
        $sum2 = 0;
        $sum3 = 0;
        $sum4 = 0;
    @endphp
        @foreach ($data as $data)
        @php
            $page_no++;
        @endphp
            <table style="width: 100%;border-collapse: collapse;" @if(count($data) == 20) class="page" @endif>
                <tr>
                    <td style="vertical-align: top;width:300px;white-space:nowrap;" colspan="2">
                        <table>
                            <tr>
                                <td>โปรแกรม : </td>
                                <td>OMR0020_3 </td>
                            </tr>
                            <tr>
                                <td>สั่งพิมพ์ : </td>
                                <td>{{ getDefaultData('/users')->fnd_user_name }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="text-center" style="vertical-align: top;" colspan="8">
                        <table style="width: 100%;">
                            <tr>
                                <td class="text-center">การยาสูบแห่งประเทศไทย</td>
                            </tr>
                            <tr>
                                <td class="text-center">รายงานค่าขนส่งยาเส้นรายร้านค้า : {{ @$data->first()['product_type_code']}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">วันที่ {{ request()->start }} ถึงวันที่  {{ request()->end }} </td>
                            </tr>
                        </table>
                    </td> <!-- -->
                    <td style="vertical-align: top;width:200px;" colspan="2">
                        <table>
                            <tr>
                                <td>วันที่</td>
                                <td>:</td>
                                <td>{{ FormatDate::DateThaiNumericWithSplash(date('Y-m-d')) }}</td>
                            </tr>
                            <tr>
                                <td>เวลา</td>
                                <td>:</td>
                                <td>{{ date('H:i') }}</td>
                            </tr>
                            <tr>
                                <td>หน้า</td>
                                <td>:</td>
                                <td>{{ $page_no }}</td>
                            </tr>
                        </table>
                    </td> <!-- -->
                </tr>

                <tr>
                    <td colspan="6">สาย {{ $k }}</td>
                    <td colspan="6" style="text-align: right">{{ $data->first()['invoice_batch'] }}</td>
                </tr>

                <tr class="header">
                    <td class="text-center bb bt fit" rowspan="2">ลำดับ</td>
                    <td class="text-center bb bt fit" rowspan="2">วันที่</td>
                    <td class="text-center bb bt fit" rowspan="2">เลขที่</td>
                    <td class="text-center bb bt" rowspan="2" width="20%">ชื่อร้าน</td>
                    <td class="text-center bb bt fit" rowspan="2">ตลาด</td>
                    <td class="text-right bb bt" rowspan="2" width="10%">พันมวน</td>
                    <td class="text-center bt" colspan="2" style="width: 100px;" width="10%">คิดเป็นหีบ/ห่อ</td>
                    <td class="text-center bt" colspan="2" style="width: 100px;" width="10%">อัตรา</td>
                    <td class="text-right bb bt" rowspan="2" width="10%">จำนวนเงิน</td>
                    <td class="text-right bb bt" rowspan="2" style="width: 100px;" width="10%"></td>
                </tr>

                <tr class="header">
                    <td class="text-center bb bt" width="5%">หีบ</td>
                    <td class="text-center bb bt" width="5%">ห่อ</td>
                    <td class="text-center bb bt" width="5%">หีบ</td>
                    <td class="text-center bb bt" width="5%">ห่อ</td>
                </tr>
          

           
                @foreach ($data as $key => $d)
                @php
                    $key_number++;
                @endphp
                    <tr class="list">
                        <td class="text-center">{{ $key_number }}</td>
                        <td class="text-center">{{ FormatDate::DateThaiNumericWithSplash($d['doc_ref_date']) }}</td>
                        <td class="text-center">{{ $d['doc_ref_code'] }}</td>
                        <td class="text-left space" style="white-space: nowrap;">{{ $d['customer_name'] }}</td>
                        <td class="text-left space" style="white-space: nowrap;">{{ $d['province_name'] }}</td>
                        {{-- <td class="text-right">{{ number_format($d['sum_apv_cardbroadbox_qty'],1) }}</td> --}}
                        <td class="text-right"></td>
                        <td class="text-center space">{{ number_format($d['apv_cardbroadbox_qty'],1) }}</td>
                        <td class="text-center space">{{ number_format($d['apv_carton_qty'],1) }}</td>
                        {{-- <td class="text-left">{{ $d['cigarette_delivery_rates'] }}</td>
                        <td class="text-left">{{ $d['cigarette_delivery_rates2'] }}</td> --}}
                        <td class="text-left space">{{ $d['leaf_delivery_rates'] }}</td>
                        <td class="text-left space">{{ $d['leaf_delivery_rates2'] }}</td>
                        <td class="text-righ space" style="text-align: right">{{ number_format($d['carfare_apv_amount'],6) }}</td>
                        <td class="text-right"></td>
                    </tr>
                    @php
                        $sum1 += $d['sum_apv_cardbroadbox_qty'];
                        $sum2 += $d['apv_cardbroadbox_qty'];
                        $sum3 += $d['apv_carton_qty'];
                        $sum4 += $d['carfare_apv_amount'];
                    @endphp
                @endforeach
                @if($loop->last)
                <tr class="list  list-total">
                    <td class="text-right" colspan="5">รวมภาค</td>
                    <td class="text-right" width="10%"></td>
                    <td class="text-center" width="5%">{{ number_format($sum2,1) }}</td>
                    <td class="text-center" width="5%">{{ number_format($sum3,1) }}</td>
                    <td width="5%"></td>
                    <td width="5%"></td>
                    <td class="text-right" width="10%">{{ number_format($sum4,6) }}</td>
                    <td class="text-right" width="7.9%">{{ number_format($sum4,2) }}</td>
                </tr>
                @endif
                @if(!$loop->last)
                    </table>
                @endif
        @endforeach
        @php
            $tsum1 += $sum1;
            $tsum2 += $sum2;
            $tsum3 += $sum3;
            $tsum4 += $sum4;
        @endphp
       
            @if(!empty($new_data_3) && $round == $countarray)
            <tr class="list">
                <td class="text-right" colspan="5">รวมทุกภาค</td>
                <td class="text-right" width="10%"></td>
                {{-- <td class="text-right" width="10%">{{ number_format($tsum1,1) }}</td> --}}
                <td class="text-center" width="5%">{{ number_format($tsum2,1) }}</td>
                <td class="text-center" width="5%">{{ number_format($tsum3,1) }}</td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td class="text-right" width="10%">{{ number_format($tsum4,6) }}</td>
                <td class="text-right" width="7.9%">{{ number_format($tsum4,2) }}</td>
            </tr>
            @endif
       
    </table>
    @if($round != $countarray)
    <div style='page-break-after: always;'></div>
    @endif
    @endforeach
</body>
</html>
