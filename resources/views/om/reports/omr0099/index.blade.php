<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>รายงานภาษีอบจ. แยกรายจังหวัดและร้านค้า</title>
    @include('om.reports.omr0099._style')
</head>
</head>

<body>
    @php 
    $i = 1;
    $n = 1;
    $sum_carton = 0;
    $sumary = 0;
    @endphp
        
        <div style="page-break-after: always;"> </div>

        <table width="100%" class="border_gray" style="border:none;border-bottom:1px solid #000">
            <thead>
                <tr>
                    <td colspan="7" style="background-color: #fff;border:none;">
                        @include('om.reports.omr0099.header')
                    </td>
                </tr>
                {{-- <tr>
                    <td colspan="5" style="font-weight: bold;background-color: #fff;border:none; @if(!$loop->first) border-right:1px solid #000; border-left:1px solid #000;  @endif">{{$market}}</td>
                </tr> --}}
                <tr style="background:#F0F0F0;">
                    <th class="left top bottom" height="35" width="5%" align="center">ลำดับ</th>
                    <th class="left top bottom" height="35" width="25%" align="center">ร้านค้า</th>
                    <th class="left top bottom" height="35" width="15%" align="center">สำนักงานพื้นที่</th>
                    <th class="left top bottom" height="35" width="20%" align="center">ซอย ถนน ตำบล</th>
                    <th class="left top bottom right" height="35" width="20%" align="center">อำเภอ จังหวัด รหัส</th>
                    <th class="left top bottom right" height="35" width="20%" align="center">พันมวน</th>
                    <th class="left top bottom right" height="35" width="20%" align="center">เงินภาษี อบจ.</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->sortBy(function($i) {
                    // $set = 0;
                    // switch ($i->region_code) {
                    //     case 'ภาคกลาง':
                    //         $set = 1;
                    //         break;
                    //     case 'ภาคเหนือ':
                    //         $set = 2;
                    //         break;
                    //     case 'ภาคตะวันออกเฉียงเหนือ':
                    //         $set = 3;
                    //         break;
                    //     case 'ภาคใต้':
                    //         $set = 4;
                    //         break;
                    //     default:
                    //         $set = 5;
                    //         break;
                    // }
                    switch ($i->region_code) {
                        case 'ภาคกลาง':
                            return 1;
                            break;
                        case 'ภาคตะวันตก':
                            return 2;
                            break;
                        case 'ภาคตะวันออกเฉียงเหนือ':
                            return 3;
                            break;
                        case 'ภาคเหนือ':
                            return 4;
                            break;
                        case 'ภาคใต้':
                            return 5;
                            break;
                        default:
                            return 5;
                            break;
                    }
                })->groupBy('region_code') as $market => $data)
                    {{-- return $set. $i->province_name;
                })->groupBy('province_name') as $province => $items) --}}
                {{-- @php 
                    $m = 0;
                    
                @endphp --}}
                @foreach($data->sortBy('province_name')->groupBy('province_name') as $province => $items)
                @php 
                    $m = 0;
                    
                @endphp
                @foreach($items->sortBy('customer_name')->groupBy('customer_number') as $item)
                @php 
                if($m == 0) {
                    $m++;
                    // continue;
                }
                // $consignment_qty = $item->where('consignment_quantity', '>', 0)->sum('consignment_quantity');
                // $tax_per_qty = $item->unique(function($i) {
                //     return $i->customer_id.$i->pao_percent_inv_id;
                // })->whereNotNull('tax_per_qty')->sum('tax_per_qty');
                // $approve_qty = $item->where('approve_quantity', '>', 0)->sum('approve_quantity');
                // if(count($item->whereNotNull('tax_per_qty')) > 0) {
                //     $carton = $tax_per_qty;
                // } elseif($consignment_qty > 0) {
                //     $carton = $consignment_qty;
                // } else {
                //     $carton = $approve_qty;
                // }
                // $sum_carton += $carton;
                // $subtotal = $carton * $taxRate->tag;
                // $sumary += $subtotal;
                        $p_qty = $item->sum('p_qty');
                        $subtotal = $p_qty * 93;

                        $sum_carton += $p_qty;
                        $sumary += $subtotal;
                        $ship = optional(\DB::table('PTOM_CUSTOMER_SHIP_SITES')->where('customer_id', $item->first()->customer_id)->where('ship_to_site_name', 'อบจ')->first());

                @endphp
                <tr>
                    <td class="left bottom " width="5%" align="center">
                        {{$n}}
                    </td>
                    <td class="right bottom " width="25%">&nbsp;{{$item->first()->customer_name}}</td>
                    <td class="right bottom right " width="20%">องค์การบริหารส่วนจังหวัด {{$item->first()->province_name}}</td>
                    <td class="right bottom " width="15%">{{ $ship->address_line1 ?? $item->first()->address_line1}} {{ $ship->alley ?? $item->first()->alley}} {{ $ship->district ?? $item->first()->district}}</td>
                    <td class="right bottom " width="20%">{{ $ship->city ?? $item->first()->city}} {{ $ship->province_name ?? $item->first()->province_name}} {{ $ship->postal_code ?? $item->first()->postal_code}}</td>
                    <td class="right bottom right " align="right" width="20%">{{ number_format($p_qty, 2) }}</td>
                    <td class="right bottom right " align="right" width="20%">{{ number_format($subtotal, 2) }}</td>
                </tr>
               @php
                        $n++;
               @endphp
                @endforeach
                @endforeach
                @php 
                $i++;
                @endphp
                @endforeach
                <tr>
                    <td class="left bottom ">&nbsp;</td>
                    <td class="left bottom ">&nbsp;</td>
                    <td class="left bottom ">&nbsp;</td>
                    <td class="left bottom "></td>
                    <td class="left bottom "></td>
                    <td class="left bottom "></td>
                    <td class="left bottom right "></td>
                </tr>
                <tr class=" border-rigth-none border-left-none ">
                    <th width="45%" height="30" valign="middle" class="top bottom left " align="right"
                        colspan="4">รวมทั้งสิ้น &nbsp;</th>
                    <th width="15%" class="top bottom left border-rigth-none" align="right">&nbsp;</th>
                    <th width="20%" class="top bottom" align="right">{{number_format($sum_carton, 2)}}</th>
                    <th width="20%" class="top bottom right" align="right">
                        {{number_format($sumary, 2)}} </th>
                </tr>
            </tbody>
        </table>
            {{-- <table width="100%" class="border_top_bottom" style="margin-top:5px">
                <tbody>
                    <tr class=" border-rigth-none border-left-none ">
                        <th width="45%" height="30" valign="middle" class="top bottom left " align="right"
                            colspan="2">รวมทั้งสิ้น &nbsp;</th>
                        <th width="15%" class="top bottom left border-rigth-none" align="right">&nbsp;</th>
                        <th width="20%" class="top bottom" align="right">{{number_format($sum_carton, 2)}}</th>
                        <th width="20%" class="top bottom right" align="right">
                            {{number_format($sumary, 2)}} </th>
                    </tr>
                </tbody>
            </table> --}}
            <table width="100%" style="margin-top:5px;">
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td colspan="4">หมายเหตุรายการ: {{ @$remark }} </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="4">จบรายงาน</td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>ผู้จัดทำ __________________________</td>
                                <td>ผู้ตรวจทาน __________________________</td>
                                <td>หัวหน้ากอง __________________________</td>
                                <td>หัวหน้าส่วนงาน __________________________</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
</body>

</html>
