<div class="row col-lg-12">
    <div class="col-md-7" style="font-size: 16px; text-align: left; width: 150px;">
        <div style="margin-bottom: 10px;"> <strong> โปรแกรม : </strong> {{ $programCode }} </div>
    </div>
    <div class="col-md-4" style="font-size: 16px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"> การยาสูบแห่งประเทศไทย </div>
        <div style="margin-bottom: 10px;"> คงคลังบุหรี่ที่อยู่ในโกดังขาย </div>
        <div style="margin-bottom: 10px;"> วันที่ {{ formatLongDateThai(date('Y-m-d')) }} เวลา 7:30 น. วันที่ผลิต : {{ formatLongDateThai($previousDate) }} </div>
    </div>
    <div align="right" class="col-md-1" style="font-size: 16px;">
        <div style="margin-bottom: 10px;"> วันที่ : {{ strtoupper(date('d-M-Y')) }} </div>
        <div style="margin-bottom: 10px;"> เวลา : {{ date('H:i') }} </div>
        <div style="margin-bottom: 10px;"> หน้า : {{ $page_no." / ".$page }} </div>
    </div>
</div>