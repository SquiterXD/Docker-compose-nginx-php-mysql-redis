<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> -->
        @include('ct.Komsupanat._style')
    </head>
    <body>
    @foreach ($G1 as $G1_H )
      
      <div  class='row'>
      <div style="width: 33%" align="left"></div>
            <div style="width: 33%" align="center"><b>การยาสูบแห่งประเทศไทย DR Site-TOT</b></div>
            <div style="width: 33%" align="left"></div>
      </div>
      <br>
      <br>
      <div class= "row2">
            <div  style="width: 33%" align="left"><b>รหัสโปรแกรม : CTR01012</b></div>
            <div  style="width: 33%" align="center"><b> รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม</b></div>
            <div  style="width: 33%" align="right"><b> วันที่พิมพ์ :  </b> {{ date('d/m/Y H:i', strtotime(now())) }}</div>
        </div>
        <div class="row2">
            <div  style="width: 33%"  > <b>หน่วยงาน : </b>{{$G1_H->dept_code}}</div>
            <div  style="width: 33%" align="center" ><b>ตั้งแต่วันที่ </b> <b>ถึงวันที่ </b> </b> </div>
            <div style="width: 33%" ></div>
        </div>
        <div class="row3">
            <div  style="width: 33%" align="left"><b> ศุนย์ต้นทุน : </b></div>        
        </div>
        <hr style="border-top: 1px solid #000000">
        @include('ct.Komsupanat._table', ['G1_H' => $G1_H])
        @endforeach
    </body>
</html>
