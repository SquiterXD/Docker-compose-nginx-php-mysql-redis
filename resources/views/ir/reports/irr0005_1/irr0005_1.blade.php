<?php
// $mpdf = new \Mpdf\Mpdf();
?>
<!DOCTYPE html>

<html>
<title>{{ $programCode }} - {{ $progTitle }}</title>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        thead {
            position: fixed; /* จัดวาง header ของตาราง */
            z-index: 1; /* ให้ header ของตารางอยู่ข้างบน */
            width: 100%; /* กำหนดความกว้างของ header ของตาราง */
            overflow: hidden; /* ซ่อนข้อมูลที่เกินขนาดของ header ของตาราง */
            top: 1; /* จัดวาง header ของตารางอยู่ท */
        }
        body {
            font-family: "cordia";
            font-size: 14pt;
        }

        p {
            margin: 0pt;
        }

        .left {
            border-left: 0.1mm solid #000000;
        }

        .right {
            border-right: 0.1mm solid #000000;
        }

        .top {
            border-top: 0.1mm solid #000000;
        }

        .bottom {
            border-bottom: 0.1mm solid #000000;
        }

        td {
            vertical-align: top;
        }
    </style>
</head>

<body>

    <?php
    $sum = [];
    $sumgroup = [];
    $sumTotal = [];
    $sum['insurance_amount'] = 0;
    $sum['duty_amount'] = 0;
    $sum['vat_amount'] = 0;
    $sum['total15'] = 0;
    $sum['discount'] = 0;
    $sum['total17'] = 0;
    $sumgroup['insurance_amount'] = 0;
    $sumgroup['duty_amount'] = 0;
    $sumgroup['vat_amount'] = 0;
    $sumgroup['total15'] = 0;
    $sumgroup['discount'] = 0;
    $sumgroup['total17'] = 0;
    $total['insurance_amount'] = 0;
    $total['duty_amount'] = 0;
    $total['vat_amount'] = 0;
    $total['total15'] = 0;
    $total['discount'] = 0;
    $total['total17'] = 0;
    $count = 0;
    ?>

    <htmlpageheader name="myheader">
        <table width="100%">
            <thead>
                <tr>
                    <td width="30%" align="left"><b>โปรแกรม</b> : IRR0005-1 </td>
                    <td width="40%" align="center">
                        <h3>การยาสูบแห่งประเทศไทย</h3>
                    </td>
                    <td width="30%" align="right"><b>วันที่</b> : {{$nowDateTH}}</td>
                </tr>
                <tr>
                    <td align="left"><b>สั่งพิมพ์</b> &nbsp;&nbsp;: {{ $user }} </td>
                    <td align="center"><b>รายงานรายละเอียดการชำระค่ากรมธรรม์ประกันภัยยานพาหนะ {{$renewtype}}</b></td>
                    <!-- <td align="right"><b>เวลา</b> : {{ date("H:i") }}</td> -->
                    <td width="30%" align="right"><b>เวลา</b> : {{ date("H:i") }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td align="left"></td>
                    <td align="center"><b> ตั้งแต่เดือน {{$monthtitle}} </b></td>
                    <td align="right"><b>หน้า</b> : {PAGENO}/{nb}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </thead>
        </table>
    </htmlpageheader>

    <htmlpagefooter name="myfooter">

        <hr />
    </htmlpagefooter>
    <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
    <sethtmlpagefooter name="myfooter" value="on" />
    @php($total_page=count($show_page))
    @php($page_ind=1)
    @php($show_group_ind=0)

    @php($sum_renewtype_insurance_amount= 0)
    @php($sum_renewtype_discount= 0)
    @php($sum_renewtype_duty_amount= 0)
    @php($sum_renewtype_vat_amount= 0)
    @php($sum_renewtype_total17= 0)

    @php($sum_grouptype_insurance_amount= 0)
    @php($sum_grouptype_discount= 0)
    @php($sum_grouptype_duty_amount= 0)
    @php($sum_grouptype_vat_amount= 0)
    @php($sum_grouptype_total17= 0)


    @php($chk_renewtype='xx')
    @foreach ($show_page as $key => $page)
    @php($row_no=1)
    @php($tmp_groupname = 'xx')
    @php($tmp_companyname = 'xx')
    @php($tmp_vatrefund='xx')

    @php($showTable='show')
    @php($row_no=1)


    <table width="100%" style="padding-top:12px">
        <thead>
            <tr>
                <td width="30%" align="left"><b><u>{{$page->group_name}}</u></b></td>
                <td align="center"><b>{{$page->renew_type}}</b></td>
            </tr>
            <tr>

                <td align="left"><b>{{$page->company_name == '' ? 'ไม่ระบุ' :  $page->company_name}} - {{$page->vat_refund == 'Y' ? 'ภาษีขอคืนได้':'ภาษีขอคืนไม่ได้'}} </b></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>

        </thead>
    </table>
    <table width="100%">
        <thead>
            <tr>
                <td align="left"><b>{{$page->sum_car_type}}</b></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
        </thead>
    </table>
    <table width="100%" style="padding-top:12px" cellspacing="0" cellpadding="0">

        <thead>
            <tr style="background:#FFF;">
                <th class="top bottom">ลำดับ</th>
                <th class="top bottom">ยี่ห้อ</th>
                <th class="top bottom">ประเภท</th>
                <th class="top bottom">เลขทะเบียน</th>
                <th class="top bottom">เลขที่กรมธรรม์</th>
                <th class="top bottom">ระยะเวลาเอาประกัน</th>
                <th class="top bottom">
                    <sm>(1)</sm><br /> ค่าเบี้ย<br />ประกัน
                </th>
                <th class="top bottom">
                    <sm>(2)</sm><br />ส่วนลด
                </th>
                <th class="top bottom">
                    <sm>(3)</sm><br /> อากร
                </th>
                <th class="top bottom">
                    <sm>(4)</sm><br /> ภาษีมูลค่า<br />เพิ่ม
                </th>
                <th class="top bottom">
                    <sm>(1)-(2)+(3)+(4)</sm><br />รวมเป็นเงิน<br />ทั้งสิ้น
                </th>
                <th class="top bottom">สถานที่</th>
            </tr>
        </thead>
        @php($total_insurance_amount= 0)
        @php($total_discount= 0)
        @php($total_duty_amount= 0)
        @php($total_vat_amount= 0)
        @php($total_total17= 0)
        @foreach ($datas as $key => $row)
        @if($row->group_show==$page->group_show)
        <tr>
            <td>{{$row_no}}</td>
            <td>{{$row->car_brand}}</td>
            <td align="left" style="white-space: nowrap;">{{mb_substr($row->car_type,0,20)?:'ไม่ทราบประเภท'}}</td>
            <td align="center">{{$row->license_plate}}</td>
            <td align="center">{{$row->policy_number}}</td>
            <td align="center" style="white-space: nowrap;">{{toperioddate($row->period_date)}}</td>
            <td align="right">{{number_format($row->insurance_amount,2)}}</td>
            <td align="right">{{number_format($row->discount,2)}}</td>
            <td align="right">{{number_format($row->duty_amount,2)}}</td>
            <td align="right">{{number_format($row->vat_amount,2)}}</td>
            <td align="right">{{number_format($row->total17,2)}}</td>
            <td style="white-space: nowrap;">&nbsp;&nbsp;{{$row->location_description}}</td>
            @php($row_no=$row_no+1)
        </tr>

        @php($total_insurance_amount= $total_insurance_amount+$row->insurance_amount)
        @php($total_discount= $total_discount+$row->discount)
        @php($total_duty_amount= $total_duty_amount+$row->duty_amount)
        @php($total_vat_amount= $total_vat_amount+$row->vat_amount)
        @php($total_total17= $total_total17+$row->total17)

        @php($sum_renewtype_insurance_amount= $sum_renewtype_insurance_amount+$row->insurance_amount)
        @php($sum_renewtype_discount= $sum_renewtype_discount+$row->discount)
        @php($sum_renewtype_duty_amount= $sum_renewtype_duty_amount+$row->duty_amount)
        @php($sum_renewtype_vat_amount= $sum_renewtype_vat_amount+$row->vat_amount)
        @php($sum_renewtype_total17= $sum_renewtype_total17+$row->total17)

        @php($sum_grouptype_insurance_amount= $sum_grouptype_insurance_amount+$row->insurance_amount)
        @php($sum_grouptype_discount= $sum_grouptype_discount+$row->discount)
        @php($sum_grouptype_duty_amount= $sum_grouptype_duty_amount+$row->duty_amount)
        @php($sum_grouptype_vat_amount= $sum_grouptype_vat_amount+$row->vat_amount)
        @php($sum_grouptype_total17= $sum_grouptype_total17+$row->total17)


        @endif
        @endforeach
        <tr style="background:#F0F0F0;">
            <th class="top bottom" colspan="6" align="right">รวม {{$page->company_name == '' ? 'ไม่ระบุ' :  $page->company_name}} - {{$page->vat_refund == 'Y' ? 'ภาษีขอคืนได้':'ภาษีขอคืนไม่ได้'}} &nbsp;&nbsp;</th>
            <td class="top bottom" align="right">{{number_format($total_insurance_amount,2)}}</td>
            <td class="top bottom" align="right">{{number_format($total_discount,2)}}</td>
            <td class="top bottom" align="right">{{number_format($total_duty_amount,2)}}</td>
            <td class="top bottom" align="right">{{number_format($total_vat_amount,2)}}</td>
            <td class="top bottom" align="right">{{number_format($total_total17,2)}}</td>
            <td class="top bottom" align="right">&nbsp;</td>
        </tr>

        @if($show_group_ind+1 < $total_page) @if($show_page[$show_group_ind]->renew_type != $show_page[$show_group_ind+1]->renew_type)
            <tr style="background:#F0F0F0;">
                <th class="top bottom" colspan="6" align="right">รวม {{$show_page[$show_group_ind]->renew_type}}&nbsp;&nbsp;</th>
                <td class="top bottom" align="right">{{number_format($sum_renewtype_insurance_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_renewtype_discount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_renewtype_duty_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_renewtype_vat_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_renewtype_total17,2)}}</td>
                <td class="top bottom" align="right">&nbsp;</td>
            </tr>
            @php($sum_renewtype_insurance_amount= 0)
            @php($sum_renewtype_discount= 0)
            @php($sum_renewtype_duty_amount= 0)
            @php($sum_renewtype_vat_amount= 0)
            @php($sum_renewtype_total17= 0)
            @endif

            @if($show_page[$show_group_ind]->group_name != $show_page[$show_group_ind+1]->group_name)
            <tr style="background:#F0F0F0;">
                <th class="top bottom" colspan="6" align="right">รวม {{$show_page[$show_group_ind]->group_name}}&nbsp;&nbsp;</th>
                <td class="top bottom" align="right">{{number_format($sum_grouptype_insurance_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_grouptype_discount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_grouptype_duty_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_grouptype_vat_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_grouptype_total17,2)}}</td>
                <td class="top bottom" align="right">&nbsp;</td>
            </tr>
            @php($sum_grouptype_insurance_amount= 0)
            @php($sum_grouptype_discount= 0)
            @php($sum_grouptype_duty_amount= 0)
            @php($sum_grouptype_vat_amount= 0)
            @php($sum_grouptype_total17= 0)
            @endif


            @else:

            <tr style="background:#F0F0F0;">
                <th class="top bottom" colspan="6" align="right">รวม {{$show_page[$show_group_ind]->renew_type}}&nbsp;&nbsp;</th>
                <td class="top bottom" align="right">{{number_format($sum_renewtype_insurance_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_renewtype_discount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_renewtype_duty_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_renewtype_vat_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_renewtype_total17,2)}}</td>
                <td class="top bottom" align="right">&nbsp;</td>
            </tr>
            <tr style="background:#F0F0F0;">
                <th class="top bottom" colspan="6" align="right">รวม {{$show_page[$show_group_ind]->group_name}}&nbsp;&nbsp;</th>
                <td class="top bottom" align="right">{{number_format($sum_grouptype_insurance_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_grouptype_discount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_grouptype_duty_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_grouptype_vat_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($sum_grouptype_total17,2)}}</td>
                <td class="top bottom" align="right">&nbsp;</td>
            </tr>
            @endif


            @if($page_ind == count($show_page))
            @foreach ($summary_all as $key => $row)
            <tr style="background:#F0F0F0;">
                <th class="top bottom" colspan="6" align="right">รวมทั้งสิ้น &nbsp;&nbsp;</th>
                <td class="top bottom" align="right">{{number_format($row->insurance_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($row->discount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($row->duty_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($row->vat_amount,2)}}</td>
                <td class="top bottom" align="right">{{number_format($row->total17,2)}}</td>
                <td class="top bottom" align="right">&nbsp;</td>
            </tr>
            @endforeach
            @endif

    </table>


    @if($total_page !=$page_ind)
    <pagebreak>
        @endif
        @php($page_ind=$page_ind+1)
        @php($show_group_ind=$show_group_ind+1)
        @endforeach



</body>


</html>
