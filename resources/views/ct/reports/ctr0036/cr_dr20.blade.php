<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    @include('ct.Reports.ctr0036._style')
    <style>
            .table_data{
                border: 0.5px solid rgb(200, 200, 200);
                border-collapse: collapse;
                height: 20px;
                width: 100%;
            }
        </style>
    </head>
    <body>
        @php
            $page_no++;
            $totalDr = 0;
            $totalCr = 0;
        @endphp
        @include('ct.Reports.ctr0036.header')
        <table class="table_data" style="border: #000000 solid 0.5px; padding: 5px; margin-top: 20px;">
            <tr>
                <td style="border: 1px solid #000000;text-align: left; background-color: powderblue;" colspan=4>
                    <b>ใบโอนแยกต้นทุนขายค่าแสตมป์ยาสูบและกองทุนฯ</b>
                </td>
            </tr>
            @foreach($DrCr20 as $dc)
                @php
                    $totalDr += $dc->dr_cr=='DR'? $dc->stamp_amount: 0;
                    $totalCr += $dc->dr_cr=='CR'? $dc->stamp_amount: 0;
                @endphp
                <tr>
                    <td style="border: 1px solid #000000;text-align: left;"> {{ $dc->account }}</td>
                    <td style="border: 1px solid #000000;text-align: left;"> {{ $dc->account_desc }}</td>
                    @if($dc->dr_cr=='DR') 
                        <td style="border: 1px solid #000000;text-align: right;">{{ number_format($dc->stamp_amount, 2) }}</td>
                        <td style="border: 1px solid #000000;text-align: right;"> 0.00 </td>
                    @endif
                    @if($dc->dr_cr=='CR')
                        <td style="border: 1px solid #000000;text-align: right;"> 0.00 </td>
                        <td style="border: 1px solid #000000;text-align: right;">{{ number_format($dc->stamp_amount, 2) }}</td>
                    @endif
                </tr>
            @endforeach
            <tr>
                <td colspan="2" style="border: 1px solid #000000; text-align: right;"> <strong> รวม </strong> </td>
                <td style="border: 1px solid #000000; text-align: right;"> {{ number_format($totalDr, 2) }} </td>
                <td style="border: 1px solid #000000; text-align: right;"> {{ number_format($totalCr, 2) }} </td>
            </tr>
        </table>
    </body>
</html>