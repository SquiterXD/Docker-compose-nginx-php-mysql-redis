
@php
    $borderLine = 'border: 1px solid #000000; vertical-align: middle;';
@endphp
<table class="table-excel">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th  align="center" colspan="13"><b>การยาสูบแห่งประเทศไทย</b> </th>
            <th></th>
            <th></th>
          </tr>
        <tr>
            <th> <b>รหัสโปรแกรม : CTRP0097</b> </th>
            <th></th>
            <th align="center" colspan="13"><b>กระดาษทำการคำนวณค่าวัตถุดิบ-มาตรฐานและคิดเข้างาน ตามคำสั่งผลิต</b> </th>
            <th><b>วันที่พิมพ์ :</b> </th>
            <th>{{date('d/m/Y H:m', strtotime(now())) }}</th>
        </tr>
        <tr>
            <th><b>ปีงบประมาณ : 2565</b> </th>
            <th></th>
            <th> <b> {{ $tDate}} </b> </th>
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
        <tr>
            <th colspan="2">  <b>หน่วยงาน  61000200 กองผลิตยาเส้น</b> </th>
            <th> <b>{{ $mfgBatchHeader->ct_cc_code . ' : '. $mfgBatchHeader->ct_cc_name  }}</b>  </th>
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
        <tr>
            <th align="center" rowspan="3" style="{{ $borderLine }}"><b> รหัส </b></th>
            <th align="center" rowspan="3" style="{{ $borderLine }}"><b> LOT </b></th>
            <th align="center" rowspan="3" style="{{ $borderLine }}"><b> รายละเอียด </b></th>
            <th align="center" rowspan="3" style="{{ $borderLine }}"><b> คำสั่งผลิต </b></th>
            <th align="center" rowspan="3" style="{{ $borderLine }}"><b> หน่วยนับ </b></th>
            <th align="center" style="{{ $borderLine }}"><b>ปริมาณ</b></th>
            <th align="center" colspan="2" style="{{ $borderLine }}"><b>ปริมาณมาตรฐาน</b></th>
            <th align="center" colspan="2" style="{{ $borderLine }}"><b>ค่าวัตถุดิบ-มาตรฐาน </b></th>
            <th align="center" colspan="2" style="{{ $borderLine }}"><b>ค่าวัตถุดิบ-คิดเข้างาน</b></th>
            <th align="center" style="{{ $borderLine }}"><b>ค่าแรง</b></th>
            <th align="center" style="{{ $borderLine }}"><b>ค่าใช้จ่ายการผลิตผันแปร</b></th>
            <th align="center" style="{{ $borderLine }}"><b>ค่าใช้จ่ายการผลิตคงที่</b></th>
            <th align="center" style="{{ $borderLine }}"><b>รวมต้นทุนการผลิต</b></th>
            <th align="center" style="{{ $borderLine }}"><b>รวมต้นทุนการผลิต</b></th>
        </tr>
        <tr>
            <th align="center" style="{{ $borderLine }}"><b>ผลผลิต </b></th>
            <th align="center" style="{{ $borderLine }}"><b>ปริมาณ</b></th>
            <th align="center" style="{{ $borderLine }}"><b>ราคาต่อหน่วย&nbsp;&nbsp;&nbsp;(บาท)</b></th>
            <th align="center" style="{{ $borderLine }}"><b>ปริมาณ</b></th>
            <th align="center" style="{{ $borderLine }}"><b>ต้นทุน&nbsp;&nbsp;&nbsp;(บาท)</b></th>
            <th align="center" style="{{ $borderLine }}"><b>ปริมาณ</b></th>
            <th align="center" style="{{ $borderLine }}"><b>ต้นทุน (บาท)</b></th>
            <th align="center" style="{{ $borderLine }}"></th>
            <th align="center" style="{{ $borderLine }}"></th>
            <th align="center" style="{{ $borderLine }}"></th>
            <th align="center" rowspan="2" style="{{ $borderLine }}"><b>มาตรฐาน</b></th>
            <th align="center" rowspan="2" style="{{ $borderLine }}"><b>คิดเข้างาน</b></th>
        </tr>
        <tr>
            <th align="center" style="{{ $borderLine }}"><b>(Output)  </b></th>
            <th align="center" style="{{ $borderLine }}"><b>SQ. </b> </th>
            <th align="center" style="{{ $borderLine }}"><b>SP.  </b></th>
            <th align="center" style="{{ $borderLine }}"><b>(Output&nbsp;&nbsp;&nbsp;* SQ)  </b></th>
            <th align="center" style="{{ $borderLine }}"><b>(Output&nbsp;&nbsp;&nbsp;* SQ * SP)  </b></th>
            <th align="center" style="{{ $borderLine }}"><b>AQ.  </b></th>
            <th align="center" style="{{ $borderLine }}"><b>AQ.* SP </b> </th>
            <th align="center" style="{{ $borderLine }}"></th>
            <th align="center" style="{{ $borderLine }}"></th>
            <th align="center" style="{{ $borderLine }}"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mfgBatchGenWipends as $productCode => $mfgBatchGenWipendByProductCode)
            <tr>
                @php
                        $ct_std_dl_per_ccunit   =    $mfgBatchGenWipendByProductCode->first()->ct_std_dl_per_ccunit; 
                        $ct_std_voh_per_ccunit  =    $mfgBatchGenWipendByProductCode->first()->ct_std_voh_per_ccunit; 
                        $ct_std_foh_per_ccunit  =    $mfgBatchGenWipendByProductCode->first()->ct_std_foh_per_ccunit; 
                        $ct_std_prd_per_ccunit  =    $mfgBatchGenWipendByProductCode->first()->ct_std_prd_per_ccunit; 
                        $sumUnitPrice           =       $ct_std_prd_per_ccunit - $ct_std_dl_per_ccunit - $ct_std_voh_per_ccunit - $ct_std_foh_per_ccunit;
                        $ct_prd_aq_wipcomplete  =  $mfgBatchGenWipendByProductCode->where('ct_prd_aq_wipcomplete', '!=',null)->first()->ct_prd_aq_wipcomplete;
                @endphp
                <th style="{{ $borderLine }}"><b>{{ $mfgBatchGenWipendByProductCode->first()->ct_product_code }}</b></th>
                <th style="{{ $borderLine }}"></th>
                <th style="{{ $borderLine }}"><b>{{ $mfgBatchGenWipendByProductCode->first()->ct_product_name }}</b></th>
                <th style="{{ $borderLine }}"><b>{{ $mfgBatchGenWipendByProductCode->first()->ct_batch_no }}</b></th>
                <th align="center" style="{{ $borderLine }}"><b>{{ $mfgBatchGenWipendByProductCode->first()->ct_product_uom_name }}</b>
                </th>
                <th style="{{ $borderLine }}">
                    <b>{{ $ct_prd_aq_wipcomplete}}</b></th>
                <th style="{{ $borderLine }}">
                    </th>
                <th style="{{ $borderLine }}"><b>{{ $sumUnitPrice }} </b>  </th>
                <th style="{{ $borderLine }}"></th>
                <th style="{{ $borderLine }}"></th>
                <th style="{{ $borderLine }}"></th>
                <th style="{{ $borderLine }}"></th>
                <th style="{{ $borderLine }}">
                    <b>{{ $ct_std_dl_per_ccunit }} </b></th>
                <th style="{{ $borderLine }}">
                    <b>{{ $ct_std_voh_per_ccunit }} </b></th>
                <th style="{{ $borderLine }}">
                    <b>{{ $ct_std_foh_per_ccunit }} </b></th>
                <th style="{{ $borderLine }}">
                    <b>{{ $ct_std_prd_per_ccunit }} </b></th>
                <th style="{{ $borderLine }}"></th>
            </tr>
            @foreach ($mfgBatchGenWipendByProductCode->groupBy(function ($q) {
                    return $q->ct_inv_org_dm . ' ' . $q->ct_inv_org_dm_name;
                })
            as $org => $mfgBatchGenWipendByOrg)
                <tr>
                    <td colspan="17" style="{{ $borderLine }}"> <b>{{ $org }}</b> </td>
                </tr>
                @foreach ($mfgBatchGenWipendByOrg as $mfgBatchGenWipend)
                    <tr>
                        <td style="{{ $borderLine }}"> {{ $mfgBatchGenWipend->ct_dm_code }} </td>
                        <td style="{{ $borderLine }}"> {{ $mfgBatchGenWipend->ct_dm_lot_inwip }} </td>
                        <td style="{{ $borderLine }}"> {{ $mfgBatchGenWipend->ct_dm_name }} </td>
                        <td style="{{ $borderLine }}"> </td>
                        <td align="center" style="{{ $borderLine }}"> {{ $mfgBatchGenWipend->ct_dm_uom }} </td>
                        <td style="{{ $borderLine }}"></td>
                        <td align="right" style="{{ $borderLine }}">
                            {{ $mfgBatchGenWipend->ct_std_dm_qty }} </td>
                        <td align="right" style="{{ $borderLine }}">
                            {{ $mfgBatchGenWipend->ct_std_dm_per_ccunit }} </td>
                        <td align="right" style="{{ $borderLine }}">
                            {{ $mfgBatchGenWipend->ct_dm_sq_inwip }}</td>
                        <td align="right" style="{{ $borderLine }}">
                            {{ $mfgBatchGenWipend->ct_dm_sqsp_inwip }} </td>
                        <td align="right" style="{{ $borderLine }}">
                            {{ $mfgBatchGenWipend->ct_dm_aq_inwip }} </td>
                        <td align="right" style="{{ $borderLine }}">
                            {{ $mfgBatchGenWipend->ct_dm_aqsp_inwip }}  </td>
                        <td style="{{ $borderLine }}"> </td>
                        <td style="{{ $borderLine }}"></td>
                        <td style="{{ $borderLine }}"></td>
                        <td style="{{ $borderLine }}"></td>
                        <td style="{{ $borderLine }}"></td>
                    </tr>
                @endforeach
                <tr>
                    <th style="{{ $borderLine }}" colspan="8"><b>รวม {{ $org }}</b> </th>
                    <th align="right" style="{{ $borderLine }}"><b>
                            {{ $mfgBatchGenWipendByOrg->sum('ct_dm_sq_inwip') }} </b></th>
                    <th align="right" style="{{ $borderLine }}"><b>
                            {{ $mfgBatchGenWipendByOrg->sum('ct_dm_sqsp_inwip') }} </b></th>
                    <th align="right" style="{{ $borderLine }}"><b>
                            {{ $mfgBatchGenWipendByOrg->sum('ct_dm_aq_inwip') }} </b></th>
                    <th align="right" style="{{ $borderLine }}"><b>
                            {{ $mfgBatchGenWipendByOrg->sum('ct_dm_aqsp_inwip') }} </b> </th>
                    <th style="{{ $borderLine }}"></th>
                    <th style="{{ $borderLine }}"></th>
                    <th style="{{ $borderLine }}"></th>
                    <th style="{{ $borderLine }}"></th>
                    <th style="{{ $borderLine }}"></th>
                </tr>
            @endforeach
            <tr>
                @php
                    $a = $ct_prd_aq_wipcomplete * $ct_std_dl_per_ccunit;
                    $b = $ct_prd_aq_wipcomplete * $ct_std_voh_per_ccunit;
                    $c = $ct_prd_aq_wipcomplete * $ct_std_foh_per_ccunit;
                    $d = $ct_prd_aq_wipcomplete * $ct_std_prd_per_ccunit
                @endphp
                <th style="{{ $borderLine }}" colspan="8"><b>รวมตามคำสั่งผลิต {{$mfgBatchGenWipendByProductCode->first()->ct_batch_no}} </b> </th>
                <th align="right" style="{{ $borderLine }}"><b>
                        {{ $mfgBatchGenWipendByProductCode->sum('ct_dm_sq_inwip') }} </b></th>
                <th align="right" style="{{ $borderLine }}"><b>
                        {{ $mfgBatchGenWipendByProductCode->sum('ct_dm_sqsp_inwip') }} </b></th>
                <th align="right" style="{{ $borderLine }}"><b>
                        {{ $mfgBatchGenWipendByProductCode->sum('ct_dm_aq_inwip') }} </b></th>
                <th align="right" style="{{ $borderLine }}"><b>
                        {{ $mfgBatchGenWipendByProductCode->sum('ct_dm_aqsp_inwip') }} </b> </th>
                <th align="right" style="{{ $borderLine }}">{{  $a }}  </th>
                <th align="right" style="{{ $borderLine }}">{{  $b }}</th>
                <th align="right" style="{{ $borderLine }}">{{  $c }}</th>
                <th align="right" style="{{ $borderLine }}">{{  $d }}</th>
                <th align="right" style="{{ $borderLine }}">{{  $mfgBatchGenWipendByProductCode->sum('ct_dm_aqsp_inwip')+$a+$b+$c  }} </th>
            </tr>
            <tr>
                <td colspan="17"></td>
            </tr>
            <tr>
                <td style="{{ $borderLine }}" colspan="17">สรุปตาม Org.ของวัตถุดิบ </td>
            </tr>

            @foreach ($mfgBatchGenWipendByProductCode->groupBy(function ($q) {
                        return $q->ct_inv_org_dm . ' ' . $q->ct_inv_org_dm_name;
                    })
                as $org => $mfgBatchGenWipendByOrg)
                <tr>
                    <th style="{{ $borderLine }}" colspan="8"><b>รวม {{ $org }}</b> </th>
                    <th align="right" style="{{ $borderLine }}"><b>
                            {{ $mfgBatchGenWipendByOrg->sum('ct_dm_sq_inwip') }} </b></th>
                    <th align="right" style="{{ $borderLine }}"><b>
                            {{ $mfgBatchGenWipendByOrg->sum('ct_dm_sqsp_inwip') }} </b></th>
                    <th align="right" style="{{ $borderLine }}"><b>
                            {{ $mfgBatchGenWipendByOrg->sum('ct_dm_aq_inwip') }} </b></th>
                    <th align="right" style="{{ $borderLine }}"><b>
                            {{ $mfgBatchGenWipendByOrg->sum('ct_dm_aqsp_inwip') }} </b> </th>
                    <th style="{{ $borderLine }}"></th>
                    <th style="{{ $borderLine }}"></th>
                    <th style="{{ $borderLine }}"></th>
                    <th style="{{ $borderLine }}"></th>
                    <th style="{{ $borderLine }}"></th>
                </tr>
                @if ($loop->last)
                    <tr>
                        <th style="{{ $borderLine }}" colspan="8"><b>รวมทั้งสิ้น</b> </th>
                        <th align="right" style="{{ $borderLine }}"><b>
                                {{ $mfgBatchGenWipendByProductCode->sum('ct_dm_sq_inwip') }} </b></th>
                        <th align="right" style="{{ $borderLine }}"><b>
                                {{ $mfgBatchGenWipendByProductCode->sum('ct_dm_sqsp_inwip') }} </b></th>
                        <th align="right" style="{{ $borderLine }}"><b>
                                {{ $mfgBatchGenWipendByProductCode->sum('ct_dm_aq_inwip') }} </b></th>
                        <th align="right" style="{{ $borderLine }}"><b>
                                {{ $mfgBatchGenWipendByProductCode->sum('ct_dm_aqsp_inwip') }} </b> </th>
                        <th align="right" style="{{ $borderLine }}">{{  $a }}  </th>
                        <th align="right" style="{{ $borderLine }}">{{  $b }}</th>
                        <th align="right" style="{{ $borderLine }}">{{  $c }}</th>
                        <th align="right" style="{{ $borderLine }}">{{  $d }}</th>
                        <th align="right" style="{{ $borderLine }}">{{  $mfgBatchGenWipendByProductCode->sum('ct_dm_aqsp_inwip')+$a+$b+$c  }} </th>
                    </tr>
                    <tr>
                        <td colspan="17"></td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>
