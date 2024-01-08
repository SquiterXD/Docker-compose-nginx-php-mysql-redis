<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @include('om.reports._style')
</head>

<body>
    <div style="min-height: 120px;">
        <table border="0" width="100%" style="font-size: 12px;">
            <tr>
                <td width="25%" class="text-left">
                    <div>
                        <div style="width: 100%;" class="text-left tw-inline-block tw-font-bold"> โปรแกรม :
                            {{ $programCode }} </div>
                    </div>

                    <div>
                        <div style="width: 100%;" class="text-left tw-inline-block tw-font-bold"> สั่งพิมพ์ :
                            {{ $user }} </div>
                    </div>
                    <div>
                        &nbsp;
                    </div>
                </td>
                <td width="50%" class="text-left">
                    <div>
                        <h5 class="text-center tw-font-bold" style="padding-bottom: 2px;"> การยาสูบแห่งประเทศไทย </h5>
                    </div>
                    <div>
                        <div class="text-center tw-font-bold"> รายการจำหน่ายยาสูบ/ยาเส้น (รต/1) </div>
                    </div>
                    <div>
                        <div class="text-center tw-font-bold"> วันที่ {{ $approve_date }}</div>
                    </div>
                </td>
                <td width="25%" class="text-right">
                    <div>
                        <div style="width: 30%;" class="text-right tw-inline-block tw-font-bold"> วันที่: </div>
                        <div style="width: 40%;" class="text-left tw-inline-block"> {{ $nowDateTH }} </div>
                    </div>
                    <div>
                        <div style="width: 30%;" class="text-right tw-inline-block tw-font-bold"> เวลา: </div>
                        <div style="width: 40%;" class="text-left tw-inline-block"> {{ date("H:i") }} </div>
                    </div>
                    <div>
                        <div style="width: 30%;" class="text-right tw-inline-block tw-font-bold"> หน้า: </div>
                        <div style="width: 40%;" class="text-left tw-inline-block"> {{ $page }} </div>
                    </div>
                </td>
            </tr>
        </table>
        <hr />
        <table border="1" width="100%" style="font-size: 12px;">
            <thead>
                <tr style="background:#F0F0F0;">
                    <th class="text-center" rowspan="2">เลขที่ใบกำกับสินค้า</th>
                    <th class="text-center nowarp" colspan="2" rowspan="2">ชื่อร้านค้า</th>
                    <th class="text-center" colspan="{{count($cigarette)}}" class="text-center">บุหรี่</th>
                    <th class="text-center" colspan="{{count($rework)}}" class="text-center">ยาเส้น</th>
                    <th class="text-center" rowspan="2" >ยอดรวมบุหรี่</th>
                    <th class="text-center" rowspan="2" >จำนวนเงินบุหรี่</th>
                    <th class="text-center" rowspan="2" >ยอดรวมยาเส้น</th>
                    <th class="text-center" rowspan="2" >จำนวนเงินยาเส้น</th>
                    <th class="text-center" rowspan="2" >รวมจำนวนเงินทั้งสิ้น</th>
                </tr>
                <tr style="background:#F0F0F0;">
                    @foreach ($cigarette as $item)
                    <th class="text-center">{{ $item->item_description }}</th>
                    @endforeach
                    @foreach ($rework as $item)
                    <th class="text-center">{{ $item->item_description }}</th>
                    @endforeach
                </tr>
            </thead>
            <tr><td colspan="{{8+count($cigarette)+count($rework)}}"><br/>seca<hr/><br/></td></tr>
            <tbody>
                @foreach($layout1_seca as $row)
                <tr>
                    <td>
                        <span class="text-center" style="white-space: nowrap;" >{{($row->province_code==10?'***ไม่อบจ***':'***อบจ***')}}</span>
                        <br/>
                        <span class="text-center" style="white-space: nowrap;" >{{ isset($custtype[$row->customer_type_id])?$custtype[$row->customer_type_id]:''}}</span>
                        <br/>
                        {{$row->pick_release_no}}</td>
                    <td>{{$row->customer_name}}</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                    <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                    <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                    <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                    <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                    <td>{{number_format($row->amount10+$row->amount20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>
                </tr>
                @endforeach

                @foreach($layout1_sum_seca as $row)
                <tr>
                    <td>&nbsp; รวมยอดกทม</td>
                    <td>&nbsp;</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                        <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                        <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                        <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                        <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>                </tr>
                @endforeach
            </tbody>
            <tr><td colspan="{{8+count($cigarette)+count($rework)}}"><br/>secb<hr/><br/></td></tr>
            <tbody>
                @foreach($layout1_secb as $row)
                <tr>
                    <td>
                        <span class="text-center" style="white-space: nowrap;" >{{ ($row->province_code==10 ? '***ไม่อบจ***':'***อบจ***')}}</span>
                        <br/>
                        <span class="text-center" style="white-space: nowrap;" >{{ isset($custtype[$row->customer_type_id])?$custtype[$row->customer_type_id]:''}}</span>
                        <br/>
                        {{$row->pick_release_no}}</td>
                    <td>{{$row->customer_name}}</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                    <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                    <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                    <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                    <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                    <td>{{number_format($row->amount10+$row->amount20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>
                </tr>
                @endforeach

                @foreach($layout1_sum_secb as $row)
                <tr>
                    <td>&nbsp; รวมยอดฝากขาย</td>
                    <td>&nbsp;</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                        <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                        <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                        <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                        <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>                </tr>
                @endforeach
            </tbody>
            <tr><td colspan="{{8+count($cigarette)+count($rework)}}"><br/>secc<hr/><br/></td></tr>
            <tbody>
                @foreach($layout1_secc as $row)
                <tr>
                    <td>
                        <span class="text-center" style="white-space: nowrap;" >{{ ($row->province_code==10 ? '***ไม่อบจ***':'***อบจ***')}}</span>
                        <br/>
                        <span class="text-center" style="white-space: nowrap;" >{{ isset($custtype[$row->customer_type_id])?$custtype[$row->customer_type_id]:''}}</span>
                        <br/>
                        {{$row->pick_release_no}}</td>
                    <td>{{$row->customer_name}}</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                    <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                    <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                    <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                    <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                    <td>{{number_format($row->amount10+$row->amount20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>
                </tr>
                @endforeach

                @foreach($layout1_sum_secc as $row)
                <tr>
                    <td>&nbsp; รวมยอดส่งเสริม ไม่คิดมูลค่า</td>
                    <td>&nbsp;</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                        <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                        <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                        <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                        <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>                </tr>
                @endforeach
            </tbody>
            <!-- layout1_sum_groupa -->
            <tr><td colspan="{{8+count($cigarette)+count($rework)}}"><br/>sum-groupa<hr/><br/></td></tr>
            <tbody>
                @foreach($layout1_sum_groupa as $row)
                    <tr>
                        <td>&nbsp; รวมยอดขาย ไม่ อบจ.</td>
                        <td>&nbsp;</td>
                        <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                        <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                        <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                        <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                        <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tr><td colspan="{{8+count($cigarette)+count($rework)}}"><br/>secd<hr/><br/></td></tr>
            <tbody>
                @foreach($layout1_secd as $row)
                <tr>
                    <td>
                        <span class="text-center" style="white-space: nowrap;" >{{ ($row->province_code==10 ? '***ไม่อบจ***':'***อบจ***')}}</span>
                        <br/>
                        <span class="text-center" style="white-space: nowrap;" >{{ isset($custtype[$row->customer_type_id])?$custtype[$row->customer_type_id]:''}}</span>
                        <br/>
                        {{$row->pick_release_no}}</td>
                    <td>{{$row->customer_name}}</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                    <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                    <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                    <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                    <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                    <td>{{number_format($row->amount10+$row->amount20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>
                </tr>
                @endforeach

                @foreach($layout1_sum_secd as $row)
                <tr>
                    <td>&nbsp; รวมยอดต่างจังหวัด</td>
                    <td>&nbsp;</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                        <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                        <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                        <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                        <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>                </tr>
                @endforeach
            </tbody>
            <tr><td colspan="{{8+count($cigarette)+count($rework)}}"><br/>sece<hr/><br/></td></tr>
            <tbody>
                @foreach($layout1_sece as $row)
                <tr>
                    <td>
                        <span class="text-center" style="white-space: nowrap;" >{{ ($row->province_code==10 ? '***ไม่อบจ***':'***อบจ***')}}</span>
                        <br/>
                        <span class="text-center" style="white-space: nowrap;" >{{ isset($custtype[$row->customer_type_id])?$custtype[$row->customer_type_id]:''}}</span>
                        <br/>
                        {{$row->pick_release_no}}</td>
                    <td>{{$row->customer_name}}</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                    <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                    <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                    <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                    <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                    <td>{{number_format($row->amount10+$row->amount20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>
                </tr>
                @endforeach

                @foreach($layout1_sum_sece as $row)
                <tr>
                    <td>&nbsp; รวมยอดฝากขาย</td>
                    <td>&nbsp;</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                        <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                        <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                        <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                        <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>                </tr>
                @endforeach
            </tbody>
            <tr><td colspan="{{8+count($cigarette)+count($rework)}}"><br/>secf<hr/><br/></td></tr>
            <tbody>
                @foreach($layout1_secf as $row)
                <tr>
                    <td>
                        <span class="text-center" style="white-space: nowrap;" >{{ ($row->province_code==10 ? '***ไม่อบจ***':'***อบจ***')}}</span>
                        <br/>
                        <span class="text-center" style="white-space: nowrap;" >{{ isset($custtype[$row->customer_type_id])?$custtype[$row->customer_type_id]:''}}</span>
                        <br/>
                        {{$row->pick_release_no}}</td>
                    <td>{{$row->customer_name}}</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                        <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                    <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                    <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                    <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                    <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                    <td>{{number_format($row->amount10+$row->amount20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>
                </tr>
                @endforeach

                @foreach($layout1_sum_secf as $row)
                <tr>
                    <td>&nbsp; รวมยอดส่งเสริม ไม่คิดมูลค่า</td>
                    <td>&nbsp;</td>
                    <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                        <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                        <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                        <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                        <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>                </tr>
                @endforeach
            </tbody>
            <!-- layout1_sum_groupb -->
            <tr><td colspan="{{8+count($cigarette)+count($rework)}}"><br/>sum-groupb<hr/><br/></td></tr>
            <tbody>
                @foreach($layout1_sum_groupb as $row)
                    <tr>
                        <td>&nbsp; รวมยอดขาย ไม่ อบจ.</td>
                        <td>&nbsp;</td>
                        <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                        <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                        <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                        <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                        <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>
                    </tr>
                @endforeach
            </tbody>
            <!-- layout1_sum_groupab -->
            <tr><td colspan="{{8+count($cigarette)+count($rework)}}"><br/>sum-groupab<hr/><br/></td></tr>
            <tbody>
                @foreach($layout1_sum_groupab as $row)
                    <tr>
                        <td>&nbsp; รวมยอดขาย อบจ. และไม่อบจ.</td>
                        <td>&nbsp;</td>
                        <th>ส่ง<br/>สั่ง</th>
                        @foreach ($cigarette as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        @foreach ($rework as $item)
                            <td class="text-right" >{{ number_format($row->{'a'.$item->item_id},2) }}<br/>{{ number_format($row->{'o'.$item->item_id},2) }}</td>
                        @endforeach
                        <td>{{number_format($row->approveqty10,2)}}<br/>{{number_format($row->orderqty10,2)}}</td>
                        <td>{{number_format($row->conamount10,2)}}<br/>{{number_format($row->amount10,2)}}</td>
                        <td>{{number_format($row->approveqty20,2)}}<br/>{{number_format($row->orderqty20,2)}}</td>
                        <td>{{number_format($row->conamount20,2)}}<br/>{{number_format($row->amount20,2)}}</td>
                        <td>{{number_format($row->approveqty10+$row->approveqty20,2)}}<br/>{{number_format($row->conamount10+$row->conamount20,2)}}</td>
                    </tr>
                @endforeach
            </tbody>



        </table>

        <hr />
        <br />
        <br />
        <table border="0" width="100%" style="font-size: 12px;">
            <tr>
                <td style="width:30%;" class="text-center"></td>
                <td style="width:40%;" class="text-center text-top">จบรายงาน</td>
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
    </div>
    <div style="page-break-after: always;"> </div>
</body>

</html>
