<div class="row col-lg-12">
    <div class="col-md-7" style="font-size: 16px; text-align: left; width: 150px;">
        <div style="margin-bottom: 15px;"> <strong> โปรแกรม : </strong> {{ $programCode }} </div>
        <div style="margin-bottom: 15px;"> <strong> ประเภทประกันภัย : </strong> {{ $glLine->first()->fndLookup->description }} </div>
        <div style="margin-bottom: 15px;"> <strong> กลุ่ม : </strong> {{ getGlGroup($glLine->first()->group_code) }}
        </div>
    </div>
    <div class="col-md-4" style="font-size: 18px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"> การยาสูบแห่งประเทศไทย </div>
        <div style="margin-bottom: 10px;"> รายงานส่งข้อมูลค่าเบี้ยประกันภัยรายเดือน </div>
        <div style="margin-bottom: 10px;"> ข้อมูลค่าเบี้ยประกันเดือน {{ $period_name_thai }} </div>
    </div>
    <div align="right" class="col-md-1" style="font-size: 16px;">
        <div style="margin-bottom: 15px;"> วันที่ : {{ strtoupper(date('d-M-Y')) }} </div>
        <div style="margin-bottom: 15px;"> เวลา : {{ date('H:i') }} </div>
        <div style="margin-bottom: 15px;"> หน้า : {{ ($key + 1)." / ".$page }} </div>
    </div>
</div>

<div class="row col-lg-12" style="font-size: 16px; margin-top: 8px;">
    <div class="col-md-10">
        <strong> Batch Name : </strong> {!! getGlBatch($glLine->first()->je_header_id) !!}
    </div>
</div>


<div class="row col-lg-12" style="font-size: 16px; margin-top: 10px; margin-bottom: 7px;">
    <div class="col-md-9">
        <strong> Reference : </strong> {!! getGlBatch($glLine->first()->ref_je_header_id) !!}
    </div>
    <div align="right" class="col-md-3" style="margin-bottom: 8px; font-size: 16px;">
        <strong> {{ $glLine->first()->interface_status == 'S'? 'ส่งเข้า GL แล้ว': 'ยังไม่ส่งเข้า GL' }} </strong>
    </div>
</div>