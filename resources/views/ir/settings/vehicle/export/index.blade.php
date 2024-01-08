<div>
    <table>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="14"><strong>{{ $orgName }}</strong></th>
        </tr>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="14"><strong>รายงานข้อมูลยานพาหนะ (Vehicles)</strong></th>
        </tr>
    </table>
    <table class="table table-responsive-sm table-bordered" style="border: 1px solid #000000;">
        <thead>
            <tr>
                <th style="border: 1px solid #000000; text-align: center;"><strong>ลำดับ</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>ทะเบียนรถ</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>ชุดกรมธรรม์</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>กลุ่ม</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>ประเภทรถ</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>ยี่ห้อรถ</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>ขอคืนภาษีได้</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>ภาษี (%)</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>อากร (%)</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>รหัสทรัพย์สิน</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>รหัสบัญชี</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>วันที่ดึงข้อมูลจากระบบ FA</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>Active</strong></th>
                <th style="border: 1px solid #000000; text-align: center;"><strong>สถานะการขาย</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataList as $data)
                <tr>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->license_plate }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->policy_set_number }} {{ $data->policy_set_number ? ':' : ''}} {{ $data->policy_set_description }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->group_desc }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->vehicle_type_name }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->vehicle_brand_name }}</td>
                    <td style="border: 1px solid #000000; text-align: center; vertical-align: top;">
                        {{ $data->return_vat_flag == 'Y' ? '✔': '' }}
                    </td>
                    <td style="border: 1px solid #000000;">{{ $data->vat_percent ? $data->vat_percent : $data->vat_percent }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->revenue_stamp_percent ? $data->revenue_stamp_percent : $data->revenue_stamp_percent }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->asset_number }}</td>
                    <td style="border: 1px solid #000000;">{{ $data->account_number }}</td>
                    <td style="border: 1px solid #000000;">
                        @if ($data->asset_number)
                            {{ date(trans('date.format'),strtotime($data->creation_date)) }}
                        @endif
                    </td>
                    <td style="border: 1px solid #000000; text-align: center; vertical-align: top;">
                        {{ $data->active_flag == 'Y' ? '✔': '' }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: center; vertical-align: top;">
                        {{ $data->sold_flag == 'Y' ? '✔': '' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>