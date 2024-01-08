<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>คำสั่งผลิตประจำปักษ์</title>

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
    <div class="row col-lg-12">
        <div class="flexrow">
            <div style="text-align: left;"> <strong> โปรแกรม : </strong> {{ $programCode }} </div>
            <div style="text-align: center;"> การยาสูบแห่งประเทศไทย </div>
            <div style="text-align: right;"> วันที่ : {{ strtoupper(date('d-M-Y')) }} </div>
        </div>
        <div class="flexrow">
            <div style="text-align: left;"> <strong> สั่งพิมพ์ : </strong> {{ \Auth::user()->name }} </div>
            <div style="text-align: center;"> คำสั่งผลิตประจำปักษ์ </div>
            <div style="text-align: right"> เวลา : {{ date('H:i') }} </div>
        </div>
        <div class="flexrow">
            <div style="text-align: left;"> </div>
            <div style="text-align: center;"> ปีงบประมาณ : 2565 ครั้งที่ 1</div>
            <div style="text-align: right"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></div>
        </div>
        <div class="flexrow">
            <div style="text-align: left;"> </div>
            <div style="text-align: center;"> ประเภทบุหรี่ : xxxxx </div>
            <div style="text-align: right">สถานะ : xxxxxxxx </div>
        </div>
        <br><br>
    </div>
</body>
</html>