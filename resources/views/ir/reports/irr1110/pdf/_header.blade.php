{{-- 
    <div class="row">
        <div  style=" width:20%;"> <h3> Program Code : IRR1110 </h3> </div>
        <div style="width:60%;" align="center"> <h3> การยาสูบแห่งประเทศไทย </h3> </div>
        <div style="width:10%;" align="right"> <h3> วันที่ : </h3> </div>
        <div style="width:10%;" align="left"> <h3> {{ ' '. parseToDateTh(now()) }} </h3> </div>
    </div>
    <div class="row">
        <div  style=" width:20%;"> <h3> สั่งพิมพ์ : </h3> </div>
        <div style="width:60%;" align="center"> 
        </div>
        <div style="width:10%;" align="right"> <h3> เวลา : </h3> </div>
        <div style="width:10%;" align="left"> <h3> {{ date('H:i', strtotime(now())) }} </h3> </div>
    </div>

    <div class="row">
        <div  style=" width:20%;"> <h3> </h3> </div>
        <div style="width:60%;" align="center"> <h3> เปลี่ยนชื่อรายงานเป็น ข้อมูลมูลค่าทุนประกัน (Inventory) รายปี  </h3> </div>
        <div style="width:10%;" align="right"> <h3>  </h3> </div>
        <div style="width:10%;" align="left"> <h3> </h3> </div>
    </div>
    <div class="row">
        <div  style=" width:20%;"> <h3> </h3> </div>
        <div style="width:60%;" align="center"> <h3>  </h3> </div>
        <div style="width:10%;" align="right"> </div>
        <div style="width:10%;" align="left"></div>
    </div> --}}

    <table width="100%" style="font-size: 16px">
        <tr >
            <td width="20%"> <span class="p-h2">Program Code : {{$program->program_code}} </span>  </td>
            <td width="70%"   align="center"> <span class="p-h2"> การยาสูบแห่งประเทศไทย </span>  </td>
            <td width="10%">   <span class="p-h2"> วันที่ :  {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }} </span> </td>
        </tr>
        <tr>
            <td>  สั่งพิมพ์ : {{  $userProfile->user_name}} </td>
            <td width="65%" align="center"> <span class="p-h2"> ชุดที่ : {{ $reportStocks[0]->policy_set_header_id. ' : '. $reportStocks[0]->policy_set_description}} </span></td>
            <td><span class="p-h2"> เวลา : {{ Carbon\Carbon::now()->format('H:i') }}</span></td>
        </tr>
        <tr>
            <td></td>
            <td width="70%"   align="center"> {{$program->description}}   </td>
            <td> หน้า: <span class="page"></span> / <span class="topage"></span></td>
        </tr>
    </table>


