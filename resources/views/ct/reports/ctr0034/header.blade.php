<style>
    table, tr, th{
    border:none;
    }
</style>
<table>


        <tr>
            <td style="text-align: left;  width: 300px;"colspan=4 ><b>โปรแกรม</b> : CTR0034</td>
            <td style="text-align: center;  width: 400px;"colspan=5><b>การยาสูบแห่งประเทศไทย</b></td>
            <td style="text-align: right;  width: 300px;"colspan=4></td>
        </tr>
        <tr>
            <td style="text-align: left;   width: 300px;"colspan=4></td>
            <td style="text-align: center;  width: 400px;" colspan=5><b>รายงานการใช้วัตถุดิบและเปรียบเทียบผลต่าง</b></td>
            <td style="text-align: right;  width: 300px;"colspan=4></td>
        </tr>
        <tr>
            <td style="text-align: left; width: 300px;"colspan=4></td>
            <td style="text-align: center; width: 400px;" colspan=5><b>วันที่</b> {{$dateFromTH}} <b>ถึง</b> {{$dateToTH}}</td>
            <td style="text-align: right; width: 300px;"colspan=4> </td>
        </tr>
        <tr>

            <td style="text-align: left; width: 300px;"colspan=4><b>หน่วยงาน</b> : {{$header['dept_code']}} &nbsp;  {{$header['dept_desc']}} &emsp; ศูนย์ต้นทุน : {{$header['cost_code']}} &nbsp;  {{$header['cost_desc']}} </td>
            <td style="text-align: center; width: 400px;" colspan=5></td>
            @if (request()->type_rpt == "yes")
                <td colspan="4"></td>
                <td style="text-align: right; width: 300px;"colspan=2><b> วันที่พิมพ์</b> : {{$Sysdate}} {{$time}} </td>
            @else
                <td style="text-align: right; width: 300px;"colspan=4><b> วันที่พิมพ์</b> : {{$Sysdate}} {{$time}} </td>
            @endif
        </tr>

        <tr>
            <td style="text-align: left; width: 300px;"colspan=4><b>พันธุ์ใบยา</b> :{{$TypeProd}}</td>
            <td style="text-align: center; width: 400px;" colspan=5></td>
            <td style="text-align: right; width: 300px;"colspan=4> </td>
        </tr>

</table>

