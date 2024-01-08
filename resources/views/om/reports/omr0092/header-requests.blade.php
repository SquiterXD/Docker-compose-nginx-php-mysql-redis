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
@include('ct.reports.ctr0101._style')

</head>
<body style="border:0; margin: 0;" onload="subst()">
<table border="0" width="100%">

<tr>
    <td></td>

<td><h6 class="text-center tw-font-bold"> การยาสูบแห่งประเทศไทย</h6></td>
<td><div>
            <div style="width: 100%;" class="tw-inline-block tw-font-bold text-right"> วันที่ : {{$DATE}} </div> 
        </div> </td>
</tr>
<tr>
    <td width="33%">
            <div    style="font-size: 16px;" 
                    class="tw-inline-block tw-font-bold text-left"> รหัสโปรแกรม :  OMR0092                       
            </div>                     
        
            
        
    </td>
    <td width="33%"style="text-align: center; "> 
        <div>
            <div    style=" font-size: 16px;" 
                    class="text-center tw-inline-block tw-font-bold text-center"> รายงานยอดลูกหนี้ค่ายาสูบที่ยังไม่ได้ชำระเงินเมื่อถึงกำหนดชำระ                          
            </div>                     
        </div>

        
    </td>
    <td width="33%"> 
        <div>
            <div style="width: 100%;" class="tw-inline-block tw-font-bold text-right"> เวลา : {{$time}} </div> 
        </div>

        
    </td>
</tr>
<tr>
    <td>
    <div    style="font-size: 16px;" 
                    class="tw-inline-block tw-font-bold text-center">สั่งพิมพ์ : {{$user}}  </div> 
    </td>
    <td style="text-align: center; ">
            <div    style="font-size: 16px;" 
                    class="tw-inline-block tw-font-bold text-center"> ประจำวันที่ {{$START_DATE}}   </div> 
    </td>
    <td>

    <div style="width: 100%;" class="tw-inline-block tw-font-bold text-right" ><strong>หน้า : </strong><span class="page"></span> / <span class="topage"></span></div>
    
    </td>
</tr>
</table>   
    
</body>
</html>
