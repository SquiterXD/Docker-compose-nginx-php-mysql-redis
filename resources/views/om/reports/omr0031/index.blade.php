<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

<title>OMR0031 สรุปยอดจำหน่ายยาสูบ/ยาเส้นประจำเดือน</title>
@include('ct.reports.ctr0101._style')

    </head>
    <body>
        <style>
      


            table, tr, td, th, tbody, thead, tfoot {
                page-break-inside: avoid !important;
            }
        
       
        
        </style>
        <!-- style="page-break-after:always; " -->
    <!-- 11111111111111111111111111 -->
        @php
//         20	Modern trade
// 60	ขายพนักงาน  
// 80	ส่งเสริม    
// 50	ป.2         
// 30	สโมสรกรุงเทพ
// 40	สโมสรภูมิภาค
// 10	ป.1         
        $checkSum   =   'N';
            $checkSumCustomerType   ='N';
            $groupA =   'กลุ่ม ร้านขายส่งยาสูบประเภท 1';
            $groupB =   'เขต กทม.'; 
            $dataListsX =   $dataLists1;
            $uom    =   'พันมวน';
            $case = 1;
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>
    <!-- 2222222222222222222222     -->
        @php
            $groupA =   'กลุ่ม ร้านขายส่งยาสูบประเภท 1';
            $groupB =   'เขต ตจว.'; 
            $dataListsX =   $dataLists2;
            $checkSumCustomerType   ='Y';
            $dataListsY =    $dataLists1->merge($dataLists2);
            $customer_type_id = 10;
            $case = 2;
            //dd($dataListsY,$dataLists1,$dataLists2);
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>
        <!-- 3333333333333333333333 -->
        @php
            $checkSumCustomerType   ='Y';
            $groupA =   'กลุ่ม Modern Trade';
            $groupB =   'MT'; 
            $dataListsX =   $dataLists3;
            $dataListsY =   $dataLists3;
            $case = 3;

        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>
            <!-- 44444444444444444444444 -->
        @php
            $checkSumCustomerType   ='N';
            $groupA =   'กลุ่ม ร้านค้าสโมสร';
            $groupB =   'สโมสรกรุงเทพ'; 
            $dataListsX =   $dataLists4;
            $case = 4;
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>
            <!-- 555555555555555555 -->
        @php
            
            $groupA =   'กลุ่ม ร้านค้าสโมสร';
            $groupB =   'สโมสรภูมิภาค'; 
            $dataListsX =   $dataLists5;
            $checkSumCustomerType   ='Y';
            $dataListsY =    $dataLists4->merge($dataLists5);
            $case = 5;
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>

        <!-- 66666666666666666666 -->
        @php
            $groupA =   'กลุ่ม ขายพนักงาน';
            $groupB =   'ขายพนักงาน'; 
            $dataListsX =   $dataLists6;
            $checkSumCustomerType   ='Y';
            $dataListsY =    $dataLists6;
            $case = 6;
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>

        @php
            $groupA =   'กลุ่ม ร้านขายส่งยาสูบประเภท 2';
            $groupB =   'ป.2'; 
            $dataListsX =   $dataLists7;
            $checkSumCustomerType   ='Y';
            $dataListsY =    $dataLists7;
            $case = 7;
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>

        @php
            $uom    =   'หีบ';
            $groupA =   'กลุ่ม ร้านค้ายาเส้น';
            $groupB =   'เขต กทม.'; 
            $dataListsX =   $dataLists8;
            $checkSumCustomerType   ='N';
            $case = 8;
        
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>

        @php
            $groupA =   'กลุ่ม ร้านค้ายาเส้น';
            $groupB =   'เขต ตจว.'; 
            $dataListsX =   $dataLists9;
            $checkSumCustomerType   ='N';
            $case = 9;
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>

        @php
            $groupA =   'กลุ่ม ร้านค้ายาเส้น';
            $groupB =   'MT'; 
            $dataListsX =   $dataLists10;
            $checkSumCustomerType   ='N';
            $case = 10;
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>

        @php
            $groupA =   'กลุ่ม ร้านค้ายาเส้น';
            $groupB =   'สโมสรกรุงเทพ'; 
            $dataListsX =   $dataLists11;
            $checkSumCustomerType   ='N';
            $case = 11;
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>

        @php
            $groupA =   'กลุ่ม ร้านค้ายาเส้น';
            $groupB =   'สโมสรภูมิภาค'; 
            $dataListsX =   $dataLists12;
            $checkSumCustomerType   ='N';
            $case = 12;
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>

        @php
            $groupA =   'กลุ่ม ร้านค้ายาเส้น';
            $groupB =   'ขายพนักงาน'; 
            $dataListsX =   $dataLists13;
            $checkSumCustomerType   ='N';
            $case = 13;
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>

        @php
            $groupA =   'กลุ่ม ร้านค้ายาเส้น';
            $groupB =   'ป.2'; 
            $dataListsX =   $dataLists14;
            $checkSumCustomerType   ='Y';
            $dataListsY =    $dataLists8->merge($dataLists9)->merge($dataLists10)->merge($dataLists11)->merge($dataLists12)->merge($dataLists13)->merge($dataLists14);
            $case =14;
        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>
        @php 
            $countList15= 0;
        @endphp
        @foreach($dataLists15->whereNotNull('order_type_name')->groupBy('order_type_name') as $order_type_name => $dataListx)
        @php
            //dd($dataListx[0]->order_type_name);
            @endphp
        
        @php
            $countList15+=1;
            $groupA =   'กลุ่มบุหรี่ไม่คิดมูลค่า';
            $groupB =   $order_type_name; 
            
            $dataListsX = collect();
           
            foreach($dataLists17 as $index => $dataList17){
           
                if( $item = $dataLists15->where('order_type_name', $order_type_name)->where('item_description', $dataList17->item_description)->first() ){
                    $dataListsX->push($item);
                }else {
                    $dataListsX->push($dataList17);
                }
            }

            $checkSumCustomerType   ='N';
            if(count($dataLists15->groupBy('order_type_name'))==$countList15){
                $checkSumCustomerType   ='Y';
                $dataListsY = $dataLists15;

            }

        @endphp
        @include('om.reports.omr0031._table')
        <div style="page-break-after: always"></div>
        @endforeach
        @php 
            //dd(count($dataLists15->groupBy('order_type_name')),$countList15);
            $countList16= 0;
        @endphp
        @foreach($dataLists16->whereNotNull('order_type_name')->groupBy('order_type_name') as $order_type_name =>$dataListx)

        @php
            $countList16+=1;
            $groupA =   'กลุ่มยาเส้นไม่คิดมูลค่า';
            $groupB =   $order_type_name; 
            $dataListsX = collect();
            foreach($dataLists18 as $index => $dataList18){
                if( $item = $dataLists16->where('item_description', $dataList18->item_description)->first() ){
                    $dataListsX->push($item);
                }else {
                    $dataListsX->push($dataList17);
                }
            }
            // $dataListsX= $dataLists18;
            $checkSumCustomerType   ='N';
            if(count($dataLists16->groupBy('order_type_name') )==$countList16){
                $checkSumCustomerType   ='Y';
                $dataListsY =   $dataLists16;
                $checkSum   =   'Y';
                $dataListsZ =$dataLists1->merge($dataLists2)->merge($dataLists3)->merge($dataLists4)->merge($dataLists5)->merge($dataLists6)->merge($dataLists7)->merge($dataLists8)->merge($dataLists9)->merge($dataLists10)->merge($dataLists11)->merge($dataLists12)->merge($dataLists13)->merge($dataLists14)->merge($dataLists15)->merge($dataLists16);
                //dd($dataListsZ);
            }
        @endphp
        @include('om.reports.omr0031._table')
        
        <div style="page-break-after: always"></div>
        @endforeach   
        <br>
        <div>
            <div style="padding-top:1px;text-align:center">จบรายงาน</div>
            <div style="padding-top:1px;text-align:right">
                <div>หัวหน้าส่วนงาน _____________________________ <br><br>
            </div>
            <div style="padding-top:1px;text-align:right">
                <div>ผู้จัดทำ _____________________________ &nbsp; &nbsp; &nbsp; &nbsp; หัวหน้ากองบริหารขาย _____________________________ <br><br>
            </div>
        </div>
    </body>
</html>

