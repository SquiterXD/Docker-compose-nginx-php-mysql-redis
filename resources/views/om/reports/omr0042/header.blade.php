


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('om.reports.omr0042._style')
    <script>
        function subst() {
          var vars={};
          var x=document.location.search.substring(1).split('&');
          for(var i in x) {var z=x[i].split('=',2);vars[z[0]] = unescape(z[1]);}
          var x=['frompage','topage','page','webpage','section','subsection','subsubsection'];
          for(var i in x) {
            var y = document.getElementsByClassName(x[i]);
            for(var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
          }
        }
    </script>
</head>
<body onload="subst()">

<div class="row col-lg-12">
    <div class="col-md-4" style="font-size: 16px; text-align: left; width: 150px;">
        <div style="margin-bottom: 15px;"> <strong> รหัสโปรแกรม : OMR0042 </strong>  </div>
        <div style="margin-bottom: 15px;"> <strong> สั่งพิมพ์ : {{ optional(@$user)->user_id }} </strong> </div>
    </div>
    <div class="col-md-4" style="font-size: 20px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"> การยาสูบแห่งประเทศไทย </div>
        <div style="margin-bottom: 10px;"> ยอดจำหน่ายบุหรี่เงินสด และยอดคงเหลือ </div>
        <div style="margin-bottom: 10px;"> จากวันที่   ถึงวันที่  </div>
    </div>
    <div align="right" class="col-md-4" style="font-size: 16px;">
        @php
            $now = date("d")."/".date("m")."/".(date("Y")+543);
        @endphp
        <div style="margin-bottom: 15px; font-weight: bold;"> วันที่ : {{ now()->setTimezone('Asia/Bangkok')->format($now ) }} </div>
        <div style="margin-bottom: 15px; font-weight: bold;"> เวลา : {{ now()->setTimezone('Asia/Bangkok')->format('H:i:s' ) }} </div>
        <div style="margin-bottom: 10px; font-weight: bold;"> หน้า <span class="page"></span> / <span class="topage"></span></div>
    </div>
</div>
</body>
</html>


