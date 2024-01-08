<br>
<div class="row col-lg-12">
    <div class="col-md-7" style="font-size: 16px; text-align: left; width: 150px;">
        <div style="margin-bottom: 10px;"> <strong> โปรแกรม : {{ $programCode }} </strong></div>
        <div style="margin-bottom: 10px;">  <strong> สั่งพิมพ์ : {{ auth()->user()->name }} </strong></div>
        <div style="margin-bottom: 10px;">  </div>
    </div>
    <div class="col-md-4" style="font-size: 16px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"> <strong> การยาสูบแห่งประเทศไทย</strong> </div>
        <div style="margin-bottom: 10px;"> <strong> รายงานสูญเสียแสตมป์</strong> </div>
        <div style="margin-bottom: 10px;"> <strong> ปีงบประมาณ : {{ $biweekly->period_year_thai }} &nbsp;&nbsp;&nbsp; ปักษ์ : {{$biweekly->biweekly}} </strong></div>
    </div>
    <div align="right" class="col-md-1" style="font-size: 16px;">
        <div style="margin-bottom: 10px;"> <strong> วันที่ : {{ strtoupper(date('d-m-Y')) }} </strong> </div>
        <div style="margin-bottom: 10px;"> <strong> เวลา : {{ date('H:i') }} </strong> </div>
        <div style="margin-bottom: 10px;"> <strong> หน้า : {{ $page_no." / ".$page }} </strong> </div>
    </div>
</div>