<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ptpm Batch Transaction V</title>

    <script>
        function subst() {
            var vars = {};
            var query_strings_from_url = document.location.search.substring(1).split('&');
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

    <link rel="stylesheet" href="{{ asset('css/report.css') }}">

    <style type="text/css">
        body{
            font-size: 11px;
        }
        table, th, td {
          border: 0px solid black  !important;
          /*border-collapse: collapse !important;*/
        }
        th, td {
          padding: 3px !important;
          /*background-color: salmon;*/
        }
    </style>

</head>
<body style="border:0; margin: 0;" onload="subst()">
    <table  width="100%" CELLSPACING="0" CELLPADDING="0" border="0">
        <thead>
            <tr>
                <td colspan="2"  align="left"><strong>โปรแกรม :</strong> {{ $programCode ?? $issueHeader->program_code }}</td>
                <td  align="center"><strong>การยาสูบแห่งประเทศไทย</strong></td>
                <td colspan="2" align="right"><strong>วันที่ :</strong> {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td width="20%" align="left"><strong>สั่งพิมพ์ : </strong> {{ $profile->user_name }}</td>
                <td width="20%" align="left"><strong>เลขที่คำสั่งผลิต : </strong>  {{ $issueHeader->batch_no }}</td>
                <td width="20%" align="center"><strong>รายงานเบิกจาก INVENTORY</strong></td>
                <td width="20%" align="right"><strong>เลขที่คำสั่งผลิต : </strong> {{ optional($ptpmHead)->batch_no }}</td>
                <td width="20%" align="right"><strong>เวลา :</strong> {{ Carbon\Carbon::now()->format('H:i') }}</td>
            </tr>
            <tr>
                <td width="20%" align="left"><strong>พิมพ์ครั้งที่ :</strong> 1</td>
                <td width="20%"></td>
                <td width="20%" align="center"><strong>หน่วยงาน : </strong> {{ $reportInfo->department_desc }}</td>
                <td width="20%" align="right">{{ $reportInfo->routing_desc }}</td>
                <td width="20%" align="right"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></td>
            </tr>
            <tr>
                <td width="20%" align="left"><strong>ใบขอเบิกเลขที่ : </strong>  {{ $issueHeader->request_number }}</td>
                <td width="20%" align="left"><strong>Blend no :</strong> {{ $blend->blend_no }}</td>
                <td width="20%" align="center"><strong>วันที่ขอเบิก :</strong> {{ optional($ptpmHead)->transaction_date_thai }}</td>
                <td width="20%" align="right"><strong>ผลผลิตที่ได้ :</strong>{{ number_format($requiredQty,6) }}</td>
                <td width="20%" align="right"><strong>คลังสินค้า :</strong> {{ optional($ptpmHead)->subinventory_code }}</td>
            </tr>
            <tr>
                <td width="20%" align="left" colspan="4"><strong>สินค้าที่ผลิต : </strong> {{ $reportInfo->product_desc }}</td>
                <td width="20%" align="right"><strong>สถานะตัดใช้ :</strong> {{ $reportInfo->status_desc }}</td>
            </tr>
        </thead>
    </table>
    <br><br>
    {{-- <div class="row">
        <div class="col-lg-12 header">
            <div class="flexrow">
                <div style="text-align: left"><strong>โปรแกรม :</strong> {{ $programCode ?? $issueHeader->program_code }}</div>
                <div style="text-align: center" class="texthead"><strong>การยาสูบแห่งประเทศไทย</strong></div>
                <div style="text-align: right"><strong>วันที่ :</strong> {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }}</div>
            </div>
            <div class="flexrow">
                <div style="text-align: left; border: 1px solid #000;"><strong>สั่งพิมพ์ : </strong> {{ $profile->user_name }} </div>
                <div style="text-align: left; border: 1px solid #000;"><strong>เลขที่คำสั่งผลิต : </strong>  {{ $issueHeader->batch_no }}</div>
                <div style="text-align: left; border: 1px solid #000;"><strong>รายงานเบิกจาก INVENTORY</strong></div>
                <div style="text-align: right; color: white"><strong>เลขที่คำสั่งผลิต : </strong> {{ optional($ptpmHead)->batch_no }}</div>
                <div style="text-align: right"><strong>เวลา :</strong> {{ Carbon\Carbon::now()->format('H:i') }}</div>
            </div>
            <div class="flexrow">
                <div style="text-align: left; border: 1px solid #000;"><strong>พิมพ์ครั้งที่ :</strong> 1</div>
                <div style="text-align: left; border: 1px solid #000;  color: white"><strong>OPERATION No. : </strong> *************** </div>
                <div style="text-align: left; border: 1px solid #000;"><strong>หน่วยงาน : </strong> {{ $reportInfo->department_desc }}</div>
                <div style="text-align: right">{{ $reportInfo->routing_desc }}</div>
                <div style="text-align: right"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></div>
            </div>
            <div class="flexrow" style="border: 1px solid #000;">
                <div style="text-align: left; border: 1px solid #000;"><strong>ใบขอเบิกเลขที่ : </strong>  {{ $issueHeader->request_number }}</div>
                <div style="text-align: left; border: 1px solid #000;"><strong>Blend no :</strong> {{ $blend->blend_no }} </div>
                <div style="text-align: left"><strong>วันที่ขอเบิก :</strong> {{ optional($ptpmHead)->transaction_date_thai }}</div>
                <div style="text-align: right"><strong>ผลผลิตที่ได้ :</strong>{{ number_format($requiredQty,6) }} </div>
                <div style="text-align: right"><strong>คลังสินค้า :</strong> {{ optional($ptpmHead)->subinventory_code }}</div>
            </div>
            <div class="flexrow" style="border: 1px solid #000;">
                <div style="text-align: left">
                    <strong>สินค้าที่ผลิต : </strong> {{ optional($ptpmHead)->item_no }}: {{ optional($ptpmHead)->item_desc }}
                </div>
                <div style="text-align: right"><strong>สถานะตัดใช้ :</strong> {{ $reportInfo->status_desc }}</div>
            </div>
            <br>
            <br>
        </div>
    </div> --}}
</body>
</html>
