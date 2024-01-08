<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>รายงานการแจ้งเหตุเคลมประกันภัย</title> --}}

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
    <div class="row col-lg-12">
        <div class="flexrow">
            <div style="width: 250px;"> โปรแกรม :  {{ $program->program_code }}</div>
            <div style="width: 450px; text-align: center;">การยาสูบแห่งประเทศไทย</div>
            <div style="width: 250px; text-align: right;"> วันที่ : {{ ' '. parseToDateTh(now()) }}</div>
        </div>
        <div class="flexrow">
            <div style="width: 250px;" width="30%"> สั่งพิมพ์ :  {{ \Auth::user()->username }}</div>
            <div style="width: 450px; text-align: center;" width="40%">{{$program->description}}</div>
            <div style="width: 250px; text-align: right;" width="30%">เวลา : {{ date('H:i', strtotime(now())) }}</div>
        </div>
        <div class="flexrow">
            <div style="width: 250px;" width="30%"> </div>
            <div style="width: 450px; text-align: center;" width="40%">
                @php
                    $countData = count($companies);
                @endphp
                @if ($countData > 1)
                    @foreach ($companies as $company)
                        @if ($loop->last)
                            {{ " และ "  }}
                        @endif
                        {{  $company->company_name  }}
                    @endforeach 
                @else
                    @foreach ($companies as $company)
                        {{  $company->company_name  }}
                    @endforeach 
                @endif
            </div>
            <div style="width: 250px; text-align: right;" width="30%">หน้า : <span class="page"></span> / <span class="topage"></span></div>
        </div>
        <div class="flexrow">
            <div style="text-align: left;"></div>
            <div style="text-align: center;">ปีงบประมาณ {{ $periodYear ? $periodYear + 543 : '' }} </div>
            <div style="text-align: right;"></div>
        </div>
        <div class="flexrow" >
            @php
                $ex_sDate = explode('/' ,$periodDate[0]);
                $ex_eDate = explode('/' ,$periodDate[1]);
            @endphp
            <div style="text-align: left;"></div>
            <div style="text-align: center;"> สำหรับวันที่ {{ $ex_sDate[0] . ' ' . $thaimonths[$ex_sDate[1]] . ' ' . $ex_sDate[2] }} ถึง {{ $ex_eDate[0] . ' ' . $thaimonths[$ex_eDate[1]] . ' ' . $ex_eDate[2] }} </div>
            <div style="text-align: right"></div>
        </div>
    </div>
</body>
</html>