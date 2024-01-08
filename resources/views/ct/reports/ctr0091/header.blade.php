
@foreach ($apIn as $value)
@endforeach
<div class="row col-lg-12">
    <div class="col-md-4" style="font-size: 16px; text-align: left; width: 150px;">
        <div style="margin-bottom: 15px;"> <strong> รหัสโปรแกรม : CTR0091</strong>  </div>
        <div style="margin-bottom: 15px;"> <strong> หน่วยงาน : {{ $value->ct_dept_code }} {{ $value->ct_dept_name }}</strong> </div>
        <div style="margin-bottom: 15px;"> <strong> ศูนย์ต้นทุน : {{ $value->ct_cc_code }} {{ $value->ct_cc_name }} </strong></div>
    </div>
    <div class="col-md-4" style="font-size: 20px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"> การยาสูบแห่งประเทศไทย </div>
        <div style="margin-bottom: 10px;"> รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามผลิตภัณฑ์ </div>
        <div style="margin-bottom: 10px;"> ตั้งแต่วันที่ {{ $value->ct_accounting_date }}  ถึงวันที่ {{ $value->ct_accounting_date }} </div>
    </div>
    <div align="right" class="col-md-4" style="font-size: 16px;">
        <div style="margin-bottom: 15px;"> วันที่พิมพ์ : {{ now()->setTimezone('Asia/Bangkok')->format('d/m/Y H:i ' ) }} </div>
    </div>
</div>

<div class="row col-lg-12">
    <div class="col-md-4">
        <strong> กลุ่มผลิตภัณฑ์ : 99 ไม่ระบุกลุ่มผลิตภัณฑ์</strong>
    </div>
    <div class="col-md-4" style="font-size: 16px;">
        <strong> รหัสผลิตภัณฑ์ : {{ $value->ct_product_code}} {{ $value->ct_product_name }}</strong>
    </div>
    <div align="right" class="col-md-4" style="font-size: 16px;">
        <strong> จำนวนที่ผลิต : {{ number_format($value->ct_prd_aq_wipcomplete, 2) }}  </strong>
    </div>
</div>

