<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> -->
    @include('ir.reports.irr6210._style')

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

<body onload="subst()">
  <div style="padding-top: 100px;">
    <table style="width:100%">
      <tbody>
        <tr>
          <td align="left" colspan="3"><b>รหัสโปรแกรม : IRR6210</b></td>
          <td align="center" colspan="24"><b>การยาสูบแห่งประเทศไทย</b></td>
          <td align="right" colspan="3"><b> วันที่ : </b> <b>{{ date('d/m/Y', strtotime(now())) }}</b></td>
        </tr>
        <tr>
          <td align="left" colspan="3"><b>สั่งพิมพ์ : {{ \Auth::user()->name }}</b></td>
          <td align="center" colspan="24"><b>ชุดที่</b></td>
          <td align="right" colspan="3"><b>เวลา : </b> <b>{{ date('H:i', strtotime(now())) }}</b></td>
        </tr>
        <tr>
          <td colspan="3"></td>
          <td align="center" colspan="24"><b>รายงานดุลค่าเบี้ยประกัน ประจำเดือน </b></td>
          <td align="right" colspan="3"><b>หน้า : </b><span class="page"></span> / <span class="topage"></span></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>

</html>