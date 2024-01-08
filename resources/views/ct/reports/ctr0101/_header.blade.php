<div style="min-height: 120px;">

    <h5 class="text-center tw-font-bold" style="padding-bottom: 12px;"> การยาสูบแห่งประเทศไทย (DR Site-TOT) </h5>

    <table border="0" width="100%" style="font-size: 12px;">
        <tr>
            <td width="25%" class="text-left"> 
                <div>
                    <div style="width: 35%;" class="tw-inline-block tw-font-bold"> รหัสโปรแกรม </div> 
                    <div style="width: 55%;"class="tw-inline-block"> {{ $programCode }} </div>
                </div>

                <div>
                    <div style="width: 35%;" class="tw-inline-block tw-font-bold"> หน่วยงาน </div> 
                    <div style="width: 55%;"class="tw-inline-block"> {{ $deptCode }} </div>
                </div>

                <div>
                    <div style="width: 35%;" class="tw-inline-block tw-font-bold"> ศูนย์ต้นทุน </div> 
                    <div style="width: 55%;"class="tw-inline-block"> {{ $ccCode }} </div>
                </div>

            </td>
            <td width="50%" class="text-left"> 
                <div>
                    <div class="text-center tw-font-bold"> รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม </div> 
                </div>

                <div>
                    <div class="text-center tw-font-bold"> ตั้งแต่วันที่ {{ $startDateTH }} ถึงวันที่ {{ $endDateTH }} </div> 
                </div>
                <div> &nbsp; </div>

            </td>
            <td width="25%" class="text-right"> 
                <div>
                    <div style="width: 35%;" class="text-left tw-inline-block tw-font-bold"> วันที่พิมพ์ </div> 
                    <div style="width: 55%;" class="text-left tw-inline-block"> {{ $nowDateTH }} </div>
                </div>
                <div> &nbsp; </div>
                <div> &nbsp; </div>
            </td>
        </tr>
    </table>
    
</div>