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
            font-size: 12px;
        }
    </style>

</head>
<body style="border:0; margin: 0; " onload="subst()">
    <div class="row" style="top:0px; border: 0px solid #000;">
        <div class="col-lg-12">
            <div class="flexrow">
                <div style="text-align: left">
                    <strong>การยาสูบแห่งประเทศไทย</strong>
                    <div>
                        <strong>Tobacco Authority of Thailand</strong>
                    </div>
                </div>
                <div style="text-align: center; font-size: 15px;">
                    <strong>ใบส่งสินค้า</strong>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div style="text-align: right">
                    <strong>วันที่ :</strong> {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }}
                    <div>
                        <strong>เวลา :</strong> {{ Carbon\Carbon::now()->format('H:i') }}
                    </div>
                </div>
            </div>
            {{-- <div class="flexrow">
                <div style="text-align: left"><strong>&nbsp;</strong> </div>
                <div style="text-align: center"><strong>&nbsp;</strong></div>
                <div style="text-align: right"><strong>เวลา :</strong> {{ Carbon\Carbon::now()->format('H:i') }}</div>
            </div> --}}
            <div class="flexrow">
                <div ><strong>&nbsp;</strong></div>
                <div ><strong>&nbsp;</strong>   </div>
                <div ><strong>&nbsp;</strong>   </div>
                <div style="text-align: right"><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></div>
            </div>
            <div class="flexrow">
                <div style="text-align: left"><strong>ชื่อหน่วยงานส่ง : {{ $header->dept_fm }}</strong> </div>
                <div style="text-align: right"><strong>สถานะขอเบิก : {{ optional($header->status)->description }}</strong> </div>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top: 5px; padding-bottom: 5px;">
                <tr>
                    <td width="60%"><strong>หน่วยงานรับ  </strong> {{ $header->subinventory_to_desc }}</td>
                    <td width="25%"><strong>เลขที่ใบส่งของ  </strong> {{ $header->transfer_number }}</td>
                    <td width="15%" style="text-align: right" ><strong>วันที่ส่ง </strong> {{ $header->transfer_date_format }}</td>
                </tr>
            </table>
            {{-- <div class="flexrow" style="border-bottom: 1px solid #000;  padding-top: 5px; padding-bottom: 5px;">
                <div ><strong>หน่วยงานรับ  </strong> {{ $header->subinventory_to_desc }}</div>
                <div ><strong>เลขที่ใบส่งของ  </strong> {{ $header->transfer_number }}</div>
                <div ><strong>วันที่ส่ง </strong> {{ $header->transfer_date_format }}</div>
            </div> --}}
        </div>
    </div>
</body>
</html>
