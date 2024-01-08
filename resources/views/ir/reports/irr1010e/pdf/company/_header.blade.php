
    <div class="row">
        <div  style=" width:20%;"> <h3> Program Code : IRR1010 </h3> </div>
        <div style="width:60%;" align="center"> <h3> การยาสูบแห่งประเทศไทย </h3> </div>
        <div style="width:10%;" align="right"> <h3> วันที่ : </h3> </div>
        <div style="width:10%;" align="left"> <h3> {{ ' '. parseToDateTh(now()) }} </h3> </div>
    </div>
    <div class="row">
        <div  style=" width:20%;"> <h3> </h3> </div>
        <div style="width:60%;" align="center"> 
            {{-- <h3> ชุดที่: {{ $policySetDes }}</h3>  --}}
        </div>
        <div style="width:10%;" align="right"> <h3> เวลา : </h3> </div>
        <div style="width:10%;" align="left"> <h3> {{ date('H:i', strtotime(now())) }} </h3> </div>
    </div>

    <div class="row">
        <div  style=" width:20%;"> <h3> </h3> </div>
        <div style="width:60%;" align="center"> <h3> เปลี่ยนชื่อรายงานเป็น ข้อมูลมูลค่าทุนประกัน (Inventory) รายปี</h3> </div>
        <div style="width:10%;" align="right"> <h3>  </h3> </div>
        <div style="width:10%;" align="left"> <h3> </h3> </div>
    </div>
    <div class="row">
        <div  style=" width:20%;"> <h3> </h3> </div>
        <div style="width:60%;" align="center"> <h3>  {{ $date["month"] }} </h3> </div>
        <div style="width:10%;" align="right"> </div>
        <div style="width:10%;" align="left"></div>
    </div>


