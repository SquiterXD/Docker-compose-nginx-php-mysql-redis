<div>
    <table>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="19"><strong>การยาสูบแห่งประเทศไทย</strong></th>
        </tr>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="19"><strong>การต่ออายุประกันภัย - ข้อมูลสินค้าประจำปี</strong></th>
        </tr>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="19"><strong>กรมธรรม์ชุดที่ {{ $header->policy_set_number }} : {{ $header->policy_set_description }}</strong></th>
        </tr>
        <tr>
            <th style="text-align: center; font-size: 16px;" colspan="19"><strong>ปี : {{ $header->year + 543}} วัน เดือน ปี ที่ดึงข้อมูล : {{ parseToDateTh($header->period_from) }} - {{ parseToDateTh($header->period_to) }} </strong></th>
        </tr>
    </table>
    <table class="table table-responsive-sm table-bordered" style="border: 1px solid #000000;">
        <thead>
            <tr>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Line No</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>IR Status <br>สถานะ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Line Type<br>ประเภท</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Period From <br>ตั้งแต่เดือน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Period To <br>ถึงเดือน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Organization</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Sub Inventory Code <br>รหัสคลังสินค้า</strong></th>
                <th style="border: 1px solid #000000; vertical-align: middle; text-align: center;"><strong>Sub Inventory <br>คลังสินค้า</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Sub Group Code <br>รหัสกลุ่มสินค้าย่อย</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Sub Group Description <br>กลุ่มสินค้าย่อย</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>กลุ่มของทรัพย์สิน</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>รายการ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Item Code <br> รหัสพัสดุ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Item Description <br> พัสดุ</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>UOM <br> หน่วย</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Original Quantity <br> ปริมาณเดิม</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Price per unit <br>ราคาต่อหน่วย (บาท)</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Amount <br>มูลค่าสินค้า (บาท)</strong></th>
                <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;"><strong>Coverage Amount <br>มูลค่าทุนประกัน</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            @php
                $m_f = date('m', strtotime($data->period_from));
                $y_f = date('Y', strtotime($data->period_from))+543;

                $m_t = date('m', strtotime($data->period_to));
                $y_t = date('Y', strtotime($data->period_to))+543;
            @endphp
                <tr>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->line_number }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->status }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->line_type }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->period_from ? $m_f.'/'.$y_f : '' }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->period_to   ? $m_t.'/'.$y_t : '' }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> 
                        {{ $data->organizationView ? $data->organizationView->organization_code . ' : ' . $data->organizationView->organization_name : '' }} 
                    </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->sub_inventory_code }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->sub_inventory_desc }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->location_code }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->location_desc }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> 
                        {{ $data->assetGroupView ? $data->assetGroupView->meaning . ' : ' . $data->assetGroupView->description : '' }} 
                    </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->stock_list_description }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->item_code }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->item_description }} </td>
                    <td style="border: 1px solid #000000; text-align: center;"> {{ $data->uom ? $data->uom->description : '' }} </td>
                    <td style="border: 1px solid #000000; text-align: right;"> {{ number_format($data->original_quantity, 2) }} </td>
                    <td style="border: 1px solid #000000; text-align: right;"> {{ number_format($data->unit_price, 2) }} </td>
                    <td style="border: 1px solid #000000; text-align: right;"> {{ number_format($data->line_amount, 2) }} </td>
                    <td style="border: 1px solid #000000; text-align: right;"> {{ number_format($data->coverage_amount, 2) }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>