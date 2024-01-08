<table>
    {{-- @include('om.reports.omr0030.header') --}}

{{----------------- header -----------------------------}}
<table>
    <thead>
        <tr>
            <th>โปรแกรม : OMR0030</th>
            <th></th>
            <th></th>
            <th></th>
            <th>การยาสูบแห่งประเทศไทย</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>สั่งพิมพ์ : {{ $user->username }} </td>
            <td></td>
            <td></td>
            <td></td>
            <td>รายงานส่วนลดค่าการตลาด</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            {{-- <td></td> --}}
            @php
                $now = date("d")."/".date("m")."/".(date("Y")+543);
            @endphp
            <td>วันที่: {{ now()->setTimezone('Asia/Bangkok')->format($now ) }} </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>จากวันที่ {{ $request->from_date }} ถึงวันที่ {{ $request->to_date }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            {{-- <td></td> --}}
            <td>เวลา: {{ now()->setTimezone('Asia/Bangkok')->format('H:i:s' ) }} </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            {{-- <td></td> --}}
            <td>หน้า:</td>
        </tr>
    </tbody>
</table>

{{------------------------data--------------------------}}
<table class="table table-bordered">
    <thead>
        <tr>
            <th style="border: 0.5px solid #000000; text-align: center;">รหัสลูกค้า</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ร้านค้า</th>
            <th style="border: 0.5px solid #000000; text-align: center;">กลุ่ม</th>
            <th style="border: 0.5px solid #000000; text-align: center;">จำนวน (พันมวน)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">มูลค่าขายปลีก</th>
            <th style="border: 0.5px solid #000000; text-align: center;">มูลค่าขาย</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ค่าการตลาด</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ภาษีมูลค่าเพิ่ม</th>
            <th style="border: 0.5px solid #000000; text-align: center;">อบจ.</th>
            <th style="border: 0.5px solid #000000; text-align: center;">แสตมป์</th>
            {{-- <th style="border: 0.5px solid #000000; text-align: center;">รายได้หลังหักภาษีและแสตมป์</th> --}}
        </tr>
    </thead>
    <tbody>
        @php
            ////////////// รวมทั้งสิ้น ////////////////////
            $all_total_roll_qty = 0; // จำนวน (พันมวน)
            $all_total_retail_amt = 0; // ราคาปลีก (บาท)
            $all_total_fact_amt = 0; // ราคาโรงงาน (บาท)
            $all_total_reduce_amt = 0; // ส่วนลดค่าการตลาด
            $all_total_tax_amt = 0; // ภาษีมูลค่าเพิ่ม
            $all_total_province_amt = 0; // อบจ.
            $all_total_stamp_amt = 0; // แสตมป์
            $all_total_sum_amt = 0; // รายได้หลังหักภาษีและแสตมป์
        @endphp
        @foreach ($data as $group_name => $groupCustomer)
            @php
                ////////////// รวม ////////////////////
                $total_roll_qty = 0; // จำนวน (พันมวน)
                $total_retail_amt = 0; // ราคาปลีก (บาท)
                $total_fact_amt = 0; // ราคาโรงงาน (บาท)
                $total_reduce_amt = 0; // ส่วนลดค่าการตลาด
                $total_tax_amt = 0; // ภาษีมูลค่าเพิ่ม
                $total_province_amt = 0; // อบจ.
                $total_stamp_amt = 0; // แสตมป์
                $total_sum_amt = 0; // รายได้หลังหักภาษีและแสตมป์
            @endphp
            @foreach ($groupCustomer as $customer_number => $items)
                @php
                    $add_pao = $pao->where('customer_number', $customer_number)->sum('pao_amount');

                    $customer_name = $items->first()->customer_name;
                    $sum_roll_qty = $items->sum('qty');
                    $sum_retail_amt = $items->sum('retail_amount');
                    $sum_fact_amt = $items->sum('amount');
                    $sum_reduce_amt = $sum_retail_amt - $sum_fact_amt;

                    $itemAdjust = $adjust->where('customer_number', $customer_number)->first() ?? false;
                    if($itemAdjust) {
                        $valueAdjust = $itemAdjust['adjust_amount'];
                    } else {
                        $valueAdjust = 0;
                    }

                    if ($found = $taxAdjust->where('customer_number', $customer_number)->first()) {
                        $sum_tax_amt = $found->total + $valueAdjust;
                    }else {
                        $sum_tax_amt = $items->sum('tax_amount');
                    }

                    // $sum_tax_amt = $items->sum('tax');
                    $sum_province_amt = $items->sum('pao_amount') + $add_pao;
                    $sum_stamp_amt = $items->reduce(function ($carry, $item) use($stamp) {
                        return $carry + ((optional($stamp->where('cigarette_code', $item->item_code)->first())->unit_price ?: 0) * ($item->qty * 50));
                    }, 0);
                    $sum_amt = $sum_fact_amt - ($sum_tax_amt - $sum_stamp_amt);

                    $total_roll_qty += $sum_roll_qty; // จำนวน (พันมวน)
                    $total_retail_amt += $sum_retail_amt; // ราคาปลีก (บาท)
                    $total_fact_amt += $sum_fact_amt; // ราคาโรงงาน (บาท)
                    $total_reduce_amt += $sum_reduce_amt; // ส่วนลดค่าการตลาด
                    $total_tax_amt += $sum_tax_amt; // ภาษีมูลค่าเพิ่ม
                    $total_province_amt += $sum_province_amt; // อบจ.
                    $total_stamp_amt += $sum_stamp_amt; // แสตมป์
                    $total_sum_amt += $sum_amt;// รายได้หลังหักภาษีและแสตมป์

                    ////////////// รวมทั้งสิ้น ////////////////////
                    $all_total_roll_qty += $sum_roll_qty; // จำนวน (พันมวน)
                    $all_total_retail_amt += $sum_retail_amt; // ราคาปลีก (บาท)
                    $all_total_fact_amt += $sum_fact_amt; // ราคาโรงงาน (บาท)
                    $all_total_reduce_amt += $sum_reduce_amt; // ส่วนลดค่าการตลาด
                    $all_total_tax_amt += $sum_tax_amt; // ภาษีมูลค่าเพิ่ม
                    $all_total_province_amt += $sum_province_amt; // อบจ.
                    $all_total_stamp_amt += $sum_stamp_amt; // แสตมป์
                    $all_total_sum_amt += $sum_amt; // รายได้หลังหักภาษีและแสตมป์
                @endphp
                <tr>
                    <td style="border: 0.5px solid #000000;">{{$customer_number}} </td>
                    <td style="border: 0.5px solid #000000;">{{$customer_name}} </td>
                    <td style="border: 0.5px solid #000000;">{{$group_name}} </td>

                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_roll_qty ?: '-' }} </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_retail_amt ?: '-' }} </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_fact_amt ?: '-' }} </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_reduce_amt ?: '-' }}  </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_tax_amt ?: '-' }} </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_province_amt ?: '-' }} </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_stamp_amt ?: '-' }}</td>
                    {{-- <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_amt ?: '-' }}</td> --}}
                </tr>
                @if ($loop->last)
                    <tr>
                        <td colspan="2" style="border: 0.5px solid #000000; text-align: right;">รวม</td>
                        <td style="border: 0.5px solid #000000; text-align: right;"></td>

                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_roll_qty ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_retail_amt ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_fact_amt ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_reduce_amt ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_tax_amt ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_province_amt ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_stamp_amt ?: '-' }} </td>
                        {{-- <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_sum_amt ?: '-' }} </td> --}}
                    </tr>
                @endif
            @endforeach
        @endforeach
        <tr>

        </tr>
        <tr>
            <td colspan="2" style="border: 0.5px solid #000000; text-align: right;">รวมทั้งสิ้น</td>
            <td style="border: 0.5px solid #000000; text-align: right;"></td>

            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_roll_qty ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_retail_amt ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_fact_amt ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_reduce_amt ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_tax_amt ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_province_amt ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_stamp_amt ?: '-' }} </td>
            {{-- <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_sum_amt ?: '-' }} </td> --}}
        </tr>
    </tbody>
</table>