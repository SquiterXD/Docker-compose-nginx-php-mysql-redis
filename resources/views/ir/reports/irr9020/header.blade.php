<div class="row col-lg-12">
    <div class="col-md-7" style="font-size: 16px; text-align: left; width: 150px;">
        <div style="margin-bottom: 5px;"> <strong> โปรแกรม : </strong> {{ $programCode }} </div>
        <div style="margin-bottom: 5px;"> <strong> สั่งพิมพ์ : </strong> {{ $user_id }} </div>
        <div style="margin-bottom: 5px;"> <strong> กลุ่ม : </strong> {{ $group_name }} </div>
    </div>
    <div class="col-md-4" style="font-size: 20px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 5px;"> การยาสูบแห่งประเทศไทย </div>
        <div style="margin-bottom: 5px;"> รายงานรายละเอียดค่าเบี้ยประกันภัยยานพาหนะ </div>
        <div style="margin-bottom: 5px;"> ปีงบประมาณ {{ $thYear }} </div>
    </div>
    <div align="right" class="col-md-1" style="font-size: 16px;">
        <div style="margin-bottom: 5px;"> วันที่ : {{ strtoupper(date('d-M-Y')) }} </div>
        <div style="margin-bottom: 5px;"> เวลา : {{ date('H:i') }} </div>
        <div style="margin-bottom: 5px;"> หน้า : {{ $page_no." / ".$pageAll }} </div>
    </div>
</div>

{{-- <div class="row col-lg-12" style="font-size: 16px; margin-top: 10px; margin-bottom: 10px;">
    <div align="right" class="col-md-3 offset-md-9" style=" font-size: 16px;">
        <strong> {{ $lines[0]['interface_status'] == 'S'? 'ส่งเข้า AR แล้ว': 'ยังไม่ส่งเข้า AR' }} </strong>
    </div>
</div> --}}
