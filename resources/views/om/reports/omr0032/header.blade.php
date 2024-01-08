<div class="row col-lg-12">
    <div class="col-md-7" style="font-size: 16px; text-align: left; width: 150px;">
        <div style=""> <strong> โปรแกรม : </strong> OMR0032 </div>
        <div style=""> <strong> สั่งพิมพ์ : </strong>  {{ optional(auth()->user())->username }} </div>
    </div>
    <div class="col-md-4" style="font-size: 20px; text-align: center; font-weight: bold;">
        <div style=""> การยาสูบแห่งประเทศไทย </div>
        <div style=""> รายงานภาษี อบจ.&nbsp;แยกรายจังหวัดและร้านค้า ประจำเดือน  {{ $monthTh }}</div>
    </div>
    <div align="right" class="col-md-1" style="font-size: 16px;">
        <div style=""> วันที่ : {{ parseToDateTh(now()) }} </div>
        <div style=""> เวลา : {{ date('H:i') }} </div>
        <div style=""> หน้า : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
    </div>
</div>

