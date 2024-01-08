<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: garuda;
            font-size: 10pt;
        }

        .righttd {
            font-variant: small-caps;
            text-align: right;
        }

    </style>
</head>
<body>
    <!--mpdf
        <htmlpageheader name="myheader">
            <table width="100%">
            <thead>
            <tr>
                <td valign="bottom"  class="left" width="30%" sylte=" border: 0.1mm solid #000000;">
                    <table>
                        <tr>
                            <td align="left">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left">โปรแกรม : {{$programCode}}_2 </td>
                        </tr>
                        <tr>
                            <td align="left">สั่งพิมพ์ &nbsp;&nbsp;: {{ $user }} </td>
                        </tr>
                        <tr>
                            <td align="left">&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <th width="40%" class="text-left"  sylte=" border: 0.1mm solid #000000;">
                    <div>
                        <h2 class="text-center tw-font-bold" style="padding-bottom: 2px;"> การยาสูบแห่งประเทศไทย </h2>
                    </div>
                    <div>
                        <div class="text-center tw-font-bold"> รายการจำหน่ายยาสูบ/ยาเส้น (รต/1) ใบขน (สโมสร) </div>
                    </div>
                    <div>
                        <div class="text-center tw-font-bold"> วันที่ {{ $approve_date_th }}</div>
                    </div>
                </th>
                <td  valign="bottom"  class="righttd" width="30%">
                    <table>
                        <tr>
                            <td  align="left" >วันที่: {{ $nowDateTH }} </td>
                        </tr><tr>
                            <td  align="left" >เวลา: {{ date("H:i") }}  </td>
                        </tr><tr>
                            <td  align="left" >หน้า : {PAGENO}/{nb} </td>
                        </tr><tr>
                            <td  align="left" >หน่วย : บุหรี่/พันมวน ยาเส้น/หีบ</td>
                        </tr>

                    </table>
                </td>
            </tr>
            </thead>
            </table>
        </htmlpageheader>
        <htmlpagefooter name="myfooter">
          <hr/>
          {DATE Y-m-d H:i:s}
        </htmlpagefooter>
        <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
        <sethtmlpagefooter name="myfooter" value="on" />
    mpdf-->
    @for($cut_item = 0; $cut_item < 2; $cut_item++)
        @if($cut_item != 0)
            <pagebreak />
        @endif
    <table border="0" width="100%" style="font-size: 12px;">
        <thead>
            <tr style="background:#F0F0F0;">
                <th class="text-center" rowspan="2">เลขที่ใบกำกับสินค้า</th>
                <th class="text-center nowarp" colspan="2" rowspan="2">ชื่อร้านค้า</th>
            @if($cut_item == 0)
                <th class="text-center" colspan="14" class="text-center">บุหรี่</th>
            @else
                <th class="text-center" colspan="{{count($cigarette)-14}}" class="text-center">บุหรี่</th>
            @endif
            @if($cut_item > 0)
                <th class="text-center" colspan="{{count($rework)}}" class="text-center">ยาเส้น</th>
                <th class="text-center" rowspan="2" >ยอดรวมบุหรี่</th>
                <th class="text-center" rowspan="2" >จำนวนเงินบุหรี่</th>
                <th class="text-center" rowspan="2" >ยอดรวมยาเส้น</th>
                <th class="text-center" rowspan="2" >จำนวนเงินยาเส้น</th>
                <th class="text-center" rowspan="2" >รวมจำนวนเงินทั้งสิ้น</th>
            @endif
            </tr>
            <tr style="background:#F0F0F0;">
                @foreach ($cigarette as $item)
                    @if($cut_item == 0)
                        @if($loop->index <= 13)
                <th class="text-center">{{ $item->item_description }}</th>
                        @endif
                    @else
                        @if($loop->index > 13)
                <th class="text-center">{{ $item->item_description }}</th>
                        @endif
                    @endif
                @endforeach
            @if($cut_item > 0)
                @foreach ($rework as $item)
                <th class="text-center">{{ $item->item_description }}</th>
                @endforeach
            @endif
            </tr>
        </thead>
        <!-- ****  ไม่อบจ **** ** ฝากสโมสรยาสูบขาย ** sea -->
            <tbody>
                <tr>
                    <td><b>***ไม่อบจ***</b><br/>** ฝากสโมสรยาสูบขาย **</td>
                @if($cut_item > 0)
                    <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
                @endif
                </tr>
                @foreach($layout2_seca as $row)
                    <tr>
                        <td>{{$row->consignment_no}}</td>
                        <td style="white-space: nowrap;" >{{$row->customer_name}}</td>
                        <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                        @if($cut_item == 0)
                            @if($loop->index <= 13)
                        <td class="text-right">
                            {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                        </td>
                            @endif
                        @else
                            @if($loop->index > 13)
                        <td class="text-right">
                            {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                        </td>
                            @endif
                        @endif
                        @endforeach
                    @if($cut_item > 0)
                        @foreach ($rework as $item)
                        <td class="text-right">
                            {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                        </td>
                        @endforeach
                        <td>{{$row->approveqty10 ? number_format($row->approveqty10,2) : ''}}<br />{{$row->orderqty10 ? number_format($row->orderqty10,2) : ''}}</td>
                        <td>{{$row->conamount10 ? number_format($row->conamount10,2) : ''}}<br />{{$row->amount10 ? number_format($row->amount10,2) : ''}}</td>
                        <td>{{$row->approveqty20 ? number_format($row->approveqty20,2) : ''}}<br />{{$row->orderqty20 ? number_format($row->orderqty20,2) : ''}}</td>
                        <td>{{$row->conamount20 ? number_format($row->conamount20,2) : ''}}<br />{{$row->amount20 ? number_format($row->amount20,2) : ''}}</td>
                        <td>{{number_format($row->conamount10+$row->conamount20,2)}}<br/>{{number_format($row->amount10+$row->amount20,2)}}</td>
                    @endif
                    </tr>
                @endforeach
                <tr>
                    @if($cut_item == 0)
                    <td colspan="{{2+count($cigarette)}}"><hr width="100%"></td>
                    @else
                    <td colspan="{{(count($cigarette)-14)+count($rework)+8}}"><hr width="100%"></td>
                    @endif
                </tr>
                <!-- รวมยอดขาย  ไม่ อบจ. -->
                @if(count($layout2_sum_seca)>0)
                    @foreach($layout2_sum_seca as $row)
                        <tr>
                            <td>&nbsp;<b> รวมยอดขาย  ไม่ อบจ.</b></td>
                            <td>&nbsp;</td>
                            <th>ส่ง<br/>สั่ง</th>
                            @foreach ($cigarette as $item)
                            @if($cut_item == 0)
                                @if($loop->index <= 13)
                            <td class="text-right">
                                {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                            </td>
                                @endif
                            @else
                                @if($loop->index > 13)
                            <td class="text-right">
                                {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                            </td>
                                @endif
                            @endif
                            @endforeach
                        @if($cut_item > 0)
                            @foreach ($rework as $item)
                            <td class="text-right">
                                {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                            </td>
                            @endforeach
                            <td>{{$row->approveqty10 ? number_format($row->approveqty10,2) : ''}}<br />{{$row->orderqty10 ? number_format($row->orderqty10,2) : ''}}</td>
                            <td>{{$row->conamount10 ? number_format($row->conamount10,2) : ''}}<br />{{$row->amount10 ? number_format($row->amount10,2) : ''}}</td>
                            <td>{{$row->approveqty20 ? number_format($row->approveqty20,2) : ''}}<br />{{$row->orderqty20 ? number_format($row->orderqty20,2) : ''}}</td>
                            <td>{{$row->conamount20 ? number_format($row->conamount20,2) : ''}}<br />{{$row->amount20 ? number_format($row->amount20,2) : ''}}</td>
                            <td>{{number_format($row->conamount10+$row->conamount20,2)}}<br/>{{number_format($row->approveqty10+$row->approveqty20,2)}}</td>
                        @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td style="white-space: nowrap;"><b>&nbsp; รวมยอดขาย  ไม่ อบจ.</b></td>
                    @if($cut_item > 0)
                        <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
                    @endif
                    </tr>
                @endif
            </tbody>
            <tr>
                @if($cut_item == 0)
                <td colspan="{{2+count($cigarette)}}"><hr width="100%"></td>
                @else
                <td colspan="{{(count($cigarette)-14)+count($rework)+8}}"><hr width="100%"></td>
                @endif
            </tr>
        <!-- ****  อบจ **** ** ฝากสโมสรยาสูบขาย ** seb -->
            <tbody>
                <tr>
                    <td><b>*** อบจ ***</b><br/>** ฝากสโมสรยาสูบขาย **</td>
                    <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
                </tr>
                @foreach($layout2_secb as $row)
                    <tr>
                        <td>{{$row->consignment_no}}</td>
                        <td style="white-space: nowrap;" >{{$row->customer_name}}</td>
                        <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                        @if($cut_item == 0)
                            @if($loop->index <= 13)
                        <td class="text-right">
                            {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                        </td>
                            @endif
                        @else
                            @if($loop->index > 13)
                        <td class="text-right">
                            {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                        </td>
                            @endif
                        @endif
                        @endforeach
                    @if($cut_item > 0)
                        @foreach ($rework as $item)
                        <td class="text-right">
                            {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                        </td>
                        @endforeach
                        <td>{{$row->approveqty10 ? number_format($row->approveqty10,2) : ''}}<br />{{$row->orderqty10 ? number_format($row->orderqty10,2) : ''}}</td>
                        <td>{{$row->conamount10 ? number_format($row->conamount10,2) : ''}}<br />{{$row->amount10 ? number_format($row->amount10,2) : ''}}</td>
                        <td>{{$row->approveqty20 ? number_format($row->approveqty20,2) : ''}}<br />{{$row->orderqty20 ? number_format($row->orderqty20,2) : ''}}</td>
                        <td>{{$row->conamount20 ? number_format($row->conamount20,2) : ''}}<br />{{$row->amount20 ? number_format($row->amount20,2) : ''}}</td>
                        <td>{{number_format($row->conamount10+$row->conamount20,2)}}<br/>{{number_format($row->amount10+$row->amount20,2)}}</td>
                    @endif
                    </tr>
                @endforeach
                <tr>
                    @if($cut_item == 0)
                    <td colspan="{{2+count($cigarette)}}"><hr width="100%"></td>
                    @else
                    <td colspan="{{(count($cigarette)-14)+count($rework)+8}}"><hr width="100%"></td>
                    @endif
                </tr>
                <!-- รวมยอดขาย อบจ. sum_seb -->
                @if(count($layout2_sum_secb)>0)
                    @foreach($layout2_sum_secb as $row)
                        <tr>
                            <td><b>&nbsp; รวมยอดขาย อบจ.</b></td>
                            <td>&nbsp;</td>
                            <th>ส่ง<br/>สั่ง</th>
                            @foreach ($cigarette as $item)
                            @if($cut_item == 0)
                                @if($loop->index <= 13)
                            <td class="text-right">
                                {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                            </td>
                                @endif
                            @else
                                @if($loop->index > 13)
                            <td class="text-right">
                                {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                            </td>
                                @endif
                            @endif
                            @endforeach
                        @if($cut_item > 0)
                            @foreach ($rework as $item)
                            <td class="text-right">
                                {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                            </td>
                            @endforeach
                            <td>{{$row->approveqty10 ? number_format($row->approveqty10,2) : ''}}<br />{{$row->orderqty10 ? number_format($row->orderqty10,2) : ''}}</td>
                            <td>{{$row->conamount10 ? number_format($row->conamount10,2) : ''}}<br />{{$row->amount10 ? number_format($row->amount10,2) : ''}}</td>
                            <td>{{$row->approveqty20 ? number_format($row->approveqty20,2) : ''}}<br />{{$row->orderqty20 ? number_format($row->orderqty20,2) : ''}}</td>
                            <td>{{$row->conamount20 ? number_format($row->conamount20,2) : ''}}<br />{{$row->amount20 ? number_format($row->amount20,2) : ''}}</td>
                            <td>{{number_format($row->conamount10+$row->conamount20,2)}}<br/>{{number_format($row->approveqty10+$row->approveqty20,2)}}</td>
                        @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td style="white-space: nowrap;"><b>&nbsp; รวมยอดขาย อบจ.</b></td>
                    @if($cut_item > 0)
                        <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
                    @endif
                    </tr>
                @endif
            </tbody>
            <tr>
                @if($cut_item == 0)
                <td colspan="{{2+count($cigarette)}}"><hr width="100%"></td>
                @else
                <td colspan="{{(count($cigarette)-14)+count($rework)+8}}"><hr width="100%"></td>
                @endif
            </tr>
        <!-- รวมยอดขาย อบจ. และไม่อบจ. sum_ab -->
            @if(count($layout2_sum_secab)>0)
                <tbody>
                    @foreach($layout2_sum_secab as $row)
                        <tr>
                            <td style="white-space: nowrap;" ><b>&nbsp; รวมยอดขาย อบจ. และไม่อบจ.</b></td>
                            <td>&nbsp;</td>
                            <th>ส่ง<br/>สั่ง</th>
                            @foreach ($cigarette as $item)
                            @if($cut_item == 0)
                            @if($loop->index <= 13)
                            <td class="text-right">
                                {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                            </td>
                                @endif
                            @else
                                @if($loop->index > 13)
                            <td class="text-right">
                                {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                            </td>
                                @endif
                            @endif
                            @endforeach
                        @if($cut_item > 0)
                            @foreach ($rework as $item)
                            <td class="text-right">
                                {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id},2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                            </td>
                            @endforeach
                            <td>{{$row->approveqty10 ? number_format($row->approveqty10,2) : ''}}<br />{{$row->orderqty10 ? number_format($row->orderqty10,2) : ''}}</td>
                            <td>{{$row->conamount10 ? number_format($row->conamount10,2) : ''}}<br />{{$row->amount10 ? number_format($row->amount10,2) : ''}}</td>
                            <td>{{$row->approveqty20 ? number_format($row->approveqty20,2) : ''}}<br />{{$row->orderqty20 ? number_format($row->orderqty20,2) : ''}}</td>
                            <td>{{$row->conamount20 ? number_format($row->conamount20,2) : ''}}<br />{{$row->amount20 ? number_format($row->amount20,2) : ''}}</td>
                            <td>{{number_format($row->conamount10+$row->conamount20,2)}}<br/>{{number_format($row->approveqty10+$row->approveqty20,2)}}</td>
                        @endif
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tr>
                    <td style="white-space: nowrap;"><b>&nbsp; รวมยอดขาย อบจ. และไม่อบจ.</b></td>
                @if($cut_item > 0)
                    <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
                @endif
                </tr>
            @endif
    </table>
    <table border="0" width="100%" style="font-size: 12px;">
        <tr>
            <td>
                <table border="0" width="100%" style="font-size: 12px;">
                    <tr><td colspan="3">&nbsp;</td></tr>
                    <tr><td align="center" colspan="3">จบรายงาน</td></tr>
                    <tr><td colspan="3">&nbsp;</td></tr>
                    <tr>
                        <td style="width:30%;" class="text-center"></td>
                        <td style="width:40%;" class="text-center text-top">&nbsp;</td>
                        <td style="width:30%;" class="text-left">
                            <div>หัวหน้าส่วนงาน___________________________สำเนา หมวดลูกหนี้-เจ้าหนี้</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:30%;" class="text-center"></td>
                        <td style="width:40%;" class="text-center text-top"></td>
                        <td style="width:30%;" class="text-left">
                            <br />
                            <div>หัวหน้ากองบริหารขาย___________________________</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:30%;" class="text-center"></td>
                        <td style="width:40%;" class="text-center text-top"></td>
                        <td style="width:30%;" class="text-left">
                            <br />
                            <div>ผู้จัดทำ_____________________________________</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    @endfor
</body>
</html>
