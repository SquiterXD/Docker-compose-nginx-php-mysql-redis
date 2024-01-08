<div>
    <table>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="30"><strong>การยาสูบแห่งประเทศไทย</strong></th>
        </tr>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="30"><strong>การต่ออายุประกันภัย - รถยนต์</strong></th>
        </tr>
        <tr>
            {{-- <th style="text-align: center; font-size: 16px;" colspan="14"><strong>กรมธรรม์ชุดที่ {{ $header->policy_set_number }} : {{ $header->policy_set_description }}</strong></th> --}}
        </tr>
        <tr>
            {{-- <th style="text-align: center; font-size: 16px;" colspan="14"><strong>ปี : {{ $header->year + 543}} ณ วันที่ : {{ parseToDateTh($header->as_of_date) }}</strong></th> --}}
        </tr>
    </table>
    <table class="table table-responsive-sm table-bordered" style="border: 1px solid #000000;">
        <thead>
            <tr>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>IR Status <br>สถานะ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Document number<br>เลขที่เอกสาร</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Year <br>ปี</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>License plate <br>ทะเบียนรถยนต์</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>เรียกเก็บ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Renew type <br>ประเภทการต่ออายุ</strong></th>
                <th style="border: 1px solid #000000; vertical-align: middle; text-align: center;"><strong>Start date <br>วันที่เริ่มต้นการคิดเบี้ยประกัน </strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>End date <br>วันที่สิ้นสุดการคิดเบี้ยประกัน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Days <br>จำนวนวัน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Premium <br>ค่าเบี้ยประกัน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Discount <br>ส่วนลด</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Duty Fee <br>อากร</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Vat <br>ภาษีมูลค่าเพิ่ม</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Net Amount <br>ค่าเบี้ยประกันสุทธิ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Tax recoverable <br>ภาษีขอคืนได้</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Insurance Expense <br>ค่าเบี้ยประกันตัดค่าใช้จ่าย</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Car type <br>ประเภทรถยนต์</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Policy no. <br>เลขที่กรมธรรม์</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Company name <br>ผู้รับประกันภัย</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Asset Number <br>รหัสทรัพย์สิน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Group <br>กลุ่ม</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Location Code <br>รหัสสถานที่ </strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Location <br>สถานที่</strong></th>
                <th style="border: 1px solid #000000; vertical-align: middle; text-align: center;"><strong>Expense Account <br>รหัสบัญชีค่าใช้จ่าย</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Expense Account Description <br>บัญชีค่าใช้จ่าย</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Brand <br>ยี่ห้อ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>CC. <br>ซีซี รถ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Engine number <br>หมายเลขเครื่องยนต์</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Vehicle identification Number <br>หมายเลขตัวถัง</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>สถานะการตัดค่าใช้จ่าย</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            @php
                $start_date = date_create(date('Y-m-d', strtotime($data->start_date)));
                $end_date   = date_create(date('Y-m-d', strtotime($data->end_date)));
                $diff       = date_diff($start_date, $end_date);
                $total_days = $diff->days;
            @endphp
                <tr>
                    @php
                        $carType = '';
                        if ($data->car_type) {
                            $carTypeSplit =  explode('(' , $data->car_type);
                            $carType = $carTypeSplit[0];
                        }
                    @endphp
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->status }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->document_number }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->year+543 }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->license_plate }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->receivable_name }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->renew_type }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ parseToDateTh($data->start_date) }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ parseToDateTh($data->end_date) }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $total_days }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->insurance_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->discount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->duty_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->vat_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->net_amount, 2) }}</td>
                    <td style="border: 1px solid #000000; text-align: center; vertical-align: top;">{{ $data->vat_refund == 'Y' ? '✔': '' }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ number_format($data->insurance_expense, 2) }}</td>
                    <td style="border: 1px solid #000000;">{{ $carType ? $carType : $data->car_type }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $data->policy_number }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->company_name }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->asset_number }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->group_name }}</td>
                    <td style="border: 1px solid #000000; text-align: left">{{ $data->vehicle ? $data->vehicle->location_code : '' }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->vehicle ? $data->vehicle->location_description : '' }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->expense_account }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->expense_account_desc }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->car_brand }}</td>
                    <td style="border: 1px solid #000000; text-align: left">{{ $data->car_cc }}</td>
                    <td style="border: 1px solid #000000; text-align: left">{{ $data->engine_number }}</td>
                    <td style="border: 1px solid #000000; text-align: left">{{ $data->tank_number }}</td>
                    <td style="border: 1px solid #000000; text-align: center; vertical-align: top;">
                        {{ $data->expense_flag == 'Y' ? '✔': '' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>