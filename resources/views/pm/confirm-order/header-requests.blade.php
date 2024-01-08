<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ptpm Requests V</title>

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
    </style>

</head>
<body style="border:0; margin: 0;" onload="subst()">
    <div class="row">
        <div class="col-lg-12">
            <div class="flexrow">
                <div style="text-align: left"><strong>โปรแกรม :</strong>
                    {{-- {{ $ptpmHead->program_code }} --}} PMR0005
                </div>
                <div style="text-align: center"><strong>การยาสูบแห่งประเทศไทย</strong></div>
                <div style="text-align: right"><strong>วันที่ :</strong> {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }}</div>
            </div>
            <div class="flexrow">
                <div style="text-align: left"><strong>สั่งพิมพ์ :
                    </strong> {{ $userProfile->user_name }}
                </div>
                <div style="text-align: center"><strong>ใบโอนวัตถุดิบ/วัสดุเพื่อใช้ในการผลิต</strong></div>
                <div style="text-align: right"><strong>เวลา :</strong> {{ Carbon\Carbon::now()->format('H:i') }}</div>
            </div>
            <div class="flexrow">
                <div ><strong>พิมพ์ครั้งที่ :</strong>1</div>
                <div ><strong>วันที่ขอเบิก :</strong>   {{ $ptpmHead->request_date_thai }}</div>
                <div ><strong>วันที่นำส่ง ยสท. :</strong>   {{ $ptpmHead->send_date_thai }}</div>
                <div style="text-align: right"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></div>
            </div>
            <div class="flexrow">
                <div style="text-align: left"><strong>หน่วยงาน : </strong> {{ $ptpmHead->department_code_header }}</div>
                <div style="text-align: right"><strong>ใบขอเบิกเลขที่ :</strong> {{ $ptpmHead->request_number }}</div>
            </div>
            <div class="flexrow">
                <div style="text-align: left"><strong>สินค้าที่ผลิต : </strong> {{ $ptpmHead->description_header }}</div>
                <div style="text-align: right"><strong>สถานะขอเบิก :</strong> {{ $ptpmHead->request_status }}</div>
            </div>
            <br>
            <br>
        </div>
    </div>
</body>
</html>
