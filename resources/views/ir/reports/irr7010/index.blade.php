
    <!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> -->
        @include('ir.reports.irr7010._style')
       
        <script>
            function subst() {
            var vars = {};
            var query_strings_from_url = document.location.search.substring(1).split('&');
            console.log(query_strings_from_url);
            for (var query_string in query_strings_from_url) {
                if (query_strings_from_url.hasOwnProperty(query_string)) {
                    var temp_var = query_strings_from_url[query_string].split('=', 2);
                    vars[temp_var[0]] = decodeURI(temp_var[1]);
                }
            }
            var css_selector_classes = ['page', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate', 'time', 'title', 'doctitle', 'sitepage', 'sitepages'];
            for (var css_class in css_selector_classes) {
                if (css_selector_classes.hasOwnProperty(css_class)) {
                    var element = document.getElementsByClassName(css_selector_classes[css_class]);
                    for (var j = 0; j < element.length; ++j) {
                        element[j].textContent = vars[css_selector_classes[css_class]];
                    }
                }
            }
        }


        </script>
  
    
    </head>


    <body onload="subst()">
        
    <!-- <span class="pagenum"></span> -->
    @foreach ($dataLists->groupBy('policy_set') as $dataListByPolicyS=>$dataListByPolicy)
    @foreach($dataListByPolicy->groupBy('company_name') as $dataListByComS=>$dataListByCom)
    @foreach($dataListByCom->groupBy('user_policy_number') as $dataListByUserPoS=>$dataListByUserPo)
    @foreach($dataListByUserPo->groupBy('status') as $dataListByStatusS => $dataListByStatus)
    @php
    // dd($dataListByComS);
    @endphp
       
    <div class="page-break">
        <div class= "row">
            <div style="width: 33%" align="left"><b>รหัสโปรแกรม : </b>IRR7010</div>
            <div style="width: 33%" align="center"><b>การยาสูบแห่งประเทศไทย</b></div>
            <div  style="width: 25%" align="left"></div>
            <div style="width: 8%" align="left"><b>วันที่ :  </b> {{ date('d/m/Y', strtotime(now())) }}</div>
        </div>

        <div class= "row"></div>

        <div class= "row">
            <div  style="width: 33%" align="left"><b>สั่งพิมพ์ : </b> {{$user}}</div>
            <div  style="width: 33%" align="center"><b> {{$dataListByPolicyS??''}}</b></div>
            <div  style="width: 25%" align="left"></div>
            <div  style="width: 8%" align="left"><b>เวลา :  </b> &nbsp; &nbsp; &nbsp; &nbsp;{{ date('H:i', strtotime(now()))}}</div>
            </div>
            <div class= "row"></div>
            <div class= "row">
                <div  style="width: 8%" align="left"></div>
                <div  style="width: 83%" align="center"> <b>รายละเอียดมูลค่าทุนประกันภัยทรัพย์สิน (เพิ่ม / ลด) และการคำนวณค่าเบี้ยประกันภัยโดยการประกันแบบ Replacement Value</b></div>
                <div  style="width: 8% " align="left" ><b>หน้า :  </b></div>
                

            </div>
        <div class="row">
            
            <div style="width: 33%" ></div>
        </div>

        <div class= "row">
            <div  style="width: 10%" align="left"></div>
            <div  style="width: 80%" align="center"><b> {{ $dataListByComS}}</b></div>
            
            <div  style="width: 10%" align="left"> </div>
        </div>

        <div class="row">
        </div>
        @php
        if(is_null($startDate)){
            
            $start ='';
            $END ='';
        }else{
            $start ='ตั้งแต่วันที่ ';
            $END =' ถึงวันที่ ';
            
        }
        @endphp
        <div class= "row">
            <div  style="width: 33%" align="left"></div>
            <div  style="width: 33%" align="center"><b> {{$start}}</b>{{$startDate}}<b> {{$END}}</b>{{$endDate}}</div>
            <div  style="width: 25%" align="left"></div>
            <div  style="width: 8%" align="left"> </div>
        </div>
        <div class="row">

        </div>
     

        <div class="row">
            <div align="left"><b>เลขที่กรมธรรม์ : </b>{{$dataListByUserPoS??''}}</div>
            <div align="right"> <b>เลขที่สลักหลัง : {{$dataListByUserPo[0]->comments}}</b></div>
        </div>
        <div class="row">

        </div>
        <div class="row">
            <div align="left"><b>สถานะ : </b>{{$dataListByStatusS}}</div>
        </div>
        @include('ir.reports.irr7010._table')

        </div>
   
        @endforeach
        @endforeach
        @endforeach
        @endforeach

        



   
    </body>
</html>
