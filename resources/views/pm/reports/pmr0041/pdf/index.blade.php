<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew Bold.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        thead{display: table-header-group;}
        tfoot {display: table-row-group;}
        tr {page-break-inside: avoid;}

        body {
            font-family: "THSarabunNew" !important;
        }
        table {
            width:100%;
            border-collapse: collapse;
        }
        td {
            border:none !important;
            /*border: 1px solid #000 !important;*/
        }
        div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }
        .border {
            border-top:1px solid #000 !important;
            border-bottom:1px solid #000 !important;
        }

        tbody tr td {
            line-height: 1.1 !important;
            vertical-align: bottom !important;
        }

        thead tr td {
            line-height: 1.2 !important;
        }

    </style>
    <body style="">
        @php
            $styleTh = 'border:  1px solid black !important; line-height: 100px; ';
            $styleFont16 = 'border:  1px solid black !important; font-size: 16px; ';
            $styleFont14 = 'border:  1px solid black !important; font-size: 14px; ';
            $font18 = 'font-size: 18px; ';
            $font16 = 'font-size: 16px; ';
            $font14 = 'font-size: 14px; ';
            $border = 'border:  1px solid black !important; ';
            $lineNo = 0;
        @endphp
        <table style="">
            @foreach ($datas->groupBy('subinventory_to') as  $subinventoryTo => $lines)
                <thead>
                    <tr>
                        <td  align="left"   height="20" colspan="2"  style="{{ $font18 }}"><b>คลังที่รับสินค้า : </b> {{ $subinventoryTo }}</td>
                        <td  align="center" height="20" colspan="5"  style="{{ $font18 }}"></td>
                        <td  align="right"  height="20" colspan="2" style="{{ $font18 }}"></td>
                    </tr>
                    <tr>
                        <td width="80px;" valign="middle" align="center" height="30"  style="{{ $styleFont16 }}"><b>วันที่ได้ผลผลิต</b></td>
                        <td width="80px;" valign="middle" align="center" height="30"  style="{{ $styleFont16 }}"><b>วันที่นำส่ง</b></td>
                        <td width="80px;" valign="middle" align="center" height="30"  style="{{ $styleFont16 }}"><b>เลขที่</b></td>
                        <td width="70px;" valign="middle" align="center" height="30"  style="{{ $styleFont16 }}"><b>ลำดับที่</b></td>
                        <td width="100px;" valign="middle" align="center" height="30"  style="{{ $styleFont16 }}"><b>รหัสสินค้า</b></td>
                        <td valign="middle" align="center" height="30"  style="{{ $styleFont16 }}"><b>รายการ</b></td>
                        <td width="150px;" valign="middle" align="center" height="30"  style="{{ $styleFont16 }}"><b>LOT NO.</b></td>
                        <td width="100px;" valign="middle" align="center" height="30"  style="{{ $styleFont16 }}"><b>จำนวน</b></td>
                        <td width="100px;" valign="middle" align="center" height="30"  style="{{ $styleFont16 }}"><b>หน่วยนับ</b></td>
                    </tr>
                </thead>
                @foreach ($lines->groupBy('transfer_number') as $transferNumbers)
                    @foreach ($transferNumbers as $key => $data)
                    <tr>
                        <td align="center" style="{{ $font14 }} {{ $border }}">{{ $data->product_date_th }}</td>
                        <td align="center" style="{{ $font14 }} {{ $border }}">{{ $data->transfer_date_th }}</td>
                        <td align="center" style="{{ $font14 }} {{ $border }}">{{ $data->transfer_number }}</td>
                        <td align="center" style="{{ $font14 }} {{ $border }}">{{ $key + 1 }}</td>
                        <td align="center" style="{{ $font14 }} {{ $border }}">{{ $data->item_number }}</td>
                        <td style="{{ $font14 }} {{ $border }}">{{ $data->item_desc }}</td>
                        <td style="{{ $font14 }} {{ $border }}">{{ $data->lot_number }}</td>
                        <td align="right" style="{{ $font14 }} {{ $border }}">{{ $data->qty }}</td>
                        <td style="{{ $font14 }} {{ $border }}" align="center">{{ $data->uom }}</td>
                    </tr>
                    @endforeach
                @endforeach
            @endforeach
        </table>
    </body>
</html>
