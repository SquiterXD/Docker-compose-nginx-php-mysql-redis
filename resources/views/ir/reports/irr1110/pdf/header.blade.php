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
    @include('ir.reports.irr1110._style')
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
            <td>  สั่งพิมพ์ : {{  $userProfile->user_name}} </td>
            <td width="65%" align="center"> <span class="p-h2"> ชุดที่ : {{ $reportStocks[0]->policy_set_header_id. ' : '. $reportStocks[0]->policy_set_description}} </span></td>
            <td><span class="p-h2"> เวลา : {{ Carbon\Carbon::now()->format('H:i') }}</span></td>
        </tr>
        <tr>
            <td></td>
            <td width="70%"   align="center"> {{$program->description}}   </td>
            <td> หน้า: <span class="page"></span> / <span class="topage"></span></td>
        </tr>
    </table>
</body>
</html>
