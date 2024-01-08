<div>
    <table>
        @php
            // as_of_date
        @endphp
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="14"><strong>การยาสูบแห่งประเทศไทย</strong></th>
        </tr>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="14"><strong>การต่ออายุประกันภัย - ทรัพย์สิน</strong></th>
        </tr>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="14"><strong>กรมธรรม์ชุดที่ {{ $header->policy_set_number }} : {{ $header->policy_set_description }}</strong></th>
        </tr>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="14"><strong>ปี : {{ $header->year + 543}} ณ วันที่ : {{ parseToDateTh($header->as_of_date) }}</strong></th>
        </tr>
    </table>
    <table class="table table-responsive-sm table-bordered" style="border: 1px solid #000000;">
        <thead>
            <tr>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>ลำดับ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>IR Status <br>สถานะ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Line Type<br>ประเภท</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Department Code By Location <br>รหัสหน่วยงานตามสถานที่</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Department By Location <br>หน่วยงานตามสถานที่</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Department Code By Expense <br>รหัสหน่วยงานตามค่าใช้จ่าย</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Department By Expense <br>หน่วยงานตามค่าใช้จ่าย</strong></th>
                <th style="border: 1px solid #000000; vertical-align: middle; text-align: center;"><strong>Expense Account Code <br>รหัสบัญชี</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Expense Account Description <br>บัญชีค่าใช้จ่าย</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Asset Number <br>รหัสทรัพย์สิน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>รหัสสังกัด</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>สังกัด</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>กลุ่มของทรัพย์สิน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>รหัสหมวด</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>หมวด</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Qty. จำนวน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Asset Cost <br>ราคาทุน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>overage Amount <br>มูลค่าทุนประกัน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Premium <br>ค่าเบี้ยประกัน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Duty Fee <br>อากร</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Vat <br>ภาษีมูลค่าเพิ่ม</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Net Amount <br>ค่าเบี้ยประกันสุทธิ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>เรียกเก็บ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>สถานะการตัดค่าใช้จ่าย</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                @php
                    $vatCal = ($data->insurance_amount + $data->duty_amount) * 7 /100;
                    $netAmount = $data->insurance_amount + $data->duty_amount + $vatCal;
                @endphp
                <tr>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->status }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->line_type }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->department_location_code }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->department_location_name }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->department_cost_code }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->department_cost_name }}</td>
                    <td style="border: 1px solid #000000; text-align: left;">{{ $data->account_code }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->account_desc }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->asset_number }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->department_code }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->department_name }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->location_name }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->category_code }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->category_description }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ number_format($data->quantity, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->current_cost, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->adjustment_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->insurance_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->duty_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->vat_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->net_amount, 2) }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->receivable_name }}</td>
                    <td style="border: 1px solid #000000; text-align: center; vertical-align: top;">
                        {{ $data->expense_flag == 'Y' ? '✔': '' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>