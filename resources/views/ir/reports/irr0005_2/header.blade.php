<div class="row col-lg-12">
    <div style="font-size: 16px; text-align: left; width: 150px;">
        <div style="margin-bottom: 5px;"> <strong> โปรแกรม : </strong> {{ $programCode }} </div>
        <div style="margin-bottom: 5px;"> <strong> สั่งพิมพ์ : </strong> {{ optional(auth()->user())->name }}</div>
        <div style="margin-bottom: 5px;"> <strong> กลุ่ม : </strong> {{ $group_name }} </div>
        <div style="margin-bottom: 5px;"> <strong> ประเภทประกันภัย : </strong> {{ $renew_type }} </div>
    </div>
    <div style="font-size: 16px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 5px;"> การยาสูบแห่งประเทศไทย </div>
        <div style="margin-bottom: 5px;"> รายงานรายละเอียดค่าเบี้ยประกันภัยยานพาหนะ </div>
        <div style="margin-bottom: 5px;"> เดือนที่เริ่มต้นคิดค่าเบี้ย : {{ $month_start_th }}</div>
        <div style="margin-bottom: 5px;"> วันที่ {{ $start_date_to_th }}</div>
    </div>
    <div style="text-align: right; width: 150px; font-size: 16px;">
        <div style="margin-bottom: 5px;"> <strong>วันที่ :</strong> {{ parseToDateTh(now()) }} </div>
        <div style="margin-bottom: 5px;"> <strong>เวลา :</strong> {{ date('H:i') }} </div>
        <div style="margin-bottom: 5px;"> <strong>หน้า :</strong> {{ $page_no." / ".$pageAll }} </div>
    </div>
</div>

{{-- <div class="row col-lg-12" style="font-size: 16px; margin-top: 10px; margin-bottom: 10px;">
    <div align="right" class="col-md-3 offset-md-9" style=" font-size: 16px;">
        <strong> {{ $lines[0]['interface_status'] == 'S'? 'ส่งเข้า AR แล้ว': 'ยังไม่ส่งเข้า AR' }} </strong>
    </div>
</div> --}}
