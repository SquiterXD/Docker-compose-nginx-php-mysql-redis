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
            font-size: 16px;
            line-height: 1;
        }
        #table-header td {
            padding:0px !important;
        }
    </style>
</head>

<body style=""
onload="subst()"
>
    <table  width="100%"  >
        <thead>
            <tr>
                <td width="33%"  align="left"  style=""><b>โปรแกรม : </b>  CTR0035</td>
                <td width="33%"  align="center"  style=""><b>การยาสูบแห่งประเทศไทย</b></td>
                <td width="33%"  align="right" valign="top"  style=""><b> วันที่พิมพ์ : </b> {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i') }} </td>
            </tr>
            <tr>
                <td width="33%"  align="left"    style=""></td>
                <td width="33%"  align="center"  style=""><b>รายงานสรุปต้นทุนการผลิต {{ optional($fmCost)->description }}</b></td>
                <td width="33%"  align="right"  style="">หน้า : <span class="page"></span>/<span class="topage"></span></td>
            </tr>
            <tr>
                <td width="33%"  align="left"     style=""></td>
                <td width="33%"  align="center"  style=""><b>ประจำเดือน {{ optional($period)->month_thai }} {{ optional($period)->year_thai }}   </b></td>
                <td width="33%"  align="center"  style=""> </td>
            </tr>
        </thead>
    </table>
</body>

</html>