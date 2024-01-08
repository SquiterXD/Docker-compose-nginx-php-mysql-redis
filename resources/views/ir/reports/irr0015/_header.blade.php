<div class="row" style="font-size: 18px;">
    <div style="width:100%;" align="center"> <b> กระดาษทำการคำนวณทุนประกันแท้จริง และเบี้ยประกันภัยส่วนที่เหลือ - สต็อกสินค้า (30 ก.ย. {{ substr((int)$year+543 - 1, -2) }} - 30 ก.ย. {{ substr((int)$year+543, -2) }}) ปี {{ (int)$year+543 }} </b> </div>
</div>
@foreach ($policyNumbers as $key => $item)
    <div class="row" style="font-size: 18px; {{ $loop->last ? 'margin-bottom: 15px;' : ''}}">
        <div style="width:100%;" align="center"> <b> {{ $key }} กรมธรรม์เลขที่ {{ $item ? $item : '-' }} (แยกส่วนกลางและส่วนภูมิภาค)</b> </div>
    </div>
@endforeach
   

