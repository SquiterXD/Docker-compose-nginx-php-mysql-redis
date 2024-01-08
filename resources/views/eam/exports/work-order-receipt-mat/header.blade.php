<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>


        body {
                font-family: 'SarabunSans';
                font-size: 10px;
            }

            .table-content {
                border-collapse: collapse;
                font-size: 10px;
                page-break-inside:auto;
            }

            .table-header {
                text-align: center;
            }

            .table-content tr {
                page-break-inside:avoid;
                page-break-after:auto;
            }

            .text-center {
                text-align: center;
            }

            .col-1  {}
            .col-2  {}
            .col-3  {}
            .col-4  {}
            .col-5  {}
            .col-6  {}
            .col-7  {}
            .col-8  {}
            .col-9  {}
            .col-10 {}


            .table-main {
                border-collapse: collapse;
                font-size: 10px;
                page-break-inside:auto;
            }
            .table-main thead tr td {
                text-align: center;
            }
            .table-main tr {
                page-break-inside:avoid;
                page-break-after:auto;
            }

            .table-footer {
                margin-top: 15px;
                margin-left: auto;
                margin-right: auto;
                font-family: 'SarabunSans';
                font-size: 10px;
            }
    </style>
    <script>
        function subst() {
            var vars={};
            var x=document.location.search.substring(1).split('&');
            for (var i in x) {var z=x[i].split('=',2);vars[z[0]] = unescape(z[1]);}
            var x=['frompage','topage','page','webpage','section','subsection','subsubsection'];
            for (var i in x) {
                var y = document.getElementsByClassName(x[i]);
                for (var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
            }
        }
    </script>
</head>
<body onload="subst()" style="margin:0; padding: 0; overflow:hidden;">

    <table class="table-content" style="width:100%">
            <tr>
                <td style="text-align: left; width: 33%;">EAM_510 V.1</td>
                <td style="text-align: center; width: 33%;">การยาสูบแห่งประเทศไทย</td>
                <td style="text-align: right; width: 33%;"></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 33%;"></td>
                <td style="text-align: center; width: 33%;">รายงานส่งอะไหล่เข้าระบบสินค้าคงคลัง</td>
                <td style="text-align: right; width: 33%;"></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 33%;"></td>
                @if(isset($date['now']))
                	<td style="text-align: center; width: 33%;">วันที่ / เวลาที่จัดพิมพ์ :  {{Str::upper($date['now']) }}</td>
                @else
                	<td style="text-align: center; width: 33%;">วันที่ / เวลาที่จัดพิมพ์ :  }}</td>
                @endif
                <td style="text-align: right; width: 33%;"></td>
            </tr>
            <tr>
                <td colspan="10" style="width:99%"></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 33%;"></td>
                @if(isset($date['from']) && isset($date['to']))
                	<td style="text-align: center; width: 33%;">จากวันที่ :   {{Str::upper($date['from']) }}  ถึงวันที่ : {{Str::upper($date['to']) }}</td>
                @else
                    <td style="text-align: center; width: 33%;">จากวันที่ :     ถึงวันที่ : </td>
                @endif
                <td style="text-align: right; width: 33%;">จำนวนหน้า / หน้าทั้งหมด <span class="page"></span> / <span class="topage"></span></td>            
            </tr>
    </table>
</body>
</html>
