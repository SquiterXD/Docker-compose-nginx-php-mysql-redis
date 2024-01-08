<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- <script>
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
    </script> --}}

    <link rel="stylesheet" href="{{ asset('css/report.css') }}">

    <style type="text/css">
        body{
            font-size: 12px;
        }
        .pagenum1:after {
            content: counter(page);
        }
    </style>

</head>
<body>
    {{-- style="border:0; margin: 0;" onload="subst()" --}}
    {{-- <div class="row col-lg-12">
        <div class="flexrow">
            <div style="width: 250px;"><strong> โปรแกรม : </strong> {{ $programCode }}</div>
            <div style="width: 450px; text-align: center;"><strong>การยาสูบแห่งประเทศไทย</strong></div>
            <div style="width: 250px; text-align: right;"><strong> วันที่ : </strong> {{ ' '. parseToDateTh(now()) }}</div>
        </div>

        <div class="flexrow">
            <div style="width: 250px;" width="30%"><strong> สั่งพิมพ์ : </strong> {{ \Auth::user()->username }}</div>
            <div style="width: 450px; text-align: center;" width="40%"><strong>ชุด : </strong>{{ $policySetDes }}</div>
            <div style="width: 250px; text-align: right;" width="30%"><strong> เวลา : </strong> {{ date('H:i', strtotime(now())) }}</div>
        </div>

        <div class="flexrow">
            <div style="width: 250px;" width="30%"></div>
            <div style="width: 450px; text-align: center;" width="40%">
                <strong>{{$program->description}}</strong>
            </div>
            <div style="width: 250px; text-align: right;" width="30%"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></div>
        </div>
        <div class="flexrow">
            <div style="width: 250px;" width="30%"></div>
            <div style="width: 450px; text-align: center;" width="40%">
                <strong>
                    @foreach ($companies as $company)
                        @if ($loop->last)
                            {{ " และ "  }}
                        @endif
                        {{  $company->company_name  }}
                    @endforeach 
                </strong>
            </div>
            <div style="width: 250px; text-align: right;" width="30%"></div>
        </div>
        <div class="flexrow">
            <div style="width: 250px;" width="30%"></div>
            <div style="width: 450px; text-align: center;" width="40%">
                <strong>ปีงบประมาณ {{ $periodYear ? $periodYear + 543 : '' }}</strong>
            </div>
            <div style="width: 250px; text-align: right;" width="30%"></div>
        </div>
        <div class="flexrow">
            @php
                $ex_sDate = explode('/' ,$periodDate[0]);
                $ex_eDate = explode('/' ,$periodDate[1]);
            @endphp
            <div style="width: 250px;" width="30%"> <strong>{{ ucfirst($reportType) }}</strong> </div>
            <div style="width: 450px; text-align: center;" width="40%">
                <strong>สำหรับวันที่ {{ $ex_sDate[0] . ' ' . $thaimonths[$ex_sDate[1]] . ' ' . $ex_sDate[2] }} ถึง {{ $ex_eDate[0] . ' ' . $thaimonths[$ex_eDate[1]] . ' ' . $ex_eDate[2] }}</strong>
            </div>
            <div style="width: 250px; text-align: right;" width="30%"></div>
        </div>
    </div> --}}
    <div class="row">
        <div style="width:20%;text-align:left">
            <span class="b">โปรแกรม</span> :<br>
            <span class="b">สั่งพิมพ์</span> : {{ optional(auth()->user())->username }}<br>
            <br>
        </div>
        <div style="width:60%;text-align:center; font-size: 28;" class="b">
                การยาสูบแห่งประเทศไทย<br>
                {{-- {{ $progTitle }}
                @php
                    foreach($progPara as $para){
                        echo "<br>".$para;
                    }
                @endphp --}}
        </div>
        <div style="width:20%;text-align:right;">
            <span class="b">วันที่</span> : {{ parseToDateTh(now()) }}<br>
            <span class="b">เวลา</span> :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
            <span class="b">หน้า</span> : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
        </div>
    </div>
</body>
</html>