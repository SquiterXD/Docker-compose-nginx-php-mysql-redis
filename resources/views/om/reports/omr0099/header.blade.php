<div class="row col-lg-12">
    <div class="col-md-7" style="font-size: 16px; text-align: left; width: 150px;">
        <div style=""> <strong> โปรแกรม : </strong> OMR0099 </div>
        <div style=""> <strong> สั่งพิมพ์ : </strong>  {{ optional(auth()->user())->username }} </div>
    </div>
    <div class="col-md-4" style="font-size: 20px; text-align: center; font-weight: bold;">
        <div style=""> การยาสูบแห่งประเทศไทย </div>
        @php 
        $month = Carbon\Carbon::createFromFormat('d/m/Y H:i:s', request()->month)->addYears(543);
        @endphp
        <div style=""> รายงานภาษี อบจ. ร้านค้า ป.1 ที่นำส่งธนาคาร ประจำวันที่ {{ $month->startOfMonth()->format('d/m/Y') }} ถึง {{ $month->endOfMonth()->format('d/m/Y') }}</div>
    </div>
    <div align="right" class="col-md-1" style="font-size: 16px;">
        <div style=""> วันที่ : {{ parseToDateTh(now()) }} </div>
        <div style=""> เวลา : {{ date('H:i') }} </div>
        <div style=""> หน้า : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
    </div>
</div>

