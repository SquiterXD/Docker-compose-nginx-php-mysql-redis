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
        line-height:  35px;
        padding-left: 1in;
        
        height: auto;
        font-size: 17pt;
    }

    .right-table{
        line-height:  20px;
        /* padding-left: 0.5in; */
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
    <div class="page-hight">
        <table class="table maintable" border="0">
            <tr>
                <td width="50%" class="header-number">{{ $prints[0]->payment_number }}</td>
                <td class="header-date">{{ FormatDate::DateThaiNumericWithSplash(date_format(date_create($prints[0]->payment_date),'Y/m/d')) }}</td>
                <td class="text-right">{{ date_format(date_create(date('Y-m-d H:i:s')),'H:i') }}</td>
            </tr>
            <tr>
                <td colspan="3">{{ $prints[0]->customer_number }} {{ $prints[0]->customer_name }}</td>
             </tr>
            <tr>
                <!--toat_edit-->
                @if($prints[0]->customer_number=="D00003" && !empty($prints_ship))
                <td colspan="3">{{$prints_ship[0]->address_line1}} {{$prints_ship[0]->alley}} {{$prints_ship[0]->district}} {{$prints_ship[0]->city}} {{ $prints_ship[0]->province_name }} {{$prints_ship[0]->postal_code}} &nbsp;
                @else
                <td colspan="3">{{$prints[0]->address_line1}} {{$prints[0]->alley}} {{$prints[0]->district}} {{$prints[0]->city}} {{ $prints[0]->province_name }} {{$prints[0]->postal_code}} &nbsp;
                @endif
                <!--end_toat_edit-->
            </td>
            </tr>
            <tr>
               <td colspan="2" style="padding-top:5px">ได้รับเงินเตรียมชำระค่ายาสูบ/ยาเส้น</td>
               <td class="text-left" style="padding-right:60px; padding-top:5px">{{ $prints[0]->payment_status == 'Cancel'? 0 : number_format($prints[0]->payment_amount,2) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="line-height: 0px;">
                    <h2 class="money-thai">
                        <strong>***{{ $prints[0]->payment_status == 'Cancel'? 'ยกเลิกใบเสร็จรับเงิน' :ConverttoThai($prints[0]->payment_amount) }}***</strong>
                    </h2>
                </td>
            </tr>
        </table>
        <div style="width: 5.5in; float: left;">
            <table class="left-table" style="line-height:30px;padding-top: 19px;">
                @if($prints[0]->cash)
                    <tr class="detail-total">
                        <td style="width:30px;" ><strong>X</strong></td>
                        <td style="width:5in;" class="total">{{number_format($prints[0]->cash_amount,2) }}</td>
                    </tr>
                @else
                    <tr class="detail-total">
                        <td style="width:30px;" >&nbsp;</td>
                        <td style="width:5in;" class="total">&nbsp;</td>
                    </tr>
                @endif
                @if($prints[0]->bill)
                    <tr class="detail-total">
                        <td style="width:30px;"><strong>X</strong></td>
                        <td style="width:5in;" class="total">{{number_format($prints[0]->bill_amount,2)}}
                    </tr>
                @else
                    <tr class="detail-total">
                        <td style="width:30px;">&nbsp;</td>
                        <td style="width:5in;" class="total">&nbsp;</td>
                    </tr>
                @endif
                @if($prints[0]->tranf)
                    <tr class="detail-total">
                        <td style="width:30px;" ><strong>X</strong></td>
                        <td style="width:5in;" class="total">{{number_format($prints[0]->tranf_amount,2)}}</td>
                    </tr>
                @else
                    <tr class="detail-total">
                        <td style="width:30px;" >&nbsp;</td>
                        <td style="width:5in;" class="total">&nbsp;</td>
                    </tr>
                @endif
            </table>
            <div style="padding-left: 1in; height: auto; font-size: 16pt; line-height:30px;width: 550px;">
                @if(!empty($prints[0]->invoice_list))
                <label style="line-height:14px;line-break:anywhere;font-size:smaller;">ชำระหนี้ตาม Invoice เลขที่ {!!  $prints[0]->invoice_list !!}</label>
                @endif
            </div>
        </div>
        <div style=" width: 2.5in; float: left;">
            <table class="right-table" style="padding: 0px !important; border-collapse: collapse;">
                <tr class="detail-total" style="padding: 0px !important;">
                    <td style="width:5in;" class="label-total">เงินสด</td>
                    @if(@$prints[0]->prepare_order_number)
                        <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ ($prints[0]->product_type_10)? amountwithdayonprintwithOrderHearder($prints[0]->payment_header_id,0,10) : '0.00' }}</td>
                    @else 
                        <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ amountwithdayonprint($prints[0]->payment_header_id,0) }}</td>
                    @endif
                </tr>
                <tr class="detail-total" style="padding: 0px !important;">
                    <td style="width:5in;" class="label-total">เงินเชื่อ 7 วัน</td>
                    <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ amountwithdayonprint($prints[0]->payment_header_id,7) }}</td>
                </tr>
                <tr class="detail-total" style="padding: 0px !important;">
                    <td style="width:5in;" class="label-total">เงินเชื่อ 14 วัน</td>
                    <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ amountwithdayonprint($prints[0]->payment_header_id,14) }}</td>
                </tr>
                <tr class="detail-total" style="padding: 0px !important;">
                    <td style="width:5in;" class="label-total">เงินเชื่อ 28 วัน</td>
                    <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ amountwithdayonprint($prints[0]->payment_header_id,28) }}</td>
                </tr>
                <tr class="detail-total" style="padding: 0px !important;">
                    <td style="width:5in;" class="label-total">เงินค่ายาเส้น</td>
                    <td style="width:3in; padding: 0px !important; text-align:right;" class="text-right">{{ (@$prints[0]->product_type_20)? amountwithdayonprintwithOrderHearder($prints[0]->payment_header_id,0,20) : '0.00' }}</td>
                </tr> 
            </table>
            <table style="padding-left: 0.5in;">
                <tr class="detail-total">
                    <td style="width:5in;" class="label-total"></td>
                    <td style="width:3in; padding-right:18px; padding-top:13px;" class="text-left"><img style="width: 60px;" src="{{ asset("img/signature/receipt/sing_MCROMP0027.png") }}" alt=""></td>
                </tr>
            </table>
        </div>

        {{-- <table class="table" border="0" width="40%">
            <tr>
                <td width="50%" class="header-number">{{ $prints[0]->payment_number }}</td>
               <td class="header-date">{{ FormatDate::DateThaiNumericWithSplash(date_format(date_create($prints[0]->payment_date),'Y/m/d')) }}</td>
               <td class="text-right">{{ date_format(date_create($prints[0]->payment_date),'H:i') }}</td>
            </tr>
            <tr>
                <td colspan="3">{{ $prints[0]->customer_number }} {{ $prints[0]->customer_name }}</td>
             </tr>
            <tr>
               <td colspan="3">{{ $prints[0]->province_thai }} &nbsp;</td>
            </tr>
            <tr>
               <td colspan="2">ได้รับเงินเตรียมชำระค่ายาสูบ/ยาเส้น</td>
               <td class="text-right">{{ number_format($prints[0]->payment_amount,2) }}</td>
            </tr>
            <tr>
                <td colspan="3" style=" line-height: 15px;"><h2 class="money-thai"><strong>***{{ baht_text($prints[0]->payment_amount) }}***</strong></h2></td>
            </tr>
            <tr class="detail-total">
                <td width="50%"></td>
               <td class="label-total">เงินสด</td>
               <td class="text-right">{{ amountwithdayonprint($prints[0]->payment_header_id,0) }}</td>
            </tr>
            <tr class="detail-total">
                <td width="50%"></td>
               <td class="label-total">เงินเชื่อ 7 วัน</td>
               <td class="text-right">{{ amountwithdayonprint($prints[0]->payment_header_id,7) }}</td>
            </tr>
            <tr class="detail-total">
                <td width="50%"></td>
               <td class="label-total">เงินเชื่อ 14 วัน</td>
               <td class="text-right">{{ amountwithdayonprint($prints[0]->payment_header_id,14) }}</td>
            </tr>
            <tr class="detail-total">
                <td width="50%" class="total">{{ number_format($prints[0]->total_payment_amount,2) }}</td>
               <td class="label-total">เงินเชื่อ 28 วัน</td>
               <td class="text-right">{{ amountwithdayonprint($prints[0]->payment_header_id,28) }}</td>
            </tr>
                <tr class="detail-total">
                    <td style="width:3in;" class="label-total">เงินค่ายาเส้น</td>
                    <td style="width:3in; padding-right:10px;" class="text-left">0.00</td>
                </tr> 
            <tr class="detail-total">
                <td style="width:3in;" class="label-total"></td>
                <td style="width:3in; padding-right:35px; padding-top:15px;" class="text-left"><img style="width: 60px;" src="{{ asset("img/signature/receipt/sing_MCROMP0027.png") }}" alt=""></td>
            </tr>   
        </table> --}}
    </div>

<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
</body>
</html>
