<div class="row col-lg-12">
    <div class="col-md-4" style="font-size: 16px; text-align: left; width: 150px;">
        <div style="margin-bottom: 15px;"> <strong> โปรแกรม : </strong> {{ $programProfile->program_code }} </div>
        <div style="margin-bottom: 15px;"> <strong> สั่งพิมพ์ : </strong> {{ \Auth::user()->name }} </div>
        <div style="margin-bottom: 15px;">  </div>
    </div>
    <div class="col-md-4" style="font-size: 20px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"> การยาสูบแห่งประเทศไทย </div>
        <div style="margin-bottom: 10px;"> รายงานประมาณการค่าใช้จ่ายล่วงเวลา </div>
        <div style="margin-bottom: 10px;"> ปีงบประมาณ {{ $otMain->ppBiWeekly->period_year_thai }} ปักษ์ที่ {{ $otMain->ppBiWeekly->biweekly }} </div>
    </div>
    <div align="right" class="col-md-4" style="font-size: 16px;">
        <div style="margin-bottom: 15px;"> วันที่ : {{ strtoupper(date('d-M-Y')) }} </div>
        <div style="margin-bottom: 15px;"> เวลา : {{ date('H:i') }} </div>
        <div style="margin-bottom: 15px;"> หน้า : {{ $pageFix }}/{{ $totalPage }} </div>
    </div>
</div>