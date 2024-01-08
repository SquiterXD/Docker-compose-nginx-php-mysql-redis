<?php
// dump($datas);
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $programCode }} - {{ $progTitle }}</title>
    <style>
        body {
            font-weight: 400 !important;
            /* font-family: "thsarabun"; */
            font-size: 14pt;
            /* font-family: cordia;
            font-size: 16pt; */
        }

        table {
            border-collapse: collapse;
        }
        table th, b, h3, h2, h4 {
            font-weight: 100 !important;
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
    <!--mpdf
        <htmlpageheader name="myheader">
            <table width="100%">
                <thead>
                    <tr >
                        <td valign="bottom" width="30%">
                            <table>
                                <tr >
                                    <td align="left">&nbsp;</td>
                                </tr>
                                <tr >
                                    <td align="left">โปรแกรม : OMR0037 </td>
                                </tr>
                                <tr >
                                    <td align="left">สั่งพิมพ์ &nbsp;&nbsp;: {{ $user }} </td>
                                </tr>
                                <tr >
                                    <td align="left">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                        <td width="40%" class="text-left" >
                            <div>
                                <center><h2 style="padding-bottom: 2px;"> การยาสูบแห่งประเทศไทย </h2></center>
                            </div>
                            <div>
                                <center><h3 align="center" style=\"font-family: cordia; font-size: 16pt;\" >สรุปค่าขนส่ง รายตรา รายเดือน</h3></center>
                            </div>
                            <div>
                                <h4  align="center">จากวันที่ {{parseToDateTh($start_date)}} ถึง วันที่ {{parseToDateTh($end_date)}}</h4>
                            </div>
                        </td>
                        <td  valign="bottom"  align="right" width="30%">
                            <table>
                                <tr >
                                    <td  align="right" >&nbsp;</td>
                                </tr>
                                <tr >
                                    <td  align="right" >วันที่: {{$nowDateTH}} </td>
                                </tr><tr >
                                    <td  align="right" >เวลา: {{ date("H:i") }}  </td>
                                </tr><tr >
                                    <td  align="right" >หน้า : {PAGENO}/{nb} </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </thead>
            </table>
        </htmlpageheader>
        <htmlpagefooter name="myfooter">
        </htmlpagefooter>
        <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
        <sethtmlpagefooter name="myfooter" value="on" />
    mpdf-->
    <table width="100%">
        <thead>
            <tr>
                <th width="15%" class="top  bottom" rowspan="2">ลำดับ</th>
                <th width="25%" class="top  bottom" rowspan="2">ตราบุหรี่</th>
                <th width="25%" class="top" colspan="4">ค่าขนส่งปกติ</th>
                <th width="250%" class="top" colspan="4">ค่าขนส่งส่งเสริม</th>
                <th width="20%" class="top  bottom" rowspan="2">รวมค่าชนส่ง</th>
            </tr>
            <tr>
                <th width="10%" class="bottom top ">คิดเป็นพันมวน</th>
                <th width="10%" class="bottom top ">หีบ</th>
                <th width="10%" class="bottom top ">ห่อ</th>
                <th width="10%" class="bottom top ">จำนวนเงิน</th>
                <th width="10%" class="bottom top ">คิดเป็นพันมวน</th>
                <th width="10%" class="bottom top ">หีบ</th>
                <th width="10%" class="bottom top ">ห่อ</th>
                <th width="10%" class="bottom top ">จำนวนเงิน</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3"><b>บุหรี่ในประเทศ</b></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <?php
            $sumcols = [];
            $sumcols['nx11'] = 0;
            $sumcols['nx12'] = 0;
            $sumcols['nx13'] = 0;
            $sumcols['nxx14'] = 0;
            $sumcols['yx11'] = 0;
            $sumcols['yx12'] = 0;
            $sumcols['yx13'] = 0;
            $sumcols['yxx14'] = 0;
            ?>
            @php($i=1)
            @foreach($datas as $key => $row)
            @if($row->product_type_code == 10 )
            <tr>
                <td align="center">{{$i}}</td>
                <td align="left">{{$row->item_description}}</td>
                <td align="right">{{number_format($row->nx11,2)}}</td>
                <td align="right">{{number_format($row->nx12,2)}}</td>
                <td align="right">{{number_format($row->nx13,2)}}</td>
                <td align="right">{{number_format($row->nxx14,2)}}</td>
                <td align="right">{{number_format($row->yx11,2)}}</td>
                <td align="right">{{number_format($row->yx12,2)}}</td>
                <td align="right">{{number_format($row->yx13,2)}}</td>
                <td align="right">{{number_format($row->yxx14,2)}}</td>
                <td align="right">{{number_format($row->nxx14+$row->yxx14,2)}}</td>
            </tr>
            <?php
            $sumcols['nx11'] += $row->nx11;
            $sumcols['nx12'] += $row->nx12;
            $sumcols['nx13'] += $row->nx13;
            $sumcols['nxx14'] += $row->nxx14;
            $sumcols['yx11'] += $row->yx11;
            $sumcols['yx12'] += $row->yx12;
            $sumcols['yx13'] += $row->yx13;
            $sumcols['yxx14'] += $row->yxx14;
            ?>
            @php($i++)
            @endif
            @endforeach
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="top bottom" colspan="2" align="right"><b>รวมบุหรี่</b></td>
                <td class="top bottom" align="right">{{number_format($sumcols['nx11'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcols['nx12'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcols['nx13'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcols['nxx14'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcols['yx11'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcols['yx12'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcols['yx13'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcols['yxx14'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcols['nxx14']+$sumcols['yxx14'],2)}}</td>
            </tr>
            <tr>
                <td colspan="3"><b>ยาเส้นไม่ปรุง</b></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <?php
            $sumcolx = [];
            $sumcolx['nx11'] = 0;
            $sumcolx['nx12'] = 0;
            $sumcolx['nx13'] = 0;
            $sumcolx['nxx14'] = 0;
            $sumcolx['yx11'] = 0;
            $sumcolx['yx12'] = 0;
            $sumcolx['yx13'] = 0;
            $sumcolx['yxx14'] = 0;
            ?>
            @php($i=1)
            @foreach($datas as $key => $row)
            @if($row->product_type_code == 20 )
            <tr>
                <td align="center">{{$i}}</td>
                <td align="left">{{$row->item_description}}</td>
                <td align="right">{{number_format($row->nx11,2)}}</td>
                <td align="right">{{number_format($row->nx12,2)}}</td>
                <td align="right">{{number_format($row->nx13,2)}}</td>
                <td align="right">{{number_format($row->nxx14,2)}}</td>
                <td align="right">{{number_format($row->yx11,2)}}</td>
                <td align="right">{{number_format($row->yx12,2)}}</td>
                <td align="right">{{number_format($row->yx13,2)}}</td>
                <td align="right">{{number_format($row->yxx14,2)}}</td>
                <td align="right">{{number_format($row->nxx14+$row->yxx14,2)}}</td>
            </tr>
            <?php
            $sumcolx['nx11'] += $row->nx11;
            $sumcolx['nx12'] += $row->nx12;
            $sumcolx['nx13'] += $row->nx13;
            $sumcolx['nxx14'] += $row->nxx14;
            $sumcolx['yx11'] += $row->yx11;
            $sumcolx['yx12'] += $row->yx12;
            $sumcolx['yx13'] += $row->yx13;
            $sumcolx['yxx14'] += $row->yxx14;
            ?>
            @php($i++)
            @endif
            @endforeach
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="top bottom" colspan="2" align="right"><b>รวมยาเส้น</b></td>
                <td class="top bottom" align="right">{{number_format($sumcolx['nx11'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['nx12'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['nx13'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['nxx14'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['yx11'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['yx12'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['yx13'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['yxx14'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['nxx14']+$sumcolx['yxx14'],2)}}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="top bottom" colspan="2" align="right"><b>รวมทั้งสิ้น</b></td>
                <td class="top bottom" align="right">{{number_format($sumcolx['nx11']+$sumcols['nx11'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['nx12']+$sumcols['nx12'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['nx13']+$sumcols['nx13'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['nxx14']+$sumcols['nxx14'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['yx11']+$sumcols['yx11'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['yx12']+$sumcols['yx12'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['yx13']+$sumcols['yx13'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['yxx14']+$sumcols['yxx14'],2)}}</td>
                <td class="top bottom" align="right">{{number_format($sumcolx['nxx14']+$sumcols['nxx14'],2)}}</td>
            </tr>
        </tbody>
    </table>
    <table border="0" width="100%" style="font-size: 12px;">
        <tr>
            <td>
                <table border="0" width="100%" style="font-size: 16px;">
                    <tr>
                        <td colspan="4">หมายเหตุรายการ: {{$remark}} </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>