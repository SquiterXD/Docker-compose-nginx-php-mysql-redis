<div style="min-height: 180px; max-height: 180px; margin-top: 220px;">

    <h5 class="text-center tw-font-bold" style="padding-bottom: 12px;"> การยาสูบแห่งประเทศไทย (DR Site-TOT) </h5>

    <table border="0" width="100%" style="font-size: 15px;">

        </thead>

            <tr>
                <th width="30%" class="text-left"> 
                    <div class="tw-font-bold"> รหัสโปรแกรม : {{ $programCode }} </div>
                </th>
                <th colspan="2" class="text-center" style="font-size: 17px;">  
                    <div class="tw-font-bold"> รายงานบัตรต้นทุนมาตรฐาน </div>
                </th>
                <th width="20%" class="text-right"> 
                    <div class="tw-font-bold"> หน้าที่ : {{ $pgIndex+1 }} / {{ count($reportProductGroupItems) }} </div>
                </th>
            </tr>

            <tr>
                <th width="30%" class="text-left"> 
                    <div class="tw-font-bold"> ปีบัญชีงบประมาณ : {{ $periodYearTh }} </div>
                </th>
                <th width="20%" class="text-center">  
                    <div class="tw-font-bold"> ครั้งที่ : {{ $versionNo }} </div>
                </th>
                <th width="30%" class="text-center">  
                    <div class="tw-font-bold"> แผนผลิตครั้งที่ : {{ $planVersionNo }} </div>
                </th>
                <th width="20%" class="text-right"> 
                    <div class="tw-font-bold"> วันที่พิมพ์ : {{ $reportDate }} {{ $reportTime }} </div>
                </th>
            </tr>

            <tr>

                <th width="30%" class="text-left"> 
                    <div class="tw-font-bold"> วันที่เริ่มต้นใช้อัตรามาตรฐาน  : {{ $reportProductGroupItem['start_date_thai'] }} </div>
                </th>

                <th width="20%" class="text-left">  
                </th>

                <th width="30%" class="text-left">  
                    <div class="tw-font-bold"> วันที่สิ้นสุด : {{ $reportProductGroupItem['end_date_thai'] }} </div>
                </th>

                <th width="20%" class="text-right"> 
                    
                </th>

            </tr>

            <tr>

                <th width="30%" class="text-left"> 
                    <div class="tw-font-bold"> ศูนย์ต้นทุน : {{ $reportProductGroupItem['cost_code'] }} {{ $reportProductGroupItem['cost_desc'] }} </div>
                </th>
                
                <th width="20%" class="text-left">  
                </th>

                <th width="30%" class="text-left">  
                    <div class="tw-font-bold"> กลุ่มผลิตภัณฑ์ : {{ $reportProductGroupItem['product_group'] }} {{ $reportProductGroupItem['product_group_desc'] }} </div>
                </th>

                <th width="20%" class="text-left"> 
                    <div class="tw-font-bold"> หน่วยนับ : {{ $reportProductGroupItem['cost_quantity'] }} {{ $reportProductGroupItem['uom_desc'] }} </div>
                </th>

            </tr>

            <tr>

                <th width="30%" class="text-left"> 
                    <div class="tw-font-bold"> ผลิตภัณฑ์ : {{ $reportProductGroupItem['product_item_number'] }} {{ $reportProductGroupItem['product_item_desc'] }} </div>
                </th>
                
                <th width="20%" class="text-left">  
                </th>

                <th width="30%" class="text-left">  
                </th>

                <th width="20%" class="text-right"> 
                </th>

            </tr>

        </thead>

    </table>

</div>
