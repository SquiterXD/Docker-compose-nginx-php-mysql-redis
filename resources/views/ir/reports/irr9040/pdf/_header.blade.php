@foreach ($insurance as $item)

    <div class="row">
        <div  style=" width:20%;"> <b> Program Code : IRR9040 </b> </div>
        <div style="width:60%;" align="center"> <b> การยาสูบแห่งประเทศไทย </b> </div>
        <div style="width:10%;" align="right"> <b> วันที่ :  </b> </div>
        <div style="width:10%;" align="left"> <b> {{ ' '. parseToDateTh(now()) }} </b> </div>
    </div>
    <div class="row">
        <div style="width:20%;"> <b> สั่งพิมพ์ : 00285</b> </div>
        <div style="width:60%;" align="center"> <b> รายงานรถยนต์สิ้นอายุกรมธรรม์ </b> </div>
        <div style="width:10%;" align="right"> <b> เวลา :  </b> </div>
        <div style="width:10%;" align="left"> <b> {{ date('H:i', strtotime(now())) }} </b> </div>
    </div>

    <div class="row">
        <div  style=" width:20%;"> <b> {{$item->group_desc}} </b> </div>
        <div style="width:60%;" align="center"> <b> เดือน {{$item->insurance_expire_date}}</b> </div>
        <div style="width:10%;" align="right"> <b> หน้า :  </b> </div>
        <div style="width:10%;" align="left"> <b> 1 </b> </div>
    </div>
 @break
@endforeach


