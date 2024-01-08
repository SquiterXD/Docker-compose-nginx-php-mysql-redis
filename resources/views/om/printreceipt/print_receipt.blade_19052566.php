<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOAT - ใบเสร็จรับเงิน </title>

    <meta name="csrf-param" content="_token">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />
<style>
    /* .A4 {
        background: white;
        width: 21cm;
        height: 29.7cm;
        display: block;
        margin: 0 auto;
        padding: 10px 25px;
        margin-bottom: 0.5cm;
        box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
         overflow-y: scroll;
        box-sizing: border-box;
    } */
    @font-face {
        font-family: Cordia UPC;
        src: url('{{ asset("custom/fonts/cordia-new/CordiaUPC.ttf") }}');
        /* src: url("file://{!! public_path('/custom/fonts/cordia-new/CordiaUPC.ttf') !!}") format('truetype'); */
    }

    body{
        font-family: Cordia UPC;
        font-style: normal;
        width: 8in;
        height: 5.5in;
    }

    .maintable{
        line-height:35px;
        padding-top: 1.4in;
        padding-left: 0.9in;
        width: 9.2in;
        height: auto;
        font-size: 17pt;
    }

    .subtable{
        line-height:  20px;
        /* padding-left: 1in; */
        width: 9.2in;
        height: auto;
        font-size: 16pt;
    }
    .parent-table{
        /* display: flex; */
        display: inline-block;
    }
    .left-table{
        line-height:  25px;
        padding-left: 1in;

        height: auto;
        font-size: 17pt;
    }

    .right-table{
        line-height:  20px;
        padding-left: 0.5in;
        height: auto;
        font-size: 17pt;
    }


    .signaturetable{
        padding-top: 0.7in;
        line-height:  30px;
        padding-left: 8.5in;
        width: 9.2in;
        height: auto;
        font-size: 16pt;
    }

    .page-hight{
        height: 5.5in;

    }

    .header-number {
        padding-left: 0.5in;
        width: 4.5in;
    }

    .header-date {
        padding-left: 0.5in;
        width: 130px;
    }

    .money-thai{
        padding-top: 25px;
    }

    .detail-total {
        /* line-height: 1px; */
        /* width: 9.2in; */
    }

    .label-total {
        padding-left: 27.9px;
    }

    .total {
        text-align: right;
        padding-right: 40px;
    }

    .page-break {
        display: block;
        page-break-before: always;
    }
    /* @media print {
        .page-break {
            display: block;
            page-break-before: always;
        }
    }

    @media print {
        body {
            margin: 0;
            padding: 0;
        }

        .A4 {
            box-shadow: none;
            margin: 0;
            width: auto;
            height: auto;
        }

        .noprint {
            display: none;
        }

        .enable-print {
            display: block;
        }
    } */
</style>
</head>

<body>
    @foreach ($prints as $key => $item_payment)
    <div class="page-hight {{ ($key > 0)? 'page-break' : '' }}">
        <table class="table maintable" border="0">
            <tr>
                <td width="50%" class="header-number">{{ $item_payment->payment_number }}</td>
                <td class="header-date">{{ FormatDate::DateThaiNumericWithSplash(date_format(date_create($item_payment->payment_date),'Y/m/d')) }}</td>
                <td class="text-right">{{ date_format(date_create(date('Y-m-d H:i:s')),'H:i') }}</td>
            </tr>
            <tr>
                <td colspan="3">{{ $item_payment->customer_number }} {{ $item_payment->customer_name }}</td>
             </tr>
            <tr>
                
                @if($item_payment->customer_number=="D00003")
                @foreach ($prints_ship as $key => $item_payment_t)
                <td colspan="3">{{--{{$item_payment_t->address_line1}} {{$item_payment_t->alley}} {{$item_payment_t->district}} {{$item_payment_t->city}} {{$item_payment_t->province_name}} {{$item_payment_t->postal_code}}&nbsp;</td>--}}
                 {{--@if(!empty($item_payment_t->address_line1))--}}
                    {{!empty($item_payment_t->address_line1) ? $item_payment_t->address_line1 : ''}} {{!empty($item_payment_t->alley) ? $item_payment_t->alley : ''}} {{!empty($item_payment_t->district) ? $item_payment_t->district : ''}} {{!empty($item_payment_t->city) ? $item_payment_t->city : ''}} {{!empty($item_payment_t->province_name) ? $item_payment_t->province_name:''}} {{!empty($item_payment_t->postal_code) ? $item_payment_t->postal_code : ''}}
                    {{--    --}}
                 {{--@endif--}}
                 </td>
                @endforeach
                @else
                <td colspan="3">{{$item_payment->address_line1}} {{$item_payment->alley}} {{$item_payment->tambon_thai}} {{$item_payment->city_thai}} {{ !empty($item_payment->province_code)? $province_list[$item_payment->province_code]['name_th'] : $item_payment->state }} {{$item_payment->postal_code}}&nbsp;</td>
                @endif
            </tr>
            <tr>
               <td colspan="2" style="padding-top:5px">ได้รับเงินเตรียมชำระค่ายาสูบ/ยาเส้น</td>
               <td class="text-left" style="padding-right:60px; padding-top:5px">{{ number_format($item_payment->payment_status =="Cancel" ? '0': $item_payment->payment_amount,2) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="line-height: 0px;">
                    <h2 class="money-thai">
                        <strong>***{{ $item_payment->payment_status =="Cancel" ? 'ยกเลิกใบเสร็จรับเงิน': ConverttoThai($item_payment->payment_amount) }}***</strong>
                    </h2>
                </td>
            </tr>

        </table>
        <div style="width: 5.5in; float: left;">
            <table class="left-table" style="line-height:30px;padding-top: 19px;">
                @if($item_payment->cash)
                    <tr class="detail-total">
                        <td style="width:30px;" ><strong>X</strong></td>
                        <td style="width:5in;" class="total">{{number_format($item_payment->cash_amount,2) }}</td>
                    </tr>
                @else
                    <tr class="detail-total">
                        <td style="width:30px;" >&nbsp;</td>
                        <td style="width:5in;" class="total">&nbsp;</td>
                    </tr>
                @endif
                @if($item_payment->bill)
                    <tr class="detail-total">                                                                                                                                                                                                                               
                        <td style="width:30px;"><strong>X</strong></td>
                        <td style="width:5in;" class="total">{{number_format($item_payment->bill_amount,2)}}
                    </tr>
                @else
                    <tr class="detail-total">
                        <td style="width:30px;">&nbsp;</td>
                        <td style="width:5in;" class="total">&nbsp;</td>
                    </tr>
                @endif
                @if($item_payment->tranf)
                    <tr class="detail-total">
                        <td style="width:30px;" ><strong>X</strong></td>
                        <td style="width:5in;" class="total">{{number_format($item_payment->tranf_amount,2)}}</td>
                    </tr>
                @else
                    <tr class="detail-total">
                        <td style="width:30px;" >&nbsp;</td>
                        <td style="width:5in;" class="total">&nbsp;</td>
                    </tr>
                @endif
            </table>
            <div style="padding-left: 1in; height: auto; font-size: 16pt; line-height:30px;width: 550px;">
                @if(!empty($item_payment->invoice_list))
                <label style="line-height:14px;line-break:anywhere;font-size:smaller;">ชำระหนี้ตาม Invoice เลขที่ {{  $item_payment->invoice_list }}</label>
                @endif
            </div>
        </div>
        <div style=" width: 2.5in; float: left;padding-bottom: 13px;">
            <table class="right-table" style="padding: 0px !important; border-collapse: collapse;">
                <tr class="detail-total" style="padding: 0px !important;">
                    <td style="width:5in;" class="label-total">เงินสด</td>
                    @if($item_payment->prepare_order_number)
                        <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ ($item_payment->product_type_10)? amountwithdayonprintwithOrderHearder($item_payment->payment_header_id,0,10) : '0.00' }}</td>
                    @else 
                        <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ amountwithdayonprint($item_payment->payment_header_id,0) }}</td>
                    @endif
                </tr>
                <tr class="detail-total" style="padding: 0px !important;">
                    <td style="width:5in;"class="label-total">เงินเชื่อ 7 วัน</td>
                    <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ amountwithdayonprint($item_payment->payment_header_id,7) }}</td>
                </tr>
                <tr class="detail-total" style="padding: 0px !important;">
                    <td style="width:5in;" class="label-total">เงินเชื่อ 14 วัน</td>
                    <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ amountwithdayonprint($item_payment->payment_header_id,14) }}</td>
                </tr>
                <tr class="detail-total" style="padding: 0px !important;">
                    <td style="width:5in;" class="label-total">เงินเชื่อ 28 วัน</td>
                    <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ amountwithdayonprint($item_payment->payment_header_id,28) }}</td>
                </tr>
                <tr class="detail-total" style="padding: 0px !important;">
                    <td style="width:5in;" class="label-total">เงินค่ายาเส้น</td>
                    <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ ($item_payment->product_type_20)? amountwithdayonprintwithOrderHearder($item_payment->payment_header_id,0,20) : '0.00' }}</td>
                </tr>
            </table>
            @if($key > 0)
            <br>
            @endif
            <table style="padding-left: 0.5in;">
                <tr class="detail-total">
                    <td style="width:5in;" class="label-total"></td>
                    <td style="width:3in; padding-right:18px; padding-top:13px;" class="text-left"><img style="width: 60px;" src="{{ asset("img/signature/receipt/sing_MCROMP0027.png") }}" alt=""></td>
                </tr>
            </table>
        </div>
    </div>
    @endforeach
    <script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
</body>
</html>
