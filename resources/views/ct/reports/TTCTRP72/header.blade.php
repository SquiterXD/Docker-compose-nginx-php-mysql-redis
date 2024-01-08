<style>
    table, tr, th{
    border:none;
    }
</style>
<table>
@foreach ($QueryHeadRpt as $Rpt)

        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"colspan=3 >โปรแกรม : TTCTRP72</th>
            <th style="text-align: center; font-weight: bold; width: 400px;"colspan=4>การยาสูบแห่งประเทศไทย(DR Site-TOT)</th>
            <th style="text-align: right; font-weight: bold; width: 300px;"colspan=3>วันที่ : {{$Sysdate}}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold; width: 300px;"colspan=3>สั่งพิมพ์ : {{ Auth::user()->name }} </th>
            <th style="text-align: center; font-weight: bold; width: 400px;" colspan=4>รายงานบัตรต้นทุนแยกตามพันธ์ใบยา</th>
            <th style="text-align: right; font-weight: bold; width: 300px;"colspan=3>เวลา : {{$time}}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"colspan=3>ประเภทใบยา : {{$Rpt->type_product_th}}</th>
            <th style="text-align: center; font-weight: bold;width: 400px;" colspan=4>ประจำวันที่ {{$dateFromTH}} ถึง {{$dateToTH}}</th>
            <th style="text-align: right; font-weight: bold;width: 300px;"colspan=3> </th>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"colspan=3>ฤดู/ปี การผลิต : {{$Rpt->crop_year}}</th>
            <th style="text-align: center; font-weight: bold;width: 400px;" colspan=4></th>
            <th style="text-align: right; font-weight: bold;width: 300px;"colspan=3></th>
        </tr>

        <tr>
            <th style="text-align: left; font-weight: bold;width: 300px;"colspan=3>ศูนย์ต้นทุน : {{$Rpt->cost_center}}</th>
            <th style="text-align: center; font-weight: bold;width: 400px;" colspan=4></th>
            <th style="text-align: right; font-weight: bold;width: 300px;"colspan=3> </th>
        </tr>
@endforeach
</table>
