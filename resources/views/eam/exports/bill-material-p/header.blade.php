<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style type="text/css">
        @font-face{
            font-family: 'SarabunSans';
            font-style: 'normal';
            src: url("file://{!! public_path('/fonts/Sarabun-Regular.ttf') !!}") format('truetype');
        }

        body {
            font-family: 'SarabunSans';
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

    </style>

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
</head>
<body style="border:0; margin:0;" onload="subst()">
    @foreach ($requestEquip as $data)
        <div style="position: absolute; left: 0;">
            <img src="{!! public_path('/img/logo-home2.png') !!}" width="80">
        </div>
        <div style="position: absolute; right: 0;">หน้า <span class="page"></span></div>
        <div class="text-center" style="padding-top: 25px;">การยาสูบแห่งประเทศไทย</div>
        <div class="text-center" style="margin-top: 5px"> ใบโอนย้ายพัสดุ</div>
        <div style="position: absolute; right: 0; top: 28px; width: 156px;">เลขที่ &nbsp;&nbsp;&nbsp; {{$data["data"]->request_equip_no}}</div>
        <div style="position: absolute; right: 0; top: 28px;">________________________________</div>
        <div style="position: absolute; right: 130px; top: 49px;">วันที่</div>
        @if(isset($data["data"]->send_date))
            <div style="position: absolute; right: 52px; top: 49px;">{{date_format(date_create($data["data"]->send_date), "j-M-Y")}}</div>
        @endif
        <div style="position: absolute; right: 0; top: 48px;">________________________________</div>
        <div style="text-align: left; margin-top: 25px;">ชื่อหน่วยงาน :&nbsp;&nbsp; {{$data["data"]->department_code}} - {{$data["data"]->department_desc}} ({{$data["data"]->to_subinventory}})</div>
        <div style="text-align: left; margin-top: 5px;">มีความประสงค์จะขอโอนพัสดุตามรายการด้านล่าง"เพื่อนำมาเก็บไว้ที่คลังของหน่วยงาน" ไว้สำหรับใช้งานภายในหน่วยงานต่อไป</div>
        <div style="text-align: left; margin-top: 5px; margin-bottom: 15px;">โปรดโอนพัสดุตามรายละเอียดดังนี้</div>
    @endforeach
</body>
</html>