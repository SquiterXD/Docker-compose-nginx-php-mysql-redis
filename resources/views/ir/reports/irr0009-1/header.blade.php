<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงานบันทึกบัญชีค่าเบี้ยประกันภัยยานพาหนะ ประจำเดือน</title>

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
    @include('ir.reports.irr0009-1._style')

    <style type="text/css">
        body{
            font-size: 18px;
        }
    </style>

</head>
<body style="border:0; margin: 0;" onload="subst()">
    <table class="table-noborder" style="width: 100%">
        <tr>
            <td style="text-align: left;"><strong> โปรแกรม : </strong> {{ $programCode }}</td>
            <td style="text-align: center;"><strong>การยาสูบแห่งประเทศไทย</strong></td>
            <td style="text-align: right;"><strong> วันที่ : </strong> {{ parseToDateTh(date('d/m/Y')) }}</td>
        </tr>
        <tr>
            <td style="text-align: left;"><strong> สั่งพิมพ์ : </strong> {{ \Auth::user()->name }}</td>
            <td style="text-align: center;"><strong>รายงานบันทึกบัญชีค่าเบี้ยประกันภัยยานพาหนะ ประจำเดือน {{ $thaimonths[date('m', strtotime($month))]}}  {{ date('Y', strtotime($month))+543 }}</strong></td>
            <td style="text-align: right;"><strong> เวลา : </strong> {{ date('H:i') }}</td>
        </tr>
        <tr>
            <td style="text-align: left;"><strong> </td>
            <td style="text-align: center;"><strong>{{ $renewType }} {{ $groupCodeDesc }} </strong></td>
            <td style="text-align: right;"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></td>
        </tr>
    </table>
    <br>
    {{-- <div class="row">
        <div class="col-lg-12 flexrow">
            <div class="col-lg-4" style="width: 200px; border: 1px solid black;"><strong> โปรแกรม : </strong> {{ $programCode }}</div>
            <div class="col-lg-4" style="width: 400px; text-align: center;"><strong>การยาสูบแห่งประเทศไทย</strong></div>
            <div class="col-lg-4" style="text-align: right;"><strong> วันที่ : </strong> {{ strtoupper(date('d-m-Y')) }}</div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 flexrow">
            <div class="col-lg-4" style="width: 200px; border: 1px solid black;"><strong> สั่งพิมพ์ : </strong> {{ \Auth::user()->name }}</div>
            <div class="col-lg-4" style="width: 400px; text-align: center;"><strong>รายงานบันทึกบัญชีค่าเบี้ยประกันภัยยานพาหนะ ประจำเดือน {{ $thaimonths[date('m', strtotime($month))]}}  {{ date('Y', strtotime($month))+543 }}</strong></div>
            <div class="col-lg-4" style="text-align: right;"><strong> เวลา : </strong> {{ date('H:i') }}</div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 flexrow">
            <div class="col-lg-4" style="width: 200px; border: 1px solid black;"> </div>
            <div class="col-lg-4" style="width: 400px; text-align: center;"><strong>{{ $renewType }} {{ $groupCodeDesc }} </strong></div>
            <div class="col-lg-4" style="text-align: right;"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></div>
        </div>
    </div> --}}
    {{-- <div class="row col-lg-12">
        <div class="flexrow">
            <div style="width: 250px;"><strong> โปรแกรม : </strong> {{ $programCode }}</div>
            <div style="width: 450px; text-align: center;"><strong>การยาสูบแห่งประเทศไทย</strong></div>
            <div style="width: 250px; text-align: right;"><strong> วันที่ : </strong> {{ strtoupper(date('d-m-Y')) }}</div>
        </div>

        <div class="flexrow">
            <div style="width: 250px;" width="30%"><strong> สั่งพิมพ์ : </strong> {{ \Auth::user()->name }}</div>
            <div style="width: 450px; text-align: center;" width="40%"><strong>รายงานบันทึกบัญชีค่าเบี้ยประกันภัยยานพาหนะ ประจำเดือน {{ $thaimonths[date('m', strtotime($month))]}}  {{ date('Y', strtotime($month))+543 }}</strong></div>
            <div style="width: 250px; text-align: right;" width="30%"><strong> เวลา : </strong> {{ date('H:i') }}</div>
        </div>

        <div class="flexrow">
            <div style="width: 250px;" width="30%"> </div>
            <div style="width: 450px; text-align: center;" width="40%"><strong>{{ $renewType }} {{ $groupCodeDesc }} </strong></div>
            <div style="width: 250px; text-align: right;" width="30%"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></div>
        </div>
        <br><br>
    </div> --}}
</body>
</html>