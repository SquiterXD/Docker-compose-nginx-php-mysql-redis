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
        table{
            border-collapse: collapse
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
                            <td align="left">โปรแกรม : {{$programCode}}_4 </td>
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
                        <div class="text-center tw-font-bold"> {{ $repname }} </div>
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
    @foreach($layout_data_all as $pn=> $lda)
        @if($pn > 0)
            <pagebreak />
        @endif
        @php
            $last_cigarette = 0;
            $last_rework = 0;
        @endphp
        @foreach($column_header_span as $page_no => $span_arr)
            @php
                $cigarette_cnt = isset($span_arr['บุหรี่']) ? $span_arr['บุหรี่']['colspan'] + $last_cigarette : 0;
                $rework_cnt = isset($span_arr['ยาเส้น']) ? $span_arr['ยาเส้น']['colspan'] + $last_rework : 0;
                $colspan = collect($span_arr)->reduce(function ($carry, $item) {
                    return $carry + $item['colspan'];
                }, 0);
            @endphp
            @if($page_no > 0)
                <pagebreak />
            @endif
            <table border="0" width="100%" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th class="text-center" 
                            rowspan="2" 
                            style="width:120px;border-top:1px solid #000; border-bottom:1px solid #000">เลขที่ใบกำกับสินค้า</th>
                        <th class="nowarp" 
                            rowspan="2" 
                            style=" white-space: nowrap; 
                                    text-align: left !important; 
                                    padding-left:15px;
                                    border-top:1px solid #000; 
                                    border-bottom:1px solid #000">ชื่อร้านค้า</th>
                        <th rowspan="2" style="border-top:1px solid #000; border-bottom:1px solid #000"></th>
                        @foreach($span_arr as $header_name => $span)
                        <th class="text-center" 
                            style="border-top:1px solid #000; border-bottom:1px solid #000" 
                            colspan="{{  $span['colspan'] }}" 
                            rowspan="{{  $span['rowspan'] }}" 
                            width="100px">{{$header_name}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @if(isset($span_arr['บุหรี่']) ||isset($span_arr['ยาเส้น']))
                            @if(isset($span_arr['บุหรี่']))
                                @for($i=$last_cigarette; $i < $cigarette_cnt; $i++)
                                    @php 
                                        $item_description = explode(' ', $cigarette[$i]->item_description, 2);
                                    @endphp
                                    <th class="text-right"  style="border-bottom:1px solid #000" width="100px">{!! @$item_description[0] !!} <br>{!! @$item_description[1] !!}</th>
                                @endfor
                            @endif
                            @if(isset($span_arr['ยาเส้น']))
                                @for($i=$last_rework; $i < $rework_cnt; $i++)
                                    <th class="text-right"  style="border-bottom:1px solid #000" width="100px">{{ $rework[$i]->item_description }}</th>
                                @endfor
                            @endif
                        @else
                            <tr>
                                <td colspan="{{$colspan+3}}">&nbsp;</td>
                            </tr>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    @foreach($lda as $key => $layout_data_detail)
                    
                        @if(($layout_data_detail['section_type']) == 'header')
                            <tr>
                                <td width="140px">
                                    <b>***{{$layout_data_detail['type']}}***</b>
                                    <br/>** {{$layout_data_detail['name']}} **
                                </td>
                                <td colspan="{{$colspan+2}}">&nbsp;</td>
                            </tr>
                        @endif
                        @if(($layout_data_detail['section_type']) == 'detail')
                            @php
                                $row = $layout_data_detail['sec'];
                            @endphp
                            <tr>
                                <td>{{$row->invoice_no}}</td>
                                <td style="white-space: nowrap;">{{$row->customer_name}}</td>
                                <td>ส่ง<br />สั่ง</td>
                                @if(isset($span_arr['บุหรี่']))
                                    @for($i=$last_cigarette; $i < $cigarette_cnt; $i++)
                                        @php
                                        $uomcode = array('unit' => 1);
                                        @endphp
                                        <td style="text-align: right !important" align="right">
                                            {{ $row->{'a'.$cigarette[$i]->item_id} ? number_format($row->{'a'.$cigarette[$i]->item_id}* $uomcode['unit'],2) : '' }}<br />{{ $row->{'o'.$cigarette[$i]->item_id} ? number_format($row->{'o'.$cigarette[$i]->item_id},2) : '' }}
                                        </td>
                                    @endfor
                                @endif
                                @if(isset($span_arr['ยาเส้น']))
                                    @for($i=$last_rework; $i < $rework_cnt; $i++)
                                        @php
                                        $uomcode = array('unit' => 1);
                                        @endphp
                                        <td class="text-right" align="right">
                                            {{ $row->{'a'.$rework[$i]->item_id} ? number_format($row->{'a'.$rework[$i]->item_id} * $uomcode['unit'],2) : '' }}<br />{{ $row->{'o'.$rework[$i]->item_id} ? number_format($row->{'o'.$rework[$i]->item_id},2) : '' }}
                                        </td>
                                    @endfor
                                @endif
                                @if(isset($span_arr['ยอดรวมบุหรี่']))
                                    <td align="right">{{$row->submitqty10 ? number_format($row->submitqty10,2) : ''}}<br />{{$row->orderqty10 ? number_format($row->orderqty10,2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['จำนวนเงินบุหรี่']))
                                    <td align="right">{{$row->submitamount10 ? number_format($row->submitamount10,2) : ''}}<br />{{$row->orderamount10 ? number_format($row->orderamount10,2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['ยอดรวมยาเส้น']))
                                    <td align="right">{{$row->submitqty20 ? number_format($row->submitqty20,2) : ''}}<br />{{$row->orderqty20 ? number_format($row->orderqty20,2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['จำนวนเงินยาเส้น']))
                                    <td align="right">{{$row->submitamount20 ? number_format($row->submitamount20,2) : ''}}<br />{{$row->orderamount20 ? number_format($row->orderamount20,2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['รวมจำนวนเงินทั้งสิ้น']))
                                    <td align="right">{{number_format($row->submitamount10+$row->submitamount20,2)}}<br />{{number_format($row->orderamount10+$row->orderamount20,2)}}</td>
                                @endif
                            </tr>
                        @endif
                        @if(($layout_data_detail['section_type']) == 'sum')
                            <tr>
                                <td colspan="{{$colspan+3}}">
                                    <hr width="100%">
                                </td>
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;"><b>&nbsp; รวมยอด{{$layout_data_detail['sum_name']}}</b></td>
                                <td>&nbsp;</td>
                                <td>ส่ง<br />สั่ง</td>
                                @if(isset($span_arr['บุหรี่']))
                                    @php
                                        $sum_key_arr = array_keys($layout_data_detail['sum_sec']['cigarette']);
                                        $sum_sec_cigarette_arr = $layout_data_detail['sum_sec']['cigarette'];
                                    @endphp
                                    @for($i=$last_cigarette; $i < $cigarette_cnt; $i++)
                                        @php
                                        $uomcode = array('unit' => 1);
                                        @endphp
                                            <td class="text-right" align="right">
                                            {{ $sum_sec_cigarette_arr[$sum_key_arr[$i]]['a'] ? number_format($sum_sec_cigarette_arr[$sum_key_arr[$i]]['a']* $uomcode['unit'],2) : '' }}<br />{{ $sum_sec_cigarette_arr[$sum_key_arr[$i]]['o'] ? number_format($sum_sec_cigarette_arr[$sum_key_arr[$i]]['o'],2) : '' }}
                                        </td>
                                    @endfor
                                @endif
                                @if(isset($span_arr['ยาเส้น']))
                                    @php
                                        $sum_sec_key_rework_arr = array_keys($layout_data_detail['sum_sec']['rework']);
                                        $sum_sec_rework_arr = $layout_data_detail['sum_sec']['rework'];
                                    @endphp
                                    @for($i=$last_rework; $i < $rework_cnt; $i++)
                                        <td  class="text-right" align="right" >
                                            {{ $sum_sec_rework_arr[$rework[$i]->item_id]['a'] ? number_format($sum_sec_rework_arr[$rework[$i]->item_id]['a'] * $uomcode['unit'] ,2) : '' }}
                                            <br/>
                                            {{ $sum_sec_rework_arr[$rework[$i]->item_id]['o'] ? number_format($sum_sec_rework_arr[$rework[$i]->item_id]['o'],2) : '' }}
                                            {{-- {{ $rework[$i]->item_description }}{{ ($rework[$i]->item_id) }} --}}
                                        </th>
                                    @endfor
                                    @foreach($sum_sec_key_rework_arr as $i)
                                        @php
                                        $uomcode = array('unit' => 1);
                                        @endphp
                                        {{-- <td class="text-right" align="right">
                                            {{ $sum_sec_rework_arr[$i]['a'] ? number_format($sum_sec_rework_arr[$i]['a'] * $uomcode['unit'] ,2) : '' }}
                                            <br/>
                                            {{ $sum_sec_rework_arr[$i]['o'] ? number_format($sum_sec_rework_arr[$i]['o'],2) : '' }}
                                        </td> --}}
                                    @endforeach
                                @endif
                                @if(isset($span_arr['ยอดรวมบุหรี่']))
                                    <td align="right">{{$layout_data_detail['sum_sec']['qty'][0]['submitqty10'] ? number_format($layout_data_detail['sum_sec']['qty'][0]['submitqty10'],2) : ''}}<br />{{$layout_data_detail['sum_sec']['qty'][0]['orderqty10'] ? number_format($layout_data_detail['sum_sec']['qty'][0]['orderqty10'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['จำนวนเงินบุหรี่']))
                                    <td align="right">{{$layout_data_detail['sum_sec']['qty'][1]['submitamount10'] ? number_format($layout_data_detail['sum_sec']['qty'][1]['submitamount10'],2) : ''}}<br />{{$layout_data_detail['sum_sec']['qty'][1]['orderamount10'] ? number_format($layout_data_detail['sum_sec']['qty'][1]['orderamount10'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['ยอดรวมยาเส้น']))
                                    <td align="right">{{$layout_data_detail['sum_sec']['qty'][2]['submitqty20'] ? number_format($layout_data_detail['sum_sec']['qty'][2]['submitqty20'],2) : ''}}<br />{{$layout_data_detail['sum_sec']['qty'][2]['orderqty20'] ? number_format($layout_data_detail['sum_sec']['qty'][2]['orderqty20'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['จำนวนเงินยาเส้น']))
                                    <td align="right">{{$layout_data_detail['sum_sec']['qty'][3]['submitamount20'] ? number_format($layout_data_detail['sum_sec']['qty'][3]['submitamount20'],2) : ''}}<br />{{$layout_data_detail['sum_sec']['qty'][3]['orderamount20'] ? number_format($layout_data_detail['sum_sec']['qty'][3]['orderamount20'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['รวมจำนวนเงินทั้งสิ้น']))
                                    <td align="right">{{ number_format($layout_data_detail['sum_sec']['qty'][4]['submitamount10submitamount20'],2)}}<br />{{number_format($layout_data_detail['sum_sec']['qty'][4]['orderamount10orderamount20'],2)}}</td>
                                @endif
                            </tr>
                            <tr>
                                <td colspan="{{$colspan + 3}}">
                                    <hr width="100%">
                                </td>
                            </tr>
                        @endif

                        @if(($layout_data_detail['section_type']) == 'sum_all_a')
                            @php
                                $layout_sum_groupa = $layout_data_detail['sum_sec_all'];
                            @endphp
                            <tr>
                                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดขาย ไม่อบจ.</b></td>
                                <td>&nbsp;</td>
                                <td>ส่ง<br />สั่ง</td>
                                @if(isset($span_arr['บุหรี่']))
                                    @for($i=$last_cigarette; $i < $cigarette_cnt; $i++)
                                        <td class="text-right" align="right">
                                            {{ $layout_sum_groupa['a'.$cigarette[$i]->item_id] ? number_format($layout_sum_groupa['a'.$cigarette[$i]->item_id],2) : '' }}<br />{{ $layout_sum_groupa['o'.$cigarette[$i]->item_id] ? number_format($layout_sum_groupa['o'.$cigarette[$i]->item_id],2) : '' }}
                                        </td>
                                    @endfor
                                @endif
                                @if(isset($span_arr['ยาเส้น']))
                                    @for($i=$last_rework; $i < $rework_cnt; $i++)
                                        <td class="text-right" align="right">
                                            {{ $layout_sum_groupa['a'.$rework[$i]->item_id] ? number_format($layout_sum_groupa['a'.$rework[$i]->item_id],2) : '' }}<br />{{ $layout_sum_groupa['o'.$rework[$i]->item_id] ? number_format($layout_sum_groupa['o'.$rework[$i]->item_id],2) : '' }}
                                        </td>
                                    @endfor
                                @endif
                                @if(isset($span_arr['ยอดรวมบุหรี่']))
                                    <td align="right">{{$layout_sum_groupa['submitqty10'] ? number_format($layout_sum_groupa['submitqty10'],2) : ''}}<br />{{$layout_sum_groupa['orderqty10'] ? number_format($layout_sum_groupa['orderqty10'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['จำนวนเงินบุหรี่']))
                                    <td align="right">{{$layout_sum_groupa['submitamount10'] ? number_format($layout_sum_groupa['submitamount10'],2) : ''}}<br />{{$layout_sum_groupa['orderamount10'] ? number_format($layout_sum_groupa['orderamount10'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['ยอดรวมยาเส้น']))
                                    <td align="right">{{$layout_sum_groupa['submitqty20'] ? number_format($layout_sum_groupa['submitqty20'],2) : ''}}<br />{{$layout_sum_groupa['orderqty20'] ? number_format($layout_sum_groupa['orderqty20'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['จำนวนเงินยาเส้น']))
                                    <td align="right">{{$layout_sum_groupa['submitamount20'] ? number_format($layout_sum_groupa['submitamount20'],2) : ''}}<br />{{$layout_sum_groupa['orderamount20'] ? number_format($layout_sum_groupa['orderamount20'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['รวมจำนวนเงินทั้งสิ้น']))
                                    <td align="right">{{number_format($layout_sum_groupa['submitamount10']+$layout_sum_groupa['submitamount20'],2)}}<br />{{number_format($layout_sum_groupa['orderamount10']+$layout_sum_groupa['orderamount20'],2)}}</td>
                                @endif
                            </tr>
                            <tr>
                                <td colspan="{{$colspan + 3}}">
                                    <hr width="100%">
                                </td>
                            </tr>
                        @endif

                        @if(($layout_data_detail['section_type']) == 'sum_all_b')
                            @php
                                $layout_sum_groupb = $layout_data_detail['sum_sec_all'];
                            @endphp
                            <tr>
                                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดขาย อบจ.</b></td>
                                <td>&nbsp;</td>
                                <td>ส่ง<br />สั่ง</td>
                                @if(isset($span_arr['บุหรี่']))
                                    @for($i=$last_cigarette; $i < $cigarette_cnt; $i++)
                                        <td  class="text-right" align="right">
                                            {{ $layout_sum_groupb['a'.$cigarette[$i]->item_id] ? number_format($layout_sum_groupb['a'.$cigarette[$i]->item_id],2) : '' }}<br />{{ $layout_sum_groupb['o'.$cigarette[$i]->item_id] ? number_format($layout_sum_groupb['o'.$cigarette[$i]->item_id],2) : '' }}
                                        </td>
                                    @endfor
                                @endif
                                @if(isset($span_arr['ยาเส้น']))
                                    @for($i=$last_rework; $i < $rework_cnt; $i++)
                                        <td class="text-right" align="right">
                                            {{ $layout_sum_groupb['a'.$rework[$i]->item_id] ? number_format($layout_sum_groupb['a'.$rework[$i]->item_id],2) : '' }}<br />{{ $layout_sum_groupb['o'.$rework[$i]->item_id] ? number_format($layout_sum_groupb['o'.$rework[$i]->item_id],2) : '' }}
                                        </td>
                                    @endfor
                                @endif
                                @if(isset($span_arr['ยอดรวมบุหรี่']))
                                    <td align="right">{{$layout_sum_groupb['submitqty10'] ? number_format($layout_sum_groupb['submitqty10'],2) : ''}}<br />{{$layout_sum_groupb['orderqty10'] ? number_format($layout_sum_groupb['orderqty10'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['จำนวนเงินบุหรี่']))
                                    <td align="right">{{$layout_sum_groupb['submitamount10'] ? number_format($layout_sum_groupb['submitamount10'],2) : ''}}<br />{{$layout_sum_groupb['orderamount10'] ? number_format($layout_sum_groupb['orderamount10'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['ยอดรวมยาเส้น']))
                                    <td align="right">{{$layout_sum_groupb['submitqty20'] ? number_format($layout_sum_groupb['submitqty20'],2) : ''}}<br />{{$layout_sum_groupb['orderqty20'] ? number_format($layout_sum_groupb['orderqty20'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['จำนวนเงินยาเส้น']))
                                    <td align="right">{{$layout_sum_groupb['submitamount20'] ? number_format($layout_sum_groupb['submitamount20'],2) : ''}}<br />{{$layout_sum_groupb['orderamount20'] ? number_format($layout_sum_groupb['orderamount20'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['รวมจำนวนเงินทั้งสิ้น']))
                                    <td align="right">{{number_format($layout_sum_groupb['submitamount10']+$layout_sum_groupb['submitamount20'],2)}}<br />{{number_format($layout_sum_groupb['orderamount10']+$layout_sum_groupb['orderamount20'],2)}}</td>
                                @endif
                            </tr>
                            <tr>
                                <td colspan="{{$colspan + 3}}">
                                    <hr width="100%">
                                </td>
                            </tr>
                        @endif

                        @if(($layout_data_detail['section_type']) == 'sum_all_ab')
                            @php
                                $layout_sum_groupab = $layout_data_detail['sum_sec_all'];
                            @endphp
                            <tr>
                                <td style="white-space: nowrap;"><b>&nbsp; รวมยอดขาย อบจ. และ ไม่อบจ.</b></td>
                                <td>&nbsp;</td>
                                <td>ส่ง<br />สั่ง</td>
                                @if(isset($span_arr['บุหรี่']))
                                    @for($i=$last_cigarette; $i < $cigarette_cnt; $i++)
                                        <td class="text-right" align="right">
                                            {{ $layout_sum_groupab['a'.$cigarette[$i]->item_id] ? number_format($layout_sum_groupab['a'.$cigarette[$i]->item_id],2) : '' }}<br />{{ $layout_sum_groupab['o'.$cigarette[$i]->item_id] ? number_format($layout_sum_groupab['o'.$cigarette[$i]->item_id],2) : '' }}
                                        </td>
                                    @endfor
                                @endif
                                @if(isset($span_arr['ยาเส้น']))
                                    @for($i=$last_rework; $i < $rework_cnt; $i++)
                                        <td class="text-right" align="right">
                                            {{ $layout_sum_groupab['a'.$rework[$i]->item_id] ? number_format($layout_sum_groupab['a'.$rework[$i]->item_id],2) : '' }}<br />{{ $layout_sum_groupab['o'.$rework[$i]->item_id] ? number_format($layout_sum_groupab['o'.$rework[$i]->item_id],2) : '' }}
                                        </td>
                                    @endfor
                                @endif
                                @if(isset($span_arr['ยอดรวมบุหรี่']))
                                    <td align="right">{{$layout_sum_groupab['submitqty10'] ? number_format($layout_sum_groupab['submitqty10'],2) : ''}}<br />{{$layout_sum_groupab['orderqty10'] ? number_format($layout_sum_groupab['orderqty10'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['จำนวนเงินบุหรี่']))
                                    <td align="right">{{$layout_sum_groupab['submitamount10'] ? number_format($layout_sum_groupab['submitamount10'],2) : ''}}<br />{{$layout_sum_groupab['orderamount10'] ? number_format($layout_sum_groupab['orderamount10'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['ยอดรวมยาเส้น']))
                                    <td align="right">{{$layout_sum_groupab['submitqty20'] ? number_format($layout_sum_groupab['submitqty20'],2) : ''}}<br />{{$layout_sum_groupab['orderqty20'] ? number_format($layout_sum_groupab['orderqty20'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['จำนวนเงินยาเส้น']))
                                    <td align="right">{{$layout_sum_groupab['submitamount20'] ? number_format($layout_sum_groupab['submitamount20'],2) : ''}}<br />{{$layout_sum_groupab['orderamount20'] ? number_format($layout_sum_groupab['orderamount20'],2) : ''}}</td>
                                @endif
                                @if(isset($span_arr['รวมจำนวนเงินทั้งสิ้น']))
                                    <td align="right">{{number_format($layout_sum_groupab['submitamount10']+$layout_sum_groupab['submitamount20'],2)}}<br />{{number_format($layout_sum_groupab['orderamount10']+$layout_sum_groupab['orderamount20'],2)}}</td>
                                @endif
                            </tr>
                            <tr>
                                <td colspan="{{$colspan + 3}}">
                                    <hr width="100%">
                                </td>
                            </tr>
                        @endif

                    @endforeach
                </tbody>
            </table>
            @php
                $last_cigarette = $cigarette_cnt;
                $last_rework = $rework_cnt;
            @endphp
        @endforeach
    @endforeach
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
</body>

</html>
