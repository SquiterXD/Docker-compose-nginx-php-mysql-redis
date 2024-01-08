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
                            <td align="left">โปรแกรม : {{$programCode}}_1 </td>
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
                        <div class="text-center tw-font-bold"> รายการจำหน่ายยาสูบ/ยาเส้น (รต/1) </div>
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
                <th class="text-center nowarp" colspan="2" rowspan="2" style="white-space: nowrap;">ชื่อร้านค้า</th>
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
        <!-- ****  ไม่อบจ ****  ** ร้านค้าป. 1 **   --------------------------------* -->
        <tbody>
            <tr>
                <td><b>***ไม่อบจ***</b><br />** ร้านค้าป. 1 **</td>
            @if($cut_item > 0)
                <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
            @endif
            </tr>
            @foreach($layout1_seca as $row)
            <tr>
                <td>
                    {{$row->pick_release_no}}
                </td>
                <td style="white-space: nowrap;">{{$row->customer_name}}</td>
                <td>ส่ง<br />สั่ง</td>
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
                <td>{{number_format($row->conamount10+$row->conamount20,2)}}<br />{{number_format($row->amount10+$row->amount20,2)}}
                </td>
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
            <!--  รวมยอดกทม. -->
            @if(count($layout1_sum_seca_new) > 0)
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดกทม</b></td>
                <td>&nbsp;</td>
                <td>ส่ง<br />สั่ง</td>
                @foreach ($layout1_sum_seca_new['cigarette'] as $item)
                    @if($cut_item == 0)
                        @if($loop->index <= 13)
                <td class="text-right">
                    {{ $item['a'] ? number_format($item['a'],2) : '' }}<br />{{ $item['o'] ? number_format($item['o'],2) : '' }}
                </td>
                        @endif
                    @else
                        @if($loop->index > 13)
                <td class="text-right">
                    {{ $item['a'] ? number_format($item['a'],2) : '' }}<br />{{ $item['o'] ? number_format($item['o'],2) : '' }}
                </td>
                        @endif
                    @endif
                @endforeach
            @if($cut_item > 0)
                @foreach ($layout1_sum_seca_new['rework'] as $item)
                <td class="text-right">
                    {{ $item['a'] ? number_format($item['a'],2) : '' }}<br />{{ $item['o'] ? number_format($item['o'],2) : '' }}
                </td>
                @endforeach
                <td>{{$layout1_sum_seca_new['qty'][0]['approveqty10'] ? number_format($layout1_sum_seca_new['qty'][0]['approveqty10'],2) : ''}}<br />{{$layout1_sum_seca_new['qty'][0]['orderqty10'] ? number_format($layout1_sum_seca_new['qty'][0]['orderqty10'],2) : ''}}</td>
                <td>{{$layout1_sum_seca_new['qty'][1]['conamount10'] ? number_format($layout1_sum_seca_new['qty'][1]['conamount10'],2) : ''}}<br />{{$layout1_sum_seca_new['qty'][1]['amount10'] ? number_format($layout1_sum_seca_new['qty'][1]['amount10'],2) : ''}}</td>
                <td>{{$layout1_sum_seca_new['qty'][2]['approveqty20'] ? number_format($layout1_sum_seca_new['qty'][2]['approveqty20'],2) : ''}}<br />{{$layout1_sum_seca_new['qty'][2]['orderqty20'] ? number_format($layout1_sum_seca_new['qty'][2]['orderqty20'],2) : ''}}</td>
                <td>{{$layout1_sum_seca_new['qty'][3]['conamount20'] ? number_format($layout1_sum_seca_new['qty'][3]['conamount20'],2) : ''}}<br />{{$layout1_sum_seca_new['qty'][3]['amount20'] ? number_format($layout1_sum_seca_new['qty'][3]['amount20'],2) : ''}}</td>
                <td>{{ number_format($layout1_sum_seca_new['qty'][4]['conamount10conamount20'],2)}}<br />{{number_format($layout1_sum_seca_new['qty'][4]['amount10amount20'],2)}}</td>
            @endif
            </tr>
            @else
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดกทม</b></td>
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
        <!-- ****  ไม่อบจ **** ** ฝากสโมสรยาสูบขาย ** -->
        <tbody>
            <tr>
                <td><b>***ไม่อบจ***</b><br />** ฝากสโมสรยาสูบขาย **</td>
            @if($cut_item > 0)
                <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
            @endif
            </tr>
            @foreach($layout1_secb as $row)
            <tr>
                <td>{{$row->consignment_no}}</td>
                <td style="white-space: nowrap;">{{$row->customer_name}}</td>
                <td>ส่ง<br />สั่ง</td>
                @foreach ($cigarette as $item)
                    @php
                        $uomcode = array('unit' => 1);
                    @endphp
                    @foreach ($layout1_secb_convert_rate as $item_lscr)
                        @if (is_object($item_lscr['item_id']))
                            @if ($item_lscr['item_id'] == $item->item_id)
                                @if ($item_lscr['uom_code'] != 'CGK')
                                @php
                                    $uomcode['unit'] = $item_lscr['conversions_rate'];
                                @endphp
                                @endif
                            @endif
                        @endif
                    @endforeach
                    @if($cut_item == 0)
                        @if($loop->index <= 13)
                <td class="text-right">
                    {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id} * $uomcode['unit'],2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                </td>
                        @endif
                    @else
                        @if($loop->index > 13)
                <td class="text-right">
                    {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id} * $uomcode['unit'],2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                </td>
                        @endif
                    @endif
                @endforeach
            @if($cut_item > 0)
                @foreach ($rework as $item)
                    @php
                        $uomcode = array('unit' => 1);
                    @endphp
                    @foreach ($layout1_secb_convert_rate as $item_lscr)
                        @if (is_object($item_lscr['item_id']))
                            @if ($item_lscr['item_id'] == $item->item_id)
                                @if ($item_lscr['uom_code'] != 'CS1')
                                @php
                                    $uomcode['unit'] = $item_lscr['conversions_rate'];
                                @endphp
                                @endif
                            @endif
                        @endif
                    @endforeach
                <td class="text-right">
                    {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id} * $uomcode['unit'],2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                </td>
                @endforeach
                <td>{{$row->approveqty10 ? number_format($row->approveqty10,2) : ''}}<br />{{$row->orderqty10 ? number_format($row->orderqty10,2) : ''}}</td>
                <td>{{$row->conamount10 ? number_format($row->conamount10,2) : ''}}<br />{{$row->amount10 ? number_format($row->amount10,2) : ''}}</td>
                <td>{{$row->approveqty20 ? number_format($row->approveqty20,2) : ''}}<br />{{$row->orderqty20 ? number_format($row->orderqty20,2) : ''}}</td>
                <td>{{$row->conamount20 ? number_format($row->conamount20,2) : ''}}<br />{{$row->amount20 ? number_format($row->amount20,2) : ''}}</td>
                <td>{{number_format($row->conamount10+$row->conamount20,2)}}<br />{{number_format($row->amount10+$row->amount20,2)}}
                </td>
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
            <!-- รวมยอดฝากขาย -->
            @if(count($layout1_sum_secb_new) > 0)
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดฝากขาย</b></td>
                <td>&nbsp;</td>
                <td>ส่ง<br />สั่ง</td>
                @foreach ($layout1_sum_secb_new['cigarette'] as $item)
                    @php
                        $uomcode = array('unit' => 1);
                    @endphp
                    @foreach ($layout1_secb_convert_rate as $item_lscr)
                        @if (is_object($item_lscr['item_id']))
                            @if ($item_lscr['item_id'] == $item->item_id)
                                @if ($item_lscr['uom_code'] != 'CGK')
                                @php
                                    $uomcode['unit'] = $item_lscr['conversions_rate'];
                                @endphp
                                @endif
                            @endif
                        @endif
                    @endforeach
                    @if($cut_item == 0)
                        @if($loop->index <= 13)
                <td class="text-right">
                    {{ $item['a'] ? number_format($item['a'] * $uomcode['unit'],2) : '' }}<br />{{ $item['o'] ? number_format($item['o'],2) : '' }}
                </td>
                        @endif
                    @else
                        @if($loop->index > 13)
                <td class="text-right">
                    {{ $item['a'] ? number_format($item['a'] * $uomcode['unit'],2) : '' }}<br />{{ $item['o'] ? number_format($item['o'],2) : '' }}
                </td>
                        @endif
                    @endif
                @endforeach
            @if($cut_item > 0)
                @foreach ($layout1_sum_secb_new['rework'] as $item)
                    @php
                        $uomcode = array('unit' => 1);
                    @endphp
                    @foreach ($layout1_secb_convert_rate as $item_lscr)
                        @if (is_object($item_lscr['item_id']))
                            @if ($item_lscr['item_id'] == $item->item_id)
                                @if ($item_lscr['uom_code'] != 'CS1')
                                @php
                                    $uomcode['unit'] = $item_lscr['conversions_rate'];
                                @endphp
                                @endif
                            @endif
                        @endif
                    @endforeach
                <td class="text-right">
                    {{ $item['a'] ? number_format($item['a'] * $uomcode['unit'],2) : '' }}<br />{{ $item['o'] ? number_format($item['o'],2) : '' }}
                </td>
                @endforeach
                <td>{{$layout1_sum_secb_new['qty'][0]['approveqty10'] ? number_format($layout1_sum_secb_new['qty'][0]['approveqty10'],2) : ''}}<br />{{$layout1_sum_secb_new['qty'][0]['orderqty10'] ? number_format($layout1_sum_secb_new['qty'][0]['orderqty10'],2) : ''}}</td>
                <td>{{$layout1_sum_secb_new['qty'][1]['conamount10'] ? number_format($layout1_sum_secb_new['qty'][1]['conamount10'],2) : ''}}<br />{{$layout1_sum_secb_new['qty'][1]['amount10'] ? number_format($layout1_sum_secb_new['qty'][1]['amount10'],2) : ''}}</td>
                <td>{{$layout1_sum_secb_new['qty'][2]['approveqty20'] ? number_format($layout1_sum_secb_new['qty'][2]['approveqty20'],2) : ''}}<br />{{$layout1_sum_secb_new['qty'][2]['orderqty20'] ? number_format($layout1_sum_secb_new['qty'][2]['orderqty20'],2) : ''}}</td>
                <td>{{$layout1_sum_secb_new['qty'][3]['conamount20'] ? number_format($layout1_sum_secb_new['qty'][3]['conamount20'],2) : ''}}<br />{{$layout1_sum_secb_new['qty'][3]['amount20'] ? number_format($layout1_sum_secb_new['qty'][3]['amount20'],2) : ''}}</td>
                <td>{{number_format($layout1_sum_secb_new['qty'][4]['conamount10conamount20'],2)}}<br />{{number_format($layout1_sum_secb_new['qty'][4]['amount10amount20'],2)}}</td>
            @endif
            </tr>
            @else
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp;รวมยอดฝากขาย</b></td>
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
        <!-- ****  ไม่อบจ **** ** ส่งเสริม ไม่คิดมูลค่า ** -->
        <tbody>
            <tr>
                <td><b>***ไม่อบจ***</b><br />** ส่งเสริม ไม่คิดมูลค่า **</td>
            @if($cut_item > 0)
                <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
            @endif
            </tr>
            @foreach($layout1_secc as $row)
            <tr>
                <td>{{$row->pick_release_no}}</td>
                <td style="white-space: nowrap;">{{$row->customer_name}}</td>
                <td>ส่ง<br />สั่ง</td>
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
                <td>{{number_format($row->conamount10+$row->conamount20,2)}}<br />{{number_format($row->amount10+$row->amount20,2)}}
                </td>
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
            <!-- รวมยอดส่งเสริม ไม่คิดมูลค่า -->
            @if(count($layout1_sum_secc_new) > 0)
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดส่งเสริม ไม่คิดมูลค่า</b></td>
                <td>&nbsp;</td>
                <td>ส่ง<br />สั่ง</td>
                @foreach ($layout1_sum_seca_new['cigarette'] as $item)
                    @if($cut_item == 0)
                        @if($loop->index <= 13)
                <td class="text-right">
                    {{ $item['a'] ? number_format($item['a'],2) : '' }}<br />{{ $item['o'] ? number_format($item['o'],2) : '' }}
                </td>
                        @endif
                    @else
                        @if($loop->index > 13)
                <td class="text-right">
                    {{ $item['a'] ? number_format($item['a'],2) : '' }}<br />{{ $item['o'] ? number_format($item['o'],2) : '' }}
                </td>
                        @endif
                    @endif
                @endforeach
            @if($cut_item > 0)
                @foreach ($layout1_sum_seca_new['rework'] as $item)
                <td class="text-right">
                    {{ $item['a'] ? number_format($item['a'],2) : '' }}<br />{{ $item['o'] ? number_format($item['o'],2) : '' }}
                </td>
                @endforeach
                <td>{{$layout1_sum_secc_new['qty'][0]['approveqty10'] ? number_format($layout1_sum_secc_new['qty'][0]['approveqty10'],2) : ''}}<br />{{$layout1_sum_secc_new['qty'][0]['orderqty10'] ? number_format($layout1_sum_secc_new['qty'][0]['orderqty10'],2) : ''}}</td>
                <td>{{$layout1_sum_secc_new['qty'][1]['conamount10'] ? number_format($layout1_sum_secc_new['qty'][1]['conamount10'],2) : ''}}<br />{{$layout1_sum_secc_new['qty'][1]['amount10'] ? number_format($layout1_sum_secc_new['qty'][1]['amount10'],2) : ''}}</td>
                <td>{{$layout1_sum_secc_new['qty'][2]['approveqty20'] ? number_format($layout1_sum_secc_new['qty'][2]['approveqty20'],2) : ''}}<br />{{$layout1_sum_secc_new['qty'][2]['orderqty20'] ? number_format($layout1_sum_secc_new['qty'][2]['orderqty20'],2) : ''}}</td>
                <td>{{$layout1_sum_secc_new['qty'][3]['conamount20'] ? number_format($layout1_sum_secc_new['qty'][3]['conamount20'],2) : ''}}<br />{{$layout1_sum_secc_new['qty'][3]['amount20'] ? number_format($layout1_sum_secc_new['qty'][3]['amount20'],2) : ''}}</td>
                <td>{{number_format($layout1_sum_secc_new['qty'][4]['conamount10conamount20'],2)}}<br />{{number_format($layout1_sum_secc_new['qty'][4]['amount10amount20'],2)}}</td>
            @endif
            </tr>
            @else
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp;รวมยอดส่งเสริม ไม่คิดมูลค่า</b></td>
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
        <!-- รวมยอดขาย ไม่ อบจ. -->
        @if(count($layout1_sum_groupa) > 0)
        <tbody>
            @foreach($layout1_sum_groupa as $row)
            <tr>
                <td><b>&nbsp; รวมยอดขาย ไม่ อบจ.</b></td>
                <td>&nbsp;</td>
                <th>ส่ง<br />สั่ง</th>
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
                <td>{{number_format($row->conamount10+$row->conamount20,2)}}<br />{{number_format($row->approveqty10+$row->approveqty20,2)}}
                </td>
            @endif
            </tr>
            @endforeach
        </tbody>
        @else
        <tr>
            <td style="white-space: nowrap;"><b>&nbsp; รวมยอดขาย ไม่ อบจ.</b></td>
        @if($cut_item > 0)
            <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
        @endif
        </tr>
        @endif
        <tr>
            @if($cut_item == 0)
            <td colspan="{{2+count($cigarette)}}"><hr width="100%"></td>
            @else
            <td colspan="{{(count($cigarette)-14)+count($rework)+8}}"><hr width="100%"></td>
            @endif
        </tr>
        <!-- ****  อบจ ****  ** ร้านค้าป. 1 ** -->
        <tbody>
            <tr>
                <td><b>***อบจ***</b><br />** ร้านค้าป. 1 **</td>
            @if($cut_item > 0)
                <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
            @endif
            </tr>
            @foreach($layout1_secd as $row)
            <tr>
                <td>{{$row->pick_release_no}}</td>
                <td style="white-space: nowrap;">{{$row->customer_name}}</td>
                <td>ส่ง<br />สั่ง</td>
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
                <td>{{number_format($row->conamount10+$row->conamount20,2)}}<br />{{number_format($row->amount10+$row->amount20,2)}}
                </td>
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
            <!-- รวมยอดต่างจังหวัด -->
            @if(count($layout1_sum_secd) > 0)
            @foreach($layout1_sum_secd as $row)
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดต่างจังหวัด</b></td>
                <td>&nbsp;</td>
                <td>ส่ง<br />สั่ง</td>
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
                <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br />{{number_format($row->conamount10+$row->conamount20,2)}}</td>
            @endif
            </tr>
            @endforeach
            @else
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดต่างจังหวัด </b></td>
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
        <!-- ****  อบจ **** ** ฝากสโมสรยาสูบขาย ** -->
        <tbody>
            <tr>
                <td><b>***อบจ***</b><br />** ฝากสโมสรยาสูบขาย **</td>
            @if($cut_item > 0)
                <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
            @endif
            </tr>
            @foreach($layout1_sece as $row)
            <tr>
                <td>{{$row->consignment_no}}</td>
                <td style="white-space: nowrap;">{{$row->customer_name}}</td>
                <td>ส่ง<br />สั่ง</td>
                @foreach ($cigarette as $item)
                    @php
                        $uomcode = array('unit' => 1);
                    @endphp
                    @foreach ($layout1_secb_convert_rate as $item_lscr)
                        @if (is_object($item_lscr['item_id']))
                            @if ($item_lscr['item_id'] == $item->item_id)
                                @if ($item_lscr['uom_code'] != 'CGK')
                                @php
                                    $uomcode['unit'] = $item_lscr['conversions_rate'];
                                @endphp
                                @endif
                            @endif
                        @endif
                    @endforeach
                    @if($cut_item == 0)
                        @if($loop->index <= 13)
                <td class="text-right">
                    {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id} * $uomcode['unit'],2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                </td>
                        @endif
                    @else
                        @if($loop->index > 13)
                <td class="text-right">
                    {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id} * $uomcode['unit'],2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                </td>
                        @endif
                    @endif
                @endforeach
            @if($cut_item > 0)
                @foreach ($rework as $item)
                    @php
                        $uomcode = array('unit' => 1);
                    @endphp
                    @foreach ($layout1_secb_convert_rate as $item_lscr)
                        @if (is_object($item_lscr['item_id']))
                            @if ($item_lscr['item_id'] == $item->item_id)
                                @if ($item_lscr['uom_code'] != 'CS1')
                                @php
                                    $uomcode['unit'] = $item_lscr['conversions_rate'];
                                @endphp
                                @endif
                            @endif
                        @endif
                    @endforeach
                <td class="text-right">
                    {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id} * $uomcode['unit'],2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                </td>
                @endforeach
                <td>{{$row->approveqty10 ? number_format($row->approveqty10,2) : ''}}<br />{{$row->orderqty10 ? number_format($row->orderqty10,2) : ''}}</td>
                <td>{{$row->conamount10 ? number_format($row->conamount10,2) : ''}}<br />{{$row->amount10 ? number_format($row->amount10,2) : ''}}</td>
                <td>{{$row->approveqty20 ? number_format($row->approveqty20,2) : ''}}<br />{{$row->orderqty20 ? number_format($row->orderqty20,2) : ''}}</td>
                <td>{{$row->conamount20 ? number_format($row->conamount20,2) : ''}}<br />{{$row->amount20 ? number_format($row->amount20,2) : ''}}</td>
                <td>{{number_format($row->amount10+$row->amount20,2)}}<br />{{number_format($row->conamount10+$row->conamount20,2)}}
                </td>
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
            <!-- รวมยอดฝากขาย -->
            @if(count($layout1_sum_sece) > 0)
            @foreach($layout1_sum_sece as $row)
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดฝากขาย</b></td>
                <td>&nbsp;</td>
                <td>ส่ง<br />สั่ง</td>
                @foreach ($cigarette as $item)
                    @php
                        $uomcode = array('unit' => 1);
                    @endphp
                    @foreach ($layout1_secb_convert_rate as $item_lscr)
                        @if (is_object($item_lscr['item_id']))
                            @if ($item_lscr['item_id'] == $item->item_id)
                                @if ($item_lscr['uom_code'] != 'CGK')
                                @php
                                    $uomcode['unit'] = $item_lscr['conversions_rate'];
                                @endphp
                                @endif
                            @endif
                        @endif
                    @endforeach
                    @if($cut_item == 0)
                        @if($loop->index <= 13)
                <td class="text-right">
                    {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id} * $uomcode['unit'],2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                </td>
                        @endif
                    @else
                        @if($loop->index > 13)
                <td class="text-right">
                    {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id} * $uomcode['unit'],2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                </td>
                        @endif
                    @endif
                @endforeach
            @if($cut_item > 0)
                @foreach ($rework as $item)
                    @php
                        $uomcode = array('unit' => 1);
                    @endphp
                    @foreach ($layout1_secb_convert_rate as $item_lscr)
                        @if (is_object($item_lscr['item_id']))
                            @if ($item_lscr['item_id'] == $item->item_id)
                                @if ($item_lscr['uom_code'] != 'CS1')
                                @php
                                    $uomcode['unit'] = $item_lscr['conversions_rate'];
                                @endphp
                                @endif
                            @endif
                        @endif
                    @endforeach
                <td class="text-right">
                    {{ $row->{'a'.$item->item_id} ? number_format($row->{'a'.$item->item_id} * $uomcode['unit'],2) : '' }}<br />{{ $row->{'o'.$item->item_id} ? number_format($row->{'o'.$item->item_id},2) : '' }}
                </td>
                @endforeach
                <td>{{$row->approveqty10 ? number_format($row->approveqty10,2) : ''}}<br />{{$row->orderqty10 ? number_format($row->orderqty10,2) : ''}}</td>
                <td>{{$row->conamount10 ? number_format($row->conamount10,2) : ''}}<br />{{$row->amount10 ? number_format($row->amount10,2) : ''}}</td>
                <td>{{$row->approveqty20 ? number_format($row->approveqty20,2) : ''}}<br />{{$row->orderqty20 ? number_format($row->orderqty20,2) : ''}}</td>
                <td>{{$row->conamount20 ? number_format($row->conamount20,2) : ''}}<br />{{$row->amount20 ? number_format($row->amount20,2) : ''}}</td>
                <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br />{{number_format($row->conamount10+$row->conamount20,2)}}
                </td>
            @endif
            </tr>
            @endforeach
            @else
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดฝากขาย</b></td>
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
        <!-- ****  อบจ ****  ** ส่งเสริม ไม่คิดมูลค่า ** -->
        <tbody>
            <tr>
                <td><b>***อบจ***</b><br />** ส่งเสริม ไม่คิดมูลค่า **</td>
            @if($cut_item > 0)
                <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
            @endif
            </tr>
            @foreach($layout1_secf as $row)
            <tr>
                <td>
                    <span class="text-center" style="white-space: nowrap;"><b>{{ ($row->province_code==10 ? '***ไม่อบจ***':'***อบจ***')}}</b></span>
                    <br />
                    <span class="text-center" style="white-space: nowrap;">{{ isset($custtype[$row->customer_type_id])?$custtype[$row->customer_type_id]:''}}</span>
                    <br />
                    {{$row->pick_release_no}}
                </td>
                <td style="white-space: nowrap;">{{$row->customer_name}}</td>
                <td>ส่ง<br />สั่ง</td>
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
                <td>{{number_format($row->amount10+$row->amount20,2)}}<br />{{number_format($row->conamount10+$row->conamount20,2)}}
                </td>
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
            <!-- รวมยอดส่งเสริม ไม่คิดมูลค่า -->
            @if(count($layout1_sum_secf) > 0)
            @foreach($layout1_sum_secf as $row)
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดส่งเสริม ไม่คิดมูลค่า</b></td>
                <td>&nbsp;</td>
                <td>{{($row->approveqty10+$row->approveqty20) ? 'ส่ง<br />สั่ง' : ''}}</td>
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
                <td>{{($row->approveqty10+$row->approveqty20) ? number_format($row->approveqty10+$row->approveqty20,2) : ''}}<br />{{($row->conamount10+$row->conamount20) ? number_format($row->conamount10+$row->conamount20,2) : ''}}
                </td>
            @endif
            </tr>
            @endforeach
            @else
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดส่งเสริม ไม่คิดมูลค่า</b></td>
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
        <!-- รวมยอดขาย อบจ. -->
        @if(count($layout1_sum_groupb) > 0)
        <tbody>
            @foreach($layout1_sum_groupb as $row)
            <tr>
                <td><b>&nbsp; รวมยอดขาย อบจ.</b></td>
                <td>&nbsp;</td>
                <td>ส่ง<br />สั่ง</td>
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
                <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br />{{number_format($row->conamount10+$row->conamount20,2)}}
                </td>
            @endif
            </tr>
            @endforeach
        </tbody>
        @else
        <tr>
            <td style="white-space: nowrap;"><b>&nbsp; รวมยอดขาย อบจ.</b></td>
        @if($cut_item > 0)
                <td colspan="{{(count($cigarette)-14)+count($rework)+5}}">&nbsp;</td>
            @endif
        </tr>
        @endif
        <tr>
            @if($cut_item == 0)
            <td colspan="{{2+count($cigarette)}}"><hr width="100%"></td>
            @else
            <td colspan="{{(count($cigarette)-14)+count($rework)+8}}"><hr width="100%"></td>
            @endif
        </tr>
        <!-- รวมยอดขาย อบจ. และไม่อบจ. -->
        @if(count($layout1_sum_groupab) > 0)
        <tbody>
            @foreach($layout1_sum_groupab as $row)
            <tr>
                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดขาย อบจ. และไม่อบจ.</b></td>
                <td>&nbsp;</td>
                <td>ส่ง<br />สั่ง</td>
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
                <td>{{number_format($row->conamount10+$row->conamount20,2)}}<br />{{number_format($row->approveqty10+$row->approveqty20,2)}}
                </td>
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
                    <tr>
                        <td align="center" colspan="3">จบรายงาน</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
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
