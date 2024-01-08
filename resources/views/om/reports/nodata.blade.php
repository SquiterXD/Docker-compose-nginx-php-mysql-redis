<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<table class="table">
    @php
        $colspan = 1;
    @endphp
    <thead>
        <tr>
            <th style="text-align:left;">โปรแกรม : {{ $programCode }}</th>
            <th colspan={{ $colspan }} style="text-align:center;">การยาสูบแห่งประเทศไทย</th>
            <th style="text-align:left;"> วันที่ : {{ parseToDateTh(now()) }}</th>
        </tr>
        <tr>
            <th style="text-align:left;">สั่งพิมพ์ : {{ optional(auth()->user())->username }}</th>
            <th colspan={{ $colspan }} style="text-align:center;">{{ $progTitle }}</th>
            <th style="text-align:left;">เวลา : {{ date('H:i', strtotime(now())) }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan={{ $colspan }} style="text-align:center;">{{ $progPara }}</th>
            <th style="text-align:left;"> หน้า : <span class="pagenum">1</span></th>
        </tr>
        <tr>
            <th></th>
            <th colspan={{ $colspan }} style="text-align:center;"></th>
            <th style="text-align:left;"> </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan=3 style="text-align: center;">ไม่มีข้อมูลในระบบ</td>
        </tr>
    </tbody>

</table>
