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

    {{-- <link rel="stylesheet" href="{{ asset('css/report.css') }}"> --}}
    @include('ir.reports.irr1010._style')
    <style type="text/css">
        body{
            font-size: 11px;
        }
    </style>
    
</head>
<body style="border:0; margin: 0;" onload="subst()">
        <table width="100%" style="font-size: 16px">
            <tr >
                <td width="20%"> <span class="p-h2">Program Code : {{$program->program_code}} </span>  </td>
                <td width="70%"   align="center"> <span class="p-h2"> การยาสูบแห่งประเทศไทย </span>  </td>
                <td width="10%">   <span class="p-h2"> วันที่ :  {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }} </span> </td>
            </tr>
            <tr>
                <td></td>
                <td width="65%" align="center"> <span class="p-h2"> ชุดที่ : {{ $reportStocks[0]->policy_set_header_id. ' : '. $reportStocks[0]->policy_set_description}} </span></td>
                <td><span class="p-h2"> เวลา : {{ Carbon\Carbon::now()->format('H:i') }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td width="70%"   align="center"> {{$program->description}} </td>
                <td> หน้า: <span class="page"></span> / <span class="topage"></span></td>
            </tr>
            <tr>
                <td></td>
                <td width="70%"   align="center">  {{ $date['month'] }} </td>
                <td> </td>
            </tr>
            <tr>
                <td></td>
                <td width="70%"   align="center">  {{  $date['month_off'] }} </td>
                <td> </td>
            </tr>
        </table>
         {{-- {{ dd('xxxxx')}} --}}
        {{-- <div class="col-lg-12">
            <div class="flexrow">
                <div style="text-align: left"><strong>โปรแกรม :</strong> {{ $ptpmHead->program_code }}**</div>
                <div style="text-align: center"><strong>การยาสูบแห่งประเทศไทย</strong></div>
                <div style="text-align: right"><strong>วันที่ :</strong> {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }}</div>
            </div>
            <div class="flexrow">
                <div style="text-align: left"><strong>สั่งพิมพ์ : </strong> {{ $ptpmHead->organization_code }}</div>
                <div style="text-align: center"><strong>ใบโอนวัตถุดิบ/วัสดุเพื่อใช้ในการผลิต</strong></div>
                <div style="text-align: right"><strong>เวลา :</strong> {{ Carbon\Carbon::now()->format('H:i') }}</div>
            </div>
            <div class="flexrow">
                <div ><strong>พิมพ์ครั้งที่ :</strong>1**</div>
                <div ><strong>วันที่ขอเบิก :</strong>   {{ $ptpmHead->request_date_thai }}</div>
                <div ><strong>วันที่นำส่ง รยส. :</strong>   {{ $ptpmHead->send_date_thai }}</div>
                <div style="text-align: right"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></div>
            </div>
            <div class="flexrow">
                <div style="text-align: left"><strong>หน่วยงาน : </strong> {{ $ptpmHead->department_code_header }}</div>
                <div style="text-align: right"><strong>ใบขอเบิกเลขที :</strong> {{ $ptpmHead->request_number }}</div>
            </div>
            <div class="flexrow">
                <div style="text-align: left"><strong>สินค้าที่ผลิต : </strong> {{ $ptpmHead->description_header }}</div>
                <div style="text-align: right"><strong>สถานะขอเบิก :</strong> {{ $ptpmHead->request_status }}</div>
            </div>
            <br>
            <br>
        </div> --}}
</body>
</html>
