<div>
    <table>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="30"><strong>การยาสูบแห่งประเทศไทย</strong></th>
        </tr>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="30"><strong>การต่ออายุประกันภัย - สถานีน้ำมัน</strong></th>
        </tr>
    </table>
    <table class="table table-responsive-sm table-bordered" style="border: 1px solid #000000;">
        <thead>
            <tr>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">IR Status<br>สถานะ</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Document Number<br>เลขที่เอกสาร</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Reference <br>Document</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Year<br>ปี</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">ประเภทสถานีน้ำมัน</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Group<br>กลุ่ม</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Start Date<br>วันที่เริ่มต้นการคิดเบี้ยประกัน</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">End Date<br>วันที่สิ้นสุดการคิดเบี้ยประกัน</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Days<br>จำนวนวัน</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Premium<br>ค่าเบี้ยประกัน</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Discount<br>ส่วนลด</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Duty Fee<br>อากร</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Vat<br>ภาษีมูลค่าเพิ่ม</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Net Amount<br>ค่าเบี้ยประกันสุทธิ</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Tax Recoverable<br>ภาษีขอคืนได้</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Policy No.<br>เลขที่กรมธรรม์</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Company Name<br>ผู้รับประกันภัย</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Expense Account<br>รหัสบัญชีค่าใช้จ่าย</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Expense Account Description<br>บัญชีค่าใช้จ่าย</th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">สถานะการตัดค่าใช้จ่าย</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->status }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->document_number }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->reference_document_number }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->year+543 }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->type_code }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->group_name }}</td>
                    <td style="border: 1px solid #000000;">{{ parseToDateTh($data->start_date) }}</td>
                    <td style="border: 1px solid #000000;">{{ parseToDateTh($data->end_date) }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->total_days }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->insurance_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->discount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->duty_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->vat_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->net_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: center; vertical-align: top;">
                        {{ $data->vat_refund == 'Y' ? '✔': '' }}
                    </td>
                    <td style="border: 1px solid #000000;">{{ $data->policy_number }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->company_name }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->expense_account }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->expense_account_desc }}</td>
                    <td style="border: 1px solid #000000; text-align: center; vertical-align: top;">
                        {{ $data->expense_flag == 'Y' ? '✔': '' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>