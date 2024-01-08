<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-param" content="_token">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>จ่ายยาสูบจากใบเตรียมการขาย @if (!empty($number))
            {{ $number[0]->issue_number }} @endif
    </title>
    <link rel="stylesheet" href="{{ public_path('css/omp0040/style-landscape.css') }}">
    <style>
        table,
        tr,
        td,
        th,
        tbody,
        thead,
        tfoot {
            page-break-inside: avoid !important;
        }

        .table-list tr.header td {
            padding: 12px 0;
            border-collapse: collapse
        }

        .table-list tr.header-top td {
            padding: 10px 0 8px 0;
        }

        .table-list tr.header-bottom td {
            padding: 2px 0 10px 0;
        }

        .table-list tr.header td {
            padding: 12px 6px;
        }

        .table-list tr.list td {
            padding: 6px 6px;
        }

        .table-list tr.footer td {
            padding: 12px 6px;
        }

        .table-footer {
            width: 100%;
            margin-top: 2rem;
        }

        .table-footer tr td {
            padding: 12px 4px;
        }

        .table-signature {
            width: 400px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 1rem;
        }

        .table-signature tr td {
            padding: 6px 0px;
        }

        /* table {
            table-layout:auto;
            width: 100%;
        } */
        /* td {
            width: 60px;
        } */
    </style>
</head>

<body class="font-cordia">
    <?php
    $sumall[0] = 0;
    $sum1 = 0;
    $sum2 = 0;
    $sum3 = 0;
    $sum4 = 0;
    $page_no = 0;
    $order_header_id_1 = [];
    for ($i = 1; $i <= count($array_sequences); $i++) {
        $sumall[$i] = 0;
    }
    $new_querys = array_chunk($querys, 3);
    ?>
            <div style='page-break-after: always;'></div>
            <table style="width: 100%;" cellspacing="0" class="table-list" style="border: 1px solid black;">
        @empty($new_querys)
            @php
                $page_no++;
            @endphp

            <tr>
                <td colspan="{{ count($array_sequences) + 3 }}">
                    <table style="width: 100%;">
                        <tr>
                            <td style="vertical-align: top;width:350px;">
                                <table>
                                    <tr>
                                        <td>โปรแกรม : </td>
                                        <td>OMR0012</td>
                                    </tr>
                                    <tr>
                                        <td>สั่งพิมพ์ : </td>
                                        <td>{{ getDefaultData('/users')->fnd_user_name }}</td>
                                    </tr>
                                </table>
                            </td><!-- -->
                            <td class="text-center" style="vertical-align: top;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td class="text-center">การยาสูบแห่งประเทศไทย</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if (!empty($number))
                                                {{ $number[0]->issue_number }} @endif
                                        </td>
                                    </tr>
                                </table>
                            </td> <!-- -->
                            <td style="vertical-align: top;width:200px;">
                                <table>
                                    <tr>
                                        <td>วันที่</td>
                                        <td>:</td>
                                        <td>
                                            @if (!empty($number))
                                                {{ FormatDate::DateThaiNumericWithSplash($number[0]->issue_date) }}
                                            @else
                                                {{ FormatDate::DateThaiNumericWithSplash(date('Y-m-d')) }} @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>เวลา</td>
                                        <td>:</td>
                                        <td>
                                            @if (!empty($number))
                                                {{ \Carbon\Carbon::parse($number[0]->issue_date)->format('H:i') }}
                                            @else
                                                {{ date('H:i') }} @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>หน่วย</td>
                                        <td>:</td>
                                        <td>พันมวน/บุหรี่ หีบ/ยาเส้น</td>
                                    </tr>
                                    <tr>
                                        <td>หน้า</td>
                                        <td>:</td>
                                        <td>{{ $page_no }}</td>
                                        {{-- <td><span class="page"></span></td> --}}
                                    </tr>
                                </table>
                            </td> <!-- -->
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="header">
                <td class="text-center bb bt" style="width: 100px;border: 1px solid black;">เลขที่ใบเตรียม</td>
                <td class="text-center bb bt" style="width: 130px;border: 1px solid black;">ชื่อร้านค้า</td>
                @foreach ($array_sequences as $s)
                    <td class="text-center bb bt" style="border: 1px solid black;width: 60px !important;">
                        {{ $s[1] }}</td>
                @endforeach
                <td class="text-center bb bt" style="border: 1px solid black;">ยอดรวมบุหรี่(พันมวน)</td>
            </tr>

            <tr class="list" style="border: 1px solid black;">
                <td colspan="{{ count($array_sequences) + 3 }}" style="background-color:#FCD528;border: 1px solid black;">
                    <b>รายการส่งเสริมการตลาด</b></td>
            </tr>
        </table>
    @else
       
        @foreach ($new_querys as $query)
            @php
                $page_no++;
            @endphp
            <div style='page-break-after: always;'></div>
            <table style="width: 100%;" cellspacing="0" class="table-list" style="border: 1px solid black;">
                <tr>
                    <td colspan="{{ count($array_sequences) + 3 }}">
                        <table style="width: 100%;">
                            <tr>
                                <td style="vertical-align: top;width:350px;">
                                    <table>
                                        <tr>
                                            <td>โปรแกรม : </td>
                                            <td>OMR0012</td>
                                        </tr>
                                        <tr>
                                            <td>สั่งพิมพ์ : </td>
                                            <td>{{ getDefaultData('/users')->fnd_user_name }}</td>
                                        </tr>
                                    </table>
                                </td><!-- -->
                                <td class="text-center" style="vertical-align: top;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td class="text-center">การยาสูบแห่งประเทศไทย</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                @if (!empty($number))
                                                    {{ $number[0]->issue_number }}
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td> <!-- -->
                                <td style="vertical-align: top;width:200px;">
                                    <table>
                                        <tr>
                                            <td>วันที่</td>
                                            <td>:</td>
                                            <td>
                                                @if (!empty($number))
                                                    {{ FormatDate::DateThaiNumericWithSplash($number[0]->issue_date) }}
                                                @else
                                                    {{ FormatDate::DateThaiNumericWithSplash(date('Y-m-d')) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>เวลา</td>
                                            <td>:</td>
                                            <td>
                                                @if (!empty($number))
                                                    {{ \Carbon\Carbon::parse($number[0]->issue_date)->format('H:i') }}
                                                @else
                                                    {{ date('H:i') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>หน่วย</td>
                                            <td>:</td>
                                            <td>พันมวน/บุหรี่ หีบ/ยาเส้น</td>
                                        </tr>
                                        <tr>
                                            <td>หน้า</td>
                                            <td>:</td>
                                            <td>{{ $page_no }}</td>
                                            {{-- <td><span class="page"></span></td> --}}
                                        </tr>
                                    </table>
                                </td> <!-- -->
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="header">
                    <td class="text-center bb bt" style="width: 100px;border: 1px solid black;">เลขที่ใบเตรียม</td>
                    <td class="text-center bb bt" style="width: 130px;border: 1px solid black;">ชื่อร้านค้า</td>
                    @foreach ($array_sequences as $s)
                        <td class="text-center bb bt" style="border: 1px solid black;width: 60px !important;">
                            {{ $s[1] }}</td>
                    @endforeach
                    <td class="text-center bb bt" style="border: 1px solid black;">ยอดรวมบุหรี่(พันมวน)</td>
                </tr>
                @foreach ($query as $q)
                    @if ($q->promo_flag != 'Y')
                        <?php $sum = 0;
                        array_push($order_header_id_1, $q->order_header_id); ?>
                        <tr class="list" style="border: 1px solid black;">
                            <td class="text-center" style="border: 1px solid black;">{{ $q->prepare_order_number }}</td>
                            <td style="border: 1px solid black;">{{ $q->customer_name }}</td>
                            @foreach ($array_sequences as $key => $s)
                                {{-- <td style="border: 1px solid black;width: 60px !important;">{{ getitemtoreportomp0040(trim((float)$s[0]),$q->order_header_id) }}</td> --}}
                                <td style="border: 1px solid black;width: 60px !important;">
                                    {{ number_format((float) getitemtoreportomp0040(trim((float) $s[0]), $q->order_header_id), 2) }}
                                </td>
                                <?php $k = $key + 1;
                                $sum += getitemtoreportomp0040sum(trim((float) $s[0]), $q->order_header_id);
                                $sumall[$k] += getitemtoreportomp0040sum(trim((float) $s[0]), $q->order_header_id); ?>
                            @endforeach
                            <td style="border: 1px solid black;">{{ number_format($sum, 2) }}</td>
                            <?php $sumall[0] += $sum; ?>
                        </tr>
                    @endif
                @endforeach

                <tr class="list" style="border: 1px solid black;">
                    <td colspan="{{ count($array_sequences) + 3 }}"
                        style="background-color:#FCD528;border: 1px solid black;"><b>รายการส่งเสริมการตลาด</b></td>
                </tr>

                @foreach ($query as $q)
                    @if ($q->promo_flag == 'Y')
                        <?php $sum = 0; ?>
                        <tr class="list" style="border: 1px solid black;">
                            <td class="text-center" style="border: 1px solid black;">{{ $q->prepare_order_number }}</td>
                            <td style="border: 1px solid black;">{{ $q->customer_name }}</td>
                            @foreach ($array_sequences as $key => $s)
                                <td style="border: 1px solid black;width: 60px !important;">
                                    {{ getitemtoreportomp0040($s[0], $q->order_header_id, true) }}</td>
                                <?php $k = $key + 1;
                                $sum += getitemtoreportomp0040sum($s[0], $q->order_header_id, true);
                                $sumall[$k] += getitemtoreportomp0040sum($s[0], $q->order_header_id, true); ?>
                            @endforeach
                            <td style="border: 1px solid black;">{{ number_format($sum, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
        @endforeach
        @endif

        {{-- @if (count($new_querys) == 0) --}}
            <div style='page-break-after: always;'></div>
            <table style="width: 100%;" cellspacing="0" class="table-list" style="border: 1px solid black;">
        {{-- @endif --}}
        <tr class="list" style="background-color:#C7C5B7;border: 1px solid black;">
            <td class="text-left" colspan="2" style="border: 1px solid black;">รวมทั้งสิ้น</td>
            <?php
                        for($i = 1; $i <= count($array_sequences); $i++){
                        ?>
            <td style="border: 1px solid black;width: 60px !important;">{{ number_format($sumall[$i], 2) }}</td>
            <?php
                        }
                        ?>
            <td style="border: 1px solid black;">{{ number_format($sumall[0], 2) }}</td>
        </tr>

        <tr class="list" style="background-color:#C7C5B7;border: 1px solid black;">
            <td rowspan="2" class="text-center" style="border: 1px solid black;">รวมทั้งสิ้น</td>
            <td class="text-center" style="border: 1px solid black;">จำนวนหีบ และ</td>
            @foreach ($array_sequences as $key => $s)
                <td style="border: 1px solid black;width: 60px !important;">
                    {{ number_format(getapprovecardboardbox($s[0], $order_header_id_1), 2) }}</td>
                <?php $sum1 += getapprovecardboardbox($s[0], $order_header_id_1); ?>
            @endforeach
            <td style="border: 1px solid black;">{{ number_format($sum1, 2) }}</td>
        </tr>
        <tr class="list" style="background-color:#C7C5B7;border: 1px solid black;">
            <td class="text-center" style="border: 1px solid black;">จำนวนห่อ</td>
            @foreach ($array_sequences as $key => $s)
                <td style="border: 1px solid black;width: 60px !important;">
                    {{ number_format(getapprovecarton($s[0], $order_header_id_1), 2) }}</td>
                <?php $sum2 += getapprovecarton($s[0], $order_header_id_1); ?>
            @endforeach
            <td style="border: 1px solid black;">{{ number_format($sum2, 2) }}</td>
        </tr>

        <tr class="list" style="background-color:#C7C5B7;border: 1px solid black;">
            <td rowspan="2" class="text-center" style="border: 1px solid black;">รวมรายการส่งเสริมการตลาด</td>
            <td class="text-center" style="border: 1px solid black;">จำนวนหีบ และ</td>
            @foreach ($array_sequences as $key => $s)
                <td style="border: 1px solid black;width: 60px !important;">
                    {{ number_format(getapprovecardboardbox($s[0], $order_header_id_1, true), 2) }}</td>
                <?php $sum3 += getapprovecardboardbox($s[0], $order_header_id_1, true); ?>
            @endforeach
            <td style="border: 1px solid black;">{{ number_format($sum3, 2) }}</td>
        </tr>
        <tr class="list" style="background-color:#C7C5B7;border: 1px solid black;">
            <td class="text-center" style="border: 1px solid black;">จำนวนห่อ</td>
            @foreach ($array_sequences as $key => $s)
                <td style="border: 1px solid black;width: 60px !important;">
                    {{ number_format(getapprovecarton($s[0], $order_header_id_1, true), 2) }}</td>
                <?php $sum4 += getapprovecarton($s[0], $order_header_id_1, true); ?>
            @endforeach
            <td style="border: 1px solid black;">{{ number_format($sum4, 2) }}</td>
        </tr>
        </table>


        <div style='page-break-after: always;'></div>


        <?php
        $sumall2[0] = 0;
        $sum12 = 0;
        $sum22 = 0;
        $sum32 = 0;
        $sum42 = 0;
        $order_header_id_2 = [];
        for ($i = 1; $i <= count($array_sequences2); $i++) {
            $sumall2[$i] = 0;
        }
        $new_querys20 = array_chunk($querys20, 3);
        ?>
            <div style='page-break-after: always;'></div>
            <table style="width: 100%;" cellspacing="0" class="table-list" style="border: 1px solid black;">
            @empty($new_querys20)
                @php
                    $page_no++;
                @endphp

                <tr>
                    <td colspan="{{ count($array_sequences2) + 3 }}">
                        <table style="width: 100%;">
                            <tr>
                                <td style="vertical-align: top;width:350px;">
                                    <table>
                                        <tr>
                                            <td>โปรแกรม : </td>
                                            <td>OMR0012</td>
                                        </tr>
                                        <tr>
                                            <td>สั่งพิมพ์ : </td>
                                            <td>{{ getDefaultData('/users')->fnd_user_name }}</td>
                                        </tr>
                                    </table>
                                </td><!-- -->
                                <td class="text-center" style="vertical-align: top;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td class="text-center">การยาสูบแห่งประเทศไทย</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                @if (!empty($number))
                                                    {{ $number[0]->issue_number }} @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td> <!-- -->
                                <td style="vertical-align: top;width:200px;">
                                    <table>
                                        <tr>
                                            <td>วันที่</td>
                                            <td>:</td>
                                            <td>
                                                @if (!empty($number))
                                                    {{ FormatDate::DateThaiNumericWithSplash($number[0]->issue_date) }}
                                                @else
                                                    {{ FormatDate::DateThaiNumericWithSplash(date('Y-m-d')) }} @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>เวลา</td>
                                            <td>:</td>
                                            <td>
                                                @if (!empty($number))
                                                    {{ \Carbon\Carbon::parse($number[0]->issue_date)->format('H:i') }}
                                                @else
                                                    {{ date('H:i') }} @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>หน่วย</td>
                                            <td>:</td>
                                            <td>พันมวน/บุหรี่ หีบ/ยาเส้น</td>
                                        </tr>
                                        <tr>
                                            <td>หน้า</td>
                                            <td>:</td>
                                            <td>{{ $page_no }}</td>
                                            {{-- <td><span class="page"></span></td> --}}
                                        </tr>
                                    </table>
                                </td> <!-- -->
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="header">
                    <td class="text-center bb bt" style="width: 100px;border: 1px solid black;">เลขที่ใบเตรียม</td>
                    <td class="text-center bb bt" style="width: 130px;border: 1px solid black;">ชื่อร้านค้า</td>
                    @foreach ($array_sequences2 as $s)
                        <td class="text-center bb bt" style="border: 1px solid black;width: 80px;">{{ $s[1] }}</td>
                    @endforeach
                    <td class="text-center bb bt" style="border: 1px solid black;">ยอดรวมยาเส้น</td>
                </tr>

                <tr class="list" style="border: 1px solid black;">
                    <td colspan="{{ count($array_sequences2) + 3 }}" style="background-color:#FCD528;border: 1px solid black;">
                        <b>รายการส่งเสริมการตลาด</b></td>
                </tr>
        </table>
            @else
                @foreach ($new_querys20 as $query)
                    @php
                        $page_no++;
                    @endphp
                <div style='page-break-after: always;'></div>
                <table style="width: 100%;" cellspacing="0" class="table-list" style="border: 1px solid black;">
                    <tr>
                        <td colspan="{{ count($array_sequences2) + 3 }}">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="vertical-align: top;width:350px;">
                                        <table>
                                            <tr>
                                                <td>โปรแกรม : </td>
                                                <td>OMR0012</td>
                                            </tr>
                                            <tr>
                                                <td>สั่งพิมพ์ : </td>
                                                <td>{{ getDefaultData('/users')->fnd_user_name }}</td>
                                            </tr>
                                        </table>
                                    </td><!-- -->
                                    <td class="text-center" style="vertical-align: top;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td class="text-center">การยาสูบแห่งประเทศไทย</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    @if (!empty($number))
                                                        {{ $number[0]->issue_number }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td> <!-- -->
                                    <td style="vertical-align: top;width:200px;">
                                        <table>
                                            <tr>
                                                <td>วันที่</td>
                                                <td>:</td>
                                                <td>
                                                    @if (!empty($number))
                                                        {{ FormatDate::DateThaiNumericWithSplash($number[0]->issue_date) }}
                                                    @else
                                                        {{ FormatDate::DateThaiNumericWithSplash(date('Y-m-d')) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>เวลา</td>
                                                <td>:</td>
                                                <td>
                                                    @if (!empty($number))
                                                        {{ \Carbon\Carbon::parse($number[0]->issue_date)->format('H:i') }}
                                                    @else
                                                        {{ date('H:i') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>หน่วย</td>
                                                <td>:</td>
                                                <td>พันมวน/บุหรี่ หีบ/ยาเส้น</td>
                                            </tr>
                                            <tr>
                                                <td>หน้า</td>
                                                <td>:</td>
                                                <td>{{ $page_no }}</td>
                                                {{-- <td><span class="page"></span></td> --}}
                                            </tr>
                                        </table>
                                    </td> <!-- -->
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="header">
                        <td class="text-center bb bt" style="width: 100px;border: 1px solid black;">เลขที่ใบเตรียม</td>
                        <td class="text-center bb bt" style="width: 130px;border: 1px solid black;">ชื่อร้านค้า</td>
                        @foreach ($array_sequences2 as $s)
                            <td class="text-center bb bt" style="border: 1px solid black;width: 80px;">{{ $s[1] }}
                            </td>
                        @endforeach
                        <td class="text-center bb bt" style="border: 1px solid black;">ยอดรวมยาเส้น</td>
                    </tr>

                    @foreach ($query as $q)
                        @if ($q->promo_flag != 'Y')
                            <?php $sum = 0;
                            array_push($order_header_id_2, $q->order_header_id); ?>
                            <tr class="list" style="border: 1px solid black;">
                                <td class="text-center" style="border: 1px solid black;">{{ $q->prepare_order_number }}</td>
                                <td style="border: 1px solid black;">{{ $q->customer_name }}</td>
                                @foreach ($array_sequences2 as $key => $s)
                                    <td style="border: 1px solid black;">
                                        {{ getitemtoreportomp0040($s[0], $q->order_header_id) }}</td>
                                    <?php $k = $key + 1;
                                    $sum += getitemtoreportomp0040sum($s[0], $q->order_header_id);
                                    $sumall2[$k] += getitemtoreportomp0040sum($s[0], $q->order_header_id); ?>
                                @endforeach
                                <td style="border: 1px solid black;">{{ number_format($sum, 2) }}</td>
                                <?php $sumall2[0] += $sum; ?>
                            </tr>
                        @endif
                    @endforeach

                    <tr class="list" style="border: 1px solid black;">
                        <td colspan="{{ count($array_sequences2) + 3 }}"
                            style="background-color:#FCD528;border: 1px solid black;"><b>รายการส่งเสริมการตลาด</b></td>
                    </tr>

                    @foreach ($query as $q)
                        @if ($q->promo_flag == 'Y')
                            <?php $sum = 0; ?>
                            <tr class="list" style="border: 1px solid black;">
                                <td class="text-center" style="border: 1px solid black;">{{ $q->prepare_order_number }}</td>
                                <td style="border: 1px solid black;">{{ $q->customer_name }}</td>
                                @foreach ($array_sequences2 as $key => $s)
                                    <td style="border: 1px solid black;">
                                        {{ getitemtoreportomp0040($s[0], $q->order_header_id, true) }}</td>
                                    <?php $k = $key + 1;
                                    $sum += getitemtoreportomp0040sum($s[0], $q->order_header_id, true);
                                    $sumall2[$k] += getitemtoreportomp0040sum($s[0], $q->order_header_id, true); ?>
                                @endforeach
                                <td style="border: 1px solid black;">{{ number_format($sum, 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
                @endif
                {{-- @if(count($new_querys20)== 0) --}}
            <div style='page-break-after: always;'></div>
            <table style="width: 100%;" cellspacing="0" class="table-list" style="border: 1px solid black;">
                {{-- @endif --}}

                <tr class="list" style="background-color:#C7C5B7;border: 1px solid black;">
                    <td class="text-left" colspan="2" style="border: 1px solid black;">รวมทั้งสิ้น</td>
                    <?php
                    for($i = 1; $i <= count($array_sequences2); $i++){
                    ?>
                    <td style="border: 1px solid black;">{{ number_format($sumall2[$i], 2) }}</td>
                    <?php
                    }
                    ?>
                    <td style="border: 1px solid black;">{{ number_format($sumall2[0], 2) }}</td>
                </tr>

                <tr class="list" style="background-color:#C7C5B7;border: 1px solid black;">
                    <td rowspan="2" class="text-center" style="border: 1px solid black;">รวมทั้งสิ้น</td>
                    <td class="text-center" style="border: 1px solid black;">จำนวนหีบ และ</td>
                    @foreach ($array_sequences2 as $key => $s)
                        <td style="border: 1px solid black;">
                            {{ number_format(getapprovecardboardbox($s[0], $order_header_id_2), 2) }}</td>
                        <?php $sum12 += getapprovecardboardbox($s[0], $order_header_id_2); ?>
                    @endforeach
                    <td style="border: 1px solid black;">{{ number_format($sum12, 2) }}</td>
                </tr>
                <tr class="list" style="background-color:#C7C5B7;border: 1px solid black;">
                    <td class="text-center" style="border: 1px solid black;">จำนวนห่อ</td>
                    @foreach ($array_sequences2 as $key => $s)
                        <td style="border: 1px solid black;">{{ number_format(getapprovecarton($s[0], $order_header_id_2), 2) }}
                        </td>
                        <?php $sum22 += getapprovecarton($s[0], $order_header_id_2); ?>
                    @endforeach
                    <td style="border: 1px solid black;">{{ number_format($sum22, 2) }}</td>
                </tr>

                <tr class="list" style="background-color:#C7C5B7;border: 1px solid black;">
                    <td rowspan="2" class="text-center" style="border: 1px solid black;">รวมรายการส่งเสริมการตลาด</td>
                    <td class="text-center" style="border: 1px solid black;">จำนวนหีบ และ</td>
                    @foreach ($array_sequences2 as $key => $s)
                        <td style="border: 1px solid black;">
                            {{ number_format(getapproveQty($s[0], $order_header_id_2, true,'CS1'), 2) }}</td>
                        <?php $sum32 += getapproveQty($s[0], $order_header_id_2, true,'CS1'); ?>
                    @endforeach
                    <td style="border: 1px solid black;">{{ number_format($sum32, 2) }}</td>
                </tr>
                <tr class="list" style="background-color:#C7C5B7;border: 1px solid black;">
                    <td class="text-center" style="border: 1px solid black;">จำนวนห่อ</td>
                    @foreach ($array_sequences2 as $key => $s)
                        <td style="border: 1px solid black;">
                            {{ number_format(getapproveQty($s[0], $order_header_id_2, true,'CL1'), 2) }}</td>
                        <?php $sum42 += getapproveQty($s[0], $order_header_id_2, true,'CL1'); ?>
                    @endforeach
                    <td style="border: 1px solid black;">{{ number_format($sum42, 2) }}</td>
                </tr>
            </table>
        </body>

        </html>
