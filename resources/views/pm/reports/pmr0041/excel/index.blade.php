<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    <body>
        @php
            $styleTh = 'border:  1px solid black; line-height: 100px';
            $styleFont16 = 'border:  1px solid black; font-size: 16px';
            $styleFont14 = 'border:  1px solid black; font-size: 14px';
            $font18 = 'font-size: 18px; ';
            $font16 = 'font-size: 16px; ';
            $font14 = 'font-size: 14px; ';
            $border = 'border:  1px solid black; ';
            $lineNo = 0;
        @endphp
        <table>
            <tr>
                <td  align="left"   height="20" colspan="2"  style="{{ $font18 }}"><b>โปรแกรม : </b> {{ request()->program_code }}</td>
                <td  align="center" height="20" colspan="5"  style="{{ $font18 }}"><b> การยาสูบแห่งประเทศไทย </b></td>
                <td  align="right"  height="20" colspan="2" style="{{ $font18 }}"><b>วันที่พิมพ์ : </b> {{ $reportData->date }} </td>
            </tr>
            <tr>
                <td  align="left"   height="20" colspan="2"  style="{{ $font18 }}"><b>พิมพ์โดย : </b> {{ $profile->user_name }}</td>
                <td  align="center" height="20" colspan="5"  style="{{ $font18 }}"><b> {{ $reportData->name }} </b></td>
                <td  align="right" height="20" colspan="2" style="{{ $font18 }}"><b> เวลา : </b> {{ $reportData->time }}  </td>
            </tr>
            <tr>
                <td  align="left"   height="20" colspan="2"  style="{{ $font18 }}"><b>หน่วยงาน : </b> {{ $reportData->department_desc }}</td>
                <td  align="center" height="20" colspan="5"  style="{{ $font18 }}"></td>
                <td  align="right" height="20" colspan="2" style="{{ $font18 }}"></td>
            </tr>
            @foreach ($datas->groupBy('subinventory_to') as  $subinventoryTo => $lines)
                <tr>
                    <td  align="left"   height="20" colspan="2"  style="{{ $font18 }}"><b>คลังที่รับสินค้า : </b> {{ $subinventoryTo }}</td>
                    <td  align="center" height="20" colspan="5"  style="{{ $font18 }}"></td>
                    <td  align="right"  height="20" colspan="2" style="{{ $font18 }}"></td>
                </tr>
                <tr>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>วันที่ได้ผลผลิต</b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>วันที่นำส่ง</b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>เลขที่</b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>ลำดับที่</b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>รหัสสินค้า</b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>รายการ</b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>LOT NO.</b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>จำนวน</b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>หน่วยนับ</b></td>
                </tr>
                @foreach ($lines->groupBy('transfer_number') as $transferNumbers)
                    @foreach ($transferNumbers as $key => $data)
                    <tr>
                        <td style="{{ $font14 }} {{ $border }}">{{ $data->product_date_th }}</td>
                        <td style="{{ $font14 }} {{ $border }}">{{ $data->transfer_date_th }}</td>
                        <td style="{{ $font14 }} {{ $border }}">{{ $data->transfer_number }}</td>
                        <td style="{{ $font14 }} {{ $border }}">{{ $key + 1 }}</td>
                        <td style="{{ $font14 }} {{ $border }}">{{ $data->item_number }}</td>
                        <td style="{{ $font14 }} {{ $border }}">{{ $data->item_desc }}</td>
                        <td style="{{ $font14 }} {{ $border }}">{{ $data->lot_number }}</td>
                        <td style="{{ $font14 }} {{ $border }}">{{ $data->qty }}</td>
                        <td style="{{ $font14 }} {{ $border }}" align="center">{{ $data->uom }}</td>
                    </tr>
                    @endforeach
                @endforeach
            @endforeach
        </table>
    </body>
</html>
