<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายการเรียกเก็บเงินค่าบุหรี่</title>

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
            font-size: 12px;
        }
    </style>

</head>
<body style="border:0; margin: 0;" onload="subst()">
    <table style="width: 100%">
        <tr>
            <td style="width: 30%"><strong> โปรแกรม : </strong> {{ $programCode }}</td>
            <td style="text-align: center;"><strong>การยาสูบแห่งประเทศไทย</strong></td>
            <td style="text-align: right;"><strong> วันที่ : </strong> {{ parseToDateTh(now()) }}</td>
        </tr>
        <tr>
            <td style="width: 30%"><strong> สั่งพิมพ์ : </strong> {{ \Auth::user()->name }}</td>
            <td style="text-align: center;"><strong>รายการเรียกเก็บเงินค่าบุหรี่</strong></td>
            <td style="text-align: right;"><strong> เวลา : </strong> {{ date('H:i') }}</td>
        </tr>
        <tr>
            <td style="width: 30%"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: right;"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></td>
        </tr>
    </table>
    {{-- <div class="row col-lg-12">
        <div class="flexrow">
            <div style="width: 250px;"><strong> โปรแกรม : </strong> {{ $programCode }}</div>
            <div style="width: 450px; text-align: center;"><strong>การยาสูบแห่งประเทศไทย</strong></div>
            <div style="width: 250px; text-align: right;"><strong> วันที่ : </strong> {{ parseToDateTh(now()) }}</div>
        </div>

        <div class="flexrow">
            <div style="width: 250px;" width="40%"><strong> สั่งพิมพ์ : </strong> {{ \Auth::user()->name }}</div>
            <div style="width: 450px; text-align: center;" width="40%"><strong>รายการเรียกเก็บเงินค่าบุหรี่</strong></div>
            <div style="width: 250px; text-align: right;" width="20%"><strong> เวลา : </strong> {{ date('H:i') }}</div>
        </div>

        <div class="flexrow">
            <div style="width: 250px;" width="40%"> </div>
            <div style="width: 450px;" width="40%"></div>
            <div style="width: 250px; text-align: right;" width="20%"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></div>
        </div>
        <br><br>
    </div> --}}



    {{-- ----------------------------------------- --}}


    {{-- <div class="row col-lg-12">
        <div class="flexrow">
            <div style="width: 250px;">
                <strong> โปรแกรม : </strong> {{ $programCode }}
            </div>
            <div style="width: 450px; text-align: center;">
                <strong>การยาสูบแห่งประเทศไทย</strong>
            </div>
            <div style="width: 250px; text-align: right;">
                <strong> วันที่ : </strong> {{ parseToDateTh(now()) }}
            </div>
        </div>

        <div class="flexrow">
            <div width="width: 250px;">
                <strong> สั่งพิมพ์ : </strong> {{ \Auth::user()->name }}
            </div>
            <div style="width: 450px; text-align: center;">
                <strong>รายการเรียกเก็บเงินค่าบุหรี่</strong>
            </div>
            <div style="width: 250px; text-align: right;">
                <strong> เวลา : </strong> {{ date('H:i') }}
            </div>
        </div>

        <div class="flexrow">
            <div style="width: 250px;"></div>
            <div style="width: 450px; text-align: center;">
                <strong></strong>
            </div>
            <div style="width: 250px; text-align: right;"">
                <strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span>
            </div>
        </div>
    </div> --}}
</body>
</html>