@foreach ($apIn as $value_hed)
@endforeach
<thead>
  <tr>
    <th></th>
    <th></th>
    <th></th>
    <th colspan="3" style="text-align: center;">การยาสูบแห่งประเทศไทย</th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="2">รหัสโปรแกรม : CTR0091</td>
    <td></td>
    <td colspan="3" style="text-align: center;">รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามผลิตภัณฑ์</td>
    <td></td>
    <td colspan="2" style="text-align: center;">วันที่พิมพ์ : {{ now()->setTimezone('Asia/Bangkok')->format('d/m/Y H:i ' ) }}</td>
  </tr>
  <tr>
    <td colspan="2">หน่วยงาน : {{ $value_hed->ct_dept_code }} {{ $value_hed->ct_dept_name }} </td>
    <td></td>
    <td colspan="3" style="text-align: center;">ตั้งแต่วันที่ {{ $value_hed->ct_accounting_date }}  ถึงวันที่ {{ $value_hed->ct_accounting_date }}</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2">ศูนย์ต้นทุน : {{ $value_hed->ct_cc_code }} {{ $value_hed->ct_cc_name }}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2">กลุ่มผลิตภัณฑ์ : 99 ไม่ระบุกลุ่มผลิตภัณฑ์</td>
    <td></td>
    <td colspan="4">รหัสผลิตภัณฑ์ : {{ $value_hed->ct_product_code}} {{ $value_hed->ct_product_name }}</td>
    <td>จำนวนที่ผลิต :</td>
    <td style="text-align: left">{{ $value_hed->ct_prd_aq_wipcomplete }}</td>
  </tr>
</tbody>

<table style="border: 1px solid #000000;">
    <thead>
      <tr>
        <th colspan="2" rowspan="2" style="text-align: center; border: 1px solid #000000;">รหัสวัตถุดิบ</th>
        <th rowspan="2" style="text-align: center; border: 1px solid #000000;">LOT</th>
        <th rowspan="2" style="text-align: center; border: 1px solid #000000;">รายละเอียด</th>
        <th rowspan="2" style="text-align: center; border: 1px solid #000000;">หน่วยนับ</th>
        <th colspan="3" style="text-align: center; border: 1px solid #000000;">จริง</th>
        <th rowspan="2" style="text-align: center; border: 1px solid #000000;" >หมายเหตุ</th>
      </tr>
      <tr>
        <th style="text-align: center; border: 1px solid #000000;">จำนวน</th>
        <th style="text-align: center; border: 1px solid #000000;">ราคา</th>
        <th style="text-align: center; border: 1px solid #000000;"> จำนวนเงิน</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($apIn as $value)
            <tr>
                <td  colspan="2" style="text-align: center; border: 1px solid #000000;">{{ $value->ct_dm_code }}</td>
                <td style="text-align: center; border: 1px solid #000000;">{{ $value->ct_dm_lot_inwip }}</td>
                <td style="text-align: left; border: 1px solid #000000;">{{ $value->ct_dm_name }}</td>
                <td style="text-align: center; border: 1px solid #000000;">{{ $value->ct_dm_uom }}</td>
                <td style="text-align: right; border: 1px solid #000000;">{{ $value->ct_dm_aq_inwip }}</td>
                <td style="text-align: right; border: 1px solid #000000;">{{ $value->ct_dm_ap_inwip }}</td>
                <td style="text-align: right; border: 1px solid #000000;">{{ $value->ct_dm_aqsp_inwip  }}</td>
                <td style="text-align: right; border: 1px solid #000000;"></td>
          </tr>
        @endforeach
        <tr>
            <td colspan="2" style="border: 0.5px solid #000000; text-align: center;"> </td>
            <td style="border: 0.5px solid #000000; text-align: center;"></td>
            <td style="border: 0.5px solid #000000;"></td>
            <td style="border: 0.5px solid #000000; text-align: center;"></td>
            <td style="border: 0.5px solid #000000; text-align: right;"></td>
            <td style="border: 0.5px solid #000000; text-align: center;">รวม</td>
            <td style="border: 0.5px solid #000000; text-align: right;">{{ $apIn->sum('ct_dm_aqsp_inwip')  }}</td>
            <td style="border: 0.5px solid #000000; text-align: right;"></td>
        </tr>
    </tbody>
</table>

<table style="border: 1px solid #000000;">
    <thead>
      <tr>
        <th colspan="4" style="border: 1px solid #000000;">สรุปการใช้วัตถุดิบ ผลิต ตามผลิตภัณฑ์ : {{ $value_hed->ct_product_name }}</th>
        <th style="border: 1px solid #000000; text-align:center">ปริมาณจริง</th>
        <th style="border: 1px solid #000000; text-align:center">จำนวนจริง</th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
        @foreach ($dm_group as $val_g)
            <tr>
                <td style="border: 1px solid #000000;"></td>
                <td colspan="3" style="border: 1px solid #000000;">{{ $val_g->ct_dm_group }} {{ $val_g->ct_dm_group_name }}</td>
                <td style="border: 1px solid #000000; text-align:right; ">{{ $val_g->ct_dm_aq_inwip }}</td>
                <td style="border: 1px solid #000000; text-align:right;">{{ $val_g->ct_dm_aqap_inwip }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>

<table style="border: 1px solid #000000;">
    <thead>
      <tr>
        <th colspan="4" style="border: 1px solid #000000;">สรุปการใช้วัตถุดิบ ผลิต ตามหน่วยงาน : {{ $value_hed->ct_dept_code }} {{ $value_hed->ct_dept_name }} </th>
        <th style="border: 1px solid #000000; text-align:center">ปริมาณจริง</th>
        <th style="border: 1px solid #000000; text-align:center">จำนวนจริง</th>
        <th></th>
        <th>จำนวนที่ผลิต :</th>
        <th style="text-align: left">{{ $value_hed->ct_prd_aq_wipcomplete }}</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($dm_group as $val_g)
        <tr>
            <td style="border: 1px solid #000000;"></td>
            <td colspan="3" style="border: 1px solid #000000;">{{ $val_g->ct_dm_group }} {{ $val_g->ct_dm_group_name }}</td>
            <td style="border: 1px solid #000000; text-align:right; ">{{ $val_g->ct_dm_aq_inwip }}</td>
            <td style="border: 1px solid #000000; text-align:right;">{{ $val_g->ct_dm_aqap_inwip }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>

<table style="border: 1px solid #000000;">
    <thead>
      <tr>
        <th colspan="4" style="border: 1px solid #000000;">สรุปการใช้วัตถุดิบรวมทุกผลิตภัณฑ์ : {{ $value_hed->ct_product_name }}</th>
        <th style="border: 1px solid #000000; text-align:center">ปริมาณจริง</th>
        <th style="border: 1px solid #000000; text-align:center">จำนวนจริง</th>
        <th></th>
        <th>จำนวนที่ผลิต :</th>
        <th style="text-align: left">{{ $value_hed->ct_prd_aq_wipcomplete }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($dm_group as $val_g)
            <tr>
                <td style="border: 1px solid #000000;"></td>
                <td colspan="3" style="border: 1px solid #000000;">{{ $val_g->ct_dm_group }} {{ $val_g->ct_dm_group_name }}</td>
                <td style="border: 1px solid #000000; text-align:right; ">{{ $val_g->ct_dm_aq_inwip }}</td>
                <td style="border: 1px solid #000000; text-align:right;">{{ $val_g->ct_dm_aqap_inwip }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
