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
body, td {
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

<body 
onload="subst()"
>
   
    <table style="width:100%;" id="table-header">
            <tr>
                <td>โปรแกรม : PDP00003</td>
                <td align="center">การยาสูบแห่งประเทศไทย</td>
                <td align="right">วันที่ : {{ now()->addYears(543)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>สั่งพิมพ์ : {{ auth()->user()->username }}</td>
                <td align="center">สรุปการใช้สูตรแต่ละบุหรี่</td>
                <td align="right">วันที่ : {{ now()->addYears(543)->format('H:i') }}</td>
            </tr>
            <tr>
                <td></td>
                <td align="center">blend No.: {{ request()->cicFrom }} - {{ request()->cicTo }}</td>
                <td align="right">หน้า : <span class="page"></span></td>
            </tr>
    </table>
</body>

</html>