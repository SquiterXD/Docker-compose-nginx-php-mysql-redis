
    <div class="row">
        <div  style=" width:20%;"> <b> Program Code : IRR9110 </b> </div>
        <div style="width:60%;" align="center"> <b> การยาสูบแห่งประเทศไทย </b> </div>
        <div style="width:10%;" align="right"> <b> วันที่ : </b> </div>
        <div style="width:10%;" align="left"> <b> {{ ' '. parseToDateTh(now()) }} </b> </div>
    </div>
    <div class="row">
        <div  style=" width:20%;"> <b> </b> </div>
        <div style="width:60%;" align="center"> <b> รายงานการบันทึกบัญชีค่าเบี้ยประกันภัยยานพาหนะ ประจำเดือน {{$element->period_name}}</b> </div>
        <div style="width:10%;" align="right"> <b> เวลา : </b> </div>
        <div style="width:10%;" align="left"> <b> {{ date('H:i', strtotime(now())) }} </b> </div>
    </div>

    <div class="row">
        <div  style=" width:20%;"> <b> </b> </div>
        <div style="width:60%;" align="center"> <b> {{$element->renew_type }} - {{$element->group_desc}}</b> </div>
        <div style="width:10%;" align="right"> <b> หน้า : </b> </div>
        <div style="width:10%;" align="left"> <b> 1 </b> </div>
    </div>



