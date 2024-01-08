<div class="row col-lg-12">
    <div class="col-md-6" style="font-size: 16px; text-align: left;">
        <div style="margin-bottom: 10px;"><strong> โปรแกรม : CTR0036 &nbsp; CTP0005</strong></div>
        <div style="margin-bottom: 10px;"><strong> สั่งพิมพ์ : {{ Auth::user()->name }} </strong></div>
        <div> </div>
    </div>
    <div class="col-md-4" style="font-size: 16px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"><strong> การยาสูบแห่งประเทศไทย </strong></div>
        <div style="margin-bottom: 10px;"><strong> รายงานต้นทุนขายแยกแสตมป์และกองทุน </strong></div>
        <div><strong> ประจำเดือน : {{ $request->period_name }} &nbsp; ประเภท : {{ $productType }} </strong></div>
    </div>
    <div align="right" class="col-md-1" style="font-size: 16px;">
        <div style="margin-bottom: 10px;"><strong> วันที่ : {{ date('d-m-Y') }} </strong></div>
        <div style="margin-bottom: 10px;"><strong> เวลา : {{ date('H:i') }} </strong></div>
        <div><strong> หน้า {{ $page_no }}/{{ $page }} </strong></div>
    </div>
</div>
