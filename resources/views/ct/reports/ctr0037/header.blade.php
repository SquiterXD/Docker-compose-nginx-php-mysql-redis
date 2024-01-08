<div class="row col-lg-12">
    <div class="col-md-6" style="font-size: 16px; text-align: left;">
        <div style="margin-bottom: 10px;"><strong> โปรแกรม : CTR0037 </strong></div>
        <div style="margin-bottom: 10px;"><strong> สั่งพิมพ์ : {{ Auth::user()->name }} </strong></div>
        <div> </div>
        <div> </div>
    </div>
    <div class="col-md-4" style="font-size: 16px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"><strong> การยาสูบแห่งประเทศไทย </strong></div>
        <div style="margin-bottom: 10px;"><strong> รายงานบุหรี่ระหว่างทาง (ยอดขนแต่ยังไม่ได้ขาย) </strong></div>
        <div><strong> ประจำสิ้นเดือน : {{ $period->month_thai }} {{ date('Y', strtotime($period->start_date_thai)) }} </strong></div>
        <div> </div>
    </div>
    <div align="right" class="col-md-1" style="font-size: 16px;">
        <div style="margin-bottom: 10px;"><strong> วันที่ : {{ date('d-m-Y') }} </strong></div>
        <div style="margin-bottom: 10px;"><strong> เวลา : {{ date('H:i') }} </strong></div>
        <div style="margin-bottom: 10px;"><strong> หน้า {{ $page_no }}/{{ $page }} </strong></div>
        <div><strong>  หน่วย: พันมวน  </strong></div>
    </div>
</div>
