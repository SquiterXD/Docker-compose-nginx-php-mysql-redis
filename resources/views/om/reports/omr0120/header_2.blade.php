

<div class="row col-lg-12">
    <div class="col-md-4" style="font-size: 16px; text-align: left; width: 150px;">
        <div style="margin-bottom: 15px; font-weight: bold;"> <strong></strong> รหัสโปรแกรม : OMR0120_1 </div>
        <div style="margin-bottom: 15px; font-weight: bold;"> <strong></strong> สั่งพิมพ์ : {{ $user->user_id }} </div>
    </div>
    <div class="col-md-4" style="font-size: 20px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"> การยาสูบแห่งประเทศไทย </div>
        <div style="margin-bottom: 10px;"> ยอดขายบุหรี่ตาม ใบ Invoice รายตรา/รายบริษัท </div>
        <div style="margin-bottom: 10px;"> ปีงบประมาณ {{ $years_th }} </div>
        <div style="margin-bottom: 10px;"> ตั้งแต่เดือน  {{$fm}} ถึงเดือน {{$tm}} </div>
    </div>
    <div align="right" class="col-md-4" style="font-size: 16px;">
        @php
            $now = date("d")."/".date("m")."/".(date("Y")+543);
        @endphp
        <div style="margin-bottom: 15px; font-weight: bold;"> วันที่ : {{ now()->setTimezone('Asia/Bangkok')->format($now) }} </div>
        <div style="margin-bottom: 15px; font-weight: bold;"> เวลา : {{ now()->setTimezone('Asia/Bangkok')->format('H:i:s' ) }} </div>
    </div>
</div>

<div class="row col-lg-12">
    <div class="col-md-4">
        <strong></strong>
    </div>
    <div class="col-md-4" style="font-size: 16px;">
        <strong></strong>
    </div>
    <div align="right" class="col-md-4" style="font-size: 16px;">
        <strong> หน่วยนับยาเส้น : {{ $tobacco_type->unit_of_measure }} </strong><br>
        <strong> หน่วยนับยาเส้นพอง/ใบยา : {{ $medicinal_type->unit_of_measure }} </strong>
    </div>
</div>

