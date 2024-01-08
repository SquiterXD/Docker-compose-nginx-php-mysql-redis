<div class="row col-lg-12">
    <div class="col-md-4" style="font-size: 16px; text-align: left; width: 150px;">
        <div style="margin-bottom: 15px;"> <strong> โปรแกรม : </strong> {{ $programCode }} </div>
        <div style="margin-bottom: 15px;"> <strong> ประเภทประกันภัย : </strong> {{ $lines[0]['interface_type'] }} </div>
        <div style="margin-bottom: 15px;"> <strong> Batch Name : </strong> {{ $lines[0]['invoice_batch'] }} </div>
    </div>
    <div class="col-md-4" style="font-size: 18px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"> การยาสูบแห่งประเทศไทย </div>
        <div style="margin-bottom: 10px;"> รายงานส่งข้อมูลค่าเบี้ยประกันภัยจ่ายล่วงหน้า </div>
        <div style="margin-bottom: 10px;"> ข้อมูลค่าเบี้ยประกันภัยจ่ายล่วงหน้า </div>
    </div>
    <div align="right" class="col-md-4" style="font-size: 16px;">
        <div style="margin-bottom: 15px;"> วันที่ : {{ strtoupper(date('d-M-Y')) }} </div>
        <div style="margin-bottom: 15px;"> เวลา : {{ date('H:i') }} </div>
        <div style="margin-bottom: 15px;"> หน้า : {{ $page_no." / ".$page }} </div>
    </div>
</div>

<div class="row col-lg-12" style="font-size: 16px; margin-top: 10px; margin-bottom: 10px; ">
    <div class="col-md-9">
        <strong> Group ID : </strong> {{ $lines[0]['h_attribute2'] }}
    </div>
    <div align="right" class="col-md-3" style="font-size: 16px;">
        <strong> {{ $lines[0]['interface_status'] == 'S'? 'ส่งเข้า AP แล้ว': 'ยังไม่ส่งเข้า AP' }} </strong>
    </div>
</div>

