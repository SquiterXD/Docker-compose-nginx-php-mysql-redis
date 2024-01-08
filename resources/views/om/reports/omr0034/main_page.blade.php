<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> สรุปยอดผ่านข้อมูลค่านายหน้าไปยังระบบบัญชีเจ้าหนี้ </title>
    @include('om.reports._style')
</head>
<style>                  
    .row {
        display: -webkit-box; /* wkhtmltopdf uses this one */
        display: flex;
        -webkit-box-pack: center; /* wkhtmltopdf uses this one */
        justify-content: flex-start;
        margin-bottom: 3px;
    }

    .row > div {
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        flex: 1;
    }

    .row > div:last-child {
        margin-right: 0;
    }

    .report_header {
        font-size: 18px;
        text-align: center;
        vertical-align: middle;
        padding: 7px;
    }
</style>
<body>
@php
    $page_no = 0;
@endphp
@foreach ($result as $number => $lines)
    @php
        $lineLimit = $maxLine;
        $page = count($result);
        $page_no++;
    @endphp
    <div style="page-break-after: always;"></div>
    <div class="row col-lg-12">
        <div class="col-md-4" style="font-size: 16px; text-align: left; width: 150px;">
            <div style="margin-bottom: 15px;"><strong> โปรแกรม : </strong> OMR0034</div>
            <div style="margin-bottom: 15px;"><strong> สั่งพิมพ์ : </strong> {{$user_id}} </div>
        </div>
        <div class="col-md-4" style="font-size: 20px; text-align: center; font-weight: bold;">
            <div style="margin-bottom: 10px;"> การยาสูบแห่งประเทศไทย</div>
            <div style="margin-bottom: 10px;"> สรุปยอดผ่านข้อมูลค่านายหน้าไปยังระบบบัญชีเจ้าหนี้</div>
            <div style="margin-bottom: 10px;"> จากวันที่ {{ $input['start_date'] }}
                ถึงวันที่ {{ $input['end_date'] }}</div>
        </div>
        <div align="right" class="col-md-4" style="font-size: 16px;">
            <div style="margin-bottom: 15px;"><strong> วันที่ :</strong> {{ $input['now'] }}</div>
            <div style="margin-bottom: 15px;"><strong> เวลา :</strong> {{ date('H:i') }}</div>
            <div style="margin-bottom: 15px;"><strong> หน้า :</strong> {{ $page_no." / ".$page }}</div>
            <div style="margin-bottom: 15px;"><strong> หน่วย :</strong> บาท</div>
        </div>
    </div>
    <table class="table"
           style="border-collapse: collapse; padding: 0px; margin: 0px;">
        <thead>
        <tr style="background-color: #C7CCC5;border-top: 0.5px solid #000000;border-bottom: 0.5px solid #000000;">
            <th width="4%" class="report_header">
                ลำดับ
            </th>
            <th width="10%" class="report_header">
                Invoice Batch
            </th>
            <th width="5%" class="report_header">
                เลขที่ฝากขาย
            </th>
            <th width="10%" class="report_header">
                วันที่ฝากขาย
            </th>
            <th width="5%" class="report_header">
                รหัสร้านค้า
            </th>
            <th width="17%" class="report_header">
                ชื่อร้านค้า
            </th>
            <th width="8%" class="report_header">
                ค่านายหน้า
            </th>
            <th width="8%" class="report_header">
                Voucher no.
            </th>
            <th width="8%" class="report_header">
                Invoice Number (AP)
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($lines as $no => $data_detail)
            <tr>
                <td style="font-size: 16px;text-align: center;">
                    {{($page_no-1)*$lineLimit+($no+1)}}
                </td>
                <td style="font-size: 16px;text-align: left;">
                    {{$data_detail['invoice_batch']}}
                </td>
                <td style="font-size: 16px;text-align: center;">
                    {{$data_detail['doc_ref_code']}}
                </td>
                <td style="font-size: 16px;text-align: center;">
                    {{ \Carbon\Carbon::parse($data_detail['doc_ref_date'])->addYear(543)->format('d/m/Y') }}
                </td>
                <td style="font-size: 16px;text-align: left;">
                    {{$data_detail['customer_number']}}
                </td>
                <td style="font-size: 16px;text-align: left;">
                    {{$data_detail['customer_name']}}
                </td>
                <td style="font-size: 16px;text-align: right;padding-right: 10px">
                    {{number_format($data_detail->customer_type_id == '30' ? ($data_detail->consignment ? ($data_detail->consignment->commission_amount * 100 / 107) : $data_detail->line_amount_excluded_vat) : $data_detail->line_amount_excluded_vat,2)}}
                </td>
                <td style="font-size: 16px;text-align: center;">
                    {{$data_detail['voucher_number']}}
                </td>
                <td style="font-size: 16px;text-align: center;">
                    {{$data_detail['invoice_num']}}
                </td>
            </tr>
        @endforeach
        @if ($page_no === $page)
            <tr>
                <td style="text-align: left;padding-right: 20px;font-size: 16px; border-top: 0.5px solid #000000;border-bottom: 0.5px solid #000000; text-align: center;padding-top: 7px;padding-bottom: 7px"></td>
                <td style="text-align: left;padding-right: 20px;font-size: 16px; border-top: 0.5px solid #000000;border-bottom: 0.5px solid #000000; text-align: center;padding-top: 7px;padding-bottom: 7px"></td>
                <td style="text-align: left;padding-right: 20px;font-size: 16px; border-top: 0.5px solid #000000;border-bottom: 0.5px solid #000000; text-align: center;padding-top: 7px;padding-bottom: 7px"></td>
                <td style="text-align: left;padding-right: 20px;font-size: 16px; border-top: 0.5px solid #000000;border-bottom: 0.5px solid #000000; text-align: center;padding-top: 7px;padding-bottom: 7px"></td>
                <td style="text-align: left;padding-right: 20px;font-size: 16px; border-top: 0.5px solid #000000;border-bottom: 0.5px solid #000000; text-align: center;padding-top: 7px;padding-bottom: 7px"></td>
                <td
                    style="text-align: left;padding-right: 20px;font-size: 16px; border-top: 0.5px solid #000000;border-bottom: 0.5px solid #000000; text-align: center;padding-top: 7px;padding-bottom: 7px">
                    <strong>รวมทั้งหมด</strong>
                </td>
                <td
                    style="text-align: right!important;padding-right: 10px;font-size: 16px; border-top: 0.5px solid #000000;border-bottom: 0.5px solid #000000; text-align: center;padding-top: 7px;padding-bottom: 7px">
                    <strong>{{number_format($total,2)}}</strong>
                </td>
                <td style="text-align: left;padding-right: 20px;font-size: 16px; border-top: 0.5px solid #000000;border-bottom: 0.5px solid #000000; text-align: center;padding-top: 7px;padding-bottom: 7px"></td>
                <td style="text-align: left;padding-right: 20px;font-size: 16px; border-top: 0.5px solid #000000;border-bottom: 0.5px solid #000000; text-align: center;padding-top: 7px;padding-bottom: 7px"></td>
            </tr>
        @endif
        </tbody>
    </table>
@endforeach
<div class="col-lg-12" style="margin-top: 10px">
    <strong>หมายเหตุรายการ :</strong> {{$input['remark']}}
</div>
</body>
</html>
