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
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
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
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>รายงานส่วนลดค่าการตลาด</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @php
                $now = date("d")."/".date("m")."/".(date("Y")+543);
            @endphp
            <td>วันที่: {{ now()->setTimezone('Asia/Bangkok')->format($now ) }} </td>
            <td></td>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>จากวันที่ {{ $request->from_date }} ถึงวันที่ {{ $request->to_date }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>เวลา: {{ now()->setTimezone('Asia/Bangkok')->format('H:i:s' ) }} </td>
            <td></td>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>หน้า:</td>
            <td></td>
        </tr>
    </tbody>
</table>

{{------------------------data--------------------------}}
<table class="table table-bordered">
    <thead>
        <tr>
            <th style="border: 0.5px solid #000000; min-width:150px; text-align: center;" rowspan="2">ตราสินค้า</th>
            <th style="border: 0.5px solid #000000; text-align: center;" colspan="6">ป.1</th>
            <th style="border: 0.5px solid #000000; text-align: center;" colspan="6">MT</th>
            <th style="border: 0.5px solid #000000; text-align: center;" colspan="6">CVS</th>
            <th style="border: 0.5px solid #000000; text-align: center;" colspan="6">สโมสร</th>
            <th style="border: 0.5px solid #000000; text-align: center;" colspan="9">รวม</th>
        </tr>
        <tr>
            <th style="border: 0.5px solid #000000; text-align: center;">จำนวน(พันมวน)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">จำนวน(ซอง)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ราคาโรงงาน(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ราคาปลีก(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ค่าการตลาด(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ค่าการตลาด/ซอง</th>

            <th style="border: 0.5px solid #000000; text-align: center;">จำนวน(พันมวน)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">จำนวน(ซอง)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ราคาโรงงาน(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ราคาปลีก(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ค่าการตลาด(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ค่าการตลาด/ซอง</th>
            
            <th style="border: 0.5px solid #000000; text-align: center;">จำนวน(พันมวน)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">จำนวน(ซอง)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ราคาโรงงาน(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ราคาปลีก(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ค่าการตลาด(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ค่าการตลาด/ซอง</th>

            <th style="border: 0.5px solid #000000; text-align: center;">จำนวน(พันมวน)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">จำนวน(ซอง)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ราคาโรงงาน(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ราคาปลีก(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ค่าการตลาด(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ค่าการตลาด/ซอง</th>

            <th style="border: 0.5px solid #000000; text-align: center;">จำนวน(พันมวน)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">จำนวน(ซอง)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ราคาโรงงาน(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ราคาปลีก(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ค่าการตลาด(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">ภาษีมูลค่าเพิ่ม(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">อบจ.(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">แสตมป์(บาท)</th>
            <th style="border: 0.5px solid #000000; text-align: center;">รายได้หลังภาษีฯและแสตมป์</th>
        </tr>
    </thead>
    <tbody>
        @php
                ////////////// MT //////////////////
                $all_MT_sumCusRQty20 = 0;
                $all_MT_sumCusPQty20 = 0;
                $all_MT_sumCtyPAmout20 = 0;
                $all_MT_sumCtyRAmout20 = 0;
                $all_MT_sumCtyPRAmout20 = 0;

                ////////////// CVS //////////////////
                $all_CVS_sumCusRQty20 = 0;
                $all_CVS_sumCusPQty20 = 0;
                $all_CVS_sumCtyPAmout20 = 0;
                $all_CVS_sumCtyRAmout20 = 0;
                $all_CVS_sumCtyPRAmout20 = 0;

                ////////////// P1 //////////////////
                $all_P1_sumCusRQty10 = 0;
                $all_P1_sumCusPQty10 = 0;
                $all_P1_sumCtyPAmout10 = 0;
                $all_P1_sumCtyRAmout10 = 0;
                $all_P1_sumCtyPRAmout10 = 0;

                ////////////// สโมสร //////////////////
                $all_CLUB_sumCusRQty3040 = 0;
                $all_CLUB_sumCusPQty3040 = 0;
                $all_CLUB_sumCtyPAmout3040 = 0;
                $all_CLUB_sumCtyRAmout3040 = 0;
                $all_CLUB_sumCtyPRAmout3040 = 0;

                ////////////// รวม ////////////////////
                $all_total_roll_qty = 0; // จำนวน (พันมวน)
                $all_total_pack_qty = 0; // จำนวน (ซอง)
                $all_total_retail_amt = 0; // ราคาปลีก (บาท)
                $all_total_fact_amt = 0; // ราคาโรงงาน (บาท)
                $all_total_reduce_amt = 0; // ส่วนลดค่าการตลาด
                $all_total_tax_amt = 0; // ภาษีมูลค่าเพิ่ม
                $all_total_province_amt = 0; // อบจ.
                $all_total_stamp_amt = 0; // แสตมป์
                $all_total_stamp_tax_amt = 0;
        @endphp
        {{-- {{ dd($data->groupBy(function($item, $key){
            if($item->customer_type_id == '30' || $item->customer_type_id == '40'){
                return '30,40';
            }
            else {
                return $item->customer_type_id;
            }
        }))
    }} --}}
        {{-- $data->groupBy('attribute1') --}}
        @foreach ($data as $key_lp => $value_lp)
        
            @php
                ////////////// MT //////////////////
                $MT_sumCusRQty20 = 0;
                $MT_sumCusPQty20 = 0;
                $MT_sumCtyPAmout20 = 0;
                $MT_sumCtyRAmout20 = 0;
                $MT_sumCtyPRAmout20 = 0;

                ////////////// CVS //////////////////
                $CVS_sumCusRQty20 = 0;
                $CVS_sumCusPQty20 = 0;
                $CVS_sumCtyPAmout20 = 0;
                $CVS_sumCtyRAmout20 = 0;
                $CVS_sumCtyPRAmout20 = 0;

                ////////////// P1 //////////////////
                $P1_sumCusRQty10 = 0;
                $P1_sumCusPQty10 = 0;
                $P1_sumCtyPAmout10 = 0;
                $P1_sumCtyRAmout10 = 0;
                $P1_sumCtyPRAmout10 = 0;

                ////////////// สโมสร //////////////////
                $CLUB_sumCusRQty3040 = 0;
                $CLUB_sumCusPQty3040 = 0;
                $CLUB_sumCtyPAmout3040 = 0;
                $CLUB_sumCtyRAmout3040 = 0;
                $CLUB_sumCtyPRAmout3040 = 0;

                ////////////// รวม ////////////////////
                $total_roll_qty = 0; // จำนวน (พันมวน)
                $total_pack_qty = 0; // จำนวน (ซอง)
                $total_retail_amt = 0; // ราคาปลีก (บาท)
                $total_fact_amt = 0; // ราคาโรงงาน (บาท)
                $total_reduce_amt = 0; // ส่วนลดค่าการตลาด
                $total_tax_amt = 0; // ภาษีมูลค่าเพิ่ม
                $total_province_amt = 0; // อบจ.
                $total_stamp_amt = 0; // แสตมป์
                $total_stamp_tax_amt = 0;
            @endphp
            <tr>
                <td style="border: 0.5px solid #000000; text-align: right;"> กลุ่มราคา {{$key_lp}} บาท </td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>

                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>

                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>

                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>

                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
                <td style="border: 0.5px solid #000000;"></td>
            </tr>
            @foreach ($value_lp as $k_lp => $va_lp)
                @php
                    ////////////// MT //////////////////
                    $MT_cusRQty20 = $va_lp->where('customer_type_id', 20)
                    ->filter(function ($item, $key) {
                        return is_null($item->attribute3);
                    })->sum('qty');
                    $MT_cusPQty20 = $MT_cusRQty20 * 50;
                    $MT_cusPAmount20 = $va_lp->where('customer_type_id', 20)
                    ->filter(function ($item, $key) {
                        return is_null($item->attribute3);
                    })->sum('amount');
                    $MT_cusRAmount20 = $va_lp->where('customer_type_id', 20)
                    ->filter(function ($item, $key) {
                        return is_null($item->attribute3);
                    })->sum('retail_amount');
                    $MT_cusSumPRAmount20 = $MT_cusRAmount20 - $MT_cusPAmount20;

                    $MT_sumCusRQty20 += $MT_cusRQty20;
                    $MT_sumCusPQty20 += $MT_cusPQty20;
                    $MT_sumCtyPAmout20 += $MT_cusPAmount20;
                    $MT_sumCtyRAmout20 += $MT_cusRAmount20;
                    $MT_sumCtyPRAmout20 += $MT_cusSumPRAmount20;

                    $all_MT_sumCusRQty20 += $MT_cusRQty20;
                    $all_MT_sumCusPQty20 += $MT_cusPQty20;
                    $all_MT_sumCtyPAmout20 += $MT_cusPAmount20;
                    $all_MT_sumCtyRAmout20 += $MT_cusRAmount20;
                    $all_MT_sumCtyPRAmout20 += $MT_cusSumPRAmount20;

                    ////////////// CVS //////////////////
                    $CVS_cusRQty20 = $va_lp->where('customer_type_id', 20)
                    ->filter(function ($item, $key) {
                        return !is_null($item->attribute3);
                    })->sum('qty');
                    $CVS_cusPQty20 = $CVS_cusRQty20 * 50;
                    $CVS_cusPAmount20 = $va_lp->where('customer_type_id', 20)
                    ->filter(function ($item, $key) {
                        return !is_null($item->attribute3);
                    })->sum('amount');
                    $CVS_cusRAmount20 = $va_lp->where('customer_type_id', 20)
                    ->filter(function ($item, $key) {
                        return !is_null($item->attribute3);
                    })->sum('retail_amount');
                    $CVS_cusSumPRAmount20 = $CVS_cusRAmount20 - $CVS_cusPAmount20;

                    $CVS_sumCusRQty20 += $CVS_cusRQty20;
                    $CVS_sumCusPQty20 += $CVS_cusPQty20;
                    $CVS_sumCtyPAmout20 += $CVS_cusPAmount20;
                    $CVS_sumCtyRAmout20 += $CVS_cusRAmount20;
                    $CVS_sumCtyPRAmout20 += $CVS_cusSumPRAmount20;

                    $all_CVS_sumCusRQty20 += $CVS_cusRQty20;
                    $all_CVS_sumCusPQty20 += $CVS_cusPQty20;
                    $all_CVS_sumCtyPAmout20 += $CVS_cusPAmount20;
                    $all_CVS_sumCtyRAmout20 += $CVS_cusRAmount20;
                    $all_CVS_sumCtyPRAmout20 += $CVS_cusSumPRAmount20;

                    ////////////// P1 //////////////////
                    $P1_cusRQty10 = $va_lp->where('customer_type_id', 10)->sum('qty');
                    $P1_cusPQty10 = $P1_cusRQty10 * 50;
                    $P1_cusPAmount10 = $va_lp->where('customer_type_id', 10)->sum('amount');
                    $P1_cusRAmount10 = $va_lp->where('customer_type_id', 10)->sum('retail_amount');
                    $P1_cusSumPRAmount10 = $P1_cusRAmount10 - $P1_cusPAmount10;

                    $P1_sumCusRQty10 += $P1_cusRQty10;
                    $P1_sumCusPQty10 += $P1_cusPQty10;
                    $P1_sumCtyPAmout10 += $P1_cusPAmount10;
                    $P1_sumCtyRAmout10 += $P1_cusRAmount10;
                    $P1_sumCtyPRAmout10 += $P1_cusSumPRAmount10;

                    $all_P1_sumCusRQty10 += $P1_cusRQty10;
                    $all_P1_sumCusPQty10 += $P1_cusPQty10;
                    $all_P1_sumCtyPAmout10 += $P1_cusPAmount10;
                    $all_P1_sumCtyRAmout10 += $P1_cusRAmount10;
                    $all_P1_sumCtyPRAmout10 += $P1_cusSumPRAmount10;

                    ////////////// สโมสร //////////////////
                    $CLUB_cusRQty3040 = $va_lp->whereIn('customer_type_id', ['30', '40'] )->sum('qty');
                    $CLUB_cusPQty3040 = $CLUB_cusRQty3040 * 50;
                    $CLUB_cusPAmount3040 = $va_lp->whereIn('customer_type_id', ['30', '40'] )->sum('amount');
                    $CLUB_cusRAmount3040 = $va_lp->whereIn('customer_type_id', ['30', '40'] )->sum('retail_amount');
                    $CLUB_cusSumPRAmount3040 = $CLUB_cusRAmount3040 - $CLUB_cusPAmount3040;

                    $CLUB_sumCusRQty3040 += $CLUB_cusRQty3040;
                    $CLUB_sumCusPQty3040 += $CLUB_cusPQty3040;
                    $CLUB_sumCtyPAmout3040 += $CLUB_cusPAmount3040;
                    $CLUB_sumCtyRAmout3040 += $CLUB_cusRAmount3040;
                    $CLUB_sumCtyPRAmout3040 += $CLUB_cusSumPRAmount3040;

                    $all_CLUB_sumCusRQty3040 += $CLUB_cusRQty3040;
                    $all_CLUB_sumCusPQty3040 += $CLUB_cusPQty3040;
                    $all_CLUB_sumCtyPAmout3040 += $CLUB_cusPAmount3040;
                    $all_CLUB_sumCtyRAmout3040 += $CLUB_cusRAmount3040;
                    $all_CLUB_sumCtyPRAmout3040 += $CLUB_cusSumPRAmount3040;

                    ////////////// รวม ////////////////////
                    $sum_roll_qty = $va_lp->sum('qty');
                    $sum_pack_qty = $sum_roll_qty * 50;
                    $sum_retail_amt = $va_lp->sum('retail_amount');
                    $sum_fact_amt = $va_lp->sum('amount');
                    $sum_reduce_amt = $sum_retail_amt - $sum_fact_amt;

                    $sum_tax_amt = 0;
                    $itemAdjust = $adjust->where('item_code', $k_lp)->first() ?? false;
                    if($itemAdjust) {
                        $valueAdjust = $itemAdjust->dr - $itemAdjust->cr;
                    } else {
                        $valueAdjust = 0;
                    }

                    if ($found = $taxAdjust->where('item_code', $k_lp)->first()) {
                        $sum_tax_amt = $found->total + $valueAdjust;
                    }
                    else {
                        $sum_tax_amt = $va_lp->sum('tax_amount');
                    }

                    $add_pao = $pao->where('item_code', $k_lp)->sum('pao_amount');
                    // $sum_tax_amt = $va_lp->sum('tax_amount');
                    $sum_province_amt = $va_lp->sum('pao_amount') + $add_pao;
                    $sum_stamp_amt = (optional($stamp->where('cigarette_code', $k_lp)->first())->unit_price ?: 0) * $sum_pack_qty; // $va_lp->sum('s_amount');
                    $sum_stamp_tax_amt = $sum_fact_amt - $sum_tax_amt - $sum_province_amt - $sum_stamp_amt; // $va_lp->sum('s_amount');

                    $total_roll_qty += $sum_roll_qty; // จำนวน (พันมวน)
                    $total_pack_qty += $sum_pack_qty; // จำนวน (ซอง)
                    $total_fact_amt += $sum_fact_amt; // ราคาโรงงาน (บาท)
                    $total_retail_amt += $sum_retail_amt; // ราคาปลีก (บาท)
                    $total_reduce_amt += $sum_reduce_amt; // ส่วนลดค่าการตลาด
                    $total_tax_amt += $sum_tax_amt; // ภาษีมูลค่าเพิ่ม
                    $total_province_amt += $sum_province_amt; // อบจ.
                    $total_stamp_amt += $sum_stamp_amt; // แสตมป์
                    $total_stamp_tax_amt += $sum_stamp_tax_amt; // รายได้หลังภาษีฯและแสตมป์

                    $all_total_roll_qty += $sum_roll_qty; // จำนวน (พันมวน)
                    $all_total_pack_qty += $sum_pack_qty; // จำนวน (ซอง)
                    $all_total_retail_amt += $sum_retail_amt; // ราคาโรงงาน (บาท)
                    $all_total_fact_amt += $sum_fact_amt; // ราคาปลีก (บาท)
                    $all_total_reduce_amt += $sum_reduce_amt; // ส่วนลดค่าการตลาด
                    $all_total_tax_amt += $sum_tax_amt; // ภาษีมูลค่าเพิ่ม
                    $all_total_province_amt += $sum_province_amt; // อบจ.
                    $all_total_stamp_amt += $sum_stamp_amt; // แสตมป์
                    $all_total_stamp_tax_amt += $sum_stamp_tax_amt; // รายได้หลังภาษีฯและแสตมป์

                @endphp
                <tr>
                    <td style="border: 0.5px solid #000000;">{{$va_lp->first()->item_description}} </td>
                    
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $P1_cusRQty10 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $P1_cusPQty10 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $P1_cusPAmount10 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $P1_cusRAmount10 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $P1_cusSumPRAmount10 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $P1_cusSumPRAmount10/($P1_cusPQty10 ?: 1) ?: '-' }}</td>

                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $MT_cusRQty20 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $MT_cusPQty20 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $MT_cusPAmount20 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $MT_cusRAmount20 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $MT_cusSumPRAmount20 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $MT_cusSumPRAmount20/($MT_cusPQty20 ?: 1) ?: '-' }}</td>

                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CVS_cusRQty20 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CVS_cusPQty20 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CVS_cusPAmount20 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CVS_cusRAmount20 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CVS_cusSumPRAmount20 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CVS_cusSumPRAmount20/($CVS_cusPQty20 ?: 1) ?: '-' }}</td>

                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CLUB_cusRQty3040 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CLUB_cusPQty3040 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CLUB_cusPAmount3040 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CLUB_cusRAmount3040 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CLUB_cusSumPRAmount3040 ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right; ">{{ $CLUB_cusSumPRAmount3040/($CLUB_cusPQty3040 ?: 1) ?: '-' }}</td>

                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_roll_qty ?: '-' }} </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_pack_qty ?: '-' }} </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_fact_amt ?: '-' }} </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_retail_amt ?: '-' }} </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_reduce_amt ?: '-' }}  </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_tax_amt ?: '-' }} </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_province_amt ?: '-' }} </td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_stamp_amt ?: '-' }}</td>
                    <td style="border: 0.5px solid #000000; text-align: right;"> {{ $sum_stamp_tax_amt ?: '-' }} </td>
                </tr>
                @if ($loop->last)
                    <tr>
                        <td style="border: 0.5px solid #000000; text-align: right;">รวม</td>
                        
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $P1_sumCusRQty10 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $P1_sumCusPQty10 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $P1_sumCtyPAmout10 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $P1_sumCtyRAmout10 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $P1_sumCtyPRAmout10 ?: '-'  }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $P1_sumCtyPRAmout10/($P1_sumCusPQty10 ?: 1) ?: '-'  }} </td>

                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $MT_sumCusRQty20 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $MT_sumCusPQty20 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $MT_sumCtyPAmout20 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $MT_sumCtyRAmout20 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $MT_sumCtyPRAmout20 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $MT_sumCtyPRAmout20/($MT_sumCusPQty20 ?: 1) ?: '-' }} </td>

                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CVS_sumCusRQty20 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CVS_sumCusPQty20 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CVS_sumCtyPAmout20 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CVS_sumCtyRAmout20 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CVS_sumCtyPRAmout20 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CVS_sumCtyPRAmout20/($CVS_sumCusPQty20 ?: 1) ?: '-' }} </td>

                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CLUB_sumCusRQty3040 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CLUB_sumCusPQty3040 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CLUB_sumCtyPAmout3040 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CLUB_sumCtyRAmout3040 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CLUB_sumCtyPRAmout3040 ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $CLUB_sumCtyPRAmout3040/($CLUB_sumCusPQty3040 ?: 1) ?: '-' }} </td>

                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_roll_qty ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_pack_qty ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_fact_amt ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_retail_amt ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_reduce_amt ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_tax_amt ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_province_amt ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_stamp_amt ?: '-' }} </td>
                        <td style="border: 0.5px solid #000000; text-align: right;"> {{ $total_stamp_tax_amt ?: '-' }} </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
        
        <tr>

        </tr>
        <tr>
            <td style="border: 0.5px solid #000000; text-align: right;">รวมทั้งสิ้น</td>

            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_P1_sumCusRQty10 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_P1_sumCusPQty10 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_P1_sumCtyPAmout10 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_P1_sumCtyRAmout10 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_P1_sumCtyPRAmout10 ?: '-'  }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_P1_sumCtyPRAmout10/($all_P1_sumCusPQty10 ?: 1) ?: '-'  }} </td>

            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_MT_sumCusRQty20 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_MT_sumCusPQty20 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_MT_sumCtyPAmout20 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_MT_sumCtyRAmout20 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_MT_sumCtyPRAmout20 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_MT_sumCtyPRAmout20/($all_MT_sumCusPQty20 ?: 1) ?: '-' }} </td>

            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CVS_sumCusRQty20 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CVS_sumCusPQty20 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CVS_sumCtyPAmout20 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CVS_sumCtyRAmout20 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CVS_sumCtyPRAmout20 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CVS_sumCtyPRAmout20/($all_CVS_sumCusPQty20 ?: 1) ?: '-' }} </td>

            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CLUB_sumCusRQty3040 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CLUB_sumCusPQty3040 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CLUB_sumCtyPAmout3040 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CLUB_sumCtyRAmout3040 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CLUB_sumCtyPRAmout3040 ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_CLUB_sumCtyPRAmout3040/($all_CLUB_sumCusPQty3040 ?: 1) ?: '-' }} </td>

            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_roll_qty ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_pack_qty ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_fact_amt ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_retail_amt ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_reduce_amt ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_tax_amt ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_province_amt ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_stamp_amt ?: '-' }} </td>
            <td style="border: 0.5px solid #000000; text-align: right;"> {{ $all_total_stamp_tax_amt ?: '-' }} </td>
        </tr>

    </tbody>
</table>
