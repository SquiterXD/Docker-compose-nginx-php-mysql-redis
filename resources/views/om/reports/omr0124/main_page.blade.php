<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <title> รายการเรียกเก็บเงินค่าบุหรี่ </title>
    @include('om.reports.omr0124._style')
</head>
<body> 
    <div class="row">
        <div class="col-md-12">
            <div style="margin-top: 10px;">
                <div class="text-center">
                    <div style="font-size: 18px;">
                        <strong> 
                            {{ $bank->bank_account_name }}
                        </strong>
                    </div>
                    <div style="font-size: 18px;">
                        <strong> 
                            วัน {{ $dateArr[strtoupper(date('D', strtotime($paymentDate)))] }} ที่ {{ parseToDateTh($paymentDate) }}
                        </strong>
                    </div>
                </div>
            <table class="table" style="margin-top: 10px; margin-bottom: 10px;">
                    <tr style="border: 0.5px solid #000; background-color: #e6e6e6;">
                        <td style="border: 0.5px solid #000; text-align: center; width: 60px;">
                            <strong>ลำดับที่</strong>
                        </td>
                        <td style="border: 0.5px solid #000; text-align: center;">
                            <strong>ชื่อร้าน</strong>
                        </td>
                        <td style="border: 0.5px solid #000; text-align: center; width: 120px;">
                            <strong>ใบเสร็จรับเงินเลขที่</strong>
                        </td>
                        <td style="border: 0.5px solid #000; text-align: center; width: 120px;">
                            <strong>จำนวนเงิน (บาท)</strong>
                        </td>
                    </tr>
                    @foreach ($data as $list)
                        <tr>
                            <td style="border: 0.5px solid #000; text-align: center;">
                                {{ $loop->iteration }}
                            </td>
                            <td style="border: 0.05px solid #000;">
                                {{ $list->customer_name }}
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center;">
                                {{ $list->payment_number }}
                            </td>
                            <td style="border: 0.5px solid #000; text-align: right;">
                                {{ number_format($list->payment_amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    <tr style="background-color: #e6e6e6;">
                        <td style="text-align: center; border: 0.5px solid #000" colspan="3">
                            <strong>ยอดรวม</strong>
                        </td>
                        <td style="text-align: right; border: 0.5px solid #000"> 
                            <strong>{{ number_format($data->sum('payment_amount'), 2) }}</strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
