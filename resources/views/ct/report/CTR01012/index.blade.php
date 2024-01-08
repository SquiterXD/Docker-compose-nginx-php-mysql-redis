
    <!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> -->
        @include('ct.report.CTR01012._style')
    </head>

    </head>
    <body>
    @foreach ($ListData_Hs as $ListData_H )
    
        <div class= "row">
            <div style="width: 33%" align="left"></div>
            <div style="width: 33%" align="center"><b>การยาสูบแห่งประเทศไทย DR Site-TOT</b></div>
            <div style="width: 33%" align="left"></div>
        </div>

        <div class= "row"></div>

        <div class= "row">
            <div  style="width: 33%" align="left"><b>รหัสโปรแกรม : CTR101</b></div>
            <div  style="width: 33%" align="center"><b> รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม</b></div>
            <div  style="width: 33%" align="right"><b> วันที่พิมพ์ :  </b> {{ date('d/m/Y H:i', strtotime(now())) }}</div>
        </div>
        <div class="row">
            
            <div  style="width: 33%"  > <b>หน่วยงาน: </b>{{$ListData_H->dept_code != '' ? $ListData_H->dept_code.' '. $ListData_H->PtglCoaDeptCodeV[0]->description : ''}}</div>
            <div  style="width: 33%" align="center" > <b>ตั้งแต่วันที่ </b> {{parseToDateTh($request->start_date) }} <b>ถึงวันที่ </b> {{parseToDateTh($request->end_date) }} </div>
            <div style="width: 33%" ></div>
        </div>
        <div class="row">
            <div > <b> ศุนย์ต้นทุน: </b>{{$request->cc_code}} </div>           
        </div>
        
        <hr style="border-top: 1px solid #000000">
        @include('ct.report.CTR01012._table', ['ListData_H' => $ListData_H])
        @endforeach

    
    
 
    </body>
</html>
