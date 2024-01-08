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

            .col-1  { width: 10px; }
            .col-2  { width: 60px; }
            .col-3  { width: 60px; }
            .col-4  { width: 200px; }
            .col-5  { width: 200px; }
            .col-6  { width: 40px; }
            .col-7  { width: 60px; }
            .col-8  { width: 60px; }
            .col-9  { width: 200px; }
            .col-10 { width: 200px; }


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

    <table class="table-content">
        <thead>
            <tr style="text-align: center;">
                <td colspan="10">รายงานสรุปสถานะใบสั่งซ่อมที่ส่งมอบสร็จสิ้นตั้งแต่ยังไม่ปิดค่าใช้จ่าย</td>
            </tr>
            <tr style="text-align: center;">
                <td colspan="10"><p style="margin-top: 15px;"></p></td>
            </tr>
            <tr style="text-align: right;">
                <td style="padding-right: 45px;" colspan="8"></td>
                <td colspan="2">วันที่/เวลาที่จัดพิมพ์ : {{Str::upper($date['now']) }}</td>
            </tr>
            <tr>
                <td colspan="10" style="text-align: right;">
                    จำนวนหน้า/หน้าทั้งหมด : <span class="page"></span> / <span class="topage"></span>
                </td>
            </tr>
            <tr class="table-header">
                <td class="col-1"></td>
                <td class="col-2"></td>
                <td class="col-3"></td>
                <td class="col-4"></td>
                <td class="col-5"></td>
                <td class="col-6"></td>
                <td class="col-7"></td>
                <td class="col-8"></td>
                <td class="col-9"></td>
                <td class="col-10"></td>
            </tr>
        </thead>
    </table>
</body>
</html>
