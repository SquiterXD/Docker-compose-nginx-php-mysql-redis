<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: "cordia";
            font-size: 14pt;
        }

        p {	margin: 0pt; }

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

        td { vertical-align: top; }

    </style>
</head>
<body>
    <!--mpdf
        <htmlpageheader name="myheader">
            <table width="100%">
                <thead>
                    <tr>
                        <td width="30%" align="left">โปรแกรม : IRR90101 </td>
                        <td width="40%" align="center">
                            <h3>การยาสูบแห่งประเทศไทย</h3>
                        </td>
                        <td width="30%" align="right">วันที่: {{$nowDateTH}}</td>
                    </tr>
                    <tr>
                        <td align="left">สั่งพิมพ์ &nbsp;&nbsp;: {{ $user }} </td>
                        <td align="center">รายงานรายละเอียดการชำระค่ากรมธรรม์ประกันภัยยานพาหนะ {{$renewtype}}</td>
                        <td align="right">เวลา: {{ date("H:i") }}</td>
                    </tr>
                    <tr>
                        <td align="left"></td>
                        <td align="center"> ตั้งแต่เดือน {{$monthtitle}} </td>
                        <td align="right">หน้า : {PAGENO}/{nb}</td>
                    </tr>
                </thead>
            </table>
        </htmlpageheader>
        <htmlpagefooter name="myfooter">
            <hr />
        </htmlpagefooter>
        <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
        <sethtmlpagefooter name="myfooter" value="on" />
    mpdf-->
    <table  width="100%">
        <thead>
            <tr><th align="left" colspan="14"><u>{{$groupname?:'ไม่ระบุส่วน'}}</u></th></tr>
            <tr><th align="left" colspan="6">{{$companyname?:'ไม่ระบุบริษัท'}} - {{$varrefundtype?:'ไม่ระบุประเภทภาษี'}}</th>
            <th align="center" colspan="3">{{$displayRenewType}}</th></tr>
            <tr><th align="left" colspan="14">{{$ss}}</th></tr>

            <tr style="background:#FFF;">
            <th class="top bottom">ลำดับ</th>
            <th class="top bottom">ยี่ห้อ</th>
            <th class="top bottom">ประเภท</th>
            <th class="top bottom">เลขทะเบียน</th>
            <th class="top bottom">หมายเลขตัวถัง</th>
            <th class="top bottom">ระยะเวลาเอาประกัน</th>
            <th class="top bottom"><sm>(1)</sm><br/> ค่าเบี้ย<br/>ประกัน</th>
            <th class="top bottom"><sm>(2)</sm><br/> ค่าอากร</th>
            <th class="top bottom"><sm>(3)</sm><br/> ภาษีมูลค่า<br/>เพิ่ม</th>
            <th class="top bottom"><sm>(1)+(2)+(3)</sm><br/>รวมเป็น<br/>เงิน</th>
            <th class="top bottom"><sm>(4)</sm><br/> หักส่วนลด<br/>12% จาก(1)</th>
            <th class="top bottom"><sm>(1)-(4)+(2)+(3)</sm><br/>รวมเป็นเงิน<br/>ทั้งสิ้น</th>
            <th class="top bottom">หน่วยงานที่ใช้</th>
            </tr>
        </thead>
        <tbody>
            @php($groupname = 'xx')
            @php($companyname = 'xx')
            @php($vatrefund='xx')
            <?php
            $sum = [];
            $sumgroup = [];
            $sumTotal=[];
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
            @foreach ($datas as $key => $row)
                @if(($companyname != $row->company_name && $companyname != 'xx' or $vatrefund != $row->vat_refund  && $vatrefund != 'xx' ) )
                    <tr  style="background:#F0F0F0;">
                        <th class="top bottom" colspan="6" align="right">รวม {{$companyname?:'บริษัทประกันภัย ...'}} - {{isset($vt[$vatrefund])?$vt[$vatrefund]:$row->vat_refund?:'!!!'}}&nbsp;&nbsp;</th>
                        <td class="top bottom" align="right">{{number_format($sum['insurance_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sum['duty_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sum['vat_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sum['total15'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sum['discount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sum['total17'],2)}}</td>
                        <td class="top bottom" align="right">&nbsp;</td>
                    </tr>
                    <?php
                                $sum['insurance_amount'] = 0;
                                $sum['duty_amount'] = 0;
                                $sum['vat_amount'] = 0;
                                $sum['total15'] = 0;
                                $sum['discount'] = 0;
                                $sum['total17'] = 0;
                                $vatrefund = 'xx';
                                $company_name = 'xx';
                    ?>
                @endif
                @if($groupname != $row->group_name && $groupname != 'xx')
                <tr  style="background:#F0F0F0;">
                        <th class="top bottom" colspan="6" align="right">รวม {{$groupname}}&nbsp;&nbsp;</th>
                        <td class="top bottom" align="right">{{number_format($sumgroup['insurance_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sumgroup['duty_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sumgroup['vat_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sumgroup['total15'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sumgroup['discount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sumgroup['total17'],2)}}</td>
                        <td class="top bottom" align="right">&nbsp;</td>
                    </tr>
                    <?php
                                $sumgroup['insurance_amount'] = 0;
                                $sumgroup['duty_amount'] = 0;
                                $sumgroup['vat_amount'] = 0;
                                $sumgroup['total15'] = 0;
                                $sumgroup['discount'] = 0;
                                $sumgroup['total17'] = 0;
                                $groupname = 'xx';
                                $count = 0;
                    ?>
                @endif

                @php($vatrefund = $row->vat_refund)
                @php($groupname = $row->group_name)
                @php($companyname = $row->company_name)

                <?php

                $sum['insurance_amount'] += $row->insurance_amount;
                $sum['duty_amount'] += $row->duty_amount;
                $sum['vat_amount'] += $row->vat_amount;
                $sum['total15'] += $row->total15;
                $sum['discount'] += $row->discount;
                $sum['total17'] += $row->total17;
                $sumgroup['insurance_amount'] += $row->insurance_amount;
                $sumgroup['duty_amount'] += $row->duty_amount;
                $sumgroup['vat_amount'] += $row->vat_amount;
                $sumgroup['total15'] += $row->total15;
                $sumgroup['discount'] += $row->discount;
                $sumgroup['total17'] += $row->total17;
                $total['insurance_amount'] += $row->insurance_amount;
                $total['duty_amount'] += $row->duty_amount;
                $total['vat_amount'] += $row->vat_amount;
                $total['total15'] += $row->total15;
                $total['discount'] += $row->discount;
                $total['total17'] += $row->total17;
                $count++;
                ?>
                <tr>
                <!-- <td>{{$row->row_num}}/{{$row->group_name?:'ไม่ทราบส่วน'}}/{{$row->vat_refund}}/{{$row->company_id?:'xx'}}</td> -->
                <td>{{$row->row_num}}</td>
                <td>{{$row->car_brand}}</td>
                <td align="left"  style="white-space: nowrap;" >{{mb_substr($row->car_type,0,20)?:'ไม่ทราบประเภท'}}</td>
                <td align="center" >{{$row->license_plate}}</td>
                <td align="center" >{{$row->tank_number}}</td>
                <td align="center" style="white-space: nowrap;" >{{toperioddate($row->period_date)}}</td>
                <td align="right">{{number_format($row->insurance_amount,2)}}</td>
                <td align="right">{{number_format($row->duty_amount,2)}}</td>
                <td align="right">{{number_format($row->vat_amount,2)}}</td>
                <td align="right">{{number_format($row->total15,2)}}</td>
                <td align="right">{{number_format($row->discount,2)}}</td>
                <td align="right">{{number_format($row->total17,2)}}</td>
                <td  style="white-space: nowrap;">&nbsp;&nbsp;{{$row->department_name}}</td>
             
                </tr>
            @endforeach
      
            <?php
                 // dump($row->row_num,$sum,$sumgroup,'บริษัทยกมา---->',$companyname,'บริษัทใน row->',$row->company_name,'ประเภทภาษียกมา---->',$vatrefund,'ประเภทภาษีใน row--->',$row->vat_refund);
            ?>
            @if(($count > 0 ) )
            <tr  style="background:#F0F0F0;">
                        <th class="top bottom" colspan="6" align="right">รวม {{$companyname?:'ไม่ระบุบริษัท'}} - {{isset($vt[$vatrefund])?$vt[$vatrefund]:$row->vat_refund?:'!!!'}}&nbsp;&nbsp;</th>
                        <td class="top bottom" align="right">{{number_format($sum['insurance_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sum['duty_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sum['vat_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sum['total15'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sum['discount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sum['total17'],2)}}</td>
                        <td class="top bottom" align="right">&nbsp;</td>
                    </tr>
                    <?php
                                $sum['insurance_amount'] = 0;
                                $sum['duty_amount'] = 0;
                                $sum['vat_amount'] = 0;
                                $sum['total15'] = 0;
                                $sum['discount'] = 0;
                                $sum['total17'] = 0;
                                $vatrefund = 'xx';
                                $company_name = 'xx';
                    ?>
                     <tr  style="background:#F0F0F0;">
                        <th class="top bottom" colspan="6" align="right">รวม {{$groupname}}&nbsp;&nbsp;</th>
                        <td class="top bottom" align="right">{{number_format($sumgroup['insurance_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sumgroup['duty_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sumgroup['vat_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sumgroup['total15'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sumgroup['discount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($sumgroup['total17'],2)}}</td>
                        <td class="top bottom" align="right">&nbsp;</td>
                    </tr>
                    <?php
                                $sumgroup['insurance_amount'] = 0;
                                $sumgroup['duty_amount'] = 0;
                                $sumgroup['vat_amount'] = 0;
                                $sumgroup['total15'] = 0;
                                $sumgroup['discount'] = 0;
                                $sumgroup['total17'] = 0;
                                $groupname = 'xx';
                                $count = 0;
                    ?>
                     <tr  style="background:#F0F0F0;">
                        <th class="top bottom" colspan="6" align="right">รวมทั้งสิ้น &nbsp;&nbsp;</th>
                        <td class="top bottom" align="right">{{number_format($total['insurance_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($total['duty_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($total['vat_amount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($total['total15'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($total['discount'],2)}}</td>
                        <td class="top bottom" align="right">{{number_format($total['total17'],2)}}</td>
                        <td class="top bottom" align="right">&nbsp;</td>
            </tr>
            @endif
           
        </tbody>
    </table>
</body>
</html>
<?php //dd('--stop---'); ?>