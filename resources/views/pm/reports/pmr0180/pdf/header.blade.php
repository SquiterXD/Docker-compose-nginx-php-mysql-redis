<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }
        body{
            margin: 0;
            font-family: "THSarabunNew" !important;
            font-size: 15px;
            line-height: 1;
        }
        #table-header td {
            padding:0px !important;
        }
    </style>
    @php
        $styleTh = 'border:  1px solid black !important; line-height: 100px; ';
        $styleFont16 = 'border:  1px solid black !important; font-size: 16px; ';
        $styleFont14 = 'border:  1px solid black !important; font-size: 14px; ';
        $font18 = 'font-size: 18px; ';
        $font16 = 'font-size: 16px; ';
        $font14 = 'font-size: 14px; ';
        $border = 'border:  1px solid black !important; ';
        $lineNo = 0;
    @endphp
</head>

<body style=" border:0; margin: 0;" onload="subst()" >
    <table  width="100%"  style="padding-left: 5px; padding-right: 5px;"   >
        <thead>
            <tr>
                <td  width="33.33%" align="left"   style="{{ $font18 }}"><b>โปรแกรม : </b> {{ request()->program_code }}</td>
                <td  width="33.33%" align="center"   style="{{ $font18 }}"><b> การยาสูบแห่งประเทศไทย </b></td>
                <td  width="33.33%" align="right"  style="{{ $font18 }}"><b>วันที่พิมพ์ : </b> {{ $reportData->date }} </td>
            </tr>
            <tr>
                <td  width="33.33%" align="left"   style="{{ $font18 }}"><b>สั่งพิมพ์ : </b> {{ $profile->user_name }}</td>
                <td  width="33.33%" align="center"   style="{{ $font18 }}"><b> {{ $reportData->name }} </b></td>
                <td  width="33.33%" align="right"  style="{{ $font18 }}"><b> เวลา : </b> {{ $reportData->time }}  </td>
            </tr>
            <tr>
                <td  width="33.33%" align="left"   style="{{ $font18 }}"></td>
                <td  width="33.33%" align="center"   style="{{ $font18 }}"><b>{{ $reportData->department_desc }}</b></td>
                <td  width="33.33%" align="right"  style="{{ $font18 }}"><b>หน้าที่ :</b> <span class="page"></span>/<span class="topage"></span></td>
            </tr>
        </thead>
    </table>
</body>

</html>