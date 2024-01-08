<div class="row col-lg-12">
    <div class="col-md-7" style="font-size: 16px; text-align: left; font-weight: bold;">
        <div style="margin-bottom: 20px;"> <p> &nbsp; <br></p> </div>
        <div style="margin-bottom: 10px;"> <p> &nbsp; <br></p> </div>
        <div style="margin-bottom: 10px;"> โปรแกรม : {{ $programCode }} </div>
    </div>
    <div class="col-md-4" style="font-size: 20px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"> การยาสูบแห่งประเทศไทย </div>
        <div style="margin-bottom: 10px;"> รายงานส่งข้อมูลค่าเบี้ยประกันภัยรายเดือน </div>
        <div style="margin-bottom: 10px;"> ข้อมูลค่าเบี้ยประกันเดือน {{ $period_name_thai }} </div>
    </div>
    <div align="right" class="col-md-1" style="font-size: 16px;">
        <div style="margin-bottom: 20px;"> <p> &nbsp; <br></p> </div>
        <div style="margin-bottom: 10px;"> วันที่ : {{ date('d-m-Y') }} </div>
        <div style="margin-bottom: 10px;"> เวลา : {{ date('H:i') }} </div>
    </div>
</div>

<div class="row col-lg-12" style="font-size: 18px; margin-top: 10px;">
    <div class="col-md-10">
        <strong> กลุ่ม : </strong> {{ $account_mapping->account_code.' : '.$account_mapping->description }}
    </div>
    <div align="right" class="col-md-2" style="margin-bottom: 8px; font-size: 16px;">
        <strong> หน้า : </strong> {{ ($key + 1)." / ".$page }}
    </div>
</div>