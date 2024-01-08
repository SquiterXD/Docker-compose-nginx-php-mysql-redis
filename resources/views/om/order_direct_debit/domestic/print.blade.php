<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOAT - รายงานการโอนเงินระบบ Direct Debit </title>

    <meta name="csrf-param" content="_token">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('om.order_direct_debit.domestic._style')
</head>
<body>
    <div class="">
        <table class="table maintable" border="0">
            <tr>
                <td width="25%" style="font-size: 18px;"> </td>
                <td width="25%" style="font-size: 18px;" class="text-center"> การยาสูบแห่งประเทศไทย </td>
                <td width="25%" style="font-size: 18px;" class="text-right"> วันที่ : &nbsp;{{ parseToDateTh(date('Y-m-d')) }}</td>
            </tr>
            <tr>
                <td width="25%" style="font-size: 18px;"> สั่งพิมพ์ : &nbsp;{{ auth()->user()->name }} </td>
                <td width="25%" style="font-size: 18px;" class="text-center"> รายงานการโอนเงินระบบ Direct Debit </td>
                <td width="25%" style="font-size: 18px;" class="text-right"> เวลา : &nbsp;{{ date('H:i') }} </td>
            </tr>
        </table>

        <table class="table table-bordered" cellspacing="0"  style="width: 100%; border: 0.5px solid #000; margin-top: 20px;" style="">
            <thead>
                <tr>
                    <th width="6%" class="text-center" style="border: 0.5px solid #000; font-size: 18px;"> เลขที่ใบเตรียมขาย </th>
                    <th width="6%" class="text-center" style="border: 0.5px solid #000; font-size: 18px;"> รหัสลูกค้า </th>
                    <th width="17%" class="text-center" style="border: 0.5px solid #000; font-size: 18px;"> ชื่อร้านค้า </th>
                    <th width="6%" class="text-center" style="border: 0.5px solid #000; font-size: 18px;"> หมายเลขบัญชี </th>
                    <th width="6%" class="text-center" style="border: 0.5px solid #000; font-size: 18px;"> จำนวนเงิน </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach($orders as $order)
                    @php
                        $total += $orderAmount[$order->product_type_code.'-'.$order->customer_id];
                    @endphp
                    <tr>
                        <td class="text-center" style="border: 0.5px solid #000; font-size: 16px;"> {{ $order->prepare_order_number }} </td>
                        <td class="text-center" style="border: 0.5px solid #000; font-size: 16px;"> {{ $order->customer_number }} </td>
                        <td class="text-left" style="border: 0.5px solid #000; font-size: 16px;"> {{ $order->customer_name }} </td>
                        <td class="text-center" style="border: 0.5px solid #000; font-size: 16px;"> {{ $order->account_number }} </td>
                        <td class="text-right" style="border: 0.5px solid #000; font-size: 16px;"> {{ number_format($orderAmount[$order->product_type_code.'-'.$order->customer_id], 2)}} </td>
                    </tr>
                    @if ($loop->last)
                        <tr>
                            <th colspan="4" class="text-right" style="border: 0.5px solid #fff; font-size: 16px;"> รวม </th>
                            <th class="text-right" style="border: 0.5px solid #fff; font-size: 16px;"> {{ number_format($total, 2)}} </th>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="row col-12" style="margin-top: 0.5rem;">
            <div class="col-md-12 text-center" style="font-size: 16px;"> <strong> จบรายงาน </strong> </div>
        </div>
        <div class="row col-12" style="margin-top: 2rem; font-size: 16px;">
            <div class="col-md-6 text-center"> <strong> ผู้จัดทำ _________________________________________________ </strong> </div>
            <div class="col-md-6 text-center"> <strong> ผู้รับรอง _________________________________________________ </strong> </div>
        </div>


    </div>
    <script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
</body>
</html>
